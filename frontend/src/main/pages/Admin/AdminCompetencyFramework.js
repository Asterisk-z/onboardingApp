import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllActiveCategories } from "redux/stores/memberCategory/category";
import { loadAllActiveGroupPositions } from "redux/stores/positions/positionStore";
import { createCompetency, loadAllCompetency, loadAllCompetencyGroupName } from "redux/stores/competency/competencyStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminCompetencyTable from './Tables/AdminCompetencyTable'


const AdminCreateCompetencyFramework = ({ activeCategories, activePositions, updateParent, closeModel }) => {

    const dispatch = useDispatch();
    const navigate = useNavigate();

    const [loading, setLoading] = useState(false);

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();


    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('name', values.name)
        formData.append('description', values.description)
        formData.append('position', values.position)
        formData.append('member_category', values.member_category)

        try {
            setLoading(true);

            const resp = await dispatch(createCompetency(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    closeModel()
                    resetField('name')
                    resetField('description')
                    resetField('position')
                    resetField('member_category')
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
        <React.Fragment>
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
                    <label className="form-label" htmlFor="description">
                        Description
                    </label>
                    <div className="form-control-wrap">
                        <textarea id="description" className="form-control" {...register('description', { required: "This Field is required" })} ></textarea>
                        {errors.description && <span className="invalid">{errors.description.message}</span>}
                    </div>
                </div>
                <div className="form-group">
                    <label className="form-label" htmlFor="member_category">
                        Membership Category
                    </label>
                    <div className="form-control-wrap">
                        <div className="form-control-select">
                            <select className="form-control form-select" id="member_category" style={{ color: "black !important" }} {...register('member_category', { required: "This Field is Required" })}>
                                <option value="">Select Membership Category</option>
                                {$activeCategories && $activeCategories?.map((category) => (
                                    <option key={category.id} value={category.id}>
                                        {category.name}
                                    </option>
                                ))}
                            </select>
                            {errors.member_category && <p className="invalid">{`${errors.member_category.message}`}</p>}
                        </div>
                    </div>
                </div>
                <div className="form-group">
                    <label className="form-label" htmlFor="position">
                        Position
                    </label>
                    <div className="form-control-wrap">
                        <div className="form-control-select">
                            <select className="form-control form-select" id="position" style={{ color: "black !important" }} {...register('position', { required: "THis Field is Required" })}>
                                <option value="">Select Position</option>
                                {$activePositions && $activePositions?.map((position) => (
                                    <option key={position.id} value={position.id}>
                                        {position.name}
                                        {position.is_compulsory == '1' && <span style={{ color: 'red' }}>*</span>}
                                    </option>
                                ))}
                            </select>
                            {errors.positions && <p className="invalid">{`${errors.positions.message}`}</p>}
                        </div>
                    </div>
                </div>
                <div className="form-group">
                    <Button color="primary" type="submit" size="lg">
                        {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Create"}
                    </Button>
                </div>
            </form>
        </React.Fragment>
    );
};

const AdminCompetencyFramework = ({ drawer }) => {

    const dispatch = useDispatch();
    const navigate = useNavigate();

    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);

    const categories = useSelector((state) => state?.category?.list) || null;
    const positions = useSelector((state) => state?.position?.all_group_list) || null;
    const competencies = useSelector((state) => state?.competency?.list) || null;
    const competencyNames = useSelector((state) => state?.competency?.list_com_group_name) || null;

    useEffect(() => {
        dispatch(loadAllCompetency());
    }, [dispatch, parentState]);

    useEffect(() => {
        dispatch(loadAllActiveGroupPositions());
        dispatch(loadAllCompetencyGroupName());
        dispatch(loadAllActiveCategories());
    }, [dispatch]);


    const $categories = categories ? JSON.parse(categories) : null;
    const $positions = positions ? JSON.parse(positions) : null;
    const $competencies = competencies ? JSON.parse(competencies) : null;
    const $competencyNames = competencyNames ? JSON.parse(competencyNames) : null;

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const toggleForm = () => setModalForm(!modalForm);

    let filteredCompetencies = $competencies;
    const [tableData, setTableData] = useState($competencies);

    const handleFormSubmit = async (values) => {
        if (values?.competencyName) {
            filteredCompetencies = filteredCompetencies.filter((item) => item.name == values?.competencyName)
        }
        if (values?.position) {
            filteredCompetencies = filteredCompetencies.filter((item) => item.position == values?.position)
        }
        if (values?.category) {
            filteredCompetencies = filteredCompetencies.filter((item) => item.member_category == values?.category)
        }
        setTableData(filteredCompetencies)
    };

    const updateParentState = (newState) => {
        setParentState(newState);
    };

    return (
        <React.Fragment>
            <Head title="Competency"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Competency
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" >
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/admin-competency-done-all`)}>All Compliant ARs</span>
                                            </Button>
                                        </li>
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/admin-competency-undone-all`)}>All Non Compliant ARs</span>
                                            </Button>
                                        </li>
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={toggleForm}>Add new Competency Framework</span>
                                            </Button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>

                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        <BlockTitle tag="h4">Competency List Filter</BlockTitle>
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>

                                    <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                                        <Row>
                                            <Col md={'4'}>

                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="competencyName">
                                                        Competency Name
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <select className="form-control form-select" {...register('competencyName')}>
                                                                <option value=''>All</option>
                                                                {$competencyNames && $competencyNames.map((competencyName, index) =>
                                                                    <option key={`competencyName${index}`} value={competencyName.id}>{competencyName.name}</option>
                                                                )}
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </Col>
                                            <Col md={'4'}>

                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="category">
                                                        Category
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <select className="form-control form-select" {...register('category')}>
                                                                <option value=''>All</option>
                                                                {$categories && $categories.map((active_category, index) =>
                                                                    <option key={`activeCategory${index}`} value={active_category.id}>{active_category.name}</option>
                                                                )}
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </Col>
                                            <Col md={'4'}>

                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="position">
                                                        Position
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <select className="form-control form-select" {...register('position')}>
                                                                <option value=''>All</option>
                                                                {$positions && $positions.map((active_position, index) =>
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

                            <Modal isOpen={modalForm} toggle={toggleForm}>
                                <ModalHeader toggle={toggleForm} close={
                                    <button className="close" onClick={toggleForm}>
                                        <Icon name="cross" />
                                    </button>
                                }
                                >
                                    Create Competency
                                </ModalHeader>
                                <ModalBody>
                                    <AdminCreateCompetencyFramework activeCategories={$categories} activePositions={$positions} updateParent={updateParentState} closeModel={toggleForm} />
                                </ModalBody>
                                <ModalFooter className="bg-light">
                                    <span className="sub-text">Competencies</span>
                                </ModalFooter>
                            </Modal>

                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        {/* <BlockTitle tag="h4">All Membership</BlockTitle> */}
                                        {/* <p>{competencies}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$competencies && <AdminCompetencyTable updateParent={updateParentState} parentState={parentState} data={tableData || $competencies} positions={$positions} categories={$categories} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminCompetencyFramework;
