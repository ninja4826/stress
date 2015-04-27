<?php

use Phinx\Migration\AbstractMigration;

class Vendors extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-change-method
     *
     * Uncomment this method if you would like to use it.
     *
     */
     
    public function change()
    {
        if (!$this->hasTable('parts'))
        {
            return;
        }
        $table = $this->table('vendors');
        $table
            ->addColumn('vendor_name', 'string')
            ->addColumn('comment', 'string')
            ->addColumn('website', 'string')
            ->addColumn('email', 'string')
            ->addColumn('active', 'boolean')
            ->save();
        $table = $this->table('vendor_rates');
        $table
            ->addColumn('rate', 'decimal', ['precision' => 12, 'scale' => 2])
            ->save();
        $table = $this->table('part_vendors');
        $table
            ->addColumn('part_id', 'integer')
            ->addColumn('vendor_id', 'integer')
            ->addColumn('vendor_name', 'string')
            ->addColumn('markup', 'string')
            ->addColumn('discount', 'decimal', ['precision' => 12, 'scale' => 2])
            ->addColumn('preferred', 'boolean')
            ->addForeignKey('part_id', 'parts', 'id')
            ->addForeignKey('vendor_id', 'vendors', 'id')
            ->save();
        $table = $this->table('p_v_rates');
        $table
            ->addColumn('rate', 'decimal', ['precision' => 12, 'scale' => 2])
            ->save();
        $table = $this->table('p_v_rate_histories');
        $table
            ->addColumn('p_v_rate_id', 'integer')
            ->addColumn('part_vendor_id', 'integer')
            ->addColumn('date', 'datetime')
            ->addColumn('comment', 'string')
            ->addForeignKey('p_v_rate_id', 'p_v_rates', 'id')
            ->addForeignKey('part_vendor_id', 'part_vendors', 'id')
            ->save();
        $table = $this->table('part_price_histories');
        $table
            ->addColumn('part_vendor_id', 'integer')
            ->addColumn('date_changed', 'datetime')
            ->addColumn('price', 'decimal', ['precision' => 12, 'scale' => 2])
            ->addForeignKey('part_vendor_id', 'part_vendors', 'id')
            ->save();
        $table = $this->table('part_transactions');
        $table
            ->addColumn('part_vendor_id', 'integer')
            ->addColumn('order_num', 'integer')
            ->addColumn('date', 'datetime')
            ->addColumn('change_qty', 'integer')
            ->addColumn('price', 'decimal', ['precision' => 12, 'scale' => 2])
            ->addForeignKey('part_vendor_id', 'part_vendors', 'id')
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
