<?php

namespace App\MessageModel;

class MImage extends AbsMessageModel
{
    public function __construct($imgUrl, $img_title)
    {
        parent::__construct(['img_url' => $imgUrl, 'img_title' => $img_title]);
    }
}