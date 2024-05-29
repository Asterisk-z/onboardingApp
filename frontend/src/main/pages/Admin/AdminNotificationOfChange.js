import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadMegNotificationOfChange } from "redux/stores/notificationOfChange/changeStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminNotificationOfChangeTable from './Tables/AdminNotificationOfChangeTable'



const Complaint = ({ drawer }) => {

    const dispatch = useDispatch();
    const [parentState, setParentState] = useState('Initial state');


    const list_changes = useSelector((state) => state?.change?.list_changes) || null;
    useEffect(() => {
        dispatch(loadMegNotificationOfChange());
    }, [dispatch, parentState]);
    const $list_changes = list_changes ? JSON.parse(list_changes) : null;


    const updateParentState = (newState) => {
        setParentState(newState);
    };


    return (
        <React.Fragment>
            <Head title="Notification Of Change"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Notification Of Change
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
                                        <BlockTitle tag="h4">Change  History</BlockTitle>
                                        {/* <p>{list_changes}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$list_changes && <AdminNotificationOfChangeTable updateParent={updateParentState} parentState={parentState} data={$list_changes} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default Complaint;
