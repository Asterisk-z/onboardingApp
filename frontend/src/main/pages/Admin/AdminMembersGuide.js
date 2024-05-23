import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
// import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, CardFooter, CardText, CardTitle, CardBody, CardHeader } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllMembersGuide, createMembersGuide, updateMembersGuide } from "redux/stores/membersGuide/membersGuideStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
// import data from "@srcMain";
// import AdminRegulatorTable from "./Tables/AdminRegulatorTable";



const UpdateMembersComponent = ({ membersGuide, updateParent }) => {

    const dispatch = useDispatch();

    const [loading, setLoading] = useState(false);

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const handleFormUpdate = async (values) => {


        const postValues = {};
        postValues.name = values.name;
        postValues.file = values.file[0];
        postValues.id = membersGuide.id;


        try {
            setLoading(true);


            const resp = await dispatch(updateMembersGuide(postValues));

            // console.log(values, postValues, loading, resp.payload)
            if (resp.payload?.message === "success") {

                setTimeout(() => {
                    setLoading(false);
                    resetField('name')
                    resetField('file')
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
                <label className="form-label" htmlFor="name">
                    name
                </label>
                <div className="form-control-wrap">
                    <input type="text" id="name" className="form-control" {...register('name', { required: "This Field is required", })} defaultValue={membersGuide.name} />
                    {errors.name && <span className="invalid">{errors.name.message}</span>}
                </div>
            </div>
            <div className="form-group">
                <label className="form-label" htmlFor="file">
                    Upload Document
                </label>
                <div className="form-control-wrap">
                    <input type="file" id="file" className="form-control" {...register('file', { required: "This Field is required" })} />
                    {errors.file && <span className="invalid">{errors.file.message}</span>}
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

const AdminMembersGuide = ({ drawer }) => {

    const dispatch = useDispatch();

    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const [modalFormUpdate, setModalFormUpdate] = useState(false);

    const membersGuide = useSelector((state) => state?.membersGuide?.all_guides) || null;

    useEffect(() => {
        dispatch(loadAllMembersGuide());
    }, [dispatch, parentState]);

    const $membersGuide = membersGuide ? JSON.parse(membersGuide) : null;

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const toggleForm = () => setModalForm(!modalForm);
    const toggleUpdateForm = () => setModalFormUpdate(!modalFormUpdate);


    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('name', values.name)
        formData.append('file', values.file[0])
        try {
            setLoading(true);

            const resp = await dispatch(createMembersGuide(formData));

            if (resp.payload?.message === "success") {
                // console.log(formData);
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('name')
                    resetField('file')
                    setParentState(Math.random())
                }, 1000);
            } else {
                setLoading(false);
            }

        } catch (error) {
            setLoading(false);
        }

    };


    const updateParentState = (newState) => {
        setModalFormUpdate(!modalFormUpdate)
        setParentState(newState);
    };



    return (
        <React.Fragment>
            <Head title="Members Guide"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Members Guide
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" >
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            {!$membersGuide &&
                                                <Button color="primary">
                                                    <span onClick={toggleForm}>Create Members Guide</span>
                                                </Button>
                                            }
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
                        Create Members Guide
                    </ModalHeader>
                    <ModalBody>
                        <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                            <div className="form-group">
                                <label className="form-label" htmlFor="name">
                                    Name
                                </label>
                                <div className="form-control-wrap">
                                    <input type="text" id="name" className="form-control" {...register('name', { required: "This Field is required" })} />
                                    {errors.name && <span className="invalid">{errors.name.message}</span>}
                                </div>
                            </div>

                            <div className="form-group">
                                <label className="form-label" htmlFor="file">
                                    Upload File
                                </label>
                                <div className="form-control-wrap">
                                    <input type="file" id="file" accept=".pdf" className="form-control" {...register('file', { required: "This Field is required" })} />
                                    {errors.file && <span className="invalid">{errors.file.message}</span>}
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
                        <span className="sub-text">Members Guide</span>
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>
                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        {/* {membersGuide} */}
                                        {/* <BlockTitle tag="h4">All Membership</BlockTitle> */}
                                        {/* <p>{regulators}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {/* {$fees && <AdminRegulatorTable  updateParent={updateParentState} parentState={parentState} data={$regulators} expandableRows pagination actions />} */}
                                    {$membersGuide &&
                                        <Card className="card-bordered gold">
                                            <CardHeader className="border-bottom">
                                                Members Guide
                                            </CardHeader>
                                            <CardBody className="card-inner">
                                                <CardTitle tag="h5">{$membersGuide.name}</CardTitle>
                                                <CardText>
                                                    {/* {$applicantGuide.url} */}
                                                </CardText>
                                                <a style={{ marginRight: '10px' }} href={$membersGuide.file_path} target="_blank" className="btn btn-primary" rel="noreferrer">View Document</a>
                                                <Button color="primary" onClick={toggleUpdateForm}>Edit</Button>
                                            </CardBody>
                                            {/* <CardFooter className="border-top">{moment($applicantGuide.created_at).format('ll')}</CardFooter> */}

                                            <Modal isOpen={modalFormUpdate} toggle={toggleUpdateForm} >
                                                <ModalHeader toggle={toggleUpdateForm} close={<button className="close" onClick={toggleUpdateForm}><Icon name="cross" /></button>}>
                                                    Update
                                                </ModalHeader>
                                                <ModalBody>
                                                    <UpdateMembersComponent membersGuide={$membersGuide} updateParent={updateParentState} />
                                                </ModalBody>
                                                <ModalFooter className="bg-light">
                                                    <span className="sub-text">Update Members Guide</span>
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
export default AdminMembersGuide;
