<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Location Entity.
 */
class Location extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'isle' => true,
        'seg' => true,
        'shelf' => true,
        'box' => true,
        'location_name' => true,
        'parts' => true,
    ];
}
