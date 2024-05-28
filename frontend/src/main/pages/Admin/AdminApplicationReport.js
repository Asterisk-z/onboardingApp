import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useForm } from "react-hook-form";
import { useNavigate } from "react-router-dom";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadInstitutionApplications } from "redux/stores/membership/applicationProcessStore"
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import { loadAllActiveCategories } from 'redux/stores/memberCategory/category'
import AdminApplicationReportTable from './Tables/AdminApplicationReportTable'
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import DatePicker from "react-datepicker";
import moment from 'moment';



const AdminApplicationReport = ({ drawer }) => {

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [parentState, setParentState] = useState('Initial state');

    const updateParentState = (newState) => {
        setParentState(newState);
    };

    const all_institutions = useSelector((state) => state?.applicationProcess?.all_institutions) || null;
    const active_categories = useSelector((state) => state?.category?.list) || null;
    useEffect(() => {
        dispatch(loadAllActiveCategories());
        dispatch(loadInstitutionApplications());
    }, [dispatch, parentState]);

    const $all_institutions = all_institutions ? JSON.parse(all_institutions) : null;
    const $active_categories = active_categories ? JSON.parse(active_categories) : null;


    let filteredApplication = $all_institutions;



    const { register, handleSubmit, formState: { errors }, resetField, setValue, getValues } = useForm();
    const [loading, setLoading] = useState(false);
    const [startDate, setStartDate] = useState(false);
    const [endDate, setEndDate] = useState(false);
    const [tableData, setTableData] = useState($all_institutions);

    const handleFormSubmit = async (values) => {

        if (values?.start_date) {
            filteredApplication = filteredApplication.filter((item) => (new Date(item.createdAt).getTime()) > (new Date(values?.start_date).getTime()))
        }
        if (values?.end_date) {
            filteredApplication = filteredApplication.filter((item) => (new Date(item.createdAt).getTime()) < (new Date(values?.end_date).getTime()))
        }
        if (values?.status) {
            filteredApplication = filteredApplication.filter((item) => item.internal.application_type_status == values?.status)
        }
        if (values?.category) {
            filteredApplication = filteredApplication.filter((item) => item.internal.category_id == values?.category)
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

    return (
        <React.Fragment>
            <Head title="Application Report"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Application Report
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
                                        <BlockTitle tag="h4">Application Report Filter</BlockTitle>
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
                                                    <label className="form-label" htmlFor="full-name">
                                                        Status
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <select className="form-control form-select" {...register('status')}>
                                                                <option value="">Select Status</option>
                                                                <option value="Pending">Ongoing</option>
                                                                <option value="CLOSED">Closed</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </Col>
                                            <Col md={'3'}>

                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="category">
                                                        Category
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <select className="form-control form-select" {...register('category')}>
                                                                <option value=''>All</option>
                                                                {$active_categories && $active_categories.map((active_category, index) =>
                                                                    <option key={`activeCategory${index}`} value={active_category.id}>{active_category.name}</option>
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
                                        <BlockTitle tag="h4">Application Report</BlockTitle>
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$all_institutions && <AdminApplicationReportTable updateParent={updateParentState} data={tableData || $all_institutions} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminApplicationReport;
