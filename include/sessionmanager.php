<?php

class sessionManager {

    public function Set($key, $value) {
        $_SESSION[$key] = $value;
        // $_SESSION['start'] = time();
        // $_SESSION['expire'] = $_SESSION['start'] + (30 * 60);
    }

    public function Get($key) {
        // session_start();
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        } else {
            return null;
        }
    }

    public function isExpired() {

        $expireAfterMin = 10;
        $expireAfterSeconds = '';

//Check to see if our "last action" session
//variable has been set.
        if (isset($_SESSION['currenttimestamp'])) {
            $sessiontimestamp = $_SESSION['currenttimestamp'];
            $currentimestamp = time();

            //Convert our minutes into seconds.
            $expireAfterSeconds = $expireAfterMin * 60;
            $result = (int) $currentimestamp - (int) $sessiontimestamp;

//            return $result."Session timst : ".$sessiontimestamp ."Current timstap :" .$currentimestamp ;
            //Check to see if they have been inactive for too long.
            if ($result >= $expireAfterSeconds) {
                //User has been inactive for too long.
//                print_r( $result . " Session timst : " . $sessiontimestamp . " Current timstap :" . $currentimestamp);
                return true;
            } else {
                $_SESSION['currenttimestamp'] = $currentimestamp;
//                print_r( $result . " Session timst : " . $sessiontimestamp . " Current timstap :" . $currentimestamp);
                return false;
            }
        } else {
            return true;
        }
    }

    public function remove($key) {
        //session_start();
        unset($_SESSION[$key]);
    }

    public function start() {
        session_start();
    }

    public function destroy() {
        // Unset all of the session variables.
        $_SESSION = array();

        session_unset();
        session_destroy();
    }

}
