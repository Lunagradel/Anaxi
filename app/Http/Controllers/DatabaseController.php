<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MongoDB\Client as MongoClient;
use MongoDB\Collection as Collection;

class DatabaseController extends Controller
{
	public function index() {
		$client = new MongoClient( 'mongodb://admin:anaxiParty@anaxidev-shard-00-00-q9sz0.mongodb.net:27017,anaxidev-shard-00-01-q9sz0.mongodb.net:27017,anaxidev-shard-00-02-q9sz0.mongodb.net:27017/users?ssl=true&replicaSet=AnaxiDev-shard-0&authSource=admin');

		$db = $client->Anaxi;
		$collection = $db->users;
//		return $collection->find()->toArray();
//		$db = $client->users;


//		$db = $client->createCollection("users");
//		$db->createCollection("users");

		$collection->insertOne([
			'firstName' => 'Johannes',
			'lastName' => 'Sved',
			'age' => 100
		]);

		return $collection->find()->toArray();

	}
}
