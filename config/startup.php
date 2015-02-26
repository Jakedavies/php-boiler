<?php
require_once __DIR__ ."/../vendor/autoload.php";
require_once __DIR__ ."/../lib/renderer/Renderer.php";
require_once __DIR__ . '/../app/controllers/BaseController.php';
require_once __DIR__ . '/../app/controllers/LanderController.php';
require_once __DIR__ . '/../app/controllers/UserController.php';
require_once __DIR__ . '/../app/controllers/CharityController.php';
use Propel\Runtime\Propel;
use Propel\Runtime\Connection\ConnectionManagerSingle;
$serviceContainer = Propel::getServiceContainer();
$serviceContainer->setAdapterClass('defaultdb', 'mysql');
$manager = new ConnectionManagerSingle();
$manager->setConfiguration(array(
    'dsn'      => 'mysql:host=127.0.0.1;dbname=donationdb;port=3306',
    'user'     => 'donation-auth',
    'password' => 'password',
));
$serviceContainer->setConnectionManager('defaultdb', $manager);
