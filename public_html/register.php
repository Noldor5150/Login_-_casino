<?php

require_once '../bootloader.php';

$db = new \Core\FileDB(DB_FILE);
$repository = new \Core\User\Repository($db, TABLE_USERS);
