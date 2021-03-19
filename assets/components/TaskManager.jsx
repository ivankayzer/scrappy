import React, { useState, useEffect } from "react";
import PropTypes from "prop-types";
import axios from "../plugins/axios";
import ManageTask from "./modals/ManageTask";
import ManageTaskScripts, {
  defaultScript,
  scriptOptions,
} from "./modals/ManageTaskScripts";

const TaskManager = ({ close, taskId, updateTask, addTask }) => {
  const [currentStep, setCurrentStep] = useState("task");
  const [task, setTask] = useState({});
  const [scripts, setScripts] = useState(defaultScript);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    if (taskId) {
      const taskPromise = axios.get(`/tasks/${taskId}`).then((response) => {
        setTask(response.data.task);
      });
      const scriptPromise = axios
        .get(`/tasks/${taskId}/scripts`)
        .then((response) => {
          const loadedScripts = response.data.scripts.map((script) => ({
            ...script,
            type: scriptOptions.find((so) => so.value === script.type),
          }));

          setScripts(loadedScripts);
        });

      Promise.all([taskPromise, scriptPromise]).then(() => {
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
          addAndNext={(t) => {
            addTask(t);
            setCurrentStep("scripts");
          }}
          updateAndNext={(t) => {
            updateTask(t);
            setCurrentStep("scripts");
          }}
        />
      )}
      {!loading && currentStep === "scripts" && (
        <ManageTaskScripts taskId={task.id} existingScripts={scripts} close={close} />
      )}
    </div>
  );
};

TaskManager.propTypes = {
  close: PropTypes.func.isRequired,
  updateTask: PropTypes.func.isRequired,
  addTask: PropTypes.func.isRequired,
  taskId: PropTypes.number,
};

TaskManager.defaultProps = {
  taskId: null,
};

export default TaskManager;
