import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import { useNavigate } from "react-router-dom";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { useForm } from "react-hook-form";
import { useDispatch, useSelector } from "react-redux";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge,  Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, CardBody, CardTitle } from "reactstrap";
import { DataTablePagination } from "components/Component";
import { userUpdateUserAR, userCancelUpdateUserAR, userProcessUpdateUserAR, userTransferUserAR } from "redux/stores/authorize/representative";
import { loadAllCategoryPositions } from "redux/stores/positions/positionStore";
import { megProcessAddUserAR } from "redux/stores/authorize/representative";
import moment from "moment";
import Icon from "components/icon/Icon";
import Swal from "sweetalert2";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';


const Export = ({ data }) => {
    const [modal, setModal] = useState(false);

    useEffect(() => {
        if (modal === true) {
        setTimeout(() => setModal(false), 2000);
        }
    }, [modal]);

    const newData = data.map((item, index) => {
        return ({
            "User ID": ++index,
            "Name": `${item.firstName} ${item.lastName}`,
            "Email": item.email,
            "Phone": item.phone,
            "Role": item.role.name,
            "Status": item.approval_status,
            "Date Created": moment(item.createdAt).format('MMM. D, YYYY HH:mm')
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

    const user_id = props.ar_user.id
    const ar_user = props.ar_user

    
    const [modalForm, setModalForm] = useState(false);
    const [modalView, setModalView] = useState(false);
    const [modalViewUpdate, setModalViewUpdate] = useState(false);

    const toggleForm = () => setModalForm(!modalForm);
    const toggleView = () => setModalView(!modalView);
    const toggleViewUpdate = () => setModalViewUpdate(!modalViewUpdate);
    
    const dispatch = useDispatch();
    const navigate = useNavigate();
    
    const { register, handleSubmit, formState: { errors }, resetField, setValue } = useForm();
    const [loading, setLoading] = useState(false);
    const [document, setDocument] = useState([]);

   
 
    
        
    const askAction = async (action) => {

        if (action == 'approve') {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, approve it!",
            }).then((result) => {
                if (result.isConfirmed) {

                    const formData = new FormData();
                    formData.append('user_id', ar_user.id);
                    formData.append('action', 'approve');
                    const resp = dispatch(megProcessAddUserAR(formData));

                    props.updateParentParent(Math.random())
                    setModalViewUpdate(false)
                    setModalView(false)

                }
            });
        }

        if (action == 'decline') {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, decline it!",
            }).then((result) => {
                if (result.isConfirmed) {

                    const formData = new FormData();
                    formData.append('user_id', ar_user.id);
                    formData.append('action', 'decline');
                    const resp = dispatch(megProcessAddUserAR(formData));

                    props.updateParentParent(Math.random())
                    setModalViewUpdate(false)
                    setModalView(false)
                }
            });
        }

    };
  
    

    // const checkValue = (value) => {
    //     console.log(parseInt(value.target.value))
    //     // parseInt(value) ? setValue(parseInt(value)) : ""
    //     if (!isNaN(parseInt(value.target.value))) {
    //         value.target.value = parseInt(value.target.value)
    //     }
    // };

    
  return (
    <>
        <div className="toggle-expand-content" style={{ display: "block" }}>
            <ul className="nk-block-tools g-3">
                 <li className="nk-block-tools-opt">
                    {(aUser.is_admin_meg() && ar_user.approval_status == 'pending') &&
                        <>
                            <UncontrolledDropdown direction="right">
                                <DropdownToggle className="dropdown-toggle btn btn-sm" color="secondary">MEG Review</DropdownToggle>

                                <DropdownMenu>
                                    <ul className="link-list-opt">
                                
                                            <li size="xs">
                                                <DropdownItem tag="a"  onClick={toggleView} >
                                                    <Icon name="eye"></Icon>
                                                    <span>AR Details</span>
                                                </DropdownItem>
                                            </li>

                                                <li size="xs">
                                                    <DropdownItem tag="a" onClick={(e) => askAction('approve')} >
                                                        <Icon name="eye"></Icon>
                                                        <span>Approve</span>
                                                    </DropdownItem>
                                                </li>
                                                <li size="xs">
                                                    <DropdownItem tag="a" onClick={(e) => askAction('decline')} >
                                                        <Icon name="eye"></Icon>
                                                        <span>Decline</span>
                                                    </DropdownItem>
                                                </li>
                                        
                                    </ul>
                                </DropdownMenu>
                            </UncontrolledDropdown>
                        </>
                    }
                </li>
                


            </ul>
        </div>
       
        <Modal isOpen={modalView} toggle={toggleView} size="lg">
            <ModalHeader toggle={toggleView} close={<button className="close" onClick={toggleView}><Icon name="cross" /></button>}>
                View AR
            </ModalHeader>
            <ModalBody>
                    <Card className="card">   
                        <CardBody className="card-inner">

                          <CardTitle tag="h5" className="text-center">
                              <img src={ar_user.img} className="rounded-xl" style={{ height: '200px', width: '200px', borderRadius: '100%' }} />
                          </CardTitle>

                          <table className="table table-striped table-bordered table-hover">
                              <thead>
                                  <tr>
                                      <th scope="col"></th>
                                      <th scope="col"></th>
                                  </tr>
                              </thead>
                              <tbody>
                                  <tr>
                                      <td>First Name</td>
                                      <td className="text-capitalize">{`${ar_user.firstName}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Last Name</td>
                                      <td className="text-capitalize">{`${ar_user.lastName}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Email</td>
                                      <td className="text-capitalize">{`${ar_user.email}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Phone</td>
                                      <td className="text-capitalize">{`${ar_user.phone}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Nationality</td>
                                      <td className="text-capitalize">{`${ar_user.nationality.toLowerCase()}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Role</td>
                                      <td className="text-capitalize">{`${ar_user.role.name.toLowerCase()}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Position</td>
                                      <td className="text-capitalize">{`${ar_user.position.name.toLowerCase()}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Status</td>
                                      <td className="text-capitalize">{`${ar_user.approval_status.toLowerCase()}`}</td>
                                  </tr>
                                  <tr>
                                      <td>RegID</td>
                                      <td className="text-capitalize">{`${ar_user.regId}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Institution</td>
                                      <td className="text-capitalize">{`${ar_user.institution?.name?.toLowerCase()}`}</td>
                                  </tr>
                                  {/* <tr>
                                      <td>Profile Photo</td>
                                      <td>{ar_user.img ? (
                                          <a size="lg" href={ar_user.img} target="_blank">
                                              <Button color="primary">
                                                  <span >{"View Image"}</span>
                                              </Button>
                                          </a>


                                      ) : `Not Uploaded`}</td>
                                  </tr> */}
                                  <tr>
                                      <td>Signature Mandate</td>
                                      <td>{ar_user.mandate_form ? (
                                          <a size="lg" href={ar_user.mandate_form} target="_blank" className="btn-primary">
                                              <Button color="primary">
                                                  <span >{"View Mandate"}</span>
                                              </Button>
                                          </a>
                                      ) : `Not Uploaded`}</td>
                                  </tr>

                              </tbody>
                          </table>
                          {(aUser.is_admin_meg() && ar_user.approval_status == 'pending') &&
                              <>
                                  <ul className="g-4 center">
                                      <li className="btn-group">
                                          <Button color="primary" size="md" onClick={(e) => askAction('approve')} ><span>Approve</span></Button>
                                      </li>
                                      <li className="btn-group">
                                          <Button className="decline" size="md" onClick={(e) => askAction('decline')} >Decline</Button>
                                      </li>
                                  </ul>
                              </>
                          }
                          
                        </CardBody>
                    </Card>
            </ModalBody>
            <ModalFooter className="bg-light">
                <span className="sub-text">View Authorised Representative</span>
            </ModalFooter>
        </Modal>
        
    </>


  );
};

const DashARTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState, positions, countries, roles, authorizers, pending }) => {
    const authRepColumn = [
    {
        name: "User ID",
        selector: (row, index) => ++index,
        sortable: true,
        width: "100px",
        wrap: true
    },
    {
        name: "Name",
        selector: (row) => (`${row.firstName} ${row.lastName}`),
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
        name: "Email",
        selector: (row) => (`${row.email} `),
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
        name: "Phone",
        selector: (row) => (`${row.phone}`),
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
        name: "Role",
        selector: (row) => { return (<><Badge color="success">{`${row.role.name}`}</Badge></>) },
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
        name: "Status",
        selector: (row) => { return (<><Badge color="success" className="text-uppercase">{`${row.approval_status}`}</Badge></>) },
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
        name: "Date Created",
        selector: (row) => moment(row.createdAt).format('MMM. D, YYYY HH:mm'),
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
        name: "Action",
        selector: (row) => (<>
                        <ActionTab ar_user={row} updateParentParent={updateParent} pending={pending} />
                    </>),
        width: "150px",
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
                            columns={authRepColumn}
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
            // } else {

            //     return (
            //             <>
            //                 <Skeleton count={20} height={30}  style={{display: 'block',lineHeight: 2, padding: '1rem',width: 'auto',}}/>
            //             </>
                        
            //         )
            // }
    // };
    
        //   return (
        //           <Countdown
        //             date={Date.now() + 5000}
        //             renderer={renderer}
        //         />

                
        //     );
 


};

export default DashARTable;
