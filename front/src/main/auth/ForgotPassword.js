import React from "react";
import Logo from "../../images/logo.png";
import LogoDark from "../../images/logo-dark.png";
import Head from "../../layout/head/Head";
import AuthFooter from "../../pages/auth/AuthFooter";
import { Block, BlockContent, BlockDes, BlockHead, BlockTitle, Button, PreviewCard } from "../../components/Component";
import { Link } from "react-router-dom";

const ForgotPassword = () => {
  return (
    <>
      <Head title="Forgot-Password" />
      <div className="login-block">
        <Block className="nk-block-middle nk-auth-body  wide-xs">
          <PreviewCard className="card-bordered" bodyClass="card-inner-lg">
            <BlockHead>
              <BlockContent>
                <BlockTitle tag="h5">Reset password</BlockTitle>
                <BlockDes>
                  <p>If you forgot your password, well, then we’ll email you instructions to reset your password.</p>
                </BlockDes>
              </BlockContent>
            </BlockHead>
            <form>
              <div className="form-group">
                <div className="form-label-group">
                  <label className="form-label" htmlFor="default-01">
                    Email
                  </label>
                </div>
                <input
                  type="text"
                  className="form-control form-control-lg"
                  id="default-01"
                  placeholder="Enter your email address"
                />
              </div>
              <div className="form-group">
                <Button color="primary" size="lg" className="btn-block" onClick={(ev) => ev.preventDefault()}>
                  Send Reset Link
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
