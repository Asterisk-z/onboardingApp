import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import { useNavigate } from "react-router-dom";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { useForm } from "react-hook-form";
import { useDispatch, useSelector } from "react-redux";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, CardBody, CardTitle } from "reactstrap";
import { DataTablePagination } from "components/Component";
import { userUpdateUserAR, userCancelUpdateUserAR, userProcessUpdateUserAR, userTransferUserAR } from "redux/stores/authorize/representative";
import { loadAllCategoryPositions } from "redux/stores/positions/positionStore";
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
            "SN": ++index,
            "Name": `${item.firstName} ${item.lastName}`,
            "Email": item.email,
            "Phone": item.phone,
            "Role": item.role,
            "Status": item.approval_status,
            "Sign-on Date": moment(item?.createdAt).format('MMM. D, YYYY HH:mm')
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

const ActionTab = (props) => {

    const aUser = useUser();
    const aUserUpdate = useUserUpdate();

    const tabItem = props.tabItem


    const navigate = useNavigate();


    return (
        <>
            {aUser?.user_data?.id == tabItem.internal?.submitted_by && <>
                {tabItem.internal?.show_form == 1 ? <>
                    <button className="btn btn-sm btn-secondary" color="secondary" onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/application/${tabItem.internal?.application_uuid}`)}>Continue Application</button>
                </> : <>

                    <button className="btn btn-sm btn-secondary" color="secondary" onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/application_detail/${tabItem.internal?.application_uuid}`)} >
                        Basic Information
                    </button>
                </>}
            </>}

            {/* <div className="toggle-expand-content" style={{ display: "block" }}>
            <ul className="nk-block-tools g-3">
                 <li className="nk-block-tools-opt">
                    <UncontrolledDropdown direction="right">
                          {aUser?.user_data?.id == tabItem.internal?.submitted_by && <>
                            <DropdownToggle className="dropdown-toggle btn btn-sm" color="secondary">Action</DropdownToggle>
                          </>}

                        <DropdownMenu>
                            <ul className="link-list-opt">

                                    {tabItem.internal?.show_form == 1 ? <>
                                        <li size="xs">
                                            <DropdownItem tag="a"  onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/application/${tabItem.internal?.application_uuid}`) } >
                                                <Icon name="eye"></Icon>
                                                <span>Continue Application</span>
                                            </DropdownItem>
                                        </li>
                                    </> : <>
                                        <li size="xs">
                                              <DropdownItem tag="a" onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/application_detail/${tabItem.internal?.application_uuid}`) } >
                                                <Icon name="eye"></Icon>
                                                <span>Application Detail</span>
                                            </DropdownItem>
                                        </li>
                                    </>}
                            </ul>
                            
                        </DropdownMenu>
                    </UncontrolledDropdown>
                </li>
            </ul>
        </div> */}

        </>

    );
};

const AuthRepTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState, positions, countries, roles, authorizers, pending }) => {
    const authRepColumn = [
        {
            name: "SN",
            selector: (row, index) => ++index,
            sortable: true,
            width: "100px",
            wrap: true
        },
        {
            name: "Type",
            selector: (row) => { return (<><span className="text-uppercase">{`${row?.internal?.application_type.toUpperCase()}`}</span></>) },
            sortable: true,
            width: "auto",
            wrap: true
        },
        // {
        //     name: "Overall Status",
        //     selector: (row) => { return (<><span className="text-uppercase">{`${row?.internal?.application_type_status.toUpperCase()}`}</span></>) },
        //     sortable: true,
        //     width: "auto",
        //     wrap: true
        // },
        // {
        //     name: "Next Office",
        //     selector: (row) => { return (<><span  className="text-uppercase">{`${row?.internal?.office_to_perform_next_action.toUpperCase()}`}</span></>) },
        //     sortable: true,
        //     width: "auto",
        //     wrap: true
        // },
        {
            name: "Category",
            selector: (row) => (`${row?.internal?.category_name}`),
            sortable: true,
            width: "auto",
            wrap: true
        },
        // {
        //     name: "Role",
        //     selector: (row) => { return (<><Badge color="success">{`${row.role}`}</Badge></>) },
        //     sortable: true,
        //     width: "auto",
        //     wrap: true
        // },
        {
            name: "Status",
            selector: (row) => { return (<><Badge color="success" className="text-uppercase">{`${row?.internal?.status_description}`}</Badge></>) },
            sortable: true,
            width: "auto",
        },
        {
            name: "Sign-on Date",
            selector: (row) => moment(row?.internal?.createdAt).format('MMM. D, YYYY HH:mm'),
            sortable: true,
            width: "auto",
            wrap: true
        },
        {
            name: "Action",
            selector: (row) => (<>
                <ActionTab tabItem={row} updateParent4={updateParent} />
            </>),
            width: "auto",
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
                columns={authRepColumn}
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
    // } else {

    //     return (
    //             <>
    //                 <Skeleton count={20} height={30}  style={{display: 'block',lineHeight: 2, padding: '1rem',width: 'auto',}}/>
    //             </>

    //         )
    // }
    // };

    //   return (
    //           <Countdown
    //             date={Date.now() + 5000}
    //             renderer={renderer}
    //         />


    //     );



};

export default AuthRepTable;
