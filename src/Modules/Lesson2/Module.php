<?php

namespace App\Modules\Lesson2;
use function App\Modules\Lesson_utils\moduleSourceUrl;
  
/**
 * The module definition class.
 *
 * The module file is similar to that of lesson 1, with an extra 
 * 'department' menu item. 
 */
class Module extends \Sintattica\Atk\Core\Module
{
    static $module = 'Lesson2';

    public function register()
    {
        $this->registerNode('department', Department::class, ['admin', 'add', 'edit', 'delete']);
        $this->registerNode('employee', Employee::class, ['admin', 'add', 'edit', 'delete']);
    }

    public function boot()
    {
        $this->addMenuItem('lesson2');

        $this->addNodeToMenu('departments', 'department', 'admin', 'lesson2');
        $this->addNodeToMenu('employees', 'employee', 'admin', 'lesson2');
        
        $this->addMenuItem("-", "", "lesson2");
        
        $this->addMenuItem("modulesource", moduleSourceUrl("Lesson2"), "lesson2");
    }
}
