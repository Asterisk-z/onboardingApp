import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, CardHeader, CardFooter, CardImg, CardText, CardBody, CardTitle, CardSubtitle, CardLink, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllActiveCompetency, sendCompetency } from "redux/stores/competency/competencyStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";


const UpdateCompetency = ({ drawer }) => {


    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    const [modalForm, setModalForm] = useState(false);
    const [modalFormView, setModalFormView] = useState(false);
    const [competencyId, setCompetencyId] = useState(0);
    const [loading, setLoading] = useState(false);
    const [evidenceFile, setEvidenceFile] = useState([]);
    const toggleForm = () => setModalForm(!modalForm);
    const toggleFormView = () => setModalFormView(!modalFormView);


    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const competencies = useSelector((state) => state?.competency?.list_active) || null;

    useEffect(() => {
        dispatch(loadAllActiveCompetency());
    }, [dispatch, counter]);

    const $competencies = competencies ? JSON.parse(competencies) : null;

    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('framework_id', competencyId)
        formData.append('comment', values.comment)
        formData.append('is_competent', 1)
        if (evidenceFile) formData.append('evidence', evidenceFile)

        try {
            setLoading(true);

            const resp = await dispatch(sendCompetency(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('comment')
                    resetField('evidence')
                    setCounter(!counter)
                    // window.location.reload(true)
                }, 1000);
            } else {
                setLoading(false);
            }

        } catch (error) {
            setLoading(false);
        }

    };

    const handleFileChange = (event) => {
        setEvidenceFile(event.target.files[0]);
    };

    return (
        <React.Fragment>
            <Head title="Upload Competency"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Competency
                            </BlockTitle>
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>


                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        {/* <BlockTitle tag="h4"></BlockTitle> */}
                                        {/* <p>{competency}</p> */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    <Row className="g-gs">
                                        {$competencies && $competencies.map((competency, index) =>
                                            <Col lg="4" key={index}>
                                                <Modal isOpen={modalFormView} toggle={toggleFormView}>
                                                    <ModalHeader toggle={toggleFormView} close={
                                                        <button className="close" onClick={toggleFormView}>
                                                            <Icon name="cross" />
                                                        </button>
                                                    }
                                                    >
                                                        Competency
                                                    </ModalHeader>
                                                    <ModalBody>
                                                        <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                                                            <div className="form-group">
                                                                <label className="form-label" htmlFor="comment">
                                                                    Comments (optional)
                                                                </label>
                                                                <div className="form-control-wrap">
                                                                    <textarea type="text" className="form-control" id="comment" {...register('comment', { required: false })} defaultValue={competency.description}></textarea>
                                                                    {errors.comment && <p className="invalid">{`${errors.comment.message}`}</p>}
                                                                </div>
                                                            </div>
                                                            <div className="form-group">
                                                                <label className="form-label" htmlFor="evidence">
                                                                    {/* Upload Evidence (*jpg, png) (optional) */}
                                                                    Evidence
                                                                </label>
                                                                {/* <div className="form-control-wrap">
                                                                    <input type="file" accept=".gif,.jpg,.jpeg,.png,.pdf" id="evidence" className="form-control"  {...register('evidence', {})} onChange={handleFileChange} />
                                                                    {errors.evidence && <p className="invalid">{`${errors.evidence.message}`}</p>}
                                                                </div> */}
                                                            </div>
                                                            <div className="form-group">

                                                            </div>
                                                        </form>
                                                    </ModalBody>
                                                    <ModalFooter className="bg-light">
                                                        <span className="sub-text">Competency</span>
                                                    </ModalFooter>
                                                </Modal>
                                                <Card className="card-bordered gold">
                                                    <CardBody className="card-inner">
                                                        <CardTitle tag="h5">{competency.name}</CardTitle>
                                                        <CardSubtitle tag="h6" className="mb-2 white">
                                                            {competency.description}
                                                        </CardSubtitle>
                                                        {!competency.ar_response ? <>
                                                            <CardLink className="btn btn-primary" color="primary" onClick={(ev) => { toggleForm(); setCompetencyId(competency.id); }}>Yes</CardLink>
                                                            <CardLink className="btn btn-primary" color="gray">No</CardLink>
                                                        </> : <>
                                                            <div className="flex">
                                                                <CardLink className="btn btn-primary" color="primary">{competency.ar_response.status == 'pending' ? `Awaiting CCO Approval` : `Approved by CCO`}</CardLink>
                                                                <CardLink href={competency?.ar_response?.evidence_file} className="btn btn-primary" color="primary" target="_blank">{`View`}</CardLink>
                                                            </div>
                                                        </>}
                                                    </CardBody>
                                                </Card>
                                            </Col>)}

                                        <Modal isOpen={modalForm} toggle={toggleForm}>
                                            <ModalHeader toggle={toggleForm} close={
                                                <button className="close" onClick={toggleForm}>
                                                    <Icon name="cross" />
                                                </button>
                                            }
                                            >
                                                Competency
                                            </ModalHeader>
                                            <ModalBody>
                                                <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                                                    <div className="form-group">
                                                        <label className="form-label" htmlFor="comment">
                                                            Comments (optional)
                                                        </label>
                                                        <div className="form-control-wrap">
                                                            <textarea type="text" className="form-control" id="comment" {...register('comment', { required: false })}></textarea>
                                                            {errors.comment && <p className="invalid">{`${errors.comment.message}`}</p>}
                                                        </div>
                                                    </div>
                                                    <div className="form-group">
                                                        <label className="form-label" htmlFor="evidence">
                                                            Upload Evidence (*jpg, png) (optional)
                                                        </label>
                                                        <div className="form-control-wrap">
                                                            <input type="file" accept=".gif,.jpg,.jpeg,.png,.pdf" id="evidence" className="form-control"  {...register('evidence', {})} onChange={handleFileChange} />
                                                            {errors.evidence && <p className="invalid">{`${errors.evidence.message}`}</p>}
                                                        </div>
                                                    </div>
                                                    <div className="form-group">
                                                        <Button color="primary" type="submit" size="lg">
                                                            {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Yes"}
                                                        </Button>
                                                    </div>
                                                </form>
                                            </ModalBody>
                                            <ModalFooter className="bg-light">
                                                <span className="sub-text">Competency</span>
                                            </ModalFooter>
                                        </Modal>
                                    </Row>
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};

export default UpdateCompetency;
