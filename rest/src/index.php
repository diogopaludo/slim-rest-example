<?php

require __DIR__ . '/../vendor/autoload.php';

$settings = require __DIR__ . '/config.php';
$app = new \Slim\App($settings);

$container = $app->getContainer();
$container['upload_directory'] = __DIR__ . '/uploads';
$container['db'] = function ($c) {
	$db = $c['settings']['db'];
	$pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'], $db['user'], $db['pass']);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	$pdo->exec('set names utf8');
	return $pdo;
};

$app->add(function ($req, $res, $next) {
	$tk = $req->getHeader('X-Token');
	if (!empty($tk[0])) {
		session_id($tk[0]);
	}
	session_start(['use_cookies' => 0]);
	return $next($req, $res);
});

$app->group('/rest', function () {
	require __DIR__ . '/user.php';
	require __DIR__ . '/auth.php';
	require __DIR__ . '/dados.php';
	require __DIR__ . '/modelo.php';
	require __DIR__ . '/variavel.php';
	require __DIR__ . '/tipo-variavel.php';
	require __DIR__ . '/modelo-variavel.php';
	require __DIR__ . '/transformacao.php';
	require __DIR__ . '/label.php';
	require __DIR__ . '/durbin-watson.php';
	require __DIR__ . '/relatorio.php';
	require __DIR__ . '/avaliacao.php';
	require __DIR__ . '/upload.php';
});

$app->options('/{routes:.+}', function ($request, $response, $args) {
	return $response;
});

$app->add(function ($req, $res, $next) {
	$response = $next($req, $res);
	return $response->withHeader('Access-Control-Allow-Origin', '*')->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, X-Token')->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$app->run();
