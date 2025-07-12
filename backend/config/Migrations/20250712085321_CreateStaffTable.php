<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class CreateStaffTable extends BaseMigration
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
        $table = $this->table('staff');
        $table->addColumn('user_id', 'integer', [
                'null' => false
            ])
            ->addColumn('employee_id', 'string', [
                'limit' => 50,
                'null' => false
            ])
            ->addColumn('first_name', 'string', [
                'limit' => 100,
                'null' => false
            ])
            ->addColumn('last_name', 'string', [
                'limit' => 100,
                'null' => false
            ])
            ->addColumn('first_name_kana', 'string', [
                'limit' => 100,
                'null' => true
            ])
            ->addColumn('last_name_kana', 'string', [
                'limit' => 100,
                'null' => true
            ])
            ->addColumn('phone', 'string', [
                'limit' => 20,
                'null' => true
            ])
            ->addColumn('mobile', 'string', [
                'limit' => 20,
                'null' => true
            ])
            ->addColumn('position', 'string', [
                'limit' => 100,
                'null' => true
            ])
            ->addColumn('department', 'string', [
                'limit' => 100,
                'null' => true
            ])
            ->addColumn('hire_date', 'date', [
                'null' => true
            ])
            ->addColumn('salary', 'decimal', [
                'precision' => 10,
                'scale' => 2,
                'null' => true
            ])
            ->addColumn('hourly_rate', 'decimal', [
                'precision' => 8,
                'scale' => 2,
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
            ->addForeignKey('user_id', 'users', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->addIndex(['employee_id'], ['unique' => true])
            ->addIndex(['user_id'], ['unique' => true])
            ->create();
    }
}
