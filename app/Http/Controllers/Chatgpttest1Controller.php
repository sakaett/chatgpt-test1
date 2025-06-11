<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stchatgpt\Completion;
use Stchatgpt\QuestionThread;

/**
 * chatgpt test1 コントローラー
 * */
class Chatgpttest1Controller extends Controller
{
    //top page
    public function index(){

        return view('chatgpt_test1/index');
    }

    // Completion chatgptに普通に質問するだけのAPI
    public function completionView(){

        return view('completion/index');
    }

    // 質問の回答を表示
    public function completionExec(Request $request){

        // キーを取得してインスタンス作成
        $comp = new Completion(config('app.CHATGPT_SECRET'));
        $res = null;
        try{
            //質問を投げる。responseに回答が入っている
            $res = $comp->execute( $request->get('q'));
        }catch(\ErrorException $e){
            echo($e->getCode());
            echo($e->getMessage());
            throw $e;
        }

        $response = json_decode( $res,true);

        return view('completion/results',['res' => $response]);
    }

    /*-- 以下は、学習した職務経歴書に対する質問について回答するAI。
     *  一連の連続する質問のシーケンスをスレッドとして管理しているので、threadQxxxという名前にしてみた。
     *
     */

    /**
     * 初期画面表示
     * */
    public function threadQStart(){

        return view('threadq/index');
    }

    /**
     * 質問の実行と結果取得
     * */
    public function threadQexec(Request $request){

        //formのhiddenにあるスレッドID
        $threadId = $request->get('thread_id');

        //質問スレッドクラスのインタンス
        $q = new QuestionThread(config('app.CHATGPT_SECRET'));

        //スレッドIDがnullなら最初の質問
        //スレッドを新規に開始して、スレッドIDを取得する。
        if($threadId == null ){
            $json = $q->beginThread();
            try{
                $res = json_decode($json,true);
                $threadId = $res['id'];
            }catch(\ErrorException $e){
                echo($e->getCode());
                echo($e->getMessage());
                throw $e;
            }
        }

        //スレッドIDをQuestionThreadのインスタンスに設定する。
        //これ以降、このインスタンスの内部でスレッドIDが使用される
        $q->setThreadId($threadId);

        $res = null;

        /**
         * スレッドに質問を送信する。
         * */
        try{
            $res = $q->putQuetion($request->get('q'));
        }catch(\ErrorException $e){
            echo($e->getCode());
            echo($e->getMessage());
            throw $e;
        }

        // run id
        $run_id = null;

        /**
         * 「run」を開始し、run_idを取得する。
         *  runの開始により、AIが質問の解析と回答の生成を開始する。
         * ※質問の送信、即run開始とならないという事は、複数の質問を同時に処理を想定しているのか?
         * */
        try{
            $json = $q->runQuestion();
            $res = json_decode($json,true);
            $run_id = $res['id'];
        }catch(\ErrorException $e){
            echo($e->getCode());
            echo($e->getMessage());
            throw $e;
        }

        /**
         * runの完了を待つ。
         * とりあえず30 secでエラーとする。
         * */
        $times = 0;
        while(true){
            try{
                $json = $q->waitRun($run_id);
                $res = json_decode($json,true);
                $status = $res['status'];

                // statusがcompletedなら、解析完了。
                if( $status == "completed"){
                    break;
                }
                sleep(3);
                $times++;
                if($times > 10){
                    throw new \ErrorException("wait run over 30 second.");
                }
            }catch(\ErrorException $e){
                echo($e->getCode());
                echo($e->getMessage());
                throw $e;
            }
        }

        /**
         * 解析結果を取得する。
         * */
        $data = null;
        try{
            $json = $q->getMessageList();
            $data = json_decode($json,true);
        }catch(\ErrorException $e){
            echo($e->getCode());
            echo($e->getMessage());
            throw $e;
        }

        return view('threadq/thread_view',['thread_id' => $threadId ,'data' => $data]);

    }


}
