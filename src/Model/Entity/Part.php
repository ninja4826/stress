<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Part Entity.
 */
class Part extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'manufacturer_id' => true,
        'category_id' => true,
        'part_num' => true,
        'description' => true,
        'amt_on_hand' => true,
        'location_id' => true,
        'active' => true,
        'cc_id' => true,
        'manufacturer' => true,
        'category' => true,
        'location' => true,
        'cc' => true,
    ];
}
