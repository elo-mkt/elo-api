<?php
/**
 * Created by IntelliJ IDEA.
 * User: smorales
 * Date: 08/03/18
 * Time: 14:38
 */

require_once 'test/Tester.php';
require_once 'test/VOFactory.php';
require_once __DIR__ . '/vendor/autoload.php';

spl_autoload_register(function ($class_name) {
	include $class_name . '.php';
});

$tester = new Tester();

//echo phpinfo();
echo $tester->test();