<?php

namespace App\Logging;

use Monolog\Logger;
use MongoDB\Client as MongoClient;
use Monolog\Handler\MongoDBHandler;

class CreateMongoLogger
{
    public function __invoke(array $config)
    {
        $client = new MongoClient(env('MONGODB_URI'));

        return new Logger('mongodb', [
            new MongoDBHandler(
                $client, // Truyền client
                env('DB_MONGO_DATABASE'), // Tên database
                'logs' // Tên collection
            )
        ]);
    }
}
