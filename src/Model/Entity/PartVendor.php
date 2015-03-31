<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartVendor Entity.
 */
class PartVendor extends Entity
{

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
