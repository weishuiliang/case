import React from 'react';
import { Select, Spin } from 'antd'
import axios from 'axios';
import qs from 'qs';

import API from '../../contants/ApiRoot';
import { TASK_USER_LIST_POST } from '../../contants/actionTypes/task';

const { Option } = Select;

class NameSelect extends React.Component {
	constructor(props) {
		super(props);
		
		const value = this.props.value || {};
		this.state = {
			selectedValue: value.selectedValue || '',
			selectedText: value.selectedText || '',
			nameList: [],
			fetching: true,
		}
	}

	componentDidMount() {
		const { role_type } = this.props;
		this.fetchUser(role_type);
	}

	componentWillReceiveProps(nextProps) {
		if (('value' in nextProps) && nextProps.value) {
			const { value } = nextProps;			
			this.setState({
				selectedValue: value.selectedValue,
				selectedText: value.selectedText,
			});
		}
	}

	handleNameChange = (selectedValue) => {
		const { nameList } = this.state;
		const selectedText = nameList.filter(d => d.value === selectedValue)[0].text;
		if (!('value' in this.props)) {
			this.setState({selectedValue, selectedText});
		}
		this.triggerChange({ selectedValue, selectedText });
		// console.log(this.props.value);
	}
	
	triggerChange = (changedValue) => {
		const onChange = this.props.onChange;
		if (onChange) {
			onChange(Object.assign({}, this.state, changedValue));
			// onChange(changedValue.value);
		}
		// console.log(`changedValue: ${JSON.stringify(changedValue)}`);
	}

	fetchUser = (role_type) => {
		this.setState({ fetching: true });
		axios({
			method: 'POST',
			url: API[TASK_USER_LIST_POST],
			data: qs.stringify({role_type}),
		}).then(response => {
			if (response.data.status === 1) {
				const data = response.data.data.map(user => ({
					// id: user.user_id,
					text: user.name,
					value: user.user_id,
				}));
				this.setState({nameList: data, fetching: false});
			}
		});
	}

	render() { 
		const { nameList, selectedValue } = this.state;
		return (
			<Select
				value={selectedValue}
				onChange={this.handleNameChange}
				placeholder="选择人员名称"
			>
				{nameList.map(d => <Option key={d.value} value={d.value}>{d.text}</Option>)}
			</Select>
		)
	}

}

export default NameSelect;