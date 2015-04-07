<?php
namespace App\Model\Entity;

// use Cake\ORM\Entity;
use App\Model\Entity\AppEntity as Entity;

/**
 * PVRateHistory Entity.
 */
class PVRateHistory extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'p_v_rate_id' => true,
        'part_vendor_id' => true,
        'date' => true,
        'comment' => true,
        'p_v_rate' => true,
        'part_vendor' => true,
    ];
}
