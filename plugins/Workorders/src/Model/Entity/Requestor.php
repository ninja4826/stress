<?php
namespace Workorders\Model\Entity;

use Cake\ORM\Entity;

/**
 * Requestor Entity.
 */
class Requestor extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'name' => true,
        'extension' => true,
    ];
}
