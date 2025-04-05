<?php

require 'sessionmanager.php';

require 'session-instanciator.php';

$IdNumber = $sesmanager->Get("IdNumber");


require 'databasehandler.php';

$dbhandler = new databaseHandler();
$feedback = $dbhandler->Open();

if ($feedback == "true") {
    // Updating Last Login Date and Time
    $dbhandler->Update("UPDATE usercredentials SET isonline='0'  WHERE idnumber='$IdNumber' ");
}

$dbhandler->Close();

$sesmanager->destroy();

// PHP permanent URL redirection
header("Location: ../../", true, 301);
exit();
?>
