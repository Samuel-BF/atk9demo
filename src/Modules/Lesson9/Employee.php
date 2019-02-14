<?php
namespace App\Modules\Lesson9;

/**
 * This lesson introduces many-to-many relations.
 *
 * The basis of implementing a many-to-many relation is 'normalization'.
 * This means that, like in the database, the relation is represented
 * by an intermediary node. This intermediary node has 2 manytoone
 * relations with the nodes on both sides of the manytomany relation.
 *
 * See the file EmployeeProject.php for the node that links
 * many projects to many employees.
 *
 * For simplicity, we're using the employee class from lesson 1 as
 * the basis.
 */
use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Relations\ShuttleRelation;
use function App\Modules\Lesson_utils\nodeSourceUrl;

class Employee extends Node
{
    public function __construct($nodeUri)
    {
        parent::__construct($nodeUri, Node::NF_ADD_LINK);
        $this->setTable('lesson9_employee');
        //$this->setIndex('name');
        $this->setOrder('name');
        $this->setDescriptorTemplate('[name]');

        $this->add(new Attribute('id', Attribute::AF_AUTOKEY));
        $this->add(new Attribute('name', Attribute::AF_SEARCHABLE|Attribute::AF_UNIQUE));
        $this->add(new Attribute('salary', Attribute::AF_TOTAL));

        /**
         * The following code is where we add the manytomany relation.
         * The third parameter tells ATK what intermediary node to use
         * (normalization).
         * In this case, we use a shuttle relationship. In the project
         * node we'll demonstrate a different type of relationship.
         * Available types are: shuttle, extendedshuttle, select, bool,
         * list.
         */
        $this->add(new ShuttleRelation(
            'projects',
            Attribute::AF_SEARCHABLE | ShuttleRelation::AF_MANYTOMANY_DETAILVIEW,
            'Lesson9.employeeproject',
            'Lesson9.project'
        ));
    }

    public function adminFooter()
    {
        return nodeSourceUrl("Lesson9.Employee") . ' / EmployeeProject : ' . nodeSourceUrl("Lesson9.EmployeeProject");
    }
}
