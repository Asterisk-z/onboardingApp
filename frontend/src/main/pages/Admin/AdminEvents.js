import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import DatePicker from "react-datepicker"
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, MultiDatePicker, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
// import { loadAllActiveCategories } from "redux/stores/memberCategory/category";
// import { loadAllActivePositions } from "redux/stores/positions/positionStore";
// import { createCompetency, loadAllCompetency } from "redux/stores/competency/competencyStore";
import { megUpdateEvent, megDeleteEvent, loadAllEvent } from "redux/stores/education/eventStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminEventTable from './Tables/AdminEventTable'



const AdminEvents = ({ drawer }) => {

    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);

    const events = useSelector((state) => state?.educationEvent?.list_all) || null;

    useEffect(() => {
        dispatch(loadAllEvent({'show_past_events' : 1, "name" : "", "from_date" : "", "to_date" : ""}));
    }, [dispatch, parentState]);

    useEffect(() => {
        dispatch(megDeleteEvent());
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

    // const handleFormSubmit = async (values) => {
    //     // const formData = new FormData();
    //     // formData.append('name', values.name)
    //     // formData.append('description', values.description)
    //     // formData.append('position', values.position)
    //     // formData.append('member_category', values.member_category)
    //     console.log(values)
    //     // try {
    //     //     setLoading(true);

    //     //     const resp = await dispatch(createCompetency(formData));

    //     //     if (resp.payload?.message == "success") {
    //     //         setTimeout(() => {
    //     //             setLoading(false);
    //     //             setModalForm(!modalForm)
    //     //             resetField('name')
    //     //             resetField('description')
    //     //             resetField('position')
    //     //             resetField('member_category')
    //     //             setParentState(Math.random())
    //     //         }, 1000);
    //     //     } else {
    //     //       setLoading(false);
    //     //     }

    //     // } catch (error) {
    //     //     setLoading(false);
    //     // }

    // };

    const $events = events ? JSON.parse(events) : null;

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
                                                <span onClick={(e) => navigate(process.env.PUBLIC_URL + '/admin-create-event')}>Add new Event</span>
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
                                        {/* <BlockTitle tag="h4">All Membership</BlockTitle> */}
                                        {/* <p>{competencies}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$events && <AdminEventTable updateParent={updateParentState} parentState={parentState} data={$events} expandableRows pagination actions />}
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
