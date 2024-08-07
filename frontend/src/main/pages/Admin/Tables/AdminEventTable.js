import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import { useNavigate } from "react-router-dom";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { useForm } from "react-hook-form";
import { useDispatch } from "react-redux";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, CardTitle, CardBody } from "reactstrap";
import { DataTablePagination } from "components/Component";
import { megDeleteEvent } from "redux/stores/education/eventStore";
import moment from "moment";
import Icon from "components/icon/Icon";
import Swal from "sweetalert2";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';

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
            "Event Name": `${item.name}`,
            "Description": item.description,
            "Date": moment(item.date).format('MMM D, YYYY'),
            "Annual": item.is_annual,
            "Registration Fee": (item.fee < 1) ? 'Free' : `${item.fee}`,
            "Interests": `${item.registrations_count}  Users`,
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


const ActionTab = ({ updateParentParent, tabItem }) => {
    const tabItem_id = tabItem.id
    const [modalForm, setModalForm] = useState(false);
    const navigate = useNavigate();

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const toggleForm = () => setModalForm(!modalForm);

    const dispatch = useDispatch();
    const { register, handleSubmit, formState: { errors }, resetField } = useForm();
    const [loading, setLoading] = useState(false);

    const [formData, setFormData] = useState({
        name: tabItem.name,
        description: tabItem.description,
        position: tabItem.position,
        member_category: tabItem.member_category,
    });


    const askAction = async (action) => {

        if (action == 'delete') {
            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to delete this event!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Confirm",
            }).then((result) => {

                if (result.isConfirmed) {
                    console.log('herer')
                    const formData = new FormData();
                    formData.append('event_id', tabItem_id);
                    dispatch(megDeleteEvent(formData));

                    updateParentParent(Math.random())

                }
            });
        }
    }

    return (
        <>

            <div className="toggle-expand-content" style={{ display: "block" }}>
                <ul className="nk-block-tools g-3">
                    <li className="nk-block-tools-opt">
                        <UncontrolledDropdown direction="right">
                            <DropdownToggle className="dropdown-toggle btn btn-sm" color="primary">Action</DropdownToggle>

                            <DropdownMenu>
                                <ul className="link-list-opt">

                                    <li size="xs">
                                        <DropdownItem tag="a" onClick={toggleForm} >
                                            <Icon name="eye"></Icon>
                                            <span>View</span>
                                        </DropdownItem>
                                    </li>
                                    {(authUser.is_admin_meg() && (tabItem.is_event_completed == 0)) && <>
                                        <li size="xs">
                                            <DropdownItem tag="a" onClick={(e) => navigate(`${process.env.PUBLIC_URL}/admin-edit-event/${tabItem_id}`)} >
                                                <Icon name="pen"></Icon>
                                                <span>Edit</span>
                                            </DropdownItem>
                                        </li>
                                        <li size="xs">
                                            <DropdownItem tag="a" onClick={(e) => askAction('delete')} >
                                                <Icon name="trash"></Icon>
                                                <span>Delete</span>
                                            </DropdownItem>
                                        </li>
                                    </>}

                                    <li size="xs">
                                        <DropdownItem tag="a" onClick={(e) => navigate(`${process.env.PUBLIC_URL}/admin-event-registration/${tabItem_id}`)} >
                                            <Icon name="eye"></Icon>
                                            <span>View Registrations</span>
                                        </DropdownItem>
                                    </li>
                                    {/* {(!tabItem.active) ? <>
                    <li size="xs">
                      <DropdownItem tag="a" onClick={(e) => askAction('open')} >
                        <Icon name="eye"></Icon>
                        <span>Activate</span>
                      </DropdownItem>
                    </li></> : <>
                    <li size="xs">
                      <DropdownItem tag="a" onClick={(e) => askAction('close')} >
                        <Icon name="eye"></Icon>
                        <span>Deactivate</span>
                      </DropdownItem>
                    </li>
                  </>
                  } */}

                                </ul>
                            </DropdownMenu>
                        </UncontrolledDropdown>
                    </li>

                </ul>
            </div>
            <Modal isOpen={modalForm} toggle={toggleForm} size="lg">
                <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
                    View Event
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
                                        <td>Event Name </td>
                                        <td className="text-capitalize">{`${tabItem.name}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Description </td>
                                        <td className="text-capitalize">{`${tabItem.description}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Event Date </td>
                                        <td className="text-capitalize">{`${moment(tabItem.date).format("MMM D, YYYY")}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Annual</td>
                                        <td className="text-capitalize">{`${(tabItem.is_annual == 1) ? 'Yes' : 'No'}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Registration Fee</td>
                                        <td className="text-capitalize">{`${(tabItem.fee < 1) ? 'Free' : `${tabItem.fee}`}`}</td>
                                    </tr>
                                    <tr>
                                        <td>Interests </td>
                                        <td className="text-capitalize">{`${tabItem?.registrations_count}  Users`}</td>
                                    </tr>

                                </tbody>
                            </table>
                        </CardBody>
                    </Card>
                </ModalBody>
            </Modal>
        </>

    );
};


const AdminEventTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState }) => {

    const tableColumn = [
        {
            name: "SN",
            selector: (row, index) => ++index,
            sortable: true,
            width: "60px",
            wrap: true
        },
        {
            name: "Event Name",
            selector: (row) => row.name,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Description",
            selector: (row) => row.description,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Event Date",
            selector: (row) => moment(row.date).format("MMM D, YYYY"),
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Annual",
            selector: (row) => { return (<><Badge color={(row.is_annual == 1) ? 'success' : 'gray'}>{(row.is_annual == 1) ? `Yes` : `No`}</Badge></>) },
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Registration Fee",
            selector: (row) => (row.fee < 1) ? 'Free' : `${row.fee}`,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Interests",
            selector: (row) => `${row.registrations_count} Users`,
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Action",
            selector: (row) => (<>
                <ActionTab tabItem={row} updateParentParent={updateParent} />
            </>),
            width: "90px"
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

export default AdminEventTable;
