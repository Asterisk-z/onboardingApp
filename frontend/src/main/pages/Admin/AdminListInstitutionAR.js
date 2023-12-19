import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import {adminLoadUserARs} from "redux/stores/authorize/representative"
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminListARTable from './Tables/AdminListARTable'



const AdminInstitutionAr = ({ drawer }) => {


    const { institution_id } = useParams();
    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();

    const [parentState, setParentState] = useState('Initial state');

    const updateParentState = (newState) => {
        setParentState(newState);
    };

    const ar_users = useSelector((state) => state?.arUsers?.list) || null;
    useEffect(() => {
        dispatch(adminLoadUserARs({"approval_status": "","institution_id":institution_id,"role_id":""}));
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
                                Institution ARs
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
                                <BackTo link="/admin-institutions" icon="arrow-left">
                                    Institutions
                                </BackTo>
                                <BlockTitle tag="h4">All Institution ARs</BlockTitle>

                                {/* <p>{ar_users}</p> */}
                                {/* {<p>{parentState}</p>} */}
                            </BlockHeadContent>
                        </BlockHead>

                        <PreviewCard>
                            {$ar_users && <AdminListARTable  updateParent={updateParentState} parentState={parentState} data={$ar_users} expandableRows pagination actions />}
                        </PreviewCard>
                    </Block>


                </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminInstitutionAr;
