<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
use Cake\ORM\TableRegistry;
use Cake\Event\Event;
use Cake\Log\Log;
use Cake\Database\Expression\Comparison;

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
    }
    
    public function search($arr, $select = ['id']) {
        $response = [];
        if (array_key_exists('filters', $arr) && count(array_keys($arr)) == 1) {
            $arr = $arr['filters'];
        }
        foreach ($arr as $model => $filters) {
            $this->$model = TableRegistry::get($model);
            $query = $this->$model->find('all', ['']);
            foreach($filters as $filter) {
                $query_;
                if (array_key_exists('or', $filter) || array_key_exists('and', $filter)) {
                    $query_ = $this->group_search($query, $filter);
                } else {
                    $query_ = $this->_search($query, $filter);
                }
            }
            $query->select($select);
            $response[$model] = $query;
        }
        return $response;
    }
    
    private function group_search($query, $arr) {
        $group = (array_key_exists('or', $arr) ? 'or' : 'and');
        // Log::write('debug', 'START');
        // Log::write('debug', $arr);
        $arr = $arr[$group];
        // Log::write('debug', 'CHANGED SCOPE');
        // Log::write('debug', $arr);
        if ($group == 'or') {
            $group = 'or_';
        } elseif ($group == 'and') {
            $group = 'and_';
        } else {
            return $query;
        }
        
        foreach ($arr as $key => $arr_) {
            $arr[$key]['opt'] = $this->get_opt($arr_['op']);
        }
        // Log::write('debug', 'CHANGED OPTS');
        // Log::write('debug', $arr);
        $q = $query->where(function ($exp) use ($arr, $group, $blah) {
            return $exp->$group(function ($exp_) use ($arr, $blah) {
                foreach ($arr as $filter_) {
                    $exp_->$filter_['opt']($filter_['name'], $filter_['val']);
                }
                return $exp_;
            });
        });
        return $q;
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
            case 'regexp':
                $opt = 'regexp';
                break;
            default:
                $opt = '';
                break;
        }
        return $opt;
    }
}