import React, { useState, useRef, useEffect, forwardRef } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { BlockTitle, Icon } from "components/Component";
import { Steps, Step } from "react-step-builder";
import { Row, Col, Button, Input } from "reactstrap";
import { HeaderLogo } from "pages/components/HeaderLogo";
import DatePicker from "react-datepicker";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import { loadPageFields, loadFieldOption, uploadField } from "redux/stores/membership/applicationStore";
import moment from 'moment';


const ApplicantInformation = (props) => {

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
  
    let initialValues = [];

    if (fields) {
      const fieldValues = fields.map((field) => ({ [field.name]: field.field_value?.uploaded_field ? field.field_value?.uploaded_field : null }))
      initialValues = Object.assign({}, ...fieldValues);
    //   console.log(initialValues, fieldValues)
    }
  
    const onInputChange = async (values) => {
        
      if (!values.field_value || !values.field_name || !values.field_type) return
        setValue(values.field_name, values.field_value)
        clearErrors(values.field_name)
        const postValues = new Object();
        postValues.field_name = values.field_name;
        postValues.field_value = values.field_value;
        postValues.field_type = values.field_type;
        postValues.category_id = authUser.user_data.institution.category[0].id;
        
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
        initialValues = []
        props.next()
    };
    
    const nextProcess = () => {
        console.log(errors)
    }


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
                        <input type="text" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({'field_name' : field.name, "field_value" : e.target.value, "field_type" : field.type})} defaultValue={initialValues[field.name]} />
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
                                <DatePicker selected={initialValues[field.name] ? new Date(initialValues[field.name]) : new Date()}  {...register(field.name, { required: 'This field is required' })} id={field.name} onChange={(e) => onInputChange({'field_name' : field.name, "field_value" : moment(e).format('YYYY-MM-DD'), "field_type" : field.type})} defaultValue={initialValues[field.name]} className="form-control date-picker" />
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
                                <input type="text" id={field.name} className="form-control" {...register(field.name, {required: 'This field is required', pattern: {value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i, message: "Invalid email address"},})} onBlur={(e) => onInputChange({'field_name' : field.name, "field_value" : e.target.value, "field_type" : field.type})} defaultValue={initialValues[field.name]} />
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
                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({'field_name' : field.name, "field_value" : e.target.value, "field_type" : field.type})} defaultValue={initialValues[field.name]}  />
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
                                    <select className="form-control form-select" type="select" name={field.name} id={field.name} {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({'field_name' : field.name, "field_value" : e.target.value, "field_type" : field.type})} defaultValue={initialValues[field.name]}> 
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
            <Button color="primary" type="submit" onClick={nextProcess}>
              Next
            </Button>
          </li>
        </ul>
      </div>
    </form>
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
        dispatch(loadPageFields({"page" : "2", "category" : authUser.user_data.institution.category[0].id}));
    }, [dispatch, parentState]);

    
    const onInputChange = async (values) => {
        
      if (!values.field_value || !values.field_name || !values.field_type) return
        setValue(values.field_name, values.field_value)
        clearErrors(values.field_name)
        const postValues = new Object();
        postValues.field_name = values.field_name;
        postValues.field_value = values.field_value;
        postValues.field_type = values.field_type;
        postValues.category_id = authUser.user_data.institution.category[0].id;
        
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
        console.log(errors)
    }

    
    const onInputChangeTest = async (values) => {

        console.log(values)
     
    };


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
                            <input type="text" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({'field_name' : field.name, "field_value" : e.target.value, "field_type" : field.type})} defaultValue={field?.field_value?.uploaded_field} />
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
                                <DatePicker selected={field?.field_value?.uploaded_field ? new Date(field?.field_value?.uploaded_field) : new Date()}  {...register(field.name, { required: 'This field is required' })} id={field.name} onBlur={(e) => onInputChange({'field_name' : field.name, "field_value" : moment(e).format('YYYY-MM-DD'), "field_type" : field.type})} defaultValue={field?.field_value?.uploaded_field} className="form-control date-picker" />
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
                                <input type="text" id={field.name} className="form-control" {...register(field.name, {required: 'This field is required', pattern: {value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i, message: "Invalid email address"},})} onBlur={(e) => onInputChange({'field_name' : field.name, "field_value" : e.target.value, "field_type" : field.type})} defaultValue={field?.field_value?.uploaded_field} />
                            {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                            </div>
                        </div>
                    </Col>
                )
            } else if (field.type == 'number') {
                return (
                    <Col md="6" key={index}>
                        <div className="form-group">
                            <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                            <div className="form-control-wrap">
                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({'field_name' : field.name, "field_value" : e.target.value, "field_type" : field.type})} defaultValue={field?.field_value?.uploaded_field ? field?.field_value?.uploaded_field : 0}  />
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
                                    <select className="form-control form-select" type="select" name={field.name} id={field.name} {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({'field_name' : field.name, "field_value" : e.target.value, "field_type" : field.type})} defaultValue={field?.field_value?.uploaded_field}> 
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
            } else if (field.type == 'checkbox') {
                const checkedBoxes = field.field_value?.uploaded_field ? JSON.parse(field.field_value?.uploaded_field) : {};
                const checkedValues = (values) => {
                  
                    checkedBoxes[values.option_value] = values.field_value
                    
                    const field_value = JSON.stringify(checkedBoxes)
                    onInputChange({'field_name' : field.name, "field_value" : field_value, "field_type" : field.type})
                }  
                return (
                    <div  key={index}>
                        <Col md="12">
                            <div className="form-group">
                                <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                                <div className="form-control-wrap">
                                    <ul className="custom-control-group gy-4">
                                        {field.field_options && field.field_options.map((option, index) => (
                                            
                                                <li key={index}>
                                                    <div className="custom-control custom-checkbox custom-control-pro no-control checked">
                                                        <input type="checkbox" className="custom-control-input" name="btnCheck" id={`btnCheck${index}`} defaultChecked={checkedBoxes[option.option_value] ? true : false}  onChange={(e) => checkedValues({'option_value' : option.option_value, "field_value" : e.target.checked, "option_name" : option.option_name})} />
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
                            
                            if (checkedBoxes.bonds && child_field.name == 'MonthlyAverageValueOfTradesPerProductBonds' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number" id={child_field.name} className="form-control"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )
                            }
                            
                            if (checkedBoxes.treasuryBills && child_field.name == 'MonthlyAverageValueOfTradesPerProductTreasuryBills' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number" id={child_field.name} className="form-control"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )

                            }
                            if (checkedBoxes.commercialPapers && child_field.name == 'MonthlyAverageValueOfTradesPerProductCommercialPaper' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )

                            }
                            if (checkedBoxes.moneyMarket && child_field.name == 'MonthlyAverageValueOfTradesPerProductMoneyMarket' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )

                            }
                            if (checkedBoxes.foreignExchange && child_field.name == 'MonthlyAverageValueOfTradesPerProductForeignExchange' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )

                            }
                            if (checkedBoxes.derivatives && child_field.name == 'MonthlyAverageValueOfTradesPerProductDerivatives' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )

                            }
                            if (checkedBoxes.others && child_field.name == 'MonthlyAverageValueOfTradesPerProductOthers' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )

                            }
                            if (checkedBoxes.bonds && child_field.name == 'AverageTradeSizePerTransactionBonds' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )

                            }
                            if (checkedBoxes.treasuryBills && child_field.name == 'AverageTradeSizePerTransactionTreasuryBills' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )

                            }
                            if (checkedBoxes.commercialPapers && child_field.name == 'AverageTradeSizePerTransactionCommercialPaper' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )

                            }
                            if (checkedBoxes.moneyMarket && child_field.name == 'AverageTradeSizePerTransactionMoneyMarket' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )

                            }
                            if (checkedBoxes.foreignExchange && child_field.name == 'AverageTradeSizePerTransactionForeignExchange' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )

                            }
                            if (checkedBoxes.derivatives && child_field.name == 'AverageTradeSizePerTransactionDerivatives' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )

                            }
                            if (checkedBoxes.others && child_field.name == 'AverageTradeSizePerTransactionOthers' ) {
                               
                                 return (
                                    <Col md="6" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number"  onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
        dispatch(loadPageFields({"page" : "3", "category" : authUser.user_data.institution.category[0].id}));
    }, [dispatch, parentState]);
  
  
    const onInputChange = async (values) => {
        
      if (!values.field_value || !values.field_name || !values.field_type) return
        setValue(values.field_name, values.field_value)
        clearErrors(values.field_name)
        const postValues = new Object();
        postValues.field_name = values.field_name;
        postValues.field_value = values.field_value;
        postValues.field_type = values.field_type;
        postValues.category_id = authUser.user_data.institution.category[0].id;
        
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
        console.log(errors)
    }


  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <h3>Disciplinary History</h3>
      <p>The questions below relate to the company and the key officers listed above. Responses should cover material events which occurred in the past ten (10) years and should include events that have occurred anywhere in the world. If in doubt as to the materiality or relevance of the event, please disclose the event. If the answer to the any of the questions below is “YES”, the applicant is required to provide additional information/details in a separate sheet.</p>
      <Row className="gy-4">
              {fields && fields.map((field, index) => {
            
           if (field.type == 'select') {
                return (
                    <Col md="12" key={index}>
                        <div className="form-group">
                            <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
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
                        
                            <Row>
                        {field.child_fields && field.child_fields.map((child_field, index) => {
                            
                                 return (
                                    <Col md="12" key={index}>
                                        <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{child_field.description}</label>
                                            <div className="form-control-wrap">
                                                
                                                <div className="form-control-select" >
                                                    <select className="form-control form-select" type="select" name={child_field.name} id={child_field.name} {...register(child_field.name, { required: 'This field is required' })} onChange={(e) => onInputChange({'field_name' : child_field.name, "field_value" : e.target.value, "field_type" : child_field.type})} defaultValue={child_field?.field_value?.uploaded_field}> 
                                                        <option>Select Option</option>
                                                        {child_field.field_options && child_field.field_options.map((option, index) => (
                                                            <option key={index} value={option.option_value}>{option.option_name}</option>
                                                        ))}
                                                    </select>
                                                </div>
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div>
                                        {/* <div className="form-group">
                                            <label className="form-label text-capitalize" htmlFor="company-name">{`${child_field.description} (N)`}</label>
                                            <div className="form-control-wrap">
                                                <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: 'This field is required' })} onKeyUp={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
                                                {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                            </div>
                                        </div> */}
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

    useEffect(() => {
        dispatch(loadPageFields({"page" : "4", "category" : authUser.user_data.institution.category[0].id}));
    }, [dispatch, parentState]);
  
  
    const onInputChange = async (values) => {
        
      if (!values.field_value || !values.field_name || !values.field_type) return
        setValue(values.field_name, values.field_value)
        clearErrors(values.field_name)
        const postValues = new Object();
        postValues.field_name = values.field_name;
        postValues.field_value = values.field_value;
        postValues.field_type = values.field_type;
        postValues.category_id = authUser.user_data.institution.category[0].id;
        
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
        console.log(errors)
    }


  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)} encType="multipart/form-data">
      <h3>Supporting Documents</h3>
      <Row className="gy-4">
              {fields && fields.map((field, index) => {
            
           if (field.type == 'file') {
                return (
                    <Col md="12" key={index}>
                        <div className="form-group">
                            <label className="form-label text-capitalize" htmlFor="company-name">{field.description}</label>
                            <div className="form-control-wrap">
                                
                                <input type="file"  accept=".gif,.jpg,.jpeg,.png,.pdf" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({'field_name' : field.name, "field_value" : e.target.files[0], "field_type" : field.type})} />
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
const StepSix = (props) => {
  const [formData, setFormData] = useState({
    surname: "",
    firstName: "",
    middleName: "",
    number: "",
    email: "",
    address: ""
  });

  const onInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const { register, handleSubmit, formState: { errors } } = useForm();

  const submitForm = (data) => {
    //window.location.reload();
    props.next();
  };

  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <h3>Key Officers</h3>
      <br />
      <h5 style={{ 'marginTop': '10px' }}>Managing Director/Chief Executive Office</h5>
      <Row className="gy-3">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="surname">
              Surname
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="surname"
                {...register('surname', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.surname && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="first-name">
              First Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="first-name"
                {...register('firstName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.firstName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="middle-name">
              Middle Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="middle-name"
                {...register('middleName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.middleName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="number">
              Telephone/ Mobile No.
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="number"
                {...register('accountManagerNumber', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.number && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="email">
              Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="email"
                {...register('email', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.email && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="address">
              Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="address"
                {...register('address', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.address && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
      </Row>
      {/* <h5 style={{'marginTop':'10px'}}>Treasurer/Chief Financial Officer </h5>
      <Row className="gy-3">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="surname">
              Surname
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="surname"
                {...register('surname', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.surname && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="first-name">
              First Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="first-name"
                {...register('firstName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.firstName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="middle-name">
              Middle Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="middle-name"
                {...register('middleName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.middleName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="number">
              Telephone/ Mobile No.
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="number"
                {...register('accountManagerNumber', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.number && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="email">
              Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="email"
                {...register('email', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.email && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="address">
              Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="address"
                {...register('address', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.address && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
      </Row>
      <h5 style={{'marginTop':'10px'}}>Chief Compliance Officer </h5>
      <Row className="gy-3">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="surname">
              Surname
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="surname"
                {...register('surname', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.surname && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="first-name">
              First Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="first-name"
                {...register('firstName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.firstName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="middle-name">
              Middle Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="middle-name"
                {...register('middleName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.middleName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="number">
              Telephone/ Mobile No.
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="number"
                {...register('accountManagerNumber', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.number && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="email">
              Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="email"
                {...register('email', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.email && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="address">
              Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="address"
                {...register('address', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.address && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
      </Row>
      <h5 style={{'marginTop':'10px'}}>Internal Auditor</h5>
      <Row className="gy-3">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="surname">
              Surname
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="surname"
                {...register('surname', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.surname && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="first-name">
              First Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="first-name"
                {...register('firstName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.firstName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="middle-name">
              Middle Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="middle-name"
                {...register('middleName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.middleName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="number">
              Telephone/ Mobile No.
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="number"
                {...register('accountManagerNumber', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.number && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="email">
              Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="email"
                {...register('email', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.email && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="address">
              Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="address"
                {...register('address', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.address && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
      </Row>
      <h5 style={{'marginTop':'10px'}}>Risk Management Officer</h5>
      <Row className="gy-3">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="surname">
              Surname
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="surname"
                {...register('surname', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.surname && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="first-name">
              First Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="first-name"
                {...register('firstName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.firstName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="middle-name">
              Middle Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="middle-name"
                {...register('middleName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.middleName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="number">
              Telephone/ Mobile No.
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="number"
                {...register('accountManagerNumber', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.number && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="email">
              Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="email"
                {...register('email', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.email && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="address">
              Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="address"
                {...register('address', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.address && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
      </Row> */}
      <div className="actions clearfix">
        <ul>
          <li>
            <Button color="primary" onClick={props.next}>
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

const StepSeven = (props) => {
  const [formData, setFormData] = useState({
    surname: "",
    firstName: "",
    middleName: "",
    number: "",
    email: "",
    address: ""
  });

  const onInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const { register, handleSubmit, formState: { errors } } = useForm();

  const submitForm = (data) => {
    //window.location.reload();
    props.next();
  };

  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <h3>Disciplinary History</h3>
      <p>The questions below relate to the company and the key officers listed above. Responses should cover material events which occurred in the past ten (10) years and should include events that have occurred anywhere in the world. If in doubt as to the materiality or relevance of the event, please disclose the event. If the answer to the any of the questions below is “YES”, the applicant is required to provide additional information/details in a separate sheet.</p>
      <br />
      <h5>THE COMPANY</h5>
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Has the company or any of its affiliates , been denied registration or expelled from membership of any securities exchange, self-regulatory organisation (SRO) or associations?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>2.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Has your membership, or that of any affiliates, in any of the institutions/ associations mentioned above at any time been revoked, suspended or withdrawn?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>3.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Has your company, or any of its affiliates, ever been refused a Fidelity Bond?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>4.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Has your company, or any of its affiliates, ever been refused a Fidelity Bond?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <h4>MD/CEO</h4>
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been convicted of any criminal offence? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>2.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>3.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been a Director, partner or otherwise concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one year of that connection? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>4.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>5.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>6.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been refused authorisation or licence to carry on a trade, business or profession or to be a member of a securities exchange?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>7.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>8.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever had such authorisation, membership or licence (referred to above) revoked or terminated?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>9.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been disqualified from acting as a Director?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <h4>TREASURER</h4>
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been convicted of any criminal offence?  </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>2.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>2.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one year of that connection? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>2.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>2.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <h4>CHIEF COMPLIANCE OFFICER</h4>
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been convicted of any criminal offence?  </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?  </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one year of that connection? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any Authority which may lead to such proceedings?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <div className="actions clearfix">
        <ul>
          <li>
            <Button color="primary" onClick={props.next}>
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

const StepEight = (props) => {
  const [formData, setFormData] = useState({
    surname: "",
    firstName: "",
    middleName: "",
    number: "",
    email: "",
    address: ""
  });

  const onInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const { register, handleSubmit, formState: { errors } } = useForm();

  const submitForm = (data) => {
    //window.location.reload();
    props.next();
  };

  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <h3>Supporting Documents</h3>

      <Row className="gy-3">

        <div style={{ display: 'flex', justifyContent: 'space-between' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <p>Company Profile containing brief description of the following inter alia:
            History & Company Overview
            Details of Business Services
            Profiles of Board of Directors
            Profiles of Executive Management Staff</p>
          <div>
            <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'center', gap: '5px' }}>
              <input type="file" id="yes" />
              <label for="yes"></label><br />
            </div>
          </div>
        </div>
      </Row>
      <hr />
      <div className="actions clearfix">
        <ul>
          <li>
            <Button color="primary" onClick={props.next}>
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

const StepNine = (props) => {
  const [formData, setFormData] = useState({
    surname: "",
    firstName: "",
    middleName: "",
    number: "",
    email: "",
    address: ""
  });

  const onInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const { register, handleSubmit, formState: { errors } } = useForm();

  const submitForm = (data) => {
    //window.location.reload();
    props.next();
  };

  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <i>By submitting this application to become a member of FMDQ Securities Exchange Limited and signing this form in the manner below:

        We declare that the information provided is complete and accurate and we agree, if approved, to comply with and be bound by the Rules of FMDQ Exchange, which are or may be in force from time to time
        We further declare that we will update our trading practices in line with the Rules. We will notify FMDQ Exchange of any additional information which is relevant to the application and of any significant changes in the information provided in this application form which occur after the date of submission of the application
        We understand that misleading or attempting to mislead FMDQ Exchange’s representatives during the application process will be deemed an act of misconduct and may render the applicant liable to disciplinary proceedings
        We agree that any entity within FMDQ Group may have access to the information contained herein for marketing purposes
        We undertake to comply with FMDQ Exchange’s Rules, the Investment and Securities Act (ISA) 2007, Securities and Exchange Commission Rules and such other regulation relating to our activities on the Exchange, as may be amended from time to time
      </i>
      <br />
      {/* <h5>THE COMPANY</h5>
      <Row className="gy-3">
        <div style={{ display: 'flex', justifyContent: 'space-between' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <p>Has the company or any of its affiliates , been denied registration or expelled from membership of any securities exchange, self-regulatory organisation (SRO) or associations?</p>
          <div style={{ maxWidth: '50px' }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
              <input type="radio" id="yes" name="no" value="yes" />
              <label for="yes">Yes</label><br />
            </div>
            <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
              <input type="radio" id="no" name="no" value="no" />
              <label for="no">No</label><br />
            </div>
          </div>
        </div>
      </Row> */}
      <hr />
      <div className="actions clearfix">
        <ul>
          <li>
            <Button color="primary" onClick={props.next}>
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
            <span className="number">APPLICATION FEE</span> <h5>PAYMENT</h5>
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

const Success = (props) => {
  return (
    <div className="d-flex justify-content-center align-items-center p-3">
      <BlockTitle tag="h6" className="text-center">
        Thank you for submitting form
      </BlockTitle>
    </div>
  );
};

const Fourth = (props) => {
  return (
    <div className="d-flex justify-content-center align-items-center p-3">
      <BlockTitle tag="h6" className="text-center">
        Thank you for submitting form
      </BlockTitle>
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
            <h2>{`${authUser.user_data.institution.category[0].name} Application`} </h2>
            <p>Please fill forms to complete your application</p>
          </div>
          <div className="nk-wizard nk-wizard-simple is-alter wizard clearfix">
            <Steps config={config}>
              <Step component={ApplicantInformation} />
              <Step component={TradingDetail} />
              <Step component={DisciplinaryHistory} />
              <Step component={SupportingDocuments} />
              <Step component={StepSix} />
              <Step component={StepSeven} />
              <Step component={StepEight} />
              <Step component={StepNine} />
              <Step component={Success} />
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
