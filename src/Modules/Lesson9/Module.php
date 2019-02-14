<?php
namespace App\Modules\Lesson9;

use function App\Modules\Lesson_utils\moduleSourceUrl;

/**
 * The module definition class.
 *
 * This module introduces the many-to-many relations, see node files 
 * for more details
 *
 * The lesson8 covered functionnality that disappeared from Atk.
 */
class Module extends \Sintattica\Atk\Core\Module
{
    static $module = 'Lesson9';
    
    public function boot()
    {
        $this->addMenuItem('lesson9');

        $this->addNodeToMenu('employees', 'employee', 'admin', 'lesson9');
        $this->addNodeToMenu('projects', 'project', 'admin', 'lesson9');
        
        $this->addMenuItem("-", "", "lesson9");
        $this->addMenuItem("modulesource", moduleSourceUrl("Lesson9"), "lesson9");
    }

    public function register()
    {
        $this->registerNode("employeeproject", EmployeeProject::class);
        $this->registerNode("employee", Employee::class, ["admin", "add", "edit", "delete"]);
        $this->registerNode("project", Project::class, ["admin", "add", "edit", "delete"]);
    }
}
