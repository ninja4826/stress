<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;
use Cake\ORM\TableRegistry;

class AppEntity extends Entity
{
  
  public $_virtual = ['display_name', 'display_field', 'table_name'];
  
  protected function _getTableName() {
    return $this->_registryAlias;
  }
  
  protected function _getFields() {
    return array_keys($this->_accessible);
  }
  
  public function __toString() {
    $display_field = TableRegistry::get($this->_registryAlias)->displayField();
    return (string)$this->$display_field;
  }
}