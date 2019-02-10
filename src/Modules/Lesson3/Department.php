<?php

namespace App\Modules\Lesson3;

use Sintattica\Atk\Attributes\BoolAttribute;
use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Attributes\TabbedPane;
use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Relations\OneToManyRelation;
use function App\Modules\Lesson_utils\nodeSourceUrl;
/**
 * This node is similar to the department node of lesson 2.
 * We'll add various features to the department functionality.
 * One is the use of tabs to make the user interface cleaner.
 * 
 * Finally, we're doing something nifty to manipulate the
 * behaviour of attributes on the fly; in this case we have an
 * 'is hiring' field per department that toggles whether or not
 * new employees can be added.
 */
class department extends Node
{

    function __construct($nodeUri) {
        parent::__construct($nodeUri, Node::NF_ADD_LINK);
        $this->setTable('lesson3_department');
        $this->setDescriptorTemplate('[name]');
        $this->setOrder('name');
        
        $this->add(new Attribute('id', Attribute::AF_AUTOKEY));
        $this->add(new Attribute('name', Attribute::AF_SEARCHABLE|Attribute::AF_UNIQUE));

        /**
         * The next 2 lines tells ATK to put both the 'employees' and 
         * 'is_hiring' fields on the 'staff' tab.
         */
        $this->add(new OneToManyRelation('employees', Attribute::AF_HIDE_LIST, 'Lesson3.employee'), 'staff');
        $this->add(new BoolAttribute('is_hiring'), 'staff');
        
        
        /**
         * Now, we're adding a bit of ajax magic. Whenever the is_hiring field
         * is changed, we want the 'add employee' link to disappear right away. To 
         * accomplish this, we can retrieve the is_hiring attribute and add a 
         * function that will refresh 'employees 'as its dependee. You can try this
         * by toggling the is_hiring checkbox on the staff tab; you'll notice
         * that the 'add new employee' link disappears right away.
         */
        $this->getAttribute('is_hiring')->addDependency(
            function ($editform) { $editform->refreshAttribute('employees'); });
    }

    public function adminFooter()
    {
      return nodeSourceUrl('Lesson3.Department');
    }
   
    /**
     * By defining a method whose name is equal to that of an attribute, with
     * the _display postfix, we tell the system that we want to influence the
     * way names are displayed. In this example, we want to display the name
     * of departments that are hiring new employees, in bold.
     * 
     * To try out this feature, edit a department, change the checkbox of its
     * 'is hiring' field and look at how the name is bold/not bold in the
     * record list.
     */
    public function name_display($record)
    {
        /**
         * First we retrieve the original text that would be displayed if we
         * would have no override.
         */
        $nameAttribute = $this->getAttribute('name');
        $displayString = $nameAttribute->display($record);

        /**
         * Then, if is_hiring is true, we add bold tags around the
         * original text.
         */
        if ($record['is_hiring']) {
            $displayString = "<b>{$displayString}</b>";
        }

        return $displayString;
    }

    /**
     * By defining a method whose name is equal to that of an attribute, we
     * can override the editing of the attribute. In this example, if
     * 'is_hiring' is not true, we want to disable the addition of new
     * employees in the list of employees for this department.
     */
    public function employees_edit($record, $fieldprefix, $mode)
    {
        /**
         * If is_hiring is not false, we disable the add functionality
         * on the target node. This is done by retrieving the destination
         * node (lesson3.employee), and adding the NF_NO_ADD flag to it.
         */
        $employees = $this->getAttribute('employees');

        if (!$record['is_hiring']) {
            $node = $employees->getDestination();
            $node->addFlag(Node::NF_NO_ADD);
        }

        /**
         * Finally, we call the original edit method, because we
         * don't want to override anything else.
         */
        return $employees->edit($record, $fieldprefix, $mode);
    }
}
