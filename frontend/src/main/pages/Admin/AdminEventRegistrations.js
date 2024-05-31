import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import DatePicker from "react-datepicker"
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, MultiDatePicker, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { MEGFSGLoadAllEventRegistration, loadSingleEvent, sendForCertificateSigning, signCertificate, sendCertificate } from "redux/stores/education/eventStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminEventRegistrationTable from './Tables/AdminEventRegistrationTable'
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import Swal from "sweetalert2";



const FinalForm = ({ setModalFinalForm, event_id, event_registrations }) => {

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);


    const { register, handleSubmit, formState: { errors }, resetField, setValue } = useForm();



    const $eventRegistrations = event_registrations ? event_registrations.filter((item) => item.status == 'Registered').map((val) => ({ 'label': `${val?.user.firstName} ${val?.user.lastName} (${val?.user.email})`, 'value': val.id })) : {}
    $eventRegistrations.unshift({ 'label': 'Send to all registered ARs', 'value': 'all' })


    // array.unshift(newElement);

    const handleFormSubmit = async (values) => {
        const formData = new Object();
        formData.event_id = event_id
        if (values.presentation) {
            formData.presentation = values.presentation[0]
        }
        console.log((values.ars.map((item) => item.value)).includes('all'))
        if ((values.ars.map((item) => item.value)).includes('all')) {
            formData.event_registrations = event_registrations.filter((item) => item.status == 'Registered').map((val) => (val.id))
        } else {
            formData.event_registrations = values.ars.map((val) => (val.value));
        }

        try {
            setLoading(true);

            const resp = await dispatch(sendCertificate(formData));

            if (resp.payload?.message === "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalFinalForm(false)
                    resetField('presentation')
                    resetField('ars')
                }, 1000);
            } else {
                setLoading(false);
            }

        } catch (error) {
            setLoading(false);
        }

    };

    const updateArs = (value) => {
        setValue('ars', value)
        // const category = getValues('category').map((val) => (val.value))
        // dispatch(loadAllCategoryPositions({ 'category_ids': category }));
    };

    return (
        <React.Fragment>

            <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">

                <div className="form-group">

                    <label className="form-label" htmlFor="position">
                        Qualified ARs
                    </label>
                    <div className="form-control-wrap">
                        <div className="form-control-select">
                            <input type="hidden" {...register('ars', { required: "This Field is Required" })} />
                            <RSelect name="ars" isMulti options={$eventRegistrations} onChange={(value) => updateArs(value)} />
                            {errors.ars && <p className="invalid">{`${errors.ars.message}`}</p>}
                        </div>
                    </div>
                </div>

                <div className="form-group">
                    <label className="form-label" htmlFor="presentation">
                        Upload Presentation
                    </label>
                    <div className="form-control-wrap">
                        <input type="file" id="file" accept=".pdf" className="form-control" {...register('presentation', { required: false })} />
                        {errors.presentation && <span className="invalid">{errors.presentation.message}</span>}
                    </div>
                </div>
                <div className="form-group">
                    <Button color="primary" type="submit" size="lg">
                        {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Create"}
                    </Button>
                </div>
            </form>
        </React.Fragment >
    );
};

const AdminEvents = ({ drawer }) => {

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const { event_id } = useParams();
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);



    const event = useSelector((state) => state?.educationEvent?.single_event) || null
    useEffect(() => {
        dispatch(loadSingleEvent({ "event_id": event_id }));
    }, [dispatch]);
    const $event = event ? JSON.parse(event) : null;


    const event_registrations = useSelector((state) => state?.educationEvent?.list_all_registrations) || null;
    useEffect(() => {
        dispatch(MEGFSGLoadAllEventRegistration({ 'event_id': event_id }));
    }, [dispatch, parentState]);
    const $event_registrations = event_registrations ? JSON.parse(event_registrations) : null;

    const updateParentState = (newState) => {
        setParentState(newState);
    };

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const [modalFinalForm, setModalFinalForm] = useState(false);
    const toggleFinalForm = () => setModalFinalForm(!modalFinalForm);

    const [modalForm, setModalForm] = useState(false);

    const toggleForm = () => setModalForm(!modalForm);


    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('event_id', event_id);
        formData.append('signature', values.signature[0])
        try {
            setLoading(true);

            const resp = await dispatch(signCertificate(formData));

            if (resp.payload?.message === "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
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



    const askAction = async (action) => {

        if (action == 'sendSigning') {
            Swal.fire({
                title: "Are you sure?",
                // text: "Do you wa!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Confirm",
            }).then((result) => {

                if (result.isConfirmed) {

                    const formData = new FormData();
                    formData.append('event_id', event_id);
                    dispatch(sendForCertificateSigning(formData));
                    setTimeout(() => {
                        setParentState(Math.random())
                    }, 3000)


                }
            });
        }
    }

    return (
        <React.Fragment>
            <Head title="Conference And Events"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                ARs Event Registrations
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
                                    <BlockBetween>
                                        <BlockHeadContent>
                                            <BlockTitle page tag="h3">

                                            </BlockTitle>
                                        </BlockHeadContent>
                                        <BlockHeadContent>

                                            <div className="toggle-wrap nk-block-tools-toggle">
                                                <div className="toggle-expand-content" >
                                                    <ul className="nk-block-tools g-3">

                                                        {(authUser.is_admin_meg() && $event && $event_registrations?.length > 0 && ($event.is_event_completed == 0)) && <>
                                                            <li className="nk-block-tools-opt">
                                                                <a href={$event?.preview_certificate} target="_blank">
                                                                    <Button color="primary">
                                                                        View Certificate Sample
                                                                    </Button>
                                                                </a>
                                                            </li>
                                                            {($event.is_sent_for_signing == 0) && <>
                                                                <li className="nk-block-tools-opt">
                                                                    {/* {!$membersGuide && */}
                                                                    <Button color="primary">
                                                                        <span onClick={() => askAction('sendSigning')}>Send For Certificate for signing</span>
                                                                    </Button>
                                                                    {/* } */}
                                                                </li>
                                                            </>}

                                                            {($event.is_sent_for_signing == 1 && (!$event.signed_by)) && <>
                                                                <li className="nk-block-tools-opt">
                                                                    {/* {!$membersGuide && */}
                                                                    <Button color="primary">
                                                                        <span onClick={toggleForm}>Upload Event Certificate Signature</span>
                                                                    </Button>
                                                                    {/* } */}
                                                                </li>
                                                            </>}


                                                            {($event.signed_by && ($event.cert_signature) && ($event.is_event_completed == 0)) && <>
                                                                <li className="nk-block-tools-opt">
                                                                    {/* {!$membersGuide && */}
                                                                    <Button color="primary">
                                                                        <span onClick={toggleFinalForm}>Send Certificate and Presentation</span>
                                                                    </Button>
                                                                    {/* } */}
                                                                </li>
                                                            </>}
                                                        </>}
                                                    </ul>
                                                </div>
                                            </div>

                                            {/* <BlockTitle tag="h4">All Membership</BlockTitle> */}
                                            {/* <p>{events}</p> */}
                                            {/* {<p>{parentState}</p>} */}
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
                                        Event Certificate Signature
                                    </ModalHeader>
                                    <ModalBody>
                                        <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">

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
                                        <span className="sub-text"></span>
                                    </ModalFooter>
                                </Modal>


                                <Modal isOpen={modalFinalForm} toggle={toggleFinalForm}>
                                    <ModalHeader toggle={toggleFinalForm} close={
                                        <button className="close" onClick={toggleFinalForm}>
                                            <Icon name="cross" />
                                        </button>
                                    }
                                    >
                                        Send Event AR Certificate
                                    </ModalHeader>
                                    <ModalBody>
                                        {$event_registrations && <FinalForm setModalFinalForm={setModalFinalForm} event_id={event_id} event_registrations={$event_registrations} />}
                                    </ModalBody>
                                    <ModalFooter className="bg-light">
                                        <span className="sub-text"></span>
                                    </ModalFooter>
                                </Modal>
                                <PreviewCard>
                                    {$event_registrations && <AdminEventRegistrationTable updateParent={updateParentState} parentState={parentState} data={$event_registrations} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>
                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment >
    );
};
export default AdminEvents;
