<?php
namespace Workorders\Model\Entity;

use Cake\ORM\Entity;

/**
 * TaskType Entity.
 */
class TaskType extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'task_type' => true,
        'tasks' => true,
    ];
}
