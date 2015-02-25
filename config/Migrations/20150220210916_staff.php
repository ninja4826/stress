<?php

use Phinx\Migration\AbstractMigration;

class Staff extends AbstractMigration
{
    public function change() {
        $address = $this->table('addresses');
        $address
            ->addColumn('street_address', 'string')
            ->addColumn('city', 'string')
            ->addColumn('zip_code', 'integer')
            ->addColumn('country', 'string')
            ->addColumn('state', 'string')
            ->addColumn('m_phone', 'string', ['null' => true])
            ->addColumn('f_phone', 'string', ['null' => true])
            ->save();
        $staff = $this->table('staffs');
        $staff
            ->addColumn('first_name', 'string')
            ->addColumn('last_name', 'string')
            ->addColumn('email', 'string')
            ->addColumn('active', 'boolean', ['default' => true])
            ->addColumn('address_id', 'integer')
            ->addForeignKey('address_id', 'addresses', 'id')
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