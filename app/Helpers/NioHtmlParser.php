<?php

namespace App\Helpers;

use App\Helpers\Library\Html2Text;

class NioHtmlParser
{
    public static function getText($htmlString)
    {
        $html = new Html2Text($htmlString);
        return $html->getText();
    }
}
