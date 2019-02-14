<?php
namespace App\Modules\Lesson4;

use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Attributes\CurrencyAttribute;
use Sintattica\Atk\Attributes\DateAttribute;
use Sintattica\Atk\Attributes\DummyAttribute;
use Sintattica\Atk\Attributes\EmailAttribute;
use Sintattica\Atk\Relations\ManyToOneRelation;
use function App\Modules\Lesson_utils\nodeSourceUrl;

/**
 * This node is similar to the employee node of lesson 4, but contains
 * many improvements.
 *
 * The major addition in this lesson is triggers, but the lesson also
 * contains a few other nifty tricks.
 */
 
class Employee extends Node
{
    public function __construct($nodeUri)
    {
        /**
         * There's one new flag in the next line of code. The NF_TRACK_CHANGES
         * keeps track of record modifications, which will be used in the update
         * trigger later on in this file.
         */
        parent::__construct($nodeUri, Node::NF_ADD_LINK | Node::NF_TRACK_CHANGES);
        $this->setTable('lesson4_employee');
        $this->setDescriptorTemplate('[name]');
        //$this->setIndex('name');
        $this->setOrder('name');

        $this->add(new Attribute('id', Attribute::AF_AUTOKEY));
        $this->add(new Attribute('name', Attribute::AF_SEARCHABLE|Attribute::AF_UNIQUE));
        $this->add(new CurrencyAttribute('salary', Attribute::AF_TOTAL, '€'));
        $this->add(new ManyToOneRelation('department', Attribute::AF_SEARCHABLE, 'Lesson4.department'));
        $this->add(new ManyToOneRelation(
            'manager',
            Attribute::AF_SEARCHABLE|ManyToOneRelation::AF_RELATION_AUTOCOMPLETE,
            'Lesson4.employee'
        ));

        /**
         * In the next line, we learn a couple of things. First, we manually add
         * a new attribute. In this case an atkDummyAttribute, which is a field
         * that is not retrieved from the database; it's typically used to add
         * comments to fields.With the AF_HIDE_LIST, the attribute is hidden
         * from the recordlist, and only displayed in add/edit/view screens.
         * Like the hasOne and get methods, add returns a fluid interface to
         * a utility class that we can use to call 'insertBefore' to make sure
         * this new field displays at a particular place in the screens.
         */
        $this->add(new DummyAttribute(
            'comment',
            Attribute::AF_HIDE_LIST,
            "The demo will send mail to the address below!"
        ));
        $this->add(new EmailAttribute('email'));

        $this->add(new DateAttribute('hiredate'), 'default.contractinfo');
        $this->getAttribute('salary')->setSections(['default.contractinfo']);
    }

    public function adminFooter()
    {
        return nodeSourceUrl("Lesson4.Employee");
    }

    public function rowColor($record)
    {
        $manager_id = $record['manager']['id'];
        if ($manager_id!="") {
            $salary = $record['salary'];

            $managerNode = $this->getAttribute('manager')->getDestination();
            $managerRecord = $managerNode->select("id=$manager_id")->includes('salary')->getFirstRow();
            $managerSalary = $managerRecord['salary'];

            if ($salary > $managerSalary) {
                return '#ff0000';
            }
        }
    }

    /**
     * One of the application level triggers that is implemented, is a trigger
     * that is fired when adding a new record. By giving the method the name
     * 'postAdd', it is called automatically when a new record was added.
     * The record that was added is passed as a parameter to the method.
     */
    public function postAdd($record)
    {
        /**
         * First we check if an emailaddress was entered.
         */
        if ($record["email"]!='') {
            
            /**
             * If so, we sent a welcome message. In the welcome message, we
             * count the number of employees using the countDb method.
             */
            $num = $this->select()->getRowCount();
            $body = "Hi {$record["name"]},\n\nWelcome to the company and have a good time!\n\n".
                         "We now have {$num} employees\n";

            /**
             * Finally we use php's standard mail() method to send the email.
             * (for this to work, make sure emailsettings in your php.ini are
             * set correctly).
             */
            mail($record["email"], "Welcome", $body);
        }

        /**
         * If something went wrong in the postadd, we can return false, so the
         * complete add-transaction is rolled back (if the database driver
         * supports it). In this case, all went well, so we return true.
         */
        return true;
    }

    /**
     * The next trigger is fired when a record is updated. The updated
     * record is passed as a parameter.
     */
    public function postUpdate($record)
    {
        $newSalary = $record["salary"];

        /**
         * Remember the NF_TRACK_CHANGES we added in the atkNode call above?
         * This flag makes sure that the original, unmodified record, is passed
         * to the postUpdate method in the 'atkorgrec' field of the record.
         * We use this, to compare the new with the old salary.
         */
        $oldSalary = $record["atkorgrec"]["salary"];

        /**
         * If the salary was modified, and we know the employees' email,
         * we send a mail with the salary modification.
         */
        if ($record["email"]!='' && $newSalary!=$oldSalary) {
            $body = "Hi {$record["name"]},\n\n".
                "We ".($oldSalary>$newSalary?"lowered":"raised")." your salary with ".abs($newSalary-$oldSalary).".\n".
                "So your current salary is now: {$record["salary"]}\n";

            /**
             * Again, we use the php mail() method to mail the message.
             */
            mail($record["email"], "Salary changed", $body);
        }
        return true;
    }

    /**
     * The final record is the postDelete trigger, which is fired when a record
     * is deleted.
     * In this case, we send a goodby message.
     */
    public function postDelete($record)
    {
        if ($record["email"]!='') {
            $body = "Hi {$record["name"]}\n\nThanks for working at the company!";
            mail($record["email"], "Goodbye", $body);
        }
        return true;
    }
}
