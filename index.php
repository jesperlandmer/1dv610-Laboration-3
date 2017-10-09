<?php

session_start();

// ACTIVATE ERROR SHOWING
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// SET TIME ZONE
date_default_timezone_set('Europe/Stockholm');

require_once('controller/Register.php');

require_once('view/LayoutView.php');

$layOutView = new \view\LayoutView(false);
$register = new \controller\Register();

$layOutView->render();