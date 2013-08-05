<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

require_once "vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Sarasa\Core\Config;

$paths = array("app/");
$isDevMode = false;

$string = file_get_contents("config.json");
$settings = json_decode($string, true);

$dbParams = array(
        'driver'   => 'pdo_mysql',
        'user'     => $settings['dbuser'],
        'password' => $settings['dbpass'],
        'dbname'   => $settings['dbname'],
    );
    
$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
$entityManager = EntityManager::create($dbParams, $config);

$helperSet = new \Symfony\Component\Console\Helper\HelperSet(
    array(
        'em' => new \Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($entityManager)
    )
);
