<?php

namespace Acme\ColorApi\Controller\Action;

use Acme\ColorApi\Framework\Router;

interface CrudEndpointInterface
{
    public function addHandledRoutes(Router $router): void;
}
