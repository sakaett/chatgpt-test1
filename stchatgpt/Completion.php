<?php
namespace Stchatgpt;

/**
 *特に学習させていない、普段のchatGPTに、普通に質問するためのクラス。
 * */
class Completion extends Base
{

    private $url = "https://api.openai.com/v1/chat/completions";
    public function __construct($api_secret)
    {
        parent::__construct($api_secret);
    }

    /**
     * 質問し回答を取得する。
     * */
    public function execute($q){

        $request_body = array(
            "model" => "gpt-4o",
            "messages" =>  [
                ["role" => "system", "content" => "You are a helpful assistant."],
                ["role" => "user", "content" => "$q"]
            ],
            "temperature" =>  0
        );

        $res = $this->sendPost($this->url,json_encode( $request_body ));

        return $res;

    }

}

