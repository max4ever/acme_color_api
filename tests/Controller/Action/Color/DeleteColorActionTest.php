<?php

namespace Tests\Controller\Action\Color;

use Acme\ColorApi\Controller\Action\Color\DeleteColorAction;
use Acme\ColorApi\Repository\ColorRepository;
use PHPUnit\Framework\TestCase;
use Sunrise\Http\Message\ResponseFactory;
use Sunrise\Http\ServerRequest\ServerRequest;
use Sunrise\Uri\UriFactory;

class DeleteColorActionTest extends TestCase
{

    public function testDeleteOk(): void
    {
        $repoMock = $this->createMock(ColorRepository::class);
        $deleteAction = new DeleteColorAction($repoMock);

        $request = (new ServerRequest)
            ->withMethod('DELETE')
            ->withUri((new UriFactory)->createUri('http://localhost/color/'))
            ->withQueryParams(['id' => 1]);

        $response = $deleteAction->handleRequest($request);

        $expectedResponse = (new ResponseFactory())->createResponse(204);
        self::assertEquals(204, $response->getStatusCode());
        self::assertEquals((string)$expectedResponse->getBody(), (string)$response->getBody());
        self::assertEquals($expectedResponse->getHeaders(), $response->getHeaders());
    }

    public function testBadRequest(): void
    {
        $repoMock = $this->createMock(ColorRepository::class);
        $deleteAction = new DeleteColorAction($repoMock);

        $request = (new ServerRequest)
            ->withMethod('DELETE')
            ->withUri((new UriFactory)->createUri('http://localhost/color/'));

        $response = $deleteAction->handleRequest($request);

        $expectedResponse = (new ResponseFactory())->createResponse(400);
        self::assertEquals(400, $response->getStatusCode());
        self::assertEquals((string)$expectedResponse->getBody(), (string)$response->getBody());
        self::assertEquals($expectedResponse->getHeaders(), $response->getHeaders());
    }

}
