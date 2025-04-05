<?php

require_once '../include/databasehandler.php';
require_once '../include/sessionmanager.php';
require_once '../include/customfunctions.php';

$feedback = 0;
require_once '../include/session-instanciator.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["Sign-inButton"])) {

        $dbhandler = new databaseHandler();
        $feedback = $dbhandler->open();

        if ($feedback == "true") {

            $UserPassword = $dbhandler->CheckInput(md5($_POST["Password"]));
            $IdNumber = $dbhandler->CheckInput($_POST["UserName"]);

            $result = $dbhandler->getData("select idnumber, password, verificationemailsent, verificationstatus, status, lastlogin, email from usercredentials where idnumber='$IdNumber' ");
//            print_r($result);
//            var_dump($result);
            $match = mysqli_num_rows($result);

            if ($match > 0) {
                $data = array();
                while ($row = mysqli_fetch_assoc($result)) {
                    array_push($data, $row['idnumber']);
                    array_push($data, $row['password']);
                    array_push($data, $row['verificationemailsent']);
                    array_push($data, $row['verificationstatus']);
                    array_push($data, $row['status']);
                    array_push($data, $row['lastlogin']);
                    array_push($data, $row['email']);
                }

                $currentdatetime = date('M d, Y - g:i A', time());

//echo $currentdatetime;
                if (($data[0] == $IdNumber) && ($data[1] == $UserPassword) && ($data[3] == 1) && ($data[4] == 1)) {

                    $sesmanager->Set("IdNumber", $data[0]);
                    $sesmanager->Set("LastLogin", $data[5]);
                    $sesmanager->Set("EmailAddress", $data[6]);

                    // Updating Last Login Date and Time
                    $dbhandler->Update("UPDATE usercredentials SET lastlogin='$currentdatetime', isonline='1'  WHERE idnumber='$IdNumber' AND password='$UserPassword'");

                    // PHP permanent URL redirection
                    header("Location: ../../dashboard", true, 301);
                    exit();
                } else if (($data[0] == $IdNumber) && ($data[1] != $UserPassword)) {
                    echo $currentdatetime;
                    $sesmanager->Set("msg", "Error Generated: Your Password is Incorrect :error");
                    // PHP permanent URL redirection
                    header("Location: ../../login", true, 301);
                    exit();
                }if (($data[0] == $IdNumber) && ($data[1] == $UserPassword) && ($data[3] == 1) && ($data[4] == 0)) {
                    $sesmanager->Set("msg", "Error Generated: Your Account is Disabled, Contact Administrator (icst.faculty@cug.edu.gh) :error");
                    // PHP permanent URL redirection
                    header("Location: ../../login", true, 301);
                    exit();
                } else if (($data[0] == $IdNumber) && ($data[1] == $UserPassword) && ($data[2] == 1) && ($data[3] == 0)) {
                    $sesmanager->Set("msg", "Error Generated: Check your Email to Activate your Account :error");
                    // PHP permanent URL redirection
                    header("Location: ../../sign-in", true, 301);
                    exit();
                } else {

                    $sesmanager->Set("msg", "Error Generated: Your Sign up Proccess is not Completed, Please Fill and Submit Data Again. :error");
                    // PHP permanent URL redirection
                    header("Location: ../../signup", true, 301);
                    exit();
                }
            } else {
                $sesmanager->Set("msg", "Error Generated: You do not have Registered Account, Sign up Now. :error");
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
        header("Location: ../../sign-in", true, 301);
        exit();
    }
} else {
//    Kill User Session
    $sesmanager->destroy();

    // PHP permanent URL redirection
    header("Location: ../../sign-in", true, 301);
    exit();
}
?>