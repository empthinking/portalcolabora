<?php
declare(strict_types=1);
class Product {
	private $id;
	private $prodName;
	private $desc;
	private $cat;
	private $price;

	function __construct(string $name, string $desc, int $cat, float $price, int $id){
	}
	function getName() : string{
		return $this->prodName;
	}
	function getDesc() : string{
		return $this->desc;
	}
	function getCategory() : string{
		return $this->cat;
	}
	function getPrice() : float{
		return $this->price;
	}
	function setName($name) : void{
		$this->prodName = name;
	}
	function setDesc($desc) : void{
		$this->desc = $desc;
	}

?>
