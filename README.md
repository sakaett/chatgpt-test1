# simpleなchatgpt apiのテスト

## 使い方

- .env.exampleを参考に、.envファイルを作成してください。
- * 末尾に、chatGPTの秘密鍵と、作成したアシスタントIDを設定する項目があります。
  * 秘密鍵を取得して.envに設定した後、app/Console/Commands の下のUploadKeireki.phpコマンドを使用して、解析したいファイルをuploadします。
  * 次に、CreateAssistant.phpコマンドで、assistantを作成し、IDを.envに設定します。

## デモ環境について

- * 私が必要と判断した方には、デモ環境のURLとID/PWを別途連絡させていただいております。
  * ChatGPT OpenAI APIの利用料金は有料のため、デポジット不足などのせいで動作しない可能性があります。

## TODO

- * viewのReact化と、API化
  * ファインチューニングについて
  * JavaやRailsでのサーバー側実装
