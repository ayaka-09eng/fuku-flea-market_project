# アプリケーション名
coachtechフリマ  

## プロジェクトの概要
初年度でのユーザー数1000人達成を目指す、アイテムの出品と購入を行うためのフリマアプリを開発する。  

## 環境構築
```  
１）リポジトリからダウンロード  
git clone git@github.com:ayaka-09eng/fuku-flea-market_project.git  
  
２）srcディレクトリにある「.env.example」をコピーして 「.env」を作成し DBとMAILの設定を変更  
cp .env.example .env  
---  
DB_CONNECTION=mysql  
DB_HOST=mysql  
DB_PORT=3306  
DB_DATABASE=laravel_db  
DB_USERNAME=laravel_user  
DB_PASSWORD=laravel_pass  
  
MAIL_FROM_ADDRESS="example@example.com"  
---  
※.envが保存できない場合は以下コマンドを実行  
docker-compose exec php bash  
chown -R 1000:1000 .env  
  
３）dockerコンテナを構築  
docker-compose up -d --build  
  
４）Laravelをインストール  
docker-compose exec php bash  
composer install  
  
５）アプリケーションキーを作成  
php artisan key:generate  
  
６）DBのテーブルを作成  
php artisan migrate  
  
７）DBのテーブルにダミーデータを投入  
php artisan db:seed  
  
※The stream or file could not be opened"エラーが発生した場合  
srcディレクトリにあるstorageディレクトリに権限を設定  
chmod -R 777 storage  
  
８）Stripeのアカウントを作成  
Stripeアカウント作成URL：https://dashboard.stripe.com/register?locale=ja-JP  
  
９）Stripeにログインする  
StripeログインURL：https://dashboard.stripe.com/  
  
１０）左上の「サンドボックス」が表示されていることを確認する  
※テストモードで問題無し  
  
１１）左下の「開発者」をクリックする  
※Standardアカウントでは本番・テストどちらでも同じ場所にある  
  
１２）「API キー」を開く  
  
１３）テスト用の秘密鍵（シークレットキー）を「.env」の最下部に設定する  
---  
STRIPE_SECRET=sk_test_で始まるキー  
---  
※本プロジェクトではStripe Checkoutをサーバー側のみで使用しているため、  
必要なのはStripeの「秘密鍵（Secret key）」のみ  
公開鍵（公開可能キー）は使用しない  
  
１４）Stripe PHP SDK をインストール
docker-compose exec php bash  
composer require stripe/stripe-php  
```  

### Stripe テストカード番号
Stripe Checkoutの動作確認には、以下のテストカード番号を使用できます。  
  
・カード番号：4242 4242 4242 4242  
・有効期限：任意の未来日（例：12/34）  
・CVC：任意の3桁（例：123）  
  
※この番号はStripeが公式に公開しているテストカードです。  

## 管理者ユーザーおよび一般ユーザーのログイン情報
本プロジェクトでは、あらかじめ用意されたダミーデータを使用してログインできます。  
ユーザー情報はphpMyAdminからusersテーブルを確認してください。  
ダミーユーザーのパスワードはすべて共通で「password」となっています。  
  
補足  
・管理者ユーザーは本プロジェクトでは使用していません  
・ログイン確認を行う際は、usersテーブルに登録されている任意のユーザーを利用できます  

## 使用技術(実行環境)
PHP：8.1.34  
Laravel：8.83.8  
MySQL：8.0.26  
Ngnix：1.21.1  

## URL
商品一覧：http://localhost/  
会員登録：http://localhost/register  
ログイン：http://localhost/login  
phpMyAdmin：http://localhost:8080/  
MailHog：http://localhost:8025/  

## ER図
![ER図](ER.drawio.png)