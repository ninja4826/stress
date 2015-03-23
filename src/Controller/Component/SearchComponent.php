<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Log\Log;

/**
 * Search component
 */
class SearchComponent extends Component
{
    
    public $controller;

    /**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];
    
    public function startup(Event $event) {
        $this->controller = $event->subject();
        var_dump($this->controller);
    }
    
    public function search($arr) {
        $response = [];
        foreach ($arr as $model => $filters) {
            $this->$model = TableRegistry::get($model);
            Log::write('debug', $model);
            foreach($filters as $filter) {
                $query = $this->$model->find();
                $query_;
                if (array_key_exists('or', $filter) || array_key_exists('and', $filter)) {
                    $query_ = $this->group_search($query, $filter);
                } else {
                    $query_ = $this->_search($query, $filter);
                }
                Log::write('debug', $query_->sql());
                $query->where(function ($exp) use ($query_) {
                    return $exp->add($query_);
                });
            }
            Log::write('debug', $query->sql());
            $response[$model] = $query;
        }
        return $response;
    }
    
    private function group_search($query, $arr) {
        $group = (array_key_exists('or', $arr) ? 'or' : 'and');
        $arr = $arr[$group];
        
        if ($group == 'or') {
            $group = 'or_';
        } elseif ($group == 'and') {
            $group = 'and_';
        } else {
            return $query;
        }
        $this_ = $this;
        
        foreach ($arr as $arr_) {
            $arr_['opt'] = $this->get_opt($arr_['op']);
        }
        return $query->where(function ($exp) use ($arr) {
            return $exp->$group(function ($exp_) use ($arr) {
                foreach ($arr as $filter) {
                    $exp_->$filter['opt']($filter['name'], $filter['val']);
                }
            });
        });
    }
    
    private function _search($query, $arr) {
        $opt = $this->get_opt($arr['op']);
        return $query->where(function ($exp) use ($opt, $arr) {
            return $exp->$opt($arr['name'], $arr['val']);
        });
    }
    
    private function get_opt($opt_str) {
        $opt;
        switch ($opt_str) {
            case '==':
                $opt = 'eq';
                break;
            case '!=':
                $opt = 'notEq';
                break;
            case '>': 
                $opt = 'gt';
                break;
            case '<':
                $opt = 'lt';
                break;
            case '>=':
                $opt = 'gte';
                break;
            case '<=':
                $opt = 'lte';
                break;
            case 'k':
                $opt = 'like';
                break;
        }
        return $opt;
    }
}