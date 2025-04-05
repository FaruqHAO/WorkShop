<?php

if ($sesmanager->isExpired()) {
//    sending error Message
    $sesmanager->Set("msg", "Error Generated: Please Login to Acces this Page :error");

//    redirecting to login
    header("Location: ./scripts/include/kill-session", true, 301);
    exit();
} elseif ($sesmanager->Get("IdNumber") == "") {
//    sending error Message
    $sesmanager->Set("msg", "Error Generated: Please Login to Acces this Page :error");

//    redirecting to login
    header("Location: ./scripts/include/kill-session", true, 301);
    exit();
} else {
    $IdNumber = $sesmanager->Get("IdNumber");

//    Connecting to Database and getting  User name for profile
    require_once 'databasehandler.php';
    $dbhandler = new databaseHandler();

    $dbhandler->Open();
    $query = "select LASTNAME, OTHERNAMES from studentdata where STUDID='$IdNumber' ";
    $result = $dbhandler->getData($query);

    $details = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($details, $row['LASTNAME']);
        array_push($details, $row['OTHERNAMES']);
    }
    
    $dbhandler->Close();
    
    $surname = $details[0];
    $othernames = $details[1];

    $LastLogin = $sesmanager->Get("LastLogin");
    $EmailAddress = $sesmanager->Get("EmailAddress");
    
}
?>