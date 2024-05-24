import React, { useEffect, useState } from "react";
import { useDispatch, useSelector } from "react-redux";
import { useForm } from "react-hook-form";
import { Modal, ModalHeader, ModalBody, ModalFooter, Card, CardHeader, CardFooter, CardImg, CardText, CardBody, CardTitle, CardSubtitle, CardLink } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Icon, Button, Row, Col, BlockBetween, RSelect, BlockDes, BackTo, PreviewCard, ReactDataTable } from "components/Component";
import { loadAllActiveRegulators } from "redux/stores/regulators/regulatorStore";
import Content from "layout/content/Content";
import Head from "layout/head/Head";




const Regulators = ({ drawer }) => {


    const [counter, setCounter] = useState(false);
    const dispatch = useDispatch();

    const regulators = useSelector((state) => state?.regulator?.active_list) || null;

    useEffect(() => {
        dispatch(loadAllActiveRegulators());
    }, [dispatch, counter]);

    const $regulators = regulators ? JSON.parse(regulators) : null;


    return (
        <React.Fragment>
            <Head title="Regulators"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Regulators
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
                                        <BlockTitle tag="h4">Regulators</BlockTitle>
                                        {/* <p>{regulators}</p> */}
                                    </BlockHeadContent>
                                </BlockHead>

                                <PreviewCard>
                                    <Row className="g-gs">
                                        {$regulators && $regulators.map((regulator, index) =>
                                            <Col lg="3" key={index}>
                                                <Card className="card-bordered gold">
                                                    <CardBody className="card-inner">
                                                        <CardTitle tag="h5">{regulator.name}</CardTitle>
                                                        <CardText className="h-15 overflow-auto">
                                                            {regulator?.brief}
                                                        </CardText>
                                                        <CardLink href={regulator.url} target="_blank" className="btn btn-primary" color="primary">Goto Website</CardLink>
                                                    </CardBody>
                                                </Card>
                                            </Col>)}
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
export default Regulators;
