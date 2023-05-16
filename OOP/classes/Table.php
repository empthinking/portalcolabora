<?php
require_once 'db.php';

abstract class Table {

    protected $table_name;
    protected $db;
    public  $error;

    function __construct(mysqli $db, string $table_name){
        $this->db = $db;
        $this->table_name = $table_name;
    }    

    // Executa uma query
    protected function sqlQuery(string $sql) : bool {
        if(!$this->db->query($sql)){
            $this->error = $this->db->error;
            return FALSE;    
        }
        return TRUE;
    }
    

    // Realiza uma query preparada
    protected function secureQuery(string $sql_prep, mixed ...$variables) : bool{
        if(!$stmt = $this->db->prepare($sql_prep)){
            $this->error = $stmt->error;
            $stmt->close();
            return FALSE;
        }

        if(!$stmt->execute($variables)){
            $this->error = $stmt->error;
            $stmt->close();
            return FALSE;
        }

        return TRUE;
    }

    //Retorna um array multidimensional contendo as linhas requistadas
    protected function getRows(string $sql) : array | bool {
        $sql = $db->real_escape_string($sql);

        if(!$result = $this->db->query($sql)){
            $this->error = $this->db->error;
            return FALSE;
        }
        while($row = $result->fetch_assoc())
            $table[] = $row;
        $result->close();
        return $table;
    }

    //Retorna uma única linha requisitada
    protected function getOneRow(string $sql) : array | bool {
        $sql = $db->real_escape_string($sql);

        if(!$result = $this->db->query($sql)) {
            $this->error = $this->db->error;
            return FALSE;
        }

        $row = $result->fetch_assoc();
        $result->close();
        return $row;
    }
    
    protected function secureGetOneRow(string $sql_prep, mixed ...$variables) : array | bool {
        if(!$stmt = $this->msqli->prepare($sql_prep)){
            $this->error = $stmt->error;
            $stmt->close();
            return FALSE;
        }

        if(!$stmt->execute($variables)){
            $this->error = $stmt->error;
            $stmt->close();
            return FALSE;
        }

        $result = $stmt->get_result();
        $stmt->close();
        $row = $result->fetch_assoc();
        $result->close();
        return $row;
    }

    protected function secureGetRows(string $sql_prep, mixed ...$variables) : array | bool {
        if(!$stmt = $this->msqli->prepare($sql_prep)) {
            $this->error = $stmt->error;
            $stmt->close();
            return FALSE;
        }

        if(!$stmt->execute($variables)) {
            $this->error = $stmt->error;
            $stmt->close();
            return FALSE;
        }

        $result = $stmt->get_result();
        $stmt->close();
        while($row = $result->fetch_assoc())
            $table[] = $row;
        $result->close();
        return $table;
    }

    function __destruct(){
        $this->db->close();
    }

} 
