import React, { useEffect } from "react";
import { useDispatch, useSelector } from "react-redux";
import { Card } from "reactstrap";
import { Block, BlockHead, BlockHeadContent, BlockTitle, BlockBetween,  PreviewCard } from "components/Component";

import { loadAllUserLog } from "redux/stores/activity/audit";
import Content from "layout/content/Content";
import Head from "layout/head/Head";
import AuditTableUser from './Tables/AuditTableUser'



const UserAuditLog = ({ drawer }) => {
        
 

const AuditLog = () => {
    
    const dispatch = useDispatch();
    const activity = useSelector((state) => state?.activity?.ulist) || null;
    useEffect(() => {
        dispatch(loadAllUserLog());
    }, [dispatch]);
  
    
    const $activity = activity ? JSON.parse(activity) : null;
  
    return (
        <React.Fragment>
            <Content>


                <Block size="xl">
                    <BlockHead>
                        <BlockHeadContent>
                            <BlockTitle tag="h4">User Log</BlockTitle>
                        </BlockHeadContent>
                    </BlockHead>

                    <PreviewCard>
                        {$activity && <AuditTableUser data={$activity} expandableRows pagination actions />}
                    </PreviewCard>
                </Block>


            </Content>
        </React.Fragment>
    );
}


    return (
        <React.Fragment>
            <Head title="User Audit Log"></Head>
            <Content>
                <BlockHead size="sm">
                    <BlockBetween>
                        <BlockHeadContent>
                            <BlockTitle page tag="h3">
                                Activity Log
                            </BlockTitle>
                        </BlockHeadContent>
                        <BlockHeadContent>
                            
                        </BlockHeadContent>
                    </BlockBetween>
                </BlockHead>
                <Block size="lg">
                    <Card className="card-bordered card-preview">
                        <AuditLog />
                    </Card>
                </Block>
            </Content>
        </React.Fragment>
    );
};
export default UserAuditLog;
