import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import DatePicker from "react-datepicker"
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween,MultiDatePicker, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllActiveCategories } from "redux/stores/memberCategory/category";
import { loadAllActivePositions } from "redux/stores/positions/positionStore";
import { createCompetency, loadAllCompetency } from "redux/stores/competency/competencyStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminCompetencyTable from './Tables/AdminCompetencyTable'



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

    
    const { register, handleSubmit, formState: { errors }, resetField, getValues } = useForm();
    const [eventTime, setEventTime] = useState(new Date());
    const [eventDate, setEventDate] = useState(new Date());
    const [isEventFree, setIsEventFree] = useState(true);
  const today = new Date()
  const tomorrow = new Date()

  tomorrow.setDate(tomorrow.getDate() + 1)

  const [values, setValues] = useState([today, tomorrow])
 
 
    const toggleForm = () => setModalForm(!modalForm);

    const handleFormSubmit = async (values) => {
        // const formData = new FormData();
        // formData.append('name', values.name)
        // formData.append('description', values.description)
        // formData.append('position', values.position)
        // formData.append('member_category', values.member_category)
    console.log(values)
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
    
    const $categories = categories ? JSON.parse(categories) : null;
    const $positions = positions ? JSON.parse(positions) : null;
    const $competencies = competencies ? JSON.parse(competencies) : null;
    
    const updateParentState = (newState) => {
        setParentState(newState);
    };


    return (
        <React.Fragment>
            <Head title="Conference And Events"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Conference And Events
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" >
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={toggleForm}>Add new Event</span>
                                            </Button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                <Modal isOpen={modalForm} toggle={toggleForm} size="lg">
                    <ModalHeader toggle={toggleForm} close={
                            <button className="close" onClick={toggleForm}>
                                <Icon name="cross" />
                            </button>
                        }
                    >
                        Create Competency
                    </ModalHeader>
                    <ModalBody>
                        <form  onSubmit={handleSubmit(handleFormSubmit)}  className="is-alter" encType="multipart/form-data">
                            <Row className={`justify g-2 `}>
                                <Col md='12'>     
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="name">
                                            Name Of Event
                                        </label>
                                        <div className="form-control-wrap">
                                            <input type="text" id="name" className="form-control" {...register('name', { required: "This Field is required" })}  />
                                            {errors.name && <span className="invalid">{ errors.name.message }</span>}
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
                                            <input type="hidden" {...register('date', { required: "This Field is required" })} value={eventDate}/>
                                            <DatePicker selected={eventDate} onChange={(date) => setEventDate(date)} className="form-control date-picker"  id="date"   />
                                            {errors.date && <span className="invalid">{ errors.date.message }</span>}
                                        </div>
                                    </div>
                                </Col>
                                <Col md='6'>
                                    <div className="form-group">
                                        <label className="form-label" htmlFor="time">
                                            Time
                                        </label>
                                        <div className="form-control-wrap">
                                            <input type="hidden" {...register('time', { required: "This Field is required" })} value={eventTime}/>
                                             <DatePicker selected={eventTime} onChange={(time) => setEventTime(time)} id="time"  showTimeSelect showTimeSelectOnly timeIntervals={15} timeCaption="Time" dateFormat="h:mm aa"  className="form-control date-picker"/>
                                            {errors.time && <span className="invalid">{ errors.time.message }</span>}
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
                                                        <input type="radio" className="custom-control-input" name="isEventAnnual" value={'yes'} id="isEventAnnualYes"  {...register('isEventAnnual', { required: "This Field is required" })}  defaultChecked={true}/>
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
                                            {errors.isEventAnnual && <span className="invalid">{ errors.isEventAnnual.message }</span>}
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
                                                        <input type="radio" className="custom-control-input" name="isEventFree" value={'yes'} id="isEventFreeYes" onChange={(ev) => setIsEventFree(!isEventFree)}  {...register('isEventFree', { required: "This Field is required" })}  defaultChecked={true}/>
                                                        <label className="custom-control-label" htmlFor="isEventFreeYes">
                                                        Yes it is
                                                        </label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div className="custom-control custom-radio custom-control-pro no-control checked">
                                                        <input type="radio" className="custom-control-input" name="isEventFree" value={'no'} id="isEventFreeNo" onChange={(ev) => setIsEventFree(!isEventFree)}  {...register('isEventFree', { required: "This Field is required" })} />
                                                        <label className="custom-control-label" htmlFor="isEventFreeNo">
                                                            No it is not
                                                        </label>
                                                    </div>
                                                </li>
                                            </ul>
                                            {errors.isEventFree && <span className="invalid">{ errors.isEventFree.message }</span>}
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
                                            <input type="file" id="file" className="form-control" {...register('img', { required: "This Field is required" })}  />
                                            {errors.img && <span className="invalid">{ errors.img.message }</span>}
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
                                                <select className="form-control form-select" {...register('registered_remainder_frequency')} id="registered_remainder_frequency" >
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
                                            <input type="hidden" {...register('date', { required: "This Field is required" })} value={eventDate} />
                                                <MultiDatePicker />
                                            {/* <DatePicker selected={eventDate} onChange={(date) => setEventDate(date)} className="form-control date-picker"  id="date"   /> */}
                                            {errors.date && <span className="invalid">{ errors.date.message }</span>}
                                        </div>
                                    </div>
                                </Col>
                                
                                <Col sm="6">
                                    <div className="form-group">
                                        <label htmlFor="unregistered_remainder_frequency" className="form-label">
                                            Send Reminder to the UnRegistered ARs
                                        </label>
                                        <div className="form-control-wrap">
                                            <div className="form-control-select">
                                                <select className="form-control form-select" {...register('unregistered_remainder_frequency')} id="unregistered_remainder_frequency" >
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
                                            Select Reminder Dates For Unregistered ARs
                                        </label>
                                        <div className="form-control-wrap">
                                            <input type="hidden" {...register('date', { required: "This Field is required" })} value={eventDate}/>
                                            <DatePicker selected={eventDate} onChange={(date) => setEventDate(date)} className="form-control date-picker"  id="date"   />
                                            {errors.date && <span className="invalid">{ errors.date.message }</span>}
                                        </div>
                                    </div>
                                </Col>








                            <div className="form-group">
                                <label className="form-label" htmlFor="member_category">
                                    Membership Category
                                </label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select" id="member_category"  style={{ color: "black !important" }} {...register('member_category', { required: "This Field is Required" })}>
                                        <option value="">Select Membership Category</option>
                                        {$categories && $categories?.map((category) => (
                                            <option key={category.id} value={category.id}>
                                                {category.name}
                                            </option>
                                        ))}
                                        </select>
                                        {errors.member_category && <p className="invalid">{`${errors.member_category.message}`}</p>}
                                    </div>
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="position">
                                    Position
                                </label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select" id="position" style={{ color: "black !important" }} {...register('position', { required: "THis Field is Required" })}>
                                        <option value="">Select Position</option>
                                        {$positions && $positions?.map((position) => (
                                            <option key={position.id} value={position.id}>
                                                {position.name}
                                            </option>
                                        ))}
                                        </select>
                                        {errors.positions && <p className="invalid">{`${errors.positions.message}`}</p>}
                                    </div>
                                </div>
                            </div>
                            <div className="form-group">
                                <Button color="primary" type="submit"  size="lg">
                                    {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : "Create"}
                                </Button>
                            </div>

                            </Row>
                        </form>
                    </ModalBody>
                    <ModalFooter className="bg-light">
                        <span className="sub-text">Competencies</span>
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>


                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        {/* <BlockTitle tag="h4">All Membership</BlockTitle> */}
                                        {/* <p>{competencies}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$competencies && <AdminCompetencyTable  updateParent={updateParentState} parentState={parentState} data={$competencies} positions={$positions} categories={$categories} expandableRows pagination actions />}
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
