<?php

namespace tpl;

class Tpl
{
    // private $templatePath;
    protected $tpl;

    public function __construct($templateFile = '')
    {
        $this->tpl = $templateFile;
    }

    public function render($template, $variables = null)
    {
        $output = file_get_contents($this->tpl . $template);
        if ($variables != null) {
            foreach ($variables as $key => $value) {
                $output = str_replace('{{' . $key . '}}', $value, $output);
            };
            return $output;
        }
        return $output;
    }
}
