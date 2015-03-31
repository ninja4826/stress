<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * VendorRate Entity.
 */
class VendorRate extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'rate' => true,
    ];
}
