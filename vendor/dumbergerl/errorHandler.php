<?php

namespace DumbergerL;

use Exception;

class ErrHandler {

    static function handle(Exception $text, $failure = false)
    {
        echo "\nAN ERROR APEARS...\n\t".$text->getMessage().'\n';
        if($failure)die();
    }
}