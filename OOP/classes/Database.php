<?php

class Database {

    private $mysqli
    public  $error;

    public __construct(mysqli $mysqli){
    	$this->mysqli = $mysqli;
    }    

    // Executa uma query
    protected function query(string $sql) : bool {
        if(!$this->mysqli->query($sql)):
            $this->error[__METHOD__] = $this->mysqli->error;
            return FALSE;    
        else:
            return TRUE;
        endif;
    }
	

    // Realiza uma query preparada
   protected function secureQuery(string $sql_prep, mixed ...$variables) : bool{
        if(($stmt = $this->msqli->prepare($sql_prep)) === FALSE):
            $this->error = $stmt->error;
            $stmt->close();
            return FALSE;
        elseif($stmt->execute($variables) === FALSE):
            $this->error = $stmt->error;
            $stmt->close();
            return FALSE;
	else:
            return TRUE;
        endif;
    }

    //Requisita quantidades arbitrárias de linhas e retorna como array numérico
   protected function getRows(string $sql) : array | bool {
        $sql = $mysqli->real_escape_string($sql);
        if(($result = $this->mysqli->query($sql)) === FALSE):
            $this->error[__METHOD__] = $this->mysqli->error;
            return FALSE;
        endif;
        while($row = $result->fetch_assoc)
            $table[] = $row;
        $result->close();
        return $table;
    }

   protected function secureGetRows(string $sql_prep, mixed ...$variables) : array | bool {
        if(($stmt = $this->msqli->prepare($sql_prep)) === FALSE):
            $this->error[__METHOD__] = $stmt->error;
            $stmt->close();
            return FALSE;
        elseif($stmt->execute($variables) === FALSE):
            $this->error[__METHOD__] = $stmt->error;
            $stmt->close();
            return FALSE;
	else:
	    $result = $stmt->get_result();
            $stmt->close();
            while($row = $result->fetch_assoc)
                $table[] = $row;
            $result->close();
	    return $table;
        endif;
    }

    function isEmailRegistered(string $email) : bool{

    }

    function getUserByEmail(string $email) : User | bool {    
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)):
            $this->error = 'Email inválido';
            return FALSE;
        endif;
        $sql = 'SELECT * FROM ' . USER_T . 'WHERE ' . U_E .' = ' . $email;

        if(($user = $this->queryRows($sql)) === FALSE):
            $this->error = 'Erro durante a requisição'; 
            return FALSE;
        endif;

        return new User($user[0][U_ID], $user[0][U_N], $user[0][U_E], $user[0][U_P], $user[0][U_NUM]);
    }
    function __destruct(){
        $this->mysqli->close();
    }

} 
