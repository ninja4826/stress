<?php
namespace App\Model\Entity;

// use Cake\ORM\Entity;
use App\Model\Entity\AppEntity as Entity;

/**
 * PartPriceHistory Entity.
 */
class PartPriceHistory extends Entity
{
    
    protected function _getDisplayName() {
        return $this->price;
    }
    
    protected function _getDisplayField() {
        return 'price';
    }

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'part_vendor_id' => true,
        'date_changed' => true,
        'price' => true,
        'part_vendor' => true,
    ];
}
