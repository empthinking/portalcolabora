<?php

class Product {
    private $prod_id;
    private $prod_name;
    private $desc;
    private $price;
    private $categ;
    private $user_id;

    public $error; 

    function __construct(db $db, mixed $user_id){
        parent::__construct($db);
        $this->user_id = $user_id;
    } 

    function setName(string $name) : bool {
        if(!validateName($name)){
            $this->error[__METHOD__] = 'Nome inválido';
            return FALSE;
        }

        $this->prod_name = $name;
    }

    function setPrice(mixed $price) : bool {
        if(!validatePrice($price)){
            $this->error[__METHOD__] = 'Formato inválido';
            return FALSE;
        }

        $this->price = (float)$price;
        return TRUE;
    }

    function setDescription(mixed $desc = '') : bool {
        if(empty($desc))
            return TRUE;
        $this->desc = $this->db->real_escape_string(htmlspecialchars(trim((string)$desc)));
        return TRUE;
    }

    function setCategory(mixed $categ) : bool {
        $this->categ = $categ;
        return TRUE;
    }

    function setUserId(int $id) : bool {
        $this->user_id = $id;
        return TRUE;
    }

    protected function validateName(mixed $name) : bool {
        return preg_match('/^[a-zA-Z_0-9]+$/', $name))
    }

    protected function validatePrice(mixed $price) : bool {
        return filter_var($price, FILTER_VALIDATE_FLOAT) || filter_var($price, FILTER_VALIDATE_INT); 
    }

    //protected function validateCategory() : bool;

    function getName() : string{
        return $this->prod_name;
    }

    function getDescription() : string{
        return $this->desc;
    }

    function getPrice() : float {
        return $this->price;
    }

    function getCategory() : string {
        return $this->categ;
    }

    function getUserId() : int {
         return $this->user_id;
    }

    function insert() : bool {
        if(empty($this->prod_name) || empty($this->desc) || empty($this->price) || empty($this->categ)){
            $this->error[__METHOD__] = 'Todos os campos devem ser preenchidos';
            return FALSE;
        }
        $sql = 'INSERT INTO %s(%s, %s, %s, %s) VALUES(%s, %s, %s, %s) WHERE %s = %s';
        $sql = sprintf($sql, P_TABLE, P_N, P_D, P_P, P_C, U_ID, $this->prod_name, $this->prod_desc, $this->price, $this->categ, U_ID, $this->user_id);

        if(!$this->query($sql)){
            $this->error[__METHOD__] = 'Não foi possível concluir a transação';
            return FALSE;
        }
        return TRUE;
    }

    function update(string $column) : bool {
        $sql = 'UPDATE '. P_TABLE . 'SET ' . $column . '=%s WHERE ' . U_ID . ' = ' . $this->user_id;
        if(!$this->query($sql)){
            $this->error[__METHOD__] = 'Não foi possível concluir a transação';
            return FALSE;
        }
        return TRUE;
    }

    function delete() : bool {
        $sql = 'DELETE FROM ' . P_TABLE . ' WHERE ' . U_ID . ' = ' . $this->user_id;
        if(!$this->query($sql)){
            $this->error[__METHOD__] = 'Não foi possível concluir a transação';
            return FALSE;
        }
        return TRUE;
    }

    function close(){
        $this->db->close();
    }
?>
