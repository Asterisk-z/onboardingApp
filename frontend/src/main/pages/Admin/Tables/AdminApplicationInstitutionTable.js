import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { useForm } from "react-hook-form";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import Icon from "components/icon/Icon";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge,  Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, CardBody, CardTitle } from "reactstrap";
import { DataTablePagination } from "components/Component";
import moment from "moment";
import {uploadConcession, FSDPaymentEvidence, FSDReviewSummary, MBGPaymentEvidence} from "redux/stores/membership/applicationProcessStore"
import { megProcessTransferUserAR } from "redux/stores/authorize/representative";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import Swal from "sweetalert2";


const Export = ({ data }) => {
    const [modal, setModal] = useState(false);

    useEffect(() => {
        if (modal === true) {
        setTimeout(() => setModal(false), 2000);
        }
    }, [modal]);

    const newData = data.map((item, index) => {
        return ({
            "IID": ++index,
            "Name": `${item.name}`,
            "Categories": item.category,
            "Total ARs": item.ars,
            "Status": `Pending Registration`,
            "Date Created": moment(item.createdAt).format('MMM. DD, YYYY HH:mm')
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
    const [modalForm, setModalForm] = useState(false);
    const [modalView, setModalView] = useState(false);
    const [modalReviewView, setModalReviewView] = useState(false);
    const [showConcession, setShowConcession] = useState(false);
    const [modalPaymentView, setModalPaymentView] = useState(false);
    const [modalViewUpdate, setModalViewUpdate] = useState(false);

    const toggleForm = () => setModalForm(!modalForm);
    const toggleReviewView = () => setModalReviewView(!modalReviewView);
    const toggleView = () => setModalView(!modalView);
    const togglePaymentView = () => setModalPaymentView(!modalPaymentView);
    const toggleConcession = () => {
        if (!showConcession) {
              Swal.fire({
                title: "Do you want to add concession?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {

                    setShowConcession(!showConcession)

                } else {

                    const postValues = new Object();
                    postValues.application_id = institution.internal.application_id;
                    const resp = dispatch(uploadConcession(postValues));
                    props.updateParentParent(Math.random());

                }
            });
            
        } 

    }
    const toggleViewUpdate = () => setModalViewUpdate(!modalViewUpdate);

    const dispatch = useDispatch();
  
  
    const latest_evidence = useSelector((state) => state?.applicationProcess?.latest_evidence) || null;
  
      useEffect(() => {

        if (aUser.is_admin_fsd()) {
          dispatch(FSDPaymentEvidence({'application_id' : institution.internal.application_id}));
        }
        
        if (aUser.is_admin_mbg()) {
          dispatch(MBGPaymentEvidence({'application_id' : institution.internal.application_id}));
        }

        
      }, [dispatch]);
  
      
    const $latest_evidence = latest_evidence ? JSON.parse(latest_evidence) : null;
    
    const askAction = (action) => {
      if(action == 'approvePaymentReview') {
          Swal.fire({
            title: "Are you sure?",
            text: "Do you want to approve payment!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes!",
            html: '<div class="flex flex-column text-left"><label htmlFor="amount">Amount</label><input type="number" id="amount" name="amount" class="form-control" required /><label htmlFor="comments">Comment</label><textarea id="comments" class="form-control" rows="4" cols="50" placeholder="Enter Comment" required></textarea></div>', // Add textarea to the alert
          }).then((result) => {
            if (result.isConfirmed) {
              const comments = document.getElementById('comments').value; // Get value from the textarea
              const amount = document.getElementById('amount').value; // Get value from the textarea
              if (comments && amount) {
                const formData = new FormData();
                formData.append('application_id', institution.internal.application_id);
                formData.append('status', 'approve');
                formData.append('comment', comments); 
                formData.append('amount_received', amount);
                dispatch(FSDReviewSummary(formData));
                updateParentParent(Math.random());
              }

            }
          });
      }
      
      if(action == 'declinePaymentReview') {
          Swal.fire({
            title: "Are you sure?",
            text: "Do you want to approve payment!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes!",
            html: '<div class="flex flex-column text-left"><label htmlFor="comments">Comment</label><textarea id="comments" class="form-control" rows="4" cols="50" placeholder="Enter Comment" required></textarea></div>', // Add textarea to the alert
          }).then((result) => {
            if (result.isConfirmed) {
              const comments = document.getElementById('comments').value; // Get value from the textarea
              if (comments) {
                const formData = new FormData();
                formData.append('application_id', institution.internal.application_id);
                formData.append('status', 'approve');
                formData.append('comment', comments); 
                dispatch(FSDReviewSummary(formData));
                updateParentParent(Math.random());
              }
            }
          });
      }
      

    };
  
  return (
    <>
        <div className="toggle-expand-content" style={{ display: "block" }}>
            <ul className="nk-block-tools g-3">
                 <li className="nk-block-tools-opt">
                    <UncontrolledDropdown direction="right">
                        <DropdownToggle className="dropdown-toggle btn btn-md" color="secondary">Action</DropdownToggle>

                        <DropdownMenu>
                            <ul className="link-list-opt">
                        
                                    <li size="xs">
                                        <DropdownItem tag="a"  onClick={toggleView} >
                                            <Icon name="eye"></Icon>
                                            <span>View Application</span>
                                        </DropdownItem>
                                    </li>
                                    {(aUser.is_admin_mbg() || aUser.is_admin_fsd()) &&
                                        <>
                                            <li size="xs">
                                                <DropdownItem tag="a"  onClick={togglePaymentView} >
                                                    <Icon name="eye"></Icon>
                                                    <span>Payment Information</span>
                                                </DropdownItem>
                                            </li>
                                        </>
                                    }


                                
                            </ul>
                        </DropdownMenu>
                    </UncontrolledDropdown>
                </li>
                

            </ul>
        </div>
       
        <Modal isOpen={modalPaymentView} toggle={togglePaymentView} size="lg">
            <ModalHeader toggle={togglePaymentView} close={<button className="close" onClick={togglePaymentView}><Icon name="cross" /></button>}>
                Payment View
            </ModalHeader>
            <ModalBody>
                  {(institution.internal.concession_stage != '1') ? <>
                        <Button onClick={toggleConcession} >Upload Concession</Button>
                    </> : 
                    (institution?.payment_information?.is_paid == '1') ? <>
                        <ul>
                            <li><span className="lead">Invoice Number : </span>{`${institution?.payment_information?.invoice_number}`}</li>
                            <li><span className="lead">Date of Payment : </span>{`${institution?.payment_information?.date_paid}`}</li>
                            <li><span className="lead">Reference : </span>{`${institution?.payment_information?.reference}`}</li>
                            {(aUser.is_admin_mbg() && $latest_evidence) && <>
                            <li><span className="lead">Amount received by FSD : </span>{`${institution?.internal?.amount_received_by_fsd}`}</li>
                            <li><span className="lead">Comment : </span>{`${institution?.fsd_review?.comment}`}</li>
                            </>}
                        </ul>
                        <div className="my-4">
                            <Button color="primary" className="mx-2">View Invoice</Button>
                            {(aUser.is_admin_fsd() && $latest_evidence) && <>
                            
                            <a className="btn btn-primary mx-2" href={$latest_evidence.proof} target="_blank">Latest evidence of payment</a>
                            <Button color="primary" className="mx-2"  onClick={toggleReviewView}>Payment Review</Button>
                            
                            </>}
                            {(aUser.is_admin_mbg() && $latest_evidence) && <>
                            
                            <a className="btn btn-primary mx-2" href={$latest_evidence.proof} target="_blank">Latest evidence of payment</a>
                            {/* <Button color="primary" className="mx-2"  onClick={toggleReviewView}>Payment Review</Button> */}
                            
                            </>}
                        </div>
                      </> : <>
                          <h5>Not Paid</h5>
                      </>}
                  
                  {showConcession && <>
                    <UploadConcession tabItem={institution} updateParentParent={props.updateParentParent} closeModel={togglePaymentView}/>
                  </>}
                  
            </ModalBody>
            <ModalFooter className="bg-light">
                <span className="sub-text">View Institutions</span>
            </ModalFooter>
        </Modal>
        
             
        <Modal isOpen={modalReviewView} toggle={toggleReviewView} size="sm">
            <ModalHeader toggle={toggleReviewView} close={<button className="close" onClick={toggleReviewView}><Icon name="cross" /></button>}>
                Payment Review
            </ModalHeader>
            <ModalBody>
                        <ul>
                            <li><span className="lead">Concession Amount : </span>{`${institution?.payment_details?.concession_amount}`}</li>
                            <li><span className="lead">Total Fee : </span>{`${institution?.payment_details?.total}`}</li>
                        </ul>
                        <div className="my-4">
                          
                            {(aUser.is_admin_fsd()) && <>
                            
                            <a className="btn btn-primary mx-2" href={institution?.payment_details?.concession_file} target="_blank">View Concession Document </a>
                                
                            <div className="my-4">
                                <Button color="primary" className="mx-2" onClick={() => askAction('approvePaymentReview')}>Approve</Button>
                                <Button color="primary" className="mx-2" onClick={() => askAction('declinePaymentReview')}>Decline</Button>
                            </div>
                            </>}
                        </div>
            </ModalBody>
            <ModalFooter className="bg-light">
                <span className="sub-text">View Institutions</span>
            </ModalFooter>
        </Modal>
       
        <Modal isOpen={modalView} toggle={toggleView} size="lg">
            <ModalHeader toggle={toggleView} close={<button className="close" onClick={toggleView}><Icon name="cross" /></button>}>
                View Institution
            </ModalHeader>
            <ModalBody>
                    {/* <Card className="card">   
                        <CardBody className="card-inner">
                            <CardTitle tag="h5">{ `${institution.firstName} ${institution.lastName} (${institution.email})` }</CardTitle>
                          
                              <ul>
                                  <li><span className="lead">Phone : </span>{`${institution.phone}`}</li>
                                  <li><span className="lead">Nationality : </span>{`${institution.nationality}`}</li>
                                  <li><span className="lead">Role : </span>{`${institution.role.name}`}</li>
                                  <li><span className="lead">Position : </span>{`${institution.position.name}`}</li>
                                  <li><span className="lead">Status : </span>{`${institution.approval_status}`}</li>
                                  <li><span className="lead">RegID : </span>{`${institution.regId}`}</li>
                                  <li><span className="lead">Institution : </span>{`${institution.institution.name}`}</li>
                              </ul>
                        </CardBody>
                    </Card> */}
            </ModalBody>
            <ModalFooter className="bg-light">
                <span className="sub-text">View Institutions</span>
            </ModalFooter>
        </Modal>
        
        <Modal isOpen={modalViewUpdate} toggle={toggleViewUpdate} size="lg">
            <ModalHeader toggle={toggleViewUpdate} close={<button className="close" onClick={toggleViewUpdate}><Icon name="cross" /></button>}>
                View Institution
            </ModalHeader>
            <ModalBody>
                    {/* <Card className="card">   
                        <CardBody className="card-inner">
                            <CardTitle tag="h5">{ `${institution.firstName} ${institution.lastName} (${institution.email})` }</CardTitle>
                          
                              <ul>
                                  <li><span className="lead">Phone : </span>{`${institution.phone}`}</li>
                                  <li><span className="lead">Nationality : </span>{`${institution.nationality}`}</li>
                                  <li><span className="lead">Role : </span>{`${institution.role.name}`}</li>
                                  <li><span className="lead">Position : </span>{`${institution.position.name}`}</li>
                                  <li><span className="lead">Status : </span>{`${institution.approval_status}`}</li>
                                  <li><span className="lead">RegID : </span>{`${institution.regId}`}</li>
                                  <li><span className="lead">Institution : </span>{`${institution.institution.name}`}</li>
                              </ul>
                        </CardBody>
                    </Card> */}
            </ModalBody>
            <ModalFooter className="bg-light">
                <span className="sub-text">View Institutions</span>
            </ModalFooter>
        </Modal>
    </>


  );
};

const UploadConcession = ({ updateParentParent, tabItem, positions, closeModel }) => {
    
    const aUser = useUser();
    const aUserUpdate = useUserUpdate();
    
    const tabItem_id = tabItem.id
    const [complainFile, setComplainFile] = useState([]);
    const [loading, setLoading] = useState(false);
    const dispatch = useDispatch();
    
    const { handleSubmit, register, watch, formState: { errors } } = useForm();

    const submitForm = async (data) => {
            
            const postValues = new Object();
              postValues.concession_amount = data.concession_amount;
              postValues.concession_file = complainFile;
              postValues.application_id = tabItem.internal.application_id;

              try {
                  setLoading(true);
                  
                  const resp = await dispatch(uploadConcession(postValues));

                  if (resp.payload?.message == "success") {
                      setTimeout(() => {
                          setLoading(false);
                          updateParentParent(Math.random())
                          closeModel()
                      }, 1000);
                  
                  } else {
                    setLoading(false);
                  }
                  
              } catch (error) {
                setLoading(false);
              }
          
        };



    
    const handleFileChange = (event) => {
		setComplainFile(event.target.files[0]);
    };
    
  
    return (
        <>
            
            <form className="content clearfix my-5" onSubmit={handleSubmit(submitForm)}  encType="multipart/form-data">
                
    
                <div className="form-group">
                    <label className="form-label" htmlFor="concession_amount">
                        Concession Amount
                    </label>
                    <div className="form-control-wrap">
                        <input type="number" id="concession_amount" className="form-control" {...register('concession_amount', { required: "This Field is required" })}  />
                        {errors.concession_amount && <span className="invalid">{ errors.concession_amount.message }</span>}
                    </div>
                </div>
                <div className="form-group">
                    <label className="form-label" htmlFor="concession_file">
                        Concession File
                    </label>
                    <div className="form-control-wrap">
                        <input type="file" id="concession_file" className="form-control" {...register('concession_file', { required: "This Field is required" })} onChange={handleFileChange}/>
                        {errors.concession_file && <span className="invalid">{ errors.concession_file.message }</span>}
                    </div>
                </div>
                <div className="form-group">
                    <Button color="primary" type="submit"  size="lg">
                        {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : "Upload Concession"}
                    </Button>
                </div>
                
          </form>
          
      </>


    );
};


const AdminInstitutionTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState }) => {
    const complainColumn = [
      {
          name: "ID",
          selector: (row, index) => ++index,
          sortable: true,
          width: "100px",
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
          name: "Institution Name",
          selector: (row) => { return (<>{`${row.basic_details.companyName}`}</>) },
          sortable: true,
          width: "auto",
          wrap: true
      },
      {
          name: "Concession",
          selector: (row) => { return row.internal.concession_stage == 1 ? (<><Badge color="success" className="text-uppercase">{`Concession Sent`}</Badge></>) : (<><Badge color="success" className="text-uppercase">{`Pending Concession`}</Badge></>) },
          sortable: true,
          width: "auto",
          wrap: true
      },
      {
          name: "Status",
          selector: (row) => { return (<><Badge color="success" className="text-uppercase">{`Application Completed`}</Badge></>) },
          sortable: true,
          width: "auto",
          wrap: true
      },
      {
          name: "Date Created",
          selector: (row) => moment(row.createdAt).format('MMM. DD, YYYY HH:mm'),
          sortable: true,
          width: "auto",
          wrap: true
      },
      {
        name: "Action",
        selector: (row) => (<>
                        <ActionTab institution={row}  updateParentParent={updateParent} />
                    </>),
        width: "100px",
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
              {actions && <Export data={data} />}
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

export default AdminInstitutionTable;
