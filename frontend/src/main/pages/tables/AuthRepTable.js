import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { useForm } from "react-hook-form";
import { useDispatch, useSelector } from "react-redux";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge,  Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label } from "reactstrap";
import { DataTablePagination } from "components/Component";
import { sendComplaintFeedback, updateComplaintStatus } from "redux/stores/complaints/complaint";
import { userUpdateUserAR, userCancelUpdateUserAR, userProcessUpdateUserAR } from "redux/stores/authorize/representative";
import moment from "moment";
import Icon from "components/icon/Icon";
import { AiOutlineArrowRight } from "react-icons/ai";
import Swal from "sweetalert2";

const Export = ({ data }) => {
  const [modal, setModal] = useState(false);

  useEffect(() => {
    if (modal === true) {
      setTimeout(() => setModal(false), 2000);
    }
  }, [modal]);

  const fileName = "user-data";

  const exportCSV = () => {
    const exportType = exportFromJSON.types.csv;
    exportFromJSON({ data, fileName, exportType });
  };

  const exportExcel = () => {
    const exportType = exportFromJSON.types.xls;
    exportFromJSON({ data, fileName, exportType });
  };

  const copyToClipboard = () => {
    setModal(true);
  };

  return (
    <React.Fragment>
      <div className="dt-export-buttons d-flex align-center">
        <div className="dt-export-title d-none d-md-inline-block">Export</div>
        <div className="dt-buttons btn-group flex-wrap">
          <CopyToClipboard text={JSON.stringify(data)}>
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
          <div className="text-center">Copied {data.length} rows to clipboard</div>
        </div>
      </Modal>
    </React.Fragment>
  );
};


const SendFeedback = (props) => {
    const user_id = props.ar_user.id
    const ar_user = props.ar_user
    const $positions = props.positions
    const $countries = props.countries
    const $roles = props.roles
    const $authorizers = props.authorizers
  
    const [modalForm, setModalForm] = useState(false);
    const [modalDetail, setModalDetail] = useState(false);
    const [modalOpenAsk, setModalOpenAsk] = useState(false);
    const [modalCloseAsk, setModalCloseAsk] = useState(false);

    const toggleForm = () => setModalForm(!modalForm);
    const toggleModalDetail = () => setModalDetail(!modalForm);
    const toggleModalOpenAsk = () => setModalOpenAsk(!modalOpenAsk);
    const toggleModalCloseAsk = () => setModalCloseAsk(!modalCloseAsk);
    
    const dispatch = useDispatch();
    const { register, handleSubmit, formState: { errors }, resetField, setValue } = useForm();
    const [loading, setLoading] = useState(false);
    
    
    const handleFormSubmit = async (values) => {

        const formData = new FormData();
        formData.append('user_id', user_id)
        formData.append('first_name', values.firstName)
        formData.append('last_name', values.lastName)
        formData.append('position_id', values.position_id)
        formData.append('nationality', values.nationality)
        formData.append('role_id', values.role)
        formData.append('email', values.email)
        formData.append('ar_authoriser_id', values.ar_authoriser_id)
        formData.append('phone', values.phone)
        
        try {
            setLoading(true);
            
            const resp = await dispatch(userUpdateUserAR(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                  setLoading(false);
                  setModalForm(!modalForm)
                  setInitValues({
                    firstName: ar_user.firstName,
                    lastName: ar_user.lastName,
                    email: ar_user.email,
                    phone: ar_user.phone,
                    nationality: ar_user.nationality,
                    position: ar_user.position,
                    role_id: ar_user.role.id,
                  });
                  
                }, 1000);
                
                props.updateParentParent(Math.random())
            
            } else {
              setLoading(false);
            }
            
      } catch (error) {
        setLoading(false);
      }
    }; 

    const toggleComplainStatus = async () => {

        const user_id = props.ar_user.id
        const updateStatus = (props.ar_user.status != 'NEW') ? 'ONGOING' : 'CLOSED';
        const formData = new FormData();

        formData.append('user_id', user_id)
        formData.append('status', updateStatus)

        try {
            setLoading(true);
            
            const resp = await dispatch(updateComplaintStatus(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalOpenAsk(false)
                    setModalCloseAsk(false)
                    props.updateParentParent(Math.random())
                }, 1000);
            
            } else {
              setLoading(false);
            }
            
      } catch (error) {
        setLoading(false);
      }
    }

    const toggleModalDetailTwo = () => {
        setModalDetail(false)
    }
        
    const [initValues, setInitValues] = useState({
      firstName: ar_user.firstName,
      lastName: ar_user.lastName,
      email: ar_user.email,
      phone: ar_user.phone,
      nationality: ar_user.nationality,
      position: ar_user.position,
      role_id: ar_user.role.id,
    });

    
  const askAction = async (action) => {
    if(action == 'approve') {
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
                const resp = dispatch(userProcessUpdateUserAR(formData));

                if (resp.payload?.message == "success") {
                    setTimeout(() => {
                        props.updateParentParent(Math.random())
                    }, 1000);
                
                }
            }
        });
    }
    
    if(action == 'decline') {
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
                const resp = dispatch(userProcessUpdateUserAR(formData));

                if (resp.payload?.message == "success") {
                    setTimeout(() => {
                        props.updateParentParent(Math.random())
                    }, 1000);
                
                }
            }
        });
    }
    
    if(action == 'cancel') {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes, Cancel it!",
        }).then((result) => {
            if (result.isConfirmed) {
                
                const formData = new FormData();
                formData.append('user_id', ar_user.id);
                const resp = dispatch(userCancelUpdateUserAR(formData));

                if (resp.payload?.message == "success") {
                    setTimeout(() => {
                        props.updateParentParent(Math.random())
                    }, 1000);
                
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
                    <Button color="primary" size="xs" onClick={toggleModalDetail}>
                        <span>View</span>
                    </Button>
                </li>
                
                    {(!props?.pending) &&
                      <li className="nk-block-tools-opt">
                          <Button color="primary" size="xs" onClick={toggleForm}>
                              <span>Update AR</span>
                          </Button>
                      </li>
                    }
                    {(!props?.pending && ar_user.update_payload) &&
                      <li className="nk-block-tools-opt">
                          <Button color="primary" size="xs" onClick={(e) => askAction('cancel')} >
                              <span>Cancel Update</span>
                          </Button>
                      </li>
                    }
                    {(ar_user.update_payload && props?.pending) &&
                        <>
                      <li className="nk-block-tools-opt">
                        <UncontrolledDropdown direction="right">
                            <DropdownToggle className="dropdown-toggle btn btn-xs" color="secondary">Update</DropdownToggle>

                            <DropdownMenu>
                                <ul className="link-list-opt">
                                
                                <li>
                                    <DropdownItem tag="a" href="#links"  onClick={(e) => askAction('approve')} >
                                    <Icon name="eye"></Icon>
                                    <span>Approve</span>
                                    </DropdownItem>
                                </li>
                                <li>
                                    <DropdownItem tag="a" href="#links"  onClick={(e) => askAction('decline')} >
                                    <Icon name="eye"></Icon>
                                    <span>Decline</span>
                                    </DropdownItem>
                                </li>
                                {/* <li>
                                    <DropdownItem tag="a" href="#links" onClick={(ev) => ev.preventDefault()}>
                                    <Icon name="pen"></Icon>
                                    <span>Edit</span>
                                    </DropdownItem>
                                </li>
                                <li>
                                    <DropdownItem tag="a" href="#links" onClick={(ev) => ev.preventDefault()} >
                                    <Icon name="eye"></Icon>
                                    <span>View</span>
                                    </DropdownItem>
                                </li>
                                <li>
                                    <DropdownItem tag="a" href="#links" onClick={(ev) => ev.preventDefault()}>
                                    <Icon name="trash"></Icon>
                                    <span>Delete</span>
                                    </DropdownItem>
                                </li> */}
                                </ul>
                            </DropdownMenu>
                            </UncontrolledDropdown>
                        </li>
                        
                            {/* <li className="nk-block-tools-opt" >
                                <Button color="primary" size="xs"  onClick={toggleModalOpenAsk}>
                                    <span>Open Ticket</span>
                                </Button>
                            </li>
                            <li className="nk-block-tools-opt" >
                                <Button color="primary" size="xs"  onClick={toggleModalOpenAsk}>
                                    <span>Open Ticket</span>
                                </Button>
                            </li>                        */}
                        </>

                    }
                    {ar_user.status == 'ONGOING' &&
                        <li className="nk-block-tools-opt" >
                            <Button color="primary" size="xs"  onClick={toggleModalCloseAsk}>
                                <span>Closed Ticket</span>
                            </Button>
                        </li>
                    }

            </ul>
        </div>
        <Modal isOpen={modalOpenAsk} toggle={toggleModalOpenAsk}>
            
            <ModalBody className="modal-body-lg text-center">
                <div className="nk-modal">
                <Icon className="nk-modal-icon icon-circle icon-circle-xxl ni ni-check bg-success"></Icon>
                <h4 className="nk-modal-title">Do you want to open this complain!</h4>
                <div className="nk-modal-action">
                    <Button color="primary" size="lg" className="btn-mw" onClick={toggleComplainStatus}>
                        {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : (<span>Proceed <AiOutlineArrowRight /></span>) }
                    </Button>
                </div>
                </div>
            </ModalBody>
            <ModalFooter className="bg-light">
                <div className="text-center w-100">
                    <p>
                        Members Registration Oversight Information System (MROIS)
                    </p>
                </div>
            </ModalFooter>
        </Modal>
        <Modal isOpen={modalCloseAsk} toggle={toggleModalCloseAsk}>
            <ModalBody className="modal-body-lg text-center">
                <div className="nk-modal">
                    <Icon className="nk-modal-icon icon-circle icon-circle-xxl ni ni-check bg-success"></Icon>
                <h4 className="nk-modal-title">Do you want to close this complain!</h4>
                <div className="nk-modal-text">

                </div>
                <div className="nk-modal-action">
                    <Button color="primary" size="lg" className="btn-mw" onClick={toggleComplainStatus}>
                        {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : (<span>Proceed <AiOutlineArrowRight /></span>) }
                    </Button>
                </div>
                </div>
            </ModalBody>
            <ModalFooter className="bg-light">
                <div className="text-center w-100">
                    <p>
                        Members Registration Oversight Information System (MROIS)
                    </p>
                </div>
            </ModalFooter>
        </Modal>
        <Modal isOpen={modalForm} toggle={toggleForm} size="lg">
            <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
                Update 
            </ModalHeader>
            <ModalBody>
                <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                                    
                    <Row className="gy-4">
                        <Col sm="6">
                            <div className="form-group">
                                <Label htmlFor="firstName" className="form-label">
                                    First Name
                                </Label>
                                <div className="form-control-wrap">
                                    <input className="form-control" type="text" id="firstName" placeholder="Enter First Name" {...register('firstName', { required: "First Name is Required" })} defaultValue={initValues.firstName}/>
                                    {errors.firstName && <p className="invalid">{`${errors.firstName.message}`}</p>}
                                </div>
                            </div>
                        </Col>
                        <Col sm="6">
                            <div className="form-group">
                                <Label htmlFor="lastName" className="form-label">
                                    Last Name
                                </Label>
                                <div className="form-control-wrap">
                                    <input className="form-control" type="text" id="lastName" placeholder="Enter Last Name"  {...register('lastName', { required: "Last Name is Required" })}  defaultValue={initValues.lastName}/>
                                    {errors.lastName && <p className="invalid">{`${errors.lastName.message}`}</p>}
                                </div>
                            </div>
                        </Col>
                        <Col sm="6">
                            <div className="form-group">
                                <Label htmlFor="email" className="form-label">
                                    Email Address
                                </Label>
                                <div className="form-control-wrap">
                                    <input className="form-control" type="email" id="email" placeholder="Enter Email Address" {...register('email', { required: "Email Address is Required" })}  defaultValue={initValues.email}/>
                                    {errors.email && <p className="invalid">{`${errors.email.message}`}</p>}
                                </div>
                            </div>
                        </Col>
                        <Col sm="6">
                            <div className="form-group">
                                <Label htmlFor="phone" className="form-label">
                                    Phone Number
                                </Label>
                                <div className="form-control-wrap">
                                    <input className="form-control" type="text" id="phone" placeholder="Enter Last Name"  {...register('phone', { required: "Phone is Required" })}  defaultValue={initValues.phone}/>
                                    {errors.phone && <p className="invalid">{`${errors.phone.message}`}</p>}
                                </div>
                            </div>
                        </Col>
                        <Col sm="6">
                            <div className="form-group">
                                <Label htmlFor="position_id" className="form-label">
                                    Position
                                </Label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select" {...register('position_id', { required: "Position is Required" })}  defaultValue={initValues.position}>
                                            <option value="">Select Position</option>
                                            {$positions && $positions?.map((position, index) => (
                                                <option key={index} value={position.id}>
                                                    {position.name}
                                                </option>
                                            ))}
                                        </select>
                                        {errors.position_id && <p className="invalid">{`${errors.position_id.message}`}</p>}
                                    </div>
                                </div>
                            </div>
                        </Col>
                        <Col sm="6">
                            <div className="form-group">
                                <Label htmlFor="nationality" className="form-label">
                                    Nationality
                                </Label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select" {...register('nationality', { required: "Nationality is Required" })}  defaultValue={initValues.nationality}>
                                            <option value="">Select Nationality</option>
                                            {$countries && $countries?.map((country, index) => (
                                                <option key={index} value={country.code}>
                                                    {country.name}
                                                </option>
                                            ))}
                                        </select>
                                        {errors.nationality && <p className="invalid">{`${errors.nationality.message}`}</p>}
                                    </div>
                                </div>
                            </div>
                        </Col>
                        <Col sm="6">
                            <div className="form-group">
                                <Label htmlFor="nationality" className="form-label">
                                    Role
                                </Label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select" {...register('role', { required: "Roles is Required" })}  defaultValue={initValues.role}>
                                            <option value="">Select Role</option>
                                            {$roles && $roles?.map((role, index) => (
                                                <option key={index} value={role.id}>
                                                {role.name}
                                                </option>
                                            ))}
                                        </select>
                                        {errors.role && <p className="invalid">{`${errors.role.message}`}</p>}
                                    </div>
                                </div>
                            </div>
                        </Col>
                        <Col sm="6">
                            <div className="form-group">
                                <Label htmlFor="nationality" className="form-label">
                                    Authoriser
                                </Label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select" {...register('ar_authoriser_id', { required: "Authoriser is Required" })}>
                                            <option value="">Select Authoriser</option>
                                            {$authorizers && $authorizers?.map((authorizer, index) => user_id != authorizer.id ? (
                                                <option key={index} value={authorizer.id}>
                                                {`${authorizer.first_name} ${authorizer.last_name} ( ${authorizer.email} )`}
                                                </option>
                                            ): "")}
                                        </select>
                                        {errors.role && <p className="invalid">{`${errors.role.message}`}</p>}
                                    </div>
                                </div>
                            </div>
                        </Col>
                        <Col sm="12">
                            <div className="form-group">
                                <Button color="primary" type="submit"  size="lg">
                                    {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : "Update"}
                                </Button>
                            </div>
                        </Col>
                    </Row>
                </form>
            </ModalBody>
            <ModalFooter className="bg-light">
                <span className="sub-text">Update Authorised Representative</span>
            </ModalFooter>
        </Modal> 
        <Modal isOpen={modalDetail} toggle={toggleModalDetail}>
            <ModalHeader toggle={toggleModalDetailTwo} close={<button className="close" onClick={toggleModalDetailTwo}> <Icon name="cross" /></button> } >
                    View
            </ModalHeader>
            <ModalBody className="modal-body-xl">
                <div className="nk-modal">
                    <h6 className="title">User: {ar_user.user_id}</h6>
                    <h6 className="title">Type: {ar_user.complaint_type_id}</h6>
                    <p>
                        {ar_user.body}
                    </p>
                    <p>
                        {ar_user.documment}
                    </p>
                    <h6 className="title">Comments:</h6>
                      {/* {complaint.comment.length > 1 && complaint.comment?.map((comment, index) => (
                          <p key={index}>{comment.comment}<br/>{ moment(comment.createdAt).format('MMM. DD, YYYY HH:mm') }</p>))} */}
                </div>
            </ModalBody>
            <ModalFooter className="bg-light">
                <div className="text-center w-100">
                    <p>
                        Members Registration Oversight Information System (MROIS)
                    </p>
                </div>
            </ModalFooter>
        </Modal>
    </>


  );
};

const AuthRepTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState, positions, countries, roles, authorizers, pending }) => {
    const authRepColumn = [
    {
        name: "User ID",
        selector: (row) => row.id,
        sortable: true,
    },
    {
        name: "Name",
        selector: (row) => (`${row.firstName} ${row.lastName}`),
        sortable: true,
    },
    {
        name: "Email",
        selector: (row) => (`${row.email}`),
        sortable: true,
    },
    {
        name: "Phone",
        selector: (row) => (`${row.phone}`),
        sortable: true,
    },
    {
        name: "Role",
        selector: (row) => { return (<><Badge color="success">{`${row.role.name}`}</Badge></>) },
        sortable: true,
        // hide: "sm",
    },
    {
        name: "Date Created",
        selector: (row) => moment(row.createdAt).format('MMM. DD, YYYY HH:mm'),
        sortable: true,
        hide: "md",
    },
    {
        name: "Action",
        selector: (row) => (<>
                        <SendFeedback ar_user={row} positions={positions} countries={countries} roles={roles} authorizers={authorizers} updateParentParent={updateParent} pending={pending} />
                    </>),
        sortable: true,
        hide: "md",
    },
    ];
  const [tableData, setTableData] = useState(data);
  const [searchText, setSearchText] = useState("");
  const [rowsPerPageS, setRowsPerPage] = useState(10);
  const [mobileView, setMobileView] = useState();

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
};

export default AuthRepTable;
