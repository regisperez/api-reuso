<?php
namespace controllers{
	/*
	Classe lona
	*/
	class Lona extends Pdo{
		
		/*
		lista
		Listando lonas
		*/
		public function lista(){
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM sedeclonas");
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}
		/*
		get
		param $id
		Pega lona pelo id
		*/
		public function get($id){
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM sedeclonas WHERE _id = :id");
			$sth ->bindValue(':id',$id);
			$sth->execute();
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}

		/*
		nova
		Cadastra lona
		*/
		public function nova(){
			global $app;
			$dados = json_decode($app->request->getBody(), true);
			$dados = (sizeof($dados)==0)? $_POST : $dados;
			$keys = array_keys($dados); //Paga as chaves do array
			/*
			O uso de prepare e bindValue é importante para se evitar SQL Injection
			*/
			$sth = $this->PDO->prepare("INSERT INTO sedeclonas (".implode(',', $keys).") VALUES (:".implode(",:", $keys).")");
			foreach ($dados as $key => $value) {
				$sth ->bindValue(':'.$key,$value);
			}
			$sth->execute();
			//Retorna o id inserido
			$app->render('default.php',["data"=>['_id'=>$this->PDO->lastInsertId()]],200); 
		}

		/*
		editar
		param $id
		Editando lona
		*/
		public function editar($id){
			global $app;
			$dados = json_decode($app->request->getBody(), true);
			$dados = (sizeof($dados)==0)? $_POST : $dados;
			$sets = [];
			foreach ($dados as $key => $VALUES) {
				$sets[] = $key." = :".$key;
			}

			$sth = $this->PDO->prepare("UPDATE sedeclonas SET ".implode(',', $sets)." WHERE _id = :id");
			$sth ->bindValue(':id',$id);
			foreach ($dados as $key => $value) {
				$sth ->bindValue(':'.$key,$value);
			}
			//Retorna status da edição
			$app->render('default.php',["data"=>['status'=>$sth->execute()==1]],200); 
		}

		/*
		excluir
		param $id
		Excluindo lona
		*/
		public function excluir($id){
			global $app;
			$sth = $this->PDO->prepare("DELETE FROM sedeclonas WHERE _id = :id");
			$sth ->bindValue(':id',$id);
			$app->render('default.php',["data"=>['status'=>$sth->execute()==1]],200); 
		}
	}
}