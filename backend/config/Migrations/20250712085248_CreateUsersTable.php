<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateUsersTable extends BaseMigration
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
        if (!$this->hasTable('users')) {
            $table = $this->table('users');
            $table->addColumn('username', 'string', [
                    'limit' => 255,
                    'null' => false
                ])
                ->addColumn('email', 'string', [
                    'limit' => 255,
                    'null' => false
                ])
                ->addColumn('password', 'string', [
                    'limit' => 255,
                    'null' => false
                ])
                ->addColumn('role', 'enum', [
                    'values' => ['admin', 'manager', 'staff'],
                    'default' => 'staff',
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
                ->addIndex(['username'], ['unique' => true])
                ->addIndex(['email'], ['unique' => true])
                ->create();
        }
    }
}
