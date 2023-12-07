import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { Col, Modal, ModalBody, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem } from "reactstrap";
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

const ExpandableRowComponent = ({ data }) => {
  return (
    <ul className="dtr-details p-2 border-bottom ms-1">
      <li className="d-block d-sm-none">
        <span className="dtr-title">Company</span> <span className="dtr-data">{data.company}</span>
      </li>
      <li className="d-block d-sm-none">
        <span className="dtr-title ">Gender</span> <span className="dtr-data">{data.gender}</span>
      </li>
      <li>
        <span className="dtr-title">Start Date</span> <span className="dtr-data">{data.startDate}</span>
      </li>
      <li>
        <span className="dtr-title">Salary</span> <span className="dtr-data">{data.salary}</span>
      </li>
    </ul>
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

const DropdownExample = () => {
  // const [isOpen, setIsOpen] = useState(false);
  
  // const toggle = () => {setIsOpen(!isOpen)};
  const [isDropdownVisible, setDropdownVisible] = useState(false);

  const handleButtonClick = () => {
    setDropdownVisible(!isDropdownVisible);
    console.log(isDropdownVisible)
  };
  const styles = {
    dropdownContainer: {
      position: "relative",
      display: "inline-block",
      // height: "300px"
    },
    
    dropdownContent: {
      display: "block",
      position: "absolute",
      top: "70%",
      left: "0",
      height: "300px",
      width: "300px",
      backgroundColor: "red",
      border: "1px solid #ccc",
      boxShadow: "0 8px 16px rgba(0, 0, 0, 0.2)",
      padding: "8px",
      zIndex: "1000"
    }
    
  }
  return (
    // <Dropdown isOpen={true} toggle={toggle}>
    //   <DropdownToggle className="btn-action" color="primary">
    //     <span>Dropdown Button</span>
    //   </DropdownToggle>
    //   <DropdownMenu>
    //     <ul className="link-list-opt">
    //       <li>
    //         <DropdownItem
    //           tag="a"
    //           href="#links"
    //           onClick={(ev) => ev.preventDefault()}
    //         >
    //           <span>Profile Settings</span>
    //         </DropdownItem>
    //       </li>
    //       <li>
    //         <DropdownItem
    //           tag="a"
    //           href="#links"
    //           onClick={(ev) => ev.preventDefault()}
    //         >
    //           <span>Notifications</span>
    //         </DropdownItem>
    //       </li>
    //       <li>
    //         <DropdownItem
    //           tag="a"
    //           href="#links"
    //           onClick={(ev) => ev.preventDefault()}
    //         >
    //           <span>Another Action</span>
    //         </DropdownItem>
    //       </li>
    //       <li>
    //         <DropdownItem
    //           tag="a"
    //           href="#links"
    //           onClick={(ev) => ev.preventDefault()}
    //         >
    //           <span>Something else here</span>
    //         </DropdownItem>
    //       </li>
    //     </ul>
    //   </DropdownMenu>
    // </Dropdown>
    // <div style={styles.dropdownContainer}>
    //   <button onClick={handleButtonClick}>Toggle Dropdown</button>
    //   {isDropdownVisible && 
    //   <div  style={styles.dropdownContent}>
    //       <p>Item 1</p>
    //       <p>Item 2</p>
    //       <p>Item 3</p>
    //   </div>}
    // </div>
    <select
      name="action"
      className="custom-select custom-select-sm form-control form-control-sm"
      onChange={(e) => e.preventDefault()} value={'Action'}
        >
          <option value="Action">Action</option>
          <option value="View" onClick={(ev) => ev.preventDefault()}>View</option>
          <option value="Edit" onClick={(ev) => ev.preventDefault()}>Edit</option>
          <option value="Delete" onClick={(ev) => ev.preventDefault()}>Delete</option>
        </select>
  )
}

const DropdownTrans = () => {
    return (
                <UncontrolledDropdown direction="right">
                  <div className="btn-group">
                    <Button color="secondary">Action</Button>
                    <DropdownToggle className="dropdown-toggle-split" color="secondary">
                      <Icon name="chevron-right"></Icon>
                    </DropdownToggle>
                  </div>
                  <DropdownMenu>
                    <ul className="link-list-opt">
                      <li>
                        <DropdownItem tag="a" href="#links" onClick={(ev) => ev.preventDefault()}>
                          <span>Profile Settings</span>
                        </DropdownItem>
                      </li>
                      <li>
                        <DropdownItem tag="a" href="#links" onClick={(ev) => ev.preventDefault()}>
                          <span>Notifications</span>
                        </DropdownItem>
                      </li>
                      <li>
                        <DropdownItem tag="a" href="#links" onClick={(ev) => ev.preventDefault()}>
                          <span>Another Action</span>
                        </DropdownItem>
                      </li>
                      <li>
                        <DropdownItem tag="a" href="#links" onClick={(ev) => ev.preventDefault()}>
                          <span>Something else here</span>
                        </DropdownItem>
                      </li>
                    </ul>
                  </DropdownMenu>
                </UncontrolledDropdown>

    );
  };

const complainColumn = [
      {
        name: "Ticket ID",
        selector: (row) => row.id,
        sortable: true,
      },
      {
        name: "Body",
        selector: (row) => row.body,
        sortable: true,
        hide: 370,
      },
      {
        name: "Status",
        selector: (row) => row.status,
        sortable: true,
        hide: "sm",
      },
      {
        name: "Date Created",
        selector: (row) => moment(row.createdAt).format('MMM. DD, YYYY HH:mm'),
        sortable: true,
        hide: "md",
      },
      {
        name: "Action",
        selector: (row) => (<DropdownExample/>),
        sortable: true,
        hide: "md",
      },
  ];

const ComplaintTableUser = ({ data, pagination, actions, className, selectableRows, expandableRows }) => {
  const [tableData, setTableData] = useState(data);
  const [searchText, setSearchText] = useState("");
  const [rowsPerPageS, setRowsPerPage] = useState(10);
  const [mobileView, setMobileView] = useState();

  useEffect(() => {
    let defaultData = tableData;
    if (searchText !== "") {
      defaultData = data.filter((item) => {
        return item.name.toLowerCase().includes(searchText.toLowerCase());
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
        className={className}
        selectableRows={selectableRows}
        selectableRowsComponent={CustomCheckbox}
        expandableRowsComponent={ExpandableRowComponent}
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

export default ComplaintTableUser;
