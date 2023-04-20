<?php

namespace App\Http\Traits;

trait UsesTemplateVars
{
    protected $template_vars = [];

    public function addTemplateVariables($vars_array)
    {
        $this->template_vars = array_merge($this->template_vars, $vars_array);
    }
}
