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
        $db = $this->params['database'];
        
        $this->out('Dropping database "' . $db . '"');
        $this->conn->query("DROP DATABASE IF EXISTS " . $db);
        $this->out('Database "' . $db . '" has been dropped.');
        $this->out('Creating database "' . $db . '"');
        $this->conn->query("CREATE DATABASE " . $db);
        $this->out('Database "' . $db . '" has been created.');
        
        if ($this->params['migrate'] || $this->params['fill']) {
            $mig = ROOT . '/bin/cake migrations ';
            $this->out(shell_exec($mig . 'migrate'), 1, Shell::VERBOSE);
            $this->out(shell_exec($mig . 'status'), 1, Shell::VERBOSE);
            $this->out('Migrations are done.');
        }
        $this->out('Database has been cleaned.', 1, Shell::QUIET);
        
        if ($this->params['fill']) {
            $this->RecordGenerator->main();
        }
    }
    
    public function getOptionParser() {
        $parser = parent::getOptionParser();
        $parser->addOption('migrate', [
            'short' => 'm',
            'help' => 'Run migrations to recreate database after deletion.',
            'boolean' => true
        ]);
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
        ]);
        return $parser;
    }
}