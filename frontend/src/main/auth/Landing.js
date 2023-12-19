
import React, { useState, } from "react";
import { useNavigate } from 'react-router-dom';
import { Block, BlockDes, BlockHead, BlockHeadContent, BlockTitle, PreviewCard } from "../../components/Component";
import Content from "../../layout/content/Content";
import Head from "../../layout/head/Head";
import Logo from "../../images/fmdq/FMDQ-Logo.png";
import "./auth.css";

const Landing = ({ ...props }) => {
  const navigate = useNavigate();
  const [selectedOption, setSelectedOption] = useState(null);

  const handleOptionClick = (option) => {
    setSelectedOption(option);
  };

  const handleContinueClick = () => {
    if (selectedOption === 'accept') {
      navigate(process.env.PUBLIC_URL + '/auth-register');
    } else if (selectedOption === 'reject') {
      window.location.href = 'https://fmdqgroup.com/exchange/membership/';
    }
  };

  return (
    <React.Fragment>
      <Head title="Privacy Notice" />
      <div className="landing">
        <Content>
          <div className="content-page wide-md m-auto padding">
            <Block>
              <PreviewCard className="card-bordered">
                <BlockHead size="lg" wide="xs" className="mx-auto">
                  <BlockHeadContent className="text-center">
                    <img src={Logo} alt="fmdq logo" className="image" />
                    <h4 className="mrois-title">Members Registration Oversight Information System (MROIS)</h4>
                  </BlockHeadContent>
                </BlockHead>
                <div className="entry">
                  <h4 className="title-header">FMDQ Privacy Notice</h4>
                  <h4 className="title">Consent Requirement</h4>
                  <p>
                    FMDQ Securities Exchange Limited (the “Exchange”) is (i) committed to treating your personal information as private and confidential, and (ii) dedicated to ensuring that personal information provided is treated in accordance with best practice and extant regulation. The Exchange will process your personal information where consent has been provided or in accordance with the law. You may withdraw your consent at any given time and inform the Exchange in writing of the withdrawal. However, the withdrawal of the consent shall not affect the lawfulness of processing based on consent before withdrawal.
                  </p>

                  <p>
                    We hereby request that you provide the Exchange with your consent to collect and process your personal information by clicking the applicable check box further below.
                  </p>

                  <h4 className="title">Collectable Information</h4>
                  <p>
                    We collect personal information directly from you and where lawful and reasonable, we may collect personal information about you from third parties and publicly available sources such as government and regulatory agencies. The personal information that we collect include (but are not limited to) your name, address, age, gender, account details, passport details, bank verification number, biometric information, telephone number, email address, occupation, and other information that the Exchange deems necessary for provision of its services to you.
                  </p>

                  <h4 className="title">Purpose of Collection of Personal Information</h4>
                  <p>
                    Your information will be collected and processed for the purpose of onboarding you as a Member of the Exchange and in continuing our business relationship with you. The Exchange will also collect and process your personal information to comply with applicable law, regulatory requirements, and as a self-regulatory organisation.
                  </p>

                  <h4 className="title">Technical Methods Used to Collect and Store Information</h4>
                  <p>The methods and mediums used by the Exchange in the collection of personal information include: (a) Online forms embedded on the Member Regulation Oversight Information System; (b) Contracts and Agreements; (c) Surveys and Questionnaires; (d) Interviews; (e) Other systems to which access has been granted by virtue of your membership; and (f) Website visits. Your personal information will be retained and stored for the period in which it is needed for the purposes set out in this Notice or in line with relevant legal and regulatory requirements.</p>

                  <h4 className="title">Third Party Access to Personal Information</h4>
                  <p>The Exchange is the recipient of your personal data. In the course of providing services to you, the data collected may be shared with other FMDQ associated entities under FMDQ Group and service providers engaged by us. We will not disclose your personal information to external organisations that are not our service providers unless you give us your consent, or required by law to do so, or where necessary to the conclusion of performance of our obligations to you. In addition, we may transfer your personal information out of Nigeria in line with the requirements of the Nigeria Data Protection Regulation, 2019. We may also share your information where there is a regulatory or statutory obligation to disclose such personal information in accordance with the provisions of applicable laws.</p>

                  <h4 className="title">Principles Governing Data Processing</h4>
                  <p>The collection and use of your personal information by the Exchange is guided by certain principles which include, data accuracy, data authorisation, data limitation, data security, data confidentiality, data retention, and data accountability.</p>

                  <h4 className="title">Available Remedies in the Event of Violation and Timeframe for Remedy</h4>
                  <p>You have a right to withdraw consent for processing your personal information in cases where consent has previously been given, and the right to rectify inaccurate and incomplete information at any time, and the Exchange shall upon receipt of such request, ensure same is rectified without delay and at least within one month. You also have the right to request from the Exchange, access and the ability to rectify your personal information, restriction of the processing of your personal information, request for deletion of your personal information or to object to the processing as well the right to data portability.</p>
                  <p>The Member can also contact the Exchange's Data Protection Officer:</p>
                  Contact Name: Babajide Bayode
                  <br />
                  Email: privacypolicy@fmdqgroup.com

                  <h4 className="title">Limitation of Liability Clause</h4>
                  <p>The Exchange will not be liable for any inaccurate personal information provided by the Member.</p>

                  <h4 className="title">Changes to our Privacy Notice</h4>
                  <p>Due to constant changes in technology and regulatory requirements, we may need to change or update this Notice from time to time. You will always be able to find the most recent version of this Notice on this system.</p>

                  <h4 className="title">Additional Information</h4>
                  <p>For additional information on the Exchange’s Privacy Policy please visit our website: <a href="https://www.fmdqgroup.com/privacy-policy/" target="_blank" rel="noreferrer" style={{ color: '#1D326C' }}>www.fmdqgroup.com/privacy-policy</a></p>


                  <p>By clicking “Agree”, you confirm that you have read and understood the foregoing and consent to the collection, use, storage, processing, transfer and disclosure of your personal information in accordance with the Exchange’s Privacy Policy</p>

                  <div className="flex-button ">
                    <button className="rjt-btn" onClick={() => handleOptionClick('reject')}>Reject</button>
                    <button onClick={() => handleOptionClick('accept')}>Accept</button>
                  </div>
                  <div className="flex-button">
                    <button onClick={handleContinueClick} disabled={!selectedOption}> Confirm and Continue</button>
                  </div>
                </div>
              </PreviewCard>
            </Block>
          </div>
        </Content>
      </div>

    </React.Fragment>
  );
};

export default Landing;
