/**
 * 用户登录界面
 */
import React, { Component } from 'react';
import { Form, Icon, Input, Button, message } from 'antd';
import axios from 'axios';
import Qs from 'qs';
import * as types from '../../contants/actionTypes/login';
import API from '../../contants/ApiRoot';
//styles
import './Styles.scss';

const FormItem = Form.Item;

class Login extends Component {

	handleSubmit = (e) => {
		e.preventDefault();
		this.props.form.validateFields((err, values) => {
			if (!err) {
				console.log('Received values of form: ', values);
				this.fetchLogin(values);
			}
		});
	};

	fetchLogin(values) {
		const { actions } = this.props;

		let data = {
			type: types.LOGIN_POST,
			method: 'post',
			params: {
				account: values.userName,
				pwd: values.password
			}
		};
		let callback = {
			onSuccess: (data) => {
				_global.history.push('/');
			},
			onError: (err) => {message.error(err);}
		};
		actions.request(data, callback, {progress: true, middleNet: true});
	}
	
	render() {
		const { getFieldDecorator } = this.props.form;
		return (
			<Form onSubmit={this.handleSubmit} className="login-form _main-container">
				<FormItem>
					{getFieldDecorator('userName', {
						rules: [{ required: true, message: '请输入用户名!' }],
					})(
						<Input prefix={<Icon type="user" style={{ fontSize: 13 }} />} placeholder="Username" />
					)}
				</FormItem>
				<FormItem>
					{getFieldDecorator('password', {
						rules: [{ required: true, message: '请输入密码!' }],
					})(
						<Input prefix={<Icon type="lock" style={{ fontSize: 13 }} />} type="password" placeholder="Password" />
					)}
				</FormItem>
				<FormItem>
					<Button type="primary" htmlType="submit" style={{width: '100%'}}>
						登录
					</Button>
				</FormItem>
			</Form>
		)
	}
}

export default  Form.create()(Login);
