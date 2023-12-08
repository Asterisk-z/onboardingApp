import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllComplaintTypes } from "redux/stores/complaints/complaintTypes";
import { sendComplaint, loadAllUsersComplaints } from "redux/stores/complaints/complaint";

import { DataTableData, dataTableColumns, dataTableColumns2, userData, orderData } from "components/table/TableData";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminComplaintTable from './Tables/AdminComplaintTable'



const Complaint = ({ drawer }) => {
        
    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [complainFile, setComplainFile] = useState([]);
    const [sm, updateSm] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const complaintType = useSelector((state) => state?.complaintType?.list) || null;

    const toggleForm = () => setModalForm(!modalForm);

    useEffect(() => {
        dispatch(loadAllComplaintTypes());
    }, [dispatch]);

    const $complaintType = complaintType ? JSON.parse(complaintType) : null;
  

const UserCompTable = () => {
    
    const dispatch = useDispatch();
    const complaints = useSelector((state) => state?.complaint?.list) || null;
    useEffect(() => {
        dispatch(loadAllUsersComplaints());
    }, [counter, dispatch]);
  
    
    const $complaints = complaints ? JSON.parse(complaints) : null;
  
    return (
        <React.Fragment>
            <Content>


                <Block size="xl">
                    <BlockHead>
                        <BlockHeadContent>
                            <BlockTitle tag="h4">Complaint History</BlockTitle>
                            {/* <p>{complaints}</p> */}
                        </BlockHeadContent>
                    </BlockHead>

                    <PreviewCard>
                        {$complaints && <AdminComplaintTable data={$complaints} expandableRows pagination actions />}
                    </PreviewCard>
                </Block>


            </Content>
        </React.Fragment>
    );
}


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
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" style={{ display: sm ? "block" : "none" }}>
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={toggleForm}>Add Complaint</span>
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
                        <UserCompTable />
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default Complaint;
