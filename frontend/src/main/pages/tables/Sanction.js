import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { Col, Modal, ModalBody, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge,  ModalHeader,  ModalFooter } from "reactstrap";
import { DataTablePagination } from "components/Component";
import moment from "moment";
import Icon from "components/icon/Icon";

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
  
    const complaint = props.complaint
    const [modalForm, setModalForm] = useState(false);

    const toggleForm = () => setModalForm(!modalForm);
  
  return (
    <>
      <Button color="secondary"  className="btn"  onClick={toggleForm}> <Icon name="eye"></Icon> View</Button>
          <Modal isOpen={modalForm} toggle={toggleForm} size="xl">
            <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
                View
            </ModalHeader>
            <ModalBody className="modal-body-xl">
                <div className="nk-modal">
                    <h6 className="title">Complaint Type:</h6>
                    <p>
                        {complaint.complaint_type.name}
                    </p>
                    <h6 className="title">Complaint Description: </h6>
                    <p>
                        {complaint.body}
                    </p>
                    
                      {complaint.documment &&
                        <>
                          <a href={complaint.documment} target="_blank" className="btn btn-secondary">View Document</a>
                        </>}
                      
                        {complaint.comment.length > 0 && <><h6 className="title">Comment(s):</h6></> }
                        {complaint.comment.length > 0 && complaint.comment?.map((comment, index) => (<p key={index}>{comment.comment}<br />{ comment.commenter.first_name } <br />{ moment(comment.createdAt).format('MMM. DD, YYYY HH:mm') }</p>))}
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

const complainColumn = [
  {
    name: "TID",
    selector: (row) => row.id,
    sortable: true,
    width: "80px",
  },
  {
    name: "Description",
    selector: (row) => row.body,
    sortable: true,
    width: "auto",
    wrap: true
  },
  {
    name: "Status",
    selector: (row) => { return (<><Badge color="success">{`${row.status}`}</Badge></>) },
    sortable: true,
    width: "150px",
  },
  {
    name: "Comments",
    selector: (row) => { return (<><Badge color="gray">{`${row.comment.length} Comments`}</Badge></>) },
    sortable: true,
    width: "150px",
  },
  {
    name: "Date Created",
    selector: (row) => moment(row.createdAt).format('MMM. DD, YYYY HH:mm'),
    sortable: true,
    width: "150px",
  },
  {
    name: "Action",
    selector: (row) => (<> <DropdownTrans  complaint={row} /></>),
    sortable: true,
    width: "150px",
  },
];

const ComplaintTableUser = ({ data, pagination, actions, className, selectableRows, expandableRows }) => {
  const [tableData, setTableData] = useState(data);
  const [searchText, setSearchText] = useState("");
  const [rowsPerPageS, setRowsPerPage] = useState(10);
  const [mobileView, setMobileView] = useState();
  
  if (data != tableData) {
    setTableData(data)
  }
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
