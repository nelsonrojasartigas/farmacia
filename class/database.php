<?php
// clase que administra la conexion con la base de datos
class Database extends PDO
{
	private $host = 'localhost';
	private $base = 'farmacia';
	private $user = 'root';
	private $pass = '';
	private $charset = 'utf8';

	public function __construct(){
        parent::__construct(
                'mysql:host=' . $this->host . ';dbname=' . $this->base,
                $this->user,
                $this->pass,
                array(
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES ' . $this->charset
                ));
    }
}