import React, { useEffect, useState } from "react";
import PropTypes from "prop-types";
import Modal from "../Modal";
import Event from "../Event";
import axios from "../../plugins/axios";

const Notifications = ({ close }) => {
  const [events, setEvents] = useState([]);

  useEffect(() => {
    axios
      .get("/events/all")
      .then((response) => setEvents(response.data.events));
  }, []);

  return (
    <Modal close={close} title="Notifications">
      <div className="mt-6 sm:mt-5 space-y-6 sm:space-y-5">
        <ul
          className="-mb-8 overflow-y-auto"
          style={{ height: "calc(100vh - 250px)" }}
        >
          {events.map((event, i) => (
            <Event
              color={event.color}
              isLast={events.length - 1 === i}
              name={event.name}
              timestamp={event.timestamp}
              subtext={event.subtext}
              changes={event.changes}
              taskName={event.taskName}
            />
          ))}
        </ul>
      </div>
    </Modal>
  );
};

Notifications.propTypes = {
  close: PropTypes.func.isRequired,
};

export default Notifications;
