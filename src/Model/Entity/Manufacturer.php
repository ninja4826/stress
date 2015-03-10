<?php
namespace App\Model\Entity;

use App\Model\Entity\AppEntity as Entity;

/**
 * Manufacturer Entity.
 */
class Manufacturer extends Entity
{
    
    protected function _getDisplayName() {
        return $this->manufacturer_name;
    }

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'manufacturer_name' => true,
        'active' => true,
    ];
}
