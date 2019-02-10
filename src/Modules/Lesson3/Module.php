<?php

namespace App\Modules\Lesson3;
use function App\Modules\Lesson_utils\moduleSourceUrl;
  
  
/**
 * The module definition class.
 *
 * The module file is identical to that of lesson 2.
 */
class Module extends \Sintattica\Atk\Core\Module
{
    static $module = 'Lesson3';

    public function register()
    {
        $this->registerNode('department', Department::class, ['admin', 'add', 'edit', 'delete']);
        $this->registerNode('employee', Employee::class, ['admin', 'add', 'edit', 'delete']);
    }

    public function boot()
    {
        $this->addMenuItem('lesson3');

        $this->addNodeToMenu('departments', 'department', 'admin', 'lesson3');
        $this->addNodeToMenu('employees', 'employee', 'admin', 'lesson3');
        
        $this->addMenuItem("-", "", "lesson3");
        
        $this->addMenuItem("modulesource", moduleSourceUrl("Lesson3"), "lesson3");
    }
}
