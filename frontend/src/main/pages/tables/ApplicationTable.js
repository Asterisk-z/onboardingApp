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
            "Role": item.role,
            "Status": item.approval_status,
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
    
    const categories = aUser.user_data.institution.category ? aUser.user_data.institution.category : [];
    const user_id = props.tabItem.id
    const tabItem = props.tabItem
    
    const $positions = props.positions
    const $countries = props.countries
    const $roles = props.roles
    const $authorizers = props.authorizers
    
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
    const [signatureMandate, setSignatureMandate] = useState([]);

    const handleFormSubmit = async (values) => {

        const formData = new FormData();
        formData.append('user_id', user_id)
        formData.append('first_name', values.firstName)
        formData.append('middle_name', values.middleName)
        formData.append('last_name', values.lastName)
        formData.append('position_id', values.position_id)
        formData.append('nationality', values.nationality)
        formData.append('role_id', values.role)
        formData.append('email', values.email)
        formData.append('ar_authoriser_id', values.ar_authoriser_id)
        formData.append('phone', values.phone)
        if (document) {
            formData.append('img', document)
        }
        try {
            setLoading(true);
            
            const resp = await dispatch(userUpdateUserAR(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                  setLoading(false);
                  setModalForm(!modalForm)
                  setInitValues({
                    firstName: tabItem.firstName,
                    lastName: tabItem.lastName,
                    email: tabItem.email,
                    phone: tabItem.phone,
                    nationality: tabItem.nationality,
                    position: tabItem.position,
                    role_id: tabItem.role.id,
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
                    <UncontrolledDropdown direction="right">
                        {aUser?.user_data?.id == tabItem.submitted_by && <>
                            <DropdownToggle className="dropdown-toggle btn btn-sm" color="secondary">Action</DropdownToggle>
                          </>}

                        <DropdownMenu>
                            <ul className="link-list-opt">
                        
                                    {/* <li size="xs">
                                        <DropdownItem tag="a"  onClick={toggleView} >
                                            <Icon name="eye"></Icon>
                                            <span>View Application</span>
                                        </DropdownItem>
                                    </li> */}

                                    {tabItem.show_form == 1 ? <>
                                        <li size="xs">
                                            <DropdownItem tag="a"  onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/application`) } >
                                                <Icon name="eye"></Icon>
                                                <span>Continue Application</span>
                                            </DropdownItem>
                                        </li>
                                    </> : <>
                                        <li size="xs">
                                            <DropdownItem tag="a"  onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/application_detail`) } >
                                                <Icon name="eye"></Icon>
                                                <span>Application Detail</span>
                                            </DropdownItem>
                                        </li>
                                    </>}
                            </ul>
                            
                        </DropdownMenu>
                    </UncontrolledDropdown>
                </li>
            </ul>
        </div>
        {/* <div className="toggle-expand-content" style={{ display: "block" }}>
            <ul className="nk-block-tools g-3">
                 <li className="nk-block-tools-opt">
                    <UncontrolledDropdown direction="right">
                        <DropdownToggle className="dropdown-toggle btn btn-sm" color="secondary">Action</DropdownToggle>

                        <DropdownMenu>
                            <ul className="link-list-opt">
                        
                                    <li size="xs">
                                        <DropdownItem tag="a"  onClick={toggleView} >
                                            <Icon name="eye"></Icon>
                                            <span>View AR</span>
                                        </DropdownItem>
                                    </li>
                                    
                                    {(ar_user.approval_status == 'approved') && <>
                                        {(!props?.pending && !tabItem.update_payload && aUser.is_ar_inputter()) &&
                                            <>
                                                <li size="xs">
                                                    <DropdownItem tag="a"  onClick={toggleForm} >
                                                        <Icon name="eye"></Icon>
                                                        <span>Update AR</span>
                                                    </DropdownItem>
                                                </li>
                                            </>
                                        }
                                    
                                        {(!props?.pending && tabItem.update_payload && aUser.is_ar_inputter()) &&
                                    
                                            <li size="xs">
                                                <DropdownItem tag="a"  onClick={(e) => askAction('cancel')} >
                                                    <Icon name="eye"></Icon>
                                                    <span>Cancel Update</span>
                                                </DropdownItem>
                                            </li>
                                        }
                                        
                                        {(tabItem.update_payload && props?.pending && aUser.is_ar_authorizer() ) &&
                                            <>
                                                <li size="xs">
                                                    <DropdownItem tag="a"  onClick={toggleViewUpdate} >
                                                        <Icon name="eye"></Icon>
                                                        <span>View Update AR</span>
                                                    </DropdownItem>
                                                </li>
                                                <li size="xs">
                                                    <DropdownItem tag="a"  onClick={(e) => askAction('approve')} >
                                                        <Icon name="eye"></Icon>
                                                        <span>Approve</span>
                                                    </DropdownItem>
                                                </li>
                                                <li size="xs">
                                                    <DropdownItem tag="a"  onClick={(e) => askAction('decline')} >
                                                        <Icon name="eye"></Icon>
                                                        <span>Decline</span>
                                                    </DropdownItem>
                                                </li>
                                            </>
                                        }
                                        
                                        {(!props?.pending && !tabItem.update_payload && aUser.is_ar_inputter()) &&
                                            <>
                                                <li size="xs" onClick={(e) => navigate(`${process.env.PUBLIC_URL}/transfer-auth-representative/${user_id}`)} >
                                                    <DropdownItem tag="a"  >
                                                        <Icon name="eye"></Icon>
                                                        <span>Transfer AR</span>
                                                    </DropdownItem>
                                                </li>
                                                <li size="xs" onClick={(e) => navigate(`${process.env.PUBLIC_URL}/change-auth-representative/${user_id}`)} >
                                                    <DropdownItem tag="a"  >
                                                        <Icon name="eye"></Icon>
                                                        <span>Change AR Status</span>
                                                    </DropdownItem>
                                                </li>
                                            </>
                                        }
                                      </>
                                    }
                                
                            </ul>
                        </DropdownMenu>
                    </UncontrolledDropdown>
                </li>
                

                    {ar_user.status == 'ONGOING' &&
                        <li className="nk-block-tools-opt" >
                            <Button color="primary" size="xs"  onClick={toggleModalCloseAsk}>
                                <span>Closed Ticket</span>
                            </Button>
                        </li>
                    }

            </ul>
        </div>
       
        <Modal isOpen={modalViewUpdate} toggle={toggleViewUpdate} size="lg">
            <ModalHeader toggle={toggleViewUpdate} close={<button className="close" onClick={toggleViewUpdate}><Icon name="cross" /></button>}>
                View Update AR
            </ModalHeader>
            <ModalBody>
                    <Card className="card">   
                        <CardBody className="card-inner">
                            <CardTitle tag="h5">{ `${ar_user.firstName} ${ar_user.lastName} (${ar_user.email})` }</CardTitle>
                            
                                <ul>
                                    <li><span className="lead">Phone : </span>{`${ar_user.phone}`}</li>
                                    <li><span className="lead">Nationality : </span>{`${ar_user.nationality}`}</li>
                                    <li><span className="lead">Role : </span>{`${ar_user.role.name}`}</li>
                                    <li><span className="lead">Position : </span>{`${ar_user.position.name}`}</li>
                                    <li><span className="lead">Status : </span>{`${ar_user.approval_status}`}</li>
                                    <li><span className="lead">RegID : </span>{`${ar_user.regId}`}</li>
                                    <li><span className="lead">Institution : </span>{`${ar_user.institution.name}`}</li>
                                </ul>
                           
                        </CardBody>
                    </Card>
            </ModalBody>
            <ModalFooter className="bg-light">
                <span className="sub-text">View Authorised Representative</span>
            </ModalFooter>
        </Modal>
        <Modal isOpen={modalView} toggle={toggleView} size="lg">
            <ModalHeader toggle={toggleView} close={<button className="close" onClick={toggleView}><Icon name="cross" /></button>}>
                View AR
            </ModalHeader>
            <ModalBody>
                    <Card className="card">   
                        <CardBody className="card-inner">
                            <CardTitle tag="h5">{ `${ar_user.firstName} ${ar_user.lastName} (${ar_user.email})` }</CardTitle>
                            
                                <ul className="gy-3">
                                    <li  className="text-capitalize"><span className="lead">Phone : </span>{`${ar_user.phone}`}</li>
                                    <li  className="text-capitalize"><span className="lead">Nationality : </span>{`${ar_user.nationality.toLowerCase()}`}</li>
                                    <li  className="text-capitalize"><span className="lead">Role : </span>{`${ar_user.role.name.toLowerCase()}`}</li>
                                    <li  className="text-capitalize"><span className="lead">Position : </span>{`${ar_user.position.name.toLowerCase()}`}</li>
                                    <li  className="text-capitalize"><span className="lead">Status : </span>{`${ar_user.approval_status.toLowerCase()}`}</li>
                                    <li  className="text-capitalize"><span className="lead">RegID : </span>{`${ar_user.regId}`}</li>
                                    <li  className="text-capitalize"><span className="lead">Institution : </span>{`${ar_user?.institution?.name}`}</li>
                                </ul>
                            
                        </CardBody>
                    </Card>
            </ModalBody>
            <ModalFooter className="bg-light">
                <span className="sub-text">View Authorised Representative</span>
            </ModalFooter>
        </Modal>
        
        <Modal isOpen={modalForm} toggle={toggleForm} size="lg">
            <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
                Update AR
            </ModalHeader>
            <ModalBody>
                <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                                    
                    <Row className="gy-4">
                        <Col sm="6">
                            <div className="form-group">
                                <Label htmlFor="lastName" className="form-label">
                                    Surname
                                </Label>
                                <div className="form-control-wrap">
                                    <input className="form-control" type="text" id="lastName" placeholder="Enter Last Name"  {...register('lastName', { required: "Surname is Required" })}  defaultValue={initValues.lastName}/>
                                    {errors.lastName && <p className="invalid">{`${errors.lastName.message}`}</p>}
                                </div>
                            </div>
                        </Col>
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
                                <Label htmlFor="middleName" className="form-label">
                                    Middle Name
                                </Label>
                                <div className="form-control-wrap">
                                    <input className="form-control" type="text" id="middleName" placeholder="Enter First Name" {...register('middleName', { required: false })} defaultValue={initValues.middleName}/>
                                    {errors.middleName && <p className="invalid">{`${errors.middleName.message}`}</p>}
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
                                    <input className="form-control"  type="text" id="phone" placeholder="Enter Last Name" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""}  {...register('phone', { required: "Phone is Required" })}  defaultValue={parseInt(initValues.phone) ? parseInt(initValues.phone) : 0}/>
                                    {errors.phone && <p className="invalid">{`${errors.phone.message}`}</p>}
                                </div>
                            </div>
                        </Col>
                        <Col sm="6">
                            <div className="form-group">
                                <Label htmlFor="email" className="form-label">
                                    Group Email Address
                                </Label>
                                <div className="form-control-wrap">
                                    <input className="form-control" type="email" id="group_email" placeholder="Enter Group Email Address" {...register('group_email', { required: "Group Email Address is Required" })}  defaultValue={initValues.group_email}/>
                                    {errors.group_email && <p className="invalid">{`${errors.group_email.message}`}</p>}
                                </div>
                            </div>
                        </Col>
                        <Col sm="6">
                        
                            <div className="form-group">
                                <Label htmlFor="position_id" className="form-label">
                                    Category
                                </Label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select" {...register('category_type', { required: "Category is Required" })} >
                                            <option value="">Select Category</option>
                                            {categories && categories?.map((category, index) => (
                                                <option key={index} value={category.id}>
                                                    {category.name}
                                                </option>
                                            ))}
                                        </select>
                                        {errors.category_type && <p className="invalid">{`${errors.category_type.message}`}</p>}
                                    </div>
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
                                    Digital Photo
                                </Label>
                                <div className="form-control-wrap">
                                    <input type="file" accept=".gif,.jpg,.jpeg,.png,.pdf" className="form-control"  {...register('digitalPhone', {  required: false })} onChange={handleDificalFileChange}/>
                                    {errors.digitalPhone && <p className="invalid">{`${errors.digitalPhone.message}`}</p>}
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
                                        {errors.ar_authoriser_id && <p className="invalid">{`${errors.ar_authoriser_id.message}`}</p>}
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
        </Modal> */}
    </>


  );
};

const AuthRepTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState, positions, countries, roles, authorizers, pending }) => {
    const authRepColumn = [
    {
        name: "User ID",
        selector: (row, index) => ++index,
        sortable: true,
        width: "100px",
        wrap: true
    },
    {
        name: "Type",
        selector: (row) => (`Application`),
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
        name: "Next Office",
        selector: (row) => (`${row.office_to_perform_next_action} `),
        sortable: true,
        width: "auto",
        wrap: true
    },
    // {
    //     name: "Phone",
    //     selector: (row) => (`${row.phone}`),
    //     sortable: true,
    //     width: "auto",
    //     wrap: true
    // },
    // {
    //     name: "Role",
    //     selector: (row) => { return (<><Badge color="success">{`${row.role}`}</Badge></>) },
    //     sortable: true,
    //     width: "auto",
    //     wrap: true
    // },
    {
        name: "Status",
        selector: (row) => { return (<><Badge color="success" className="text-uppercase">{`${row.status_description}`}</Badge></>) },
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
                        <ActionTab tabItem={row} />
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

export default AuthRepTable;