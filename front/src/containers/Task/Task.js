/**
 * 任务列表
 */
import React from 'react';
// redux相关
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import * as actions from '../../actions/task';
//component
import TaskTableList from '../../components/Task/TaskTableList';

// import ModifyTaskModal from './ModifyTaskModal_r';
import ModifyTaskModal from '../../components/Task/ModifyTaskModal';


class Task extends React.Component {
	state ={
		modalKey: 0,
    modalVisible: false,
    confirmLoading: false,
	}

	handleOpenModal = () => {
		this.setState({
			modalKey:'' + Date.now() + Math.floor(Math.random() * 100),
			modalVisible: true,
		})
	}

	handleCloseModal = () => {
		this.setState({
			modalVisible: false,
		})
	}

  render() {
    const { taskReducer, actions, taskId } = this.props;
    return (
			<div>
				<TaskTableList handleOpenModal={this.handleOpenModal} data={taskReducer.taskList} actions={actions} />
				<ModifyTaskModal key={this.state.modalKey} handleCancel={this.handleCloseModal} visible={this.state.modalVisible} initialValue={taskReducer.modifyTask} taskId={taskId} actions={actions} />
			</div>
		);
  }
}

function mapStateToProps(state) {
	return {
		taskReducer: state.taskReducer,
		taskId: state.taskReducer.modifyTaskId.task_id,
	};
}

function mapDispatchToProps(dispatch) {
	return {
		actions: bindActionCreators(actions, dispatch)
	};
}

export default connect(mapStateToProps, mapDispatchToProps)(Task);
