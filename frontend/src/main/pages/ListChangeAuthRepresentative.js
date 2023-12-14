import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, Input} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { userLoadStatusChangeUserAR } from "redux/stores/authorize/representative";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import ChangeStatusAuthRepTable from './Tables/ChangeStatusAuthRepTable'


const ListTransferAuthRepresentative = ({ drawer }) => {
        
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [modalForm, setModalForm] = useState(false);
    const [parentState, setParentState] = useState('Initial state');

    const authorize_reps = useSelector((state) => state?.arUsers?.status_list) || null;

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const toggleForm = () => setModalForm(!modalForm);
    
    const updateParentState = (newState) => {
        setParentState(newState);
    };

    useEffect(() => {
        dispatch(userLoadStatusChangeUserAR());
    }, [dispatch, parentState]);
      



    const $authorize_reps = authorize_reps ? JSON.parse(authorize_reps) : null;



    return (
        <React.Fragment>
            <Head title="Pending Authorised Representative"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Change Authorised Representatives Status
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
                                        {/* <BlockTitle tag="h4">List</BlockTitle> */}
                                        {/* <p>{authorize_reps}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                        <div className="toggle-wrap nk-block-tools-toggle">
                                            <div className="toggle-expand-content" style={{ display: true ? "block" : "none" }}>
                                                <ul className="nk-block-tools g-3">
                                                    <li className="nk-block-tools-opt">
                                                        <Button color="primary">
                                                            <span onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/auth-representatives`)}>Back</span>
                                                        </Button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$authorize_reps && <ChangeStatusAuthRepTable updateParent={updateParentState} parentState={parentState} data={$authorize_reps}   expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default ListTransferAuthRepresentative;
