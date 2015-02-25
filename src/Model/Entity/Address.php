<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Address Entity.
 */
class Address extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'street_address' => true,
        'city' => true,
        'zip_code' => true,
        'country' => true,
        'state' => true,
        'm_phone' => true,
        'f_phone' => true,
        'staff' => true,
    ];
}
