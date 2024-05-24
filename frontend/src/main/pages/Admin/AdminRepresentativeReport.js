import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useForm } from "react-hook-form";
import { useNavigate } from "react-router-dom";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, BlockContent, Button, Row, Col, BlockBetween, Icon, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { adminLoadARsReport } from "redux/stores/authorize/representative"
import { loadInstitutionApplications } from "redux/stores/membership/applicationProcessStore"
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import { loadAllActivePositions } from 'redux/stores/positions/positionStore'
import { loadAllActiveInstitutions } from 'redux/stores/institution/institutionStore'
import { loadAllActiveCategories } from 'redux/stores/memberCategory/category'
import AdminRepresentativeReportTable from './Tables/AdminRepresentativeReportTable'
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import DatePicker from "react-datepicker";
import CopyToClipboard from "react-copy-to-clipboard";
import moment from 'moment';



const AdminRepresentativeReport = ({ drawer }) => {

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [parentState, setParentState] = useState('Initial state');

    const updateParentState = (newState) => {
        setParentState(newState);
    };


    const active_categories = useSelector((state) => state?.category?.list) || null;
    const institutions = useSelector((state) => state?.institutions?.list) || null;
    const active_positions = useSelector((state) => state?.position?.all_list) || null;

    const ar_users = useSelector((state) => state?.arUsers?.report_list) || null;
    useEffect(() => {
        dispatch(loadAllActiveInstitutions());
        dispatch(loadAllActivePositions());
        dispatch(loadAllActiveCategories());
        dispatch(adminLoadARsReport({ "approval_status": "", "institution_id": "", "role_id": "" }));
    }, [dispatch, parentState]);

    const $ar_users = ar_users ? JSON.parse(ar_users) : null;
    const $active_categories = active_categories ? JSON.parse(active_categories) : null;
    const $institutions = institutions ? JSON.parse(institutions) : null;
    const $active_positions = active_positions ? JSON.parse(active_positions) : null;


    let filteredApplication = $ar_users;



    const { register, handleSubmit, formState: { errors }, resetField, setValue, getValues } = useForm();
    const [loading, setLoading] = useState(false);
    const [startDate, setStartDate] = useState(false);
    const [endDate, setEndDate] = useState(false);
    const [tableData, setTableData] = useState($ar_users);


    const handleFormSubmit = async (values) => {


        if (values?.start_date) {
            filteredApplication = filteredApplication.filter((item) => item.created_at > values?.start_date)
        }
        if (values?.end_date) {
            filteredApplication = filteredApplication.filter((item) => item.created_at < values?.end_date)
        }
        if (values?.institution) {
            filteredApplication = filteredApplication.filter((item) => item.institution.id == values?.institution)
        }
        if (values?.position) {
            filteredApplication = filteredApplication.filter((item) => item.position.id == values?.position)
        }

        setTableData(filteredApplication)

    };

    const setDate = (item, value) => {

        setValue(item, value);
        if (item == 'start_date') {
            setStartDate(value)
        }
        if (item == 'end_date') {
            setEndDate(value)
        }
    }

    const [copied, setCopied] = useState(false);

    const toggleCopied = () => setCopied(!copied);

    const copyToClipboard = () => setCopied(true);

    return (
        <React.Fragment>
            <Head title="Authorised Representatives Reports"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Authorised Representatives Reports
                            </BlockTitle>
                            {/* {categories} */}
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
                                    <BlockHeadContent>
                                        <BlockTitle tag="h4">Authorised Representatives Report Filter</BlockTitle>
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>

                                    <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                                        <Row>
                                            <Col md={'3'}>

                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="full-name">
                                                        Start Date
                                                    </label>
                                                    <div className="form-control-wrap">

                                                        <input type="hidden" {...register('start_date')} />
                                                        <DatePicker selected={startDate ? new Date(startDate) : ""} onChange={(e) => {
                                                            setDate('start_date', e);
                                                        }} className="form-control date-picker" />

                                                    </div>
                                                </div>
                                            </Col>
                                            <Col md={'3'}>

                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="full-name">
                                                        End Date
                                                    </label>
                                                    <div className="form-control-wrap">

                                                        <input type="hidden" {...register('end_date')} />
                                                        <DatePicker selected={endDate ? new Date(endDate) : ""} onChange={(e) => {
                                                            setDate('end_date', e);
                                                        }} className="form-control date-picker" />

                                                    </div>
                                                </div>
                                            </Col>

                                            <Col md={'3'}>
                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="institution">
                                                        Institution
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <select className="form-control form-select" {...register('institution')}>
                                                                <option value=''>All</option>
                                                                {$institutions && $institutions.map((institution, index) =>
                                                                    <option key={`activeInstitution${index}`} value={institution.id}>{institution.name}</option>
                                                                )}
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </Col>
                                            <Col md={'3'}>

                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="position">
                                                        Position
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <select className="form-control form-select" {...register('position')}>
                                                                <option value=''>All</option>
                                                                {$active_positions && $active_positions.map((active_position, index) =>
                                                                    <option key={`activePosition${index}`} value={active_position.id}>{active_position.name}</option>
                                                                )}
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </Col>
                                            <Col md={'12'} className="">

                                                <div className="form-group float-end m-5">
                                                    <Button color="primary" type="submit" size="lg">
                                                        {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Filter Report"}
                                                    </Button>
                                                </div>
                                            </Col>
                                        </Row>

                                    </form>
                                </PreviewCard>
                            </Block>


                        </Content>
                        <Content>

                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        {authUser.is_admin_meg() && <>
                                            <BlockContent>
                                                {/* <Button color="primary" type="submit" size="lg">
                                                    {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Filter Report"}
                                                </Button> */}
                                                <div className="float-end" >
                                                    <CopyToClipboard text={`${window.location.host}${process.env.PUBLIC_URL}/stakeholder-ar-request`}>
                                                        <Button color="primary" size="lg" onClick={() => copyToClipboard()}>
                                                            <span>Copy stakeholder request link</span>
                                                        </Button>
                                                    </CopyToClipboard>{" "}
                                                    <Button color="primary" size="lg" onClick={() => navigate(`${process.env.PUBLIC_URL}/admin-stakeholder-request`)}>
                                                        <span>Stakeholder requests</span>
                                                    </Button>

                                                    <Modal isOpen={copied} toggle={toggleCopied} className="modal-dialog-centered text-center" size="sm">
                                                        <ModalHeader toggle={toggleCopied} close={<button className="close" onClick={toggleCopied}><Icon name="cross" /></button>}>

                                                        </ModalHeader>
                                                        <ModalBody className="text-center m-2">
                                                            <h5>Copied to clipboard</h5>
                                                        </ModalBody>
                                                        <div className="p-3 bg-light">
                                                            <div className="text-center">AR Report URL link copied to clipboard</div>
                                                        </div>
                                                    </Modal>

                                                </div>
                                            </BlockContent>
                                        </>}

                                        <BlockTitle tag="h4">Authorised Representatives Reports</BlockTitle>
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$ar_users && <AdminRepresentativeReportTable updateParent={updateParentState} parentState={parentState} data={tableData || $ar_users} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminRepresentativeReport;
