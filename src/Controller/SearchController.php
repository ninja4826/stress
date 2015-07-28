<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\ORM\TableRegistry;
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
        Log::write('debug', 'IN SEARCH CONTROLLER');
        Log::write('debug', $this->request->query);
        if (array_key_exists('q', $this->request->query)) {
        // if (array_key_exists('keyword', $this->request->data)) {
        // if ($this->request->is('post')) {
            // $data = $this->request->data;
            
            // $data = $this->request->data;
            // $test_data = json_decode($this->request->query['q']);
            
            $data = json_decode($this->request->query['q'], true);
            
            // $data = json_decode($this->request->query['q']);
            
            // if (array_key_exists('keyword', $data)) {
            //     $search_bar;
            //     $k = '%'.$data['keyword'].'%';
            //     $temp_ = [
            //         'Parts' => [
            //             'part_num',
            //             'description'
            //         ],
            //         'Categories' => [
            //             'category_name'
            //         ],
            //         'CostCenters' => [
            //             'description'
            //         ],
            //         'Manufacturers' => [
            //             'manufacturer_name'
            //         ]
            //     ];
            //     $arr = [];
                
            //     foreach($temp_ as $table => $fields) {
            //         $or_arr = [];
            //         foreach($fields as $field) {
            //             $or_arr[] = [
            //                 'name' => $field,
            //                 'op' => 'k',
            //                 'val' => $k
            //             ];
            //         }
            //         $arr[$table] = [['or' => $or_arr]];
            //     }
                
            //     $search_bar = ['bar' => true, 'k' => $arr];
            //     $this->set('search_bar', $search_bar);
            //     $this->set('_serialize', ['search_bar']);
            //     return;
            // } else {
            //     $this->set('search_bar', ['bar' => false]);
            // }
            $items = $this->Search->search($data);
            Log::write('debug', $items);
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
            Log::write('debug', 'DID SEARCH THING');
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
    
    public function new_search() {
        if (array_key_exists('q', $this->request->query)) {
            $data = json_decode($this->request->query['q'], true);
            
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
            $tables = [];
            foreach (['Parts', 'Categories', 'CostCenters', 'Manufacturers'] as $table_name) {
                $table = TableRegistry::get($table_name);
                Log::write('debug', $table);
                $fields = $table->getFields();
                $tables[$table_name] = $fields;
                
            }
            $this->set('search_bar', ['bar' => false]);
            $this->set('info', $tables);
            $this->set('_serialize', ['search_bar', 'info']);
        }
    }
    
    public function new_format_results() {
        
    }
}
