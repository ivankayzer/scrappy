/* eslint-disable jsx-a11y/label-has-associated-control */
import React from "react";
import ScriptDescription from "../ScriptDescription";
import Input from "../Input";

const Execute = ({ label, code }) => {
  return (
    <div>
      <ScriptDescription description="Extract information from the page using JavaScript" />
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
              <Input
                value={label}
                name="label"
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
                value={code}
              />
            </div>
          </div>
        </div>
      </div>
    </div>
  );
};

export default Execute;
