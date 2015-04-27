<?php
namespace App\Model\Entity;

use App\Model\Entity\AppEntity as Entity;

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
        'vendor_name' => true,
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
