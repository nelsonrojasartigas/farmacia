<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require('../class/categoriaModel.php');
require('../class/marcaModel.php');
require('../class/productoModel.php');
require('../class/config.php');

//creamos una instancia de la clase rolModel
$productos = new productoModel;
$marcas = new marcaModel;
$categorias = new categoriaModel;


//print_r($_GET);

if (isset($_GET['id'])) {
	//recuperamos y sanitizamos el dato que viene por cabecera
	$id = filter_var($_GET['id'], FILTER_VALIDATE_INT);
	//$id = (int) $id;

	$res = $productos->getProductoId($id);
	$cat = $categorias->getcategorias();
	$mar = $marcas->getMarcas();



	if (!$res) {
		$msg = 'error';
		header('Location: index.php?e=' . $msg);
	}

	if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
		//sanitizamos el dato
		//print_r($_POST);exit;
        $nombre = trim(strip_tags($_POST['nombre']));
		$codigo = trim(strip_tags($_POST['codigo']));
		$precio = trim(strip_tags($_POST['precio']));
		$categoria = (int) $_POST['categoria'];
		$marca = (int) $_POST['marca'];
		$activo = (int) $_POST['activo'];
        $descripcion = trim(strip_tags($_POST['descripcion']));
        
		if (!$nombre) {
            $mensaje = 'Ingrese el nombre';
        }elseif (!$codigo) {
			$mensaje = 'Ingrese el codigo';
		}elseif (!$precio) {
			$mensaje = 'Ingrese precio';
		}elseif (!$categoria) {
            $mensaje = 'Ingrese categoria';
		}elseif (!$marca) {
            $mensaje = 'Ingrese marca';
        }elseif (!$activo) {
            $mensaje = 'Seleccione Activo / Desactivo';
        }elseif (!$descripcion) {
            $mensaje = 'Ingrese descripcion';
		}else{
			//print_r($id);exit;
			//actualizamos el rol
			$res = $productos->editProducto($id, $nombre, $codigo, $precio, $categoria, $marca, $descripcion, $activo);
			//print_r($res);exit;
			if ($res) {
				$msg = 'ok';
				header('Location: show.php?m=' . $msg . '&id=' . $id);
			}
		}
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
				<?php if(isset($_GET['m'])): ?>
					<p class="alert alert-success">El producto se ha modificado correctamente</p>
				<?php endif; ?>

				<?php if(isset($mensaje)): ?>
					<p class="alert alert-danger"><?php echo $mensaje; ?></p>
				<?php endif; ?>

				<form action="" method="post">

					<div class="form-group">
						<label>Nombre</label>
						<input type="text" name="nombre" value="<?php echo $res['nombre']; ?>" placeholder="Nombre del producto" class="form-control">
					</div>

                    <div class="form-group">
						<label>Codigo</label>
						<input type="text" name="codigo" value="<?php echo $res['codigo']; ?>" placeholder="Codigo" class="form-control">
					</div>

					<div class="form-group">
						<label>Precio</label>
						<input type="text" name="precio" value="<?php echo $res['precio']; ?>" placeholder="Precio del producto" class="form-control">
					</div>

					<div class="form-group">
						<label>Categoria</label>
						<select name="categoria" class="form-control">
							<option value="<?php echo $res['categorias_id'] ?>"><?php echo $res['categoria']; ?></option>
								<?php foreach($cat as $r):?>
									<option value="<?php echo $r['id']; ?>"><?php echo $r['nombre']; ?></option>
								<?php endforeach; ?>
						</select>
					</div>

					<div class="form-group">
						<label>Marca</label>
						<select name="marca" class="form-control">
							<option value="<?php echo $res['marcas_id'] ?>"><?php echo $res['marca']; ?></option>
								<?php foreach($mar as $r):?>
									<option value="<?php echo $r['id']; ?>"><?php echo $r['nombre']; ?></option>
								<?php endforeach; ?>
						</select>
					</div>

					<div class="form-group">
						<label>Activo</label>
						<input type="text" name="activo" value="<?php echo $res['activo']; ?>" placeholder="..." class="form-control">
					</div>

                    <div class="form-group">
						<label>Descripción</label>
						<textarea name="descripcion" value="<?php echo $res['descripcion']; ?>" class="form-control" rows="4" style="resize: none" placeholder="Descripcion">
						</textarea>
					</div>

                    

                    

					<div class="form-group">
						<input type="hidden" name="enviar" value="si">
						<button type="submit" class="btn btn-success">Modificar</button>
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