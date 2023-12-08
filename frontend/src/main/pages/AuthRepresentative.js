import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllComplaintTypes } from "redux/stores/complaints/complaintTypes";
import { userLoadUserARs } from "redux/stores/authorize/representative";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AuthRepTable from './Tables/AuthRepTable'



const AuthRepresentative = ({ drawer }) => {
        
    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [complainFile, setComplainFile] = useState([]);
    const [sm, updateSm] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const complaintType = useSelector((state) => state?.complaintType?.list) || null;

    const toggleForm = () => setModalForm(!modalForm);

    // useEffect(() => {
    //     dispatch(loadAllComplaintTypes());
    // }, [dispatch]);

    const $complaintType = complaintType ? JSON.parse(complaintType) : null;
  
    const [parentState, setParentState] = useState('Initial state');

    const updateParentState = (newState) => {
        setParentState(newState);
    };

    const TableData = () => {
       
        const dispatch = useDispatch();
        const authorize_reps = useSelector((state) => state?.arUsers?.list) || null;
        useEffect(() => {
            dispatch(userLoadUserARs());
        }, [dispatch,parentState]);
    
        
        const $authorize_reps = authorize_reps ? JSON.parse(authorize_reps) : null;
        
        return (
            <React.Fragment>
                <Content>


                    <Block size="xl">
                        <BlockHead>
                            <BlockHeadContent>
                                {/* <BlockTitle tag="h4">List</BlockTitle> */}
                                <p>{authorize_reps}</p>
                                {/* {<p>{parentState}</p>} */}
                            </BlockHeadContent>
                        </BlockHead>

                        <PreviewCard>
                            {$authorize_reps && <AuthRepTable  updateParent={updateParentState} parentState={parentState} data={$authorize_reps} expandableRows pagination actions />}
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
                                Authorised Representatives
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <TableData/>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AuthRepresentative;
