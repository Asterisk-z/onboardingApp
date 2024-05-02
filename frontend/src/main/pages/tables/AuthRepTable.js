import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import { useNavigate } from "react-router-dom";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { useForm } from "react-hook-form";
import { useDispatch, useSelector } from "react-redux";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge,  Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, CardBody, CardTitle } from "reactstrap";
import { DataTablePagination, UserAvatar } from "components/Component";
import { userUpdateUserAR, userCancelUpdateUserAR, userProcessUpdateUserAR, userTransferUserAR } from "redux/stores/authorize/representative";
import { loadAllCategoryPositions, clearPosition } from "redux/stores/positions/positionStore";
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
    const categories = aUser.user_data.institution.category ? aUser.user_data.institution.category : [];
    const user_id = props.ar_user.id
    const ar_user = props.ar_user
    const [categoryIds, setCategoryIds] = useState([]);
    // const [categoryIds, setCategoryIds] = useState(aUser.user_data.institution.category.map((cat) => cat.id));

    // const $positions = props.positions
    const $countries = props.countries
    const $all_positions = props.positions
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
    
    const { register, handleSubmit, formState: { errors }, resetField, setValue, getValues } = useForm();
    const [loading, setLoading] = useState(false);
    const [document, setDocument] = useState([]);

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
 
    const [initValues, setInitValues] = useState({
      firstName: ar_user.firstName,
      lastName: ar_user.lastName,
      email: ar_user.email,
        phone: ar_user.phone,
        middleName: ar_user.middleName,
        nationality: ar_user.nationality_code,
        group_email: ar_user.group_email,
      position: ar_user.position.id,
      role_id: ar_user.role.id,
        img: ar_user.img
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
                    setModalViewUpdate(false)
                            props.updateParentParent(Math.random())
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
                    setModalViewUpdate(false)

                            props.updateParentParent(Math.random())
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
                    setModalViewUpdate(false)

                            props.updateParentParent(Math.random())
                }
            });
        }

    };
  
    
    const handleDificalFileChange = (event) => {
		  setDocument(event.target.files[0]);
    };

    const [myApplicationCategoryIds, setMyApplicationCategoryIds] = useState(categoryIds)
    const positions = useSelector((state) => state?.position?.list) || null;
    // $all_positions
    useEffect(() => {
        if (myApplicationCategoryIds.length > 0) {
            const postValues = new Object();
            postValues.category_ids = myApplicationCategoryIds;
            dispatch(loadAllCategoryPositions(postValues));
        } 
        
    }, [myApplicationCategoryIds]);

    const $positions = myApplicationCategoryIds.length > 0  ? (positions ? JSON.parse(positions) : null) : ($all_positions ? $all_positions?.filter(item => item.id == ar_user.position.id) : null);

    const updatePositionList = (event) => {
        setMyApplicationCategoryIds([event.target.value]);
    }

    const checkValue = (value) => {
        // setMyApplicationCategoryIds([event.target.value]);
        console.log((JSON.parse(value)).phone)
    }

  return (
    <>
        <div className="toggle-expand-content" style={{ display: "block" }}>
            {!props?.home && 
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
                                            {(!props?.pending && !ar_user.update_payload && aUser.is_ar_inputter()) &&
                                                <>
                                                    <li size="xs">
                                                        <DropdownItem tag="a"  onClick={toggleForm} >
                                                            <Icon name="eye"></Icon>
                                                            <span>Edit</span>
                                                        </DropdownItem>
                                                    </li>
                                                </>
                                            }
                                        
                                            {(!props?.pending && ar_user.update_payload && aUser.is_ar_inputter()) &&
                                        
                                                <li size="xs">
                                                    <DropdownItem tag="a"  onClick={(e) => askAction('cancel')} >
                                                        <Icon name="eye"></Icon>
                                                        <span>Cancel Update</span>
                                                    </DropdownItem>
                                                </li>
                                            }
                                            
                                            {(ar_user.update_payload && props?.pending && aUser.is_ar_authorizer() ) &&
                                                <>
                                                    <li size="xs">
                                                        <DropdownItem tag="a"  onClick={toggleViewUpdate} >
                                                            <Icon name="eye"></Icon>
                                                            <span>View Update AR</span>
                                                        </DropdownItem>
                                                    </li>
                                                    {/* <li size="xs">
                                                        <DropdownItem tag="a" >
                                                            <Icon name="eye"></Icon>
                                                            <span>Approve</span>
                                                        </DropdownItem>
                                                    </li>
                                                    <li size="xs">
                                                        <DropdownItem tag="a">
                                                            <Icon name="eye"></Icon>
                                                            <span>Decline</span>
                                                        </DropdownItem>
                                                    </li> */}
                                                </>
                                            }
                                            
                                            {(!props?.pending && !ar_user.update_payload && aUser.is_ar_inputter()) &&
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
                                                            <span>Deactivate/Activate AR</span>
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

                </ul>
            }

        </div>
       
        <Modal isOpen={modalViewUpdate} toggle={toggleViewUpdate} size="lg">
            <ModalHeader toggle={toggleViewUpdate} close={<button className="close" onClick={toggleViewUpdate}><Icon name="cross" /></button>}>
                View Update AR
            </ModalHeader>
              <ModalBody>
                  <Card className="card">
                      <CardBody className="card-inner">
                          <CardTitle tag="h5" className="text-center">
                              <img src={ar_user.img} className="rounded-xl" style={{ height: '200px', width: '200px', borderRadius: '100%' }} />
                          </CardTitle>
                          <CardTitle tag="h5">{`Initial AR Information`}</CardTitle>

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

                              </tbody>
                          </table>
                          {/* </CardText> */}
                      </CardBody>
                  </Card>
                    <Card className="card">   
                        <CardBody className="card-inner">
                          <CardTitle tag="h5">{`Update AR Information` }</CardTitle>
                          {/* <CardText> */}

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
                                      <td className="text-capitalize">{`${(JSON.parse(ar_user.update_payload))?.first_name}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Last Name</td>
                                      <td className="text-capitalize">{`${(JSON.parse(ar_user.update_payload))?.last_name}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Middle Name</td>
                                      <td className="text-capitalize">{`${(JSON.parse(ar_user.update_payload))?.middle_name}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Email</td>
                                      <td className="text-capitalize">{`${(JSON.parse(ar_user.update_payload))?.email}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Phone</td>
                                      <td className="text-capitalize">{`${(JSON.parse(ar_user.update_payload))?.phone}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Role</td>
                                      <td className="text-capitalize">{`${(JSON.parse(ar_user.update_payload))?.role?.name?.toLowerCase()}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Position</td>
                                      <td className="text-capitalize">{`${(JSON.parse(ar_user.update_payload))?.position?.name?.toLowerCase()}`}</td>
                                  </tr>
                                  <tr>
                                      <td>Institution</td>
                                      <td className="text-capitalize">{`${ar_user.institution?.name?.toLowerCase()}`}</td>
                                  </tr>

                              </tbody>
                          </table>
                          <div className="float-end">
                              <button className="btn  btn-primary float-end m-2"  onClick={(e) => askAction('approve')}>Approve</button>
                              <button className="btn  btn-secondary float-end m-2"  onClick={(e) => askAction('decline')} >Decline</button>
                          </div>
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
                                      <td className="text-capitalize">{`${ar_user.nationality.toLowerCase() }`}</td>
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
                            {/* </CardText> */}
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
                        <Col sm="12" className="text-center">

                              {/* <div className="user-avatar size-xl" size='xl'> */}
                              <img src={initValues.img} className="rounded-xl" style={{ height: '200px', width: '200px', borderRadius: '100%' }} />
                              {/* <img src={'http://127.0.0.1:8000/storage/users/GGKTInKkMZs3bbIpA76UgeqfUOnLXfQuarSRvgIz.png'} className="rounded-lg" style={{ height: '200px', width: '200px', borderRadius: '100%' }} /> */}

                              {/* </div> */}
                        </Col>
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
                                    {/* onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""}  */}
                                    <input className="form-control"  type="text" id="phone" placeholder="Enter phone number"  {...register('phone', { required: "Phone is Required" })}  defaultValue={parseInt(initValues.phone) ? parseInt(initValues.phone) : 0}/>
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
                            {/* Not Required */}
                            <div className="form-group">
                                <Label htmlFor="position_id" className="form-label">
                                    Category
                                </Label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select" {...register('category_type', { required: "Category is Required" })} onChange={updatePositionList} >
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
                                                    {position.is_compulsory == '1' && '*'}
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
                                          <select className="form-control form-select" {...register('role', { required: "Roles is Required" })} defaultValue={initValues.role_id}>
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
                                    Upload Digital Photo
                                </Label>
                                <div className="form-control-wrap">

                                          <input type="file" accept="image/*" className="form-control"  {...register('digitalPhone', { required: false })} onChange={handleDificalFileChange} />
                                          
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
                                              {$authorizers && $authorizers?.map((authorizer, index) => user_id != authorizer.id && authorizer.approval_status == 'approved' ? (
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
        </Modal>
    </>

  );
};

const AuthRepTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState, positions, categories, countries, roles, authorizers, pending, home }) => {
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
    // {
    //     name: "Phone",
    //     selector: (row) => (`${row.phone}`),
    //     sortable: true,
    //     width: "auto",
    //     wrap: true
    // },
    {
        name: "Position",
        selector: (row) => (`${row?.position?.name}`),
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
        name: "AR Status",
        selector: (row) => { return (<><Badge color="success" className="text-uppercase">{`${row.is_active ? 'Active' : 'Deactivated'}`}</Badge></>) },
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
        selector: (row) => {
            console.log("ferere")
            return (moment(row.createdAt).format('MMM. D, YYYY HH:mm'))
        },
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
        name: "Action",
        selector: (row) => (<>
                        <ActionTab home={home} ar_user={row} positions={positions} countries={countries} roles={roles} authorizers={authorizers} updateParentParent={updateParent} pending={pending} categories={categories}/>
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
