import React from "react";
import PropTypes from "prop-types";

const Input = ({
  name,
  value,
  onChange,
  onValueChange,
  placeholder,
  type,
  label,
}) => {
  const decoratedOnChange = (e) => {
    onChange(e);
    onValueChange(e.target.value);
  };

  return (
    <>
      {label && (
        <label
          htmlFor={name}
          className="block text-sm font-medium text-gray-700 sm:mt-px sm:pt-2"
        >
          {label}
        </label>
      )}

      <div className="mt-1 sm:mt-0 sm:col-span-2">
        <div className="w-full flex rounded-md shadow-sm">
          <input
            type={type}
            name={name}
            id={name}
            placeholder={placeholder}
            onChange={decoratedOnChange}
            value={value}
            className="flex-1 block w-full focus:ring-indigo-500 focus:border-indigo-500 min-w-0 rounded-md sm:text-sm border-gray-300"
          />
        </div>
      </div>
    </>
  );
};

Input.propTypes = {
  name: PropTypes.string.isRequired,
  value: PropTypes.string.isRequired,
  onChange: PropTypes.func,
  onValueChange: PropTypes.func,
  placeholder: PropTypes.string,
  type: PropTypes.string,
  label: PropTypes.string,
};

Input.defaultProps = {
  placeholder: "",
  type: "text",
  label: null,
  onChange: () => {},
  onValueChange: () => {},
};

export default Input;
