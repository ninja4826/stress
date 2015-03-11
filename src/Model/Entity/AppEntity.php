<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class AppEntity extends Entity
{
  
  public $_virtual = ['display_name', 'display_field'];
  
  protected function _getTableName() {
    return $this->_registryAlias;
  }
}