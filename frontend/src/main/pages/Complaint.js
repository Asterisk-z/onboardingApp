import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllComplaintTypes } from "redux/stores/complaints/complaintTypes";
import { sendComplaint, loadAllComplaints } from "redux/stores/complaints/complaint";

import { DataTableData, dataTableColumns, dataTableColumns2, userData, orderData } from "components/table/TableData";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import ComplaintTableUser from './ComplaintTableUser'



const Complaint = ({ drawer }) => {
        
    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [complainFile, setComplainFile] = useState([]);
    const [sm, updateSm] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const { register, handleSubmit, formState: { errors }, resetField } = useForm();
    const complaintType = useSelector((state) => state?.complaintType?.list) || null;

    const toggleForm = () => setModalForm(!modalForm);

    useEffect(() => {
        dispatch(loadAllComplaintTypes());
    }, [dispatch]);

    const $complaintType = complaintType ? JSON.parse(complaintType) : null;
        
    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('complaint_type', values.complaint_type)
        formData.append('body', values.body)
        formData.append('document', complainFile)
        
        try {
            setLoading(true);
            
            const resp = await dispatch(sendComplaint(formData));

            if (resp.payload?.message == "success") {
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

const ComplainTable = () => {
    
    const dispatch = useDispatch();
    const complaints = useSelector((state) => state?.complaint?.list) || null;
    useEffect(() => {
        dispatch(loadAllComplaints());
    }, [counter, dispatch]);
  
    
    const $complaints = complaints ? JSON.parse(complaints) : null;
  
    return (
        <React.Fragment>
            <Content>


                <Block size="xl">
                    <BlockHead>
                        <BlockHeadContent>
                            <BlockTitle tag="h4">Complaint History</BlockTitle>
                            {/* <p>{complaints}</p> */}
                        </BlockHeadContent>
                    </BlockHead>

                    <PreviewCard>
                        {$complaints && <ComplaintTableUser data={$complaints} expandableRows pagination actions />}
                    </PreviewCard>
                </Block>


            </Content>
        </React.Fragment>
    );
}


    return (
        <React.Fragment>
            <Head title="Complaint"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Complaints
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" style={{ display: sm ? "block" : "none" }}>
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={toggleForm}>Add Complaint</span>
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
                        Fill Complain Form
                    </ModalHeader>
                    <ModalBody>
                        <form  onSubmit={handleSubmit(handleFormSubmit)}  className="is-alter" encType="multipart/form-data">
                            <div className="form-group">
                                <label className="form-label" htmlFor="full-name">
                                    Complaint Type
                                </label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select" {...register('complaint_type', { required: "Type is Required" })}>
                                        <option value="">Select Type</option>
                                        {$complaintType && $complaintType?.map((complaintType) => (
                                            <option key={complaintType.id} value={complaintType.id}>
                                            {complaintType.name}
                                            </option>
                                        ))}
                                        </select>
                                        {errors.complaint_type && <p className="invalid">{`${errors.complaint_type.message}`}</p>}
                                    </div>
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="email">
                                    Complain
                                </label>
                                <div className="form-control-wrap">
                                    <textarea type="text" className="form-control" {...register('body', { required: "Body is Required" })}></textarea>
                                     {errors.body && <p className="invalid">{`${errors.body.message}`}</p>}
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="phone-no">
                                    Upload Document (*jpg, png)
                                </label>
                                <div className="form-control-wrap">
                                    <input type="file" accept="image/*" className="form-control"  {...register('document', { })} onChange={handleFileChange}/>
                                     {errors.document && <p className="invalid">{`${errors.document.message}`}</p>}
                                </div>
                            </div>
                            <div className="form-group">
                                <Button color="primary" type="submit"  size="lg">
                                    {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : "File Complain"}
                                </Button>
                            </div>
                        </form>
                    </ModalBody>
                    <ModalFooter className="bg-light">
                        <span className="sub-text">Complaint</span>
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <ComplainTable />
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default Complaint;
