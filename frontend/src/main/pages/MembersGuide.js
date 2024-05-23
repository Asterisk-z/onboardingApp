import React, { useState, useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { Card, CardTitle, CardBody, CardLink } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Row, Col, BlockBetween, PreviewCard } from "components/Component";
import { loadActiveGuide } from "redux/stores/membersGuide/membersGuideStore";



const Homepage = () => {

  const [counter, setCounter] = useState(false);
  const dispatch = useDispatch();
  useEffect(() => {
    dispatch(loadActiveGuide());
  }, [dispatch, counter]);
  const membersGuide = useSelector((state) => state?.membersGuide?.active) || null;
  const $membersGuide = membersGuide ? JSON.parse(membersGuide) : null;


  return (
    <React.Fragment>
      <Head title="Members Guide"></Head>
      <Content>
        <BlockHead size="sm">
          <BlockBetween>
            <BlockHeadContent>
              <BlockTitle page tag="h3">
                Members Guide
              </BlockTitle>
            </BlockHeadContent>
          </BlockBetween>
        </BlockHead>
        <PreviewCard>
          <Row className="g-gs">
            {$membersGuide &&
              <Col lg="3">
                <Card className="card-bordered gold">
                  <CardBody className="card-inner">
                    <CardTitle tag="h5">{$membersGuide.name}</CardTitle>
                    <CardLink href={$membersGuide.file_path} target="_blank" className="btn btn-primary" color="primary">View Document</CardLink>
                  </CardBody>
                </Card>
              </Col>}
          </Row>
        </PreviewCard>
      </Content>
    </React.Fragment>
  );
};
export default Homepage;
