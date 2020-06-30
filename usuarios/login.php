<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require('../class/usuarioModel.php');


//print_r($res);
if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
	//creamos una instancia de la clase rolModel y usuarioModel
	$usuarios = new usuarioModel;

	$email = trim(strip_tags($_POST['email']));
	$password = trim(strip_tags($_POST['password']));

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$mensaje = 'Ingresa tu email';
	}elseif (!$password) {
		$mensaje = 'Ingresa tu password';
	}else{
		//verificar que el usuario este registrado
		$res = $usuarios->getUsuarioRegistrado($email, $password);

		if ($res) {
			//inicio de session
			$_SESSION['autenticado'] = 'si';//esta variable de session inicializa una session de un usuario
			$_SESSION['id'] = $res['id'];//esta variable de session guarda el id del usuario registrado
			$_SESSION['nombre'] = $res['nombre'];//esta variable de session guarda el nombre del usuario
			$_SESSION['email'] = $res['email'];//esta variable de session guarda el email del usuario
			$_SESSION['rol'] = $res['rol'];//esta variable de session guarda el nombre del rol del usuario

			header('Location: ../index.php');
		}else{
			$mensaje = 'El usuario o el password no son correctos';
		}
	}
}

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">

	<title>Login Usuario</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<img src="https://image.freepik.com/foto-gratis/contador-tienda-mesa-farmacia-fondo-estante-borroso-desenfoque-foco-droga-medico-tienda-farmacia-medicamento-blanco-medicina-farmacia_109285-5942.jpg" class="rounded float-left"  alt="..." width="450" height="330" style="vertical-align:middle;margin:10px 20px">
</head>
<body>
	<div class="container">
		<?php include('../partials/header.php'); ?>
		<div class="row">
			<div class="col-md-6 mt-3">
				<h3>Login Usuario</h3>
				<?php if(isset($mensaje)): ?>
					<p class="alert alert-danger"><?php echo $mensaje; ?></p>
				<?php endif; ?>
				<form action="" method="post">
					<div class="form-group">
						<label>Email</label>
						<input type="email" name="email" placeholder="Tu email" class="form-control">
					</div>
					<div class="form-group">
						<label>Password</label>
						<input type="password" name="password" class="form-control" placeholder="Tu password">
					</div>
					<div class="form-group">
						<input type="hidden" name="enviar" value="si">
						<button type="submit" class="btn btn-success">Ingresar</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</body>
</html>