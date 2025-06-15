import React from "react";

/**
 * 送信ボタン
 *
 */
export function SubmitButton({onPush}){

		return(
			<button id="submitButton" onClick={onPush}>送信</button>
		);
}