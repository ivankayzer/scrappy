import React, { useState, useEffect } from "react";
import PropTypes from "prop-types";
import axios from "../plugins/axios";
import ManageTask from "./modals/ManageTask";
import ManageTaskScripts from "./modals/ManageTaskScripts";

const TaskManager = ({ close, taskId, updateTask, addTask }) => {
  const [currentStep, setCurrentStep] = useState("task");
  const [task, setTask] = useState({});
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (taskId) {
      axios.get(`/tasks/${taskId}`).then((response) => {
        setTask(response.data.task);
        setLoading(false);
      });
    } else {
      setLoading(false);
    }
  }, []);

  return (
    <div>
      {!loading && currentStep === "task" && (
        <ManageTask
          task={task}
          close={close}
          addAndNext={(task) => {
            addTask(task);
            setCurrentStep("scripts");
          }}
          updateAndNext={(task) => {
            updateTask(task);
            setCurrentStep("scripts");
          }}
        />
      )}
      {!loading && currentStep === "scripts" && (
        <ManageTaskScripts close={close} />
      )}
    </div>
  );
};

TaskManager.propTypes = {
  close: PropTypes.func.isRequired,
  updateTask: PropTypes.func.isRequired,
  taskId: PropTypes.number,
};

TaskManager.defaultProps = {
  taskId: null,
};

export default TaskManager;
