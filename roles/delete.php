<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require('../class/rolModel.php');
//creamos una instancia de la clase rolModel
$roles = new rolModel;

if (isset($_GET['id'])) {
	$id = (int) $_GET['id'];

	//preguntamos si existe datos asociados al id
	$res = $roles->getRolId($id);

	if ($res) {
		//eliminar
		$sql = $roles->deleteRoles($id);

		if ($sql) {
			$msg = 'ok';
			header('Location: index.php?mg=' . $msg);
		}else{
			$msg = 'error';
			header('Location: index.php?er=' . $msg);
		}

	}else{
		$msg = 'error';
		header('Location: index.php?e=' . $msg);
	}
}
if(isset($_SESSION['autenticado']) && $_SESSION['rol'] == 'Administrador'):

else: 
	header('Location: ' . BASE_URL . 'index.php');
	endif;