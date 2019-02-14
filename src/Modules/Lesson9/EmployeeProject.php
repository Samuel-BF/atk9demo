<?php
namespace App\Modules\Lesson9;

use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Relations\ManyToOneRelation;

class EmployeeProject extends Node
{
    public function __construct($nodeUri)
    {
        parent::__construct($nodeUri);
        $this->setTable('lesson9_employeeproject');

        $this->add(new ManyToOneRelation('employee_id', Attribute::AF_PRIMARY, 'Lesson9.employee'));
        $this->add(new ManyToOneRelation('project_id', Attribute::AF_PRIMARY, 'Lesson9.project'));
    }
}
