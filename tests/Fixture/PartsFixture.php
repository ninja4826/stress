<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PartsFixture
 *
 */
class PartsFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'manufacturer_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'category_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'part_num' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'description' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        'amt_on_hand' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'location_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'active' => ['type' => 'boolean', 'length' => null, 'null' => false, 'default' => '1', 'comment' => '', 'precision' => null],
        'cc_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        '_indexes' => [
            'manufacturer_key' => ['type' => 'index', 'columns' => ['manufacturer_id'], 'length' => []],
            'category_key' => ['type' => 'index', 'columns' => ['category_id'], 'length' => []],
            'cc_key' => ['type' => 'index', 'columns' => ['cc_id'], 'length' => []],
            'location_key' => ['type' => 'index', 'columns' => ['location_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'parts_ibfk_1' => ['type' => 'foreign', 'columns' => ['manufacturer_id'], 'references' => ['manufacts', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'parts_ibfk_2' => ['type' => 'foreign', 'columns' => ['category_id'], 'references' => ['categories', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'parts_ibfk_3' => ['type' => 'foreign', 'columns' => ['cc_id'], 'references' => ['cost_centers', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'parts_ibfk_4' => ['type' => 'foreign', 'columns' => ['location_id'], 'references' => ['locations', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
        ],
        '_options' => [
'engine' => 'InnoDB', 'collation' => 'utf8_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id' => 1,
            'manufacturer_id' => 1,
            'category_id' => 1,
            'part_num' => 'SN74S74N-T',
            'description' => 'Lorem ipsum dolor sit amet',
            'amt_on_hand' => 10,
            'location_id' => 1,
            'active' => 1,
            'cc_id' => 1
        ],
    ];
}
