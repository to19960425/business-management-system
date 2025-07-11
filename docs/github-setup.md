# GitHub Setup Instructions

## 1. GitHub リポジトリの作成

### 手動でリポジトリを作成する場合
1. GitHub にログイン
2. 新しいリポジトリを作成
   - Repository name: `business-management-system`
   - Description: `Modern business management system with React + TypeScript + CakePHP + Docker`
   - Public / Private を選択
   - README.md は追加しない（すでにローカルに存在するため）
   - .gitignore は追加しない（すでにローカルに存在するため）

### CLI で作成する場合（GitHub CLI が必要）
```bash
gh repo create business-management-system --public --description "Modern business management system with React + TypeScript + CakePHP + Docker"
```

## 2. リモートリポジトリの設定

```bash
# リモートリポジトリを追加
git remote add origin https://github.com/YOUR_USERNAME/business-management-system.git

# または SSH を使用する場合
git remote add origin git@github.com:YOUR_USERNAME/business-management-system.git

# リモートリポジトリにプッシュ
git push -u origin main
```

## 3. Issue テンプレートの作成

### .github/ISSUE_TEMPLATE/task.md
```markdown
---
name: Task
about: Development task
title: '[TASK] '
labels: ''
assignees: ''
---

## Description
<!-- タスクの詳細説明 -->

## Acceptance Criteria
<!-- 完了条件 -->
- [ ] 
- [ ] 
- [ ] 

## Additional Information
<!-- 追加情報 -->

## Priority
<!-- High / Medium / Low -->

## Estimated Time
<!-- 推定作業時間 -->
```

## 4. Milestone の作成

以下の8つのMilestoneを作成:

1. **Phase 1: 基盤構築** (期限: 2週間後)
   - Description: Docker環境セットアップ、CakePHP基盤構築、React基盤構築
   
2. **Phase 2: データベース設計・実装** (期限: 3週間後)
   - Description: データベース設計、マイグレーション作成、CakePHP Model作成

3. **Phase 3: 認証システム** (期限: 4週間後)
   - Description: JWT認証API実装、フロントエンド認証状態管理

4. **Phase 4: 基本CRUD機能** (期限: 7週間後)
   - Description: スタッフ・クライアント・協力会社管理機能

5. **Phase 5: 案件管理** (期限: 10週間後)
   - Description: 受注案件・社内案件・進捗管理機能

6. **Phase 6: ダッシュボード・分析** (期限: 12週間後)
   - Description: ダッシュボード、レポート機能

7. **Phase 7: 追加機能** (期限: 14週間後)
   - Description: マイページ機能、通知システム

8. **Phase 8: テスト・デプロイ準備** (期限: 15週間後)
   - Description: 単体テスト・統合テスト、本番環境設定

## 5. ラベルの作成

以下のラベルを作成:

### 技術分野
- `backend` - バックエンド関連
- `frontend` - フロントエンド関連
- `database` - データベース関連
- `docker` - Docker関連
- `api` - API関連

### 作業タイプ
- `setup` - セットアップ作業
- `infrastructure` - インフラ構築
- `feature` - 機能開発
- `bug` - バグ修正
- `test` - テスト関連
- `documentation` - ドキュメント作成

### 優先度
- `priority:high` - 高優先度
- `priority:medium` - 中優先度
- `priority:low` - 低優先度

### その他
- `enhancement` - 機能改善
- `security` - セキュリティ関連
- `performance` - パフォーマンス関連
- `ui/ux` - UI/UX関連

## 6. Project Board の作成

1. GitHub の Projects タブで新しいプロジェクトを作成
2. Template: "Team backlog" を選択
3. 以下のカラムを設定:
   - **Backlog**: 未着手のタスク
   - **Ready**: 着手準備完了
   - **In Progress**: 作業中
   - **Review**: レビュー待ち
   - **Done**: 完了

## 7. 自動化設定

### GitHub Actions (オプション)
- CI/CD パイプラインの設定
- 自動テスト実行
- 依存関係の自動更新

### Issue の自動割り当て
- CODEOWNERS ファイルの設定
- Issue テンプレートの拡張