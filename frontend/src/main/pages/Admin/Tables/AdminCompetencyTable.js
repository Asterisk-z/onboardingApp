import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import { useNavigate } from "react-router-dom";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { useForm } from "react-hook-form";
import { useDispatch } from "react-redux";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge,  Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { DataTablePagination } from "components/Component";
import { updateMembershipCategoryStatus, updateMembershipCategory, mapToPositions, unlinkFromPositions } from "redux/stores/memberCategory/category";
import { updateCompetency, updateStatusCompetency } from "redux/stores/competency/competencyStore";
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
            "Name": `${item.name}`,
            "Description": item.description,
            "Category": item.category_obj.name,
            "Position": item.position_obj.name,
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


const ActionTab = ({ updateParentParent, tabItem, positions, categories}) => {
    const tabItem_id = tabItem.id
    const [modalForm, setModalForm] = useState(false);
    const navigate = useNavigate();

    const toggleForm = () => setModalForm(!modalForm);
    
    const dispatch = useDispatch();
    const { register, handleSubmit, formState: { errors }, resetField } = useForm();
    const [loading, setLoading] = useState(false);
    
    const [formData, setFormData] = useState({
        name: tabItem.name ,
        description: tabItem.description ,
        position: tabItem.position ,
        member_category: tabItem.member_category ,
    });
    const handleFormSubmit = async (values) => {

        const formData = new FormData();
        formData.append('competency_id', tabItem_id)
        formData.append('name', values.name)
        formData.append('description', values.description)
        formData.append('position', values.position)
        formData.append('member_category', values.member_category)
        
        try {
            setLoading(true);
            
            const resp = await dispatch(updateCompetency(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    updateParentParent(Math.random())
                }, 1000);
            
            } else {
              setLoading(false);
            }
            
      } catch (error) {
        setLoading(false);
      }
    }; 

          
    const askAction = async (action) => {

      if(action == 'open') {
          Swal.fire({
              title: "Are you sure?",
              text: "Do you want to activate this Competency!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Yes, open it!",
          }).then((result) => {

            if (result.isConfirmed) {
                  
                  const formData = new FormData();
                  formData.append('competency_id', tabItem_id);
                  formData.append('action', 'activate');
                  const resp = dispatch(updateStatusCompetency(formData));
                  updateParentParent(Math.random())
                  
                  
              }
          });
      }
      
      if(action == 'close') {
          Swal.fire({
              title: "Are you sure?",
              text: "Do you want to deactivate this Competency!",
              icon: "warning",
              showCancelButton: true,
              confirmButtonText: "Yes, close it!",
          }).then((result) => {

            if (result.isConfirmed) {
                  
                  const formData = new FormData();
                  formData.append('competency_id', tabItem_id);
                  formData.append('action', 'deactivate');
                  formData.append('reason', 'deactivate');
                  const resp = dispatch(updateStatusCompetency(formData));
                  updateParentParent(Math.random())
                
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
                                  <DropdownItem tag="a"  onClick={toggleForm} >
                                      <Icon name="eye"></Icon>
                                      <span>Edit</span>
                                  </DropdownItem>
                              </li>
                              <li size="xs">
                                  <DropdownItem tag="a"  onClick={(e) => navigate(`${process.env.PUBLIC_URL}/admin-competency-done/${tabItem_id}`)} >
                                      <Icon name="eye"></Icon>
                                      <span>View Compliant ARs</span>
                                  </DropdownItem>
                              </li>
                              <li size="xs">
                                  <DropdownItem tag="a"  onClick={(e) => navigate(`${process.env.PUBLIC_URL}/admin-competency-undone/${tabItem_id}`)} >
                                      <Icon name="eye"></Icon>
                                      <span>View Non-Compliant ARs</span>
                                  </DropdownItem>
                              </li>
                              {(!tabItem.active) ? <>
                              <li size="xs">
                                  <DropdownItem tag="a"  onClick={(e) => askAction('open')} >
                                      <Icon name="eye"></Icon>
                                      <span>Activate</span>
                                  </DropdownItem>
                              </li></> : <>
                              <li size="xs">
                                    <DropdownItem tag="a"  onClick={(e) => askAction('close')} >
                                        <Icon name="eye"></Icon>
                                        <span>Deactivate</span>
                                    </DropdownItem>
                                </li>
                              </>
                              }

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
                <form  onSubmit={handleSubmit(handleFormSubmit)}  className="is-alter" encType="multipart/form-data">
                    
                          <div className="form-group">
                              <label className="form-label" htmlFor="name">
                                  Name
                              </label>
                              <div className="form-control-wrap">
                                  <input type="text" id="name" className="form-control" {...register('name', { required: "This Field is required" })}  defaultValue={formData.name} />
                                  {errors.name && <span className="invalid">{ errors.name.message }</span>}
                              </div>
                          </div>
                          <div className="form-group">
                              <label className="form-label" htmlFor="description">
                                  Description
                              </label>
                              <div className="form-control-wrap">
                                  <textarea id="description" className="form-control" {...register('description', { required: "This Field is required" })} defaultValue={formData.description} ></textarea>
                                  {errors.description && <span className="invalid">{errors.description.message}</span>}
                              </div>
                          </div>
                          <div className="form-group">
                              <label className="form-label" htmlFor="member_category">
                                  Membership Category
                              </label>
                              <div className="form-control-wrap">
                                  <div className="form-control-select">
                                      <select className="form-control form-select" id="member_category"  style={{ color: "black !important" }} {...register('member_category', { required: "This Field is Required" })} defaultValue={formData.member_category} >
                                      <option value="">Select Membership Category</option>
                                      {categories && categories?.map((category) => (
                                          <option key={category.id} value={category.id}>
                                              {category.name}
                                          </option>
                                      ))}
                                      </select>
                                      {errors.member_category && <p className="invalid">{`${errors.member_category.message}`}</p>}
                                  </div>
                              </div>
                          </div>
                          <div className="form-group">
                              <label className="form-label" htmlFor="position">
                                  Position
                              </label>
                              <div className="form-control-wrap">
                                  <div className="form-control-select">
                                      <select className="form-control form-select" id="position" style={{ color: "black !important" }} {...register('position', { required: "THis Field is Required" })} defaultValue={formData.position} >
                                      <option value="">Select Position</option>
                                      {positions && positions?.map((position) => (
                                          <option key={position.id} value={position.id}>
                                              {position.name}
                                          </option>
                                      ))}
                                      </select>
                                      {errors.positions && <p className="invalid">{`${errors.positions.message}`}</p>}
                                  </div>
                              </div>
                          </div>
                    <div className="form-group">
                        <Button color="primary" type="submit"  size="lg">
                            {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : "Update Competency"}
                        </Button>
                    </div>
                </form>
            </ModalBody>
            <ModalFooter className="bg-light">
                <span className="sub-text">Update Competency</span>
            </ModalFooter>
        </Modal>
      </>


    );
};


const AdminCompetencyTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState, positions, categories}) => {
    const tableColumn = [
    {
        name: "ID",
        selector: (row, index) => ++index,
        sortable: true,
        width: "100px",
        wrap: true
    },
    {
        name: "Name",
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
        name: "Status",
        selector: (row) => {
                return (
                    <>
                        <Badge color={row.active ? "success" : "danger"}>{row.active ? 'Active' : 'Deactivated'} </Badge>
                    </>
                );
            },
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
        name: "Category",
        selector: (row) => row.category_obj.name,
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
        name: "Position",
        selector: (row) => row.position_obj.name,
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
        name: "Date Created",
        selector: (row) => moment(row.createdAt).format('MMM. D, YYYY HH:mm'),
        sortable: true,
        width: "auto",
        wrap: true
    },
    {
        name: "Action",
        selector: (row) => (<>
                        <ActionTab tabItem={row} updateParentParent={updateParent} positions={positions} categories={categories}/>
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

export default AdminCompetencyTable;
