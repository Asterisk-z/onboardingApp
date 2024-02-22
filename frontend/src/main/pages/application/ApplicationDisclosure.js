import React, { useState, useRef, useEffect, forwardRef } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { BlockContent, BlockTitle, Icon } from "components/Component";
import { Steps, Step } from "react-step-builder";
import { Row, Col, Button, Input } from "reactstrap";
import { HeaderLogo } from "pages/components/HeaderLogo";
import DatePicker from "react-datepicker";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import { loadPageFields, fetchApplication, completeApplication, fetchInitialApplication } from "redux/stores/membership/applicationStore";
import moment from 'moment';
import Swal from "sweetalert2";



const Header = (props) => {
    return (
        <div className="steps clearfix">
            <ul>
            </ul>
        </div>
    );
};



const config = {
    before: Header,
};

const Form = () => {


    const authUser = useUser();
    const authUserUpdate = useUserUpdate();

    const styles = {
        color: {
            marginBottom: "10px",
        },
        scroll: {
            overFlow: "scroll",
        },
        card: {
            backgroundColor: "#fff",
            margin: "50px 30px",
            padding: "20px"
        }

    }
    const dispatch = useDispatch();
    const { application_uuid } = useParams();
    const application_details = useSelector((state) => state?.application?.application_details) || null;
    const initial_application = useSelector((state) => state?.application?.initial_application) || null;

    useEffect(() => {
        if (application_uuid) {
            dispatch(fetchApplication({ "application_uuid": application_uuid }));
        }
    }, [dispatch]);

    const $application_details = application_details ? JSON.parse(application_details) : null;

    useEffect(() => {
        if (!$application_details?.disclosure_stage) {
            dispatch(fetchInitialApplication({ "application_uuid": application_uuid }));
        }
    }, [$application_details]);


    const $initial_application = initial_application ? JSON.parse(initial_application) : null;

    const ApplicantInformation = (props) => {

        const navigate = useNavigate();

        const authUser = useUser();
        const authUserUpdate = useUserUpdate();

        const dispatch = useDispatch();

        const [parentState, setParentState] = useState('Initial state');
        const [loading, setLoading] = useState(false);
        const [modalForm, setModalForm] = useState(false);

        const { reset, register, handleSubmit, formState: { errors }, setValue, clearErrors } = useForm();
        const fields = useSelector((state) => state?.application?.all_fields) || null;



        // useEffect(() => {
        //     if ($application_details) {
        //         dispatch(loadPageFields({ "page": "1", "category": $application_details?.membership_category?.id, "application_id": $application_details?.id }));
        //     }
        // }, [dispatch, parentState, $application_details]);


        const onInputChange = () => {

            Swal.fire({
                title: "Are you sure?",
                text: "Do you want to submit application!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, submit it!",
            }).then((result) => {

                if (result.isConfirmed) {

                    submitApplication()

                }
            });

        };


        const submitApplication = async () => {
            try {

                const resp = await dispatch(completeApplication({ 'application_id': $application_details?.id }));

                if (resp.payload?.message == "success") {
                    setParentState(Math.random())
                    navigate(`${process.env.PUBLIC_URL}/dashboard`)
                } else {
                    navigate(`${process.env.PUBLIC_URL}/dashboard`)
                }

            } catch (error) {

            }
        };

        const submitForm = (data) => {

        };

        // console.log(authUser.user_data.institution);

        return (

                <div>


                <table className="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Name</th>
                            <th scope="col" className="width-30">Value</th>
                            <th scope="col" >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {/* {$user_application} */}
                        {$initial_application?.application_requirements && $initial_application?.application_requirements?.map((initial_application_item, index) => (
                            <tr key={index}>
                                <th scope="row">{++index}</th>
                                <td>{initial_application_item.field.description}</td>
                                <td>
                                    {initial_application_item.uploaded_file != null ? <>
                                        <a className="btn btn-primary" href={initial_application_item.file_path} target="_blank">View File </a>
                                    </> : <>
                                        {initial_application_item.uploaded_field}
                                    </>}
                                </td>
                                <td>
                                    <Button className="btn btn-secondary" title="By clicking this button, you confirm acceptance of the existing document" onClick={(e) => onInputChange({ 'field_name': initial_application_item?.field?.name, "field_value": initial_application_item?.uploaded_field, "field_type": initial_application_item?.type })} >Move</Button>
                                </td>
                            </tr>

                        ))}
                    </tbody>
                </table>

                    <div>
                        <button className="btn btn-primary">Update Record</button>
                    </div>
                
                </div>

        );
    };


    return <>
        <Head title="Form" />
        <HeaderLogo />

        <Content>
            <Content>
                <div className="">
                    <div style={{ 'margin': '0px 10px !important' }}>
                        <div style={styles.card}>
                            <div style={styles.color}>
                                {$application_details && <h3>{`${$application_details.membership_category.name} Application`} </h3>}
                                <p>Move data to new membership category</p>
                            </div>
                            <div className="nk-wizard nk-wizard-simple is-alter wizard clearfix">
                                <Steps config={config}>
                                    <Step component={ApplicantInformation} />
                                </Steps>
                            </div>
                        </div>
                    </div>
                </div>
            </Content>
        </Content>

    </>;
};
// type="submit"
export default Form;

