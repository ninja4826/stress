<?php

use Phinx\Migration\AbstractMigration;

class Workorder extends AbstractMigration
{
    public function change() {
        $wo_types = $this->table('wo_types');
        $wo_types
            ->addColumn('type', 'string')
            ->save();
        
        $wo_statuses = $this->table('wo_statuses');
        $wo_statuses
            ->addColumn('status', 'string')
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
            ->addForeignKey('pm_id', 'staff', 'id')
            ->addForeignKey('req_id', 'requestors', 'id')
            ->save();
            
        $wo_update_histories = $this->table('wo_update_histories');
        $wo_update_histories
            ->addColumn('workorder_id', 'integer')
            ->addColumn('staff_id', 'integer')
            ->addColumn('date_modified', 'datetime')
            ->addForeignKey('workorder_id', 'workorders', 'id')
            ->addForeignKey('staff_id', 'staff', 'id')
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