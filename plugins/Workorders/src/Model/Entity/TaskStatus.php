<?php
namespace Workorders\Model\Entity;

use Cake\ORM\Entity;

/**
 * TaskStatus Entity.
 */
class TaskStatus extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'task_status' => true,
        'wo_tasks' => true,
    ];
}
