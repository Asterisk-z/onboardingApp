import React, { useState, useRef, useEffect, forwardRef } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { BlockContent, BlockTitle, Icon } from "components/Component";
import { Steps, Step } from "react-step-builder";
import { Row, Col, Button, Input } from "reactstrap";
import { HeaderLogo } from "pages/components/HeaderLogo";
import DatePicker from "react-datepicker";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import { loadPageFields, loadPreview, fetchApplication, completeApplication } from "redux/stores/membership/applicationStore";
import moment from 'moment';
import Swal from "sweetalert2";




 



const Header = (props) => {
  return (
    <div className="steps clearfix">
      <ul>
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
    const dispatch = useDispatch();
    const { application_uuid } = useParams();
    const application_details = useSelector((state) => state?.application?.application_details) || null;
    useEffect(() => {
      if (application_uuid) {
        dispatch(fetchApplication({ "application_uuid": application_uuid }));
      }
    }, [dispatch]);

    const $application_details = application_details ? JSON.parse(application_details) : null;

  
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

      if ($application_details) {
        // dispatch(loadPreview({ "application_id": $application_details?.id }));

        dispatch(loadPageFields({ "page": "1", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
      }
    }, [dispatch, parentState, $application_details]);


    const onInputChange = () => {

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

        const resp = await dispatch(completeApplication({ 'application_id': $application_details?.id }));

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
              <Button color="primary" onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/application/${$application_details?.uuid}`)}>
                Back To Application
              </Button>
            </li>
          </ul>
        </div>
      </form>
    );
  };


  return <>
    <Head title="Form" />
    <HeaderLogo />
    
    <Content>
        <Content>
          <div className="">
            <div style={{ 'margin': '0px 10px !important' }}>
              <div style={styles.card}>
                <div style={styles.color}>
                      {$application_details && <h3>{`${$application_details.membership_category.name} Application`} </h3>}
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

