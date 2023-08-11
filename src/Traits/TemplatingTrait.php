<?php 

namespace WdrGsheetsImporter\Traits;

use Smarty;

trait TemplatingTrait {
    private function loadTemplate(string $name): string 
    {
        return constant('WDR_GSHEETS_PLUGIN') . '/static/templates/' . $name . '.tpl';
    }

    private function display(string $view, array $context): string 
    {
        $smarty = new Smarty();

        foreach ($context as $key => $param) {
            $smarty->assign($key, $param);
        }

        $smarty->assign('active_layer', $view);

        $smarty->setTemplateDir([
            constant('WDR_GSHEETS_PLUGIN') . '/static/templates/'
        ]);

        return $smarty->fetch($this->loadTemplate($view));
    }
}