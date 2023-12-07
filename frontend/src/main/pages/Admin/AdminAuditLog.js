import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Card } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, BlockBetween,  PreviewCard } from "components/Component";
import { loadAllAuditLog } from "redux/stores/activity/audit";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AllActivities from './Tables/AllActiviity'



const ActivityLog = ({ drawer }) => {
        
 

const ActivityLogTable = () => {
    
    const dispatch = useDispatch();
    const activity = useSelector((state) => state?.activity?.list) || null;
    useEffect(() => {
        dispatch(loadAllAuditLog());
    }, [dispatch]);
  
    
    const $activity = activity ? JSON.parse(activity) : null;
  
    return (
        <React.Fragment>
            <Content>


                <Block size="xl">
                    <BlockHead>
                        <BlockHeadContent>
                            <BlockTitle tag="h4">Users Activities</BlockTitle>
                            {/* <p>{activity}</p> */}
                        </BlockHeadContent>
                    </BlockHead>

                    <PreviewCard>
                        {$activity && <AllActivities data={$activity} expandableRows pagination actions />}
                    </PreviewCard>
                </Block>


            </Content>
        </React.Fragment>
    );
}


    return (
        <React.Fragment>
            <Head title="ActivityLog"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Users Activities
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <ActivityLogTable />
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default ActivityLog;
