<?php
require_once 'config.php';

use Erpk\Harvester\Module\Citizen\CitizenModule;

$module = new CitizenModule($client);

$citizen = $module->getProfile(5065893);
print_r($citizen);
echo "\r\n";
//if ($citizen['party']['id'] == $fedsID) echo 'A FED!!!!';