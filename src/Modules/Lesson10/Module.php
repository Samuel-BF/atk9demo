<?php
namespace App\Modules\Lesson10;

use function App\Modules\Lesson_utils\moduleSourceUrl;

/**
 * The module definition class.
 *
 * The module file is identical to that of lesson 2.
 *
 * This module introduces the filter in relations, see Employee node
 * source for more details.
 */
class Module extends \Sintattica\Atk\Core\Module
{
    public static $module = 'Lesson10';
    
    public function boot()
    {
        $this->addMenuItem('lesson10');

        $this->addNodeToMenu('employees', 'employee', 'admin', 'lesson10');
        $this->addNodeToMenu('departments', 'department', 'admin', 'lesson10');
        
        $this->addMenuItem("-", "", "lesson10");
        $this->addMenuItem("modulesource", moduleSourceUrl("Lesson10"), "lesson10");
    }

    public function register()
    {
        $this->registerNode("employee", Employee::class, ["admin", "add", "edit", "delete"]);
        $this->registerNode("department", Department::class, ["admin", "add", "edit", "delete"]);
    }
}
