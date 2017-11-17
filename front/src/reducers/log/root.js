/**
 * log
 */
import * as types from '../../contants/actionTypes/log';

const initState = {
	list: [],
	loading: false
};

const logList = (state = initState, action) => {
	switch(action.type) {
		case types.LOG_LIST_POST + '_ON':
			state = {
				...state,
				loading: true
			};
			return state;
		case types.LOG_LIST_POST + '_SUCCESS':
			state = {
				...state,
				list: [...action.data],
				loading: false
			};
			return state;
		case types.LOG_LIST_POST + '_ERROR':
			state = {
				...state,
				loading: false
			};
			return state;
		default:
			return state;
	}
};
export default logList;