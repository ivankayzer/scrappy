/* eslint-disable jsx-a11y/label-has-associated-control */
import React, { useState } from "react";
import PropTypes from "prop-types";
import Modal from "../Modal";
import Select from "../Select";
import Execute from "../scriptTypes/Execute";
import Snapshot from "../scriptTypes/Snapshot";
import axios from "../../plugins/axios";
import Trash from "../icons/Trash";

export const scriptOptions = [
  {
    value: "execute",
    label: "Execute",
  },
  {
    value: "snapshot",
    label: "Snapshot",
  },
];

export const defaultScript = {
  type: scriptOptions[0],
  label: "",
  code: "",
};

const scriptTypes = {
  execute: Execute,
  snapshot: Snapshot,
};

const ManageTaskScripts = ({ close, existingScripts, taskId }) => {
  const [scripts, setScripts] = useState(existingScripts);

  const updateType = (i, type) => {
    setScripts(scripts.map((s, index) => (index === i ? { ...s, type } : s)));
  };

  const updateLabel = (i, label) => {
    setScripts(scripts.map((s, index) => (index === i ? { ...s, label } : s)));
  };

  const updateCode = (i, code) => {
    setScripts(scripts.map((s, index) => (index === i ? { ...s, code } : s)));
  };

  const submit = () => {
    axios
      .patch(`/tasks/${taskId}/scripts`, {
        scripts: scripts.map((script, i) => ({
          id: script.id || null,
          label: script.label,
          code: script.code,
          type: script.type.value,
          executionOrder: i,
        })),
      })
      .then(close);
  };

  return (
    <Modal
      wide
      subTitle="Write scripts to execute on a page to get necessary data"
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
          onClick={submit}
          type="button"
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
          {scripts.map((script, i) => (
            <div className="border-b pb-10 mb-10">
              <div className="flex">
                <Select
                  options={scriptOptions}
                  value={script.type}
                  onChange={(type) => updateType(i, type)}
                />
                <button
                  type="button"
                  onClick={() =>
                    setScripts(scripts.filter((s, index) => index !== i))
                  }
                  className="ml-3 inline-flex shadow-sm items-center px-2 py-1 border border-red-600 text-sm leading-5 font-medium rounded-md text-white bg-red-600 hover:bg-red-800 hover:border-red-800 focus:outline-none focus:border-blue-300 focus:shadow-outline-blue transition ease-in-out duration-150"
                >
                  <Trash />
                </button>
              </div>
              <div className="pt-3">
                {React.createElement(scriptTypes[script.type.value], {
                  label: script.label,
                  code: script.code,
                  updateLabel: (label) => updateLabel(i, label),
                  updateCode: (code) => updateCode(i, code),
                })}
              </div>
            </div>
          ))}
          <span className="inline-flex rounded-md mt-6 w-full flex justify-center">
            <button
              type="button"
              id="add-field"
              onClick={() => setScripts([...scripts, defaultScript])}
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
};

ManageTaskScripts.propTypes = {
  close: PropTypes.func.isRequired,
  taskId: PropTypes.number.isRequired,
  // eslint-disable-next-line react/forbid-prop-types
  existingScripts: PropTypes.array.isRequired,
};

export default ManageTaskScripts;
