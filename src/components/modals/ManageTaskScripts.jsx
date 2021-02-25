/* eslint-disable jsx-a11y/label-has-associated-control */
import React from "react";
import PropTypes from "prop-types";
import Modal from "../Modal";

const ManageTaskScripts = ({ isOpen, close }) => (
  <Modal
    wide
    subTitle="Write scripts to execute on a page to get necessary data"
    isOpen={isOpen}
    close={close}
    title="Add scripts to a task"
    footerMeta={
      <nav className="flex items-center justify-center" aria-label="Progress">
        <p className="text-sm font-medium">Step 2 of 2</p>
        <ol className="ml-8 flex items-center space-x-5">
          <li>
            <a
              href="#"
              className="relative flex items-center justify-center"
              aria-current="step"
            >
              <span
                className="relative block w-2.5 h-2.5 bg-indigo-600 rounded-full"
                aria-hidden="true"
              />
              <span className="sr-only">Step 1</span>
            </a>
          </li>

          <li>
            <a
              href="#"
              className="relative flex items-center justify-center"
              aria-current="step"
            >
              <span className="absolute w-5 h-5 p-px flex" aria-hidden="true">
                <span className="w-full h-full rounded-full bg-indigo-200" />
              </span>
              <span
                className="relative block w-2.5 h-2.5 bg-indigo-600 rounded-full"
                aria-hidden="true"
              />
              <span className="sr-only">Step 2</span>
            </a>
          </li>
        </ol>
      </nav>
    }
    submit={
      <button
        type="submit"
        className="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Save
      </button>
    }
  >
    <div
      className="flex flex-col justify-between"
      style={{ height: "calc(100% - 90px)" }}
    >
      <div>
        <div className="border-b pb-10">
          <div className="flex w-full items-center rounded rounded-b-none">
            <div className="sm:items-start sm:border-gray-200 w-full">
              <button
                type="button"
                aria-haspopup="listbox"
                aria-expanded="true"
                aria-labelledby="listbox-label"
                className="bg-white relative w-full border border-gray-300 rounded-md shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
              >
                <span className="flex truncate items-center">
                  <span className="font-normal block">Evaluate</span>
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
            </div>

            <span className="inline-flex rounded-md">
              <button
                type="button"
                className="inline-flex items-center p-1.5 ml-3 border border-red-700 text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:text-gray-50 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue active:text-gray-50 active:bg-red-800 transition ease-in-out duration-150"
              >
                <svg
                  className="w-5 h-5"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                  />
                </svg>
              </button>
            </span>
          </div>
          <div className="pt-3">
            <div>
              <div className="rounded-md bg-blue-50 p-4">
                <div className="flex">
                  <div className="flex-shrink-0">
                    <svg
                      className="h-5 w-5 text-blue-400"
                      fill="currentColor"
                      viewBox="0 0 20 20"
                    >
                      <path
                        fillRule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clipRule="evenodd"
                      />
                    </svg>
                  </div>
                  <div className="ml-3 flex-1 md:flex md:justify-between">
                    <p className="text-sm leading-5 text-blue-700">
                      Extract information from the page using JavaScript
                    </p>
                  </div>
                </div>
              </div>
              <div className="flex md:gap-6 mt-6">
                <div className="flex flex-col w-1/3">
                  <label
                    htmlFor="url"
                    className="block text-sm font-medium text-gray-700 sm:mt-px"
                  >
                    Label
                  </label>
                  <div className="sm:col-span-2 mt-2">
                    <div className="w-full flex rounded-md shadow-sm">
                      <input
                        type="text"
                        name="url"
                        id="url"
                        placeholder="Price"
                        className="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-md sm:text-sm border-gray-300"
                      />
                    </div>
                  </div>
                </div>
                <div className="w-full">
                  <div className="path-field">
                    <label
                      htmlFor="variable"
                      className="block text-sm leading-5 font-medium text-gray-700"
                    >
                      JavaScript code (jQuery is supported)
                    </label>
                    <div className="rounded-md shadow-sm">
                      <textarea
                        rows="3"
                        className="flex-1 mt-2 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-md sm:text-sm border-gray-300 px-3 py-2 resize-none"
                        placeholder="$('#listing > .offer > img').text()"
                      />
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <span className="inline-flex rounded-md mt-6 w-full flex justify-center">
          <button
            type="button"
            id="add-field"
            className="inline-flex shadow-sm items-center px-4 py-2 border border-gray-300 text-sm leading-5 font-medium
                        rounded-md text-gray-700 bg-white hover:text-gray-500 focus:outline-none
                        focus:border-blue-300 focus:shadow-outline-blue active:text-gray-800 active:bg-gray-50
                        transition ease-in-out duration-150"
          >
            Add new field
          </button>
        </span>
      </div>
    </div>
  </Modal>
);

ManageTaskScripts.propTypes = {
  isOpen: PropTypes.bool.isRequired,
  close: PropTypes.func.isRequired,
};

export default ManageTaskScripts;
