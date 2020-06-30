<?php
require_once('modelo.php');

class usuarioModel extends Modelo{

	public function __construct(){
		//disponemos de lo declarado en el constructor de la clase modelo
		parent::__construct();
	}

	//metodo que muestra todos los usuarios
	public function getUsuarios(){
		$usu = $this->_db->query("SELECT u.id, u.nombre as usuario, r.nombre as rol, u.active FROM usuarios u INNER JOIN roles r ON u.rol_id = r.id ORDER BY rol");

		return $usu->fetchall();
	}

	//metodo que muestra un usuario por id
	public function getUsuarioId($id){
		$id = (int) $id;

		$usu = $this->_db->prepare("SELECT u.id, u.nombre as usuario, r.nombre as rol, u.rol_id, u.active, u.email, u.created_at, u.updated_at FROM usuarios u INNER JOIN roles r ON u.rol_id = r.id WHERE u.id = ?");
		$usu->bindParam(1, $id);
		$usu->execute();

		return $usu->fetch();
	}

	//metodo que verifica que un usuario este registrado
	public function getUsuarioEmail($email){
		$usu = $this->_db->prepare("SELECT id FROM usuarios WHERE email = ?");
		$usu->bindParam(1, $email);
		$usu->execute();

		return $usu->fetch();
	}

	//metodo que verifique usuario y contraseña de un usuario
	public function getUsuarioRegistrado($email, $clave){
		$clave = sha1($clave);

		$usu = $this->_db->prepare("SELECT u.id, u.nombre, u.email, r.nombre as rol FROM usuarios u INNER JOIN roles r ON u.rol_id = r.id WHERE u.email = ? AND u.password = ? AND u.active = 1");
		$usu->bindParam(1, $email);
		$usu->bindParam(2, $clave);
		$usu->execute();

		return $usu->fetch();
	}

	//metodo para insertar usuarios
	public function setUsuario($nombre, $email, $clave, $rol){
		$rol = (int) $rol;
		$clave = sha1($clave);

		//activo = 1 y 2 = inactivo

		$usu = $this->_db->prepare("INSERT INTO usuarios VALUES(null, ?, ?, ?, ?, 1, now(), now())");
		$usu->bindParam(1, $nombre);
		$usu->bindParam(2, $email);
		$usu->bindParam(3, $clave);
		$usu->bindParam(4, $rol);
		$usu->execute();

		$row = $usu->rowCount();
		return $row;
	}

	//metodo para editar usuario
	public function editUsuario($id, $nombre, $email, $rol, $active){
		$rol = (int) $rol;

		$usu = $this->_db->prepare("UPDATE usuarios SET nombre = ?, email = ?, rol_id = ?, active = ?, updated_at = now() WHERE id = ?");
		$usu->bindParam(1, $nombre);
		$usu->bindParam(2, $email);
		$usu->bindParam(3, $rol);
		$usu->bindParam(4, $active);
		$usu->bindParam(5, $id);
		$usu->execute();

		$row = $usu->rowCount();
		return $row;
	}

	//metodo para cambiar password
	public function editPassword($id, $clave){
		$id = (int) $id;
		$clave = sha1($clave);

		$usu = $this->_db->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
		$usu->bindParam(1, $clave);
		$usu->bindParam(2, $id);
		$usu->execute();

		$row = $usu->rowCount();
		return $row;
	}
}