import React from "react";

const MobileNavigation = () => (
  <header className="md:hidden flex-shrink-0 relative h-16 bg-white flex items-center">
    <div className="absolute inset-y-0 left-0 lg:static lg:flex-shrink-0">
      <a
        href="#"
        className="flex items-center justify-center h-16 w-16 bg-blue-400 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-600 lg:w-20"
      >
        <img
          className="h-8 w-auto"
          src="https://tailwindui.com/img/logos/workflow-mark.svg?color=white"
          alt="Workflow"
        />
      </a>
    </div>

    <div className="mx-auto lg:hidden">
      <div className="relative">
        <div className="pointer-events-none absolute inset-y-0 right-0 flex items-center justify-center pr-2">
          <svg
            className="h-5 w-5 text-gray-500"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
            aria-hidden="true"
          >
            <path
              fillRule="evenodd"
              d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
              clipRule="evenodd"
            />
          </svg>
        </div>
      </div>
    </div>

    <div className="absolute inset-y-0 right-0 pr-4 flex items-center sm:pr-6 lg:hidden">
      <button
        type="button"
        className="-mr-2 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-600"
      >
        <span className="sr-only">Open main menu</span>
        <svg
          className="block h-6 w-6"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke="currentColor"
          aria-hidden="true"
        >
          <path
            strokeLinecap="round"
            strokeLinejoin="round"
            strokeWidth="2"
            d="M4 6h16M4 12h16M4 18h16"
          />
        </svg>
      </button>
    </div>
  </header>
);

export default MobileNavigation;
