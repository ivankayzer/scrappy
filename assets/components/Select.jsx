import React, { useState } from "react";
import PropTypes from "prop-types";
import { Transition } from "@headlessui/react";

const ValueIcon = ({ icon }) => (
  <div className="flex justify-center w-10">
    <span className="mr-1">{icon}</span>
  </div>
);

const Select = ({ onChange, options, value }) => {
  const [isOpen, setIsOpen] = useState(false);

  const decoratedSetValue = (v) => {
    onChange(v);
    setIsOpen(false);
  };

  return (
    <div className="relative w-full">
      <button
        onClick={() => setIsOpen(!isOpen)}
        type="button"
        className="relative w-full bg-white border border-gray-300 rounded-md shadow-sm pl-1 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm cursor-pointer"
      >
        <div className="flex items-center">
          {value.icon ? (
            <ValueIcon icon={value.icon} />
          ) : (
            <div className="ml-3" />
          )}
          <span className="block truncate">{value.label}</span>
        </div>
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

      <Transition
        show={isOpen}
        leaveFrom="transition ease-in duration-100"
        leave="opacity-100"
        leaveTo="opacity-0"
      >
        <div className="absolute z-10 mt-1 w-full rounded-md bg-white shadow-lg">
          <div
            tabIndex="-1"
            className="max-h-60 flex flex-col rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
          >
            {options.map((option) => (
              <button
                type="button"
                onClick={() => decoratedSetValue(option)}
                key={option.value}
                className="text-gray-900 cursor-default select-none relative py-2 pl-1 pr-0 hover:bg-gray-50 cursor-pointer focus:outline-none"
              >
                <div className="flex items-center">
                  {option.icon ? (
                    <ValueIcon icon={option.icon} />
                  ) : (
                    <div className="ml-3" />
                  )}
                  <span className="font-normal block">{option.label}</span>
                </div>
              </button>
            ))}
          </div>
        </div>
      </Transition>
    </div>
  );
};

const optionPropType = {
  value: PropTypes.oneOfType([PropTypes.string, PropTypes.number]).isRequired,
  label: PropTypes.string.isRequired,
  icon: PropTypes.node,
};

Select.propTypes = {
  onChange: PropTypes.func,
  options: PropTypes.arrayOf(PropTypes.shape(optionPropType)).isRequired,
  value: PropTypes.shape(optionPropType).isRequired,
};

Select.defaultProps = {
  onChange: () => {},
};

ValueIcon.propTypes = {
  icon: PropTypes.node.isRequired,
};

export default Select;
