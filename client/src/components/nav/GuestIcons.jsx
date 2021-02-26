import React from "react";
import { Link } from "react-router-dom";
import LoginIcon from "../icons/LoginIcon";

const GuestIcons = () => (
  <Link
    to="/login"
    className="bg-gray-900 text-white flex-shrink-0 inline-flex items-center justify-center h-14 w-14 rounded-lg"
  >
    <LoginIcon />
  </Link>
);

export default GuestIcons;
