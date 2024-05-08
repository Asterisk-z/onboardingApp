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
import PasswordSet from "main/auth/PasswordSet";
import ApplicationDetail from "main/pages/application/Detail";
import ApplicationQPay from "main/pages/application/Payment";
import ApplicationPreview from "main/pages/application/Preview";
import Application from "main/pages/application/Index";
import Applications from "main/pages/application/Applications";
import ApplicationDisclosure from "main/pages/application/ApplicationDisclosure";
import Additions from "main/pages/application/Additions";
import Conversions from "main/pages/application/Conversions";
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
import AdminFeesFramework from "main/pages/Admin/AdminFeesFramework"
import AdminDoh from "main/pages/Admin/AdminDoh"

import Complaint from "main/pages/Complaint" 
import AuditLog from "main/pages/AuditLog" 
import AuthRepresentative from "main/pages/AuthRepresentative" 
import ListTransferAuthRepresentative from "main/pages/ListTransferAuthRepresentative" 
import ChangeAuthRepresentatives from "main/pages/ListChangeAuthRepresentative" 
import ChangeAuthRepresentative from "main/pages/ChangeAuthRepresentative" 
import TransferAuthRepresentative from "main/pages/TransferAuthRepresentative" 
import PendingUpdateAuthRepresentative from "main/pages/PendingUpdateAuthRepresentative"
import PendingAuthRepresentative from "main/pages/PendingAuthRepresentative"
import ViewAuthRepresentative from "main/pages/ViewAuthRepresentative"
import FeesFramework from "main/pages/FeesFramework"
import Regulators from "main/pages/Regulators"
import Sanction from "main/pages/Sanction"
import ApplicantsGuide from "main/pages/ApplicantsGuide"
import MembersGuide from "main/pages/MembersGuide"
import Education from "main/pages/Education"
import RegisteredEvent from "main/pages/RegisteredEvent"
import UpdateCompetency from "main/pages/UpdateCompetency"
import ApproveCompetency from "main/pages/ApproveCompetency"


import AdminAuditLog from "main/pages/Admin/AdminAuditLog" 
import AdminInstitutions from "main/pages/Admin/AdminInstitutions";
import AddBroadcast from "main/pages/Admin/AddBroadcast";
import UserAuditLog from "main/pages/Admin/AuditLog" 
import AdminApplicantGuide from "main/pages/Admin/AdminApplicantGuide"
import AdminCompetencyFramework from "main/pages/Admin/AdminCompetencyFramework"
import AdminCompetencyDone from "main/pages/Admin/AdminCompetencyDone"
import AdminCompetencyUndone from "main/pages/Admin/AdminCompetencyUndone"
import AdminCompetencyDoneAll from "main/pages/Admin/AdminCompetencyDoneAll"
import AdminCompetencyUndoneAll from "main/pages/Admin/AdminCompetencyUndoneAll"
import AdminMembersGuide from "main/pages/Admin/AdminMembersGuide"
import AdminAddEvents from "main/pages/Admin/AdminAddEvents"
import AdminEvents from "main/pages/Admin/AdminEvents"
import AdminEventRegistrations from "main/pages/Admin/AdminEventRegistrations"
import AdminApplications from "main/pages/Admin/AdminApplications"
import AdminAllApplications from "main/pages/Admin/AdminAllApplications"
import AdminEditEvents from "main/pages/Admin/AdminEditEvents"
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
            <Route path="set/password" element={<PasswordSet />}></Route>
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
        
      


        {/* <Route path={`${process.env.PUBLIC_URL}`} element={<LoggedInLayoutNoSidebar />}>
 
            
        </Route>
         */}















      
        
        <Route path={`${process.env.PUBLIC_URL}`} element={<UserLayout />}>
          
          <Route path="dashboard" element={<UserHomepage />}></Route>
          <Route path="complaint" element={<Complaint />}></Route>
          <Route path="audit-log" element={<AuditLog />}></Route>
          <Route path="auth-representatives-pending" element={<PendingAuthRepresentative />}></Route>
          <Route path="auth-representatives-pending-update" element={<PendingUpdateAuthRepresentative />}></Route>
          <Route path="auth-representatives-view" element={<ViewAuthRepresentative />}></Route>
          <Route path="transfer-auth-representatives" element={<ListTransferAuthRepresentative />}></Route>
          <Route path="change-auth-representative/:ar_user_id" element={<ChangeAuthRepresentative />}></Route>
          <Route path="change-auth-representatives" element={<ChangeAuthRepresentatives />}></Route>
          <Route path="transfer-auth-representative/:ar_user_id" element={<TransferAuthRepresentative />}></Route>
          <Route path="auth-representatives" element={<AuthRepresentative />}></Route>
          <Route path="fees-framework" element={<FeesFramework />}></Route>
          <Route path="sanctions" element={<Sanction />}></Route>
          <Route path="regulators" element={<Regulators />}></Route>
          <Route path="applicant-guide" element={<ApplicantsGuide />}></Route>
          <Route path="membership-guide" element={<MembersGuide />}></Route>
          <Route path="update-competency" element={<UpdateCompetency />}></Route>
          <Route path="education-and-learning" element={<Education />}></Route>
          <Route path="registered-events" element={<RegisteredEvent />}></Route>
          <Route path="approve-competency" element={<ApproveCompetency />}></Route>
          
          <Route path="membership-applications" element={<Applications />}></Route>
          <Route path="membership-addictions" element={<Additions />}></Route>
          <Route path="membership-conversions" element={<Conversions />}></Route>
          <Route path="application/:application_uuid" element={<Application />}></Route>
          <Route path="application_disclosure/:application_uuid" element={<ApplicationDisclosure />}></Route>
          <Route path="application_preview/:application_uuid" element={<ApplicationPreview />}></Route>
          <Route path="application_detail/:application_uuid" element={<ApplicationDetail />}></Route>
          <Route path="qpay_check" element={<ApplicationQPay />}></Route>
          <Route path="application_q_pay_success" element={<ApplicationQPay />}></Route>
          <Route path="application_q_pay_error" element={<ApplicationQPay />}></Route>
          
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
          <Route path="admin-fees-framework" element={<AdminFeesFramework/>}></Route>
          <Route path="admin-applicant-guide" element={<AdminApplicantGuide/>}></Route>
          <Route path="admin-members-guide" element={<AdminMembersGuide/>}></Route>
          <Route path="admin-doh" element={<AdminDoh/>}></Route>
          <Route path="admin-competency-framework" element={<AdminCompetencyFramework/>}></Route>
          <Route path="admin-competency-done/:competency_id" element={<AdminCompetencyDone/>}></Route>
          <Route path="admin-competency-undone/:competency_id" element={<AdminCompetencyUndone/>}></Route>
          <Route path="admin-competency-done-all" element={<AdminCompetencyDoneAll/>}></Route>
          <Route path="admin-competency-undone-all" element={<AdminCompetencyUndoneAll/>}></Route>
          <Route path="admin-create-event" element={<AdminAddEvents/>}></Route>
          <Route path="admin-edit-event/:event_id" element={<AdminEditEvents/>}></Route>
          <Route path="admin-events" element={<AdminEvents/>}></Route>
          <Route path="admin-event-registration/:event_id" element={<AdminEventRegistrations/>}></Route>
          <Route path="admin-applications" element={<AdminApplications/>}></Route>
          <Route path="admin-all-applications" element={<AdminAllApplications/>}></Route>
          <Route path="wizard" element={<WizardTest />}></Route>
        
        </Route>
      </Routes>
  );
};
export default Router;
