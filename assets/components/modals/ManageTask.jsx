/* eslint-disable jsx-a11y/label-has-associated-control */
import React, { useState } from "react";
import PropTypes from "prop-types";
import { Transition } from "@headlessui/react";
import Modal from "../Modal";
import Select from "../Select";
import Input from "../Input";

const ManageTask = ({ close }) => {
  const [name, setName] = useState("");
  const [url, setUrl] = useState("");
  const [status, setStatus] = useState("active");
  const [notificationChannel, setNotificationChannel] = useState("telegram");
  const [checkFrequency, setCheckFrequency] = useState(5);
  const [hoursOfActivity, setHoursOfActivity] = useState(null);

  return (
    <Modal
      wide
      subTitle="Get started by filling in the information below to create your new task"
      close={close}
      title="Create a new task"
      footerMeta={
        <nav className="flex items-center justify-center" aria-label="Progress">
          <p className="text-sm font-medium">Step 1 of 2</p>
          <ol className="ml-8 flex items-center space-x-5">
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
                <span className="sr-only">Step 1</span>
              </a>
            </li>

            <li>
              <a
                href="#"
                className="block w-2.5 h-2.5 bg-gray-200 rounded-full hover:bg-gray-400"
              >
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
          Next
        </button>
      }
    >
      <div className="px-4 py-6 sm:px-6 sm:divide-y sm:divide-gray-200">
        <div className="space-y-6 sm:space-y-5">
          <div className="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-gray-200 sm:pt-5">
            <Input onValueChange={setName} value={name} name="name" label="Name" placeholder="Playstation 5" />
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
                <Select
                  options={[
                    {
                      value: "active",
                      label: "Active",
                      icon: (
                        <span
                          className="bg-green-400 flex-shrink-0 inline-block h-2 w-2 rounded-full"
                          aria-hidden="true"
                        />
                      ),
                    },
                    {
                      value: "inactive",
                      label: "Inactive",
                      icon: (
                        <span
                          className="bg-gray-200 flex-shrink-0 inline-block h-2 w-2 rounded-full"
                          aria-hidden="true"
                        />
                      ),
                    },
                  ]}
                />
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
                <Select
                  options={[
                    {
                      value: "telegram",
                      label: "Telegram",
                    },
                  ]}
                />
              </div>
            </div>
          </div>
          <div className="sm:grid sm:border-t sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-gray-200 sm:pt-5">
            <label
              htmlFor="check_frequency"
              className="text-sm font-medium text-gray-700 sm:mt-px flex flex-col"
            >
              Check frequency
              <span className="text-xs text-gray-400">in seconds</span>
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
};

ManageTask.propTypes = {
  close: PropTypes.func.isRequired,
};

export default ManageTask;
