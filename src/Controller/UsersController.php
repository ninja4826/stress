<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Network\Exception\ForbiddenException;
use Cake\Event\Event;

class UsersController extends AppController {
    
    public $paginate = [
        'contain' => ['Staffs']
    ];
    
    public function beforeFilter(Event $event) {
        parent::beforeFilter($event);
        $this->Auth->allow(['add', 'logout']);
    }
    
    public function index() {
        $this->set('users', $this->paginate($this->Users));
        $this->set('_serialize', ['categories']);
    }
    
    public function view($id) {
        if (!$id) {
            throw new NotFoundException(__('Invalid user'));
        }
        
        $user = $this->Users->get($id, [
            'contain' => ['Staffs']
        ]);
        $this->set('user', $user);
        $this->set('_serialize', ['user']);
    }
    
    public function add() {
        $user = $this->Users->newEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->data);
            if ($this->Users->save($user)) {
                $this->Flash->success('The user has been created.');
                return $this->redirect(['action' => 'view', $user->id]);
            }
            $this->Flash->error(__('Unable to create the user'));
        }
        if (array_key_exists('staff', $this->request->query)) {
            $user_ = $this->Users->findByStaffId($this->request->query['staff']);
            if ($user_) {
                $this->Flash->error(__('A user already exists for this staff member.'));
                return $this->redirect(['controller' => 'Staffs', 'action' => 'view', $this->request->query['staff']]);
            }
        } else {
            $staffs = $this->Users->Staffs->find('list', ['limit' => 200]);
            $this->set('staffs', $staffs);
        }
        $this->set(compact('user'));
        $this->set('_serialize', ['user']);
    }
    
    public function login() {
        if ($this->request->is('post')) {
            $user = $this->Auth->identify();
            if ($user) {
                $this->Auth->setUser($user);
                return $this->redirect($this->Auth->redirectUrl());
            }
            $this->Flash->error(__('Invalid username or password, please try again.'));
        }
    }
    
    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
}