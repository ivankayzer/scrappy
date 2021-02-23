import React from "react";
import PropTypes from "prop-types";

const Task = ({
  name,
  url,
  lastChecked,
  checkFrequency,
  notificationChannel,
}) => (
  <li
    style={{ minHeight: 121 }}
    className="bg-white py-5 px-6 cursor-pointer hover:bg-gray-50 focus-within:ring-2 focus-within:ring-inset relative focus-within:ring-cyan-600 @if($loop->first) bg-gray-100 @endif"
  >
    <div
      className="border-l-8 border-{{ $task['isActive'] ? $task['needsAttention'] ? 'yellow-300' : 'green-400' : 'gray-200' }} w-8 absolute left-0"
      style={{ height: "calc(100% + 1px)", top: -1 }}
    />
    <div className="flex justify-between space-x-3">
      <div className="min-w-0 flex-1">
        <a href="#" className="block focus:outline-none">
          <p className="text-sm font-medium text-gray-900">{name}</p>
        </a>
        <div className="text-sm overflow-hidden truncate text-gray-500 hover:border-b">
          {url}
        </div>
      </div>
      <time
        dateTime="2021-01-27T16:35"
        className="flex-shrink-0 whitespace-nowrap text-sm text-gray-500"
      >
        {lastChecked}
      </time>
    </div>
    <div className="mt-5 flex text-gray-500 text-sm space-x-2">
      <p>{checkFrequency}</p>
      <span aria-hidden="true">·</span>
      <p>{notificationChannel}</p>
    </div>
  </li>
);

export const taskPropTypes = {
  name: PropTypes.string.isRequired,
  url: PropTypes.string.isRequired,
  lastChecked: PropTypes.string.isRequired,
  checkFrequency: PropTypes.string.isRequired,
  notificationChannel: PropTypes.string.isRequired,
}

Task.propTypes = taskPropTypes;

export default Task;
