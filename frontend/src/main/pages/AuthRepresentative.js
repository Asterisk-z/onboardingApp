import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, Input} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadUserRoles } from "redux/stores/roles/roleStore";
import { loadAllPositions } from "redux/stores/positions/positionStore";
import { loadAllCountries } from "redux/stores/nationality/country";
import { userLoadUserARs, userCreateUserAR } from "redux/stores/authorize/representative";
import { loadAllActiveAuthoriser } from "redux/stores/users/userStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AuthRepTable from './Tables/AuthRepTable'


const AuthRepresentative = ({ drawer }) => {
        
    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [sm, updateSm] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const [parentState, setParentState] = useState('Initial state');

    const roles = useSelector((state) => state?.role?.list) || null;
    const positions = useSelector((state) => state?.position?.list) || null;
    const countries = useSelector((state) => state?.country?.list) || null;
    const authorizers = useSelector((state) => state?.user?.list) || null;
    const authorize_reps = useSelector((state) => state?.arUsers?.list) || null;

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const toggleForm = () => setModalForm(!modalForm);
     
    useEffect(() => {
      dispatch(userLoadUserARs({"approval_status" : "", "role_id": ""}));
      dispatch(loadUserRoles());
      dispatch(loadAllPositions());
      dispatch(loadAllCountries());
      dispatch(loadAllActiveAuthoriser());
    }, [dispatch, parentState]);
      
    const handleFormSubmit = async (values) => {

        const formData = new FormData();
        formData.append('first_name', values.firstName)
        formData.append('last_name', values.lastName)
        formData.append('position_id', values.position_id)
        formData.append('nationality', values.nationality)
        formData.append('role_id', values.role)
        formData.append('email', values.email)
        formData.append('phone', values.phone)
        
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

    const updateParentState = (newState) => {
        setParentState(newState);
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
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={toggleForm}>Create AR</span>
                                            </Button>
                                        </li>
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
                                    </ul> 
                                </div>
                            </div>
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                <Modal isOpen={modalForm} toggle={toggleForm} size="lg">
                    <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
                        Add Authorised Representative
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
                                            <input className="form-control" type="text" id="firstName" placeholder="Enter First Name" {...register('firstName', { required: "First Name is Required" })}/>
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
                                            <input className="form-control" type="text" id="lastName" placeholder="Enter Last Name"  {...register('lastName', { required: "Last Name is Required" })} />
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
                                            <input className="form-control" type="email" id="email" placeholder="Enter Email Address" {...register('email', { required: "Email Address is Required" })}/>
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
                                            <input className="form-control" type="text" id="phone" placeholder="Enter Last Name"  {...register('phone', { required: "Phone is Required" })} />
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
                                            Nationality
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
                                <Col sm="12">
                                    <div className="form-group">
                                        <Label htmlFor="nationality" className="form-label">
                                            Role
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
                                <Col sm="12">
                                    <div className="form-group">
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
                                        <div className="toggle-wrap nk-block-tools-toggle">
                                            <div className="toggle-expand-content" style={{ display: sm ? "block" : "none" }}>
                                                <ul className="nk-block-tools g-3">
                                                    <li className="nk-block-tools-opt">
                                                        <Button color="primary">
                                                            <span onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/auth-representatives-pending`)}>Pending Authorised Representative</span>
                                                        </Button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
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
