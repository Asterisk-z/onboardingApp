import React, { useLayoutEffect } from "react";
import { Routes,Route, useLocation } from "react-router-dom";
import WizardTest from "../pages/components/forms/WizardTest";
import InvoicePrint from "../pages/pre-built/invoice/InvoicePrint";

import Error404Classic from "../pages/error/404-classic";
import Error404Modern from "../pages/error/404-modern";
import Error504Modern from "../pages/error/504-modern";
import Error504Classic from "../pages/error/504-classic";



import Login from "main/auth/Login";
import Logout from "main/auth/Logout";
import Register from "main/auth/Register";
import ForgotPassword from "main/auth/ForgotPassword";
import PasswordUpdate from "main/auth/PasswordUpdate";
import PasswordReset from "main/auth/PasswordChange";
import Application from "main/pages/application/Index";
import Form from "main/forms/Form";
import AdminBroadcast from "main/pages/Admin/AdminBroadcast" 
import AdminListInstitutionAR from "main/pages/Admin/AdminListInstitutionAR" 
import AdminListAR from "main/pages/Admin/AdminListAR" 
import AdminTransferAR from "main/pages/Admin/AdminTransferAR" 
import AdminCategories from "main/pages/Admin/AdminCategories" 
import AdminComplaintType from "main/pages/Admin/AdminComplaintType" 
import AdminPositions from "main/pages/Admin/AdminPositions" 
import AdminComplaint from "main/pages/Admin/AdminComplaint" 
import AdminRegulators from "main/pages/Admin/AdminRegulators"
import AdminSanctions from "main/pages/Admin/AdminSanctions"

import Complaint from "main/pages/Complaint" 
import AuditLog from "main/pages/AuditLog" 
import AuthRepresentative from "main/pages/AuthRepresentative" 
import ListTransferAuthRepresentative from "main/pages/ListTransferAuthRepresentative" 
import ChangeAuthRepresentatives from "main/pages/ListChangeAuthRepresentative" 
import ChangeAuthRepresentative from "main/pages/ChangeAuthRepresentative" 
import TransferAuthRepresentative from "main/pages/TransferAuthRepresentative" 
import PendingAuthRepresentative from "main/pages/PendingAuthRepresentative" 
import FeesFramework from "main/pages/FeesFramework"
import Regulators from "main/pages/Regulators"
import Sanction from "main/pages/Sanction"

import AdminAuditLog from "main/pages/Admin/AdminAuditLog" 
import AdminInstitutions from "main/pages/Admin/AdminInstitutions";
import AddBroadcast from "main/pages/Admin/AddBroadcast";
import UserAuditLog from "main/pages/Admin/AuditLog" 
import Success from "pages/auth/Success";

import Layout from "layout/Index";
import AdminLayout from "layout/AdminLayout";
import UserLayout from "layout/UserLayout";
import LayoutNoSidebar from "layout/Index-nosidebar";


import MainLayout from "main/layout/Index";
import MainLayoutNoSidebar from "main/layout/Index-nosidebar";
import LoggedInLayoutNoSidebar from "layout/loggedin-nosideber";


import Landing from "main/auth/Landing";
import UserHomepage from "main/pages/Homepage";
import AdminHomepage from "main/pages/Admin/Homepage";

const Router = () => {
  const location = useLocation();
  useLayoutEffect(() => {
    window.scrollTo(0, 0);
  }, [location]);

  return (
      <Routes>
        {/*Panel */}

        <Route path={`${process.env.PUBLIC_URL}`} element={<MainLayoutNoSidebar />}>
            {/* <Route path="auth-success" element={<Success />}></Route> */}
            <Route path="auth-password-reset" element={<PasswordReset />}></Route>
            <Route path="auth-password-update" element={<PasswordUpdate />}></Route>
            <Route path="auth-reset" element={<ForgotPassword />}></Route>
            <Route path="auth-register" element={<Register />}></Route>
            <Route path="privacy-policy" element={<Landing />}></Route>
            <Route path="login" element={<Login />}></Route>
            <Route path="logout" element={<Logout />}></Route>
            <Route path="form" element={<Form />}></Route>
            <Route index element={<Login />}></Route>
            

            <Route path="errors">
              <Route path="404-modern" element={<Error404Modern />}></Route>
              <Route path="404-classic" element={<Error404Classic />}></Route>
              <Route path="504-modern" element={<Error504Modern />}></Route>
              <Route path="504-classic" element={<Error504Classic />}></Route>
            </Route>
            <Route path="*" element={<Error404Modern />}></Route>
            
            <Route path="invoice-print/:invoiceId" element={<InvoicePrint />}></Route>
        </Route>
        
      


        <Route path={`${process.env.PUBLIC_URL}`} element={<LoggedInLayoutNoSidebar />}>
 
            <Route path="application" element={<Application />}></Route>
            
        </Route>
        















      
        
        <Route path={`${process.env.PUBLIC_URL}`} element={<UserLayout />}>
          
          <Route path="dashboard" element={<UserHomepage />}></Route>
          <Route path="complaint" element={<Complaint />}></Route>
          <Route path="audit-log" element={<AuditLog />}></Route>
          <Route path="auth-representatives-pending" element={<PendingAuthRepresentative />}></Route>
          <Route path="transfer-auth-representatives" element={<ListTransferAuthRepresentative />}></Route>
          <Route path="change-auth-representative/:ar_user_id" element={<ChangeAuthRepresentative />}></Route>
          <Route path="change-auth-representatives" element={<ChangeAuthRepresentatives />}></Route>
          <Route path="transfer-auth-representative/:ar_user_id" element={<TransferAuthRepresentative />}></Route>
          <Route path="auth-representatives" element={<AuthRepresentative />}></Route>
          <Route path="fees-framework" element={<FeesFramework />}></Route>
          <Route path="sanctions" element={<Sanction />}></Route>
          <Route path="regulators" element={<Regulators />}></Route>
        </Route>

        <Route path={`${process.env.PUBLIC_URL}`} element={<AdminLayout />}>
          <Route path="admin-dashboard" element={<AdminHomepage />}></Route>
          <Route path="admin-complaint" element={<AdminComplaint />}></Route>
          <Route path="admin-audit-log" element={<AdminAuditLog />}></Route>
          <Route path="admin-broadcast" element={<AdminBroadcast />}></Route>
          <Route path="admin-list-ar" element={<AdminListAR />}></Route>
          <Route path=":institution_id/list-ars" element={<AdminListInstitutionAR />}></Route>
          <Route path="admin-transfer-ar" element={<AdminTransferAR />}></Route>
          <Route path="user-audit-log" element={<UserAuditLog />}></Route>
          <Route path="add-broadcast" element={<AddBroadcast />}></Route>
          <Route path="admin-institutions" element={<AdminInstitutions />}></Route>
          <Route path="admin-complaint-type" element={<AdminComplaintType />}></Route>
          <Route path="admin-categories" element={<AdminCategories />}></Route>
          <Route path="admin-positions" element={<AdminPositions />}></Route>
          <Route path="admin-regulators" element={<AdminRegulators />}></Route>
          <Route path="admin-sanctions" element={<AdminSanctions />}></Route>
          <Route path="wizard" element={<WizardTest />}></Route>


        </Route>
      </Routes>
  );
};
export default Router;
