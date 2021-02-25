import React, { useEffect, useState } from "react";
import MobileNavigation from "../components/MobileNavigation";
import Sidebar from "../components/Sidebar";
import router from "../router";
import TaskDetails from "../components/TaskDetails";
import TasksList from "../components/TasksList";
import ManageTask from "../components/modals/ManageTask";
import EmptyState from "../components/EmptyState";
import ManageTaskScripts from "../components/modals/ManageTaskScripts";

const Tasks = () => {
  const [fetchState, setFetchState] = useState(null);
  const [tasks, setTasks] = useState([]);
  const [selectedTask, setSelectedTask] = useState(null);

  const [manageModal, showManageModal] = useState(false);
  const [manageScriptsModal, showManageScriptsModal] = useState(false);

  useEffect(() => {
    router.get("/tasks").then((response) => {
      setTasks(response);
      setSelectedTask(response[0]);
      setFetchState("LOADED");
    });
  }, []);

  return (
    <div className="h-screen flex flex-col">
      <MobileNavigation />
      <div className="min-h-0 flex-1 flex md:overflow-hidden">
        <Sidebar user />

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

      <ManageTask close={() => showManageModal(false)} isOpen={manageModal} />

      <ManageTaskScripts
        close={() => showManageScriptsModal(false)}
        isOpen={manageScriptsModal}
      />
    </div>
  );
};

export default Tasks;
