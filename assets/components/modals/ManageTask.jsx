/* eslint-disable jsx-a11y/label-has-associated-control */
import React, { useState } from "react";
import PropTypes from "prop-types";
import Modal from "../Modal";
import Select from "../Select";
import Input from "../Input";
import axios from "../../plugins/axios";

const statusOptions = [
  {
    value: 1,
    label: "Active",
    icon: (
      <span
        className="bg-green-400 flex-shrink-0 inline-block h-2 w-2 rounded-full"
        aria-hidden="true"
      />
    ),
  },
  {
    value: -1,
    label: "Inactive",
    icon: (
      <span
        className="bg-gray-200 flex-shrink-0 inline-block h-2 w-2 rounded-full"
        aria-hidden="true"
      />
    ),
  },
];

const notificationChannelOptions = [
  {
    value: "telegram",
    label: "Telegram",
  },
];

const ManageTask = ({ close, updateAndNext, addAndNext, task }) => {
  const [id, setId] = useState(task.id || null);
  const [name, setName] = useState(task.name || "");
  const [url, setUrl] = useState(task.url || "");
  const [status, setStatus] = useState(
    task.rawStatus
      ? statusOptions.find((so) => so.value === task.rawStatus)
      : statusOptions[0]
  );
  const [notificationChannel, setNotificationChannel] = useState(
    task.notificationChannel
      ? notificationChannelOptions.find(
          (nco) => nco.value === task.notificationChannel
        )
      : notificationChannelOptions[0]
  );

  const [checkFrequency, setCheckFrequency] = useState(
    task.checkFrequencyInSeconds || "300"
  );
  const [hoursOfActivity, setHoursOfActivity] = useState(
    task.hoursOfActivity || ""
  );

  const submit = () => {
    const taskData = {
      name,
      url,
      status: status.value,
      notificationChannel: notificationChannel.value,
      checkFrequency,
      hoursOfActivity,
    };

    if (id) {
      axios
        .patch(`/tasks/${id}`, taskData)
        .then((response) => updateAndNext(response.data.task))
        .catch((error) => console.error(error));
    } else {
      axios
        .put("/tasks", taskData)
        .then((response) => addAndNext(response.data.task))
        .catch((error) => console.error(error));
    }
  };

  return (
    <Modal
      wide
      subTitle="Get started by filling in the information below to create your new task"
      close={close}
      title={id ? "Update a task" : "Create a new task"}
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
          onClick={submit}
          type="button"
          className="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
        >
          Next
        </button>
      }
    >
      <div className="px-4 py-6 sm:px-6 sm:divide-y sm:divide-gray-200">
        <div className="space-y-6 sm:space-y-5">
          <div className="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-gray-200 sm:pt-5">
            <Input
              onValueChange={setName}
              value={name}
              name="name"
              label="Name"
              placeholder="Playstation 5"
            />
          </div>
          <div className="sm:grid sm:border-t sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-gray-200 sm:pt-5">
            <Input
              value={url}
              onValueChange={setUrl}
              name="url"
              id="url"
              label="URL"
              placeholder="https://www.playstation.com/en-us/ps5/"
            />
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
                  options={statusOptions}
                  value={status}
                  onChange={setStatus}
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
                  options={notificationChannelOptions}
                  value={notificationChannel}
                  onChange={setNotificationChannel}
                />
              </div>
            </div>
          </div>
          <div className="sm:grid sm:border-t sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-gray-200 sm:pt-5">
            <Input
              label="Check frequency"
              subLabel="in seconds"
              type="number"
              name="check_frequency"
              placeholder="300"
              value={checkFrequency}
              onValueChange={setCheckFrequency}
            />
          </div>
          <div className="sm:grid sm:border-t sm:grid-cols-3 sm:gap-4 sm:items-start sm:border-gray-200 sm:pt-5">
            <Input
              name="hours_of_activity"
              label="Hours of activity"
              placeholder="9-17 or 13,14,17"
              value={hoursOfActivity}
              onValueChange={setHoursOfActivity}
            />
          </div>
        </div>
      </div>
    </Modal>
  );
};

ManageTask.propTypes = {
  close: PropTypes.func.isRequired,
  addAndNext: PropTypes.func.isRequired,
  updateAndNext: PropTypes.func.isRequired,
  // eslint-disable-next-line react/forbid-prop-types
  task: PropTypes.object.isRequired,
};

export default ManageTask;
