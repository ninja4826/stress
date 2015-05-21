<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Manufacturers Controller
 *
 * @property \App\Model\Table\ManufacturersTable $Manufacturers
 */
class ManufacturersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('manufacturers', $this->paginate($this->Manufacturers));
        $this->set('_serialize', ['manufacturers']);
    }

    /**
     * View method
     *
     * @param string|null $id Manufacturer id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $manufacturer = $this->Manufacturers->get($id, [
            'contain' => []
        ]);
        $this->set('manufacturer', $manufacturer);
        $this->set('_serialize', ['manufacturer']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $manufacturer = $this->Manufacturers->newEntity();
        if ($this->request->is('post')) {
            $manufacturer = $this->Manufacturers->patchEntity($manufacturer, $this->request->data);
            if ($this->Manufacturers->save($manufacturer)) {
                $this->Flash->success('The manufacturer has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The manufacturer could not be saved. Please, try again.');
            }
        }
        $this->set(compact('manufacturer'));
        $this->set('_serialize', ['manufacturer']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Manufacturer id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $manufacturer = $this->Manufacturers->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $manufacturer = $this->Manufacturers->patchEntity($manufacturer, $this->request->data);
            if ($this->Manufacturers->save($manufacturer)) {
                $this->Flash->success('The manufacturer has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The manufacturer could not be saved. Please, try again.');
            }
        }
        $this->set(compact('manufacturer'));
        $this->set('_serialize', ['manufacturer']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Manufacturer id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $manufacturer = $this->Manufacturers->get($id);
        if ($this->Manufacturers->delete($manufacturer)) {
            $this->Flash->success('The manufacturer has been deleted.');
        } else {
            $this->Flash->error('The manufacturer could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
