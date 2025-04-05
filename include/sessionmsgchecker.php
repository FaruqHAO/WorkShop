 <?php 
//    Handling Notication to display or not
    $msgshow = 0;

    $msg = $sesmanager->Get("msg");
    $sesmanager->remove("msg");
    if ($msg == '') {
        $msgshow = 0;
    } else {
        $msgshow = 1;
        $msg = explode(':', $msg);
    }
    ?>