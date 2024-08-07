import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import DataTable from "react-data-table-component";
import exportFromJSON from "export-from-json";
import { useForm } from "react-hook-form";
import CopyToClipboard from "react-copy-to-clipboard";
import { Col, Modal, ModalBody, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, Spinner, Badge, ModalHeader, ModalFooter } from "reactstrap";
import { DataTablePagination } from "components/Component";
import moment from "moment";
import Icon from "components/icon/Icon";
import { arUpdateNotificationOfChangeStatus, arSendCommentNotificationOfChange } from "redux/stores/notificationOfChange/changeStore";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import Swal from "sweetalert2";


const Export = ({ data }) => {
  const [modal, setModal] = useState(false);

  useEffect(() => {
    if (modal === true) {
      setTimeout(() => setModal(false), 2000);
    }
  }, [modal]);

  const newData = data.map((item, index) => {
    return ({
      "SN": ++index,
      "Description": `${item.body}`,
      "Status": item.status,
      "Comments": item.comment.length,
      "Date Created": moment(item.createdAt).format('MMM. D, YYYY HH:mm')
    })
  });

  const fileName = "data";

  const exportCSV = () => {
    const exportType = exportFromJSON.types.csv;
    exportFromJSON({ data: newData, fileName: fileName, exportType: exportType });

  };

  const exportExcel = () => {
    const exportType = exportFromJSON.types.xls;
    exportFromJSON({ data: newData, fileName: fileName, exportType: exportType });

  };

  const copyToClipboard = () => {
    setModal(true);
  };

  return (
    <React.Fragment>
      <div className="dt-export-buttons d-flex align-center">
        <div className="dt-export-title d-none d-md-inline-block">Export</div>
        <div className="dt-buttons btn-group flex-wrap">
          <CopyToClipboard text={JSON.stringify(newData)}>
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
          <div className="text-center">Copied {newData.length} rows to clipboard</div>
        </div>
      </Modal>
    </React.Fragment>
  );
};


const CustomCheckbox = React.forwardRef(({ onClick, ...rest }, ref) => (
  <div className="custom-control custom-control-sm custom-checkbox notext">
    <input
      id={rest.name}
      type="checkbox"
      className="custom-control-input"
      ref={ref}
      onClick={onClick}
      {...rest}
    />
    <label className="custom-control-label" htmlFor={rest.name} />
  </div>
));



const CommentSection = ({ updateParentParent, complaint, toggleCommentForm }) => {
  const authUser = useUser();
  const authUserUpdate = useUserUpdate();
  const complaint_id = complaint.id

  const [modalForm, setModalForm] = useState(false);
  const [modalDetail, setModalDetail] = useState(false);

  const toggleForm = () => setModalForm(!modalForm);
  const toggleModalDetail = () => { setModalDetail(!modalForm) };

  const dispatch = useDispatch();
  const { register, handleSubmit, formState: { errors }, resetField, setValue, getValues } = useForm();
  const [loading, setLoading] = useState(false);

  const sendComment = async (values) => {

    const formData = new FormData();
    formData.append('notification_id', complaint.id)
    formData.append('comment', values.comment)

    try {
      setLoading(true);

      const resp = await dispatch(arSendCommentNotificationOfChange(formData));

      if (resp.payload?.message == "success") {
        setTimeout(() => {
          setLoading(false);
          toggleCommentForm()
          resetField('comment')
          updateParentParent(Math.random())
        }, 1000);
      } else {
        setLoading(false);
      }

    } catch (error) {
      console.log(error)
      setLoading(false);
    }
  };

  const testAct = () => {
    console.log(errors)
  }

  return (
    <>




      <form onSubmit={handleSubmit(sendComment)} className="is-alter" encType="multipart/form-data">


        <div className="form-group">
          <label className="form-label" htmlFor="email">
            Comment
          </label>
          <div className="form-control-wrap">
            <textarea type="text" className="form-control" {...register('comment', { required: "This Field is Required" })}></textarea>
            {errors.comment && <p className="invalid">{`${errors.comment.message}`}</p>}
          </div>
        </div>


        <div className="form-group">
          <Button color="primary" type="submit" size="lg" >
            {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Send Comment"}
          </Button>
        </div>
      </form>




    </>


  );
};

const DropdownTrans = (props) => {

  const authUser = useUser();
  const authUserUpdate = useUserUpdate();
  const dispatch = useDispatch();
  const complaint = props.complaint

  const [loading, setLoading] = useState(false);
  const [modalForm, setModalForm] = useState(false);
  const toggleForm = () => setModalForm(!modalForm);

  const [modalCommentForm, setModalCommentForm] = useState(false);
  const toggleCommentForm = () => setModalCommentForm(!modalCommentForm);


  const [modalReasonForm, setModalReasonForm] = useState(false);
  const toggleReasonForm = () => setModalReasonForm(!modalReasonForm);


  const { register, handleSubmit, formState: { errors }, resetField, getValues } = useForm();



  const updateChangeStatus = async (status, reason = '') => {
    const formData = new FormData();
    formData.append('notification_id', complaint.id)
    formData.append('status', status)
    if (status == 'rejected') formData.append('reason', getValues('reason') ? getValues('reason') : '')


    try {
      setLoading(true);

      const resp = await dispatch(arUpdateNotificationOfChangeStatus(formData));

      if (resp.payload?.message == "success") {
        setTimeout(() => {
          setLoading(false);
          setModalReasonForm(!modalCommentForm)
          resetField('reason')
          // setCounter(!counter)
          window.location.reload(true)
        }, 1000);
      } else {
        setLoading(false);
      }

    } catch (error) {
      console.log(error)
      setLoading(false);
    }
  }

  const askAction = async (action) => {
    if (action == 'approved') {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, approve it!",
      }).then((result) => {
        if (result.isConfirmed) {
          updateChangeStatus('approved');
        }
      });
    }
  }

  return (
    <>
      <Button color="secondary" className="btn" onClick={toggleForm}> <Icon name="eye"></Icon> View</Button>
      <Modal isOpen={modalForm} toggle={toggleForm} size="xl">
        <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
          View
        </ModalHeader>
        <ModalBody className="modal-body-xl">

          <table className="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th scope="col"></th>
                <th scope="col"></th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Subject</td>
                <td className="text-capitalize">{`${complaint.subject}`}</td>
              </tr>
              <tr>
                <td>Summary</td>
                <td className="text-capitalize">{`${complaint.summary}`}</td>
              </tr>
              <tr>
                <td>Requester</td>
                <td className="text-capitalize">{`${complaint.requester?.full_name}`}</td>
              </tr>
              <tr>
                <td>Authoriser</td>
                <td className="text-capitalize">{`${complaint.authorizer?.full_name}`}</td>
              </tr>
              <tr>
                <td>Confidentiality Level</td>
                <td className="text-capitalize">{`${complaint.confidentialityLevel}`}</td>
              </tr>
              <tr>
                <td>Regulatory Approval</td>
                <td>{complaint.regulatoryApproval ? (
                  <a size="lg" href={complaint.regulatoryApproval} target="_blank" className="btn-primary">
                    <Button color="primary">
                      <span >{"View Regulatory Approval"}</span>
                    </Button>
                  </a>
                ) : `Not Uploaded`}</td>
              </tr>
              <tr>
                <td> Other Document</td>
                <td>{complaint.attachment ? (
                  <a size="lg" href={complaint.attachment} target="_blank" className="btn-primary">
                    <Button color="primary">
                      <span >{"View Document"}</span>
                    </Button>
                  </a>
                ) : `Not Uploaded`}</td>
              </tr>

              <tr>
                <td>AR Status</td>
                <td className="text-capitalize">{`${complaint.arStatus}`}</td>
              </tr>
              {complaint.arStatusReason && <>
                <tr>
                  <td>AR Status Reason</td>
                  <td className="text-capitalize">{`${complaint.arStatusReason}`}</td>
                </tr>
              </>}
              <tr>
                <td>Request Status</td>
                <td className="text-capitalize">{`${complaint.status}`}</td>
              </tr>

            </tbody>
          </table>

          <div className="nk-modal">


            {complaint.comment.length > 0 && <><h6 className="title">Comment(s):</h6></>}
            {complaint.comment.length > 0 && complaint.comment?.map((comment, index) => (<p key={index}>{comment.comment}<br />{comment.commenter.first_name} <br />{moment(comment.createdAt).format('MMM. D, YYYY HH:mm')}</p>))}

            <div className="float-end">
              {authUser.is_ar_inputter() && complaint.isArApproved && complaint.comment.length > 1 ? <>
                <Button className="btn  btn-primary float-end m-2" onClick={(e) => setModalCommentForm(true)}>Comment</Button>
              </> : ''}
              {authUser.is_ar_authorizer() && complaint.authorizer?.id == authUser?.user_data?.id && complaint.isArPending ? <>
                <Button className="btn  btn-primary float-end m-2" onClick={(e) => askAction('approved')}>Approve</Button>
                <Button className="btn  btn-warning float-end m-2" onClick={(e) => setModalReasonForm(true)} >Reject</Button>
              </> : ''}

            </div>
          </div>
        </ModalBody>
        <ModalFooter className="bg-light">
          <div className="text-center w-100">
            <p>
              Member Regulation and Oversight Information System (MROIS)
            </p>
          </div>
        </ModalFooter>
      </Modal>


      <Modal isOpen={modalReasonForm} toggle={toggleReasonForm}>
        <ModalHeader toggle={toggleReasonForm} close={
          <button className="close" onClick={toggleReasonForm}>
            <Icon name="cross" />
          </button>
        }
        >
          Send Reason
        </ModalHeader>
        <ModalBody>
          <form onSubmit={(e) => { e.preventDefault(); handleSubmit(updateChangeStatus('rejected')) }} className="is-alter" encType="multipart/form-data">

            <div className="form-group">
              <label className="form-label" htmlFor="email">
                Do you have a reason?
              </label>
              <div className="form-control-wrap">
                <textarea type="text" className="form-control" {...register('reason', { required: "This Field is Required" })}></textarea>
                {errors.reason && <p className="invalid">{`${errors.reason.message}`}</p>}
              </div>
            </div>


            <div className="form-group">
              <Button color="primary" type="submit" size="lg">
                {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Reject"}
              </Button>
            </div>
          </form>
        </ModalBody>
        <ModalFooter className="bg-light">
          <span className="sub-text">Notification Of change</span>
        </ModalFooter>
      </Modal>


      <Modal isOpen={modalCommentForm} toggle={toggleCommentForm}>
        <ModalHeader toggle={toggleCommentForm} close={
          <button className="close" onClick={toggleCommentForm}>
            <Icon name="cross" />
          </button>
        }
        >
          Send Comment
        </ModalHeader>
        <ModalBody>

          <CommentSection toggleCommentForm={toggleCommentForm} updateParentParent={props.updateParentParent} complaint={complaint} />

        </ModalBody>
        <ModalFooter className="bg-light">
          <span className="sub-text">Notification Of change</span>
        </ModalFooter>
      </Modal>

    </>
  );
};


const ComplaintTableUser = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent }) => {


  const complainColumn = [
    {
      name: "SN",
      selector: (row, index) => ++index,
      sortable: true,
      width: "80px",
    },
    {
      name: "Subject",
      selector: (row) => row.subject,
      sortable: true,
      width: "auto",
      wrap: true
    },
    // {
    //   name: "Details",
    //   selector: (row) => row.summary,
    //   sortable: true,
    //   width: "auto",
    //   wrap: true
    // },
    {
      name: "Confidentiality",
      selector: (row) => { return (<><Badge color="success" className="text-uppercase">{`${row.confidentialityLevel}`}</Badge></>) },
      sortable: true,
    },
    {
      name: "AR Status",
      selector: (row) => { return (<><Badge color="success" className="text-uppercase">{`${row.arStatus}`}</Badge></>) },
      sortable: true,
    },
    {
      name: "Request Status",
      selector: (row) => { return (<><Badge color="success" className="text-uppercase">{`${row.status}`}</Badge></>) },
      sortable: true,
    },
    {
      name: "Comments",
      selector: (row) => { return (<><Badge color="gray">{`${row.comment.length} Comments`}</Badge></>) },
      sortable: true,
    },
    {
      name: "Date Created",
      selector: (row) => moment(row.createdAt).format('MMM. D, YYYY HH:mm'),
      sortable: true,
    },
    {
      name: "Action",
      selector: (row) => (<> <DropdownTrans complaint={row} updateParentParent={updateParent} /></>),
      sortable: true,
    },
  ];

  const [tableData, setTableData] = useState(data);
  const [searchText, setSearchText] = useState("");
  const [rowsPerPageS, setRowsPerPage] = useState(10);
  const [mobileView, setMobileView] = useState();

  useEffect(() => {
    setTableData(data)
  }, [data]);

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

  // const renderer = ({ hours, minutes, seconds, completed }) => {
  //         if (completed) {
  return (
    <div className={`dataTables_wrapper dt-bootstrap4 no-footer ${className ? className : ""}`}>
      <Row className={`justify g-2 ${actions ? "with-export" : ""}`}>
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
        selectableRowsComponent={CustomCheckbox}
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
  //         } else {

  //             return (
  //                     <>
  //                         <Skeleton count={10} height={20}  style={{display: 'block',lineHeight: 2, padding: '1rem',width: 'auto',}}/>
  //                     </>

  //                 )
  //         }
  // };

  //       return (
  //               <Countdown
  //                 date={Date.now() + 5000}
  //                 renderer={renderer}
  //             />


  //         );
};

export default ComplaintTableUser;
