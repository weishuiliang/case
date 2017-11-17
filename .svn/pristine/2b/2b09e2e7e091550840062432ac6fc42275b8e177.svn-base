/**
 * axios post请求
 */
import axios from 'axios';
import Qs from 'qs';

export const post = (url, params) => {
	return axios({
		method: 'post',
		url: url,
		data: {
			...params
		},
		transformRequest: [function (data, headers) {
			data = Qs.stringify(data);
			return data;
		}]
	})
};