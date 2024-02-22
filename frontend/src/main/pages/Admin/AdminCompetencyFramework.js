import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllActiveCategories } from "redux/stores/memberCategory/category";
import { loadAllActivePositions } from "redux/stores/positions/positionStore";
import { createCompetency, loadAllCompetency } from "redux/stores/competency/competencyStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminCompetencyTable from './Tables/AdminCompetencyTable'



const AdminCompetencyFramework = ({ drawer }) => {
        
    const dispatch = useDispatch();
    const navigate = useNavigate();

    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    
    const categories = useSelector((state) => state?.category?.list) || null;
    const positions = useSelector((state) => state?.position?.list) || null;
    const competencies = useSelector((state) => state?.competency?.list) || null;

    useEffect(() => {
        dispatch(loadAllCompetency());
    }, [dispatch, parentState]);
    
    useEffect(() => {
        dispatch(loadAllActivePositions());
        dispatch(loadAllActiveCategories());
    }, [dispatch]);

    
    const { register, handleSubmit, formState: { errors }, resetField } = useForm();
 
    const toggleForm = () => setModalForm(!modalForm);

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
                    setModalForm(!modalForm)
                    resetField('name')
                    resetField('description')
                    resetField('position')
                    resetField('member_category')
                    setParentState(Math.random())
                }, 1000);
            } else {
              setLoading(false);
            }
            
      } catch (error) {
        setLoading(false);
      }

    }; 
    
    const $categories = categories ? JSON.parse(categories) : null;
    const $positions = positions ? JSON.parse(positions) : null;
    const $competencies = competencies ? JSON.parse(competencies) : null;
    
    const updateParentState = (newState) => {
        setParentState(newState);
    };


    return (
        <React.Fragment>
            <Head title="Competency Framework"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Competency Framework
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
                        <form  onSubmit={handleSubmit(handleFormSubmit)}  className="is-alter" encType="multipart/form-data">
                            
                            <div className="form-group">
                                <label className="form-label" htmlFor="name">
                                    Name
                                </label>
                                <div className="form-control-wrap">
                                    <input type="text" id="name" className="form-control" {...register('name', { required: "This Field is required" })}  />
                                    {errors.name && <span className="invalid">{ errors.name.message }</span>}
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
                                        <select className="form-control form-select" id="member_category"  style={{ color: "black !important" }} {...register('member_category', { required: "This Field is Required" })}>
                                        <option value="">Select Membership Category</option>
                                        {$categories && $categories?.map((category) => (
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
                                        {$positions && $positions?.map((position) => (
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
                                <Button color="primary" type="submit"  size="lg">
                                    {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : "Create"}
                                </Button>
                            </div>
                        </form>
                    </ModalBody>
                    <ModalFooter className="bg-light">
                        <span className="sub-text">Competencies</span>
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
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
                                    {$competencies && <AdminCompetencyTable  updateParent={updateParentState} parentState={parentState} data={$competencies} positions={$positions} categories={$categories} expandableRows pagination actions />}
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
