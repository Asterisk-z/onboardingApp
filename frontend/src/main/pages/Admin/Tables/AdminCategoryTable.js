import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import { useForm } from "react-hook-form";
import { useDispatch } from "react-redux";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { DataTablePagination } from "components/Component";
import { updateMembershipCategoryStatus, updateMembershipCategory, mapToPositions, unlinkFromPositions } from "redux/stores/memberCategory/category";
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
      "CDID ID": ++index,
      "Code": `${item.code}`,
      "Name": item.name,
      "Positions": item.positions.map((position) => position.name).toString(),
      "Status": item.active,
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
            <Button className="buttons-copy buttons-html5" title="Copy To Clipboard" onClick={() => copyToClipboard()}>
              <span>Copy</span>
            </Button>
          </CopyToClipboard>{" "}
          <button className="btn btn-secondary buttons-csv buttons-html5" title="Export To CSV" type="button" onClick={() => exportCSV()}>
            <span>CSV</span>
          </button>{" "}
          <button className="btn btn-secondary buttons-excel buttons-html5" title="Export To Excel" type="button" onClick={() => exportExcel()}>
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


const ActionTab = ({ updateParentParent, tabItem, positions }) => {
  const tabItem_id = tabItem.id
  const [modalForm, setModalForm] = useState(false);
  const [modalPositionForm, setModalPositionForm] = useState(false);
  const [modalUnlinkPositionForm, setModalUnlinkPositionForm] = useState(false);

  const toggleForm = () => setModalForm(!modalForm);
  const togglePositionForm = () => setModalPositionForm(!modalPositionForm);
  const toggleUnlinkPositionForm = () => setModalUnlinkPositionForm(!modalUnlinkPositionForm);

  const dispatch = useDispatch();
  const { register, handleSubmit, formState: { errors }, resetField } = useForm();
  const [loading, setLoading] = useState(false);

  const [formData, setFormData] = useState({
    code: tabItem.code,
    name: tabItem.name,
  });
  const handleFormSubmit = async (values) => {

    const formData = new FormData();
    formData.append('category_id', tabItem_id)
    formData.append('name', values.name)

    try {
      setLoading(true);

      const resp = await dispatch(updateMembershipCategory(formData));

      if (resp.payload?.message == "success") {
        setTimeout(() => {
          setLoading(false);
          setModalForm(!modalForm)
          resetField('name')
          resetField('code')
          updateParentParent(Math.random())
        }, 1000);

      } else {
        setLoading(false);
      }

    } catch (error) {
      setLoading(false);
    }
  };

  const closeModel = () => {
    setModalPositionForm(false)
    setModalUnlinkPositionForm(false)
  }


  const askAction = async (action) => {

    if (action == 'open') {
      Swal.fire({
        title: "Are you sure?",
        text: "Do you want to activate this category!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, open it!",
      }).then((result) => {

        if (result.isConfirmed) {

          const formData = new FormData();
          formData.append('category_id', tabItem_id);
          formData.append('action', 'activate');
          const resp = dispatch(updateMembershipCategoryStatus(formData));

          updateParentParent(Math.random())


        }
      });
    }

    if (action == 'close') {
      Swal.fire({
        title: "Are you sure?",
        text: "Do you want to deactivate this category!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, close it!",
      }).then((result) => {

        if (result.isConfirmed) {

          const formData = new FormData();
          formData.append('category_id', tabItem_id);
          formData.append('action', 'deactivate');
          const resp = dispatch(updateMembershipCategoryStatus(formData));
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
                    <DropdownItem tag="a" onClick={toggleForm} >
                      <Icon name="eye"></Icon>
                      <span>Edit</span>
                    </DropdownItem>
                  </li>
                  <li size="xs">
                    <DropdownItem tag="a" onClick={togglePositionForm} >
                      <Icon name="eye"></Icon>
                      <span>Add Positions</span>
                    </DropdownItem>
                  </li>
                  <li size="xs">
                    <DropdownItem tag="a" onClick={toggleUnlinkPositionForm} >
                      <Icon name="eye"></Icon>
                      <span>Unlink Positions</span>
                    </DropdownItem>
                  </li>
                  {(!tabItem.active) ? <>
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
          <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
            <div className="form-group">
              <label className="form-label" htmlFor="code">
                Code
              </label>
              <div className="form-control-wrap">
                <input type="text" id="code" className="form-control" {...register('code', { required: "This Field is required" })} defaultValue={formData.code} />
                {errors.code && <span className="invalid">{errors.code.message}</span>}
              </div>
            </div>
            <div className="form-group">
              <label className="form-label" htmlFor="full-name">
                Name
              </label>
              <div className="form-control-wrap">
                <input type="text" id="name" className="form-control" {...register('name', { required: "This Field is required" })} defaultValue={formData.name} />
                {errors.name && <span className="invalid">{errors.name.message}</span>}
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
          <span className="sub-text">Update Category</span>
        </ModalFooter>
      </Modal>
      <Modal isOpen={modalPositionForm} toggle={togglePositionForm} size="xl" >
        <ModalHeader toggle={togglePositionForm} close={<button className="close" onClick={togglePositionForm}><Icon name="cross" /></button>}>
          Add Position
        </ModalHeader>
        <ModalBody>

          <h6 className="title">Linked Position:</h6>

          <>
            {tabItem.positions.map((position, index) => (
              <p className="zeroMarginBottom" key={index}>{position.name}</p>
            ))}
          </>
          <LinkPositions tabItem={tabItem} updateParentParent={updateParentParent} positions={positions} closeModel={closeModel} />
        </ModalBody>
        <ModalFooter className="bg-light">
          <span className="sub-text">Category</span>
        </ModalFooter>
      </Modal>
      <Modal isOpen={modalUnlinkPositionForm} toggle={toggleUnlinkPositionForm} size="xl" >
        <ModalHeader toggle={toggleUnlinkPositionForm} close={<button className="close" onClick={toggleUnlinkPositionForm}><Icon name="cross" /></button>}>
          Unlink Position
        </ModalHeader>
        <ModalBody>
          <UnLinkPositions tabItem={tabItem} updateParentParent={updateParentParent} positions={positions} closeModel={closeModel} />
        </ModalBody>
        <ModalFooter className="bg-light">
          <span className="sub-text">Category</span>
        </ModalFooter>
      </Modal>
    </>


  );
};

const LinkPositions = ({ updateParentParent, tabItem, positions, closeModel }) => {
  const tabItem_id = tabItem.id
  const [positionIds, setPositionIds] = useState([]);
  const [loading, setLoading] = useState(false);
  const dispatch = useDispatch();

  const { handleSubmit, register, watch, formState: { errors } } = useForm();

  const submitForm = async (data) => {
    const clickedIds = Object.keys(positionIds)
    const valuesIds = Object.values(positionIds)
    const checkedId = clickedIds.filter((check, index) => valuesIds[index]);

    const postValues = new Object();
    postValues.category = tabItem_id;
    postValues.position = checkedId;

    try {
      setLoading(true);

      const resp = await dispatch(mapToPositions(postValues));

      if (resp.payload?.message == "success") {
        setTimeout(() => {
          setLoading(false);
          updateParentParent(Math.random())
          closeModel()
        }, 1000);

      } else {
        setLoading(false);
      }

    } catch (error) {
      setLoading(false);
    }

  };


  const checkItem = (event) => {
    const ids = positionIds;
    ids[event.target.value] = event.target.checked
  };
  // console.log(positions, tabItem.positions)

  return (
    <>
      {(positions.length > tabItem.positions.length) ? <>
        <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
          <Row className="gy-4">
            <Col md="12">
              <div className="form-group">
                <label className="form-label">
                  Positions
                </label>
                <div className="form-control-wrap">
                  {positions && positions?.map((position, index) => {
                    if (!tabItem.positions.map((position) => position.id).includes(position.id)) {
                      return (
                        <article className="custom-control" key={index} style={{ paddingLeft: '5px !important' }}>
                          <input type="checkbox" className="" onChange={(e) => checkItem(e)} name='position_id[]' value={position.id} id={`fw-policy${position.id}`} />
                          <label className="" htmlFor={`fw-policy${position.id}`}>
                            <span>
                              {position.name}
                            </span>
                          </label>
                        </article>
                      )
                    }
                  })}
                  {errors.username && <span className="invalid">This field is required</span>}
                </div>
              </div>
            </Col>
          </Row>
          <div className="actions clearfix">
            <ul>
              <li>
                <Button color="primary" type="submit">
                  {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Link Positions"}
                </Button>
              </li>
            </ul>
          </div>
        </form>
      </> : <>
        <h4>No Positions to Add</h4>
      </>}
    </>


  );
};

const UnLinkPositions = ({ updateParentParent, tabItem, positions, closeModel }) => {
  const tabItem_id = tabItem.id
  const [positionIds, setPositionIds] = useState([]);
  const [loading, setLoading] = useState(false);
  const dispatch = useDispatch();

  const { handleSubmit, register, watch, formState: { errors } } = useForm();

  const submitForm = async (data) => {
    const clickedIds = Object.keys(positionIds)
    const valuesIds = Object.values(positionIds)
    const checkedId = clickedIds.filter((check, index) => valuesIds[index]);

    const postValues = new Object();

    postValues.category = tabItem_id;
    postValues.position = checkedId;

    try {
      setLoading(true);

      const resp = await dispatch(unlinkFromPositions(postValues));

      if (resp.payload?.message == "success") {
        setTimeout(() => {
          setLoading(false);
          updateParentParent(Math.random())
          closeModel()
        }, 1000);

      } else {
        setLoading(false);
      }

    } catch (error) {
      setLoading(false);
    }

  };


  const checkItem = (event) => {
    const ids = positionIds;
    ids[event.target.value] = event.target.checked
  };

  return (
    <>
      {(tabItem.positions.length > 0) ? <>
        <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
          <Row className="gy-4">
            <Col md="12">
              <div className="form-group">
                <label className="form-label">
                  Positions
                </label>
                <div className="form-control-wrap">
                  {tabItem.positions && tabItem.positions?.map((position, index) => {
                    if (positions.map((position) => position.id).includes(position.id)) {
                      return (
                        <article className="custom-control" key={index} style={{ paddingLeft: '5px !important' }}>
                          <input type="checkbox" className="" onChange={(e) => checkItem(e)} name='position_id[]' value={position.id} id={`fw-policy${position.id}`} />
                          <label className="" htmlFor={`fw-policy${position.id}`}>
                            <span>
                              {position.name}
                            </span>
                          </label>
                        </article>
                      )
                    }
                  })}
                  {errors.username && <span className="invalid">This field is required</span>}
                </div>
              </div>
            </Col>
          </Row>
          <div className="actions clearfix">
            <ul>
              <li>
                <Button color="primary" type="submit">
                  {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Unlink Positions"}
                </Button>
              </li>
            </ul>
          </div>
        </form>
      </> : <>
        <h4>No Position to Unlink</h4>
      </>}
    </>


  );
};

const AdminCategoryTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState, positions }) => {
  const tableColumn = [
    {
      name: "CDID",
      selector: (row, index) => ++index,
      sortable: true,
      width: "100px",
      wrap: true
    },
    {
      name: "Code",
      selector: (row) => row.code,
      sortable: true,
      width: "auto",
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
      name: "Positions",
      selector: (row) => row.positions.map((position) => position.name).toString(),
      sortable: true,
      width: "auto",
      wrap: true
    },
    {
      name: "Status",
      selector: (row) => { return (<><Badge color="success">{(row.active) ? `Activated` : `Deactivated`}</Badge></>) },
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
        <ActionTab tabItem={row} updateParentParent={updateParent} positions={positions} />
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

export default AdminCategoryTable;
