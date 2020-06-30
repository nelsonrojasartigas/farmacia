<?php
require('modelo.php');

class rolModel extends Modelo
{
	public function __construct(){
		//disponemos de lo declarado en el constructor de la clase modelo
		parent::__construct();
	}

	//traemos todos los roles de la tabla roles
	public function getRoles(){
		//consulta a la tabla roles usando el objeto db de la clase modelo
		$roles = $this->_db->query("SELECT id, nombre FROM roles ORDER BY nombre");

		//retornamos lo que haya en la tabla roles
		return $roles->fetchall();
	}

	public function getRolId($id){
		$id = (int) $id;

		$rol = $this->_db->prepare("SELECT id, nombre, created_at, updated_at FROM roles WHERE id = ?");
		
		$rol->bindParam(1, $id);
		$rol->execute();

		return $rol->fetch();
	}

	//verificar el registro previo de un rol
	public function getRolNombre($nombre){
		$rol = $this->_db->prepare("SELECT id FROM roles WHERE nombre = ?");
		$rol->bindParam(1, $nombre);
		$rol->execute();

		return $rol->fetch();
	}

	public function setRoles($nombre){
		$rol = $this->_db->prepare("INSERT INTO roles VALUES(null, ?, now(), now())");
		$rol->bindParam(1, $nombre); //definimos el valor de cada ?
		$rol->execute();//ejecutamos la consulta

		$row = $rol->rowCount(); //devuelve la cantidad de registros insertados
		return $row;
	}

	//metodo para actualizar o modificar roles
	public function editRoles($id, $nombre){
		//print_r($nombre);exit;
		$id = (int) $id;

		$rol = $this->_db->prepare("UPDATE roles SET nombre = ?, updated_at = now() WHERE id = ?");
		$rol->bindParam(1, $nombre);
		$rol->bindParam(2, $id);
		$rol->execute();

		$row = $rol->rowCount(); //devuelve la cantidad de registros modificadas
		//print_r($row);exit;
		return $row;
	}

	//metodo para eliminar roles
	public function deleteRoles($id){
		$id = (int) $id;

		$rol = $this->_db->prepare("DELETE FROM roles WHERE id = ?");
		$rol->bindParam(1, $id);
		$rol->execute();

		$row = $rol->rowCount();
		return $row;
	}
}