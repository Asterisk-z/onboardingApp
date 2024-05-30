import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import exportFromJSON from "export-from-json";
import { useDispatch, useSelector } from "react-redux";
import CopyToClipboard from "react-copy-to-clipboard";
import { Col, Modal, ModalBody, Row, Button, Dropdown, Card, Spinner, Label, CardBody, CardTitle, Badge, ModalHeader, ModalFooter } from "reactstrap";
import { DataTablePagination } from "components/Component";
import { updateSanctionStatus, loadAllSanctions } from "redux/stores/sanctions/sanctionStore";
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
            "ID": ++index,
            "Institution": `${item.institution_obj.name}`,
            "Sanction Summary": item.sanction_summary,
            "AR Summary": item.ar_summary,
            "CCO": item.sanctioner.full_name,
            "AR": item.sanctionee.full_name_with_mail,
            "Date Created": moment(item.created_at).format('MMM. D, YYYY HH:mm')
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



const DropdownTrans = (props) => {

    const dispatch = useDispatch();
    const sanction = props.data
    const [modalForm, setModalForm] = useState(false);

    const toggleForm = () => setModalForm(!modalForm);


    const askAction = (action, ar) => {

        // if (action == 'memberStatus') {
        Swal.fire({
            title: "Are you sure?",
            text: "",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes",
            cancelButtonText: "No",
        }).then((result) => {
            if (result.isConfirmed) {

                const formData = new FormData();
                formData.append('sanction_id', sanction.id);
                formData.append('status', action);
                dispatch(updateSanctionStatus(formData));
                setModalForm(false)

                setTimeout(() => {
                    dispatch(loadAllSanctions());
                }, 2000)

            }
        });
        // }



    };

    return (
        <>
            <Button color="secondary" className="btn" onClick={toggleForm}> <Icon name="eye"></Icon> View</Button>
            <Modal isOpen={modalForm} toggle={toggleForm} size="xl">
                <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
                    View
                </ModalHeader>
                <ModalBody className="modal-body-xl">

                    <Card className="card">
                        <CardBody className="card-inner">

                            <table className="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Sanction Summary</td>
                                        <td className="text-capitalize">{`${sanction?.sanction_summary}`}</td>
                                    </tr>
                                    <tr>
                                        <td>AR Summary</td>
                                        <td className="text-capitalize">{`${sanction?.ar_summary}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Evidence</td>
                                        <td>{sanction?.evidence_file ? (
                                            <a size="lg" href={sanction?.evidence_file} target="_blank" className="btn-primary">
                                                <Button color="primary">
                                                    <span >{"View"}</span>
                                                </Button>
                                            </a>
                                        ) : `Not Uploaded`}</td>
                                    </tr>
                                    <tr>
                                        <td>CCO</td>
                                        <td className="text-capitalize">{`${sanction?.sanctioner?.fullName}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td className="text-uppercase">{`${sanction?.status}`}</td>
                                    </tr>
                                    <tr>
                                        <td colSpan={2} className="text-center">{sanction?.status == 'pending' ? (
                                            <>
                                                <Button color="primary" onClick={() => askAction('investigating')}>
                                                    <span >{"Start Investigating"}</span>
                                                </Button>
                                            </>
                                        ) : ``}
                                            {['pending', 'investigating'].includes(sanction?.status) ? (
                                                <>
                                                    <Button color="warning" onClick={() => askAction('closed')}>
                                                        <span >{"Close"}</span>
                                                    </Button>
                                                </>
                                            ) : ``}</td>
                                    </tr>

                                </tbody>
                            </table>
                            <h4>Sanctioned AR</h4>
                            <CardTitle tag="h5" className="text-center">
                                <img src={sanction?.sanctionee.img} className="rounded-xl" style={{ height: '200px', width: '200px', borderRadius: '100%' }} />
                            </CardTitle>

                            <table className="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>First Name</td>
                                        <td className="text-capitalize">{`${sanction?.sanctionee?.firstName}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Last Name</td>
                                        <td className="text-capitalize">{`${sanction?.sanctionee?.lastName}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td className="text-capitalize">{`${sanction?.sanctionee?.email}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Phone</td>
                                        <td className="text-capitalize">{`${sanction?.sanctionee?.phone}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Nationality</td>
                                        <td className="text-capitalize">{`${sanction?.sanctionee?.nationality.toLowerCase()}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Role</td>
                                        <td className="text-capitalize">{`${sanction?.sanctionee?.role.name.toLowerCase()}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Position</td>
                                        <td className="text-capitalize">{`${sanction?.sanctionee?.position.name.toLowerCase()}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td className="text-capitalize">{`${sanction?.sanctionee?.approval_status.toLowerCase()}`}</td>
                                    </tr>
                                    <tr>
                                        <td>RegID</td>
                                        <td className="text-capitalize">{`${sanction?.sanctionee?.regId}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Institution</td>
                                        <td className="text-capitalize">{`${sanction?.sanctionee?.institution?.name?.toLowerCase()}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Signature Mandate</td>
                                        <td>{sanction?.sanctionee?.mandate_form ? (
                                            <a size="lg" href={sanction?.sanctionee?.mandate_form} target="_blank" className="btn-primary">
                                                <Button color="primary">
                                                    <span >{"View Mandate"}</span>
                                                </Button>
                                            </a>
                                        ) : `Not Uploaded`}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </CardBody>
                    </Card>
                </ModalBody>
                <ModalFooter className="bg-light">
                    <div className="text-center w-100">
                        <p>
                            Member Regulation and Oversight Information System (MROIS)
                        </p>
                    </div>
                </ModalFooter>
            </Modal>
        </>
    );
};


const AdminSanctionTable = ({ data, pagination, actions, className, selectableRows, expandableRows }) => {


    const sanctionColumn = [
        {
            name: "ID",
            selector: (row, index) => ++index,
            sortable: true,
            width: "80px",
        },
        {
            name: "Institution",
            selector: (row) => row.institution_obj.name,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Sanction Summary",
            selector: (row) => row.sanction_summary,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "AR Summary",
            selector: (row) => row.ar_summary,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Evidence",
            selector: (row) => { return row.evidence_file ? (<><a href={row.evidence_file} target="_blank" className="btn btn-success">{`View`}</a></>) : (<><Badge color="warning">{`No evidence`}</Badge></>) },
            sortable: true,
            width: "150px",
        },
        {
            name: "CCO",
            selector: (row) => row.sanctioner.fullName,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "AR",
            selector: (row) => row.sanctionee.fullNameWithMail,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Date Created",
            selector: (row) => moment(row.created_at).format('MMM. D, YYYY HH:mm'),
            sortable: true,
            width: "150px",
        }, {
            name: "Action",
            selector: (row) => (<>
                <DropdownTrans data={row} />
            </>),
            width: "100px",
        }
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
                columns={sanctionColumn}
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
};

export default AdminSanctionTable;
