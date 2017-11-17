/**
 * 用户设置POp
 */
import React, { Component } from 'react';
import { Modal } from 'antd';
import EditUserInfo from './EditUserInfo';
import * as types from '../../contants/actionTypes/login';
import { openNotification } from '../../utils/utils';

class UserSettingPop extends Component {
	constructor(props) {
		super(props);
		this.state = {
			visible: false,
			modalKey: 0
		};
		this.handleLogout = this.handleLogout.bind(this);
		this.handleShowModal = this.handleShowModal.bind(this);
		this.handleHideModal = this.handleHideModal.bind(this);
	}

	handleLogout() {
		const { actions } = this.props;
		let data = {
			type:types.LOGIN_OUT_POST,
			method: 'post',
			params: {}
		};
		let callback = {
			onSuccess: (data) => {
				// console.log(_global)
				// _global.history.push('/');
				location.href = '/';
				openNotification('success', '退出成功');
			},
			onError: (err) => {
				openNotification('error', err);
			}
		};
		actions.request(data, callback, {middleNet: true});
	}

	handleShowModal() {
		this.setState({
			visible: true,
			modalKey: Date.parse(new Date())
		});
	}

	handleHideModal() {
		this.setState({visible: false});
	}

	render() {
		const { actions } = this.props;

		return (
			<div>
				<p className="pointer" onClick={this.handleShowModal}>修改密码</p>
				<p className="pointer" onClick={this.handleLogout}>退出</p>
				<EditUserInfo
					key={this.state.modalKey}
					actions={actions}
					visible={this.state.visible}
					onShowModal={this.handleShowModal}
					onHideModal={this.handleHideModal}
				/>
			</div>
		)
	}
}

export default UserSettingPop;
