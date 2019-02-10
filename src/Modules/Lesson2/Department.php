<?php
namespace App\Modules\Lesson2;

use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Relations\OneToManyRelation;
use function App\Modules\Lesson_utils\nodeSourceUrl;

/**
 * The department is a simple node with an id as primary key, and a name
 * field.
 * New is the use of the 'one to many relation'. Departments and employees
 * have a master/detail relationship, or 1:N association.
 * If you want to reflect this in an application, adding a single line is
 * enough to add master/detail functionality to the node.
 * This results in the ability to add employees directly to a department.
 */
class Department extends Node
{

    function __construct($nodeUri)
    {
        parent::__construct($nodeUri, Node::NF_ADD_LINK);
        $this->setTable('lesson2_department');
        $this->setDescriptorTemplate('[name]');
        $this->setOrder('name');

        $this->add(new Attribute('id', Attribute::AF_AUTOKEY));
        $this->add(new Attribute('name', Attribute::AF_SEARCHABLE|Attribute::AF_UNIQUE));
        
        /**
         * The next line adds the relationship. 
         * 
         * The first parameter is the name of the entity we have a 
         * relationship with. This parameter is smart, it understands
         * words. E.g. we say 'has many employees'. The employee entity
         * is called 'employee', not 'employees', but this is OK. ATK
         * understands what you're trying to do.
         * 
         * Also, you'll note that we don't have to tell it what foreign
         * keys to use for the relationship. ATK discovers that employee 
         * has a 'department_id' field so it decides to use that as the
         * foreign key.
         */
        $this->add(new OneToManyRelation('employees', Attribute::AF_HIDE_LIST, 'Lesson2.employee'));
    }

    public function adminFooter()
    {
      return nodeSourceUrl("Lesson2.Department");
    }
}
