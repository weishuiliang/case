import React, {Component} from 'react';
import { bindActionCreators } from 'redux';
import { connect } from 'react-redux';
import * as actions from '../../actions/login';

import {Layout, Menu, Icon} from 'antd';
const {Content, Footer, Sider} = Layout;
const SubMenu = Menu.SubMenu;
import Header from '../../components/Layout/HeaderContent';
import Breadcrumb from '../../components/Layout/Breadcrumb';
import MenuList from '../../components/Layout/MenuList';
import './Styles.scss';

class PageFrame extends Component {
	constructor(props) {
		super(props);
	}

	render() {
		const {router, location, actions} = this.props;
		const {pathname} = location;

		return (
			<Layout style={{minHeight: '100vh'}}>
				<Sider
					trigger={null}
					collapsible
				>
					<div className="logo"/>

					<MenuList
						router={router}
						path={pathname}
					/>
				</Sider>
				<Layout>
					<Header
						actions={actions}
					/>

					<Content style={{margin: '0 16px'}}>

						<Breadcrumb breadcrumb={[]}/>

						<div style={{padding: 24, background: '#fff', minHeight: 360}}>
							{this.props.children}
						</div>

					</Content>

					<Footer style={{textAlign: 'center'}}>
						项目管理系统 ©2017 Created by 微一案技术部
					</Footer>
				</Layout>
			</Layout>
		);
	}
}

const mapStateToProps = (state, ownProps) => ({

});
const mapDispatchToProps = (dispatch, ownProps) => ({
	actions: bindActionCreators(actions, dispatch)
});


export default connect(
	mapStateToProps,
	mapDispatchToProps
)(PageFrame);
