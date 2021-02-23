import React from "react";
import PropTypes from "prop-types";

const Event = ({ isLast, color, name, subtext, timestamp, changes }) => (
  <li>
    <div className="relative pb-8">
      {!isLast && (
        <span
          className="absolute top-5 left-5 -ml-px h-full w-0.5 bg-gray-200"
          aria-hidden="true"
        />
      )}

      <div className="relative flex items-start space-x-3">
        <div>
          <div className="relative px-1">
            <div
              className={`h-8 w-8 rounded-full ring-8 ring-white flex items-center justify-center bg-${color}-100`}
            >
              <svg
                className={`h-5 w-5 text-${color}-500`}
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                aria-hidden="true"
              >
                <path
                  fillRule="evenodd"
                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-6-3a2 2 0 11-4 0 2 2 0 014 0zm-2 4a5 5 0 00-4.546 2.916A5.986 5.986 0 0010 16a5.986 5.986 0 004.546-2.084A5 5 0 0010 11z"
                  clipRule="evenodd"
                />
              </svg>
            </div>
          </div>
        </div>
        <div className="min-w-0 flex-1">
          <div>
            <div className="text-sm">
              <div className="font-medium text-gray-900">{name}</div>
            </div>
            <p className="mt-0.5 text-xs text-gray-400">{timestamp}</p>
          </div>
          {subtext && (
            <div className="mt-2 text-sm text-gray-600">
              <p>{subtext}</p>
            </div>
          )}

          {changes ? (
            <div className="mt-2 text-sm text-gray-600">
              {changes.map((change) => (
                <div className="flex items-center">
                  <span className="line-through">{change.old}</span>
                  <span className="mx-3">
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
                        strokeWidth="2"
                        d="M17 8l4 4m0 0l-4 4m4-4H3"
                      />
                    </svg>
                  </span>
                  <span>{change.new}</span>
                </div>
              ))}
            </div>
          ) : null}
        </div>
      </div>
    </div>
  </li>
);

export const eventPropTypes = {
  isLast: PropTypes.bool.isRequired,
  color: PropTypes.string.isRequired,
  name: PropTypes.string.isRequired,
  subtext: PropTypes.string,
  timestamp: PropTypes.string.isRequired,
  changes: PropTypes.arrayOf({
    old: PropTypes.string.isRequired,
    new: PropTypes.string.isRequired,
  }),
}

Event.propTypes = eventPropTypes;

Event.defaultProps = {
  changes: [],
  subtext: null,
};

export default Event;
