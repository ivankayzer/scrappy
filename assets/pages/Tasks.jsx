import React, { useEffect, useState } from "react";
import MobileNavigation from "../components/MobileNavigation";
import Sidebar from "../components/nav/Sidebar";
import TaskDetails from "../components/TaskDetails";
import TasksList from "../components/TasksList";
import ManageTask from "../components/modals/ManageTask";
import EmptyState from "../components/EmptyState";
import ManageTaskScripts from "../components/modals/ManageTaskScripts";
import axios from '../plugins/axios';

const Tasks = () => {
  const [fetchState, setFetchState] = useState(null);
  const [tasks, setTasks] = useState([]);
  const [selectedTask, setSelectedTask] = useState(null);

  const [manageModal, showManageModal] = useState(false);
  const [manageScriptsModal, showManageScriptsModal] = useState(false);

  useEffect(() => {
    axios.get("/tasks/all").then((response) => {
      const tasksList = response.data.tasks;
      setTasks(tasksList);
      setSelectedTask(tasksList[0]);
      setFetchState("LOADED");
    });
  }, []);

  return (
    <div className="h-screen flex flex-col">
      <MobileNavigation />
      <div className="min-h-0 flex-1 flex md:overflow-hidden">
        <Sidebar user={{ email: "ivankayzer@gmail.com" }} />

        {!tasks.length && fetchState === "LOADED" ? (
          <EmptyState onActionClick={() => showManageModal(true)} />
        ) : (
          <main className="min-w-0 flex-1 border-t border-gray-200 xl:flex">
            {selectedTask && (
              <TaskDetails
                name={selectedTask.name}
                url={selectedTask.url}
                checkFrequency={selectedTask.checkFrequency}
                notificationChannel={selectedTask.notificationChannel}
                lastChecked={selectedTask.lastChecked}
                events={selectedTask.events}
              />
            )}

            <TasksList
              openManageModal={() => showManageModal(true)}
              openManageScriptsModal={() => showManageScriptsModal(true)}
              setSelected={(task) => setSelectedTask(task)}
              selectedId={selectedTask?.id}
              tasks={tasks}
            />
          </main>
        )}
      </div>

      {manageModal && <ManageTask close={() => showManageModal(false)} />}

      {manageScriptsModal && (
        <ManageTaskScripts close={() => showManageScriptsModal(false)} />
      )}
    </div>
  );
};

export default Tasks;
