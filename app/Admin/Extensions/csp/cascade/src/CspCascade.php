<?php

namespace CspCascade;

use Encore\Admin\Extension;

class CspCascade extends Extension
{
    public $name = 'cascade';

    public $views = __DIR__.'/../resources/views';

    public $assets = __DIR__.'/../resources/assets';

    public $menu = [
        'title' => 'Cspcascade',
        'path'  => 'cascade',
        'icon'  => 'fa-gears',
    ];
}