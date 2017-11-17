import { combineReducers } from 'redux';
import { routerReducer } from 'react-router-redux';
import loginReducer from './login/root';
import organizeReducer from './organize/root';
import taskReducer from './task/root';
import logList from './log/root';

const rootReducer = combineReducers({
    routing: routerReducer,
    loginReducer,
    taskReducer,
	logList,
	...organizeReducer,
});

export default rootReducer;