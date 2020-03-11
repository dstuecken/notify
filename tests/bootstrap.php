<?php

$baseDir = dirname(__DIR__);

$loader = require __DIR__.'/../vendor/autoload.php';
$loader->add('NotifyTest\\', array($baseDir.'/tests/Notify/'));
$loader->register();
