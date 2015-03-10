<?php
namespace App\Model\Entity;

use App\Model\Entity\AppEntity as Entity;

/**
 * Category Entity.
 */
class Category extends Entity
{
    
    protected function _getDisplayName() {
        return $this->category_name;
    }

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'category_name' => true,
    ];
}
