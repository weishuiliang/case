/**
 * 登录认证
 */
import { getCookie } from '../utils/utils';

export const loginAuth = (nextState, replace, callback) => {
	if (!getCookie('user_id')) {
		replace({ pathname: '/login' })
	} else {
		callback();
	}
};