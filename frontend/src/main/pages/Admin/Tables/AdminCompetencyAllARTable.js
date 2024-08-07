import React, { useEffect, useState } from "react";
import DataTable from "react-data-table-component";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import exportFromJSON from "export-from-json";
import CopyToClipboard from "react-copy-to-clipboard";
import Icon from "components/icon/Icon";
import { useDispatch } from "react-redux";
import { Col, Row, Button, Dropdown, UncontrolledDropdown, DropdownToggle, DropdownMenu, DropdownItem, Badge, Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner, Label, CardBody, CardTitle } from "reactstrap";
import { DataTablePagination } from "components/Component";
import moment from "moment";
import { updateMEGStatusCompetency, loadOverAllCompliantArs } from "redux/stores/competency/competencyStore";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
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
      "User Detail": `${item.firstName} ${item.lastName} ${item.email}`,
      "Institution": item.institution_name,
      "Competency Name": item.name,
      "Competency Description": item.description,
      "Date Created": moment(item.created_at).format('MMM. D, YYYY HH:mm')
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

  const navigate = useNavigate();
  const dispatch = useDispatch();

  const [modalForm, setModalForm] = useState(false);
  const toggleForm = () => setModalForm(!modalForm);

  const [sendDeficiency, setSendDeficiency] = useState(false);
  const toggleSendDeficiency = () => setSendDeficiency(!sendDeficiency);

  const competency = props.competency
  const framework = props.competency?.framework
  const proficiencies = props.competency?.framework?.proficiencies

  // const { competency_id } = useParams();

  // const competency_response = ar_user.competency_response.filter((response) => response.framework_id == competency_id)[0]

  const { register, handleSubmit, formState: { errors }, resetField } = useForm();
  const [loading, setLoading] = useState(false);

  const handleFormSubmit = async (values) => {

    const formData = new FormData();
    formData.append('competency_id', competency?.id)
    formData.append('message', values.deficiency)

    try {
      setLoading(true);

      const resp = await dispatch(updateMEGStatusCompetency(formData));

      if (resp.payload?.message == "success") {
        setTimeout(() => {
          setLoading(false);
          setModalForm(!modalForm)
          setSendDeficiency(!sendDeficiency)
          resetField('deficiency')
          dispatch(loadOverAllCompliantArs());
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

      <Button className="btn btn-secondary btn-sm " onClick={toggleForm} color="primary" >Details</Button>


      <Modal isOpen={modalForm} toggle={toggleForm} size="lg">
        <ModalHeader toggle={toggleForm} close={<button className="close" onClick={toggleForm}><Icon name="cross" /></button>}>
          Update
        </ModalHeader>
        <ModalBody>
          {competency && <>
            <div>
              <h6 className="title">Competency Update </h6>
              <table className="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>AR </td>
                    <td className="text-capitalize">{`${competency?.ar?.full_name} `}</td>
                  </tr>
                  <tr>
                    <td>AR Email </td>
                    <td className="text-capitalize">{`${competency?.ar?.email} `}</td>
                  </tr>
                  <tr>
                    <td>Authorized By</td>
                    <td className="text-capitalize">{`${competency?.cco?.full_name_with_mail}`}</td>
                  </tr>
                  <tr>
                    <td>Institution</td>
                    <td className="text-capitalize">{`${competency?.institution?.name}`}</td>
                  </tr>
                  {competency?.evidence_file && <>
                    <tr>
                      <td>Evidence</td>
                      <td className="text-capitalize">
                        <a target="_blank" href={competency?.evidence_file} className="btn btn-secondary"> View Evidence</a>
                      </td>
                    </tr>
                  </>}
                  {competency?.comment && <>
                    <tr>
                      <td>Comment</td>
                      <td className="text-capitalize">{`${competency?.comment}`}</td>
                    </tr>
                  </>}

                </tbody>
              </table>
              <div className="text-center">
                <Button className="btn btn-success btn-sm " onClick={toggleSendDeficiency} color="primary"  >Send Deficiency</Button>
              </div>
            </div>
          </>}
          {framework && <>
            <div>
              <h6 className="title">Competency </h6>
              <table className="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    <th scope="col"></th>
                    <th scope="col"></th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Name</td>
                    <td className="text-capitalize">{`${framework?.name}`}</td>
                  </tr>
                  <tr>
                    <td>Description</td>
                    <td className="text-capitalize">{`${framework?.description}`}</td>
                  </tr>
                  <tr>
                    <td>Category</td>
                    <td className="text-capitalize">{`${framework?.category_obj?.name}`}</td>
                  </tr>
                  <tr>
                    <td>Position</td>
                    <td className="text-capitalize">{`${framework?.position_group_obj?.name}`}</td>
                  </tr>
                  <tr>
                    <td>Expected Proficiency</td>
                    <td className="text-capitalize">{`${framework?.expected_proficiency}`}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </>}
          {proficiencies?.length > 0 && <>
            <div>
              <h6 className="title">Competency Proficiencies </h6>
              <table className="table table-striped table-bordered table-hover">
                <thead>
                  <tr>
                    {/* <th scope="col">#</th>
                    <th scope="col">Full Name</th>
                    <th scope="col">Email</th> */}
                  </tr>
                </thead>
                <tbody>
                  {proficiencies && proficiencies.map
                    ((proficiency, index) =>
                      <tr key={index}>
                        <td>{`${++index}`}</td>
                        <td className="text-capitalize">{`${proficiency?.description}`}</td>
                      </tr>
                    )}
                </tbody>
              </table>
            </div>
          </>}

        </ModalBody>
        <ModalFooter className="bg-light">
          <span className="sub-text">Update Competency</span>
        </ModalFooter>
      </Modal>


      <Modal isOpen={sendDeficiency} toggle={toggleSendDeficiency} size="lg">
        <ModalHeader toggle={toggleSendDeficiency} close={<button className="close" onClick={toggleSendDeficiency}><Icon name="cross" /></button>}>
          Update
        </ModalHeader>
        <ModalBody>

          <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">
            <div className="form-group">
              <label className="form-label" htmlFor="email">
                Deficiency
              </label>
              <div className="form-control-wrap">
                <textarea type="text" className="form-control" {...register('deficiency', { required: "deficiency is Required" })}></textarea>
                {errors.deficiency && <p className="invalid">{`${errors.deficiency.message}`}</p>}
              </div>
            </div>
            <div className="form-group">
              <Button color="primary" type="submit" size="lg">
                {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Send"}
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

const AdminCompetencyARTable = ({ data, pagination, actions, className, selectableRows, expandableRows, updateParent, parentState }) => {
  const complainColumn = [
    {
      name: "SN",
      selector: (row, index) => ++index,
      sortable: true,
      width: "100px",
      wrap: true
    },
    {
      name: "User Detail",
      selector: (row) => { return (<><p>{`${row.ar?.first_name} ${row.ar?.last_name}`}<br />{`${row.ar?.email}`}</p></>) },
      sortable: true,
      width: "auto",
      wrap: true
    },
    {
      name: "Institution",
      selector: (row) => { return (<>{`${row.institution?.name}`}</>) },
      sortable: true,
      width: "auto",
      wrap: true
    },
    // {
    //     name: "Position",
    //     selector: (row) => { return (<>{`${row.position_obj.name}`}</>) },
    //     sortable: true,
    //     width: "auto",
    //     wrap: true
    // },
    {
      name: "Competency Name",
      selector: (row) => { return (<>{`${row?.framework?.name}`}</>) },
      sortable: true,
      width: "auto",
      wrap: true
    },
    {
      name: "Competency Description",
      selector: (row) => { return (<>{`${row?.framework?.description}`}</>) },
      sortable: true,
      width: "auto",
      wrap: true
    },
    {
      name: "Date Created",
      selector: (row) => moment(row.created_at).format('MMM. D, YYYY HH:mm'),
      sortable: true,
      width: "auto",
      wrap: true
    },
    {
      name: "Action",
      selector: (row) => (<>
        <ActionTab competency={row} updateParentParent={updateParent} />
      </>),
      width: "100px",
    },
  ];
  // const newData = data.map((datum, index) => {
  //     // let datumm = {'id': index}
  //     const datumm = { ...datum, ['id']: index }
  //     console.log(datum,datumm)
  // })
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

export default AdminCompetencyARTable;
