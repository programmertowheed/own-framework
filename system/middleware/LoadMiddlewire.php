<?php

namespace System\middleware;

trait LoadMiddlewire
{
    public function __construct($param)
    {
        parent::injectRequest();
        $result = $this->handle($param);
        if (!$result) {
            exit();
        }
    }

}
