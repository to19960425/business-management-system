gh issue view $ARGUMENTS でGitHubのIssueの内容を確認し、タスクの遂行を行なってください。
タスクは以下の手順で進めてください。

1. Issueに記載されている内容を理解する
2. mainブランチにチェックアウトし、git pullを行い、最新のリモートの状態を取得する
3. Issueの内容を元に、適切な命名でfeatureブランチを作成、チェックアウトする
4. Issueの内容を実現するために必要なタスクをTDD（テスト駆動開発）に基づいて遂行する
5. テストとLintを実行し、すべてのテストが通ることを確認する
6. コミットを適切な粒度で作成する
7. featureブランチをリモートにプッシュする
8. 以下のルールに従ってPRを作成する
    - 使用言語は日本語
    - PRのdescriptionのテンプレートは @.github/PULL_REQUEST_TEMPLATE.md を参照し、それに従うこと
    - PRのdescriptionのテンプレート内でコメントアウトされている箇所は必ず削除すること
    - PRのdescriptionには`Closes #$ARGUMENTS`と記載すること
9. PRのレビューとマージを依頼する（必要に応じて）

注意: PRがマージされた後は、mainブランチに戻ってgit pullで最新の状態を取得し、不要なfeatureブランチは削除してください。
