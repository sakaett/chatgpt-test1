<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stchatgpt\Base;

/**
 * ChatGPTに解析させたいファイルをuploadします。
 *
 * */
class UploadKeireki extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:upload-keireki';

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
        $url =  "https://api.openai.com/v1/files";
        /**
         * ここに、uploadしたいファイルへのpathを記載してください。
         * */
        $file_path = '/media/sf_workspace/chatgpt-test/keireki-1.txt';

        $base = new Base(config('app.CHATGPT_SECRET'));

        $file  = $base->createPostFile($file_path, 'text/plain','keireki.txt');
        $body = array(
            'purpose' => 'assistants',
            'file' => $file
        );

        try{
            $res = $base->sendPostFile($url,  $body  );
        }catch(\ErrorException $e){
            print($e->getCode());
            print($e->getMessage());
        }

        /**
         * resonseをコンソールに出力します。
         * 「id」がuploadしたファイルのIDなので、このIDを使用して次の「アシスタントの作成」を行います。CreateAssistant.phpを参照。
         * */
        print($res);

        /*
         * {
{
  "object": "file",
  "id": "file-QoW6FoVgGZjahZwFPua7TA",
  "purpose": "assistants",
  "filename": "keireki.txt",
  "bytes": 34282,
  "created_at": 1749545542,
  "expires_at": null,
  "status": "processed",
  "status_details": null
}
         */

    }
    protected function resolveCommand($command)
    {}

}
