<?php

namespace CspCascade\Http\Controllers;

use Encore\Admin\Layout\Content;
use Illuminate\Routing\Controller;

class CspCascadeController extends Controller
{
    public function index(Content $content)
    {
        return $content
            ->title('Title')
            ->description('Description')
            ->body(view('cascade::index'));
    }
}