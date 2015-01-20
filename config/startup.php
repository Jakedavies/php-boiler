<?php
require_once __DIR__ ."/../vendor/autoload.php";
require_once __DIR__ ."/../lib/Renderer.php";
require_once __DIR__ . '/../protected/controllers/LanderController.php';

use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;
$serviceContainer = Propel::getServiceContainer();
$serviceContainer->setAdapterClass('hydradb', 'mysql');
$manager = new ConnectionManagerSingle();
$manager->setConfiguration(array(
    'dsn'      => 'mysql:host=127.0.0.1;dbname=hydradb;port=3306',
    'user'     => 'hydrauth',
    'password' => 'hydr@',
));
$serviceContainer->setConnectionManager('hydradb', $manager);

use Monolog\Logger;
use Monolog\Handler\StreamHandler;
$logger = new Logger('defaultLogger');
$logger->pushHandler(new StreamHandler('php://stderr'));
Propel::getServiceContainer()->setLogger('defaultLogger', $logger);