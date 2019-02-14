<?php
namespace App\Modules\Lesson5;

/**
 * This node is new. It is used to edit profiles. A profile is a set of user
 * privileges. In this scenario, each user has one profile (many-to-one
 * relation).
 */
use Sintattica\Atk\Core\Node;
use Sintattica\Atk\Core\Tools;
use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Attributes\DummyAttribute;
/**
 * The profileattribute can be used to edit the privileges.
 */
use Sintattica\Atk\Attributes\ProfileAttribute;
use Sintattica\Atk\Relations\ManyToOneRelation;
use function App\Modules\Lesson_utils\nodeSourceUrl;

class Profile extends Node
{
    public function __construct($nodeUri)
    {
        parent::__construct($nodeUri, Node::NF_EDITAFTERADD);
        $this->setTable("lesson5_profile");
        $this->setOrder("name");
        $this->setDescriptorTemplate("[name]");

        $this->add(new Attribute("id", Attribute::AF_AUTOKEY));
        $this->add(new Attribute("name", Attribute::AF_OBLIGATORY|Attribute::AF_UNIQUE|Attribute::AF_SEARCHABLE, 50));

        /**
         * In lesson4, we already encountered the dummy attribute to display a
         * text. In this lesson, we do the same, but this time we use the atktext()
         * method to internationalize the text. See the en.lng file in the
         * languages/ subdirectory of lesson5, so you can see how the atktext()
         * method translates the string to an actual text.
         */
        $this->add(new DummyAttribute(
            "profile_explanation",
            Attribute::AF_HIDE_LIST|Attribute::AF_HIDE_ADD,
            Tools::atktext("profile_explanation", "Lesson5")
        ));

        /**
         * The profile attribute edits all application access privileges. The
         * privileges that exist are loaded from the Module.php files. See
         * this modules' Module.php file for an example.
         */
        $this->add(new ProfileAttribute("accessrights", Attribute::AF_HIDE_ADD|Attribute::AF_BLANKLABEL));
    }

    public function adminFooter()
    {
        return nodeSourceUrl("Lesson5.Profile");
    }
}
