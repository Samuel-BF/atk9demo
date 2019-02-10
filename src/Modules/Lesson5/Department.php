<?php

namespace App\Modules\Lesson5;

use Sintattica\Atk\Attributes\BoolAttribute;
use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Attributes\TabbedPane;
use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Relations\OneToManyRelation;
use Sintattica\Atk\Security\SecurityManager;
use function App\Modules\Lesson_utils\nodeSourceUrl;

/**
 * This node is similar to the department node of lesson 4.
 * The addition is an implementation of 'recordActions'.
 * In this lesson, a department can only be edited by it's
 * members. If a user is logged in, he can only edit his
 * own department.
 */

class Department extends Node
{

    function __construct($nodeUri) {
        parent::__construct($nodeUri, Node::NF_ADD_LINK);
        $this->setTable('lesson5_department');
        $this->setDescriptorTemplate('[name]');
        $this->setOrder('name');
        
        $this->add(new Attribute('id', Attribute::AF_AUTOKEY));
        $this->add(new Attribute('name', Attribute::AF_SEARCHABLE|Attribute::AF_UNIQUE));
        $this->add(new OneToManyRelation('employees', Attribute::AF_HIDE_LIST, 'Lesson5.employee'), 'staff');
        $this->add(new BoolAttribute('is_hiring'), 'staff');
        
        $this->getAttribute('is_hiring')->addDependency(
            function ($editform) { $editform->refreshAttribute('employees'); });
    }

    public function adminFooter()
    {
      return nodeSourceUrl('Lesson5.Department');
    }
   
    public function name_display($record)
    {
        $nameAttribute = $this->getAttribute('name');
        $displayString = $nameAttribute->display($record, "list");

        if ($record['is_hiring']) {
            $displayString = "<b>{$displayString}</b>";
        }

        return $displayString;
    }

    public function employees_edit($record, $fieldprefix, $mode)
    {
        $employees = $this->getAttribute('employees');

        if (!$record['is_hiring']) {
            $node = $employees->getDestination();
            $node->addFlag(Node::NF_NO_ADD);
        }
        return $employees->edit($record, $fieldprefix, $mode);
    }
    
    /**
     * The recordActions method can be implemented to add or remove actions
     * for a record.
     */
    function recordActions($record,&$actions,&$mraactions)
    {
        /**
         * First we determine the currently logged in user.
         */
        $user = SecurityManager::atkGetUser();

        /**
         * Then we compare the department_id of the employee, with the record
         * we are currently editing. A user may only edit his own department and
         * the administrator can edit all records
         */
        if ('administrator'!=$user['name'] && $record['id']!=$user['department'])
        {
            /**
             * If they do not match, the edit and delete actions are removed from
             * this records' action list.
             */
            unset($actions["edit"]);
            unset($actions["delete"]);
        }
    }
}
