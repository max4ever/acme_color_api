<?php declare(strict_types=1);

namespace Acme\ColorApi\Controller\Action;

use Acme\ColorApi\Controller\Action\Color\DeleteColorAction;
use Acme\ColorApi\Controller\Action\Color\GetColorAction;
use Acme\ColorApi\Controller\Action\Color\PatchColorAction;
use Acme\ColorApi\Controller\Action\Color\PostColorAction;
use Acme\ColorApi\Controller\Action\Color\PutColorAction;
use Acme\ColorApi\Framework\Router;

final class ColorEndpoint implements CrudEndpointInterface
{
    public const BASE_URL = '/color/';

    public function addHandledRoutes(Router $router): void{
        $router->addGetUrlHandler(self::BASE_URL, GetColorAction::class);
        $router->addPostUrlHandler(self::BASE_URL, PostColorAction::class);
        $router->addPatchUrlHandler(self::BASE_URL, PatchColorAction::class);
        $router->addPutUrlHandler(self::BASE_URL, PutColorAction::class);
        $router->addDeleteUrlHandler(self::BASE_URL, DeleteColorAction::class);
    }
}
