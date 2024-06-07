<?php

namespace App\Middleware;

use App\Helper\JWTHelper;
use App\Services\BaseServices;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class LoginMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var HttpResponse
     */
    protected $response;


    public function __construct(ContainerInterface $container, HttpResponse $response, RequestInterface $request)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
    }


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {

            $userToken = $request->getHeaderLine('user_token');
            var_dump($userToken);
            $userData = JWTHelper::decode($userToken);
            var_dump($userData);
            if (!$userData) {
                error(1002);
            }
            BaseServices::setLoginUserInfo($userData);
            return $handler->handle($request);
        } catch (\Exception $exception) {
            return $this->response->json(
                [
                    'code' => $exception->getCode(),
                    'data' => [],
                    'msg' => $exception->getMessage()
                ]
            );
        }
    }
}