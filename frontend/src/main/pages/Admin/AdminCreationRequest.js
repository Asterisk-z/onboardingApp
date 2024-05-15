import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { getMsgArCreationRequest, getMbgArCreationRequest } from "redux/stores/authorize/arCreation";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminCreationRequestTable from './Tables/AdminCreationRequestTable'
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';



const AdminCreationRequest = ({ drawer }) => {

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const dispatch = useDispatch();
    const [parentState, setParentState] = useState('Initial state');

    const msg_ar_request_list = useSelector((state) => state?.arCreation?.msg_ar_request_list) || null;
    const mbg_ar_request_list = useSelector((state) => state?.arCreation?.mbg_ar_request_list) || null;
    useEffect(() => {
        
            if (authUser.is_admin_msg()) {
                dispatch(getMsgArCreationRequest({'status' : ''}));
            }
            if (authUser.is_admin_mbg()) {
                dispatch(getMbgArCreationRequest({'status' : ''}));
            }
    }, [dispatch, parentState]);


    const $msg_ar_request_list = msg_ar_request_list ? JSON.parse(msg_ar_request_list) : null;
    const $mbg_ar_request_list = mbg_ar_request_list ? JSON.parse(mbg_ar_request_list) : null;

    const updateParentState = (newState) => {
        console.log(newState)
        setParentState(newState);
    };


    return (
        <React.Fragment>
            <Head title="AR Creation Request"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                AR Creation Request
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
                                        <BlockTitle tag="h4">AR Creation Request History</BlockTitle>
                                        {/* <p>{complaints}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {(authUser.is_admin_msg() && $msg_ar_request_list) && <AdminCreationRequestTable updateParent={updateParentState} parentState={parentState} data={$msg_ar_request_list} expandableRows pagination actions />}
                                    {(authUser.is_admin_mbg() && $mbg_ar_request_list) && <AdminCreationRequestTable updateParent={updateParentState} parentState={parentState} data={$mbg_ar_request_list} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminCreationRequest;
