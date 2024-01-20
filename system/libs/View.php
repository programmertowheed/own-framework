<?php

namespace System\libs;

/**
 * Load class
 */
class View
{

    public function show($filename, $data = false)
    {
        if ($data == true) {
            extract($data);
        }
        $filename = str_replace(".", "/", $filename);

        include BASE_PATH . "app/views/" . $filename . ".php";
    }


}

?>