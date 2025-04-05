<?php

class databaseHandler {

    private $db_host = "localhost";
    private $db_port = "3306";
    private $db_name = "vcblog";
    private $db_user = "root";
    private $db_pass = "";

    public function Open() {

        global $con;

//        $con = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
        $con = mysqli_connect($this->db_host, $this->db_user, $this->db_pass, $this->db_name, $this->db_port);

        if ($con) {
            $dbSelect = mysqli_select_db($con, $this->db_name);
            if ($dbSelect) {
                return "true";
            } else {
                return mysqli_error($con);
            }
        } else {
            return mysqli_error($con);
        }
    }

    public function Close() {
        global $con;

        $res = mysqli_close($con);
        if ($res) {
            return "true";
        } else {
            return mysqli_error($con);
        }
    }

    public function clearStoredResults() {
        global $con;

        do {
            if (mysqli_store_result($con)) {
                mysqli_free_result($con);
            }
        } while (mysqli_more_results($con) && mysqli_next_result($con) );
    }

    public function insertData($table, $data) {
        global $con;

        $keys = "`" . implode("`, `", array_keys($data)) . "`";
        $values = "'" . implode("', '", $data) . "'";
        //var_dump("INSERT INTO `{$table}` ({$keys}) VALUES ({$values})");
        mysqli_query($con, "INSERT INTO `{$table}` ({$keys}) VALUES ({$values})");

        return mysqli_insert_id($con) . mysqli_error($con);
    }

    public function generateInsertValues($data) {
        global $querygot;



        foreach ($data as $row) {
            
        }




        return "true";
    }

    public function updateData($table, $conColumn, $conValue, $data) {
        global $con;

        $updates = array();
        if (count($data) > 0) {
            foreach ($data as $key => $value) {

                $value = mysqli_real_escape_string($con, $value);
                $value = "'$value'";
                $updates[] = "$key = $value";
            }
        }
        $implodeArray = implode(', ', $updates);
        $query = "UPDATE " . $table . " SET " . $implodeArray . " WHERE " . $conColumn . "='" . $conValue . "'";
        //var_dump($query);
        $res = mysqli_query($con, $query);
        if (!$res) {
            return "Can't Update data " . mysqli_error($con);
        } else {
            return "true";
        }
    }

    public function Delete($query) {
        global $con;

        $res = mysqli_query($con, $query);
        // var_dump($query);
        if (!$res) {
            return "Can't delete data " . mysqli_error();
        } else {
            return "true";
        }
    }

    public function execNonQuery($query) {
        global $con;

        $res = mysqli_query($con, $query);
        if (!$res) {
            return "Can't Execute Query" . mysqli_error($con);
        } else {
            return "true";
        }
    }

    public function checkInput($inputdata) {
        global $con;

        if (strlen($inputdata) > 0) {
            $inputdata1 = trim($inputdata);
            $inputdata2 = stripslashes($inputdata1);
            $inputdata3 = htmlspecialchars($inputdata2);
            $inputdata4 = mysqli_real_escape_string($con, $inputdata3);

            return $inputdata4;
        } else {
            return $inputdata;
        }
    }

    public function getData($query) {
        global $con;

        $res = mysqli_query($con, $query);
        if (!$res) {
            return "Can't get data " . mysqli_error($con);
        } else {
            return $res;
        }
    }

    public function executeMultiQuery($query) {
        global $con;
        $this->clearStoredResults();

//        mysqli_begin_transaction($con);

        try {

            $result = mysqli_multi_query($con, $query);

            if ($result) {
//                mysqli_commit($con);
                return $result;
            } else {
//                mysqli_rollback($con);
                return "Error in runing query : " . mysqli_error($con);
            }
        } catch (mysqli_sql_exception $e) {
            return "Error in runing query : " . $e;
        }
    }

    public function executeQuery($query) {
        global $con;
        $this->clearStoredResults();
        
        try {

            $result = mysqli_query($con, $query);
            if ($result) {
                return $result;
            } else {
                return "Error in runing query : " . mysqli_error($con);
            }
        } catch (mysqli_sql_exception $e) {
            return "Mysql Error : " . $e;
        }
    }

    public function Update($query) {
        global $con;
        $this->clearStoredResults();

        $res = mysqli_query($con, $query);
        if (!$res) {
            return "Can't update data " . mysqli_error($con);
        } else {
            return $res;
        }
    }

    public function executeUpdate($query) {
        global $con;
        $this->clearStoredResults();

        $feedback = mysqli_query($con, $query);
        if (!$feedback) {
            return "Can't update data " . mysqli_error($con);
        } else {
            return $feedback;
        }
    }

}

//function executequery($query) {
////print_r($connn);
//    global $connn;
//
//    $result = mysqli_query($connn, $query);
//    // print_r($result);
//    if ($result) {
//        return $result;
//    } else {
//        return "Error in runing query : " . mysqli_connect_error($connn);
//    }
//}
//  
//
//
?>
