import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, Link } from "react-router-dom";
import { Spinner } from "reactstrap";
import { useForm } from "react-hook-form";
import Head from "layout/head/Head";
import { Block, BlockContent, BlockHeadContent, BlockDes, BlockHead, BlockTitle, Button, PreviewCard } from "../../components/Component";
import Logo from "images/fmdq/FMDQ-Logo.png";
import { stakeHolderAccess } from "./../../redux/stores/authenticate/authStore";

const StakeHolderRequest = () => {

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
            const data = new FormData()
            data.append('email', formData.email)
            data.append('access', "AR-REPORT")

            const resp = await dispatch(stakeHolderAccess(data));

            if (resp.payload?.message == "success") {
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

    return (
        <>
            <Head title="Forgot-Password" />
            <div className="login-block">
                <Block className="nk-block-middle nk-auth-body  wide-xs">
                    <PreviewCard className="card-bordered" bodyClass="card-inner-lg">
                        <BlockHead>
                            <BlockContent>
                                <div className="logo-div">
                                    <img className="logo" src={Logo} alt="fmdq logo" />
                                    <h4>Member Regulation and Oversight Information System (MROIS)</h4>
                                </div>
                                <BlockTitle tag="h5">FMDQ internal stakeholder access request</BlockTitle>
                                <BlockDes>
                                    {/* <p></p> */}
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
                                <input type="email"  {...register('email', { required: "This field is required" })} readOnly={mailSent} className="form-control form-control-lg" placeholder="Enter your email address" autoComplete="off" />
                            </div>
                            <div className="form-group">
                                <Button color="primary" size="lg" type="submit" className="btn-block" >
                                    {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Request Access"}
                                </Button>
                            </div>
                        </form>
                    </PreviewCard>
                </Block>
            </div>
        </>
    );
};
export default StakeHolderRequest;
