import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useNavigate } from "react-router-dom";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, Spinner} from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button,BlockBetween, PreviewCard } from "components/Component";
import { adminLoadUserARs } from "redux/stores/authorize/representative";
import { sendSanction, loadAllSanctions } from "redux/stores/sanctions/sanctionStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AdminSanctionTable from './Tables/AdminSanctionTable'


const Sanction = ({ drawer }) => {
        
    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();
    const sanctions = useSelector((state) => state?.sanctions?.view_all) || null;
    useEffect(() => {
        dispatch(loadAllSanctions());
    }, [dispatch, counter]);
  
    const $sanctions = sanctions ? JSON.parse(sanctions) : null;

    return (
        <React.Fragment>
            <Head title="Sanctions"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Disciplinary and Sanctions
                            </BlockTitle>
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <Content>


                            <Block size="xl">
                                <BlockHead>
                                    <BlockHeadContent>
                                        <BlockTitle tag="h4">Disciplinary and Sanctions History</BlockTitle>
                                        {/* <p>{sanctions}</p> */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    {$sanctions && <AdminSanctionTable data={$sanctions} expandableRows pagination actions />}
                                </PreviewCard>
                            </Block>


                        </Content>
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default Sanction;
