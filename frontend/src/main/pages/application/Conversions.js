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
import { loadAllMyActiveCategories, loadAllOtherActiveCategories } from "redux/stores/memberCategory/category";
import { additionRequest, conversionRequest } from "redux/stores/membership/applicationStore";
import AuthRepTable from '../Tables/AuthRepTable'
import ApplicationTable from '../Tables/ApplicationTable'

import { loadArDashboard } from "redux/stores/dashboard/dashboardStore";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';



const ConvertMemberForm = ({ other_categories, my_categories, updateParent }) => {

    const dispatch = useDispatch();

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const [loading, setLoading] = useState(false);

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const handleFormSubmit = async (values) => {


        const postValues = {};
        postValues.old_category = values.old_category;
        postValues.new_category = values.new_category;
        postValues.institution = authUser?.user_data?.institution?.id;


        try {
            setLoading(true);


            const resp = await dispatch(conversionRequest(postValues));

            // console.log(values, postValues, loading, resp.payload)
            if (resp.payload?.message === "success") {

                setTimeout(() => {
                    setLoading(false);
                    updateParent(Math.random())
                }, 1000);
            } else {
                setLoading(false);
            }

        } catch (error) {
            setLoading(false);
        }

    };

    const checking = () => {
        console.log("errors")
    }
    return (
        <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">

            <div className="form-group w-100">
                <div className="form-label">
                    <label htmlFor="old_category">Membership Category<span style={{ color: 'red' }}> *</span>:</label>
                </div>
                <div className="form-control-wrap">
                    <div className="form-control-select">
                        <select className="form-control form-select" style={{ width: '100%' }}  {...register('old_category', { required: true })} >
                            <option value="">Select A Category</option>
                            {my_categories && my_categories?.map((category) => (
                                <option key={category.id} value={category.id}>
                                    {category.name}
                                </option>
                            ))}
                        </select>
                        {errors.category && <p className="invalid">Category field is required</p>}
                    </div>
                </div>
            </div>

            <div className="form-group w-100">
                <div className="form-label">
                    <label htmlFor="new_category">New Membership Category<span style={{ color: 'red' }}> *</span>:</label>
                </div>
                <div className="form-control-wrap">
                    <div className="form-control-select">
                        <select className="form-control form-select" style={{ width: '100%' }}  {...register('new_category', { required: true })} >
                            <option value="">Select A Category</option>
                            {other_categories && other_categories?.map((category) => (
                                <option key={category.id} value={category.id}>
                                    {category.name}
                                </option>
                            ))}
                        </select>
                        {errors.category && <p className="invalid">Category field is required</p>}
                    </div>
                </div>
            </div>

            <div className="form-group">
                <Button color="primary" type="submit" size="lg">
                    {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Submit"}
                </Button>
            </div>
        </form>
    )
}

const Homepage = () => {
    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const dispatch = useDispatch();
    const navigate = useNavigate();

    const [modalForm, setModalForm] = useState(false);
    const [parentState, setParentState] = useState('Initial state');
    const toggleForm = () => setModalForm(!modalForm);

    const my_categories = useSelector((state) => state?.category?.my_categories) || null;
    const other_categories = useSelector((state) => state?.category?.other_categories) || null;
    const application_list = useSelector((state) => state?.applicationProcess?.application_list) || null;

    useEffect(() => {
        dispatch(loadApplications({ 'application_type': 'conversion' }));
        dispatch(loadAllMyActiveCategories());
        dispatch(loadAllOtherActiveCategories());
    }, [dispatch, parentState]);

    const updateParentState = (newState) => {
        setModalForm(false)
        setParentState(newState);
    };

    const $application_list = application_list ? JSON.parse(application_list) : null
    const $my_categories = my_categories ? JSON.parse(my_categories) : null;
    const $other_categories = other_categories ? JSON.parse(other_categories) : null;

    return (
        <React.Fragment>
            <Head title="Membership Conversion"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Membership Conversion
                            </BlockTitle>
                        </BlockHeadContent>

                        <BlockHeadContent>
                            {authUser?.user_data?.institution?.application[0].completed_at && <>
                                <div className="toggle-wrap nk-block-tools-toggle">
                                    <div className="toggle-expand-content" style={{ display: true ? "block" : "none" }}>
                                        <ul className="nk-block-tools g-3">
                                            <li className="nk-block-tools-opt">
                                                <Button color="primary">
                                                    <span onClick={toggleForm}>New Member Conversion</span>
                                                </Button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </>}
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>

                <Modal isOpen={modalForm} toggle={toggleForm}>
                    <ModalHeader toggle={toggleForm} close={
                        <button className="close" onClick={toggleForm}>
                            <Icon name="cross" />
                        </button>
                    }
                    >
                        New Member Conversion
                    </ModalHeader>
                    <ModalBody>
                        <ConvertMemberForm other_categories={$other_categories} my_categories={$my_categories} updateParent={updateParentState} />
                    </ModalBody>
                    <ModalFooter className="bg-light">
                        <span className="sub-text">Application</span>
                    </ModalFooter>
                </Modal>

                <Content>

                    <Block size="xl">

                        <BlockHead>
                            <BlockHeadContent>
                                <BlockTitle tag="h4">Conversion</BlockTitle>
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
