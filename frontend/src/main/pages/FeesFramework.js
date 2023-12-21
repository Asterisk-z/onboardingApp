import React, { useState, useEffect } from "react";
import Head from "layout/head/Head";
import Content from "layout/content/Content";
import { Card } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, Row, Col, BlockBetween} from "components/Component";



const Homepage = () => {


  return (
    <React.Fragment>
      <Head title="Fees Framework"></Head>
      <Content>
        <BlockHead size="sm">
          <BlockBetween>
            <BlockHeadContent>
              <BlockTitle page tag="h3">
                Fee Framework
              </BlockTitle>
            </BlockHeadContent>
          </BlockBetween>
        </BlockHead>
        <Block>
          <Row className="g-gs">
            <Col xxl="3" sm="6">
              <Card className="color1">
                <div className="nk-ecwg nk-ecwg6">
                  <div className="card-inner">
                    <div className="card-title-group">
                      <div className="card-title">
                        <h6 className="title">{"Goto Fee Framework"}</h6>
                      </div>
                    </div>
                  </div>
                </div>
              </Card>
            </Col>
          </Row>
        </Block>
      </Content>
    </React.Fragment>
  );
};
export default Homepage;
