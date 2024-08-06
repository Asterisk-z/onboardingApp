import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
// import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllStakeHolders, createStakeHolder } from "redux/stores/users/userStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminStakeHoldersTable from "./Tables/AdminStakeHoldersTable";



const AdminStakeHolder = ({ drawer }) => {

    const dispatch = useDispatch();

    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);

    const all_stakeholders = useSelector((state) => state?.user?.stake_view_all) || null;

    useEffect(() => {
        dispatch(loadAllStakeHolders());
    }, [dispatch, parentState]);


    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const toggleForm = () => setModalForm(!modalForm);

    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('firstName', values.firstName)
        formData.append('lastName', values.lastName)
        formData.append('email', values.email)
        try {
            setLoading(true);

            const resp = await dispatch(createStakeHolder(formData));

            if (resp.payload?.message === "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('firstName')
                    resetField('lastName')
                    resetField('email')
                    setParentState(Math.random())
                }, 1000);
            } else {
                setLoading(false);
            }

        } catch (error) {
            setLoading(false);
        }

    };

    const $all_stakeholders = all_stakeholders ? JSON.parse(all_stakeholders) : null;

    const updateParentState = (newState) => {
        setParentState(newState);
    };


    return (
        <React.Fragment>
            <Head title="Stakeholders"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Stakeholders
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" >
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={toggleForm}>Create Stakeholder</span>
                                            </Button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
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
                        Create Stakeholder
                    </ModalHeader>
                    <ModalBody>
                        <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                            <div className="form-group">
                                <label className="form-label" htmlFor="full-name">
                                    First Name
                                </label>
                                <div className="form-control-wrap">
                                    <input type="text" id="name" className="form-control" {...register('firstName', { required: "This Field is required" })} />
                                    {errors.firstName && <span className="invalid">{errors.firstName.message}</span>}
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="full-name">
                                    Last Name
                                </label>
                                <div className="form-control-wrap">
                                    <input type="text" id="name" className="form-control" {...register('lastName', { required: "This Field is required" })} />
                                    {errors.lastName && <span className="invalid">{errors.lastName.message}</span>}
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="full-name">
                                    Email
                                </label>
                                <div className="form-control-wrap">
                                    <input type="email" id="name" className="form-control" {...register('email', { required: "This Field is required" })} />
                                    {errors.email && <span className="invalid">{errors.email.message}</span>}
                                </div>
                            </div>

                            <div className="form-group">
                                <Button color="primary" type="submit" size="lg">
                                    {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Create"}
                                </Button>
                            </div>
                        </form>
                    </ModalBody>
                    <ModalFooter className="bg-light">
                        <span className="sub-text">Create </span>
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>
                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        {/* <BlockTitle tag="h4">All Membership</BlockTitle> */}
                                        {/* <p>{all_stakeholders}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$all_stakeholders && <AdminStakeHoldersTable updateParent={updateParentState} parentState={parentState} data={$all_stakeholders} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminStakeHolder;