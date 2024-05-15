import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllActiveComplaintTypes } from "redux/stores/complaints/complaintTypes";
import { sendCreationRequest, getArCreationRequest } from "redux/stores/authorize/arCreation";
import { loadFmdqSystems } from "redux/stores/settings/config";
import { userLoadUserARs } from "redux/stores/authorize/representative";
import { sendComplaint, loadAllComplaints } from "redux/stores/complaints/complaint";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import ArCreationRequestTable from './ArCreationRequestTable'
import Select from "react-select";



const ARCreationRequest = ({ drawer }) => {

    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [complainFile, setComplainFile] = useState([]);
    const [sm, updateSm] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const { register, handleSubmit, formState: { errors }, resetField, setValue, getValues } = useForm();
    const systems = useSelector((state) => state?.settings?.systems) || null;
    const authorize_reps = useSelector((state) => state?.arUsers?.list) || null;

    const toggleForm = () => setModalForm(!modalForm);

    useEffect(() => {
        dispatch(loadFmdqSystems());
        dispatch(userLoadUserARs({ "approval_status": "approved", "role_id": "" }));
    }, [dispatch]);

    const $authorize_reps = authorize_reps ? JSON.parse(authorize_reps) : null;
    const $authorizeRepsOption = $authorize_reps ? $authorize_reps.map((item) => {
        return { value: item?.id, label: `${item?.lastName} ${item?.firstName}` }
    }) : null;
    const $systems = systems ? JSON.parse(systems) : null;
    const $systemsOption = $systems ? $systems.map((item) => {
        return { value: item?.id, label: item?.name}
    }) : null;

    const handleFormSubmit = async (values) => {


        const postValues = new Object();
        postValues.ars = values.ars;
        postValues.system_id = values.system_id;
        try {
            setLoading(true);

            const resp = await dispatch(sendCreationRequest(postValues));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('ars')
                    resetField('system_id')
                    setCounter(!counter)
                    // window.location.reload(true)
                }, 1000);
            } else {
                setLoading(false);
            }

        } catch (error) {
            console.log(error)
            setLoading(false);
        }

    };

    const ar_request_list = useSelector((state) => state?.arCreation?.ar_request_list) || null;
    useEffect(() => {
        dispatch(getArCreationRequest({ "status": "" }));
    }, [dispatch, counter]);


    const $ar_request_list = ar_request_list ? JSON.parse(ar_request_list) : null;
    console.log($ar_request_list)
    return (
        <React.Fragment>
            <Head title="AR Creation Request"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                AR Creation Request
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" style={{ display: sm ? "block" : "none" }}>
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={toggleForm}>Create Request</span>
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
                        AR Creation Request
                    </ModalHeader>
                    <ModalBody>
                        <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                            <div className="form-group">
                                <label className="form-label" htmlFor="full-name">
                                    FMDQ Systems
                                </label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <Select
                                            classNamePrefix="react-select"
                                            options={$systemsOption} 
                                            {...register('system_id', { required: "System is Required" })} 
                                            onChange={(e) => {
                                                setValue('system_id', e.value);
                                            }}
                                        />
                                        {errors.system_id && <p className="invalid">{`${errors.system_id.message}`}</p>}
                                    </div>
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="full-name">
                                    AR
                                </label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <Select
                                            classNamePrefix="react-select"
                                            options={$authorizeRepsOption} isMulti
                                            {...register('ars', { required: "AR is Required" })}
                                            onChange={(e) => {
                                                setValue('ars', e.map((item) => (item.value)));
                                                // setValue('ars', e.map((item) => (item.value)));
                                            }}
                                        />
                                        {errors.ars && <p className="invalid">{`${errors.ars.message}`}</p>}
                                    </div>
                                </div>
                            </div>
                            <div className="form-group">
                                <Button color="primary" type="submit" size="lg">
                                    {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Submit"}
                                </Button>
                            </div>
                        </form>
                    </ModalBody>
                    <ModalFooter className="bg-light">
                        
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>


                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        <BlockTitle tag="h4">Request History</BlockTitle>
                                        {/* <p>{ar_request_list}</p> */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$ar_request_list && <ArCreationRequestTable data={$ar_request_list} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default ARCreationRequest;
