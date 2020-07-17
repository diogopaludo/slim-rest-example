<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$this->post('/auth', function (Request $request, Response $response) {
	$params = $request->getParsedBody();
	$email = filter_var($params['email'], FILTER_VALIDATE_EMAIL);
	$password = $params['password'];
	if (empty($email)) {
		return $response->withJson(['status' => 'invalid_email']);
	}
	if (empty($password)) {
		return $response->withJson(['status' => 'invalid_password']);
	}
	$stm = $this->db->prepare('SELECT id, password FROM usuarios WHERE email=:email limit 1');
	$stm->execute(['email' => $email]);
	if ($stm->rowCount() == 0) {
		return $response->withJson(['status' => 'invalid_email']);
	}
	$res = $stm->fetchObject();
	if (crypt($password, $res->password) != $res->password) {
		return $response->withJson(['status' => 'invalid_password']);
	}
	$_SESSION['user'] = $res->id;
	return $response->withJson(['status' => true, 'token' => session_id()]);
});

$this->get('/auth', function (Request $request, Response $response) {
	return $response->withJson(['auth' => !empty($_SESSION['user'])]);
});

$this->delete('/auth', function (Request $request, Response $response) {
	unset($_SESSION['user']);
	return $response->withJson(['status' => true]);
});
