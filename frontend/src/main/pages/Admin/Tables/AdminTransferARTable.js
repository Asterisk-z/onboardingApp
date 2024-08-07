import React, { useEffect, useState } from "react";
import { useNavigate } from "react-router-dom";
import { useDispatch } from "react-redux";
import DataTable from "react-data-table-component";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import Icon from "components/icon/Icon";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, CardBody, CardTitle } from "reactstrap";
import { DataTablePagination } from "components/Component";
import moment from "moment";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import { megProcessTransferUserAR } from "redux/stores/authorize/representative";
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
      "Institution": `${item.new_institution.category[0].name}`,
      "Email": item.ar.email,
      "Status": item.approval_status,
      "Role": item.ar.role.name,
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

const ActionTab = (props) => {

  const aUser = useUser();
  const aUserUpdate = useUserUpdate();

  const record = props.data
  const institution = record.new_institution
  const ar_user = record.ar
  const requester = record.requester
  const approver = record.approver
  const navigate = useNavigate();
  const [modalForm, setModalForm] = useState(false);
  const [modalView, setModalView] = useState(false);
  const [modalViewUpdate, setModalViewUpdate] = useState(false);

  const toggleForm = () => setModalForm(!modalForm);
  const toggleView = () => setModalView(!modalView);
  const toggleViewUpdate = () => setModalViewUpdate(!modalViewUpdate);

  const dispatch = useDispatch();


  const askAction = async (action) => {
    if (action == 'approve') {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, approve it!",
      }).then((result) => {
        if (result.isConfirmed) {

          const formData = new FormData();
          formData.append('user_id', record.id);
          formData.append('action', 'approve');
          const resp = dispatch(megProcessTransferUserAR(formData));

          // if (resp.payload?.message == "success") {
          setTimeout(() => {
            props.updateParentParent(Math.random())
            setModalViewUpdate(false)
          }, 1000);

          // }
        }
      });
    }

    if (action == 'decline') {
      Swal.fire({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, reject it!",
      }).then((result) => {
        if (result.isConfirmed) {

          const formData = new FormData();
          formData.append('user_id', record.id);
          formData.append('action', 'decline');
          const resp = dispatch(megProcessTransferUserAR(formData));

          // if (resp.payload?.message == "success") {
          setTimeout(() => {
            props.updateParentParent(Math.random())
            setModalViewUpdate(false)
          }, 1000);

          // }
        }
      });
    }


  };

  return (
    <>
      <div className="toggle-expand-content" style={{ display: "block" }}>
        <ul className="nk-block-tools g-3">
          {(aUser.is_admin_meg()) &&
            <>
              <li className="nk-block-tools-opt">
                <UncontrolledDropdown direction="right">
                  <DropdownToggle className="dropdown-toggle btn btn-md" color="secondary">MEG Review</DropdownToggle>

                  <DropdownMenu>
                    <ul className="link-list-opt">



                      <li size="xs">
                        <DropdownItem tag="a" onClick={toggleViewUpdate} >
                          <Icon name="eye"></Icon>
                          <span>Authorised Representative Review</span>
                        </DropdownItem>
                      </li>


                    </ul>
                  </DropdownMenu>
                </UncontrolledDropdown>
              </li>


            </>
          }
        </ul>
      </div>


      <Modal isOpen={modalViewUpdate} toggle={toggleViewUpdate} size="lg">
        <ModalHeader toggle={toggleViewUpdate} close={<button className="close" onClick={toggleViewUpdate}><Icon name="cross" /></button>}>
          Transfer Review
        </ModalHeader>
        <ModalBody>

          <Card className="card">
            <CardBody className="card-inner">
              {/* <CardTitle tag="h5">{`View User`}</CardTitle> */}
              {/* <CardText> */}

              <CardTitle tag="h5" className="text-center">
                <img src={ar_user.img} className="rounded-xl" style={{ height: '200px', width: '200px', borderRadius: '100%' }} />
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
                    <td className="text-capitalize">{`${ar_user.firstName}`}</td>
                  </tr>
                  <tr>
                    <td>Last Name</td>
                    <td className="text-capitalize">{`${ar_user.lastName}`}</td>
                  </tr>
                  <tr>
                    <td>Email</td>
                    <td className="text-capitalize">{`${ar_user.email}`}</td>
                  </tr>
                  <tr>
                    <td>Phone</td>
                    <td className="text-capitalize">{`${ar_user.phone}`}</td>
                  </tr>
                  <tr>
                    <td>Nationality</td>
                    <td className="text-capitalize">{`${ar_user.nationality.toLowerCase()}`}</td>
                  </tr>
                  <tr>
                    <td>Role</td>
                    <td className="text-capitalize">{`${ar_user.role.name ? ar_user.role.name.split(' ')[0] + ' ' + ar_user.role.name.split(' ')[1].toLowerCase() : ''}`}</td>
                  </tr>
                  <tr>
                    <td>Position</td>
                    <td className="text-capitalize">{`${ar_user.position.name.toLowerCase()}`}</td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td className="text-capitalize">{`${ar_user.approval_status.toLowerCase()}`}</td>
                  </tr>
                  <tr>
                    <td>RegID</td>
                    <td className="text-capitalize">{`${ar_user.regId}`}</td>
                  </tr>
                  <tr>
                    <td>Institution</td>
                    <td className="text-capitalize">{`${ar_user.institution?.name?.toLowerCase()}`}</td>
                  </tr>
                  <tr>
                    <td>Signature Mandate</td>
                    <td>{ar_user.mandate_form ? (
                      <a size="lg" href={ar_user.mandate_form} target="_blank" className="btn-primary">
                        <Button color="primary">
                          <span >{"View Mandate"}</span>
                        </Button>
                      </a>
                    ) : `Not Uploaded`}</td>
                  </tr>
                  <tr>
                    <td>Requester</td>
                    <td className="text-capitalize">{`${requester.firstName} ${requester.lastName} (${requester.email})`}</td>
                  </tr>
                  <tr>
                    <td>Approver</td>
                    <td className="text-capitalize">{`${approver.firstName} ${approver.lastName} (${approver.email})`}</td>
                  </tr>
                  <tr>
                    <td>Authoriser Transfer Status</td>
                    <td className="text-capitalize">{`${record.approval_status}`}</td>
                  </tr>

                </tbody>
              </table>
              {(aUser.is_admin_meg() && record?.approval_status == 'approved' && record?.mbg_approval_status == 'pending') &&
                <>
                  <div className="float-end">
                    <button className="btn  btn-primary  m-2" onClick={(e) => askAction('approve')}>Approve</button>
                    <button className="btn  btn-secondary  m-2" onClick={(e) => askAction('decline')} >Reject</button>
                  </div>
                </>
              }
            </CardBody>
          </Card>
        </ModalBody>
        <ModalFooter className="bg-light">
          <span className="sub-text">View Institutions</span>
        </ModalFooter>
      </Modal>
    </>


  );
};

const AdminListARTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState }) => {
  const complainColumn = [
    {
      name: "SN",
      selector: (row, index) => ++index,
      sortable: true,
      width: "150px",
      wrap: true,
    },
    {
      name: "Institution",
      selector: (row) => (`${row.new_institution.category[0].name}`),
      sortable: true,
      width: "auto",
      wrap: true,
    },
    {
      name: "Email",
      selector: (row) => (`${row.ar.email}`),
      sortable: true,
      width: "auto",
      wrap: true,
    },
    {
      name: "Status",
      selector: (row) => { return (<><Badge color="success" className="text-uppercase">{`${row.approval_status}`}</Badge></>) },
      sortable: true,
      width: "auto",
      wrap: true,
    },
    {
      name: "MEG Status",
      selector: (row) => { return (<><Badge color="success" className="text-uppercase">{`${row.mbg_approval_status}`}</Badge></>) },
      sortable: true,
      width: "auto",
      wrap: true,
    },
    {
      name: "Role",
      selector: (row) => { return (<><Badge color="success">{`${row.ar.role.name}`}</Badge></>) },
      sortable: true,
      width: "auto",
      wrap: true,
    },
    {
      name: "Sign-on Date",
      selector: (row) => moment(row.createdAt).format('MMM. D, YYYY HH:mm'),
      sortable: true,
      width: "auto",
      wrap: true,
    },
    {
      name: "Action",
      selector: (row) => (<>
        <ActionTab data={row} updateParentParent={updateParent} />
      </>),
      width: "18%",
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

export default AdminListARTable;
