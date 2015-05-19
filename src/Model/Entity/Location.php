<?php
namespace App\Model\Entity;

use App\Model\Entity\AppEntity as Entity;

/**
 * Location Entity.
 */
class Location extends Entity
{
    
    protected function _getDisplayName() {
        return $this->location_name;
    }
    
    protected function _getDisplayField() {
        return 'location_name';
    }
    
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'isle' => true,
        'seg' => true,
        'shelf' => true,
        'box' => true,
        'location_name' => true,
        'parts' => true,
    ];
    
    public function __toString() {
        return $this->location_name;
    }
}
