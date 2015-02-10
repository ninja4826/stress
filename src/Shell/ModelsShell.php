<?php
namespace App\Shell;

use Cake\Console\Shell;

class ModelsShell extends Shell
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Categories');
        $this->loadModel('CostCenters');
        $this->loadModel('Locations');
        $this->loadModel('Manufacturers');
        $this->loadModel('Parts');
        $this->loadModel('Vendors');
        $this->loadModel('PartVendors');
    }
    
    public function main()
    {
        $category = $this->Categories->save($this->Categories->newEntity([
            'category_name' => 'Relays'
        ]));
        $this->out($category);
        
        $cost_center = $this->CostCenters->save($this->CostCenters->newEntity([
            'e_code' => 'E9000',
            'description' => 'cost center description',
            'active' => true,
            'default_value' => 'not sure what this is for',
            'project_number' => 9110343
        ]));
        $this->out($cost_center);
        
        $location = $this->Locations->save($this->Locations->processName([
            'location_name' => 'G1C2'
        ]));
        $this->out($location);
        
        $manufacturer = $this->Manufacturers->save($this->Manufacturers->newEntity([
            'manufacturer_name' => 'Phoenix Contact',
            'active' => true
        ]));
        $this->out($manufacturer);
        
        if ($category && $cost_center && $location && $manufacturer)
        {
            $part = $this->Parts->save($this->Parts->newEntity([
                'part_num' => 'SN74S74N',
                'description' => 'Dual flip flop relay and stuff',
                'amt_on_hand' => 5,
                'active' => true,
                'manufacturer_id' => 1,
                'category_id' => 1,
                'cc_id' => 1,
                'location_id' => 1
            ]));
            $this->out($part);
        }
    }
}