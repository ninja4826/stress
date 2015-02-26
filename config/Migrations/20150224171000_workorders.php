<?php

use Phinx\Migration\AbstractMigration;

class Workorders extends AbstractMigration
{
    public function change() {
        $wo_types = $this->table('wo_types');
        $wo_types
            ->addColumn('wo_type', 'string')
            ->save();
        $wo_statuses = $this->table('wo_statuses');
        $wo_statuses
            ->addColumn('wo_status', 'string')
            ->save();
        $requestors = $this->table('requestors');
        $requestors
            ->addColumn('name', 'string')
            ->addColumn('extension', 'string')
            ->save();
        $workorders = $this->table('workorders');
        $workorders
            ->addColumn('date_received', 'datetime')
            ->addColumn('date_required', 'datetime')
            ->addColumn('expedite', 'boolean')
            ->addColumn('description', 'string')
            ->addColumn('location', 'string')
            ->addColumn('date_signed', 'datetime')
            ->addColumn('fixed_price', 'decimal')
            ->addColumn('date_promised', 'datetime')
            ->addColumn('est_time', 'string')
            ->addColumn('wo_status_id', 'integer')
            ->addColumn('wo_type_id', 'integer')
            ->addColumn('project_number', 'integer')
            ->addColumn('pm_id', 'integer')
            ->addColumn('req_id', 'integer')
            ->addColumn('wo_req', 'string')
            ->addForeignKey('wo_status_id', 'wo_statuses', 'id')
            ->addForeignKey('wo_type_id', 'wo_types', 'id')
            ->addForeignKey('pm_id', 'staffs', 'id')
            ->addForeignKey('req_id', 'requestors', 'id')
            ->save();
        $wo_update_histories = $this->table('wo_update_histories');
        $wo_update_histories
            ->addColumn('workorder_id', 'integer')
            ->addColumn('staff_id', 'integer')
            ->addColumn('date_modified', 'datetime')
            ->addForeignKey('workorder_id', 'workorders', 'id')
            ->addForeignKey('staff_id', 'staffs', 'id')
            ->save();
        $task_statuses = $this->table('task_statuses');
        $task_statuses
            ->addColumn('task_status', 'string')
            ->save();
        $task_types = $this->table('task_types');
        $task_types
            ->addColumn('task_type', 'string')
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
            ->addForeignKey('staff_id', 'staffs', 'id')
            ->addForeignKey('task_status_id', 'task_statuses', 'id')
            ->addForeignKey('task_id', 'tasks', 'id')
            ->save();
        $wo_task_update_histories = $this->table('wo_task_update_histories');
        $wo_task_update_histories
            ->addColumn('wo_task_id', 'integer')
            ->addColumn('staff_id', 'integer')
            ->addColumn('update_type', 'string')
            ->addColumn('date_modified', 'datetime')
            ->addForeignKey('wo_task_id', 'wo_tasks', 'id')
            ->addForeignKey('staff_id', 'staffs', 'id')
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