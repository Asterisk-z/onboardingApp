import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import Logo from "../../images/fmdq/FMDQ-Logo.png";
import Head from "../../layout/head/Head";
import { Block, BlockContent, BlockDes, BlockHead, BlockTitle, Button, Icon, PreviewCard } from "../../components/Component";
import { Form, Spinner, Alert, Modal, ModalBody, ModalFooter } from "reactstrap";
import {} from "reactstrap"
import { useForm } from "react-hook-form";
import { Link } from "react-router-dom";
import { AiOutlineArrowRight } from "react-icons/ai";
import { useNavigate } from 'react-router-dom';
import { loginUser } from "./../../redux/stores/authenticate/authStore";


const Login = () => {
  const [modalSuccess, setModalSuccess] = useState(false);
  const toggleSuccess = () => setModalSuccess(!modalSuccess);

  const [loading, setLoading] = useState(false);
  const [passState, setPassState] = useState(false);
  const [errorVal, setError] = useState("");
  const navigate = useNavigate();

  const dispatch = useDispatch();
  
  const { register, handleSubmit, formState: { errors } } = useForm();
  
  const handleProceed = () => navigate(process.env.PUBLIC_URL+'/form');
  

  const handleFormSubmit = async (formData) => {
    setLoading(true);
    
      try {
        setLoading(true);
        
        const resp = await dispatch(loginUser(formData));
  
        if (resp.payload?.message == "success") {
              localStorage.getItem('reset-password-email')
              setTimeout(() => {
                
                window.location.href = `${process.env.PUBLIC_URL}/dashboard`
                setLoading(false);
              }, 1000);
          
          setLoading(false);
        } else {
          
          setLoading(false);
        }
      } catch (error) {
        
        setLoading(false);
        // console.log(error)
        setTimeout(() => {
          setError("Cannot login with credentials");
          setLoading(false);
        }, 1000);
      }
  };


  return <>
    <Head title="Login" />
    <div className="login-block">
      <Block className="nk-block-middle nk-auth-body  wide-xs">
        <PreviewCard className="card-bordered" bodyClass="card-inner-lg">
          <BlockHead>
            <BlockContent>
              <div className="logo-div">
                <img className="logo" src={Logo} alt="fmdq logo"/>
                <h4>Members Registration Oversight Information System (MROIS)</h4>
              </div>
              <BlockTitle tag="h4">Log In</BlockTitle>
            </BlockContent>
          </BlockHead>
          {errorVal && (
            <div className="mb-3">
              <Alert color="danger" className="alert-icon">
                <Icon name="alert-circle" /> Unable to login with credentials{" "}
              </Alert>
            </div>
          )}
          <Form className="is-alter" onSubmit={handleSubmit(handleFormSubmit)}>
            <div className="form-group">
              <div className="form-label-group">
                <label className="form-label" >
                  Email/ID
                </label>
              </div>
              <div className="form-control-wrap">
                <input 
                  type="email"
                  {...register('email', { required: "This field is required" })}
                  placeholder="Enter your email address or username"
                  className="form-control-lg form-control" autoComplete="off" />
                {errors.email && <span className="invalid">{errors.email.message}</span>}
              </div>
            </div>
            <div className="form-group">
              <div className="form-label-group">
                <label className="form-label" >
                  Password
                </label>
                <Link className="link link-primary link-sm" to={`${process.env.PUBLIC_URL}/auth-reset`}>
                  Forgot Password?
                </Link>
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
                  placeholder="Enter your password" autoComplete="off"
                  className={`form-control-lg form-control ${passState ? "is-hidden" : "is-shown"}`} />
                {errors.password && <span className="invalid">{errors.password.message}</span>}
              </div>
            </div>
            <div className="form-group">
              <Button type="submit" size="lg" className="btn-block"  color="primary">
                {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Log in"}
              </Button>
            </div>
          </Form>
          <div className="form-note-s2 text-center pt-4">
            New on MROIS? <Link to={`${process.env.PUBLIC_URL}/privacy-policy`}>Sign Up</Link>
          </div>
        </PreviewCard>
      </Block>
    </div>
    <Modal isOpen={modalSuccess} toggle={handleProceed}>
      <ModalBody className="modal-body-lg text-center">
        <div className="nk-modal">
          <Icon className="nk-modal-icon icon-circle icon-circle-xxl ni ni-check bg-success"></Icon>
          <h4 className="nk-modal-title">Success!</h4>
          <div className="nk-modal-text">
            <div className="caption-text">
              Proceed to Application
            </div>
          </div>
          <div className="nk-modal-action">
            <Button color="primary" size="lg" className="btn-mw" onClick={handleProceed}>
              Proceed<span><AiOutlineArrowRight /></span>
            </Button>
          </div>
        </div>
      </ModalBody>
      <ModalFooter className="bg-light">
        <div className="text-center w-100">
          <p>
            Members Registration Oversight Information System (MROIS)
          </p>
        </div>
      </ModalFooter>
    </Modal>
  </>;
};
// type="submit"
export default Login;
