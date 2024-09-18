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



    return <>


        <div className="form-note-s2 text-center pt-2">
            Learn more about FMDQ Membership <Link to={`https://fmdqgroup.com/exchange/membership/`} target="blank">Category</Link> and <Link to={`https://fmdqgroup.com/exchange/membership/`} target="blank">Requirements</Link>
        </div>
    </>;
};
export default Register;
