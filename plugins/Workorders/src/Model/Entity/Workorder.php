<?php
namespace Workorders\Model\Entity;

use Cake\ORM\Entity;

/**
 * Workorder Entity.
 */
class Workorder extends Entity
{

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'date_received' => true,
        'date_required' => true,
        'expedite' => true,
        'description' => true,
        'location' => true,
        'date_signed' => true,
        'fixed_price' => true,
        'date_promised' => true,
        'est_time' => true,
        'wo_status_id' => true,
        'wo_type_id' => true,
        'project_number' => true,
        'pm_id' => true,
        'req_id' => true,
        'wo_req' => true,
        'wo_status' => true,
        'wo_type' => true,
        'project_number' => true,
        'requestor' => true,
        'permissions' => true,
        'wo_tasks' => true,
        'wo_update_histories' => true,
    ];
}
