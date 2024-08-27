import React, { useState, useRef, useEffect, forwardRef } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { BlockContent, BlockTitle, Icon } from "components/Component";
import { Steps, Step } from "react-step-builder";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, CardBody, CardTitle, CardText } from "reactstrap";
import { HeaderLogo } from "pages/components/HeaderLogo";
import DatePicker from "react-datepicker";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import { loadApplication, fetchApplication } from "redux/stores/membership/applicationStore";
import { loadInvoiceDownload, UploadAgreement, uploadPaymentProof, onlinePayment } from "redux/stores/membership/applicationProcessStore";
import moment from 'moment';
import Swal from "sweetalert2";




const UploadAgreementModel = ({ updateParentParent, tabItem, positions, closeModel }) => {

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
    postValues.executed_member_agreement = complainFile;
    postValues.application_id = tabItem?.application?.id;

    try {
      setLoading(true);

      const resp = await dispatch(UploadAgreement(postValues));

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

      <form className="content clearfix my-5" onSubmit={handleSubmit(submitForm)} encType="multipart/form-data">

        <div className="form-group">
          <label className="form-label" htmlFor="proveOfPayment">
            Signed Agreement
          </label>
          <div className="form-control-wrap">
            <input type="file" accept=".pdf" id="proveOfPayment" className="form-control" {...register('proveOfPayment', { required: "This Field is required" })} onChange={handleFileChange} />
            {errors.proveOfPayment && <span className="invalid">{errors.proveOfPayment.message}</span>}
          </div>
        </div>
        <div className="form-group">
          <Button color="primary" type="submit" size="md">
            {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Upload "}
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

      <form className="content clearfix my-5" onSubmit={handleSubmit(submitForm)} encType="multipart/form-data">

        <div className="form-group">
          <label className="form-label" htmlFor="proveOfPayment">
            Proof of Payment
          </label>
          <div className="form-control-wrap">
            <input type="file" accept=".pdf" id="proveOfPayment" className="form-control" {...register('proveOfPayment', { required: "This Field is required" })} onChange={handleFileChange} />
            {errors.proveOfPayment && <span className="invalid">{errors.proveOfPayment.message}</span>}
          </div>
        </div>
        <div className="form-group">
          <Button color="primary" type="submit" size="md">
            {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Upload Proof"}
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

    </div>
  );
};


const config = {
  before: Header,
};

const Form = () => {


  const dispatch = useDispatch();
  const { application_uuid } = useParams();
  const application_details = useSelector((state) => state?.application?.application_details) || null;
  useEffect(() => {
    dispatch(fetchApplication({ "application_uuid": application_uuid }));
  }, [dispatch]);

  const $application_details = application_details ? JSON.parse(application_details) : null;
  const authUser = useUser();
  const authUserUpdate = useUserUpdate();

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
      if ($application_details) {
        dispatch(loadApplication({ "application_uuid": $application_details.uuid }));
      }
    }, [dispatch, parentState, $application_details]);





    const $user_application = user_application ? JSON.parse(user_application) : null;
    const $invoice_download = invoice_download ? JSON.parse(invoice_download) : null;


    useEffect(() => {
      if ($user_application?.application?.concession_stage) {
        dispatch(loadInvoiceDownload({ 'application_id': $user_application?.application?.id }));
      }
    }, [user_application]);

    const [processing, setProcessing] = useState(false);
    const qPay = async () => {

      try {
        setProcessing(true);
        const resp = await dispatch(onlinePayment({ application_id: $user_application?.application?.id }));
        setProcessing(false);

      } catch (error) {
        setProcessing(false);
      }
    }

    const formatWord = (str) => {
      const value = str
      const firstLetter = value.charAt(0)
      const remainingLetters = value.substring(1)
      const firstLetterCap = firstLetter.toUpperCase()
      const remainingLettersLow = remainingLetters.toLowerCase()
      return `${firstLetterCap}${remainingLettersLow}`;

    }

    const checkValue = (str) => {
      try {
        // JSON.parse(str);
        // console.log(str)
        if (str?.field?.name == "productOfInterest") {
          return JSON.parse(str.uploaded_field) ? Object.keys(JSON.parse(str.uploaded_field)).join(',') : '';
        }

        if (str?.field?.type == "date") {
          return moment(str?.uploaded_field).format('MMM DD, YYYY')
        }


        return formatWord(str.uploaded_field)


      } catch (e) {
        return false;
      }
    }

    return (
      <section>

        <Row className="gy-2">
          <p>{$user_application?.application?.status_description}</p>
          <Col md='12'>
            {$user_application?.application?.concession_stage == 1 && <>

              {!$user_application?.application?.proof_of_payment || $user_application?.application?.status_description == 'FSD DECLINED PAYMENT' || $user_application?.application?.status_description == 'MBG DECLINED PAYMENT' ? <>
                <a className="btn btn-primary mx-1" href={$invoice_download} target="_blank"> View Invoice </a>
                <a className="btn btn-primary mx-1" href="#" onClick={() => setModalView(true)} >Make Payment </a>
              </> : <>
                {/* { ?
                      <><a className="btn btn-primary mx-1" href="#" onClick={toggleView} >Make Payment </a></> : */}
                {$user_application?.application?.status_description == 'PROOF OF PAYMENT UPLOADED' && <> <a className="btn btn-success mx-1" href="#">Payment Sent</a></>}

              </>}

            </>}

            {($user_application?.application?.meg2_review_stage == 1 && $user_application?.application?.membership_agreement && $user_application?.application?.is_applicant_executed_membership_agreement == 0 && $user_application?.application?.status_description == 'MEG SENT MEMBERSHIP AGREEMENT') && <>

              <a className="btn btn-primary mx-1" href={$user_application?.application?.member_agreement} target="_blank"> Download Agreement </a>
              <a className="btn btn-primary mx-1" href="#" onClick={toggleUploadAgreeView} >Upload Signed Agreement </a>
            </>}
          </Col>
          <Col md='12'>


            <table className="table table-striped table-bordered table-hover">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Name</th>
                  <th scope="col" className="width-30">Value</th>
                </tr>
              </thead>
              <tbody>
                {/* {$user_application} */}
                {$user_application?.application_requirements && $user_application?.application_requirements?.map((user_application_item, index) => (
                  <tr key={index}>
                    <th scope="row">{++index}</th>
                    <td className="">{formatWord(user_application_item.field.description)}</td>
                    <td>
                      {user_application_item.uploaded_file != null ? <>
                        <a className="btn btn-primary" href={user_application_item.file_path} target="_blank">View File </a>
                      </> : <>
                        {/* {user_application_item.uploaded_field} */}
                        <span className="">{checkValue(user_application_item)}</span>
                        {/* {isJSON(user_application_item.uploaded_field) ? "Object" : user_application_item.uploaded_field} */}
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
                        Upload proof of payment after transfer
                      </CardText>
                      <Button color="primary" onClick={toggleUploadView}>Upload</Button>
                    </CardBody>
                  </Card>
                </Col>
                <Col md='6'>
                  <Card className="card-bordered">
                    <CardBody className="card-inner">
                      <CardTitle tag="h5">Online Payment</CardTitle>
                      <CardText>
                        Pay via Q-Pay
                      </CardText>
                      <Button color="primary" onClick={qPay}>Proceed to Payment</Button>
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
                        <PayWithTransfer tabItem={$user_application} updateParentParent={setParentState} closeModel={toggleView} toggleMethod={toggleUploadView} />
                      </>}


                    </CardBody>
                  </Card>
                </Col>
              </Row>
            </>}
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
                    {/* <CardTitle tag="h5">Upload Agreement</CardTitle> */}
                    {$user_application && <>
                      <UploadAgreementModel tabItem={$user_application} updateParentParent={setParentState} closeModel={toggleView} />
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

  console.log($application_details)

  return <>
    <Head title="Form" />
    <HeaderLogo />

    <Content>
      <Content>
        <div className="">
          <div style={{ 'margin': '0px 10px !important' }}>
            <div style={styles.card}>
              <div style={styles.color}>
                {$application_details && <h3>{`${$application_details.membership_category.name} Application Detail`} </h3>}
                {/* <p>Pending Approval</p> */}

                {$application_details?.completed_at && <>
                  <table className="table table-striped table-bordered table-hover">
                    <thead>
                      <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col" className="width-30">Value</th>
                      </tr>
                    </thead>
                    <tbody>
                      {/* {$user_application} */}
                      {/* {$user_application?.application_requirements && $user_application?.application_requirements?.map((user_application_item, index) => (
                        <tr key={index}>
                          <th scope="row">{++index}</th>
                          <td className="text-capitalize">{user_application_item.field.description}</td>
                          <td>
                            {user_application_item.uploaded_file != null ? <>
                              <a className="btn btn-primary" href={user_application_item.file_path} target="_blank">View File </a>
                            </> : <>
                              {user_application_item.uploaded_field}
                            </>}
                          </td>
                        </tr>

                      ))} */}
                      <tr>
                        <th scope="row"></th>
                        <td className="">Membership category</td>
                        <td>
                          {`${$application_details?.membership_category?.name}`}
                        </td>
                      </tr>

                      <tr>
                        <th scope="row"></th>
                        <td className="">Identification number</td>
                        <td>
                          {`${$application_details?.reg_id}`}
                        </td>
                      </tr>

                      <tr>
                        <th scope="row"></th>
                        <td className="">Sign-up email address</td>
                        <td>
                          {`${$application_details?.applicant_email}`}
                        </td>
                      </tr>

                      <tr>
                        <th scope="row"></th>
                        <td className="">Sign-on date</td>
                        <td>
                          {`${$application_details?.created_at ? moment($application_details?.created_at).format('YYYY-MM-DD') : ''}`}
                        </td>
                      </tr>

                      <tr>
                        <th scope="row"></th>
                        <td className=""> Status of application</td>
                        <td>
                          {`${$application_details?.status_description}`}
                        </td>
                      </tr>

                      <tr>
                        <th scope="row"></th>
                        <td className=""> Membership agreement</td>
                        <td>
                          {$application_details.executed_membership_agreement != null && <>
                            <a className="btn btn-primary" href={$application_details.executed_membership_agreement} target="_blank">Download </a>
                          </>}
                        </td>
                      </tr>
                      <tr>
                        <th scope="row"></th>
                        <td className=""> E-Success letter</td>
                        <td>
                          {$application_details.e_success_letter != null && <>
                            <a className="btn btn-primary" href={$application_details.e_success_letter} target="_blank">Download </a>
                          </>}
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </>}


              </div>
              <div className="nk-wizard nk-wizard-simple is-alter wizard clearfix">
                <Steps config={config}>
                  <Step component={ApplicantInformation} />
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

