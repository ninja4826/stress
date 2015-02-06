<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Log\Log;
use Cake\ORM\TableRegistry;

/**
 * Locations Controller
 *
 * @property \App\Model\Table\LocationsTable $Locations
 */
class LocationsController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index()
    {
        $this->set('locations', $this->paginate($this->Locations));
        $this->set('_serialize', ['locations']);
    }

    /**
     * View method
     *
     * @param string|null $id Location id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $location = $this->Locations->get($id, [
            'contain' => ['Parts']
        ]);
        $parts = [];
        $partsTable = TableRegistry::get('Parts');
        foreach ($location->parts as $part)
        {
            $parts[] = $partsTable->get($part->id, [
                'contain' => ['Manufacturers', 'Categories', 'Locations', 'CostCenters']
            ]);
        }
        $this->set('location', $location);
        $this->set('parts', $parts);
        $this->set('_serialize', ['location']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $location = $this->Locations->newEntity();
        if ($this->request->is('post')) {
            $location = $this->Locations->patchEntity($location, $this->request->data);
            if ($this->Locations->save($location)) {
                $this->Flash->success('The location has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The location could not be saved. Please, try again.');
            }
        }
        $this->set(compact('location'));
        $this->set('_serialize', ['location']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Location id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $location = $this->Locations->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $location = $this->Locations->patchEntity($location, $this->request->data);
            if ($this->Locations->save($location)) {
                $this->Flash->success('The location has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The location could not be saved. Please, try again.');
            }
        }
        $this->set(compact('location'));
        $this->set('_serialize', ['location']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Location id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $location = $this->Locations->get($id);
        if ($this->Locations->delete($location)) {
            $this->Flash->success('The location has been deleted.');
        } else {
            $this->Flash->error('The location could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
