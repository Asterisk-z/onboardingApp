import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, Input, Badge, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadUserRoles } from "redux/stores/roles/roleStore";
import { loadAllCategoryPositions } from "redux/stores/positions/positionStore";
import { loadAllCountries } from "redux/stores/nationality/country";
import { userLoadUserARs, userCreateUserAR, userSearchUserARs } from "redux/stores/authorize/representative";
import { loadAllActiveAuthoriser } from "redux/stores/users/userStore";
import { loadAllSettings } from "redux/stores/settings/config";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AuthRepTable from './Tables/AuthRepTable'
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';


const AuthRepresentative = ({ drawer }) => {
        
    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const categories = authUser.user_data.institution.category ? authUser.user_data.institution.category : [];
    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    const [categoryIds, setCategoryIds] = useState(authUser.user_data.institution.category.map((cat) => cat.id));
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [sm, updateSm] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const [modelForSearchAR, setModelForSearchAR] = useState(false);
    const [parentState, setParentState] = useState('Initial state');

    const roles = useSelector((state) => state?.role?.list) || null;
    const positions = useSelector((state) => state?.position?.list) || null;
    const countries = useSelector((state) => state?.country?.list) || null;
    const authorizers = useSelector((state) => state?.user?.list) || null;
    const authorize_reps = useSelector((state) => state?.arUsers?.list) || null;
    const ar_search_result = useSelector((state) => state?.arUsers?.search_list) || null;
    const settings = useSelector((state) => state?.settings?.list) || null;

    const { register, handleSubmit, formState: { errors }, resetField, getValues } = useForm();
    const [document, setDocument] = useState([]);
    const [signatureMandate, setSignatureMandate] = useState([]);

    const toggleForm = () => setModalForm(!modalForm);
    const toggleModelForSearch = () => setModelForSearchAR(!modelForSearchAR);
     
    useEffect(() => {
      dispatch(userLoadUserARs({"approval_status" : "", "role_id": ""}));
      dispatch(loadUserRoles());
      dispatch(loadAllCountries());
      dispatch(loadAllActiveAuthoriser());
      dispatch(loadAllSettings({"config" : "mandate_form"}));
    }, [dispatch, parentState]);
   
    useEffect(() => {
        dispatch(loadAllCategoryPositions({'category_ids' : categoryIds}));
    }, [categoryIds]);

    
    useEffect(() => {
        if ($ar_search_result) {
            if ($ar_search_result.length > 0) {
                setModelForSearchAR(true);
                console.log($ar_search_result)
            } 
        }
    }, [ar_search_result]);
   
    const handleFormSubmit = async (values) => {

        const formData = new FormData();
        formData.append('first_name', values.firstName)
        formData.append('last_name', values.lastName)
        formData.append('middle_name', values.middleName)
        formData.append('position_id', values.position_id)
        formData.append('nationality', values.nationality)
        formData.append('role_id', values.role)
        formData.append('group_email', values.group_email)
        formData.append('email', values.email)
        formData.append('phone', values.phone)
        formData.append('img', values.digitalPhone[0])
        formData.append('mandate_form', values.signedMandate[0])
        
        try {
            setLoading(true);
            
            const resp = await dispatch(userCreateUserAR(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                  setLoading(false);
                  setModalForm(!modalForm)
                  resetField('firstName')
                  resetField('lastName')
                  resetField('position_id')
                  resetField('nationality')
                  resetField('role')
                  resetField('email')
                  resetField('phone')
                  setParentState(Math.random())
                }, 1000);
            
            } else {
              setLoading(false);
            }
            
      } catch (error) {
        setLoading(false);
      }

    }; 


    const $countries = countries ? JSON.parse(countries) : null;
    const $roles = roles ? JSON.parse(roles) : null;
    const $positions = positions ? JSON.parse(positions) : null;
    const $authorizers = authorizers ? JSON.parse(authorizers) : null;
    const $authorize_reps = authorize_reps ? JSON.parse(authorize_reps) : null;
    const $ar_search_result = ar_search_result ? JSON.parse(ar_search_result) : null;
    const $settings = settings ? JSON.parse(settings) : null;

    const updateParentState = (newState) => {
        setParentState(newState);
    };
    
    const updatePosition = (event) => {
        if (event.target.value) {
            setCategoryIds([event.target.value])
        }
    }
    
    const searchArFromFirstNameAndLastName = (event) => {
        // console.log(getValues('firstName') , getValues('lastName'))
        if (getValues('firstName') && getValues('lastName')) {
            dispatch(userSearchUserARs({"first_name" : getValues('firstName'), "last_name": getValues('lastName')}));
            // return
        }
    }
    // if ($ar_search_result.length > 0) {
    //     setModelForSearchAR(true);
    // } 
    const handleDificalFileChange = (event) => {
		  setDocument(event.target.files[0]);
    };
    const handleSignaturewChange = (event) => {
		  setSignatureMandate(event.target.files[0]);
    };
    
    return (
        <React.Fragment>
            <Head title="Authorised Representative"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Authorised Representatives
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" style={{ display: sm ? "block" : "none" }}>
                                    <ul className="nk-block-tools g-3">
                                        {authUser.is_ar_inputter() && <>
                                             <li className="nk-block-tools-opt">
                                                <Button color="primary">
                                                    <span onClick={toggleForm}>Add New AR</span>
                                                </Button>
                                            </li>
                                        </>}
                                        {authUser.is_ar_authorizer() && <>
                                            <li className="nk-block-tools-opt">
                                                <Button color="primary" onClick={(e) => navigate(`${process.env.PUBLIC_URL}/transfer-auth-representatives`)}>
                                                    <span>Transfer AR</span>
                                                </Button>
                                            </li>
                                            <li className="nk-block-tools-opt">
                                                <Button color="primary" onClick={(e) => navigate(`${process.env.PUBLIC_URL}/change-auth-representatives`)}>
                                                    <span>Status AR</span>
                                                </Button>
                                            </li>
                                            <li className="nk-block-tools-opt">
                                                <Button color="primary" onClick={(e) => navigate(`${process.env.PUBLIC_URL}/auth-representatives-pending`)}>
                                                    <span>Pending AR</span>
                                                </Button>
                                            </li>
                                         </>}
                                    </ul> 
                                </div>
                            </div>
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                <Modal isOpen={modelForSearchAR} toggle={toggleModelForSearch} size="xl">
                    <ModalHeader toggle={toggleModelForSearch} close={<button className="close" onClick={toggleModelForSearch}><Icon name="cross" /></button>}>
                        Authorised Representative already exist 
                    </ModalHeader>
                    <ModalBody>
                        <p>Do you want to transfer Authorised Representative?</p>
                        {/* {ar_search_result} */}
                        <table className="table table-orders">
                            <thead className="tb-odr-head">
                                <tr className="tb-odr-item">
                                    <th className="tb-odr-info">
                                        <span className="tb-odr-id">UID</span>
                                    </th>
                                    <th className="tb-odr-amount">
                                        <span className="tb-odr-total">Full Name</span>
                                    </th>
                                    <th className="tb-odr-amount">
                                        <span className="tb-odr-total">Email</span>
                                    </th>
                                    <th className="tb-odr-amount">
                                        <span className="tb-odr-total">Institution</span>
                                    </th>
                                    <th className="tb-odr-amount">
                                        <span className="tb-odr-total">Role</span>
                                    </th>
                                    <th className="tb-odr-amount">
                                        <span className="tb-odr-total">Position</span>
                                    </th>
                                    <th className="tb-odr-action">&nbsp;</th>
                                </tr>
                            </thead>
                            <tbody className="tb-odr-body">
                                {$ar_search_result && $ar_search_result.map((item) => {
                                return (
                                    <tr className="tb-odr-item" key={item.id}>
                                        <td className="tb-odr-info">
                                            <span className="tb-odr-id">{item.id}</span>
                                        </td>
                                        <td className="tb-odr-amount">
                                            <span className="tb-odr-total">{`${item.firstName} ${item.lastName}`}</span>
                                        </td>
                                        <td className="tb-odr-amount">
                                            <span className="tb-odr-total">{`${item.email}`}</span>
                                        </td>
                                        <td className="tb-odr-amount">
                                            <span className="tb-odr-total">{`${item.institution.name} `}</span>
                                        </td>
                                        <td className="tb-odr-amount">
                                            <span className="tb-odr-total">{`${item.role.name}`}</span>
                                        </td>
                                        <td className="tb-odr-amount">
                                            <span className="tb-odr-total">{`${item.position.name}`}</span>
                                        </td>
                                        <td className="tb-odr-action">
                                            <div className="tb-odr-btns d-none d-md-inline">
                                                <Button color="primary" className="btn-sm" onClick={(e) => navigate(`${process.env.PUBLIC_URL}/transfer-auth-representative/${item.id}`)}>
                                                    Transfer
                                                </Button>
                                            </div>
                                        </td>
                                    </tr>
                                );
                                })}
                            </tbody>
                        </table>
                    </ModalBody>
                    <ModalFooter className="bg-light">
                        <span className="sub-text">Authorise Representative</span>
                    </ModalFooter>
                </Modal>
                <Modal isOpen={modalForm} toggle={toggleForm} size="lg">
                    <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
                        Add Authorised Representative
                        {/* {ar_search_result} */}
                    </ModalHeader>
                    <ModalBody>
                        <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                                            
                            <Row className="gy-4">
                                <Col sm="6">
                                    <div className="form-group">
                                        <Label htmlFor="lastName" className="form-label">
                                            Surname<span style={{color:'red'}}> *</span>
                                        </Label>
                                        <div className="form-control-wrap">
                                            <input className="form-control" type="text" id="lastName" placeholder="Enter Last Name"  {...register('lastName', { required: "Last Name is Required" })} onKeyUp={searchArFromFirstNameAndLastName}/>
                                            {errors.lastName && <p className="invalid">{`${errors.lastName.message}`}</p>}
                                        </div>
                                    </div>
                                </Col>
                                <Col sm="6">
                                    <div className="form-group">
                                        <Label htmlFor="firstName" className="form-label">
                                            First Name<span style={{color:'red'}}> *</span>
                                        </Label>
                                        <div className="form-control-wrap">
                                            <input className="form-control" type="text" id="firstName" placeholder="Enter First Name" {...register('firstName', { required: "First Name is Required" })} onKeyUp={searchArFromFirstNameAndLastName}/>
                                            {errors.firstName && <p className="invalid">{`${errors.firstName.message}`}</p>}
                                        </div>
                                    </div>
                                </Col>
                                <Col sm="6">
                                    <div className="form-group">
                                        <Label htmlFor="firstName" className="form-label">
                                            Middle Name<span style={{color:'red'}}> *</span>
                                        </Label>
                                        <div className="form-control-wrap">
                                            <input className="form-control" type="text" id="middleName" placeholder="Enter Middle Name" {...register('middleName', { required: false })} />
                                            {errors.middleName && <p className="invalid">{`${errors.middleName.message}`}</p>}
                                        </div>
                                    </div>
                                </Col>
                                <Col sm="6">
                                    <div className="form-group">
                                        <Label htmlFor="nationality" className="form-label">
                                            Nationality<span style={{color:'red'}}> *</span>
                                        </Label>
                                        <div className="form-control-wrap">
                                            <div className="form-control-select">
                                                <select className="form-control form-select" {...register('nationality', { required: "Nationality is Required" })}>
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
                                            Email Address<span style={{color:'red'}}> *</span>
                                        </Label>
                                        <div className="form-control-wrap">
                                            <input className="form-control" type="email" id="email" placeholder="Enter Email Address" {...register('email', { required: "Email Address is Required" })}/>
                                            {errors.email && <p className="invalid">{`${errors.email.message}`}</p>}
                                        </div>
                                    </div>
                                </Col>
                                <Col sm="6">
                                    <div className="form-group">
                                        <Label htmlFor="phone" className="form-label">
                                            Phone Number<span style={{color:'red'}}> *</span>
                                        </Label>
                                        <div className="form-control-wrap">
                                            <input className="form-control" type="text" id="phone" placeholder="Enter Phone Number"  {...register('phone', { required: "Phone is Required" })} />
                                            {errors.phone && <p className="invalid">{`${errors.phone.message}`}</p>}
                                        </div>
                                    </div>
                                </Col>
                                <Col sm="6">
                                    <div className="form-group">
                                        <Label htmlFor="group_email" className="form-label">
                                            Group Email Address<span style={{color:'red'}}> *</span>
                                        </Label>
                                        <div className="form-control-wrap">
                                            <input className="form-control" type="email" id="group_email" placeholder="Enter Group Email Address" {...register('group_email', { required: "Group Email Address is Required" })}/>
                                            {errors.group_email && <p className="invalid">{`${errors.group_email.message}`}</p>}
                                        </div>
                                    </div>
                                </Col>
                                <Col sm="6">
                                    <div className="form-group">
                                        <Label htmlFor="position_id" className="form-label">
                                            Category<span style={{color:'red'}}> *</span>
                                        </Label>
                                        <div className="form-control-wrap">
                                            <div className="form-control-select">
                                                <select className="form-control form-select" {...register('category_type', { required: "Position is Required" })} >
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
                                            Position<span style={{color:'red'}}> *</span>
                                        </Label>
                                        <div className="form-control-wrap">
                                            <div className="form-control-select">
                                                <select className="form-control form-select" {...register('position_id', { required: "Position is Required" })}>
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
                                            Role<span style={{color:'red'}}> *</span>
                                        </Label>
                                        <div className="form-control-wrap">
                                            <div className="form-control-select">
                                                <select className="form-control form-select" {...register('role', { required: "Roles is Required" })}>
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
                                            Digital Photo<span style={{color:'red'}}> *</span>
                                        </Label>
                                        <div className="form-control-wrap">
                                             <input type="file" accept=".gif,.jpg,.jpeg,.png,.pdf" className="form-control"  {...register('digitalPhone', {  required: "Digital Photo is Required" })} onChange={handleDificalFileChange}/>
                                            {errors.digitalPhone && <p className="invalid">{`${errors.digitalPhone.message}`}</p>}
                                        </div>
                                    </div>
                                </Col>
                                <Col sm="6">
                                    <div className="form-group">
                                        <Label htmlFor="nationality" className="form-label">
                                            Signed Signature Mandate<span style={{color:'red'}}> *</span>
                                        </Label>
                                        <div className="form-control-wrap">
                                             <input type="file" accept=".gif,.jpg,.jpeg,.png,.pdf" className="form-control"  {...register('signedMandate', {  required: "Signed Mandate is Required" })} onChange={handleSignaturewChange}/>
                                            {errors.signedMandate && <p className="invalid">{`${errors.signedMandate.message}`}</p>}
                                        </div>
                                    </div>
                                </Col>
                                <Col sm="12">
                                    <div className="form-group">
                                        {/* {settings} */}
                                        {($settings && $settings.name == 'mandate_form') && <>
                                            <a  size="lg" href={$settings.value}  download="mandate_form.pdf" target="_blank" className="active btn btn-primary">
                                                {"Download Signature Mandate"}
                                            </a>
                                        </>}
                                        
                                    </div>
                                </Col>
                                <Col sm="12">
                                    <div className="form-group float-right">
                                        <Button color="primary" type="submit"  size="lg">
                                            {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : "Create"}
                                        </Button>
                                    </div>
                                </Col>
                            </Row>
                        </form>
                    </ModalBody>
                    <ModalFooter className="bg-light">
                        <span className="sub-text">Authorise Representative</span>
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>


                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        {/* <BlockTitle tag="h4">List</BlockTitle> */}
                                        {/* <p>{authorize_reps}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$authorize_reps && <AuthRepTable  updateParent={updateParentState} parentState={parentState} data={$authorize_reps} positions={$positions} countries={$countries} authorizers={$authorizers} roles={$roles}  expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AuthRepresentative;
