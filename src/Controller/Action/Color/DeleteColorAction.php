<?php declare(strict_types=1);

namespace Acme\ColorApi\Controller\Action\Color;

use Acme\ColorApi\Controller\Action\AbstractCrudAction;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Sunrise\Http\Message\Response;

class DeleteColorAction extends AbstractCrudAction
{

    public function handleRequest(ServerRequestInterface $request): ResponseInterface
    {
        $params = $request->getQueryParams();
        if (!empty($params['id']) && is_numeric($params['id'])) {
            $this->colorRepository->delete((int)$params['id']);
            return $this->getHttpResponse(204);
        }

        return $this->getHttpResponse(400);
    }
}
