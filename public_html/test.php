<?php
require '../bootloader.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$connection = new \Core\Database\Connection (
        $credentials = [
            'host'=>'localhost',
            'user'=>'root',
            'pass'=>'sindar5150'
        ]
        );

$pdo = $connection->getPDO();
$pdo->exec('CREATE TABLE `my_db`.`cocksuckers`(`her_name` VARCHAR(255) NOT NULL)');