import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import {loadAllActiveInstitutions} from "redux/stores/institution/institutionStore"
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminInstitutionTable from './Tables/AdminInstitutionTable'



const AdminInstitutions = ({ drawer }) => {
        
    const dispatch = useDispatch();
    const [parentState, setParentState] = useState('Initial state');

    const updateParentState = (newState) => {
        setParentState(newState);
    };

    const institutions = useSelector((state) => state?.institutions?.list) || null;
    useEffect(() => {
        dispatch(loadAllActiveInstitutions());
    }, [dispatch,parentState]);
    
    const $institutions = institutions ? JSON.parse(institutions) : null;

    return (
        <React.Fragment>
            <Head title="Authorised Representation"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Institutions
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
                                <BlockTitle tag="h4">All Institutions</BlockTitle>
                                {/* <p>{institutions}</p> */}
                                {/* {<p>{parentState}</p>} */}
                            </BlockHeadContent>
                        </BlockHead>

                        <PreviewCard>
                            {$institutions && <AdminInstitutionTable  updateParent={updateParentState} parentState={parentState} data={$institutions} expandableRows pagination actions />}
                        </PreviewCard>
                    </Block>


                </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminInstitutions;
