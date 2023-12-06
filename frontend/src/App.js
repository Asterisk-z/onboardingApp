import Router from "./route/Index";
import { ToastContainer } from "react-toastify";
import ThemeProvider from "./layout/provider/Theme";
// import UserProvider from "./layout/provider/AuthUser";

const App = () => {
  return (
    <ThemeProvider>
    {/* <UserProvider> */}
          <ToastContainer autoClose={5000} hideProgressBar={false} newestOnTop={false} closeOnClick rtl={false} pauseOnFocusLoss pauseOnHover theme="colored" />
          <Router />
    {/* </UserProvider> */}
    </ThemeProvider>
  );
};
export default App;