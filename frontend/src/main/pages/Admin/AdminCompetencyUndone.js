import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllNonCompliantArs } from "redux/stores/competency/competencyStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminCompetencyARTable from './Tables/AdminCompetencyARTable'



const AdminNonCompliantArs = ({ drawer }) => {
        
    const dispatch = useDispatch();
    const { competency_id } = useParams();
    const navigate = useNavigate();

    const [parentState, setParentState] = useState('Initial state');
    
    const non_compliant_ars = useSelector((state) => state?.competency?.list_non_com_ars) || null;

    useEffect(() => {
        dispatch(loadAllNonCompliantArs({'competency_id' : competency_id}));
    }, [dispatch, parentState]);
    
    const $non_compliant_ars = non_compliant_ars ? JSON.parse(non_compliant_ars) : null;
    
    const updateParentState = (newState) => {
        setParentState(newState);
    };


    return (
        <React.Fragment>
            <Head title="Non Compliant Ars - Competency"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Non Compliant ARs
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" >
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={(e) => navigate(process.env.PUBLIC_URL+'/admin-competency-framework')}>Back</span>
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
                                        {/* <p>{non_compliant_ars}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$non_compliant_ars && <AdminCompetencyARTable  parentState={parentState} data={$non_compliant_ars}  expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminNonCompliantArs;
