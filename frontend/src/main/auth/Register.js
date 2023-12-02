import React, { useState } from "react";
import { useDispatch } from "react-redux";
import { useNavigate } from "react-router-dom";
import Head from "../../layout/head/Head";
import Countries from "../../utils/Country";
import Categories from "../../utils/Category";
import { registerUser } from "./../../redux/stores/authenticate/authStore";

import {
  Block,
  BlockHeadContent,
  BlockHead,
  BlockTitle,
  Button,
  Icon,
  PreviewCard,
} from "../../components/Component";
import { Spinner } from "reactstrap";
import { useForm } from "react-hook-form";
import { Link } from "react-router-dom";
import Logo from "../../images/fmdq/FMDQ-Logo.png";

const Register = ({ drawer }) => {
  const dispatch = useDispatch();
  const [passState, setPassState] = useState(false);
  const [loading, setLoading] = useState(false);
  const { register, handleSubmit, formState: { errors } } = useForm();
  const navigate = useNavigate();

  const handleFormSubmit = async (values) => {
   
    try {
      setLoading(true);
      
      const resp = await dispatch(registerUser(values));
      console.log(register)
      console.log(resp.payload?.message)
      resetFields();
      
      if (resp.payload?.message == "success") {
        // setSuccess(true);
        // register.resetFields();
        // dispatch(loadAllCustomer({ page: 1, count: 10, status: true }));
        
        if (isAdmin !== true) {
          setTimeout(() => {
            // window.location.href = "/customer/login";
            // setSuccess(false);
            setLoading(false);
          }, 5000);
        } else {
          // setSuccess(false);
          setLoading(false);
        }
      } else {
        setLoading(false);
      }
    } catch (error) {
      setLoading(false);
    }
    // setTimeout(() => {
    //   navigate(`${process.env.PUBLIC_URL}/auth-success`);
    // }, 1000);
  };
  return <>
    
    <Head title="Register" />

    <div className="login-block">
        <Block className="nk-block-middle nk-auth-body  wide-sm">
          <div className="brand-logo pb-4 text-center">
            <Link to={`${process.env.PUBLIC_URL}/`} className="logo-link">
            </Link>
          </div>
          
          <PreviewCard className="card-bordered" bodyClass="card-inner">
            <BlockHead>
            <div className="logo-div">
                <img className="logo" src={Logo} alt="fmdq logo"/>
                <h4>Members Registration Oversight Information System (MROIS)</h4>
              {/* <h2>{`${process.env.REACT_APP_APP_API}`}</h2> */}
            </div>
            </BlockHead>
            <form form={register}  initialValues={{ remember: true, }} className="is-alter" onSubmit={handleSubmit(handleFormSubmit)}>
              <div className="d-flex flex-row g-4" >
                <div className="form-group w-50">
                <label className="form-label" >
                 First Name
                </label>
                <div className="form-control-wrap">
                  <input
                    type="text"
                    {...register('firstName', { required: true })}
                    placeholder="Enter your first name"
                    className="form-control-lg form-control" />
                  {errors.firstName && <p className="invalid">First Name field is required</p>}
                </div>
              </div>
              <div className="form-group w-50">
                <label className="form-label" >
                 Last Name
                </label>
                <div className="form-control-wrap">
                  <input
                    type="text"
                    {...register('lastName', { required: true })}
                    placeholder="Enter your last name"
                    className="form-control-lg form-control" />
                  {errors.lastName && <p className="invalid">Last Name field is required</p>}
                </div>
              </div>
              </div>
            
              <div className="d-flex flex-row g-4" >
                <div className="form-group w-50">
                    <div className="form-label">
                      <label for="nationality">Nationality:</label>
                    </div>
              <div className="form-control-wrap">
                <div className="form-control-select">
                    <select className="form-control form-select" {...register('nationality', { required: true })}>
                      <option value="">Select A Country</option>
                      {Countries && Countries?.map((country) => (
                        <option key={country} value={country}>
                          {country}
                        </option>
                      ))}
                    </select>
                    
                    {errors.nationality && <p className="invalid">Country field is required</p>}
                  </div>
                  </div>
                </div>
                <div className="form-group w-50">
                    <div className="form-label">
                      <label for="category">Membership Category:</label>
                    </div>
                <div className="form-control-wrap">
                  <div className="form-control-select">
                    <select 
                    className="form-control form-select" style={{width: '100%'}}  {...register('category', { required: true })}>
                      <option value="">Select A Category</option>
                      {Categories && Categories?.map((category) => (
                        <option key={category.key} value={category.key}>
                          {category.value}
                        </option>
                      ))}
                    </select>
                    {errors.category && <p className="invalid">Category field is required</p>}
                    </div>
                  </div>
                </div>
                
              </div>

              <div className="form-group">
                <div className="form-label-group">
                  <label className="form-label" >
                    Email
                  </label>
                </div>
                <div className="form-control-wrap">
                  <input
                    type="email"
                    bssize="lg"
                    {...register('email', { required: true })}
                    className="form-control-lg form-control"
                    placeholder="Enter your email address" />
                  {errors.email && <p className="invalid">Email field is required</p>}
                </div>
              </div>
              <div className="d-flex flex-row g-4">
                <div className="form-group w-50">
                  <div className="form-label-group">
                    <label className="form-label" >
                      Password
                    </label>
                  </div>
                  <div className="form-control-wrap">
                    <a
                      href="#password"
                      onClick={(ev) => {
                        ev.preventDefault();
                        setPassState(!passState);
                      }}
                      className={`form-icon lg form-icon-right passcode-switch ${passState ? "is-hidden" : "is-shown"}`}
                    >
                      <Icon name="eye" className="passcode-icon icon-show"></Icon>

                      <Icon name="eye-off" className="passcode-icon icon-hide"></Icon>
                    </a>
                    <input
                      type={passState ? "text" : "password"}
                      id="password"
                      {...register('password', { required: "This field is required" })}
                      placeholder="Enter your password"
                      className={`form-control-lg form-control ${passState ? "is-hidden" : "is-shown"}`} />
                    {errors.password && <span className="invalid">{errors.password.message}</span>}
                  </div>
                </div>
                <div className="form-group w-50">
                  <div className="form-label-group">
                    <label className="form-label">
                      Retype Password
                    </label>
                  </div>
                  <div className="form-control-wrap">
                    <a
                      href="#con_password"
                      onClick={(ev) => {
                        ev.preventDefault();
                        setPassState(!passState);
                      }}
                      className={`form-icon lg form-icon-right passcode-switch ${passState ? "is-hidden" : "is-shown"}`}
                    >
                      <Icon name="eye" className="passcode-icon icon-show"></Icon>

                      <Icon name="eye-off" className="passcode-icon icon-hide"></Icon>
                    </a>
                    <input
                      type={passState ? "text" : "password"}
                      id="con_password"
                      {...register('password', { required: "This field is required" })}
                      placeholder="Confirm your password"
                      className={`form-control-lg form-control ${passState ? "is-hidden" : "is-shown"}`} />
                    {errors.passcode && <span className="invalid">{errors.passcode.message}</span>}
                  </div>
                </div>
              </div>

              <div className="checkbox-flex">
                <input type="checkbox"/>
                <p>I have read, understood and accepted Terms and Conditions</p>
              </div>
              
              <div className="form-group">
                <Button type="submit" color="primary" size="lg" className="btn-block">
                  {loading ? <Spinner size="sm" color="light" /> : "Register"}
                </Button>
              </div>
            </form>
            <div className="form-note-s2 text-center pt-4">
              {" "}
              Already have an account?{" "}
              <Link to={`${process.env.PUBLIC_URL}/login`}>
                <strong>Sign in instead</strong>
              </Link>
            </div>
          </PreviewCard>
        </Block>
    </div>
  </>;
};
export default Register;
