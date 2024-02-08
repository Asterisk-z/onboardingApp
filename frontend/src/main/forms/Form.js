import React, { useState, useRef, useEffect } from "react";
import Head from "../../layout/head/Head";
import Content from "../../layout/content/Content";
import {
  Block,
  BlockHead,
  BlockHeadContent,
  BlockTitle,
  BlockDes,
  BackTo,
  PreviewCard,
} from "../../components/Component";
import { useForm } from "react-hook-form";
import { Steps, Step } from "react-step-builder";
import { Row, Col, Button } from "reactstrap";
import { HeaderLogo } from "../../pages/components/HeaderLogo";


const PersonalForm = (props) => {

  const [formData, setFormData] = useState({
    companyName: "",
    rcNumber: "",
    officeAddress: "",
    emailAddress: "",
    secondaryEmail: "",
    mobileNumber: "",
    secondaryNumber: "",
    incorporationDate: "",
    incorporationPlace: "",
    website: "",
    businessNature: "",
    capital: "",
    shareCapital: "",
    name: "",
    phone: "",
    email: "",
  });

  const onInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const { reset, register, handleSubmit, formState: { errors } } = useForm();

  const submitForm = (data) => {
    props.next();
  };

  useEffect(() => {
    reset(formData)
  }, [formData]);

  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <h3>Applicant Information</h3>
      <Row className="gy-4">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="company-name">
              Company Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                id="company-name"
                className="form-control"
                {...register('companyName', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.companyName} />
              {errors.companyName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="rc-number">
              RC Number
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                id="rc-number"
                className="form-control"
                {...register('rcNumber', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.rcNumber} />
              {errors.rcNumber && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="office-address">
              Registered Office Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                id="office-address"
                className="form-control"
                {...register('officeAddress', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.officeAddress} />
              {errors.officeAddress && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="email-address">
              Company Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                id="email-address"
                className="form-control"
                {...register('email', {
                  required: true,
                  pattern: {
                    value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
                    message: "Invalid email address",
                  },
                })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.emailAddress} />
              {errors.email && errors.email.type === "required" && (
                <span className="invalid">This field is required</span>
              )}
              {errors.emailAddress && errors.emailAddress.type === "pattern" && (
                <span className="invalid">{errors.emailAddress.message}</span>
              )}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="secondary-email">
              Secondary Company Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                id="secondary-email"
                className="form-control"
                {...register('email', {
                  required: true,
                  pattern: {
                    value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
                    message: "Invalid email address",
                  },
                })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.secondaryEmail} />
              {errors.secondaryEmail && errors.secondaryEmail.type === "required" && (
                <span className="invalid">This field is required</span>
              )}
              {errors.secondaryEmail && errors.secondaryEmail.type === "pattern" && (
                <span className="invalid">{errors.secondaryEmail.message}</span>
              )}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="mobile-number">
              Company Telephone/Mobile Number
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                id="mobile-number"
                className="form-control"
                {...register('firstName', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.mobileNumber} />
              {errors.mobileNumber && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="secondary-number">
              Secondary Telephone/Mobile Number
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                id="secondary-number"
                className="form-control"
                {...register('secondaryNumber', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.secondaryNumber} />
              {errors.secondaryNumber && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="incorporation-date">
              Date of Incorporation
            </label>
            <div className="form-control-wrap">
              <input
                type="date"
                id="incorporation-date"
                className="form-control"
                {...register('incorporationDate', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.incorporationDate} />
              {errors.incorporationDate && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="incorporation-place">
              Place of Incorporation
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                id="incorporation-place"
                className="form-control"
                {...register('incorporationPlace', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.incorporationPlace} />
              {errors.incorporationPlace && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="website">
              Corporate Website Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                id="website"
                className="form-control"
                {...register('website', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.website} />
              {errors.website && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="business-nature">
              Nature of Business
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                id="business-nature"
                className="form-control"
                {...register('businessNature', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.businessNature} />
              {errors.businessNature && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="capital">
              Authorised Share Capital
            </label>
            <div style={{ display: 'flex', width: '100%' }}>
              <select style={{ height: '35px', width: '15%', marginRight: '10px', paddingLeft: '5px' }}>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
              </select>
              <input
                type="text"
                className="form-control"
                style={{ width: '85%' }}
                {...register('capital', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.capital} />
              {errors.capital && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="share-capital">
              Paid-up Share Capital
            </label>
            <div style={{ display: 'flex', width: '100%' }}>
              <select style={{ height: '35px', width: '15%', marginRight: '10px', paddingLeft: '5px' }}>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
              </select>
              <input
                type="text"
                className="form-control"
                style={{ width: '85%' }}
                {...register('share-capital', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.shareCapital} />
              {errors.shareCapital && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <h4>Application Primary Contact Details</h4>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="name">
              Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                id="name"
                className="form-control"
                {...register('name', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.name} />
              {errors.name && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="phone-no">
              Mobile Number
            </label>
            <div className="form-control-wrap">
              <input
                type="number"
                id="phone-no"
                className="form-control"
                {...register('phone', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.phone} />
              {errors.phone && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="email">
              Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                id="email"
                className="form-control"
                {...register('email', {
                  required: true,
                  pattern: {
                    value: /^[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}$/i,
                    message: "Invalid email address",
                  },
                })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.email} />
              {errors.email && errors.email.type === "required" && (
                <span className="invalid">This field is required</span>
              )}
              {errors.email && errors.email.type === "pattern" && (
                <span className="invalid">{errors.email.message}</span>
              )}
            </div>
          </div>
        </Col>
      </Row>
      <div className="actions clearfix">
        <ul>
          <li>
            <Button color="primary" type="submit">
              Next
            </Button>
          </li>
        </ul>
      </div>
    </form>
  );
};

const UserSettings = (props) => {
  const [formData, setFormData] = useState({
    username: "",
    password: "",
    rePassword: "",
    terms: true,
  });

  const onInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const { handleSubmit, register, watch, formState: { errors } } = useForm();

  const submitForm = (data) => {
    props.next();
  };

  const password = useRef();
  password.current = watch("password");


  // const [inputValue1, setInputValue1] = useState('');
  // const [inputValue2, setInputValue2] = useState('');
  // const [checkboxChecked, setCheckboxChecked] = useState(false);


  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <h3>Banking Licence</h3>
      <Row className="gy-4">
        <Col md="12">
          <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
            <label>
              International Banking Licence
            </label>
            <input
              type="checkbox"
            // checked={checkboxChecked}
            // onChange={() => setCheckboxChecked(!checkboxChecked)}
            />
          </div>

        </Col>
        <Col md="12">
          <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
            <label>
              National Banking Licence
            </label>
            <input
              type="checkbox"
            // checked={checkboxChecked}
            // onChange={() => setCheckboxChecked(!checkboxChecked)}
            />
          </div>

        </Col>
        <Col md="12">
          <div style={{ display: 'flex', alignItems: 'center', gap: '10px' }}>
            <label >
              Regional Banking Licence
            </label>
            <input
              type="checkbox"
            // checked={checkboxChecked}
            // onChange={() => setCheckboxChecked(!checkboxChecked)}
            />
          </div>
        </Col>
      </Row>
      <h4 style={{ marginTop: '30px' }}>Trading Details</h4>
      <h5 style={{ marginTop: '30px' }}>Product of Interest:</h5>
      <Row >
        <div>
          <table style={{ borderCollapse: 'collapse', width: '100%' }}>
            <thead>
              <tr>
                <th>#</th>
                <th>Product</th>
                <th>Monthly Average Value of Trades per Product (₦)</th>
                <th>Average Trade Size per Transaction (₦)</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', paddingRight: "20px" }}>
                  <label>
                    Bond
                  </label>
                  <input
                    type="checkbox"
                  // checked={checkboxChecked}
                  // onChange={() => setCheckboxChecked(!checkboxChecked)}
                  />
                </td>
                <td>
                  <input style={{ width: '90%' }}
                    type="text"
                  // value={inputValue1}
                  // onChange={(e) => setInputValue1(e.target.value)}
                  />
                </td>
                <td>
                  <input style={{ width: '100%' }}
                    type="text"
                  // value={inputValue2}
                  // onChange={(e) => setInputValue2(e.target.value)}
                  />
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', paddingRight: "20px" }}>
                  <label>
                    Commercial Papers
                  </label>
                  <input
                    type="checkbox"
                  // checked={checkboxChecked}
                  // onChange={() => setCheckboxChecked(!checkboxChecked)}
                  />
                </td>
                <td>
                  <input style={{ width: '90%' }}
                    type="text"
                  // value={inputValue1}
                  // onChange={(e) => setInputValue1(e.target.value)}
                  />
                </td>
                <td>
                  <input style={{ width: '100%' }}
                    type="text"
                  // value={inputValue2}
                  // onChange={(e) => setInputValue2(e.target.value)}
                  />
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', paddingRight: "20px" }}>
                  <label>
                    Futures
                  </label>
                  <input
                    type="checkbox"
                  // checked={checkboxChecked}
                  // onChange={() => setCheckboxChecked(!checkboxChecked)}
                  />
                </td>
                <td>
                  <input style={{ width: '90%' }}
                    type="text"
                  // value={inputValue1}
                  // onChange={(e) => setInputValue1(e.target.value)}
                  />
                </td>
                <td>
                  <input style={{ width: '100%' }}
                    type="text"
                  // value={inputValue2}
                  // onChange={(e) => setInputValue2(e.target.value)}
                  />
                </td>
              </tr>
              <tr>
                <td>4</td>
                <td style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', paddingRight: "20px" }}>
                  <label>
                    Loans
                  </label>
                  <input
                    type="checkbox"
                  // checked={checkboxChecked}
                  // onChange={() => setCheckboxChecked(!checkboxChecked)}
                  />
                </td>
                <td>
                  <input style={{ width: '90%' }}
                    type="text"
                  // value={inputValue1}
                  // onChange={(e) => setInputValue1(e.target.value)}
                  />
                </td>
                <td>
                  <input style={{ width: '100%' }}
                    type="text"
                  // value={inputValue2}
                  // onChange={(e) => setInputValue2(e.target.value)}
                  />
                </td>
              </tr>
              <tr>
                <td>5</td>
                <td style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', paddingRight: "20px" }}>
                  <label>
                    Wrapped
                  </label>
                  <input
                    type="checkbox"
                  // checked={checkboxChecked}
                  // onChange={() => setCheckboxChecked(!checkboxChecked)}
                  />
                </td>
                <td>
                  <input style={{ width: '90%' }}
                    type="text"
                  // value={inputValue1}
                  // onChange={(e) => setInputValue1(e.target.value)}
                  />
                </td>
                <td>
                  <input style={{ width: '100%' }}
                    type="text"
                  // value={inputValue2}
                  // onChange={(e) => setInputValue2(e.target.value)}
                  />
                </td>
              </tr>
              <tr>
                <td>6</td>
                <td style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', paddingRight: "20px" }}>
                  <label>
                    Quakes
                  </label>
                  <input
                    type="checkbox"
                  // checked={checkboxChecked}
                  // onChange={() => setCheckboxChecked(!checkboxChecked)}
                  />
                </td>
                <td>
                  <input style={{ width: '90%' }}
                    type="text"
                  // value={inputValue1}
                  // onChange={(e) => setInputValue1(e.target.value)}
                  />
                </td>
                <td>
                  <input style={{ width: '100%' }}
                    type="text"
                  // value={inputValue2}
                  // onChange={(e) => setInputValue2(e.target.value)}
                  />
                </td>
              </tr>
              <tr>
                <td>7</td>
                <td style={{ display: 'flex', justifyContent: 'space-between', alignItems: 'center', paddingRight: "20px" }}>
                  <label>
                    Pay
                  </label>
                  <input
                    type="checkbox"
                  // checked={checkboxChecked}
                  // onChange={() => setCheckboxChecked(!checkboxChecked)}
                  />
                </td>
                <td>
                  <input style={{ width: '90%' }}
                    type="text"
                  // value={inputValue1}
                  // onChange={(e) => setInputValue1(e.target.value)}
                  />
                </td>
                <td>
                  <input style={{ width: '100%' }}
                    type="text"
                  // value={inputValue2}
                  // onChange={(e) => setInputValue2(e.target.value)}
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </Row>
      <h5 style={{ marginTop: '30px' }}>Direction of Trade</h5>
      <Row >
        <div>
          <table style={{ borderCollapse: 'collapse', width: '100%' }}>
            <thead>
              <tr>
                <th>#</th>
                <th>Direction</th>
                <th>check</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>1</td>
                <td style={{ display: 'flex', gap: '50px', alignItems: 'center' }}>
                  Buy
                </td>
                <td>
                  <input
                    type="checkbox"
                  // checked={checkboxChecked}
                  // onChange={() => setCheckboxChecked(!checkboxChecked)}
                  />
                </td>
              </tr>
              <tr>
                <td>2</td>
                <td style={{ display: 'flex', gap: '50px', alignItems: 'center' }}>
                  Sell
                </td>
                <td>
                  <input
                    type="checkbox"
                  // checked={checkboxChecked}
                  // onChange={() => setCheckboxChecked(!checkboxChecked)}
                  />
                </td>
              </tr>
              <tr>
                <td>3</td>
                <td style={{ display: 'flex', gap: '50px', alignItems: 'center' }}>
                  Both
                </td>
                <td>
                  <input
                    type="checkbox"
                  // checked={checkboxChecked}
                  // onChange={() => setCheckboxChecked(!checkboxChecked)}
                  />
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </Row>
      <div className="actions clearfix">
        <ul>
          <li>
            <Button color="primary" type="submit">
              Next
            </Button>
          </li>
          <li>
            <Button color="primary" onClick={props.prev}>
              Previous
            </Button>
          </li>
        </ul>
      </div>
    </form>
  );
};

const PaymentInfo = (props) => {
  const [formData, setFormData] = useState({
    name: "",
    address: "",
    telephone: "",
    accountManagerNumber: "",
    accountManagerEmail: "",
    accountNumber: ""
  });

  const onInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const { register, handleSubmit, formState: { errors } } = useForm();

  const submitForm = (data) => {
    //window.location.reload();
    props.next();
  };

  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <h3>Bank Details</h3>
      <Row className="gy-3">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="name">
              Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="name"
                {...register('tokenAddress', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.name && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="address">
              Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="address"
                {...register('address', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.address && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="telephone">
              Telephone Number
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="telephone"
                {...register('telephone', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.telephone && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="account-manager-number">
              Mobile Number of Account Manager
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="account-manager-number"
                {...register('accountManagerNumber', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.accountManagerNumber && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="account-manager-email">
              Email Address of Account Manager
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="account-manager-email"
                {...register('accountManagerEmail', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.accountManagerEmail && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="corporate-account-number">
              Corporate Account Number
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="corporate-account-number"
                {...register('accountNumber', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.accountNumber && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
      </Row>
      <div className="actions clearfix">
        <ul>
          <li>
            <Button color="primary" onClick={props.next}>
              Next
            </Button>
          </li>
          <li>
            <Button color="primary" onClick={props.prev}>
              Previous
            </Button>
          </li>

        </ul>
      </div>
    </form>
  );
};

const StepFive = (props) => {
  const [formData, setFormData] = useState({
    surname: "",
    firstName: "",
    middleName: "",
    number: "",
    email: "",
    address: ""
  });

  const onInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const { register, handleSubmit, formState: { errors } } = useForm();

  const submitForm = (data) => {
    //window.location.reload();
    props.next();
  };

  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <h3>Custodian Information</h3>
      <Row className="gy-3">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="surname">
              Surname
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="surname"
                {...register('surname', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.surname && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="first-name">
              First Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="first-name"
                {...register('firstName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.firstName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="middle-name">
              Middle Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="middle-name"
                {...register('middleName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.middleName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="number">
              Telephone/ Mobile No.
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="number"
                {...register('accountManagerNumber', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.number && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="email">
              Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="email"
                {...register('email', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.email && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="address">
              Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="address"
                {...register('address', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.address && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
      </Row>
      <div className="actions clearfix">
        <ul>
          <li>
            <Button color="primary" onClick={props.next}>
              Next
            </Button>
          </li>
          <li>
            <Button color="primary" onClick={props.prev}>
              Previous
            </Button>
          </li>
        </ul>
      </div>
    </form>
  );
};
const StepSix = (props) => {
  const [formData, setFormData] = useState({
    surname: "",
    firstName: "",
    middleName: "",
    number: "",
    email: "",
    address: ""
  });

  const onInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const { register, handleSubmit, formState: { errors } } = useForm();

  const submitForm = (data) => {
    //window.location.reload();
    props.next();
  };

  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <h3>Key Officers</h3>
      <br />
      <h5 style={{ 'marginTop': '10px' }}>Managing Director/Chief Executive Office</h5>
      <Row className="gy-3">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="surname">
              Surname
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="surname"
                {...register('surname', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.surname && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="first-name">
              First Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="first-name"
                {...register('firstName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.firstName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="middle-name">
              Middle Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="middle-name"
                {...register('middleName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.middleName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="number">
              Telephone/ Mobile No.
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="number"
                {...register('accountManagerNumber', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.number && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="email">
              Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="email"
                {...register('email', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.email && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="address">
              Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="address"
                {...register('address', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.address && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
      </Row>
      {/* <h5 style={{'marginTop':'10px'}}>Treasurer/Chief Financial Officer </h5>
      <Row className="gy-3">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="surname">
              Surname
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="surname"
                {...register('surname', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.surname && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="first-name">
              First Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="first-name"
                {...register('firstName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.firstName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="middle-name">
              Middle Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="middle-name"
                {...register('middleName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.middleName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="number">
              Telephone/ Mobile No.
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="number"
                {...register('accountManagerNumber', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.number && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="email">
              Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="email"
                {...register('email', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.email && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="address">
              Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="address"
                {...register('address', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.address && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
      </Row>
      <h5 style={{'marginTop':'10px'}}>Chief Compliance Officer </h5>
      <Row className="gy-3">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="surname">
              Surname
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="surname"
                {...register('surname', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.surname && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="first-name">
              First Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="first-name"
                {...register('firstName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.firstName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="middle-name">
              Middle Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="middle-name"
                {...register('middleName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.middleName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="number">
              Telephone/ Mobile No.
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="number"
                {...register('accountManagerNumber', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.number && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="email">
              Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="email"
                {...register('email', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.email && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="address">
              Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="address"
                {...register('address', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.address && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
      </Row>
      <h5 style={{'marginTop':'10px'}}>Internal Auditor</h5>
      <Row className="gy-3">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="surname">
              Surname
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="surname"
                {...register('surname', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.surname && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="first-name">
              First Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="first-name"
                {...register('firstName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.firstName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="middle-name">
              Middle Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="middle-name"
                {...register('middleName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.middleName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="number">
              Telephone/ Mobile No.
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="number"
                {...register('accountManagerNumber', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.number && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="email">
              Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="email"
                {...register('email', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.email && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="address">
              Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="address"
                {...register('address', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.address && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
      </Row>
      <h5 style={{'marginTop':'10px'}}>Risk Management Officer</h5>
      <Row className="gy-3">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="surname">
              Surname
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="surname"
                {...register('surname', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.surname && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="first-name">
              First Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="first-name"
                {...register('firstName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.firstName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="middle-name">
              Middle Name
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="middle-name"
                {...register('middleName', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.middleName && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="number">
              Telephone/ Mobile No.
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="number"
                {...register('accountManagerNumber', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.number && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="email">
              Email Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="email"
                {...register('email', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.email && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="address">
              Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="address"
                {...register('address', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.address && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
      </Row> */}
      <div className="actions clearfix">
        <ul>
          <li>
            <Button color="primary" onClick={props.next}>
              Next
            </Button>
          </li>
          <li>
            <Button color="primary" onClick={props.prev}>
              Previous
            </Button>
          </li>
        </ul>
      </div>
    </form>
  );
};

const StepSeven = (props) => {
  const [formData, setFormData] = useState({
    surname: "",
    firstName: "",
    middleName: "",
    number: "",
    email: "",
    address: ""
  });

  const onInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const { register, handleSubmit, formState: { errors } } = useForm();

  const submitForm = (data) => {
    //window.location.reload();
    props.next();
  };

  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <h3>Disciplinary History</h3>
      <p>The questions below relate to the company and the key officers listed above. Responses should cover material events which occurred in the past ten (10) years and should include events that have occurred anywhere in the world. If in doubt as to the materiality or relevance of the event, please disclose the event. If the answer to the any of the questions below is “YES”, the applicant is required to provide additional information/details in a separate sheet.</p>
      <br />
      <h5>THE COMPANY</h5>
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Has the company or any of its affiliates , been denied registration or expelled from membership of any securities exchange, self-regulatory organisation (SRO) or associations?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>2.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Has your membership, or that of any affiliates, in any of the institutions/ associations mentioned above at any time been revoked, suspended or withdrawn?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>3.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Has your company, or any of its affiliates, ever been refused a Fidelity Bond?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>4.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Has your company, or any of its affiliates, ever been refused a Fidelity Bond?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <h4>MD/CEO</h4>
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been convicted of any criminal offence? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>2.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>3.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been a Director, partner or otherwise concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one year of that connection? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>4.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>5.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>6.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been refused authorisation or licence to carry on a trade, business or profession or to be a member of a securities exchange?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>7.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>8.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever had such authorisation, membership or licence (referred to above) revoked or terminated?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>9.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been disqualified from acting as a Director?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <h4>TREASURER</h4>
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been convicted of any criminal offence?  </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>2.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>2.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one year of that connection? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>2.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>2.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any authority which may lead to such proceedings?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <h4>CHIEF COMPLIANCE OFFICER</h4>
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been convicted of any criminal offence?  </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of an adverse finding by, or settlement with, any government agency, court, securities exchange, SRO, tribunal or other regulatory authority?  </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been concerned in the management of a business which has gone into insolvency, liquidation, administration or the equivalent proceedings within or outside of the Nigerian jurisdiction while connected with such organisation within one year of that connection? </p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been declared bankrupt or entered into any compromise arrangement with creditors related to bankruptcy or insolvency?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <hr />
      <Row className="gy-3">
        <div style={{ display: 'flex', gap: '20px' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <div style={{ display: 'flex', justifyContent: 'space-between', width: '100%' }}>
            <p>Ever been the subject of any disciplinary or criminal proceedings or been the subject of any investigation by any Authority which may lead to such proceedings?</p>
            <div style={{ maxWidth: '50px' }}>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="yes" name="no" value="yes" />
                <label for="yes">Yes</label><br />
              </div>
              <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
                <input type="radio" id="no" name="no" value="no" />
                <label for="no">No</label><br />
              </div>
            </div>
          </div>

        </div>
      </Row>
      <div className="actions clearfix">
        <ul>
          <li>
            <Button color="primary" onClick={props.next}>
              Next
            </Button>
          </li>
          <li>
            <Button color="primary" onClick={props.prev}>
              Previous
            </Button>
          </li>
        </ul>
      </div>
    </form>
  );
};

const StepEight = (props) => {
  const [formData, setFormData] = useState({
    surname: "",
    firstName: "",
    middleName: "",
    number: "",
    email: "",
    address: ""
  });

  const onInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const { register, handleSubmit, formState: { errors } } = useForm();

  const submitForm = (data) => {
    //window.location.reload();
    props.next();
  };

  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <h3>Supporting Documents</h3>

      <Row className="gy-3">

        <div style={{ display: 'flex', justifyContent: 'space-between' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <p>Company Profile containing brief description of the following inter alia:
            History & Company Overview
            Details of Business Services
            Profiles of Board of Directors
            Profiles of Executive Management Staff</p>
          <div>
            <div style={{ display: 'flex', flexDirection: 'column', alignItems: 'center', gap: '5px' }}>
              <input type="file" id="yes" />
              <label for="yes"></label><br />
            </div>
          </div>
        </div>
      </Row>
      <hr />
      <div className="actions clearfix">
        <ul>
          <li>
            <Button color="primary" onClick={props.next}>
              Next
            </Button>
          </li>
          <li>
            <Button color="primary" onClick={props.prev}>
              Previous
            </Button>
          </li>
        </ul>
      </div>
    </form>
  );
};

const StepNine = (props) => {
  const [formData, setFormData] = useState({
    surname: "",
    firstName: "",
    middleName: "",
    number: "",
    email: "",
    address: ""
  });

  const onInputChange = (e) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const { register, handleSubmit, formState: { errors } } = useForm();

  const submitForm = (data) => {
    //window.location.reload();
    props.next();
  };

  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <i>By submitting this application to become a member of FMDQ Securities Exchange Limited and signing this form in the manner below:

        We declare that the information provided is complete and accurate and we agree, if approved, to comply with and be bound by the Rules of FMDQ Exchange, which are or may be in force from time to time
        We further declare that we will update our trading practices in line with the Rules. We will notify FMDQ Exchange of any additional information which is relevant to the application and of any significant changes in the information provided in this application form which occur after the date of submission of the application
        We understand that misleading or attempting to mislead FMDQ Exchange’s representatives during the application process will be deemed an act of misconduct and may render the applicant liable to disciplinary proceedings
        We agree that any entity within FMDQ Group may have access to the information contained herein for marketing purposes
        We undertake to comply with FMDQ Exchange’s Rules, the Investment and Securities Act (ISA) 2007, Securities and Exchange Commission Rules and such other regulation relating to our activities on the Exchange, as may be amended from time to time
      </i>
      <br />
      {/* <h5>THE COMPANY</h5>
      <Row className="gy-3">
        <div style={{ display: 'flex', justifyContent: 'space-between' }}>
          <p style={{ maxWidth: '30px' }}><b>1.</b></p>
          <p>Has the company or any of its affiliates , been denied registration or expelled from membership of any securities exchange, self-regulatory organisation (SRO) or associations?</p>
          <div style={{ maxWidth: '50px' }}>
            <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
              <input type="radio" id="yes" name="no" value="yes" />
              <label for="yes">Yes</label><br />
            </div>
            <div style={{ display: 'flex', alignItems: 'center', gap: '5px' }}>
              <input type="radio" id="no" name="no" value="no" />
              <label for="no">No</label><br />
            </div>
          </div>
        </div>
      </Row> */}
      <hr />
      <div className="actions clearfix">
        <ul>
          <li>
            <Button color="primary" onClick={props.next}>
              Next
            </Button>
          </li>
          <li>
            <Button color="primary" onClick={props.prev}>
              Previous
            </Button>
          </li>
        </ul>
      </div>
    </form>
  );
};


const Header = (props) => {
  return (
    <div className="steps clearfix">
      <ul>
        <li className={props.current >= 1 ? "first done" : "first"}>
          <a href="#wizard-01-h-0" onClick={(ev) => ev.preventDefault()}>
            <span className="number">APPLICANT</span> <h5>Information</h5>
          </a>
        </li>
        <li className={props.current >= 2 ? "done" : ""}>
          <a href="#wizard-01-h-1" onClick={(ev) => ev.preventDefault()}>
            <span className="number">TRADING</span> <h5>DETAILS</h5>
          </a>
        </li>
        <li className={props.current >= 3 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number"></span> <h5>Step 3</h5>
          </a>
        </li>
        <li className={props.current >= 4 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number"></span> <h5>Step 4</h5>
          </a>
        </li>
        <li className={props.current >= 5 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number"></span> <h5>Step 5</h5>
          </a>
        </li>
        <li className={props.current >= 6 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number"></span> <h5>Step 6</h5>
          </a>
        </li>
        <li className={props.current >= 7 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number"></span> <h5>Step 7</h5>
          </a>
        </li>
        <li className={props.current >= 8 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number"></span> <h5>Step 8</h5>
          </a>
        </li>
        <li className={props.current === 9 ? "last done" : "last"}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="number"></span> <h5>Step 9</h5>
          </a>
        </li>
      </ul>
    </div>
  );
};

const Success = (props) => {
  return (
    <div className="d-flex justify-content-center align-items-center p-3">
      <BlockTitle tag="h6" className="text-center">
        Thank you for submitting form
      </BlockTitle>
    </div>
  );
};

const Fourth = (props) => {
  return (
    <div className="d-flex justify-content-center align-items-center p-3">
      <BlockTitle tag="h6" className="text-center">
        Thank you for submitting form
      </BlockTitle>
    </div>
  );
};

const config = {
  before: Header,
};

const Form = () => {
  const [loading, setLoading] = useState(false);
  const [passState, setPassState] = useState(false);
  const [errorVal, setError] = useState("");
  const [modalSuccess, setModalSuccess] = useState(false);
  const toggleSuccess = () => setModalSuccess(!modalSuccess);
  const styles = {
    color: {
      marginBottom: "10px",
    },
    scroll: {
      overFlow: "scroll",
    },
    card: {
      backgroundColor: "#fff",
      margin: "50px 30px",
      padding: "20px"
    }

  }


  return <>
    <Head title="Form" />
    <HeaderLogo />
    
            <Content page="component">
                <Content>
    <div className="">
      <div style={{ 'margin': '0px 10px !important' }}>
        <div style={styles.card}>
          <div style={styles.color}>
            <h2>Dealing Member (Banks) Application</h2>
            <p>Please fill forms to complete your application</p>
          </div>
          <div className="nk-wizard nk-wizard-simple is-alter wizard clearfix">
            <Steps config={config}>
              <Step component={PersonalForm} />
              <Step component={UserSettings} />
              <Step component={PaymentInfo} />
              <Step component={StepFive} />
              <Step component={StepSix} />
              <Step component={StepSeven} />
              <Step component={StepEight} />
              <Step component={StepNine} />
              <Step component={Success} />
            </Steps>
          </div>
        </div>
      </div>
    </div>
                </Content>
            </Content>

  </>;
};
// type="submit"
export default Form;
