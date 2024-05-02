import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import { useDispatch, useSelector } from "react-redux";
import { useForm } from "react-hook-form";
import { useNavigate } from "react-router-dom";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { Col, Modal, ModalBody, Row, Button, Dropdown,Card, CardTitle, CardBody, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, Spinner,  ModalHeader,  ModalFooter } from "reactstrap";
import { loadAllInvitedEvent, arEventRegistration } from "redux/stores/education/eventStore";
import { DataTablePagination } from "components/Component";
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
            "Description": `${item.body}`,
            "Status": item.status,
            "Comments": item.comment,
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



const ActionTab = ({ updateParentParent, tabItem }) => {
    const tabItem_id = tabItem.id
    const [modalForm, setModalForm] = useState(false);
    const [registerForm, setRegisterForm] = useState(false);

    const [complainFile, setComplainFile] = useState([]);
    const toggleForm = () => setModalForm(!modalForm);
    const toggleRegister = () => setRegisterForm(!modalForm);

    const dispatch = useDispatch();
    const { register, handleSubmit, formState: { errors }, resetField } = useForm();
    const [loading, setLoading] = useState(false);

    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        
        formData.append('event_id', tabItem_id)
        formData.append('evidence_of_payment_img', complainFile)

        try {
            setLoading(true);
            
            const resp = await dispatch(arEventRegistration(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('evidence_of_payment_img')
                }, 1000);
            } else {
              setLoading(false);
            }
            
      } catch (error) {
        setLoading(false);
      }

    }; 
    
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
                  {tabItem.admin_remark &&
                  <li size="xs">
                    <DropdownItem tag="a" onClick={toggleRegister}>
                      <Icon name="times"></Icon>
                      <span>Admin Remark</span>
                    </DropdownItem>
                  </li>} 
                  
                  {tabItem.user_remark &&
                  <li size="xs">
                    <DropdownItem tag="a" onClick={toggleRegister}>
                      <Icon name="times"></Icon>
                      <span>User Mark</span>
                    </DropdownItem>
                  </li>} 
                  

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
              <ul className="gy-3">
                <li className="text-capitalize"><span className="lead">Event : </span>{tabItem.name}</li>
                <li className="text-capitalize"><span className="lead">Decription : </span>{tabItem.description}</li>
                <li className="text-capitalize"><span className="lead">Date(s) : </span>{tabItem.date}<span className="text-capitalize"></span></li>
                <li className="text-capitalize"><span className="lead">Annual : </span>{(tabItem.is_annual == 1) ? 'Yes' : 'No'}<span className="text-capitalize"></span></li>
                <li className="text-capitalize"><span className="lead">Registration Fee : </span>{(tabItem.fee < 1) ? 'Free' : `${tabItem.fee}`}</li>
              </ul>
            </CardBody>
          </Card>
        </ModalBody>
      </Modal>
    
    </>

  );
};


const EducationTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, registered }) => {

    
const EducationColumn = [
    {
    name: "ID",
    selector: (row, index) => ++index,
    sortable: true,
    width: "80px",
    },
    {
    name: "Event Name",
    selector: (row) => row.event.name,
    sortable: true,
    width: "auto",
    wrap: true
    },
    {
    name: "Description",
    selector: (row) => row.event.description,
    sortable: true,
    width: "auto",
    wrap: true
    },
    {
        name: "Status",
        selector: (row) => { return (<><Badge color={(row.status == 'Registered') ? 'success' : 'gray'}>{row.status}</Badge></>) },
        sortable: true,
        width: "auto",
        wrap: true
    },
  {
    name: "Evidence",
    selector: (row) => { return row.evidence_of_payment_url ? (<><a href={row.evidence_of_payment_url}  target="_blank"  className="btn btn-success btn-sm">{`View`}</a></>) : (<><Badge color="warning">{`No evidence`}</Badge></>) },
    sortable: true,
    width: "auto",
    wrap: true
  },
    {
    name: "Date",
    selector: (row) => moment(row.event.date).format('MMM. D, YYYY HH:mm'),
    sortable: true,
    width: "auto",
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
        selector: (row) => (row.event.fee < 1) ? 'Free' : `${row.event.fee}`,
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
    name: "Date Created",
    selector: (row) => moment(row.createdAt).format('MMM. D, YYYY HH:mm'),
    sortable: true,
    width: "150px",
    },
  {
    name: "Action",
      selector: (row) => (<>
          <ActionTab tabItem={row} />
      </>),
    sortable: true,
    width: "150px",
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
                        columns={EducationColumn}
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

export default EducationTable;
