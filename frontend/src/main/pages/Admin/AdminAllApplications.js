import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useForm } from "react-hook-form";
import { useNavigate } from "react-router-dom";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadInstitutionApplications } from "redux/stores/membership/applicationProcessStore"
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminApplicationInstitutionTable from './Tables/AdminApplicationInstitutionTable'
import { loadAllActiveInstitutions } from 'redux/stores/institution/institutionStore'
import { loadAllActiveCategories } from 'redux/stores/memberCategory/category'
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';



const AdminProcessInstitutions = ({ drawer }) => {

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [parentState, setParentState] = useState('Initial state');

    const updateParentState = (newState) => {
        setParentState(newState);
        console.log(newState)
    };

    const all_institutions = useSelector((state) => state?.applicationProcess?.all_institutions) || null;
    const active_categories = useSelector((state) => state?.category?.list) || null;
    const institutions = useSelector((state) => state?.institutions?.list) || null;
    useEffect(() => {
        dispatch(loadInstitutionApplications());
        dispatch(loadAllActiveInstitutions());
        dispatch(loadAllActiveCategories());
    }, [dispatch, parentState]);

    const $all_institutions = all_institutions ? JSON.parse(all_institutions) : null;
    const $active_categories = active_categories ? JSON.parse(active_categories) : null;
    const $institutions = institutions ? JSON.parse(institutions) : null;

    return (
        <React.Fragment>
            <Head title="Authorised Representation"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                All Applications
                            </BlockTitle>
                            {/* {categories} */}
                        </BlockHeadContent>
                        <BlockHeadContent>

                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" style={{ display: true ? "block" : "none" }}>
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={() => navigate(process.env.PUBLIC_URL + '/admin-applications')}>Back</span>
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
                                    {$all_institutions && <AdminApplicationInstitutionTable updateParent={updateParentState} parentState={parentState} data={$all_institutions} $active_categories={$active_categories} $institutions={$institutions} allApplications={true} expandableRows pagination actions />}
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
