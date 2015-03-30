<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

/**
 * Search Controller
 *
 * @property \App\Model\Table\SearchTable $Search
 */
class SearchController extends AppController
{
    public function initialize() {
        parent::initialize();
        $this->loadComponent('Search');
        $this->loadComponent('RequestHandler');
    }
    
    public function search() {
        if ($this->request->is('post')) {
            $data = $this->request->data;
            Log::write('debug', $data);
            // if (array_key_exists('search-bar', $data) && $data['search-bar'] == 'true') {
            if (array_key_exists('keyword', $data)) {
                $search_bar;
                Log::write('debug', 'DOING STUFF WITH SEARCH_BAR');
                $k = '%'.$data['keyword'].'%';
                $temp_ = [
                    'Parts' => [
                        'part_num',
                        'description'
                    ],
                    'Categories' => [
                        'category_name'
                    ],
                    'CostCenters' => [
                        'description'
                    ],
                    'Manufacturers' => [
                        'manufacturer_name'
                    ]
                ];
                $arr = [];
                
                foreach($temp_ as $table => $fields) {
                    $or_arr = [];
                    foreach($fields as $field) {
                        $or_arr[] = [
                            'name' => $field,
                            'op' => 'k',
                            'val' => $k
                        ];
                    }
                    $arr[$table] = [['or' => $or_arr]];
                }
                
                $search_bar = ['bar' => true, 'k' => $arr];
                $this->set('search_bar', $search_bar);
                $this->set('_serialize', ['search_bar']);
                return;
            } else {
                $this->set('search_bar', ['bar' => false]);
            }
            $items = $this->Search->search($data);
            Log::write('debug', 'GOING TO FORMAT');
            
            $this->layout = 'empty';
            $tables = json_decode(json_encode($items), true);
            $newTable = [];
            $assoc = [
                'Parts' => [
                    'Categories',
                    'CostCenters',
                    'Manufacturers',
                    'Locations'
                ],
                'Categories' => ['Parts'],
                'CostCenters' => ['Parts'],
                'Manufacturers' => ['Parts']
            ];
            foreach($tables as $table => $items) {
                $table_arr = [];
                $this->loadModel($table);
                foreach($items as $item) {
                    $table_arr[] = $this->$table->get($item['id'], ['contain' => $assoc[$table]]);
                }
                $newTable[$table] = $table_arr;
                Log::write('debug', $table_arr);
            }
            $this->set('tables', $newTable);
            $this->set('_serialize', ['tables', 'search_bar']);
            $this->render('format_results');
        } else {
            $this->set('search_bar', ['bar' => false]);
            $this->set('_serialize', ['search_bar']);
            Log::write('debug', 'GET');
        }
    }
    
    public function format_results() {
            
    }
}
