/**
 * 日志列表
 */
import React, { Component } from 'react';
import { Table } from 'antd';
import { openNotification } from '../../utils/utils';
import * as types from '../../contants/actionTypes/log';

class List extends Component {
	constructor(props) {
		super(props);
		this.state = {
			visible: false,
		};
	}

	componentDidMount() {
		this.fetchData();
	}

	fetchData() {
		const {actions} = this.props;
		let data = {
			type: types.LOG_LIST_POST,
			method: 'POST',
			params: {}
		};
		let callback = {
			onSuccess: () => {
			},
			onError: (err) => {
				openNotification('error', err);
			}
		};
		actions.request(data, callback, {tableLoading: true, middleNet: true});
	}

	getColumns() {
		let columns = [
			{
				title: 'ID',
				dataIndex: 'log_id',
				key: 'log_id',
			},
			{
				title: '操作人',
				dataIndex: 'action_user',
				key: 'action_user'
			},
			{
				title: '模块',
				dataIndex: 'module',
				key: 'module',
			},
			{
				title: '操作详情',
				dataIndex: 'log_detail',
				key: 'log_detail',
			},
			{
				title: '变更数据',
				dataIndex: 'log_title',
				key: 'log_title',
			},
			{
				title: '操作人IP',
				dataIndex: 'ip',
				key: 'ip',
			},
			{
				title: '操作时间',
				dataIndex: 'create_time',
				key: 'create_time',
			},
		];
		return columns;
	}

	render() {
		const {listInfo, actions} = this.props;
		const columns = this.getColumns();

		return (
			<Table
				loading={listInfo.loading}
				rowKey={"log_id"}
				pagination={{showQuickJumper: true}}
				columns={columns}
				dataSource={listInfo.list}
			/>
		);
	}
}

export default List;
