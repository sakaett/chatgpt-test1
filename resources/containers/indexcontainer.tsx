import {useState} from 'react';
import { SubmitButton } from '../components/SubmitButton';
import {InputText } from '../components/InputText';
import { ResultView } from '../components/resultview';
import {LoadingView} from '../components/loadingview';
import {post} from '../api/httpapi';


/**
 * トップレベルのコンテナ
 *
 *
 */
export function IndexContainer (){

	const[question , setQ] = useState<string>("");
	const [val , setVal ] = useState([]);
	const[threadId,setThreadId] = useState("");
	const[loading,setLoading] = useState(false);

	/**送信ボタン */
	function postQuestion() {
		//loading on
		setLoading(true);
		//post通信
		post("/react_q", {q: question,thread_id: threadId},
			function(res){
				console.log(res);
				//スレッドIDの保存。AIとの会話スレッドのID
				setThreadId(res.data.thread_id);
				var list :string[];
				list = [];
				res.data.data.map( (item) =>
					list.push(item.content[0].text.value)
				);
				//AIからの回答は逆順で来るのでreverseする。
				list = list.reverse();
				//stateに値設定。これでResultViewに結果表示される
				setVal(list);
				//loading off
				setLoading(false);
			},function(err){
				console.log(err);
			});
	}

	//テキストのchange。stateに入力内容を保存する。
	function handleChange(event){
		setQ(event.target.value);
	}

	return(
    <div>
        <div className="text-red">
            Laravel React+Typescript
        </div>
            <ResultView clist={ val }/>
		<LoadingView loading={loading} />
        <hr />
        <div>
            <InputText onChange={handleChange}/>
            <SubmitButton onPush={postQuestion}/>
        </div>
    </div>

	);

}