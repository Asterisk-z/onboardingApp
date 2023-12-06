import React, { useState } from "react";
import { useNavigate } from "react-router-dom";
import Logo from "../../images/logo.png";
import LogoDark from "../../images/logo-dark.png";
import Head from "../../layout/head/Head";
import AuthFooter from "../../pages/auth/AuthFooter";
import {
  Block,
  BlockContent,
  BlockDes,
  BlockHead,
  BlockTitle,
  Button,
  Icon,
  PreviewCard,
} from "../../components/Component";
import { Spinner } from "reactstrap";
import { useForm } from "react-hook-form";
import { Link } from "react-router-dom";

const Register = () => {
  const [passState, setPassState] = useState(false);
  const [loading, setLoading] = useState(false);
  const { register, handleSubmit, formState: { errors } } = useForm();
  const navigate = useNavigate();
  const handleFormSubmit = () => {
    setLoading(true);
    setTimeout(() => {
      navigate(`${process.env.PUBLIC_URL}/auth-success`);
    }, 1000);
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
              <BlockContent>
                <BlockTitle tag="h4">Register</BlockTitle>
              </BlockContent>
            </BlockHead>
            <form className="is-alter" onSubmit={handleSubmit(handleFormSubmit)}>
              <div className="d-flex flex-row g-4" >
                <div className="form-group w-50">
                <label className="form-label" htmlFor="name">
                 First Name
                </label>
                <div className="form-control-wrap">
                  <input
                    type="text"
                    id="name"
                    {...register('name', { required: true })}
                    placeholder="Enter your first name"
                    className="form-control-lg form-control" />
                  {errors.name && <p className="invalid">This field is required</p>}
                </div>
              </div>
              <div className="form-group w-50">
                <label className="form-label" htmlFor="name">
                 Last Name
                </label>
                <div className="form-control-wrap">
                  <input
                    type="text"
                    id="name"
                    {...register('name', { required: true })}
                    placeholder="Enter your last name"
                    className="form-control-lg form-control" />
                  {errors.name && <p className="invalid">This field is required</p>}
                </div>
              </div>
              </div>
              
              <div className="d-flex flex-row g-4" >
                <div className="form-group w-50">
                    <div className="form-label">
                      <label for="cars">Nationality:</label>
                    </div>
                    <select className="w-100"  name="cars" id="cars">
                      
                    </select>
                </div>
                <div className="form-group w-50">
                    <div className="form-label">
                      <label for="cars">Membership Category:</label>
                    </div>
                    <select className="w-100" style={{width: '100%'}} name="cars" id="cars">
                      
                    </select>
                </div>
                
              </div>

              <div className="form-group">
                <div className="form-label-group">
                  <label className="form-label" htmlFor="default-01">
                    Email
                  </label>
                </div>
                <div className="form-control-wrap">
                  <input
                    type="text"
                    bssize="lg"
                    id="default-01"
                    {...register('email', { required: true })}
                    className="form-control-lg form-control"
                    placeholder="Enter your email address" />
                  {errors.email && <p className="invalid">This field is required</p>}
                </div>
              </div>
              <div className="d-flex flex-row g-4">
                <div className="form-group w-50">
                  <div className="form-label-group">
                    <label className="form-label" htmlFor="password">
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
                      {...register('passcode', { required: "This field is required" })}
                      placeholder="Enter your password"
                      className={`form-control-lg form-control ${passState ? "is-hidden" : "is-shown"}`} />
                    {errors.passcode && <span className="invalid">{errors.passcode.message}</span>}
                  </div>
                </div>
                <div className="form-group w-50">
                  <div className="form-label-group">
                    <label className="form-label" htmlFor="password">
                      Retype Password
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
                      {...register('passcode', { required: "This field is required" })}
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
