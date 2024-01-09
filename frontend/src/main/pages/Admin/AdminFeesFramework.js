import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
// import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, CardFooter, CardText, CardTitle, CardBody, CardHeader } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadFeesAndDues, createFeesAndDues, updateFeesAndDues } from "redux/stores/feesAndDues/feesAndDuesStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import moment from "moment";
// import data from "@srcMain";
// import AdminRegulatorTable from "./Tables/AdminRegulatorTable";



const UpdateFeeComponent = ({fee, updateParent}) => {

    const dispatch = useDispatch();

    const [loading, setLoading] = useState(false);

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();
    
    const handleFormUpdate = async (values) => {
        

        const postValues = {};
        postValues.title = values.title;
        postValues.url = values.url;
        postValues.id = fee.id;
        
        
        try {
            setLoading(true);


            const resp = await dispatch(updateFeesAndDues(postValues));
            
            // console.log(values, postValues, loading, resp.payload)
            if (resp.payload?.message === "success") {

                setTimeout(() => {
                    setLoading(false);
                    resetField('title')
                    resetField('url')
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
        <form onSubmit={handleSubmit(handleFormUpdate)} className="is-alter" encType="multipart/form-data">
            <div className="form-group">
                <label className="form-label" htmlFor="code">
                    Title
                </label>
                <div className="form-control-wrap">
                    <input type="text" id="title" className="form-control" {...register('title', { required: "This Field is required", })} defaultValue={fee.title} />
                    {errors.title && <span className="invalid">{errors.title.message}</span>}
                </div>
            </div>
            <div className="form-group">
                <label className="form-label" htmlFor="full-name">
                    URL
                </label>
                <div className="form-control-wrap">
                    <input type="text" id="url" className="form-control" {...register('url', { required: "This Field is required" })} defaultValue={fee.url} />
                    {errors.name && <span className="invalid">{errors.url.message}</span>}
                </div>
            </div>
            <div className="form-group">
                <Button color="primary" type="submit" size="lg" onClick={checking}>
                    {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Update"}
                </Button>
            </div>
        </form>
    )
}

const AdminFees = ({ drawer }) => {

    const dispatch = useDispatch();

    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const [modalFormUpdate, setModalFormUpdate] = useState(false);

    const fees = useSelector((state) => state?.fees?.view_all) || null;

    useEffect(() => {
        dispatch(loadFeesAndDues());
    }, [dispatch, parentState]);


    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const toggleForm = () => setModalForm(!modalForm);
    const toggleUpdateForm = () => setModalFormUpdate(!modalFormUpdate);

    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('title', values.title)
        formData.append('url', values.url)
        try {
            setLoading(true);

            const resp = await dispatch(createFeesAndDues(formData));

            if (resp.payload?.message === "success") {

                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('title')
                    resetField('url')
                    setParentState(Math.random())
                }, 1000);
            } else {
                setLoading(false);
            }

        } catch (error) {
            setLoading(false);
        }

    };

    const $fees = fees ? JSON.parse(fees) : null;

    const updateParentState = (newState) => {
        setModalFormUpdate(!modalFormUpdate)
        setParentState(newState);
    };

    

    return (
        <React.Fragment>
            <Head title="Fees and Dues Framework"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Fees and Dues Framework
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" >
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            {!fees && <Button color="primary">
                                                <span onClick={toggleForm}>Create Fees Framework</span>
                                            </Button>}
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
                        Create Fees Framework
                    </ModalHeader>
                    <ModalBody>
                        <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                            <div className="form-group">
                                <label className="form-label" htmlFor="full-name">
                                    Title
                                </label>
                                <div className="form-control-wrap">
                                    <input type="text" id="title" className="form-control" {...register('title', { required: "This Field is required" })} />
                                    {errors.title && <span className="invalid">{errors.title.message}</span>}
                                </div>
                            </div>

                            <div className="form-group">
                                <label className="form-label" htmlFor="full-name">
                                    Website url
                                </label>
                                <div className="form-control-wrap">
                                    <input type="url" id="url" className="form-control" {...register('url', { required: "This Field is required" })} />
                                    {errors.url && <span className="invalid">{errors.url.message}</span>}
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
                        <span className="sub-text">Fees And Dues</span>
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>
                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        {/* <BlockTitle tag="h4">All Membership</BlockTitle> */}
                                        {/* <p>{regulators}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {/* {$fees && <AdminRegulatorTable  updateParent={updateParentState} parentState={parentState} data={$regulators} expandableRows pagination actions />} */}
                                    {$fees && 
                                    <Card className="card-bordered gold">
                                        <CardHeader className="border-bottom">
                                            Fees and Dues
                                        </CardHeader>
                                        <CardBody className="card-inner">
                                            <CardTitle tag="h5">{$fees.title}</CardTitle>
                                            <CardText>
                                                {$fees.url}
                                            </CardText>
                                            <Button color="primary" onClick={toggleUpdateForm}>Edit</Button>
                                        </CardBody>
                                        <CardFooter className="border-top">{moment($fees.created_at).format('ll')}</CardFooter>

                                        <Modal isOpen={modalFormUpdate} toggle={toggleUpdateForm} >
                                            <ModalHeader toggle={toggleUpdateForm} close={<button className="close" onClick={toggleUpdateForm}><Icon name="cross" /></button>}>
                                                Update
                                            </ModalHeader>
                                            <ModalBody>
                                                <UpdateFeeComponent fee={$fees} updateParent={updateParentState}/>
                                            </ModalBody>
                                            <ModalFooter className="bg-light">
                                                <span className="sub-text">Update Fees and Dues</span>
                                            </ModalFooter>
                                        </Modal>                                    
                                        </Card>

                                    }
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>

            </Content>
        </React.Fragment>
    );
};
export default AdminFees;
