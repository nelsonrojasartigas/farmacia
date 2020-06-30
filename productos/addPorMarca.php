<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();

require('../class/marcaModel.php');
require('../class/categoriaModel.php');
require('../class/productoModel.php');
require('../class/config.php');

//creamos las instancias para agregar un producto
$marcas = new marcaModel;
$categorias = new categoriaModel;
$productos = new productoModel;

if (isset($_GET['id'])) {
	$marca = (int) $_GET['id'];

	$mar = $marcas->getMarcaId($marca);

	if (isset($_POST['enviar']) && $_POST['enviar'] == 'si') {
		$nombre = trim(strip_tags($_POST['nombre']));
		$codigo = trim(strip_tags($_POST['codigo']));
		$precio = (int) $_POST['precio'];
		$categoria = (int) $_POST['categoria'];
		$descripcion = trim(strip_tags($_POST['descripcion']));

		if (!$nombre) {
			$mensaje = 'Ingrese el nombre del producto';
		}elseif (!$codigo) {
			$mensaje = 'Ingrese el codigo del producto';
		}elseif ($precio < 0) {
			$mensaje = 'El precio no puede ser menor que 0';
		}elseif (!$categoria) {
			$mensaje = 'Seleccione una categoría';
		}else{

			//consulta por la existencia de la categoria
			$res = $productos->getProductoCodigo($codigo);

			if ($res) {
				$mensaje = 'El producto ya existe';
			}else{
				$res = $productos->setProducto($nombre, $codigo, $precio, $categoria, $marca, $descripcion);

				if ($res) {
					$_SESSION['success'] = 'El producto se ha registrado correctamente';
					header('Location: ../marcas/show.php?id=' . $marca);
				}
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
	<title>Nuevo Producto por Marca</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('../partials/header.php'); ?>
		<div class="row">
			<div class="col-md-6 mt-3">
				<h3>Nuevo Producto</h3>
				<?php if(isset($mensaje)): ?>
					<p class="alert alert-danger"><?php echo $mensaje; ?></p>
				<?php endif; ?>

				<form action="" method="post">
					<div class="form-group">
						<label><h4 class="text-info">Marca: <?php echo $mar['nombre']; ?></h4></label>
                    </div>
                    
					<div class="form-group">
						<label>Nombre</label>
						<input type="text" name="nombre" value="<?php echo @($nombre); ?>" placeholder="Nombre del producto" class="form-control">
                    </div>
                    
					<div class="form-group">
						<label>Código</label>
						<input type="text" name="codigo" value="<?php echo @($codigo); ?>" placeholder="Código del producto" class="form-control">
                    </div>
                    
					<div class="form-group">
						<label>Precio (CLP)</label>
						<input type="number" name="precio" value="<?php echo @($precio); ?>" placeholder="Precio del producto" class="form-control">
                    </div>
                    
					<div class="form-group">
						<label>Categoría</label>
						<select name="categoria" class="form-control">
							<option value="">Seleccione...</option>
							<?php
								$cat = $categorias->getCategorias();
								foreach($cat as $c):
							?>
								<option value="<?php echo $c['id'] ?>"><?php echo $c['nombre'] ?></option>

							<?php endforeach; ?>
						</select>
                    </div>
                    
					<div class="form-group">
						<label>Descripción</label>
						<textarea name="descripcion" class="form-control" rows="4" style="resize: none">
							<?php echo @($descripcion); ?>
						</textarea>
                    </div>
                    
					<div class="form-group">
						<input type="hidden" name="enviar" value="si">
						<button type="submit" class="btn btn-success">Guardar</button>
						<a href="<?php echo BASE_URL . 'marcas/show.php?id=' . $marca; ?>" class="btn btn-link">Volver</a>
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