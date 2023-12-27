import React, { useLayoutEffect } from "react";
import { Routes,Route, useLocation } from "react-router-dom";
import { CustomerProvider } from "../pages/panel/e-commerce/customer/CustomerContext";
import { ProductContextProvider } from "../pages/pre-built/products/ProductContext";
import { UserContextProvider } from "../pages/pre-built/user-manage/UserContext";

import Homepage from "../pages/Homepage";
import Sales from "../pages/Sales";
import Analytics from "../pages/Analytics";

import EcomOrder from "../pages/panel/e-commerce/order/OrderDefault";
import EcomSupport from "../pages/panel/e-commerce/support/Messages";
import EcomProducts from "../pages/panel/e-commerce/product/ProductList";
import EcomCustomer from "../pages/panel/e-commerce/customer/CustomerList";
import EcomCustomerDetails from "../pages/panel/e-commerce/customer/CustomerDetails";
import EcomIntegration from "../pages/panel/e-commerce/integration/Integration";
import EcomSettings from "../pages/panel/e-commerce/settings/Settings";
import EcomDashboard from "../pages/panel/e-commerce/index";

import Component from "../pages/components/Index";
import Accordian from "../pages/components/Accordions";
import Alerts from "../pages/components/Alerts";
import Avatar from "../pages/components/Avatar";
import Badges from "../pages/components/Badges";
import Breadcrumbs from "../pages/components/Breadcrumbs";
import ButtonGroup from "../pages/components/ButtonGroup";
import Buttons from "../pages/components/Buttons";
import Cards from "../pages/components/Cards";
import Carousel from "../pages/components/Carousel";
import Dropdowns from "../pages/components/Dropdowns";
import FormElements from "../pages/components/forms/FormElements";
import FormLayouts from "../pages/components/forms/FormLayouts";
import FormValidation from "../pages/components/forms/FormValidation";
import DataTablePage from "../pages/components/table/DataTable";
import DateTimePicker from "../pages/components/forms/DateTimePicker";
import CardWidgets from "../pages/components/widgets/CardWidgets";
import ChartWidgets from "../pages/components/widgets/ChartWidgets";
import RatingWidgets from "../pages/components/widgets/RatingWidgets";
import SlickPage from "../pages/components/misc/Slick";
import SweetAlertPage from "../pages/components/misc/SweetAlert";
import BeautifulDnd from "../pages/components/misc/BeautifulDnd";
import DualListPage from "../pages/components/misc/DualListbox";
import GoogleMapPage from "../pages/components/misc/GoogleMap";
import Modals from "../pages/components/Modals";
import Pagination from "../pages/components/Pagination";
import Popovers from "../pages/components/Popovers";
import Progress from "../pages/components/Progress";
import Spinner from "../pages/components/Spinner";
import Tabs from "../pages/components/Tabs";
import Toast from "../pages/components/Toast";
import Tooltips from "../pages/components/Tooltips";
import Typography from "../pages/components/Typography";
import CheckboxRadio from "../pages/components/forms/CheckboxRadio";
import AdvancedControls from "../pages/components/forms/AdvancedControls";
import InputGroup from "../pages/components/forms/InputGroup";
import FormUpload from "../pages/components/forms/FormUpload";
import NumberSpinner from "../pages/components/forms/NumberSpinner";
import NouiSlider from "../pages/components/forms/nouislider";
import WizardForm from "../pages/components/forms/WizardForm";
import WizardTest from "../pages/components/forms/WizardTest";
import UtilBorder from "../pages/components/UtilBorder";
import UtilColors from "../pages/components/UtilColors";
import UtilDisplay from "../pages/components/UtilDisplay";
import UtilEmbeded from "../pages/components/UtilEmbeded";
import UtilFlex from "../pages/components/UtilFlex";
import UtilOthers from "../pages/components/UtilOthers";
import UtilSizing from "../pages/components/UtilSizing";
import UtilSpacing from "../pages/components/UtilSpacing";
import UtilText from "../pages/components/UtilText";

import Blank from "../pages/others/Blank";
import Faq from "../pages/others/Faq";
import Regularv1 from "../pages/others/Regular-1";
import Regularv2 from "../pages/others/Regular-2";
import Terms from "../pages/others/Terms";
import BasicTable from "../pages/components/table/BasicTable";
import SpecialTablePage from "../pages/components/table/SpecialTable";
import ChartPage from "../pages/components/charts/Charts";
import EmailTemplate from "../pages/components/email-template/Email";
import NioIconPage from "../pages/components/crafted-icons/NioIcon";
import SVGIconPage from "../pages/components/crafted-icons/SvgIcons";

import ProjectCardPage from "../pages/pre-built/projects/ProjectCard";
import ProjectListPage from "../pages/pre-built/projects/ProjectList";
import UserListDefault from "../pages/pre-built/user-manage/UserListDefault";
import UserListRegular from "../pages/pre-built/user-manage/UserListRegular";
import UserContactCard from "../pages/pre-built/user-manage/UserContactCard";
import UserDetails from "../pages/pre-built/user-manage/UserDetailsRegular";
import UserListCompact from "../pages/pre-built/user-manage/UserListCompact";
import UserProfileRegular from "../pages/pre-built/user-manage/UserProfileRegular";
import UserProfileSetting from "../pages/pre-built/user-manage/UserProfileSetting";
import UserProfileNotification from "../pages/pre-built/user-manage/UserProfileNotification";
import UserProfileActivity from "../pages/pre-built/user-manage/UserProfileActivity";
import OrderDefault from "../pages/pre-built/orders/OrderDefault";
import OrderRegular from "../pages/pre-built/orders/OrderRegular";
import OrderSales from "../pages/pre-built/orders/OrderSales";
import KycListRegular from "../pages/pre-built/kyc-list-regular/KycListRegular";
import KycDetailsRegular from "../pages/pre-built/kyc-list-regular/kycDetailsRegular";
import ProductCard from "../pages/pre-built/products/ProductCard";
import ProductList from "../pages/pre-built/products/ProductList";
import ProductDetails from "../pages/pre-built/products/ProductDetails";
import InvoiceList from "../pages/pre-built/invoice/InvoiceList";
import InvoiceDetails from "../pages/pre-built/invoice/InvoiceDetails";
import InvoicePrint from "../pages/pre-built/invoice/InvoicePrint";
import PricingTable from "../pages/pre-built/pricing-table/PricingTable";
import GalleryPreview from "../pages/pre-built/gallery/GalleryCardPreview";
import ReactToastify from "../pages/components/misc/ReactToastify";

import AppMessages from "../pages/app/messages/Messages";
import Chat from "../pages/app/chat/ChatContainer";
import Kanban from "../pages/app/kanban/Kanban";
import FileManager from "../pages/app/file-manager/FileManager";
import FileManagerFiles from "../pages/app/file-manager/FileManagerFiles";
import FileManagerShared from "../pages/app/file-manager/FileManagerShared";
import FileManagerStarred from "../pages/app/file-manager/FileManagerStarred";
import FileManagerRecovery from "../pages/app/file-manager/FileManagerRecovery";
import FileManagerSettings from "../pages/app/file-manager/FileManagerSettings";
import Inbox from "../pages/app/inbox/Inbox";
import Calender from "../pages/app/calender/Calender";
import JsTreePreview from "../pages/components/misc/JsTree";
import QuillPreview from "../pages/components/forms/rich-editor/QuillPreview";
import TinymcePreview from "../pages/components/forms/rich-editor/TinymcePreview";
import KnobPreview from "../pages/components/charts/KnobPreview";

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
