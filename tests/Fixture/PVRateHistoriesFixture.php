<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PVRateHistoriesFixture
 *
 */
class PVRateHistoriesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'p_v_rate_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'part_vendor_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'autoIncrement' => null],
        'date' => ['type' => 'datetime', 'length' => null, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null],
        'comment' => ['type' => 'string', 'length' => 255, 'null' => false, 'default' => null, 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'p_v_rate_id' => ['type' => 'index', 'columns' => ['p_v_rate_id'], 'length' => []],
            'part_vendor_id' => ['type' => 'index', 'columns' => ['part_vendor_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'p_v_rate_histories_ibfk_1' => ['type' => 'foreign', 'columns' => ['p_v_rate_id'], 'references' => ['p_v_rates', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'p_v_rate_histories_ibfk_2' => ['type' => 'foreign', 'columns' => ['part_vendor_id'], 'references' => ['part_vendors', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
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
            'p_v_rate_id' => 1,
            'part_vendor_id' => 1,
            'date' => '2015-02-10 22:12:53',
            'comment' => 'Lorem ipsum dolor sit amet'
        ],
    ];
}
