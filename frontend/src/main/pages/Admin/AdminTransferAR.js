import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import {megLoadTransferUserAR} from "redux/stores/authorize/representative"
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminTransferARTable from './Tables/AdminTransferARTable'



const AdminBroadcast = ({ drawer }) => {
        
    const dispatch = useDispatch();
    const [parentState, setParentState] = useState('Initial state');

    const updateParentState = (newState) => {
        setParentState(newState);
    };

    const ar_users = useSelector((state) => state?.arUsers?.transfer_list) || null;
    useEffect(() => {
        dispatch(megLoadTransferUserAR());
    }, [dispatch,parentState]);
    
    const $ar_users = ar_users ? JSON.parse(ar_users) : null;

    return (
        <React.Fragment>
            <Head title="Authorised Representation"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Authorised Representation
                            </BlockTitle>
                            {/* {categories} */}
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
                                <BlockTitle tag="h4">Transfer Authorised Representatives</BlockTitle>
                                {/* <p>{ar_users}</p> */}
                                {/* {<p>{parentState}</p>} */}
                            </BlockHeadContent>
                        </BlockHead>

                        <PreviewCard>
                            {$ar_users && <AdminTransferARTable  updateParent={updateParentState} parentState={parentState} data={$ar_users} expandableRows pagination actions />}
                        </PreviewCard>
                    </Block>


                </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminBroadcast;
