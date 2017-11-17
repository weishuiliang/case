/**
 * 网络请求actions
 */

 export const request = (data, callback, options) => {
     return {
         type: data.type,                        
         method: data.method,
         params: data.params,
		 callback,
		 options
     }
 };