import React from "react";
import {
  BrowserRouter as Router,
  Redirect,
  Route,
  Switch,
} from "react-router-dom";
import Login from "./pages/Login";
import Tasks from "./pages/Tasks";

function App() {
  return (
    <Router>
      <div>
        <Switch>
          <Route path="/login" component={Login} />
          <Route path="/tasks" component={Tasks} />
          <Redirect
            to={{
              pathname: "/login",
              state: { from: "/" },
            }}
          />
        </Switch>
      </div>
    </Router>
  );
}

export default App;
