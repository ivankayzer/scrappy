import React from "react";
import PropTypes from "prop-types";

const EmptyState = ({ onActionClick }) => (
  <main className="min-w-0 border-t border-gray-200 flex flex-col w-full h-full items-center justify-center">
    <h2 className="text-3xl font-extrabold">You have no tasks</h2>
    <button
      onClick={onActionClick}
      type="button"
      className="mt-5 inline-flex items-center px-6 py-3 border border-transparent shadow-sm text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
    >
      <svg
        className="-ml-1 mr-3 w-6 h-6"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          strokeLinecap="round"
          strokeLinejoin="round"
          strokeWidth="2"
          d="M12 6v6m0 0v6m0-6h6m-6 0H6"
        />
      </svg>
      Add your first task
    </button>
  </main>
);

EmptyState.propTypes = {
  onActionClick: PropTypes.func.isRequired,
};

export default EmptyState;
