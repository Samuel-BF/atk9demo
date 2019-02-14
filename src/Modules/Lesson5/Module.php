<?php
namespace App\Modules\Lesson5;

use function App\Modules\Lesson_utils\moduleSourceUrl;

/**
 * The module definition class.
 *
 * This module introduces, among other things, security profiles. Employees
 * get a login name/password, and a profile.
 */
class Module extends \Sintattica\Atk\Core\Module
{
    public static $module = 'Lesson5';
    
    public function boot()
    {
        $this->addMenuItem('lesson5');

        $this->addNodeToMenu('departments', 'department', 'admin', 'lesson5');
        
        /**
         * The following line adds the new profiles menu item.
         * New here is the 5th parameter to the addNodeToMenu() call. This parameter
         * makes the menuitem disappear, if the current user does not have the
         * 'admin' privilege on the profile node.
         * If you don't pass this parameter, the menu item is always visible, and
         * the user will get an 'access denied' message when clicking the item
         * anyway. (you can try this by accessing the 'lesson1' menuitems when
         * logged in as one of the employees.)
         */
        $this->addNodeToMenu('employees', 'employee', 'admin', 'lesson5', array("lesson5.profile", "admin"));
        
        $this->addMenuItem("-", "", "lesson5");
        
        $this->addMenuItem("modulesource", moduleSourceUrl("Lesson5"), "lesson5");
    }
        
    /**
     * This lesson contains security profiles. This means that no longer all
     * users may execute all actions. The administrator user still can, but
     * other users need privileges.
     * With this method, the system is instructed of the privileges that
     * exist. Usually, this corresponds to the actions that can be done
     * on a node.
     */
    public function register()
    {
        $this->registerNode("department", Department::class, ["admin", "add", "edit", "delete"]);
        /**
         * If a user has the grantall privilege, he can grant other users all
         * privileges; even privileges he does not have himself. Without this
         * privilege, users can only grant rights to other users that they have
         * themselves.
         *
         * The auth_grantall_privilege configuration value have to be set in
         * config/atk.php in order for this to work :
         * 'auth_grantall_privilege' => 'Lesson5.profile.grantall',
         */
        $this->registerNode("profile", Profile::Class, ["admin", "add", "edit", "delete", "grantall"]);
        $this->registerNode("employee", Employee::class, ["admin", "add", "edit", "delete"]);
    }
}
