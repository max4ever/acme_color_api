<?php declare(strict_types=1);

namespace Acme\ColorApi\Controller\Action\Color;

use Acme\ColorApi\Controller\Action\AbstractCrudAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sunrise\Http\Message\Response;

class PutColorAction extends AbstractCrudAction
{

    public function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        return new Response();
    }
}
