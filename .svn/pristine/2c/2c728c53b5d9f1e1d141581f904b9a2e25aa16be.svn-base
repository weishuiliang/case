import React, { PureComponent } from 'react';
import { connect } from 'dva';
import {
  Form, Input, DatePicker, Select, Button, Card, InputNumber, Radio, Icon, Tooltip,
} from 'antd';
import PageHeaderLayout from '../../layouts/PageHeaderLayout';
import styles from './style.less';

const FormItem = Form.Item;
const { Option } = Select;
const { RangePicker } = DatePicker;
const { TextArea } = Input;

@connect(state => ({
  submitting: state.form.regularFormSubmitting,
}))
@Form.create()
export default class TaskForms extends PureComponent {
  handleSubmit = (e) => {
    e.preventDefault();
    this.props.form.validateFieldsAndScroll((err, values) => {
      if (!err) {
        this.props.dispatch({
          type: 'form/submitRegularForm',
          payload: values,
        });
      }
    });
  }
  render() {
    const { submitting } = this.props;
    const { getFieldDecorator, getFieldValue } = this.props.form;

    const formItemLayout = {
      labelCol: {
        xs: { span: 24 },
        sm: { span: 7 },
      },
      wrapperCol: {
        xs: { span: 24 },
        sm: { span: 12 },
        md: { span: 10 },
      },
    };

    const submitFormLayout = {
      wrapperCol: {
        xs: { span: 24, offset: 0 },
        sm: { span: 10, offset: 7 },
      },
    };

    return (
      <PageHeaderLayout title="添加任务" content="请按照实际情况添加项目任务相关的信息。">
        <Card bordered={false}>
          <Form
            onSubmit={this.handleSubmit}
            hideRequiredMark
            style={{ marginTop: 8 }}
          >
            <FormItem
              {...formItemLayout}
              label="标题"
            >
              {getFieldDecorator('title', {
                rules: [{
                  required: true, message: '请输入标题',
                }],
              })(
                <Input placeholder="给任务起个名字" />
              )}
            </FormItem>
            <FormItem
              {...formItemLayout}
              label="预计前端工作时间"
            >
              {getFieldDecorator('frontEndDate', {
                rules: [{
                  required: true, message: '请选择起止日期',
                }],
              })(
                <RangePicker style={{ width: '100%' }} placeholder={['开始日期', '结束日期']} />
              )}
            </FormItem>
            <FormItem
              {...formItemLayout}
              label="前端负责人"
            >
              {getFieldDecorator('fontEndStaff', {
                rules: [{
                  required: true, message: '请输入前端负责人',
                }],
              })(
                <Input placeholder="请输入前端负责人姓名" />
              )}
            </FormItem>
            <FormItem
              {...formItemLayout}
              label="预计后端工作时间"
            >
              {getFieldDecorator('backEndDate', {
                rules: [{
                  required: true, message: '请选择起止日期',
                }],
              })(
                <RangePicker style={{ width: '100%' }} placeholder={['开始日期', '结束日期']} />
              )}
            </FormItem>
            <FormItem
              {...formItemLayout}
              label="后端负责人"
            >
              {getFieldDecorator('backEndStaff', {
                rules: [{
                  required: true, message: '请输入后端负责人',
                }],
              })(
                <Input placeholder="请输入后端负责人姓名" />
              )}
            </FormItem>
            {/* <FormItem
              {...formItemLayout}
              label="目标描述"
            >
              {getFieldDecorator('goal', {
                rules: [{
                  required: true, message: '请输入目标描述',
                }],
              })(
                <TextArea style={{ minHeight: 32 }} placeholder="请输入你的阶段性工作目标" rows={4} />
              )}
            </FormItem>
            <FormItem
              {...formItemLayout}
              label="衡量标准"
            >
              {getFieldDecorator('standard', {
                rules: [{
                  required: true, message: '请输入衡量标准',
                }],
              })(
                <TextArea style={{ minHeight: 32 }} placeholder="请输入衡量标准" rows={4} />
              )}
            </FormItem>
            <FormItem
              {...formItemLayout}
              label={
                <span>
                  客户
                  <em className={styles.optional}>
                    （选填）
                    <Tooltip title="目标的服务对象">
                      <Icon type="info-circle-o" style={{ marginRight: 4 }} />
                    </Tooltip>
                  </em>
                </span>
              }
            >
              {getFieldDecorator('client')(
                <Input placeholder="请描述你服务的客户，内部客户直接 @姓名／工号" />
              )}
            </FormItem>
            <FormItem
              {...formItemLayout}
              label={<span>邀评人<em className={styles.optional}>（选填）</em></span>}
            >
              {getFieldDecorator('invites')(
                <Input placeholder="请直接 @姓名／工号，最多可邀请 5 人" />
              )}
            </FormItem>
            <FormItem
              {...formItemLayout}
              label={<span>权重<em className={styles.optional}>（选填）</em></span>}
            >
              {getFieldDecorator('weight')(
                <InputNumber placeholder="请输入" min={0} max={100} />
              )}
              <span>%</span>
            </FormItem> */}
            <FormItem
              {...formItemLayout}
              label="任务难度"
              help="任务的难易程度，默认为 “一般” 难度"
            >
              {getFieldDecorator('level', {
                initialValue: '2',
                rules: [{
                  required: true, message: '请选择任务难度',
                }],
              })(
                <Radio.Group defaultValue="2">
                  <Radio value="1">简单</Radio>
                  <Radio value="2">一般</Radio>
                  <Radio value="3">困难</Radio>
                </Radio.Group>
              )}
            </FormItem>
            <FormItem {...submitFormLayout} style={{ marginTop: 32 }}>
              <Button type="primary" htmlType="submit" loading={submitting}>
                提交
              </Button>
              <Button style={{ marginLeft: 8 }}>保存</Button>
            </FormItem>
          </Form>
        </Card>
      </PageHeaderLayout>
    );
  }
}
