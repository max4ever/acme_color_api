<?php declare(strict_types=1);

namespace Acme\ColorApi\Framework;

use Acme\ColorApi\Controller\Action\ActionInterface;
use Psr\Http\Message\RequestInterface;
use RuntimeException;

class Router
{
    public const HTTP_GET = 'GET';
    public const HTTP_POST = 'POST';
    public const HTTP_PUT = 'PUT';
    public const HTTP_DELETE = 'DELETE';
    public const HTTP_PATCH = 'PATCH';

    private array $routes = [self::HTTP_GET => [], self::HTTP_POST => [], self::HTTP_PUT => [], self::HTTP_PATCH => []];

    public function addGetUrlHandler(string $basePath, string $actionInterfaceSubclass): self
    {
        $this->validateClassName($actionInterfaceSubclass);
        $this->routes[self::HTTP_GET][$basePath] = $actionInterfaceSubclass;

        return $this;
    }

    public function addPostUrlHandler(string $basePath, string $actionInterfaceSubclass): self
    {
        $this->validateClassName($actionInterfaceSubclass);
        $this->routes[self::HTTP_POST][$basePath] = $actionInterfaceSubclass;

        return $this;
    }

    public function addPutUrlHandler(string $basePath, string $actionInterfaceSubclass): self
    {
        $this->validateClassName($actionInterfaceSubclass);
        $this->routes[self::HTTP_PUT][$basePath] = $actionInterfaceSubclass;

        return $this;
    }

    public function addDeleteUrlHandler(string $basePath, string $actionInterfaceSubclass): self
    {
        $this->validateClassName($actionInterfaceSubclass);
        $this->routes[self::HTTP_DELETE][$basePath] = $actionInterfaceSubclass;

        return $this;
    }

    public function addPatchUrlHandler(string $basePath, string $actionInterfaceSubclass): self
    {
        $this->validateClassName($actionInterfaceSubclass);
        $this->routes[self::HTTP_PATCH][$basePath] = $actionInterfaceSubclass;

        return $this;
    }

    public function matchPath(RequestInterface $request): ?string
    {
        $method = $request->getMethod();
        $uri = $request->getUri();
        if ($method && $uri && isset($this->routes[$method][$uri->getPath()])) {
            return $this->routes[$method][$uri->getPath()];
        }

        return null;
    }

    /**
     * @throws RuntimeException
     */
    private function validateClassName(string $actionInterfaceSubclass): void
    {
        if (!is_subclass_of($actionInterfaceSubclass, ActionInterface::class)) {
            throw new RuntimeException('Please pass a class name that implements ActionInterface');
        }
    }
}
