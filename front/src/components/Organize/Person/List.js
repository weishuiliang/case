/**
 * 员工列表
 */
import React, {Component} from 'react';
import { Table, Button, Popconfirm } from 'antd';
import { openNotification } from '../../../utils/utils';
import * as types from '../../../contants/actionTypes/organize';
import PersonAddModal from './Add'

class PersonList extends Component {
	constructor(props){
		super(props);
		this.state = {
			visible: false,
			personInfo: {},
			type: 'new',
			modalKey: 0
		};
		this.handleEdit = this.handleEdit.bind(this);
		this.handleDel = this.handleDel.bind(this);
		this.handleShowModal = this.handleShowModal.bind(this);
		this.handleHideModal = this.handleHideModal.bind(this);
		this.handleTableChange = this.handleTableChange.bind(this);
	}

	componentDidMount() {
		this.fetchData(1);
	}

	fetchData(page) {
		const { actions } = this.props;
		let data = {
			type: types.ORGANIZE_PERSON_LIST_GET,
			method: 'get',
			params: {page}
		};
		let callback = {
			onSuccess: () => {},
			onError: (err) => {openNotification('error', err);}
		};
		actions.request(data, callback, {tableLoading: true, middleNet: true});
	}

	handleEdit(value) {
		this.setState({
			personInfo: {
				account: value.account,
				name: value.name,
				mobile: value.mobile,
				group_id: value.group_id,
				user_id: value.user_id,
				position: value.position,
				role_id: value.role_id,
			},
			visible: true,
			type: 'edit',
			modalKey: Date.parse(new Date())
		})
	}

	handleDel(id) {
		const { actions, listInfo } = this.props;
		let data = {
			type: types.ORGANIZE_PERSON_DEL_POST,
			method: 'post',
			params: {user_id: id}
		};
		let callback = {
			onSuccess: (data) => {
				// actions.delPerson(id);
				openNotification('success', '删除成功');
				this.fetchData(listInfo.pagination.current);
			},
			onError: (err) => {openNotification('error', err);}
		};
		actions.request(data, callback, {progress: true, middleNet: true});
	}

	handleTableChange(pagination, filters, sorter) {

		this.fetchData(pagination.current)
	}

	handleShowModal() {
		this.setState({
			personInfo: null,
			visible: true,
			type: 'new',
			modalKey: Date.parse(new Date())
		});
	}

	handleHideModal() {
		this.setState({visible: false});
	}

	getColumns() {
		let columns = [
			{
				title: '工号',
				dataIndex: 'user_sn',
				key: 'user_sn',
			},
			{
				title: '姓名',
				dataIndex: 'name',
				key: 'name'
			},
			{
				title: '手机号',
				dataIndex: 'mobile',
				key: 'mobile',
			},
			{
				title: '部门',
				dataIndex: 'group_name',
				key: 'group_name',
			},
			{
				title: '职位',
				dataIndex: 'position',
				key: 'position',
			},
			{
				title: '操作',
				render: (text, record, index) => {
					return (
						<span>
							<a href="#" onClick={(event) => {
								event.preventDefault();
								this.handleEdit(record)
							}}>编辑</a>
							<span className="ant-divider" />
							<Popconfirm
								title={`确认删除该人员吗?`}
								onConfirm={() => this.handleDel(record.user_id)}
								okText="确认"
								cancelText="取消"
							>
								<a href="#">删除</a>
							</Popconfirm>
						</span>
					)
				}
			}
		];
		return columns;
	}

	render() {
		const {listInfo, actions} = this.props;
		const columns = this.getColumns();

		return (
			<div>
				<Button type="primary" className="g-m-b" onClick={this.handleShowModal}>
					添加人员
				</Button>
				<Table
					loading={listInfo.loading}
					rowKey={"user_id"}
					columns={columns}
					pagination={listInfo.pagination}
					dataSource={listInfo.list}
					onChange={this.handleTableChange}
				/>
				<PersonAddModal
					key={this.state.modalKey}
					actions={actions}
					personInfo={this.state.personInfo || {}}
					visible={this.state.visible}
					type={this.state.type}
					onShowModal={this.handleShowModal}
					onHideModal={this.handleHideModal}
				/>
			</div>
		);
	}
}

export default PersonList;
