<?php
require_once 'config.php';

use Erpk\Harvester\Module\Citizen\CitizenModule;

if (!isset($_SESSION['citizen'])) {
    header("Location: index.php");
}

$module = new CitizenModule($client);

$query = $mysqli->query("SELECT * FROM elections WHERE start < CURRENT_TIMESTAMP  AND end > CURRENT_TIMESTAMP");
$election = $query->fetch_array();

$query = $mysqli->query("SELECT * FROM votes WHERE election = {$election['id']} AND erep_id = {$_SESSION['citizen']}");
if ($query->num_rows == 0) {
    $vote = false;
} else {
    $vote = $query->fetch_array();
}

//Types: 1 => CP Election, 2 => PP Election, 3 => Congress Election

