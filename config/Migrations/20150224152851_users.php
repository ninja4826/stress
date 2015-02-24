<?php

use Phinx\Migration\AbstractMigration;

class Users extends AbstractMigration
{
    
    public function change()
    {
        $roles = $this->table('roles');
        $roles
            ->addColumn('role_name', 'string')
            ->save();
        
        if ($this->hasTable('staff') && $this->hasTable('roles')) {
            $users = $this->table('users');
            $users
                ->addColumn('username', 'string')
                ->addColumn('password', 'string')
                ->addColumn('staff_id', 'integer')
                ->addColumn('role_id', 'integer')
                ->addColumn('created', 'datetime')
                ->addColumn('modified', 'datetime')
                ->addForeignKey('staff_id', 'staff', 'id')
                ->addForeignKey('role_id', 'roles', 'id')
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