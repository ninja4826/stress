<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\Log\Log;

/**
 * Staff Entity.
 */
class Staff extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'first_name' => true,
        'last_name' => true,
        'full_name' => true,
        'email' => true,
        'active' => true,
        'address_id' => true,
        'address' => true,
        'user' => true
    ];
}