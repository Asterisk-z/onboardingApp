import React, { useState, useRef, useEffect, Suspense } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { BlockContent, BlockTitle, Icon, OverlineTitle } from "components/Component";
import { Steps, Step, StepsProvider, useSteps } from "react-step-builder";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, CardBody, CardTitle, CardText } from "reactstrap";
import { HeaderLogo } from "pages/components/HeaderLogo";
import DatePicker from "react-datepicker";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import { loadPageFields, loadAllFields, loadExtra, uploadField, fetchApplication, submitPage, updateStep } from "redux/stores/membership/applicationStore";
import { UpdateDisclosure } from "redux/stores/membership/applicationProcessStore";
import moment from 'moment';
import Swal from "sweetalert2";




const Form = () => {

    const { application_uuid } = useParams();

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();

    const dispatch = useDispatch();
    const navigate = useNavigate();

    const [parentState, setParentState] = useState('0')
    const [showDisclosureModal, setShowDisclosureModal] = useState(false);

    const application_details = useSelector((state) => state?.application?.application_details) || null;
    useEffect(() => {
        dispatch(fetchApplication({ "application_uuid": application_uuid }));
    }, [dispatch]);

    const $application_details = application_details ? JSON.parse(application_details) : null;

    const [unChangeableField, setUnChangeableField] = useState(["companyName", "rcNumber", "dateOfIncorporation", "placeOfIncorporation"]);

    const [modalDisclosureStageView, setModalDisclosureStageView] = useState(false);
    const [showDisclosureForm, setShowDisclosureForm] = useState(false);

    const toggleDisclosureStageView = () => setModalDisclosureStageView(!modalDisclosureStageView);
    const toggleDisclosureForm = () => setShowDisclosureForm(!showDisclosureForm);

    useEffect(() => {

        if ($application_details && !$application_details?.disclosure_stage && !showDisclosureModal) {
            setModalDisclosureStageView(true)

        } else {
            setModalDisclosureStageView(false)
            setShowDisclosureForm(false)
        }
    }, [dispatch, $application_details]);

    const uploadDisclosure = async (value, file = null) => {

        // const postValues = new Object();
        // postValues.application_id = $application_details?.id;
        // postValues.status = value;
        const formData = new FormData();
        formData.append('application_id', $application_details?.id)
        formData.append('status', value)
        if (file) {
            formData.append('document', file)
        }
        const resp = await dispatch(UpdateDisclosure(formData));
        if (resp) {
            // window.location.reload();
            setModalDisclosureStageView(false)
            setShowDisclosureForm(false)
            setShowDisclosureModal(true)
            dispatch(fetchApplication({ "application_uuid": application_uuid }));
        }
        // setParentState(Math.random());
        // setTimeout(() => {
        //     window.location.reload();
        // }, 4000)

    }



    const actionDisclosure = async (action) => {

        if (action == 'reject') {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.close()
                    uploadDisclosure('reject')
                }
            });
        }

    }

    const formatLabel = (label) => {
        return `${label.toUpperCase().substring(0, 1)}${label.toLowerCase().substring(1)}`
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

    const overall_fields = useSelector((state) => state?.application?.overall_fields) || null;
    useEffect(() => {
        if ($application_details && $application_details?.disclosure_stage) {
            dispatch(loadAllFields({ "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
        }
    }, [application_details]);


    const ApplicantInformation = (props) => {

        useEffect(() => {
            if ($application_details) {
                dispatch(updateStep({ "application_id": $application_details?.id, "step": 1 }));
            }
        }, [dispatch]);

        const { reset, register, handleSubmit, formState: { errors }, setValue, clearErrors } = useForm();



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
                    dispatch(loadPageFields({ "page": "1", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
                } else {

                }

            } catch (error) {

            }
        };

        const updatedApplicationFields = useSelector((state) => state?.application?.all_fields) || null;
        const loadingPageFields = useSelector((state) => state?.application?.loadingPageFields) || null;
        const [applicationFields, setApplicationFields] = useState(overall_fields?.basic);

        const fieldSectionData = useRef(null);

        let fields = updatedApplicationFields ? (updatedApplicationFields[0]?.page == 1 ? updatedApplicationFields : applicationFields) : applicationFields

        const submitForm = async (data) => {

            let field_value = Object.values(data)
            let field_name = Object.keys(data)

            let list = [];

            for (let index = 0; index < field_value.length; index++) {
                let inputField = field_name[index];
                let inputValue = field_value[index];
                let field = applicationFields.filter((item) => item.name == inputField);

                if (field) {
                    let fieldItem = field[0] ? field[0] : null;


                    if (fieldItem?.name == inputField) {

                        const postValue = new Object();
                        postValue.field_name = inputField;
                        postValue.field_value = inputValue;
                        postValue.field_type = fieldItem.type;

                        list.push(postValue)

                    }
                }

            }
            // for (let index = 0; index < applicationFields.length; index++) {
            //   let field = applicationFields[index];
            //   let inputField = field_name[index];
            //   let inputValue = field_value[index];
            //   if (field.name == inputField) {

            //     const postValue = new Object();
            //     postValue.field_name = inputField;
            //     postValue.field_value = inputValue;
            //     postValue.field_type = field.type;

            //     list.push(postValue)

            //   }
            // }


            try {

                const postValues = new Object();
                postValues.application_id = $application_details?.id;
                postValues.category_id = $application_details?.membership_category?.id;
                postValues.fields = list;
                const resp = await dispatch(submitPage(postValues));

                if (resp.payload?.message == "success") {
                    dispatch(loadPageFields({ "page": "1", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
                }


                props.next()
            } catch (error) {

            }

        };

        const goBack = () => {
            dispatch(loadPageFields({ "page": "1", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            // dispatch(loadAllFields({ "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            props.prev()
        }


        useEffect(() => {
            console.log("ApplicantInformation")
            console.log(loadingPageFields)
            console.log(updatedApplicationFields)
            console.log(applicationFields)
            fieldSectionData.current = applicationFields
        }, [updatedApplicationFields, applicationFields]);

        return (
            // <Suspense fallback={
            //     <div className="text-center">
            //         <Spinner />
            //     </div>
            // }>
            <div>
                {loadingPageFields}
                {fields && <>
                    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
                        {/* <h3>Applicant Information</h3> */}
                        <Row className="gy-4">
                            {fields && fields.map((field, index) => {

                                if (field.type == 'text') {
                                    return (
                                        <Col md="6" key={`${field.name}${index}`}>
                                            <div className="form-group">
                                                <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
                                                <div className="form-control-wrap">
                                                    <input type="text" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} readOnly={($application_details?.disclosure_status && unChangeableField.includes(field.name) && field?.field_value?.uploaded_field)} />
                                                    {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                                                </div>
                                            </div>
                                        </Col>
                                    )
                                } else if (field.type == 'url') {
                                    return (
                                        <Col md="6" key={`${field.name}${index}`}>
                                            <div className="form-group">
                                                <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
                                                <div className="form-control-wrap">
                                                    <input type="url" placeholder="http://example.com" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} readOnly={($application_details?.disclosure_status && unChangeableField.includes(field.name) && field?.field_value?.uploaded_field)} />
                                                    {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                                                </div>
                                            </div>
                                        </Col>
                                    )
                                } else if (field.type == 'date') {

                                    return (
                                        <Col md="6" key={`${field.name}${index}`}>
                                            <div className="form-group">
                                                <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
                                                <div className="form-control-wrap">

                                                    <input type="hidden" {...register(field.name, { required: 'This field is required' })} value={field?.field_value?.uploaded_field} />
                                                    <DatePicker selected={field?.field_value?.uploaded_field ? new Date(field?.field_value?.uploaded_field) : ""} id={field.name} onChange={(e) => onInputChange({ 'field_name': field.name, "field_value": e, "field_type": field.type })} className="form-control date-picker" readOnly={($application_details?.disclosure_status && unChangeableField.includes(field.name) && field?.field_value?.uploaded_field)} />
                                                    {/* <DatePicker selected={field?.field_value?.uploaded_field ? new Date(field?.field_value?.uploaded_field) : ""} id={field.name} onChange={(e) => onInputChange({ 'field_name': field.name, "field_value": moment(e).format('YYYY-MM-DD'), "field_type": field.type })} className="form-control date-picker" /> */}
                                                    {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                                                </div>
                                            </div>
                                        </Col>
                                    )
                                } else if (field.type == 'email') {
                                    return (
                                        <Col md="6" key={`${field.name}${index}`}>
                                            <div className="form-group">
                                                <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
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
                                                <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
                                                <div className="form-control-wrap">
                                                    <input type="number" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} readOnly={($application_details?.disclosure_status && unChangeableField.includes(field.name) && field?.field_value?.uploaded_field)} />
                                                    {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                                                </div>
                                            </div>
                                        </Col>
                                    )
                                } else if (field.type == 'select') {
                                    return (
                                        // <div className="form-group w-50">
                                        //     <div className="form-label">
                                        //         <label htmlFor="category">Membership Category<span style={{color:'red'}}> *</span>:</label>
                                        //     </div>
                                        //     <div className="form-control-wrap">
                                        //         <div className="form-control-select">
                                        //             <select className="form-control form-select" style={{width: '100%'}}  {...register('category', { required: true })}  onChange={updatePosition}>
                                        //                 <option value="">Select A Category</option>
                                        //                 {$categories && $categories?.map((category) => (
                                        //                     <option key={category.id} value={category.id}>
                                        //                         {category.name}
                                        //                     </option>
                                        //                 ))}
                                        //             </select>
                                        //             {errors.category && <p className="invalid">Category field is required</p>}
                                        //         </div>
                                        //     </div>
                                        // </div>
                                        <Col md="6" key={`${field.name}${index}`}>
                                            <div className="form-group">
                                                <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
                                                <div className="form-control-wrap">

                                                    <div className="form-control-select" >
                                                        <select className="form-control form-select" type="select" name={field.name} id={field.name} {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} readOnly={($application_details?.disclosure_status && unChangeableField.includes(field.name) && field?.field_value?.uploaded_field)}>
                                                            <option value=''>Select Option</option>
                                                            {field.field_options && field.field_options.map((option, index) => (
                                                                <option key={`${option.option_value}${index}`} value={option.option_value}>{option.option_name}</option>
                                                            ))}
                                                        </select>
                                                        {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                                                    </div>
                                                </div>
                                            </div>
                                        </Col>
                                    )
                                }

                            })}

                        </Row>
                        {fields?.length > 0 && <>
                            <div className="actions clearfix">
                                <ul>
                                    <li>
                                        <Button color="primary" type="submit" onClick={(e) => { }}>
                                            Next
                                        </Button>
                                    </li>
                                </ul>
                            </div>
                        </>}

                    </form>
                </>}

            </div>
            // {/* </Suspense> */ }
        );
    };

    const TradingDetail = (props) => {
        useEffect(() => {
            if ($application_details) {
                dispatch(updateStep({ "application_id": $application_details?.id, "step": 2 }));
            }
        }, [dispatch]);

        const { reset, register, handleSubmit, formState: { errors }, setValue, clearErrors } = useForm();

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
                    dispatch(loadPageFields({ "page": "2", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
                } else {

                }

            } catch (error) {

            }
        };


        const updatedApplicationFields = useSelector((state) => state?.application?.all_fields) || null;
        const loadingPageFields = useSelector((state) => state?.application?.loadingPageFields) || null;
        const [applicationFields, setApplicationFields] = useState(overall_fields?.trade);

        let fields = updatedApplicationFields ? (updatedApplicationFields[0]?.page == 2 ? updatedApplicationFields : applicationFields) : applicationFields

        const submitForm = async (data) => {

            let field_value = Object.values(data)
            let field_name = Object.keys(data)

            let list = [];

            for (let index = 0; index < field_value.length; index++) {
                let inputField = field_name[index];
                let inputValue = field_value[index];
                let field = applicationFields.filter((item) => item.name == inputField);

                if (field) {
                    let fieldItem = field[0] ? field[0] : null;


                    if (fieldItem?.name == inputField) {

                        const postValue = new Object();
                        postValue.field_name = inputField;
                        postValue.field_value = inputValue;
                        postValue.field_type = fieldItem.type;

                        list.push(postValue)

                    }
                }

            }


            try {

                const postValues = new Object();
                postValues.application_id = $application_details?.id;
                postValues.category_id = $application_details?.membership_category?.id;
                postValues.fields = list;
                const resp = await dispatch(submitPage(postValues));

                if (resp.payload?.message == "success") {
                    dispatch(loadPageFields({ "page": "2", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
                }

                props.next()
            } catch (error) {

            }

        };

        const goBack = () => {

            // dispatch(loadAllFields({ "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            dispatch(loadPageFields({ "page": "1", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            props.prev()
        }


        useEffect(() => {
            console.log("TradingDetail")
            console.log(updatedApplicationFields)
            console.log(applicationFields)
        }, [updatedApplicationFields]);

        return (
            <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
                {fields && <>
                    {/* <h3>Applicant Information</h3> */}
                    <Row className="gy-4">
                        {fields && fields.map((field, index) => {

                            if (field.type == 'text') {
                                return (
                                    <Col md="6" key={`${field.name}${index}`}>
                                        <div className="form-group">
                                            <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
                                            <div className="form-control-wrap">
                                                <input type="text" id={field.name} className="form-control" {...register(field.name, { required: (field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} />
                                                {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )
                            } else if (field.type == 'date') {

                                return (
                                    <Col md="6" key={`${field.name}${index}`}>
                                        <div className="form-group">
                                            <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
                                            <div className="form-control-wrap">
                                                <DatePicker selected={field?.field_value?.uploaded_field ? new Date(field?.field_value?.uploaded_field) : new Date()}  {...register(field.name, { required: (field.required ? 'This field is required' : false) })} id={field.name} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} className="form-control date-picker" />
                                                {/* <DatePicker selected={field?.field_value?.uploaded_field ? new Date(field?.field_value?.uploaded_field) : new Date()}  {...register(field.name, { required: ( field.required ? 'This field is required' : false) })} id={field.name} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": moment(e).format('YYYY-MM-DD'), "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} className="form-control date-picker" /> */}
                                                {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )
                            } else if (field.type == 'email') {
                                return (
                                    <Col md="6" key={`${field.name}${index}`}>
                                        <div className="form-group">
                                            <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
                                            <div className="form-control-wrap">
                                                <input type="text" id={field.name} className="form-control" {...register(field.name, { required: (field.required ? 'This field is required' : false), pattern: { value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i, message: "Invalid email address" }, })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field} />
                                                {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )
                            } else if (field.type == 'number') {
                                return (
                                    <Col md="6" key={`${field.name}${index}`}>
                                        <div className="form-group">
                                            <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
                                            <div className="form-control-wrap">
                                                <input type="number" id={field.name} className="form-control" {...register(field.name, { required: (field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field ? field?.field_value?.uploaded_field : ''} />
                                                {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                                            </div>
                                        </div>
                                    </Col>
                                )
                            } else if (field.type == 'select') {
                                return (
                                    <Col md="6" key={`${field.name}${index}`}>
                                        <div className="form-group">
                                            <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
                                            <div className="form-control-wrap">

                                                <div className="form-control-select" >
                                                    <select className="form-control form-select" type="select" name={field.name} id={field.name} {...register(field.name, { required: (field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={field?.field_value?.uploaded_field}>
                                                        <option value=''>Select Option</option>
                                                        {field.field_options && field.field_options.map((option, index) => (
                                                            <option key={`${option.option_value}${index}`} value={option.option_value}>{option.option_name}</option>
                                                        ))}
                                                    </select>
                                                    {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                                                </div>
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
                                                <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control"  {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control"  {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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
                                                                    <label className="form-label" htmlFor="company-name">{`${formatLabel(child_field.description)}`}</label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="number" id={child_field.name} className="form-control" {...register(child_field.name, { required: (child_field.required ? 'This field is required' : false) })} onBlur={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field} />
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

                    {fields?.length > 0 && <>
                        <div className="actions clearfix">
                            <ul>
                                <li>
                                    <Button color="primary" type="submit" onClick={(e) => { }}>
                                        Next
                                    </Button>
                                </li>
                                <li>
                                    <Button color="primary" onClick={() => goBack()}>
                                        Previous
                                    </Button>
                                </li>
                            </ul>
                        </div>
                    </>}
                </>}
            </form>
        );

    };

    const DisciplinaryHistory = (props) => {

        useEffect(() => {
            if ($application_details) {
                dispatch(updateStep({ "application_id": $application_details?.id, "step": 3 }));
            }
        }, [dispatch]);



        const { reset, register, handleSubmit, formState: { errors }, setValue, clearErrors } = useForm();


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
                    dispatch(loadPageFields({ "page": "3", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
                } else {

                }

            } catch (error) {

            }
        };




        const updatedApplicationFields = useSelector((state) => state?.application?.all_fields) || null;
        const loadingPageFields = useSelector((state) => state?.application?.loadingPageFields) || null;
        const [applicationFields, setApplicationFields] = useState(overall_fields?.disciplinary);

        let fields = updatedApplicationFields ? (updatedApplicationFields[0]?.page == 3 ? updatedApplicationFields : applicationFields) : applicationFields

        const submitForm = async (data) => {



            dispatch(loadPageFields({ "page": "4", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            props.next()

        };

        const goBack = () => {

            // dispatch(loadAllFields({ "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            dispatch(loadPageFields({ "page": "2", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            props.prev()
        }

        useEffect(() => {
            console.log("DisciplinaryHistory")
            console.log(updatedApplicationFields)
            console.log(applicationFields)
        }, [updatedApplicationFields]);

        return (
            <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
                {fields && <>

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
                                                            <label className="form-label" htmlFor="company-name">{formatLabel(child_field.description)}</label>
                                                            <div className="form-control-wrap">

                                                                <div className="form-control-select" >
                                                                    {/* {child_field?.field_value?.uploaded_field} */}
                                                                    <select className="form-control form-select" type="select" name={child_field.name} id={child_field.name} {...register(child_field.name, { required: 'This field is required' })} onChange={(e) => onInputChange({ 'field_name': child_field.name, "field_value": e.target.value, "field_type": child_field.type })} defaultValue={child_field?.field_value?.uploaded_field}>
                                                                        <option value=''>Select Option</option>
                                                                        {child_field.field_options && child_field.field_options.map((option, index) => (
                                                                            <option key={`${option.option_value}${index}`} value={option.option_value}>{option.option_name}</option>
                                                                        ))}
                                                                    </select>
                                                                    {errors[child_field.name] && <span className="invalid">{errors[child_field.name].message}</span>}
                                                                </div>
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

                    {fields?.length > 0 && <>
                        <div className="actions clearfix">
                            <ul>
                                <li>
                                    <Button color="primary" type="submit" onClick={(e) => { }}>
                                        Next
                                    </Button>
                                </li>
                                <li>
                                    <Button color="primary" onClick={() => goBack()}>
                                        Previous
                                    </Button>
                                </li>
                            </ul>
                        </div>
                    </>}
                </>}
            </form>
        );
    };

    const SupportingDocuments = (props) => {
        useEffect(() => {
            if ($application_details) {
                dispatch(updateStep({ "application_id": $application_details?.id, "step": 4 }));
            }
        }, [dispatch]);

        const { reset, register, handleSubmit, formState: { errors }, setValue, clearErrors } = useForm();


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
                    dispatch(loadPageFields({ "page": "4", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
                } else {

                }

            } catch (error) {

            }
        };





        const updatedApplicationFields = useSelector((state) => state?.application?.all_fields) || null;
        const loadingPageFields = useSelector((state) => state?.application?.loadingPageFields) || null;
        const [applicationFields, setApplicationFields] = useState(overall_fields?.document);

        let fields = updatedApplicationFields ? (updatedApplicationFields[0]?.page == 4 ? updatedApplicationFields : applicationFields) : applicationFields

        const submitForm = async (data) => {

            dispatch(loadPageFields({ "page": "5", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            props.next()

        };

        const goBack = () => {
            // dispatch(loadAllFields({ "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            dispatch(loadPageFields({ "page": "3", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            props.prev()
        }

        useEffect(() => {
            console.log("SupportingDocuments")
            console.log(updatedApplicationFields)
            console.log(applicationFields)
        }, [updatedApplicationFields]);

        return (
            <form className="content clearfix" onSubmit={handleSubmit(submitForm)} encType="multipart/form-data">
                {fields?.length > 0 && <>
                    <h3>Supporting Documents</h3>

                    <Row className="gy-4">
                        {fields && fields.map((field, index) => {

                            if (field.type == 'file') {
                                return (
                                    <Col md="12" key={`${field.name}${index}`}>
                                        <div className="form-group">
                                            <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
                                            <div className="form-control-wrap">
                                                <div className="input-group">
                                                    <input type="file" accept="..jpg,.jpeg,.png,.pdf" id={field.name} className="form-control" onChange={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.files[0], "field_type": field.type })} style={{ display: field.field_value?.file_path ? 'none' : 'block' }} />
                                                    <label for={field.name} className="form-control" style={{ display: field.field_value?.file_path ? 'block' : 'none' }} >Document Uploaded</label>

                                                    <div className="input-group-append">
                                                        <input type="hidden" {...register(field.name, { required: (field.required ? 'This field is required' : false) })} value={field.field_value?.file_path ? field.field_value?.file_path : ''} />
                                                        {field.field_value?.file_path && <a href={field.field_value.file_path} target="_blank" className="btn btn-primary" > View File</a>}
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
                                <Button color="primary" type="submit" onClick={(e) => { }}>
                                    Next
                                </Button>
                            </li>
                            <li>
                                <Button color="primary" onClick={() => goBack()}>
                                    Previous
                                </Button>
                            </li>
                        </ul>
                    </div>
                </>}

            </form>
        );
    };

    const ApplicationDeclaration = (props) => {
        useEffect(() => {
            if ($application_details) {
                dispatch(updateStep({ "application_id": $application_details?.id, "step": 5 }));
            }
        }, [dispatch]);

        const { reset, register, handleSubmit, formState: { errors }, setValue, clearErrors } = useForm();

        const extra = useSelector((state) => state?.application?.list_extra) || null;

        useEffect(() => {
            if ($application_details) {

                dispatch(loadExtra({ "name": "applicantDeclaration", "category": $application_details?.membership_category?.id }));
            }

        }, [dispatch, $application_details]);


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
                    dispatch(loadPageFields({ "page": "5", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
                } else {

                }

            } catch (error) {

            }
        };


        const updatedApplicationFields = useSelector((state) => state?.application?.all_fields) || null;
        const loadingPageFields = useSelector((state) => state?.application?.loadingPageFields) || null;
        const [applicationFields, setApplicationFields] = useState(overall_fields?.declaration);

        let fields = updatedApplicationFields ? (updatedApplicationFields[0]?.page == 5 ? updatedApplicationFields : applicationFields) : applicationFields

        const submitForm = async (data) => {

            props.next()

        };

        const goBack = () => {
            // dispatch(loadAllFields({ "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            dispatch(loadPageFields({ "page": "4", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            props.prev()
        }


        return (
            <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
                {fields?.length > 0 && <>
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
                                            <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
                                            <div className="form-control-wrap">
                                                <div className="input-group">
                                                    <input type="file" accept=".jpg,.jpeg,.png,.pdf" id={field.name} className="form-control" onChange={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.files[0], "field_type": field.type })} style={{ display: field.field_value?.file_path ? 'none' : 'block' }} />
                                                    <label for={field.name} className="form-control" style={{ display: field.field_value?.file_path ? 'block' : 'none' }} >Document Uploaded</label>

                                                    <div className="input-group-append">
                                                        <input type="hidden" {...register(field.name, { required: 'This field is required' })} value={field.field_value?.file_path ? field.field_value?.file_path : ''} />
                                                        {field.field_value?.file_path && <a href={field.field_value.file_path} target="_blank" className="btn btn-primary" > View File</a>}
                                                    </div>
                                                </div>
                                                {errors[field.name] && <span className="invalid">{errors[field.name].message}</span>}
                                            </div>
                                        </div>

                                    </Col>

                                )
                            }

                        })}

                        <Col size="12">


                            <div className="custom-control custom-control-sm custom-checkbox notext">
                                <input
                                    type="checkbox"
                                    className="custom-control-input"
                                    id="uid1"
                                    key={Math.random()}
                                    {...register('consent', { required: 'This field is required' })}
                                />
                                <label className="custom-control-label" htmlFor="uid1"> Accept</label>

                                {errors.consent && (
                                    <span id="fv-com-error" className="invalid">
                                        This field is required
                                    </span>
                                )}
                            </div>

                        </Col>

                        {/* <Col md="12" className="col-12">
                  <div className="preview-block">
                    <OverlineTitle className="preview-title">Accept</OverlineTitle>
                    <div className="custom-control custom-checkbox image-control">
                      <input type="checkbox" className="custom-control-input" id="consent" defaultChecked={true} />
                      <label className="custom-control-label" htmlFor="consent">
                        Accept
                      </label>
                    </div>
                  </div>
                </Col> */}

                    </Row>
                    <div className="actions clearfix">
                        <ul>
                            <li>
                                <Button color="primary" type="submit" onClick={(e) => { }}>
                                    Next
                                </Button>
                            </li>
                            <li>
                                <Button color="primary" onClick={() => goBack()}>
                                    Previous
                                </Button>
                            </li>
                        </ul>
                    </div>
                </>}

            </form>
        );
    };

    const ApplicationCompleted = (props) => {

        return (
            <div className="flex flex-col justify-content-center align-items-center p-3">
                <div>
                    <BlockTitle tag="h2" className="text-center">
                        {/* Thank you for completing the Membership Application Form. Kindly proceed to Preview and Submit your Application. */}
                        Your Application has been submitted and is under review. You will be notified of any feedback soon
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

    const Header = (props) => {
        useEffect(() => {
            if ($application_details) {
                // console.log($application_details)
                // dispatch(fetchApplication({ "application_uuid": application_uuid }));

                // if (props.current != $application_details?.step) {
                props.jump($application_details?.step)
                // }
            }

        }, [])

        // console.log(props)
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
                </ul>
            </div>
        );
    };


    const config = {
        before: Header
    };


    const { reset, register, handleSubmit, formState: { errors }, setValue, clearErrors } = useForm();

    const [disclosureFile, setDisclosureFile] = useState([]);
    const handleFileChange = (event) => {
        setDisclosureFile(event.target.files[0]);
        setValue('signedDisclosureLetter', event.target.files[0])
    };
    const submitForm = async (data) => {

        uploadDisclosure('accept', disclosureFile)
        // props.next()

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

                                {/* <p>Please fill forms to complete your application</p> */}
                            </div>

                            <Modal isOpen={modalDisclosureStageView} toggle={toggleDisclosureStageView} size="lg">
                                <ModalHeader toggle={toggleDisclosureStageView} close={<button className="close" onClick={toggleDisclosureStageView}><Icon name="cross" /></button>}>
                                    Declaration of prior disclosure letter
                                </ModalHeader>
                                <ModalBody>
                                    {/* {!uploadView ? <> */}
                                    <Row className="gy-5">
                                        <Col md='12'>
                                            <Card className="card-bordered">
                                                <CardBody className="card-inner">
                                                    {/* {$application_details?.disclosure_content && <>
                                                        {`${$application_details?.disclosure_content?.body}`}
                                                    </>} */}

                                                    {!showDisclosureForm && <>

                                                        <p>Declaration of prior disclosure letter</p>
                                                        <p>{moment().format('MMM. D, YYYY HH:mm')}</p>

                                                        <p>DECLARATION OF PRIOR DISCLOSURE – [NAME OF MEMBER]</p>

                                                        <p>
                                                            With reference to [Name of Member’s] application for membership in the FMDQ Securities Exchange Limited (“FMDQ Exchange” or the “Exchange”) [Name of New Membership Category] membership category, we declare as follows:
                                                        </p>
                                                        {/* <p> */}
                                                        <ol className="">
                                                            <li>1. The required documents/disclosures for onboarding as a [Name of Previous Membership Category] have previously been provided to the Exchange.</li><br />
                                                            <li>2. The referenced documents/disclosures remain valid and subsisting and no amendment/alteration or material change has occurred, and no amendment has been made to the document(s) previously filed with and/or disclosure(s) made to the Exchange.</li><br />
                                                            <li>3. Where there is an amendment/alteration or material change in the documents/disclosures provided above, we shall upload the valid and subsisting documentation when completing the Application Form.</li><br />
                                                        </ol>
                                                        {/* </p> */}
                                                        <p><strong>Yours faithfully,</strong></p>
                                                        <p><strong>FOR: [Name of Member]</strong></p>
                                                        <br />
                                                        <br />
                                                        <br />
                                                        <br />
                                                        <br />
                                                        <p><strong>__________________________</strong></p>
                                                        <p><strong>[Authorised Signatory]</strong></p>

                                                        {/* </CardText> */}
                                                        <Button color="primary" onClick={() => setShowDisclosureForm(true)} className="mx-2">Accept</Button>
                                                        <Button color="warning" onClick={() => actionDisclosure('reject')} className="mx-2" >Reject</Button>
                                                    </>}

                                                    {showDisclosureForm && <>
                                                        <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>

                                                            <h3>Disclosure Letter</h3>
                                                            <p>the Declaration of Prior Disclosure should be downloaded and reproduced on your institution’s letterhead</p>
                                                            <ul>
                                                                <li>
                                                                    {$application_details?.disclosure_link && <a href={$application_details?.disclosure_link} target="_blank" className="btn btn-primary">Download  Disclosure Letter</a>}
                                                                </li>
                                                            </ul>
                                                            <Row className="gy-4">
                                                                <Col md="12" key={`'disclosure`}>
                                                                    <div className="form-group">
                                                                        <label className="form-label text-capitalize" htmlFor="company-name">Upload Signed Disclosure Letter</label>
                                                                        <div className="form-control-wrap">
                                                                            <div className="input-group">
                                                                                <input type="file" accept=".jpg,.jpeg,.png,.pdf" id="signedDisclosureLetter" className="form-control" onChange={handleFileChange} />

                                                                                <div className="input-group-append">
                                                                                    <input type="hidden" {...register('signedDisclosureLetter', { required: 'This field is required' })} onChange={handleFileChange} />
                                                                                    {/* {field.field_value?.file_path && <a href={field.field_value.file_path} target="_blank" className="btn btn-primary" > View File</a>} */}
                                                                                </div>
                                                                            </div>
                                                                            {errors['signedDisclosureLetter'] && <span className="invalid">{errors['signedDisclosureLetter'].message}</span>}
                                                                        </div>
                                                                    </div>

                                                                </Col>



                                                                <Col size="12">


                                                                </Col>


                                                            </Row>
                                                            <div className="actions clearfix">
                                                                <ul>
                                                                    <li>
                                                                        <Button color="primary" type="submit" onClick={(e) => { }}>
                                                                            Submit
                                                                        </Button>
                                                                    </li>
                                                                    <li>
                                                                        <Button color="warning" onClick={() => setShowDisclosureForm(false)}>
                                                                            Cancel
                                                                        </Button>
                                                                    </li>
                                                                </ul>
                                                            </div>


                                                        </form>
                                                    </>}
                                                </CardBody>
                                            </Card>
                                        </Col>
                                    </Row>
                                    {/* </> : <>
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
                                    </>} */}
                                </ModalBody>
                                <ModalFooter className="bg-light">
                                    <span className="sub-text">View Institutions</span>
                                </ModalFooter>
                            </Modal>

                            <div className="nk-wizard nk-wizard-simple is-alter wizard clearfix">


                                <Steps config={config} >
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

        </Content >
    </>;
};
// type="submit"
export default Form;
