/**
 * 部门列表
 */
import React, { Component } from 'react';
// redux相关
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import * as actions from '../../actions/organize';
//component
import GroupList from '../../components/Organize/Group/List';

class OrganizeGroup extends Component {

	render() {
		const { organizeGroup, actions } = this.props;

		return (
			<GroupList
				listInfo={organizeGroup.groupList}
				actions={actions}
			/>
		)
	}
}

function mapStateToProps(state) {
	return {
		organizeGroup: state.organizeGroup,
	};
}

function mapDispatchToProps(dispatch) {
	return {
		actions: bindActionCreators(actions, dispatch)
	};
}

export default connect(mapStateToProps, mapDispatchToProps)(OrganizeGroup);
