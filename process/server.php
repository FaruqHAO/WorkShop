<?php

require '../include/sessionmanager.php';
require_once '../include/databasehandler.php';
require_once '../include/customfunctions.php';
require_once 'emailer.php';

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

//     Add new system user case
    case "adduser";
        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();
        if ($feedback == "true") {
            $email = $dbhandler->checkInput(filter_input(INPUT_POST, 'email'));
            $firstname = $dbhandler->checkInput(filter_input(INPUT_POST, 'firstname'));
            $surname = $dbhandler->checkInput(filter_input(INPUT_POST, 'surname'));
            $middlename = $dbhandler->checkInput(filter_input(INPUT_POST, 'middlename'));
            $phonenumber = $dbhandler->checkInput(filter_input(INPUT_POST, 'phonenumber'));
            $signupmethod = $dbhandler->checkInput(filter_input(INPUT_POST, 'signupmethod'));
            $attachmentname = $dbhandler->checkInput(filter_input(INPUT_POST, 'attachmentname'));
            $workshoptitle = $dbhandler->checkInput(filter_input(INPUT_POST, 'workshoptitle'));
            

            if ($signupmethod == '0') {
                $signupmethod = "Admin Signup";
            } else {
                $signupmethod = "Self Signup";
            }

            $fullname = $firstname . " " . $middlename . " " . $surname;

            $randomuserpass = GenRandomPass();
            $encpassword = (md5($randomuserpass));

            try {
                $cexqueryfeedback = $dbhandler->executeQuery("SELECT uc.regid FROM workshopreg uc WHERE uc.email='$email'");

//                print_r($cexqueryfeedback);
//                exit;
                if ((mysqli_num_rows($cexqueryfeedback) <= 0)) {
//                    $insertQuery = "INSERT INTO usercredentials (id, username, password, lastlogin, disabled, deleted, rolegroupid, emailsent, loginflag, lastlogout, signupmethod)"
//                            . "VALUES (NULL, '$email', '$encpassword', NULL, '1', '0', '$rolegroupid', '0', '0', NULL, '$signupmethod');"
//                            . "INSERT INTO userdata (id, usercredentialid, firstname, middlename, lastname, phonenumber) "
//                            . "VALUES (NULL, (SELECT uc.id FROM usercredentials uc WHERE uc.username='$email'), '$firstname', '$middlename', '$lastname', '$phonenumber');";
                    $insertQuery = "INSERT INTO `workshopreg`(`regid`, `firstname`, `middlename`, `lastname`, `email`, `contact`, `certificate`)"
                            . " VALUES (NULL,'$firstname','$middlename','$surname','$email','$phonenumber','$signupmethod')";
                    $insertfeedback = $dbhandler->executeQuery($insertQuery);
                    if ($insertfeedback) {
//                    if (true) {
//                        print_r($insertfeedback);
//                        Sending Email Notification to new User
                        $emaildata = ['content' => 'confirmacct.php', 'username' => $email, 'password' => $randomuserpass];
                        $feedback = mailer($email, $fullname, "Work Shop Registration", $emaildata,$attachmentname,$workshoptitle);
                        if ($feedback) {
                            print_r(json_encode(['response' => $feedback]));
                            $defaultroles = array();
                            $dbusercredentialid;

//                            Update mail sent
                            $emailupdateq = "UPDATE workshopreg uc SET emailsent = '1' WHERE uc.email='$email'";
                            $insertfeedbk = $dbhandler->executeUpdate($emailupdateq);
                        } else {
                            print_r(json_encode(['response' => false, 'warning' => 'User Added, but Email could not be sent', 'error' => $feedback]));
                        }
                    } else {
                        print_r(json_encode(['response' => false]));
                    }
                } else {
                    print_r(json_encode(['response' => false, 'error' => "The User Already Exist in the System"]));
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
            $pagesdir = projectroot . '/pages';

            $filepath = $pagesdir . '/' . $filename;

//            $fileexist = file_exists($filepath);
//            $isreadable = is_readable($filepath);
//            $filecontent = is_readable($filepath);
//            
//            print ($filepath . "\n" . 'File Exist Res :' . $fileexist 
//                    .' Is Readable :'. $isreadable ."\n".'File Content : '. $filecontent);


            if (file_exists($filepath)) {
                $filecontent = file_get_contents($filepath);
                print_r(json_encode(['response' => true, 'filecontent' => $filecontent]));
            } else {
                print_r(json_encode(['response' => false]));
//                print_r(json_encode(['response' => false, 'error' => $filepath]));
            }
        } catch (Exception $e) {
            print_r(json_encode(['response' => false, 'error' => $e]));
        }

        break;

    case "verifypayment";

//check if request was made with the right data
        if (!$_SERVER['REQUEST_METHOD'] == 'POST' || !isset($_POST['reference'])) {
            die("Transaction reference not found");
        }

//set reference to a variable @ref
        $reference = $_POST['reference'];

//The parameter after verify/ is the transaction reference to be verified
        $url = 'https://api.paystack.co/transaction/verify/' . $reference;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt(
                $ch, CURLOPT_HTTPHEADER, [
            'Authorization: Bearer secret_key']
        );

//send request
        $request = curl_exec($ch);
//close connection
        curl_close($ch);
//declare an array that will contain the result 
        $result = array();

        if ($request) {
            $result = json_decode($request, true);
        }

        if (array_key_exists('data', $result) && array_key_exists('status', $result['data']) && ($result['data']['status'] === 'success')) {
            echo "success";
            //Perform necessary action
        } else {
            echo "Transaction was unsuccessful";
        }
        break;
    case"fetchallmember";
        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();
        if ($feedback == "true") {
            try {
                $seshandler = new sessionManager();
                $seshandler->start();
                $query = ("SELECT `regid`, `firstname`, `middlename`, `lastname`, `email`, `contact`, `certificate`, `emailsent` FROM `workshopreg`");
                $queryfeedback = $dbhandler->executeQuery($query);
                if (mysqli_num_rows($queryfeedback) > 0) {
                    while ($row = mysqli_fetch_assoc($queryfeedback)) {
                        $newslist[] = $row;
                    }
                    print_r(json_encode(['response' => true, 'governancelist' => $newslist]));
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
    case "fetchallbg";
        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();
        if ($feedback == "true") {
            try {
                $seshandler = new sessionManager();
                $seshandler->start();
                $userdataid = $seshandler->Get('userdataid');
                $query = ("SELECT `id`, `workshoptitle`, `workshopprice`, `workshopattactment` FROM `workshopdetails`");
                $queryfeedback = $dbhandler->executeQuery($query);
                if (mysqli_num_rows($queryfeedback) > 0) {
                    while ($row = mysqli_fetch_assoc($queryfeedback)) {
                        $bginfo[] = $row;
                    }
                    print_r(json_encode(['response' => true, 'bginfo' => $bginfo]));
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
    case "updatebgnames";
        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();
        if ($feedback == "true") {
            $inputvalue = $dbhandler->checkInput(filter_input(INPUT_POST, 'inputvalue'));
            $attribute = $dbhandler->checkInput(filter_input(INPUT_POST, 'attribute'));
            try {
                $seshandler = new sessionManager();
                $seshandler->start();
                $query = ("UPDATE `workshopdetails` SET $attribute='$inputvalue'");
                $queryfeedback = $dbhandler->executeQuery($query);
                if ($queryfeedback == true) {
                    print_r(json_encode(['response' => true]));
                } else {
                    print_r(json_encode(['response' => false]));
                }
            } catch (Exception $e) {
                print_r(json_encode(['response' => false, 'error' => $e]));
            } $dbhandler->close();
        } else {
            print_r(json_encode(['response' => 'Unable to Open Database; Check DB']));
        }
        break;
    case "addproject";
        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();
        if ($feedback == "true") {
            $seshandler = new sessionManager();
            $seshandler->start();
            try {
                define('UPLOAD_DIR', 'mailtemplates/images/');
                $filename = $_FILES["file"]["name"];
                $file_basename = substr($filename, 0, strripos($filename, '.')); // get file extention
                $file_ext = substr($filename, strripos($filename, '.')); // get file name
                $filesize = $_FILES["file"]["size"];
                $allowed_file_types = array('.pdf', '.doc', '.docx', '.xls');
                if (in_array($file_ext, $allowed_file_types) && ($filesize < 5216000)) {
                    // Rename file
                    $newfilename = "attachment" . $file_ext;
                    unlink(UPLOAD_DIR .$newfilename);
                    if (file_exists(UPLOAD_DIR . $newfilename)) {
                        // file already exists errorfetchaboutdetailfetchaboutdetail

                        print_r(json_encode(['response' => false, 'message' => "File Already Exist in the system"]));
//                        print_r(json_encode("File Already Exist in the system"));
                    } else {
                        move_uploaded_file($_FILES["file"]["tmp_name"], UPLOAD_DIR . $newfilename);
                        $userid = $seshandler->Get('usercredentialid');
                        $query = ("UPDATE `workshopdetails` SET `workshopattactment`='$newfilename'");
                        $queryfeedback = $dbhandler->executeQuery($query);
                        if ($queryfeedback == true) {
                            print_r(json_encode(['response' => true]));
                        } else {
                            print_r(json_encode(['response' => false]));
                        }
                    }
                }
            } catch (Exception $e) {
                print_r(json_encode(['response' => false, 'error' => $e]));
            } $dbhandler->close();
        } else {
            print_r(json_encode(['response' => 'Unable to Open Database; Check DB']));
        }
        break;
}

