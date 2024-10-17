import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import DatePicker from "react-datepicker"
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllActiveCategories } from "redux/stores/memberCategory/category";
import { loadAllCategoryPositions } from "redux/stores/positions/positionStore";
import { megCreateEvent } from "redux/stores/education/eventStore";
import Content from "layout/content/Content";
import MultiDatePicker from "main/pages/Components/EventDatePicker";
import Head from "layout/head/Head";
import moment from "moment";


const AdminEvents = ({ drawer }) => {

    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);

    const categories = useSelector((state) => state?.category?.list) || null;
    const positions = useSelector((state) => state?.position?.list) || null;

    useEffect(() => {
        dispatch(loadAllActiveCategories());
    }, [dispatch]);


    const { register, handleSubmit, formState: { errors }, resetField, getValues, setValue } = useForm();
    const [todaysDate, setTodaysDate] = useState(new Date());
    const [eventTime, setEventTime] = useState(new Date());
    const [eventDate, setEventDate] = useState(new Date());
    const [unregisteredDate, setUnregisteredDate] = useState("");
    const [registeredDate, setRegisteredDate] = useState("");
    const [unregisteredFrequency, setUnregisteredFrequency] = useState(false);
    const [registeredFrequency, setRegisteredFrequency] = useState(false);
    const [isEventFree, setIsEventFree] = useState(false);



    const toggleForm = () => setModalForm(!modalForm);
    const toggleEvent = () => setIsEventFree(!isEventFree);

    const handleFormSubmit = async (values) => {

        const postValues = new Object();
        postValues.name = values.name;
        postValues.description = values.description;
        postValues.date = moment(eventDate).format('YYYY-MM-DD');
        postValues.time = moment(eventTime).format('HH:mm');
        postValues.is_annual = values.isEventAnnual == 'no' ? 0 : 1;
        postValues.fee = values.isEventFree == 'no' ? values.eventFee : 0;
        postValues.img = values.img[0];
        postValues.registered_remainder_frequency = values.registered_remainder_frequency;
        postValues.registered_remainder_dates = values.registered_remainders && values.registered_remainder_frequency ? values.registered_remainders : '';
        postValues.unregistered_remainder_frequency = values.unregistered_remainder_frequency;
        postValues.unregistered_remainder_dates = values.unregistered_remainders && values.unregistered_remainder_frequency ? values.unregistered_remainders : '';
        postValues.positions = values.positions.map((val) => (val.value));

        try {
            setLoading(true);

            const resp = await dispatch(megCreateEvent(postValues));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    navigate(process.env.PUBLIC_URL + '/admin-events')
                }, 1000);
            } else {
                setLoading(false);
            }

        } catch (error) {

            setLoading(false);
        }

    };

    const $categories = categories ? JSON.parse(categories) : null;
    const $positions = positions ? JSON.parse(positions) : null;
    const $positionOptions = $positions ? $positions.map((val) => ({ 'label': val.name, 'value': val.id })) : {}
    const $categoryOptions = $categories ? $categories.map((val) => ({ 'label': val.name, 'value': val.id })) : {}


    const update_unregistered_remainders = (unregistered_remainders) => {
        if (unregistered_remainders) {
            let dates = unregistered_remainders.map((item) => moment(item).format('YYYY-MM-DD')).toString()
            setUnregisteredDate(dates)
            setValue('unregistered_remainders', dates)
        }
    };

    const update_registered_remainders = (registered_remainders) => {

        if (registered_remainders) {
            let dates = registered_remainders.map((item) => moment(item).format('YYYY-MM-DD')).toString()
            setRegisteredDate(dates)
            setValue('registered_remainders', dates)
        }
    };

    const updateCategory = (value) => {
        setValue('category', value)
        const category = getValues('category').map((val) => (val.value))
        dispatch(loadAllCategoryPositions({ 'category_ids': category }));
    };

    const toggleEventDate = (value) => {
        setUnregisteredDate("")
        setRegisteredDate("")
        setValue('unregistered_remainders', '')
        setValue('registered_remainders', '')
        // update_unregistered_remainders('')
        // update_registered_remainders('')
        setEventDate(value)
    };

    const updateRegisteredFrequency = (value) => {
        setRegisteredFrequency(value)
        toggleEventDate(eventDate)
    };

    const updateUnRegisteredFrequency = (value) => {
        setUnregisteredFrequency(value)
        toggleEventDate(eventDate)
    };

    const checking = () => {

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
                                                        <DatePicker selected={eventDate} onChange={(date) => toggleEventDate(date)} className="form-control date-picker" id="date" minDate={todaysDate} dateFormat="dd/MM/yyyy" />
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
                                                                    <input type="radio" className="custom-control-input" name="isEventFree" value={'yes'} id="isEventFreeYes" onClick={() => setIsEventFree(false)}  {...register('isEventFree', { required: "This Field is required" })} defaultChecked={true} />
                                                                    <label className="custom-control-label" htmlFor="isEventFreeYes">
                                                                        Yes it is Free
                                                                    </label>
                                                                </div>
                                                            </li>
                                                            <li>
                                                                <div className="custom-control custom-radio custom-control-pro no-control checked">
                                                                    <input type="radio" className="custom-control-input" name="isEventFree" value={'no'} id="isEventFreeNo" onClick={() => setIsEventFree(true)}  {...register('isEventFree', { required: "This Field is required" })} />
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
                                                        Event Registration Fee
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <input type="number" onKeyUp={(value) => !isNaN(parseInt(value.target.value)) ? value.target.value = parseInt(value.target.value) : ""} id="eventFee" className="form-control" {...register('eventFee', { required: "This Field is required", valueAsNumber: true, })} />
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
                                                        <input type="file" id="file" accept="image/*" className="form-control" {...register('img', { required: "This Field is required" })} />
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
                                                            <select className="form-control form-select" {...register('registered_remainder_frequency')} id="registered_remainder_frequency" onChange={(value) => updateRegisteredFrequency(value.target.value)} >
                                                                <option value="">Select Frequency</option>
                                                                <option value=''>None</option>
                                                                <option value='Daily'>Daily</option>
                                                                <option value='Weekly'>Weekly</option>
                                                                <option value='Monthly'>Monthly</option>
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
                                                        <input type="hidden" {...register('registered_remainders')} value={registeredDate} />
                                                        {/* <input type="hidden" {...register('registered_remainders', { required: "This Field is required" })} value={registeredDate} /> */}
                                                        <MultiDatePicker nameAttr='registered_remainders' changeAction={update_registered_remainders} max={eventDate} reminderType={registeredFrequency} />
                                                        {errors.registered_remainders && <span className="invalid">{"This Field is required"}</span>}
                                                    </div>
                                                </div>
                                            </Col>

                                            <Col sm="6">
                                                <div className="form-group" >
                                                    <label htmlFor="unregistered_remainder_frequency" className="form-label">
                                                        Send Reminder to the Non-Registered ARs
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <select className="form-control form-select" {...register('unregistered_remainder_frequency')} id="unregistered_remainder_frequency" onChange={(value) => updateUnRegisteredFrequency(value.target.value)} >
                                                                <option value="">Select Frequency</option>
                                                                <option value=''>None</option>
                                                                <option value='Daily'>Daily</option>
                                                                <option value='Weekly'>Weekly</option>
                                                                <option value='Monthly'>Monthly</option>
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
                                                        <input type="hidden" {...register('unregistered_remainders')} value={unregisteredDate} />
                                                        {/* <input type="hidden" {...register('unregistered_remainders', { required: "This Field is required" })} value={unregisteredDate} /> */}
                                                        <MultiDatePicker nameAttr='unregistered_remainders' changeAction={update_unregistered_remainders} max={eventDate} reminderType={unregisteredFrequency}
                                                        // properties={{ 'readOnly': (!unregisteredFrequency || unregisteredFrequency == 'none') ? true : false }} 
                                                        />
                                                        {errors.unregistered_remainders && <span className="invalid">{'This Field is required'}</span>}
                                                    </div>
                                                </div>

                                            </Col>

                                            <Col md='6'>
                                                <div className="form-group">

                                                    <label className="form-label" htmlFor="position">
                                                        Category
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <input type="hidden" {...register('category', { required: "This Field is Required" })} />
                                                            <RSelect name="category" isMulti options={$categoryOptions} onChange={(value) => updateCategory(value)} />
                                                            {errors.category && <p className="invalid">{`${errors.category.message}`}</p>}
                                                        </div>
                                                    </div>
                                                </div>

                                            </Col>
                                            <Col md='6'>
                                                <div className="form-group">

                                                    <label className="form-label" htmlFor="position">
                                                        Position
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <input type="hidden" {...register('positions', { required: "This Field is Required" })} />
                                                            {$positions ? <><RSelect name="positions" isMulti options={$positionOptions} onChange={(value) => setValue('positions', value)} /></> : <><input type="text" disabled className="form-control" /></>}
                                                            {errors.positions && <p className="invalid">{`${errors.positions.message}`}</p>}
                                                        </div>
                                                    </div>
                                                </div>

                                            </Col>
                                            <Col md='12'>
                                                <div className="form-group">
                                                    <Button color="primary" type="submit" size="lg" onClick={checking}>
                                                        {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Submit"}
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
