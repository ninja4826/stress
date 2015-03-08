<?php
namespace Workorders\Model\Entity;

use Cake\ORM\Entity;

/**
 * Task Entity.
 */
class Task extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'task_type_id' => true,
        'name' => true,
        'description' => true,
        'active' => true,
        'task_type' => true,
    ];
}
