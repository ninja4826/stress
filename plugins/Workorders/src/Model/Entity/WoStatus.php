<?php
namespace Workorders\Model\Entity;

use Cake\ORM\Entity;

/**
 * WoStatus Entity.
 */
class WoStatus extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'wo_status' => true,
        'workorders' => true,
    ];
}
