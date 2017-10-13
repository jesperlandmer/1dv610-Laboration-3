<?php

session_start();

ob_start();

// ACTIVATE ERROR SHOWING
error_reporting(E_ALL);
ini_set('display_errors', 'On');

// SET TIME ZONE
date_default_timezone_set('Europe/Stockholm');

require_once('controller/MasterController.php');

try {

    $masterController = new \controller\MasterController();
    $masterController->showPage();
} catch(AssertionError $assertError) {

    echo $assertError->getMessage();
} catch(Exception $error) {

    echo $error->getMessage();
} catch (PDOException $PDOError) {

    echo $PDOError->getMessage(); 
}

session_unset();

ob_end_flush();