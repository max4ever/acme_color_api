<?php declare(strict_types=1);

namespace Tests\Framework;

use Acme\ColorApi\Controller\Action\Color\GetColorAction;
use Acme\ColorApi\Controller\Action\ColorEndpoint;
use Acme\ColorApi\Controller\Action\CrudEndpointInterface;
use Acme\ColorApi\Framework\Database\DbConnectionInterface;
use Acme\ColorApi\Framework\Kernel;
use Acme\ColorApi\Framework\Router;
use PDO;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sunrise\Http\Message\ResponseFactory;
use Sunrise\Http\ServerRequest\ServerRequest;
use Sunrise\Uri\UriFactory;

class KernelTest extends TestCase
{
    private Router $router;
    private Kernel $kernel;
    /** @var DbConnectionInterface|MockObject|null */
    private $dbConnection;

    protected function setUp(): void
    {
        $this->router = $this->createMock(Router::class);
        $this->dbConnection = $this->createMock(DbConnectionInterface::class);
        $this->kernel = new Kernel($this->dbConnection, $this->router);
    }

    /**
     * @runInSeparateProcess
     */
    public function testSendResponse(): void
    {
        $expected = ['some' => 'data'];
        $response = (new ResponseFactory())->createJsonResponse(204, $expected);

        ob_start();
        $this->kernel->sendResponse($response);
        $output = ob_get_clean();

        self::assertEquals(json_encode($expected, JSON_THROW_ON_ERROR), $output);
        self::assertEquals(204, http_response_code());
    }

    public function testRegisterEndpoints(): void
    {
        $mockCrudEndpoint = $this->createMock(CrudEndpointInterface::class);
        $mockCrudEndpoint->expects(self::once())
            ->method('addHandledRoutes');

        $this->kernel->registerEndpoints($mockCrudEndpoint);
    }

    public function testHandleRequest(): void
    {
        $request = (new ServerRequest)
            ->withMethod('GET')
            ->withUri((new UriFactory)->createUri('http://localhost/color/'))
            ->withQueryParams(['id' => 1]);

        $this->kernel->registerEndpoints(new ColorEndpoint());

        $this->router->expects(self::once())
            ->method('matchPath')
            ->with($request)
            ->willReturn(GetColorAction::class);

        $fakeColor = ['id' => 1, 'name' => 'white', 'hexValue' => 'FFFFFF'];

        $mockStatement = $this->createMock(PDOStatement::class);
        $mockStatement->expects(self::once())
            ->method('fetch')
            ->willReturn($fakeColor);

        $pdoMock = $this->createMock(PDO::class);
        $pdoMock->expects(self::once())
            ->method('prepare')
            ->willReturn($mockStatement);

        $this->dbConnection->expects(self::once())
            ->method('getInstance')
            ->willReturn($pdoMock);

        $expectedResponse = (new ResponseFactory())->createJsonResponse(200, $fakeColor);
        $response = $this->kernel->handleRequest($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertEquals((string)$expectedResponse->getBody(), (string)$response->getBody());
        self::assertEquals($expectedResponse->getHeaders(), $response->getHeaders());
    }

}
