<?php
namespace App\Shell;

use Cake\Console\Shell;

/**
 * Blah shell command.
 */
class LoadTestShell extends Shell
{
    
    public $tasks = ['LoadTest'];

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main() {
        $this->out(json_encode($this->args));
        $model = $this->args[0];
        $display_field = $this->args[1];
        $iter = $this->args[2];
        if (!($model && $display_field && $iter)) {
            $this->out('Cannot continue');
            return;
        }
        $this->LoadTest->start($model, $display_field, $iter);
    }
    
    public function getOptionParser() {
        $parser = parent::getOptionParser();
        $parser
            ->addArgument('model', [
                'help' => 'The model to use.',
                'required' => true
            ])->addArgument('display_field', [
                'help' => 'The field to use as a unique identifier.',
                'required' => true
            ])->addArgument('iterations', [
                'help' => 'The number of iterations to run.',
                'required' => true
            ]);
        return $parser;
    }
}
