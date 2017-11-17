/**
 * 人员列表
 */
import React, { Component } from 'react';
// redux相关
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import * as actions from '../../actions/organize';
//component
import PersonList from '../../components/Organize/Person/List'

class OrganizePersonList extends Component {

	render() {
		const { organizePerson, actions } = this.props;

		return (
			<PersonList
				listInfo={organizePerson.personList}
				actions={actions}
			/>
		)
	}
}

function mapStateToProps(state) {
	return {
		organizePerson: state.organizePerson,
	};
}

function mapDispatchToProps(dispatch) {
	return {
		actions: bindActionCreators(actions, dispatch)
	};
}

export default connect(mapStateToProps, mapDispatchToProps)(OrganizePersonList);