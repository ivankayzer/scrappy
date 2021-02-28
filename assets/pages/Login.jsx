import React from "react";
import { useHistory } from "react-router-dom";
import router from "../router";

const Login = () => {
  const history = useHistory();

  const login = () => {
    router.get("/login").then(() => {
      history.push("/tasks");
    });
  };

  return (
    <button
      className="bg-black text-white px-5 py-3 rounded m-5"
      onClick={login}
      type="button"
    >
      Login
    </button>
  );
};

export default Login;
