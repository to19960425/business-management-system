# Phase 2: データベース設計・実装タスク (24タスク)

## 2.1 データベース設計

### Issue #27: 現システムのテーブル構成分析とドキュメント化
- **Priority**: High
- **Labels**: database, analysis, documentation
- **Description**: 
  - 現在のSOUシステムのテーブル構成を分析
  - 各テーブルの関係性を把握
  - データベース設計書の作成
- **Acceptance Criteria**:
  - [ ] 現システムの全テーブルが一覧化されている
  - [ ] 各テーブルの用途が明確に記載されている
  - [ ] データベース設計書が作成されている

### Issue #28: 新システム用ER図作成
- **Priority**: High
- **Labels**: database, design
- **Description**: 
  - 新システム用のER図を作成
  - エンティティ間の関係性を明確化
  - 正規化を考慮した設計
- **Acceptance Criteria**:
  - [ ] 包括的なER図が作成されている
  - [ ] 全エンティティ間の関係が明確
  - [ ] 正規化が適切に行われている

### Issue #29: テーブル正規化設計
- **Priority**: High
- **Labels**: database, normalization
- **Description**: 
  - 第3正規化までの正規化設計
  - データの冗長性を排除
  - パフォーマンスとのバランスを考慮
- **Acceptance Criteria**:
  - [ ] 第3正規化が適切に実施されている
  - [ ] データの冗長性が最小限に抑えられている
  - [ ] パフォーマンスが考慮されている

### Issue #30: インデックス設計とパフォーマンス検討
- **Priority**: Medium
- **Labels**: database, performance
- **Description**: 
  - 検索性能を考慮したインデックス設計
  - クエリパフォーマンスの最適化
  - 複合インデックスの検討
- **Acceptance Criteria**:
  - [ ] 適切なインデックスが設計されている
  - [ ] パフォーマンステストが実施されている
  - [ ] 複合インデックスが適切に配置されている

### Issue #31: 外部キー制約設計
- **Priority**: High
- **Labels**: database, constraints
- **Description**: 
  - 外部キー制約の設計
  - 参照整合性の確保
  - カスケード削除の検討
- **Acceptance Criteria**:
  - [ ] 適切な外部キー制約が設定されている
  - [ ] 参照整合性が確保されている
  - [ ] カスケード削除が適切に設定されている

## 2.2 マイグレーション作成

### Issue #32: usersテーブル作成マイグレーション
- **Priority**: High
- **Labels**: database, migration
- **Description**: 
  - ユーザー情報を格納するテーブル作成
  - 認証情報、権限情報を含む
  - セキュリティを考慮した設計
- **Acceptance Criteria**:
  - [ ] usersテーブルが作成されている
  - [ ] 適切なカラムが定義されている
  - [ ] セキュリティが考慮されている

### Issue #33: staffテーブル作成マイグレーション
- **Priority**: High
- **Labels**: database, migration
- **Description**: 
  - スタッフ詳細情報を格納するテーブル作成
  - 個人情報、勤務情報を含む
  - プライバシーを考慮した設計
- **Acceptance Criteria**:
  - [ ] staffテーブルが作成されている
  - [ ] 必要なカラムが全て定義されている
  - [ ] プライバシーが考慮されている

### Issue #34: clientsテーブル作成マイグレーション
- **Priority**: High
- **Labels**: database, migration
- **Description**: 
  - クライアント情報を格納するテーブル作成
  - 企業情報、連絡先情報を含む
  - 検索性能を考慮した設計
- **Acceptance Criteria**:
  - [ ] clientsテーブルが作成されている
  - [ ] 企業情報が適切に構造化されている
  - [ ] 検索用インデックスが設定されている

### Issue #35: outsourcing_companiesテーブル作成マイグレーション
- **Priority**: High
- **Labels**: database, migration
- **Description**: 
  - 協力会社情報を格納するテーブル作成
  - 企業情報、取引条件を含む
  - 契約情報の管理
- **Acceptance Criteria**:
  - [ ] outsourcing_companiesテーブルが作成されている
  - [ ] 取引条件が適切に定義されている
  - [ ] 契約情報が管理可能

### Issue #36: projectsテーブル作成マイグレーション
- **Priority**: High
- **Labels**: database, migration
- **Description**: 
  - プロジェクト情報を格納するテーブル作成
  - 案件情報、進捗情報を含む
  - ステータス管理の実装
- **Acceptance Criteria**:
  - [ ] projectsテーブルが作成されている
  - [ ] 案件情報が適切に構造化されている
  - [ ] ステータス管理が実装されている

### Issue #37: project_tasksテーブル作成マイグレーション
- **Priority**: High
- **Labels**: database, migration
- **Description**: 
  - プロジェクト内のタスク情報を格納するテーブル作成
  - 作業内容、担当者情報を含む
  - 進捗管理の実装
- **Acceptance Criteria**:
  - [ ] project_tasksテーブルが作成されている
  - [ ] 作業内容が適切に定義されている
  - [ ] 進捗管理が実装されている

### Issue #38: time_recordsテーブル作成マイグレーション
- **Priority**: High
- **Labels**: database, migration
- **Description**: 
  - 時間記録を格納するテーブル作成
  - 作業時間、作業内容を含む
  - 集計機能を考慮した設計
- **Acceptance Criteria**:
  - [ ] time_recordsテーブルが作成されている
  - [ ] 作業時間が適切に記録される
  - [ ] 集計機能が実装されている

### Issue #39: sales_recordsテーブル作成マイグレーション
- **Priority**: High
- **Labels**: database, migration
- **Description**: 
  - 売上記録を格納するテーブル作成
  - 売上情報、支払い情報を含む
  - 会計処理を考慮した設計
- **Acceptance Criteria**:
  - [ ] sales_recordsテーブルが作成されている
  - [ ] 売上情報が適切に記録される
  - [ ] 会計処理が考慮されている

### Issue #40: 初期データ（シードデータ）作成
- **Priority**: Medium
- **Labels**: database, seed
- **Description**: 
  - 開発・テスト用の初期データ作成
  - マスタデータの準備
  - サンプルデータの作成
- **Acceptance Criteria**:
  - [ ] 必要なマスタデータが作成されている
  - [ ] 開発用サンプルデータが準備されている
  - [ ] データの整合性が確保されている

## 2.3 CakePHP Model作成

### Issue #41: User Entity/Tableクラス作成
- **Priority**: High
- **Labels**: backend, model
- **Description**: 
  - Userエンティティとテーブルクラスの作成
  - 認証関連の機能実装
  - バリデーション設定
- **Acceptance Criteria**:
  - [ ] User Entity/Tableクラスが作成されている
  - [ ] 認証機能が実装されている
  - [ ] バリデーションが設定されている

### Issue #42: Staff Entity/Tableクラス作成
- **Priority**: High
- **Labels**: backend, model
- **Description**: 
  - Staffエンティティとテーブルクラスの作成
  - スタッフ管理機能の実装
  - 権限管理の実装
- **Acceptance Criteria**:
  - [ ] Staff Entity/Tableクラスが作成されている
  - [ ] スタッフ管理機能が実装されている
  - [ ] 権限管理が実装されている

### Issue #43: Client Entity/Tableクラス作成
- **Priority**: High
- **Labels**: backend, model
- **Description**: 
  - Clientエンティティとテーブルクラスの作成
  - クライアント管理機能の実装
  - 検索機能の実装
- **Acceptance Criteria**:
  - [ ] Client Entity/Tableクラスが作成されている
  - [ ] クライアント管理機能が実装されている
  - [ ] 検索機能が実装されている

### Issue #44: OutsourcingCompany Entity/Tableクラス作成
- **Priority**: High
- **Labels**: backend, model
- **Description**: 
  - OutsourcingCompanyエンティティとテーブルクラスの作成
  - 協力会社管理機能の実装
  - 取引条件管理の実装
- **Acceptance Criteria**:
  - [ ] OutsourcingCompany Entity/Tableクラスが作成されている
  - [ ] 協力会社管理機能が実装されている
  - [ ] 取引条件管理が実装されている

### Issue #45: Project Entity/Tableクラス作成
- **Priority**: High
- **Labels**: backend, model
- **Description**: 
  - Projectエンティティとテーブルクラスの作成
  - プロジェクト管理機能の実装
  - ステータス管理の実装
- **Acceptance Criteria**:
  - [ ] Project Entity/Tableクラスが作成されている
  - [ ] プロジェクト管理機能が実装されている
  - [ ] ステータス管理が実装されている

### Issue #46: ProjectTask Entity/Tableクラス作成
- **Priority**: High
- **Labels**: backend, model
- **Description**: 
  - ProjectTaskエンティティとテーブルクラスの作成
  - タスク管理機能の実装
  - 進捗管理の実装
- **Acceptance Criteria**:
  - [ ] ProjectTask Entity/Tableクラスが作成されている
  - [ ] タスク管理機能が実装されている
  - [ ] 進捗管理が実装されている

### Issue #47: TimeRecord Entity/Tableクラス作成
- **Priority**: High
- **Labels**: backend, model
- **Description**: 
  - TimeRecordエンティティとテーブルクラスの作成
  - 時間記録機能の実装
  - 集計機能の実装
- **Acceptance Criteria**:
  - [ ] TimeRecord Entity/Tableクラスが作成されている
  - [ ] 時間記録機能が実装されている
  - [ ] 集計機能が実装されている

### Issue #48: SalesRecord Entity/Tableクラス作成
- **Priority**: High
- **Labels**: backend, model
- **Description**: 
  - SalesRecordエンティティとテーブルクラスの作成
  - 売上記録機能の実装
  - 会計処理の実装
- **Acceptance Criteria**:
  - [ ] SalesRecord Entity/Tableクラスが作成されている
  - [ ] 売上記録機能が実装されている
  - [ ] 会計処理が実装されている

### Issue #49: 全モデルのアソシエーション設定
- **Priority**: High
- **Labels**: backend, model, relationship
- **Description**: 
  - 全モデル間のアソシエーション設定
  - 関連データの取得最適化
  - 整合性チェックの実装
- **Acceptance Criteria**:
  - [ ] 全モデル間のアソシエーションが設定されている
  - [ ] 関連データの取得が最適化されている
  - [ ] 整合性チェックが実装されている

### Issue #50: 各モデルのバリデーション設定
- **Priority**: High
- **Labels**: backend, model, validation
- **Description**: 
  - 各モデルのバリデーション設定
  - 業務ルールの実装
  - エラーメッセージの多言語対応
- **Acceptance Criteria**:
  - [ ] 各モデルのバリデーションが設定されている
  - [ ] 業務ルールが実装されている
  - [ ] エラーメッセージが多言語対応されている

## 推定作業時間
- **合計**: 24タスク × 1-2日 = 約4-6週間
- **設計フェーズ**: Issue #27-31 (1週間)
- **マイグレーション**: Issue #32-40 (1-2週間)
- **Model作成**: Issue #41-50 (2-3週間)

## 依存関係
- Issue #27-31 は順次実行が必要
- Issue #32-40 は #27-31 完了後に並行実行可能
- Issue #41-50 は #32-40 完了後に並行実行可能
- Issue #49-50 は #41-48 完了後に実行