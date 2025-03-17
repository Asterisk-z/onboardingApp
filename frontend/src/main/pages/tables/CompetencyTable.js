import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import exportFromJSON from "export-from-json";
import { useDispatch } from "react-redux";
import { useForm } from "react-hook-form";
import CopyToClipboard from "react-copy-to-clipboard";
import { Col, Modal, ModalBody, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, ModalHeader, Card, Spinner, CardTitle, CardBody } from "reactstrap";
import { DataTablePagination } from "components/Component";
import { loadAllActiveCompetency, sendCompetency } from "redux/stores/competency/competencyStore";
import moment from "moment";
import Icon from "components/icon/Icon";
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
            // "Competency": `${item.framework.description}`,
            // "AR Detail": item.ar.email,
            "Response": item.is_competent ? 'YES' : 'NO',
            "Evidence": item.evidence_file,
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



const ActionTab = (props) => {
    const tabItem = props.competency

    const [modalForm, setModalForm] = useState(false);

    const dispatch = useDispatch()
    const toggleForm = () => setModalForm(!modalForm);

    const [counter, setCounter] = useState(false);
    const [modalFormView, setModalFormView] = useState(false);
    const [competencyId, setCompetencyId] = useState(0);
    const [loading, setLoading] = useState(false);
    const [evidenceFile, setEvidenceFile] = useState([]);
    const toggleFormView = () => setModalFormView(!modalFormView);


    const { register, handleSubmit, formState: { errors }, resetField } = useForm();



    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('framework_id', tabItem.id)
        formData.append('comment', values.comment)
        formData.append('is_competent', 1)
        if (evidenceFile) formData.append('evidence', evidenceFile)

        try {
            setLoading(true);

            const resp = await dispatch(sendCompetency(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('comment')
                    resetField('evidence')
                    setCounter(!counter)
                    dispatch(loadAllActiveCompetency());
                    // window.location.reload(true)
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

    const [parentState, setParentState] = useState('Initial state');

    const updateParentState = (newState) => {
        setParentState(newState);
    };



    return (
        <>
            {tabItem && <> <Button color="primary" size="sm" onClick={toggleForm} >Send</Button></>}

            <Modal isOpen={modalForm} toggle={toggleForm} size="lg">
                <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
                    Competency
                </ModalHeader>
                <ModalBody>
                    <Card className="card">
                        <CardBody className="card-inner">
                            <CardTitle tag="h5"></CardTitle>
                            <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                                <div className="form-group">
                                    <label className="form-label" htmlFor="comment">
                                        Comments (optional)
                                    </label>
                                    <div className="form-control-wrap">
                                        <textarea type="text" className="form-control" id="comment" {...register('comment', { required: false })}></textarea>
                                        {errors.comment && <p className="invalid">{`${errors.comment.message}`}</p>}
                                    </div>
                                </div>
                                <div className="form-group">
                                    <label className="form-label" htmlFor="evidence">
                                        Upload Evidence (*jpg, png, pdf) (optional)
                                    </label>
                                    <div className="form-control-wrap">
                                        <input type="file" accept=".gif,.jpg,.jpeg,.png,.pdf" id="evidence" className="form-control"  {...register('evidence', {})} onChange={handleFileChange} />
                                        {errors.evidence && <p className="invalid">{`${errors.evidence.message}`}</p>}
                                    </div>
                                </div>
                                <div className="form-group">
                                    <Button color="primary" type="submit" size="lg">
                                        {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Yes"}
                                    </Button>
                                </div>
                            </form>
                        </CardBody>
                    </Card>
                </ModalBody>
            </Modal>
        </>
    );
};

const ResponseTab = (props) => {

    const tabItem = props.response

    const [modalForm, setModalForm] = useState(false);

    const dispatch = useDispatch()
    const toggleForm = () => setModalForm(!modalForm);


    return (
        <>
            {tabItem && <> <Button color="primary" size="sm" onClick={toggleForm} ><Icon name="eye"></Icon>View</Button></>}

            <Modal isOpen={modalForm} toggle={toggleForm} size="lg">
                <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
                    View
                </ModalHeader>
                <ModalBody>
                    <Card className="card">
                        <CardBody className="card-inner">
                            <CardTitle tag="h5"></CardTitle>
                            {/* <CardText> */}

                            <table className="table table-striped table-bordered table-hover">

                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Status</td>
                                        <td className="text-capitalize">{`${(tabItem?.status == 'approved') ? 'Approved' : 'Pending'}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Response </td>
                                        <td className="text-capitalize">{`${(tabItem?.is_competent) ? 'YES' : 'NO'}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Comment </td>
                                        <td className="text-capitalize">{`${tabItem?.comment}`}</td>
                                    </tr>

                                    {tabItem?.evidence_file && <>
                                        <tr>
                                            <td>Evidence  </td>
                                            <td className="text-capitalize">
                                                <a href={tabItem?.evidence_file} target="_blank">
                                                    <Button color="primary" size="sm">view Evidence</Button>
                                                </a>
                                            </td>
                                        </tr>
                                    </>}

                                </tbody>
                            </table>
                        </CardBody>
                    </Card>
                </ModalBody>
            </Modal>
        </>
    );
};

const ProficiencyTab = (props) => {

    const tabItem = props.proficiencies

    const [modalForm, setModalForm] = useState(false);

    const dispatch = useDispatch()
    const toggleForm = () => setModalForm(!modalForm);



    return (
        <>
            {tabItem && <> <Button color="primary" size="sm" onClick={toggleForm} ><Icon name="eye"></Icon>View</Button></>}

            <Modal isOpen={modalForm} toggle={toggleForm} size="lg">
                <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
                    View Proficiencies
                </ModalHeader>
                <ModalBody>
                    <Card className="card">
                        <CardBody className="card-inner">
                            <CardTitle tag="h5"></CardTitle>
                            {/* <CardText> */}

                            <table className="table table-striped table-bordered table-hover">

                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {tabItem && tabItem?.map((item, index) => (
                                        <tr key={index}>
                                            <td>{++index} </td>
                                            <td>{item.description} </td>
                                        </tr>
                                    ))}


                                </tbody>
                            </table>
                        </CardBody>
                    </Card>
                </ModalBody>
            </Modal>
        </>
    );
};


const ApproveCompetencyTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent }) => {
    const [tableData, setTableData] = useState(data);
    const [searchText, setSearchText] = useState("");
    const [rowsPerPageS, setRowsPerPage] = useState(10);
    const [mobileView, setMobileView] = useState();

    const ApproveCompetencyColumn = [
        {
            name: "SN",
            selector: (row, index) => ++index,
            sortable: true,
            width: "80px",
        },
        {
            name: "Competency",
            selector: (row) => { return (<><p>{`${row.name} `}</p></>) },
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Description",
            selector: (row) => { return (<><p>{`${row.description}`}</p></>) },
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Expected Proficiency",
            selector: (row) => { return (<><p>{`${row.expected_proficiency}`}</p></>) },
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Status",
            selector: (row) => {
                return (<>
                    {!row.ar_response ? <>Not Uploaded</> : <>
                        <Badge color={row.ar_response.status == 'pending' ? 'success' : 'gray'}>{row.ar_response.status == 'pending' ? `Awaiting CCO Approval` : `Approved by CCO`}</Badge>
                    </>}
                </>)
            },
            sortable: true,
            width: "auto",
        },
        {
            name: "Response",
            selector: (row) => (row.ar_response ? <> <ResponseTab response={row.ar_response} updateParentParent={updateParent} /></> : "No Reponse"),
            sortable: true,
            width: "auto",
        },
        {
            name: "Proficiencies",
            selector: (row) => (row.proficiencies.length > 0 ? <> <ProficiencyTab proficiencies={row.proficiencies} updateParentParent={updateParent} /></> : "None"),
            sortable: true,
            width: "auto",
        },
        {
            name: "Action",
            selector: (row) => (!row.ar_response ? <> <ActionTab competency={row} updateParentParent={updateParent} /></> : "Sent"),
            sortable: true,
            width: "auto",
        },
    ];

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
                columns={ApproveCompetencyColumn}
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

export default ApproveCompetencyTable;
