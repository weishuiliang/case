import React from 'react';
import moment from 'moment';
import axios from 'axios';
import qs from 'qs';
import {
	Form, Input, DatePicker, Select, Button, Card, InputNumber, Radio, Icon, Tooltip, notification, Spin
} from 'antd';

import NameSelect from '../../components/Task/NameSelect';

import API from '../../contants/ApiRoot';
import { TASK_ADD_POST } from '../../contants/actionTypes/task';
import { openNotification } from '../../utils/utils';

const FormItem = Form.Item;
const { Option } = Select;
const { RangePicker } = DatePicker;
const { TextArea } = Input;

// const openNotification = (type, message) => {
// 	notification[type]({
// 		message: message
// 	});
// };

class ModifyTaskForms extends React.PureComponent {  
	state = {
		loading: false,
	}
  
	handleSubmit = (e) => {
		e.preventDefault();
		const that = this;
		this.props.form.validateFieldsAndScroll((err, values) => {
			if (!err) {
				that.setState({
					loading: true,
				});
				const {
					task_name,
					front_user,
					front_time,
					back_time,
					back_user,
					task_level,
				} = values;

				const front_start_time = moment(front_time[0]).format('X');
				const front_end_time = moment(front_time[1]).format('X');
				const back_start_time = moment(back_time[0]).format('X');
				const back_end_time = moment(back_time[1]).format('X');

				const formatedValue = {
					task_name,
					front_user_id: front_user.selectedValue,
					front_start_time,
					front_end_time,
					back_user_id: back_user.selectedValue,
					back_start_time,
					back_end_time,
					task_level,
				};
				console.log(formatedValue);

				axios({
					method: 'post',
					url: API[TASK_ADD_POST],
					// data: qs.stringify(values),
					data: qs.stringify(formatedValue),
				}).then(function(data) {
					if (data.data.status.toString() === '1') {
						openNotification('success', '添加成功');
					} else {
						openNotification('error', `添加失败: ${data.data.msg}`);
					}

					that.setState({
						loading: false,
					})
				});
				console.log(formatedValue);
			}
		});
  }
  
  handleDelete = (e) => {
    e.preventDefault();
    console.log('delete task');
  }
	render() {
		const { getFieldDecorator, getFieldValue } = this.props.form;

		const formItemLayout = {
			labelCol: {
				xs: { span: 24 },
				sm: { span: 7 },
			},
			wrapperCol: {
				xs: { span: 24 },
				sm: { span: 12 },
				md: { span: 10 },
			},
		};

		const submitFormLayout = {
			wrapperCol: {
				xs: { span: 24, offset: 0 },
				sm: { span: 10, offset: 7 },
			},
		};

		return (
			<Spin
				spinning={this.state.loading}
				tip="提交中"
			>
				<Form
					onSubmit={this.handleSubmit}
					hideRequiredMark
					style={{ marginTop: 8 }}
				>
					<FormItem
						{...formItemLayout}
						label="标题"
					>
						{getFieldDecorator('task_name', {
							rules: [{
								required: true, message: '请输入标题',
							}],
						})(
							<Input placeholder="给任务起个名字" />
						)}
					</FormItem>
					<FormItem
						{...formItemLayout}
						label="预计前端工作时间"
					>
						{getFieldDecorator('front_time', {
							rules: [{
								required: true, message: '请选择起止日期',
							}],
						})(
							<RangePicker
								style={{ width: '100%' }}
								placeholder={['开始时间', '结束时间']}
								format="YYYY-MM-DD"
							/>
						)}
					</FormItem>
					<FormItem
						{...formItemLayout}
						label="前端负责人"
					>
						{getFieldDecorator('front_user', {
							rules: [{
								required: true, message: '请输入前端负责人',
							}],
						})(
							// <Input placeholder="请输入前端负责人姓名" />
							<NameSelect role_type="1" />
						)}
					</FormItem>
					<FormItem
						{...formItemLayout}
						label="预计后端工作时间"
					>
						{getFieldDecorator('back_time', {
							rules: [{
								required: true, message: '请选择起止日期',
							}],
						})(
							<RangePicker
								style={{ width: '100%' }}
								placeholder={['开始时间', '结束时间']}
								format="YYYY-MM-DD"
							/>
						)}
					</FormItem>
					<FormItem
						{...formItemLayout}
						label="后端负责人"
					>
						{getFieldDecorator('back_user', {
							rules: [{
								required: true, message: '请输入后端负责人',
							}],
						})(
							// <Input placeholder="请输入后端负责人姓名" />
							<NameSelect role_type="2" />
						)}
					</FormItem>
					<FormItem
						{...formItemLayout}
						label="任务难度"
						help="任务的难易程度，默认为 “中等” 难度"
					>
						{getFieldDecorator('task_level', {
							initialValue: '20',
							rules: [{
								required: true, message: '请选择任务难度',
							}],
						})(
							<Radio.Group>
								<Radio value="10">简单</Radio>
								<Radio value="20">中等</Radio>
								<Radio value="30">困难</Radio>
							</Radio.Group>
						)}
					</FormItem>
					<FormItem {...submitFormLayout} style={{ marginTop: 32, textAlign: 'right' }}>
						<Button type="primary" htmlType="submit">
							提交
						</Button>
						{/* <Button style={{ marginLeft: 8 }} onClick={e => this.handleDelete(e)}>删除</Button> */}
					</FormItem>
				</Form>
			</Spin>
		);
	}
}

const WrappedTaskForms = Form.create()(ModifyTaskForms);
export default WrappedTaskForms;
