<?php

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$this->get('/valuation/{id:[0-9]+}', function (Request $request, Response $response) {
	/*
	if (empty($_SESSION['user'])) {
		return $response->withJson([]);
	}
	$id = (int)$request->getAttribute('id');
	$stm = $this->db->query("SELECT `id`, `title`, `created_at`, `type`, `client`, `adress`, `value`, `city`, `valuated_at`, `professional`, `profession`, `register`, `land_front`, `land_side`, `land_area`, `house_area`, `house_type`, `standard`, `masonry`, `openings`, `ceiling`, `roof`, `facilities`, `access`, `infrastructure`, `appreciation`, `market`, `research`, `cub`, `bdi`, `fc`, `cd` FROM `valuations` WHERE id = '$id' AND `user_id` = '{$_SESSION['user']}'");
	$res = $stm->fetchObject();
	if (!is_object($res)) {
		return $response->withJson([]);
	}
	$res->researches = [];
	$stm = $this->db->query("SELECT `date`, `location`, `source`, `value`, `area` FROM `valuations_researches` WHERE `valuation_id` = '{$res->id}' ORDER BY `id`");
	while ($aux = $stm->fetchObject()) {
		$res->researches[] = $aux;
	}
	$stm = $this->db->query("SELECT `living_room`, `kitchen`, `bedroom`, `bathroom`, `service_area`, `balcony`, `barbecue_grill`, `garage`, `deposit`, `parking_lot`, `hall`, `locker_room`, `covered_space`, `others` FROM `valuations_compositions` WHERE `valuation_id` = '{$res->id}'");
	$res->compositions = $stm->fetchObject();
	if (!is_object($res->compositions)) {
		$res->compositions = [];
	}
	*/
	return $response->withJson($res);
});

$this->get('/valuation', function (Request $request, Response $response) {
	/*
	if (empty($_SESSION['user'])) {
		return $response->withJson([]);
	}
	$stm = $this->db->query("SELECT `id`, `title`, `created_at`, `type`, `client`, `adress`, `value`, `city`, `valuated_at`, `professional`, `profession`, `register`, `land_front`, `land_side`, `land_area`, `house_area`, `house_type`, `standard`, `masonry`, `openings`, `ceiling`, `roof`, `facilities`, `access`, `infrastructure`, `appreciation`, `market`, `research`, `cub`, `bdi`, `fc`, `cd` FROM `valuations` WHERE `user_id` = '{$_SESSION['user']}'");
	$data = [];
	while ($res = $stm->fetchObject()) {
		$res->researches = [];
		$stm_researches = $this->db->query("SELECT `date`, `location`, `source`, `value`, `area` FROM `valuations_researches` WHERE `valuation_id` = '{$res->id}' ORDER BY `id`");
		while ($aux = $stm_researches->fetchObject()) {
			$res->researches[] = $aux;
		}
		$res->compositions = [];
		$stm_compositions = $this->db->query("SELECT `living_room`, `kitchen`, `bedroom`, `bathroom`, `service_area`, `balcony`, `barbecue_grill`, `garage`, `deposit`, `parking_lot`, `hall`, `locker_room`, `covered_space`, `others` FROM `valuations_compositions` WHERE `valuation_id` = '{$res->id}'");
		while ($aux = $stm_compositions->fetchObject()) {
			$res->compositions = $aux;
		}
		$data[] = $res;
	}
	*/
	return $response->withJson($data);
});

$this->post('/valuation', function (Request $request, Response $response) {
	/*
	if (empty($_SESSION['user'])) {
		return $response->withJson([]);
	}
	$params = $request->getParsedBody();
	$valuation_data = [
		'user_id' => $_SESSION['user'],
		'title' => $params['title'] ?: null,
		'created_at' => $params['created_at'] ?: date('Y-m-d H:i:s'),
		'type' => $params['type'] ?: null,
		'client' => $params['client'] ?: null,
		'adress' => $params['adress'] ?: null,
		'value' => is_null($params['value']) ? null : $params['value'],
		'city' => $params['city'] ?: null,
		'valuated_at' => $params['valuated_at'] ?: null,
		'professional' => $params['professional'] ?: null,
		'profession' => $params['profession'] ?: null,
		'register' => $params['register'] ?: null,
		'land_front' => is_null($params['land_front']) ? null : $params['land_front'],
		'land_side' => is_null($params['land_side']) ? null : $params['land_side'],
		'land_area' => is_null($params['land_area']) ? null : $params['land_area'],
		'house_area' => is_null($params['house_area']) ? null : $params['house_area'],
		'house_type' => $params['house_type'] ?: null,
		'standard' => $params['standard'] ?: null,
		'masonry' => $params['masonry'] ?: null,
		'openings' => $params['openings'] ?: null,
		'ceiling' => $params['ceiling'] ?: null,
		'roof' => $params['roof'] ?: null,
		'facilities' => $params['facilities'] ?: null,
		'access' => $params['access'] ?: null,
		'infrastructure' => $params['infrastructure'] ?: null,
		'appreciation' => $params['appreciation'] ?: null,
		'market' => $params['market'] ?: null,
		'research' => $params['research'] ?: null,
		'cub' => is_null($params['cub']) ? null : $params['cub'],
		'bdi' => is_null($params['bdi']) ? null : $params['bdi'],
		'fc' => is_null($params['fc']) ? null : $params['fc'],
		'cd' => is_null($params['cd']) ? null : $params['cd']
	];

	$stm = $this->db->prepare('INSERT INTO `valuations`(`user_id`, `title`, `created_at`, `type`, `client`, `adress`, `value`, `city`, `valuated_at`, `professional`, `profession`, `register`, `land_front`, `land_side`, `land_area`, `house_area`, `house_type`, `standard`, `masonry`, `openings`, `ceiling`, `roof`, `facilities`, `access`, `infrastructure`, `appreciation`, `market`, `research`, `cub`, `bdi`, `fc`, `cd`) VALUES (:user_id, :title, :created_at, :type, :client, :adress, :value, :city, :valuated_at, :professional, :profession, :register, :land_front, :land_side, :land_area, :house_area, :house_type, :standard, :masonry, :openings, :ceiling, :roof, :facilities, :access, :infrastructure, :appreciation, :market, :research, :cub, :bdi, :fc, :cd)');
	$stm->execute($valuation_data);
	$id = $this->db->lastInsertId();

	if (!($id > 0)) {
		return $response->withJson(['status' => 'error']);
	}
	foreach ($params['researches'] as $research) {
		$data = [
			'research_date' => $research['date'],
			'location' => $research['location'],
			'source' => $research['source'],
			'value' => $research['value'],
			'area' => $research['area']
		];
		$stm = $this->db->prepare(" INSERT INTO `valuations_researches` (`valuation_id`, `date`, `location`, `source`, `value`, `area`) VALUES ('$id', :research_date, :location, :source, :value, :area)");
		if ($stm->execute($data) === false) {
			return $response->withJson(['status' => 'error']);
		}
	}
	if ($params['composition']) {
		$data = [
			'living_room' => (int)$params['composition']['living_room'],
			'kitchen' => (int)$params['composition']['kitchen'],
			'bedroom' => (int)$params['composition']['bedroom'],
			'bathroom' => (int)$params['composition']['bathroom'],
			'service_area' => (int)$params['composition']['service_area'],
			'balcony' => (int)$params['composition']['balcony'],
			'barbecue_grill' => (int)$params['composition']['barbecue_grill'],
			'garage' => (int)$params['composition']['garage'],
			'deposit' => (int)$params['composition']['deposit'],
			'parking_lot' => (int)$params['composition']['parking_lot'],
			'hall' => (int)$params['composition']['hall'],
			'locker_room' => (int)$params['composition']['locker_room'],
			'covered_space' => (int)$params['composition']['covered_space'],
			'others' => $params['composition']['others'] ?: ''
		];
		$stm = $this->db->prepare(" INSERT INTO `valuations_compositions` (`valuation_id`, `living_room`, `kitchen`, `bedroom`, `bathroom`, `service_area`, `balcony`, `barbecue_grill`, `garage`, `deposit`, `parking_lot`, `hall`, `locker_room`, `covered_space`, `others`) VALUES ('$id', :living_room, :kitchen, :bedroom, :bathroom, :service_area, :balcony, :barbecue_grill, :garage, :deposit, :parking_lot, :hall, :locker_room, :covered_space, :others)");
		if ($stm->execute($data) === false) {
			return $response->withJson(['status' => 'error']);
		}
	}
	return $response->withJson(['status' => true, 'token' => $id]);
	*/
});

$this->put('/valuation/{id:[0-9]+}', function (Request $request, Response $response) {
	/*
	try {
		$id = (int)$request->getAttribute('id');
		if (!($id > 0)) {
			return $response->withJson(['status' => 'error']);
		}
		$params = $request->getParsedBody();
		$valuation_data = [
			'id' => (int)$request->getAttribute('id'),
			'user_id' => $_SESSION['user'],
			'title' => $params['title'] ?: null,
			'created_at' => $params['created_at'] ?: date('Y-m-d H:i:s'),
			'type' => $params['type'] ?: null,
			'client' => $params['client'] ?: null,
			'adress' => $params['adress'] ?: null,
			'value' => is_null($params['value']) ? null : $params['value'],
			'city' => $params['city'] ?: null,
			'valuated_at' => $params['valuated_at'] ?: null,
			'professional' => $params['professional'] ?: null,
			'profession' => $params['profession'] ?: null,
			'register' => $params['register'] ?: null,
			'land_front' => is_null($params['land_front']) ? null : $params['land_front'],
			'land_side' => is_null($params['land_side']) ? null : $params['land_side'],
			'land_area' => is_null($params['land_area']) ? null : $params['land_area'],
			'house_area' => is_null($params['house_area']) ? null : $params['house_area'],
			'house_type' => $params['house_type'] ?: null,
			'standard' => $params['standard'] ?: null,
			'masonry' => $params['masonry'] ?: null,
			'openings' => $params['openings'] ?: null,
			'ceiling' => $params['ceiling'] ?: null,
			'roof' => $params['roof'] ?: null,
			'facilities' => $params['facilities'] ?: null,
			'access' => $params['access'] ?: null,
			'infrastructure' => $params['infrastructure'] ?: null,
			'appreciation' => $params['appreciation'] ?: null,
			'market' => $params['market'] ?: null,
			'research' => $params['research'] ?: null,
			'cub' => is_null($params['cub']) ? null : $params['cub'],
			'bdi' => is_null($params['bdi']) ? null : $params['bdi'],
			'fc' => is_null($params['fc']) ? null : $params['fc'],
			'cd' => is_null($params['cd']) ? null : $params['cd']
		];
		$stm = $this->db->prepare('UPDATE `valuations` SET `title`=:title, `created_at`=:created_at, `type`=:type, `client`=:client, `adress`=:adress, `value`=:value, `city`=:city, `valuated_at`=:valuated_at, `professional`=:professional, `profession`=:profession, `register`=:register, `land_front`=:land_front, `land_side`=:land_side, `land_area`=:land_area, `house_area`=:house_area, `house_type`=:house_type, `standard`=:standard, `masonry`=:masonry, `openings`=:openings, `ceiling`=:ceiling, `roof`=:roof, `facilities`=:facilities, `access`=:access, `infrastructure`=:infrastructure, `appreciation`=:appreciation, `market`=:market, `research`=:research, `cub`=:cub, `bdi`=:bdi, `fc`=:fc, `cd`=:cd WHERE id=:id AND user_id=:user_id');
		if ($stm->execute($valuation_data) === false) {
			return $response->withJson(['status' => 'error']);
		}
		if (count($params['researches'])) {
			$id = (int)$request->getAttribute('id');
			$data = [
				'id' => $id
			];
			$stm = $this->db->prepare('DELETE FROM `valuations_researches` WHERE `valuation_id` = :id');
			if ($stm->execute($data) === false) {
				return $response->withJson(['status' => 'error']);
			}
		}
		foreach ($params['researches'] as $research) {
			$data = [
				'research_date' => $research['date'],
				'location' => $research['location'],
				'source' => $research['source'],
				'value' => $research['value'],
				'area' => $research['area']
			];
			$stm = $this->db->prepare("INSERT INTO `valuations_researches` (`valuation_id`, `date`, `location`, `source`, `value`, `area`) VALUES ('$id', :research_date, :location, :source, :value, :area)");
			if ($stm->execute($data) === false) {
				return $response->withJson(['status' => 'error']);
			}
		}
		if (count($params['composition'])) {
			$id = (int)$request->getAttribute('id');
			$data = [
				'id' => $id
			];
			$stm = $this->db->prepare('DELETE FROM `valuations_compositions` WHERE `valuation_id` = :id');
			if ($stm->execute($data) === false) {
				return $response->withJson(['status' => 'error']);
			}
		}
		if ($params['composition']) {
			$data = [
				'living_room' => (int)$params['composition']['living_room'],
				'kitchen' => (int)$params['composition']['kitchen'],
				'bedroom' => (int)$params['composition']['bedroom'],
				'bathroom' => (int)$params['composition']['bathroom'],
				'service_area' => (int)$params['composition']['service_area'],
				'balcony' => (int)$params['composition']['balcony'],
				'barbecue_grill' => (int)$params['composition']['barbecue_grill'],
				'garage' => (int)$params['composition']['garage'],
				'deposit' => (int)$params['composition']['deposit'],
				'parking_lot' => (int)$params['composition']['parking_lot'],
				'hall' => (int)$params['composition']['hall'],
				'locker_room' => (int)$params['composition']['locker_room'],
				'covered_space' => (int)$params['composition']['covered_space'],
				'others' => $params['composition']['others'] ?: ''
			  ];
			$stm = $this->db->prepare(" INSERT INTO `valuations_compositions` (`valuation_id`, `living_room`, `kitchen`, `bedroom`, `bathroom`, `service_area`, `balcony`, `barbecue_grill`, `garage`, `deposit`, `parking_lot`, `hall`, `locker_room`, `covered_space`, `others`) VALUES ('$id', :living_room, :kitchen, :bedroom, :bathroom, :service_area, :balcony, :barbecue_grill, :garage, :deposit, :parking_lot, :hall, :locker_room, :covered_space, :others)");
			if ($stm->execute($data) === false) {
				return $response->withJson(['status' => 'error']);
			}
		}
		return $response->withJson(['status' => true]);
	} catch (Exception $e) {
		return $response->withJson(['status' => 'error']);
	}
	*/
});

$this->delete('/valuation/{id:[0-9]+}', function (Request $request, Response $response) {
	/*
	if (empty($_SESSION['user'])) {
		return $response->withJson([]);
	}
	$id = (int)$request->getAttribute('id');
	$data = [
		'id' => $id
	];
	try {
		$stm = $this->db->prepare('DELETE FROM `valuations_researches` WHERE `valuation_id` = :id');
		if ($stm->execute($data) === false) {
			return $response->withJson(['status' => 'error']);
		}
		$stm = $this->db->prepare('DELETE FROM `valuations_compositions` WHERE `valuation_id` = :id');
		if ($stm->execute($data) === false) {
			return $response->withJson(['status' => 'error']);
		}
		$stm = $this->db->prepare('DELETE FROM `valuations` WHERE id=:id');
		if ($stm->execute($data) === false) {
			return $response->withJson(['status' => 'error']);
		}
	} catch (Exception $e) {
		return $response->withJson(['status' => 'error']);
	}
	return $response->withJson(['status' => true]);
	*/
});
