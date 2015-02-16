<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * PartVendors Controller
 *
 * @property \App\Model\Table\PartVendorsTable $PartVendors
 */
class PartVendorsController extends AppController
{
    
    public $helpers = ['Form', 'Html', 'Time'];
    /**
     * View method
     *
     * @param string|null $id Part Vendor id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $partVendor = $this->PartVendors->get($id, [
            'contain' => ['Parts', 'Vendors', 'PVRateHistories', 'PartPriceHistories', 'PartTransactions']
        ]);
        $this->set('partVendor', $partVendor);
        $this->set('_serialize', ['partVendor']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $partVendor = $this->PartVendors->newEntity();
        if ($this->request->is('post')) {
            $partVendor = $this->PartVendors->patchEntity($partVendor, $this->request->data);
            if ($this->PartVendors->save($partVendor)) {
                $this->Flash->success('The part vendor has been saved.');
                return $this->redirect(['controller' => 'Parts', 'action' => 'view', $id]);
            } else {
                $this->Flash->error('The part vendor could not be saved. Please, try again.');
            }
        }
        $q = $this->request->query;
        if (!array_key_exists('vendor', $q)) {
            $vendors = $this->PartVendors->Vendors->find('list', ['limit' => 200]);
        } else {
            $vendors = null;
        }
        if (!array_key_exists('part', $q)) {
            $parts = $this->PartVendors->Parts->find('list', ['limit' => 200]);
        } else {
            $parts = null;
        }
        $this->set(compact('partVendor', 'parts', 'vendors', 'q'));
        $this->set('_serialize', ['partVendor']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Part Vendor id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $partVendor = $this->PartVendors->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $partVendor = $this->PartVendors->patchEntity($partVendor, $this->request->data);
            if ($this->PartVendors->save($partVendor)) {
                $this->Flash->success('The part vendor has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The part vendor could not be saved. Please, try again.');
            }
        }
        $parts = $this->PartVendors->Parts->find('list', ['limit' => 200]);
        $vendors = $this->PartVendors->Vendors->find('list', ['limit' => 200]);
        $this->set(compact('partVendor', 'parts', 'vendors'));
        $this->set('_serialize', ['partVendor']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Part Vendor id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $partVendor = $this->PartVendors->get($id);
        if ($this->PartVendors->delete($partVendor)) {
            $this->Flash->success('The part vendor has been deleted.');
        } else {
            $this->Flash->error('The part vendor could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
