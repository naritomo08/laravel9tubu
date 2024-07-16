# Laravel9tubu

## 立ち上げ概要

Laravel9tubuyakisaitoソースを入手し、
ローカル環境でデプロイするものとなります。

必要なソースは以下にまとめてあります。

dockerソース

https://github.com/naritomo08/laravel_docker

つぶやきサイトソース

https://github.com/naritomo08/laravel9tubu

## 参考書籍

[プロフェッショナルWebプログラミング　Laravel](https://www.amazon.co.jp/gp/product/B09WMN18TR/ref=ppx_yo_dt_b_d_asin_title_351_o03?ie=UTF8&psc=1)

## 事前準備

mac+DockerCompose+vscode+gitでの環境を構築してること。
*Windowsでもｗｓｌ２＋Ubuntuで実施可能。

## 環境構築手順

### ベースリポジトリをクローンする。

```bash
$ git clone -b php8.2 https://github.com/naritomo08/laravel_docker.git laraveldocker
$ cd laraveldocker
$ rm -rf .git
$ git clone https://github.com/naritomo08/laravel9tubu.git backend
$ cd backend
$ rm -rf .git
```

最後の.git削除コマンドについて、
別途devlopブランチに元のLaravel9から以下の
対応をしたソースを置いています。

* Laravel MIX化
* breeze(認証機能)導入
* TailwindCSS 導入

これを元に新たに開発いただいても構いません。

以下のコマンドを入力してから.gitを削除してください。
```bash
$ git checkout devlop
```

### .envファイルを編集する。

```bash
$ vi .env

以下の内容に編集を行う。

APP_DEBUG = false
QUEUE_CONNECTION=database
```

### 環境構築用のシェルスクリプトを実行する。

```bash
$ chmod u+x build_env.sh && ./build_env.sh
```

### ファイルパーミッションを更新する。

```bash
$ chmod u+x set_permission.sh &&  ./set_permission.sh
```

### サイト設定を行う。

```bash
PHPコンテナログイン
$ docker-compose exec laravel_php /bin/bash
$ cd project

*パブリック画面ファイル作成初回時以下のコマンドを実施
$ chmod -R a+x node_modules

パブリック画面ファイル作成
$ npm run prod
つぶやき機能投稿画像参照リンク作成（新たに開発する場合は必要なし）
$ npm artisan storage:link
Laracvelキャッシュクリア
$ php artisan cache:clear
$ php artisan config:clear
$ php artisan route:clear
$ php artisan view:clear
```

### 各種サイト確認する。

## サイトURL

### laravel

http://127.0.0.1:8080/tweet

### adminer(DB管理ツール)

http://127.0.0.1:8081


* ログイン情報
  - サーバ: laravel_db
  - ユーザ名: laravel
  - パスワード: password
  - データベース: laravel

### mailhog(メールサーバ)

http://127.0.0.1:8025


## コンテナ起動する方法

`docker-compose.yml`が存在するフォルダーで以下のコマンドを実行する。

```bash
$ docker-compose up -d
```

## コンテナ停止する方法

`docker-compose.yml`が存在するフォルダーで以下のコマンドを実行する。

```bash
$ docker-compose stop
```

## コンテナ削除する方法

`docker-compose.yml`が存在するフォルダーで以下のコマンドを実行する。

```bash
$ docker-compose down
```

## 起動中のコンテナに入る

### PHPコンテナ

```bash
$ docker-compose exec laravel_php /bin/bash
```

### DBコンテナ

```bash
$ docker-compose exec laravel_db /bin/bash
```

## その他

開発中に以下のコマンドを実行してください。

```bash
$ docker-compose exec laravel_php /bin/bash
$ cd project

$ npm run watch
```

#### npm run watchコマンドとは

npm run watchコマンドはターミナルで実行し続け、関連ファイル全部の変更を監視します。
Webpackは変更を感知すると、アセットを自動的に再コンパイルします。

## LaravelTest(CICDにいれる予定)

```bash
PHPコンテナで動かす。

ユニットテスト
php artisan test tests/Unit/Services/TweetServiceTest.php

フィーチャーテスト
php artisan test tests/Feature/Tweet/DeleteTest.php

上記テストをまとめて実施
vendor/bin/phpunit

```

## このソースをAWS(ECS)に展開したい場合

backendフォルダに展開されているソースについて、
以下のページを参考にAWS(ECS)へ展開することもできます。

https://qiita.com/naritomo08/items/6e38955145d80c1435bd

## このソースをOCI環境に展開したい場合

以下のページで取りまとめています(作成中)

https://qiita.com/naritomo08/items/a5065f1a0b159efd47a7
