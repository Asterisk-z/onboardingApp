import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate,Link } from "react-router-dom";
import { Spinner } from "reactstrap";
import { useForm } from "react-hook-form";
import Head from "layout/head/Head";
import { Block, BlockContent, BlockHeadContent, BlockDes, BlockHead, BlockTitle, Button, PreviewCard } from "../../components/Component";
import Logo from "images/fmdq/FMDQ-Logo.png";
import { passwordResetInitiate, passwordResetOtp } from "./../../redux/stores/authenticate/authStore";

const ForgotPassword = () => {

  const [loading, setLoading] = useState(false);
  const [mailSent, setMailSent] = useState(false);
  const [passState, setPassState] = useState(false);
  const [errorVal, setError] = useState("");
  const navigate = useNavigate();

  const dispatch = useDispatch();
  
  const { register, handleSubmit, formState: { errors } } = useForm();
  

  const handleFormSubmit = async (formData) => {
    setLoading(true);
    
      try {
        setLoading(true);
        if (formData.email && formData.otp) {
          const resp = await dispatch(passwordResetOtp(formData));
          
          if (resp.payload?.message == "success") {
            setTimeout(() => {
              navigate(`${process.env.PUBLIC_URL}/auth-password-update`);
              setLoading(false);
            }, 1000);
              setLoading(false);
          }
        } else {

          const resp = await dispatch(passwordResetInitiate(formData));
          
          if (resp.payload?.message == "success") {
              localStorage.setItem('reset-password-email', formData.email)
              setMailSent(true)
              setLoading(false);
          }
        }
        console.log(formData)
        
        // if (resp.payload?.message == "success") {
        //     localStorage.setItem('reset-password-email', formData.email)
            // setTimeout(() => {
            //   navigate(`${process.env.PUBLIC_URL}/auth-otp-check`);
            //   setLoading(false);
            // }, 1000);
            
          
        //   setLoading(false);
        // } else {
        //   setLoading(false);
        // }
        setLoading(false);
      } catch (error) {
        setLoading(false);
        setTimeout(() => {
          // setError("Cannot login with credentials");
          setLoading(false);
        }, 1000);
      }
  };
  
  return (
    <>
      <Head title="Forgot-Password" />
      <div className="login-block">
        <Block className="nk-block-middle nk-auth-body  wide-xs">
          <PreviewCard className="card-bordered" bodyClass="card-inner-lg">
            <BlockHead>
              <BlockContent>
                <div className="logo-div">
                  <img className="logo" src={Logo} alt="fmdq logo"/>
                  <h4>Members Registration Oversight Information System (MROIS)</h4>
                </div>
                <BlockTitle tag="h5">Reset password</BlockTitle>
                <BlockDes>
                  <p>If you forgot your password, well, then we’ll email you instructions to reset your password.</p>
                </BlockDes>
              </BlockContent>
            </BlockHead>
            <form onSubmit={handleSubmit(handleFormSubmit)}>
              <div className="form-group">
                <div className="form-label-group">
                  <label className="form-label">
                    Email
                  </label>
                </div>
                <input type="email"  {...register('email', { required: "This field is required" })} readOnly={mailSent} className="form-control form-control-lg" placeholder="Enter your email address" autocomplete="off" />
              </div>
              {mailSent && <div className="form-group">
                <div className="form-label-group">
                  <label className="form-label">
                    OTP
                  </label>
                </div>
                <input type="text"  {...register('otp', { required: "This field is required" })} className="form-control form-control-lg" placeholder="Enter OTP" autocomplete="off"/>
              </div>}
              <div className="form-group">
                <Button color="primary" size="lg" type="submit" className="btn-block" >
                  {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Send Reset Link"}
                </Button>
              </div>
            </form>
            <div className="form-note-s2 text-center pt-4">
              <Link to={`${process.env.PUBLIC_URL}/login`}>
                <strong>Return to login</strong>
              </Link>
            </div>
          </PreviewCard>
        </Block>
      </div>
    </>
  );
};
export default ForgotPassword;
