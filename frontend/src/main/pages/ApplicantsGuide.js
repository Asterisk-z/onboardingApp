import React, { useState, useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { Card, CardTitle, CardBody, CardLink } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Row, Col, BlockBetween, PreviewCard } from "components/Component";
import { loadActiveFees } from "redux/stores/feesAndDues/feesAndDuesStore";



const Homepage = () => {

  const [counter, setCounter] = useState(false);
  const dispatch = useDispatch();
  useEffect(() => {
    dispatch(loadActiveFees());
  }, [dispatch, counter]);
  const fees = useSelector((state) => state?.fees?.active) || null;
  const $fees = fees ? JSON.parse(fees) : null;


  return (
    <React.Fragment>
      <Head title="Fees Framework"></Head>
      <Content>
        <BlockHead size="sm">
          <BlockBetween>
            <BlockHeadContent>
              <BlockTitle page tag="h3">
                FMDQ Fees and Dues Framework
              </BlockTitle>
            </BlockHeadContent>
          </BlockBetween>
        </BlockHead>
        <PreviewCard>
          <Row className="g-gs">
            {$fees &&
              <Col lg="3">
                <Card className="card-bordered">
                  <CardBody className="card-inner">
                    <CardTitle tag="h5">{$fees.title}</CardTitle>
                    <CardLink href={$fees.url} target="_blank" className="btn btn-primary" color="primary">Click to Visit</CardLink>
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
