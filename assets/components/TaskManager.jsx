import React, { useState } from "react";
import PropTypes from "prop-types";
import ManageTask from "./modals/ManageTask";
import ManageTaskScripts from "./modals/ManageTaskScripts";

const TaskManager = ({ close, taskId }) => {
  const [currentStep, setCurrentStep] = useState("task");

  if (taskId) {
  // fetch from backend
  }

  return (
    <div>
      {currentStep === "task" && (
        <ManageTask close={close} next={() => setCurrentStep("scripts")} />
      )}
      {currentStep === "scripts" && <ManageTaskScripts close={close} />}
    </div>
  );
};

TaskManager.propTypes = {
  close: PropTypes.func.isRequired,
  taskId: PropTypes.number,
};

TaskManager.defaultProps = {
  taskId: null,
};

export default TaskManager;
