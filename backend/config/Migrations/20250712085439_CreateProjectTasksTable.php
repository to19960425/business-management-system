<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateProjectTasksTable extends BaseMigration
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
        $table = $this->table('project_tasks');
        $table->addColumn('project_id', 'integer', [
                'null' => false
            ])
            ->addColumn('assigned_staff_id', 'integer', [
                'null' => true
            ])
            ->addColumn('task_name', 'string', [
                'limit' => 255,
                'null' => false
            ])
            ->addColumn('description', 'text', [
                'null' => true
            ])
            ->addColumn('status', 'enum', [
                'values' => ['pending', 'in_progress', 'testing', 'completed', 'cancelled'],
                'default' => 'pending',
                'null' => false
            ])
            ->addColumn('priority', 'enum', [
                'values' => ['low', 'medium', 'high', 'urgent'],
                'default' => 'medium',
                'null' => false
            ])
            ->addColumn('estimated_hours', 'decimal', [
                'precision' => 6,
                'scale' => 2,
                'null' => true
            ])
            ->addColumn('actual_hours', 'decimal', [
                'precision' => 6,
                'scale' => 2,
                'null' => true,
                'default' => 0
            ])
            ->addColumn('start_date', 'date', [
                'null' => true
            ])
            ->addColumn('due_date', 'date', [
                'null' => true
            ])
            ->addColumn('completed_date', 'date', [
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
            ->addForeignKey('assigned_staff_id', 'staff', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addIndex(['project_id'])
            ->addIndex(['assigned_staff_id'])
            ->addIndex(['status'])
            ->create();
    }
}
