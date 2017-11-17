/**
 * 部门Reducer
 */
import * as types from '../../contants/actionTypes/organize';

const initState = {
	groupList: {
		// pagination: {
		// 	current: 1,
		// 	total: 0,
		// 	showQuickJumper: true
		// },
		list: [],
		loading: false
	}
};

// 获取编辑后的Item信息
const getNewGroup = (array, data) => {
	let groupArray = [...array];
	let newGroup = [];
	for (let i = 0; i < groupArray.length; i++) {
		if (groupArray[i].group_id == data.group_id) {
			newGroup = {...groupArray[i], ...data};
			return newGroup
		} else if (!!groupArray[i].children && groupArray[i].children.length > 0) {
			return getNewGroup(groupArray[i].children, data)
		}
	}
	return newGroup;
};

// 将编辑后的信息加入到相应的上级部门中
const changePid = (array, data) => {
	let groupArray = [...array];
	for (let i = 0; i < groupArray.length; i++) {
		if (groupArray[i].group_id == data.group_id && groupArray[i].pid == data.pid) {
			groupArray[i] = {...groupArray[i], ...data};
			return groupArray;
		} else if (data.pid == '0') {
			groupArray = [data, ...groupArray];
			return groupArray;
		} else if (groupArray[i].group_id == data.pid) {
			let children = groupArray[i].children || [];
			let newArray = children.filter((item) => {
				return item.group_id != data.group_id
			});
			groupArray[i].children = [data, ...newArray];
			return groupArray;
		} else if (!!groupArray[i].children && groupArray[i].children.length > 0) {
			groupArray[i].children = changePid(groupArray[i].children, data)
		}
	}
	return groupArray;
};

// 删除原先的编辑信息
const delOldGroup = (array, data) => {
	let groupArray = [...array];
	for (let i = 0; i < groupArray.length; i++) {
		if (groupArray[i].group_id == data.group_id && groupArray[i].pid != data.pid) {
			groupArray.splice(i, 1);
			return groupArray;
		} else if (!!groupArray[i].children && groupArray[i].children.length > 0) {
			groupArray[i].children = delOldGroup(groupArray[i].children, data);
			if (!groupArray[i].children || groupArray[i].children.length <= 0) {
				delete groupArray[i].children;
			}
		}
	}
	return groupArray;
};

const formatList = (list) => {
	let array = [...list];
	for (let i = 0; i < array.length; i++) {
		if (!!array[i].son_list.length > 0) {
			array[i].children = [...array[i].son_list];
			formatList(array[i].son_list)
		}
	}
	return array;
};

// 添加部门
const addGroup = (array, data) => {
	let groupArray = [...array];
	for (let i = 0; i < groupArray.length; i++) {
		if (groupArray[i].group_id == data.pid) {
			groupArray[i].children = [data, ...(groupArray[i].children || [])];
			return groupArray;
		} else if (!!groupArray[i].children && groupArray[i].children.length > 0) {
			groupArray[i].children = addGroup(groupArray[i].children, data)
		}
	}
	return groupArray;
};

export const organizeGroup = (state = initState, action) => {
	switch(action.type) {
		case types.ORGANIZE_GROUP_LIST_GET + '_ON':
			state = {
				...state,
				groupList: {
					...state.groupList,
					loading: true
				}
			};
			return state;
		case types.ORGANIZE_GROUP_LIST_GET + '_SUCCESS':
			state = {
				...state,
				groupList: {
					...state.groupList,
					// pagination: {
					// 	...state.groupList.pagination,
					// 	current: parseInt(action.data.currentPage),
					// 	total:parseInt( action.data.totalCount)
					// },
					list: formatList(action.data),
					loading: false
				}
			};
			return state;
		case types.ORGANIZE_GROUP_LIST_GET + '_ERROR':
			state = {
				...state,
				groupList: {
					...state.groupList,
					loading: false
				}
			};
			return state;
		case types.ORGANIZE_GROUP_ADD_POST + '_SUCCESS':
			state = {
				...state,
				groupList: {
					...state.groupList,
					list: addGroup(state.groupList.list, action.data),
				}
			};
			return state;
		case types.ORGANIZE_GROUP_EDIT_POST + '_SUCCESS':
			let editGroup = getNewGroup(state.groupList.list, action.data);
			let createGroup = changePid(state.groupList.list, editGroup);
			let newGroup = delOldGroup(createGroup, editGroup);
			state = {
				...state,
				groupList: {
					...state.groupList,
					list: newGroup
				}
			};
			return state;
		default:
			return state;
	}
};

