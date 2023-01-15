<?php
declare(strict_types=1);

namespace Acme\ColorApi\Framework;
use Exception;

class RouteNotFoundException extends Exception
{

    public function __construct(string $url)
    {
        parent::__construct('Route not found for ' . $url, 404);
    }
}
