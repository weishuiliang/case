/**
 * 日志列表
 */
import React, { Component } from 'react';
// redux相关
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import * as actions from '../../actions/log';
//component
import LogList from '../../components/Log/List';

class Log extends Component {

	render() {
		const { logList, actions } = this.props;

		return (
			<LogList
				listInfo={logList}
				actions={actions}
			/>
		)
	}
}

function mapStateToProps(state) {
	return {
		logList: state.logList,
	};
}

function mapDispatchToProps(dispatch) {
	return {
		actions: bindActionCreators(actions, dispatch)
	};
}

export default connect(mapStateToProps, mapDispatchToProps)(Log);