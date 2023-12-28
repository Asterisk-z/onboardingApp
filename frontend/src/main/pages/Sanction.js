import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { userLoadUserARs } from "redux/stores/authorize/representative";
import { sendSanction, loadUserSanctions } from "redux/stores/sanctions/sanctionStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import SanctionTable from './Tables/SanctionTable'




const Sanction = ({ drawer }) => {
        
    const authUser = useUser();
    const authUserUpdate = useUserUpdate();

    if (authUser.is_position_cco()) {
        const [counter, setCounter] = useState(false);
        const dispatch = useDispatch();
        const [loading, setLoading] = useState(false);
        const [evidenceFile, setEvidenceFile] = useState([]);
        const [sm, updateSm] = useState(false);
        const [modalForm, setModalForm] = useState(false);
        const { register, handleSubmit, formState: { errors }, resetField } = useForm();

        const toggleForm = () => setModalForm(!modalForm);
        const ar_users = useSelector((state) => state?.arUsers?.list) || null;
        const sanctions = useSelector((state) => state?.sanctions?.view_all) || null;

        useEffect(() => {
            dispatch(userLoadUserARs({"approval_status" : "approved", "role_id": ""}));
            dispatch(loadUserSanctions());
        }, [dispatch, counter]);

        const $ar_users = ar_users ? JSON.parse(ar_users) : null;
        const $sanctions = sanctions ? JSON.parse(sanctions) : null;
            
        const handleFormSubmit = async (values) => {
            const formData = new FormData();
            formData.append('ar', values.ar)
            formData.append('ar_summary', values.ar_summary)
            formData.append('sanction_summary', values.sanction_summary)
            formData.append('evidence', evidenceFile)

            try {
                setLoading(true);

                const resp = await dispatch(sendSanction(formData));

                if (resp.payload?.message == "success") {
                    setTimeout(() => {
                        setLoading(false);
                        setModalForm(!modalForm)
                        resetField('ar')
                        resetField('ar_summary')
                        resetField('sanction_summary')
                        resetField('evidence')
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
            setEvidenceFile(event.target.files[0]);
        };


    
    

        return (
            <React.Fragment>
                <Head title="Sanction"></Head>
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
                                                    <span onClick={toggleForm}>Add Sanctions</span>
                                                </Button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </BlockHeadContent>
                        </BlockBetween>
                    </BlockHead>
                    <Modal isOpen={modalForm} toggle={toggleForm} size="lg">
                        <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>} >
                            Fill Disciplinary and Sanction Form
                        </ModalHeader>
                        <ModalBody>
                            <form  onSubmit={handleSubmit(handleFormSubmit)}  className="is-alter" encType="multipart/form-data">
                                <div className="form-group">
                                    <label className="form-label" htmlFor="full-name">
                                        Authorised Representative
                                    </label>
                                    <div className="form-control-wrap">
                                        <div className="form-control-select">
                                            <select className="form-control form-select"  style={{ color: "black !important" }} {...register('ar', { required: "AR is Required" })}>
                                            <option value="">Select Authorised Representative</option>
                                                {$ar_users && $ar_users?.map((ar_user) => {
                                                    if (authUser.id != ar_user.id) {
                                                        return (
                                                            <option key={ar_user.id} value={ar_user.id}>
                                                                {`${ar_user.firstName} ${ar_user.lastName} (${ar_user.email})`}
                                                            </option>
                                                        )
                                                    }
                                                })}
                                            </select>
                                            {errors.ar && <p className="invalid">{`${errors.ar.message}`}</p>}
                                        </div>
                                    </div>
                                </div>
                                
                                <div className="form-group">
                                    <label className="form-label" htmlFor="email">
                                        Summary of AR's Infraction
                                    </label>
                                    <div className="form-control-wrap">
                                        <textarea type="text" className="form-control" {...register('ar_summary', { required: "This field is Required" })}></textarea>
                                        {errors.ar_summary && <p className="invalid">{`${errors.ar_summary.message}`}</p>}
                                    </div>
                                </div>
                                <div className="form-group">
                                    <label className="form-label" htmlFor="email">
                                       Summary of Sanction
                                    </label>
                                    <div className="form-control-wrap">
                                        <textarea type="text" className="form-control" {...register('sanction_summary', { required: "This field is Required" })}></textarea>
                                        {errors.sanction_summary && <p className="invalid">{`${errors.sanction_summary.message}`}</p>}
                                    </div>
                                </div>
                                <div className="form-group">
                                    <label className="form-label" htmlFor="phone-no">
                                        Infraction and Sanction evidence (*pdf)
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
                            <span className="sub-text">Disciplinary And Sanction</span>
                        </ModalFooter>
                    </Modal>
                    <Block size="lg">
                        <Card className="card-bordered card-preview">
                            <Content>


                                <Block size="xl">
                                    <BlockHead>
                                        <BlockHeadContent>
                                            <BlockTitle tag="h4">Disciplinary and Sanction</BlockTitle>
                                            {/* <p>{sanctions}</p> */}
                                        </BlockHeadContent>
                                    </BlockHead>

                                    <PreviewCard>
                                        {$sanctions && <SanctionTable data={$sanctions} expandableRows pagination actions />}
                                    </PreviewCard>
                                </Block>


                            </Content>
                        </Card>
                    </Block>
                </Content>
            </React.Fragment>
        );
    } else {

        return (
            <React.Fragment>
                <Head title="Sanction"></Head>
                <Content>
                    <BlockHead size="sm">
                        <BlockBetween>
                            <BlockHeadContent>
                                <BlockTitle page tag="h3">
                                    You are not authorised to access this module
                                </BlockTitle>
                            </BlockHeadContent>
                        </BlockBetween>
                    </BlockHead>
                </Content>
            </React.Fragment>);
    }

};
export default Sanction;
