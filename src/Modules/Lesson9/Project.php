<?php
namespace App\Modules\Lesson9;

/**
 * The project node uses another kind of many-to-many relation :
 * what changes here is the way target items (employee) are added
 * to the current node (project)
 */
use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Relations\ManyToManySelectRelation;
use function App\Modules\Lesson_utils\nodeSourceUrl;

class Project extends Node
{
    public function __construct($nodeUri)
    {
        parent::__construct($nodeUri, Node::NF_ADD_LINK);
        $this->setTable('lesson9_project');
        //$this->setIndex('name');
        $this->setOrder('name');
        $this->setDescriptorTemplate('[name]');

        $this->add(new Attribute('id', Attribute::AF_AUTOKEY));
        $this->add(new Attribute('name', Attribute::AF_SEARCHABLE|Attribute::AF_UNIQUE));
        /**
         * The select relation is a manytomany type relation represented
         * by a set of selected records and a selection field. Like in
         * the Employee.php example in this module, the parameters
         * represent the intermediary node and the target node.
         */
        $this->add(new ManyToManySelectRelation(
            'employees',
            Attribute::AF_SEARCHABLE | ManyToManySelectRelation::AF_MANYTOMANY_DETAILVIEW,
            'Lesson9.employeeproject',
            'Lesson9.employee'
        ));
    }

    public function adminFooter()
    {
        return nodeSourceUrl("Lesson9.Employee");
    }
}
