import React, { useState } from "react";
import Head from "../layout/head/Head";
import Content from "../layout/content/Content";
import DataCard from "components/partials/default/DataCard";
import {
  Block,
  BlockHead,
  BlockHeadContent,
  BlockTitle,
  Icon,
  Button,
  Row,
  Col,
  BlockBetween,
} from "components/Component";
import "../../App.css"

const Homepage = () => {
  const [sm, updateSm] = useState(false);
  return (
    <React.Fragment>
      <Head title="Homepage"></Head>
      <Content>
        <BlockHead size="sm">
          <BlockBetween>
            <BlockHeadContent>
              <BlockTitle page tag="h3">
                Dashboard
              </BlockTitle>
            </BlockHeadContent>
          </BlockBetween>
        </BlockHead>
        <Block>
          <Row className="g-gs">
            <Col xxl="3" sm="6">
              <DataCard className= "color1" title="Today's Order"   amount={"0"}/>
            </Col>
            <Col xxl="3" sm="6">
              <DataCard style={{backgroundColor:"blue"}} title="Today's Revenue" amount={"0"}/>
            </Col>
            <Col xxl="3" sm="6">
              <DataCard style={{backgroundColor:"purple"}} title="Today's Customers"   amount={"0"}/>
            </Col>
            <Col xxl="3" sm="6">
              <DataCard style={{backgroundColor:"black"}} title="Today's Visitors" amount={"0"}/>
            </Col>
            {/* <Col xxl="8">
              <RecentOrders />
            </Col>
            <Col xxl="4" md="8" lg="6">
              <TopProducts />
            </Col> */}
          </Row>
        </Block>
      </Content>
    </React.Fragment>
  );
};
export default Homepage;
