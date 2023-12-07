import Router from "./route/Index";
import { ToastContainer } from "react-toastify";
import ThemeProvider from "./layout/provider/Theme";
// import UserProvider from "./layout/provider/AuthUser";

const App = () => {
  return (
    <ThemeProvider>
    {/* <UserProvider> */}
          <Router />
          <ToastContainer autoClose={5000} hideProgressBar={false} newestOnTop={false} closeOnClick rtl={false} pauseOnFocusLoss pauseOnHover theme="colored" />
    {/* </UserProvider> */}
    </ThemeProvider>
  );
};
export default App;