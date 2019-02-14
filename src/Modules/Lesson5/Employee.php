<?php
namespace App\Modules\Lesson5;

/**
 * This node is similar to the employee node of lesson 4.
 *
 * The addition in this lesson is the loginname ('employeeid' in this
 * case), and a password.
 *
 * ATK supports many security schemes. In this case, we choose an employee
 * as login, and each employee has a profile to determine his access rights.
 * We have to tell ATK how we arranged security, so in the configuration
 * file, you will find the following config entries:
 *
 * 'auth_usernode' => 'Lesson5.employee',
 *
 * 'auth_usertable' => 'lesson5_employee',
 * 'auth_userfield' => 'login',
 * 'auth_passwordfield' => 'password',
 *
 * 'auth_leveltable' => 'lesson5_employee',
 * 'auth_levelfield' => 'profile_id',
 * 'auth_accesstable' => 'lesson5_accessright',
 *
 * When you give users in the employee table a login, a password and a
 * profile, they can login, and execute those screens that you granted
 * them access to. You will notice that lesson 1 to 4 will disappear for
 * new users, since we never configured access rights for any of them,
 * so only the administrator user (who always has full access) can access
 * those lessons.
 */
use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Attributes\CurrencyAttribute;
use Sintattica\Atk\Attributes\DateAttribute;
use Sintattica\Atk\Attributes\DummyAttribute;
use Sintattica\Atk\Attributes\EmailAttribute;
/**
 * The password attribute can be used to enter passwords.
 */
use Sintattica\Atk\Attributes\PasswordAttribute;
use Sintattica\Atk\Attributes\TextAttribute;
use Sintattica\Atk\Relations\ManyToOneRelation;
use function App\Modules\Lesson_utils\nodeSourceUrl;

class Employee extends Node
{
    public function __construct($nodeUri)
    {
        /**
         * Another flag is introduced in this lesson. It's NF_MRA, which is
         * short for NF_MULTI_RECORD_ACTIONS. By setting this flag, a list of
         * checkboxes appears next to the records, and multiple records can now
         * be deleted all at once.
         */
        parent::__construct($nodeUri, Node::NF_ADD_LINK | Node::NF_TRACK_CHANGES | Node::NF_MRA);
        $this->setTable('lesson5_employee');
        $this->setDescriptorTemplate('[name]');
        //$this->setIndex('name');
        $this->setOrder('name');

        $this->add(new Attribute('id', Attribute::AF_AUTOKEY));
        /**
         * The login field is the field used to login to the application.
         */
        $this->add(new Attribute('login', Attribute::AF_OBLIGATORY|Attribute::AF_UNIQUE|Attribute::AF_HIDE_LIST));
        $this->add(new Attribute('name', Attribute::AF_SEARCHABLE|Attribute::AF_UNIQUE));
        
        /**
         * The following line adds the password attribute. The flag
         * AF_PASSWORD_NOVALIDATE has the effect that to change someones'
         * password, we don't need to enter the original password first. This
         * is useful for administrators.
         * Should this be a screen that users can edit themselves, this flag
         * could be removed, and then a user can only change his password if he
         * enters the original password first.
         */
        $this->add(new PasswordAttribute(
            'password',
            Attribute::AF_HIDE_LIST|PasswordAttribute::AF_PASSWORD_NO_VALIDATE,
            true
        ));
        
        $this->add(new DummyAttribute(
            'comment',
            Attribute::AF_HIDE_LIST,
            "The demo will send mail to the address below!"
        ));
        $this->add(new EmailAttribute('email'));
        $this->add(new ManyToOneRelation('department', Attribute::AF_SEARCHABLE, 'Lesson5.department'));
        $this->add(new ManyToOneRelation(
            'manager',
            Attribute::AF_SEARCHABLE|ManyToOneRelation::AF_RELATION_AUTOCOMPLETE,
            'Lesson5.employee'
        ));
        $this->add(new DateAttribute('hiredate'), 'default.contractinfo');
        $this->add(new CurrencyAttribute('salary', Attribute::AF_TOTAL, '€'), 'default.contractinfo');
        $this->add(new TextAttribute("notes", AF_HIDE_LIST));
        
        /**
         * In the profile_id field, we store the employee profile.
         *
         * We've already seen the many2onerelation, but what's new here is the
         * AF_RELATION_AUTOLINK flag. This flag makes direct links to the
         * profile editor. Next to the dropdown for selecting a profile, there
         * are now links for editing the current profile, or adding a new one.
         */
        $this->add(new ManyToOneRelation(
            "profile_id",
            ManyToOneRelation::AF_RELATION_AUTOLINK | Attribute::AF_HIDE_ADD,
            'Lesson5.profile'
        ));
    }

    public function adminFooter()
    {
        return nodeSourceUrl("Lesson5.Employee");
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
    
    public function postAdd($record, $mode = 'add')
    {
        if ($record["email"]!='') {
            $num = $this->select()->getRowCount();
            $body = "Hi {$record["name"]},\n\nWelcome to the company and have a good time!\n\n".
                         "We now have {$num} employees\n";
            mail($record["email"], "Welcome", $body);
        }
        return true;
    }

    public function postUpdate($record)
    {
        $newSalary = $record["salary"];
        $oldSalary = $record["atkorgrec"]["salary"];

        if ($record["email"]!='' && $newSalary!=$oldSalary) {
            $body = "Hi {$record["name"]},\n\n".
                "We ".($oldSalary>$newSalary?"lowered":"raised")." your salary with ".abs($newSalary-$oldSalary).".\n".
                "So your current salary is now: {$record["salary"]}\n";

            mail($record["email"], "Salary changed", $body);
        }
        return true;
    }

    public function postDelete($record)
    {
        if ($record["email"]!='') {
            $body = "Hi {$record["name"]}\n\nThanks for working at the company!";
            mail($record["email"], "Goodbye", $body);
        }
        return true;
    }
}
