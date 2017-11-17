/**
 * 新增部门
 */
import React, { Component } from 'react';
import { Modal, Button, Form, Icon, Input, message, Select } from 'antd'
import axios from 'axios';
import { post } from '../../../utils/fetchPost';
import { openNotification } from '../../../utils/utils';

import * as types from '../../../contants/actionTypes/organize';
import API from '../../../contants/ApiRoot';

const FormItem = Form.Item;
const Option = Select.Option;
const formItemLayout = {
	labelCol: {
		xs: { span: 24 },
		sm: { span: 6 },
	},
	wrapperCol: {
		xs: { span: 24 },
		sm: { span: 14 },
	},
};

class AddPerson extends Component {
	constructor(props) {
		super(props);
		this.state = {
			loading: false,
			selectList: [],
			selectGroup: '',
			selectPositionList: []
		};
		this.handleOk = this.handleOk.bind(this);
		this.handleSubmit = this.handleSubmit.bind(this);
		this.fetchSelectPositionList = this.fetchSelectPositionList.bind(this);
	}

	componentDidMount() {
		const { personInfo, visible } = this.props;
		if (visible) {
			this.fetchSelectList();
		}
		if (!!personInfo.group_id) {
			this.fetchSelectPositionList(personInfo.group_id)
		}
	}

	/**
	 * 添加/修改
	 * @param values
	 */
	handleOk(values) {
		const { actions, onHideModal, personInfo, type } = this.props;
		this.setState({ loading: true });
		let data = {
			type: type === 'new' ? types.ORGANIZE_PERSON_ADD_POST : types.ORGANIZE_PERSON_EDIT_POST,
			method: 'post',
			params: {
				user_id: personInfo.user_id,
				name: values.name,
				account: values.account,
				group_id: values.groupID,
				mobile: values.mobile,
				role_id: values.role_id,
				pwd: values.pwd
			}
		};
		let callback = {
			onSuccess: (data) => {
				openNotification('success', type === 'new' ? '添加成功' : '修改成功');
				this.setState({ loading: false });
				onHideModal && onHideModal();
			},
			onError: (err) => {
				openNotification('error', err);
				this.setState({ loading: false });
			}
		};
		actions.request(data, callback, {middleNet: true});
	}

	/**
	 * 请求部门列表
	 */
	fetchSelectList() {
		axios.get(API[types.ORGANIZE_ALL_GROUP_GET], {
			params: {
				is_page: 0
			}
		})
		.then((response) => {
			if (response.statusText === 'OK') {
				if (response.data.status == 1) {
					this.setState({selectList: response.data.data})
				} else {
					console.log(response.data.msg);
					openNotification('error', response.data.msg);
				}
			}
		})
		.catch((error) => {
			console.log(error);
		});
	}

	fetchSelectPositionList(value) {
		post(API[types.ORGANIZE_GROUP_POSITION_LIST_GET], {
			group_id: value
		})
		.then((response) => {
			if (response.statusText === 'OK') {
				if (response.data.status == 1) {
					this.setState({selectPositionList: response.data.data})
				} else {
					console.log(response.data.msg);
					openNotification('error', response.data.msg);
				}
			}
		})
		.catch((error) => {
			console.log(error);
		});
	}

	handleSubmit(e) {
		e.preventDefault();
		this.props.form.validateFields((err, values) => {
			if (!err) {
				console.log('Received values of form: ', values);
				this.handleOk(values);
			}
		});
	}

	setSelectConfig(id) {
		const { personInfo } = this.props;
		let config = {rules: [{required: true, message: '请选择部门' }]};

		if (!!personInfo[`${id}`] && personInfo[`${id}`] !== '0') {
			config.initialValue = `${personInfo[`${id}`] || ''}`;
		}

		return config;
	}

	render() {
		const { loading, selectList, selectPositionList } = this.state;
		const { personInfo, visible, type, onHideModal } = this.props;
		const { getFieldDecorator } = this.props.form;

		return (
			<Modal
				visible={visible}
				title={type === 'new' ? "添加人员" : "编辑人员信息" }
				onOk={this.handleOk}
				onCancel={onHideModal}
				footer={null}
			>
				<Form onSubmit={this.handleSubmit} className="login-form">
					<FormItem
						{...formItemLayout}
						label="账号"
					>
						{getFieldDecorator('account', {
							initialValue: `${personInfo.account || ''}`,
							rules: [{ required: true, message: '请输入账号' }],
						})(
							<Input placeholder="请输入账号" />
						)}
					</FormItem>
					{
						type === 'edit' ?
							<FormItem
								{...formItemLayout}
								label="新密码"
							>
								{getFieldDecorator('pwd', {
									initialValue: `${personInfo.pwd || ''}`,
									rules: [{message: '请输入新密码' }],
								})(
									<Input placeholder="请输入新密码" />
								)}
							</FormItem>
							: null
					}
					<FormItem
						{...formItemLayout}
						label="姓名"
					>
						{getFieldDecorator('name', {
							initialValue: `${personInfo.name || ''}`,
							rules: [{required: true, message: '请输入姓名' }],
						})(
							<Input placeholder="请输入姓名" />
						)}
					</FormItem>
					<FormItem
						{...formItemLayout}
						label="手机号"
					>
						{getFieldDecorator('mobile', {
							initialValue: `${personInfo.mobile || ''}`,
							rules: [{required: true, message: '请输入手机号' }],
						})(
							<Input
								placeholder="请输入手机号"
								maxLength="11"
							/>
						)}
					</FormItem>
					<FormItem
						{...formItemLayout}
						label="所属部门"
					>
						{getFieldDecorator('groupID', this.setSelectConfig('group_id'))(
							<Select
								placeholder={'请选择部门'}
								onSelect={this.fetchSelectPositionList}
							>
								{
									selectList.length > 0 && selectList.map((item, index) => {
										return (
											<Option key={item.group_id + ''} value={item.group_id + ''}>{item.group_name}</Option>
										)
									})
								}
							</Select>
						)}
					</FormItem>
					{
						selectPositionList.length > 0 ?
							<FormItem
								{...formItemLayout}
								label="职位"
							>
								{getFieldDecorator('role_id', this.setSelectConfig('role_id'))(
									<Select placeholder={'请选择职位'}
									>
										{
											selectPositionList.length > 0 && selectPositionList.map((item, index) => {
												return (
													<Option key={item.role_id + ''} value={item.role_id + ''}>{item.position}</Option>
												)
											})
										}
									</Select>
								)}
							</FormItem>
							: null
					}
					<FormItem>
						<div className="g-flex g-jc-end" style={{marginBottom: '-20px'}}>
							<Button key="back" size="large" onClick={onHideModal}>取消</Button>,
							<Button key="submit" type="primary" size="large" loading={loading} htmlType="submit">
								确认
							</Button>
						</div>
					</FormItem>
				</Form>
			</Modal>
		);
	}
}

export default Form.create()(AddPerson)
