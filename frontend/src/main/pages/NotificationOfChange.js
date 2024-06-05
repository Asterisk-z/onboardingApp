import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { sendNotificationOfChange, loadArNotificationOfChange } from "redux/stores/notificationOfChange/changeStore";
import { loadAllActiveAuthoriser } from "redux/stores/users/userStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import NotificationOfChangeTable from './Tables/NotificationOfChangeTable'
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';



const NotificationOfChange = ({ drawer }) => {

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    const navigate = useNavigate();

    const [loading, setLoading] = useState(false);
    const [confidentialityLevels, setConfidentialityLevels] = useState([{ 'id': 'high', 'name': 'High' }, { 'id': 'medium', 'name': 'Medium' }, { 'id': 'low', 'name': 'Low' },]);

    const [complainFile, setComplainFile] = useState([]);
    const [sm, updateSm] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const { register, handleSubmit, formState: { errors }, resetField, setError, clearErrors } = useForm();

    const [parentState, setParentState] = useState('Initial state');
    const toggleParent = (newState) => {
        setParentState(newState);
    };
    const toggleForm = () => setModalForm(!modalForm);

    const [requireRegulatoryApproval, setRequireRegulatoryApproval] = useState(true);

    const authorizers = useSelector((state) => state?.user?.list) || null;
    useEffect(() => {
        dispatch(loadAllActiveAuthoriser());
    }, [dispatch]);
    const $authorizers = authorizers ? JSON.parse(authorizers) : null;


    const [regulatoryFile, setRegulatoryFile] = useState([]);

    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('subject', values.subject)
        formData.append('summary', values.summary)
        formData.append('ar_authoriser_id', values.ar_authoriser_id)
        formData.append('regulatory_status', values.requireRegulatoryApproval)
        formData.append('confidentiality_level', values.confidentiality_level)
        if (values.requireRegulatoryApproval == 'yes') formData.append('regulatory_approval', values.regulatory_approval?.length > 0 ? values.regulatory_approval[0] : '')
        if (values.attachment?.length > 0) formData.append('attachment', values.attachment?.length > 0 ? values.attachment[0] : '')

        try {
            setLoading(true);

            const resp = await dispatch(sendNotificationOfChange(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('subject')
                    resetField('summary')
                    resetField('ar_authoriser_id')
                    resetField('requireRegulatoryApproval')
                    resetField('regulatory_approval')
                    resetField('confidentiality_level')
                    resetField('attachment')
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

    const handleRegulatoryFile = (event) => {
        setRegulatoryFile(event.target.files[0]);
    };

    const handleFileChange = (event) => {
        setComplainFile(event.target.files[0]);
    };

    const checkLength = (event, field) => {
        if (event.target.value.length > 200) {
            setError(field, { type: 'fieldLength', message: 'The characters can not be more than 200 characters' }, { shouldFocus: true });
        } else {
            clearErrors(`${field}.fieldLength`)
        }
    };


    const list_ar_changes = useSelector((state) => state?.change?.list_ar_changes) || null;
    useEffect(() => {
        dispatch(loadArNotificationOfChange());
    }, [dispatch, counter, parentState]);
    const $list_ar_changes = list_ar_changes ? JSON.parse(list_ar_changes) : null;


    return (
        <React.Fragment>
            <Head title="Notification Of Change"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Notification Of Change
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            {authUser.is_ar_inputter() ? <>
                                <div className="toggle-wrap nk-block-tools-toggle">
                                    <div className="toggle-expand-content" style={{ display: sm ? "block" : "none" }}>
                                        <ul className="nk-block-tools g-3">
                                            <li className="nk-block-tools-opt">
                                                <Button color="primary">
                                                    <span onClick={toggleForm}>Add Change</span>
                                                </Button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </> : ''}
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
                        Fill Notification Of Change Form
                    </ModalHeader>
                    <ModalBody>
                        <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                            <div className="form-group">
                                <label className="form-label" htmlFor="email">
                                    Change Subject
                                </label>
                                <div className="form-control-wrap">
                                    <input type="text" className="form-control" {...register('subject', { required: "This Field is Required" })} onBlur={(event) => checkLength(event, 'subject')} />
                                    {errors.subject && <p className="invalid">{`${errors.subject.message}`}</p>}
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="email">
                                    Summary Explanation Of Change
                                </label>
                                <div className="form-control-wrap">
                                    <textarea type="text" className="form-control" {...register('summary', { required: "This Field is Required" })} onBlur={(event) => checkLength(event, 'summary')}></textarea>
                                    {errors.summary && <p className="invalid">{`${errors.summary.message}`}</p>}
                                </div>
                            </div>


                            <div className="form-group">
                                <label className="form-label" htmlFor="requireRegulatoryApproval">
                                    Does change require regulatory approval?
                                </label>
                                <div className="form-control-wrap">
                                    <ul className="custom-control-group" id="requireRegulatoryApproval">
                                        <li>
                                            <div className="custom-control custom-radio custom-control-pro no-control checked">
                                                <input type="radio" className="custom-control-input" name="requireRegulatoryApproval" value={'yes'} id="requireRegulatoryApprovalYes" onClick={() => setRequireRegulatoryApproval(true)}  {...register('requireRegulatoryApproval', { required: "This Field is required" })} defaultChecked={true} />
                                                <label className="custom-control-label" htmlFor="requireRegulatoryApprovalYes">
                                                    Yes
                                                </label>
                                            </div>
                                        </li>
                                        <li>
                                            <div className="custom-control custom-radio custom-control-pro no-control checked">
                                                <input type="radio" className="custom-control-input" name="requireRegulatoryApproval" value={'no'} id="requireRegulatoryApprovalNo" onClick={() => setRequireRegulatoryApproval(false)}  {...register('requireRegulatoryApproval', { required: "This Field is required" })} />
                                                <label className="custom-control-label" htmlFor="requireRegulatoryApprovalNo">
                                                    No
                                                </label>
                                            </div>
                                        </li>

                                    </ul>
                                    {errors.requireRegulatoryApproval && <span className="invalid">{errors.requireRegulatoryApproval.message}</span>}
                                </div>
                            </div>

                            {requireRegulatoryApproval &&

                                <div className="form-group">
                                    <label className="form-label" htmlFor="phone-no">
                                        Upload the regulatory approval
                                    </label>
                                    <div className="form-control-wrap">
                                        <input type="file" accept=".jpg,.jpeg,.png,.pdf" className="form-control"  {...register('regulatory_approval', { required: "File is Required" })} onChange={handleRegulatoryFile} />
                                        {errors.regulatory_approval && <p className="invalid">{`${errors.regulatory_approval.message}`}</p>}
                                    </div>
                                </div>
                            }


                            <div className="form-group">
                                <label className="form-label" htmlFor="full-name">
                                    Confidentiality Level
                                </label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select" style={{ color: "black !important" }} {...register('confidentiality_level', { required: "Type is Required" })}>
                                            <option value="">Select Level</option>
                                            {confidentialityLevels && confidentialityLevels?.map((confidentialityLevel) => (
                                                <option key={confidentialityLevel.id} value={confidentialityLevel.id}>
                                                    {confidentialityLevel.name}
                                                </option>
                                            ))}
                                        </select>
                                        {errors.confidentiality_level && <p className="invalid">{`${errors.confidentiality_level.message}`}</p>}
                                    </div>
                                </div>
                            </div>

                            <div className="form-group">
                                <label className="form-label" htmlFor="phone-no">
                                    Attach any other document
                                </label>
                                <div className="form-control-wrap">
                                    <input type="file" accept=".gif,.jpg,.jpeg,.png,.pdf" className="form-control"  {...register('attachment', {})} onChange={handleFileChange} />
                                    {errors.attachment && <p className="invalid">{`${errors.attachment.message}`}</p>}
                                </div>
                            </div>

                            <div className="form-group">
                                <label className="form-label" htmlFor="full-name">
                                    Authoriser
                                </label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select" style={{ color: "black !important" }} {...register('ar_authoriser_id', { required: "Type is Required" })}>
                                            <option value="">Select Authoriser</option>
                                            {/* {$authorizers && $authorizers?.map((authorizer, index) => authorizer.approval_status == 'approved' ? ( */}
                                            {$authorizers && $authorizers?.map((authorizer, index) => authUser?.user_data?.id != authorizer.id && authorizer.approval_status == 'approved' ? (
                                                <option key={index} value={authorizer.id}>
                                                    {`${authorizer.first_name} ${authorizer.last_name} ( ${authorizer.email} )`}
                                                </option>
                                            ) : "")}
                                        </select>
                                        {errors.ar_authoriser_id && <p className="invalid">{`${errors.ar_authoriser_id.message}`}</p>}
                                    </div>
                                </div>
                            </div>

                            <div className="form-group">
                                <Button color="primary" type="submit" size="lg">
                                    {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Send Change"}
                                </Button>
                            </div>
                        </form>
                    </ModalBody>
                    <ModalFooter className="bg-light">
                        <span className="sub-text">Notification Of change</span>
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>


                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        <BlockTitle tag="h4">Change Request History</BlockTitle>
                                        {/* <p>{list_ar_changes}</p> */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$list_ar_changes && <NotificationOfChangeTable data={$list_ar_changes} updateParent={toggleParent} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default NotificationOfChange;
