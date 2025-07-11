# Phase 1: 基盤構築タスク (26タスク)

## 1.1 プロジェクト初期セットアップ

### Issue #1: プロジェクトディレクトリ構成作成
- **Priority**: High
- **Labels**: infrastructure, setup
- **Assignee**: 
- **Description**: 
  - 基本的なディレクトリ構成を作成
  - frontend/, backend/, docker/, docs/ の作成
  - .gitignore, README.md の作成
- **Acceptance Criteria**:
  - [ ] 基本ディレクトリ構成が作成されている
  - [ ] .gitignore が適切に設定されている
  - [ ] README.md に基本情報が記載されている

### Issue #2: .gitignore、README.md作成
- **Priority**: High
- **Labels**: documentation, setup
- **Description**: 
  - 包括的な .gitignore ファイルの作成
  - プロジェクト概要を含む README.md の作成
- **Acceptance Criteria**:
  - [ ] Node.js, PHP, Docker関連ファイルが適切に除外されている
  - [ ] README.md にセットアップ手順が記載されている

### Issue #3: 基本的なdocker-compose.yml作成
- **Priority**: High
- **Labels**: docker, infrastructure
- **Description**: 
  - 全サービスを含むdocker-compose.ymlの作成
  - 適切なネットワーク設定
- **Acceptance Criteria**:
  - [ ] 全サービス（db, backend, frontend, nginx, etc）が定義されている
  - [ ] 適切なポート設定がされている

### Issue #4: 環境変数テンプレート(.env.example)作成
- **Priority**: High
- **Labels**: configuration, security
- **Description**: 
  - 包括的な環境変数テンプレートの作成
  - セキュリティに関する設定項目の明記
- **Acceptance Criteria**:
  - [ ] 全サービスの環境変数が定義されている
  - [ ] セキュリティ関連の設定が含まれている

## 1.2 Docker環境構築

### Issue #5: MySQL用Dockerfileとinit.sql作成
- **Priority**: High
- **Labels**: docker, database
- **Description**: 
  - MySQL 8.0 の設定
  - 初期データベースとユーザーの作成
  - 日本語対応の設定
- **Acceptance Criteria**:
  - [ ] UTF-8対応のMySQL設定
  - [ ] 初期データベースが作成される
  - [ ] 日本時間の設定

### Issue #6: PHP/Apache用Dockerfile作成
- **Priority**: High
- **Labels**: docker, backend
- **Description**: 
  - PHP 8.2 + Apache の設定
  - 必要なPHP拡張の追加
  - CakePHP用の設定
- **Acceptance Criteria**:
  - [ ] PHP 8.2がインストールされている
  - [ ] 必要なPHP拡張が全て有効
  - [ ] Apache設定が適切

### Issue #7: Node.js用Dockerfile作成
- **Priority**: High
- **Labels**: docker, frontend
- **Description**: 
  - Node.js 18 Alpine の設定
  - React開発環境の構築
- **Acceptance Criteria**:
  - [ ] Node.js 18がインストールされている
  - [ ] 開発用の設定が適切
  - [ ] ホットリロードが機能する

### Issue #8: Nginx設定ファイルとDockerfile作成
- **Priority**: High
- **Labels**: docker, nginx
- **Description**: 
  - リバースプロキシの設定
  - フロントエンドとバックエンドのルーティング
- **Acceptance Criteria**:
  - [ ] APIリクエストがバックエンドに転送される
  - [ ] 静的ファイルが適切に配信される
  - [ ] セキュリティヘッダーが設定されている

### Issue #9: phpMyAdmin設定追加
- **Priority**: Medium
- **Labels**: docker, tools
- **Description**: 
  - phpMyAdmin の設定
  - データベース管理の環境構築
- **Acceptance Criteria**:
  - [ ] phpMyAdminが正常に動作する
  - [ ] データベースに接続できる

### Issue #10: Docker Compose全体の動作確認
- **Priority**: High
- **Labels**: docker, testing
- **Description**: 
  - 全サービスの正常な起動確認
  - サービス間の通信確認
- **Acceptance Criteria**:
  - [ ] 全サービスが正常に起動する
  - [ ] サービス間の通信が正常
  - [ ] 各ポートでアクセス可能

## 1.3 CakePHP基盤構築

### Issue #11: CakePHP 5.x プロジェクト作成
- **Priority**: High
- **Labels**: backend, setup
- **Description**: 
  - CakePHP 5.x の新規プロジェクト作成
  - 基本的なディレクトリ構成の確認
- **Acceptance Criteria**:
  - [ ] CakePHP 5.x プロジェクトが作成されている
  - [ ] 基本的なファイル構成が整っている

### Issue #12: データベース接続設定
- **Priority**: High
- **Labels**: backend, database
- **Description**: 
  - データベース接続設定の構成
  - 環境変数を使用した設定
- **Acceptance Criteria**:
  - [ ] データベース接続が正常に動作する
  - [ ] 環境変数が適切に使用されている

### Issue #13: CORS設定とミドルウェア設定
- **Priority**: High
- **Labels**: backend, api
- **Description**: 
  - フロントエンドからのAPIアクセスを可能にするCORS設定
  - 必要なミドルウェアの設定
- **Acceptance Criteria**:
  - [ ] フロントエンドからAPIアクセスが可能
  - [ ] 適切なCORSヘッダーが設定されている

### Issue #14: API用ルーティング基本設定
- **Priority**: High
- **Labels**: backend, api
- **Description**: 
  - RESTful APIのルーティング設定
  - APIバージョニングの設定
- **Acceptance Criteria**:
  - [ ] /api/v1 プレフィックスでアクセス可能
  - [ ] RESTfulルーティングが設定されている

### Issue #15: AppController基本設定
- **Priority**: High
- **Labels**: backend, core
- **Description**: 
  - 基本的なAppControllerの設定
  - 共通処理の実装
- **Acceptance Criteria**:
  - [ ] JSON APIレスポンスの基本設定
  - [ ] 共通エラーハンドリングの実装

### Issue #16: エラーハンドリング設定
- **Priority**: High
- **Labels**: backend, error-handling
- **Description**: 
  - API用のエラーハンドリング設定
  - 適切なHTTPステータスコードの返却
- **Acceptance Criteria**:
  - [ ] API用のエラーレスポンス形式が統一されている
  - [ ] 適切なHTTPステータスコードが返される

### Issue #17: ログ設定とデバッグ設定
- **Priority**: Medium
- **Labels**: backend, logging
- **Description**: 
  - ログ設定の構成
  - デバッグ環境の設定
- **Acceptance Criteria**:
  - [ ] ログが適切に出力される
  - [ ] デバッグ情報が開発環境で表示される

### Issue #18: API用レスポンス形式統一
- **Priority**: High
- **Labels**: backend, api
- **Description**: 
  - APIレスポンスの形式統一
  - 成功・エラー時の統一レスポンス
- **Acceptance Criteria**:
  - [ ] レスポンス形式が統一されている
  - [ ] 成功・エラー時のレスポンスが適切

## 1.4 React基盤構築

### Issue #19: Vite + React + TypeScript プロジェクト作成
- **Priority**: High
- **Labels**: frontend, setup
- **Description**: 
  - Vite を使用したReact + TypeScriptプロジェクトの作成
  - 基本的な設定ファイルの構成
- **Acceptance Criteria**:
  - [ ] Vite + React + TypeScript プロジェクトが作成されている
  - [ ] 基本的な設定が完了している

### Issue #20: フォルダ構成作成（src配下）
- **Priority**: High
- **Labels**: frontend, structure
- **Description**: 
  - src配下の適切なフォルダ構成の作成
  - コンポーネント、ページ、ユーティリティの分離
- **Acceptance Criteria**:
  - [ ] 適切なフォルダ構成が作成されている
  - [ ] ファイル命名規則が定義されている

### Issue #21: Material-UI (MUI) セットアップ
- **Priority**: High
- **Labels**: frontend, ui
- **Description**: 
  - Material-UI (MUI) の導入と設定
  - 基本的なテーマの設定
- **Acceptance Criteria**:
  - [ ] MUIが正常にインストールされている
  - [ ] 基本的なテーマが適用されている

### Issue #22: React Router基本設定
- **Priority**: High
- **Labels**: frontend, routing
- **Description**: 
  - React Router v6 の設定
  - 基本的なルーティング設定
- **Acceptance Criteria**:
  - [ ] React Routerが正常に動作する
  - [ ] 基本的なルーティングが設定されている

### Issue #23: Axios設定とAPIクライアント作成
- **Priority**: High
- **Labels**: frontend, api
- **Description**: 
  - Axiosの設定と基本的なAPIクライアントの作成
  - 認証トークンの自動付与設定
- **Acceptance Criteria**:
  - [ ] APIクライアントが正常に動作する
  - [ ] 基本的な設定が完了している

### Issue #24: 基本レイアウトコンポーネント作成
- **Priority**: High
- **Labels**: frontend, components
- **Description**: 
  - 基本的なレイアウトコンポーネントの作成
  - ヘッダー、フッター、サイドバーの基本構造
- **Acceptance Criteria**:
  - [ ] 基本レイアウトが作成されている
  - [ ] レスポンシブデザインに対応している

### Issue #25: テーマ設定とスタイリング基盤
- **Priority**: Medium
- **Labels**: frontend, styling
- **Description**: 
  - MUIテーマのカスタマイズ
  - 共通スタイルの設定
- **Acceptance Criteria**:
  - [ ] カスタムテーマが適用されている
  - [ ] 共通スタイルが定義されている

### Issue #26: 開発用プロキシ設定
- **Priority**: High
- **Labels**: frontend, development
- **Description**: 
  - 開発環境でのAPIプロキシ設定
  - CORSエラーの解決
- **Acceptance Criteria**:
  - [ ] 開発環境でAPIアクセスが可能
  - [ ] CORSエラーが発生しない

## 推定作業時間
- **合計**: 26タスク × 1-2日 = 約4-6週間
- **最優先**: Issue #1-10 (Docker環境構築)
- **次優先**: Issue #11-18 (CakePHP基盤)
- **最後**: Issue #19-26 (React基盤)

## 依存関係
- Issue #1-4 は並行して実行可能
- Issue #5-10 は #1-4 完了後に実行
- Issue #11-18 は #5-10 完了後に実行
- Issue #19-26 は #5-10 完了後に実行可能（#11-18と並行可能）