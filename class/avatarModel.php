<?php
require_once('modelo.php');

class avatarModel extends Modelo
{
	public function __construct(){
		parent::__construct();
    }
    
	public function getAvatares(){
		$ava = $this->_db->query("SELECT ava.nombre as avatar, c.id, c.nombre as cliente, c.rut FROM avatares ava INNER JOIN clientes c ON ava.cliente_id = c.id WHERE ava.portada = 1 AND c.persona = 1");

		return $ava->fetchall();
	}

	public function getAvatarNombre($nombre){
		$id = (int) $id;

		$ava = $this->_db->prepare("SELECT id FROM avatares WHERE id = ?");
		$ava->bindParam(1, $nombre);
		$prod->execute();

		return $ava->fetch();
	}

	public function getAvatarCliente($cliente){
		$cliente = (int) $cliente;

		$ava = $this->_db->prepare("SELECT id, titulo, descripcion, nombre FROM avatares WHERE cliente_id = ?");
		$ava->bindParam(1, $cliente);
		$ava->execute();

		return $ava->fetchall();
	}

	public function setAvatar($titulo, $descripcion, $avatar, $cliente, $portada){
		$cliente = (int) $cliente;
		$portada = (int) $portada;

		$ava = $this->_db->prepare("INSERT INTO avatares VALUES(null, ?, ?, ?, ?, ?, now(), now())");
		$ava->bindParam(1, $titulo);
		$ava->bindParam(2, $descripcion);
		$ava->bindParam(3, $avatar);
		$ava->bindParam(4, $cliente);
		$ava->bindParam(5, $portada);
		$ava->execute();

		$row = $ava->rowCount();
		return $row;
	}
}