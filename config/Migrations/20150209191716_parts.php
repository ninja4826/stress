<?php

use Phinx\Migration\AbstractMigration;

class Parts extends AbstractMigration
{
    
    public function change()
    {
        
        $table = $this->table('categories');
        $table
            ->addColumn('category_name', 'string')
            ->save();
        $table = $this->table('cost_centers');
        $table
            ->addColumn('e_code', 'string')
            ->addColumn('description', 'string', ['null' => true])
            ->addColumn('active', 'boolean')
            ->addColumn('default_value', 'string')
            ->addColumn('project_number', 'integer')
            ->save();
        $table = $this->table('locations');
        $table
            ->addColumn('isle', 'string')
            ->addColumn('seg', 'integer')
            ->addColumn('shelf', 'string')
            ->addColumn('box', 'integer')
            ->addColumn('location_name', 'string')
            ->save();
        $table = $this->table('manufacturers');
        $table
            ->addColumn('manufacturer_name', 'string')
            ->addColumn('active', 'boolean')
            ->save();
        $table = $this->table('parts');
        $table
            ->addColumn('part_num', 'string')
            ->addColumn('description', 'string')
            ->addColumn('amt_on_hand', 'integer')
            ->addColumn('active', 'boolean')
            // ->addColumn('manufacturer_id', 'integer')
            // ->addForeignKey('manufacturer_id', 'manufacturers', 'id')
            ->addColumn('category_id', 'integer')
            ->addForeignKey('category_id', 'categories', 'id')
            ->addColumn('cc_id', 'integer')
            ->addForeignKey('cc_id', 'cost_centers', 'id')
            ->addColumn('location_id', 'integer')
            ->addForeignKey('location_id', 'locations', 'id')
            ->save();
        $table = $this->table('parts_manufacturers');
        $table
            ->addColumn('part_id', 'integer')
            ->addForeignKey('part_id', 'parts', 'id')
            ->addColumn('manufacturer_id', 'integer')
            ->addForeignKey('manufacturer_id', 'manufacturers', 'id')
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