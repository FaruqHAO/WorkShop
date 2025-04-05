<?php

require_once '../include/databasehandler.php';
require_once '../include/sessionmanager.php';
require_once '../include/customfunctions.php';

$feedback = 0;
require_once '../include/session-instanciator.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["SignupButton"])) {

        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->Open();

        if ($feedback == "true") {

            $FullName = $dbhandler->CheckInput($_POST["FullName"]);
            $IdNumber = $dbhandler->CheckInput($_POST["IdNumber"]);
            $EncIdNumber = base64_encode_url($IdNumber);
            $EmailAddress = $dbhandler->CheckInput($_POST["EmailAddress"]);
            $B4EncPassword = $dbhandler->CheckInput($_POST["UserPassword"]);
            $UserPassword = $dbhandler->CheckInput(md5($B4EncPassword));

//            echo '<br> Posted  password : '.$_POST["UserPassword"]. '<br> Variable B4 Passowrd'. $B4EncPassword.'<br>Variable After Passowrd'. $UserPassword.'<br>';

//            $FullNameArr = explode(',', $FullName);
//Checking user from Exams Data : Step One Verification
            $result = $dbhandler->getData("select STUDID, LASTNAME, OTHERNAMES from studentdata where STUDID='$IdNumber' ");
//            var_dump($result);
            $idnumbermatch = mysqli_num_rows($result);

            $infodetails = array();
            while ($row = mysqli_fetch_assoc($result)) {

                array_push($infodetails, $row['STUDID']);
                array_push($infodetails, $row['LASTNAME'].' '.$row['OTHERNAMES']);
            }
//                echo 'Evidence of database :: '.$infodetails[1];
//                exit();
                
//            echo 'Id Number Form Input ' . $IdNumber . '<br>Name Form Input ' . $FullName . '<br> Password B4 Encryp'.$B4EncPassword. '<br> Password '.$UserPassword  ;
//            echo '<br>Name from input   ::  '.SortAllCharsNat($FullName);
//            echo '<br>Name from Database  ::  '.SortAllCharsNat($infodetails[1]);
            $namematch = (SortAllCharsNat($FullName) == SortAllCharsNat($infodetails[1]) ) ? 1 : 0 ;
//echo '<br><br>'.$namematch ;
//             exit();

//$db->close();
            if (($idnumbermatch > 0) && ($namematch == 1)) {
                
//                echo 'Works';
//                exit();
                
                //Checking if User Have Signed up already
                $result1 = $dbhandler->getData("select idnumber, verificationstatus, verificationemailsent from usercredentials where idnumber='$IdNumber' ");
//            var_dump($result);

                $match = mysqli_num_rows($result1);
                
                if ($match == 0) {

// Generate random 32 character hash and assign it to a local variable.
                    $verificationcode = md5(rand(0, 1000));

                    $data = array(
                        'idnumber' => $IdNumber,
                        'password' => $UserPassword,
                        'email' => $EmailAddress,
                        'verificationcode' => $verificationcode,
                        'verificationstatus' => 0,
                        'verificationemailsent' => 0,
                        'status' => 0
                    );
                    $insertfeedback = $dbhandler->insertData('usercredentials', $data);

                    if ($insertfeedback > 0) {

                        require 'activationmailer.php';
                    } else {
                        // Unable to insert into Database
                    }
                } else {
//                    echo 'Id found, Step 2 checking Query return number of rows : '.$match.'Staified and checking ';

                    $infob = array();
                    while ($row = mysqli_fetch_assoc($result1)) {

                        array_push($infob, $row['idnumber']);
                        array_push($infob, $row['verificationstatus']);
                        array_push($infob, $row['verificationemailsent']);
                    }

//                        Sending Email Again incase there is an problem with sending the initial time
                    if (($infob[1] == 0) && ($infob[2] == 1)) {
//                        Sending Error message
                        $sesmanager->Set("msg", "Error Generated: Signedup  Already, Please Check your Mail for Activation :error");
                        // PHP permanent URL redirection
                        header("Location: ../../signup", true, 301);
                        exit();
                    } else if (($infob[1] == 0) && ($infob[2] == 0)) {
                    // Generate random 32 character hash and assign it to a local variable.
                    $verificationcode = md5(rand(0, 1000));
                        
                    //    Updating the user table to show email sent successfully
                        $query = "update usercredentials set password='$UserPassword', email='$EmailAddress', verificationcode='$verificationcode' where idnumber='$IdNumber'; ";
                        $dbhandler->Update($query);

                        require 'activationmailer.php';

                    } else { 
//                        Sending Warning message
                        $sesmanager->Set("msg", "Warning Generated: Signed up & Activated, Please Login  :warning");
//                        // PHP permanent URL redirection
                        header("Location: ../../login", true, 301);
                        exit();                     
                        
                    }
                }
                             
                
            } else {
                $sesmanager->Set("msg", "Error Generated: ID Number not Found OR ID Number & Name do not Match. Check Your Name. :error");

                // PHP permanent URL redirection
                header("Location: ../../signup", true, 301);
                exit();

            }
        }

        $dbhandler->Close();
    } else {
        //    Kill User Session
        $sesmanager->destroy();

        //    // PHP permanent URL redirection
        header("Location: ../../signup", true, 301);
        exit();
    }
} else {
    //    Kill User Session
    $sesmanager->destroy();

    //    // PHP permanent URL redirection
    header("Location: ../../signup", true, 301);
    exit();
}

////    Sending Success Message
//    $sesmanager->Set("msg","Successfull:Event Item Data Added to Database:success");
//    
//    // PHP permanent URL redirection
//    header("Location: ../../addevents", true, 301);
//    exit();
?>