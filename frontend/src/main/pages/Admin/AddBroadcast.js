import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { CreateBroadcast, loadViewMessages } from "redux/stores/broadcast/broadcastStore";
import { loadAllCategoryPositions } from "redux/stores/positions/positionStore";
import { loadAllCategories } from "redux/stores/memberCategory/category";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminBroadcastTable from './Tables/AdminBroadcastTable'
import { Steps, Step } from "react-step-builder";

const UploadForm = (props) => {
    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    const [loading, setLoading] = useState(false);
    const [categoryId, setCategoryId] = useState(1);
    const [documentToUpload, setDocumentToUpload] = useState([]);
    const [sm, updateSm] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const navigate = useNavigate();

    const positions = useSelector((state) => state?.position?.list) || null;
    const categories = useSelector((state) => state?.category?.list) || null;

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const toggleForm = () => setModalForm(!modalForm);

    useEffect(() => {
        dispatch(loadAllCategories());
    }, [dispatch]);

    useEffect(() => {
        dispatch(loadAllCategoryPositions({ 'category_id': categoryId }));
    }, [categoryId]);

    const $positions = positions ? JSON.parse(positions) : null;
    const $categories = categories ? JSON.parse(categories) : null;

    const [parentState, setParentState] = useState('Initial state');

    const updateParentState = (newState) => {
        setParentState(newState);
    };


    const broadcasts = useSelector((state) => state?.broadcasts?.list) || null;
    useEffect(() => {
        dispatch(loadViewMessages());
    }, [dispatch, parentState]);


    const $broadcasts = broadcasts ? JSON.parse(broadcasts) : null;

    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('title', values.title)
        formData.append('content', values.content)
        formData.append('position', values.position_type)
        formData.append('category', values.category_type)
        if (documentToUpload) {
            formData.append('file', documentToUpload)
        }


        try {
            setLoading(true);

            const resp = await dispatch(CreateBroadcast(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('title')
                    resetField('content')
                    resetField('position_type')
                    resetField('category_type')
                    resetField('document')
                    setCounter(!counter)
                    setParentState(Math.random())
                }, 1000);

            } else {
                setLoading(false);
            }

        } catch (error) {
            setLoading(false);
        }

    };

    const handleFileChange = (event) => {
        setDocumentToUpload(event.target.files[0]);
    };

    const updatePosition = (event) => {
        if (event.target.value) {
            setCategoryId(event.target.value)
        }
    }

    return (
        <form onSubmit={handleFormSubmit} className="is-alter" encType="multipart/form-data">
            <Row className="gy-4">
                <Col sm="12">
                    <div className="form-group">
                        <label className="form-label" htmlFor="phone-no">
                            Title
                        </label>
                        <div className="form-control-wrap">
                            <input type="text" className="form-control"  {...register('title', { required: "content is Required" })} />
                            {errors.title && <p className="invalid">{`${errors.title.message}`}</p>}
                        </div>
                    </div>
                </Col>
                <Col sm="12">
                    <div className="form-group">
                        <label className="form-label" htmlFor="email">
                            Content
                        </label>
                        <div className="form-control-wrap">
                            <textarea type="text" className="form-control" {...register('content', { required: "content is Required" })}></textarea>
                            {errors.content && <p className="invalid">{`${errors.content.message}`}</p>}
                        </div>
                    </div>
                </Col>
                <Col sm="12">
                    <div className="form-group">
                        <label className="form-label" htmlFor="phone-no">
                            Upload Document (*jpg, png)
                        </label>
                        <div className="form-control-wrap">
                            <input type="file" accept="image/*" className="form-control"  {...register('document', {})} onChange={handleFileChange} />
                            {errors.document && <p className="invalid">{`${errors.document.message}`}</p>}
                        </div>
                    </div>
                </Col>
                <div className="actions clearfix">
                    <ul>
                        <li>
                            <Button color="primary" type="submit">
                                Next
                            </Button>
                        </li>
                    </ul>
                </div>
            </Row>
        </form>
    );
};
const Checkboxes = (props) => {
    const [formData, setFormData] = useState({
        username: "",
        password: "",
        rePassword: "",
        terms: true,
    });

    const onInputChange = (e) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const { handleSubmit, register, watch, formState: { errors } } = useForm();

    const submitForm = (data) => {
        props.next();
    };

    const password = useRef();
    password.current = watch("password");

    return (
        <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
            <Row className="gy-4">
                <Col md="6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="username">
                            Username
                        </label>
                        <div className="form-control-wrap">
                            <input
                                type="text"
                                id="username"
                                className="form-control"
                                {...register('username', { required: true })}
                                onChange={(e) => onInputChange(e)}
                                defaultValue={formData.username} />
                            {errors.username && <span className="invalid">This field is required</span>}
                        </div>
                    </div>
                </Col>
                <Col md="6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="password">
                            Password
                        </label>
                        <div className="form-control-wrap">
                            <input
                                type="password"
                                id="password"
                                className="form-control"
                                {...register('password', {
                                    required: "This field is required",
                                    minLength: {
                                        value: 6,
                                        message: "Password must have at least 6 characters",
                                    },
                                })}
                                onChange={(e) => onInputChange(e)}
                                defaultValue={formData.password} />
                            {errors.password && <span className="invalid">{errors.password.message}</span>}
                        </div>
                    </div>
                </Col>
                <Col md="6">
                    <div className="form-group">
                        <label className="form-label" htmlFor="rePassword">
                            Re-Password
                        </label>
                        <div className="form-control-wrap">
                            <input
                                type="password"
                                id="rePassword"
                                className="form-control"
                                {...register('rePassword', {
                                    required: "This field is required",
                                    validate: (value) => value === password.current || "The passwords do not match",
                                })}
                                onChange={(e) => onInputChange(e)}
                                defaultValue={formData.rePassword} />
                            {errors.rePassword && <span className="invalid">{errors.rePassword?.message}</span>}
                        </div>
                    </div>
                </Col>
                <Col md="12">
                    <div className="custom-control custom-checkbox">
                        <input
                            type="checkbox"
                            className="custom-control-input"
                            onChange={(e) => setFormData({ ...formData, terms: e.target.checked })}
                            checked={formData.terms}
                            {...register('terms', { required: true })}
                            id="fw-policy" />
                        {errors.terms && <span className="invalid">This field is required</span>}
                        <label className="custom-control-label" htmlFor="fw-policy">
                            I agreed Terms and policy
                        </label>
                    </div>
                </Col>
            </Row>
            <div className="actions clearfix">
                <ul>
                    <li>
                        <Button color="primary" type="submit">
                            Next
                        </Button>
                    </li>
                    <li>
                        <Button color="primary" onClick={props.prev}>
                            Previous
                        </Button>
                    </li>
                </ul>
            </div>
        </form>
    );
};
const Header = (props) => {
    return (
        <div className="steps clearfix">
            <ul>
                <li className={props.current >= 1 ? "first done" : "first"}>
                    <a href="#wizard-01-h-0" onClick={(ev) => ev.preventDefault()}>
                        <span className="number">01</span> <h5>Step 1</h5>
                    </a>
                </li>
                <li className={props.current >= 2 ? "done" : ""}>
                    <a href="#wizard-01-h-1" onClick={(ev) => ev.preventDefault()}>
                        <span className="number">02</span> <h5>Step 2</h5>
                    </a>
                </li>
                <li className={props.current >= 3 ? "done" : ""}>
                    <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
                        <span className="current-info audible">current step: </span>
                        <span className="number">03</span> <h5>Step 3</h5>
                    </a>
                </li>
            </ul>
        </div>
    );
};
const Success = (props) => {
    return (
        <div className="d-flex justify-content-center align-items-center p-3">
            <BlockTitle tag="h6" className="text-center">
                Thank you for submitting form
            </BlockTitle>
        </div>
    );
};
const config = {
    before: Header,
};

export const WizardForm = () => {
    return (
        <React.Fragment>
            <Head title="Wizard Form" />
            <Content page="component">
                <Block size="lg">
                    <BlockHead>
                        <BlockHeadContent>
                            <BlockTitle tag="h5">Add Broadcast Message</BlockTitle>
                            <p>Fill forms to send broadcast.</p>
                        </BlockHeadContent>
                    </BlockHead>
                    <PreviewCard>
                        <div className="nk-wizard nk-wizard-simple is-alter wizard clearfix">
                            <Steps config={config}>
                                <Step component={UploadForm} />
                                <Step component={Checkboxes} />
                                {/* <Step component={PaymentInfo} /> */}
                                <Step component={Success} />
                            </Steps>
                        </div>
                    </PreviewCard>
                </Block>
            </Content>
        </React.Fragment>
    );
};


const AdminBroadcast = ({ drawer }) => {

    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    const [loading, setLoading] = useState(false);
    const [categoryId, setCategoryId] = useState(1);
    const [documentToUpload, setDocumentToUpload] = useState([]);
    const [sm, updateSm] = useState(false);
    const [modalForm, setModalForm] = useState(false);

    const positions = useSelector((state) => state?.position?.list) || null;
    const categories = useSelector((state) => state?.category?.list) || null;

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const toggleForm = () => setModalForm(!modalForm);

    useEffect(() => {
        dispatch(loadAllCategories());
    }, [dispatch]);

    useEffect(() => {
        dispatch(loadAllCategoryPositions({ 'category_id': categoryId }));
    }, [categoryId]);

    const $positions = positions ? JSON.parse(positions) : null;
    const $categories = categories ? JSON.parse(categories) : null;

    const [parentState, setParentState] = useState('Initial state');

    const updateParentState = (newState) => {
        setParentState(newState);
    };


    const broadcasts = useSelector((state) => state?.broadcasts?.list) || null;
    useEffect(() => {
        dispatch(loadViewMessages());
    }, [dispatch, parentState]);


    const $broadcasts = broadcasts ? JSON.parse(broadcasts) : null;

    const handleFormSubmit = async (values) => {
        const formData = new FormData();
        formData.append('title', values.title)
        formData.append('content', values.content)
        formData.append('position', values.position_type)
        formData.append('category', values.category_type)
        if (documentToUpload) {
            formData.append('file', documentToUpload)
        }


        try {
            setLoading(true);

            const resp = await dispatch(CreateBroadcast(formData));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    setModalForm(!modalForm)
                    resetField('title')
                    resetField('content')
                    resetField('position_type')
                    resetField('category_type')
                    resetField('document')
                    setCounter(!counter)
                    setParentState(Math.random())
                }, 1000);

            } else {
                setLoading(false);
            }

        } catch (error) {
            setLoading(false);
        }

    };

    const handleFileChange = (event) => {
        setDocumentToUpload(event.target.files[0]);
    };

    const updatePosition = (event) => {
        if (event.target.value) {
            setCategoryId(event.target.value)
        }
    }

    return (
        <React.Fragment>
            <Head title="Broadcast"></Head>
            <Content>
                <WizardForm />
            </Content>
        </React.Fragment>
    );
};
export default AdminBroadcast;
