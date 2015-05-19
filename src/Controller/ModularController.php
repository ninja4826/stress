<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Modular Controller
 *
 * @property \App\Model\Table\ModularTable $Modular
 */
class ModularController extends AppController
{

    /**
     * Index method
     *
     * @return void
     */
    public function index($model = 'parts')
    {
        $this->loadComponent('API');
        $info = $this->API->get_info($model, [], false);
        $info['results'] = $this->API->search([$model => []]);
        
        $fields = $info['fields'];
        
        foreach($fields as $field_name => $field) {
            if (array_key_exists('assoc', $field)) {
                if (array_key_exists('type', $field['assoc']) && $field['assoc']['type'] == 'belongsToMany') {
                    unset($info['fields'][$field_name]);
                } elseif (array_key_exists('display_field', $field) && $field['display_field']) {
                    $info['fields'][$field_name]['url'] = Router::url([
                        'controller' => $model,
                        'action' => 'view'
                    ]);
                } else {
                    $info['fields'][$field_name]['assoc']['url'] = Router::url([
                        'controller' => $field['assoc']['model'],
                        'action' => 'view'
                    ]);
                }
            } elseif (array_key_exists('display_field', $field) && $field['display_field']) {
                $info['fields'][$field_name]['url'] = Router::url([
                    'controller' => $model,
                    'action' => 'view'
                ]);
            }
        }
    }

    /**
     * View method
     *
     * @param string|null $id Modular id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($id = null)
    {
        $modular = $this->Modular->get($id, [
            'contain' => []
        ]);
        $this->set('modular', $modular);
        $this->set('_serialize', ['modular']);
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $modular = $this->Modular->newEntity();
        if ($this->request->is('post')) {
            $modular = $this->Modular->patchEntity($modular, $this->request->data);
            if ($this->Modular->save($modular)) {
                $this->Flash->success('The modular has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The modular could not be saved. Please, try again.');
            }
        }
        $this->set(compact('modular'));
        $this->set('_serialize', ['modular']);
    }

    /**
     * Edit method
     *
     * @param string|null $id Modular id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $modular = $this->Modular->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $modular = $this->Modular->patchEntity($modular, $this->request->data);
            if ($this->Modular->save($modular)) {
                $this->Flash->success('The modular has been saved.');
                return $this->redirect(['action' => 'index']);
            } else {
                $this->Flash->error('The modular could not be saved. Please, try again.');
            }
        }
        $this->set(compact('modular'));
        $this->set('_serialize', ['modular']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Modular id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $modular = $this->Modular->get($id);
        if ($this->Modular->delete($modular)) {
            $this->Flash->success('The modular has been deleted.');
        } else {
            $this->Flash->error('The modular could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
