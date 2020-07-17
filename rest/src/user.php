<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$this->get('/user', function (Request $request, Response $response) {
	/*
	if (empty($_SESSION['user'])) {
		return $response->withJson([]);
	}
	$stm = $this->db->query('SELECT * FROM user');
	$users = [];
	while ($res = $stm->fetchObject()) {
		$users[] = $res;
	}
	return $response->withJson($users);
	*/
});

$this->get('/user/{id:[0-9]+}', function (Request $request, Response $response) {
	/*
	if (empty($_SESSION['user'])) {
		return $response->withJson([]);
	}
	$params = $request->getParsedBody();
	$id = (int)$request->getAttribute('id');
	$stm = $this->db->query('SELECT * FROM user WHERE id=' . $id);
	$res = $stm->fetchObject();

	if (!is_object($res)) {
		return $response->withJson([]);
	}

	return $response->withJson($res);
	*/
});

$this->put('/user/{id:[0-9]+}', function (Request $request, Response $response) {
	/*
	if (empty($_SESSION['user'])) {
		return $response->withJson(['status' => 'error']);
	}
	$params = $request->getParsedBody();
	$id = (int)$request->getAttribute('id');
	$name = $params['name'];
	$email = filter_var($params['email'], FILTER_VALIDATE_EMAIL);
	$password = $params['password'] ?: null;

	if (empty($email) and !empty($params['email'])) {
		return $response->withJson(['status' => 'invalid_email']);
	}
	if (empty($email) or empty($name)) {
		return $response->withJson(['status' => 'empty_data']);
	}

	$stm = $this->db->prepare('SELECT 1 FROM user WHERE email=:email AND id <> :id LIMIT 1');
	$stm->execute(['id' => $id, 'email' => $email]);
	if ($stm->rowCount() > 0) {
		return $response->withJson(['status' => 'duplicated_email']);
	}

	$data = [
		'id' => $id,
		'name' => $name,
		'email' => $email
	];

	if (!empty($password)) {
		$data['password'] = crypt($password, sha1(rand()));
	}

	$stm = $this->db->prepare(
  	'	UPDATE user 
	  	SET
      		name=:name,
      		email=:email
      		' . (empty($password) ? '' : ',password=:password') . '
		WHERE id=:id
	');
	$st = $stm->execute($data);
	if ($st === false) {
		return $response->withJson(['status' => 'error']);
	}
	return $response->withJson(['status' => true]);
	*/
});

$this->post('/user', function (Request $request, Response $response) {
	/*
	if (empty($_SESSION['user'])) {
		return $response->withJson(['status' => 'error']);
	}
	$params = $request->getParsedBody();
	$name = $params['name'];
	$email = filter_var($params['email'], FILTER_VALIDATE_EMAIL);
	$password = $params['password'];

	if (empty($email) and !empty($params['email'])) {
		return $response->withJson(['status' => 'invalid_email']);
	}
	if (empty($email) or empty($name) or empty($password)) {
		return $response->withJson(['status' => 'empty_data']);
	}

	$stm = $this->db->prepare('SELECT 1 FROM user WHERE email=:email LIMIT 1');
	$stm->execute(['email' => $email]);
	if ($stm->rowCount() > 0) {
		return $response->withJson(['status' => 'duplicated_email']);
	}

	$data = [
		'name' => $name,
		'email' => $email,
		'password' => crypt($password, sha1(rand())),
		'image' => ''
	];

	$stm = $this->db->prepare('INSERT INTO user (name,email,password,image) VALUES (:name,:email,:password,:image)');
	$stm->execute($data);
	$id = $this->db->lastInsertId();
	if (!($id > 0)) {
		return $response->withJson(['status' => 'error']);
	}

	return $response->withJson(['status' => true, 'token' => $id]);
	*/
});

$this->delete('/user/{id:[0-9]+}', function (Request $request, Response $response) {
	/*
	if (empty($_SESSION['user'])) {
		return $response->withJson(['status' => 'error']);
	}

	$users = $this->db->exec('DELETE FROM user WHERE id=' . (int)$request->getAttribute('id'));
	if ($users == 0) {
		return $response->withJson(['status' => 'error']);
	}

	return $response->withJson(['status' => true]);
	*/
});

$this->post('/user', function (Request $request, Response $response) {
	/*
	try {
		$params = $request->getParsedBody();

		$email = filter_var($params['email'], FILTER_VALIDATE_EMAIL);
		$name = $params['name'];
		$password = $params['password'];

		if (empty($email) and !empty($params['email'])) {
			return $response->withJson(['status' => 'invalid_email']);
		}
		if (empty($email) or empty($name) or empty($password)) {
			return $response->withJson(['status' => 'empty_data']);
		}

		$stm = $this->db->prepare('SELECT 1 FROM user WHERE email=:email LIMIT 1');
		$stm->execute(['email' => $email]);

		if ($stm->rowCount() > 0) {
			return $response->withJson(['status' => 'duplicated_email']);
		}

		$stm = $this->db->prepare('INSERT INTO user (name,email,password,image) VALUES (:name,:email,:password,:image)');
		$stm->execute(['name' => $name, 'email' => $email, 'password' => crypt($password, sha1(rand())), 'image' => '']);

		$id = $this->db->lastInsertId();
		if (!($id > 0)) {
			return $response->withJson(['status' => 'error']);
		}

		$_SESSION['user'] = $id;

		return $response->withJson(['status' => true, 'token' => session_id()]);
	} catch (Exception $e) {
		return $response->withJson(['status' => 'error']);
	}
	*/
});

$this->get('/user', function (Request $request, Response $response) {
	/*
	if (empty($_SESSION['user'])) {
		return $response->withJson([]);
	}
	$stm = $this->db->query('SELECT id, name, email, image FROM user WHERE id=' . $_SESSION['user']);
	$res = $stm->fetchObject();
	return $response->withJson($res);
	*/
});

$this->put('/user', function (Request $request, Response $response) {
	/*
	if (empty($_SESSION['user'])) {
		return $response->withJson(['status' => 'error']);
	}
	$params = $request->getParsedBody();
	$name = $params['name'];
	$password = $params['password'];
	$imagem = $params['image'];
	if (empty($name)) {
		return $response->withJson(['status' => 'empty_data']);
	}
	$data = ['id' => $_SESSION['user'], 'name' => $name];
	$complement = '';
	if (!empty($password)) {
		$complement = ',password=:password';
		$data['password'] = crypt($password, sha1(rand()));
	}
	if (!empty($imagem)) {
		$complement .= ',image=:image';
		$data['image'] = $imagem;
	}
	$stm = $this->db->prepare('UPDATE user SET name=:name ' . $complement . ' where id=:id');
	$st = $stm->execute($data);
	if ($st === false) {
		return $response->withJson(['status' => 'error']);
	}

	return $response->withJson(['status' => true]);
	*/
});

$this->delete('/user', function (Request $request, Response $response) {
	/*
	if (empty($_SESSION['user'])) {
		return $response->withJson(['status' => 'error']);
	}
	$users = $this->db->exec('DELETE FROM user WHERE id=' . $_SESSION['user']);
	if ($users == 0) {
		return $response->withJson(['status' => 'error']);
	}
	unset($_SESSION['user']);
	return $response->withJson(['status' => true]);
	*/
});
