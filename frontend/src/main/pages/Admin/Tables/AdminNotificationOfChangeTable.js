import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { useForm } from "react-hook-form";
import { useDispatch } from "react-redux";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, Input, Badge, Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { DataTablePagination, RSelect } from "components/Component";
import { sendComplaintFeedback, updateComplaintStatus } from "redux/stores/complaints/complaint";
import { megUpdateNotificationOfChangeStatus, megSendCommentNotificationOfChange } from "redux/stores/notificationOfChange/changeStore";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import moment from "moment";
import Icon from "components/icon/Icon";
import Swal from "sweetalert2";
import { getValue } from "@testing-library/user-event/dist/utils";

const Export = ({ data }) => {
    const [modal, setModal] = useState(false);

    useEffect(() => {
        if (modal === true) {
            setTimeout(() => setModal(false), 2000);
        }
    }, [modal]);

    const newData = data.map((item, index) => {
        return ({
            "TID ID": ++index,
            "Description": `${item.body}`,
            "Status": item.status,
            "Comment(s)": item.comment.length,
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


const ApproveSection = ({ updateParentParent, complaint, stakeholders, toggleApproveForm }) => {
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

    const toggleModalDetailTwo = () => {
        setModalDetail(false)
    }


    const updateStakeHolder = (value) => {
        setValue('stakeholders', value)

        // const category = getValues('stakeholders').map((val) => (val.value))

    };

    const [file, setFile] = useState([]);

    const handleFile = (event) => {
        setFile(event.target.files[0]);
    };

    const sendApprove = async (values) => {

        const formData = new Object();
        formData.notification_id = complaint.id
        formData.document = values.document[0]
        formData.list_of_stakeholders = values.stakeholders?.map((item) => item.value)
        formData.summary = values.summary
        formData.subject = values.subject
        formData.status = 'approved'

        try {
            setLoading(true);

            const resp = await dispatch(megUpdateNotificationOfChangeStatus(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    toggleApproveForm()
                    resetField('document')
                    resetField('list_of_stakeholders')
                    resetField('summary')
                    resetField('subject')
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




            <form onSubmit={handleSubmit(sendApprove)} className="is-alter" encType="multipart/form-data">

                <div className="form-group">
                    <label className="form-label" htmlFor="email">
                        Subject
                    </label>
                    <div className="form-control-wrap">
                        <input type="text" className="form-control" {...register('subject', { required: "This Field is Required" })} />
                        {errors.subject && <p className="invalid">{`${errors.subject.message}`}</p>}
                    </div>
                </div>

                <div className="form-group">

                    <label className="form-label" htmlFor="position">
                        Stake Holder
                    </label>
                    <div className="form-control-wrap">
                        <div className="form-control-select">
                            <input type="hidden" {...register('stakeholders', { required: "This Field is Required" })} />
                            <RSelect name="stakeholders" isMulti options={stakeholders} onChange={(value) => updateStakeHolder(value)} />
                            {errors.stakeholders && <p className="invalid">{`${errors.stakeholders.message}`}</p>}
                        </div>
                    </div>
                </div>

                <div className="form-group">
                    <label className="form-label" htmlFor="email">
                        Summary
                    </label>
                    <div className="form-control-wrap">
                        <textarea type="text" className="form-control" {...register('summary', { required: "This Field is Required" })}></textarea>
                        {errors.summary && <p className="invalid">{`${errors.summary.message}`}</p>}
                    </div>
                </div>

                <div className="form-group">
                    <label className="form-label" htmlFor="phone-no">
                        Document
                    </label>
                    <div className="form-control-wrap">
                        <input type="file" accept=".pdf" className="form-control"  {...register('document', { required: "File is Required" })} onChange={handleFile} />
                        {errors.document && <p className="invalid">{`${errors.document.message}`}</p>}
                    </div>
                </div>


                <div className="form-group">
                    <Button color="primary" type="submit" size="lg" onClick={testAct}>
                        {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Send summary"}
                    </Button>
                </div>
            </form>




        </>


    );
};


const RejectSection = ({ updateParentParent, complaint, stakeholders, toggleRejectForm }) => {
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

    const sendReject = async (values) => {
        console.log(values)
        const formData = new FormData();
        formData.append('notification_id', complaint.id)
        formData.append('reason', values.reason)
        formData.append('status', 'rejected')

        try {
            setLoading(true);

            const resp = await dispatch(megUpdateNotificationOfChangeStatus(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    toggleRejectForm()
                    resetField('reason')
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




            <form onSubmit={handleSubmit(sendReject)} className="is-alter" encType="multipart/form-data">


                <div className="form-group">
                    <label className="form-label" htmlFor="email">
                        Reason
                    </label>
                    <div className="form-control-wrap">
                        <textarea type="text" className="form-control" {...register('reason', { required: "This Field is Required" })}></textarea>
                        {errors.reason && <p className="invalid">{`${errors.reason.message}`}</p>}
                    </div>
                </div>


                <div className="form-group">
                    <Button color="primary" type="submit" size="lg" >
                        {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Reject"}
                    </Button>
                </div>
            </form>




        </>


    );
};


const SendFeedback = ({ updateParentParent, complaint, stakeholders }) => {
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



    const [modalCommentForm, setModalCommentForm] = useState(false);
    const toggleCommentForm = () => setModalCommentForm(!modalCommentForm);
    const [modalApproveForm, setModalApproveForm] = useState(false);
    const toggleApproveForm = () => setModalApproveForm(!modalApproveForm);
    const [modalRejectForm, setModalRejectForm] = useState(false);
    const toggleRejectForm = () => setModalRejectForm(!modalRejectForm);


    const sendComment = async (values) => {
        const formData = new FormData();
        formData.append('notification_id', complaint.id)
        formData.append('comment', values.comment)
        try {
            setLoading(true);

            const resp = await dispatch(megSendCommentNotificationOfChange(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalCommentForm(!modalCommentForm)
                    resetField('comment')
                    updateParentParent(Math.random())
                }, 1000);
            } else {
                setLoading(false);
            }

        } catch (error) {
            setLoading(false);
        }

    };


    return (
        <>

            <Button color="secondary" className="btn" onClick={toggleForm}> Details</Button>
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
                                <td>Summery</td>
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
                                <td>Status</td>
                                <td className="text-capitalize">{`${complaint.status}`}</td>
                            </tr>

                        </tbody>
                    </table>

                    <div className="nk-modal">

                        {complaint.comment.length > 0 && <><h6 className="title">Comment(s):</h6></>}
                        {complaint.comment.length > 0 && complaint.comment?.map((comment, index) => (<p key={index}>{comment.comment}<br /><small>{comment.commenter.first_name}</small> <br /><small>{moment(comment.createdAt).format('MMM. D, YYYY HH:mm')}</small> </p>))}

                        <div className="float-end">
                            {authUser.is_admin_meg() && complaint.isArApproved && complaint.isMEGPending ? <>
                                <Button className="btn  btn-primary float-end m-2" onClick={(e) => setModalCommentForm(true)}>Comment</Button>
                            </> : ''}

                        </div>

                        <div className="float-start">

                            {authUser.is_admin_meg() && complaint.isArApproved && complaint.isMEGPending ? <>
                                <Button className="btn  btn-primary float-end m-2" onClick={(e) => setModalApproveForm(true)}>Approve</Button>
                                <Button className="btn  btn-warning float-end m-2" onClick={(e) => setModalRejectForm(true)}>Reject</Button>
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

            <Modal isOpen={modalApproveForm} toggle={toggleApproveForm}>
                <ModalHeader toggle={toggleApproveForm} close={
                    <button className="close" onClick={toggleApproveForm}>
                        <Icon name="cross" />
                    </button>
                }
                >
                    Approve Request
                </ModalHeader>
                <ModalBody>
                    <ApproveSection stakeholders={stakeholders} toggleApproveForm={toggleApproveForm} updateParentParent={updateParentParent} complaint={complaint} />
                </ModalBody>
                <ModalFooter className="bg-light">
                    <span className="sub-text">Notification Of change</span>
                </ModalFooter>
            </Modal>



            <Modal isOpen={modalRejectForm} toggle={toggleRejectForm}>
                <ModalHeader toggle={toggleRejectForm} close={
                    <button className="close" onClick={toggleRejectForm}>
                        <Icon name="cross" />
                    </button>
                }
                >
                    Reject Request
                </ModalHeader>
                <ModalBody>

                    <RejectSection stakeholders={stakeholders} toggleRejectForm={toggleRejectForm} updateParentParent={updateParentParent} complaint={complaint} />

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
                            <Button color="primary" type="submit" size="lg">
                                {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Send Comment"}
                            </Button>
                        </div>
                    </form>
                </ModalBody>
                <ModalFooter className="bg-light">
                    <span className="sub-text">Notification Of change</span>
                </ModalFooter>
            </Modal>

        </>


    );
};

const ComplaintTableUser = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState, stakeholders }) => {
    const complainColumn = [
        {
            name: "ID",
            selector: (row, index) => ++index,
            sortable: true,
            width: "100px",
            wrap: true
        },
        {
            name: "Subject",
            selector: (row) => row.subject,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "AR No.",
            selector: (row) => row.requester?.reg_id,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Request ID",
            selector: (row) => row.requestId,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Member Name",
            selector: (row) => row.requester?.full_name,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Status",
            selector: (row) => { return (<><Badge color="success" className="text-uppercase">{`${row.status}`}</Badge></>) },
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Comment(s)",
            selector: (row) => { return (<><Badge color="gray">{`${row.comment.length} Comment(s)`}</Badge></>) },
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Date Created",
            selector: (row) => moment(row.createdAt).format('MMM. D, YYYY HH:mm'),
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Action",
            selector: (row) => (<>
                <SendFeedback complaint={row} updateParentParent={updateParent} stakeholders={stakeholders} />
            </>),
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
