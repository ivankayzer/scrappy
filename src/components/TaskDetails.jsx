import React from "react";
import PropTypes from "prop-types";
import Event, { eventPropTypes } from "./Event";

const TaskDetails = ({
  name,
  url,
  checkFrequency,
  notificationChannel,
  lastChecked,
  events,
}) => (
  <div className="flex flex-col w-full bg-white">
    <div className="px-10 py-5 overflow-hidden h-full">
      <div className="w-full mb-10">
        <div className="md:flex md:items-center md:justify-between">
          <div className="flex items-start">
            <div className="flex-shrink-0">
              <div className="relative">
                <span
                  className="absolute inset-0 shadow-inner rounded-full"
                  aria-hidden="true"
                />
              </div>
            </div>
            <div className="pt-1.5">
              <h1 className="text-3xl font-extrabold text-gray-900">{name}</h1>
              <p className="text-sm text-gray-400 max-w-lg">
                <a href="#">{url}</a>
              </p>
              <div className="mt-5 flex text-gray-500 text-sm space-x-20">
                <div>
                  <p className="text-xs">checking</p>
                  <strong>{checkFrequency}</strong>
                </div>
                <div>
                  <p className="text-xs">sending notifications to</p>
                  <strong>{notificationChannel}</strong>
                </div>
                <div>
                  <p className="text-xs">last checked</p>
                  <strong>{lastChecked}</strong>
                </div>
              </div>
            </div>
          </div>
          <div className="mt-6 flex flex-col-reverse justify-stretch space-y-4 space-y-reverse sm:flex-row-reverse sm:justify-end sm:space-x-reverse sm:space-y-0 sm:space-x-3 md:mt-0 md:flex-row md:space-x-3">
            <button
              type="button"
              className="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-cyan-500"
            >
              <span className="flex-shrink-0 flex items-center justify-center mr-3">
                <span
                  className="h-1.5 w-1.5 rounded-full bg-green-500"
                  aria-hidden="true"
                />
              </span>
              Active
            </button>
            <button
              type="button"
              className="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-cyan-600 hover:bg-cyan-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-100 focus:ring-cyan-500"
            >
              Edit
            </button>
          </div>
        </div>
      </div>
      <div>
        <div className="flex justify-between flex-col">
          <div>
            <div className="flex items-center mb-10">
              <span className="relative z-0 inline-flex shadow-sm rounded-md">
                <button
                  type="button"
                  className="relative inline-flex items-center px-4 py-2 rounded-l-md border border-cyan-500
                                                bg-cyan-600 text-sm font-medium text-white hover:bg-cyan-600 focus:z-10
                                                focus:outline-none focus:ring-1 focus:ring-cyan-500 focus:border-cyan-500"
                >
                  Events
                </button>
                <button
                  type="button"
                  className="-ml-px relative inline-flex items-center px-4 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50 focus:z-10 focus:outline-none focus:ring-1 focus:ring-cyan-500 focus:border-cyan-500"
                >
                  All activity
                </button>
              </span>
            </div>
            <div className="flow-root">
              <ul
                className="-mb-8 overflow-scroll"
                style={{ height: "calc(100vh - 365px)" }}
              >
                {events.map((event, i) => (
                  <Event
                    name={event.name}
                    subtext={event.subtext}
                    changes={event.changes}
                    color={event.color}
                    timestamp={event.timestamp}
                    key={event.id}
                    isLast={i === events.length - 1}
                  />
                ))}
              </ul>
            </div>
          </div>
          <div className="mt-10 bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div className="flex-1 flex justify-between sm:hidden">
              <a
                href="#"
                className="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500"
              >
                Previous
              </a>
              <a
                href="#"
                className="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:text-gray-500"
              >
                Next
              </a>
            </div>
            <div className="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p className="text-sm text-gray-700">
                  Showing
                  <span className="font-medium">1</span>
                  to
                  <span className="font-medium">5</span>
                  of
                  <span className="font-medium">97</span>
                  results
                </p>
              </div>
              <div>
                <nav
                  className="relative z-0 inline-flex shadow-sm -space-x-px"
                  aria-label="Pagination"
                >
                  <a
                    href="#"
                    className="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                  >
                    <span className="sr-only">Previous</span>
                    <svg
                      className="h-5 w-5"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                    >
                      <path
                        fillRule="evenodd"
                        d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                        clipRule="evenodd"
                      />
                    </svg>
                  </a>
                  <a
                    href="#"
                    className="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                  >
                    1
                  </a>
                  <a
                    href="#"
                    className="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                  >
                    2
                  </a>
                  <a
                    href="#"
                    className="hidden md:inline-flex relative items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                  >
                    3
                  </a>
                  <span className="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700">
                    ...
                  </span>
                  <a
                    href="#"
                    className="hidden md:inline-flex relative items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                  >
                    8
                  </a>
                  <a
                    href="#"
                    className="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                  >
                    9
                  </a>
                  <a
                    href="#"
                    className="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50"
                  >
                    10
                  </a>
                  <a
                    href="#"
                    className="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50"
                  >
                    <span className="sr-only">Next</span>
                    <svg
                      className="h-5 w-5"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                    >
                      <path
                        fillRule="evenodd"
                        d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                        clipRule="evenodd"
                      />
                    </svg>
                  </a>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
);

TaskDetails.propTypes = {
  name: PropTypes.string.isRequired,
  url: PropTypes.string.isRequired,
  checkFrequency: PropTypes.string.isRequired,
  notificationChannel: PropTypes.string.isRequired,
  lastChecked: PropTypes.string.isRequired,
  events: PropTypes.arrayOf(eventPropTypes).isRequired,
};

export default TaskDetails;
