import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import { useNavigate } from "react-router-dom";
import { useDispatch, useSelector } from "react-redux";
import { useForm } from "react-hook-form";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import Icon from "components/icon/Icon";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, CardBody, CardTitle } from "reactstrap";
import { DataTablePagination } from "components/Component";
import moment from "moment";
import { uploadConcession, FSDPaymentEvidence, FSDReviewSummary, MBGPaymentEvidence, MBGReview, MEGReview, MEG2Review, MEGUploadAgreement, completeApplication, MEGSendMembershipAgreement, MEG2SendESuccess } from "redux/stores/membership/applicationProcessStore"
import { MEGUpdateMembershipAgreement, MEGUpdateMembershipESuccessLetter } from "redux/stores/membership/applicationProcessStore";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import Swal from "sweetalert2";
import DatePicker from "react-datepicker"
import Editor from 'react-simple-wysiwyg';


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
            "Name": `${item.name}`,
            "Categories": item.category,
            "Total ARs": item.ars,
            "Status": `Pending Registration`,
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
                        <Button className="buttons-copy buttons-html5" title="Copy To Clipboard" onClick={() => copyToClipboard()}>
                            <span>Copy</span>
                        </Button>
                    </CopyToClipboard>{" "}
                    <button className="btn btn-secondary buttons-csv buttons-html5" title="Export To CSV" type="button" onClick={() => exportCSV()}>
                        <span>CSV</span>
                    </button>{" "}
                    <button className="btn btn-secondary buttons-excel buttons-html5" title="Export To Excel" type="button" onClick={() => exportExcel()}>
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


const ActionTab = (props) => {

    const aUser = useUser();
    const aUserUpdate = useUserUpdate();

    const institution = props.institution
    const navigate = useNavigate();
    const [modalForm, setModalForm] = useState(false);
    const [modalView, setModalView] = useState(false);
    const [signedAgreement, setSignedAgreement] = useState(false);
    const [updateMemberAgreement, setUpdateMemberAgreement] = useState(false);
    const [updateMemberESuccessLetter, setUpdateMemberESuccessLetter] = useState(false);
    const [modalReviewView, setModalReviewView] = useState(false);
    const [showConcession, setShowConcession] = useState(false);
    const [modalPaymentView, setModalPaymentView] = useState(false);
    const [modalViewUpdate, setModalViewUpdate] = useState(false);


    const toggleForm = () => setModalForm(!modalForm);
    const toggleReviewView = () => setModalReviewView(!modalReviewView);
    const toggleView = () => setModalView(!modalView);
    const toggleSignedAgreement = () => setSignedAgreement(!signedAgreement);
    const toggleUpdateMemberAgreement = () => setUpdateMemberAgreement(!updateMemberAgreement);
    const toggleUpdateMemberESuccessLetter = () => setUpdateMemberESuccessLetter(!updateMemberESuccessLetter);
    const togglePaymentView = () => {
        setModalPaymentView(!modalPaymentView)
        if (!modalPaymentView) setShowConcession(modalPaymentView)
    };

    const toggleConcession = () => {
        if (!showConcession) {
            Swal.fire({
                title: "Do you want to add concession?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes",
                cancelButtonText: "No Concession",
                allowOutsideClick: false
            }).then((result) => {
                if (result.isConfirmed) {

                    setShowConcession(!showConcession)

                } else {

                    const postValues = new Object();
                    postValues.application_id = institution.internal.application_id;
                    const resp = dispatch(uploadConcession(postValues));
                    props.updateParentParent(Math.random());
                    togglePaymentView()

                }
            });

        }

    }

    const toggleViewUpdate = () => setModalViewUpdate(!modalViewUpdate);

    const dispatch = useDispatch();


    const latest_evidence = useSelector((state) => state?.applicationProcess?.latest_evidence) || null;

    useEffect(() => {

        if (aUser.is_admin_fsd()) {
            dispatch(FSDPaymentEvidence({ 'application_id': institution.internal.application_id }));
        }

        if (aUser.is_admin_mbg()) {
            dispatch(MBGPaymentEvidence({ 'application_id': institution.internal.application_id }));
        }


    }, [dispatch]);


    const $latest_evidence = latest_evidence ? JSON.parse(latest_evidence) : null;

    const askAction = (action) => {
        if (action == 'approvePaymentReview') {
            Swal.fire({
                title: "Kindly Validate Payment",
                text: "Do you want to validate payment!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Confirm!",
                cancelButtonText: "Decline",
                html: '<div class="flex flex-column text-left"><label htmlFor="amount">Amount Received</label><input type="number" id="amount" name="amount" class="form-control" required /><label htmlFor="comments">Comment</label><textarea id="comments" class="form-control" rows="4" cols="50" placeholder="Enter Comment" required></textarea></div>', // Add textarea to the alert
            }).then((result) => {
                if (result.isConfirmed) {
                    const comments = document.getElementById('comments').value; // Get value from the textarea
                    const amount = document.getElementById('amount').value; // Get value from the textarea
                    if (comments && amount) {
                        const formData = new FormData();
                        formData.append('application_id', institution.internal.application_id);
                        formData.append('status', 'approve');
                        formData.append('comment', comments);
                        formData.append('amount_received', amount);
                        dispatch(FSDReviewSummary(formData));
                        setModalForm(false)
                        setModalView(false)
                        setSignedAgreement(false)
                        setModalReviewView(false)
                        setShowConcession(false)
                        setModalPaymentView(false)
                        setModalViewUpdate(false)
                        props.updateParentParent(Math.random());
                    } else {
                        Swal.fire("Comment and Amount is required!");
                    }

                }
            });
        }

        if (action == 'declinePaymentReview') {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to decline payment!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                cancelButtonText: "No",
                html: '<div class="flex flex-column text-left"><label htmlFor="comments">Comment</label><textarea id="comments" class="form-control" rows="4" cols="50" placeholder="Enter Comment" required></textarea></div>', // Add textarea to the alert
            }).then((result) => {
                if (result.isConfirmed) {
                    const comments = document.getElementById('comments').value; // Get value from the textarea
                    if (comments) {
                        const formData = new FormData();
                        formData.append('application_id', institution.internal.application_id);
                        formData.append('status', 'decline');
                        formData.append('comment', comments);
                        dispatch(FSDReviewSummary(formData));
                        setModalForm(false)
                        setModalView(false)
                        setSignedAgreement(false)
                        setModalReviewView(false)
                        setShowConcession(false)
                        setModalPaymentView(false)
                        setModalViewUpdate(false)
                        props.updateParentParent(Math.random());
                    } else {
                        Swal.fire("Comment is required!");
                    }
                }
            });
        }

        if (action == 'approveFSDReview') {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to approve review!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                cancelButtonText: "No",
                html: '<div class="flex flex-column text-left"><label htmlFor="comments">Comment</label><textarea id="comments" class="form-control" rows="4" cols="50" placeholder="Enter Comment" required></textarea></div>', // Add textarea to the alert
            }).then((result) => {
                if (result.isConfirmed) {
                    const comments = document.getElementById('comments').value; // Get value from the textarea
                    if (comments) {
                        const formData = new FormData();
                        formData.append('application_id', institution.internal.application_id);
                        formData.append('status', 'approve');
                        formData.append('comment', comments);
                        dispatch(MBGReview(formData));
                        setModalForm(false)
                        setModalView(false)
                        setSignedAgreement(false)
                        setModalReviewView(false)
                        setShowConcession(false)
                        setModalPaymentView(false)
                        setModalViewUpdate(false)
                        props.updateParentParent(Math.random());
                    } else {
                        Swal.fire("Comment is required!");
                    }
                }
            });
        }

        if (action == 'declineFSDReview') {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to approve review!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                cancelButtonText: "No",
                html: '<div class="flex flex-column text-left"><label htmlFor="comments">Comment</label><textarea id="comments" class="form-control" rows="4" cols="50" placeholder="Enter Comment" required></textarea></div>', // Add textarea to the alert
            }).then((result) => {
                if (result.isConfirmed) {
                    const comments = document.getElementById('comments').value; // Get value from the textarea
                    if (comments) {
                        const formData = new FormData();
                        formData.append('application_id', institution.internal.application_id);
                        formData.append('status', 'decline');
                        formData.append('comment', comments);
                        dispatch(MBGReview(formData));
                        setModalForm(false)
                        setModalView(false)
                        setSignedAgreement(false)
                        setModalReviewView(false)
                        setShowConcession(false)
                        setModalPaymentView(false)
                        setModalViewUpdate(false)
                        props.updateParentParent(Math.random());
                    } else {
                        Swal.fire("Comment is required!");
                    }
                }
            });
        }


        if (action == 'approveApplicationsReview') {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to approve review!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                cancelButtonText: "No",
                html: '<div class="flex flex-column text-left"><label htmlFor="application_report">Application Report</label><input type="file"  accept=".pdf" id="application_report" name="application_report" class="form-control" required /><label htmlFor="comments">Comment</label><textarea id="comments" class="form-control" rows="4" cols="50" placeholder="Enter Comment" required></textarea></div>', // Add textarea to the alert
            }).then((result) => {
                if (result.isConfirmed) {
                    const application_report = document.getElementById('application_report').files[0]; // Get value from the textarea
                    const comments = document.getElementById('comments').value; // Get value from the textarea

                    if (comments && application_report) {
                        const formData = new FormData();
                        formData.append('application_id', institution.internal.application_id);
                        formData.append('status', 'approve');
                        formData.append('comment', comments);
                        formData.append('application_report', application_report);
                        dispatch(MEGReview(formData));
                        setModalForm(false)
                        setModalView(false)
                        setSignedAgreement(false)
                        setModalReviewView(false)
                        setShowConcession(false)
                        setModalPaymentView(false)
                        setModalViewUpdate(false)
                        props.updateParentParent(Math.random());
                    } else {
                        Swal.fire("Comment and Report is required!");
                    }
                }
            });
        }

        if (action == 'declineApplicationReview') {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to approve review!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                cancelButtonText: "No",
                html: '<div class="flex flex-column text-left"><label htmlFor="comments">Comment</label><textarea id="comments" class="form-control" rows="4" cols="50" placeholder="Enter Comment" required></textarea></div>', // Add textarea to the alert
            }).then((result) => {
                if (result.isConfirmed) {
                    const comments = document.getElementById('comments').value; // Get value from the textarea
                    if (comments) {
                        const formData = new FormData();
                        formData.append('application_id', institution.internal.application_id);
                        formData.append('status', 'decline');
                        formData.append('comment', comments);
                        dispatch(MEGReview(formData));
                        setModalForm(false)
                        setModalView(false)
                        setSignedAgreement(false)
                        setModalReviewView(false)
                        setShowConcession(false)
                        setModalPaymentView(false)
                        setModalViewUpdate(false)
                        props.updateParentParent(Math.random());
                    } else {
                        Swal.fire("Comment is required!");
                    }
                }
            });
        }


        if (action == 'approveMEGApplicationsReview') {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to approve review!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Approve",
                cancelButtonText: "Decline",
            }).then((result) => {
                if (result.isConfirmed) {

                    const formData = new FormData();
                    formData.append('application_id', institution.internal.application_id);
                    dispatch(MEG2Review(formData));
                    setModalForm(false)
                    setModalView(false)
                    setSignedAgreement(false)
                    setModalReviewView(false)
                    setShowConcession(false)
                    setModalPaymentView(false)
                    setModalViewUpdate(false)
                    props.updateParentParent(Math.random());

                }
            });
        }


        if (action == 'completeApplication') {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to complete membership application!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {

                    const formData = new FormData();
                    formData.append('application_id', institution.internal.application_id);
                    dispatch(completeApplication(formData));
                    setModalForm(false)
                    setModalView(false)
                    setSignedAgreement(false)
                    setModalReviewView(false)
                    setShowConcession(false)
                    setModalPaymentView(false)
                    setModalViewUpdate(false)
                    props.updateParentParent(Math.random());

                }
            });
        }

        if (action == 'sendAgreement') {
            Swal.fire({
                title: "Are you sure?",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {

                    const formData = new FormData();
                    formData.append('application_id', institution.internal.application_id);
                    dispatch(MEGSendMembershipAgreement(formData));
                    setModalForm(false)
                    setModalView(false)
                    setSignedAgreement(false)
                    setModalReviewView(false)
                    setShowConcession(false)
                    setModalPaymentView(false)
                    setModalViewUpdate(false)
                    props.updateParentParent(Math.random());

                }
            });
        }


        if (action == 'sendESuccessLetter') {
            Swal.fire({
                title: "Are you sure?",
                text: "",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes!",
                cancelButtonText: "No",
            }).then((result) => {
                if (result.isConfirmed) {

                    const formData = new FormData();
                    formData.append('application_id', institution.internal.application_id);
                    dispatch(MEG2SendESuccess(formData));
                    setModalForm(false)
                    setModalView(false)
                    setSignedAgreement(false)
                    setModalReviewView(false)
                    setShowConcession(false)
                    setModalPaymentView(false)
                    setModalViewUpdate(false)
                    props.updateParentParent(Math.random());

                }
            });
        }



    };
    // console.log(institution)
    // console.log(institution.fsd_review[institution.fsd_review.length-1].comment)

    return (
        <>
            <div className="toggle-expand-content" style={{ display: "block" }}>

                <ul className="nk-block-tools g-3">
                    <li className="nk-block-tools-opt">
                        <UncontrolledDropdown direction="right">
                            <DropdownToggle className="dropdown-toggle btn btn-md" color="secondary">Action</DropdownToggle>

                            <DropdownMenu>
                                <ul className="link-list-opt">

                                    <li size="xs">
                                        <DropdownItem tag="a" onClick={toggleView} >
                                            <Icon name="eye"></Icon>
                                            <span>View Application</span>
                                        </DropdownItem>
                                    </li>
                                    {(aUser.is_admin_mbg() || aUser.is_admin_fsd()) &&
                                        <>
                                            <li size="xs">
                                                <DropdownItem tag="a" onClick={togglePaymentView} >
                                                    <Icon name="eye"></Icon>
                                                    <span>Payment Information</span>
                                                </DropdownItem>
                                            </li>
                                        </>
                                    }



                                </ul>
                            </DropdownMenu>
                        </UncontrolledDropdown>
                    </li>


                </ul>
            </div>

            <Modal isOpen={modalPaymentView} toggle={togglePaymentView} size="lg">
                <ModalHeader toggle={togglePaymentView} close={<button className="close" onClick={togglePaymentView}><Icon name="cross" /></button>}>
                    Payment View
                </ModalHeader>
                <ModalBody>
                    {(institution.internal.concession_stage != '1') ? <>
                        {!showConcession && <>
                            <Button onClick={toggleConcession} >Concession</Button>
                        </>}
                    </> :
                        (institution?.latest_evidence?.proof) ? <>
                            <ul>
                                <li><span className="lead">Invoice Number : {`${institution?.payment_information?.invoice_number}`} </span></li>
                                <li><span className="lead">Date of Payment : {`${institution?.latest_evidence?.dateUpload ? institution?.latest_evidence?.dateUpload : ''}`}</span></li>
                                <li><span className="lead">Reference : {`${institution?.payment_information?.reference}`}</span></li>
                                {(aUser.is_admin_mbg() && $latest_evidence) && <>
                                    <li><span className="lead">Amount received by FSD : {`${institution?.internal?.amount_received_by_fsd}`}</span></li>
                                    <li><span className="lead">Comment : {`${institution.fsd_review[institution.fsd_review.length - 1].comment}`}</span></li>
                                </>}
                            </ul>
                            <div className="my-4">
                                <a className="btn btn-primary mx-2" href={institution?.payment_details?.invoice_url} target="_blank">View Invoice</a>
                                {(aUser.is_admin_fsd() && $latest_evidence) && <>

                                    <a className="btn btn-primary mx-2" href={$latest_evidence.proof} target="_blank">Latest evidence of payment</a>
                                    <Button color="primary" className="mx-2" onClick={toggleReviewView}>Payment Review</Button>

                                </>}
                                {(aUser.is_admin_mbg() && $latest_evidence) && <>

                                    <a className="btn btn-primary mx-2" href={$latest_evidence.proof} target="_blank">Latest evidence of payment</a>
                                    {/* <Button color="primary" className="mx-2"  onClick={toggleReviewView}>Payment Review</Button> */}
                                    <div className="my-4">
                                        <h6>Are you satisfied with FSD Review?</h6>
                                        <Button color="primary" className="mx-2" onClick={() => askAction('approveFSDReview')}>Approve</Button>
                                        <Button color="primary" className="mx-2" onClick={() => askAction('declineFSDReview')}>Decline</Button>
                                    </div>

                                </>}
                            </div>
                        </> : <>
                            <h5>Not Paid</h5>
                        </>}

                    {showConcession && <>
                        <UploadConcession tabItem={institution} updateParentParent={props.updateParentParent} closeModel={togglePaymentView} />
                    </>}

                </ModalBody>
                <ModalFooter className="bg-light">
                    <span className="sub-text"> </span>
                </ModalFooter>
            </Modal>


            <Modal isOpen={modalReviewView} toggle={toggleReviewView} size="sm">
                <ModalHeader toggle={toggleReviewView} close={<button className="close" onClick={toggleReviewView}><Icon name="cross" /></button>}>
                    Payment Review
                </ModalHeader>
                <ModalBody>
                    <ul>
                        <li><span className="lead">Concession Amount : </span>{institution?.payment_details?.concession_amount ? `${institution?.payment_details?.concession_amount?.toLocaleString("en-US")}` : ``}</li>
                        <li><span className="lead">Total Fee : </span>{institution?.payment_details?.total ? `${institution?.payment_details?.total?.toLocaleString("en-US")}` : ``}</li>
                    </ul>
                    <div className="my-4">

                        {(aUser.is_admin_fsd()) && <>

                            <a className="btn btn-primary mx-2" href={institution?.payment_details?.concession_file} target="_blank">View Concession Document </a>

                            <div className="my-4">
                                <Button color="primary" className="mx-2" onClick={() => askAction('approvePaymentReview')}>Validate Payment</Button>
                                <Button color="primary" className="mx-2" onClick={() => askAction('declinePaymentReview')}>Decline</Button>
                            </div>
                        </>}
                    </div>
                </ModalBody>
                <ModalFooter className="bg-light">
                    <span className="sub-text"> </span>
                </ModalFooter>
            </Modal>

            <Modal isOpen={modalView} toggle={toggleView} size="xl">
                <ModalHeader toggle={toggleView} close={<button className="close" onClick={toggleView}><Icon name="cross" /></button>}>
                    View Institution Application
                </ModalHeader>
                <ModalBody>
                    <Card className="card">
                        <CardBody className="card-inner">
                            <CardTitle tag="h5">{`Basic Information`}</CardTitle>

                            <table className="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {institution?.bank_details?.companyName && <>
                                        <tr>
                                            <td></td>
                                            <td>Company Name</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.companyName ?? ''}`}</td>
                                        </tr>
                                    </>}

                                    {institution?.bank_details?.applicationPrimaryContactName && <>
                                        <tr>
                                            <td></td>
                                            <td>Company Name</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.applicationPrimaryContactName ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.individualModeOfIdentification && <>
                                        <tr>
                                            <td></td>
                                            <td>Company Name</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.individualModeOfIdentification ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.individualResidentialAddress && <>
                                        <tr>
                                            <td></td>
                                            <td>Company Name</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.individualResidentialAddress ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.applicationPrimaryContactTelephone && <>
                                        <tr>
                                            <td></td>
                                            <td>Company Name</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.applicationPrimaryContactTelephone ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.applicationPrimaryContactEmailAddress && <>
                                        <tr>
                                            <td></td>
                                            <td>Company Name</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.applicationPrimaryContactEmailAddress ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.reasonForSeekingMembership && <>
                                        <tr>
                                            <td></td>
                                            <td>Company Name</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.reasonForSeekingMembership ?? ''}`}</td>
                                        </tr>
                                    </>}


                                    {institution?.bank_details?.rcNumber && <>
                                        <tr>
                                            <td></td>
                                            <td>RC Number</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.rcNumber ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.registeredOfficeAddress && <>
                                        <tr>
                                            <td></td>
                                            <td>Registered Office Address</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.registeredOfficeAddress ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.placeOfIncorporation && <>
                                        <tr>
                                            <td></td>
                                            <td>Town/City</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.placeOfIncorporation ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.dateOfIncorporation && <>
                                        <tr>
                                            <td></td>
                                            <td>Date of Incorporation</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.dateOfIncorporation ? moment(institution?.basic_details?.dateOfIncorporation).format('MMM. D, YYYY') : ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.placeOfIncorporation && <>
                                        <tr>
                                            <td></td>
                                            <td>Place of Incorporation</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.placeOfIncorporation ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.natureOfBusiness && <>
                                        <tr>
                                            <td></td>
                                            <td>Nature of Business</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.natureOfBusiness ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.companyTelephoneNumber && <>
                                        <tr>
                                            <td></td>
                                            <td>Company Primary Telephone Number</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.companyTelephoneNumber ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.companyTelephoneNumber && <>
                                        <tr>
                                            <td></td>
                                            <td>Company Secondary Telephone Number</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.companyTelephoneNumber ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.companyEmailAddress && <>
                                        <tr>
                                            <td></td>
                                            <td>Company Email Address</td>
                                            <td className="text-lowercase">{`${institution?.basic_details?.companyEmailAddress ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.corporateWebsiteAddress && <>
                                        <tr>
                                            <td></td>
                                            <td>Company Website Address</td>
                                            <td className="text-lowercase">{`${institution?.basic_details?.corporateWebsiteAddress ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.authorisedShareCapital && <>
                                        <tr>
                                            <td></td>
                                            <td>Authorised Share Capital</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.authorisedShareCapital ?? ''}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.authorisedShareCapitalCurrency && <>
                                        <tr>
                                            <td></td>
                                            <td>Authorised Share Capital Currency</td>
                                            <td className="text-capitalize">{`${institution?.basic_details?.authorisedShareCapitalCurrency ?? ''}`}</td>
                                        </tr>
                                    </>}

                                </tbody>
                            </table>
                        </CardBody>
                        <CardBody className="card-inner">
                            <CardTitle tag="h5">{`Bank Details`}</CardTitle>

                            <table className="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {institution?.bank_details?.bankDetailName && <>
                                        <tr>
                                            <td>1</td>
                                            <td>Bank Detail</td>
                                            <td className="text-capitalize">{`${institution?.bank_details?.bankDetailName}`}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Bank Address</td>
                                            <td className="text-capitalize">{`${institution?.bank_details?.bankDetailAddress}`}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Bank Telephone</td>
                                            <td className="text-capitalize">{`${institution?.bank_details?.bankDetailTelephone}`}</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Type Of Account</td>
                                            <td className="text-capitalize">{`${institution?.bank_details?.bankDetailTypeOfAccount}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.bank_details?.bankDetailNameOne && <>

                                        <tr>
                                            <td>1</td>
                                            <td>Bank Detail</td>
                                            <td className="text-capitalize">{`${institution?.bank_details?.bankDetailNameOne}`}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Bank Address</td>
                                            <td className="text-capitalize">{`${institution?.bank_details?.bankDetailAddressOne}`}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Bank Telephone</td>
                                            <td className="text-capitalize">{`${institution?.bank_details?.bankDetailTelephoneOne}`}</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Type Of Account</td>
                                            <td className="text-capitalize">{`${institution?.bank_details?.bankDetailTypeOfAccountOne}`}</td>
                                        </tr>
                                    </>}

                                    {institution?.bank_details?.bankDetailNameTwo && <>

                                        <tr>
                                            <td>1</td>
                                            <td>Bank Detail</td>
                                            <td className="text-capitalize">{`${institution?.bank_details?.bankDetailNameTwo}`}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Bank Address</td>
                                            <td className="text-capitalize">{`${institution?.bank_details?.bankDetailAddressTwo}`}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Bank Telephone</td>
                                            <td className="text-capitalize">{`${institution?.bank_details?.bankDetailTelephoneTwo}`}</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Type Of Account</td>
                                            <td className="text-capitalize">{`${institution?.bank_details?.bankDetailTypeOfAccountTwo}`}</td>
                                        </tr>
                                    </>}

                                </tbody>
                            </table>
                        </CardBody>
                        {institution?.bank_license_details?.bankingLicense && <>

                            <CardBody className="card-inner">
                                <CardTitle tag="h5">{`Type of Bank License`}</CardTitle>

                                <table className="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Banking License</td>
                                            <td className="text-capitalize">{`${institution?.bank_license_details?.bankingLicense}`}</td>
                                        </tr>


                                    </tbody>
                                </table>
                            </CardBody>
                        </>}


                        <CardBody className="card-inner">
                            <CardTitle tag="h5">{`Disciplinary History `}</CardTitle>

                            <table className="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        {/* <th scope="col">#</th> */}
                                        <th scope="col">Name</th>
                                        <th scope="col">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {institution?.disciplinary_details?.chiefComplianceOfficerDisciplinary && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>chiefComplianceOfficerDisciplinary</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.chiefComplianceOfficerDisciplinary}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryFive && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any Authority which may lead to such proceedings?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryFive}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryFour && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryFour}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryOne && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been convicted of any criminal offence? </td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryOne}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryThree && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryThree}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryTwo && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.chiefComplianceOfficerDisciplinaryTwo}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.companyDisciplinary && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>companyDisciplinary</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.companyDisciplinary}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.companyDisciplinaryFour && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Has your company, or any of its affiliates, been subject to any winding up order/receivership arrangement? </td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.companyDisciplinaryFour}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.companyDisciplinaryOne && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Has the company or any of its affiliates , been denied registration or expelled from membership of any securities exchange, self-regulatory organisation (SRO) or associations?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.companyDisciplinaryOne}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.companyDisciplinaryThree && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Has your company, or any of its affiliates, ever been refused any Fidelity Bond?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.companyDisciplinaryThree}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.companyDisciplinaryTwo && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Has your membership, or that of any affiliates, in any of the institutions/associations mentioned above at any time been revoked, suspended or withdrawn?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.companyDisciplinaryTwo}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.mdceoDisciplinary && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>mdceoDisciplinary</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinary}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.mdceoDisciplinaryEight && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been disqualified from acting as a Director?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinaryEight}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.mdceoDisciplinaryFive && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinaryFive}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.mdceoDisciplinaryFour && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinaryFour}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.mdceoDisciplinaryOne && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been convicted of any criminal offence?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinaryOne}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.mdceoDisciplinarySeven && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever had such authorisation, membership or licence (referred to above) revoked or terminated?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinarySeven}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.mdceoDisciplinarySix && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been refused authorisation or licence to carry on a trade, business or profession or to be a member of a securities exchange?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinarySix}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.mdceoDisciplinaryThree && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been a Director, partner or otherwise concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinaryThree}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.mdceoDisciplinaryTwo && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.mdceoDisciplinaryTwo}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.treasureDisciplinary && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>treasureDisciplinary</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.treasureDisciplinary}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.treasureDisciplinaryFive && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.treasureDisciplinaryFive}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.treasureDisciplinaryFour && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.treasureDisciplinaryFour}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.treasureDisciplinaryOne && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been convicted of any criminal offence?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.treasureDisciplinaryOne}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.treasureDisciplinaryThree && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the similar proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one (1) year of that connection?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.treasureDisciplinaryThree}`}</td>
                                        </tr>
                                    </>}
                                    {institution?.disciplinary_details?.treasureDisciplinaryTwo && <>
                                        <tr>
                                            {/* <td>-</td> */}
                                            <td>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?</td>
                                            <td className="text-capitalize">{`${institution?.disciplinary_details?.treasureDisciplinaryTwo}`}</td>
                                        </tr>
                                    </>}


                                </tbody>
                            </table>
                        </CardBody>

                        {institution?.custodian_details?.custodianInformationName && <>
                            <CardBody className="card-inner">
                                <CardTitle tag="h5">{`Custodian Information`}</CardTitle>

                                <table className="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                        <tr>
                                            <td>1</td>
                                            <td>Name</td>
                                            <td className="text-capitalize">{`${institution?.custodian_details?.custodianInformationName}`}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td> Address</td>
                                            <td className="text-capitalize">{`${institution?.custodian_details?.custodianInformationAddress}`}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Mobile Contact</td>
                                            <td className="text-capitalize">{`${institution?.custodian_details?.custodianInformationMobileNumberOfContact}`}</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Telephone</td>
                                            <td className="text-capitalize">{`${institution?.custodian_details?.custodianInformationTelephone}`}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </CardBody>
                        </>}

                        <CardBody className="card-inner">
                            <CardTitle tag="h5">{`Supporting Documents`}</CardTitle>

                            <table className="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col" className="width-30">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {/* {$user_application} */}
                                    {institution?.required_documents && institution?.required_documents?.map((document, index) => (
                                        <tr key={index}>
                                            <th scope="row">{++index}</th>
                                            <td>{document.description}</td>
                                            <td>
                                                {document.uploaded_file != null ? <>
                                                    <a className="btn btn-primary" href={document.file_path} target="_blank">View File </a>
                                                </> : <>
                                                    {document.uploaded_field}
                                                </>}
                                            </td>
                                        </tr>

                                    ))}
                                </tbody>
                            </table>
                        </CardBody>

                        {institution?.latest_evidence && <>
                            <CardBody className="card-inner">
                                <CardTitle tag="h5">{`Payment Information`}</CardTitle>

                                <table className="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>Invoice Number</td>
                                            <td className="text-capitalize">{`${institution?.payment_information?.invoice_number}`}</td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>Payment Reference</td>
                                            <td className="text-capitalize">{`${institution?.payment_information?.reference}`}</td>
                                        </tr>
                                        <tr>
                                            <td>3</td>
                                            <td>Date of Payment</td>
                                            <td className="text-capitalize">{`${institution?.payment_information?.date_paid}`}</td>
                                        </tr>
                                        <tr>
                                            <td>4</td>
                                            <td>Amount Paid</td>
                                            <td className="text-capitalize">{`${institution?.payment_details?.total}`}</td>
                                        </tr>
                                        <tr>
                                            <td>5</td>
                                            <td>Concession Amount</td>
                                            <td className="text-capitalize">{`${institution?.payment_details?.concession_amount}`}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </CardBody>
                        </>}
                        <CardBody className="card-inner">
                            <CardTitle tag="h5">{`MBG Review`}</CardTitle>
                            {/* <ul>
                                  <li><span className="lead">Status :{`${institution?.mbg_review[institution?.mbg_review.length - 1]?.status ? institution?.mbg_review[institution?.mbg_review.length - 1]?.status : ""}`} </span></li>
                                  <li><span className="lead">Reason :{`${institution?.mbg_review[institution?.mbg_review.length - 1]?.comment ? institution?.mbg_review[institution?.mbg_review.length - 1]?.comment : ""}`} </span></li>
              </ul> */}
                            <table className="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Status</td>
                                        <td className="text-capitalize">{`${institution?.mbg_review[institution?.mbg_review.length - 1]?.status ? institution?.mbg_review[institution?.mbg_review.length - 1]?.status : ""}`}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Reason</td>
                                        <td className="text-capitalize">{`${institution?.mbg_review[institution?.mbg_review.length - 1]?.comment ? institution?.mbg_review[institution?.mbg_review.length - 1]?.comment : ""}`}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </CardBody>
                        <CardBody className="card-inner">
                            <CardTitle tag="h5">{`FSD Review`}</CardTitle>
                            {/* <ul>
                                  <li><span className="lead">Status :{`${institution?.fsd_review[institution?.fsd_review.length - 1]?.status ? institution?.fsd_review[institution?.fsd_review.length - 1]?.status : ""}`} </span></li>
                                  <li><span className="lead">Reason :{`${institution?.fsd_review[institution?.fsd_review.length - 1]?.comment ? institution?.fsd_review[institution?.fsd_review.length - 1]?.comment : ""}`} </span></li>
              </ul> */}
                            <table className="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Status</td>
                                        <td className="text-capitalize">{`${institution?.fsd_review[institution?.fsd_review.length - 1]?.status ? institution?.fsd_review[institution?.fsd_review.length - 1]?.status : ""}`}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Reason</td>
                                        <td className="text-capitalize">{`${institution?.fsd_review[institution?.fsd_review.length - 1]?.comment ? institution?.fsd_review[institution?.fsd_review.length - 1]?.comment : ""}`}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </CardBody>
                        <CardBody className="card-inner">
                            <CardTitle tag="h5">{`MEG Review`}</CardTitle>
                            {/* <ul>
                                  <li><span className="lead">Status :{`${institution?.meg_review[institution?.meg_review.length - 1]?.status ? institution?.meg_review[institution?.meg_review.length - 1]?.status : ""}`} </span></li>
                                  <li><span className="lead">Reason :{`${institution?.meg_review[institution?.meg_review.length - 1]?.comment ? institution?.meg_review[institution?.meg_review.length - 1]?.comment : ""}`} </span></li>
              </ul> */}
                            <table className="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>Status</td>
                                        <td className="text-capitalize">{`${institution?.meg_review[institution?.meg_review.length - 1]?.status ? institution?.meg_review[institution?.meg_review.length - 1]?.status : ""}`}</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Reason</td>
                                        <td className="text-capitalize">{`${institution?.meg_review[institution?.meg_review.length - 1]?.comment ? institution?.meg_review[institution?.meg_review.length - 1]?.comment : ""}`}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </CardBody>
                        {(aUser.is_admin_meg() && institution.internal.mbg_review_stage && !institution.internal.meg_review_stage) &&
                            <div className="gy-0">
                                <h5>Application Review</h5>
                                <Button className="btn btn-primary mx-2" onClick={() => askAction('declineApplicationReview')}>Reject Application</Button>
                                <Button className="btn btn-success mx-2" onClick={() => askAction('approveApplicationsReview')}> Upload Application Report</Button>
                            </div>
                        }
                        {(aUser.is_admin_meg2() && institution.internal.meg_review_stage && !institution.internal.meg2_review_stage) &&
                            <div className="gy-0">
                                {/* <h5>Application Review</h5> */}
                                <Button className="btn btn-success mx-2" onClick={() => askAction('approveMEGApplicationsReview')}> Application Review</Button>
                            </div>
                        }

                        {(aUser.is_admin_meg() && institution?.internal?.is_applicant_executed_membership_agreement == 1 && institution?.internal?.is_meg_executed_membership_agreement == 0) && <>
                            {/* {(aUser.is_admin_meg() && institution?.internal?.is_applicant_executed_membership_agreement && !institution?.internal?.is_meg_executed_membership_agreement ) && <> */}
                            <div className="gy-0">
                                <h5>Upload Signed Agreement</h5>
                                <a className="btn btn-primary mx-2" href={institution?.internal?.applicant_executed_membership_agreement} target="_blank">View Executed Agreement</a>
                                <Button className="btn btn-success mx-2" onClick={toggleSignedAgreement}>Upload Executed Agreement</Button>
                            </div>
                        </>

                        }
                        {/* {(aUser.is_admin_meg() && institution?.internal?.is_applicant_executed_membership_agreement == 1 && institution?.internal?.is_meg_executed_membership_agreement == 1 ) && 
                        <div className="gy-0">
                                <h5>Final Review</h5>
                                <a className="btn btn-primary mx-2"   onClick={(e) => navigate(`${process.env.PUBLIC_URL}/${institution?.internal?.institution_id}/list-ars`)} target="_blank">View Authorised Representatives</a>
                                {!institution?.completed && <Button className="btn btn-success mx-2"   onClick={() => askAction('completeApplication')}>Complete Application</Button>}
                          </div>
                      } */}
                        {(aUser.is_admin_meg() && institution?.internal?.meg2_review_stage == 1 && institution?.internal?.meg_review_stage == 1 && institution?.internal?.is_applicant_executed_membership_agreement == 0) &&
                            <div className="gy-0">
                                <h5>Membership Agreement</h5>
                                <a className="btn btn-primary mx-2" onClick={() => setUpdateMemberAgreement(true)}>Update Agreement Detail</a>
                                {institution?.internal?.has_member_agreement && <>
                                    <a className="btn btn-primary mx-2" href={institution?.internal?.member_agreement_preview} target="_blank">Preview Agreement</a>
                                    <Button className="btn btn-success mx-2" onClick={() => askAction('sendAgreement')}> Send Agreement</Button>

                                </>}
                            </div>
                        }
                        {(aUser.is_admin_meg2()
                            && institution.internal.meg2_review_stage == 1
                            && institution.internal.meg_review_stage == 1
                            && institution?.internal?.is_applicant_executed_membership_agreement == 1
                            && institution?.internal?.is_meg_executed_membership_agreement == 1) &&
                            <div className="gy-0">
                                <h5>Send E-Success Letter</h5>
                                <a className="btn btn-primary mx-2" onClick={() => setUpdateMemberESuccessLetter(true)}>Update E-Success Letter Detail</a>
                                {institution?.internal?.has_e_success && <>
                                    <a className="btn btn-primary mx-2" href={institution?.internal?.e_success_letter_preview} target="_blank">Preview E-Success Letter</a>
                                    <Button className="btn btn-success mx-2" onClick={() => askAction('sendESuccessLetter')}> Approve E-Success Letter</Button>

                                </>}
                            </div>
                        }
                    </Card>
                </ModalBody>
                <ModalFooter className="bg-light">
                    <span className="sub-text"> </span>
                </ModalFooter>
            </Modal>

            <Modal isOpen={modalViewUpdate} toggle={toggleViewUpdate} size="lg">
                <ModalHeader toggle={toggleViewUpdate} close={<button className="close" onClick={toggleViewUpdate}><Icon name="cross" /></button>}>
                    View Institution
                </ModalHeader>
                <ModalBody>

                </ModalBody>
                <ModalFooter className="bg-light">
                    <span className="sub-text"> </span>
                </ModalFooter>
            </Modal>

            <Modal isOpen={signedAgreement} toggle={toggleSignedAgreement} size="lg">
                <ModalHeader toggle={toggleSignedAgreement} close={<button className="close" onClick={toggleSignedAgreement}><Icon name="cross" /></button>}>
                    Upload MEG Signed Agreement
                </ModalHeader>
                <ModalBody>
                    <Row className="gy-5">
                        <Col md='12'>
                            <Card className="card-bordered">
                                <CardBody className="card-inner">

                                    <UploadAgreementModel tabItem={institution} updateParentParent={props.updateParentParent} closeModel={toggleSignedAgreement} />

                                </CardBody>
                            </Card>
                        </Col>
                    </Row>
                </ModalBody>
                <ModalFooter className="bg-light">
                    <span className="sub-text"> </span>
                </ModalFooter>
            </Modal>

            <Modal isOpen={updateMemberAgreement} toggle={toggleUpdateMemberAgreement} size="lg">
                <ModalHeader toggle={toggleUpdateMemberAgreement} close={<button className="close" onClick={toggleUpdateMemberAgreement}><Icon name="cross" /></button>}>
                    Update Member Agreement
                </ModalHeader>
                <ModalBody>
                    <Row className="gy-5">
                        <Col md='12'>
                            <Card className="card-bordered">
                                {/* <CardBody className="card-inner"> */}

                                <UpdateAgreement tabItem={institution} updateParentParent={props.updateParentParent} closeModel={toggleUpdateMemberAgreement} />

                                {/* </CardBody> */}
                            </Card>
                        </Col>
                    </Row>
                </ModalBody>
                <ModalFooter className="bg-light">
                    <span className="sub-text"> </span>
                </ModalFooter>
            </Modal>

            <Modal isOpen={updateMemberESuccessLetter} toggle={toggleUpdateMemberESuccessLetter} size="lg">
                <ModalHeader toggle={toggleUpdateMemberESuccessLetter} close={<button className="close" onClick={toggleUpdateMemberESuccessLetter}><Icon name="cross" /></button>}>
                    Update E-Success Letter
                </ModalHeader>
                <ModalBody>
                    <Row className="gy-5">
                        <Col md='12'>
                            <Card className="card-bordered">
                                {/* <CardBody className="card-inner"> */}

                                <UpdateESuccessLetter tabItem={institution} updateParentParent={props.updateParentParent} closeModel={toggleUpdateMemberESuccessLetter} />

                                {/* </CardBody> */}
                            </Card>
                        </Col>
                    </Row>
                </ModalBody>
                <ModalFooter className="bg-light">
                    <span className="sub-text"> </span>
                </ModalFooter>
            </Modal>
        </>


    );
};



const UpdateAgreement = ({ updateParentParent, tabItem, positions, closeModel }) => {

    const aUser = useUser();
    const aUserUpdate = useUserUpdate();

    const tabItem_id = tabItem.id
    const [complainFile, setComplainFile] = useState([]);
    const [loading, setLoading] = useState(false);
    const dispatch = useDispatch();

    const [date, setDate] = useState(new Date());
    const toggleDate = (value) => {
        setDate(value)
    };

    const { handleSubmit, register, watch, formState: { errors } } = useForm();

    const submitForm = async (data) => {

        const postValues = new Object();
        postValues.application_id = tabItem.internal.application_uuid;
        postValues.name = data.institution_name;
        postValues.address_one = data.institution_address_one;
        postValues.address_two = data.institution_address_two;
        postValues.address_three = data.institution_address_three;
        postValues.rc_number = data.institution_rc_number;
        postValues.date = moment(date).format('YYYY-MM-DD');

        try {
            setLoading(true);

            const resp = await dispatch(MEGUpdateMembershipAgreement(postValues));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    updateParentParent(Math.random())
                    closeModel()
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
        <>

            <form className="content clearfix my-5" onSubmit={handleSubmit(submitForm)} encType="multipart/form-data">

                <div className="form-group">
                    <label className="form-label" htmlFor="institution_name">
                        Applicant Name
                    </label>
                    <div className="form-control-wrap">
                        <input type="text" id="institution_name" className="form-control" {...register('institution_name', { required: "This Field is required" })} defaultValue={tabItem?.eMemberAgreement?.companyName} />
                        {errors.institution_name && <span className="invalid">{errors.institution_name.message}</span>}
                    </div>
                </div>
                <div className="form-group">
                    <label className="form-label" htmlFor="institution_address_one">
                        Applicant Address Line One
                    </label>
                    <div className="form-control-wrap">
                        <input type="text" id="institution_address_one" className="form-control" {...register('institution_address_one', { required: "This Field is required" })} defaultValue={tabItem?.eMemberAgreement?.registeredOfficeAddressOne} />
                        {errors.institution_address_one && <span className="invalid">{errors.institution_address_one.message}</span>}
                    </div>
                </div>
                <div className="form-group">
                    <label className="form-label" htmlFor="institution_address_two">
                        Applicant Address Line Two
                    </label>
                    <div className="form-control-wrap">
                        <input type="text" id="institution_address_two" className="form-control" {...register('institution_address_two', { required: "This Field is required" })} defaultValue={tabItem?.eMemberAgreement?.registeredOfficeAddressTwo} />
                        {errors.institution_address_two && <span className="invalid">{errors.institution_address_two.message}</span>}
                    </div>
                </div>
                <div className="form-group">
                    <label className="form-label" htmlFor="institution_address_three">
                        Applicant Address Line Three
                    </label>
                    <div className="form-control-wrap">
                        <input type="text" id="institution_address_three" className="form-control" {...register('institution_address_three', { required: "This Field is required" })} defaultValue={tabItem?.eMemberAgreement?.registeredOfficeAddressThree} />
                        {errors.institution_address_three && <span className="invalid">{errors.institution_address_three.message}</span>}
                    </div>
                </div>

                {tabItem?.eMemberAgreement?.rcNumber && <>
                    <div className="form-group">
                        <label className="form-label" htmlFor="institution_rc_number">
                            Applicant RC Number
                        </label>
                        <div className="form-control-wrap">
                            <input type="text" id="institution_rc_number" className="form-control" {...register('institution_rc_number', { required: "This Field is required" })} defaultValue={tabItem?.eMemberAgreement?.rcNumber} />
                            {errors.institution_rc_number && <span className="invalid">{errors.institution_rc_number.message}</span>}
                        </div>
                    </div>
                </>}

                <div className="form-group">
                    <label className="form-label" htmlFor="date">
                        Date
                    </label>
                    <div className="form-control-wrap">
                        <input type="hidden" {...register('date', { required: "This Field is required" })} value={date} />
                        <DatePicker selected={date} onChange={(date) => toggleDate(date)} className="form-control date-picker" id="date" maxDate={new Date(tabItem?.eMemberAgreement?.date)} />
                        {errors.date && <span className="invalid">{errors.date.message}</span>}
                    </div>
                </div>

                {/* <Card className="card-bordered">
          <CardBody className="card-inner">
            <CardTitle>Authorised Signatory</CardTitle>
            <div className="form-group">
              <label className="form-label" htmlFor="authorised_signatory_name_one">
                Name
              </label>
              <div className="form-control-wrap">
                <input type="number" id="authorised_signatory_name_one" className="form-control" {...register('authorised_signatory_name_one', { required: "This Field is required" })} />
                {errors.authorised_signatory_name_one && <span className="invalid">{errors.authorised_signatory_name_one.message}</span>}
              </div>
            </div>
            <div className="form-group">
              <label className="form-label" htmlFor="authorised_signatory_designation_one">
                Designation
              </label>
              <div className="form-control-wrap">
                <input type="number" id="authorised_signatory_designation_one" className="form-control" {...register('authorised_signatory_designation_one', { required: "This Field is required" })} />
                {errors.authorised_signatory_designation_one && <span className="invalid">{errors.authorised_signatory_designation_one.message}</span>}
              </div>
            </div>
            <div className="form-group">
              <label className="form-label" htmlFor="authorised_signatory_signature_one">
                Signature (image)
              </label>
              <div className="form-control-wrap">
                <input type="file" accept=".png,.jpg,.jpeg" id="authorised_signatory_signature_one" className="form-control" {...register('authorised_signatory_signature_one', { required: "This Field is required" })} onChange={handleFileChange} />
                {errors.authorised_signatory_signature_one && <span className="invalid">{errors.authorised_signatory_signature_one.message}</span>}
              </div>
            </div>
          </CardBody>
        </Card>

        <Card className="card-bordered">
          <CardBody className="card-inner">
            <CardTitle>Authorised Signatory 2</CardTitle>
            <div className="form-group">
              <label className="form-label" htmlFor="authorised_signatory_name_two">
                Name
              </label>
              <div className="form-control-wrap">
                <input type="number" id="authorised_signatory_name_two" className="form-control" {...register('authorised_signatory_name_two', { required: "This Field is required" })} />
                {errors.authorised_signatory_name_two && <span className="invalid">{errors.authorised_signatory_name_two.message}</span>}
              </div>
            </div>
            <div className="form-group">
              <label className="form-label" htmlFor="authorised_signatory_designation_two">
                Designation
              </label>
              <div className="form-control-wrap">
                <input type="number" id="authorised_signatory_designation_two" className="form-control" {...register('authorised_signatory_designation_two', { required: "This Field is required" })} />
                {errors.authorised_signatory_designation_two && <span className="invalid">{errors.authorised_signatory_designation_two.message}</span>}
              </div>
            </div>
            <div className="form-group">
              <label className="form-label" htmlFor="authorised_signatory_signature_two">
                Signature (image)
              </label>
              <div className="form-control-wrap">
                <input type="file" accept=".png,.jpg,.jpeg" id="authorised_signatory_signature_two" className="form-control" {...register('authorised_signatory_signature_two', { required: "This Field is required" })} onChange={handleFileChange} />
                {errors.authorised_signatory_signature_two && <span className="invalid">{errors.authorised_signatory_signature_two.message}</span>}
              </div>
            </div>
          </CardBody>
        </Card> */}


                <div className="form-group">
                    <Button color="primary" type="submit" size="lg">
                        {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Update "}
                    </Button>
                </div>

            </form>

        </>


    );
};

const UpdateESuccessLetter = ({ updateParentParent, tabItem, positions, closeModel }) => {

    const aUser = useUser();
    const aUserUpdate = useUserUpdate();

    const tabItem_id = tabItem.id
    const [complainFile, setComplainFile] = useState([]);
    const [loading, setLoading] = useState(false);
    const dispatch = useDispatch();

    const [date, setDate] = useState(new Date());
    const toggleDate = (value) => {
        setDate(value)
    };

    const { handleSubmit, register, watch, formState: { errors } } = useForm();

    const submitForm = async (data) => {

        const postValues = new Object();
        postValues.application_id = tabItem.internal.application_uuid;
        postValues.name = data.institution_name;
        postValues.address_one = data.institution_address_one;
        postValues.address_two = data.institution_address_two;
        postValues.address_three = data.institution_address_three;
        postValues.member = tabItem?.eSuccess?.applicant_name ? tabItem?.eSuccess?.applicant_name : '';
        // postValues.member = data.member_name;

        try {
            setLoading(true);

            const resp = await dispatch(MEGUpdateMembershipESuccessLetter(postValues));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    updateParentParent(Math.random())
                    closeModel()
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
        <>

            <form className="content clearfix my-5" onSubmit={handleSubmit(submitForm)} encType="multipart/form-data">

                <div className="form-group">
                    <label className="form-label" htmlFor="institution_name">
                        Applicant Name
                    </label>
                    <div className="form-control-wrap">
                        <input type="text" id="institution_name" className="form-control" {...register('institution_name', { required: "This Field is required" })} defaultValue={tabItem?.eSuccess?.companyName} />
                        {errors.institution_name && <span className="invalid">{errors.institution_name.message}</span>}
                    </div>
                </div>
                <div className="form-group">
                    <label className="form-label" htmlFor="institution_address_one">
                        Applicant Address Line Onw
                    </label>
                    <div className="form-control-wrap">
                        <input type="text" id="institution_address_one" className="form-control" {...register('institution_address_one', { required: "This Field is required" })} defaultValue={tabItem?.eSuccess?.registeredOfficeAddressOne} />
                        {errors.institution_address_one && <span className="invalid">{errors.institution_address_one.message}</span>}
                    </div>
                </div>
                <div className="form-group">
                    <label className="form-label" htmlFor="institution_address_two">
                        Applicant Address Line Two
                    </label>
                    <div className="form-control-wrap">
                        <input type="text" id="institution_address_two" className="form-control" {...register('institution_address_two', { required: "This Field is required" })} defaultValue={tabItem?.eSuccess?.registeredOfficeAddressTwo} />
                        {errors.institution_address_two && <span className="invalid">{errors.institution_address_two.message}</span>}
                    </div>
                </div>
                <div className="form-group">
                    <label className="form-label" htmlFor="institution_address_three">
                        Applicant Address Line Three
                    </label>
                    <div className="form-control-wrap">
                        <input type="text" id="institution_address_three" className="form-control" {...register('institution_address_three', { required: "This Field is required" })} defaultValue={tabItem?.eSuccess?.registeredOfficeAddressThree} />
                        {errors.institution_address_three && <span className="invalid">{errors.institution_address_three.message}</span>}
                    </div>
                </div>

                {(tabItem?.basic_details?.rcNumber) && <>
                    <div className="form-group">
                        <label className="form-label" htmlFor="member_name">
                            Member Name
                        </label>
                        <div className="form-control-wrap">
                            <input type="text" id="member_name" className="form-control" {...register('member_name', { required: "This Field is required" })} defaultValue={tabItem?.eSuccess?.applicant_name} />
                            {errors.member_name && <span className="invalid">{errors.member_name.message}</span>}
                        </div>
                    </div>
                </>}

                <div className="form-group">
                    <Button color="primary" type="submit" size="lg">
                        {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Update "}
                    </Button>
                </div>

            </form>

        </>


    );
};

const UploadAgreementModel = ({ updateParentParent, tabItem, positions, closeModel }) => {



    const navigate = useNavigate();
    const tabItem_id = tabItem.id
    const [complainFile, setComplainFile] = useState([]);
    const [loading, setLoading] = useState(false);
    const dispatch = useDispatch();

    const { handleSubmit, register, watch, formState: { errors } } = useForm();

    const submitForm = async (data) => {

        const postValues = new Object();
        postValues.executed_member_agreement = complainFile;
        postValues.application_id = tabItem?.internal.application_id;

        try {
            setLoading(true);

            const resp = await dispatch(MEGUploadAgreement(postValues));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    updateParentParent(Math.random())
                    closeModel()
                    //   navigate(`${process.env.PUBLIC_URL}/dashboard`)
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
        <>

            <form className="content clearfix my-5" onSubmit={handleSubmit(submitForm)} encType="multipart/form-data">

                <div className="form-group">
                    <label className="form-label" htmlFor="proveOfPayment">
                        Signed Agreement
                    </label>
                    <div className="form-control-wrap">
                        <input type="file" accept=".pdf" id="proveOfPayment" className="form-control" {...register('proveOfPayment', { required: "This Field is required" })} onChange={handleFileChange} />
                        {errors.proveOfPayment && <span className="invalid">{errors.proveOfPayment.message}</span>}
                    </div>
                </div>
                <div className="form-group">
                    <Button color="primary" type="submit" size="md">
                        {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Upload "}
                    </Button>

                    <Button color="primary" size='md' className="mx-3" onClick={closeModel}>Cancel</Button>
                </div>

            </form>

        </>


    );
};

const UploadConcession = ({ updateParentParent, tabItem, positions, closeModel }) => {

    const aUser = useUser();
    const aUserUpdate = useUserUpdate();

    const tabItem_id = tabItem.id
    const [complainFile, setComplainFile] = useState([]);
    const [loading, setLoading] = useState(false);
    const dispatch = useDispatch();

    const { handleSubmit, register, watch, formState: { errors } } = useForm();

    const submitForm = async (data) => {

        const postValues = new Object();
        postValues.concession_amount = data.concession_amount;
        postValues.concession_file = complainFile;
        postValues.application_id = tabItem.internal.application_id;

        try {
            setLoading(true);

            const resp = await dispatch(uploadConcession(postValues));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    updateParentParent(Math.random())
                    closeModel()
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
        <>

            <form className="content clearfix my-5" onSubmit={handleSubmit(submitForm)} encType="multipart/form-data">


                <div className="form-group">
                    <label className="form-label" htmlFor="concession_amount">
                        Concession Amount
                    </label>
                    <div className="form-control-wrap">
                        <input type="number" id="concession_amount" className="form-control" {...register('concession_amount', { required: "This Field is required" })} />
                        {errors.concession_amount && <span className="invalid">{errors.concession_amount.message}</span>}
                    </div>
                </div>
                <div className="form-group">
                    <label className="form-label" htmlFor="concession_file">
                        Concession Approval (pdf)
                    </label>
                    <div className="form-control-wrap">
                        <input type="file" accept=".pdf" id="concession_file" className="form-control" {...register('concession_file', { required: "This Field is required" })} onChange={handleFileChange} />
                        {errors.concession_file && <span className="invalid">{errors.concession_file.message}</span>}
                    </div>
                </div>
                <div className="form-group">
                    <Button color="primary" type="submit" size="lg">
                        {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Upload Concession"}
                    </Button>
                </div>

            </form>

        </>


    );
};


const AdminInstitutionTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState, allApplications, $active_categories, $institutions }) => {

    const complainColumn = [
        {
            name: "SN",
            selector: (row, index) => ++index,
            sortable: true,
            width: "100px",
            wrap: true
        },
        {
            name: "Category",
            selector: (row) => { return (<><p>{`${row.internal.category_name}`}</p></>) },
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Institution Name",
            selector: (row) => { return (<>{`${row.basic_details.companyName}`}</>) },
            sortable: true,
            width: "auto",
            wrap: true
        },
        // {
        //   name: "Concession",
        //   selector: (row) => { return row.internal.concession_stage == 1 ? (<><Badge color="success" className="text-uppercase">{`Concession Updated`}</Badge></>) : (<><Badge color="success" className="text-uppercase">{`Pending Concession`}</Badge></>) },
        //   sortable: true,
        //   width: "auto",
        //   wrap: true
        // },
        {
            name: "Status",
            selector: (row) => { return (<><Badge color="success" className="text-uppercase">{row.internal.status}</Badge></>) },
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Sign-on Date",
            selector: (row) => moment(row.createdAt).format('MMM. D, YYYY HH:mm'),
            sortable: true,
            width: "auto",
            wrap: true
        },
    ];

    if (!allApplications) {
        complainColumn.push({
            name: "Action",
            selector: (row) => (<>
                <ActionTab institution={row} updateParentParent={updateParent} />
            </>),
            width: "100px",
        })
    }
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
                let tableSet = [item.internal.category_name, item.basic_details.companyName, item.internal.status]
                // return (Object.values(item).join('').toLowerCase()).includes(searchText.toLowerCase())
                return (tableSet.join('').toLowerCase()).includes(searchText.toLowerCase())
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


    const [loading, setLoading] = useState(false);

    const { register, handleSubmit, formState: { errors }, resetField, setValue, getValues } = useForm();

    let filteredApplication = data;

    const handleFormSubmit = async (values) => {

        if (values?.institution) {
            filteredApplication = filteredApplication.filter((item) => item.internal.institution_id == values?.institution)
        }
        if (values?.category) {
            filteredApplication = filteredApplication.filter((item) => item?.internal?.category_id == values?.category)
        }

        setTableData(filteredApplication)

    };

    return (
        <>
            <div>
                <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                    <Row>

                        <Col md={'6'}>
                            <div className="form-group">
                                <label className="form-label" htmlFor="category">
                                    Category
                                </label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select" {...register('category')}>
                                            <option value=''>All</option>
                                            {$active_categories && $active_categories.map((active_category, index) =>
                                                <option key={`activeCategory${index}`} value={active_category.id}>{active_category.name}</option>
                                            )}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </Col>

                        <Col md={'6'}>
                            <div className="form-group">
                                <label className="form-label" htmlFor="institution">
                                    Institution
                                </label>
                                <div className="form-control-wrap">
                                    <div className="form-control-select">
                                        <select className="form-control form-select" {...register('institution')}>
                                            <option value=''>All</option>
                                            {$institutions && $institutions.map((institution, index) =>
                                                institution?.name &&
                                                <option key={`activeInstitution${index}`} value={institution.id}>{institution.name}</option>
                                            )}
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </Col>

                        <Col md={'12'} className="">

                            <div className="form-group float-end m-5">
                                <Button color="primary" type="submit" size="lg">
                                    {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Filter Report"}
                                </Button>
                            </div>
                        </Col>
                    </Row>

                </form>
            </div>
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
        </>

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

export default AdminInstitutionTable;
