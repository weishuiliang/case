/**
 * 人员Reducer
 */
import * as types from '../../contants/actionTypes/organize';

const initState = {
	personList: {
		pagination: {
			current: 1,
			total: 0,
			showQuickJumper: true
		},
		list: [],
		loading: false
	},
};

const editPerson = (array, data) => {
	let personArray = [...array];
	for (let i = 0; i < personArray.length; i++) {
		if (personArray[i].user_id == data.user_id) {
			personArray[i] = {...personArray[i], ...data}
		}
	}
	return personArray;
};

export const organizePerson = (state = initState, action) => {
	switch(action.type) {
		case types.ORGANIZE_PERSON_LIST_GET + '_ON':
			state = {
				...state,
				personList: {
					...state.personList,
					loading: true
				}
			};
			return state;
		case types.ORGANIZE_PERSON_LIST_GET + '_SUCCESS':
			state = {
				...state,
				personList: {
					...state.personList,
					pagination: {
						...state.personList.pagination,
						current: parseInt(action.data.currentPage),
						total:parseInt( action.data.totalCount)
					},
					list: [...action.data.list],
					loading: false
				}
			};
			return state;
		case types.ORGANIZE_PERSON_LIST_GET + '_ERROR':
			state = {
				...state,
				personList: {
					...state.personList,
					loading: false
				}
			};
			return state;
		case types.ORGANIZE_PERSON_ADD_POST + '_SUCCESS':
			state = {
				...state,
				personList: {
					...state.personList,
					list: [action.data, ...state.personList.list],
					pagination: {
						...state.personList.pagination,
						total: state.personList.pagination.total + 1
					}
				}
			};
			return state;
		case types.ORGANIZE_PERSON_EDIT_POST + '_SUCCESS':
			state = {
				...state,
				personList: {
					...state.personList,
					list: editPerson(state.personList.list, action.data)
				}
			};
			return state;
		default:
			return state;
	}
};

