<?php
namespace App\Modules\Lesson10;

use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Attributes\CurrencyAttribute;
use Sintattica\Atk\Attributes\DateAttribute;
use Sintattica\Atk\Attributes\TextAttribute;
use Sintattica\Atk\Relations\ManyToOneRelation;
use function App\Modules\Lesson_utils\nodeSourceUrl;

/**
 * This node is similar to the employee node of lesson 3.
 *
 * The difference is that we add 2 constraints on who can be a manager
 * of an employee :
 *  - the manager is from the same department
 *  - the manager is not the employee itself
 */
class Employee extends Node
{
    public function __construct($nodeUri)
    {
        parent::__construct($nodeUri, Node::NF_ADD_LINK);
        $this->setTable('lesson10_employee');
        $this->setDescriptorTemplate('[name]');
        //$this->setIndex('name');
        $this->setOrder('name');

        $this->add(new Attribute('id', Attribute::AF_AUTOKEY));
        $this->add(new Attribute('name', Attribute::AF_OBLIGATORY|Attribute::AF_SEARCHABLE|Attribute::AF_UNIQUE));
        $this->add(new CurrencyAttribute('salary', Attribute::AF_TOTAL, '€'));
        $dpt = $this->add(new ManyToOneRelation('department', Attribute::AF_SEARCHABLE, 'Lesson10.department'));
        $mgr = $this->add(new ManyToOneRelation('manager', Attribute::AF_SEARCHABLE, 'Lesson10.employee'));
        $this->add(new DateAttribute('hiredate'));
        $this->add(new TextAttribute('notes'));

        /**
         * Two things here :
         * - we reference the relation by the $mgr variable, result of $this->add few lines earlier.
         *   we could also use $this->getAttribute('manager')->addDestinationFilter.
         * - the addDestinationFilter function implement the constraints we want to apply. The filter is
         *   parsed and field between brackets are replaced by corresponding values.
         */
        $mgr->addDestinationFilter("lesson10_employee.department = '[department.id]' AND lesson10_employee.id<>'[id]'");
        
        /**
         * And like in department node of lesson3, we add a callback to refresh manager attribute when
         * department attribute is modified.
         */
        $dpt->addDependency(function ($editform) {
            $editform->refreshAttribute('manager');
        });
    }

    public function adminFooter()
    {
        return nodeSourceUrl("Lesson10.Employee");
    }
}
