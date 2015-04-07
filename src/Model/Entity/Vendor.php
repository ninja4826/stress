<?php
namespace App\Model\Entity;

// use Cake\ORM\Entity;
use App\Model\Entity\AppEntity as Entity;

/**
 * Vendor Entity.
 */
class Vendor extends Entity
{
    
    protected function _getDisplayName() {
        return $this->vendor_name;
    }
    
    protected function _getDisplayField() {
        return 'vendor_name';
    }

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'vendor_name' => true,
        'comment' => true,
        'website' => true,
        'email' => true,
        'active' => true,
    ];
}
