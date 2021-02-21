import { useEffect } from "react";
import router from "./router";

function App() {
  useEffect(() => {
    router.get("/login").then((response) => console.log(response));
  }, []);
  return null;
}

export default App;
