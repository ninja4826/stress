<?php
namespace App\Model\Entity;

use App\Model\Entity\AppEntity as Entity;

/**
 * CostCenter Entity.
 */
class CostCenter extends Entity
{
    protected function _getDisplayName() {
        return $this->e_code;
    }
    
    protected function _getDisplayField() {
        return 'e_code';
    }
    
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'e_code' => true,
        'description' => true,
        'active' => true,
        'default_value' => true,
        'project_number' => true,
    ];
}
