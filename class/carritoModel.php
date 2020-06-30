<?php
require_once('modelo.php');

class carritoModel extends Modelo{
	public function __construct(){
		parent::__construct();
	}

	public function getCarrito(){

	}

	public function getCarritoId($id){

	}

	public function setCarrito($usuario, $cantidad, $producto, $total){
		$mar = $this->_db->prepare("INSERT INTO carrito VALUES(null, ?, ?, ?, ?, now(), now())");
		$mar->bindParam(1, $usuario);
		$mar->bindParam(2, $cantidad);
		$mar->bindParam(3, $producto);
		$mar->bindParam(4, $total);
		$mar->execute();

		$row = $mar->rowCount();
		return $row;
	}
}