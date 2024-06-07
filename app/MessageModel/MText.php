<?php

namespace App\MessageModel;

class MText extends AbsMessageModel
{
    public function __construct($text, $extend = [])
    {
        parent::__construct(['text' => $text, 'extend' => $extend]);
    }
}