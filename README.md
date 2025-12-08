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

# イメージ図
<img width="1318" height="480" alt="Image" src="https://github.com/user-attachments/assets/a8b4ecb5-ef03-4e4a-b836-bf5c55fa2ed3" />

<img width="1448" height="898" alt="Image" src="https://github.com/user-attachments/assets/4ba9fb1d-7a9f-4bf5-970d-479ca09db173" />
- ダッシュボードでは今月の売り上げが見えるよう実装予定

<img width="1460" height="685" alt="Image" src="https://github.com/user-attachments/assets/baf3480f-34a9-451d-aec7-00e97c46a7e1" />

<img width="1454" height="641" alt="Image" src="https://github.com/user-attachments/assets/96e6a152-b0a0-4b89-b727-9b0167e61fe8" />
- 商品に紐づくカテゴリ及びサブカテゴリCRUD機能

<img width="1456" height="735" alt="Image" src="https://github.com/user-attachments/assets/03245ee2-0a5d-484a-8228-a8299251a3c5" />
- キービジュアルCRUD機能

<img width="1465" height="546" alt="Image" src="https://github.com/user-attachments/assets/383af8ea-0435-46b9-ac52-a084ce0e4192" />
ユーザー管理機能

その他実装予定
- 振込管理機能
- 決済管理機能
- フロントサイト側（決済機能）
- お知らせ管理機能
- お問い合わせ管理
