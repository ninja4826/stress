<?php

use Phinx\Migration\AbstractMigration;

class Task extends AbstractMigration
{
    public function change() {
        $task_statuses = $this->table('task_statuses');
        $task_statuses
            ->addColumn('status', 'string')
            ->save();
        
        $task_types = $this->table('task_types');
        $task_types
            ->addColumn('type', 'string')
            ->save();
        
        $tasks = $this->table('tasks');
        $tasks
            ->addColumn('task_type_id', 'integer')
            ->addColumn('name', 'string')
            ->addColumn('description', 'string')
            ->addColumn('active', 'boolean')
            ->addForeignKey('task_type_id', 'task_types', 'id')
            ->save();
        
        $wo_tasks = $this->table('wo_tasks');
        $wo_tasks
            ->addColumn('workorder_id', 'integer')
            ->addColumn('staff_id', 'integer')
            ->addColumn('task_status_id', 'integer')
            ->addColumn('task_id', 'integer')
            ->addForeignKey('workorder_id', 'workorders', 'id')
            ->addForeignKey('staff_id', 'staff', 'id')
            ->addForeignKey('task_status_id', 'task_statuses', 'id')
            ->addForeignKey('task_id', 'tasks', 'id')
            ->save();
        
        $wo_task_update_histories = $this->table('wo_task_update_histories');
        $wo_task_update_histories
            ->addColumn('wo_task_id', 'integer')
            ->addColumn('staff_id', 'integer')
            ->addColumn('type', 'string')
            ->addColumn('date_modified', 'datetime')
            ->addForeignKey('wo_task_id', 'wo_tasks', 'id')
            ->addForeignKey('staff_id', 'staff', 'id')
            ->save();
        
        $part_tasks = $this->table('part_tasks');
        $part_tasks
            ->addColumn('quantity', 'integer')
            ->addColumn('task_date', 'datetime')
            ->save();
    }
    
    /**
     * Migrate Up.
     */
    public function up()
    {
    
    }

    /**
     * Migrate Down.
     */
    public function down()
    {

    }
}