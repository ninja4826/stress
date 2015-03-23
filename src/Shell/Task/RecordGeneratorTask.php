<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\I18n\Time;

class RecordGeneratorTask extends Shell {
    
    public function initialize() {
        parent::initialize();
        $this->loadModel('Categories');
        $this->loadModel('CostCenters');
        $this->loadModel('Locations');
        $this->loadModel('Manufacturers');
        $this->loadModel('Parts');
        $this->loadModel('Vendors');
        $this->loadModel('PartVendors');
        $this->loadModel('PartTransactions');
        $this->loadModel('PartPriceHistories');
        $this->loadModel('Staffs');
        $this->loadModel('Addresses');
        $this->loadModel('Users');
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
        
        /*
        
        $vendor = $this->Vendors->save($this->Vendors->newEntity([
            'vendor_name' => 'Mouser',
            'comment' => 'blank comment',
            'website' => 'http://mouser.com',
            'email' => 'employee@mouser.com',
            'active' => true
        ]));
        $this->out($vendor);
        
        $other_vendor = $this->Vendors->save($this->Vendors->newEntity([
            'vendor_name' => 'Newegg',
            'comment' => 'newegg shtuff',
            'website' => 'http://newegg.com',
            'email' => 'emp@newegg.com',
            'active' => true
        ]));
        $this->out($other_vendor);
        
        if ($part && $vendor) {
            $part_vendor = $this->PartVendors->save($this->PartVendors->newEntity([
                'part_id' => 1,
                'vendor_id' => 1,
                'markup' => 'not sure what markup is...',
                'discount' => '60',
                'preferred' => true
            ]));
            $this->out($part_vendor);
            if ($part_vendor) {
                $partTransaction = $this->PartTransactions->save($this->PartTransactions->newEntity([
                    'part_vendor_id' => 1,
                    'order_num' => 123456,
                    'date' => Time::now(),
                    'change_qty' => 20,
                    'price' => 1.5
                ]));
                $this->out($partTransaction);
            }
        }
        
        */
    }
}