<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateClientsTable extends BaseMigration
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
        $table = $this->table('clients');
        $table->addColumn('client_code', 'string', [
                'limit' => 50,
                'null' => false
            ])
            ->addColumn('company_name', 'string', [
                'limit' => 255,
                'null' => false
            ])
            ->addColumn('company_name_kana', 'string', [
                'limit' => 255,
                'null' => true
            ])
            ->addColumn('contact_name', 'string', [
                'limit' => 100,
                'null' => true
            ])
            ->addColumn('contact_email', 'string', [
                'limit' => 255,
                'null' => true
            ])
            ->addColumn('contact_phone', 'string', [
                'limit' => 20,
                'null' => true
            ])
            ->addColumn('postal_code', 'string', [
                'limit' => 10,
                'null' => true
            ])
            ->addColumn('address', 'text', [
                'null' => true
            ])
            ->addColumn('website', 'string', [
                'limit' => 255,
                'null' => true
            ])
            ->addColumn('industry', 'string', [
                'limit' => 100,
                'null' => true
            ])
            ->addColumn('contract_type', 'enum', [
                'values' => ['monthly', 'project', 'hourly'],
                'default' => 'project',
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
            ->addIndex(['client_code'], ['unique' => true])
            ->addIndex(['company_name'])
            ->create();
    }
}
