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
            ->addColumn('manufacturer_id', 'integer')
            ->addForeignKey('manufacturer_id', 'manufacturers', 'id')
            ->addColumn('category_id', 'integer')
            ->addForeignKey('category_id', 'categories', 'id')
            ->addColumn('cc_id', 'integer')
            ->addForeignKey('cc_id', 'cost_centers', 'id')
            ->addColumn('location_id', 'integer')
            ->addForeignKey('location_id', 'locations', 'id')
            ->save();
        
        $tables = [
            'parts' => [
                'part_num',
                'description'
            ],
            'categories' => [
                'category_name'
            ],
            'cost_centers' => [
                'description'
            ],
            'locations' => [
                'location_name'
            ],
            'manufacturers' => [
                'manufacturer_name'
            ]
        ];
        
        foreach($tables as $table => $fields) {
            $str = "CREATE FULLTEXT INDEX {$table}_index ON {$table}(".implode(',', $fields).")";
            echo "\n\n\n\n\n\n\n\n{$str}\n\n\n\n\n\n\n\n";
            $this->execute($str);
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