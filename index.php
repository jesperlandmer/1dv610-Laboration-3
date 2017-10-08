<?php

session_start();

//Activate error showing
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once('model/User.php');
require_once('view/LayoutView.php');

$layOutView = new \view\LayoutView();
$layOutView->render(false);

