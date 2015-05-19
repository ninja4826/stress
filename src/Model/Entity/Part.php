<?php
namespace App\Model\Entity;

use App\Model\Entity\AppEntity as Entity;

/**
 * Part Entity.
 */
class Part extends Entity
{
    
    // protected $_virtual = ['display_name'];
    
    protected function _getDisplayName() {
        return $this->part_num;
    }
    
    protected function _getDisplayField() {
        return 'part_num';
    }

    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * @var array
     */
    protected $_accessible = [
        'category_id' => true,
        'part_num' => true,
        'description' => true,
        'amt_on_hand' => true,
        'location_name' => true,
        'location_id' => true,
        'active' => true,
        'cc_id' => true,
        // 'manufacturers' => true,
        'manufacturer_id' => true,
        'category' => true,
        'cost_center' => true
    ];
}
