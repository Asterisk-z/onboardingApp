import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllCategories, createMembershipCategory } from "redux/stores/memberCategory/category";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminCategoryTable from './Tables/AdminCategoryTable'



const AdminCategory = ({ drawer }) => {
        
    const dispatch = useDispatch();

    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    
    const categories = useSelector((state) => state?.category?.all_list) || null;

    useEffect(() => {
        dispatch(loadAllCategories());
    }, [dispatch, parentState]);

    
    const { register, handleSubmit, formState: { errors }, resetField } = useForm();
 
    const toggleForm = () => setModalForm(!modalForm);

    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('code', values.code)
        formData.append('name', values.name)
        
        try {
            setLoading(true);
            
            const resp = await dispatch(createMembershipCategory(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('code')
                    resetField('name')
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
    
    const updateParentState = (newState) => {
        console.log(newState)
        setParentState(newState);
    };


    return (
        <React.Fragment>
            <Head title="Category"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Membership Categories
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" >
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={toggleForm}>Create Category</span>
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
                        Create Category
                    </ModalHeader>
                    <ModalBody>
                        <form  onSubmit={handleSubmit(handleFormSubmit)}  className="is-alter" encType="multipart/form-data">
                            
                            <div className="form-group">
                                <label className="form-label" htmlFor="code">
                                    Code
                                </label>
                                <div className="form-control-wrap">
                                    <input type="text" id="code" className="form-control" {...register('code', { required: "This Field is required" })}  />
                                    {errors.code && <span className="invalid">{ errors.code.message }</span>}
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="full-name">
                                    Name
                                </label>
                                <div className="form-control-wrap">
                                    <input type="text" id="name" className="form-control" {...register('name', { required: "This Field is required" })} />
                                    {errors.name && <span className="invalid">{ errors.name.message }</span>}
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
                        <span className="sub-text">Categories</span>
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>


                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        {/* <BlockTitle tag="h4">All Membership</BlockTitle> */}
                                        {/* <p>{categories}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$categories && <AdminCategoryTable  updateParent={updateParentState} parentState={parentState} data={$categories} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminCategory;
