<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Staffs Controller
 *
 * @property \App\Model\Table\StaffsTable $Staffs
 */
class StaffsController extends AppController
{

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
            'contain' => ['Addresses']
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
            $staff = $this->Staffs->patchEntity($staff, $this->request->data);
            if ($this->Staffs->save($staff)) {
                $this->Flash->success('The staff has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The staff could not be saved. Please, try again.');
            }
        }
        $addresses = $this->Staffs->Addresses->find('list', ['limit' => 200]);
        $this->set(compact('staff', 'addresses'));
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
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $staff = $this->Staffs->patchEntity($staff, $this->request->data);
            if ($this->Staffs->save($staff)) {
                $this->Flash->success('The staff has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The staff could not be saved. Please, try again.');
            }
        }
        $addresses = $this->Staffs->Addresses->find('list', ['limit' => 200]);
        $this->set(compact('staff', 'addresses'));
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
        if ($this->Staffs->delete($staff)) {
            $this->Flash->success('The staff has been deleted.');
        } else {
            $this->Flash->error('The staff could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
