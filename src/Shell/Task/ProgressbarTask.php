<?php
namespace App\Shell\Task;

use Cake\Console\Shell;

class ProgressbarTask extends Shell {
    public function initialize() {
        parent::initialize();
    }
    
    public function main() {
    }
    
    public function init($total) {
        $this->i = 0;
        $this->total = $total;
        $this->label = "";
    }
    
    public function add() {
        $this->i++;
        $this->progressBar();
    }
    
    // function progressBar($current, $total, $label) {
    public function progressBar() {
        
        $current = $this->i;
        $total = $this->total;
        $label = $this->label;
        
        // This function assumes that you start with completion of 0%. 
         
        // If the first time you call this function is with 1% 
        // completion, you will delete the last 106 characters of 
        // output from your program. 
         
        // If this is the case, simply call this function before with 
        // a hard coded 0. 
         
        // check to see if this is the first go-round 
        if ($current == 0) 
        { 
            // this is the first time so output the progess bar label 
            if ($label == "") 
                echo "Progress: "; 
            else if ($label != "none") 
                echo $label; 
             
            // start the bar with a nice edge 
            echo "|"; 
        } 
        else 
        { 
            // this isn't the first time so remove the previous progress bar 
            for ($place = 106; $place >= 0; $place--) 
            { 
                // echo a backspace to remove the previous character 
                echo "\010"; 
            } 
        } 
         
        // output the progess bar as it should be 
        for ($place = 0; $place <= 100; $place++) 
        { 
            // output stars if we're finished through this point 
            // or spaces if not 
            if ($place <= ($current / $total * 100)) 
                echo "*"; 
            else 
                echo " "; 
        } 
         
        // end the bar with a nice edge and a label 
        echo "| 100%"; 
         
        // check to see if this is the last go-round 
        if ($current == $total) 
        { 
            // this is the end of the progress bar, output an end of line 
            echo "\n"; 
        } 
    }  
}