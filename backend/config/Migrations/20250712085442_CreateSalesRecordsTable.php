<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateSalesRecordsTable extends BaseMigration
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
        $table = $this->table('sales_records');
        $table->addColumn('project_id', 'integer', [
                'null' => false
            ])
            ->addColumn('client_id', 'integer', [
                'null' => false
            ])
            ->addColumn('invoice_number', 'string', [
                'limit' => 50,
                'null' => false
            ])
            ->addColumn('invoice_date', 'date', [
                'null' => false
            ])
            ->addColumn('due_date', 'date', [
                'null' => true
            ])
            ->addColumn('total_hours', 'decimal', [
                'precision' => 8,
                'scale' => 2,
                'null' => true
            ])
            ->addColumn('hourly_rate', 'decimal', [
                'precision' => 8,
                'scale' => 2,
                'null' => true
            ])
            ->addColumn('subtotal', 'decimal', [
                'precision' => 12,
                'scale' => 2,
                'null' => false
            ])
            ->addColumn('tax_rate', 'decimal', [
                'precision' => 5,
                'scale' => 4,
                'null' => true,
                'default' => 0.10
            ])
            ->addColumn('tax_amount', 'decimal', [
                'precision' => 12,
                'scale' => 2,
                'null' => true
            ])
            ->addColumn('total_amount', 'decimal', [
                'precision' => 12,
                'scale' => 2,
                'null' => false
            ])
            ->addColumn('payment_status', 'enum', [
                'values' => ['pending', 'paid', 'overdue', 'cancelled'],
                'default' => 'pending',
                'null' => false
            ])
            ->addColumn('payment_date', 'date', [
                'null' => true
            ])
            ->addColumn('payment_method', 'enum', [
                'values' => ['bank_transfer', 'cash', 'credit_card', 'check'],
                'null' => true
            ])
            ->addColumn('description', 'text', [
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
            ->addForeignKey('client_id', 'clients', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addIndex(['invoice_number'], ['unique' => true])
            ->addIndex(['project_id'])
            ->addIndex(['client_id'])
            ->addIndex(['payment_status'])
            ->addIndex(['invoice_date'])
            ->create();
    }
}
