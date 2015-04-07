<?php

use Phinx\Migration\AbstractMigration;

class PurchaseOrder extends AbstractMigration
{
    public function change()
    {
        
        
        $table = $this->table('purchase_orders');
        $table
            ->addColumn('po_num', 'integer')
            ->addColumn('person_ordering', 'string')
            ->addColumn('project_number', 'integer')
            ->addColumn('date_ordered', 'date')
            ->addColumn('date_received', 'date')
            ->addColumn('comments', 'text')
            ->addColumn('completed', 'boolean')
            ->addColumn('vendor_id', 'integer')
            ->addColumn('order_num', 'string') // concatenates existing information to create readable format
            ->addColumn('order_data', 'string') // json format, containing part ids and quantitities for transactions upon completion
            ->addForeignKey('vendor_id', 'vendors', 'id')
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