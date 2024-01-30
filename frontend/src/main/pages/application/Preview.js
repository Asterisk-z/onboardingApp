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
import { loadPageFields, loadExtra, completeApplication } from "redux/stores/membership/applicationStore";
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
    const fields = useSelector((state) => state?.application?.all_fields) || null;

    useEffect(() => {
        dispatch(loadPageFields({"page" : "1", "category" : authUser.user_data.institution.category[0].id}));
    }, [dispatch, parentState]);
  
  
    const onInputChange =  () => {
        
          Swal.fire({
              title: "Are you sure?",
              text: "Do you want to submit application!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Yes, submit it!",
          }).then((result) => {

            if (result.isConfirmed) {

                submitApplication()
                  
              }
          });
     
    };


    const submitApplication = async () => {
        try {
            
            const resp = await dispatch(completeApplication());

            if (resp.payload?.message == "success") {
                setParentState(Math.random())
                navigate(`${process.env.PUBLIC_URL}/dashboard`)
            } else {
                navigate(`${process.env.PUBLIC_URL}/dashboard`)
            }
            
        } catch (error) {
            
      }
    };
    
    const submitForm = (data) => {
      
    };
    
  // console.log(authUser.user_data.institution);

  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      {/* <h3>Applicant Information</h3> */}
      <Row className="gy-4">
              {fields && fields.map((field, index) => {
            
            if (field.type == 'text') {
                return (
                    <Col md="6" key={index}>
                    <div className="form-group">
                        <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                        <div className="form-control-wrap">
                        <input type="text" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} disabled defaultValue={field?.field_value?.uploaded_field} />
                        {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                        </div>
                    </div>
                    </Col>
                )
            } else if(field.type == 'date') {
                
                return (
                    <Col md="6" key={index}>
                        <div className="form-group">
                            <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                            <div className="form-control-wrap">
                              
                                  <input type="hidden" {...register(field.name, { required: 'This field is required' })} value={field?.field_value?.uploaded_field} />
                                <DatePicker selected={field?.field_value?.uploaded_field ? new Date(field?.field_value?.uploaded_field) : new Date()}  id={field.name} disabled className="form-control date-picker" />
                                {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                            </div>
                        </div>
                    </Col>
                )
            }else if(field.type == 'email') {
                return (
                    <Col md="6" key={index}>
                        <div className="form-group">
                            <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                            <div className="form-control-wrap">
                                <input type="text" id={field.name} className="form-control" {...register(field.name, {required: 'This field is required', pattern: {value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i, message: "Invalid email address"},})} disabled defaultValue={field?.field_value?.uploaded_field} />
                            {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                            </div>
                        </div>
                    </Col>
                )
            }else if(field.type == 'number') {
                return (
                    <Col md="6" key={index}>
                        <div className="form-group">
                            <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                            <div className="form-control-wrap">
                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} disabled defaultValue={field?.field_value?.uploaded_field}  />
                                {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                            </div>
                        </div>
                    </Col>
                )
            } else if (field.type == 'select') {
                return (
                    <Col md="6" key={index}>
                        <div className="form-group">
                            <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                            <div className="form-control-wrap">
                                
                                <div className="form-control-select" >
                                    <select className="form-control form-select" type="select" name={field.name} id={field.name} {...register(field.name, { required: 'This field is required' })} disabled defaultValue={field?.field_value?.uploaded_field}> 
                                        <option>Select Option</option>
                                        {field.field_options && field.field_options.map((option, index) => (
                                            <option key={index} value={option.option_value}>{option.option_name}</option>
                                        ))}
                                    </select>
                                </div>
                                {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                            </div>
                        </div>
                    </Col>
                )
            }
             
        })}

      </Row>
      <div className="actions clearfix">
        <ul>
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
        </ul>
      </div>
    </form>
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
                          <h2>{`${authUser.user_data.institution.category[0].name} Application Preview`} </h2>
                          <p>Check for any errors</p>
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

