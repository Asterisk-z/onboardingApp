import React, { useState, useRef, useEffect, forwardRef } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { BlockContent, BlockTitle, Icon } from "components/Component";
import { Steps, Step } from "react-step-builder";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, CardBody, CardTitle } from "reactstrap";
import { HeaderLogo } from "pages/components/HeaderLogo";
import DatePicker from "react-datepicker";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import { loadPageFields, loadExtra, uploadField, fetchApplication } from "redux/stores/membership/applicationStore";
import { UpdateDisclosure } from "redux/stores/membership/applicationProcessStore";
import moment from 'moment';
import Swal from "sweetalert2";


const Header = (props) => {
  return (
    <div className="steps clearfix">
      <ul>
        <li className={props.current >= 1 ? "first done" : "first"}>
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
        </li>
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
    
    const { application_uuid } = useParams();
    
    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [parentState, setParentState] = useState('0')
    const [showDisclosureModal, setShowDisclosureModal] = useState(false);
    
    const toggleDisclosureModel = () => setShowDisclosureModal(false)

    const application_details = useSelector((state) => state?.application?.application_details) || null;
    useEffect(() => {
      dispatch(fetchApplication({ "application_uuid": application_uuid }));
    }, [dispatch]);
  
    const $application_details = application_details ? JSON.parse(application_details) : null;
    
    if ($application_details && !$application_details?.disclosure_stage && !showDisclosureModal) {
      
        Swal.fire({
          title: "Declaration of prior disclosure?",
          text: "You won't be able to revert this!",
          icon: "warning",
          showCancelButton: true,
          confirmButtonText: "Accept",
          cancelButtonText: "Reject",
          allowOutsideClick: false
        }).then((result) => {
          if (result.isConfirmed) {

            Swal.close()
            
            navigate(`${process.env.PUBLIC_URL}/application_disclosure/${$application_details.uuid}`)

          } else {

            const postValues = new Object();
            postValues.application_id = $application_details?.id;
            postValues.status = 'reject';
            const resp = dispatch(UpdateDisclosure(postValues));
            setParentState(Math.random());
          }
        });

    } 
    
    const updateParent = () => {
      setParentState(Math.random())
    }

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


      const ApplicantInformation = (props) => {

        const authUser = useUser();
        const authUserUpdate = useUserUpdate();

        const dispatch = useDispatch();

        const [parentState, setParentState] = useState('Initial state');
        const [loading, setLoading] = useState(false);
        const [modalForm, setModalForm] = useState(false);

        const { reset, register, handleSubmit, formState: { errors }, setValue, clearErrors } = useForm();
        const fields = useSelector((state) => state?.application?.all_fields) || null;
        // console.log($application_details?.uuid)
        useEffect(() => {
          if ($application_details && $application_details?.disclosure_stage) {
            dispatch(loadPageFields({ "page": "1", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
          }
        }, [dispatch, parentState, $application_details]);

        const onInputChange = async (values) => {

          if (!values.field_value || !values.field_name || !values.field_type) return
          setValue(values.field_name, values.field_value)
          clearErrors(values.field_name)
          const postValues = new Object();
          postValues.field_name = values.field_name;
          postValues.field_value = values.field_value;
          postValues.field_type = values.field_type;
          postValues.application_id = $application_details?.id;
          postValues.category_id = $application_details?.membership_category?.id;

          try {

            const resp = await dispatch(uploadField(postValues));

            if (resp.payload?.message == "success") {
              setParentState(Math.random())
            } else {

            }

          } catch (error) {

          }
        };


        const submitForm = (data) => {
          // initialValues = []
          props.next()
        };

        const nextProcess = () => {
          // console.log(errors)
        }


        return (
          <div>
            {fields && <>
              <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
                {/* <h3>Applicant Information</h3> */}
                <Row className="gy-4">
                  {fields && fields.map((field, index) => {

                    if (field.type == 'text') {
                      return (
                        <Col md="6" key={`${field.name}${index}`}>
                          <div className="form-group">
                            <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                            <div className="form-control-wrap">
                              <input type="text" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} />
                              {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                            </div>
                          </div>
                        </Col>
                      )
                    } else if(field.type == 'url') {
                      return (
                        <Col md="6" key={`${field.name}${index}`}>
                          <div className="form-group">
                            <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                            <div className="form-control-wrap">
                              <input type="url" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} />
                              {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                            </div>
                          </div>
                        </Col>
                      )
                    } else if (field.type == 'date') {

                      return (
                        <Col md="6" key={`${field.name}${index}`}>
                          <div className="form-group">
                            <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                            <div className="form-control-wrap">

                              <input type="hidden" {...register(field.name, { required: 'This field is required' })} value={field?.field_value?.uploaded_field} />
                              <DatePicker selected={field?.field_value?.uploaded_field ? new Date(field?.field_value?.uploaded_field) : ""} id={field.name} onChange={(e) => onInputChange({ 'field_name': field.name, "field_value": moment(e).format('YYYY-MM-DD'), "field_type": field.type })} className="form-control date-picker" />
                              {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                            </div>
                          </div>
                        </Col>
                      )
                    } else if (field.type == 'email') {
                      return (
                        <Col md="6" key={`${field.name}${index}`}>
                          <div className="form-group">
                            <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                            <div className="form-control-wrap">
                              <input type="text" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required', pattern: { value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i, message: "Invalid email address" }, })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} />
                              {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                            </div>
                          </div>
                        </Col>
                      )
                    } else if (field.type == 'number') {
                      return (
                        <Col md="6" key={`${field.name}${index}`}>
                          <div className="form-group">
                            <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                            <div className="form-control-wrap">
                              <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} />
                              {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                            </div>
                          </div>
                        </Col>
                      )
                    } else if (field.type == 'select') {
                      return (
                        <Col md="6" key={`${field.name}${index}`}>
                          <div className="form-group">
                            <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                            <div className="form-control-wrap">

                              <div className="form-control-select" >
                                <select className="form-control form-select" type="select" name={field.name} id={field.name} {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field}>
                                  <option value=''>Select Option</option>
                                  {field.field_options && field.field_options.map((option, index) => (
                                    <option key={`${option.option_value}${index}`} value={option.option_value}>{option.option_name}</option>
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
                      <Button color="primary" type="submit" onClick={nextProcess}>
                        Next
                      </Button>
                    </li>
                  </ul>
                </div>
              </form>        
            </>}
            
          </div>

        );
      };

      const TradingDetail = (props) => {


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
            dispatch(loadPageFields({ "page": "2", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
          }
        }, [dispatch, parentState, $application_details]);


        const onInputChange = async (values) => {

          if (!values.field_value || !values.field_name || !values.field_type) return
          setValue(values.field_name, values.field_value)
          clearErrors(values.field_name)
          const postValues = new Object();
          postValues.field_name = values.field_name;
          postValues.field_value = values.field_value;
          postValues.field_type = values.field_type;
          postValues.application_id = $application_details?.id;
          postValues.category_id = $application_details?.membership_category?.id;

          try {

            const resp = await dispatch(uploadField(postValues));

            if (resp.payload?.message == "success") {
              setParentState(Math.random())
            } else {

            }

          } catch (error) {

          }
        };


        const submitForm = (data) => {
          props.next()
        };

        const nextProcess = () => {
          // console.log(errors)
        }


        const onInputChangeTest = async (values) => {

          // console.log(values)

        };


        return (
          <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
            {/* <h3>Applicant Information</h3> */}
            <Row className="gy-4">
              {fields && fields.map((field, index) => {

                if (field.type == 'text') {
                  return (
                    <Col md="6" key={`${field.name}${index}`}>
                      <div className="form-group">
                        <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                        <div className="form-control-wrap">
                          <input type="text" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} />
                          {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                        </div>
                      </div>
                    </Col>
                  )
                } else if (field.type == 'date') {

                  return (
                    <Col md="6" key={`${field.name}${index}`}>
                      <div className="form-group">
                        <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                        <div className="form-control-wrap">
                          <DatePicker selected={field?.field_value?.uploaded_field ? new Date(field?.field_value?.uploaded_field) : new Date()}  {...register(field.name, { required: 'This field is required' })} id={field.name} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": moment(e).format('YYYY-MM-DD'), "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} className="form-control date-picker" />
                          {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                        </div>
                      </div>
                    </Col>
                  )
                } else if (field.type == 'email') {
                  return (
                    <Col md="6" key={`${field.name}${index}`}>
                      <div className="form-group">
                        <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                        <div className="form-control-wrap">
                          <input type="text" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required', pattern: { value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i, message: "Invalid email address" }, })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} />
                          {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                        </div>
                      </div>
                    </Col>
                  )
                } else if (field.type == 'number') {
                  return (
                    <Col md="6" key={`${field.name}${index}`}>
                      <div className="form-group">
                        <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                        <div className="form-control-wrap">
                          <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field ? field?.field_value?.uploaded_field : 0} />
                          {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                        </div>
                      </div>
                    </Col>
                  )
                } else if (field.type == 'select') {
                  return (
                    <Col md="6" key={`${field.name}${index}`}>
                      <div className="form-group">
                        <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                        <div className="form-control-wrap">

                          <div className="form-control-select" >
                            <select className="form-control form-select" type="select" name={field.name} id={field.name} {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field}>
                              <option value=''>Select Option</option>
                              {field.field_options && field.field_options.map((option, index) => (
                                <option key={`${option.option_value}${index}`} value={option.option_value}>{option.option_name}</option>
                              ))}
                            </select>
                          </div>
                          {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                        </div>
                      </div>
                    </Col>
                  )
                } else if (field.type == 'checkbox') {
                  const checkedBoxes = field.field_value?.uploaded_field ? JSON.parse(field.field_value?.uploaded_field) : {};
                  const checkedValues = (values) => {

                    checkedBoxes[values.option_value] = values.field_value

                    const field_value = JSON.stringify(checkedBoxes)
                    onInputChange({ 'field_name': field.name, "field_value": field_value, "field_type": field.type })
                  }
                  return (
                    <div key={`${field.name}${index}`}>
                      <Col md="12">
                        <div className="form-group">
                          <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                          <div className="form-control-wrap">
                            <ul className="custom-control-group gy-4">
                              {field.field_options && field.field_options.map((option, index) => (

                                <li key={`${option.option_value}${index}`}>
                                  <div className="custom-control custom-checkbox custom-control-pro no-control checked">
                                    <input type="checkbox" className="custom-control-input" name="btnCheck" id={`btnCheck${index}`} defaultChecked={checkedBoxes[option.option_value] ? true : false} onChange={(e) => checkedValues({ 'option_value': option.option_value, "field_value": e.target.checked, "option_name": option.option_name })} />
                                    <label className="custom-control-label" htmlFor={`btnCheck${index}`}>
                                      {option.option_name}
                                    </label>
                                  </div>
                                </li>
                              ))}

                            </ul>

                            {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                          </div>
                        </div>
                        <Row>
                          {field.child_fields && field.child_fields.map((child_field, index) => {

                            if (checkedBoxes.bonds && child_field.name == 'MonthlyAverageValueOfTradesPerProductBonds') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" id={child_field.name} className="form-control" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )
                            }

                            if (checkedBoxes.treasuryBills && child_field.name == 'MonthlyAverageValueOfTradesPerProductTreasuryBills') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" id={child_field.name} className="form-control" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )

                            }
                            if (checkedBoxes.commercialPapers && child_field.name == 'MonthlyAverageValueOfTradesPerProductCommercialPaper') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )

                            }
                            if (checkedBoxes.moneyMarket && child_field.name == 'MonthlyAverageValueOfTradesPerProductMoneyMarket') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )

                            }
                            if (checkedBoxes.foreignExchange && child_field.name == 'MonthlyAverageValueOfTradesPerProductForeignExchange') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )

                            }
                            if (checkedBoxes.derivatives && child_field.name == 'MonthlyAverageValueOfTradesPerProductDerivatives') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )

                            }
                            if (checkedBoxes.others && child_field.name == 'MonthlyAverageValueOfTradesPerProductOthers') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )

                            }
                            if (checkedBoxes.bonds && child_field.name == 'AverageTradeSizePerTransactionBonds') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )

                            }
                            if (checkedBoxes.treasuryBills && child_field.name == 'AverageTradeSizePerTransactionTreasuryBills') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )

                            }
                            if (checkedBoxes.commercialPapers && child_field.name == 'AverageTradeSizePerTransactionCommercialPaper') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )

                            }
                            if (checkedBoxes.moneyMarket && child_field.name == 'AverageTradeSizePerTransactionMoneyMarket') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )

                            }
                            if (checkedBoxes.foreignExchange && child_field.name == 'AverageTradeSizePerTransactionForeignExchange') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )

                            }
                            if (checkedBoxes.derivatives && child_field.name == 'AverageTradeSizePerTransactionDerivatives') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )

                            }
                            if (checkedBoxes.others && child_field.name == 'AverageTradeSizePerTransactionOthers') {

                              return (
                                <Col md="6" key={`${child_field.name}${index}`}>
                                  <div className="form-group">
                                    <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description}`}</label>
                                    <div className="form-control-wrap">
                                      <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                      {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                    </div>
                                  </div>
                                </Col>
                              )

                            }

                          })}
                        </Row>


                      </Col>
                    </div>

                  )
                }

              })}


            </Row>
            <div className="actions clearfix">
              <ul>
                <li>
                  <Button color="primary" type="submit" onClick={nextProcess}>
                    Next
                  </Button>
                </li>
                <li>
                  <Button color="primary" onClick={props.prev}>
                    Previous
                  </Button>
                </li>
              </ul>
            </div>
          </form>
        );

      };

      const DisciplinaryHistory = (props) => {


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
            dispatch(loadPageFields({ "page": "3", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
          }
        }, [dispatch, parentState, $application_details]);


        const onInputChange = async (values) => {

          if (!values.field_value || !values.field_name || !values.field_type) return
          setValue(values.field_name, values.field_value)
          clearErrors(values.field_name)
          const postValues = new Object();
          postValues.field_name = values.field_name;
          postValues.field_value = values.field_value;
          postValues.field_type = values.field_type;
          postValues.application_id = $application_details?.id;
          postValues.category_id = $application_details?.membership_category?.id;

          try {

            const resp = await dispatch(uploadField(postValues));

            if (resp.payload?.message == "success") {
              setParentState(Math.random())
            } else {

            }

          } catch (error) {

          }
        };


        const submitForm = (data) => {
          props.next()
        };

        const nextProcess = () => {
          // console.log(errors)
        }


        return (
          <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
            <h3>Disciplinary History</h3>
            <p>The questions below relate to the company and the key officers listed above. Responses should cover material events which occurred in the past ten (10) years and should include events that have occurred anywhere in the world. If in doubt as to the materiality or relevance of the event, please disclose the event. If the answer to the any of the questions below is “YES”, the applicant is required to provide additional information/details in a separate sheet.</p>
            <Row className="gy-4">
              {fields && fields.map((field, index) => {

                if (field.type == 'select') {
                  return (
                    <Col md="12" key={`${field.name}${index}`}>
                      <div className="form-group">
                        <label className="form-label text-uppercase font-black" htmlFor="company-name">{field.description}</label>
                        <div className="form-control-wrap">

                          {/* <div className="form-control-select" >
                                        <select className="form-control form-select" type="select" name={field.name} id={field.name} {...register(field.name, { required: 'This field is required' })} onChange={(e) => onInputChange({'field_name' : field.name, "field_value" : e.target.value, "field_type" : field.type})} defaultValue={field?.field_value?.uploaded_field}> 
                                            <option>Select Option</option>
                                            {field.field_options && field.field_options.map((option, index) => (
                                                <option key={index} value={option.option_value}>{option.option_name}</option>
                                            ))}
                                        </select>
                                    </div>
                                    {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>} */}
                        </div>
                      </div>

                      <Row className="gy-3">
                        {field.child_fields && field.child_fields.map((child_field, index) => {

                          return (
                            <Col md="12" key={`${child_field.name}${index}`}>
                              <div className="form-group">
                                <label className="form-label text-capitalize" htmlFor="company-name">{child_field.description}</label>
                                <div className="form-control-wrap">

                                  <div className="form-control-select" >
                                    {child_field?.field_value?.uploaded_field}
                                    <select className="form-control form-select" type="select" name={child_field.name} id={child_field.name} {...register(child_field.name, { required: 'This field is required' })} onChange={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field}>
                                      <option value=''>Select Option</option>
                                      {child_field.field_options && child_field.field_options.map((option, index) => (
                                        <option key={`${option.option_value}${index}`} value={option.option_value}>{option.option_name}</option>
                                      ))}
                                    </select>
                                  </div>
                                  {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                </div>
                              </div>

                            </Col>
                          )



                        })}
                      </Row>
                    </Col>

                  )
                }

              })}


            </Row>
            <div className="actions clearfix">
              <ul>
                <li>
                  <Button color="primary" type="submit" onClick={nextProcess}>
                    Next
                  </Button>
                </li>
                <li>
                  <Button color="primary" onClick={props.prev}>
                    Previous
                  </Button>
                </li>
              </ul>
            </div>
          </form>
        );
      };

      const SupportingDocuments = (props) => {

        const authUser = useUser();
        const authUserUpdate = useUserUpdate();

        const dispatch = useDispatch();

        const [parentState, setParentState] = useState('Initial state');
        const [loading, setLoading] = useState(false);
        const [modalForm, setModalForm] = useState(false);

        const { reset, register, handleSubmit, formState: { errors }, setValue, clearErrors } = useForm();
        const fields = useSelector((state) => state?.application?.all_fields) || null;
        const extra = useSelector((state) => state?.application?.list_extra) || null;

        useEffect(() => {
          if ($application_details) {
            dispatch(loadPageFields({ "page": "4", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
          }
        }, [dispatch, parentState, $application_details]);


        const onInputChange = async (values) => {

          if (!values.field_value || !values.field_name || !values.field_type) return
          setValue(values.field_name, values.field_value)
          clearErrors(values.field_name)
          const postValues = new Object();
          postValues.field_name = values.field_name;
          postValues.field_value = values.field_value;
          postValues.field_type = values.field_type;
          postValues.application_id = $application_details?.id;
          postValues.category_id = $application_details?.membership_category?.id;

          try {

            const resp = await dispatch(uploadField(postValues));

            if (resp.payload?.message == "success") {
              setParentState(Math.random())
            } else {

            }

          } catch (error) {

          }
        };


        const submitForm = (data) => {
          props.next()
        };

        const nextProcess = () => {
          // console.log(errors)
        }


        return (
          <form className="content clearfix" onSubmit={handleSubmit(submitForm)} encType="multipart/form-data">
            <h3>Supporting Documents</h3>

            <Row className="gy-4">
              {fields && fields.map((field, index) => {

                if (field.type == 'file') {
                  return (
                    <Col md="12" key={`${field.name}${index}`}>
                      <div className="form-group">
                        <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                        <div className="form-control-wrap">
                          <div className="input-group">
                            <input type="file" accept="..jpg,.jpeg,.png,.pdf" id={field.name} className="form-control" onChange={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.files[0], "field_type": field.type })} />

                            <div className="input-group-append">
                              <input type="hidden" {...register(field.name, { required: 'This field is required' })} value={field.field_value?.file_path ? field.field_value?.file_path : ''} />
                              {field.field_value?.file_path && <a href={field.field_value.file_path} target="_blank" className="btn btn-primary" > Check File</a>}
                            </div>
                          </div>
                          {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                        </div>
                      </div>

                    </Col>

                  )
                }

              })}

              <Col md="12">




                {/* <p>Accepted Modes of Payment: Cheque/Bank Draft/Online Transfer</p>
              <p>All cheques are payable to “FMDQ SECURITIES EXCHANGE LIMITED”</p>
              <table className="table">
                  <tbody>    
                      <tr>          
                          <th>Bank Name</th>      
                          <td>	Access Bank PLC</td>
                      </tr>    
                      <tr>   
                          <th>Account Name</th>      
                          <td>FMDQ Holdings PLC4</td>   
                      </tr>    
                      <tr>           
                          <th>Account Number</th>    
                          <td>068997740</td>   
                      </tr>      
                      <tr>         
                          <th>Sort Code</th>  
                          <td>044151106</td>  
                      </tr>  
                  </tbody>
              </table> */}
              </Col>

            </Row>
            <div className="actions clearfix">
              <ul>
                <li>
                  <Button color="primary" type="submit" onClick={nextProcess}>
                    Next
                  </Button>
                </li>
                <li>
                  <Button color="primary" onClick={props.prev}>
                    Previous
                  </Button>
                </li>
              </ul>
            </div>
          </form>
        );
      };

      const ApplicationDeclaration = (props) => {

        const authUser = useUser();
        const authUserUpdate = useUserUpdate();

        const dispatch = useDispatch();

        const [parentState, setParentState] = useState('Initial state');
        const [loading, setLoading] = useState(false);
        const [modalForm, setModalForm] = useState(false);

        const { reset, register, handleSubmit, formState: { errors }, setValue, clearErrors } = useForm();
        const fields = useSelector((state) => state?.application?.all_fields) || null;
        const extra = useSelector((state) => state?.application?.list_extra) || null;

        useEffect(() => {
          if ($application_details) {
            dispatch(loadPageFields({ "page": "5", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            dispatch(loadExtra({ "name": "applicantDeclaration", "category": $application_details?.membership_category?.id }));
          }

        }, [dispatch, parentState, $application_details]);


        const onInputChange = async (values) => {

          if (!values.field_value || !values.field_name || !values.field_type) return
          setValue(values.field_name, values.field_value)
          clearErrors(values.field_name)
          const postValues = new Object();
          postValues.field_name = values.field_name;
          postValues.field_value = values.field_value;
          postValues.field_type = values.field_type;
          postValues.application_id = $application_details?.id;
          postValues.category_id = $application_details?.membership_category?.id;

          try {

            const resp = await dispatch(uploadField(postValues));

            if (resp.payload?.message == "success") {
              setParentState(Math.random())
            } else {

            }

          } catch (error) {

          }
        };


        const submitForm = (data) => {
          props.next()
        };

        const nextProcess = () => {
          // console.log(errors)
        }


        return (
          <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
            <h3>Applicant Declaration</h3>
            <p>By submitting this application to become a member of FMDQ Securities Exchange Limited and signing this form in the manner below:</p>
            <ul>
              <li>
                {extra?.applicantDeclaration && <a href={extra?.applicantDeclaration.file_path} target="_blank" className="btn btn-primary">Download Applicant Declaration</a>}
              </li>
            </ul>
            <Row className="gy-4">
              {fields && fields.map((field, index) => {

                if (field.type == 'file') {
                  return (
                    <Col md="12" key={`${field.name}${index}`}>
                      <div className="form-group">
                        <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                        <div className="form-control-wrap">
                          <div className="input-group">
                            <input type="file" accept=".jpg,.jpeg,.png,.pdf" id={field.name} className="form-control" onChange={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.files[0], "field_type": field.type })} />

                            <div className="input-group-append">
                              <input type="hidden" {...register(field.name, { required: 'This field is required' })} value={field.field_value?.file_path ? field.field_value?.file_path : ''} />
                              {field.field_value?.file_path && <a href={field.field_value.file_path} target="_blank" className="btn btn-primary" > Check File</a>}
                            </div>
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
                  <Button color="primary" type="submit" onClick={nextProcess}>
                    Next
                  </Button>
                </li>
                <li>
                  <Button color="primary" onClick={props.prev}>
                    Previous
                  </Button>
                </li>
              </ul>
            </div>
          </form>
        );
      };

      const ApplicationCompleted = (props) => {

        return (
          <div className="flex flex-col justify-content-center align-items-center p-3">
            <div>
              <BlockTitle tag="h2" className="text-center">
                Thank you for completing the Membership Application Form.
              </BlockTitle>
              <BlockContent className="text-center">
                <Button color="primary" onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/application_preview/${$application_details.uuid}`)}>
                  Preview Application
                </Button>
              </BlockContent>
            </div>

          </div>
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
                      
                      <p>Please fill forms to complete your application</p>
                    </div>
                    <div className="nk-wizard nk-wizard-simple is-alter wizard clearfix">
                      <Steps config={config}>
                        <Step component={ApplicantInformation} />
                        <Step component={TradingDetail} />
                        <Step component={DisciplinaryHistory} />
                        <Step component={SupportingDocuments} />
                        <Step component={ApplicationDeclaration} />
                        <Step component={ApplicationCompleted} />
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
