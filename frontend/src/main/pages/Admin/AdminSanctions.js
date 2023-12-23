import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button,BlockBetween, PreviewCard } from "components/Component";
import { loadAllActiveARs } from "redux/stores/sanctions/fetchAR";
import { sendSanction, loadAllSanctions } from "redux/stores/sanctions/sanctionStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminSanctionTable from './Tables/AdminSanctionTable'



const Sanction = ({ drawer }) => {
        
    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    // const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [complainFile, setComplainFile] = useState([]);
    const [sm] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const { register, handleSubmit, formState: { errors }, resetField } = useForm();
    const fetchAR = useSelector((state) => state?.fetchAR?.list) || null;

    const toggleForm = () => setModalForm(!modalForm);

    useEffect(() => {
        dispatch(loadAllActiveARs());
    }, [dispatch]);

    const $fetchAR = fetchAR ? JSON.parse(fetchAR) : null;
        
    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('ar', values.ar)
        formData.append('body', values.body)
        formData.append('document', complainFile)
        try {
            setLoading(true);
            
            const resp = await dispatch(sendSanction(formData));

            if (resp.payload?.message === "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('complaint_type')
                    resetField('body')
                    resetField('document')
                    setCounter(!counter)
                }, 1000);
            } else {
              setLoading(false);
            }
            
      } catch (error) {
        setLoading(false);
      }

    }; 

    const handleFileChange = (event) => {
		  setComplainFile(event.target.files[0]);
    };

    const sanctions = useSelector((state) => state?.sanction?.view_all) || null;
    useEffect(() => {
        dispatch(loadAllSanctions());
    }, [dispatch, counter]);
  
    
    const $sanctions = sanctions ? JSON.parse(sanctions) : null;

    return (
        <React.Fragment>
            <Head title="Sanctions"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Disciplinary and Sanctions
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" style={{ display: sm ? "block" : "none" }}>
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={toggleForm}>Add Sanction</span>
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
                        Fill Disciplinary and Sanction Form
                    </ModalHeader>
                    <ModalBody>
                        <form  onSubmit={handleSubmit(handleFormSubmit)}  className="is-alter" encType="multipart/form-data">
                            <div className="form-group">
                                <label className="form-label" htmlFor="full-name">
                                    AR
                                </label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select"  style={{ color: "black !important" }} {...register('ar', { required: "AR is Required" })}>
                                        <option value="">Select AR</option>
                                        {$fetchAR && $fetchAR?.map((fetchAR) => (
                                            <option key={fetchAR.id} value={fetchAR.id}>
                                                {fetchAR.first_name}
                                            </option>
                                        ))}
                                        </select>
                                        {errors.ar && <p className="invalid">{`${errors.ar.message}`}</p>}
                                    </div>
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="email">
                                    AR Summary
                                </label>
                                <div className="form-control-wrap">
                                    <textarea type="text" className="form-control" {...register('body', { required: "This field is Required" })}></textarea>
                                     {errors.body && <p className="invalid">{`${errors.body.message}`}</p>}
                                </div>
                            </div>
                              <div className="form-group">
                                <label className="form-label" htmlFor="email">
                                    Sanction Summary
                                </label>
                                <div className="form-control-wrap">
                                    <textarea type="text" className="form-control" {...register('body', { required: "This field is Required" })}></textarea>
                                     {errors.body && <p className="invalid">{`${errors.body.message}`}</p>}
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="phone-no">
                                    Upload Document (*pdf)
                                </label>
                                <div className="form-control-wrap">
                                    <input type="file" accept=".pdf" className="form-control"  {...register('evidence', {required: "This field is Required" })} onChange={handleFileChange}/>
                                     {errors.evidence && <p className="invalid">{`${errors.evidence.message}`}</p>}
                                </div>
                            </div>
                            <div className="form-group">
                                <Button color="primary" type="submit"  size="lg">
                                    {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : "Send Sanction"}
                                </Button>
                            </div>
                        </form>
                    </ModalBody>
                    <ModalFooter className="bg-light">
                        <span className="sub-text">Disciplinary and Sanction Module</span>
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>


                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        <BlockTitle tag="h4">Disciplinary and Sanctions History</BlockTitle>
                                        {/* <p>{sanctions}</p> */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$sanctions && <AdminSanctionTable data={$sanctions} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default Sanction;
