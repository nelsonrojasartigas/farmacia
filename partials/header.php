
<nav class="navbar navbar-expand-lg navbar-light" style="background-color: #e3f2fd;">
    <a class="navbar-brand" href="#">Farmacia</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

      <?php if(isset($_SESSION['autenticado']) && $_SESSION['rol'] == 'Administrador'): ?>

        <li class="nav-item active">
            <a class="nav-link" href="<?php echo BASE_URL . 'index.php' ?>">Home <span class="sr-only">(current)</span></a>
        </li>

        <li class="nav-item dropdown">          
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Administración</a>
          
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                <a class="dropdown-item" href="<?php echo BASE_URL . 'categorias/'; ?>">Categorias</a>
                <a class="dropdown-item" href="<?php echo BASE_URL . 'clientes/'; ?>">Clientes</a>
                <a class="dropdown-item" href="<?php echo BASE_URL . 'marcas/'; ?>">Marcas</a>
                <a class="dropdown-item" href="<?php echo BASE_URL . 'productos/'; ?>">Productos</a>
            <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="<?php echo BASE_URL . 'roles/'; ?>">Roles</a>
                <a class="dropdown-item" href="<?php echo BASE_URL . 'usuarios/'; ?>">Usuarios</a>
            </div>
                            
        </li>

      </li>
      <?php endif; ?>  

        <?php if(isset($_SESSION['autenticado'])): ?>
          <a class="nav-link" href="<?php echo BASE_URL . 'usuarios/cerrar.php' ?>">Cerrar Sesión</a>
        <?php endif; ?>
     
    </ul>

  </div>
</nav>