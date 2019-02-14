<?php
namespace App\Modules\Lesson1;

/**
 * This file contains the definition of a node. It describes our basic
 * business entity. It contains hints for the userinterface of the admin
 * screens and other feature definitions.
 *
 * Note how very little code (approx. 10 lines, the rest is comments) can
 * generate a complete administration screen for employee records.
 */
use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Attributes\Attribute;
use function App\Modules\Lesson_utils\nodeSourceUrl;

/**
 * A node usually represents one table in the database. In this case, we
 * define the node for employees, to generate the CRUD app for managing
 * employees.
 */
class Employee extends Node
{
    public function __construct($nodeUri)
    {
        /**
         * Some behaviour can be influenced by adding so-called 'node flags' to our
         * node. In this case, we add the NF_ADD_LINK. This means that in admin screens
         * we don't want to add records in the same screen, we want a link to a separate
         * add screen instead. (Remove the flag and browse the app to see the difference
         */
        parent::__construct($nodeUri, Node::NF_ADD_LINK);

        /**
         * The next line tells ATK which table this node represents.
         * (It is good practice to prefix the tablename with the name of the
         * module, since nodes from different modules may have the same name,
         * but table names must be unique).
         */
        $this->setTable('lesson1_employee');

        /**
         * The next line indicates that the "name" field can be used to generate
         * an alphabetical index in the admin screen.
         * For now, this ATK functionality does not work.
         */
        //$this->setIndex('name');
    
        /**
         * The following line sets the default order for this node. The order
         * can be adjusted by the user by clicking the column heading.
        */
        $this->setOrder('name');

        /**
         * With the descriptor, we can tell ATK how generally a record from this entity is
         * displayed. Employees are displayed by their name, so we use the name field as
         * $descriptor. To see this in action, edit an employee and look at the title
         * of the box. It will say Employee [Bill] indicating that we're editing bill.
         * If you would remove the $descriptor, it would simply say Employee [3] because
         * it falls back to using the database id if we don't tell it what field to use.
         * The brackets are used because this is a template, containing fieldnames between
         * square brackets. An example of a more complex $descriptor could be:
         * protected $descriptor = "[name] ([city])";
         * This results in the display of 'Jack (New York)' when editing employee
         * Jack from New York.
         */
        $this->setDescriptorTemplate('[name]');

        /**
         * Then next line defines an Attribute of the Employee Node, which corresponds to a
         * column of lesson1_employee table. This first Attribute is 'id' and comes with a
         * flag AF_AUTOKEY, which marks it as a primary key, autoincrementing and hidden
         * field.
         */
        $this->add(new Attribute('id', Attribute::AF_AUTOKEY));
        
        /**
         * With the next line, we add the name Attribute, and add a
         * flag to it, to make this field searchable. In the app, you'll see a search box
         * on top of the 'name' column. This flag is what causes that.
         * We also add the AF_UNIQUE flag to make the app force the user to enter unique
         * employees only. Note how we can concatenate multiple flags (they are bitwise).
         */
        $this->add(new Attribute('name', Attribute::AF_SEARCHABLE|Attribute::AF_UNIQUE));

        /**
         * Here's another example of adding flags to attributes; we're telling ATK that the
         * salary field should be totalled.
         */
        $this->add(new Attribute('salary', Attribute::AF_TOTAL));
    }

    /**
     * The adminFooter method is called by ATK to check if you have custom
     * code that you want to display below the list of records. There's also
     * an adminHeader method to put things above the list.
     *
     * In this case, the footer is used to display a link to this sourcefile,
     * nicely highlighted. The method used here is provided in the module.inc
     * file of the lesson_utils module.
     */
    public function adminFooter()
    {
        return nodeSourceUrl("Lesson1.Employee");
    }
}
