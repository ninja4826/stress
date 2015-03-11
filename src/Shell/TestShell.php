<?php

namespace App\Shell;

use Cake\Console\Shell;

class TestShell extends shell {
    public function main() {
        shell_exec('touch asdfasdf');
    }
}