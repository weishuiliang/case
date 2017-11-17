/**
 * 任务 -- 任务列表
 */
import * as types from '../../contants/actionTypes/task';

const initState = {
	modifyTaskId: '1',
	modifyTask: {},
	taskList: [],
};

const taskReducer = (state = initState, action) => {
	switch(action.type) {
		case types.TASK_GET: {
			return {
				...state,
				taskList: [...action.data],
			};
		}
		
		case types.TASK_MODIFY_ID_CHANGE: {
			const modifyTaskId = action.data;
			const taskList = state.taskList.slice();
			const modifyTask = taskList.filter(task => task["task_id"] === modifyTaskId["task_id"])[0];
			const { front_user_name, front_user_id, back_user_name, back_user_id } = modifyTask;
			return {
				...state,
				modifyTaskId: action.data,
				modifyTask: {
					...modifyTask,
					front_user: {
						selectedText: front_user_name,
						selectedValue: front_user_id,
					},
					back_user: {
						selectedText: back_user_name,
						selectedValue: back_user_id,
					},
				},
			}
		}

		case types.TASK_FINISH: {
			const {task_id, over_time} = action.data;
			let taskList = state.taskList.slice();
			taskList.map((task) => {
				if (task.task_id === task_id) {
					task.over_time = over_time;
				}
			});
			return {
				...state,
				taskList,
			}
		}

		case types.TASK_UPDATE_POST: {
			const {task_id, task} = action.data;
			// console.log(`taskId: ${task_id}, task: ${task}`);
			let taskList = state.taskList.slice();
			// console.log(taskList);
			taskList.map((origin_task, index) => {
				if (origin_task.task_id === task_id) {
					taskList[index] = {
						...taskList[index],
						...task,
					};
				}
			});
			return {
				...state,
				taskList,
			}
		}

		case types.TASK_DEL_POST: {
			const task_id = action.data;
			let taskList = state.taskList.filter(task => task.task_id !== task_id);
			return {
				...state,
				taskList,
			}
		}

		default:
			return state;
	}
};

export default taskReducer;