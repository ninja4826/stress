<?php
namespace Workorders\Model\Entity;

use Cake\ORM\Entity;

/**
 * PartTask Entity.
 */
class PartTask extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'quantity' => true,
        'task_date' => true,
        'part_id' => true,
        'part' => true,
    ];
}
