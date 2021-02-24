import React, { useEffect, useState } from "react";
import MobileNavigation from "../components/MobileNavigation";
import Sidebar from "../components/Sidebar";
import router from "../router";
import TaskDetails from "../components/TaskDetails";
import TasksList from "../components/TasksList";
import Modal from "../components/Modal";
import ManageTask from "../components/modals/ManageTask";

const Tasks = () => {
  const [tasks, setTasks] = useState([]);
  const [selectedTask, setSelectedTask] = useState(null);

  const [manageModal, showManageModal] = useState(false);

  useEffect(() => {
    router.get("/tasks").then((response) => {
      setTasks(response);
      setSelectedTask(response[0]);
    });
  }, []);

  return (
    <div className="h-screen flex flex-col">
      <MobileNavigation />
      <div className="min-h-0 flex-1 flex md:overflow-hidden">
        <Sidebar user />

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
            setSelected={(task) => setSelectedTask(task)}
            selectedId={selectedTask?.id}
            tasks={tasks}
          />
        </main>
      </div>

      <ManageTask close={() => showManageModal(false)} isOpen={manageModal} />
    </div>
  );
};

export default Tasks;
