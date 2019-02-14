<?php
namespace App\Modules\Lesson7;

use function App\Modules\Lesson_utils\moduleSourceUrl;

/**
 * The module definition class.
 *
 * This module introduces TreeNode object.
 * The module.inc file itself contains nothing new. The things to learn are
 * in the node files.
 *
 * And where has gone Lesson 6 ? Well, the functionnality it covered has been
 * removed between Atk8 and Atk9.
 */
class Module extends \Sintattica\Atk\Core\Module
{
    public static $module = 'Lesson7';
    
    public function boot()
    {
        $this->addMenuItem('lesson7');

        $this->addNodeToMenu('category', 'category', 'admin', 'lesson7');
        
        $this->addMenuItem("-", "", "lesson7");
        $this->addMenuItem("modulesource", moduleSourceUrl("Lesson7"), "lesson7");
    }

    public function register()
    {
        $this->registerNode("category", Category::class, ["admin", "add", "edit", "delete"]);
    }
}
