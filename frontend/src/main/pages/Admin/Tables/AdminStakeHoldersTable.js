import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { useForm } from "react-hook-form";
import { useDispatch } from "react-redux";
import { Col, Row, Button, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, Modal, ModalHeader, ModalBody, ModalFooter, Spinner } from "reactstrap";
import { DataTablePagination } from "components/Component";
import { updateStakeHolder, updateStakeHolderStatus } from "redux/stores/users/userStore";
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
            "PID": ++index,
            "Name": `${item.name}`,
            "Website": item.url,
            "Status": item.active,
            "Sign-on Date": moment(item.createdAt).format('MMM. D, YYYY HH:mm')
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


const ActionTab = ({ updateParentParent, tabItem }) => {
    const tabItem_id = tabItem.id
    const [modalForm, setModalForm] = useState(false);
    const [modalDetail, setModalDetail] = useState(false);

    const toggleForm = () => setModalForm(!modalForm);
    const toggleModalDetail = () => { setModalDetail(!modalForm) };

    const dispatch = useDispatch();
    const { register, handleSubmit, formState: { errors }, resetField } = useForm();
    const [loading, setLoading] = useState(false);

    const [formData, setFormData] = useState({
        firstName: tabItem.first_name,
        lastName: tabItem.last_name,
        email: tabItem.email,
    });
    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('id', tabItem_id)
        formData.append('firstName', values.firstName)
        formData.append('lastName', values.lastName)
        formData.append('email', values.email)
        // console.log("ded")
        try {
            setLoading(true);
            const resp = await dispatch(updateStakeHolder(formData));

            if (resp.payload?.message === "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('firstName')
                    resetField('lastName')
                    resetField('email')
                    updateParentParent(Math.random())
                }, 1000);

            } else {
                setLoading(false);
            }

        } catch (error) {
            setLoading(false);
        }
    };

    const toggleModalDetailTwo = () => {
        setModalDetail(false)
    }


    const askAction = async (status) => {
        const actionText = tabItem.approval_status ? 'Activate' : 'Deactivate';
        const oppositeStatus = tabItem.approval_status == 'approved' ? 'declined' : 'approved';

        const confirmationText = tabItem.approval_status == 'declined' ? 'Do you want to activate this stakeholder?' : 'Do you want to deactivate this stakeholder?';

        const confirmationButtonText = tabItem.approval_status ? 'Yes, activate' : 'Yes, deactivate';

        Swal.fire({
            title: 'Are you sure?',
            text: confirmationText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: confirmationButtonText,
        }).then((result) => {
            if (result.isConfirmed) {
                const formData = new FormData();
                formData.append('id', tabItem_id);
                formData.append('status', oppositeStatus);
                const resp = dispatch(updateStakeHolderStatus(formData));
                updateParentParent(Math.random());
            }
        });
    };

    return (
        <>

            <div className="toggle-expand-content" style={{ display: "block" }}>
                <ul className="nk-block-tools g-3">
                    <li className="nk-block-tools-opt">
                        <UncontrolledDropdown direction="right">
                            <DropdownToggle className="dropdown-toggle btn btn-sm" color="secondary">Action</DropdownToggle>

                            <DropdownMenu>
                                <ul className="link-list-opt">
                                    <li size="xs">
                                        <DropdownItem tag="a" onClick={toggleForm} >
                                            <Icon name="eye"></Icon>
                                            <span>Edit</span>
                                        </DropdownItem>
                                    </li>
                                    {tabItem.approval_status == 'approved' ? (
                                        <>
                                            <li size="xs">
                                                <DropdownItem tag="a" onClick={() => askAction('declined')}>
                                                    <Icon name="eye"></Icon>
                                                    <span>Deactivate</span>
                                                </DropdownItem>
                                            </li>
                                        </>
                                    ) : (
                                        <>
                                            <li size="xs">
                                                <DropdownItem tag="a" onClick={() => askAction('approved')}>
                                                    <Icon name="eye"></Icon>
                                                    <span>Activate</span>
                                                </DropdownItem>
                                            </li>
                                        </>
                                    )}

                                </ul>
                            </DropdownMenu>
                        </UncontrolledDropdown>
                    </li>

                </ul>
            </div>
            <Modal isOpen={modalForm} toggle={toggleForm} >
                <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
                    Update
                </ModalHeader>
                <ModalBody>
                    <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
                        <div className="form-group">
                            <label className="form-label" htmlFor="full-name">
                                First Name
                            </label>
                            <div className="form-control-wrap">
                                <input type="text" id="name" className="form-control" {...register('firstName', { required: "This field is required" })} defaultValue={formData.firstName} />
                                {errors.firstName && <span className="invalid">{errors.firstName.message}</span>}
                            </div>
                        </div>
                        <div className="form-group">
                            <label className="form-label" htmlFor="full-name">
                                Last Name
                            </label>
                            <div className="form-control-wrap">
                                <input type="text" id="name" className="form-control" {...register('lastName', { required: "This field is required" })} defaultValue={formData.lastName} />
                                {errors.lastName && <span className="invalid">{errors.lastName.message}</span>}
                            </div>
                        </div>
                        <div className="form-group">
                            <label className="form-label" htmlFor="full-name">
                                Email
                            </label>
                            <div className="form-control-wrap">
                                <input type="text" id="name" className="form-control" {...register('email', { required: "This field is required" })} defaultValue={formData.email} />
                                {errors.email && <span className="invalid">{errors.email.message}</span>}
                            </div>
                        </div>
                        <div className="form-group">
                            <Button color="primary" type="submit" size="lg">
                                {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Update"}
                            </Button>
                        </div>
                    </form>
                </ModalBody>
                <ModalFooter className="bg-light">
                    <span className="sub-text">Update Status</span>
                </ModalFooter>
            </Modal>
        </>


    );
};

const AdminRegulatorTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState }) => {
    const tableColumn = [
        {
            name: "ID",
            selector: (row, index) => ++index,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Full Name",
            selector: (row) => row.full_name,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Email ",
            selector: (row) => row.email,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Status",
            selector: (row) => {
                return (
                    <>
                        <Badge color={row.approval_status == 'approved' ? "success" : "danger"} className="text-uppercase">{row.approval_status} </Badge>
                    </>
                );
            },
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
        {
            name: "Action",
            selector: (row) => (<>
                <ActionTab tabItem={row} updateParentParent={updateParent} />
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
                columns={tableColumn}
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

export default AdminRegulatorTable;
