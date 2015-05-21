<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use Cake\ORM\TableRegistry;

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
    public function index($model = 'Parts')
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
        $this->set(compact('info'));
    }

    /**
     * View method
     *
     * @param string|null $id Modular id.
     * @return void
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function view($model = 'Parts', $id = null)
    {
        $table = TableRegistry::get($model);
        $object = $table->get($id, [
            'contain' => $table->assocs
        ]);
        $this->loadComponent('API');
        $info = $this->API->get_info($model, [], false);
        $this->set(compact('object', 'info'));
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add($model = 'Parts', $alterations = [])
    {
        $this->loadComponent('API');
        $info = $this->API->get_info($model, $alterations);
        $this->set(compact('info'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Modular id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function edit($model = 'Parts', $id = null)
    {
        $object = TableRegistry::get($model)->get($id);
        $this->loadComponent('API');
        $info = $this->API->get_info($model);
        foreach($info['fields'] as $name => $field) {
            $info['fields'][$name]['default'] = $object->$name;
        }
        $info['fields']['id'] = [
            'default' => $object->id,
            'field_name' => 'id',
            'label' => 'ID',
            'required' => true,
            'search' => false,
            'type' => 'hidden'
        ];
        foreach($info['fields'] as $name => $field) {
            if (array_key_exists('assoc', $field)) {
                $table = TableRegistry::get($field['assoc']['model']);
                $info['fields'][$name]['default'] = $table->get($object[$field['assoc']['key']])->display_name;
            }
        }
        $this->setAction('add', $model, $info['fields']);
    }

    /**
     * Delete method
     *
     * @param string|null $id Modular id.
     * @return void Redirects to index.
     * @throws \Cake\Network\Exception\NotFoundException When record not found.
     */
    public function delete($model = 'Parts', $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $table = TableRegistry::get($model);
        $modular = $table->get($id);
        if ($table->delete($modular)) {
            $this->Flash->success('The modular has been deleted.');
        } else {
            $this->Flash->error('The modular could not be deleted. Please, try again.');
        }
        return $this->redirect(['action' => 'index']);
    }
}
