#coachtechフリマ(模擬案件1)
フリマ風アプリ。商品閲覧、出品、購入、お気に入り、コメント、プロフィール管理ができます。
会員登録後はメール認証完了後にログイン可能な仕様です。

##環境構築
**Dockerビルド**
1.git clone git@github.com:lesser-fam/Mock-case1.git
2.DockerDesktopを立ち上げる
3.docker-compose up -d --build

**Laravel環境構築**
1.docker-compose exec php bash
2.composer install
3.「.env.example」ファイルをコピーして「.env」ファイルを作成
4..envに以下の環境変数を追加

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass

5.アプリケーションキーの作成
bash
php artisan key:generate

6.マイグレーションの実行
bash
php artisan migrate

7.シーディングの実行
bash
php artisan db:seed

8.storageリンク
bash
php artisan storage:link

9.テスト実行
php artisan test


##使用技術
-PHP 8.4.13
-Laravel 8.83.29
-MySQL 8.0.26
-Laravel Fortify（認証・メール認証）
-Stripe（決済）

##ER図
![ER図](/erd.png)

##URL
-開発環境：http:/localhost/
-phpMyAdmin：http:/localhost:8080/

##テストユーザー
id  user_name   email               password
1   太郎        test1@example.com   password
2   次郎        test2@example.com   password
3   三郎        test3@example.com   password
4   四郎        test4@example.com   password
5   五郎        test5@example.com   password
6   六郎        test6@example.com   password
※上記ユーザーはSeederにより作成されています。

##補足
・会員登録後はメール認証が完了するまでログイン不可

・メール認証完了後、自動ログインされプロフィール編集画面へ遷移

・テストケース「11支払い方法選択機能」について
　小計への支払い方法の反映をJavaScriptで実装しているため、Feature Testは未実施（担当コーチ了承済）