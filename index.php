<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

session_start();

require('vendor/smarty/smarty/libs/Smarty.class.php');
require('vendor/autoload.php');
require('app/controllers/route.php');
require('db.php');
require_once('app/controllers/functions.php');

$smarty = new Smarty();

$smarty->setTemplateDir('app/views/');
