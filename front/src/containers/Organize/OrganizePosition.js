/**
 * 职位列表
 */
import React, { Component } from 'react';
// redux相关
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import * as actions from '../../actions/organize';
//component
import PositionList from '../../components/Organize/Position/List';

class OrganizeGroup extends Component {

	render() {
		const { organizePosition, actions } = this.props;

		return (
			<div>
				<PositionList
					listInfo={organizePosition.positionList}
					actions={actions}
				/>
			</div>
		)
	}
}

function mapStateToProps(state) {
	return {
		organizePosition: state.organizePosition,
	};
}

function mapDispatchToProps(dispatch) {
	return {
		actions: bindActionCreators(actions, dispatch)
	};
}

export default connect(mapStateToProps, mapDispatchToProps)(OrganizeGroup);