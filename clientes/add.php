<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require('../class/clienteModel.php');
require('../class/config.php');

//creamos una instancia de la clase rolModel
$clientes = new clienteModel;

//print_r($res);
if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
	$nombre = trim(strip_tags($_POST['nombre']));
    $rut = trim(strip_tags($_POST['rut']));
    $direccion = trim(strip_tags($_POST['direccion']));
    $fechanacimiento = trim(strip_tags($_POST['fechanacimiento']));
    $persona = trim(strip_tags($_POST['persona']));

	if (!$nombre) {
		$mensaje = 'Ingrese el nombre';
	}elseif (!$rut) {
        $mensaje = 'Ingrese el rut';
    }elseif (!$direccion) {
        $mensaje = 'Ingrese la direccion';
    }elseif (!$fechanacimiento) {
        $mensaje = 'Ingrese fecha nacimiento';
    }elseif (!$persona) {
		$mensaje = 'Seleccione la persona';
	}else{

		//consulta por la existencia
		$res = $clientes->getClienteRut($rut);

		if ($res) {
			$mensaje = 'El cliente ingresado ya existe';
		}else{
			$res = $clientes->setClientes($nombre, $rut, $direccion, $fechanacimiento, $persona);

			if ($res) {
				$msg = 'ok';
				header('Location: index.php?m=' . $msg);
			}
		}
	}
}

if(isset($_SESSION['autenticado']) && $_SESSION['rol'] == 'Administrador'):

?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Nuevo cliente</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>

<body>
	<div class="container">
		<?php include('../partials/header.php'); ?>

		<div class="row">
			<div class="col-md-6 mt-3">

				<h3>Nuevo cliente</h3>

				<?php if(isset($mensaje)): ?>
					<p class="alert alert-danger"><?php echo $mensaje; ?></p>
				<?php endif; ?>

				<form action="" method="post">

					<div class="form-group">
						<label>Nombre</label>
						<input type="text" name="nombre" value="<?php echo @($nombre); ?>" placeholder="Ingrese nombre" class="form-control">
					</div>

                    <div class="form-group">
						<label>RUT</label>
						<input type="text" name="rut" value="<?php echo @($rut); ?>" placeholder="Ingrese RUT" class="form-control">
					</div>

                    <div class="form-group">
						<label>Direccion</label>
						<input type="text" name="direccion" value="<?php echo @($direccion); ?>" placeholder="Ingrese direccion" class="form-control">
					</div>

                    <div class="form-group">
						<label>Fecha de nacimiento</label>
						<input type="date" name="fechanacimiento" value="<?php echo @($fechanacimiento); ?>" placeholder="Ingrese fecha nacimiento" class="form-control">
					</div>

                    <div class="form-group">
						<label>Persona</label>
						<input type="text" name="persona" value="<?php echo @($persona); ?>" placeholder="Ingrese persona" class="form-control">
					</div>										

					<div class="form-group">
						<input type="hidden" name="enviar" value="si">
						<button type="submit" class="btn btn-success">Guardar</button>
						<a href="index.php" class="btn btn-link">Volver</a>
					</div>

				</form>
			</div>
		</div>
	</div>
</body>
</html>

<?php else: 
	header('Location: ' . BASE_URL . 'index.php');
	endif;
?>