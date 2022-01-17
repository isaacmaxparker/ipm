<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\Traits\UsesTemplateVars;
use App\Enums\Json;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, UsesTemplateVars;

    public function __construct()
    {
      //  parent::__construct();
    }

    protected function renderView($request, $template, $variables)
    {
        $variables['is_ajax'] = $request->ajax();
        if ($request->ajax()) {
            $branding = isset($variables['branding']) ? $variables['branding'] : false;
            $content = array_merge($variables, ['isolate_section'=>'content']);
            $aside = array_merge($variables, ['isolate_section'=>'aside']);
            $nav = array_merge($variables, ['isolate_section'=>'nav']);
            return $this->response(['url'=>$request->getrequestUri(), 'messages'=>session('widget_message'),'branding'=> $branding, 'content'=> view($template, $content)->render(), 'aside'=> view($template, $aside)->render(), 'nav'=> view($template, $nav)->render() ]);
        }
        return view($template, $variables);
    }
}



