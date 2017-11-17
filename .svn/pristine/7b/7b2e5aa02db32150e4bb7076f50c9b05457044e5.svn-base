import React from 'react';
import { Table, Popconfirm, Button, Input, Icon, DatePicker } from 'antd';
import moment from 'moment';
import qs from 'qs';
import axios from 'axios';

import Upload from './Upload';
import DateFilterDropdown from './DateFilterDropdown';

import API from '../../contants/ApiRoot';
import { TASK_GET, TASK_END_POST, TASK_DEL_POST, TASK_UPLOAD_POST, TASK_EXPORT_POST } from '../../contants/actionTypes/task';

import { openNotification } from '../../utils/utils';

import './task.scss';

const { RangePicker } = DatePicker;

class TaskTableList extends React.Component {
	state = {
		loading: true,
		loadingTip: '正在获取数据...',
		pagination: {
			showQuickJumper: true,
		},
		selectedRowKeys: [],
		sortName: null, // 排序 的名称
		sortValue: null, // 排序方式 'asc' | 'desc'

		// 搜索前端
		frontSearchText: null,
		frontFiltered: false,
		frontFilterDropdownVisible: false,

		// 搜索后端
		backSearchText: null,
		backFiltered: false,
		backFilterDropdownVisible: false,

		// 过滤前端开始时间
		frontStartTimeFrom: null,
		frontStartTimeTo: null,
		frontStartTimeFiltered: false,
		frontStartTimeFilterDropdownVisible: false,

		// 过滤前端结束时间
		frontEndTimeFrom: null,
		frontEndTimeTo: null,
		frontEndTimeFiltered: false,
		frontEndTimeFilterDropdownVisible: false,

		// 过滤后端开始时间
		backStartTimeFrom: null,
		backStartTimeTo: null,
		backStartTimeFiltered: false,
		backStartTimeFilterDropdownVisible: false,

		// 过滤后端结束时间
		backEndTimeFrom: null,
		backEndTimeTo: null,
		backEndTimeFiltered: false,
		backEndTimeFilterDropdownVisible: false,

		// 过滤实际结束时间
		overTimeFrom: null,
		overTimeTo: null,
		overTimeFiltered: false,
		overTimeFilterDropdownVisible: false,

	};
	componentDidMount() {
		this.fetchData();
		// const { getTaskList } = this.props.actions;
		// axios.get(API[TASK_GET]).then(response => {
		// 	console.log(response);
		// 	getTaskList(response.data.data.list);
		// 	this.setState({
		// 		loading: false,
		// 	});
		// });
	}

	fetchData = (params = {}) => {
		const { getTaskList } = this.props.actions;
		const {
			frontSearchText,
			backSearchText,

			frontStartTimeFrom,
			frontStartTimeTo,

			frontEndTimeFrom,
			frontEndTimeTo,

			backStartTimeFrom,
			backStartTimeTo,

			backEndTimeFrom,
			backEndTimeTo,

			overTimeFrom,
			overTimeTo,

			sortName,
			sortValue,
		} = this.state;

		params ={
			front_user_name: frontSearchText,
			back_user_name: backSearchText,

			front_start_time_from: !!frontStartTimeFrom ? frontStartTimeFrom.startOf('day').format('X') : null,
			front_start_time_to: !!frontStartTimeTo ? frontStartTimeTo.endOf('day').format('X') : null,

			front_end_time_from: !!frontEndTimeFrom ? frontEndTimeFrom.startOf('day').format('X') : null,
			front_end_time_to: !!frontEndTimeTo ? frontEndTimeTo.endOf('day').format('X') : null,

			back_start_time_from: !!backStartTimeFrom ? backStartTimeFrom.startOf('day').format('X') : null,
			back_start_time_to: !!backStartTimeTo ? backStartTimeTo.endOf('day').format('X') : null,

			back_end_time_from: !!backEndTimeFrom ? backEndTimeFrom.startOf('day').format('X') : null,
			back_end_time_to: !!backEndTimeTo ? backEndTimeTo.endOf('day').format('X') : null,

			over_time_from: !!overTimeFrom ? overTimeFrom.startOf('day').format('X') : null,
			over_time_to: !!overTimeTo ? overTimeTo.endOf('day').format('X') : null,

			sort_name: sortName,
			sort_val: sortValue,
			...params,
		};
		
		this.setState({
			loading: true,
			loadingTip: '正在获取数据...'
		});
		return axios({
			method: 'GET',
			url: API[TASK_GET],
			params
		}).then(response => {
			console.log(response);
			getTaskList(response.data.data.list);
			this.setState({
				pagination: {
					current: Number(response.data.data.currentPage),
					total: Number(response.data.data.totalCount),
				},
				loading: false,
			});
		});
	}

	// 约束 DatePicker 的开始和结束日期
	disabledStartDate = (endValue) => (startValue) => {
		if (!startValue || !endValue) {
			return false;
		}	
		return startValue.valueOf() > endValue.valueOf();
	}
	disabledEndDate = (startValue) => (endValue) => {
		if (!startValue || !endValue) {
			return false;
		}
		return endValue.valueOf() <= startValue.valueOf();
	}

	// 搜索前端
	onFrontSearchInputChange = (e) => {
		this.setState({ frontSearchText: e.target.value });
	}
	onFrontSearch = () => {
		const { frontSearchText } = this.state;
		this.fetchData({
			front_user_name: frontSearchText
		}).then(() => {
			this.setState({
				frontFilterDropdownVisible: false,
				frontFiltered: !!frontSearchText,
			})
		})
	}

	// 搜索后端
	onBackSearchInputChange = (e) => {
		this.setState({ backSearchText: e.target.value });
	}
	onBackSearch = () => {
		const { backSearchText } = this.state;
		this.fetchData({
			back_user_name: backSearchText
		}).then(() => {
			this.setState({
				backFilterDropdownVisible: false,
				backFiltered: !!backSearchText,
			});
		})
	}

	// 过滤前端开始时间
	onFrontStartTimeFromChange = (value) => {
		this.setState({
			frontStartTimeFrom: value,
			frontStartTimeFilterDropdownVisible: true, // 防止选择日期后 dropdown 关闭 
		});
	}
	onFrontStartTimeToChange = (value) => {
		this.setState({
			frontStartTimeTo: value,
			frontStartTimeFilterDropdownVisible: true, // 防止选择日期后 dropdown 关闭
		});
	}
	onFrontStartTimeConfirm = () => {
		const { frontStartTimeFrom, frontStartTimeTo } = this.state;
		this.fetchData().then(() => {
			this.setState({
				frontStartTimeFiltered: (!!frontStartTimeFrom) || (!!frontStartTimeTo),
				frontStartTimeFilterDropdownVisible: false,
			});
		});
	}

	// 过滤前端结束时间
	onFrontEndTimeFromChange = (value) => {
		this.setState({
			frontEndTimeFrom: value,
			frontEndTimeFilterDropdownVisible: true,
		});
	}
	onFrontEndTimeToChange = (value) => {
		this.setState({
			frontEndTimeTo: value,
			frontEndTimeFilterDropdownVisible: true,
		});
	}
	onFrontEndTimeConfirm = () => {
		const { frontEndTimeFrom, frontEndTimeTo } = this.state;
		this.fetchData().then(() => {
			this.setState({
				frontEndTimeFiltered: (!!frontEndTimeFrom) || (!!frontEndTimeTo),
				frontEndTimeFilterDropdownVisible: false,
			});
		});
	}

	// 过滤后端开始时间
	onBackStartTimeFromChange = (value) => {
		this.setState({
			backStartTimeFrom: value,
			backStartTimeFilterDropdownVisible: true,
		});
	}
	onBackStartTimeToChange = (value) => {
		this.setState({
			backStartTimeTo: value,
			backStartTimeFilterDropdownVisible: true, // 防止选择日期后 dropdown 关闭
		});
	}
	onBackStartTimeConfirm = () => {
		const { backStartTimeFrom, backStartTimeTo } = this.state;
		this.fetchData().then(() => {
			this.setState({
				backStartTimeFiltered: (!!backStartTimeFrom) || (!!backStartTimeTo),
				backStartTimeFilterDropdownVisible: false,
			});
		});
	}

	// 过滤后端结束时间
	onBackEndTimeFromChange = (value) => {
		this.setState({
			backEndTimeFrom: value,
			backEndTimeFilterDropdownVisible: true,
		});
	}
	onBackEndTimeToChange = (value) => {
		this.setState({
			backEndTimeTo: value,
			backEndTimeFilterDropdownVisible: true,
		});
	}
	onBackEndTimeConfirm = () => {
		const { backEndTimeFrom, backEndTimeTo } = this.state;
		this.fetchData().then(() => {
			this.setState({
				backEndTimeFiltered: (!!backEndTimeFrom) || (!!backEndTimeTo),
				backEndTimeFilterDropdownVisible: false,
			});
		});
	}

	// 过滤实际结束时间
	onOverTimeFromChange = (value) => {
		this.setState({
			overTimeFrom: value,
			overTimeFilterDropdownVisible: true,
		});
	}
	onOverTimeToChange = (value) => {
		this.setState({
			overTimeTo: value,
			overTimeFilterDropdownVisible: true,
		});
	}
	onOverTimeConfirm = () => {
		const { overTimeFrom, overTimeTo } = this.state;
		this.fetchData().then(() => {
			this.setState({
				overTimeFiltered: (!!overTimeFrom) || (!!overTimeTo),
				overTimeFilterDropdownVisible: false,
			});
		});
	}

	// table内容多选
	onSelectChange = (selectedRowKeys) => {
		console.log('selectedRowKeys changed: ', selectedRowKeys);
		this.setState({selectedRowKeys});
	}

	// 导出控制
	handleExportList = () => {
		const { selectedRowKeys } = this.state;
		axios({
			method: 'POST',
			url: API[TASK_EXPORT_POST],
			data: {task_id_list: selectedRowKeys},
			responseType: 'blob'
		}).then(response => {
			if (response.data) {
				// console.log(response.data);
				let a = document.createElement('a');
				let url = window.URL.createObjectURL(response.data);
				const filename = '任务.xls';
				a.href = url;
				a.download = filename;
				document.body.appendChild(a);
				a.click();
				window.URL.revokeObjectURL(url);
				document.body.removeChild(a);
			} else {
				openNotification('error', `出错了`)
			}
			/*
			if (response.data.status === '1' && false) {
				let a = document.createElement('a');
				const url = response.data.url; // 文件下载地址
				const filename = '任务.xls'; // 下载栏显示的文件名 html5 api
				a.href = url;
				a.download = filename;
				a.click();
				a = null;
			} else {
				openNotification('error', `出错了`)
			}
			*/
		});
	}

	// 表格状态更新
	handleTableChange = (pagination, filters, sort) => {
		const pager = {...this.state.pagination};
		pager.current = pagination.current;
		this.setState({
			pagination: pager,
			sortName: sort.field,
			sortValue: sort.order === 'ascend' ? 'asc' : 'desc',
		});
		this.fetchData({
			page: pager.current,
			sort_name: sort.field,
			sort_val: sort.order === 'ascend' ? 'asc' : 'desc',
			...filters,
		});
	};

	// 弹出编辑任务弹窗
	handleClickModify = (e, task_id) => {
		e.preventDefault();
		this.props.handleOpenModal();
		this.props.actions.changeTaskModifyId({task_id});
	}

	// 标记任务为完成
	handleFinishTask = (e, record) => {
		e.preventDefault();
		this.setState({
			loading: true,
			loadingTip: '正在将任务标记为完成...',
		});

		const { finishTask } = this.props.actions;
		const time = Date.now();
		const params = {
			task_id: record.task_id,
			over_time: moment(time).format('X'),
		}
		axios({
			method: 'post',
			url: API[TASK_END_POST],
			// url: '/api/task/task/task-over.json',
			data: qs.stringify(params),
			// data: params,
		}).then(data => {
				if(data.data.status.toString() === '1') {
					openNotification('success', `标记 ${record.task_name} 为完成成功`);
					// alert('标记为完成成功');
					finishTask({
						task_id: params.task_id,
						over_time: moment(time).format('YYYY-MM-DD'),
					});
				} else {
					openNotification('error', `标记 ${record.task_name} 为完成失败, ${data.data.msg}`);
				}
				this.setState({ loading: false });
			}
		)
	}

	// 删除任务
	handleDeleteTask = (e, record) => {
		e.preventDefault();
		this.setState({
			loading: true,
			loadingTip: '正在删除任务...',
		});

		const { deleteTask } = this.props.actions;

		const { task_id, task_name }= record;
    axios.post(
			API[TASK_DEL_POST],
			qs.stringify({task_id})
		).then(response => {
			if (response.data.status.toString() === '1') {
				console.log('删除成功');
				deleteTask(task_id);
				openNotification('success', `删除 ${task_name} 成功`);
				this.fetchData({page: this.state.pagination.current}); // 删除成功后重新获取数据
			} else {
				// alert('更新失败');
				openNotification('error', `删除 ${task_name} 失败, ${response.data.msg}`);
				this.setState({ loading: false });
			}
		})
  }

	render() {
		const { handleClickModify } = this.props;
		const {
			loading,
			loadingTip,
			pagination,
			selectedRowKeys,
			frontStartTimeFrom,
			frontStartTimeTo,
			frontEndTimeFrom,
			frontEndTimeTo,
			backStartTimeFrom,
			backStartTimeTo,
			backEndTimeFrom,
			backEndTimeTo,
			overTimeFrom,
			overTimeTo
		} = this.state;

		const rowSelection = {
			selectedRowKeys,
			onChange: this.onSelectChange,
		};
		const hasSelected = selectedRowKeys.length > 0;

		const fetchData = this.fetchData;
		const uploadProps = {
			name: 'file',
			action: API[TASK_UPLOAD_POST],
			onChange(info) {
				if (info.file.status !== 'uploading') {
					console.log(info.file, info.fileList);
				}
				if (info.file.status === 'done') {
					openNotification('success', "文件上传成功");
					fetchData(); // 上传成功后重新获取数据
				} else if (info.file.status === 'error') {
					openNotification('error', "文件上传失败");
				}
			},
		};
		const columns = [
			{	// 任务名称
				title: '任务名称',
				dataIndex: 'task_name',
				key: 'task_name',
			},
			{ // 难度
				title: '难度',
				dataIndex: 'task_level_name',
				key: 'task_level_name',
			},
			{ // 前端负责人
				title: '前端',
				dataIndex: 'front_user_name',
				key: 'front_user_name',
				filterDropdown: (
					<div className="task-filter-dropdown">
						<Input
							className="input"
							ref={ele => this.frontSearchInput = ele}
							placeholder="搜索前端"
							value={this.state.frontSearchText}
							onChange={this.onFrontSearchInputChange}
							onPressEnter={this.onFrontSearch}
						/>
						<Button type="primary" onClick={this.onFrontSearch}>搜索</Button>
					</div>
				),
				filterIcon: <Icon type="search" style={{color: this.state.frontFiltered ? '#108ee9' : '#aaa'}}/>,
				filterDropdownVisible: this.state.frontFilterDropdownVisible,
				onFilterDropdownVisibleChange: (visible) => {
					this.setState({
						frontFilterDropdownVisible: visible,
					}, () => this.frontSearchInput.focus());
				},
			},
			{ // 后端负责人
				title: '后端',
				dataIndex: 'back_user_name',
				key: 'back_user_name',
				filterDropdown: (
					<div className="task-filter-dropdown">
						<Input
							className="input"
							ref={ele => this.backSearchInput = ele}
							placeholder="搜索后端"
							value={this.state.backSearchText}
							onChange={this.onBackSearchInputChange}
							onPressEnter={this.onBackSearch}
						/>
						<Button type="primary" onClick={this.onBackSearch}>搜索</Button>
					</div>
				),
				filterIcon: <Icon type="search" style={{color: this.state.backFiltered ? '#108ee9' : '#aaa'}}/>,
				filterDropdownVisible: this.state.backFilterDropdownVisible,
				onFilterDropdownVisibleChange: (visible) => {
					this.setState({
						backFilterDropdownVisible: visible,
					}, () => this.backSearchInput.focus());
				},
			},
			{ // 开始时间(前端)
				title: '开始时间（前端）',
				dataIndex: 'front_start_time',
				key: 'front_start_time',
				sorter: true,
				filterDropdown: (
					<DateFilterDropdown
						startValue={this.state.frontStartTimeFrom}
						endValue={this.state.frontStartTimeTo}
						disabledStartDate={this.disabledStartDate(frontStartTimeTo)}
						disabledEndDate={this.disabledEndDate(frontStartTimeFrom)}
						onStartChange={this.onFrontStartTimeFromChange}
						onEndChange={this.onFrontStartTimeToChange}
						onConfirm={this.onFrontStartTimeConfirm}
					/>
				),
				filterIcon: <Icon type="filter" style={{color: this.state.frontStartTimeFiltered ? '#108ee9' : '#aaa'}}/>,
				filterDropdownVisible: this.state.frontStartTimeFilterDropdownVisible,
				onFilterDropdownVisibleChange: (visible) => {
					this.setState({
						frontStartTimeFilterDropdownVisible: visible,
					});
				},
			},
			{ // 预计完成时间(前端)
				title: '预计完成时间（前端）',
				dataIndex: 'front_end_time',
				key: 'front_end_time',
				sorter: true,
				filterDropdown: (
					<DateFilterDropdown
						startValue={this.state.frontEndTimeFrom}
						endValue={this.state.frontEndTimeTo}
						disabledStartDate={this.disabledStartDate(frontEndTimeTo)}
						disabledEndDate={this.disabledEndDate(frontEndTimeFrom)}
						onStartChange={this.onFrontEndTimeFromChange}
						onEndChange={this.onFrontEndTimeToChange}
						onConfirm={this.onFrontEndTimeConfirm}
					/>
				),
				filterIcon: <Icon type="filter" style={{color: this.state.frontEndTimeFiltered ? '#108ee9' : '#aaa'}}/>,
				filterDropdownVisible: this.state.frontEndTimeFilterDropdownVisible,
				onFilterDropdownVisibleChange: (visible) => {
					this.setState({
						frontEndTimeFilterDropdownVisible: visible,
					});
				},
			},
			{ // 开始时间（后端）
				title: '开始时间（后端）',
				dataIndex: 'back_start_time',
				key: 'back_start_time',
				sorter: true,
				filterDropdown: (
					<DateFilterDropdown
						startValue={this.state.backStartTimeFrom}
						endValue={this.state.backStartTimeTo}
						disabledStartDate={this.disabledStartDate(backStartTimeTo)}
						disabledEndDate={this.disabledEndDate(backStartTimeFrom)}
						onStartChange={this.onBackStartTimeFromChange}
						onEndChange={this.onBackStartTimeToChange}
						onConfirm={this.onBackStartTimeConfirm}
					/>
				),
				filterIcon: <Icon type="filter" style={{color: this.state.backStartTimeFiltered ? '#108ee9' : '#aaa'}}/>,
				filterDropdownVisible: this.state.backStartTimeFilterDropdownVisible,
				onFilterDropdownVisibleChange: (visible) => {
					this.setState({
						backStartTimeFilterDropdownVisible: visible,
					});
				},
			},
			{ // 预计完成时间（后端）
				title: '预计完成时间（后端）',
				dataIndex: 'back_end_time',
				key: 'back_end_time',
				sorter: true,
				filterDropdown: (
					<DateFilterDropdown
						startValue={this.state.backEndTimeFrom}
						endValue={this.state.backEndTimeTo}
						disabledStartDate={this.disabledStartDate(backEndTimeTo)}
						disabledEndDate={this.disabledEndDate(backEndTimeFrom)}
						onStartChange={this.onBackEndTimeFromChange}
						onEndChange={this.onBackEndTimeToChange}
						onConfirm={this.onBackEndTimeConfirm}
					/>
				),
				filterIcon: <Icon type="filter" style={{color: this.state.backEndTimeFiltered ? '#108ee9' : '#aaa'}}/>,
				filterDropdownVisible: this.state.backEndTimeFilterDropdownVisible,
				onFilterDropdownVisibleChange: (visible) => {
					this.setState({
						backEndTimeFilterDropdownVisible: visible,
					});
				},
			},
			{ // 实际完成时间
				title: '实际完成时间',
				dataIndex: 'over_time',
				key: 'over_time',
				sorter: true,
				filterDropdown: (
					<DateFilterDropdown
						startValue={this.state.overTimeFrom}
						endValue={this.state.overTimeTo}
						disabledStartDate={this.disabledStartDate(overTimeTo)}
						disabledEndDate={this.disabledEndDate(overTimeFrom)}
						onStartChange={this.onOverTimeFromChange}
						onEndChange={this.onOverTimeToChange}
						onConfirm={this.onOverTimeConfirm}
					/>
				),
				filterIcon: <Icon type="filter" style={{color: this.state.overTimeFiltered ? '#108ee9' : '#aaa'}}/>,
				filterDropdownVisible: this.state.overTimeFilterDropdownVisible,
				onFilterDropdownVisibleChange: (visible) => {
					this.setState({
						overTimeFilterDropdownVisible: visible,
					});
				},
			},
			{ // 操作
				title: '操作',
				key: 'action',
				render: (text, record) => (
					<span>
						<a href="#" onClick={(e) => this.handleClickModify(e, record.task_id)} >编辑</a>
						<span className="ant-divider" />
						<Popconfirm
							title={`确定任务完成了么？`}
							onConfirm={(e) => this.handleFinishTask(e, record)}
							okText="确认"
							cancelText="取消"
						>
							<a href="#">完成</a>
						</Popconfirm>
						<span className="ant-divider" />
						<Popconfirm
							title={`确定要删除任务？`}
							onConfirm={(e) => this.handleDeleteTask(e, record)}
							okText="确认"
							cancelText="取消"
							style={{alignItems: 'end'}}
						>
							<a href="#">删除</a>
						</Popconfirm>
					</span>
				)
			}
		];
		return (
			<div>
				<div style={{margin: '1em 0'}}>
					<Button
						style={{margin: "0 1em 0 0"}}
						type="primary"
						disabled={!hasSelected}
						onClick={this.handleExportList}
					>
						批量导出
					</Button>
					<Upload {...uploadProps} />
				</div>
				<Table
					loading={{
						spinning: loading,
						tip: loadingTip,
					}}
					rowKey="task_id"
					columns={columns}
					dataSource={this.props.data}
					pagination={pagination}
					onChange={this.handleTableChange}
					rowSelection={rowSelection}
				/>
			</div>
		);
	}
}

export default TaskTableList;
