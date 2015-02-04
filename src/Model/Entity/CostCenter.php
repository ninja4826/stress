<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * CostCenter Entity.
 */
class CostCenter extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'e_code' => true,
        'description' => true,
        'active' => true,
        'def' => true,
        'project_number' => true,
    ];
}
