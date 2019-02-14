<?php

namespace App\Modules\Lesson4;

use Sintattica\Atk\Attributes\BoolAttribute;
use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Attributes\TabbedPane;
use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Relations\OneToManyRelation;
use function App\Modules\Lesson_utils\nodeSourceUrl;

/**
 * This node is equal to the department node of lesson 3.
 */

class Department extends Node
{
    public function __construct($nodeUri)
    {
        parent::__construct($nodeUri, Node::NF_ADD_LINK);
        $this->setTable('lesson4_department');
        $this->setDescriptorTemplate('[name]');
        $this->setOrder('name');
        
        $this->add(new Attribute('id', Attribute::AF_AUTOKEY));
        $this->add(new Attribute('name', Attribute::AF_SEARCHABLE|Attribute::AF_UNIQUE));
        $this->add(new OneToManyRelation('employees', Attribute::AF_HIDE_LIST, 'Lesson4.employee'), 'staff');
        $this->add(new BoolAttribute('is_hiring'), 'staff');
        
        $this->getAttribute('is_hiring')->addDependency(
            function ($editform) {
                $editform->refreshAttribute('employees');
            }
        );
    }

    public function adminFooter()
    {
        return nodeSourceUrl('Lesson4.Department');
    }
   
    public function name_display($record, $mode)
    {
        $nameAttribute = $this->getAttribute('name');
        $displayString = $nameAttribute->display($record, $mode);

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
}
