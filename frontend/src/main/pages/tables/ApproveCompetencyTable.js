import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import exportFromJSON from "export-from-json";
import { useDispatch } from "react-redux";
import CopyToClipboard from "react-copy-to-clipboard";
import { Col, Modal, ModalBody, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, ModalHeader, ModalFooter } from "reactstrap";
import { DataTablePagination } from "components/Component";
import { updateCCOStatusCompetency } from "redux/stores/competency/competencyStore";
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
      "TID": ++index,
      "Competency": `${item.framework.description}`,
      "AR Detail": item.ar.email,
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



const ActionTab = (props) => {
  const tabItem = props.complaint

  const updateParentParent = props.updateParentParent

  const tabItem_id = tabItem.id
  const [modalForm, setModalForm] = useState(false);

  const dispatch = useDispatch()
  const toggleForm = () => setModalForm(!modalForm);

  const askAction = async (action) => {

    if (action == 'open') {
      Swal.fire({
        title: "Are you sure?",
        text: "Do you want to approve this Competency Response!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, approve it!",
      }).then((result) => {

        if (result.isConfirmed) {

          const formData = new FormData();
          formData.append('competency_id', tabItem_id);
          formData.append('action', 'activate');
          formData.append('status', 'approved');
          const resp = dispatch(updateCCOStatusCompetency(formData));
          updateParentParent(Math.random())


        }
      });
    }

    if (action === 'close') {
      Swal.fire({
        title: "Are you sure?",
        text: "Do you want to reject this Competency Response!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, reject it!",
        html: '<label htmlFor="rejectReason">Reason for Reject</label><textarea id="rejectReason" className="form-control" rows="4" cols="50" placeholder="Enter rejection reason"></textarea>', // Add textarea to the alert
      }).then((result) => {
        if (result.isConfirmed) {
          const rejectReason = document.getElementById('rejectReason').value; // Get value from the textarea
          const formData = new FormData();
          formData.append('competency_id', tabItem_id);
          formData.append('action', 'deactivate');
          formData.append('status', 'rejected');
          formData.append('reason', rejectReason); // Append the rejection reason
          const resp = dispatch(updateCCOStatusCompetency(formData));
          updateParentParent(Math.random());
        }
      });
    }
  

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
                      <span>View</span>
                    </DropdownItem>
                  </li>
                  {(tabItem.status == 'pending') ? <>
                    <li size="xs">
                      <DropdownItem tag="a" onClick={(e) => askAction('open')} >
                        <Icon name="eye"></Icon>
                        <span>Approve</span>
                      </DropdownItem>
                    </li>
                    <li size="xs">
                      <DropdownItem tag="a" onClick={(e) => askAction('close')} >
                        <Icon name="eye"></Icon>
                        <span>Reject</span>
                      </DropdownItem>
                    </li>
                  </> : ""
                  }

                </ul>
              </DropdownMenu>
            </UncontrolledDropdown>
          </li>

        </ul>
      </div>
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
      name: "ID",
      selector: (row, index) => ++index,
      sortable: true,
      width: "80px",
    },
    {
      name: "Competency",
      selector: (row) => { return (<><p>{`${row.framework.name} `}<br />{`${row.framework.description}`}</p></>) },
      sortable: true,
      width: "auto",
      wrap: true
    },
    {
      name: "AR Detail",
      selector: (row) => { return (<><p>{`${row.ar.first_name} ${row.ar.last_name}`}<br />{`${row.ar.email}`}</p></>) },
      sortable: true,
      width: "auto",
      wrap: true
    },
    {
      name: "Status",
      selector: (row) => { return (<><Badge color={row.status == 'approved' ? 'success' : 'gray'}>{row.status == 'approved' ? 'Approved' : 'Pending'}</Badge></>) },
      sortable: true,
      width: "150px",
    },
    {
      name: "Response",
      selector: (row) => { return (<><Badge color={row.is_competent ? 'success' : 'gray'}>{row.is_competent ? 'YES' : 'NO'}</Badge></>) },
      sortable: true,
      width: "150px",
    },
    {
      name: "Evidence",
      selector: (row) => { return row.evidence ? (<><a href={row.evidence_file} target="_blank" className="btn btn-secondary">View</a></>) : "" },
      sortable: true,
      width: "150px",
    },
    {
      name: "Date Created",
      selector: (row) => moment(row.createdAt).format('MMM. D, YYYY HH:mm'),
      sortable: true,
      width: "150px",
    },
    {
      name: "Action",
      selector: (row) => (<> <ActionTab complaint={row} updateParentParent={updateParent} /></>),
      sortable: true,
      width: "150px",
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
