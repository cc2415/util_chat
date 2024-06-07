<?php

namespace App\Controller;

class BaseController extends AbstractController
{

    public function json($data, $code = 200, $msg = 'success')
    {
       return  $this->response->json(['data' => $data, 'code' => $code, 'msg' => $msg]);
    }

}