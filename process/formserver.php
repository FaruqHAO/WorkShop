<?php

require '../include/sessionmanager.php';
require_once '../include/databasehandler.php';
require_once '../include/customfunctions.php';


switch (filter_input(INPUT_POST, 'action')) {
    case "signin";

        $email = filter_input(INPUT_POST, 'email');
        $password = (md5(filter_input(INPUT_POST, 'password')));

        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();
        if ($feedback == "true") {
            $query = ("SELECT * FROM userdata ud INNER JOIN usercredentials uc ON uc.id = ud.usercredentialid WHERE username= '$email'");
            $queryfeedback = $dbhandler->executeQuery($query);
//            print_r(mysqli_fetch_assoc($queryfeedback));
            if (mysqli_num_rows($queryfeedback) > 0) {
                $data = array();
                while ($row = mysqli_fetch_assoc($queryfeedback)) {
                    array_push($data, $row['id']);
                    array_push($data, $row['username']);
                    array_push($data, $row['password']);
                    array_push($data, $row['lastlogin']);
                    array_push($data, $row['disabled']);
                    array_push($data, $row['deleted']);
                    array_push($data, $row['rolegroupid']);
                    array_push($data, $row['loginflag']);
                    array_push($data, $row['usercredentialid']);
                }

//            print_r($data);

                if (($data[1] === $email) && ($data[2] === $password)) {

                    if ($data[4] === '1') {
                        print_r(json_encode(['response' => 'User Account Disabled, Contact Administrator']));
                    }

                    if ($data[5] === '1') {
                        print_r(json_encode(['response' => 'User Account not Allowed to Access System']));
                    }

                    if (($data[4] === '0') && ($data[5] === '0')) {

                        $seshandler = new sessionManager();
                        $seshandler->start();
                        $seshandler->Set('userdataid', $data[0]);
                        $seshandler->Set('rolegroupid', $data[6]);
                        $seshandler->Set('usercredentialid', $data[8]);

                        $seshandler->Set('currenttimestamp', time());


                        //updating the last login time
                        $updatequery = ("UPDATE usercredentials SET lastlogin='$currentdatetime', loginflag='1' WHERE username='$email' AND password='$password'");

                        $updatefeedback = $dbhandler->executeUpdate($updatequery);
                        if ($updatefeedback) {
                            print_r(json_encode(['response' => true]));
                        }
                    }
                } elseif (($data[0] !== $email) || ($data[1] !== $password)) {
                    print_r(json_encode(['response' => false]));
                }
            } else {
                print_r(json_encode(['response' => 'User not found or User does not Exist;']));
            }

            $dbhandler->close();
        } else {
            print_r(json_encode(['response' => 'Unable to Open Database; Check DB']));
        }

        break;


//     Sign out Case
    case "signout";

        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();
        if ($feedback == "true") {

            try {
                $seshandler = new sessionManager();
                $seshandler->start();
                $userdataid = $seshandler->Get('userdataid');
                $usercredentialid = $seshandler->Get('usercredentialid');

                //updating the last login time
                $updatequery = ("UPDATE usercredentials SET lastlogout='$currentdatetime', loginflag='0' WHERE id='$usercredentialid'");

                $updatefeedback = $dbhandler->executeUpdate($updatequery);
                if ($updatefeedback) {
                    $seshandler->destroy();

                    print_r(json_encode(['response' => true]));
                } else {
                    print_r(json_encode(['response' => false]));
                }
            } catch (Exception $e) {
                print_r(json_encode(['response' => false, 'error' => $e]));
            }


            $dbhandler->close();
        } else {
            print_r(json_encode(['response' => 'Unable to Open Database; Check DB']));
        }

        break;

//     Check Session variables
    case "retrivesessiondata";

        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();
        if ($feedback == "true") {

            try {

                $seshandler = new sessionManager();
                $seshandler->start();
                $userdataid = $seshandler->Get('userdataid');
                $usercredentialid = $seshandler->Get('usercredentialid');

                if ($userdataid && $usercredentialid) {

                    $query = ("SELECT * FROM userdata ud INNER JOIN usercredentials uc ON uc.id = ud.usercredentialid WHERE uc.id= '$usercredentialid'");
                    $queryfeedback = $dbhandler->executeQuery($query);
                    //            print_r(mysqli_fetch_assoc($queryfeedback));
                    if (mysqli_num_rows($queryfeedback) > 0) {
                        $data = array();
                        while ($row = mysqli_fetch_assoc($queryfeedback)) {
                            array_push($data, $row['username']);
                            array_push($data, $row['lastname']);
                            array_push($data, $row['firstname'] . " " . $row['middlename']);
                        }
                    }

                    print_r(json_encode(['response' => true, 'username' => $data[0], 'lastname' => $data[1], 'othernames' => $data[2]]));
                } else {
                    print_r(json_encode(['response' => false]));
                }
            } catch (Exception $e) {
                print_r(json_encode(['response' => false, 'error' => $e]));
            }


            $dbhandler->close();
        } else {
            print_r(json_encode(['response' => 'Unable to Open Database; Check DB']));
        }

        break;


//     Retirve main menu
    case "retrievemainmenu";

        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();
        if ($feedback == "true") {

            try {

                $seshandler = new sessionManager();
                $seshandler->start();
                $userdataid = $seshandler->Get('userdataid');
                $usercredentialid = $seshandler->Get('usercredentialid');

                if ($userdataid && $usercredentialid) {
                    $submenu = array();
                    $mainmenu = array();

                    $query = ("SELECT DISTINCT mm.id, mm.menuicon, mm.menutitle, mm.menuid, mm.datatarget 
                            FROM roles r, userspecificroles usr, mainmenu mm WHERE usr.roleid = r.id AND mm.id = r.mainmenuid 
                            AND usr.usercredentialid = '$usercredentialid' AND usr.accessallow = '1' AND r.is_active = '1' ");
//                print_r($query);echo "\n\n";
                    $queryfeedback = $dbhandler->executeQuery($query);
//                print_r(mysqli_fetch_assoc($queryfeedback));

                    if (mysqli_num_rows($queryfeedback) > 0) {
                        while ($row = mysqli_fetch_assoc($queryfeedback)) {
                            $mainmenu[] = $row;
                        }

                        foreach ($mainmenu as $menuitem) {
                            $mainmenuitemid = $menuitem['id'];

                            $subquery = ("SELECT r.id, r.title, r.name, r.mainmenuid FROM roles r, userspecificroles usr WHERE usr.roleid = r.id "
                                    . "AND usr.usercredentialid = '$usercredentialid' AND r.mainmenuid = '$mainmenuitemid' "
                                    . "AND usr.accessallow = '1' AND r.is_active = '1'  ");

                            $queryfeedback = $dbhandler->executeQuery($subquery);
                            //                print_r(mysqli_fetch_assoc($queryfeedback));

                            if (mysqli_num_rows($queryfeedback) > 0) {
                                while ($row = mysqli_fetch_assoc($queryfeedback)) {
                                    $submenu[] = $row;
                                }
                            }
                        }

                        print_r(json_encode(['response' => true, 'mainmenu' => $mainmenu, 'submenu' => $submenu]));
                    }
                } else {
                    print_r(json_encode(['response' => false]));
                }
            } catch (Exception $e) {
                print_r(json_encode(['response' => false, 'error' => $e]));
            }


            $dbhandler->close();
        } else {
            print_r(json_encode(['response' => 'Unable to Open Database; Check DB']));
        }

        break;


    //     Check if user is inactive for a time set in session manager
    case "checksession";
        try {
            $seshandler = new sessionManager();
            $seshandler->start();

            if ($seshandler->isExpired() === true) {
                print_r(json_encode(['response' => true]));
            } else {
                print_r(json_encode(['response' => false]));
            }
        } catch (Exception $e) {
            print_r(json_encode(['response' => false, 'error' => $e]));
        }

        break;


//Retrive Page Content from Server in pages folder
    case "retrievepagecontent";
        try {
            $filename = filter_input(INPUT_POST, 'pagefilename');

//            $pagesdir = projectroot . '/' . 'admin' . '/' . 'pages';
            $pagesdir = PROJECTROOT . '/' . 'admin' . '/' . 'pages';

            $filepath = $pagesdir . '/' . $filename;


            if (file_exists($filepath)) {
                $filecontent = file_get_contents($filepath);
                print_r(json_encode(['response' => true, 'filecontent' => $filecontent]));
            } else {
                print_r(json_encode(['response' => false]));
            }
        } catch (Exception $e) {
            print_r(json_encode(['response' => false, 'error' => $e]));
        }

        break;


    case "checkemailexist";
        $email = filter_input(INPUT_POST, 'email');

        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();
        if ($feedback == "true") {
            try {
                $query = ("SELECT uc.email FROM workshopreg uc WHERE uc.email='$email'");
//                print($query);
                $queryfeedback = $dbhandler->executeQuery($query);
                
                if (mysqli_num_rows($queryfeedback) > 0) {
                    print_r(json_encode(['response' => true]));
                    
                } else {
                    print_r(json_encode(['response' => false]));
                    
                }
            } catch (Exception $e) {
                print_r(json_encode(['response' => false, 'error' => $e]));
            }

            $dbhandler->close();
        } else {
            print_r(json_encode(['response' => 'Unable to Open Database; Check DB']));
        }


        break;
        
        
//    Check Phone number exist    
    case "checkphonenumberexist";
        $phonenumber = filter_input(INPUT_POST, 'phonenumber');

        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();
        if ($feedback == "true") {
            try {
                $query = ("SELECT ud.contact FROM workshopreg ud WHERE ud.contact='$phonenumber'");
//                print($query);
                $queryfeedback = $dbhandler->executeQuery($query);
                
                if (mysqli_num_rows($queryfeedback) > 0) {
                    print_r(json_encode(['response' => true]));
                    
                } else {
                    print_r(json_encode(['response' => false]));
                    
                }
            } catch (Exception $e) {
                print_r(json_encode(['response' => false, 'error' => $e]));
            }

            $dbhandler->close();
        } else {
            print_r(json_encode(['response' => 'Unable to Open Database; Check DB']));
        }


        break;

        
        
//        Fetch all roles
    case "fetchroles";
        $type = filter_input(INPUT_POST, 'type');
        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();
        if ($feedback == "true") {
            try {

                $seshandler = new sessionManager();
                $seshandler->start();
                $userdataid = $seshandler->Get('userdataid');
                $usercredentialid = $seshandler->Get('usercredentialid');

                if ($userdataid && $usercredentialid) {
                    $userslist = array();

                    if ($type == 'active') {
                        $query = ("SELECT  r.id, r.title FROM roles r WHERE r.is_active='1'");
                    } else {
                        $query = ("SELECT * FROM roles r ");
                    }
                    $queryfeedback = $dbhandler->executeQuery($query);
                    if (mysqli_num_rows($queryfeedback) > 0) {
                        while ($row = mysqli_fetch_assoc($queryfeedback)) {
                            $roleslist[] = $row;
                        }
                    }

                    print_r(json_encode(['response' => true, 'roleslist' => $roleslist]));
                } else {
                    print_r(json_encode(['response' => false]));
                }
            } catch (Exception $e) {
                print_r(json_encode(['response' => false, 'error' => $e]));
            }

            $dbhandler->close();
        } else {
            print_r(json_encode(['response' => 'Unable to Open Database; Check DB']));
        }


        break;



//        Fetch all role Group
    case "fetchrolegroup";
        $type = filter_input(INPUT_POST, 'type');
        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();
        if ($feedback == "true") {
            try {

                $seshandler = new sessionManager();
                $seshandler->start();
                $userdataid = $seshandler->Get('userdataid');
                $usercredentialid = $seshandler->Get('usercredentialid');

                if ($userdataid && $usercredentialid) {
                    $userslist = array();

                    if ($type == 'active') {
                        $query = ("SELECT  rg.id, rg.title FROM rolegroup rg WHERE rg.is_active='1'");
                    } else {
                        $query = ("SELECT * FROM rolegroup rg ");
                    }

                    $queryfeedback = $dbhandler->executeQuery($query);
                    if (mysqli_num_rows($queryfeedback) > 0) {
                        while ($row = mysqli_fetch_assoc($queryfeedback)) {
                            $rolegrouplist[] = $row;
                        }

                        print_r(json_encode(['response' => true, 'rolegrouplist' => $rolegrouplist]));
                    }
                } else {
                    print_r(json_encode(['response' => false]));
                }
            } catch (Exception $e) {
                print_r(json_encode(['response' => false, 'error' => $e]));
            }

            $dbhandler->close();
        } else {
            print_r(json_encode(['response' => 'Unable to Open Database; Check DB']));
        }


        break;
}


