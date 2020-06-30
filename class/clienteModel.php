<?php
require_once('modelo.php');

class clienteModel extends Modelo
{
	public function __construct(){
		//disponemos de lo declarado en el constructor de la clase modelo
		parent::__construct();
	}

	//traemos todos los roles de la tabla roles
	public function getClientes(){
		//consulta a la tabla roles usando el objeto db de la clase modelo
		$clientes = $this->_db->query("SELECT id, nombre, rut, direccion, fecha_nacimiento, persona FROM clientes ORDER BY nombre");

		//retornamos lo que haya en la tabla roles
		return $clientes->fetchall();
	}

	public function getClienteId($id){
		$id = (int) $id;

		$cli = $this->_db->prepare("SELECT id, nombre, rut, direccion, fecha_nacimiento, persona, created_at, updated_at FROM clientes WHERE id = ?");
		
		$cli->bindParam(1, $id);
		$cli->execute();

		return $cli->fetch();
	}

	//verificar el registro previo
	public function getClienteRut($rut){
		$cli = $this->_db->prepare("SELECT id FROM clientes WHERE rut = ?");
		$cli->bindParam(1, $rut);
		$cli->execute();

		return $cli->fetch();
	}

	public function setClientes($nombre, $rut, $direccion, $fechanacimiento, $persona){
		$cli = $this->_db->prepare("INSERT INTO clientes VALUES(null, ?, ?, ?, ?, ?, now(), now())");
        $cli->bindParam(1, $nombre); 
        $cli->bindParam(2, $rut);
        $cli->bindParam(3, $direccion);
        $cli->bindParam(4, $fechanacimiento);
        $cli->bindParam(5, $persona);
		$cli->execute();//ejecutamos la consulta

		$row = $cli->rowCount(); //devuelve la cantidad de registros insertados
		return $row;
	}

	//metodo para actualizar o modificar 
	public function editClientes($id, $nombre, $rut, $direccion, $fechanacimiento, $persona){
		//print_r($nombre);exit;
		$id = (int) $id;

		$cli = $this->_db->prepare("UPDATE clientes SET nombre = ?, rut = ?, direccion = ?, fecha_nacimiento = ?, persona = ?, updated_at = now() WHERE id = ?");
        $cli->bindParam(1, $nombre);
        $cli->bindParam(2, $rut);
        $cli->bindParam(3, $direccion);
        $cli->bindParam(4, $fechanacimiento);
        $cli->bindParam(5, $persona);
		$cli->bindParam(6, $id);
		$cli->execute();

		$row = $cli->rowCount(); //devuelve la cantidad de registros modificadas
		//print_r($row);exit;
		return $row;
	}

	//metodo para eliminar 
	public function deleteClientes($id){
		$id = (int) $id;

		$cli = $this->_db->prepare("DELETE FROM clientes WHERE id = ?");
		$cli->bindParam(1, $id);
		$cli->execute();

		$row = $cli->rowCount();
		return $row;
	}
}