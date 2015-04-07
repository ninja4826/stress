<?php
namespace App\Model\Entity;

// use Cake\ORM\Entity;
use App\Model\Entity\AppEntity as Entity;
use Cake\ORM\TableRegistry;

/**
 * PartVendor Entity.
 */
class PartVendor extends Entity
{
    
    protected function _getLatestPrice() {
        return $this->part_price_histories[0];
    }

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'part_id' => true,
        'vendor_id' => true,
        'markup' => true,
        'discount' => true,
        'preferred' => true,
        'part' => true,
        'vendor' => true,
        'p_v_rate_histories' => true,
        'part_price_histories' => true,
        'part_transactions' => true,
    ];
}
