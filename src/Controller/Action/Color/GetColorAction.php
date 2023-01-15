<?php declare(strict_types=1);

namespace Acme\ColorApi\Controller\Action\Color;

use Acme\ColorApi\Controller\Action\AbstractCrudAction;
use Acme\ColorApi\Repository\NotFoundException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class GetColorAction extends AbstractCrudAction
{

    public function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        if (!empty($params['id']) && is_numeric($params['id'])) {
            return $this->getJsonResponse(200, $this->colorRepository->getColor((int)$params['id'])->toArray());
        }

        return $this->getJsonResponse(200, $this->colorRepository->findAll());
    }
}
