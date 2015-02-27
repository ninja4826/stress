<?php
namespace Workorders\Model\Entity;

use Cake\ORM\Entity;

/**
 * WoTaskUpdateHistory Entity.
 */
class WoTaskUpdateHistory extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'wo_task_id' => true,
        'staff_id' => true,
        'update_type' => true,
        'date_modified' => true,
        'wo_task' => true,
        'staff' => true,
    ];
}
