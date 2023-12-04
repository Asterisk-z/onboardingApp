import Router from "./route/Index";
import { ToastContainer } from "react-toastify";
import ThemeProvider from "./layout/provider/Theme";

const App = () => {
  return (
    <ThemeProvider>
          <ToastContainer autoClose={5000} hideProgressBar={false} newestOnTop={false} closeOnClick rtl={false} pauseOnFocusLoss pauseOnHover theme="colored" />
          <Router />
    </ThemeProvider>
  );
};
export default App;