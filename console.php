<?php
require __DIR__.'/vendor/autoload.php';

ini_set('memory_limit', '512M');

use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new Commands\UploadXml());
$application->run();