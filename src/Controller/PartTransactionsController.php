<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

/**
 * PartTransactions Controller
 *
 * @property \App\Model\Table\PartTransactionsTable $PartTransactions
 */
class PartTransactionsController extends AppController
{

    public function initialize() {
        parent::initialize();
        $this->helpers[] = 'Url';
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index($partVendor = null) {
        $this->paginate = [
            'finder' => ['vendor' => ['id' => $partVendor]],
            'contain' => [
                'PartVendors' => function($pv) {
                    return $pv->contain(['Vendors', 'Parts']);
                }
            ]
        ];

        $this->set('partTransactions', $this->paginate($this->PartTransactions));
        $this->set('_serialize', ['part_transactions']);
    }

    /**
     * View method
     *
     * @param string|null $id Part Transaction id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $partTransaction = $this->PartTransactions->get($id, [
            'contain' => ['PartVendors']
        ]);
        $this->set('partTransaction', $partTransaction);
        $this->set('_serialize', ['partTransaction']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($partVendor = null)
    {
        $partTransaction = $this->PartTransactions->newEntity();

        if ($this->request->is('post')) {
            $partTransaction = $this->PartTransactions->patchEntity($partTransaction, $this->request->data);
            if ($this->PartTransactions->save($partTransaction)) {
                $this->Flash->success('The part transaction has been saved.');
                return $this->redirect(['controller' => 'Parts', 'action' => 'view', $partVendor]);
            } else {
                $this->Flash->error('The part transaction could not be saved. Please, try again.');
            }
        }

        $vendors_ = TableRegistry::get('Vendors')->find('all', [
            'conditions' => ['active' => '1'],
            'fields' => ['id', 'vendor_name']
        ])->toArray();
        foreach ($vendors_ as $k => $v) {
            $vendors_[$k] = $v->vendor_name;
        }
        $this->loadModel('PartVendors');


        $partVendors = $this->PartVendors->find('all', [
            'contain' => [
                'Vendors'
            ]
        ]);
/*
        if (array_key_exists('part', $this->request->query)) {
            $partVendors->where([
                'part_id' => $this->request->query['part']
            ]);
        }
*/
        $partVendors = $partVendors->toArray();

        foreach ($partVendors as $k => $v) {
            $partVendors[$k] = $v->vendor->vendor_name;
        }
        $vendors = [
            'vendors' => $vendors_,
            'part_vendors' => $partVendors
        ];
        $this->set(compact('partTransaction', 'partVendor', 'vendors'));
        $this->set('_serialize', ['partTransaction']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Part Transaction id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $partTransaction = $this->PartTransactions->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $partTransaction = $this->PartTransactions->patchEntity($partTransaction, $this->request->data);
            if ($this->PartTransactions->save($partTransaction)) {
                $this->Flash->success('The part transaction has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The part transaction could not be saved. Please, try again.');
            }
        }
        $partVendors = $this->PartTransactions->PartVendors->find('list', ['limit' => 200]);
        $this->set(compact('partTransaction', 'partVendors'));
        $this->set('_serialize', ['partTransaction']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Part Transaction id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $partTransaction = $this->PartTransactions->get($id);
        if ($this->PartTransactions->delete($partTransaction)) {
            $this->Flash->success('The part transaction has been deleted.');
        } else {
            $this->Flash->error('The part transaction could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
