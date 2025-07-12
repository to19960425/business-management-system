<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateTimeRecordsTable extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        $table = $this->table('time_records');
        $table->addColumn('project_id', 'integer', [
                'null' => false
            ])
            ->addColumn('staff_id', 'integer', [
                'null' => false
            ])
            ->addColumn('project_task_id', 'integer', [
                'null' => true
            ])
            ->addColumn('work_date', 'date', [
                'null' => false
            ])
            ->addColumn('start_time', 'time', [
                'null' => true
            ])
            ->addColumn('end_time', 'time', [
                'null' => true
            ])
            ->addColumn('hours_worked', 'decimal', [
                'precision' => 6,
                'scale' => 2,
                'null' => false
            ])
            ->addColumn('hourly_rate', 'decimal', [
                'precision' => 8,
                'scale' => 2,
                'null' => true
            ])
            ->addColumn('total_amount', 'decimal', [
                'precision' => 10,
                'scale' => 2,
                'null' => true
            ])
            ->addColumn('work_type', 'enum', [
                'values' => ['regular', 'overtime', 'holiday', 'travel'],
                'default' => 'regular',
                'null' => false
            ])
            ->addColumn('description', 'text', [
                'null' => true
            ])
            ->addColumn('is_billable', 'boolean', [
                'default' => true,
                'null' => false
            ])
            ->addColumn('is_approved', 'boolean', [
                'default' => false,
                'null' => false
            ])
            ->addColumn('approved_by', 'integer', [
                'null' => true
            ])
            ->addColumn('approved_at', 'datetime', [
                'null' => true
            ])
            ->addColumn('notes', 'text', [
                'null' => true
            ])
            ->addColumn('active', 'boolean', [
                'default' => true,
                'null' => true
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'null' => true
            ])
            ->addColumn('modified', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'update' => 'CURRENT_TIMESTAMP',
                'null' => true
            ])
            ->addForeignKey('project_id', 'projects', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('staff_id', 'staff', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('project_task_id', 'project_tasks', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addForeignKey('approved_by', 'staff', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addIndex(['project_id'])
            ->addIndex(['staff_id'])
            ->addIndex(['work_date'])
            ->addIndex(['is_billable'])
            ->create();
    }
}
