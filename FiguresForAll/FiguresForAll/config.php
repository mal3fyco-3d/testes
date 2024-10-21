<?php
/* Descrição: Configurações da aplicação
 * Autor: Mário Pinto
 * 
 */
$guru='14';
$dsg_dbo = [
    'host' => 'mysql-sa.mgmt.ua.pt',
    'port' => '3306',
    'charset' => 'utf8',    
    'dbname' => 'esan-dsg'.$guru,
    'username' => 'esan-dsg'.$guru.'-dbo',
    'password' => 'MptGFhRPotCcCKbk'
];
$dsg_web = [
    'host' => 'mysql-sa.mgmt.ua.pt',
    'port' => '3306',
    'charset' => 'utf8',
    'dbname' => 'esan-dsg'.$guru,
    'username' => 'esan-dsg'.$guru.'-web',
    'password' => 'hxS72nG9iwi5Q3nB'
];


// Descomentar o utilizador pretendido: DBO ou WEB
$db = $dsg_dbo;
#$db = $dsg_web;

define('DEBUG', true);

if (DEBUG) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
}

// Autor
define('AUTHOR', 'Miguel Ferreira');
define('UC', 'PAW');
define('ANO_LETIVO', '2021.2022');


