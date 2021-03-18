import React, { useEffect, useState } from "react";
import MobileNavigation from "../components/MobileNavigation";
import Sidebar from "../components/nav/Sidebar";
import TaskDetails from "../components/TaskDetails";
import TasksList from "../components/TasksList";
import EmptyState from "../components/EmptyState";
import axios from "../plugins/axios";
import TaskManager from "../components/TaskManager";

const Tasks = () => {
  const [fetchState, setFetchState] = useState(null);
  const [tasks, setTasks] = useState([]);
  const [selectedTask, setSelectedTask] = useState(null);

  const [managedTaskId, setManagedTaskId] = useState(null);
  const [isManagerOpen, setIsManagerOpen] = useState(false);

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
          <EmptyState onActionClick={() => setIsManagerOpen(true)} />
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
                isActive={selectedTask.isActive}
                needsAttention={selectedTask.needsAttention}
                id={selectedTask.id}
                updateTask={(task) => {
                  setTasks(tasks.map((t) => (t.id === task.id ? task : t)));
                  setSelectedTask(task);
                }}
                openEditTask={(id) => {
                  setManagedTaskId(id);
                  setIsManagerOpen(true);
                }}
                deleteTask={(id) => {
                  axios.delete(`/tasks/${id}`).then(() => {
                    setTasks(tasks.filter((t) => t.id !== id));
                    setSelectedTask(tasks[0]);
                  });
                }}
              />
            )}

            <TasksList
              setSelected={(task) => setSelectedTask(task)}
              selectedId={selectedTask?.id}
              tasks={tasks}
              openAddTask={() => {
                setManagedTaskId(null);
                setIsManagerOpen(true);
              }}
            />
          </main>
        )}
      </div>

      {isManagerOpen && (
        <TaskManager
          addTask={(task) => {
            setTasks([...tasks, task]);
            setSelectedTask(task);
          }}
          updateTask={(task) => {
            setSelectedTask(task);
            setTasks(tasks.map((t) => (t.id === task.id ? task : t)));
          }}
          close={() => setIsManagerOpen(false)}
          taskId={managedTaskId}
        />
      )}
    </div>
  );
};

export default Tasks;
