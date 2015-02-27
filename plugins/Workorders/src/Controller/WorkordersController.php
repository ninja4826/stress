<?php
namespace Workorders\Controller;

use Workorders\Controller\AppController;

/**
 * Workorders Controller
 *
 * @property \Workorders\Model\Table\WorkordersTable $Workorders
 */
class WorkordersController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('workorders', $this->paginate($this->Workorders));
        $this->set('_serialize', ['workorders']);
    }

    /**
     * View method
     *
     * @param string|null $id Workorder id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $workorder = $this->Workorders->get($id, [
            'contain' => []
        ]);
        $this->set('workorder', $workorder);
        $this->set('_serialize', ['workorder']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $workorder = $this->Workorders->newEntity();
        if ($this->request->is('post')) {
            $workorder = $this->Workorders->patchEntity($workorder, $this->request->data);
            if ($this->Workorders->save($workorder)) {
                $this->Flash->success('The workorder has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The workorder could not be saved. Please, try again.');
            }
        }
        $this->set(compact('workorder'));
        $this->set('_serialize', ['workorder']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Workorder id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $workorder = $this->Workorders->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $workorder = $this->Workorders->patchEntity($workorder, $this->request->data);
            if ($this->Workorders->save($workorder)) {
                $this->Flash->success('The workorder has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The workorder could not be saved. Please, try again.');
            }
        }
        $this->set(compact('workorder'));
        $this->set('_serialize', ['workorder']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Workorder id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $workorder = $this->Workorders->get($id);
        if ($this->Workorders->delete($workorder)) {
            $this->Flash->success('The workorder has been deleted.');
        } else {
            $this->Flash->error('The workorder could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
