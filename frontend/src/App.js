import Router from "./route/Index";
import { ToastContainer } from "react-toastify";
import ThemeProvider from "./layout/provider/Theme";


const App = () => {
  return (
    <ThemeProvider>
          <Router />
          <ToastContainer autoClose={5000} hideProgressBar={false} newestOnTop={false} closeOnClick rtl={false} pauseOnFocusLoss pauseOnHover theme="colored" />
    </ThemeProvider>
  );
};
export default App;