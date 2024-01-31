import React, { useState, useRef, useEffect, forwardRef } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { BlockContent, BlockTitle, Icon } from "components/Component";
import { Steps, Step } from "react-step-builder";
import { Row, Col, Button, Input } from "reactstrap";
import { HeaderLogo } from "pages/components/HeaderLogo";
import DatePicker from "react-datepicker";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import { loadApplication, loadExtra, completeApplication } from "redux/stores/membership/applicationStore";
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
    
    const { reset, register, handleSubmit, formState: { errors }, setValue, clearErrors } = useForm();
    const user_application = useSelector((state) => state?.application?.user_application) || null;

    useEffect(() => {
        dispatch(loadApplication());
    }, [dispatch, parentState]);
  
  

    
    const $user_application = user_application ? JSON.parse(user_application) : null;

    
  console.log($user_application);

  return (
    <section>
      
      <Row className="gy-2">
        <Col md='12'>
          {$user_application?.concession_stage == 1 && <>
              <a className="btn btn-primary" href="#" target="_blank">View Invoice </a>
          </>}
        </Col>
        <Col md='12'>

              
            <table className="table table-striped table-bordered">  
    <thead>    
        <tr>      
            <th scope="col">#</th>      
            <th scope="col">Name</th>      
            <th scope="col">Value</th>      
            <th scope="col">Status</th>    
        </tr>  
    </thead>  
    <tbody>
      {/* {$user_application} */}
          {/* {$user_application && $user_application?.map((user_application_item, index) => (
              <tr>      
                  <th scope="row">{++index}</th>      
                  <td>{user_application_item}</td>      
                  <td>Otto</td>      
                  <td>@mdo</td>    
              </tr>
            
          ))} */}
    </tbody>
</table>
            
          
        </Col>
        
        
              
             
      </Row>
      <div className="actions clearfix">
        {/* <ul>
          <li>
            <Button color="primary" onClick={onInputChange}>
              Submit Application
            </Button>
          </li>
          <li>
            <Button color="primary"   onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/application`) }>
              Back To Application
            </Button>
          </li>
        </ul> */}
      </div>
    </section>
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
                          <p>Pending Approval</p>
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

