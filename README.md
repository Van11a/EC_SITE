# 開発環境の構築方法
EC管理サイト

## Dockerコンテナをビルド&起動する
```
$ docker compose build
$ docker compose up -d
```

## DB作成後マイグレーションを実行
```
$ php artisan migrate
```

## storage 以下に書き込み権限を付ける
```
$ chmod -R 777 storage
```

## 画像用tmpファイル作成
* storage/app/public/goods/配下にtmpフォルダを作る
* storage/app/public/key_visuals/配下にtmpフォルダを作る

## symbolicリンクを貼る
```
php artisan storage:link
```
* envでエラーログを日付ごとになるよう修正する

