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
        $db = ConnectionManager::get('default')->config()['database'];
        $this->conn->query("DROP DATABASE IF EXISTS ".$db);
        $this->conn->query("CREATE DATABASE ".$db);
        
        $mig = ROOT . '/bin/cake migrations ';
        $this->out(shell_exec($mig . 'migrate'));
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