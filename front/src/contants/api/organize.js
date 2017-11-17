/**
 * 组织结构 API
 */
const api = {
	// 部门
	'ORGANIZE_GROUP_LIST_GET':            '/home/group/group-list.json',
	'ORGANIZE_GROUP_ADD_POST':            '/home/group/group-add.json',
	'ORGANIZE_GROUP_EDIT_POST':           '/home/group/group-edit.json',
	'ORGANIZE_GROUP_DEL_POST':            '/home/group/group-del.json',
	// 人员
	'ORGANIZE_PERSON_LIST_GET':           '/home/user/user-list.json',
	'ORGANIZE_PERSON_ADD_POST':           '/home/user/user-add.json',
	'ORGANIZE_PERSON_EDIT_POST':          '/home/user/user-update.json',
	'ORGANIZE_PERSON_DEL_POST':           '/home/user/user-del.json',
	// 职位
	'ORGANIZE_POSITION_LIST_GET':           '/home/role/list.json',
	'ORGANIZE_POSITION_ADD_POST':           '/home/role/add.json',
	'ORGANIZE_POSITION_EDIT_POST':          '/home/role/update.json',
	'ORGANIZE_POSITION_DEL_POST':           '/home/role/del.json',
	// 对应部门的职位
	'ORGANIZE_GROUP_POSITION_LIST_GET':     '/home/role/group-position-list.json',
	// 获取子部门
	'ORGANIZE_CHILD_GROUP_POST':            '/home/group/son-group-list.json',
	// 获取所有部门
	'ORGANIZE_ALL_GROUP_GET':               '/home/group/group-all.json',
};

export default api;