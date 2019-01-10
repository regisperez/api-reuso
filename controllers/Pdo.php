<?php
namespace controllers{
	/*
	Classe chamado
	*/
	class Pdo{
		//Atributo para banco de dados
		public $PDO;

		/*
		__construct
		Conectando ao banco de dados
		*/
		function __construct(){
			$this->PDO = new \PDO('mysql:host=localhost;dbname=api', 'root', '1234'); //Conexão
			$this->PDO->setAttribute( \PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION ); //habilitando erros do PDO
		}
		
	}
}