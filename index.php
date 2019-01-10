<?php
//Autoload
$loader = require 'vendor/autoload.php';

//Instanciando objeto
$app = new \Slim\Slim(array(
    'templates.path' => 'templates'
));

$app->get('/', function(){
	echo "Api rodando";
});

//Listando todos
$app->get('/pessoas/', function() use ($app){
	(new \controllers\Pessoa($app))->lista();
});

$app->get('/chamados/', function() use ($app){
	(new \controllers\Chamado($app))->lista();
});

$app->get('/lonas/', function() use ($app){
	(new \controllers\Lona($app))->lista();
});

$app->get('/solicitacoes/', function() use ($app){
	(new \controllers\Solicitacao($app))->lista();
});

$app->get('/tipoocorrencias/', function() use ($app){
	(new \controllers\TipoOcorrencia($app))->lista();
});

$app->get('/vistorias/', function() use ($app){
	(new \controllers\Vistoria($app))->lista();
});

//get por id
$app->get('/pessoas/:id', function($id) use ($app){
	(new \controllers\Pessoa($app))->get($id);
});

$app->get('/chamados/:id', function($id) use ($app){
	(new \controllers\Chamado($app))->get($id);
});

$app->get('/lonas/:id', function($id) use ($app){
	(new \controllers\Lona($app))->get($id);
});

$app->get('/solicitacoes/:id', function($id) use ($app){
	(new \controllers\Solicitacao($app))->get($id);
});

$app->get('/tipoocorrencias/:id', function($id) use ($app){
	(new \controllers\TipoOcorrencia($app))->get($id);
});

$app->get('/vistorias/:id', function($id) use ($app){
	(new \controllers\Vistoria($app))->get($id);
});

//adicionar
$app->post('/pessoas/', function() use ($app){
	(new \controllers\Pessoa($app))->nova();
});

$app->post('/chamados/', function() use ($app){
	(new \controllers\Chamado($app))->nova();
});

$app->post('/lonas/', function() use ($app){
	(new \controllers\Lona($app))->nova();
});

$app->post('/solicitacoes/', function() use ($app){
	(new \controllers\Solicitacao($app))->nova();
});

$app->post('/tipoocorrencias/', function() use ($app){
	(new \controllers\TipoOcorrencia($app))->nova();
});

$app->post('/vistorias/', function() use ($app){
	(new \controllers\Vistoria($app))->nova();
});


//editar
$app->put('/pessoas/:id', function($id) use ($app){
	(new \controllers\Pessoa($app))->editar($id);
});

$app->put('/chamados/:id', function($id) use ($app){
	(new \controllers\Chamado($app))->editar($id);
});

$app->put('/lonas/:id', function($id) use ($app){
	(new \controllers\Lona($app))->editar($id);
});

$app->put('/solicitacoes/:id', function($id) use ($app){
	(new \controllers\Solicitacao($app))->editar($id);
});

$app->put('/tipoocorrencias/:id', function($id) use ($app){
	(new \controllers\TipoOcorrencia($app))->editar($id);
});

$app->put('/vistorias/:id', function($id) use ($app){
	(new \controllers\Vistoria($app))->editar($id);
});

//apagar
$app->delete('/pessoas/:id', function($id) use ($app){
	(new \controllers\Pessoa($app))->excluir($id);
});

$app->delete('/chamados/:id', function($id) use ($app){
	(new \controllers\Chamado($app))->excluir($id);
});

$app->delete('/lonas/:id', function($id) use ($app){
	(new \controllers\Lona($app))->excluir($id);
});

$app->delete('/solicitacoes/:id', function($id) use ($app){
	(new \controllers\Solicitacao($app))->excluir($id);
});

$app->delete('/tipoocorrencias/:id', function($id) use ($app){
	(new \controllers\TipoOcorrencia($app))->excluir($id);
});

$app->delete('/vistorias/:id', function($id) use ($app){
	(new \controllers\Vistoria($app))->excluir($id);
});

//listar áreas de risco
$app->get('/chamados/:latitude/:longitude/:raio', function($latitude,$longitude,$raio) use ($app){
	(new \controllers\Chamado($app))->areasDeRisco($latitude,$longitude,$raio);
});

//Rodando aplicação
$app->run();
