<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require('../class/productoModel.php');
require('../class/imagenModel.php');
require('../class/config.php');
//creamos una instancia de la clase rolModel

$productos = new productoModel;
$imagenes = new imagenModel;

//print_r($_GET);
if (isset($_GET['id'])) {
	//recuperamos y sanitizamos el dato que viene por cabecera
	$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
	//$id = (int) $id;

	$prod = $productos->getProductoId($id);
	//print_r($prod);exit;
	$img = $imagenes->getImagenProducto($id);

	if (!$prod) {
		$_SESSION['danger'] = 'El dato no es válido';
	}
}

//print_r($res);

if(isset($_SESSION['autenticado']) && $_SESSION['rol'] == 'Administrador'):
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Producto</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('../partials/header.php'); ?>
		<div class="row">
			<div class="col-md-6 mt-3">
				<h3>Producto</h3>
				<!--Valida o notifica que el registro se ha realizado-->
				<?php include('../partials/mensajes.php'); ?>
				<?php if($prod): ?>
					<table class="table table-hover">
						<tr>
							<th>Producto:</th>
							<td><?php echo $prod['nombre']; ?></td>
						</tr>
						<tr>
							<th>Código:</th>
							<td><?php echo $prod['codigo']; ?></td>
						</tr>
						<tr>
							<th>Precio:</th>
							<td><?php echo $prod['precio']; ?></td>
						</tr>
						<tr>
							<th>Categoria:</th>
							<td><?php echo $prod['categoria']; ?></td>
						</tr>
						<tr>
							<th>Marca:</th>
							<td><?php echo $prod['marca']; ?></td>
						</tr>
						<tr>
							<th>Activo:</th>
							<td><?php if($prod['activo']==1): ?> Si <?php else: ?> No <?php endif; ?></td>
						</tr>
						<tr>
							<th>Descripcion:</th>
							<td><?php echo $prod['descripcion']; ?></td>
						</tr>
						<tr>
							<th>Fecha de creación:</th>
							<td>
								<?php
									$fecha_reg = new DateTime($prod['created_at']);
									echo $fecha_reg->format('d-m-Y H:i:s');
								?>
							</td>
						</tr>
						<tr>
							<th>Fecha de modificación:</th>
							<td>
								<?php
									$fecha_mod = new DateTime($prod['updated_at']);
									echo $fecha_mod->format('d-m-Y H:i:s');
								?>
							</td>
						</tr>
					</table>
					<p>
						<a href="edit.php?id=<?php echo $prod['id']; ?>" class="btn btn-link">Editar</a>
						<a href="index.php" class="btn btn-link">Volver</a>
						
						<a href="<?php echo BASE_URL . 'imagenes/addPorProducto.php?id=' . $prod['id']; ?>" class="btn btn-primary">Agregar Imagen</a>
					</p>
				<?php endif; ?>
			</div>
			<!--Area donde mostraremos imagenes de un producto-->
			<div class="col-md-6 mt-3">
				<h4>Imágenes asociadas a <?php echo $prod['nombre']; ?></h4>
				<?php if(isset($img) && count($img)): ?>
					<?php foreach($img as $img): ?>
						<div class="col-md-6">
							<h5><?php echo $img['titulo']; ?></h5>
							<img src="<?php echo BASE_IMG . 'productos/' . $img['nombre']; ?>" class="img-responsive" >
						</div>
					<?php endforeach; ?>
				<?php else: ?>
					<p class="text-info">No hay imágenes asociadas</p>
				<?php endif; ?>
			</div>
		</div>
	</div>
</body>
</html>

<?php else:
	header('Location: ' . BASE_URL . 'index.php');
	endif;