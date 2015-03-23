<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartPriceHistory Entity.
 */
class PartPriceHistory extends Entity
{

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
