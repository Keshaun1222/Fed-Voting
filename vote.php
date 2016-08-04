<?php
require_once 'config.php';

if (!isset($_SESSION['citizen'])) {
    header("Location: index.php");
}

$date = date("Y-m-d H:i:s");
$query = $mysqli->query("SELECT * FROM elections WHERE startTime < '$date' AND endTime > '$date'");

if ($query->num_rows == 0) {
    header("Location: index.php");
}

$election = $query->fetch_array();

$query = $mysqli->query("SELECT * FROM votes WHERE election = {$election['id']} AND erep_id = {$_SESSION['citizen']}");
if ($query->num_rows == 0) {
    $vote = false;
} else {
    $vote = $query->fetch_array();
}

$query = $mysqli->query("SELECT * FROM candidates WHERE election = {$election['id']} AND erep_id = {$_SESSION['citizen']}");
if ($query->num_rows > 0) {
    header("Location: voting.php");
}

if (!$vote)
    $sql = "INSERT INTO votes VALUES (NULL, {$_SESSION['citizen']}, {$election['id']}, {$_POST['vote']})";
else
    $sql = "UPDATE votes SET single = {$_POST['vote']} WHERE id = {$vote['id']}";

$do = $mysqli->query($sql);
if (!$do) {
    $_SESSION['success'] = 'no';
} else {
    $_SESSION['success'] = 'yes';
}
header("Location: voting.php");