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
    public function add($part_id = null)
    {
        $partTransaction = $this->PartTransactions->newEntity();
        $query = $this->request->query;
        $this->loadModel('Vendors');
        if ($this->request->is('post')) {
            
            $data = $this->request->data;
            Log::write('debug', $data);
            if (!array_key_exists('part_vendor_id', $data)) {
                $part_vendor = null;
                
                if (array_key_exists('vendor_name', $data)) {
                    $vendor = $this->Vendors->findByVendorName($data['vendor_name'])->first();
                    if (!$vendor) {
                        $this->Flash->error('Vendor does not exist. Transaction could not be created.');
                        return $this->redirect([
                            'controller' => 'Parts',
                            'action' => 'view',
                            $part_id
                        ]);
                    }
                    $part_vendor = $this->PartTransactions->PartVendors->findByVendorIdAndPartId($vendor->id, $part_id)->first();
                }
                
                if (!$part_vendor) {
                    $this->Flash->error('A Part Vendor for this item cannot be found. Once a Part Vendor has been created, the transaction will be saved.');
                    return $this->redirect([
                        'controller' => 'PartVendors',
                        'action' => 'add',
                        '?' => [
                            'redirect' => json_encode(['controller' => 'Parts', 'action' => 'view', $part_id]),
                            'trans' => json_encode($data)
                        ]
                    ]);
                } else {
                    $this->request->data['part_vendor_id'] = $part_vendor->id;
                }
            }
            Log::write('debug', $this->request->data);
            $partTransaction = $this->PartTransactions->patchEntity($partTransaction, $this->request->data);
            if ($this->PartTransactions->save($partTransaction)) {
                $this->Flash->success('The part transaction has been saved.');
                return $this->redirect(['controller' => 'Parts', 'action' => 'view', $part_id]);
            } else {
                $this->Flash->error('The part transaction could not be saved. Please, try again.');
            }
        }
        $vendors = $this->Vendors->find('list', ['limit' => 200]);
        $this->set(compact('partTransaction', 'vendors', 'query', 'part_id'));
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
