<?php
namespace DatabaseConnection;

/**
 * Created by PhpStorm.
 * User: Johannes
 * Date: 12/12/2017
 * Time: 09.13
 */

use MongoDB\Client as MongoClient;

class DatabaseConnection {
	static $DatabaseConnection = NULL;
	static $DatabasePassword;

	public function __construct() {
		self::$DatabasePassword = $_ENV['DB_PASSWORD'];
	}

	static function GetMongoInstance()
	{
		if (self::$DatabaseConnection === null)
		{
			try {
				$Connection = new MongoClient(
					'mongodb://admin:'.self::$DatabasePassword.'@anaxidev-shard-00-00-q9sz0.mongodb.net:27017,anaxidev-shard-00-01-q9sz0.mongodb.net:27017,anaxidev-shard-00-02-q9sz0.mongodb.net:27017/users?ssl=true&replicaSet=AnaxiDev-shard-0&authSource=admin'
				);
				$Database = $Connection->Anaxi;
				$Collection = $Database->users;
			} catch (MongoConnectionException $e) {
				die('Failed to connect to MongoDB '.$e->getMessage());
			}
			self::$DatabaseConnection = $Collection;
		}
		return self::$DatabaseConnection;
	}
}