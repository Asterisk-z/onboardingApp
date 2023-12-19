import React, { useState, useEffect } from "react";
import Head from "../layout/head/Head";
import Content from "../layout/content/Content";
import { Card } from "reactstrap";
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
  PreviewCard
} from "components/Component";
import { useDispatch, useSelector } from "react-redux";
import { userLoadUserARs } from "redux/stores/authorize/representative";
import AuthRepTable from './Tables/AuthRepTable'




const Homepage = () => {
  const dispatch = useDispatch();
  const arUsers = useSelector((state) => state?.arUsers?.list) || null;

  useEffect(() => {
    dispatch(userLoadUserARs());
  }, [dispatch]);


  const $arUsers = arUsers ? JSON.parse(arUsers) : null;
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
              <Card className="color1">
                <div className="nk-ecwg nk-ecwg6">
                  <div className="card-inner">
                    <div className="card-title-group">
                      <div className="card-title">
                        <h6 className="title">{"My Applications"}</h6>
                      </div>
                    </div>
                    <div className="data">
                      <div className="data-group">
                        <div className="amount">{"0"}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </Card>
            </Col>
            <Col xxl="3" sm="6">
              <Card className="color2">
                <div className="nk-ecwg nk-ecwg6">
                  <div className="card-inner">
                    <div className="card-title-group">
                      <div className="card-title">
                        <h6 className="title">{"Authorised Representatives"}</h6>
                      </div>
                    </div>
                    <div className="data">
                      <div className="data-group">
                        <div className="amount">{"0"}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </Card>
            </Col>
            <Col xxl="3" sm="6">
              <Card className="color4">
                <div className="nk-ecwg nk-ecwg6">
                  <div className="card-inner">
                    <div className="card-title-group">
                      <div className="card-title">
                        <h6 className="title">{"Complaints"}</h6>
                      </div>
                    </div>
                    <div className="data">
                      <div className="data-group">
                        <div className="amount">{"0"}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </Card>
            </Col>
            <Col xxl="3" sm="6">
              <Card className="color3">
                <div className="nk-ecwg nk-ecwg6">
                  <div className="card-inner">
                    <div className="card-title-group">
                      <div className="card-title">
                        <h6 className="title">{"Messages"}</h6>
                      </div>
                    </div>
                    <div className="data">
                      <div className="data-group">
                        <div className="amount">{"0"}</div>
                      </div>
                    </div>
                  </div>
                </div>
              </Card>
            </Col>
            {/* <Col xxl="8">
              <RecentOrders />
            </Col>
            <Col xxl="4" md="8" lg="6">
              <TopProducts />
            </Col> */}
          </Row>
        </Block>
        <Content>


          <Block size="xl">
            <BlockHead>
              <BlockHeadContent>
                <BlockTitle tag="h4">User</BlockTitle>
              </BlockHeadContent>
            </BlockHead>

            <PreviewCard>
              {$arUsers && <AuthRepTable data={$arUsers} expandableRows pagination actions />}
            </PreviewCard>
          </Block>


        </Content>
      </Content>
    </React.Fragment>
  );
};
export default Homepage;
