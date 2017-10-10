<?php

session_start();

// ACTIVATE ERROR SHOWING
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// SET TIME ZONE
date_default_timezone_set('Europe/Stockholm');

require_once('controller/MasterController.php');

$masterController = new \controller\MasterController();
$masterController->showPage();

session_unset();