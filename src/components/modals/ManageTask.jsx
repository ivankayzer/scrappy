/* eslint-disable jsx-a11y/label-has-associated-control */
import React from "react";
import PropTypes from "prop-types";
import Modal from "../Modal";

const ManageTask = ({ isOpen, close }) => (
  <Modal
    wide
    subTitle="Get started by filling in the information below to create your new task."
    isOpen={isOpen}
    close={close}
    title="Create a new task"
  >
    <div className="px-4 py-6 sm:px-6 sm:divide-y sm:divide-gray-200">
      <div className="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
        <div className="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-gray-200 sm:pt-5">
          <label
            htmlFor="name"
            className="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
          >
            Name
          </label>
          <div className="mt-1 sm:mt-0 sm:col-span-2">
            <div className="w-full flex rounded-md shadow-sm">
              <input
                type="text"
                name="name"
                id="name"
                placeholder="Playstation 5"
                className="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-md sm:text-sm border-gray-300"
              />
            </div>
          </div>
        </div>
        <div className="sm:grid sm:border-t sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-gray-200 sm:pt-5">
          <label
            htmlFor="url"
            className="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
          >
            URL
          </label>
          <div className="mt-1 sm:mt-0 sm:col-span-2">
            <div className="w-full flex rounded-md shadow-sm">
              <input
                type="text"
                name="url"
                id="url"
                placeholder="https://www.playstation.com/en-us/ps5/"
                className="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-md sm:text-sm border-gray-300"
              />
            </div>
          </div>
        </div>
        <div className="sm:grid sm:border-t sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-gray-200 sm:pt-5">
          <label
            htmlFor="status"
            className="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
          >
            Status
          </label>
          <div className="mt-1 sm:mt-0 sm:col-span-2 flex justify-center">
            <div className="w-full">
              <div className="mt-1 relative">
                <button
                  type="button"
                  aria-haspopup="listbox"
                  aria-expanded="true"
                  aria-labelledby="listbox-label"
                  className="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                  <span className="flex truncate items-center">
                    <span
                      className="bg-green-400 flex-shrink-0 inline-block h-2 w-2 rounded-full"
                      aria-hidden="true"
                    />
                    <span className="ml-3 font-normal block">Active</span>
                  </span>
                  <span className="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg
                      className="h-5 w-5 text-gray-400"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                    >
                      <path
                        fillRule="evenodd"
                        d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clipRule="evenodd"
                      />
                    </svg>
                  </span>
                </button>

                <transition
                  enter-active-className="undefined"
                  enter-className="undefined"
                  enter-to-className="undefined"
                  leave-active-className="transition ease-in duration-100"
                  leave-className="opacity-100"
                  leave-to-className="opacity-0"
                >
                  <div className="absolute mt-1 w-full rounded-md bg-white shadow-lg">
                    <ul
                      tabIndex="-1"
                      role="listbox"
                      aria-labelledby="listbox-label"
                      aria-activedescendant="listbox-item-3"
                      className="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                    >
                      <li
                        id="listbox-option-0"
                        className="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9"
                      >
                        <span className="flex truncate items-center">
                          <span
                            className="bg-gray-200 flex-shrink-0 inline-block h-2 w-2 rounded-full"
                            aria-hidden="true"
                          />
                          <span className="ml-3 font-normal block">
                            Inactive
                          </span>
                        </span>
                      </li>
                    </ul>
                  </div>
                </transition>
              </div>
            </div>
          </div>
        </div>
        <div className="sm:grid sm:border-t sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-gray-200 sm:pt-5">
          <label
            htmlFor="url"
            className="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
          >
            Notification channel
          </label>
          <div className="mt-1 sm:mt-0 sm:col-span-2 flex justify-center">
            <div className="w-full">
              <div className="mt-1 relative">
                <button
                  type="button"
                  disabled
                  aria-haspopup="listbox"
                  aria-expanded="true"
                  aria-labelledby="listbox-label"
                  className="bg-gray-50 relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                >
                  <span className="flex truncate items-center">
                    <span className="font-normal block">Telegram</span>
                  </span>
                  <span className="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                    <svg
                      className="h-5 w-5 text-gray-400"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                    >
                      <path
                        fillRule="evenodd"
                        d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z"
                        clipRule="evenodd"
                      />
                    </svg>
                  </span>
                </button>

                <transition
                  enter-active-className="undefined"
                  enter-className="undefined"
                  enter-to-className="undefined"
                  leave-active-className="transition ease-in duration-100"
                  leave-className="opacity-100"
                  leave-to-className="opacity-0"
                >
                  <div className="absolute mt-1 w-full rounded-md bg-white shadow-lg">
                    <ul
                      tabIndex="-1"
                      role="listbox"
                      aria-labelledby="listbox-label"
                      aria-activedescendant="listbox-item-3"
                      className="max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
                    >
                      <li
                        id="listbox-option-0"
                        className="text-gray-900 cursor-default select-none relative py-2 pl-3 pr-9"
                      >
                        <span className="flex truncate items-center">
                          <span
                            className="bg-gray-200 flex-shrink-0 inline-block h-2 w-2 rounded-full"
                            aria-hidden="true"
                          />
                          <span className="ml-3 font-normal block">
                            Inactive
                          </span>
                        </span>
                      </li>
                    </ul>
                  </div>
                </transition>
              </div>
            </div>
          </div>
        </div>
        <div className="sm:grid sm:border-t sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-gray-200 sm:pt-5">
          <label
            htmlFor="check_frequency"
            className="text-sm font-medium text-gray-700 sm:mt-px flex flex-col"
          >
            Check frequency
            <span className="text-xs text-gray-400">in minutes</span>
          </label>
          <div className="mt-1 sm:mt-0 sm:col-span-2">
            <div className="w-full flex rounded-md shadow-sm">
              <input
                type="number"
                name="check_frequency"
                id="check_frequency"
                placeholder="5"
                className="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-md sm:text-sm border-gray-300"
              />
            </div>
          </div>
        </div>
        <div className="sm:grid sm:border-t sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-gray-200 sm:pt-5">
          <label
            htmlFor="hours_of_activity"
            className="text-sm font-medium text-gray-700 sm:mt-px flex flex-col sm:pt-2"
          >
            Hours of activity
          </label>
          <div className="mt-1 sm:mt-0 sm:col-span-2">
            <div className="w-full flex rounded-md shadow-sm">
              <input
                type="text"
                name="hours_of_activity"
                id="hours_of_activity"
                placeholder="9-17 or 13,14,17"
                className="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-md sm:text-sm border-gray-300"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  </Modal>
);

ManageTask.propTypes = {
  isOpen: PropTypes.bool.isRequired,
  close: PropTypes.func.isRequired,
};

export default ManageTask;
