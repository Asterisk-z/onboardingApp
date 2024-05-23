import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
// import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, CardFooter, CardText, CardTitle, CardBody, CardHeader } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllMembersGuide, createMembersGuide, updateMembersGuide } from "redux/stores/membersGuide/membersGuideStore";
import { loadGetSignature, postSignature } from "redux/stores/settings/config"
import Content from "layout/content/Content";
import Head from "layout/head/Head";
// import data from "@srcMain";
// import AdminRegulatorTable from "./Tables/AdminRegulatorTable";



const AdminDoh = ({ drawer }) => {

    const dispatch = useDispatch();

    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const [modalFormUpdate, setModalFormUpdate] = useState(false);

    const dohList = useSelector((state) => state?.settings?.doh_list) || null;

    useEffect(() => {
        dispatch(loadGetSignature());
    }, [dispatch, parentState]);

    const $dohList = dohList ? JSON.parse(dohList) : null;

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const toggleForm = () => setModalForm(!modalForm);
    const toggleUpdateForm = () => setModalFormUpdate(!modalFormUpdate);


    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('name', values.name)
        formData.append('grade', values.grade)
        formData.append('division', values.division)
        formData.append('signature', values.signature[0])
        try {
            setLoading(true);

            const resp = await dispatch(postSignature(formData));

            if (resp.payload?.message === "success") {
                // console.log(formData);
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('name')
                    resetField('grade')
                    resetField('division')
                    resetField('signature')
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
            <Head title="DOH Signature"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                DOH Signature
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" >
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            {/* {!$membersGuide && */}
                                            <Button color="primary">
                                                <span onClick={toggleForm}>Create DOH Signature</span>
                                            </Button>
                                            {/* } */}
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
                        Create DOH Signature
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
                                <label className="form-label" htmlFor="grade">
                                    Grade
                                </label>
                                <div className="form-control-wrap">
                                    <input type="text" id="grade" className="form-control" {...register('grade', { required: "This Field is required" })} />
                                    {errors.grade && <span classgrade="invalid">{errors.grade.message}</span>}
                                </div>
                            </div>

                            <div className="form-group">
                                <label className="form-label" htmlFor="division">
                                    Division
                                </label>
                                <div className="form-control-wrap">
                                    <input type="text" id="division" className="form-control" {...register('division', { required: "This Field is required" })} />
                                    {errors.division && <span className="invalid">{errors.division.message}</span>}
                                </div>
                            </div>

                            <div className="form-group">
                                <label className="form-label" htmlFor="signature">
                                    Upload Signature
                                </label>
                                <div className="form-control-wrap">
                                    <input type="file" id="file" accept=".jpeg,.png,.jpg" className="form-control" {...register('signature', { required: "This Field is required" })} />
                                    {errors.signature && <span className="invalid">{errors.signature.message}</span>}
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
                                    {$dohList && <>

                                        <Card className="card-bordered">
                                            <CardHeader className="border-bottom">
                                                DOH Signature
                                            </CardHeader>
                                            <CardBody className="card-inner">
                                                <CardTitle tag="h6">{$dohList.grade}</CardTitle>
                                                <CardTitle tag="h6">{$dohList.division}</CardTitle>
                                                <CardTitle tag="h6">{$dohList.name}</CardTitle>
                                                <CardText>
                                                    {/* {$applicantGuide.url} */}
                                                </CardText>
                                                <a style={{ marginRight: '10px' }} href={dohList.signature} target="_blank" className="btn btn-primary" rel="noreferrer">View Signature</a>

                                            </CardBody>
                                        </Card>
                                    </>

                                    }
                                    {/* {$dohList} */}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>

            </Content>
        </React.Fragment>
    );
};
export default AdminDoh;
