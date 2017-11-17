import React from 'react';
import { DatePicker, Button } from 'antd';

const DateFilterDropdown = ({
  startValue,
  endValue,
  onStartChange,
  onEndChange,
  disabledStartDate,
  disabledEndDate,
  onConfirm,
} = {}) => (
  <div className="task-filter-dropdown">
    <DatePicker
      className="dateInput"
      placeholder="开始时间"
      value={startValue}
      onChange={onStartChange}
      disabledDate={disabledStartDate}
    />
    <br />
    <DatePicker
      className="dateInput"
      placeholder="结束时间"
      value={endValue}
      onChange={onEndChange}
      disabledDate={disabledEndDate}
    />
    <br />
    <Button type="primary" onClick={onConfirm} >确认</Button>
  </div>
);

export default DateFilterDropdown;