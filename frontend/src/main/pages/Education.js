import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllActiveComplaintTypes } from "redux/stores/complaints/complaintTypes";
import { sendComplaint, loadAllComplaints } from "redux/stores/complaints/complaint";
import { loadAllInvitedEvent, arEventRegistration } from "redux/stores/education/eventStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import EducationTable from './Tables/EducationTable'



const EducationAndLearning = ({ drawer }) => {
        
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [sm, updateSm] = useState(false);

    const invitedEvents = useSelector((state) => state?.educationEvent?.list_all_invited) || null;

    useEffect(() => {
        dispatch(loadAllInvitedEvent());
    }, [dispatch]);

    
    const $invitedEvents = invitedEvents ? JSON.parse(invitedEvents) : null;

    return (
        <React.Fragment>
            <Head title="Education And Learning"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Education And Learning
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" style={{ display: sm ? "block" : "none" }}>
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary" onClick={(e) => navigate(`${process.env.PUBLIC_URL}/registered-events`)}>
                                                <span>Registered Events</span>
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
                                        <BlockTitle tag="h4">All Events</BlockTitle>
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$invitedEvents && <EducationTable data={$invitedEvents} registered={false} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default EducationAndLearning;
