<?php declare(strict_types=1);

namespace Acme\ColorApi\Controller\Action;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface ActionInterface
{
    public function handleRequest(ServerRequestInterface $request): ResponseInterface;
}
