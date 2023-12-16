import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { CreateBroadcast, loadViewMessages } from "redux/stores/broadcast/broadcastStore";
import { loadAllCategoryPositions } from "redux/stores/positions/positionStore";
import { loadAllCategories } from "redux/stores/memberCategory/category";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminBroadcastTable from './Tables/AdminBroadcastTable'


const AdminBroadcast = ({ drawer }) => {
        
    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    const [loading, setLoading] = useState(false);
    const [categoryIds, setCategoryIds] = useState([1]);
    const [documentToUpload, setDocumentToUpload] = useState([]);
    const [sm, updateSm] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const navigate = useNavigate();

    const positions = useSelector((state) => state?.position?.list) || null;
    const categories = useSelector((state) => state?.category?.list) || null;

    const { register, handleSubmit, formState: { errors }, resetField } = useForm();

    const handleAdd = () => navigate(process.env.PUBLIC_URL+'/add-broadcast');

    const toggleForm = () => setModalForm(!modalForm);

    useEffect(() => {
        dispatch(loadAllCategories());
    }, [dispatch]);

    useEffect(() => {
        dispatch(loadAllCategoryPositions({'category_ids' : categoryIds}));
    }, [categoryIds]);

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
            setCategoryIds([event.target.value])
        }
    }

    return (
        <React.Fragment>
            <Head title="Broadcast"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Broadcast
                            </BlockTitle>
                            {/* {categories} */}
                        </BlockHeadContent>
                        <BlockHeadContent>
                            <div className="toggle-wrap nk-block-tools-toggle">
                                <div className="toggle-expand-content" style={{ display: sm ? "block" : "none" }}>
                                    <ul className="nk-block-tools g-3">
                                        <li className="nk-block-tools-opt">
                                            <Button color="primary">
                                                <span onClick={handleAdd}>Add New Broadcast</span>
                                            </Button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                <Content>


                    <Block size="xl">
                        <BlockHead>
                            <BlockHeadContent>
                                <BlockTitle tag="h4">Broadcast History</BlockTitle>
                                {/* <p>{broadcasts}</p> */}
                                {/* {<p>{parentState}</p>} */}
                            </BlockHeadContent>
                        </BlockHead>

                        <PreviewCard>
                            {$broadcasts && <AdminBroadcastTable  updateParent={updateParentState} parentState={parentState} data={$broadcasts} expandableRows pagination actions />}
                        </PreviewCard>
                    </Block>


                </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default AdminBroadcast;
