# 技術仕様書

## 1. システム概要

### 1.1 プロジェクト名
Business Management System (BMS)

### 1.2 システムの目的
現在のSOUシステムをベースに、モダンな技術スタックで構築する業務管理システム

### 1.3 対象ユーザー
- 管理者
- マネージャー
- スタッフ
- クライアント（将来的）

## 2. 技術スタック

### 2.1 フロントエンド
- **Base**: React 18.x + TypeScript 5.x
- **Build Tool**: Vite 4.x
- **UI Library**: Material-UI (MUI) v5
- **State Management**: Redux Toolkit または Zustand
- **Routing**: React Router v6
- **HTTP Client**: Axios
- **Form Management**: React Hook Form + Yup
- **Charts**: Chart.js または Recharts
- **Styling**: Styled Components または Emotion

### 2.2 バックエンド
- **Framework**: CakePHP 5.x
- **PHP Version**: 8.2+
- **Database**: MySQL 8.0
- **Authentication**: JWT (JSON Web Token)
- **API Design**: RESTful API
- **PDF Generation**: TCPDF
- **Email**: CakePHP Mailer
- **Caching**: Redis (オプション)

### 2.3 インフラストラクチャ
- **Containerization**: Docker + Docker Compose
- **Web Server**: Apache (PHP) + Nginx (Reverse Proxy)
- **Database**: MySQL 8.0
- **Development Tools**: phpMyAdmin, Mailhog

## 3. アーキテクチャ

### 3.1 全体構成
```
┌─────────────────┐    ┌─────────────────┐
│   React App     │    │   CakePHP API   │
│   (Frontend)    │<-->│   (Backend)     │
│   Port: 3000    │    │   Port: 8000    │
└─────────────────┘    └─────────────────┘
         │                       │
         │              ┌─────────────────┐
         │              │   MySQL 8.0     │
         │              │   (Database)    │
         │              │   Port: 3306    │
         │              └─────────────────┘
         │
┌─────────────────┐
│   Nginx         │
│   (Proxy)       │
│   Port: 80      │
└─────────────────┘
```

### 3.2 フロントエンドアーキテクチャ
```
src/
├── components/          # 再利用可能コンポーネント
│   ├── common/         # 汎用コンポーネント
│   ├── forms/          # フォーム関連
│   └── ui/             # UI部品
├── pages/              # ページコンポーネント
│   ├── auth/           # 認証関連
│   ├── dashboard/      # ダッシュボード
│   ├── staff/          # スタッフ管理
│   ├── clients/        # クライアント管理
│   └── projects/       # プロジェクト管理
├── hooks/              # カスタムフック
├── services/           # API通信
├── store/              # 状態管理
├── types/              # TypeScript型定義
├── utils/              # ユーティリティ
├── constants/          # 定数
└── styles/             # スタイル定義
```

### 3.3 バックエンドアーキテクチャ
```
src/
├── Controller/         # APIコントローラー
│   ├── Api/           # API用コントローラー
│   │   ├── AuthController.php
│   │   ├── StaffController.php
│   │   └── ProjectsController.php
│   └── AppController.php
├── Model/             # データモデル
│   ├── Entity/        # エンティティクラス
│   └── Table/         # テーブルクラス
├── Service/           # ビジネスロジック
│   ├── AuthService.php
│   ├── StaffService.php
│   └── ProjectService.php
├── Middleware/        # ミドルウェア
│   └── AuthenticationMiddleware.php
└── Utility/           # ユーティリティ
```

## 4. データベース設計

### 4.1 主要テーブル

#### 4.1.1 users テーブル
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'manager', 'staff') DEFAULT 'staff',
    active BOOLEAN DEFAULT TRUE,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### 4.1.2 staff テーブル
```sql
CREATE TABLE staff (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    kana VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(20),
    department VARCHAR(100),
    position VARCHAR(100),
    hire_date DATE,
    hourly_rate DECIMAL(10,2),
    active BOOLEAN DEFAULT TRUE,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);
```

#### 4.1.3 clients テーブル
```sql
CREATE TABLE clients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    company_name VARCHAR(255) NOT NULL,
    contact_name VARCHAR(255),
    email VARCHAR(255),
    phone VARCHAR(20),
    address TEXT,
    industry VARCHAR(100),
    active BOOLEAN DEFAULT TRUE,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

#### 4.1.4 projects テーブル
```sql
CREATE TABLE projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    client_id INT NOT NULL,
    project_number VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    start_date DATE,
    end_date DATE,
    deadline DATE,
    budget DECIMAL(12,2),
    status ENUM('planning', 'in_progress', 'completed', 'cancelled') DEFAULT 'planning',
    manager_id INT,
    created DATETIME DEFAULT CURRENT_TIMESTAMP,
    modified DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (client_id) REFERENCES clients(id),
    FOREIGN KEY (manager_id) REFERENCES staff(id)
);
```

### 4.2 インデックス設計
- 主キー: 全テーブル
- 外部キー: 関連テーブル
- 検索用: email, phone, project_number
- 複合インデックス: status + created, client_id + status

## 5. API設計

### 5.1 エンドポイント一覧

#### 5.1.1 認証系
```
POST   /api/v1/auth/login          # ログイン
POST   /api/v1/auth/logout         # ログアウト
POST   /api/v1/auth/refresh        # トークン更新
GET    /api/v1/auth/profile        # プロフィール取得
```

#### 5.1.2 スタッフ管理
```
GET    /api/v1/staff               # スタッフ一覧
POST   /api/v1/staff               # スタッフ登録
GET    /api/v1/staff/{id}          # スタッフ詳細
PUT    /api/v1/staff/{id}          # スタッフ更新
DELETE /api/v1/staff/{id}          # スタッフ削除
```

#### 5.1.3 クライアント管理
```
GET    /api/v1/clients             # クライアント一覧
POST   /api/v1/clients             # クライアント登録
GET    /api/v1/clients/{id}        # クライアント詳細
PUT    /api/v1/clients/{id}        # クライアント更新
DELETE /api/v1/clients/{id}        # クライアント削除
```

#### 5.1.4 プロジェクト管理
```
GET    /api/v1/projects            # プロジェクト一覧
POST   /api/v1/projects            # プロジェクト登録
GET    /api/v1/projects/{id}       # プロジェクト詳細
PUT    /api/v1/projects/{id}       # プロジェクト更新
DELETE /api/v1/projects/{id}       # プロジェクト削除
```

### 5.2 レスポンス形式

#### 5.2.1 成功レスポンス
```json
{
  "success": true,
  "data": {
    "id": 1,
    "name": "Example"
  },
  "message": "Success"
}
```

#### 5.2.2 エラーレスポンス
```json
{
  "success": false,
  "error": {
    "code": "VALIDATION_ERROR",
    "message": "Validation failed",
    "details": {
      "email": ["Email is required"]
    }
  }
}
```

### 5.3 認証
- JWT トークンベースの認証
- Authorization ヘッダーでトークン送信
- トークンの有効期限: 1時間
- リフレッシュトークン: 7日間

## 6. セキュリティ

### 6.1 認証・認可
- パスワードハッシュ化 (bcrypt)
- JWT トークン
- RBAC (Role-Based Access Control)
- セッション管理

### 6.2 データ保護
- 入力値検証
- XSS対策
- SQL インジェクション対策
- CSRF対策

### 6.3 通信セキュリティ
- HTTPS通信
- CORS設定
- セキュリティヘッダー

## 7. パフォーマンス

### 7.1 フロントエンド
- コード分割 (Code Splitting)
- 遅延読み込み (Lazy Loading)
- 画像最適化
- キャッシュ戦略

### 7.2 バックエンド
- データベースクエリ最適化
- インデックス設計
- キャッシュ (Redis)
- ページネーション

## 8. 国際化・多言語対応

### 8.1 対応言語
- 日本語 (メイン)
- 英語 (将来対応)

### 8.2 実装方針
- React: react-i18next
- CakePHP: 内蔵の国際化機能
- データベース: UTF-8mb4

## 9. テスト戦略

### 9.1 フロントエンド
- Unit Test: Jest + React Testing Library
- Integration Test: Cypress
- E2E Test: Playwright

### 9.2 バックエンド
- Unit Test: PHPUnit
- Integration Test: CakePHP Test Suite
- API Test: Postman/Newman

## 10. 運用・保守

### 10.1 ログ管理
- アプリケーションログ
- エラーログ
- アクセスログ

### 10.2 監視
- システムメトリクス
- アプリケーションメトリクス
- ヘルスチェック

### 10.3 バックアップ
- データベースバックアップ
- アプリケーションコードバックアップ
- 設定ファイルバックアップ

## 11. 今後の拡張性

### 11.1 機能拡張
- モバイルアプリ対応
- 外部システム連携
- AI機能の追加

### 11.2 技術的拡張
- マイクロサービス化
- クラウドネイティブ対応
- GraphQL対応