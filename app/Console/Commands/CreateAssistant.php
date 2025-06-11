<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use function GuzzleHttp\json_decode;
use Stchatgpt\Base;

/**
 * UploadしたファイルのIDを使用して、アシスタントを作成します。
 * */
class CreateAssistant extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-assistant';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $url = "https://api.openai.com/v1/assistants";

        $body  = array(
            # instructionsで、このアシスタントが何をするのかを設定します。英文で設定したほうが確実に動作します。
            #　 chatgptが、uploadしたファイルの形式を認識できない場合、勝手にexcelやcsvと認識して解析に失敗する場合があります。その場合、
            #　以下の文章のように、ファイルのフォーマットを示唆する文章を設定します。
            "instructions" => "You are a bot providing information on one person's work history. Tell me the contents of the text file you loaded. Format of the file you loaded is text file.",
            "name" => "secretary",
            "tools" => array(
                array("type" => "code_interpreter")
            ),
            "model" => "gpt-4o",
            "tool_resources" => array(
                "code_interpreter" => array(
                "file_ids" => array(
                    # ファイルのアップロード[UploadKeireki.php]で取得したファイルIDを代入
                    "file-QoW6FoVgGZjahZwFPua7TA",
                )
                )
            )
            );

            $body = json_encode($body);

            $base = new Base(config('app.CHATGPT_SECRET'));

            $res = null;
            try{
                $res = $base->sendPostAssistants($url,  $body  );
            }catch(\ErrorException $e){
                print($e->getCode());
                print($e->getMessage());
            }

            /**
             * レスポンスの「id」がアシスタントのIDです。
             * .envファイルの「CHATGPT_ASSISTANT_ID」に設定してください。
             * .env.exampleファイルを参考にしてください。
             * */
            print($res);


            /*
             *{
  "id": "asst_Z6Yg3QV5W1X9CTwIuOx81afk",
  "object": "assistant",
  "created_at": 1749598114,
  "name": "secretary",
  "description": null,
  "model": "gpt-4o",
  "instructions": "You are a bot providing information on one person's work history. Tell me the contents of the file you loaded. Format of the file you loaded is text file.",
  "tools": [
    {
      "type": "code_interpreter"
    }
  ],
  "top_p": 1.0,
  "temperature": 1.0,
  "reasoning_effort": null,
  "tool_resources": {
    "code_interpreter": {
      "file_ids": [
        "file-QoW6FoVgGZjahZwFPua7TA"
      ]
    }
  },
  "metadata": {},
  "response_format": "auto"
}
             */

        }


    protected function resolveCommand($command)
    {}

}
