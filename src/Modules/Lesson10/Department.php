<?php
namespace App\Modules\Lesson10;

use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Relations\OneToManyRelation;
use function App\Modules\Lesson_utils\nodeSourceUrl;

/**
 * This node is similar to the department node of lesson 2.
 *
 */
class Department extends Node
{

    public function __construct($nodeUri)
    {
        parent::__construct($nodeUri, Node::NF_ADD_LINK);
        $this->setTable('lesson10_department');
        $this->setDescriptorTemplate('[name]');
        $this->setOrder('name');

        $this->add(new Attribute('id', Attribute::AF_AUTOKEY));
        $this->add(new Attribute('name', Attribute::AF_OBLIGATORY|Attribute::AF_SEARCHABLE|Attribute::AF_UNIQUE));

        $this->add(new OneToManyRelation('employees', Attribute::AF_HIDE_LIST, 'Lesson2.employee'));
    }

    public function adminFooter()
    {
        return nodeSourceUrl("Lesson10.Department");
    }
}
