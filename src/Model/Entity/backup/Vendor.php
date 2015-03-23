<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Vendor Entity.
 */
class Vendor extends Entity
{

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
