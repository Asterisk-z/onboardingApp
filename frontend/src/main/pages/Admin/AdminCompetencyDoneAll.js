import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadOverAllCompliantArs, loadAllCompetencyGroupName } from "redux/stores/competency/competencyStore";
import { loadAllActiveCategories } from "redux/stores/memberCategory/category";
import { loadAllActiveGroupPositions } from "redux/stores/positions/positionStore";
import { loadAllActiveInstitutions } from 'redux/stores/institution/institutionStore'
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminCompetencyAllARTable from './Tables/AdminCompetencyAllARTable'



const AdminCompliantArs = ({ drawer }) => {

    const dispatch = useDispatch();

    const navigate = useNavigate();

    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);

    const compliant_ars = useSelector((state) => state?.competency?.list_all_com_ars) || null;

    const categories = useSelector((state) => state?.category?.list) || null;
    const institutions = useSelector((state) => state?.institutions?.list) || null;
    const positions = useSelector((state) => state?.position?.all_group_list) || null;
    const competencyNames = useSelector((state) => state?.competency?.list_com_group_name) || null;

    useEffect(() => {
        dispatch(loadOverAllCompliantArs());
    }, [dispatch, parentState]);

    useEffect(() => {
        dispatch(loadAllActiveGroupPositions());
        dispatch(loadAllCompetencyGroupName());
        dispatch(loadAllActiveInstitutions());
        dispatch(loadAllActiveCategories());
    }, [dispatch]);

    const $categories = categories ? JSON.parse(categories) : null;
    const $positions = positions ? JSON.parse(positions) : null;
    const $institutions = institutions ? JSON.parse(institutions) : null;
    const $competencyNames = competencyNames ? JSON.parse(competencyNames) : null;

    const $compliant_ars = compliant_ars ? JSON.parse(compliant_ars) : null;


    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const toggleForm = () => setModalForm(!modalForm);

    let filteredCompliantArs = $compliant_ars;
    const [tableData, setTableData] = useState($compliant_ars);

    const handleFormSubmit = async (values) => {

        if (values?.institution) {
            filteredCompliantArs = filteredCompliantArs.filter((item) => item.institution?.id == values?.institution)
        }
        if (values?.competencyName) {
            filteredCompliantArs = filteredCompliantArs.filter((item) => item?.framework?.name == values?.competencyName)
        }
        if (values?.position) {
            filteredCompliantArs = filteredCompliantArs.filter((item) => item?.framework?.position == values?.position)
        }
        if (values?.category) {
            filteredCompliantArs = filteredCompliantArs.filter((item) => item?.framework?.member_category == values?.category)
        }
        setTableData(filteredCompliantArs)
    };



    return (
        <React.Fragment>
            <Head title="Compliant Ars - Competency"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                All Compliant ARs
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" >
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={(e) => navigate(process.env.PUBLIC_URL + '/admin-competency-framework')}>Back</span>
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
                                            <Col md={'3'}>

                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="institution">
                                                        Institution
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <select className="form-control form-select" {...register('institution')}>
                                                                <option value=''>All</option>
                                                                {$institutions && $institutions.map((institution, index) => {
                                                                    if (institution.name) {
                                                                        return <option key={`institution${index}`} value={institution.id}>{institution.name}</option>
                                                                    }
                                                                }

                                                                )}
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </Col>
                                            <Col md={'3'}>

                                                <div className="form-group">
                                                    <label className="form-label" htmlFor="competencyName">
                                                        Competency Name
                                                    </label>
                                                    <div className="form-control-wrap">
                                                        <div className="form-control-select">
                                                            <select className="form-control form-select" {...register('competencyName')}>
                                                                <option value=''>All</option>
                                                                {$competencyNames && $competencyNames.map((competencyName, index) =>
                                                                    <option key={`competencyName${index}`} value={competencyName.name}>{competencyName.name}</option>
                                                                )}
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
                                                                {$categories && $categories.map((active_category, index) =>
                                                                    <option key={`activeCategory${index}`} value={active_category.id}>{active_category.name}</option>
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


                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        {/* <BlockTitle tag="h4">All Membership</BlockTitle> */}
                                        {/* <p>{competencies}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$compliant_ars && <AdminCompetencyAllARTable parentState={parentState} data={tableData || $compliant_ars} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminCompliantArs;
