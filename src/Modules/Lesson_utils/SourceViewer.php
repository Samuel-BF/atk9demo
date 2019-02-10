<?php

namespace App\Modules\Lesson_utils;
 
use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Core\Atk;
use Sintattica\Atk\Session\SessionManager;

class SourceViewer extends Node
{
    function __construct($nodeUri){
        parent::__construct($nodeUri);
    }

    function getSourceFileName($module, $node){
        $atk = Atk::getInstance();
        if ($node=="")
            $filename = $atk->moduleDir($module)."Module.php";
        else
            $filename = $atk->moduleDir($module).$node.".php";

        if (strpos($filename, "./") === 0)
            $filename = substr($filename, 2);

        if ((strpos($filename, "..")!==false) || (!file_exists($filename)))
            return false;

        return $filename;
    }

    function getContent($filename)
    {
        if ($filename !== false) {
            $content = '<div align="left" style="font-size: 10pt">';
            $content.= '<br>'.$this->text("sourcecode_of").' <b>'.$filename.'</b>:<br><br>';
            $content.= highlight_file($filename, true);
            $content.='</div>';
        } else {
            $content = $this->text("invalid_file") . ' : ' . $filename;
        }

        $sessionmanager = SessionManager::getInstance();
        if ($sessionmanager->atkLevel()>0)
            $content.= '<br><br>'.atkButton("&lt;&lt; " . $this->text("back"), "", SESSION_BACK, false);

        return $content;
    }

    function getTitle($module, $node) {
        $title = $this->text("the_source_for") . " ";
        if (empty($node))
        $title .= $this->text("module") . " $module";
        else
        $title .= $this->text("node") . " $module.$node";
        return $title;
    }

    function action_view() {
        // Get used objects
        $sessionmanager = SessionManager::getInstance();
        $page = &$this->getPage();
        $ui = &$this->getUi();

        // Read the module and node and filename
        $module = $sessionmanager->pageVar("module");
        $node = $sessionmanager->pageVar("node");
        $filename = $this->getSourceFileName($module, $node);

        // Create the interface
        $content = $this->getContent($filename);
        $title = $this->getTitle($module, $node);
        $output = $ui->renderBox(array("title"=>$title, "content"=>$content));
        $actionpage = $this->renderActionPage("view", $output);

        $page->addContent($actionpage);
    }

}

?>
