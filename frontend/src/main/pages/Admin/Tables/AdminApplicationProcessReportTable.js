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
import { loadInstitutionApplicationReport, FSDPaymentEvidence, FSDReviewSummary, MBGPaymentEvidence, MBGReview, MEGReview, MEG2Review, MEGUploadAgreement, completeApplication, MEGSendMembershipAgreement, MEG2SendESuccess } from "redux/stores/membership/applicationProcessStore"
import { megProcessMemberStatus, megProcessInstitutionStatus } from "redux/stores/authorize/representative";
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
      // "Membership ID": item?.reg_id,
      // "Institution": item?.basic_details?.companyName,
      // // "Institution": item?.basic_details?.companyName,
      // "Category": item?.internal?.category_name,
      // "Address": item?.basic_details?.registeredOfficeAddress,
      // "Phone number": item?.basic_details?.companyTelephoneNumber,
      // "Email address": item?.basic_details?.companyEmailAddress,
      // "Website": item?.basic_details?.corporateWebsiteAddress,
      // "Type": item?.internal?.application_type,
      // "Status": item?.internal?.status_description,
      // "Sign-on date": moment(item?.internal?.createdAt).format('MMM. D, YYYY LT')
    })
  });

  const fileName = "report";

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
            <Button className="buttons-copy buttons-html5" title="Copy To Clipboard" onClick={() => copyToClipboard()}>
              <span>Copy</span>
            </Button>
          </CopyToClipboard>{" "}
          <button className="btn btn-secondary buttons-csv buttons-html5" title="Export To CSV" type="button" onClick={() => exportCSV()}>
            <span>CSV</span>
          </button>{" "}
          <button className="btn btn-secondary buttons-excel buttons-html5" title="Export To Excel" type="button" onClick={() => exportExcel()}>
            <span>Excel</span>
          </button>{" "}
          {/* <a href={reportUrl} target="_blank">
            <button className="btn btn-secondary buttons-pdf buttons-html5" type="button" title="Export To PDF">
              <span>PDF</span>
            </button>
          </a>
          {" "} */}
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
  const isReport = props.isReport
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
          formData.append('action', ar.member_status == 'active' ? 'suspend' : 'approve');
          dispatch(megProcessMemberStatus(formData));
          setModalView(false)
          props.updateParentParent(Math.random());

          dispatch(loadInstitutionApplicationReport());

        }
      });
    }


    if (action == 'institutionStatus') {
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
          formData.append('institution_id', institution?.internal?.institution_id);
          formData.append('action', institution?.internal?.institution?.status == 'Active' ? 'suspend' : 'approve');
          dispatch(megProcessInstitutionStatus(formData));
          setModalView(false)
          props.updateParentParent(Math.random());

          dispatch(loadInstitutionApplicationReport());

        }
      });
    }



  };

  return (
    <>
      <button className="btn btn-primary btn-md" onClick={toggleView} >Details</button>

    </>


  );
};

const AdminApplicationReportTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, reportUrl, isReport }) => {
  const complainColumn = [
    {
      name: "SN",
      selector: (row, index) => ++index,
      sortable: true,
      width: "auto",
      wrap: true
    },
    {
      name: "Application ID",
      selector: (row) => { return (<>{`${row.application_reg_id}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "Institution Name",
      selector: (row) => { return (<>{`${row.institution_name}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "Type",
      selector: (row) => { return (<><span className="text-capitalize">{`${row.application_type}`}</span></>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "Applicant Submission",
      selector: (row) => { return (<>{`${row.applicant_completed_application ? moment(row.applicant_completed_application).format('MMM. D, YYYY LT') : 'Not Done'}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "MBG Concession",
      selector: (row) => { return (<>{`${row.mbg_completed_concession ? moment(row.mbg_completed_concession).format('MMM. D, YYYY LT') : 'Not Done'}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "Applicant Payment",
      selector: (row) => { return (<>{`${row.applicant_made_payment ? moment(row.applicant_made_payment).format('MMM. D, YYYY LT') : 'Not Done'}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "FSD Validation",
      selector: (row) => { return (<>{`${row.fsd_validated_payment ? moment(row.fsd_validated_payment).format('MMM. D, YYYY LT') : 'Not Done'}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "MBG Approval",
      selector: (row) => { return (<>{`${row.mbg_approve_payment ? moment(row.mbg_approve_payment).format('MMM. D, YYYY LT') : 'Not Done'}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "MEG Review",
      selector: (row) => { return (<>{`${row.meg_review_application_document ? moment(row.meg_review_application_document).format('MMM. D, YYYY LT') : 'Not Done'}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "MEG2 Review",
      selector: (row) => { return (<>{`${row.meg2_approve_application_document ? moment(row.meg2_approve_application_document).format('MMM. D, YYYY LT') : 'Not Done'}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "MEG Agreement",
      selector: (row) => { return (<>{`${row.meg_send_agreement_to_applicant ? moment(row.meg_send_agreement_to_applicant).format('MMM. D, YYYY LT') : 'Not Done'}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "Applicant Agreement",
      selector: (row) => { return (<>{`${row.applicant_upload_agreement ? moment(row.applicant_upload_agreement).format('MMM. D, YYYY LT') : 'Not Done'}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "Applicant AR Addition",
      selector: (row) => { return (<>{`${row.applicant_added_all_ar ? moment(row.applicant_added_all_ar).format('MMM. D, YYYY LT') : 'Not Done'}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "MEG Agreement Execution",
      selector: (row) => { return (<>{`${row.meg_upload_signed_agreement ? moment(row.meg_upload_signed_agreement).format('MMM. D, YYYY LT') : 'Not Done'}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "MEG2 ESuccess Letter",
      selector: (row) => { return (<>{`${row.meg2_send_esuccess_letter ? moment(row.meg2_send_esuccess_letter).format('MMM. D, YYYY LT') : 'Not Done'}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },
    {
      name: "Average TAT",
      selector: (row) => { return (<>{`${row.average_time_taken ? row.average_time_taken : 'Not Applicable'}`}</>) },
      sortable: true,
      width: "200px",
      wrap: true
    },

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
