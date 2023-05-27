<?php
define('SQL_INSERT_PRODUCT', 'INSERT INTO products(produto_nome, produto_descricao, produto_preco, produto_category, user_id) VALUES(?, ?, ?, ?, ?)  WHERE prod_id = ?');
define('SQL_SELECT_PRODUCT', 'SELECT * FROM products WHERE user_id = ?');
define('SQL_UPDATE_PRODUCT_NAME', 'UPDATE products SET produto_nome = ? WHERE user_id = ?');
define('SQL_UPDATE_PRODUCT_DESCRIPTION', 'UPDATE products SET produto_descricao = ? WHERE user_id = ?');
define('SQL_UPDATE_PRODUCT_PRICE', 'UPDATE products SET produto_preco = ? WHERE user_id = ?');
define('SQL_UPDATE_PRODUCT_CATEGORY', 'UPDATE products SET produto_category = ? WHERE user_id = ?');
define('SQL_DELETE_PRODUCT', 'DELETE FROM products WHERE produto_id = ?');


class Product {
   private $prod_id;
   private $prod_name;
   private $desc;
   private $price;
   private $categ;
   private $user_id;
   private $mysqli;

   function __construct(mysqli $mysqli, int $user_id){
       if(isset($user_id) && filter_var($user_id, FILTER_VALIDATE_INT)):
           $this->user_id = $user_id;
       else:
           throw new Exception('ID de usuario ausente ou inválido');
       endif;
   
	if(isset($mysqli)):
         $this->mysqli = $mysqli;
      else:
         throw new Exception('Necessita do objeto mysqli');
       endif;
   } 

    function setName(string $name) : void {
        $this->prod_name = $name;
    }

    function setPrice(float $price) : void {
        $this->price = $price;
    }

    function setDescription(string $desc) : void {
        $this->desc = $desc;
    }

    function setCategory(string $categ) : void{
        $this->categ = $categ;
    }
    function setUserId(int $id) : void {
	    $this->user_id = $id;
    }

    function setAllProductData(string $name, string $desc, float $price, string $categ) : void{
        if(empty($name) || empty($desc) || empty($price) || empty($categ))
            throw new Exception('Todos os campos devem ser preenchidos');
        if(!preg_match('/^[a-zA-Z_0-9]+$/', $name))
            throw new Exception('Nome deve conter apenas letras, números ou sublinhado apenas');
        if(!filter_var($price, FILTER_VALIDATE_FLOAT))
            throw new Exception('Preço em formato inválido');
      //Filtro de categoria a definir

        $this->prod_name  = $name;
        $this->desc       = $desc;
        $this->price      = $price;
        $this->categ      = $categ;
    }
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
    function getProductDataById() : void {
        $stmt = $this->mysqli->prepare(SQL_SELECT_PRODUCT);
        $stmt->bind_param('i', $this->user_id);
        if($stmt->execute()):
            $result  = $stmt->get_result();
            $row     = $result->fetch_assoc();

            $this->id         = $row['produto_id'];   
            $this->prod_name  = $row['produto_nome'];
            $this->desc       = $row['produto_descricao'];
            $this->price      = $row['produto_preco'];
            $this->categ      = $row['produto_category'];
            $this->user_id    = $row['user_id'];
        else:
            throw new Exception($this->mysqli->error . PHP_EOL . $this->mysqli->errno);
        endif;

      $stmt->close();
      $result->free_result();
    }
/*
    function getProductData(string $sql) : void {
        $stmt = $this->mysqli->prepare($sql);
        $stmt->bind_param('i', $this->user_id);
        if($stmt->execute()):
            $result  = $stmt->get_result();
            $row     = $result->fetch_assoc();

            $this->id         = $row['produto_id'];   
            $this->prod_name  = $row['produto_nome'];
            $this->desc       = $row['produto_descricao'];
            $this->price      = $row['produto_preco'];
            $this->categ      = $row['produto_category'];
            $this->user_id    = $row['user_id'];
        else:
            throw new Exception($this->mysqli->error . PHP_EOL . $this->mysqli->errno);
        endif;

      $stmt->close();
      $result->free_result();
    }
 */

    function insertToDataBase() : void {
        $stmt = $this->mysqli->prepare(SQL_INSERT_PRODUCT);
        $stmt->bind_param('ssdsii', $this->prod_name, $this->desc, $this->price, $this->categ, $this->user_id, $this->prod_id);
        if(!$stmt->execute())
            throw new Exception($this->mysqli->error . PHP_EOL . $this->mysqli->errno);
        $stmt->close();
    }

    function updateNameFromDataBase(){
	if(!isset($this->prod_name)) throw new Exception('Nome ausente');
        $stmt = $this->mysqli->prepare(SQL_UPDATE_PRODUCT_NAME);
        $stmt->bind_param('si', $this->prod_name, $this->id);
        if(!$stmt->execute())
            throw new Exception($this->mysqli->error . PHP_EOL . $this->mysqli->errno);
        $stmt->close();
    }

    function updateDescriptionFromDataBase(){
	    if(!isset($this->desc)) throw new Exception('Descrição ausente');
        $stmt = $this->mysqli->prepare(SQL_UPDATE_PRODUCT_DESCRIPTION);
        $stmt->bind_param('si', $this->desc, $this->prod_id);
        if(!$stmt->execute())
            throw new Exception($this->mysqli->error . PHP_EOL . $this->mysqli->errno);
        $stmt->close();
    }
    function updatePriceFromDataBase(){
	    if(!isset($this->price)) throw new Exception('Preço ausente');
        $stmt = $this->mysqli->prepare(SQL_UPDATE_PRODUCT_DESCRIPTION);
        $stmt->bind_param('di', $this->price, $this->prod_id);
        if(!$stmt->execute())
            throw new Exception($this->mysqli->error . PHP_EOL . $this->mysqli->errno);
        $stmt->close();
    }
    function updateCategoryFromDataBase(){
	    if(!isset($this->categ)) throw new Exception('Categoria ausente');
        $stmt = $this->mysqli->prepare(SQL_UPDATE_PRODUCT_CATEGORY);
        $stmt->bind_param('si', $this->categ, $this->prod_id);
        if(!$stmt->execute())
            throw new Exception($this->mysqli->error . PHP_EOL . $this->mysqli->errno);
        $stmt->close();
    }
    function deleteProduct(){
        $stmt = $this->mysqli->prepare(SQL_PRODUCT_DELETE);
        $stmt->bind_param('i', $this->prod_id);
        if(!$stmt->execute())
            throw new Exception($this->mysqli->error . PHP_EOL . $this->mysqli->errno);
        $stmt->close();
    }

    function close(){
        $this->mysqli->close();
    }
?>
