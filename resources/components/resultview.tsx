import { useEffect, useRef, useLayoutEffect } from "react";

/**
 *
 * 結果表示view
 *
 */
export function ResultView( { clist }){

	//下に自動スクロール
	const scrollRef = useRef(null);
	useLayoutEffect(() =>
		scrollRef?.current?.scrollIntoView()
	);

	//受け取った結果をリストにする
	const items = clist.map( (item) =>
<li>{item}</li>
	);

	    return(
		<div class="result-parent">
			<div class="resultView" >
				<ul>
				{items}
				</ul>
				<div ref={scrollRef}></div>
			</div>
		</div>
	    );
}