import React from "react";
import { Outlet } from "react-router-dom";
import Head from "../main/layout/head/Head";
import UserProvider from "./provider/AuthUser";

const Layout = ({title, ...props}) => {

  return (
    <>
    <UserProvider type="user">
      <Head title={!title && 'Loading'} />
      <div className="nk-app-root">
        <div className="nk-wrap nk-wrap-nosidebar">
          <div className="nk-content">
            <Outlet />
          </div>
        </div>
      </div> 
    </UserProvider>
    </>
  );
};
export default Layout;
