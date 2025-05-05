import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate, useParams } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Card, Spinner, Label, Input, CardText, CardBody, CardTitle } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadUserRoles } from "redux/stores/roles/roleStore";
import { loadAllCategoryPositions } from "redux/stores/positions/positionStore";
import { loadAllCountries } from "redux/stores/nationality/country";
import { userTransferUserAR, userViewUserAR } from "redux/stores/authorize/representative";
import { loadAllActiveAuthoriser } from "redux/stores/users/userStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import { loadAllSettings } from "redux/stores/settings/config";
import { useUser, useUserUpdate } from 'layout/provider/AuthUser';
import Swal from "sweetalert2";


const TransferAuthRepresentative = ({ drawer }) => {

    const { ar_user_id } = useParams();

    const authUser = useUser();
    const authUserUpdate = useUserUpdate();
    const categories = authUser.user_data.institution.category ? authUser.user_data.institution.category : [];
    const dispatch = useDispatch();
    const navigate = useNavigate();
    const [categoryIds, setCategoryIds] = useState(authUser.user_data.institution.category.map((cat) => cat.id));
    const [loading, setLoading] = useState(false);
    const [sm, updateSm] = useState(false);
    const [parentState, setParentState] = useState('Initial state');
    const [document, setDocument] = useState([]);
    const [signatureMandate, setSignatureMandate] = useState([]);

    const user = useSelector((state) => state?.arUsers?.single_ar) || null;
    const roles = useSelector((state) => state?.role?.list) || null;
    const positions = useSelector((state) => state?.position?.list) || null;
    const countries = useSelector((state) => state?.country?.list) || null;
    const authorizers = useSelector((state) => state?.user?.list) || null;

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const settings = useSelector((state) => state?.settings?.list) || null;


    useEffect(() => {
        dispatch(userViewUserAR({ "user_id": ar_user_id }));
        dispatch(loadUserRoles());
        dispatch(loadAllCountries());
        dispatch(loadAllActiveAuthoriser());
        dispatch(loadAllSettings({ "config": "mandate_form" }));
    }, [dispatch, parentState]);

    useEffect(() => {
        dispatch(loadAllCategoryPositions({ 'category_ids': categoryIds }));
    }, [categoryIds]);

    const $countries = countries ? JSON.parse(countries) : null;
    const $roles = roles ? JSON.parse(roles) : null;
    const $positions = positions ? JSON.parse(positions) : null;
    const $authorizers = authorizers ? JSON.parse(authorizers) : null;
    const $user = user ? JSON.parse(user) : null;

    let initValues = {
        lastName: $user?.lastName,
        firstName: $user?.firstName,
        middleName: $user?.middleName,
        groupEmail: $user?.group_email,
        email: $user?.email,
        phone: $user?.phone,
        nationality: $user?.nationality,
        position: $user?.position?.id,
        role_id: $user?.role?.id,
    };

    useEffect(() => {
        if ($user) {
            initValues = {
                lastName: $user?.lastName,
                firstName: $user?.firstName,
                middleName: $user?.middleName,
                groupEmail: $user?.group_email,
                email: $user?.email,
                phone: $user?.phone,
                nationality: $user?.nationality,
                position: $user?.position?.id,
                role_id: $user?.role?.id,
            };
        }
    }, [$user]);

    const handleFormSubmit = async (values) => {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Yes!",
        }).then((result) => {
            if (result.isConfirmed) {
                handleMainFormSubmit(values)
            }
        });

    }

    const handleMainFormSubmit = async (values) => {

        const formData = new FormData();
        formData.append('user_id', ar_user_id)
        formData.append('first_name', values.firstName)
        formData.append('middle_name', values.middleName)
        formData.append('last_name', values.lastName)
        formData.append('position_id', values.position_id)
        formData.append('nationality', values.nationality)
        formData.append('role_id', values.role)
        formData.append('email', values.email)
        formData.append('ar_authoriser_id', values.ar_authoriser_id)
        formData.append('phone', values.phone)
        formData.append('reason', values.reason)

        if (document) {
            formData.append('img', document)
        }
        if (signatureMandate) {
            formData.append('mandate_form', signatureMandate)
        }

        try {
            setLoading(true);

            const resp = await dispatch(userTransferUserAR(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    // setInitValues({
                    //     email: $user?.email,
                    //     phone: $user?.phone,
                    //     nationality: $user?.nationality,
                    //     position: $user?.position,
                    //     role_id: $user?.role.id,
                    // });

                }, 1000);

                navigate(`${process.env.PUBLIC_URL}/auth-representatives`)

                props.updateParentParent(Math.random())


            } else {
                setLoading(false);
            }

        } catch (error) {
            setLoading(false);
        }
    };


    const $settings = settings ? JSON.parse(settings) : null;



    const handleDificalFileChange = (event) => {
        setDocument(event.target.files[0]);
    };

    const handleSignaturewChange = (event) => {
        setSignatureMandate(event.target.files[0]);
    };


    return (
        <React.Fragment>
            <Head title="Pending Authorised Representative"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Transfer Authorised Representative
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>

                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>


                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        {/* <BlockTitle tag="h4">List</BlockTitle> */}
                                        {/* <p>{authorize_reps}</p> */}
                                        {/* {<p>{user}</p>} */}
                                        <div className="toggle-wrap nk-block-tools-toggle">
                                            <div className="toggle-expand-content" style={{ display: sm ? "block" : "none" }}>
                                                <ul className="nk-block-tools g-3">
                                                    <li className="nk-block-tools-opt">
                                                        <Button color="primary">
                                                            <span onClick={(ev) => navigate(`${process.env.PUBLIC_URL}/auth-representatives`)}>Cancel</span>
                                                        </Button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>

                                    <Row className="gy-4">

                                        <Col sm="6">

                                            {$user && <>

                                                <Card className="card-borderless">
                                                    <CardBody className="card-inner">
                                                        {/* <CardTitle tag="h5">{ `${$user.firstName} ${$user.lastName} (${$user.email})` }</CardTitle> */}
                                                        {/* <CardText> */}
                                                        {/* <ul>
                                                                <li><span className="lead">Phone : </span>{`${$user.phone}`}</li>
                                                                <li><span className="lead">Nationality : </span>{`${$user.nationality}`}</li>
                                                                <li><span className="lead">Role : </span>{`${$user.role.name}`}</li>
                                                                <li><span className="lead">Position : </span>{`${$user.position.name}`}</li>
                                                                <li><span className="lead">Status : </span>{`${$user.approval_status}`}</li>
                                                                <li><span className="lead">RegID : </span>{`${$user.regId}`}</li>
                                                                <li><span className="lead">Institution : </span>{`${$user.institution.name}`}</li>
                                                            </ul> */}
                                                        {/* </CardText> */}

                                                        <CardTitle tag="h5" className="text-center">
                                                            <img src={$user.img} className="rounded-xl" style={{ height: '200px', width: '200px', borderRadius: '100%' }} />
                                                        </CardTitle>

                                                        <table className="table table-striped table-bordered table-hover">
                                                            <thead>
                                                                <tr>
                                                                    <th scope="col"></th>
                                                                    <th scope="col"></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>First Name</td>
                                                                    <td className="text-capitalize">{`${$user.firstName}`}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Last Name</td>
                                                                    <td className="text-capitalize">{`${$user.lastName}`}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Email</td>
                                                                    <td className="text-lowercase">{`${$user.email}`}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Phone</td>
                                                                    <td className="text-capitalize">{`${$user.phone}`}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Nationality</td>
                                                                    <td className="text-capitalize">{`${$user.nationality.toLowerCase()}`}</td>
                                                                </tr>
                                                                {/* <tr>
                                                                    <td>Role</td>
                                                                    <td className="text-capitalize">{`${user.role?.name ? user.role?.name.split(' ')[0] + ' ' + user.role?.name.split(' ')[1].toLowerCase() : ''}`}</td>
                                                                </tr> */}
                                                                {/* <tr>
                                                                    <td>Position</td>
                                                                    <td className="text-capitalize">{`${$user.position.name.toLowerCase()}`}</td>
                                                                </tr> */}
                                                                <tr>
                                                                    <td>Status</td>
                                                                    <td className="text-capitalize">{`${$user.approval_status.toLowerCase()}`}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>RegID</td>
                                                                    <td className="text-capitalize">{`${$user.regId}`}</td>
                                                                </tr>
                                                                {/* <tr>
                                                                    <td>Institution</td>
                                                                    <td className="text-capitalize">{`${$user.institution?.name?.toLowerCase()}`}</td>
                                                                </tr> */}

                                                            </tbody>
                                                        </table>
                                                    </CardBody>

                                                </Card>

                                            </>}

                                        </Col>
                                        <Col sm="6">
                                            {$user &&
                                                <>
                                                    <form onSubmit={handleSubmit(handleFormSubmit)} className="is-alter" encType="multipart/form-data">

                                                        <Row className="gy-4">
                                                            <Col sm="6">
                                                                <div className="form-group">
                                                                    <Label htmlFor="lastName" className="form-label">
                                                                        Surname
                                                                    </Label>
                                                                    <div className="form-control-wrap">
                                                                        <input className="form-control" type="text" id="lastName" placeholder="Enter Last Name"  {...register('lastName', { required: "Surname is Required" })} defaultValue={initValues.lastName} />
                                                                        {errors.lastName && <p className="invalid">{`${errors.lastName.message}`}</p>}
                                                                    </div>
                                                                </div>
                                                            </Col>
                                                            <Col sm="6">
                                                                <div className="form-group">
                                                                    <Label htmlFor="firstName" className="form-label">
                                                                        First Name
                                                                    </Label>
                                                                    <div className="form-control-wrap">
                                                                        <input className="form-control" type="text" id="firstName" placeholder="Enter First Name" {...register('firstName', { required: "First Name is Required" })} defaultValue={initValues.firstName} />
                                                                        {errors.firstName && <p className="invalid">{`${errors.firstName.message}`}</p>}
                                                                    </div>
                                                                </div>
                                                            </Col>
                                                            <Col sm="6">
                                                                <div className="form-group">
                                                                    <Label htmlFor="middleName" className="form-label">
                                                                        Middle Name
                                                                    </Label>
                                                                    <div className="form-control-wrap">
                                                                        <input className="form-control" type="text" id="middleName" placeholder="Enter First Name" {...register('middleName', { required: false })} defaultValue={initValues.middleName} />
                                                                        {errors.middleName && <p className="invalid">{`${errors.middleName.message}`}</p>}
                                                                    </div>
                                                                </div>
                                                            </Col>
                                                            <Col sm="6">
                                                                <div className="form-group">
                                                                    <Label htmlFor="email" className="form-label">
                                                                        Email Address
                                                                    </Label>
                                                                    <div className="form-control-wrap">
                                                                        <input className="form-control" type="email" id="email" placeholder="Enter Email Address" {...register('email', { required: "Email Address is Required" })} defaultValue={initValues.email} />
                                                                        {errors.email && <p className="invalid">{`${errors.email.message}`}</p>}
                                                                    </div>
                                                                </div>
                                                            </Col>
                                                            <Col sm="6">
                                                                <div className="form-group">
                                                                    <Label htmlFor="email" className="form-label">
                                                                        Group Email Address
                                                                    </Label>
                                                                    <div className="form-control-wrap">
                                                                        <input className="form-control" type="email" id="group_email" placeholder="Enter Group Email Address" {...register('group_email', { required: "Group Email Address is Required" })} defaultValue={initValues.groupEmail} />
                                                                        {errors.group_email && <p className="invalid">{`${errors.group_email.message}`}</p>}
                                                                    </div>
                                                                </div>
                                                            </Col>
                                                            <Col sm="6">
                                                                <div className="form-group">
                                                                    <Label htmlFor="phone" className="form-label">
                                                                        Phone Number
                                                                    </Label>
                                                                    <div className="form-control-wrap">
                                                                        <input className="form-control" type="text" id="phone" placeholder="Enter Phone Name"  {...register('phone', { required: "Phone is Required" })} defaultValue={initValues.phone} />
                                                                        {errors.phone && <p className="invalid">{`${errors.phone.message}`}</p>}
                                                                    </div>
                                                                </div>
                                                            </Col>
                                                            <Col sm="6">
                                                                <div className="form-group">
                                                                    <Label htmlFor="position_id" className="form-label">
                                                                        Position
                                                                    </Label>
                                                                    <div className="form-control-wrap">
                                                                        <div className="form-control-select">
                                                                            <select className="form-control form-select" {...register('position_id', { required: "Position is Required" })} defaultValue={initValues.position}>
                                                                                <option value="">Select Position</option>
                                                                                {$positions && $positions?.map((position, index) => (
                                                                                    <option key={index} value={position.id}>
                                                                                        {position.name}
                                                                                        {position.is_compulsory == '1' && <>*</>}
                                                                                    </option>
                                                                                ))}
                                                                            </select>
                                                                            {errors.position_id && <p className="invalid">{`${errors.position_id.message}`}</p>}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </Col>
                                                            <Col sm="6">
                                                                <div className="form-group">
                                                                    <Label htmlFor="nationality" className="form-label">
                                                                        Nationality
                                                                    </Label>
                                                                    <div className="form-control-wrap">
                                                                        <div className="form-control-select">
                                                                            <select className="form-control form-select" {...register('nationality', { required: "Nationality is Required" })} defaultValue={initValues.nationality}>
                                                                                <option value="">Select Nationality</option>
                                                                                {$countries && $countries?.map((country, index) => (
                                                                                    <option key={index} value={country.code}>
                                                                                        {country.name}
                                                                                    </option>
                                                                                ))}
                                                                            </select>
                                                                            {errors.nationality && <p className="invalid">{`${errors.nationality.message}`}</p>}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </Col>
                                                            <Col sm="12">
                                                                <div className="form-group">
                                                                    {/* {settings} */}
                                                                    {($settings && $settings.name == 'mandate_form') && <>
                                                                        <a size="lg" href={$settings.value} download="mandate_form.pdf" target="_blank" className="active btn btn-primary">
                                                                            {"Download Signature Mandate"}
                                                                        </a>
                                                                    </>}

                                                                </div>
                                                            </Col>
                                                            <Col sm="6">
                                                                <div className="form-group">
                                                                    <Label htmlFor="nationality" className="form-label">
                                                                        Upload Digital Photo
                                                                    </Label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="file" accept="image/*" className="form-control"  {...register('digitalPhone', { required: false })} onChange={handleDificalFileChange} />
                                                                        {errors.digitalPhone && <p className="invalid">{`${errors.digitalPhone.message}`}</p>}
                                                                    </div>
                                                                </div>
                                                            </Col>
                                                            <Col sm="6">
                                                                <div className="form-group">
                                                                    <Label htmlFor="Signature" className="form-label">
                                                                        Signed Signature Mandate<span style={{ color: 'red' }}> *</span>
                                                                    </Label>
                                                                    <div className="form-control-wrap">
                                                                        <input type="file" accept=".pdf" className="form-control"  {...register('signedMandate', { required: "Signed Mandate is Required" })} onChange={handleSignaturewChange} />
                                                                        {errors.signedMandate && <p className="invalid">{`${errors.signedMandate.message}`}</p>}
                                                                    </div>
                                                                </div>
                                                            </Col>
                                                            <Col sm="6">
                                                                <div className="form-group">
                                                                    <Label htmlFor="nationality" className="form-label">
                                                                        Role
                                                                    </Label>
                                                                    <div className="form-control-wrap">
                                                                        <div className="form-control-select">
                                                                            <select className="form-control form-select" {...register('role', { required: "Roles is Required" })} defaultValue={initValues.role_id}>
                                                                                <option value="">Select Role</option>
                                                                                {$roles && $roles?.map((role, index) => (
                                                                                    <option key={index} value={role.id}>
                                                                                        {role.name}
                                                                                    </option>
                                                                                ))}
                                                                            </select>
                                                                            {errors.role && <p className="invalid">{`${errors.role.message}`}</p>}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </Col>
                                                            <Col sm="6">
                                                                <div className="form-group">
                                                                    <Label htmlFor="nationality" className="form-label">
                                                                        Authoriser
                                                                    </Label>
                                                                    <div className="form-control-wrap">
                                                                        <div className="form-control-select">
                                                                            <select className="form-control form-select" {...register('ar_authoriser_id', { required: "Authoriser is Required" })}>
                                                                                <option value="">Select Authoriser</option>
                                                                                {$authorizers && $authorizers?.map((authorizer, index) => ar_user_id != authorizer.id && authorizer.approval_status == 'approved' ? (
                                                                                    <option key={index} value={authorizer.id}>
                                                                                        {`${authorizer.first_name} ${authorizer.last_name} ( ${authorizer.email} )`}
                                                                                    </option>
                                                                                ) : "")}
                                                                            </select>
                                                                            {errors.ar_authoriser_id && <p className="invalid">{`${errors.ar_authoriser_id.message}`}</p>}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </Col>
                                                            <Col sm="12">
                                                                <div className="form-group">
                                                                    <Label htmlFor="nationality" className="form-label">
                                                                        Reason
                                                                    </Label>
                                                                    <div className="form-control-wrap">
                                                                        <textarea type="text" className="form-control" {...register('reason', { required: "Reason is Required" })}></textarea>
                                                                        {errors.reason && <p className="invalid">{`${errors.reason.message}`}</p>}
                                                                    </div>
                                                                </div>
                                                            </Col>
                                                            <Col sm="12">
                                                                <div className="form-group">
                                                                    <Button color="primary" type="submit" size="lg">
                                                                        {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Transfer"}
                                                                    </Button>
                                                                </div>
                                                            </Col>
                                                        </Row>
                                                    </form>
                                                </>
                                            }
                                        </Col>


                                    </Row>

                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default TransferAuthRepresentative;
