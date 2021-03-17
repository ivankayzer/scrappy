import React, { useState } from "react";
import PropTypes from "prop-types";
import Task, { taskPropTypes } from "./Task";
import Select from "./Select";

const TasksList = ({
  tasks,
  selectedId,
  setSelected,
  openManageModal,
  openManageScriptsModal,
}) => {
  const [search, setSearch] = useState("");

  return (
    <aside className="hidden xl:block xl:flex-shrink-0 xl:order-first w-2/6">
      <div className="h-full relative flex flex-col w-full border-r border-gray-200 bg-gray-100">
        <div className="flex-shrink-0">
          <div className="px-6 pt-6 pb-4 bg-white border-b">
            <div className="flex justify-between">
              <div>
                <div className="flex items-center space-x-3">
                  <h2 className="text-xl font-medium text-gray-900">Tasks</h2>
                </div>
                <p className="mt-1 text-sm text-gray-600">
                  Search list of {tasks.length} tasks
                </p>
              </div>

              <div>
                <button type="button" onClick={openManageModal}>
                  Add a task
                </button>
                <button type="button" onClick={openManageScriptsModal}>
                  Add task scripts
                </button>
              </div>
            </div>
            <form className="mt-6 flex space-x-4" action="#">
              <div className="flex items-center justify-between w-full min-w-0">
                <div className="relative rounded-md shadow-sm w-full">
                  <div className="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg
                      className="h-5 w-5 text-gray-400"
                      xmlns="http://www.w3.org/2000/svg"
                      viewBox="0 0 20 20"
                      fill="currentColor"
                      aria-hidden="true"
                    >
                      <path
                        fillRule="evenodd"
                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                        clipRule="evenodd"
                      />
                    </svg>
                  </div>
                  <input
                    type="search"
                    name="search"
                    id="search"
                    className="focus:ring-blue-500 focus:border-blue-400 block w-full pl-10 sm:text-sm border-gray-300 rounded-md"
                    placeholder="Search"
                    value={search}
                    onChange={(e) => setSearch(e.target.value)}
                  />
                </div>
                <div className="ml-3 w-60">
                  <Select
                    options={[
                      {
                        value: "all",
                        label: "All",
                        icon: (
                          <>
                            <span
                              className="bg-green-400 flex-shrink-0 inline-block h-2 w-2 rounded-full"
                              aria-hidden="true"
                            />
                            <span className="bg-yellow-400 flex-shrink-0 inline-block -ml-1 h-2 w-2 rounded-full" />
                            <span className="bg-gray-200 flex-shrink-0 inline-block -ml-1 h-2 w-2 rounded-full" />
                          </>
                        ),
                      },
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
                        value: "needs_active",
                        label: "Needs attention",
                        icon: (
                          <span className="bg-yellow-300 flex-shrink-0 inline-block h-2 w-2 rounded-full" />
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
            </form>
          </div>
        </div>
        <nav
          aria-label="Message list"
          className="min-h-0 flex-1 overflow-y-auto"
        >
          <ul className="border-b border-gray-200 divide-y divide-gray-200">
            {tasks
              .filter(
                (task) =>
                  !search ||
                  task.name.toLowerCase().includes(search.toLowerCase()) ||
                  task.url.toLowerCase().includes(search.toLowerCase())
              )
              .map((task) => (
                <Task
                  key={task.id}
                  onClick={() => setSelected(task)}
                  isActive={task.isActive}
                  needsAttention={task.needsAttention}
                  isSelected={task.id === selectedId}
                  name={task.name}
                  checkFrequency={task.checkFrequency}
                  lastChecked={task.lastChecked}
                  notificationChannel={task.notificationChannel}
                  url={task.url}
                />
              ))}
          </ul>
        </nav>
      </div>
    </aside>
  );
};

TasksList.propTypes = {
  tasks: PropTypes.arrayOf(PropTypes.shape(taskPropTypes)).isRequired,
  selectedId: PropTypes.number,
  setSelected: PropTypes.func.isRequired,
  openManageModal: PropTypes.func.isRequired,
  openManageScriptsModal: PropTypes.func.isRequired,
};

TasksList.defaultProps = {
  selectedId: null,
};

export default TasksList;
