<?php
namespace Workorders\Model\Entity;

use Cake\ORM\Entity;

/**
 * WoUpdateHistory Entity.
 */
class WoUpdateHistory extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'workorder_id' => true,
        'staff_id' => true,
        'date_modified' => true,
        'workorder' => true,
        'staff' => true,
    ];
}
