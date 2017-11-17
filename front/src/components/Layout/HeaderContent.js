import React, { Component } from 'react';
import { Layout, Icon, Avatar, Popover } from 'antd';
import { getCookie } from '../../utils/utils';
import UserSettingPop from './UserSettingPop';

const { Header } = Layout;

class HeaderContent extends Component {
    render() {
        const { collapsed, actions } = this.props;

        return (
            <Header style={{ background: '#fff', padding: '0 20px', display: 'flex', justifyContent: 'flex-end', alignItems: 'center' }}>

				<div className="g-flex-cc" style={{cursor: 'pointer', marginRight: '20px'}}>
					<Popover placement="bottom" title={null} content={<UserSettingPop actions={actions} />} trigger="click">
						<Avatar
							style={{verticalAlign: 'middle', marginRight: '10px'}}
							src="https://zos.alipayobjects.com/rmsportal/ODTLcjxAfvqbxHnVXCYX.png"
						/>
						{getCookie('name')}
					</Popover>
				</div>
            </Header>
        )
    }
}

export default HeaderContent;