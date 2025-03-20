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
import { UpdateDisclosure, fetchApplicationDisclosureContent } from "redux/stores/membership/applicationProcessStore";
import moment from 'moment';
import Swal from "sweetalert2";




const ApplicantInformation = (props) => {

    const { application_uuid } = useParams();

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();

    const dispatch = useDispatch();
    const navigate = useNavigate();

    const [parentState, setParentState] = useState('0')
    const [showDisclosureModal, setShowDisclosureModal] = useState(false);

    const application_details = useSelector((state) => state?.application?.application_details) || null;
    const application_disclosure_details = useSelector((state) => state?.applicationProcess?.application_disclosure_details) || null;

    useEffect(() => {
        dispatch(fetchApplication({ "application_uuid": application_uuid }));
    }, [dispatch]);

    const $application_details = application_details ? JSON.parse(application_details) : null;
    const $application_disclosure_details = application_disclosure_details ? JSON.parse(application_disclosure_details) : null;

    const [unChangeableField, setUnChangeableField] = useState(["companyName", "rcNumber", "dateOfIncorporation", "placeOfIncorporation"]);

    const [modalDisclosureStageView, setModalDisclosureStageView] = useState(false);
    const [showDisclosureForm, setShowDisclosureForm] = useState(false);

    const toggleDisclosureStageView = () => setModalDisclosureStageView(!modalDisclosureStageView);
    const toggleDisclosureForm = () => setShowDisclosureForm(!showDisclosureForm);

    useEffect(() => {

        if ($application_details && !$application_details?.disclosure_stage && !showDisclosureModal) {
            dispatch(fetchApplicationDisclosureContent({ "application_uuid": application_uuid }));
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

    let $overall_fields = overall_fields;

    const uploadedValue = (field) => {
        // console.log(field);
        console.log(props.getState())
        if (field.type == 'date') {
            // new Date()
            return field?.field_value?.uploaded_field ? new Date(field?.field_value?.uploaded_field) : new Date();
        }

        return field?.field_value?.uploaded_field ? field?.field_value?.uploaded_field : "";
    }



    useEffect(() => {
        if ($application_details) {
            dispatch(updateStep({ "application_id": $application_details?.id, "step": 1 }));
        }
    }, [dispatch]);

    const { reset, register, handleSubmit, formState: { errors }, setValue, clearErrors } = useForm();

    const applicationFields = overall_fields?.basic;

    let fields = applicationFields

    const uploadFieldValue = (values) => {
        console.log(fields);
        console.log(values);

        // const { next, prev, getState, setState } = props;

        fields = fields.map((item) => {
            if (item.name == values.field_name && item.type == values.field_type) {

                return {
                    ...item,
                    field_value: {
                        ...item.field_value,
                        "uploaded_field": values.field_value,
                        fsfs: values.field_value
                    }
                };

            }
            return item
        })

    }


    const onInputChange = async (values) => {

        if (!values.field_value || !values.field_name || !values.field_type) return
        setValue(values.field_name, values.field_value)
        clearErrors(values.field_name)
        uploadFieldValue(values);
        const postValues = new Object();
        postValues.field_name = values.field_name;
        postValues.field_value = values.field_value;
        postValues.field_type = values.field_type;
        postValues.application_id = $application_details?.id;
        postValues.category_id = $application_details?.membership_category?.id;

        try {

            // const resp = await dispatch(uploadField(postValues));

            // if (resp.payload?.message == "success") {
            //     dispatch(loadPageFields({ "page": "1", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            // } else {

            // }

        } catch (error) {

        }
    };

    const updatedApplicationFields = useSelector((state) => state?.application?.all_fields) || null;
    // const loadingPageFields = useSelector((state) => state?.application?.loadingPageFields) || null;
    // const [applicationFields, setApplicationFields] = useState(overall_fields?.basic);


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

        console.log(list)

        try {

            // const postValues = new Object();
            // postValues.application_id = $application_details?.id;
            // postValues.category_id = $application_details?.membership_category?.id;
            // postValues.fields = list;
            // const resp = await dispatch(submitPage(postValues));

            // if (resp.payload?.message == "success") {
            //     dispatch(loadPageFields({ "page": "1", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
            // }

            props.next()
        } catch (error) {

        }

    };

    const goBack = () => {
        // dispatch(loadPageFields({ "page": "1", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
        props.prev()
    }


    useEffect(() => {

        if (updatedApplicationFields) {
            if (updatedApplicationFields[0]?.page == 1) {

                // console.log("ApplicantInformation")
                // console.log(loadingPageFields)
                // console.log(updatedApplicationFields)
                // console.log(applicationFields)
                fields = updatedApplicationFields
            }
        }

    }, [updatedApplicationFields, applicationFields]);

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
                                            <label className="form-label" htmlFor="company-name">{formatLabel(field.description)}</label>
                                            <div className="form-control-wrap">
                                                <input type="text" id={field.name} className="form-control"
                                                    {...register(field.name, { required: 'This field is required' })}
                                                    onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })}
                                                    defaultValue={uploadedValue(field)}
                                                    readOnly={($application_details?.disclosure_status && unChangeableField.includes(field.name) && field?.field_value?.uploaded_field)} />
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
                                                <input type="url" placeholder="http://example.com" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={uploadedValue(field)} readOnly={($application_details?.disclosure_status && unChangeableField.includes(field.name) && field?.field_value?.uploaded_field)} />
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

                                                <input type="hidden" {...register(field.name, { required: 'This field is required' })} value={uploadedValue(field)} />
                                                <DatePicker selected={uploadedValue(field)}
                                                    id={field.name} onChange={(e) => onInputChange({ 'field_name': field.name, "field_value": e, "field_type": field.type })}
                                                    className="form-control date-picker"
                                                    readOnly={($application_details?.disclosure_status && unChangeableField.includes(field.name) && field?.field_value?.uploaded_field)} />
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
                                                <input type="text" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required', pattern: { value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i, message: "Invalid email address" }, })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={uploadedValue(field)} />
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
                                                <input type="number" id={field.name} className="form-control" {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={uploadedValue(field)} readOnly={($application_details?.disclosure_status && unChangeableField.includes(field.name) && field?.field_value?.uploaded_field)} />
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
                                                    <select className="form-control form-select" type="select" name={field.name} id={field.name} {...register(field.name, { required: 'This field is required' })} onBlur={(e) => onInputChange({ 'field_name': field.name, "field_value": e.target.value, "field_type": field.type })} defaultValue={uploadedValue(field)} readOnly={($application_details?.disclosure_status && unChangeableField.includes(field.name) && field?.field_value?.uploaded_field)}>
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
    // };



};

export default ApplicantInformation;
