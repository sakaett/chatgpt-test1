import React from "react";;

/**
 *
 * テキスト入力域。onChangeでstateに入力内容を保存
 *
 */
export function InputText({onChange}){



	return(
		<input type="text" name="q" onChange={onChange} />
	);
}