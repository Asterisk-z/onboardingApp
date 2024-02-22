import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Card, Spinner, Label, Input,  CardText, CardBody, CardTitle } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadUserRoles } from "redux/stores/roles/roleStore";
import { loadAllCategoryPositions } from "redux/stores/positions/positionStore";
import { loadAllCountries } from "redux/stores/nationality/country";
import {  userTransferUserAR, userViewUserAR } from "redux/stores/authorize/representative";
import { loadAllActiveAuthoriser } from "redux/stores/users/userStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';


const TransferAuthRepresentative = ({ drawer }) => {
    
    const { ar_user_id } = useParams();
    
    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const categories = authUser.user_data.institution.category ? authUser.user_data.institution.category : [];
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [categoryIds, setCategoryIds] = useState(authUser.user_data.institution.category.map((cat) => cat.id));
    const [loading, setLoading] = useState(false);
    const [sm, updateSm] = useState(false);
    const [parentState, setParentState] = useState('Initial state');
    const [document, setDocument] = useState([]);

    const user = useSelector((state) => state?.arUsers?.single_ar) || null;
    const roles = useSelector((state) => state?.role?.list) || null;
    const positions = useSelector((state) => state?.position?.list) || null;
    const countries = useSelector((state) => state?.country?.list) || null;
    const authorizers = useSelector((state) => state?.user?.list) || null;

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();



    useEffect(() => {
        dispatch(userViewUserAR({"user_id" : ar_user_id}));
        dispatch(loadUserRoles());
        dispatch(loadAllCountries());
        dispatch(loadAllActiveAuthoriser());
    }, [dispatch, parentState]);

    useEffect(() => {
        dispatch(loadAllCategoryPositions({'category_ids' : categoryIds}));
    }, [categoryIds]);

    const $countries = countries ? JSON.parse(countries) : null;
    const $roles = roles ? JSON.parse(roles) : null;
    const $positions = positions ? JSON.parse(positions) : null;
    const $authorizers = authorizers ? JSON.parse(authorizers) : null;
    const $user = user ? JSON.parse(user) : null;

    const [initValues, setInitValues] = useState({
        email: $user?.email,
        phone: $user?.phone,
        nationality: $user?.nationality,
        position: $user?.position,
        role_id: $user?.role.id,
    });    
    


    const handleFormSubmit = async (values) => {

        const formData = new FormData();
        formData.append('user_id', ar_user_id)
        // formData.append('first_name', values.firstName)
        // formData.append('middle_name', values.middleName)
        // formData.append('last_name', values.lastName)
        formData.append('position_id', values.position_id)
        formData.append('nationality', values.nationality)
        formData.append('role_id', values.role)
        formData.append('email', values.email)
        formData.append('ar_authoriser_id', values.ar_authoriser_id)
        formData.append('phone', values.phone)
        formData.append('reason', values.reason)
        if (document) {
            formData.append('img', document)
        }

        try {
            setLoading(true);
            
            const resp = await dispatch(userTransferUserAR(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                setLoading(false);
                setInitValues({
                    email: $user?.email,
                    phone: $user?.phone,
                    nationality: $user?.nationality,
                    position: $user?.position,
                    role_id: $user?.role.id,
                });
                
                }, 1000);
                
                navigate(`${process.env.PUBLIC_URL}/auth-representatives`)
                
                props.updateParentParent(Math.random())

            
            } else {
            setLoading(false);
            }
            
    } catch (error) {
        setLoading(false);
    }
    };    

  
     

    
    const handleDificalFileChange = (event) => {
		  setDocument(event.target.files[0]);
    };


    return (
        <React.Fragment>
            <Head title="Pending Authorised Representative"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Transfer Authorised Representative
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>


                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        {/* <BlockTitle tag="h4">List</BlockTitle> */}
                                        {/* <p>{authorize_reps}</p> */}
                                        {/* {<p>{user}</p>} */}
                                        <div className="toggle-wrap nk-block-tools-toggle">
                                            <div className="toggle-expand-content" style={{ display: sm ? "block" : "none" }}>
                                                <ul className="nk-block-tools g-3">
                                                    <li className="nk-block-tools-opt">
                                                        <Button color="primary">
                                                            <span onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/auth-representatives`)}>Back</span>
                                                        </Button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    
                                    <Row className="gy-4">
                                       
                                        <Col sm="6">
                                            
                                            {$user && <>
                                            
                                                 <Card className="card-bordered">   
                                                    <CardBody className="card-inner">
                                                        <CardTitle tag="h5">{ `${$user.firstName} ${$user.lastName} (${$user.email})` }</CardTitle>
                                                        {/* <CardText> */}
                                                            <ul>
                                                                <li><span className="lead">Phone : </span>{`${$user.phone}`}</li>
                                                                <li><span className="lead">Nationality : </span>{`${$user.nationality}`}</li>
                                                                <li><span className="lead">Role : </span>{`${$user.role.name}`}</li>
                                                                <li><span className="lead">Position : </span>{`${$user.position.name}`}</li>
                                                                <li><span className="lead">Status : </span>{`${$user.approval_status}`}</li>
                                                                <li><span className="lead">RegID : </span>{`${$user.regId}`}</li>
                                                                <li><span className="lead">Institution : </span>{`${$user.institution.name}`}</li>
                                                            </ul>
                                                        {/* </CardText> */}
                                                    </CardBody>
                                                </Card>
                                            
                                            </>}
                                           
                                        </Col> 
                                        <Col sm="6">
                                                 {$user &&
                                                    <>
                                                        <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                                                                        
                                                            <Row className="gy-4">
                                                                {/* <Col sm="6">
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
                                                                </Col> */}
                                                                <Col sm="6">
                                                                    <div className="form-group">
                                                                        <Label htmlFor="email" className="form-label">
                                                                            Email Address
                                                                        </Label>
                                                                        <div className="form-control-wrap">
                                                                            <input className="form-control" type="email" id="email" placeholder="Enter Email Address" {...register('email', { required: "Email Address is Required" })} defaultValue={initValues.email} />
                                                                            {errors.email && <p className="invalid">{`${errors.email.message}`}</p>}
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
                                                                        <Label htmlFor="phone" className="form-label">
                                                                            Phone Number
                                                                        </Label>
                                                                        <div className="form-control-wrap">
                                                                            <input className="form-control" type="text" id="phone" placeholder="Enter Last Name"  {...register('phone', { required: "Phone is Required" })} defaultValue={initValues.phone} />
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
                                                                                <select className="form-control form-select" {...register('position_id', { required: "Position is Required" })} defaultValue={initValues.position}>
                                                                                    <option value="">Select Position</option>
                                                                                    {$positions && $positions?.map((position, index) => (
                                                                                        <option key={index} value={position.id}>
                                                                                            {position.name}
                                                                                            {position.is_compulsory == '1' && <span style={{ color: 'red' }}>*</span>}
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
                                                                                <select className="form-control form-select" {...register('nationality', { required: "Nationality is Required" })} defaultValue={initValues.nationality}>
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
                                                                                <select className="form-control form-select" {...register('role', { required: "Roles is Required" })} defaultValue={initValues.role}>
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
                                                                                    {$authorizers && $authorizers?.map((authorizer, index) => ar_user_id != authorizer.id ? (
                                                                                        <option key={index} value={authorizer.id}>
                                                                                            {`${authorizer.first_name} ${authorizer.last_name} ( ${authorizer.email} )`}
                                                                                        </option>
                                                                                    ) : "")}
                                                                                </select>
                                                                                {errors.ar_authoriser_id && <p className="invalid">{`${errors.ar_authoriser_id.message}`}</p>}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </Col>
                                                                <Col sm="6">
                                                                    <div className="form-group">
                                                                        <Label htmlFor="nationality" className="form-label">
                                                                            Photo
                                                                        </Label>
                                                                        <div className="form-control-wrap">
                                                                            <input type="file" accept=".gif,.jpg,.jpeg,.png,.pdf" className="form-control"  {...register('digitalPhone', {  required: false })} onChange={handleDificalFileChange}/>
                                                                            {errors.digitalPhone && <p className="invalid">{`${errors.digitalPhone.message}`}</p>}
                                                                        </div>
                                                                    </div>
                                                                </Col>
                                                                <Col sm="12">
                                                                    <div className="form-group">
                                                                        <Label htmlFor="nationality" className="form-label">
                                                                            Reason
                                                                        </Label>
                                                                        <div className="form-control-wrap">
                                                                            <textarea type="text" className="form-control" {...register('reason', { required: "reason is Required" })}></textarea>
                                                                            {errors.reason && <p className="invalid">{`${errors.reason.message}`}</p>}
                                                                        </div>
                                                                    </div>
                                                                </Col>
                                                                <Col sm="12">
                                                                    <div className="form-group">
                                                                        <Button color="primary" type="submit" size="lg">
                                                                            {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Transfer"}
                                                                        </Button>
                                                                    </div>
                                                                </Col>
                                                            </Row>
                                                        </form>
                                                    </>
                                                }                           
                                        </Col> 

                                    
                                    </Row>
                  
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default TransferAuthRepresentative;
