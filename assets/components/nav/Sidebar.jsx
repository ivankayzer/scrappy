import React, { useState } from "react";
import { Link } from "react-router-dom";
import PropTypes from "prop-types";
import AccountSettings from "../modals/AccountSettings";
import Notifications from "../modals/Notifications";
import GuestIcons from "./GuestIcons";
import UserIcons from "./UserIcons";
import DarkModeIcon from "../icons/DarkModeIcon";
import UserSettingsIcon from "../icons/UserSettingsIcon";
import LogoutIcon from "../icons/LogoutIcon";

const Sidebar = ({ user }) => {
  const [showSettings, setShowSettings] = useState(false);
  const [showNotifications, setShowNotifications] = useState(false);

  return (
    <nav
      aria-label="Sidebar"
      className="lg:flex-shrink-0 lg:bg-gray-800 lg:overflow-y-auto md:block hidden z-20"
    >
      <div className="inset-y-0 left-0 lg:static lg:flex-shrink-0">
        <Link
          to="/tasks"
          className="flex items-center justify-center h-16 w-16 bg-blue-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-600 lg:w-20"
        >
          <img
            className="h-8 w-auto"
            src="https://tailwindui.com/img/logos/workflow-mark.svg?color=white"
            alt="Workflow"
          />
        </Link>
      </div>

      <div
        className="flex flex-col justify-between"
        style={{ height: "calc(100% - 64px)" }}
      >
        <div className="relative w-20 flex flex-col p-3 space-y-3">
          {!user ? (
            <GuestIcons />
          ) : (
            <UserIcons openNotifications={() => setShowNotifications(true)} />
          )}
        </div>
        <div className="relative w-20 flex flex-col p-3 space-y-3">
          <button
            type="button"
            className="text-gray-400 hover:bg-gray-700 flex-shrink-0 inline-flex items-center justify-center h-14 w-14 rounded-lg"
          >
            <DarkModeIcon />
          </button>
          {user && (
            <>
              <button
                onClick={() => setShowSettings(true)}
                type="button"
                className="text-gray-400 hover:bg-gray-700 flex-shrink-0 inline-flex items-center justify-center h-14 w-14 rounded-lg"
              >
                <UserSettingsIcon />
              </button>
              <button
                type="button"
                className="text-gray-400 hover:bg-gray-700 flex-shrink-0 inline-flex items-center justify-center h-14 w-14 rounded-lg"
              >
                <LogoutIcon />
              </button>
            </>
          )}
        </div>
      </div>

      {showSettings && <AccountSettings close={() => setShowSettings(false)} />}

      {showNotifications && (
        <Notifications close={() => setShowNotifications(false)} />
      )}
    </nav>
  );
};

Sidebar.propTypes = {
  user: PropTypes.shape({
    email: PropTypes.string.isRequired,
  }),
};

Sidebar.defaultProps = {
  user: null,
};

export default Sidebar;
