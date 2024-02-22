import React, { useState, useEffect } from "react";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, CardFooter, CardText, CardTitle, CardBody, CardHeader } from "reactstrap";
import {
    Block,
    BlockHead,
    BlockHeadContent,
    BlockTitle,
    Icon,
    Button,
    Row,
    Col,
    BlockBetween,
    PreviewCard
} from "components/Component";
import { useForm } from "react-hook-form";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { loadApplications } from "redux/stores/membership/applicationProcessStore";
import AuthRepTable from '../Tables/AuthRepTable'
import ApplicationTable from '../Tables/ApplicationTable'

import { loadArDashboard } from "redux/stores/dashboard/dashboardStore";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';


const Homepage = () => {
    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const dispatch = useDispatch();
    const navigate = useNavigate();

    const [parentState, setParentState] = useState('Initial state');


    const application_list = useSelector((state) => state?.applicationProcess?.application_list) || null;

    useEffect(() => {
        dispatch(loadApplications({'application_type' : 'application'}));
    }, [dispatch, parentState]);

    const updateParentState = (newState) => {
        setParentState(newState);
    };

    const $application_list = application_list ? JSON.parse(application_list) : null


    return (
        <React.Fragment>
            <Head title="Membership Applications"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Membership Applications
                            </BlockTitle>
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>

                <Content>

                    <Block size="xl">

                        <BlockHead>
                            <BlockHeadContent>
                                <BlockTitle tag="h4">Applications</BlockTitle>
                            </BlockHeadContent>
                        </BlockHead>
                        <PreviewCard>
                            {$application_list && <ApplicationTable data={$application_list} updateParent={updateParentState} expandableRows pagination actions />}
                        </PreviewCard>
                    </Block>


                </Content>
            </Content>
        </React.Fragment>
    );
};
export default Homepage;
