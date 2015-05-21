<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * CostCenters Controller
 *
 * @property \App\Model\Table\CostCentersTable $CostCenters
 */
class CostCentersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('costCenters', $this->paginate($this->CostCenters));
        $this->set('_serialize', ['costCenters']);
    }

    /**
     * View method
     *
     * @param string|null $id Cost Center id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $costCenter = $this->CostCenters->get($id, [
            'contain' => []
        ]);
        $this->set('costCenter', $costCenter);
        $this->set('_serialize', ['costCenter']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $costCenter = $this->CostCenters->newEntity();
        if ($this->request->is('post')) {
            $costCenter = $this->CostCenters->patchEntity($costCenter, $this->request->data);
            if ($this->CostCenters->save($costCenter)) {
                $this->Flash->success('The cost center has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The cost center could not be saved. Please, try again.');
            }
        }
        $this->set(compact('costCenter'));
        $this->set('_serialize', ['costCenter']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Cost Center id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $costCenter = $this->CostCenters->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $costCenter = $this->CostCenters->patchEntity($costCenter, $this->request->data);
            if ($this->CostCenters->save($costCenter)) {
                $this->Flash->success('The cost center has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The cost center could not be saved. Please, try again.');
            }
        }
        $this->set(compact('costCenter'));
        $this->set('_serialize', ['costCenter']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Cost Center id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $costCenter = $this->CostCenters->get($id);
        if ($this->CostCenters->delete($costCenter)) {
            $this->Flash->success('The cost center has been deleted.');
        } else {
            $this->Flash->error('The cost center could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
