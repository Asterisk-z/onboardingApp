import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import Head from "../../layout/head/Head";
import { registerUser } from "./../../redux/stores/authenticate/authStore";
import { loadAllActiveCategories } from "./../../redux/stores/memberCategory/category";
import { loadAllCountries } from "./../../redux/stores/nationality/country";
import { loadAllCategoryPositions } from "redux/stores/positions/positionStore";
import { Block, BlockHeadContent, BlockHead, BlockTitle, Button, Icon, PreviewCard } from "../../components/Component";
import { Spinner } from "reactstrap";
import { useForm } from "react-hook-form";
import { Link } from "react-router-dom";
import Logo from "../../images/fmdq/FMDQ-Logo.png";

const Register = ({ drawer }) => {

    const dispatch = useDispatch();
    const [passState, setPassState] = useState(false);
    const [loading, setLoading] = useState(false);
    const [digitalPhoto, setDigitalPhoto] = useState([]);
    const { register, handleSubmit, formState: { errors }, getValues, setError, clearErrors } = useForm();
    const navigate = useNavigate();
    const [categoryIds, setCategoryIds] = useState([1]);

    const categories = useSelector((state) => state?.category?.list) || null;
    const countries = useSelector((state) => state?.country?.list) || null;
    const positions = useSelector((state) => state?.position?.list) || null;
      
    const handleFormSubmit = async (values) => {
    
      try {
        setLoading(true);
        const formData = new FormData();
        formData.append('firstName', values.firstName)
        formData.append('lastName', values.lastName)
        formData.append('nationality', values.nationality)
        formData.append('position', values.position)
        formData.append('category', values.category)
        formData.append('email', values.email)
        formData.append('phone', values.phone)
        formData.append('password', values.password)
        formData.append('confirm_password', values.confirm_password)
        
        const resp = await dispatch(registerUser(formData));

        if (resp.payload?.message == "success") {
            setTimeout(() => {
              navigate(`${process.env.PUBLIC_URL}/login`);
              setLoading(false);
            }, 1000);
          
        } else {
          setLoading(false);
        }
      } catch (error) {
        setLoading(false);
      }

    };

    useEffect(() => {
      dispatch(loadAllActiveCategories());
      dispatch(loadAllCountries());
    }, [dispatch]);
    
     useEffect(() => {
        dispatch(loadAllCategoryPositions({'category_ids' : categoryIds}));
    }, [categoryIds]);
  
    const $categories = categories ? JSON.parse(categories) : null;
    const $countries = countries ? JSON.parse(countries) : null;
    const $positions = positions ? JSON.parse(positions) : null;

    const passwordPolicy = (event) => {
      
        const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]).{8,}$/;
        const isValidPassword = passwordRegex.test(getValues('password'));
        
        if (!isValidPassword) {
            setError("password", { type: "password",  message: "Uppercase, lowercase, numbers and 8 characters"  }, { shouldFocus: false })
            return
        }
        if (getValues('confirm_password') !== getValues('password')) {
            setError("password", { type: "password",  message: "Password does not match"  }, { shouldFocus: false })
            setError("confirm_password", { type: "confirm_password",  message: "Password does not match"  }, { shouldFocus: false })
            return
        }
      
        clearErrors('password')
        clearErrors('confirm_password')
        
    }
    
    const handleFileChange = (event) => {
		setDigitalPhoto(event.target.files[0]);
    };
    
    const updatePosition = (event) => {
        if (event.target.value) {
            setCategoryIds([event.target.value])
        }
    }

    
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
              <img className="logo" src={Logo} alt="fmdq logo" />
                <h4>Members Registration Oversight Information System (MROIS) Sign Up Form</h4>
            </div>
            </BlockHead>
            <form  className="is-alter" onSubmit={handleSubmit(handleFormSubmit)} encType="multipart/form-data">
                <div className="d-flex flex-row g-4" >
                    <div className="form-group w-50">
                        <label className="form-label" >
                            First Name<span style={{color:'red'}}> *</span>
                        </label>
                        <div className="form-control-wrap">
                            <input type="text" {...register('firstName', { required: true })} placeholder="Enter your first name" className="form-control-lg form-control" />
                            {errors.firstName && <p className="invalid">First Name field is required</p>}
                        </div>
                    </div>
                    <div className="form-group w-50">
                        <label className="form-label" >
                            Last Name<span style={{color:'red'}}> *</span>
                        </label>
                        <div className="form-control-wrap">
                            <input type="text" {...register('lastName', { required: true })} placeholder="Enter your last name" className="form-control-lg form-control" />
                            {errors.lastName && <p className="invalid">Last Name field is required</p>}
                        </div>
                    </div>
                </div>
                <div className="d-flex flex-row g-4" >
                    <div className="form-group w-100">
                        <div className="form-label">
                            <label for="nationality">Nationality<span style={{color:'red'}}> *</span>:</label>
                        </div>
                        <div className="form-control-wrap">
                            <div className="form-control-select">
                                <select className="form-control form-select" {...register('nationality', { required: true })}>
                                    <option value="">Select A Country</option>
                                    {$countries && $countries?.map((country) => (
                                        <option key={country.code} value={country.code}>
                                            {country.name}
                                        </option>
                                    ))}
                                </select>
                                {errors.nationality && <p className="invalid">Country field is required</p>}
                            </div>
                        </div>
                    </div>
                </div>
            
                <div className="d-flex flex-row g-4" >
                    <div className="form-group w-50">
                        <div className="form-label">
                            <label for="category">Membership Category<span style={{color:'red'}}> *</span>:</label>
                        </div>
                        <div className="form-control-wrap">
                            <div className="form-control-select">
                                <select className="form-control form-select" style={{width: '100%'}}  {...register('category', { required: true })}  onChange={updatePosition}>
                                    <option value="">Select A Category</option>
                                    {$categories && $categories?.map((category) => (
                                        <option key={category.id} value={category.id}>
                                            {category.name}
                                        </option>
                                    ))}
                                </select>
                                {errors.category && <p className="invalid">Category field is required</p>}
                            </div>
                        </div>
                    </div>
                    <div className="form-group w-50">
                        <div className="form-label">
                            <label for="nationality">Position<span style={{color:'red'}}> *</span>:</label>
                        </div>
                        <div className="form-control-wrap">
                            <div className="form-control-select">
                                <select className="form-control form-select" {...register('position', { required: true })}>
                                    <option value="">Select A Position</option>
                                    {$positions && $positions?.map((position, index) => (
                                        <option key={index} value={position.id}>
                                            {position.name}
                                        </option>
                                    ))}
                                </select>
                                {errors.position && <p className="invalid">Position is required</p>}
                            </div>
                        </div>
                    </div>
                
                </div>

              <div className="d-flex flex-row g-4" >
                <div className="form-group w-50">
                  <div className="form-label-group">
                    <label className="form-label" >
                      Email<span style={{color:'red'}}> *</span>
                    </label>
                  </div>
                  <div className="form-control-wrap">
                    <input type="email" bssize="lg"  {...register('email', { required: true })} className="form-control-lg form-control" placeholder="Enter your email address" />
                    {errors.email && <p className="invalid">Email field is required</p>}
                  </div>
                </div>
                <div className="form-group w-50">
                  <div className="form-label-group">
                    <label className="form-label" >
                      Phone Number<span style={{color:'red'}}> *</span>
                    </label>
                  </div>
                  <div className="form-control-wrap">
                    <input type="text" bssize="lg" {...register('phone', { required: true, minLength: 11, valueAsNumber: true })} className="form-control-lg form-control" placeholder="Enter your phone number" />
                    {errors.phone && <p className="invalid">{`This field is required`}</p>}
                  </div>
                </div>
              </div>
              
              {/* type,message,ref */}
              <div className="d-flex flex-row g-4">
                <div className="form-group w-50">
                  <div className="form-label-group">
                    <label className="form-label" >
                      Password<span style={{color:'red'}}> *</span>
                    </label>
                  </div>
                  <div className="form-control-wrap">
                    <a href="#password" onClick={(ev) => {   ev.preventDefault();   setPassState(!passState); }} className={`form-icon lg form-icon-right passcode-switch ${passState ? "is-hidden" : "is-shown"}`}>
                      <Icon name="eye" className="passcode-icon icon-show"></Icon>
                      <Icon name="eye-off" className="passcode-icon icon-hide"></Icon>
                    </a>
                    <input type={passState ? "text" : "password"} id="password" onKeyUp={passwordPolicy} {...register('password', { required: "This field is required" })} placeholder="Enter your password" className={`form-control-lg form-control ${passState ? "is-hidden" : "is-shown"}`} />
                    {errors.password && <span className="invalid">{errors.password.message}</span>}
                  </div>
                </div>
                <div className="form-group w-50">
                  <div className="form-label-group">
                    <label className="form-label">
                      Retype Password<span style={{color:'red'}}> *</span>
                    </label>
                  </div>
                  <div className="form-control-wrap">
                    <a
                      href="#confirm_password"
                      onClick={(ev) => {
                        ev.preventDefault();
                        setPassState(!passState);
                      }}
                      className={`form-icon lg form-icon-right passcode-switch ${passState ? "is-hidden" : "is-shown"}`}
                    >
                      <Icon name="eye" className="passcode-icon icon-show"></Icon>
                      <Icon name="eye-off" className="passcode-icon icon-hide"></Icon>
                    </a>
                    <input  type={passState ? "text" : "password"}  id="confirm_password"  {...register('confirm_password', { required: "This field is required" })}  onKeyUp={passwordPolicy}  placeholder="Confirm your password"  className={`form-control-lg form-control ${passState ? "is-hidden" : "is-shown"}`} />
                    {errors.passcode && <span className="invalid">{errors.passcode.message}</span>}
                  </div>
                </div>
              </div>

              {/* <div className="checkbox-flex">
                <input type="checkbox" />
                <p>I have read, understood and accepted Terms and Conditions</p>
              </div> */}
              
              <div className="form-group">
                <Button type="submit" color="primary" size="lg" className="btn-block">
                {loading ? ( <span><Spinner size="sm" color="light" /> Processing...</span>) : "Register"}
                </Button>
              </div>
            </form>
            <div className="form-note-s2 text-center pt-4">
              {" "}
              Already have an account?{" "}
              <Link to={`${process.env.PUBLIC_URL}/login`}>
                <strong>Log in</strong>
              </Link>
            </div>
          </PreviewCard>
        </Block>
    </div>
  </>;
};
export default Register;
