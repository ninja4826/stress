<?php
namespace App\Model\Entity;

// use Cake\ORM\Entity;
use App\Model\Entity\AppEntity as Entity;

/**
 * PVRate Entity.
 */
class PVRate extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'rate' => true,
        'p_v_rate_histories' => true,
    ];
}
