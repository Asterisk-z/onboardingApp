import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, Input } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadUserRoles } from "redux/stores/roles/roleStore";
import { loadAllActivePositions } from "redux/stores/positions/positionStore";
import { loadAllCountries } from "redux/stores/nationality/country";
import { userLoadUserARs, userCreateUserAR } from "redux/stores/authorize/representative";
import { loadAllActiveAuthoriser } from "redux/stores/users/userStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AuthRepTable from './Tables/AuthRepTable'


const ViewAuthRepresentative = ({ drawer }) => {

    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [sm, updateSm] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const [parentState, setParentState] = useState('Initial state');

    const roles = useSelector((state) => state?.role?.list) || null;
    const all_positions = useSelector((state) => state?.position?.all_list) || null;
    const countries = useSelector((state) => state?.country?.list) || null;
    const authorizers = useSelector((state) => state?.user?.list) || null;
    const authorize_reps = useSelector((state) => state?.arUsers?.list) || null;

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const toggleForm = () => setModalForm(!modalForm);

    const updateParentState = (newState) => {
        setParentState(newState);
    };

    useEffect(() => {
        dispatch(loadUserRoles());
        dispatch(loadAllActivePositions());
        dispatch(loadAllCountries());
        dispatch(loadAllActiveAuthoriser());
        dispatch(userLoadUserARs({ "approval_status": "approved", 'role_id': "" }));
    }, [dispatch, parentState]);



    const $countries = countries ? JSON.parse(countries) : null;
    const $roles = roles ? JSON.parse(roles) : null;
    const $all_positions = all_positions ? JSON.parse(all_positions) : null;
    const $authorizers = authorizers ? JSON.parse(authorizers) : null;
    const $authorize_reps = authorize_reps ? JSON.parse(authorize_reps) : null;




    return (
        <React.Fragment>
            <Head title="View Authorised Representative"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                View Authorised Representatives
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
                                            <div className="toggle-expand-content" style={{ display: sm ? "block" : "none" }}>
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
                                    {$authorize_reps && <AuthRepTable updateParent={updateParentState} parentState={parentState} data={$authorize_reps} positions={$all_positions} countries={$countries} authorizers={$authorizers} roles={$roles} pending={false} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default ViewAuthRepresentative;
