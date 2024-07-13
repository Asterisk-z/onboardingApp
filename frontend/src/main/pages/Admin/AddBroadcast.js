import React, { useEffect, useRef, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { CreateBroadcast, loadBoardCastCategoryPositions } from "redux/stores/broadcast/broadcastStore";
import { loadAllCategoryPositions } from "redux/stores/positions/positionStore";
import { loadAllActiveCategories } from "redux/stores/memberCategory/category";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import { Steps, Step } from "react-step-builder";


const Header = (props) => {
    return (
        <div className="steps clearfix">
            <ul>
                <li className={props.current >= 1 ? "first done" : "first"}>
                    <a href="#wizard-01-h-0" onClick={(ev) => ev.preventDefault()}>
                        <span className="number"></span> <h5>Fields</h5>
                    </a>
                </li>
                <li className={props.current >= 2 ? "done" : ""}>
                    <a href="#wizard-01-h-1" onClick={(ev) => ev.preventDefault()}>
                        <span className="number"></span> <h5>Category</h5>
                    </a>
                </li>
                <li className={props.current >= 3 ? "done" : ""}>
                    <a href="#wizard-01-h-2" onClick={(ev) => ev.preventDefault()}>
                        <span className="current-info audible">current step: </span>
                        <span className="number"></span> <h5>Position</h5>
                    </a>
                </li>
            </ul>
        </div>
    );
};


const config = {
    before: Header,
};

const AdminBroadcast = ({ drawer }) => {
    const dispatch = useDispatch();
    const [overAllForm, setOverAllForm] = useState({
        title: "",
        content: "",
        document: "",
        category_ids: [],
        position_ids: [],
    });

    const [loading, setLoading] = useState(false);
    const navigate = useNavigate();

    const handleFormSubmit = async (values) => {

        const postValues = new Object();
        postValues.title = values.title;
        postValues.content = values.content;
        postValues.position = values.position_ids;
        postValues.category = values.category_ids;
        postValues.file = values.document;

        try {
            setLoading(true);

            const resp = await dispatch(CreateBroadcast(postValues));

            if (resp.payload?.message == "success") {
                setTimeout(() => {
                    setLoading(false);
                    navigate(process.env.PUBLIC_URL + '/admin-broadcast')
                    // setParentState(Math.random())
                }, 1000);

            } else {
                setLoading(false);
            }

        } catch (error) {
            setLoading(false);
        }

    };

    const categories = useSelector((state) => state?.category?.list) || null;

    useEffect(() => {
        dispatch(loadAllActiveCategories());
    }, [dispatch]);

    const $categories = categories ? JSON.parse(categories) : null;

    const updateOverflow = (att) => {
        const data = { ...att };
        setOverAllForm(data);
    };

    const FormFields = (props) => {

        const [documentToUpload, setDocumentToUpload] = useState([]);

        const [formData, setFormData] = useState({
            title: overAllForm.title ? overAllForm.title : "",
            content: overAllForm.content ? overAllForm.content : "",
            document: overAllForm.document ? overAllForm.document : "",
            category_ids: overAllForm.category_ids ? overAllForm.category_ids : [],
            position_ids: overAllForm.position_ids ? overAllForm.position_ids : [],
        });

        const onInputChange = (e) => {
            // console.log(e.target.value, e.target.name, { ...formData, [e.target.name]: e.target.value })
            const data = { ...formData, [e.target.name]: e.target.value };
            setFormData(data);
        };

        const { reset, register, handleSubmit, formState: { errors } } = useForm();

        const submitForm = (data) => {
            updateOverflow(formData)
            props.next();
        };


        const handleFileChange = (event) => {
            const data = { ...formData, ['document']: event.target.files[0] };
            setFormData(data);
            setDocumentToUpload(event.target.files[0]);
        };


        return (
            <form className="content clearfix" onSubmit={handleSubmit(submitForm)} encType="multipart/form-data">
                <Row className="gy-4">
                    <Col md="12">
                        <div className="form-group">
                            <label className="form-label" htmlFor="title">
                                Title
                            </label>
                            <div className="form-control-wrap">
                                <input type="text" id="title" className="form-control" {...register('title', { required: "This Field is required" })} onChange={(e) => onInputChange(e)} defaultValue={formData.title} />
                                {errors.title && <span className="invalid">{errors.title.message}</span>}
                            </div>
                        </div>
                    </Col>
                    <Col md="12">
                        <div className="form-group">
                            <label className="form-label" htmlFor="content">
                                Content
                            </label>
                            <div className="form-control-wrap">
                                <textarea id="content" className="form-control" {...register('content', { required: "This Field is required" })} onKeyUp={(e) => onInputChange(e)} defaultValue={formData.content} ></textarea>
                                {errors.content && <span className="invalid">{errors.content.message}</span>}
                            </div>
                        </div>
                    </Col>
                    <Col md="12">
                        <div className="form-group">
                            <label className="form-label" htmlFor="document">
                                Attachment
                            </label>
                            <div className="form-control-wrap">
                                <input type="file" accept="image/*" id="document" className="form-control"   {...register('document', { required: "This Field is required" })} onChange={handleFileChange} />
                                {errors.document && <p className="invalid">{`${errors.document.message}`}</p>}
                            </div>
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
                    </ul>
                </div>
            </form>
        );
    };

    const CategorySection = (props) => {

        const [categoryIds, setCategoryIds] = useState([]);

        const { handleSubmit, register, watch, formState: { errors } } = useForm();

        const submitForm = (data) => {

            const clickedIds = Object.keys(categoryIds)
            const valuesIds = Object.values(categoryIds)
            const checkedId = clickedIds.filter((check, index) => valuesIds[index]);
            // check if checkedID dey greater than 0
            if (checkedId.length > 0) {
                const newOverAll = { ...overAllForm, ['category_ids']: [...checkedId] }

                setOverAllForm(newOverAll)
                props.next();
            }
        };

        const checkCategory = (event) => {
            const ids = categoryIds;
            ids[event.target.value] = event.target.checked
        };


        return (
            <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
                <Row className="gy-4">
                    <Col md="12">
                        <div className="form-group">
                            <label className="form-label">
                                Categories
                            </label>
                            <div className="form-control-wrap">
                                {$categories && $categories?.map((category, index) => (
                                    // <input type="text" className="form-control" {...register('username', { required: true })} onChange={(e) => onInputChange(e)} defaultValue={formData.username} />
                                    <article className="custom-control" key={index} style={{ paddingLeft: '5px !important' }}>
                                        {/* checked={formData.category_ids.includes(category.id)} */}
                                        {/* {...register(`category_ids${index}`, { required: false })} */}
                                        <input type="checkbox" className="" onChange={(e) => checkCategory(e)} name='category_id[]' value={category.id} id={`fw-policy${category.id}`} />
                                        {/* {errors.terms && <span className="invalid">This field is required</span>} */}
                                        <label className="" htmlFor={`fw-policy${category.id}`}>
                                            <span>
                                                {category.name}
                                            </span>
                                        </label>
                                    </article>
                                ))}
                                {errors.username && <span className="invalid">This field is required</span>}
                            </div>
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

    const PositionSection = (props) => {

        // const positions = useSelector((state) => state?.position?.list) || null;
        const positions = useSelector((state) => state?.broadcasts?.list_positions) || null;

        useEffect(() => {
            dispatch(loadBoardCastCategoryPositions({ 'category_ids': overAllForm.category_ids }));
            // dispatch(loadAllCategoryPositions({ 'category_ids': overAllForm.category_ids }));
        }, [dispatch]);

        const $positions = positions ? JSON.parse(positions) : null;

        const [positionIds, setPositionIds] = useState([]);

        const { handleSubmit, register, watch, formState: { errors } } = useForm();

        const submitForm = (data) => {
            const clickedIds = Object.keys(positionIds)
            const valuesIds = Object.values(positionIds)
            const checkedId = clickedIds.filter((check, index) => valuesIds[index]);
            const newOverAll = { ...overAllForm, ['position_ids']: [...checkedId] }

            setOverAllForm(newOverAll)

            handleFormSubmit(newOverAll);


        };

        const checkPosition = (event) => {
            const ids = positionIds;
            ids[event.target.value] = event.target.checked
        };

        return (
            <form className="content clearfix" onSubmit={handleSubmit(submitForm)}>
                <Row className="gy-4">
                    <Col md="12">
                        <div className="form-group">
                            <label className="form-label">
                                Position
                            </label>
                            <div className="form-control-wrap">
                                {$positions && $positions?.map((position, index) => (
                                    // <input type="text" className="form-control" {...register('username', { required: true })} onChange={(e) => onInputChange(e)} defaultValue={formData.username} />
                                    <article className="custom-control" key={index} style={{ paddingLeft: '5px !important' }}>
                                        {/* checked={formData.category_ids.includes(category.id)} */}
                                        {/* {...register(`category_ids${index}`, { required: false })} */}
                                        <input type="checkbox" className="" onChange={(e) => checkPosition(e)} name='position_id[]' value={position.id} id={`fw-policy${position.id}`} />
                                        {/* {errors.terms && <span className="invalid">This field is required</span>} */}
                                        <label className="" htmlFor={`fw-policy${position.id}`}>
                                            <span>
                                                {position.name}
                                                {position.is_compulsory == '1' && <span style={{ color: 'red' }}>*</span>}
                                            </span>
                                        </label>
                                    </article>
                                ))}
                                {errors.username && <span className="invalid">This field is required</span>}
                            </div>
                        </div>
                    </Col>
                </Row>
                <div className="actions clearfix">
                    <ul>
                        <li>
                            <Button color="primary" type="submit">
                                {loading ? (<span><Spinner size="sm" color="light" /> Processing...</span>) : "Send Broadcast"}
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

    return (
        <React.Fragment>
            <Head title="Broadcast"></Head>
            <Content page="component">
                <Content>
                    <Block size="lg">
                        <BlockHead>
                            <BlockHeadContent>
                                <BlockTitle tag="h4">Add Broadcast Message</BlockTitle>
                            </BlockHeadContent>
                        </BlockHead>
                        <PreviewCard>
                            <div className="nk-wizard nk-wizard-simple is-alter wizard clearfix">
                                <Steps config={config}>
                                    <Step component={FormFields} />
                                    <Step component={CategorySection} />
                                    <Step component={PositionSection} />
                                </Steps>
                            </div>
                        </PreviewCard>
                    </Block>
                </Content>
            </Content>
        </React.Fragment>
    );
};
export default AdminBroadcast;
