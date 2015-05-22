<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\I18n\Time;
use Cake\Cache\Cache;

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
        $this->loadModel('PVRateHistories');
        $this->loadModel('PVRates');
    }
    
    public function main()
    {
        Cache::clear(false);
        
        $category = $this->Categories->save($this->Categories->newEntity([
            'category_name' => 'Relays'
        ]));
        
        $cost_center = $this->CostCenters->save($this->CostCenters->newEntity([
            'e_code' => 'E9000',
            'description' => 'cost center description',
            'active' => true,
            'default_value' => 0.5,
            'project_number' => 9110343
        ]));
        
        $manufacturer = $this->Manufacturers->newEntity([
            'manufacturer_name' => 'Phoenix Contact',
            'active' => true
        ]);
        $this->Manufacturers->save($manufacturer);
        
        $part = $this->Parts->save($this->Parts->newEntity([
            'part_num' => 'SN74S74N',
            'description' => 'Dual flip flop relay and stuff',
            'amt_on_hand' => 5,
            'active' => true,
            'category_id' => 1,
            'cc_id' => 1,
            'manufacturer_id' => 1,
            'location_name' => 'G1C2'
        ]));
        
        $vendor = $this->Vendors->save($this->Vendors->newEntity([
            'vendor_name' => 'Mouser',
            'comment' => 'blank comment',
            'website' => 'http://mouser.com',
            'email' => 'employee@mouser.com',
            'active' => true
        ]));
        
        $other_vendor = $this->Vendors->save($this->Vendors->newEntity([
            'vendor_name' => 'Newegg',
            'comment' => 'newegg shtuff',
            'website' => 'http://newegg.com',
            'email' => 'emp@newegg.com',
            'active' => true
        ]));
        
        if ($part && $vendor) {
            $part_vendor = $this->PartVendors->save($this->PartVendors->newEntity([
                'part_id' => 1,
                'vendor_id' => 1,
                'markup' => 'not sure what markup is...',
                'discount' => 0.6,
                'preferred' => true
            ]));
            if ($part_vendor) {
                $partTransaction = $this->PartTransactions->save($this->PartTransactions->newEntity([
                    'part_vendor_id' => 1,
                    'order_num' => 123456,
                    'date' => Time::now(),
                    'change_qty' => 20,
                    'price' => 1.5
                ]));
                
                $partPriceHistories = $this->PartPriceHistories->save($this->PartPriceHistories->newEntity([
                    'date_changed' => '',   // TODO: DATE STUFF
                    'price' => 5.25
                ]));
                
                $p_v_rate_histories = $this->PVRateHistories->save($this->PVRateHistories->newEntity([
                    'part_vendor_id' => 1,
                    'rate' => 0.45,
                    'date' => Time::now(),
                    'comment' => 'I just want this to be done.'
                ]));
            }
        }
    }
}