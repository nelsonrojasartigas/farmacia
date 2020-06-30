<?php
require_once('modelo.php');

class categoriaModel extends Modelo
{
	public function __construct(){
		//disponemos de lo declarado en el constructor de la clase modelo
		parent::__construct();
	}

	//traemos todos los roles de la tabla roles
	public function getCategorias(){
		//consulta a la tabla roles usando el objeto db de la clase modelo
		$categorias = $this->_db->query("SELECT id, nombre, codigo FROM categorias ORDER BY nombre");

		//retornamos lo que haya en la tabla roles
		return $categorias->fetchall();
	}

	public function getcategoriaId($id){
		$id = (int) $id;

		$cat = $this->_db->prepare("SELECT id, nombre, codigo, created_at, updated_at FROM categorias WHERE id = ?");
		
		$cat->bindParam(1, $id);
		$cat->execute();

		return $cat->fetch();
	}

	//verificar el registro previo de un rol
	public function getCategoriaNombre($nombre){
		$cat = $this->_db->prepare("SELECT id FROM categorias WHERE nombre = ?");
		$cat->bindParam(1, $nombre);
		$cat->execute();

		return $cat->fetch();
	}

	public function setCategorias($nombre, $codigo){
		$cat = $this->_db->prepare("INSERT INTO categorias VALUES(null, ?, ?, now(), now())");
        $cat->bindParam(1, $nombre); //definimos el valor de cada ?
        $cat->bindParam(2, $codigo);
		$cat->execute();//ejecutamos la consulta

		$row = $cat->rowCount(); //devuelve la cantidad de registros insertados
		return $row;
	}

	//metodo para actualizar o modificar categorias
	public function editCategorias($id, $nombre, $codigo){
		//print_r($nombre);exit;
		$id = (int) $id;

		$cat = $this->_db->prepare("UPDATE categorias SET nombre = ?, codigo = ?, updated_at = now() WHERE id = ?");
        $cat->bindParam(1, $nombre);
        $cat->bindParam(2, $codigo);
		$cat->bindParam(3, $id);
		$cat->execute();

		$row = $cat->rowCount(); //devuelve la cantidad de registros modificadas
		//print_r($row);exit;
		return $row;
	}

	//metodo para eliminar roles
	public function deleteCategorias($id){
		$id = (int) $id;

		$cat = $this->_db->prepare("DELETE FROM categorias WHERE id = ?");
		$cat->bindParam(1, $id);
		$cat->execute();

		$row = $cat->rowCount();
		return $row;
	}
}