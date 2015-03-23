<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartTransaction Entity.
 */
class PartTransaction extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'part_vendor_id' => true,
        'order_num' => true,
        'date' => true,
        'change_qty' => true,
        'price' => true,
        'part_vendor' => true,
    ];
}
