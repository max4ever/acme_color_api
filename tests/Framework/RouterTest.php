<?php declare(strict_types=1);

namespace Tests\Framework;

use Acme\ColorApi\Controller\Action\Color\DeleteColorAction;
use Acme\ColorApi\Controller\Action\Color\GetColorAction;
use Acme\ColorApi\Controller\Action\Color\PatchColorAction;
use Acme\ColorApi\Controller\Action\Color\PostColorAction;
use Acme\ColorApi\Controller\Action\Color\PutColorAction;
use Acme\ColorApi\Framework\Router;
use PHPUnit\Framework\TestCase;
use stdClass;
use Sunrise\Http\ServerRequest\ServerRequest;
use Sunrise\Uri\UriFactory;

class RouterTest extends TestCase
{

    private Router $router;

    protected function setUp(): void
    {
        $this->router = new Router();
    }

    public function testAddRouteFails(){
        $this->expectException(\RuntimeException::class);
        $this->router->addPostUrlHandler('/color', stdClass::class);
    }

    public function testMatchRoutes(): void
    {
        $this->router->addGetUrlHandler('/color/', GetColorAction::class);
        $this->router->addPostUrlHandler('/color/', PostColorAction::class);
        $this->router->addDeleteUrlHandler('/color/', DeleteColorAction::class);
        $this->router->addPatchUrlHandler('/color/', PatchColorAction::class);
        $this->router->addPutUrlHandler('/color/', PutColorAction::class);

        $request = (new ServerRequest)
            ->withMethod('GET')
            ->withUri((new UriFactory)->createUri('/color/'));

        self::assertEquals(GetColorAction::class, $this->router->matchPath($request));

        $request = $request->withMethod('POST');
        self::assertEquals(PostColorAction::class, $this->router->matchPath($request));

        $request = $request->withMethod('PUT');
        self::assertEquals( PutColorAction::class, $this->router->matchPath($request));

        $request = $request->withMethod('DELETE');
        self::assertEquals(DeleteColorAction::class, $this->router->matchPath($request));

        $request = $request->withMethod('PATCH');
        self::assertEquals(PatchColorAction::class, $this->router->matchPath($request));
    }

}
