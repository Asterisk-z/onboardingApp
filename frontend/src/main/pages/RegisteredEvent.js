import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllRegisteredEvent } from "redux/stores/education/eventStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import RegisteredEventTable from './Tables/RegisteredEventTable'



const EducationAndLearning = ({ drawer }) => {
        
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [sm, updateSm] = useState(false);

    const registered_events = useSelector((state) => state?.educationEvent?.list_all_registered) || null;

    useEffect(() => {
        dispatch(loadAllRegisteredEvent());
    }, [dispatch]);

    
    const $registered_events = registered_events ? JSON.parse(registered_events) : null;

    return (
        <React.Fragment>
            <Head title="Education And Learning"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Registered Events
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" style={{ display: sm ? "block" : "none" }}>
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary" onClick={(e) => navigate(`${process.env.PUBLIC_URL}/education-and-learning`)}>
                                                <span>Back</span>
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
                                        <BlockTitle tag="h4">Registered Events</BlockTitle>
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$registered_events && <RegisteredEventTable data={$registered_events} registered={true} expandableRows pagination actions />}
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
