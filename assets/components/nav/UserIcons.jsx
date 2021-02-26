import React from "react";
import { Link } from "react-router-dom";
import PropTypes from "prop-types";
import NotificationsIcon from "../icons/NotificationsIcon";
import TasksIcon from "../icons/TasksIcon";

const UserIcons = ({ openNotifications }) => (
  <>
    <button
      type="button"
      onClick={openNotifications}
      className="text-gray-400 hover:bg-gray-700 flex-shrink-0 inline-flex items-center justify-center h-14 w-14 rounded-lg"
    >
      <NotificationsIcon />
    </button>

    <Link
      to="/tasks"
      className="bg-gray-900 text-white flex-shrink-0 inline-flex items-center justify-center h-14 w-14 rounded-lg"
    >
      <TasksIcon />
    </Link>
  </>
);

UserIcons.propTypes = {
  openNotifications: PropTypes.func.isRequired,
};

export default UserIcons;
