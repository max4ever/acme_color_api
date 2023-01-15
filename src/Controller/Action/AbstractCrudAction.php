<?php declare(strict_types=1);

namespace Acme\ColorApi\Controller\Action;

use Acme\ColorApi\Entity\EntityInterface;
use Acme\ColorApi\Repository\ColorRepository;
use Acme\ColorApi\Repository\ColorRepositoryInterface;
use Psr\Http\Message\ResponseInterface;
use Sunrise\Http\Message\ResponseFactory;

abstract class AbstractCrudAction implements ActionInterface
{
    protected ColorRepositoryInterface $colorRepository;

    public function __construct(ColorRepositoryInterface $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    protected function getJsonResponse(int $httpCode, array $data): ResponseInterface
    {
        foreach ($data as $i => $val) {
            if ($val instanceof EntityInterface) {
                $data[$i] = $val->toArray();
            }
        }

        return (new ResponseFactory())->createJsonResponse($httpCode, $data);
    }

    protected function getHttpResponse(int $httpCode): ResponseInterface
    {
        return (new ResponseFactory())->createResponse($httpCode);
    }
}
