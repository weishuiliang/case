import React, {Component} from 'react';
import {Layout, Menu, Icon} from 'antd';
const {Sider} = Layout;
const SubMenu = Menu.SubMenu;

class MenuList extends Component {
	constructor(props) {
		super(props);
		this.state = {
			openKey: '',
			selectedKey: '',
		};
		this.handleOnItemClick = this.handleOnItemClick.bind(this);
		this.setMenuOpen = this.setMenuOpen.bind(this);
		this.openMenu = this.openMenu.bind(this);
	}

	componentDidMount() {
		this.setMenuOpen(this.props);
	}
	componentWillReceiveProps(nextProps) {
		console.log(nextProps);
		this.setMenuOpen(nextProps)
	}
	setMenuOpen(props) {
		const {path} = props;
		this.setState({
			openKey: path.substr(0, path.lastIndexOf('/')),
			selectedKey: path
		});
	};

	handleOnItemClick(e) {
		const {router} = this.props;
		this.setState({
			selectedKey: e.key
		});
		router.push(e.key)
	}

	openMenu(v) {
		console.log(v);
		this.setState({
			openKey: v[v.length - 1],
			firstHide: false,
		})
	};

	render() {

		return (
			<Menu
				theme="dark"
				selectedKeys={[this.state.selectedKey]}           //打开二级菜单
				openKeys={[this.state.openKey]}                   //选中的Item
				mode="inline"
				onClick={this.handleOnItemClick}
				onOpenChange={this.openMenu}
			>
				<Menu.Item key="/log">
					<span><i className="iconfont icon-log g-m-r-8" /></span>
					<span className="g-white">日志</span>
				</Menu.Item>
				{/*<SubMenu key="/project" title={<span><Icon type="mail" /><span>项目</span></span>}>*/}
				{/*<Menu.Item key="/project/list">项目列表</Menu.Item>*/}
				{/*<Menu.Item key="/project/add">添加项目</Menu.Item>*/}
				{/*</SubMenu>*/}
				<SubMenu key="/task" title={<span><i className="iconfont icon-task g-m-r-8" />任务</span>}>
					<Menu.Item key="/task/list">任务列表</Menu.Item>
					<Menu.Item key="/task/add">添加任务</Menu.Item>
				</SubMenu>
				<SubMenu key="/organize" title={<span><i className="iconfont icon-organize g-m-r-8" />组织</span>}>
					<Menu.Item key="/organize/group-list">部门列表</Menu.Item>
					<Menu.Item key="/organize/person-list">人员列表</Menu.Item>
					<Menu.Item key="/organize/position-list">职位列表</Menu.Item>
				</SubMenu>
			</Menu>
		);
	}
}

export default MenuList;