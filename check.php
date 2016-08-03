<?php
require_once 'config.php';

use Erpk\Harvester\Module\Citizen\CitizenModule;

$module = new CitizenModule($client);

if (isset($_POST['submit'])) {
    try {
        $citizen = $module->getProfile($_POST['id']);
        if ($citizen['ban'] || !$citizen['alive']) {
            $_SESSION['error'] = 'dead';
            header("Location: index.php");
        }
        if ($citizen['party']['id'] != $fedsID) {
            $_SESSION['error'] = 'fed';
            header("Location: index.php");
        }
        $_SESSION['citizen'] = $_POST['id'];
        header("Location: voting.php");
    } catch (Exception $e) {
        $_SESSION['error'] = 'cit';
        header("Location: index.php");
    }

} else {
    header("Location: index.php");
}