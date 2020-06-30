  <!--si existe, imprime, muestra success y elimina variable de sesion-->
  <?php if(isset($_SESSION['success'])): ?>
	<p class="alert alert-success"><?php echo $_SESSION['success']; ?></p>
<?php 
	
	unset($_SESSION['success']);
	endif;
?>


<?php if(isset($_SESSION['danger'])): ?>
	<p class="alert alert-danger"><?php echo $_SESSION['danger']; ?></p>
<?php 
	unset($_SESSION['danger']);
	endif;
?>