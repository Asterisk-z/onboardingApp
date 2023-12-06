import React, { useEffect, useState } from "react";
import Head from "../layout/head/Head";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import Content from "../layout/content/Content";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Nav, NavLink, NavItem, TabContent, TabPane, Card, Spinner} from "reactstrap";
import { Block, OrderTable, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect } from "components/Component";
import { loadAllComplaintTypes } from "../../redux/stores/complaints/complaintTypes";
import { sendComplaint } from "../../redux/stores/complaints/complaint";

import { orderData } from "components/table/TableData";
import { UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge } from "reactstrap";
// import Icon from "../icon/Icon";
// import Button from "../button/Button";

const ComplainTable = () => {
  const DropdownTrans = () => {
    return (
      <UncontrolledDropdown>
        <DropdownToggle tag="a" className="text-soft dropdown-toggle btn btn-icon btn-trigger">
          <Icon name="more-h"></Icon>
        </DropdownToggle>
        <DropdownMenu end>
          <ul className="link-list-plain">
            <li>
              <DropdownItem
                tag="a"
                href="#dropdownitem"
                onClick={(ev) => {
                  ev.preventDefault();
                }}
              >
                View
              </DropdownItem>
            </li>
            <li>
              <DropdownItem
                tag="a"
                href="#dropdownitem"
                onClick={(ev) => {
                  ev.preventDefault();
                }}
              >
                Invoice
              </DropdownItem>
            </li>
            <li>
              <DropdownItem
                tag="a"
                href="#dropdownitem"
                onClick={(ev) => {
                  ev.preventDefault();
                }}
              >
                Print
              </DropdownItem>
            </li>
          </ul>
        </DropdownMenu>
      </UncontrolledDropdown>
    );
  };
  return (
    <table className="table table-orders">
      <thead className="tb-odr-head">
        <tr className="tb-odr-item">
          <th className="tb-odr-info">
            <span className="tb-odr-id">Ticket ID</span>
            <span className="tb-odr-date d-none d-md-inline-block">Date Create</span>
          </th>
          <th className="tb-odr-amount">
            <span className="tb-odr-total">Description</span>
            <span className="tb-odr-status d-none d-md-inline-block">Status</span>
          </th>
          <th className="tb-odr-action">&nbsp;</th>
        </tr>
      </thead>
      <tbody className="tb-odr-body">
        {orderData.map((item) => {
          return (
            <tr className="tb-odr-item" key={item.id}>
              <td className="tb-odr-info">
                <span className="tb-odr-id">
                  <a
                    href="#id"
                    onClick={(ev) => {
                      ev.preventDefault();
                    }}
                  >
                    {item.id}
                  </a>
                </span>
                <span className="tb-odr-date">{item.date}</span>
              </td>
              <td className="tb-odr-amount">
                <span className="tb-odr-total">
                  <span className="amount">${item.amount}</span>
                </span>
                <span className="tb-odr-status">
                  <Badge
                    className="badge-dot"
                    color={
                      item.status === "Complete" ? "success" : item.status === "Pending" ? "warning" : "danger"
                    }
                  >
                    {item.status}
                  </Badge>
                </span>
              </td>
              <td className="tb-odr-action">
                <div className="tb-odr-btns d-none d-md-inline">
                  <Button color="primary" className="btn-sm">
                    View
                  </Button>
                </div>
                <DropdownTrans />
              </td>
            </tr>
          );
        })}
      </tbody>
    </table>
  );
};

const Complaint = ({ drawer }) => {
        
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const [complainFile, setComplainFile] = useState([]);
    const [sm, updateSm] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const { register, handleSubmit, formState: { errors } } = useForm();
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
        console.log(complainFile)
        try {
            setLoading(true);
            
            const resp = await dispatch(sendComplaint(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                  navigate(`${process.env.PUBLIC_URL}/complaint`);
                  setLoading(false);
                  setModalForm(!modalForm)
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
                                    Upload Document
                                </label>
                                <div className="form-control-wrap">
                                    <input type="file" className="form-control"  {...register('document', { })} onChange={handleFileChange}/>
                                     {errors.document && <p className="invalid">{`${errors.document.message}`}</p>}
                                </div>
                            </div>
                            <div className="form-group">
                                <Button color="primary" type="submit"  size="lg">
                                    
                                    {loading ? <Spinner size="sm" color="light" /> : "File Complain"}
                                </Button>
                            </div>
                        </form>
                    </ModalBody>
                    <ModalFooter className="bg-light">
                        <span className="sub-text">Complaint</span>
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <BlockHead>
                        <BlockHeadContent>
                            <BlockTitle tag="h4">Complains History</BlockTitle>
                        </BlockHeadContent>
                    </BlockHead>
                    <Card className="card-bordered card-preview">
                        <ComplainTable />
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default Complaint;
