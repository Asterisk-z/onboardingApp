import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
// import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, CardFooter, CardText, CardTitle, CardBody, CardHeader } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadApplicantGuide, createApplicantGuide, updateApplicantGuide } from "redux/stores/applicantGuide/applicantGuideStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";



const UpdateGuideComponent = ({applicantGuide, updateParent}) => {

    const dispatch = useDispatch();

    const [loading, setLoading] = useState(false);

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();
    
    const handleFormUpdate = async (values) => {
        

        const postValues = {};
        postValues.name = values.name;
        postValues.file = values.file[0];
        postValues.id = applicantGuide.id;
        
        
        try {
            setLoading(true);


            const resp = await dispatch(updateApplicantGuide(postValues));
            
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
        <form onSubmit={handleSubmit(handleFormUpdate)} className="is-alter" enctype="multipart/form-data">
            <div className="form-group">
                <label className="form-label" htmlFor="name">
                    name
                </label>
                <div className="form-control-wrap">
                    <input type="text" id="name" className="form-control" {...register('name', { required: "This Field is required", })} defaultValue={applicantGuide.name} />
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

const AdminApplicantGuide = ({ drawer }) => {

    const dispatch = useDispatch();

    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const [modalFormUpdate, setModalFormUpdate] = useState(false);

    const applicantGuide = useSelector((state) => state?.applicantGuide?.view_all) || null;

    useEffect(() => {
        dispatch(loadApplicantGuide());
    }, [dispatch, parentState]);


    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const toggleForm = () => setModalForm(!modalForm);
    const toggleUpdateForm = () => setModalFormUpdate(!modalFormUpdate);

    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('name', values.name)
        formData.append('file', values.file[0])
        try {
            setLoading(true);

            const resp = await dispatch(createApplicantGuide(formData));

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

    const $applicantGuide = applicantGuide ? JSON.parse(applicantGuide) : null;

    const updateParentState = (newState) => {
        setModalFormUpdate(!modalFormUpdate)
        setParentState(newState);
    };

    

    return (
        <React.Fragment>
            <Head title="Applicant Guide"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Applicant Guide
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" >
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={toggleForm}>Create Applicant Guide</span>
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
                        Create Applicant Guide
                    </ModalHeader>
                    <ModalBody>
                        <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" enctype="multipart/form-data">
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
                        <span className="sub-text">Applicant Guide</span>
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
                                    {$applicantGuide && 
                                    <Card className="card-bordered">
                                        <CardHeader className="border-bottom">
                                            Applicant Guide
                                        </CardHeader>
                                        <CardBody className="card-inner">
                                            <CardTitle tag="h5">{$applicantGuide.name}</CardTitle>
                                            <CardText>
                                                {/* {$applicantGuide.url} */}
                                            </CardText>
                                            <Button color="primary" onClick={toggleUpdateForm}>Edit</Button>
                                        </CardBody>
                                        {/* <CardFooter className="border-top">{moment($applicantGuide.created_at).format('ll')}</CardFooter> */}

                                        <Modal isOpen={modalFormUpdate} toggle={toggleUpdateForm} >
                                            <ModalHeader toggle={toggleUpdateForm} close={<button className="close" onClick={toggleUpdateForm}><Icon name="cross" /></button>}>
                                                Update
                                            </ModalHeader>
                                            <ModalBody>
                                                <UpdateGuideComponent applicantGuide={$applicantGuide} updateParent={updateParentState}/>
                                            </ModalBody>
                                            <ModalFooter className="bg-light">
                                                <span className="sub-text">Update Applicant Guide</span>
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
export default AdminApplicantGuide ;
