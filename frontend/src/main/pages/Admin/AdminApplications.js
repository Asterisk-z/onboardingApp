import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import {loadInstitutionApplications} from "redux/stores/membership/applicationProcessStore"
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminApplicationInstitutionTable from './Tables/AdminApplicationInstitutionTable'



const AdminProcessInstitutions = ({ drawer }) => {
        
    const dispatch = useDispatch();
    const [parentState, setParentState] = useState('Initial state');

    const updateParentState = (newState) => {
        setParentState(newState);
    };

    const all_institutions = useSelector((state) => state?.applicationProcess?.all_institutions) || null;
    useEffect(() => {
        dispatch(loadInstitutionApplications());
    }, [dispatch,parentState]);
    
    const $all_institutions = all_institutions ? JSON.parse(all_institutions) : null;

    console.log( $all_institutions )
    return (
        <React.Fragment>
            <Head title="Authorised Representation"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Applications
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
                                <BlockTitle tag="h4">Institutions Applications</BlockTitle>
                                {/* <p>{institutions}</p> */}
                                {/* {<p>{parentState}</p>} */}
                            </BlockHeadContent>
                        </BlockHead>

                        <PreviewCard>
                            {$all_institutions && <AdminApplicationInstitutionTable  updateParent={updateParentState} parentState={parentState} data={$all_institutions} expandableRows pagination actions />}
                        </PreviewCard>
                    </Block>


                </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminProcessInstitutions;
