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

  return (
    <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
      <Row className="gy-4">
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="username">
              Username
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                id="username"
                className="form-control"
                {...register('username', { required: true })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.username} />
              {errors.username && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="password">
              Password
            </label>
            <div className="form-control-wrap">
              <input
                type="password"
                id="password"
                className="form-control"
                {...register('password', {
                  required: "This field is required",
                  minLength: {
                    value: 6,
                    message: "Password must have at least 6 characters",
                  },
                })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.password} />
              {errors.password && <span className="invalid">{errors.password.message}</span>}
            </div>
          </div>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="rePassword">
              Re-Password
            </label>
            <div className="form-control-wrap">
              <input
                type="password"
                id="rePassword"
                className="form-control"
                {...register('rePassword', {
                  required: "This field is required",
                  validate: (value) => value === password.current || "The passwords do not match",
                })}
                onChange={(e) => onInputChange(e)}
                defaultValue={formData.rePassword} />
              {errors.rePassword && <span className="invalid">{errors.rePassword?.message}</span>}
            </div>
          </div>
        </Col>
        <Col md="12">
          <div className="custom-control custom-checkbox">
            <input
              type="checkbox"
              className="custom-control-input"
              onChange={(e) => setFormData({ ...formData, terms: e.target.checked })}
              checked={formData.terms}
              {...register('terms', { required: true })}
              id="fw-policy" />
            {errors.terms && <span className="invalid">This field is required</span>}
            <label className="custom-control-label" htmlFor="fw-policy">
              I agreed Terms and policy
            </label>
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
    tokenAddress: "",
    contribute: "",
    telegram: "",
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
      <Row className="gy-3">
        <Col md="12">
          <div className="form-group">
            <label className="form-label" htmlFor="fw-token-address">
              Token Address
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control"
                id="fw-token-address"
                {...register('tokenAddress', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.tokenAddress && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
        <Col md="12">
          <label className="form-label">I want to contribute</label>
          <ul className="d-flex flex-wrap g-2">
            <li>
              <div className="custom-control custom-radio">
                <input
                  type="radio"
                  className="custom-control-input"
                  {...register('ethRadio', { required: true })}
                  id="fw-lt1eth"
                  checked={formData.contribute === "leEth" ? true : false}
                  onChange={() => setFormData({ ...formData, contribute: "leEth" })} />
                {errors.ethRadio && <span className="invalid">This field is required</span>}
                <label className="custom-control-label" htmlFor="fw-lt1eth">
                  Less than 1 ETH
                </label>
              </div>
            </li>
            <li>
              <div className="custom-control custom-radio">
                <input
                  type="radio"
                  className="custom-control-input"
                  {...register('ethRadio', { required: true })}
                  id="fw-ov1eth"
                  checked={formData.contribute === "ovEth" ? true : false}
                  onChange={() => setFormData({ ...formData, contribute: "ovEth" })} />
                <label className="custom-control-label" htmlFor="fw-ov1eth">
                  Over than 1 ETH
                </label>
              </div>
            </li>
          </ul>
        </Col>
        <Col md="6">
          <div className="form-group">
            <label className="form-label" htmlFor="fw-telegram-username">
              Telegram Username
            </label>
            <div className="form-control-wrap">
              <input
                type="text"
                className="form-control required"
                id="fw-telegram-username"
                {...register('telegram', { required: true })}
                onChange={(e) => onInputChange(e)} />
              {errors.telegram && <span className="invalid">This field is required</span>}
            </div>
          </div>
        </Col>
      </Row>
      <div className="actions clearfix">
        <ul>
          <li>
            <Button color="primary" type="submit">
              Submit
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
            <span className="number">01</span> <h5>Step 1</h5>
          </a>
        </li>
        <li className={props.current >= 2 ? "done" : ""}>
          <a href="#wizard-01-h-1" onClick={(ev) => ev.preventDefault()}>
            <span className="number">02</span> <h5>Step 2</h5>
          </a>
        </li>
        <li className={props.current >= 3 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="current-info audible">current step: </span>
            <span className="number">03</span> <h5>Step 3</h5>
          </a>
        </li>
        <li className={props.current >= 4 ? "done" : ""}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="current-info audible">current step: </span>
            <span className="number">04</span> <h5>Step 4</h5>
          </a>
        </li>
        <li className={props.current === 5 ? "last done" : "last"}>
          <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
            <span className="current-info audible">current step: </span>
            <span className="number">05</span> <h5>Step 5</h5>
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
      color: "#ffffff",
    },
    scroll: {
      overFlow: "scroll",
    }

  }


  return <>
    <Head title="Form" />
    <HeaderLogo />
    <div className="login-block">
      <Block className="nk-block-middle nk-auth-body  wide-xl">
        <BlockHead>
          <div style={styles.color}>
            <h2 style={styles.color}>Dealing Member (Banks) Application</h2>
            <p>Please fill forms to complete your application</p>
          </div>
        </BlockHead>
        <PreviewCard>
          <div className="nk-wizard nk-wizard-simple is-alter wizard clearfix">
            <Steps config={config}>
              <Step component={PersonalForm} />
              <Step component={UserSettings} />
              <Step component={PaymentInfo} />
              <Step component={Success} />
            </Steps>
          </div>
        </PreviewCard>
      </Block>
    </div>

  </>;
};
// type="submit"
export default Form;
