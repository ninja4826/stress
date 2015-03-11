<?php

use Phinx\Migration\AbstractMigration;

class Buffer extends AbstractMigration
{
    public function change()
    {
        if (!$this->hasTable('parts')) {
            return;
        }
        
        $buffer = $this->table('buffer');
        $buffer
            ->addColumn('part_id', 'integer')
            ->addColumn('quantity', 'integer')
            ->addColumn('workorder', 'integer', ['null' => true])
            ->addColumn('requestor', 'string', ['null' => true])
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