<?php
namespace App\Modules\Lesson7;

use Sintattica\Atk\Attributes\Attribute;
use Sintattica\Atk\Attributes\NumberAttribute;
use Sintattica\Atk\Attributes\TextAttribute;
use function App\Modules\Lesson_utils\nodeSourceUrl;
/**
 * This node introduces the TreeNode. The TreeNode is an Node
 * specialisation that is created for handling data that has a hierarchical
 * structure. The adminpage is rendered as a tree instead of a recordlist,
 * to reflect the data's hierarchical structure.
 *
 * We deviate from the default employee example here because a
 * 'category' (for example product category) is more intuitive when
 * thinking of trees.
 */
use Sintattica\Atk\Core\TreeNode;
/**
 * Also, this node introduces the ManyToOneTreeRelation. It is similar
 * to the regular ManyToOneRelation as seen in the previous lessons,
 * but it is especially suited to create a relation to TreeNodes. It
 * renders the dropdown box in a tree-like fashion to reflect the data
 * structure.
 * In this example lesson, we use this relation to select a new parent
 * for a record.
 */
use Sintattica\Atk\Relations\ManyToOneTreeRelation;

class Category extends TreeNode
{
    public function __construct($nodeUri)
    {
        /**
         * The NF_TREE_* flags are specifically designed to tweak behaviour of
         * the tree. NF_TREE_NO_ROOT_COPY establishes that root items can not be
         * copied. NF_TREE_NO_ROOT_DELETE disables deletion of tree root items.
         */
        parent::__construct(
            $nodeUri,
            TreeNode::NF_COPY|TreeNode::NF_TREE_NO_ROOT_COPY|TreeNode::NF_TREE_NO_ROOT_DELETE|TreeNode::NF_ADD_LINK
        );
        $this->setTable('lesson7_category');
        $this->setDescriptorTemplate('[title]');
        
        $this->add(new Attribute('cat_id', Attribute::AF_AUTOKEY));
        $this->add(new Attribute('title', Attribute::AF_SEARCHABLE|Attribute::AF_OBLIGATORY));
        $this->add(new ManyToOneTreeRelation('parent_cat_id', Attribute::AF_PARENT, 'Lesson7.category', 'cat_id'));
    }

    public function adminFooter()
    {
        return nodeSourceUrl("Lesson7.Category");
    }
}
