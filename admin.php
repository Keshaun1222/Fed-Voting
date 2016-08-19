<?php
require_once 'config.php';

if (isset($_SESSION['admin'])) {
    include_once 'actions.php';
} else {
    include_once 'login.php';
}