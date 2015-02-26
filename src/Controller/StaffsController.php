<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
/**
 * Staffs Controller
 *
 * @property \App\Model\Table\StaffsTable $Staffs
 */
class StaffsController extends AppController
{
    
    public function initialize() {
        parent::initialize();
        $this->loadModel('Addresses');
    }

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Addresses']
        ];
        $this->set('staffs', $this->paginate($this->Staffs));
        $this->set('_serialize', ['staffs']);
    }

    /**
     * View method
     *
     * @param string|null $id Staff id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $staff = $this->Staffs->get($id, [
            'contain' => ['Addresses', 'Users']
        ]);
        $this->set('staff', $staff);
        $this->set('_serialize', ['staff']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $staff = $this->Staffs->newEntity();
        if ($this->request->is('post')) {
            $staff = $this->Staffs->patchEntity($staff, $this->request->data, [
                'associated' => [
                    'Addresses'
                ]
            ]);
            // Log::write('debug', gettype($staff->address));
            $address = $this->Addresses->newEntity(json_decode(json_encode($staff->address), true));
            if ($this->Addresses->save($address)) {
                $staff->address_id = $address->id;
            }
            // Log::write('debug', $staff);
            if ($this->Staffs->save($staff)) {
                $this->Flash->success('The staff has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The staff could not be saved. Please, try again.');
            }
        }
        $this->set(compact('staff'));
        $this->set('_serialize', ['staff']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Staff id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $staff = $this->Staffs->get($id, [
            'contain' => ['Addresses']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $staff = $this->Staffs->patchEntity($staff, $this->request->data, [
                'associated' => [
                    'Addresses'
                ]
            ]);
            if ($this->Staffs->save($staff)) {
                $this->Flash->success('The staff has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The staff could not be saved. Please, try again.');
            }
        }
        $this->set(compact('staff'));
        $this->set('_serialize', ['staff']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Staff id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $staff = $this->Staffs->get($id);
        $address = $staff->address;
        if ($this->Staffs->delete($staff)) {
            if ($this->Addresses->delete($address)) {
                $this->Flash->success('The staff has been deleted.');
            } else {
                $this->Flash->error('The staff could not be deleted due to implications with the address. Please, try again.');
            }
        } else {
            $this->Flash->error('The staff could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
