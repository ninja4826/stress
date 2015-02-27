<?php
namespace Workorders\Model\Entity;

use Cake\ORM\Entity;

/**
 * WoTask Entity.
 */
class WoTask extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'workorder_id' => true,
        'staff_id' => true,
        'task_status_id' => true,
        'task_id' => true,
        'workorder' => true,
        'staff' => true,
        'task_status' => true,
        'task' => true,
        'wo_task_update_histories' => true,
    ];
}
