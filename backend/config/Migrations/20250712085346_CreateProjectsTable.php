<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateProjectsTable extends BaseMigration
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
        $table = $this->table('projects');
        $table->addColumn('client_id', 'integer', [
                'null' => false
            ])
            ->addColumn('manager_id', 'integer', [
                'null' => false
            ])
            ->addColumn('outsourcing_company_id', 'integer', [
                'null' => true
            ])
            ->addColumn('project_code', 'string', [
                'limit' => 50,
                'null' => false
            ])
            ->addColumn('project_name', 'string', [
                'limit' => 255,
                'null' => false
            ])
            ->addColumn('description', 'text', [
                'null' => true
            ])
            ->addColumn('status', 'enum', [
                'values' => ['planning', 'active', 'on_hold', 'completed', 'cancelled'],
                'default' => 'planning',
                'null' => false
            ])
            ->addColumn('priority', 'enum', [
                'values' => ['low', 'medium', 'high', 'urgent'],
                'default' => 'medium',
                'null' => false
            ])
            ->addColumn('start_date', 'date', [
                'null' => true
            ])
            ->addColumn('end_date', 'date', [
                'null' => true
            ])
            ->addColumn('deadline', 'date', [
                'null' => true
            ])
            ->addColumn('budget', 'decimal', [
                'precision' => 12,
                'scale' => 2,
                'null' => true
            ])
            ->addColumn('estimated_hours', 'decimal', [
                'precision' => 8,
                'scale' => 2,
                'null' => true
            ])
            ->addColumn('hourly_rate', 'decimal', [
                'precision' => 8,
                'scale' => 2,
                'null' => true
            ])
            ->addColumn('contract_type', 'enum', [
                'values' => ['fixed', 'hourly', 'monthly'],
                'default' => 'fixed',
                'null' => false
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
            ->addForeignKey('client_id', 'clients', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addForeignKey('manager_id', 'staff', 'id', ['delete' => 'RESTRICT', 'update' => 'CASCADE'])
            ->addForeignKey('outsourcing_company_id', 'outsourcing_companies', 'id', ['delete' => 'SET_NULL', 'update' => 'CASCADE'])
            ->addIndex(['project_code'], ['unique' => true])
            ->addIndex(['client_id'])
            ->addIndex(['manager_id'])
            ->addIndex(['status'])
            ->create();
    }
}
