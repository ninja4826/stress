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
        
        if (array_key_exists('q', $this->request->query)) {
        // if ($this->request->is('post')) {
            // $data = $this->request->data;
            
            $data = json_decode($this->request->query['q'], true);
            
            if (array_key_exists('keyword', $data)) {
                $search_bar;
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
            $this->layout = 'empty';
            $tables = json_decode(json_encode($items), true);
            $newTable = [];
            foreach($tables as $table => $items) {
                $table_arr = [];
                $this->loadModel($table);
                foreach($items as $item) {
                    $table_arr[] = $this->$table->get($item['id'], ['contain' => $this->$table->assocs]);
                }
                $newTable[$table] = $table_arr;
            }
            $this->set('tables', $newTable);
            $this->set('_serialize', ['tables', 'search_bar']);
            $this->render('format_results');
        } else {
            $this->set('search_bar', ['bar' => false]);
            $this->set('_serialize', ['search_bar']);
        }
    }
    
    public function format_results() {
            
    }
}
