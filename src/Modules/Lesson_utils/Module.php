<?php

namespace App\Modules\Lesson_utils;

use Sintattica\Atk\Core\Tools;

class Module extends \Sintattica\Atk\Core\Module
{
    static $module = 'Lesson_utils';

    public function register()
    {
        $this->registerNode('sourceviewer', SourceViewer::class, ['view']);
    }
}

function nodeSourceUrl($nodetype) {
    list($module, $node) = explode(".", $nodetype);
    return Tools::href(Tools::dispatch_url("Lesson_utils.sourceviewer", "view", array("module"=>$module, "node"=>$node)), Tools::atktext("view_source", "lesson_utils"), SESSION_NESTED);
}

function moduleSourceUrl($module)
{
    return Tools::dispatch_url("Lesson_utils.sourceviewer", "view", array("module"=>$module));
}

?>
