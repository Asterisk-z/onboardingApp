import React from "react";
import Logomain from "../../images/fmdq/FMDQ-Logo.png"
import LogoSmall from "../../images/fmdq/fmdqg_logo_cca-removebg-preview.png";
import {Link} from "react-router-dom";

const Logo = () => {
  const styles = {
    width: {
      color: "200px",
    },
    
  }
  return (
    <Link to={`${process.env.PUBLIC_URL}/`} className="logo-link">
      <img className={styles.width} src={Logomain} alt="logo" />
      {/* <img className="logo-small logo-img logo-img-small" src={LogoSmall} alt="logo" /> */}
    </Link>
  );
};

export default Logo;
