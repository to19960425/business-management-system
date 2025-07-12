<?php
declare(strict_types=1);

use Migrations\BaseMigration;

class InitialSeedData extends BaseMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/migrations/4/en/migrations.html#the-change-method
     * @return void
     */
    public function up(): void
    {
        // Check if additional users need to be added (admin already exists)
        $userCount = $this->fetchRow('SELECT COUNT(*) as count FROM users WHERE username IN ("manager1", "staff1")');
        
        if ($userCount['count'] == 0) {
            $table = $this->table('users');
            $table->insert([
            [
                'username' => 'manager1',
                'email' => 'manager1@example.com',
                'password' => password_hash('manager123', PASSWORD_DEFAULT),
                'role' => 'manager',
                'active' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'username' => 'staff1',
                'email' => 'staff1@example.com',
                'password' => password_hash('staff123', PASSWORD_DEFAULT),
                'role' => 'staff',
                'active' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ]
        ])->save();
        }

        $staffCount = $this->fetchRow('SELECT COUNT(*) as count FROM staff WHERE employee_id IN ("EMP001", "EMP002", "EMP003")');
        
        if ($staffCount['count'] == 0) {
            $table = $this->table('staff');
        $table->insert([
            [
                'user_id' => 1,
                'employee_id' => 'EMP001',
                'first_name' => '太郎',
                'last_name' => '田中',
                'first_name_kana' => 'タロウ',
                'last_name_kana' => 'タナカ',
                'phone' => '03-1234-5678',
                'mobile' => '090-1234-5678',
                'position' => 'システム管理者',
                'department' => '管理部',
                'hire_date' => '2020-01-01',
                'salary' => 500000.00,
                'hourly_rate' => 3000.00,
                'notes' => '管理者権限を持つシステム管理者',
                'active' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 7,
                'employee_id' => 'EMP002',
                'first_name' => '花子',
                'last_name' => '佐藤',
                'first_name_kana' => 'ハナコ',
                'last_name_kana' => 'サトウ',
                'phone' => '03-2345-6789',
                'mobile' => '090-2345-6789',
                'position' => 'プロジェクトマネージャー',
                'department' => '開発部',
                'hire_date' => '2020-06-01',
                'salary' => 450000.00,
                'hourly_rate' => 2800.00,
                'notes' => 'Webアプリケーション開発のプロジェクトマネージャー',
                'active' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'user_id' => 8,
                'employee_id' => 'EMP003',
                'first_name' => '一郎',
                'last_name' => '鈴木',
                'first_name_kana' => 'イチロウ',
                'last_name_kana' => 'スズキ',
                'phone' => '03-3456-7890',
                'mobile' => '090-3456-7890',
                'position' => 'シニアエンジニア',
                'department' => '開発部',
                'hire_date' => '2021-03-01',
                'salary' => 400000.00,
                'hourly_rate' => 2500.00,
                'notes' => 'React/PHP開発のスペシャリスト',
                'active' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ]
        ])->save();
        }

        $clientCount = $this->fetchRow('SELECT COUNT(*) as count FROM clients WHERE client_code IN ("CLI001", "CLI002")');
        
        if ($clientCount['count'] == 0) {
            $table = $this->table('clients');
        $table->insert([
            [
                'client_code' => 'CLI001',
                'company_name' => '株式会社サンプル',
                'company_name_kana' => 'カブシキガイシャサンプル',
                'contact_name' => '山田太郎',
                'contact_email' => 'yamada@sample.co.jp',
                'contact_phone' => '03-4567-8901',
                'postal_code' => '100-0001',
                'address' => '東京都千代田区千代田1-1-1',
                'website' => 'https://sample.co.jp',
                'industry' => 'IT・ソフトウェア',
                'contract_type' => 'project',
                'notes' => 'Webアプリケーション開発の主要クライアント',
                'active' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ],
            [
                'client_code' => 'CLI002',
                'company_name' => '有限会社テスト商事',
                'company_name_kana' => 'ユウゲンガイシャテストショウジ',
                'contact_name' => '佐々木次郎',
                'contact_email' => 'sasaki@test-corp.co.jp',
                'contact_phone' => '03-5678-9012',
                'postal_code' => '150-0001',
                'address' => '東京都渋谷区渋谷1-2-3',
                'website' => 'https://test-corp.co.jp',
                'industry' => '製造業',
                'contract_type' => 'monthly',
                'notes' => '製造業向けシステム開発',
                'active' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ]
        ])->save();
        }

        $outsourcingCount = $this->fetchRow('SELECT COUNT(*) as count FROM outsourcing_companies WHERE company_code = "OUT001"');
        
        if ($outsourcingCount['count'] == 0) {
            $table = $this->table('outsourcing_companies');
        $table->insert([
            [
                'company_code' => 'OUT001',
                'company_name' => 'デザインパートナー株式会社',
                'company_name_kana' => 'デザインパートナーカブシキガイシャ',
                'contact_name' => '高橋美咲',
                'contact_email' => 'takahashi@design-partner.co.jp',
                'contact_phone' => '03-6789-0123',
                'postal_code' => '106-0032',
                'address' => '東京都港区六本木1-4-5',
                'website' => 'https://design-partner.co.jp',
                'specialization' => 'UI/UXデザイン',
                'hourly_rate' => 5000.00,
                'monthly_rate' => 800000.00,
                'contract_terms' => '月額固定、追加作業は別途見積もり',
                'notes' => 'UI/UXデザインの外注パートナー',
                'active' => 1,
                'created' => date('Y-m-d H:i:s'),
                'modified' => date('Y-m-d H:i:s')
            ]
        ])->save();
        }
    }

    public function down(): void
    {
        $this->execute('DELETE FROM outsourcing_companies');
        $this->execute('DELETE FROM clients');
        $this->execute('DELETE FROM staff');
        $this->execute('DELETE FROM users');
    }
}
