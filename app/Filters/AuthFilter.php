<?php
namespace App\Filter;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\API\ResponseTrait;
use Config\Services;
use Firebase\JWT\JWT;


class AuthFilter implements FilterInterface{
    use ResponseTrait;
    public function before(RequestInterface $request, $arguments = null){
        //Antes del controlador
        try {
            $key = Services::getSecretKey();
            $authHeader = $request->getServer('HTTP_AUTHORIZATION');
            if($authHeader == null)
                return Services::response()->setStatusCode(ResponseInterface::HTTP_UNAUTHORIZED,'No se ha enviado el JWT requerido');
            $arr = explode('',$authHeader);
            $jwt = $arr[1];

            JWT::decode($jwt,$key,['HS256']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){

    }

}
