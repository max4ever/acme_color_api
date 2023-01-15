<?php declare(strict_types=1);

namespace Acme\ColorApi\Framework;

use Acme\ColorApi\Controller\Action\ActionInterface;
use Acme\ColorApi\Controller\Action\CrudEndpointInterface;
use Acme\ColorApi\Framework\Database\DbConnectionInterface;
use Acme\ColorApi\Repository\ColorRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use const Sunrise\Http\Message\PHRASES;

class Kernel
{
    private Router $router;
    private DbConnectionInterface $dbConnection;

    public function __construct(DbConnectionInterface $dbConnection, Router $router)
    {
        $this->router = $router;
        $this->dbConnection = $dbConnection;
    }

    /**
     * @throws RouteNotFoundException
     */
    public function handleRequest(ServerRequestInterface $request): ResponseInterface{
        $actionClass = $this->router->matchPath($request);
        if(empty($actionClass)){
            throw new RouteNotFoundException($request->getUri()->getPath());
        }

        $actionHandler = (new $actionClass(new ColorRepository($this->dbConnection->getInstance())));
        assert($actionHandler instanceof ActionInterface);

        return $actionHandler->handleRequest($request);
    }

    public function sendResponse(ResponseInterface $response): void
    {
        foreach($response->getHeaders() as $name => $values) {
            header($name . ': ' . implode(', ', $values));
        }

        http_response_code($response->getStatusCode());
        header('HTTP/' . $response->getProtocolVersion().' ' . $response->getStatusCode() . ' ' . PHRASES[$response->getStatusCode()], true, $response->getStatusCode());

        echo $response->getBody();
    }

    public function registerEndpoints(CrudEndpointInterface $crudEndpoint): self
    {
        $crudEndpoint->addHandledRoutes($this->router);

        return $this;
    }
}
