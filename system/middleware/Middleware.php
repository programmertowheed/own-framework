<?php

namespace System\middleware;

use System\request\Request;

class Middleware
{
    public $request = null;

    public function injectRequest()
    {
        $request = new Request();
        $this->request = $request->serverRequest();
    }


}
