<?php
session_start();

unset($_SESSION['autenticado']);
unset($_SESSION['id']);
unset($_SESSION['nombre']);
unset($_SESSION['email']);

session_destroy();



header('Location: login.php');