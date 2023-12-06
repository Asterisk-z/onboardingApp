import React, { useState } from "react";
import Head from "../layout/head/Head";
import Content from "../layout/content/Content";
import {
    Modal,
    ModalHeader,
    ModalBody,
    ModalFooter,

    Nav,
    NavLink,
    NavItem,
    TabContent,
    TabPane,
    Card,
} from "reactstrap";
import {
    Block,

    OrderTable,
    BlockHead,
    BlockHeadContent,
    BlockTitle,
    Icon,
    Button,
    Row,
    Col,
    BlockBetween,
    RSelect
} from "components/Component";
import {
    DefaultCustomerChart,
    DefaultOrderChart,
    DefaultRevenueChart,
    DefaultVisitorChart,
} from "components/partials/charts/default/DefaultCharts";

const Homepage = () => {
    const [sm, updateSm] = useState(false);
    const [modalForm, setModalForm] = useState(false);
    const toggleForm = () => setModalForm(!modalForm);
    const options = {
        value: "chocolate",
        label: "Chocolate",
    }
    return (
        <React.Fragment>
            <Head title="Homepage"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Activity Log
                            </BlockTitle>
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                {/* <Block>
          <Row className="g-gs">
            <Col xxl="3" sm="6">
              <DataCard
                title="Today's Order"
                percentChange={"4.63"}
                up={true}
                chart={<DefaultOrderChart />}
                amount={"1975"}
              />
            </Col>
            <Col xxl="3" sm="6">
              <DataCard
                title="Today's Revenue"
                percentChange={"2.63"}
                up={false}
                chart={<DefaultRevenueChart />}
                amount={"$2293"}
              />
            </Col>
            <Col xxl="3" sm="6">
              <DataCard
                title="Today's Customers"
                percentChange={"4.63"}
                up={true}
                chart={<DefaultCustomerChart />}
                amount={"847"}
              />
            </Col>
            <Col xxl="3" sm="6">
              <DataCard
                title="Today's Visitors"
                percentChange={"2.63"}
                up={false}
                chart={<DefaultVisitorChart />}
                amount={"23,485"}
              />
            </Col>
            <Col xxl="6">
              <SalesStatistics />
            </Col>
            <Col xxl="3" md="6">
              <OrderStatistics />
            </Col>
            <Col xxl="3" md="6">
              <StoreStatistics />
            </Col>
            <Col xxl="8">
              <RecentOrders />
            </Col>
            <Col xxl="4" md="8" lg="6">
              <TopProducts />
            </Col>
          </Row>
                </Block> */}
                <Modal isOpen={modalForm} toggle={toggleForm}>
                    <ModalHeader
                        toggle={toggleForm}
                        close={
                            <button className="close" onClick={toggleForm}>
                                <Icon name="cross" />
                            </button>
                        }
                    >
                        Fill Complain Form
                    </ModalHeader>
                    <ModalBody>
                        <form>
                            <div className="form-group">
                                <label className="form-label" htmlFor="full-name">
                                    Complaint Type
                                </label>
                                <div className="form-control-wrap">
                                    <RSelect options={options} />
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="email">
                                    Complain
                                </label>
                                <div className="form-control-wrap">
                                    <textarea type="text" className="form-control"></textarea>
                                </div>
                            </div>
                            <div className="form-group">
                                <label className="form-label" htmlFor="phone-no">
                                    Upload Document
                                </label>
                                <div className="form-control-wrap">
                                    <input type="file" className="form-control" />
                                </div>
                            </div>
                            <div className="form-group">
                                <Button color="primary" type="submit" onClick={(ev) => ev.preventDefault()} size="lg">
                                    File Complain
                                </Button>
                            </div>
                        </form>
                    </ModalBody>
                    <ModalFooter className="bg-light">
                        <span className="sub-text">Complaint</span>
                    </ModalFooter>
                </Modal>
                <Block size="lg">
                    <BlockHead>
                        <BlockHeadContent>
                            <BlockTitle tag="h4">Complains History</BlockTitle>
                        </BlockHeadContent>
                    </BlockHead>
                    <Card className="card-bordered card-preview">
                        <OrderTable />
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default Homepage;
