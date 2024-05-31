import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { useForm } from "react-hook-form";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import Icon from "components/icon/Icon";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, CardBody, CardTitle } from "reactstrap";
import { DataTablePagination } from "components/Component";
import moment from "moment";
import { uploadConcession, FSDPaymentEvidence, FSDReviewSummary, MBGPaymentEvidence, MBGReview, MEGReview, MEG2Review, MEGUploadAgreement, completeApplication, MEGSendMembershipAgreement, MEG2SendESuccess } from "redux/stores/membership/applicationProcessStore"
import { megProcessMemberStatus } from "redux/stores/authorize/representative";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import Swal from "sweetalert2";
import JsPDF from "jspdf";
import html2canvas from "html2canvas";


const Export = ({ data, reportUrl }) => {
  const [modal, setModal] = useState(false);

  useEffect(() => {
    if (modal === true) {
      setTimeout(() => setModal(false), 2000);
    }
  }, [modal]);

  const newData = data.map((item, index) => {
    return ({
      "Membership ID": item?.reg_id,
      "Institution": item?.basic_details?.companyName,
      "Institution": item?.basic_details?.companyName,
      "Category": item?.internal?.category_name,
      "Address": item?.basic_details?.registeredOfficeAddress,
      "Phone number": item?.basic_details?.companyTelephoneNumber,
      "Email address": item?.basic_details?.companyEmailAddress,
      "Website": item?.basic_details?.corporateWebsiteAddress,
      "Status": item?.internal?.status_description,
      "Sign-on date": moment(item?.internal?.createdAt).format('MMM. D, YYYY HH:mm')
    })
  });

  const fileName = "data";

  const exportCSV = () => {
    const exportType = exportFromJSON.types.csv;
    exportFromJSON({ data: newData, fileName: fileName, exportType: exportType });

  };

  const exportExcel = () => {
    const exportType = exportFromJSON.types.xls;
    exportFromJSON({ data: newData, fileName: fileName, exportType: exportType });

  };

  const copyToClipboard = () => {
    setModal(true);
  };



  return (
    <React.Fragment>
      <div className="dt-export-buttons d-flex align-center">
        <div className="dt-export-title d-none d-md-inline-block">Export</div>
        <div className="dt-buttons btn-group flex-wrap">
          <CopyToClipboard text={JSON.stringify(newData)}>
            <Button className="buttons-copy buttons-html5" onClick={() => copyToClipboard()}>
              <span>Copy</span>
            </Button>
          </CopyToClipboard>{" "}
          <button className="btn btn-secondary buttons-csv buttons-html5" type="button" onClick={() => exportCSV()}>
            <span>CSV</span>
          </button>{" "}
          <button className="btn btn-secondary buttons-excel buttons-html5" type="button" onClick={() => exportExcel()}>
            <span>Excel</span>
          </button>{" "}
          <a href={reportUrl} target="_blank">
            <button className="btn btn-secondary buttons-pdf buttons-html5" type="button" title="Export To PDF">
              <span>PDF</span>
            </button>
          </a>
          {" "}
        </div>
      </div>
      <Modal isOpen={modal} className="modal-dialog-centered text-center" size="sm">
        <ModalBody className="text-center m-2">
          <h5>Copied to clipboard</h5>
        </ModalBody>
        <div className="p-3 bg-light">
          <div className="text-center">Copied {newData.length} rows to clipboard</div>
        </div>
      </Modal>
    </React.Fragment>
  );
};


const ActionTab = (props) => {

  const aUser = useUser();
  const aUserUpdate = useUserUpdate();

  const institution = props.institution
  const navigate = useNavigate();
  const [modalView, setModalView] = useState(false);

  const toggleView = () => setModalView(!modalView);


  const dispatch = useDispatch();


  useEffect(() => {

    if (aUser.is_admin_fsd()) {
      dispatch(FSDPaymentEvidence({ 'application_id': institution.internal.application_id }));
    }

    if (aUser.is_admin_mbg()) {
      dispatch(MBGPaymentEvidence({ 'application_id': institution.internal.application_id }));
    }


  }, [dispatch]);



  const askAction = (action, ar) => {

    if (action == 'memberStatus') {
      Swal.fire({
        title: "Are you sure?",
        text: "",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No",
      }).then((result) => {
        if (result.isConfirmed) {

          const formData = new FormData();
          formData.append('user_id', ar.id);
          formData.append('action', ar.member_status == 'active' ? 'suspend' : 'active');
          dispatch(megProcessMemberStatus(formData));
          setModalView(false)
          props.updateParentParent(Math.random());

        }
      });
    }



  };

  return (
    <>
      <button className="btn btn-primary btn-md" onClick={toggleView} >Details</button>

      <Modal isOpen={modalView} toggle={toggleView} size="xl">
        <ModalHeader toggle={toggleView} close={<button className="close" onClick={toggleView}><Icon name="cross" /></button>}>
          View Institution Application
        </ModalHeader>
        <ModalBody>
          <Card className="card">
            <CardBody className="card-inner">
              <CardTitle tag="h5">{`Basic Information`}</CardTitle>

              <table className="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Value</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Company Name</td>
                    <td className="text-capitalize">{`${institution?.basic_details?.companyName ?? ''}`}</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>RC Number</td>
                    <td className="text-capitalize">{`${institution?.basic_details?.rcNumber ?? ''}`}</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Registered Office Address</td>
                    <td className="text-capitalize">{`${institution?.basic_details?.registeredOfficeAddress ?? ''}`}</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Town/City</td>
                    <td className="text-capitalize">{`${institution?.basic_details?.placeOfIncorporation ?? ''}`}</td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Date of Incorporation</td>
                    <td className="text-capitalize">{`${institution?.basic_details?.dateOfIncorporation ?? ''}`}</td>
                  </tr>
                  <tr>
                    <td>6</td>
                    <td>Place of Incorporation</td>
                    <td className="text-capitalize">{`${institution?.basic_details?.placeOfIncorporation ?? ''}`}</td>
                  </tr>
                  <tr>
                    <td>7</td>
                    <td>Nature of Business</td>
                    <td className="text-capitalize">{`${institution?.basic_details?.natureOfBusiness ?? ''}`}</td>
                  </tr>
                  <tr>
                    <td>8</td>
                    <td>Company Primary Telephone Number</td>
                    <td className="text-capitalize">{`${institution?.basic_details?.companyTelephoneNumber ?? ''}`}</td>
                  </tr>
                  <tr>
                    <td>9</td>
                    <td>Company Secondary Telephone Number</td>
                    <td className="text-capitalize">{`${institution?.basic_details?.companyTelephoneNumber ?? ''}`}</td>
                  </tr>
                  <tr>
                    <td>10</td>
                    <td>Company Email Address</td>
                    <td className="text-capitalize">{`${institution?.basic_details?.companyEmailAddress ?? ''}`}</td>
                  </tr>
                  <tr>
                    <td>11</td>
                    <td>Company Website Address</td>
                    <td className="text-capitalize">{`${institution?.basic_details?.corporateWebsiteAddress ?? ''}`}</td>
                  </tr>
                  <tr>
                    <td>12</td>
                    <td>Authorised Share Capital</td>
                    <td className="text-capitalize">{`${institution?.basic_details?.authorisedShareCapital ?? ''}`}</td>
                  </tr>
                  <tr>
                    <td>13</td>
                    <td>Authorised Share Capital Currency</td>
                    <td className="text-capitalize">{`${institution?.basic_details?.authorisedShareCapitalCurrency ?? ''}`}</td>
                  </tr>

                </tbody>
              </table>
            </CardBody>

            {institution?.primary_contact_details?.applicationPrimaryContactName && <>

              <CardBody className="card-inner">
                <CardTitle tag="h5">{`Primary Contact Details`}</CardTitle>

                <table className="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>-</td>
                      <td>Primary Contact Name</td>
                      <td className="text-capitalize">{`${institution?.primary_contact_details?.applicationPrimaryContactName}`}</td>
                    </tr>
                    <tr>
                      <td>-</td>
                      <td>Primary Contact Email Address</td>
                      <td className="text-capitalize">{`${institution?.primary_contact_details?.applicationPrimaryContactEmailAddress}`}</td>
                    </tr>
                    <tr>
                      <td>-</td>
                      <td>Primary Contact Telephone</td>
                      <td className="text-capitalize">{`${institution?.primary_contact_details?.applicationPrimaryContactTelephone}`}</td>
                    </tr>


                  </tbody>
                </table>
              </CardBody>
            </>}
            <CardBody className="card-inner">
              <CardTitle tag="h5">{`Bank Details`}</CardTitle>

              <table className="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Value</th>
                  </tr>
                </thead>
                <tbody>
                  {institution?.bank_details?.bankDetailName && <>
                    <tr>
                      <td>1</td>
                      <td>Bank Detail</td>
                      <td className="text-capitalize">{`${institution?.bank_details?.bankDetailName}`}</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Bank Address</td>
                      <td className="text-capitalize">{`${institution?.bank_details?.bankDetailAddress}`}</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Bank Telephone</td>
                      <td className="text-capitalize">{`${institution?.bank_details?.bankDetailTelephone}`}</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Type Of Account</td>
                      <td className="text-capitalize">{`${institution?.bank_details?.bankDetailTypeOfAccount}`}</td>
                    </tr>
                  </>}
                  {institution?.bank_details?.bankDetailNameOne && <>

                    <tr>
                      <td>1</td>
                      <td>Bank Detail</td>
                      <td className="text-capitalize">{`${institution?.bank_details?.bankDetailNameOne}`}</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Bank Address</td>
                      <td className="text-capitalize">{`${institution?.bank_details?.bankDetailAddressOne}`}</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Bank Telephone</td>
                      <td className="text-capitalize">{`${institution?.bank_details?.bankDetailTelephoneOne}`}</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Type Of Account</td>
                      <td className="text-capitalize">{`${institution?.bank_details?.bankDetailTypeOfAccountOne}`}</td>
                    </tr>
                  </>}

                  {institution?.bank_details?.bankDetailNameTwo && <>

                    <tr>
                      <td>1</td>
                      <td>Bank Detail</td>
                      <td className="text-capitalize">{`${institution?.bank_details?.bankDetailNameTwo}`}</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Bank Address</td>
                      <td className="text-capitalize">{`${institution?.bank_details?.bankDetailAddressTwo}`}</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Bank Telephone</td>
                      <td className="text-capitalize">{`${institution?.bank_details?.bankDetailTelephoneTwo}`}</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Type Of Account</td>
                      <td className="text-capitalize">{`${institution?.bank_details?.bankDetailTypeOfAccountTwo}`}</td>
                    </tr>
                  </>}

                </tbody>
              </table>
            </CardBody>
            {institution?.bank_license_details?.bankingLicense && <>

              <CardBody className="card-inner">
                <CardTitle tag="h5">{`Bank License`}</CardTitle>

                <table className="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Banking License</td>
                      <td className="text-capitalize">{`${institution?.bank_license_details?.bankingLicense}`}</td>
                    </tr>


                  </tbody>
                </table>
              </CardBody>
            </>}

            {institution?.bank_license_details?.bankingLicense && <>

              <CardBody className="card-inner">
                <CardTitle tag="h5">{`Estimated Value Of Trade`}</CardTitle>

                <table className="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Value</th>
                    </tr>
                  </thead>
                  <tbody>
                    {/* <tr>
                      <td>1</td>
                      <td>Banking License</td>
                      <td className="text-capitalize">{`${institution?.bank_license_details?.bankingLicense}`}</td>
                    </tr> */}


                  </tbody>
                </table>
              </CardBody>
            </>}



            <CardBody className="card-inner">
              <CardTitle tag="h5">{`Disciplinary History `}</CardTitle>

              <table className="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Value</th>
                  </tr>
                </thead>
                <tbody>
                  {institution?.disciplinary_details?.chiefComplianceOfficerDisciplinary && <>
                    <tr>
                      <td>-</td>
                      <td>chiefComplianceOfficerDisciplinary</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.chiefComplianceOfficerDisciplinary}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryFive && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any Authority which may lead to such proceedings?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryFive}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryFour && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryFour}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryOne && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been convicted of any criminal offence? </td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryOne}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryThree && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryThree}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryTwo && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryTwo}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.companyDisciplinary && <>
                    <tr>
                      <td>-</td>
                      <td>companyDisciplinary</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.companyDisciplinary}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.companyDisciplinaryFour && <>
                    <tr>
                      <td>-</td>
                      <td>Has your company, or any of its affiliates, been subject to any winding up order/receivership arrangement? </td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.companyDisciplinaryFour}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.companyDisciplinaryOne && <>
                    <tr>
                      <td>-</td>
                      <td>Has the company or any of its affiliates , been denied registration or expelled from membership of any securities exchange, self-regulatory organisation (SRO) or associations?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.companyDisciplinaryOne}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.companyDisciplinaryThree && <>
                    <tr>
                      <td>-</td>
                      <td>Has your company, or any of its affiliates, ever been refused any Fidelity Bond?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.companyDisciplinaryThree}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.companyDisciplinaryTwo && <>
                    <tr>
                      <td>-</td>
                      <td>Has your membership, or that of any affiliates, in any of the institutions/associations mentioned above at any time been revoked, suspended or withdrawn?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.companyDisciplinaryTwo}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.mdceoDisciplinary && <>
                    <tr>
                      <td>-</td>
                      <td>mdceoDisciplinary</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinary}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.mdceoDisciplinaryEight && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been disqualified from acting as a Director?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinaryEight}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.mdceoDisciplinaryFive && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinaryFive}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.mdceoDisciplinaryFour && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinaryFour}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.mdceoDisciplinaryOne && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been convicted of any criminal offence?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinaryOne}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.mdceoDisciplinarySeven && <>
                    <tr>
                      <td>-</td>
                      <td>Ever had such authorisation, membership or licence (referred to above) revoked or terminated?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinarySeven}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.mdceoDisciplinarySix && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been refused authorisation or licence to carry on a trade, business or profession or to be a member of a securities exchange?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinarySix}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.mdceoDisciplinaryThree && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been a Director, partner or otherwise concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinaryThree}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.mdceoDisciplinaryTwo && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinaryTwo}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.treasureDisciplinary && <>
                    <tr>
                      <td>-</td>
                      <td>treasureDisciplinary</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.treasureDisciplinary}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.treasureDisciplinaryFive && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.treasureDisciplinaryFive}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.treasureDisciplinaryFour && <>
                    <tr>
                      <td>-</td>
                      <td>'Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.treasureDisciplinaryFour}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.treasureDisciplinaryOne && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been convicted of any criminal offence?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.treasureDisciplinaryOne}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.treasureDisciplinaryThree && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.treasureDisciplinaryThree}`}</td>
                    </tr>
                  </>}
                  {institution?.disciplinary_details?.treasureDisciplinaryTwo && <>
                    <tr>
                      <td>-</td>
                      <td>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?</td>
                      <td className="text-capitalize">{`${institution?.disciplinary_details?.treasureDisciplinaryTwo}`}</td>
                    </tr>
                  </>}


                </tbody>
              </table>
            </CardBody>

            {institution?.custodian_details?.custodianInformationName && <>
              <CardBody className="card-inner">
                <CardTitle tag="h5">{`Custodian Information`}</CardTitle>

                <table className="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <th scope="col">#</th>
                      <th scope="col">Name</th>
                      <th scope="col">Value</th>
                    </tr>
                  </thead>
                  <tbody>

                    <tr>
                      <td>1</td>
                      <td>Name</td>
                      <td className="text-capitalize">{`${institution?.custodian_details?.custodianInformationName}`}</td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td> Address</td>
                      <td className="text-capitalize">{`${institution?.custodian_details?.custodianInformationAddress}`}</td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Mobile Contact</td>
                      <td className="text-capitalize">{`${institution?.custodian_details?.custodianInformationMobileNumberOfContact}`}</td>
                    </tr>
                    <tr>
                      <td>4</td>
                      <td>Telephone</td>
                      <td className="text-capitalize">{`${institution?.custodian_details?.custodianInformationTelephone}`}</td>
                    </tr>
                  </tbody>
                </table>
              </CardBody>
            </>}

            <CardBody className="card-inner">
              <CardTitle tag="h5">{`Key Officers`}</CardTitle>

              <table className="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Reg ID</th>
                    <th scope="col">Status</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  {/* {$user_application} */}
                  {institution?.ars && institution?.ars?.map((ar, index) => (
                    <tr key={index}>
                      <th scope="row">{++index}</th>
                      <td>{ar.full_name}</td>
                      <td>{ar.email}</td>
                      <td>{ar.reg_id}</td>
                      <td>{ar.member_status == 'active' ? 'Active' : 'Suspended'}</td>
                      <td>
                        <button className="btn btn-primary btn-sm" onClick={() => askAction('memberStatus', ar)}>{ar.member_status == 'active' ? 'Suspend' : 'Reactivate'}</button>
                      </td>
                    </tr>

                  ))}
                </tbody>
              </table>
            </CardBody>

            <CardBody className="card-inner">
              <CardTitle tag="h5">{`Supporting Documents`}</CardTitle>

              <table className="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col" className="width-30">Value</th>
                  </tr>
                </thead>
                <tbody>
                  {/* {$user_application} */}
                  {institution?.required_documents && institution?.required_documents?.map((document, index) => (
                    <tr key={index}>
                      <th scope="row">{++index}</th>
                      <td>{document.description}</td>
                      <td>
                        {document.uploaded_file != null ? <>
                          <a className="btn btn-primary" href={document.file_path} target="_blank">View File </a>
                        </> : <>
                          {document.uploaded_field}
                        </>}
                      </td>
                    </tr>

                  ))}
                </tbody>
              </table>
            </CardBody>

            <CardBody className="card-inner">
              <CardTitle tag="h5">{`Payment Information`}</CardTitle>

              <table className="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Value</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>1</td>
                    <td>Invoice Number</td>
                    <td className="text-capitalize">{`${institution?.payment_information?.invoice_number}`}</td>
                  </tr>
                  <tr>
                    <td>2</td>
                    <td>Payment Reference</td>
                    <td className="text-capitalize">{`${institution?.payment_information?.reference}`}</td>
                  </tr>
                  <tr>
                    <td>3</td>
                    <td>Date of Payment</td>
                    <td className="text-capitalize">{`${institution?.payment_information?.date_paid}`}</td>
                  </tr>
                  <tr>
                    <td>4</td>
                    <td>Amount Paid</td>
                    <td className="text-capitalize">{`${institution?.payment_details?.total}`}</td>
                  </tr>
                  <tr>
                    <td>5</td>
                    <td>Concession Amount</td>
                    <td className="text-capitalize">{`${institution?.payment_details?.concession_amount}`}</td>
                  </tr>
                </tbody>
              </table>
            </CardBody>

          </Card>
        </ModalBody>
        <ModalFooter className="bg-light">
        </ModalFooter>
      </Modal>

    </>


  );
};

const AdminApplicationReportTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, reportUrl }) => {
  const complainColumn = [
    {
      name: "ID",
      selector: (row, index) => ++index,
      sortable: true,
      width: "100px",
      wrap: true
    },
    {
      name: "Membership ID",
      selector: (row) => { return (<>{`${row.reg_id}`}</>) },
      sortable: true,
      width: "auto",
      wrap: true
    },
    {
      name: "Institution Name",
      selector: (row) => { return (<>{`${row.basic_details.companyName}`}</>) },
      sortable: true,
      width: "auto",
      wrap: true
    },
    {
      name: "Category",
      selector: (row) => { return (<><p>{`${row.internal.category_name}`}</p></>) },
      sortable: true,
      width: "auto",
      wrap: true
    },
    {
      name: "Type",
      selector: (row) => { return (<><Badge color="success" className="text-uppercase">{row.internal.application_type}</Badge></>) },
      sortable: true,
      width: "auto",
      wrap: true
    },
    {
      name: "Type Status",
      selector: (row) => { return (<><Badge color="success" className="text-uppercase">{row.internal.application_type_status}</Badge></>) },
      sortable: true,
      width: "auto",
      wrap: true
    },
    // {
    //     name: "Concession",
    //     selector: (row) => { return row.internal.concession_stage == 1 ? (<><Badge color="success" className="text-uppercase">{`Concession Sent`}</Badge></>) : (<><Badge color="success" className="text-uppercase">{`Pending Concession`}</Badge></>) },
    //     sortable: true,
    //     width: "auto",
    //     wrap: true
    // },
    // {
    //     name: "Status",
    //     selector: (row) => { return (<><Badge color="success" className="text-uppercase">{row.internal.status}</Badge></>) },
    //     sortable: true,
    //     width: "auto",
    //     wrap: true
    // },
    {
      name: "Date Created",
      selector: (row) => moment(row.createdAt).format('MMM. D, YYYY HH:mm'),
      sortable: true,
      width: "auto",
      wrap: true
    }, {
      name: "Action",
      selector: (row) => (<>
        <ActionTab institution={row} updateParentParent={updateParent} />
      </>),
      width: "100px",
    }
  ];

  const [tableData, setTableData] = useState(data);
  const [searchText, setSearchText] = useState("");
  const [rowsPerPageS, setRowsPerPage] = useState(10);
  const [mobileView, setMobileView] = useState();

  useEffect(() => {
    setTableData(data)
  }, [data]);

  useEffect(() => {
    let defaultData = tableData;
    if (searchText !== "") {
      defaultData = data.filter((item) => {
        // return item.name.toLowerCase().includes(searchText.toLowerCase());
        return (Object.values(item).join('').toLowerCase()).includes(searchText.toLowerCase())
      });
      setTableData(defaultData);
    } else {
      setTableData(data);
    }
  }, [searchText]); // eslint-disable-line react-hooks/exhaustive-deps

  // function to change the design view under 1200 px
  const viewChange = () => {
    if (window.innerWidth < 960 && expandableRows) {
      setMobileView(true);
    } else {
      setMobileView(false);
    }
  };

  useEffect(() => {
    window.addEventListener("load", viewChange);
    window.addEventListener("resize", viewChange);
    return () => {
      window.removeEventListener("resize", viewChange);
    };
  }, []); // eslint-disable-line react-hooks/exhaustive-deps

  // const renderer = ({ hours, minutes, seconds, completed }) => {
  //         if (completed) {

  return (
    <div className={`dataTables_wrapper dt-bootstrap4 no-footer ${className ? className : ""}`}>
      <Row className={`justify-between g-2 ${actions ? "with-export" : ""}`}>
        <Col className="col-7 text-start" sm="4">
          <div id="DataTables_Table_0_filter" className="dataTables_filter">
            <label>
              <input
                type="search"
                className="form-control form-control-sm"
                placeholder="Search by name"
                onChange={(ev) => setSearchText(ev.target.value)}
              />
            </label>
          </div>
        </Col>
        <Col className="col-5 text-end" sm="8">
          <div className="datatable-filter">

            <div className="d-flex justify-content-end g-2">
              {actions && <Export data={data} reportUrl={reportUrl} />}
              <div className="dataTables_length" id="DataTables_Table_0_length">
                <label>
                  <span className="d-none d-sm-inline-block">Show</span>
                  <div className="form-control-select">
                    {" "}
                    <select
                      name="DataTables_Table_0_length"
                      className="custom-select custom-select-sm form-control form-control-sm"
                      onChange={(e) => setRowsPerPage(e.target.value)}
                      value={rowsPerPageS}
                    >
                      <option value="10">10</option>
                      <option value="25">25</option>
                      <option value="40">40</option>
                      <option value="50">50</option>
                    </select>{" "}
                  </div>
                </label>
              </div>
            </div>
          </div>
        </Col>
      </Row>
      <DataTable
        data={tableData}
        columns={complainColumn}
        className={className + ' customMroisDatatable'} id='customMroisDatatable'
        selectableRows={selectableRows}
        expandableRows={mobileView}
        noDataComponent={<div className="p-2">There are no records found</div>}
        sortIcon={
          <div>
            <span>&darr;</span>
            <span>&uarr;</span>
          </div>
        }
        pagination={pagination}
        paginationComponent={({ currentPage, rowsPerPage, rowCount, onChangePage, onChangeRowsPerPage }) => (
          <DataTablePagination
            customItemPerPage={rowsPerPageS}
            itemPerPage={rowsPerPage}
            totalItems={rowCount}
            paginate={onChangePage}
            currentPage={currentPage}
            onChangeRowsPerPage={onChangeRowsPerPage}
            setRowsPerPage={setRowsPerPage}
          />
        )}
      ></DataTable>
    </div>
  );

  //         } else {

  //             return (
  //                     <>
  //                         <Skeleton count={10} height={20}  style={{display: 'block',lineHeight: 2, padding: '1rem',width: 'auto',}}/>
  //                     </>

  //                 )
  //         }
  // };

  //       return (
  //               <Countdown
  //                 date={Date.now() + 5000}
  //                 renderer={renderer}
  //             />


  //         );
};

export default AdminApplicationReportTable;
