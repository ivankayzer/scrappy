import React from "react";
import PropTypes from "prop-types";
import Modal from "../Modal";

const AccountSettings = ({ close }) => (
  <Modal close={close} title="Account settings">
    <div className="flex w-full items-center">
      <div className="md:mt-0 md:col-span-2 w-full">
        <div className="bg-white">
          <div className="w-full text-sm text-gray-600">
            Once your account is deleted, all of its tasks and data will be
            permanently deleted.
          </div>

          <div className="mt-5">
            <button
              type="button"
              className="inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:shadow-outline-red active:bg-red-600 transition ease-in-out duration-150"
            >
              Delete Account
            </button>
          </div>
        </div>
      </div>
    </div>
  </Modal>
);

AccountSettings.propTypes = {
  close: PropTypes.func.isRequired,
};

export default AccountSettings;
