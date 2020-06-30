<?php
//llamada obligatoria a la clase database
require('database.php');

class Modelo
{
	protected $_db;

	public function __construct(){
		//creacion de instancia de la clase database
		$this->_db = new Database;
	}
}