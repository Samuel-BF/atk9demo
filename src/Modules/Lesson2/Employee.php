<?php
namespace App\Modules\Lesson2;

use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Relations\ManyToOneRelation;
use function App\Modules\Lesson_utils\nodeSourceUrl;

/**
 * This node is a copy of the employee node from lesson 1. (ofcourse, in ATK
 * it would actually not be necessary to copy, inheritance could be used
 * instead. For the clarity of the example though, a fresh node is used
 * here.)
 *
 * New are the many-to-one relations.
 */
 
class Employee extends Node
{
    public function __construct($nodeUri)
    {
        parent::__construct($nodeUri, Node::NF_ADD_LINK);
        $this->setTable('lesson2_employee');
        $this->setDescriptorTemplate('[name]');
        //$this->setIndex('name');
        $this->setOrder('name');

        $this->add(new Attribute('id', Attribute::AF_AUTOKEY));
        $this->add(new Attribute('name', Attribute::AF_SEARCHABLE|Attribute::AF_UNIQUE));
        $this->add(new Attribute('salary', Attribute::AF_TOTAL));
        
        /**
         * The first manytoone relation is a N:1 association to department. Many
         * employees can be in one department. One department can contain many
         * employees.
         * By adding a single line of code, we enable N:1 functionality in this
         * node. The effect is a dropdown from which the user can choose a
         * department.
         *
         * We don't need any parameters, ATK figures out everything on its own.
         */
         $this->add(new ManyToOneRelation('department', Attribute::AF_SEARCHABLE, 'Lesson2.department'));

        /**
         * The second manytoone we add is a recursive parent/child relationship.
         * Employees have a manager. Ofcourse, a manager is an employee too.
         *
         * In this case, we have to help ATK a bit. The department relationship
         * automagically works, because ATK finds a department field in the
         * database it can work with. There is however no employee_id field.
         * The database has a manager_id, so we have to tell ATK to use that
         * for the relationship, using the source parameter.
         *
         */
         $this->add(new ManyToOneRelation('manager', Attribute::AF_SEARCHABLE, 'Lesson2.employee'));
    }
    
    public function adminFooter()
    {
        return nodeSourceUrl("Lesson2.Employee");
    }
}
