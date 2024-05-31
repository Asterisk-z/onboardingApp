import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadOverAllCompliantArs, loadAllCompetencyGroupName } from "redux/stores/competency/competencyStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminCompetencyAllARTable from './Tables/AdminCompetencyAllARTable'



const AdminCompliantArs = ({ drawer }) => {

    const dispatch = useDispatch();

    const navigate = useNavigate();

    const [parentState, setParentState] = useState('Initial state');

    const compliant_ars = useSelector((state) => state?.competency?.list_all_com_ars) || null;
    const list_com_group_name = useSelector((state) => state?.competency?.list_com_group_name) || null;


    useEffect(() => {
        dispatch(loadAllCompetencyGroupName());
        dispatch(loadOverAllCompliantArs());
    }, [dispatch, parentState]);

    const $compliant_ars = compliant_ars ? JSON.parse(compliant_ars) : null;
    const $list_com_group_name = list_com_group_name ? JSON.parse(list_com_group_name) : null;

    const updateParentState = (newState) => {
        setParentState(newState);
    };


    return (
        <React.Fragment>
            <Head title="Compliant Ars - Competency Framework"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                All Compliant ARs
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" >
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={(e) => navigate(process.env.PUBLIC_URL + '/admin-competency-framework')}>Back</span>
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
                                        {/* <BlockTitle tag="h4">All Membership</BlockTitle> */}
                                        {/* <p>{compliant_ars}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$compliant_ars && <AdminCompetencyAllARTable parentState={parentState} data={$compliant_ars} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminCompliantArs;
