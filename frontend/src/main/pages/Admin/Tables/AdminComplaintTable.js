import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { useForm } from "react-hook-form";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge,  Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
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



const DropdownTrans = () => {
  
  const [modalForm, setModalForm] = useState(false);

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();
  const toggleForm = () => setModalForm(!modalForm);
    const [loading, setLoading] = useState(false);
        
    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('complaint_type', values.complaint_type)
        formData.append('body', values.body)
        formData.append('document', complainFile)
        
        try {
            setLoading(true);
            
            const resp = await dispatch(sendComplaint(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                  setLoading(false);
                  setModalForm(!modalForm)
                  resetField('complaint_type')
                  resetField('body')
                  resetField('document')
                  setCounter(!counter)
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
    // <UncontrolledDropdown direction="right">
    //   <DropdownToggle className="dropdown-toggle btn" color="secondary">Action</DropdownToggle>

    //   <DropdownMenu>
    //     <ul className="link-list-opt">
    //       <li>
    //         <DropdownItem tag="a" href="#links" onClick={(ev) => ev.preventDefault()}>
    //           <Icon name="pen"></Icon>
    //           <span>Send feedback</span>
    //         </DropdownItem>
    //       </li>
    //       <li>
    //         <DropdownItem tag="a" href="#links" onClick={(ev) => ev.preventDefault()}>
    //           <Icon name="eye"></Icon>
    //           <span>View Document</span>
    //         </DropdownItem>
    //       </li>
    //       <li>
    //         <DropdownItem tag="a" href="#links" onClick={(ev) => ev.preventDefault()}>
    //           <Icon name="trash"></Icon>
    //           <span>Close</span>
    //         </DropdownItem>
    //       </li>
    //     </ul>
    //   </DropdownMenu>
    // </UncontrolledDropdown>
    <>
      <div className="toggle-expand-content" style={{ display: "block" }}>
          <ul className="nk-block-tools g-3">
              <li className="nk-block-tools-opt">
                  <Button color="primary">
                      <span onClick={toggleForm}>Add feedback</span>
                  </Button>
              </li>
          </ul>
    </div>
      <Modal isOpen={modalForm} toggle={toggleForm}>
          <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
              Fill Feedback Form
          </ModalHeader>
          <ModalBody>
              <form  onSubmit={handleSubmit(handleFormSubmit)}  className="is-alter" encType="multipart/form-data">
                  <div className="form-group">
                      <label className="form-label" htmlFor="full-name">
                          Complaint Type
                      </label>
                      <div className="form-control-wrap">
                          <div className="form-control-select">
                              <select className="form-control form-select" {...register('status', { required: "Type is Required" })}>
                              <option value="">Select Type</option>
                              <option value="ONGOING">Ongoing</option>
                              <option value="CLOSED">Closed</option>
                              </select>
                              {errors.status && <p className="invalid">{`${errors.status.message}`}</p>}
                          </div>
                      </div>
                  </div>
                  <div className="form-group">
                      <label className="form-label" htmlFor="email">
                          Complain
                      </label>
                      <div className="form-control-wrap">
                          <textarea type="text" className="form-control" {...register('body', { required: "Body is Required" })}></textarea>
                            {errors.body && <p className="invalid">{`${errors.body.message}`}</p>}
                      </div>
                  </div>
                  <div className="form-group">
                      <Button color="primary" type="submit"  size="lg">
                          {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : "Send Feedback"}
                      </Button>
                  </div>
              </form>
          </ModalBody>
          <ModalFooter className="bg-light">
              <span className="sub-text">Complaint</span>
          </ModalFooter>
      </Modal> 
    </>


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
    selector: (row) => { return (<><Badge color="success">{`${row.status}`}</Badge></>) },
    sortable: true,
    hide: "sm",
  },
  {
    name: "Comments",
    selector: (row) => { return (<><Badge color="gray">{`${row.comment.length} Comments`}</Badge></>) },
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
    selector: (row) => (<> <DropdownTrans /></>),
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
};

export default ComplaintTableUser;
