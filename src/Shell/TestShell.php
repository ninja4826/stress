<?php

namespace App\Shell;

use Cake\Console\Shell;

class TestShell extends Shell {
    private $chars = 'abcdefghijklmnopqrstuvwxyz';
    private $strings = [];
    
    private $stop = 1000;
    
    public $tasks = ['Bogus'];
    
    public function initialize() {
        $this->loadModel('Parts');
    }
    
    public function main() {
        ini_set('memory_limit', '512M');        
        $this->strings = $this->randomString();
        $this->out('');
        $this->out('');
        $this->out('CREATED STRINGS');
        $this->out('');
        $this->out('');
        $this->randomTest();
        $this->out('');
        $this->out('');
        $this->out('All done creating items!');
        $this->testSelect();
        
    }
    public function randomTest() {
        for ($r = 0; $r < $this->stop; $r++) {
            $part_ = [
                'part_num' => $this->strings[$r],
                'description' => 'benchmark test, please ignore.',
                'amt_on_hand' => 1337,
                'active' => true,
                'manufacturer_id' => 1,
                'category_id' => 1,
                'cc_id' => 1,
                'location_name' => 'G1C2'
            ];
            $part = $this->Parts->newEntity($part_);
            if ($this->Parts->save($part)) {
                
                $this->out('Made part #: '.$part->id);
                $this->out('Part Number: '.$part->part_num);
		        $percent = ($r / $this->stop) * 100;
		        $this->out('#'.$r.' out of '.$this->stop);
                $this->out('Done: '.$percent.'%');
                $this->out('');
                
            } else {
                $this->out('Something went wrong...');
                break;
            }
        }
    }
    
    public function testSelect() {
        $start = microtime(true);
        $parts = $this->Parts->find('all', ['contain' => $this->Parts->assocs])->toArray();
        // $this->out($parts);
        $diff = microtime(true) - $start;
        $this->out('Microseconds: '.$diff);
        $this->out('Parts: '.count($parts));
    }
    
    public function randomString() {
        $str_arr = [];
        for ($i = 0; $i < $this->stop; $i++) {
            $existing = true;
            while ($existing) {
                $str = '';
                for ($c = 0; $c < 200; $c++) {
                    $str .= $this->chars[rand(0, strlen($this->chars) - 1)];
                }
                if (!in_array($str, $str_arr)) {
                    $str_arr[] = $str;
                    $this->out('Iteration: '.$i);
                    $this->out('String: '.$str);
                    $existing = false;
                } else {
                    $this->out('Shit.');
                }
            }
        }
        return $str_arr;
    }
}
