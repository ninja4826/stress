<?php

use Phinx\Migration\AbstractMigration;

class Warnings extends AbstractMigration
{
    
    public function change()
    {
        if (!$this->hasTable('parts')) {
            return;
        }
        
        $warnings = $this->table('warnings');
        $warnings
            ->addColumn('part_id', 'integer')
            ->addColumn('minimum', 'integer')
            ->addColumn('target', 'integer')
            ->addForeignKey('part_id', 'parts', 'id')
            ->save();
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
    
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}