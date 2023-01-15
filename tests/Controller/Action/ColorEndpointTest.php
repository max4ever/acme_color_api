<?php declare(strict_types=1);

namespace Tests\Controller\Action;

use Acme\ColorApi\Controller\Action\Color\DeleteColorAction;
use Acme\ColorApi\Controller\Action\Color\GetColorAction;
use Acme\ColorApi\Controller\Action\Color\PatchColorAction;
use Acme\ColorApi\Controller\Action\Color\PostColorAction;
use Acme\ColorApi\Controller\Action\Color\PutColorAction;
use Acme\ColorApi\Controller\Action\ColorEndpoint;
use Acme\ColorApi\Framework\Router;
use PHPUnit\Framework\TestCase;

final class ColorEndpointTest extends TestCase
{
    public function testGetWithNoData(): void
    {
        $routerMock = $this->createMock(Router::class);
        $routerMock->expects(self::once())
            ->method('addGetUrlHandler')
            ->with(ColorEndpoint::BASE_URL, GetColorAction::class);

        $routerMock->expects(self::once())
            ->method('addPostUrlHandler')
            ->with(ColorEndpoint::BASE_URL, PostColorAction::class);

        $routerMock->expects(self::once())
            ->method('addPatchUrlHandler')
            ->with(ColorEndpoint::BASE_URL, PatchColorAction::class);

        $routerMock->expects(self::once())
            ->method('addPutUrlHandler')
            ->with(ColorEndpoint::BASE_URL, PutColorAction::class);

        $routerMock->expects(self::once())
            ->method('addDeleteUrlHandler')
            ->with(ColorEndpoint::BASE_URL, DeleteColorAction::class);

        $colorEndpoint = new ColorEndpoint();

        $colorEndpoint->addHandledRoutes($routerMock);
    }

}
