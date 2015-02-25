<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\Datasource\ConnectionManager;

class DbCleanShell extends Shell {
    
    public $tasks = ['RecordGenerator'];
    
    private $conn;
    public function initialize() {
        parent::initialize();
        $this->conn = ConnectionManager::get('db_manage');
    }
    
    public function main() {
        // $db = $this->params['database'];
        
        // $this->out('Dropping database "' . $db . '"');
        // $this->conn->query("DROP DATABASE IF EXISTS " . $db);
        
        // $this->out('Database "' . $db . '" has been dropped.');
        // $this->out('Creating database "' . $db . '"');
        // $this->conn->query("CREATE DATABASE " . $db);
        // $this->out('Database "' . $db . '" has been created.');
        
        // if ($this->params['migrate'] || $this->params['fill']) {
        //     $mig = ROOT . '/bin/cake migrations ';
        //     $mig_command = $mig . 'migrate';
        //     $stat_command = $mig . 'status';
        //     if (array_key_exists('plugin', $this->params)) {
        //         $new_command = ' -c ' . $db . ' -p ' . $this->params['plugin'];
        //         $mig_command .= $new_command;
        //         $stat_command .= $new_command;
        //     }
        //     $this->out(shell_exec($mig_command), 1, Shell::VERBOSE);
        //     $this->out(shell_exec($stat_command), 1, Shell::VERBOSE);
        //     $this->out('Migrations are done.');
        // }
        // $this->out('Database has been cleaned.', 1, Shell::QUIET);
        
        // if ($this->params['fill']) {
        //     $this->RecordGenerator->main();
        // }
        
        $this->conn->query("DROP DATABASE IF EXISTS workorder");
        $this->conn->query("DROP DATABASE IF EXISTS stress");
        $this->conn->query("CREATE DATABASE stress");
        $this->conn->query("CREATE DATABASE workorder");
        
        $mig = ROOT . '/bin/cake migrations ';
        $this->out(shell_exec($mig . 'migrate'));
        $this->out(shell_exec($mig . 'migrate -c workorder -p Workorder'));
        $this->RecordGenerator->main();
    }
    
    public function getOptionParser() {
        $parser = parent::getOptionParser();
        $default_db = ConnectionManager::get('default')->config()['database'];
        $parser->addOptions([
            'database' => [
                'short' => 'd',
                'help' => 'The name of the database to be cleaned.',
                'default' => $default_db
            ],
            'migrate' => [
                'short' => 'm',
                'help' => 'Run migrations to recreate database after deletion.',
                'boolean' => true
            ],
            'fill' => [
                'short' => 'f',
                'help' => 'Fill the database after migration.',
                'boolean' => true
            ],
            'plugin' => [
                'short' => 'p',
                'help' => 'Specify the plugin to migrate.',
            ]
        ]);
        return $parser;
    }
}