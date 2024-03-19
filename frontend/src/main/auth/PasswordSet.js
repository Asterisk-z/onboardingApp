import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate,Link, useParams, useSearchParams } from "react-router-dom";
import { Spinner } from "reactstrap";
import { useForm } from "react-hook-form";
import Head from "layout/head/Head";
import { Block, BlockContent, BlockHeadContent, BlockDes, BlockHead, BlockTitle, Button, PreviewCard, Icon } from "../../components/Component";
import Logo from "images/fmdq/FMDQ-Logo.png";
import { passwordSetComplete } from "redux/stores/authenticate/authStore";

const PasswordSet = () => {

  const [searchParams, setSearchParams] = useSearchParams();
  const email = searchParams.get('email');
  const [loading, setLoading] = useState(false);
  const [passState, setPassState] = useState(false);
  const navigate = useNavigate();

  const dispatch = useDispatch();

  const { register, handleSubmit, formState: { errors }, setValue,  getValues, setError, clearErrors } = useForm();
  

  const handleFormSubmit = async (formData) => {
      setLoading(true);
    
      if(getValues('new_password') != getValues('password')) {
          setLoading(false);
          setError("password", { type: "password",  message: "Password does not match"  }, { shouldFocus: false })
          return
      }
      
      try {
          setLoading(true);
          
          const postValues = new Object();
          postValues.email = searchParams.get('email');
          postValues.signature = searchParams.get('signature');
          postValues.password = formData.password;

          const resp = await dispatch(passwordSetComplete(postValues));
          
          if (resp.payload?.message == "success") {
              setTimeout(() => {
                navigate(`${process.env.PUBLIC_URL}/login`);
                setLoading(false);
              }, 1000);
              setLoading(false);
          } else {
          setLoading(false);
        }
        setLoading(false);
      } catch (error) {
        setLoading(false);
        setTimeout(() => {
          // setError("Cannot login with credentials");
          setLoading(false);
        }, 1000);
      }
  };

      const passwordPolicy = (event) => {
      
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/;
        const isValidPassword = passwordRegex.test(getValues('password'));
        
        if (!isValidPassword) {
            setError("password", { type: "password",  message: "Uppercase, lowercase, numbers and 8 characters"  }, { shouldFocus: false })
            return
        }
        if (getValues('new_password') != getValues('password')) {
            setError("password", { type: "password",  message: "Password does not match"  }, { shouldFocus: false })
            setError("new_password", { type: "new_password",  message: "Password does not match"  }, { shouldFocus: false })
            return
        }
        
        clearErrors('password')
        clearErrors('new_password')
    }
  
  return (
    <>
      <Head title="Update-Password" />
      <div className="login-block">
        <Block className="nk-block-middle nk-auth-body  wide-xs">
          <PreviewCard className="card-bordered" bodyClass="card-inner-lg">
            <BlockHead>
              <BlockContent>
                <div className="logo-div">
                  <img className="logo" src={Logo} alt="fmdq logo"/>
                  <h4>Members Registration Oversight Information System (MROIS)</h4>
                </div>
                <BlockTitle tag="h5">Create  password</BlockTitle>
                <BlockDes>
                  <p></p>
                </BlockDes>
              </BlockContent>
            </BlockHead>
            <form onSubmit={handleSubmit(handleFormSubmit)}>
              <div className="form-group">
                <div className="form-label-group">
                  <label className="form-label">
                    Email<span style={{ color: 'red' }}> *</span>
                  </label>
                </div>
                <div className="form-control-wrap">
                <input type="email"  value={email} readOnly className="form-control form-control-lg" placeholder="Enter your email address"/>
                 </div>
              </div>
             <div className="form-group">
                <div className="form-label-group">
                  <label className="form-label">
                    Password
                  </label>
                </div>
                <div className="form-control-wrap">
                    <a href="#password" onClick={(ev) => {   ev.preventDefault();   setPassState(!passState); }} className={`form-icon lg form-icon-right passcode-switch ${passState ? "is-hidden" : "is-shown"}`}>
                      <Icon name="eye" className="passcode-icon icon-show"></Icon>
                      <Icon name="eye-off" className="passcode-icon icon-hide"></Icon>
                    </a>
                    <input type={passState ? "text" : "password"} id="password" onKeyUp={passwordPolicy} {...register('password', { required: "This field is required" })} autoComplete="off" placeholder="Enter your password" className={`form-control-lg form-control ${passState ? "is-hidden" : "is-shown"}`} />
                    {errors.password && <span className="invalid">{errors.password.message}</span>}
                  </div>
            </div>
              <div className="form-group">
                <div className="form-label-group">
                  <label className="form-label">
                    Confirm Password
                  </label>
                </div>
                
                <div className="form-control-wrap">
                  <a
                    href="#new_password"
                    onClick={(ev) => {
                      ev.preventDefault();
                      setPassState(!passState);
                    }}
                    className={`form-icon lg form-icon-right passcode-switch ${passState ? "is-hidden" : "is-shown"}`}
                  >
                    <Icon name="eye" className="passcode-icon icon-show"></Icon>
                    <Icon name="eye-off" className="passcode-icon icon-hide"></Icon>
                  </a>
                  <input  type={passState ? "text" : "password"}  id="new_password"  {...register('new_password', { required: "This field is required" })}  onKeyUp={passwordPolicy} autoComplete="off" placeholder="Confirm your password"  className={`form-control-lg form-control ${passState ? "is-hidden" : "is-shown"}`} />
                  {errors.passcode && <span className="invalid">{errors.new_password.message}</span>}
                </div>
              </div>
              <div className="form-group">
                <Button color="primary" size="lg" type="submit" className="btn-block" >
                  {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Set Password"}
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
export default PasswordSet;
