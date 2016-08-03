<?php
require __DIR__ . '/vendor/autoload.php';

use Erpk\Harvester\Client\ClientBuilder;

$builder = new ClientBuilder();
$builder->setEmail('keshaun@eotir.com');
$builder->setPassword('Dwayne12!');

$client = $builder->getClient();

$mysqli = new mysqli('localhost', 'root', 'dwayne12', 'feds');

$fedsID = 2263;