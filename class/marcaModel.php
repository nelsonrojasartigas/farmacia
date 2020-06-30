<?php
require_once('modelo.php');

class marcaModel extends Modelo{
	public function __construct(){
		parent::__construct();
	}

	public function getMarcas(){
		$mar = $this->_db->query("SELECT id, nombre FROM marcas ORDER BY nombre");

		return $mar->fetchall();
	}

	public function getMarcaId($id){
		$id = (int) $id;

		$mar = $this->_db->prepare("SELECT id, nombre, created_at, updated_at FROM marcas WHERE id = ?");
		$mar->bindParam(1, $id);
		$mar->execute();

		return $mar->fetch();
	}

	public function getMarcaNombre($nombre){
		$mar = $this->_db->prepare("SELECT id FROM marcas WHERE nombre = ?");
		$mar->bindParam(1, $nombre);
		$mar->execute();

		return $mar->fetch();
	}

	public function setMarca($nombre){
		$mar = $this->_db->prepare("INSERT INTO marcas VALUES(null, ?, now(), now())");
		$mar->bindParam(1, $nombre);
		$mar->execute();

		$row = $mar->rowCount();
		return $row;
	}

	public function editMarca($id, $nombre){
		$id = (int) $id;

		$mar = $this->_db->prepare("UPDATE marcas SET nombre = ?, updated_at = now() WHERE id = ?");
		$mar->bindParam(1, $nombre);
		$mar->bindParam(2, $id);
		$mar->execute();

		$row = $mar->rowCount();
		return $row;
	}
}