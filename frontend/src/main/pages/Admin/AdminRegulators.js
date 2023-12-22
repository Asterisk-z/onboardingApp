import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
// import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllRegulators, createRegulator } from "redux/stores/regulators/regulatorStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminRegulatorTable from "./Tables/AdminRegulatorTable";



const AdminRegulator = ({ drawer }) => {
        
    const dispatch = useDispatch();

    const [parentState, setParentState] = useState('Initial state');
    const [loading, setLoading] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    
    const regulators = useSelector((state) => state?.regulator?.view_all) || null;

    useEffect(() => {
        dispatch(loadAllRegulators());
    }, [dispatch, parentState]);

    
    const { register, handleSubmit, formState: { errors }, resetField } = useForm();
 
    const toggleForm = () => setModalForm(!modalForm);

    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('name', values.name)
        formData.append('url', values.name)
        try {
            setLoading(true);
            
            const resp = await dispatch(createRegulator(formData));

            if (resp.payload?.message === "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('name')
                    resetField('url')
                    setParentState(Math.random())
                }, 1000);
            } else {
              setLoading(false);
            }
            
      } catch (error) {
        setLoading(false);
      }

    }; 
    
    const $regulators = regulators ? JSON.parse(regulators) : null;
    
    const updateParentState = (newState) => {
        console.log(newState)
        setParentState(newState);
    };


    return (
        <React.Fragment>
            <Head title="Regulators"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Regulators
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" >
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={toggleForm}>Create Regulator</span>
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
                        Create Regulator
                    </ModalHeader>
                    <ModalBody>
                        <form  onSubmit={handleSubmit(handleFormSubmit)}  className="is-alter" encType="multipart/form-data">
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
                                <label className="form-label" htmlFor="full-name">
                                    Website
                                </label>
                                <div className="form-control-wrap">
                                    <input type="url" id="url" className="form-control" {...register('url', { required: "This Field is required" })} />
                                    {errors.url && <span className="invalid">{ errors.url.message }</span>}
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
                        <span className="sub-text">Regulators</span>
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>
                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        {/* <BlockTitle tag="h4">All Membership</BlockTitle> */}
                                        {/* <p>{positions}</p> */}
                                        {/* {<p>{parentState}</p>} */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$regulators && <AdminRegulatorTable  updateParent={updateParentState} parentState={parentState} data={$regulators} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminRegulator;
