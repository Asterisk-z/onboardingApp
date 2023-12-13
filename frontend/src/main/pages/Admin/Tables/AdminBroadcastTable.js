import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { useForm } from "react-hook-form";
import { useDispatch } from "react-redux";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge,  Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { DataTablePagination } from "components/Component";
import { sendComplaintFeedback, updateComplaintStatus } from "redux/stores/complaints/complaint";
import moment from "moment";
import Icon from "components/icon/Icon";
import { AiOutlineArrowRight } from "react-icons/ai";

const Export = ({ data }) => {
  const [modal, setModal] = useState(false);

  useEffect(() => {
    if (modal === true) {
      setTimeout(() => setModal(false), 2000);
    }
  }, [modal]);

  const fileName = "user-data";

  const exportCSV = () => {
    const exportType = exportFromJSON.types.csv;
    exportFromJSON({ data, fileName, exportType });
  };

  const exportExcel = () => {
    const exportType = exportFromJSON.types.xls;
    exportFromJSON({ data, fileName, exportType });
  };

  const copyToClipboard = () => {
    setModal(true);
  };

  return (
    <React.Fragment>
      <div className="dt-export-buttons d-flex align-center">
        <div className="dt-export-title d-none d-md-inline-block">Export</div>
        <div className="dt-buttons btn-group flex-wrap">
          <CopyToClipboard text={JSON.stringify(data)}>
            <Button className="buttons-copy buttons-html5" onClick={() => copyToClipboard()}>
              <span>Copy</span>
            </Button>
          </CopyToClipboard>{" "}
          <button className="btn btn-secondary buttons-csv buttons-html5" type="button" onClick={() => exportCSV()}>
            <span>CSV</span>
          </button>{" "}
          <button className="btn btn-secondary buttons-excel buttons-html5" type="button" onClick={() => exportExcel()}>
            <span>Excel</span>
          </button>{" "}
        </div>
      </div>
      <Modal isOpen={modal} className="modal-dialog-centered text-center" size="sm">
        <ModalBody className="text-center m-2">
          <h5>Copied to clipboard</h5>
        </ModalBody>
        <div className="p-3 bg-light">
          <div className="text-center">Copied {data.length} rows to clipboard</div>
        </div>
      </Modal>
    </React.Fragment>
  );
};


const SendFeedback = (props) => {
    const complaint_id = props.complaint.id
    const complaint = props.complaint
  
    const [modalForm, setModalForm] = useState(false);
    const [modalDetail, setModalDetail] = useState(false);
    const [modalOpenAsk, setModalOpenAsk] = useState(false);
    const [modalCloseAsk, setModalCloseAsk] = useState(false);

    const toggleForm = () => setModalForm(!modalForm);
    const toggleModalDetail = () => { setModalDetail(!modalForm) };
    const toggleModalOpenAsk = () => setModalOpenAsk(!modalOpenAsk);
    const toggleModalCloseAsk = () => setModalCloseAsk(!modalCloseAsk);
    const dispatch = useDispatch();
    const { register, handleSubmit, formState: { errors }, resetField } = useForm();
    const [loading, setLoading] = useState(false);
    
    const handleFormSubmit = async (values) => {

        const formData = new FormData();
        formData.append('complaint_id', complaint_id)
        formData.append('comment', values.comment)
        formData.append('status', values.status)
        
        try {
            setLoading(true);
            
            const resp = await dispatch(sendComplaintFeedback(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('comment')
                    resetField('status')
                    props.updateParentParent(Math.random())
                }, 1000);
            
            } else {
              setLoading(false);
            }
            
      } catch (error) {
        setLoading(false);
      }
    }; 

    const toggleComplainStatus = async () => {

        const complaint_id = props.complaint.id
        const updateStatus = (props.complaint.status != 'NEW') ? 'ONGOING' : 'CLOSED';
        const formData = new FormData();

        formData.append('complaint_id', complaint_id)
        formData.append('status', updateStatus)

        try {
            setLoading(true);
            
            const resp = await dispatch(updateComplaintStatus(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalOpenAsk(false)
                    setModalCloseAsk(false)
                    props.updateParentParent(Math.random())
                }, 1000);
            
            } else {
              setLoading(false);
            }
            
      } catch (error) {
        setLoading(false);
      }
    }

    const toggleModalDetailTwo = () => {
        setModalDetail(false)
    }
  
  return (
    <>
        <div className="toggle-expand-content" style={{ display: "block" }}>
            <ul className="nk-block-tools g-3">
                <li className="nk-block-tools-opt">
                    <Button color="primary" size="xs" onClick={toggleModalDetail}>
                        <span>View</span>
                    </Button>
                </li>
                <li className="nk-block-tools-opt">
                    <Button color="primary" size="xs" onClick={toggleForm}>
                        <span>Add feedback</span>
                    </Button>
                </li>
                    {(complaint.status == 'NEW' || complaint.status == 'CLOSED') &&
                        <li className="nk-block-tools-opt" >
                            <Button color="primary" size="xs"  onClick={toggleModalOpenAsk}>
                                <span>Open Ticket</span>
                            </Button>
                        </li>
                    }
                    {complaint.status == 'ONGOING' &&
                        <li className="nk-block-tools-opt" >
                            <Button color="primary" size="xs"  onClick={toggleModalCloseAsk}>
                                <span>Closed Ticket</span>
                            </Button>
                        </li>
                    }

            </ul>
        </div>
        <Modal isOpen={modalOpenAsk} toggle={toggleModalOpenAsk}>
            
            <ModalBody className="modal-body-lg text-center">
                <div className="nk-modal">
                <Icon className="nk-modal-icon icon-circle icon-circle-xxl ni ni-check bg-success"></Icon>
                <h4 className="nk-modal-title">Do you want to open this complain!</h4>
                <div className="nk-modal-action">
                    <Button color="primary" size="lg" className="btn-mw" onClick={toggleComplainStatus}>
                        {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : (<span>Proceed <AiOutlineArrowRight /></span>) }
                    </Button>
                </div>
                </div>
            </ModalBody>
            <ModalFooter className="bg-light">
                <div className="text-center w-100">
                    <p>
                        Members Registration Oversight Information System (MROIS)
                    </p>
                </div>
            </ModalFooter>
        </Modal>
        <Modal isOpen={modalCloseAsk} toggle={toggleModalCloseAsk}>
            <ModalBody className="modal-body-lg text-center">
                <div className="nk-modal">
                    <Icon className="nk-modal-icon icon-circle icon-circle-xxl ni ni-check bg-success"></Icon>
                <h4 className="nk-modal-title">Do you want to close this complain!</h4>
                <div className="nk-modal-text">

                </div>
                <div className="nk-modal-action">
                    <Button color="primary" size="lg" className="btn-mw" onClick={toggleComplainStatus}>
                        {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : (<span>Proceed <AiOutlineArrowRight /></span>) }
                    </Button>
                </div>
                </div>
            </ModalBody>
            <ModalFooter className="bg-light">
                <div className="text-center w-100">
                    <p>
                        Members Registration Oversight Information System (MROIS)
                    </p>
                </div>
            </ModalFooter>
        </Modal>
        <Modal isOpen={modalForm} toggle={toggleForm}>
            <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
                Fill Feedback Form
            </ModalHeader>
            <ModalBody>
                <form  onSubmit={handleSubmit(handleFormSubmit)}  className="is-alter" encType="multipart/form-data">
                    <div className="form-group">
                        <label className="form-label" htmlFor="full-name">
                            Complaint Type
                        </label>
                        <div className="form-control-wrap">
                            <div className="form-control-select">
                                <select className="form-control form-select" {...register('status', { required: "Type is Required" })}>
                                    <option value="">Select Type</option>
                                    <option value="ONGOING">Ongoing</option>
                                    <option value="CLOSED">Closed</option>
                                </select>
                                {errors.status && <p className="invalid">{`${errors.status.message}`}</p>}
                            </div>
                        </div>
                    </div>
                    <div className="form-group">
                        <label className="form-label" htmlFor="email">
                            Comment
                        </label>
                        <div className="form-control-wrap">
                            <textarea type="text" className="form-control" {...register('comment', { required: "comment is Required" })}></textarea>
                                {errors.comment && <p className="invalid">{`${errors.comment.message}`}</p>}
                        </div>
                    </div>
                    <div className="form-group">
                        <Button color="primary" type="submit"  size="lg">
                            {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : "Send Feedback"}
                        </Button>
                    </div>
                </form>
            </ModalBody>
            <ModalFooter className="bg-light">
                <span className="sub-text">Feedback</span>
            </ModalFooter>
        </Modal> 
        <Modal isOpen={modalDetail} toggle={toggleModalDetail}>
            <ModalHeader toggle={toggleModalDetailTwo} close={<button className="close" onClick={toggleModalDetailTwo}> <Icon name="cross" /></button> } >
                    View
            </ModalHeader>
            <ModalBody className="modal-body-xl">
                <div className="nk-modal">
                    <h6 className="title">User: {complaint.user_id}</h6>
                    <h6 className="title">Complaint Type: {complaint.complaint_type_id}</h6>
                    <p>
                        {complaint.body}
                    </p>
                    <p>
                        {complaint.documment}
                    </p>
                    <h6 className="title">Comments:</h6>
                      {complaint.comment.length > 1 && complaint.comment?.map((comment, index) => (
                          <p key={index}>{comment.comment}<br/>{ moment(comment.createdAt).format('MMM. DD, YYYY HH:mm') }</p>))}
                </div>
            </ModalBody>
            <ModalFooter className="bg-light">
                <div className="text-center w-100">
                    <p>
                        Members Registration Oversight Information System (MROIS)
                    </p>
                </div>
            </ModalFooter>
        </Modal>
    </>


  );
};

const AdminBroadcastTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState }) => {
    const complainColumn = [
      {
          name: "BID",
          selector: (row) => row.id,
          sortable: true,
          width: "100px",
          wrap: true
      },
      {
          name: "Title",
          selector: (row) => row.title,
          sortable: true,
          width: "auto",
          wrap: true
      },
      {
          name: "Content",
          selector: (row) => { return (<>{`${row.content}`}</>) },
          sortable: true,
          width: "auto",
          wrap: true
      },
      {
          name: "Category",
          selector: (row) => { return (<>{`${row.category}`}</>) },
          sortable: true,
          width: "auto",
          wrap: true
      },
      {
          name: "Position",
          selector: (row) => { return (<>{`${row.position}`}</>) },
          sortable: true,
          width: "auto",
          wrap: true
      },
      {
          name: "Date Created",
          selector: (row) => moment(row.createdAt).format('MMM. DD, YYYY HH:mm'),
          sortable: true,
          width: "auto",
          wrap: true
      },
    ];
  const [tableData, setTableData] = useState(data);
  const [searchText, setSearchText] = useState("");
  const [rowsPerPageS, setRowsPerPage] = useState(10);
  const [mobileView, setMobileView] = useState();

  useEffect(() => {
    let defaultData = tableData;
    if (searchText !== "") {
      defaultData = data.filter((item) => {
        // return item.name.toLowerCase().includes(searchText.toLowerCase());
        return (Object.values(item).join('').toLowerCase()).includes(searchText.toLowerCase())
      });
      setTableData(defaultData);
    } else {
      setTableData(data);
    }
  }, [searchText]); // eslint-disable-line react-hooks/exhaustive-deps

  // function to change the design view under 1200 px
  const viewChange = () => {
    if (window.innerWidth < 960 && expandableRows) {
      setMobileView(true);
    } else {
      setMobileView(false);
    }
  };

  useEffect(() => {
    window.addEventListener("load", viewChange);
    window.addEventListener("resize", viewChange);
    return () => {
      window.removeEventListener("resize", viewChange);
    };
  }, []); // eslint-disable-line react-hooks/exhaustive-deps

  return (
    <div className={`dataTables_wrapper dt-bootstrap4 no-footer ${className ? className : ""}`}>
      <Row className={`justify-between g-2 ${actions ? "with-export" : ""}`}>
        <Col className="col-7 text-start" sm="4">
          <div id="DataTables_Table_0_filter" className="dataTables_filter">
            <label>
              <input
                type="search"
                className="form-control form-control-sm"
                placeholder="Search by name"
                onChange={(ev) => setSearchText(ev.target.value)}
              />
            </label>
          </div>
        </Col>
        <Col className="col-5 text-end" sm="8">
          <div className="datatable-filter">

            <div className="d-flex justify-content-end g-2">
              {actions && <Export data={data} />}
              <div className="dataTables_length" id="DataTables_Table_0_length">
                <label>
                  <span className="d-none d-sm-inline-block">Show</span>
                  <div className="form-control-select">
                    {" "}
                    <select
                      name="DataTables_Table_0_length"
                      className="custom-select custom-select-sm form-control form-control-sm"
                      onChange={(e) => setRowsPerPage(e.target.value)}
                      value={rowsPerPageS}
                    >
                      <option value="10">10</option>
                      <option value="25">25</option>
                      <option value="40">40</option>
                      <option value="50">50</option>
                    </select>{" "}
                  </div>
                </label>
              </div>
            </div>
          </div>
        </Col>
      </Row>
      <DataTable
        data={tableData}
        columns={complainColumn}
        className={className + ' customMroisDatatable'} id='customMroisDatatable'
        selectableRows={selectableRows}
        expandableRows={mobileView}
        noDataComponent={<div className="p-2">There are no records found</div>}
        sortIcon={
          <div>
            <span>&darr;</span>
            <span>&uarr;</span>
          </div>
        }
        pagination={pagination}
        paginationComponent={({ currentPage, rowsPerPage, rowCount, onChangePage, onChangeRowsPerPage }) => (
          <DataTablePagination
            customItemPerPage={rowsPerPageS}
            itemPerPage={rowsPerPage}
            totalItems={rowCount}
            paginate={onChangePage}
            currentPage={currentPage}
            onChangeRowsPerPage={onChangeRowsPerPage}
            setRowsPerPage={setRowsPerPage}
          />
        )}
      ></DataTable>
    </div>
  );
};

export default AdminBroadcastTable;
