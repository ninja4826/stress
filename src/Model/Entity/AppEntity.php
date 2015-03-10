<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

class AppEntity extends Entity
{
  protected function _getTableName() {
    return $this->_registryAlias;
  }
}