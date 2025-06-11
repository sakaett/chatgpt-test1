<?php
namespace Stchatgpt;

/**
 * Stchatgptライブラリの基底クラス
 * 主に通信関連
 * */
class Base
{

    /**
     * .envに設定したapi key
     * */
    protected $api_key = null;


    public function __construct($api_key)
    {
        $this->api_key = $api_key;
    }

    /**
     * 通常のpost通信
     * */
    function sendPost($url,$body){

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Authorization: BEARER {$this->api_key}",
            'Content-Type: application/json',
                );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body );

        $html =  curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE );

        if($httpcode != 200){
            curl_close($curl);
            logger($url);
            throw new \ErrorException($html,$httpcode);
        }

        curl_close($curl);

        return $html;
    }

    /**
     * ヘッダにOpenAI-Betaが必要な場合のpost
     * */
    function sendPostAssistants($url,$body){

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Authorization: BEARER {$this->api_key}",
            'Content-Type: application/json',
            "OpenAI-Beta: assistants=v2"
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body );

        $html =  curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE );

        if($httpcode != 200){
            curl_close($curl);
            logger($url);
            throw new \ErrorException($html,$httpcode);
        }

        curl_close($curl);

        return $html;
    }

    /**
     * CURL Postfileの生成
     * */
    function createPostFile($path,$mime_type, $name='file'){
        return curl_file_create($path,$mime_type,$name);
    }

    /**
     * 学習させたいデータを送信する。
     * @param $body createPostFileの戻り値。CURLFile。学習させたい内容の入ったファイルを元に作成する。
     *
     * */
    function sendPostFile($url,$body){

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Authorization: BEARER {$this->api_key}",
            'Content-Type: multipart/form-data',
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl,CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body );

        $html =  curl_exec($curl);
        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE );

        if($httpcode != 200){
            curl_close($curl);
            logger($url);
            throw new \ErrorException($html,$httpcode);
        }

        curl_close($curl);

        return $html;
    }



    /**
     * ヘッダにOpenAI-Betaが必要な場合のget
     * */
    function sendGetAssistants($url){


        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $headers = array(
            "Authorization: BEARER {$this->api_key}",
            'Content-Type: application/json',
            "OpenAI-Beta: assistants=v2"
          );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $html =  curl_exec($curl);

        $httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE );
        if($httpcode != 200){
            curl_close($curl);
            logger($url);
            throw new \ErrorException($html,$httpcode);
        }

        curl_close($curl);

        return $html;

    }

}

