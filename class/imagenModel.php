<?php
require_once('modelo.php');

class imagenModel extends Modelo
{
	public function __construct(){
		parent::__construct();
    }
    
	public function getImagenes(){
		$img = $this->_db->query("SELECT img.nombre as imagen, p.id, p.nombre as producto, p.precio FROM imagenes img INNER JOIN productos p ON img.producto_id = p.id WHERE img.portada = 1 AND p.activo = 1");

		return $img->fetchall();
	}

	public function getImagenNombre($nombre){
		$id = (int) $id;

		$img = $this->_db->prepare("SELECT id FROM imagenes WHERE id = ?");
		$img->bindParam(1, $nombre);
		$prod->execute();

		return $img->fetch();
	}

	public function getImagenProducto($producto){
		$producto = (int) $producto;

		$img = $this->_db->prepare("SELECT id, titulo, descripcion, nombre FROM imagenes WHERE producto_id = ?");
		$img->bindParam(1, $producto);
		$img->execute();

		return $img->fetchall();
	}

	public function setImagen($titulo, $descripcion, $imagen, $producto, $portada){
		$producto = (int) $producto;
		$portada = (int) $portada;

		$img = $this->_db->prepare("INSERT INTO imagenes VALUES(null, ?, ?, ?, ?, ?, now(), now())");
		$img->bindParam(1, $titulo);
		$img->bindParam(2, $descripcion);
		$img->bindParam(3, $imagen);
		$img->bindParam(4, $producto);
		$img->bindParam(5, $portada);
		$img->execute();

		$row = $img->rowCount();
		return $row;
	}
}