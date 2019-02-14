<?php
namespace App\Modules\Lesson4;

use function App\Modules\Lesson_utils\moduleSourceUrl;

/**
 * The module definition class.
 *
 * The module file is identical to that of lesson 3.
 */
class Module extends \Sintattica\Atk\Core\Module
{
    public static $module = 'Lesson4';

    public function register()
    {
        $this->registerNode('department', Department::class, ['admin', 'add', 'edit', 'delete']);
        $this->registerNode('employee', Employee::class, ['admin', 'add', 'edit', 'delete']);
    }

    public function boot()
    {
        $this->addMenuItem('lesson4');

        $this->addNodeToMenu('departments', 'department', 'admin', 'lesson4');
        $this->addNodeToMenu('employees', 'employee', 'admin', 'lesson4');
        
        $this->addMenuItem("-", "", "lesson4");
        
        $this->addMenuItem("modulesource", moduleSourceUrl("Lesson4"), "lesson4");
    }
}
