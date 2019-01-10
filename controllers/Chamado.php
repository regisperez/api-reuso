<?php
namespace controllers{
	/*
	Classe chamado
	*/
	class Chamado extends Pdo{
		
		/*
		lista
		Listando chamados
		*/
		public function lista(){
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM sedecchamados");
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}

		//lista de áreas de risco conforme parâmetros
		public function areasDeRisco($latitude,$longitude,$raio){
			global $app;
			$sth = $this->PDO->prepare("SELECT *,(6371 * 
							acos(
							cos(radians(:latitude)) * 
							cos(radians(latitude)) * 
							cos(radians(:longitude) - radians(longitude)) + 
							sin(radians(:latitude)) * 
							sin(radians(latitude))
								)) AS raio
			FROM sedecchamados HAVING raio <= :raio");
			$sth ->bindValue(':latitude',$latitude);
			$sth ->bindValue(':longitude',$longitude);
			$sth ->bindValue(':raio',$raio);
			$sth->execute();
			$result = $sth->fetchAll(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}
		
		/*
		get
		param $id
		Pega chamado pelo id
		*/
		public function get($id){
			global $app;
			$sth = $this->PDO->prepare("SELECT * FROM sedecchamados WHERE _id = :id");
			$sth ->bindValue(':id',$id);
			$sth->execute();
			$result = $sth->fetch(\PDO::FETCH_ASSOC);
			$app->render('default.php',["data"=>$result],200); 
		}

		/*
		nova
		Cadastra chamado
		*/
		public function nova(){
			global $app;
			$dados = json_decode($app->request->getBody(), true);
			$dados = (sizeof($dados)==0)? $_POST : $dados;
			$keys = array_keys($dados); //Paga as chaves do array
			/*
			O uso de prepare e bindValue é importante para se evitar SQL Injection
			*/
			$sth = $this->PDO->prepare("INSERT INTO sedecchamados (".implode(',', $keys).") VALUES (:".implode(",:", $keys).")");
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
		Editando chamado
		*/
		public function editar($id){
			global $app;
			$dados = json_decode($app->request->getBody(), true);
			$dados = (sizeof($dados)==0)? $_POST : $dados;
			$sets = [];
			foreach ($dados as $key => $VALUES) {
				$sets[] = $key." = :".$key;
			}

			$sth = $this->PDO->prepare("UPDATE sedecchamados SET ".implode(',', $sets)." WHERE _id = :id");
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
		Excluindo chamado
		*/
		public function excluir($id){
			global $app;
			$sth = $this->PDO->prepare("DELETE FROM sedecchamados WHERE _id = :id");
			$sth ->bindValue(':id',$id);
			$app->render('default.php',["data"=>['status'=>$sth->execute()==1]],200); 
		}
	}
}