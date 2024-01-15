import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import DatePicker from "react-datepicker"
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, MultiDatePicker, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { MEGFSGLoadAllEventRegistration } from "redux/stores/education/eventStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminEventRegistrationTable from './Tables/AdminEventRegistrationTable'



const AdminEvents = ({ drawer }) => {

    const { event_id } = useParams();
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);

    const event_registrations = useSelector((state) => state?.educationEvent?.list_all_registrations) || null;

    useEffect(() => {
        dispatch(MEGFSGLoadAllEventRegistration({'event_id' : event_id}));
    }, [dispatch, parentState]);

    const $event_registrations = event_registrations ? JSON.parse(event_registrations) : null;

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
                                ARs Event Registrations
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
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
                                        {/* <p>{events}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$event_registrations && <AdminEventRegistrationTable updateParent={updateParentState} parentState={parentState} data={$event_registrations} expandableRows pagination actions />}
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
