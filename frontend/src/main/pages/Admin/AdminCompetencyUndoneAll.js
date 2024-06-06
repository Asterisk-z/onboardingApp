import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadOverAllNonCompliantArs, loadAllCompetencyGroupName } from "redux/stores/competency/competencyStore";
import { loadAllActiveCategories } from "redux/stores/memberCategory/category";
import { loadAllActiveGroupPositions } from "redux/stores/positions/positionStore";
import { loadAllActiveInstitutions } from 'redux/stores/institution/institutionStore'
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminCompetencyAllARNonTable from './Tables/AdminCompetencyAllARNonTable'



const AdminNonCompliantArsAll = ({ drawer }) => {

    const dispatch = useDispatch();

    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);

    const [parentState, setParentState] = useState('Initial state');

    const non_compliant_ars = useSelector((state) => state?.competency?.list_all_non_com_ars) || null;

    useEffect(() => {
        dispatch(loadOverAllNonCompliantArs());
    }, [dispatch, parentState]);

    const categories = useSelector((state) => state?.category?.list) || null;
    const institutions = useSelector((state) => state?.institutions?.list) || null;
    const positions = useSelector((state) => state?.position?.all_group_list) || null;
    const competencyNames = useSelector((state) => state?.competency?.list_com_group_name) || null;

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

    const $non_compliant_ars = non_compliant_ars ? JSON.parse(non_compliant_ars) : null;


    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    let filteredNonCompliantArs = $non_compliant_ars;
    const [tableData, setTableData] = useState($non_compliant_ars);

    const handleFormSubmit = async (values) => {

        if (values?.institution) {
            filteredNonCompliantArs = filteredNonCompliantArs.filter((item) => item.institution_name == values?.institution)
        }
        if (values?.competencyName) {
            filteredNonCompliantArs = filteredNonCompliantArs.filter((item) => item?.name == values?.competencyName)
        }
        if (values?.position) {
            filteredNonCompliantArs = filteredNonCompliantArs.filter((item) => item?.position == values?.position)
        }
        if (values?.category) {
            filteredNonCompliantArs = filteredNonCompliantArs.filter((item) => item?.member_category == values?.category)
        }
        setTableData(filteredNonCompliantArs)
    };




    return (
        <React.Fragment>
            <Head title="Non Compliant Ars - Competency"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                All Non Compliant ARs
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
                                        <BlockTitle tag="h4">List Filter</BlockTitle>
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
                                                                        return <option key={`institution${index}`} value={institution.name}>{institution.name}</option>
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
                                        {/* <p>{non_compliant_ars}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$non_compliant_ars && <AdminCompetencyAllARNonTable parentState={parentState} data={tableData || $non_compliant_ars} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminNonCompliantArsAll;
