import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import DatePicker from "react-datepicker"
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, MultiDatePicker, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllActiveCategories } from "redux/stores/memberCategory/category";
import { loadAllActivePositions } from "redux/stores/positions/positionStore";
import { createCompetency, loadAllCompetency } from "redux/stores/competency/competencyStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import moment from "moment";


const AdminEvents = ({ drawer }) => {

    const dispatch = useDispatch();

    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);

    const categories = useSelector((state) => state?.category?.list) || null;
    const positions = useSelector((state) => state?.position?.list) || null;
    const competencies = useSelector((state) => state?.competency?.list) || null;

    useEffect(() => {
        dispatch(loadAllCompetency());
    }, [dispatch, parentState]);

    useEffect(() => {
        dispatch(loadAllActivePositions());
        dispatch(loadAllActiveCategories());
    }, [dispatch]);


    const { register, handleSubmit, formState: { errors }, resetField, getValues, setValue } = useForm();
    const [eventTime, setEventTime] = useState(new Date());
    const [eventDate, setEventDate] = useState(new Date());
    const [unregisteredDate, setUnregisteredDate] = useState("");
    const [registeredDate, setRegisteredDate] = useState("");
    const [unregisteredFrequency, setUnregisteredFrequency] = useState("");
    const [registeredFrequency, setRegisteredFrequency] = useState("");
    const [isEventFree, setIsEventFree] = useState(false);
    const [formData, setFormData] = useState({
        category: [],
    });

    const today = new Date()
    const tomorrow = new Date()

    tomorrow.setDate(tomorrow.getDate() + 1)

    const [values, setValues] = useState([today, tomorrow])


    const toggleForm = () => setModalForm(!modalForm);
    const toggleEvent = () => setIsEventFree(!isEventFree);

    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('name', values.name)
        formData.append('description', values.description)
        formData.append('position', values.position)
        formData.append('member_category', values.member_category)
        console.log(values, isEventFree)
        // try {
        //     setLoading(true);

        //     const resp = await dispatch(createCompetency(formData));

        //     if (resp.payload?.message == "success") {
        //         setTimeout(() => {
        //             setLoading(false);
        //             setModalForm(!modalForm)
        //             resetField('name')
        //             resetField('description')
        //             resetField('position')
        //             resetField('member_category')
        //             setParentState(Math.random())
        //         }, 1000);
        //     } else {
        //       setLoading(false);
        //     }

        // } catch (error) {
        //     setLoading(false);
        // }

    };

    const $positions = positions ? JSON.parse(positions) : null;
    const $positionOptions = $positions ? $positions.map((val) => ({ 'label': val.name, 'value': val.id })) : {}


    const update_unregistered_remainders = (unregistered_remainders) => {
        if (unregistered_remainders) {
            setUnregisteredDate(unregistered_remainders.toString())
            setValue('unregistered_remainders', unregistered_remainders.toString())
        }

    };

    const update_registered_remainders = (registered_remainders) => {
        if (registered_remainders) {
            setRegisteredDate(registered_remainders.toString())
            setValue('registered_remainders', registered_remainders.toString())
        }
    };

    const updateRegisteredFrequency = (value) => {
        console.log(value.target.value)
    };



    const checking = () => {
        console.log(errors, isEventFree);
    };


    return (
        <React.Fragment>
            <Head title="Conference And Events"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Create New  Events
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" >
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={(e) => navigate(process.env.PUBLIC_URL + '/admin-events')}>Back</span>
                                            </Button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>


                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>

                                    <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                                        <Row className={`justify g-2 `}>
                                            <Col md='12'>
                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="name">
                                                        Name Of Event
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <input type="text" id="name" className="form-control" {...register('name', { required: "This Field is required" })} />
                                                        {errors.name && <span className="invalid">{errors.name.message}</span>}
                                                    </div>
                                                </div>
                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="description">
                                                        Description
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <textarea id="description" className="form-control" {...register('description', { required: "This Field is required" })} ></textarea>
                                                        {errors.description && <span className="invalid">{errors.description.message}</span>}
                                                    </div>
                                                </div>
                                            </Col>
                                            <Col md='6'>
                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="date">
                                                        Date
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <input type="hidden" {...register('eventDate', { required: "This Field is required" })} value={eventDate} />
                                                        <DatePicker selected={eventDate} onChange={(date) => setEventDate(date)} className="form-control date-picker" id="date" />
                                                        {errors.eventDate && <span className="invalid">{errors.eventDate.message}</span>}
                                                    </div>
                                                </div>
                                            </Col>
                                            <Col md='6'>
                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="time">
                                                        Time
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <input type="hidden" {...register('eventTime', { required: "This Field is required" })} value={eventTime} />
                                                        <DatePicker selected={eventTime} onChange={(time) => setEventTime(time)} id="time" showTimeSelect showTimeSelectOnly timeIntervals={15} timeCaption="Time" dateFormat="h:mm aa" className="form-control date-picker" />
                                                        {errors.eventTime && <span className="invalid">{errors.eventTime.message}</span>}
                                                    </div>
                                                </div>
                                            </Col>
                                            <Col md='6'>

                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="isEventAnnual">
                                                        Is it an Annual Event?
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <ul className="custom-control-group" id="isEventAnnual">
                                                            <li>
                                                                <div className="custom-control custom-radio custom-control-pro no-control checked">
                                                                    <input type="radio" className="custom-control-input" name="isEventAnnual" value={'yes'} id="isEventAnnualYes"  {...register('isEventAnnual', { required: "This Field is required" })} defaultChecked={true} />
                                                                    <label className="custom-control-label" htmlFor="isEventAnnualYes">
                                                                        Yes it is
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div className="custom-control custom-radio custom-control-pro no-control checked">
                                                                    <input type="radio" className="custom-control-input" name="isEventAnnual" value={'no'} id="isEventAnnualNo"  {...register('isEventAnnual', { required: "This Field is required" })} />
                                                                    <label className="custom-control-label" htmlFor="isEventAnnualNo">
                                                                        No it is not
                                                                    </label>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        {errors.isEventAnnual && <span className="invalid">{errors.isEventAnnual.message}</span>}
                                                    </div>
                                                </div>
                                            </Col>

                                            <Col md='6'>

                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="isEventFree">
                                                        Is it a free Event?
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <ul className="custom-control-group" id="isEventFree">
                                                            <li>
                                                                <div className="custom-control custom-radio custom-control-pro no-control checked">
                                                                    <input type="radio" className="custom-control-input" name="isEventFree" value={'yes'} id="isEventFreeYes" onClick={toggleEvent}  {...register('isEventFree', { required: "This Field is required" })} defaultChecked={true} />
                                                                    <label className="custom-control-label" htmlFor="isEventFreeYes">
                                                                        Yes it is
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div className="custom-control custom-radio custom-control-pro no-control checked">
                                                                    <input type="radio" className="custom-control-input" name="isEventFree" value={'no'} id="isEventFreeNo" onClick={toggleEvent}  {...register('isEventFree', { required: "This Field is required" })} />
                                                                    <label className="custom-control-label" htmlFor="isEventFreeNo">
                                                                        No it is not
                                                                    </label>
                                                                </div>
                                                            </li>

                                                        </ul>
                                                        {errors.isEventFree && <span className="invalid">{errors.isEventFree.message}</span>}
                                                    </div>
                                                </div>
                                            </Col>
                                            {isEventFree && <Col md='12'>
                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="eventFee">
                                                        Event Fee
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <input type="number" id="eventFee" className="form-control" {...register('eventFee', { required: "This Field is required", valueAsNumber: true, })} defaultValue={0} />
                                                        {errors.eventFee && <span className="invalid">{errors.eventFee.message}</span>}
                                                    </div>
                                                </div>
                                            </Col>}

                                            <Col md='12'>
                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="file">
                                                        Event Picture
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <input type="file" id="file" className="form-control" {...register('img', { required: "This Field is required" })} />
                                                        {errors.img && <span className="invalid">{errors.img.message}</span>}
                                                    </div>
                                                </div>
                                            </Col>

                                            <Col sm="6">
                                                <div className="form-group">
                                                    <label htmlFor="registered_remainder_frequency" className="form-label">
                                                        Send Reminder to the Registered ARs
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            {/* <select className="form-control form-select" {...register('registered_remainder_frequency')} id="registered_remainder_frequency" onChange={(value) => updateRegisteredFrequency(value)} > */}
                                                            <select className="form-control form-select" {...register('registered_remainder_frequency')} id="registered_remainder_frequency" onChange={(value) => setRegisteredFrequency(value.target.value)} >
                                                                <option value="">Select Frequency</option>
                                                                <option value='none'>None</option>
                                                                <option value='daily'>Daily</option>
                                                                <option value='weekly'>Weekly</option>
                                                                <option value='monthly'>Monthly</option>
                                                            </select>
                                                            {errors.registered_remainder_frequency && <p className="invalid">{`${errors.registered_remainder_frequency.message}`}</p>}
                                                        </div>
                                                    </div>
                                                </div>
                                            </Col>

                                            <Col md='6'>
                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="date">
                                                        Select Reminder Dates For Registered ARs
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        {/* {getValues('registered_remainder_frequency')} */}
                                                        <input type="hidden" {...register('registered_remainders', { required: "This Field is required" })} value={registeredDate} />
                                                        <MultiDatePicker nameAttr='registered_remainders' changeAction={update_registered_remainders} max={getValues('eventDate')} properties={{ 'readOnly': (!registeredFrequency || registeredFrequency == 'none') ? true : false }} />
                                                        {errors.registered_remainders && <span className="invalid">{errors.registered_remainders.message}</span>}
                                                    </div>
                                                </div>
                                            </Col>

                                            <Col sm="6">
                                                <div className="form-group">
                                                    <label htmlFor="unregistered_remainder_frequency" className="form-label">
                                                        Send Reminder to the Non-Registered ARs
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <select className="form-control form-select" {...register('unregistered_remainder_frequency')} id="unregistered_remainder_frequency" onChange={(value) => setUnregisteredFrequency(value.target.value)} >
                                                                <option value="">Select Frequency</option>
                                                                <option value='none'>None</option>
                                                                <option value='daily'>Daily</option>
                                                                <option value='weekly'>Weekly</option>
                                                                <option value='monthly'>Monthly</option>
                                                            </select>
                                                            {errors.unregistered_remainder_frequency && <p className="invalid">{`${errors.unregistered_remainder_frequency.message}`}</p>}
                                                        </div>
                                                    </div>
                                                </div>
                                            </Col>

                                            <Col md='6'>
                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="date">
                                                        Select Reminder Dates For Non-Registered ARs
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        {/* {getValues('unregistered_remainder_frequency')} */}
                                                        <input type="hidden" {...register('unregistered_remainders', { required: "This Field is required" })} value={unregisteredDate} />
                                                        <MultiDatePicker nameAttr='unregistered_remainders' changeAction={update_unregistered_remainders} max={getValues('eventDate')} properties={{ 'readOnly': (!unregisteredFrequency || unregisteredFrequency == 'none') ? true : false }} />
                                                        {errors.unregistered_remainders && <span className="invalid">{errors.unregistered_remainders.message}</span>}
                                                    </div>
                                                </div>
                                            </Col>

                                            <Col md='12'>
                                                <div className="form-group">

                                                    <label className="form-label" htmlFor="position">
                                                        Position
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <input type="hidden" {...register('positions', { required: "This Field is Required" })} />
                                                            <RSelect name="category" isMulti options={$positionOptions} onChange={(value) => setValue('positions', value)} />
                                                            {errors.positions && <p className="invalid">{`${errors.positions.message}`}</p>}
                                                        </div>
                                                    </div>
                                                </div>

                                            </Col>
                                            <Col md='12'>
                                                <div className="form-group">
                                                    <Button color="primary" type="submit" size="lg" onClick={checking}>
                                                        {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Create"}
                                                    </Button>
                                                </div>
                                            </Col>


                                        </Row>
                                    </form>
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminEvents;
