<?php
namespace App\Modules\Lesson1;

use function App\Modules\Lesson_utils\moduleSourceUrl;

/**
 * The module definition class.
 *
 * Each module extends Atk\Core\Module, to tell the system that this is a module
 * definition.
 */
class Module extends \Sintattica\Atk\Core\Module
{
    public static $module = 'Lesson1';

    public function register()
    {
        $this->registerNode('employees', Employee::class, ['admin', 'add', 'edit', 'delete']);
    }

    /**
     * The boot() method is called by ATK to determine which menuitems
     * this module has. The method usually contains one or more calls to
     * the addMenuItem() function.
     */
    public function boot()
    {
        /**
         * The next line adds a submenu called 'lesson1' to the main menu.
         */
        $this->addMenuItem('lesson1');

        /**
         * The following line adds a menuitem called 'employees' to the
         * 'lesson1' menu. The menuitems opens the 'admin' screen for the
         * 'employee' node of the 'lesson1' module.
         */
        $this->addNodeToMenu('employees', 'employees', 'admin', 'lesson1');
        
        /**
         * The next line is a separator in the lesson 1 menu. If the name is '-'
         * and the url is blank, the menuitem is considered a separator. It
         * results in a spacing between the previous and the next menuitem.
         */
        $this->addMenuItem("-", "", "lesson1");
        
        /**
         * The next line adds a link to a syntax-highlighted view this source
         * file. It uses the global moduleSourceUrl function (defined in the
         * lesson_utils module) to calculate the url.
         */
        $this->addMenuItem("modulesource", moduleSourceUrl("Lesson1"), "lesson1");
    }
}
