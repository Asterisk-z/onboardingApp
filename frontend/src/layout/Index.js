import React from "react";
import { Outlet, useNavigate } from "react-router-dom";
import Sidebar from "./sidebar/Sidebar";
import Head from "./head/Head";
import Header from "./header/Header";
import Footer from "./footer/Footer";
import AppRoot from "./global/AppRoot";
import AppMain from "./global/AppMain";
import AppWrap from "./global/AppWrap";
import UserProvider from "./provider/AuthUser";

import checkTokenExp from "../utils/checkTokenExp";

import FileManagerProvider from "../pages/app/file-manager/components/Context";

const Layout = ({title, ...props}) => {
  
  const accessToken = localStorage.getItem("access-token");
  const loggedUser = localStorage.getItem("logger");
  if(!accessToken || !loggedUser ) {
      window.location.href = `${process.env.PUBLIC_URL}/logout`;
  }
  checkTokenExp(accessToken, loggedUser);

  return (
    <UserProvider>
      <FileManagerProvider>
        <Head title={!title && 'Loading'} />
        <AppRoot>
          <AppMain>
            <Sidebar fixed />
            <AppWrap>
              <Header fixed />
                <Outlet />
              <Footer />
            </AppWrap>
          </AppMain>
        </AppRoot>
      </FileManagerProvider>      
    </UserProvider>

  );
};
export default Layout;
