<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
session_start();


define('DS', DIRECTORY_SEPARATOR);
define('ROOT', realpath(dirname(__FILE__)) . DS);
define('APP_PATH', ROOT . 'class' . DS);

try{
	require APP_PATH . 'config.php';
}
catch(Exception $e){
	echo $e->getMessage();
}

//print_r(APP_PATH);exit;

if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] == 'si'):
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Bienvenida</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</head>
<body>
	<div class="container">
		<?php include('partials/header.php'); ?>
		<div class="row">
			<div class="col-md-12 mt-3">
				<h4>
					 Bienvenid@ <?php echo $_SESSION['nombre']; ?>
				</h4>
				<ul>
					<li>Su id de usuario es <?php echo $_SESSION['id']; ?></li>
					<li>Su correo es <?php echo $_SESSION['email']; ?></li>
					<li>Su rol es <?php echo $_SESSION['rol']; ?></li>
				</ul>
			</div>
		</div>
	</div>
</body>
</html>

<?php else: 
	header('Location: ' . BASE_URL . 'usuarios/login.php');
endif;
?>