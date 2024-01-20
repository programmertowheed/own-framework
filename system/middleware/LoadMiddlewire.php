<?php

namespace System\middleware;

trait LoadMiddlewire
{
    public function __construct()
    {
        parent::injectRequest();
        $result = $this->handle();
        if (!$result) {
            exit();
        }
    }

}
