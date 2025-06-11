<?php
namespace Stchatgpt;

/**
 * Assistant API class
 *  各APIの詳細は、以下を参照のこと。
 * https://openai.apidog.io/jp/api-13218239
 * */
class QuestionThread extends Base
{

    /**
     * スレッドID
     * */
    private $thread_id = null;
    public function __construct($api_key,$thread_id = null)
    {
        parent::__construct($api_key);
        $this->thread_id = $thread_id;
    }

    /**スレッドIDを設定する*/
    public  function setThreadId($thread_id){

        $this->thread_id = $thread_id;

    }

    /**スレッドを開始し、スレッドIDを取得する。
     * */
    public function beginThread(){

        $url = "https://api.openai.com/v1/threads";

        $res = $this->sendPostAssistants($url, "{}");

        return $res;
    }

    /**
     * 質問をchatGptに送信する。
     * @param string $q 質問の文字列
     * */
    public function putQuetion($q){

        $url = "https://api.openai.com/v1/threads/{$this->thread_id}/messages";

        $data = array(
            "role" => "user",
            "content" => "{$q}"
        );

        $res = $this->sendPostAssistants($url, json_encode($data));

        return $res;

    }

    /**
     * 質問の解析を開始する。
     * */
    public function runQuestion(){

        $url = "https://api.openai.com/v1/threads/{$this->thread_id}/runs";

        $body = array(
            "assistant_id" => config('app.CHATGPT_ASSISTANT_ID')
        );

        $res = $this->sendPostAssistants($url, json_encode($body));

        return $res;

    }

    /**
     *  解析の進捗状況を取得する。statusがcompletedなら解析完了
     * */
    public function waitRun($run_id){
        $url = "https://api.openai.com/v1/threads/{$this->thread_id}/runs/{$run_id}";
        return $this->sendGetAssistants($url);
    }

    /**解析したメッセージ一覧を取得する。
     * このAPIは、スレッド内のメッセージ(質問と回答の一覧)すべてを取得する
     * */
    public function getMessageList(){
        $url = "https://api.openai.com/v1/threads/{$this->thread_id}/messages";
        return $this->sendGetAssistants($url);
    }

}

