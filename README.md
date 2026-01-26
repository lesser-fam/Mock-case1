# coachtechフリマ(模擬案件1)
- フリマ風アプリ。商品閲覧、出品、購入、お気に入り、コメント、プロフィール管理ができます。
- 会員登録後はメール認証完了後にログイン可能な仕様です。
- メール認証には MailHog を使用しています。


## 環境構築
**Dockerビルド**
1. `git clone git@github.com:lesser-fam/Mock-case1.git`
2. DockerDesktopを立ち上げる
3. `docker-compose up -d --build`

**Laravel環境構築**
1. `docker-compose exec php bash`
2. `composer install`
3. 「.env.example」ファイルをコピーして「.env」ファイルを作成
4. .envに以下の環境変数を追加
```text
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
5. アプリケーションキーの作成
```bash
php artisan key:generate
```

6. マイグレーションの実行
```bash
php artisan migrate
```

7. シーディングの実行
```bash
php artisan db:seed
```
本アプリでは、動作確認用として、以下の初期データをシーダーで作成しています。
- テストユーザー：6人
- 商品データ：運営指定のサンプル商品(10件)
- カテゴリー：運営指定のカテゴリマスタ(14件)
- 商品状態：運営指定の固定値(4件)

**テストユーザー**

| id | user_name | email             | password |
|----|-----------|-------------------|----------|
| 1  | 太郎      | test1@example.com | password |
| 2  | 次郎      | test2@example.com | password |
| 3  | 三郎      | test3@example.com | password |
| 4  | 四郎      | test4@example.com | password |
| 5  | 五郎      | test5@example.com | password |
| 6  | 六郎      | test6@example.com | password |


8. storageリンク
```bash
php artisan storage:link
```

※ 初回起動時に権限エラーが発生する場合
```bash
docker-compose exec php bash
# 以下、phpコンテナ内で実行
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

9. テスト実行

※ テスト実行前に、MySQLのrootユーザーでテスト用データベースを作成してください。
```bash
docker-compose exec mysql mysql -u root -p
```
```sql
CREATE DATABASE demo_test;
```
※ テスト実行時は'.env.testing'を使用し、すべて Feature Test として実装しています。

```bash
php artisan test
```

**実装済みテスト一覧**
```text
01 会員登録機能
    - AuthRegisterTest

02 ログイン機能
    - AuthLoginTest

03 ログアウト機能
    - AuthLogoutTest

04 商品一覧取得
    - ItemIndexTest

05 マイリスト一覧取得
    - ItemMylistTest

06 商品検索機能
    - ItemSearchTest

07 商品詳細情報取得
    - ItemShowTest

08 いいね機能
    - FavoriteTest

09 コメント送信機能
    - CommentTest

10 商品購入機能
    - PurchaseTest

11 支払い方法選択機能
    ※支払い方法選択時の表示切替は、コーチと相談の結果、JavaScriptにより制御することとしたため、PHPのFeature Testでは表示内容の切替までは検証していません。

12 配送先変更機能
    - PurchaseAddressTest

13 ユーザー情報取得
    - MypageIndexTest

14 ユーザー情報変更
    - MypageProfileTest

15 出品商品情報登録
    - ItemSellTest

16 メール認証機能
    - AuthEmailVerificationTest
```


## 使用技術
- PHP 8.4.13
- Laravel 8.83.29
- MySQL 8.0.26
- Laravel Fortify (認証)
- MailHog (メール認証)
- Stripe (決済)


## ER図
![ER図](/erd.png)


## URL
- 開発環境：http://localhost/
- phpMyAdmin：http://localhost:8080/
- MailHog：http://localhost:8025


## 補足
- 会員登録後はメール認証が完了するまでログイン不可になっています。

- 会員登録後の遷移先について
テストケース「1会員登録機能」では、会員登録後にプロフィール編集画面に遷移するとありますが、メール認証機能を実装しているため、メール認証完了後、自動ログインされてプロフィール編集画面へ遷移します。

- テストケース「11支払い方法選択機能」について
小計への支払い方法の反映をJavaScriptで実装しているため、Feature Testは未実施です。（担当コーチ了承済）

- Stripe はテスト環境(テストキー)での実装です。