<?php declare(strict_types=1);

use Acme\ColorApi\Controller\Action\ColorEndpoint;
use Acme\ColorApi\Framework\Config\IniConfigLoader;
use Acme\ColorApi\Framework\Database\MysqlConnection;
use Acme\ColorApi\Framework\Database\MysqlDbConfig;
use Acme\ColorApi\Framework\ErrorHandler;
use Acme\ColorApi\Framework\Kernel;
use Acme\ColorApi\Framework\Router;
use Sunrise\Http\ServerRequest\ServerRequestFactory;

require_once __DIR__ . '/../vendor/autoload.php';
ErrorHandler::registerHandlers();

$request = ServerRequestFactory::fromGlobals();

$iniConfig = new IniConfigLoader(__DIR__.'/../config/db.ini');
$mysqlDbConfig = new MysqlDbConfig($iniConfig);

$kernel = new Kernel(new MysqlConnection($mysqlDbConfig), new Router());
$kernel->registerEndpoints(new ColorEndpoint());

$response = $kernel->handleRequest($request);
$kernel->sendResponse($response);
