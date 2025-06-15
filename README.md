# simpleなchatgpt apiのテスト

## 使い方

- .env.exampleを参考に、.envファイルを作成してください。
- * 末尾に、chatGPTの秘密鍵と、作成したアシスタントIDを設定する項目があります。
  * 秘密鍵を取得して.envに設定した後、app/Console/Commands の下のUploadKeireki.phpコマンドを使用して、解析したいファイルをuploadします。
  * 次に、CreateAssistant.phpコマンドで、assistantを作成し、IDを.envに設定します。

## 構造

```
├── app
│   ├── Console
│   │   └── Commands
│   │       ├── CreateAssistant.php :OpenAI アシスタント作成コマンド
│   │       └── UploadKeireki.php :OpenAI ファイルのUpload
│   ├── Http
│   │   ├── Controllers
│   │   │   ├── Chatgpttest1Controller.php :chatGPT APIのテスト
│   │   │   ├── Controller.php
│   │   │   └── ReacttestController.php : 上のChatgpttest1をReact用にJSONを返すようにしたAPI
..........................
├── resources
│   ├── api
│   │   └── httpapi.tsx : react 通信関数
│   ├── components
│   │   ├── InputText.tsx :ChatGPTへの質問入力Input
│   │   ├── loadingview.tsx :ローディング中表示
│   │   ├── resultview.tsx :AIからの回答View
│   │   └── SubmitButton.tsx :送信ボタン
│   ├── containers
│   │   └── indexcontainer.tsx TOPコンテナ
│   ├── css
│   │   └── app.css
│   ├── scss
│   │   └── app.scss :react用
│   ├── ts
│   │   └── index.tsx :react用index tsx views/react_test1/index.blade.phpへの組み込みを行う
│   └── views
│       ├── chatgpt_test1 :デモのTOP画面
│       │   └── index.blade.php
│       ├── completion: 簡単な質問用のview
│       │   ├── index.blade.php
│       │   └── results.blade.php
│       ├── react_test1 : react用のview
│       │   └── index.blade.php
│       ├── threadq: 非reactの、chatGPTデモ用
│       │   ├── index.blade.php
│       │   └── thread_view.blade.php
│       └── welcome.blade.php
```

## デモ環境について

- * 私が必要と判断した方には、デモ環境のURLとID/PWを別途連絡させていただいております。
  * ChatGPT OpenAI APIの利用料金は有料のため、デポジット不足などのせいで動作しない可能性があります。

## TODO

  * ファインチューニングについて
  * JavaやRailsでのサーバー側実装
