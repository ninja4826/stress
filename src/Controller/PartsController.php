<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;
use Cake\Routing\Router;

/**
 * Parts Controller
 *
 * @property \App\Model\Table\PartsTable $Parts
 */
class PartsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index($partVendor = null)
    {
        $this->paginate = [
            'contain' => ['Manufacturers', 'Categories', 'Locations', 'CostCenters']
        ];
        Log::write('debug', $this->referer());
        $this->set('parts', $this->paginate($this->Parts));
        $this->set('_serialize', ['parts']);
    }
    
    /**
     * View method
     *
     * @param string|null $id Part id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        
        $part = $this->Parts->get($id, [
            'contain' => [
                'Manufacturers',
                'Categories',
                'Locations',
                'CostCenters',
                'PartVendors' => function ($pv) {
                    return $pv->contain(['Vendors', 'PartPriceHistories' => function ($pph) {
                        return $pph->order('date_changed DESC');
                    }]);
                }
            ]
        ]);
        Log::write('debug', $part);
        /*
        $vendor_histories = TableRegistry::get('VendorHistories')->getByPartId($part->id, [
            'contain' => ['Vendors']
        ]);
        */
        $this->set('part', $part);
        $this->set('_serialize', ['part']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $part = $this->Parts->newEntity();
        if ($this->request->is('post')) {
            
            if (!is_null($foundPart = $this->Parts->findByPartNum($this->request->data['part_num'])->first()))
            {
                $part = $foundPart;
                $part->amt_on_hand += $this->request->data['amt_on_hand'];
            } else {
                $part = $this->Parts->patchEntity($part, $this->request->data);
            }
            if ($this->Parts->save($part)) {
                $this->Flash->success('The part has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The part could not be saved. Please, try again.');
                Log::write('debug', $part);
            }
        }
        $allParts = $this->Parts->getPartNums();
        $manufacturers = $this->Parts->Manufacturers->find('list', ['limit' => 200]);
        $categories = $this->Parts->Categories->find('list', ['limit' => 200]);
        $costCenters = $this->Parts->CostCenters->find('list', ['limit' => 200]);
        $this->set(compact('part', 'manufacturers', 'categories', 'locations', 'costCenters', 'allParts'));
        $this->set('_serialize', ['part']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Part id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $part = $this->Parts->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $part = $this->Parts->patchEntity($part, $this->request->data);
            if ($this->Parts->save($part)) {
                $this->Flash->success('The part has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The part could not be saved. Please, try again.');
            }
        }
        $manufacturers = $this->Parts->Manufacturers->find('list', ['limit' => 200]);
        $categories = $this->Parts->Categories->find('list', ['limit' => 200]);
        $locations = $this->Parts->Locations->find('list', ['limit' => 200]);
        $costCenters = $this->Parts->CostCenters->find('list', ['limit' => 200]);
        $this->set(compact('part', 'manufacturers', 'categories', 'locations', 'costCenters'));
        $this->set('_serialize', ['part']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Part id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $part = $this->Parts->get($id);
        if ($this->Parts->delete($part)) {
            $this->Flash->success('The part has been deleted.');
        } else {
            $this->Flash->error('The part could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
    public function info() {}
}
