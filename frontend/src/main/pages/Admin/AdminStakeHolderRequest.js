import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllStakeHolderRequests } from "redux/stores/users/userStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminStakeHolderTable from './Tables/AdminStakeHolderTable'
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';



const AdminStakeHolder = ({ drawer }) => {

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const dispatch = useDispatch();
    const [parentState, setParentState] = useState('Initial state');

    const request_list = useSelector((state) => state?.user?.request_list) || null;
    useEffect(() => {

        if (authUser.is_admin_meg()) {
            dispatch(loadAllStakeHolderRequests({ 'status': '' }));
        }
    }, [dispatch, parentState]);


    const $request_list = request_list ? JSON.parse(request_list) : null;

    const updateParentState = (newState) => {
        console.log(newState)
        setParentState(newState);
    };


    return (
        <React.Fragment>
            <Head title="Stack Holder  Request"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Stack Holder Request
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
                                        <BlockTitle tag="h4">Stack Holder Request History</BlockTitle>
                                        {/* <p>{request_list}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {(authUser.is_admin_meg() && $request_list) && <AdminStakeHolderTable updateParent={updateParentState} parentState={parentState} data={$request_list} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminStakeHolder;
