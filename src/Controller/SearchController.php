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
        // $this->loadComponent('Security');
    }
    
    public function search() {
        if ($this->request->is('post')) {
            $this->viewClass = 'Json';
            $this->layout = 'ajax';
            $items = $this->Search->search($this->request->data);
            $this->set('response', $items);
            $this->set('_serialize', ['response']);
            
        }
    }
    
    public function format_results() {
        $tables = json_decode($this->request->query['tables'], true);
        $this->viewClass = 'Json';
        Log::write('debug', $tables);
        $this->set('tables', $tables);
        $asdf = $this->render('/Element/search/results');
        Log::write('debug', $asdf);
        // Log::write('debug', json_decode($this->request->query['tables'], true));
        // $this->viewClass = 'Json';
        // $this->layout = 'ajax';
        // $this->set('asdf', []);
        // $this->set('_serialize', ['asdf']);
    }
}
