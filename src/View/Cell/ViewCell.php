<?php
namespace App\View\Cell;

use Cake\View\Cell;

/**
 * View cell
 */
class ViewCell extends Cell
{

    /**
     * List of valid options that can be passed into this
     * cell's constructor.
     *
     * @var array
     */
    protected $_validCellOptions = [];

    /**
     * Default display method.
     *
     * @return void
     */
    public function display($model, $alterations)
    {
        $this->loadComponent('API');
        $info = $this->API->get_info($model, $alterations, false);
        
        $this->set(compact('info'));
    }
}
