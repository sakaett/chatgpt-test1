import axios from "axios";
/**
 * 通信系
 *
 */
export type SetResponse = (value :any) => void;
export type SetError = {
	(value: any ): void;
};
export const post = (url: string, body :any , successFunc: SetResponse,errorFunc: SetError) => {
	axios.post(url,body )
	.then( response => {
		successFunc(response);
	})
	.catch(error => {
		errorFunc(error);
	});
}
