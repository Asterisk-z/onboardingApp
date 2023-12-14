import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllComplaintTypes } from "redux/stores/complaints/complaintTypes";
import { loadAllUsersComplaints } from "redux/stores/complaints/complaint";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminComplaintTable from './Tables/AdminComplaintTable'



const Complaint = ({ drawer }) => {
        
    const dispatch = useDispatch();
    const [parentState, setParentState] = useState('Initial state');


    const complaints = useSelector((state) => state?.complaint?.list) || null;
    useEffect(() => {
        dispatch(loadAllUsersComplaints());
    }, [dispatch, parentState]);

    
    const $complaints = complaints ? JSON.parse(complaints) : null;
    
    const updateParentState = (newState) => {
        console.log(newState)
        setParentState(newState);
    };


    return (
        <React.Fragment>
            <Head title="Complaint"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Complaints
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
                                <BlockTitle tag="h4">Complaint History</BlockTitle>
                                {/* <p>{complaints}</p> */}
                                {/* {<p>{parentState}</p>} */}
                            </BlockHeadContent>
                        </BlockHead>

                        <PreviewCard>
                            {$complaints && <AdminComplaintTable  updateParent={updateParentState} parentState={parentState} data={$complaints} expandableRows pagination actions />}
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
