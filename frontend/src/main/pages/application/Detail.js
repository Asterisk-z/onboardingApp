import React, { useState, useRef, useEffect, forwardRef } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { BlockContent, BlockTitle, Icon } from "components/Component";
import { Steps, Step } from "react-step-builder";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge,  Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, CardBody, CardTitle, CardText } from "reactstrap";
import { HeaderLogo } from "pages/components/HeaderLogo";
import DatePicker from "react-datepicker";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import { loadApplication, completeApplication } from "redux/stores/membership/applicationStore";
import { loadInvoiceDownload } from "redux/stores/membership/applicationProcessStore";
import { uploadPaymentProof } from "redux/stores/membership/applicationProcessStore";
import moment from 'moment';
import Swal from "sweetalert2";


const ApplicantInformation = (props) => {

    const navigate = useNavigate();

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();

    const dispatch = useDispatch();

    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const [modalView, setModalView] = useState(false);
    const [uploadAgreeView, setUploadAgreeView] = useState(false);
    const [uploadView, setUploadView] = useState(false);
    
    const toggleView = () => setModalView(!modalView);
    const toggleUploadAgreeView = () => setUploadAgreeView(!uploadAgreeView);
    const toggleUploadView = () => setUploadView(!uploadView);
    
    const { reset, register, handleSubmit, formState: { errors }, setValue, clearErrors } = useForm();
    const user_application = useSelector((state) => state?.application?.user_application) || null;
    const invoice_download = useSelector((state) => state?.applicationProcess?.invoice_download) || null;

    useEffect(() => {
        dispatch(loadApplication());
    }, [dispatch, parentState]);
  
  
  

    
    const $user_application = user_application ? JSON.parse(user_application) : null;
    const $invoice_download = invoice_download ? JSON.parse(invoice_download) : null;


    useEffect(() => {
        if ($user_application) {
            dispatch(loadInvoiceDownload({ 'application_id': $user_application?.application?.id }));
        }
    }, [user_application]);
    
    
    // console.log(invoice_download)
  console.log($user_application);

  return (
    <section>
      
      <Row className="gy-2">
        <p>{ $user_application.application.status_description}</p>
        <Col md='12'>
          {$user_application?.application?.concession_stage == 1 && <>
            
              <a className="btn btn-primary mx-1" href={$invoice_download} target="_blank"> Download Invoice </a>
              {!$user_application?.application?.proof_of_payment ? <>
               <a className="btn btn-primary mx-1" href="#"  onClick={toggleView} >Make Payment </a>
                      </> : <>
               <a className="btn btn-success mx-1" href="#"  >Payment Sent</a>
                      </>}
             
          </>}
          
          {$user_application?.application?.meg2_review_stage == 1 && <>
            
              <a className="btn btn-primary mx-1" href={$user_application?.application?.membership_agreement} target="_blank"> Download Agreement </a>
                <a className="btn btn-primary mx-1" href="#"  onClick={toggleUploadAgreeView} >Upload Signed Agreement </a>
          </>}
        </Col>
        <Col md='12'>

              
            <table className="table table-striped table-bordered">  
              <thead>    
                  <tr>      
                      <th scope="col">#</th>      
                      <th scope="col">Name</th>      
                      <th scope="col">Value</th>      
                  </tr>  
              </thead>  
              <tbody>
                {/* {$user_application} */}
                    {$user_application?.application_requirements && $user_application?.application_requirements?.map((user_application_item, index) => (
                        <tr key={index}>      
                            <th scope="row">{++index}</th>      
                            <td>{user_application_item.field.description}</td>      
                            <td>
                                {user_application_item.uploaded_file != null ? <>
                                  <a className="btn btn-primary" href={user_application_item.uploaded_file} target="_blank">View File </a>
                                </> : <>
                                  { user_application_item.uploaded_field }
                                </>}
                            </td>  
                        </tr>
                      
                    ))}
              </tbody>
          </table>
            
          
        </Col>
        
        
              
             
      </Row>
      
        <Modal isOpen={modalView} toggle={toggleView} size="lg">
            <ModalHeader toggle={toggleView} close={<button className="close" onClick={toggleView}><Icon name="cross" /></button>}>
                Make Payment
            </ModalHeader>
            <ModalBody>
                  {!uploadView ? <>
                    <Row className="gy-5">
                        <Col md='6'>
                          <Card className="card-bordered">   
                            <CardBody className="card-inner">
                              <CardTitle tag="h5">Payment by Transfer</CardTitle>
                              <CardText>
                                Upload Prove Of Payment after transfer
                              </CardText>
                              <Button color="primary"  onClick={toggleUploadView}>Upload</Button>
                            </CardBody>
                          </Card>
                        </Col>
                        <Col md='6'>
                          <Card className="card-bordered">   
                            <CardBody className="card-inner">
                              <CardTitle tag="h5">Online Payment</CardTitle>
                              <CardText>
                                Upload Prove Of Payment
                              </CardText>
                              <Button color="primary">Proceed to Payment</Button>
                            </CardBody>
                          </Card>
                        </Col>
                    </Row>                  
                  </> : <>
                    <Row className="gy-5">
                        <Col md='12'>
                          <Card className="card-bordered">   
                            <CardBody className="card-inner">
                              <CardTitle tag="h5">Payment by Transfer</CardTitle>
                                {$user_application && <>
                                    <PayWithTransfer tabItem={$user_application} updateParentParent={setParentState} closeModel={toggleView}  toggleMethod={toggleUploadView}/>
                                </>}
                              
                              
                            </CardBody>
                          </Card>
                        </Col>
                    </Row>                  
                  </>}

                    

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
        <Modal isOpen={uploadAgreeView} toggle={toggleUploadAgreeView} size="lg">
            <ModalHeader toggle={toggleUploadAgreeView} close={<button className="close" onClick={toggleUploadAgreeView}><Icon name="cross" /></button>}>
                Upload Signed Agreement
            </ModalHeader>
            <ModalBody>

                    <Row className="gy-5">
                        <Col md='12'>
                          <Card className="card-bordered">   
                            <CardBody className="card-inner">
                              <CardTitle tag="h5">Payment by Transfer</CardTitle>
                                {$user_application && <>
                                    <UploadAgreement tabItem={$user_application} updateParentParent={setParentState} closeModel={toggleView}/>
                                </>}
                              
                              
                            </CardBody>
                          </Card>
                        </Col>
                    </Row>                  
            </ModalBody>
            <ModalFooter className="bg-light">
                <span className="sub-text">View Institutions</span>
            </ModalFooter>
        </Modal>
    </section>
  );
};

const UploadAgreement = ({ updateParentParent, tabItem, positions, closeModel }) => {
    
    const aUser = useUser();
    const aUserUpdate = useUserUpdate();
    
    const navigate = useNavigate();
    const tabItem_id = tabItem.id
    const [complainFile, setComplainFile] = useState([]);
    const [loading, setLoading] = useState(false);
    const dispatch = useDispatch();
    
    const { handleSubmit, register, watch, formState: { errors } } = useForm();

    const submitForm = async (data) => {
            
            const postValues = new Object();
              postValues.proof_of_payment = complainFile;
              postValues.application_id = tabItem?.application?.id;

              try {
                  setLoading(true);
                  
                //   const resp = await dispatch(uploadPaymentProof(postValues));

                  if (resp.payload?.message == "success") {
                      setTimeout(() => {
                          setLoading(false);
                          updateParentParent(Math.random())
                          closeModel()
                          navigate(`${process.env.PUBLIC_URL}/dashboard`)
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
                    <label className="form-label" htmlFor="proveOfPayment">
                        Signed Agreement
                    </label>
                    <div className="form-control-wrap">
                        <input type="file" id="proveOfPayment" className="form-control" {...register('proveOfPayment', { required: "This Field is required" })} onChange={handleFileChange}/>
                        {errors.proveOfPayment && <span className="invalid">{ errors.proveOfPayment.message }</span>}
                    </div>
                </div>
                <div className="form-group">
                    <Button color="primary" type="submit"  size="md">
                        {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : "Upload "}
                    </Button>

                    <Button color="primary" size='md' className="mx-3" onClick={closeModel}>Cancel</Button>
                </div>
                
          </form>
          
      </>


    );
};
 

const PayWithTransfer = ({ updateParentParent, tabItem, positions, closeModel, toggleMethod }) => {
    
    const aUser = useUser();
    const aUserUpdate = useUserUpdate();
    
    const navigate = useNavigate();
    const tabItem_id = tabItem.id
    const [complainFile, setComplainFile] = useState([]);
    const [loading, setLoading] = useState(false);
    const dispatch = useDispatch();
    
    const { handleSubmit, register, watch, formState: { errors } } = useForm();

    const submitForm = async (data) => {
            
            const postValues = new Object();
              postValues.proof_of_payment = complainFile;
              postValues.application_id = tabItem?.application?.id;

              try {
                  setLoading(true);
                  
                  const resp = await dispatch(uploadPaymentProof(postValues));

                  if (resp.payload?.message == "success") {
                      setTimeout(() => {
                          setLoading(false);
                          updateParentParent(Math.random())
                          closeModel()
                          toggleMethod()
                          navigate(`${process.env.PUBLIC_URL}/dashboard`)
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
                    <label className="form-label" htmlFor="proveOfPayment">
                        Prove of Payment
                    </label>
                    <div className="form-control-wrap">
                        <input type="file" id="proveOfPayment" className="form-control" {...register('proveOfPayment', { required: "This Field is required" })} onChange={handleFileChange}/>
                        {errors.proveOfPayment && <span className="invalid">{ errors.proveOfPayment.message }</span>}
                    </div>
                </div>
                <div className="form-group">
                    <Button color="primary" type="submit"  size="md">
                        {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : "Upload Prove"}
                    </Button>

                    <Button color="primary" size='md' className="mx-3" onClick={toggleMethod}>Cancel</Button>
                </div>
                
          </form>
          
      </>


    );
};
 



const Header = (props) => {
  return (
    <div className="steps clearfix">
      <ul>
        {/* <li className={props.current >= 1 ? "first done" : "first"}>
          <a href="#wizard-01-h-0" onClick={(ev) => ev.preventDefault()}>
            <span className="number">APPLICANT</span> <h5>Information</h5>
          </a>
        </li>
        <li className={props.current >= 2 ? "done" : ""}>
          <a href="#wizard-01-h-1" onClick={(ev) => ev.preventDefault()}>
            <span className="number">TRADING</span> <h5>DETAILS</h5>
          </a>
        </li>
        <li className={props.current >= 3 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number">DISCIPLINARY</span> <h5>HISTORY</h5>
          </a>
        </li>
        <li className={props.current >= 4 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number">SUPPORTING</span> <h5>DOCUMENT</h5>
          </a>
        </li>
        <li className={props.current >= 5 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number">APPLICANT</span> <h5>DECLARATION</h5>
          </a>
        </li>
        <li className={props.current >= 6 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number">APPLICATION</span> <h5>COMPLETED</h5>
          </a>
        </li> */}
        {/* <li className={props.current >= 7 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number"></span> <h5>Step 7</h5>
          </a>
        </li>
        <li className={props.current >= 8 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number"></span> <h5>Step 8</h5>
          </a>
        </li>
        <li className={props.current === 9 ? "last done" : "last"}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number"></span> <h5>Step 9</h5>
          </a>
        </li> */}
      </ul>
    </div>
  );
};



const config = {
  before: Header,
};

const Form = () => {
    
    
    const authUser = useUser();
    const authUserUpdate = useUserUpdate();

  const [loading, setLoading] = useState(false);
  const [passState, setPassState] = useState(false);
  const [errorVal, setError] = useState("");
  const [modalSuccess, setModalSuccess] = useState(false);
  const toggleSuccess = () => setModalSuccess(!modalSuccess);
  const styles = {
    color: {
      marginBottom: "10px",
    },
    scroll: {
      overFlow: "scroll",
    },
    card: {
      backgroundColor: "#fff",
      margin: "50px 30px",
      padding: "20px"
    }

  }


  return <>
    <Head title="Form" />
    <HeaderLogo />
    
            <Content>
                <Content>
                  <div className="">
                    <div style={{ 'margin': '0px 10px !important' }}>
                      <div style={styles.card}>
                        <div style={styles.color}>
                          <h2>{`${authUser.user_data.institution.category[0].name} Application Details`} </h2>
                          {/* <p>Pending Approval</p> */}
                        </div>
                        <div className="nk-wizard nk-wizard-simple is-alter wizard clearfix">
                          <Steps config={config}>
                            <Step component={ApplicantInformation} />
                            {/* <Step component={TradingDetail} />
                            <Step component={DisciplinaryHistory} />
                            <Step component={SupportingDocuments} />
                            <Step component={ApplicationDeclaration} />
                            <Step component={ApplicationCompleted} /> */}
                          </Steps>
                        </div>
                      </div>
                    </div>
                  </div>
                </Content>
            </Content>

  </>;
};
// type="submit"
export default Form;

