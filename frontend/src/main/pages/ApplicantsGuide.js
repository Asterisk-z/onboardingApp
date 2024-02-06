import React, { useState, useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { Card, CardTitle, CardBody, CardLink } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Row, Col, BlockBetween, PreviewCard } from "components/Component";
import { loadActiveGuide } from "redux/stores/applicantGuide/applicantGuideStore";



const Homepage = () => {

  const [counter, setCounter] = useState(false);
  const dispatch = useDispatch();
  useEffect(() => {
    dispatch(loadActiveGuide());
  }, [dispatch, counter]);
  const applicantGuide = useSelector((state) => state?.applicantGuide?.active) || null;
  const $applicantGuide = applicantGuide ? JSON.parse(applicantGuide) : null;


  return (
    <React.Fragment>
      <Head title="Fees Framework"></Head>
      <Content>
        <BlockHead size="sm">
          <BlockBetween>
            <BlockHeadContent>
              <BlockTitle page tag="h3">
                Applicant Guide
              </BlockTitle>
            </BlockHeadContent>
          </BlockBetween>
        </BlockHead>
        <PreviewCard>
          <Row className="g-gs">
            {$applicantGuide &&
              <Col lg="3">
                <Card className="card-bordered gold">
                  <CardBody className="card-inner">
                    <CardTitle tag="h5">{$applicantGuide.name}</CardTitle>
                    <CardLink href={$applicantGuide.file} target="_blank" className="btn btn-primary" color="primary">View Document</CardLink>
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
