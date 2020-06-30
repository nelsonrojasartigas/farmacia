<?php
require_once('modelo.php');

class productoModel extends Modelo
{

	public function __construct(){
		parent::__construct();
	}

	public function getProductos(){
		$prod = $this->_db->query("SELECT p.id, p.nombre, p.codigo, p.precio, c.nombre as categoria, m.nombre as marca, p.activo FROM productos p INNER JOIN categorias c ON c.id = p.categorias_id INNER JOIN marcas m ON m.id = p.marcas_id ORDER BY p.nombre");

		return $prod->fetchall();
	}

	public function getProductoId($id){
		$id = (int) $id;

		$prod = $this->_db->prepare("SELECT p.id, p.nombre, p.codigo, p.precio, c.nombre as categoria, m.nombre as marca, p.descripcion, p.activo, p.created_at, p.updated_at FROM productos p INNER JOIN categorias c ON c.id =p.categorias_id INNER JOIN marcas m ON m.id = p.marcas_id WHERE p.id = ?");
		$prod->bindParam(1, $id);
		$prod->execute();

		return $prod->fetch();
	}

	public function getProductoCodigo($codigo){
		$prod = $this->_db->prepare("SELECT p.id, p.nombre, p.codigo, p.precio, c.nombre as categoria, m.nombre as marca, p.descripcion, p.created_at, p.updated_at FROM productos p INNER JOIN categorias c ON c.id =p.categorias_id INNER JOIN marcas m ON m.id = p.marcas_id ORDER BY p.nombre WHERE p.codigo = ?");
		$prod->bindParam(1, $codigo);
		$prod->execute();

		return $prod->fetch();
	}

	public function getProductoCategoria($categoria){
		$categoria = (int) $categoria;

		$prod = $this->_db->prepare("SELECT p.id, p.nombre, p.codigo, p.precio, c.nombre as categoria, m.nombre as marca, p.descripcion, p.created_at, p.updated_at FROM productos p INNER JOIN categorias c ON c.id =p.categorias_id INNER JOIN marcas m ON m.id = p.marcas_id ORDER BY p.nombre WHERE p.categorias_id = ?");
		$prod->bindParam(1, $categoria);
		$prod->execute();

		return $prod->fetchall();
	}

	public function getProductoMarca($marca){
		//print_r($marca);exit;
		$marca = (int) $marca;

		$prod = $this->_db->prepare("SELECT p.id, p.nombre, p.codigo, p.precio, c.nombre as categoria, m.nombre as marca, p.descripcion, p.activo, p.created_at, p.updated_at FROM productos p INNER JOIN categorias c ON c.id = p.categorias_id INNER JOIN marcas m ON m.id = p.marcas_id WHERE p.marcas_id = ? ORDER BY p.nombre");
		$prod->bindParam(1, $marca);
		$prod->execute();

		return $prod->fetchall();
	}

	public function setProducto($nombre, $codigo, $precio, $categoria, $marca, $descripcion){
		$precio = (int) $precio;
		$categoria = (int) $categoria;
		$marca = (int) $marca;

		//1 es activo, 2 es inactivo

		$prod = $this->_db->prepare("INSERT INTO productos VALUES(null, ?, ?, ?, ?, ?, ?, 1, now(), now())");
		$prod->bindParam(1, $nombre);
		$prod->bindParam(2, $codigo);
		$prod->bindParam(3, $precio);
		$prod->bindParam(4, $categoria);
		$prod->bindParam(5, $marca);
		$prod->bindParam(6, $descripcion);
		$prod->execute();

		$row = $prod->rowCount();
		return $row;
	}

	public function editProducto($id, $nombre, $codigo, $precio, $categoria, $marca, $descripcion, $activo){
		$id = (int) $id;
		$precio = (int) $precio;
		$categoria = (int) $categoria;
		$marca = (int) $marca;
		$activo = (int) $activo;

		$prod = $this->_db->prepare("UPDATE productos SET nombre = ?, codigo = ?, precio = ?, categorias_id = ?, marcas_id = ?, descripcion = ?, activo = ?, updated_at = now() WHERE id = ?");
		$prod->bindParam(1, $nombre);
		$prod->bindParam(2, $codigo);
		$prod->bindParam(3, $precio);
		$prod->bindParam(4, $categoria);
		$prod->bindParam(5, $marca);
		$prod->bindParam(6, $descripcion);
		$prod->bindParam(7, $activo);
		$prod->bindParam(8, $id);
		$prod->execute();

		$row = $prod->rowCount();
		return $row;
	}
}