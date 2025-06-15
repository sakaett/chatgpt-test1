/**
 *
 * 簡単な、loading中表示 *
 */
export function LoadingView({ loading = false}) {

	if( loading){
		return(
			<div>Loading.....................</div>
		);
	}else{
		return(<span></span>);
	}
}