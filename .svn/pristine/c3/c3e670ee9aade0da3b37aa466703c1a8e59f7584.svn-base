/**
 * 任务管理 actions
 */
import * as types from '../contants/actionTypes/task';


export const getTaskList = (data) => {
	return (dispatch) => {
		dispatch({
			type: types.TASK_GET,
			data
		});
	};
};

export const changeTaskModifyId = (data) => {
	return (dispatch) => {
		dispatch({
			type: types.TASK_MODIFY_ID_CHANGE,
			data,
		});
	};
}

export const finishTask = (data) => {
	return (dispatch) => {
		dispatch({
			type: types.TASK_FINISH,
			data,
		})
	}
}

export const modifyTask = (data) => {
	return (dispatch) => {
		dispatch({
			type: types.TASK_END_POST,
			data
		});
	};
}

export const updateTask = (data) => {
	return (dispatch) => {
		dispatch({
			type: types.TASK_UPDATE_POST,
			data,
		});
	};
}

export const deleteTask = (data) => {
	return (dispatch) => {
		dispatch({
			type: types.TASK_DEL_POST,
			data,
		});
	};
}