import React, { useState, useEffect } from "react";
import Head from "../layout/head/Head";
import Content from "../layout/content/Content";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, CardFooter, CardText, CardTitle, CardBody, CardHeader } from "reactstrap";
import {
    Block,
    BlockHead,
    BlockHeadContent,
    BlockTitle,
    Icon,
    Button,
    Row,
    Col,
    BlockBetween,
    PreviewCard
} from "components/Component";
import { useForm } from "react-hook-form";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { userLoadUserARs } from "redux/stores/authorize/representative";
import { loadAllMyActiveCategories, loadAllOtherActiveCategories } from "redux/stores/memberCategory/category";
import { additionRequest, conversionRequest } from "redux/stores/membership/applicationStore";
import AuthRepTable from './Tables/AuthRepTable'
import ApplicationTable from './Tables/ApplicationTable'
import Swal from "sweetalert2";
import { loadArDashboard } from "redux/stores/dashboard/dashboardStore";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import { noArUpdateNotication } from "redux/stores/authorize/representative";


const AddMemberForm = ({ other_categories, updateParent }) => {

    const authUser = useUser();
    const dispatch = useDispatch();

    const [loading, setLoading] = useState(false);

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const handleFormSubmit = async (values) => {


        const postValues = {};
        postValues.new_category = values.category;
        postValues.institution = authUser?.user_data?.institution?.id;


        try {
            setLoading(true);


            const resp = await dispatch(additionRequest(postValues));

            // console.log(values, postValues, loading, resp.payload)
            if (resp.payload?.message === "success") {

                setTimeout(() => {
                    setLoading(false);
                    resetField('name')
                    updateParent(Math.random())
                }, 1000);
            } else {
                setLoading(false);
            }

        } catch (error) {
            setLoading(false);
        }

    };


    return (
        <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">

            <div className="form-group w-100">
                <div className="form-label">
                    <label htmlFor="category">Membership Category<span style={{ color: 'red' }}> *</span>:</label>
                </div>
                <div className="form-control-wrap">
                    <div className="form-control-select">
                        <select className="form-control form-select" style={{ width: '100%' }}  {...register('category', { required: true })} >
                            <option value="">Select A Category</option>
                            {other_categories && other_categories?.map((category) => (
                                <option key={category.id} value={category.id}>
                                    {category.name}
                                </option>
                            ))}
                        </select>
                        {errors.category && <p className="invalid">Category field is required</p>}
                    </div>
                </div>
            </div>

            <div className="form-group">
                <Button color="primary" type="submit" size="lg">
                    {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Submit"}
                </Button>
            </div>
        </form>
    )
}


const ConvertMemberForm = ({ other_categories, my_categories, updateParent }) => {

    const dispatch = useDispatch();

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const [loading, setLoading] = useState(false);

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const handleFormSubmit = async (values) => {


        const postValues = {};
        postValues.old_category = values.old_category;
        postValues.new_category = values.new_category;
        postValues.institution = authUser?.user_data?.institution?.id;


        try {
            setLoading(true);


            const resp = await dispatch(conversionRequest(postValues));

            // console.log(values, postValues, loading, resp.payload)
            if (resp.payload?.message === "success") {

                setTimeout(() => {
                    setLoading(false);
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
        <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">

            <div className="form-group w-100">
                <div className="form-label">
                    <label htmlFor="category">Membership Category<span style={{ color: 'red' }}> *</span>:</label>
                </div>
                <div className="form-control-wrap">
                    <div className="form-control-select">
                        <select className="form-control form-select" style={{ width: '100%' }}  {...register('old_category', { required: true })} >
                            <option value="">Select A Category</option>
                            {my_categories && my_categories?.map((category) => (
                                <option key={category.id} value={category.id}>
                                    {category.name}
                                </option>
                            ))}
                        </select>
                        {errors.category && <p className="invalid">Category field is required</p>}
                    </div>
                </div>
            </div>

            <div className="form-group w-100">
                <div className="form-label">
                    <label htmlFor="category">New Membership Category<span style={{ color: 'red' }}> *</span>:</label>
                </div>
                <div className="form-control-wrap">
                    <div className="form-control-select">
                        <select className="form-control form-select" style={{ width: '100%' }}  {...register('new_category', { required: true })} >
                            <option value="">Select A Category</option>
                            {other_categories && other_categories?.map((category) => (
                                <option key={category.id} value={category.id}>
                                    {category.name}
                                </option>
                            ))}
                        </select>
                        {errors.category && <p className="invalid">Category field is required</p>}
                    </div>
                </div>
            </div>

            <div className="form-group">
                <Button color="primary" type="submit" size="lg">
                    {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Submit"}
                </Button>
            </div>
        </form>
    )
}

const Homepage = () => {
    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const dispatch = useDispatch();
    const navigate = useNavigate();

    const [modalForm, setModalForm] = useState(false);
    const [modalAddForm, setModalAddForm] = useState(false);
    const [parentState, setParentState] = useState('Initial state');

    const toggleAddForm = () => setModalAddForm(!modalAddForm);
    const toggleForm = () => setModalForm(!modalForm);

    const arUsers = useSelector((state) => state?.arUsers?.list) || null;

    const complaints = useSelector((state) => state?.dashboard?.complaints) || 0;
    const applications = useSelector((state) => state?.dashboard?.applications) || 0;
    const ars = useSelector((state) => state?.dashboard?.ars) || 0;
    const application_list = useSelector((state) => state?.dashboard?.application_list) || null;
    const my_categories = useSelector((state) => state?.category?.my_categories) || null;
    const other_categories = useSelector((state) => state?.category?.other_categories) || null;


    useEffect(() => {
        dispatch(userLoadUserARs({ "approval_status": "", "role_id": "" }));
        dispatch(loadArDashboard());
        dispatch(loadAllMyActiveCategories());
        dispatch(loadAllOtherActiveCategories());
    }, [dispatch, parentState]);



    const $my_categories = my_categories ? JSON.parse(my_categories) : null;
    const $other_categories = other_categories ? JSON.parse(other_categories) : null;



    const updateParentState = (newState) => {
        setModalAddForm(false)
        setModalForm(false)
        setParentState(newState);
    };


    const noARUpdateUpdate = (uuid) => {
        Swal.fire({
            title: "Are you sure?",
            html: "By selecting 'No New AR Update', you are indicating that there are no new changes to report. <br/> <br/>With this selection, you will not receive further reminders regarding updates until your next interaction or update submission.  <br/> <br/>Please click 'Confirm' to proceed or 'Cancel' to return to the previous screen.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Confirm!",
            cancelButtonText: "Cancel!",
        }).then((result) => {
            if (result.isConfirmed) {

                const formData = new FormData();
                formData.append('application_uuid', uuid);

                const resp = dispatch(noArUpdateNotication(formData));

                // props.updateParentParent(Math.random())
                // setModalViewUpdate(false)
            }
        });
    }


    const $arUsers = arUsers ? JSON.parse(arUsers) : null;
    return (
        <React.Fragment>
            <Head title="Homepage"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Dashboard
                            </BlockTitle>
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                <Block>
                    <Row className="g-gs">
                        <Col xxl="3" sm="6">
                            <Card className="color1">
                                <div className="nk-ecwg nk-ecwg6">
                                    <div className="card-inner">
                                        <div className="card-title-group">
                                            <div className="card-title">
                                                <h6 className="title">{"My Applications"}</h6>
                                            </div>
                                        </div>
                                        <div className="data">
                                            <div className="data-group">
                                                <div className="amount">{applications}</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </Card>
                        </Col>
                        <Col xxl="3" sm="6">
                            <Card className="color2">
                                <div className="nk-ecwg nk-ecwg6">
                                    <div className="card-inner">
                                        <div className="card-title-group">
                                            <div className="card-title">
                                                <h6 className="title">{"Authorised Representatives"}</h6>
                                            </div>
                                        </div>
                                        <div className="data">
                                            <div className="data-group">
                                                <div className="amount">{ars}</div>
                                                {/* <div><Button color="secondary" onClick={v => navigate(`${process.env.PUBLIC_URL}/auth-representatives`)}>View</Button></div> */}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </Card>
                        </Col>
                        <Col xxl="3" sm="6">
                            <Card className="color4">
                                <div className="nk-ecwg nk-ecwg6">
                                    <div className="card-inner">
                                        <div className="card-title-group">
                                            <div className="card-title">
                                                <h6 className="title">{"Complaints"}</h6>
                                            </div>
                                        </div>
                                        <div className="data">
                                            <div className="data-group">
                                                <div className="amount">{complaints}</div>
                                                {/* <div><Button color="secondary">View</Button></div> */}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </Card>
                        </Col>
                        {false && <>
                            <Col xxl="3" sm="6">
                                <Card className="color3">
                                    <div className="nk-ecwg nk-ecwg6">
                                        <div className="card-inner">
                                            <div className="card-title-group">
                                                <div className="card-title">
                                                    <h6 className="title">{"Messages"}</h6>
                                                </div>
                                            </div>
                                            <div className="data">
                                                <div className="data-group">
                                                    <div className="amount">{"0"}</div>
                                                    {/* <div><Button color="secondary">View</Button></div> */}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </Card>
                            </Col>
                        </>}


                    </Row>
                </Block>
                <Content>


                    <Block size="xl">
                        <BlockHead className='flex justify-between'>
                            <BlockHeadContent>
                                <BlockTitle tag="h4">Applications</BlockTitle>
                            </BlockHeadContent>
                            <BlockHeadContent>

                                {authUser?.user_data?.is_application_completed && <>
                                    <div className="toggle-wrap nk-block-tools-toggle w-auto">
                                        <div className="toggle-expand-content" >
                                            <ul className="nk-block-tools g-3">
                                                <li className="nk-block-tools-opt">
                                                    <Button color="primary">
                                                        <span onClick={toggleForm}>New Member Conversion</span>
                                                    </Button>
                                                </li>
                                                <li className="nk-block-tools-opt">
                                                    <Button color="primary">
                                                        <span onClick={toggleAddForm}>New Member Addition</span>
                                                    </Button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </>}
                            </BlockHeadContent>
                        </BlockHead>

                        <Modal isOpen={modalAddForm} toggle={toggleAddForm}>
                            <ModalHeader toggle={toggleAddForm} close={
                                <button className="close" onClick={toggleAddForm}>
                                    <Icon name="cross" />
                                </button>
                            }
                            >
                                New Member Addition
                            </ModalHeader>
                            <ModalBody>
                                <AddMemberForm other_categories={$other_categories} updateParent={updateParentState} />
                            </ModalBody>
                            <ModalFooter className="bg-light">
                                <span className="sub-text">Application</span>
                            </ModalFooter>
                        </Modal>

                        <Modal isOpen={modalForm} toggle={toggleForm}>
                            <ModalHeader toggle={toggleForm} close={
                                <button className="close" onClick={toggleForm}>
                                    <Icon name="cross" />
                                </button>
                            }
                            >
                                New Member Conversion
                            </ModalHeader>
                            <ModalBody>
                                <ConvertMemberForm other_categories={$other_categories} my_categories={$my_categories} updateParent={updateParentState} />
                            </ModalBody>
                            <ModalFooter className="bg-light">
                                <span className="sub-text">Application</span>
                            </ModalFooter>
                        </Modal>

                        <PreviewCard>
                            {application_list && <ApplicationTable data={application_list} expandableRows pagination actions />}
                        </PreviewCard>
                    </Block>




                    <Block size="xl">
                        <BlockHead>
                            <BlockHeadContent>
                                <BlockTitle tag="h4">Authorised Representatives</BlockTitle>
                                {application_list && <>
                                    {application_list[0]?.internal?.is_applicant_executed_membership_agreement == '1' && <>
                                        <Button color="primary">
                                            <span onClick={() => navigate(`${process.env.PUBLIC_URL}/auth-representatives`)}>Update Authorised Representative </span>
                                        </Button>
                                    </>}

                                    {(application_list[application_list.length - 1]?.internal?.is_applicant_executed_membership_agreement == '1' && (application_list[application_list.length - 1]?.internal?.status_description == 'MEMBERSHIP AGREEMENT EXECUTED BY APPLICANT' || application_list[application_list.length - 1]?.internal?.status_description == 'APPLICANT UPLOADED ALL REQUIRED ARS')) && <>
                                        <Button color="primary" className="m-3">
                                            <span onClick={() => noARUpdateUpdate(application_list[application_list.length - 1]?.internal?.application_uuid)}>No New AR Update</span>
                                        </Button>
                                    </>}
                                </>}
                            </BlockHeadContent>
                        </BlockHead>

                        <PreviewCard>
                            {$arUsers && <AuthRepTable data={$arUsers} home={true} expandableRows pagination actions />}
                        </PreviewCard>
                    </Block>


                </Content>
            </Content>
        </React.Fragment>
    );
};
export default Homepage;
