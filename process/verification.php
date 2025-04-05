<?php

require_once '../include/databasehandler.php';
require_once '../include/sessionmanager.php';
require_once '../include/customfunctions.php';

$feedback = 0;
require_once '../include/session-instanciator.php';

if (isset($_GET['id']) && !empty($_GET['id']) AND isset($_GET['verificationcode']) && !empty($_GET['verificationcode'])) {

    $dbhandler = new databaseHandler();
    $feedback = $dbhandler->Open();

    if ($feedback == "true") {
// Verify data
        $IdNumber = $dbhandler->CheckInput(base64_decode_url($_GET['id']));
        $verificationcode = $dbhandler->CheckInput($_GET['verificationcode']);


        $search = $dbhandler->getData("SELECT idnumber, verificationcode FROM usercredentials WHERE idnumber='$IdNumber' AND verificationcode='$verificationcode' AND verificationstatus='0'");
        $match = mysqli_num_rows($search);

        if ($match > 0) {
            // We have a match, activate the account
            $dbhandler->Update("UPDATE usercredentials SET status='1', verificationstatus='1'  WHERE idnumber='$IdNumber' AND verificationcode='$verificationcode' AND verificationstatus='0'");

            $sesmanager->Set("msg", "Successfull: Account Activation Completed. You can now Login to the Portal :success");
            // PHP permanent URL redirection
            header("Location: ../../login", true, 301);
            exit();
        } else {
            // No match -> invalid url or account has already been activated.
            $sesmanager->Set("msg", "Warning Generated: Account Already Activated. You can now Login to the Portal :warning");
            // PHP permanent URL redirection
            header("Location: ../../login", true, 301);
            exit();
        }
    }
    
    $dbhandler->Close();
} else {
    // Invalid approach
    $sesmanager->Set("msg", "Error Generated: Not Enought Data For Activation. Go to your Email and Click on Activate :error");
    // PHP permanent URL redirection
    header("Location: ../../login", true, 301);
    exit();
}
?>