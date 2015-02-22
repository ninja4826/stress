<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;

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
        $q = $this->request->query;
        $trans = null;
        if (array_key_exists('trans', $q)) {
            $trans = json_decode($q['trans'], true);
        }
        $partVendor = $this->PartVendors->newEntity();
        if ($this->request->is('post')) {
            Log::write('debug', "OLD DATA: \n");
            Log::write('debug', $this->request->data);
            
            if ($trans && array_key_exists('vendor_name', $trans) && array_key_exists('part_id', $trans)) {
                
                $vendor_id = $this->PartVendors->Vendors->findByVendorName($trans['vendor_name'])->first()->id;
                $data = $this->request->data;
                $data['part_id'] = $trans['part_id'];
                $data['vendor_id'] = $vendor_id;
                Log::write('debug', "NEW DATA: \n");
                Log::write('debug', $data);
                $this->request->data = $data;
            }
            $partVendor = $this->PartVendors->patchEntity($partVendor, $this->request->data);
            if ($this->PartVendors->save($partVendor)) {
                if ($trans) {
                    $this->loadModel('PartTransactions');
                    $trans_data = $trans;
                    unset($trans_data['vendor_name']);
                    unset($trans_data['part_id']);
                    $trans_data['part_vendor_id'] = $partVendor->id;
                    $part_trans = $this->PartTransactions->newEntity($trans_data);
                    if ($this->PartTransactions->save($part_trans)) {
                        $this->Flash->success('The part vendor has been created, and the transaction has been saved.');
                        if (array_key_exists('redirect', $q)) {
                            $redirect = json_decode($q['redirect'], true);
                            return $this->redirect($redirect);
                        }
                    }
                }
                $this->Flash->success('The part vendor has been saved.');
                return $this->redirect(['controller' => 'PartVendors', 'action' => 'view', $partVendor->id]);
            } else {
                $this->Flash->error('The part vendor could not be saved. Please, try again.');
            }
        }
        
        $vendors = $this->PartVendors->Vendors->find('list', ['limit' => 200]);
        $parts = $this->PartVendors->Parts->find('list', ['limit' => 200]);
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
