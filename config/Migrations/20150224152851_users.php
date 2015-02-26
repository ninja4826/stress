<?php

use Phinx\Migration\AbstractMigration;

class Users extends AbstractMigration
{
    
    public function change()
    {
        
        $permissions = $this->table('permissions');
        $permissions
            ->addColumn('user_id', 'integer', ['null' => true])
            ->addColumn('workorder_id', 'integer', ['null' => true])
            ->addColumn('can_edit', 'boolean', ['default' => false])
            ->save();
        
        if ($this->hasTable('staffs') && $this->hasTable('permissions')) {
            $users = $this->table('users');
            $users
                ->addColumn('username', 'string')
                ->addColumn('password', 'string')
                ->addColumn('staff_id', 'integer')
                ->addColumn('created', 'datetime')
                ->addColumn('modified', 'datetime')
                ->addForeignKey('staff_id', 'staffs', 'id')
                ->save();
        }
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