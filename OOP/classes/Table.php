<?php
require_once 'db.php';

class Table {

    protected $table_name;
    protected $db;
    public  $error;

    function __construct(mysqli $db, string $table_name){
        $this->db = $db;
        $this->table_name = $table_name;
    }    

    // Realiza uma query preparada
    protected function secureSqlQuery(string $sql_prep, array $bindings, bool $return = FALSE, bool $mult_row = FALSE) : bool | array {
        if(!$stmt = $this->db->prepare($sql_prep)){
            $this->error = $stmt->error;
            $stmt->close();
            return FALSE;
        }

        if(!$stmt->execute($bindings)){
            $this->error = $stmt->error;
            $stmt->close();
            return FALSE;
        }

        if($return){
            $result = $stmt->get_result();
            $stmt->close();
            $row = $mult_result ? $result->fetch_all(MYSQLI_BOTH) : $result->fetch_assoc();
            $result->close();
            return $row;
	}

        return TRUE;
    }


    function __destruct(){
        $this->db->close();
    }

} 
