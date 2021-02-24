import React from "react";
import PropTypes from "prop-types";

const Modal = ({ wide, children, isOpen, close, title }) => {
  if (!isOpen) {
    return null;
  }
  return (
    <>
      <div className="bg-gray-100 z-20 absolute">
        <div className="fixed inset-0 overflow-hidden">
          <div className="absolute inset-0 overflow-hidden">
            <section
              className="absolute inset-y-0 right-0 pl-10 max-w-full flex sm:pl-16"
              aria-labelledby="slide-over-heading"
            >
              <transition
                enter-active-class="transform transition ease-in-out duration-500 sm:duration-700"
                enter-class="translate-x-full"
                enter-to-class="translate-x-0"
                leave-active-class="transform transition ease-in-out duration-500 sm:duration-700"
                leave-class="translate-x-0"
                leave-to-class="translate-x-full"
              >
                <div
                  className={`w-screen h-screen ${
                    wide ? "max-w-2xl" : "max-w-lg"
                  }`}
                >
                  <form className="h-full flex flex-col bg-white shadow-xl">
                    <div className="flex-1">
                      <div className="px-4 py-6 bg-gray-50 sm:px-6">
                        <div className="flex items-start justify-between space-x-3">
                          <div className="space-y-1">
                            <h1 className="text-2xl font-extrabold text-gray-900 uppercase">
                              {title}
                            </h1>
                          </div>
                          <div className="h-7 flex items-center">
                            <button
                              onClick={close}
                              type="button"
                              className="bg-transparent rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                              <span className="sr-only">Close panel</span>
                              <svg
                                className="h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                aria-hidden="true"
                              >
                                <path
                                  strokeLinejoin="round"
                                  strokeWidth="2"
                                  d="M6 18L18 6M6 6l12 12"
                                />
                              </svg>
                            </button>
                          </div>
                        </div>
                      </div>
                      <div className="px-4 py-6 sm:px-6">
                        <div>
                          <div>
                            <nav className="sm:hidden" aria-label="Back">
                              <a
                                href="#"
                                className="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700"
                              >
                                <svg
                                  className="flex-shrink-0 -ml-1 mr-1 h-5 w-5 text-gray-400"
                                  xmlns="http://www.w3.org/2000/svg"
                                  viewBox="0 0 20 20"
                                  fill="currentColor"
                                  aria-hidden="true"
                                >
                                  <path
                                    fillRule="evenodd"
                                    d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z"
                                    clipRule="evenodd"
                                  />
                                </svg>
                                Back
                              </a>
                            </nav>
                          </div>
                        </div>

                        <div className="mt-10 sm:mt-0 w-full">{children}</div>
                      </div>
                    </div>
                    <div className="flex-shrink-0 px-4 border-t border-gray-200 py-5 sm:px-6 flex justify-end">
                      <div className="space-x-3 flex justify-end">
                        <button
                          onClick={close}
                          type="button"
                          className="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                        >
                          Cancel
                        </button>
                      </div>
                    </div>
                  </form>
                </div>
              </transition>
            </section>
          </div>
        </div>
      </div>

      <div className="bg-gray-500 absolute left-0 top-0 w-screen h-screen z-10 opacity-60" />
    </>
  );
};

Modal.propTypes = {
  wide: PropTypes.bool,
  children: PropTypes.node.isRequired,
  isOpen: PropTypes.bool.isRequired,
  close: PropTypes.func.isRequired,
  title: PropTypes.string.isRequired
};

Modal.defaultProps = {
  wide: false,
};

export default Modal;
