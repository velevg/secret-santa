<?php
error_reporting(E_ALL);
ini_set('display_errors', true);

session_start();

require('vendor/smarty/smarty/libs/Smarty.class.php');
require('vendor/autoload.php');
require('route.php');
require('db.php');

$smarty = new Smarty();

$smarty->setTemplateDir('views/');
$smarty->setCompileDir('compiled/');
$smarty->setCacheDir('cache/');
$smarty->setConfigDir('configs/');
