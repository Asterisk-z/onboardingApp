<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AMC/AMB</title>
    <style>
        
        .page-break {
            page-break-after: always !important;
        }

        table.gTable {
            width: 100%;
            font-weight: lighter;
        }

        table.gTable tr td {
            text-transform: uppercase;
            text-align: center;
        }

        table.gTable,
        table.gTable>tbody>tr,
        table.gTable>tbody>tr>td {
            padding-top: 50px;
            padding-bottom: 50px;
        }

        table.p2Table {
            width: 100%;
        }

        table.p2Table th,
        table.p2Table td {
            text-align: left;
            padding: 2px;
            font-weight: lighter;
            font-size: 14px;
        }

        table.p2Table tr,
        table.p2Table td {
            width: 100%;
        }

        .padding-20>p,
        .padding-20>h4 {
            padding-left: 30px;
            padding-right: 30px;
        }

        .agreedTerm ol {
            list-style: none;
            counter-reset: num;
        }

        .agreedTerm ol li {
            counter-increment: num;
        }

        .agreedTerm ol li::before {
            content: "1."counter(num);
        }

        .agreedTerm ol li span {
            margin-left: 20px;
        }

        .nonAgency ol {
            list-style: none !important;
        }

        .nonAgency ol li::before {
            content: "";
        }


        .name-designation {
            width: 200px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .flex-space-btw {
            display: flex;
            justify-content: space-between;
        }

        .whole-signatory {
            display: flex;
            justify-content: space-between;
        }

        .signatory-cont {
            width: 200px;
        }

        .signatory {
            border-bottom: 1px solid #000;
            width: 200px;
            display: inline-flex;
        }

        .page  {
            text-align: justify !important;
            line-height: 1.5;
        }

    </style>
</head>
<body>
    <div style="width: 700px;  box-sizing: border-box;">
        <div class="page">
            <table class="gTable">
                <tbody>
                    <tr>
                        <td>MEMBERSHIP AGREEMENT</td>
                    </tr>
                    <tr>
                        <td>BETWEEN</td>
                    </tr>
                    <tr>
                        <td>FMDQ SECURITIES EXCHANGE LIMITED</td>
                    </tr>
                    <tr>
                        <td>AND</td>
                    </tr>
                    <tr>
                        <td>{{ $details->name }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="page-break"></div>
        </div>
        <div class="page">
            <h4>Table of Contents</h4>



            <table class="p2Table">
                <tr>
                    <td>1. Definitions and Interpretation ..................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>2. Market Standards......................................................................................................................................................... 8</td>
                </tr>
                <tr>
                    <td>3. Non-Agency Relationship ........................................................................................................................................... 9</td>
                </tr>
                <tr>
                    <td>4. Disclosure Requirements ............................................................................................................................................. 9</td>
                </tr>
                <tr>
                    <td>5. Anti-Money Laundering ............................................................................................................................................. 10</td>
                </tr>
                <tr>
                    <td>6. Examination of Documents ........................................................................................................................................ 10</td>
                </tr>
                <tr>
                    <td>7. Fees ............................................................................................................................................................................. 11</td>
                </tr>
                <tr>
                    <td>8. Rules and Guidelines .................................................................................................................................................. 11</td>
                </tr>
                <tr>
                    <td>9. Code of Conduct ......................................................................................................................................................... 12</td>
                </tr>
                <tr>
                    <td>10. Member’s Obligations .............................................................................................................................................. 14</td>
                </tr>

                <tr>
                    <td>11. Role Of The Exchange .............................................................................................................................................. 14</td>
                </tr>

                <tr>
                    <td>12. Discipline of the Member ......................................................................................................................................... 15</td>
                </tr>
                <tr>
                    <td>13. Termination of Membership ..................................................................................................................................... 15</td>
                </tr>
                <tr>
                    <td>14. Reporting Requirements ........................................................................................................................................... 16</td>
                </tr>
                <tr>
                    <td>15. Willingness to Promote FMDQ Exchange ................................................................................................................ 17</td>
                </tr>
                <tr>
                    <td>16. Confidentiality and Data Protection .......................................................................................................................... 17</td>
                </tr>
                <tr>
                    <td>17. Limitation of Liability ............................................................................................................................................... 18</td>
                </tr>
                <tr>
                    <td>18. Indemnity ................................................................................................................................................................... 18</td>
                </tr>
                <tr>
                    <td>19. Notices ....................................................................................................................................................................... 19</td>
                </tr>
                <tr>
                    <td>20. Binding Agreement .................................................................................................................................................... 19</td>
                </tr>
                <tr>
                    <td>21. Non-Waiver ................................................................................................................................................................ 20</td>
                </tr>
                <tr>
                    <td>22. Severability ................................................................................................................................................................ 20</td>
                </tr>
                <tr>
                    <td>23. Governing Law .......................................................................................................................................................... 20</td>
                </tr>
                <tr>
                    <td>24. Dispute Resolution ..................................................................................................................................................... 20</td>
                </tr>
                <tr>
                    <td>25. Amendment ................................................................................................................................................................. 20</td>
                </tr>
                <tr>
                    <td>26. Execution Of Agreement ............................................................................................................................................. 20</td>
                </tr>

            </table>
            <div class="page-break"></div>
        </div>
        <div class="page" style="width: 680px;">
            <h4>THIS MEMBERSHIP AGREEMENT is dated {{ formatDate($details->updated_at) }}</h4>

            <table class="p2Table">
                <tr>
                    <td>
                        <h4>BETWEEN</h4>
                        <p style="text-align:justify;">
                            
                            <strong>FMDQ SECURITIES EXCHANGE LIMITED (RC. NO. 1617162)</strong>, a company incorporated under the laws of the Federal Republic of Nigeria with its principal place of business at Exchange Place 35, Idowu Taylor Street, Victoria Island, Lagos, (hereinafter called <strong>“FMDQ Exchange”</strong> which expression shall where the context so admits include its successors and assigns) of the first part. 

                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>AND</h4>
                        <p style="text-align:justify;">
                            <strong><span style="text-transform: uppercase;">{{ $details->name }} </span>(RC NO. {{ $details->rc_number }}),</strong> a company incorporated under the laws of the Federal Republic of Nigeria with its registered office at
                            {{ $details->address }} (the <strong>“Member”</strong> which expression shall where the context so admits
                            include its successors and assigns) of the second part.
                        </p>
                        <p style="text-align:justify;">
                            In this Agreement, FMDQ Exchange and the Member shall individually be referred to as a “Party” and collectively be referred to as the “Parties”. 
                        </p>

                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>WHEREAS:</h4>
                        <div class="padding-20 agreedTerm">
                            <div class="nonAgency">
                                
                                <ol>
                                    <li>
                                        <table>
                                            <tr>
                                                <td style="width: 10px; vertical-align: top;">(A)</td>
                                                <td style="vertical-align: top; text-align: justify;">
                                                    FMDQ Exchange is licenced by the Securities and Exchange Commission (“SEC”) as a securities exchange and self-regulatory organisation with a Platform (as defined below) to enable its Members deal in Securities (as defined below) and carry out other activities. 
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                    <li>
                                        <table>
                                            <tr>
                                                <td style="width: 10px; vertical-align: top;">(B)</td>
                                                <td style="vertical-align: top; text-align: justify;">
                                                    The Member is a financial institution registered with the SEC and has indicated interest in becoming a Member (as defined below) of FMDQ Exchange with a view to offering brokerage services between Dealing Members and Clients on the Platform. 
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                    <li>
                                        <table>
                                            <tr>
                                                <td style="width: 10px; vertical-align: top;">(C)</td>
                                                <td style="vertical-align: top; text-align: justify;">
                                                   The Member has agreed to be duly licenced by FMDQ Exchange as an Associate Member (Broker). 
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                    <li>
                                        <table>
                                            <tr>
                                                <td style="width: 10px; vertical-align: top;">(D)</td>
                                                <td style="vertical-align: top; text-align: justify;">
                                                     Pursuant to the foregoing, the Parties hereby agree to be bound by the terms herein contained. 
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                </ol>
 
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="agreedTerm" >

                        <div class="nonAgency">
                            
                            <h4> IT IS HEREBY AGREED AND DECLARED as follows:-</h4>
                            
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">1.</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Definitions and Interpretation
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">1.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Definitions <br>
                                                In this Agreement, unless the context otherwise requires, the following expressions shall have the meanings set out hereunder:- 

                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Act or ISA”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the Investments and Securities Act 2007 as may be amended or supplemented from time to time;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Affiliate”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means an individual or body corporate that directly or indirectly controls, is controlled by, or is under common control with, the individual or body corporate specified.  For the purpose of this definition, the terms "controlled by" and "controls" mean the possession, directly or indirectly, of the power to direct the management or policies of an individual or body corporate, whether through the ownership of shares, by contract, or otherwise; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Agreement”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means this Membership Agreement as may be amended or supplemented from time to time; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Applicable Law”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means any law for the time being in force in Nigeria (including statutory and common law), statute, constitution, judgment, treaty, regulation, rule, by-law, order, decree, code of practice, circular, directive, other legislative measure, guidelines, guidance note, requirement, request or guideline or injunction (whether or not having force of law and, to the extent not having force of law, is generally complied with by persons to whom it is addressed or applied) of or made by any governmental authority, which is binding and enforceable; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Authorised Representatives”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means an approved representative of a Member duly recognised by FMDQ Exchange to carry out any relevant financial market related functions on behalf of the Member;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Business Day”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means a day (other than a Saturday, Sunday or Federal Government of Nigeria declared public holiday) on which banks are open for general business in Nigeria;  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“CAMA”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the Companies and Allied Matters Act 2020, as may be amended or supplemented from time to time;  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“CBN”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the Central Bank of Nigeria;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Client”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means a body corporate admitted to participate in activities as an end-user of products traded on the FMDQ Exchange platform; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Commission or SEC”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the Securities and Exchange Commission, Nigeria; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Company”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    has the meaning contained in CAMA;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                        <div class="page-break"></div>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Confidential Information”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means any information, communication or data, about any of the Parties or their respective affairs or business in any form, whether oral, written, graphic, or electromagnetic, including all plans, proposals, forecasts, technical processes, methodologies, know-how, information about technological or organisational systems, customers, personnel, business activities, marketing, financial research or development activities, databases, Intellectual Property Rights, the terms and conditions of this Agreement and other information in relation to it, whether or not it is specifically marked confidential but excluding any information, which:
                                                                    <div class="nonAgency">
                                                                        <table>
                                                                            <tr>
                                                                                <td style="width: 20px; vertical-align: top;">(I)</td>
                                                                                <td style="vertical-align: top; text-align: justify;">
                                                                                    was already known to the Recipient at the time of its disclosure to the Recipient and is not subject to confidentiality restrictions;  
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <table>
                                                                            <tr>
                                                                                <td style="width: 20px; vertical-align: top;">(II)</td>
                                                                                <td style="vertical-align: top; text-align: justify;">
                                                                                    is in the public domain at the date of its disclosure to the Recipient or thereafter enters the public domain through no fault of the Recipient (but only after it becomes part of the public domain); or 
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <table>
                                                                            <tr>
                                                                                <td style="width: 20px; vertical-align: top;">(III)</td>
                                                                                <td style="vertical-align: top; text-align: justify;">
                                                                                    is independently developed by the Recipient without use or reference to the Disclosing Party’s confidential information, as shown by documents and other competent evidence in the receiving Party’s possession; or 
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <table>
                                                                            <tr>
                                                                                <td style="width: 20px; vertical-align: top;">(IV)</td>
                                                                                <td style="vertical-align: top; text-align: justify;">
                                                                                    is required by law or regulation to be disclosed by the Recipient, provided that the Recipient, where it is reasonable in the circumstances and to the extent permitted by law or regulation, shall promptly give the Disclosing Party written notice of such requirement prior to any disclosure so that the Disclosing Party may seek a protective order or other appropriate relief;
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Court ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means any court of competent jurisdiction;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Dealing Member ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means any financial institution which has been admitted to trade Products on the Platform;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Disclosing Party ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the Party disclosing an item of Confidential Information;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ DMO ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the Debt Management Office of the Federal Republic of Nigeria; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ FMDQ Exchange Fees & Dues Framework ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the framework as advised to the Members containing all relevant and applicable fees and dues (including Membership Dues) as may be updated from time to time; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ FMDQ GOLD Award ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means a recognition of exceptional performance on the securities exchange, exemplary compliance with the FMDQ Exchange Rules and contribution to the Nigerian financial markets;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <div class="page-break"></div>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ FMDQ Exchange Rules ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means rules, circulars, bulletins, guidelines and other regulation designed by FMDQ Exchange (and where required, approved by the SEC, CBN or DMO, as the case may be) and advised to the Members to govern activities on the Platform, as may be supplemented and amended from time to time;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Force Majeure Event ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the occurrence of an event which materially interferes with the ability of a Party to perform its obligations or duties hereunder which is not within the reasonable control of the Party affected or any of its Affiliates, and which could not with the exercise of diligent efforts have been avoided, including, but not limited to, war (whether or not declared), rebellion, earthquake, fire, explosions, accident, strike, lockouts or other labour disturbances, riot, civil commotion, act of God, epidemics, pandemics, national emergencies, work stoppages, state or federal lockdowns, orders and laws of governmental authorities (both federal and state), change in Law or any act of God or other cause beyond the control of the Parties;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Intellectual Property Rights” ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    includes any patent, copyright, trademark, trade name, trade secret, brand name, logo, corporate name, internet domain name or industrial design, any registrations thereof and pending applications therefor, any other intellectual property right (including, without limitation, any know-how, trade secret, trade right, formula, conditional or proprietary report or information, customer or membership list, any marketing data, and any computer program, software, database or data right), and license or other contract relating to any of the foregoing, and any goodwill associated with any business owning, holding or using any of the foregoing; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Insider Trading ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means trading done by an individual or body corporate or group of individuals or bodies corporate who being in possession of some confidential and price sensitive information not made available to the public, utilises such information to buy or sell Securities for the benefit of themselves or any other individual or body corporate; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Market ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the Debt Management Office of the Federal Republic of Nigeria; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Member ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means Associate Member (Broker), which is a brokerage firm licenced by FMDQ Exchange to offer brokerage services between Dealing Members and Clients on the Platform; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Personal Data ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                   has the meaning contained in the Nigeria Data Protection, Regulation, 2019;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <div class="page-break"></div>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Platform ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the FMDQ Exchange-organised marketplace for listing, registration, quotation, trading and trade reporting; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Product ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means any instrument, security, currency, or other contract admitted by FMDQ Exchange for trading on the Platform, Products shall be construed accordingly;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Private Censure ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means a private disciplinary action that constitutes a formal expression of disapproval of a Member by FMDQ Exchange. It includes but is not limited to warning or infractions letters issued to the Member; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Public Censure ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means a public disciplinary action that constitutes a formal expression of disapproval of a Member by FMDQ Exchange. It includes but is not limited to newspaper publications and postings on the FMDQ Exchange website; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Recipient ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the Party receiving an item of Confidential Information; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Securities Exchange ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    has the meaning assigned to it in the ISA (or subsequent amendments thereto); 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“SEC Rules”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the rules and regulations of the Commission issued pursuant to the ISA as may be amended and supplemented from time to time; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“System”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means an electronic trading programme that allows Members to submit trade-related data and fulfil contractual obligations leading up to the clearing and settlement of executed trades. Systems used on the FMDQ Exchange Platform include (but are not limited to) Bloomberg E-bond Trading System, Refinitiv Trading System, FMDQ OTC FX Futures Trading & Reporting System. Trading systems may be different from the clearing and settlement systems. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                </ol>


                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <div class="page-break"></div>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">1.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Interpretation <br> In this Agreement: 
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.1.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    Words importing the singular number only shall include the plural and vice-versa	 and words importing the feminine gender only shall include the masculine gender and vice versa and words importing persons shall include corporations, associations, partnerships and governments (whether state or local), and the words “written” or “in writing” shall include printing, engraving, lithography or other means of visible reproduction. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.2.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    The words “hereof,” “herein,” “hereby,” “hereto” and similar words refer to this entire Agreement and not any particular Clause, Schedule or other subdivision of this Agreement. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.3.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    A reference to “Party” or “Parties” shall mean a party or parties to this Agreement. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.4.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    A reference to a statutory provision shall be deemed to include that provision as the same may from time to time be modified, amended or re-enacted.  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.5.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    Any reference to Clauses and Schedules, are to Clauses and Schedules of this Agreement, and references to sub-clauses and paragraphs are references to sub-clauses and paragraphs of the clause or schedule in which they appear.  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.6.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    A reference to a provision of this Agreement is to that provision as amended in accordance with the terms of this Agreement. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.7.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    A reference to “consent” means any consent, approval, authorisation, licence or clearance of any kind whether fiscal, statutory or regulatory. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.8.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    A reference to any document being “in the agreed form” means in a form which has been agreed by the Parties on or before the date of this Agreement and for identification purposes signed by them or on their behalf by their Authorised Signatories. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.9.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    References to days shall refer to calendar days unless Business Days are specified; references to weeks, months or years shall be to calendar weeks, months or years respectively. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.10.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                     References to any liability shall include actual, contingent, present or future liabilities. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.11.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                     Words and expressions defined in any clause shall, unless the application of any such word or expression is specifically limited to that clause, bear the meaning assigned to such word or expression throughout this Agreement. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.12.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                     The expiration or termination of this Agreement shall not affect the provisions of this Agreement which are expressly indicated to survive the expiration or termination or which of necessity must continue to have effect after such expiration or termination either expressly or impliedly.  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.13.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                     Where figures are referred to in numerals and in words, and there is any conflict between the two, the words shall prevail, unless the context indicates a contrary intention. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.14.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                     Defined terms appearing in this Agreement in upper case shall be given their meaning as defined, while the same terms appearing in lower case shall be interpreted in accordance with their plain English meaning.	 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <div class="page-break"></div>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;"></td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.15.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                     Words and phrases used in this Agreement, unless otherwise defined in this Agreement, shall have the meanings given to them in the FMDQ Exchange Rules, SEC Rules, CBN circulars, DMO guidelines, the ISA and any other legislative enactment.   
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.16.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                     A reference to FMDQ Exchange or the Member herein shall include reference to their respective successors and assigns. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.17.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                     The division of this Agreement into clauses and sub-clauses, the provision of a table of contents and the insertion of headings are for convenience of reference only and shall not be deemed to form part of the text or affect the construction or interpretation hereof. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">1.2.18.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                     Any money payable under this Agreement on a day that falls on a public holiday shall be paid on the next Business Day. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>


                            <h4>2. Market Standards</h4>
                            <p>The Member shall:</p>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">2.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                use its best endeavours to maintain such market standards as may be determined and communicated to the Member by FMDQ Exchange from time to time in its dealings with any Issuer or investor;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">2.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                comply with the minimum standards on risk management and compliance prescribed and communicated to the Member from time to time by FMDQ Exchange;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">2.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                establish a robust risk management and compliance function which shall be responsible for identifying, measuring, monitoring and reporting any risks that the Member may be exposed to; and
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">2.4</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                maintain a proper structure that ensures the efficiency of its risk management and compliance function.
                                            </td>
                                        </tr>
                                    </table>
                                </li>


                            </ol>

                            <h4>3. Non-Agency Relationship</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member or its Authorised Representatives shall not hold itself out to any individual or body corporate as being an agent of or otherwise representing or having the power in any way to act for or bind FMDQ Exchange unless expressly authorised in writing.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>

                            <h4>4. Disclosure Requirements</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">4.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                <p>The Member hereby undertakes to:</p>


                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">4.1.1</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    disclose in writing to FMDQ Exchange its membership of any other Securities Exchange at the time of the execution of this Agreement;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">4.1.2</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    disclose to FMDQ Exchange in writing, not later than one (1) calendar month from when it becomes a Member of any other Securities Exchange after the execution of this Agreement, specifying the name and principal place of business of the other Securities Exchange, the date it was registered as a member of the Securities Exchange, the duration of its membership, and such additional or other information as may be required by FMDQ Exchange;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <div class="page-break"></div>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;"></td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">4.1.3</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    disclose to FMDQ Exchange not later than one (1) calendar month after the execution of this Agreement the particulars of its management personnel and director(s) who are responsible for overseeing its financial markets function; provided that where any changes are made in respect of the aforementioned persons, it will not later than one (1) calendar month thereafter inform FMDQ Exchange of such change;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">4.1.4</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    disclose any information regarding any Security that it believes may abnormally affect the Market to FMDQ Exchange within twenty-four (24) hours of being aware of the information;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">4.1.5</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    disclose any investigation, sanction, enforcement proceeding or injunction against it in respect of any matter related to this Agreement, or any other membership agreements executed with any securities exchange, self-regulatory organisation, regulatory authority or such other body that may adversely affect the performance of its obligations herein to FMDQ Exchange within twenty-four (24) hours of being aware of the investigation, sanction, enforcement proceeding or injunction;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">4.1.6</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    disclose any event which may impair its ability to comply with this Agreement or any of the FMDQ Exchange Rules to FMDQ Exchange within twenty-four (24) hours of being aware of the event;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">4.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                For the purpose of this clause, “disclose” means to alert, make known or reveal any of the event mentioned in clause 4.1 to FMDQ Exchange. FMDQ Exchange however reserves the right to demand more information should the need arise.
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>

                            <h4>5. Anti-Money Laundering</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">5.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member covenants and represents that at all times during the subsistence of this Agreement, it shall comply with all applicable laws, policies and regulations on money laundering, including the SEC (Capital Market Operators Anti-Money Laundering, Combating the Financing of Terrorism and Proliferation Financing), Regulations, 2022 and shall establish/maintain a robust and comprehensive anti-money laundering/counter-terrorism financing framework. It shall adopt policies stating its commitment to comply with Anti-Money Laundering, Countering the Financing of Terrorism and Countering the Proliferation Financing (AML/CFT/CPF) obligations under the law and regulatory directives to actively prevent any transaction that facilitates criminal activities.The Member covenants and represents that at all times during the subsistence of this Agreement, it shall comply with all applicable laws, policies and regulations on money laundering including the SEC (Capital Market Operators Anti-Money Laundering, Combating the Financing of Terrorism and Proliferation Financing), Regulations, 2022 and shall establish/maintain a robust and comprehensive anti-money laundering/counter-terrorism financing framework. It shall adopt policies stating its commitment to comply with Anti-Money Laundering, Countering the Financing of Terrorism and Countering the Proliferation Financing (“AML/CFT/CPF”) obligations under the law and regulatory directives to actively prevent any transaction that facilitates criminal activities. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">5.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member undertakes to keep all records and documentation pertaining to any anti-money laundering and counter-terrorism financing due diligence procedures relating to its activities on the Platform for such period as required by FMDQ Exchange or by Applicable Law.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <div class="page-break"></div>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">5.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Subject to any Applicable Law prohibiting disclosure, if FMDQ Exchange is required by the regulatory authorities to satisfy itself or such authorities as to the facts of any transaction or activities of the Member on the Platform or FMDQ Exchange suspects any form of money laundering or terrorism financing, or at any time pursuant to FMDQ Exchange’s request, the Member must immediately provide copies of all due diligence materials relating to such transaction or activities to FMDQ Exchange and/or all relevant regulatory authorities. In such circumstances, the Member must also provide a translation and certification of such documents if so requested by FMDQ Exchange.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">5.4</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                If the Member delegates, assigns, subcontracts or transfers any of its rights or obligations under this Agreement to another party, the Member shall ensure that such party complies with the requirements set out in this Agreement, FMDQ Exchange’s Rules and Applicable Law.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">5.5</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member will ensure that none of its subsidiaries or Affiliates will fund all or part of any payment under any transaction out of proceeds derived from any unlawful activity which would result in any violation of any anti-money laundering or counter-terrorism financing legislation in force in Nigeria (as may be amended) and regulations thereunder or any other Applicable Law or regulation concerning anti-money laundering or the prevention thereof.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>

                            <h4>6. Examination of Documents</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">6.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member hereby undertakes that it shall make itself available for examination or audit howsoever required, and to make available any document or record relating to the Member’s functions as a Member, whether by means of paper copy, electronic copy, disk, hard drive, flash drive or such other storage device in its possession or subject to its possession, when required by FMDQ Exchange to carry out its supervisory function, provided that FMDQ Exchange shall give fourteen (14) days’ notice of such examination or review. Notwithstanding the foregoing, the Parties agree that FMDQ Exchange shall have the right to audit the documents or records of the Member, at any time and without notice, where there is a reasonable cause to do so.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                

                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">6.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                FMDQ Exchange shall ensure the confidentiality of documents provided under clause 6.1 above and not to disclose its content except as required by any law, rule, regulation, order, and judgment of a competent court in Nigeria or for any other lawful purpose and shall notify the Member before such disclosure, where practicable, and where it is impracticable to notify the Member prior to such disclosure, provide written notice to the Member promptly after disclosure.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>

                            <h4>7. Fees</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">7.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Listing Fees <br>
                                                The Member hereby agrees that:
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">7.1.1</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    FMDQ Exchange shall charge and may revise listing fees for every Security sought to be listed by an Issuer and such fees will be provided in the FMDQ Exchange Fees and Dues Framework.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">7.1.2</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    Pursuant to clause 7.1.1, notice of revision of listing fees shall be communicated to the Member.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                                <div class="page-break"></div>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">7.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Membership Dues
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">7.2.1</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    The Member shall pay an annual membership due to FMDQ Exchange at a rate to be determined by FMDQ Exchange from time to time.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">7.2.2</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    The Membership Dues shall be payable immediately upon the execution of this Agreement and shall thereafter become payable on the first Business Day of January of each year. FMDQ Exchange shall have the right to revise the dues from time to time.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;"></td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">7.2.3</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    Notice of the revised Membership Dues shall be communicated to the Member within seven (7) Business Days of such revision and in any case before the expiration of the subsisting Membership Dues.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">7.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                FMDQ Exchange shall issue an invoice to the Member for the Membership Dues. If the Member does not pay the Membership Dues within two (2) weeks of the date of the issue of the invoice, the Member shall lose all rights and privileges on the FMDQ Exchange Platform.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">7.4</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Suspension or termination of the Member’s licence under the provisions of this Agreement shall not prevent FMDQ Exchange from proceeding against the Member for the recovery of all fees payable through all available legal means.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>


                            <h4>8. Rules and Guidelines</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member shall comply with the provisions of the FMDQ Exchange Rules and any amendments thereto as may be made by FMDQ Exchange, in its relationship with FMDQ Exchange, other Members, Issuers and investors.

                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>


                            <h4>9. Code of Conduct</h4>

                            <ol>
                                <li>
                                    The Member shall comply with the code of conduct set out below and as contained in the FMDQ Exchange Rules when acting as a Member.
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">9.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                General Duties of Integrity, Care and Full Disclosure <br />
                                                As the sponsor to an Issuer’s listing of a Security, the Member shall:

                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.1.1</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    observe high standards of integrity and fair market conduct;  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.1.2</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    act with due skill, care and diligence; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.1.3</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    refrain from any act or conduct which is likely to mar the reputation of FMDQ Exchange and the Market; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.1.4</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    ensure that its Authorised Representatives act in an honest, open, truthful, cooperative manner and not mislead or conceal any material matter; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.1.5</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    when required to disclose any fact to FMDQ Exchange or investors, to act in an honest, open, truthful, cooperative manner and not mislead or conceal any material matter; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.1.6</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    provide full and prompt responses to all requests for information by FMDQ Exchange in respect of any Product traded on the Platform and provide access to all relevant books, records and other forms of documentation in accordance with the provisions of any applicable law and/or regulation;  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                                <div class="page-break"></div>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;"></td>
                                            <td style="vertical-align: top; text-align: justify;">

                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.1.7</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    take reasonable steps to ensure that its Authorised Representatives or any individual designated by it as responsible for its activities on the Platform are not under any legal obligation that restricts their ability to act for and on behalf of the Member; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.1.8</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    take reasonable steps to ensure that its Authorised Representatives or any other individual designated by it as responsible for its activities on the Platform are not under the influence of any prohibited drug or substance or under the influence of alcohol when carrying on any activity on the Platform; and 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.1.9</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    take reasonable steps to prevent any form of gambling or betting between its officers, employees, representatives, agents or any other individual or body corporate so designated amongst themselves or with the officers, employees, representatives, agents of any other trader or any member of the general public in respect of any activity on the Platform.  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>


                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">9.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                No Fraudulent or Misleading Conduct<br />
                                                The Member shall not engage in, or fail to take reasonable steps to prevent:
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.1</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    any action that has the effect, or may be expected to have the effect, of artificially and/or abnormally affecting the price or value of any Product traded on the Platform; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.2</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    entering artificial transactions or otherwise entering into or causing any artificial transaction; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.3</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    a fictitious transaction or any other false data to FMDQ Exchange or causing such data to be inputted into any FMDQ Exchange System by reporting such fictitious transaction or false data whilst knowing the transaction or data to be fictitious or false; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.4</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    any illegal action or conduct that creates or is likely to create any false or misleading impression as to the market price or value of any Product traded on the Platform; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.5</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    any action or conduct that may mar the integrity and transparency of the Platform;   
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.6</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    activities prohibited by this Agreement or the FMDQ Exchange Rules or act in concert with, or provide any assistance to any individual or body corporate (whether or not a Member) with a view to carrying out acts prohibited by this Agreement or the FMDQ Exchange Rules, or otherwise causing or contributing to a breach of any Applicable Law by such other individual or body corporate;  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.7</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    its Authorised Representatives from effecting or causing to happen a fraud or deception in relation to any Product traded on the Platform; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.8</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    its Authorised Representatives from participating in any Insider Trading in relation to a Product or knowingly assist any other individual or body corporate to participate in any such Insider Trading;  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.9</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    its Authorised Representatives from engaging in personal dealings, whether directly or indirectly, in Products traded on the Platform which the Member may have confidential information by virtue of being a capital markets participant;  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.10</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    fraudulent activities, whether directly or indirectly through an Affiliate, or otherwise make any untrue or misleading statement, or engage in any act, practice, or course of business which operates or would operate as a fraud or deceit upon any person, in connection with the purchase or sale of any Product. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                                <div class="page-break"></div>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">9.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Authorised Representatives of the Member
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.1 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    The Member shall advise FMDQ Exchange of its Authorised Representatives at the point of onboarding to become a Member.   
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.2 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    The Member shall be responsible for the actions of its Authorised Representatives. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.3 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    Persons designated to act as Authorised Representatives shall be required to meet specified competency requirements as may be laid down by FMDQ Exchange from time to time. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.4  </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    FMDQ Exchange may upon notice to the Member decline to recognise any Authorised Representatives or terminate the status of an Authorised Representatives if upon investigation the Authorised Representatives is determined to have acted in an unethical manner or is found no longer fit and proper to act as a Authorised Representatives. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;"></td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.5 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    The Member shall make adequate arrangements to ensure that all its Authorised Representatives are suitable, competent, knowledgeable, adequately trained and properly supervised. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.6 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    The Member shall ensure that its Authorised Representatives participates in and completes all trainings, inductions and all other competency requirements as FMDQ Exchange may prescribe from time to time.  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.7 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    The Member shall have the responsibility and duty to ascertain by investigation the good character, business repute, qualifications and experience of its Authorised Representatives.  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.8 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    The Member shall also be responsible for ensuring that training programmes are designed to enhance the knowledge and competence of its Authorised Representatives as an Associate Member (Broker) of FMDQ Exchange. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.9 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    The Member shall ensure that its Authorised Representatives completes all relevant annual corporate governance, risk management, compliance, AML/CFT/CPF, know-your-customer (“KYC”), reporting and such other trainings, tests and certifications and standards as may be required by FMDQ Exchange or any Applicable Law not less than once a year. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.10 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    The Member shall notify FMDQ Exchange in writing within seven (7) Business Days of any change to the list of Authorised Representatives in its employment, and bi-annually, that is, January and July of every year as part of its compliance reporting to FMDQ Exchange. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">9.4</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Responsibility for Transactions 
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.4.1 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    he Member agrees to be responsible for, all transactions and/or business conducted on the FMDQ Exchange Platform using it’s approved and recognised electronic access code, and the password/security log-in details of its Authorised Representativeswhether or not such transaction and/or business was duly approved by the authorised officers of the Member; and
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.2  </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    the Member agrees to be solely responsible for the accuracy of quotes and orders entered on the FMDQ Exchange Platform through its Authorised Representatives.  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">9.5</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Degradation of Service
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;"> </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    When using the System and associated facilities, the Member is prohibited from engaging in practices which may cause degradation of the service or give rise to a disorderly market. Such practices include, but are not limited to, submitting unwarranted or excessive electronic messages or requests to the system. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>

                            <div class="page-break"></div>

                            <h4>10. Member’s Obligations</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.1 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                except as otherwise provided in this Agreement or abide by the FMDQ Exchange Rules and any other agreement with FMDQ Exchange in force and as may be reasonably amended from time to time and promptly notified to the Member by FMDQ Exchange; 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.2 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                ensure that that the Issuer is in compliance with pay the fees, dues and other applicable charges as set out in this Agreement prescribed by FMDQ Exchange according to the conditions established by FMDQ Exchange and promptly communicated to the Member; 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.3 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                be responsible for the compilation and submission subject to clause 6.1, authorise FMDQ Exchange or its duly appointed agents to carry out on-site examinations and investigations, during normal business hours, in any place of business of the Member or its Affiliate, and submit as soon as possible any information or document relating to this Agreement which FMDQ Exchange or its agents consider appropriate for purposes of such examinations and investigations;  
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.4 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                abide by the FMDQ Exchange Rules and any other agrcomply with the technical requirements of the relevant trading System(s) and/or any other information technology system or network operated and advised by FMDQ Exchange;  
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.5 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                ensure that the Issuer meets the minimum applicatinotify FMDQ Exchange immediately in writing of any material changes to the information submitted during the course of its membership application, including in particular (but not limited to) those in respect of the Member's  licence or permission to conduct trading in Products; 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.6 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                ensure that the amount raised through the issuancenotify FMDQ Exchange of any facts or circumstances which may affect the legal form or organisation of the Member or its trading activities on the Platform, including (but not limited to) any consolidation, reorganisation, merger, change of name, change of control or similar event to which the Member is or will become a Party and provide such additional information as FMDQ Exchange may reasonably require;  
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.7 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                immediately notify FMDQ Exchange as soon as it is served or becomes aware of any bankruptcy, insolvency, winding up, administration or equivalent event (including amicable settlement) in any relevant jurisdiction the Member is subject to or to which the Member is a Party;  
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.8 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                ensure that any description of its membership or the services that it is able to provide, in the form and context in which it appears or is used, does not misrepresent the scope of the capacity which it enjoys as a Member on FMDQ Exchange; 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <div class="page-break"></div>

                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.9 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                document, implement and maintain adequate internal procedures and controls in relation to its business on the Platform;   
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.10</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                ensure that it takes reasonable steps to prevent off market quotes by its Authorised Representatives. Provided always that where it has knowledge of any circumstance justifying such off-market quote, it shall promptly notify FMDQ Exchange not later than thirty (30) minutes after becoming aware of such circumstance; 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.11</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                meet the corporate governance, risk management, compliance, AML/CFT/CPF, KYC, reporting and such other trainings, tests, certifications and standards as may be required by FMDQ Exchange or any Applicable Law not less than once a year; 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.12</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                take reasonable steps to ensure that its Authorised Representatives do not participate in any form of Insider Trading in relation to any Product traded on the Platform, or knowingly or with gross negligence assist any individual or body corporate to participate in any such Insider Trading; 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.13</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                ensure that documents, records, or any other material related to its brokerage activities howsoever called are kept strictly confidential except as may be required by any law, rule, regulation, order or judgment of a competent court in Nigeria; 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.14</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                keep and maintain proper records and books of account in respect of all transactions carried out by it for a period to be advised by FMDQ Exchange and where not expressly advised, in accordance with FMDQ Exchange’s prevailing FMDQ Exchange Rules and any other Applicable Law; 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.15</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                not transact business with any natural and legal person whose membership rights have been suspended or revoked except as expressly approved in writing by FMDQ Exchange. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.16</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                keep and retain all recordings of phone conversations, text messages and e-mails, based on which any transaction on the Platform was conducted for a period to be advised by FMDQ Exchange and in accordance with FMDQ Exchange Rules; and 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.17</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                promptly provide complete and accurate data and statistics which FMDQ Exchange may reasonably request from time to time.
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>

                            <h4>11. Role of the Exchange </h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">11.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                FMDQ Exchange undertakes to discharge its regulatory obligations as a securities exchange operating in Nigeria with fidelity.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">11.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                FMDQ Exchange shall provide the Member access to the Platform provided it complies with the terms of this Agreement and the Rules. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>
                              <div class="page-break"></div>
                            <h4>12. Discipline of the Member</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">12.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member hereby acknowledges that FMDQ Exchange has the power to take disciplinary action against it for any established violation of any of the FMDQ Exchange Rules in force, or as may be amended from time to time, or any provision of this Agreement. In particular, FMDQ Exchange has the power to impose any of the following penalties on the Member and may as appropriate, report the disciplinary action to the relevant regulatory body:
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">(a)</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    fines;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">(b)</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    non-consideration for FMDQ GOLD Award;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">(c)</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    suspension of membership on such terms and for such period as FMDQ Exchange may think fit;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">(d)</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    revocation of the Member’s licence; or
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">(e)</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    Public and/or Private Censure.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>


                                                </ol>

                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">12.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The disciplinary powers referred to above may be exercised separately or concurrently. The exercise of such powers shall not prejudice any right that may be vested in FMDQ Exchange to seek legal redress against the Member in pursuance of enforcement of the disciplinary decision.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">12.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Where the Member’s licence is revoked, it shall forthwith lose all rights to act as a Member.
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>
                            <div class="page-break"></div>

                            <h4>13. Termination of Membership</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;"> 13.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member shall cease to be a Member if:

                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.1</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    it gives FMDQ Exchange sixty (60) days’ notice in writing of its intention to terminate its membership. Such membership shall terminate at the expiration of the sixty (60) days’ notice. Notwithstanding the notice period in this sub-clause 13.1.1, FMDQ Exchange may terminate the membership (upon receipt of the notice in writing from the Member), within such shorter period as FMDQ Exchange deems fit, where the Member has no outstanding obligation(s);
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.2</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    it is wound up voluntarily;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.3</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    it has become insolvent;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.4</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    it is compulsorily wound up by order of the Court;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.5</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    the Commission has revoked its registration/licence;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.6</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    it is unable to meet or has defaulted in its obligations under this Agreement;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.7</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    upon investigation by FMDQ Exchange, it is proven that it has acted in an unprofessional and unethical manner in the Market; or
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.8</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    any other reason as FMDQ Exchange may deem fit to terminate the licence of the Member.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                </ol>

                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">13.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                               The Member hereby acknowledges that termination of its membership shall not prevent FMDQ Exchange from collecting any accrued fees, dues, fines or charges due or arising from this Agreement, the FMDQ Exchange Rules or any other agreement between FMDQ Exchange and the Member.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">13.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member hereby acknowledges that FMDQ Exchange reserves the right to apply to the Courts to recover any fees, dues, fines or charges due or arising from this Agreement upon termination of its membership and/or take all necessary steps to protect any investor until such a time that all reported claims have been settled.	 
                                            </td>
                                        </tr>
                                    </table>
                                </li>


                            </ol>

                            <h4>14. Reporting Requirements</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">14.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member, in respect of all sponsored listed Securities shall:
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">14.1.1 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    comply with the reporting requirements as determined by FMDQ Exchange and/or advised by any relevant regulatory authority (e.g. the SEC) from time to time; and 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">14.1.2 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                        submit complete trade data as captured in FMDQ Exchange-advised reporting templates at frequencies to be determined by FMDQ Exchange and/or advised any relevant regulatory authority.
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </li>

                                                </ol>

                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">14.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member shall also meet any other reporting obligations and standards as may be required by FMDQ Exchange from time to time. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>



                            <div class="page-break"></div>


                            <h4>15. Willingness to Promote FMDQ Exchange</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member hereby agrees to:
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">(i) </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    participate in market development sessions organised by FMDQ Exchange;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">(ii)</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    attend functions organised by FMDQ Exchange upon receipt of a written invitation from FMDQ Exchange;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">(iii)</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    within the Member’s discretion, promote FMDQ Exchange as a market destination; and
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">(iv)</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    provide advice, feedback and suggestions to FMDQ Exchange.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>


                                                </ol>


                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>
                            <h4>16. Confidentiality and Data Protection</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">16.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Parties shall treat as strictly confidential all Confidential Information and shall ensure that their respective authorised representatives use the Confidential Information only for the performance of their obligations and the exercise of their rights under this Agreement;.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">16.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Each Party shall protect and adequately secure every data belonging to the other Party and shall prevent against the theft or disclosure of such data by its Affiliates, directors, employees, representatives, subcontractors, agents, or any other individual or body corporate having access to the data through it.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">16.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                In the event that a Party learns of any theft, unauthorised use, disclosure, or threatened unauthorised use or disclosure of any Confidential Information, the Party shall notify the other Party of the particulars of such theft, unauthorised use or disclosure;.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">16.4</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Parties undertake and agree to comply with the provisions of the Nigeria Data Protection Regulation, 2019 issued by the National Information Technology Development Agency and any amendments thereto in respect of any Personal Data received pursuant to or in connection with this Agreement.
                                            </td>
                                        </tr>
                                    </table>
                                </li>


                            </ol>



                            <h4>17. Limitation of Liability</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">17.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Parties hereby acknowledge that each Party shall have no liability or obligation to the other for:
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">17.1.1</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    occurrences that could not have been reasonably foreseen at the date of execution of this Agreement; and includes a Force Majeure Event, provided that an event of Force Majeure shall not excuse a Party’s obligations to make payments due under this Agreement; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">17.1.2</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    any loss or damage which may be suffered, or which may arise directly or indirectly as a result of activities in the Market not caused by FMDQ Exchange, its staff and agents; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">17.1.3</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    any act, error, failure or omission on the part of FMDQ Exchange, acting reasonably, including any loss or damage in respect of the suspension, cancellation, interruption or closure of the Market in compliance with relevant directives or orders from any regulatory body in Nigeria;  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">17.1.4</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    the originality, accuracy or completeness of any information or market data provided by a third party;  
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                </ol>

                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <div class="page-break"></div>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;"></td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">17.1.5</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    FMDQ Exchange’s decision to suspend or terminate the licence of the Member provided such suspension or termination is in compliance with the provisions of this Agreement, the FMDQ Exchange Rules, SEC Rules, the ISA, CBN circulars and DMO guidelines or any other relevant legal framework; and 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">17.1.6</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    any decision of FMDQ Exchange in the exercise of its powers; provided that such powers are specifically established under this Agreement or the FMDQ Exchange Rules. 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>


                                                </ol>

                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>




                            <h4>18. Indemnity</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">18.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member hereby undertakes to indemnify FMDQ Exchange against any claim or loss arising from its wrongful, negligent or illegal activities on the Platform done in contravention of any provision of this Agreement or FMDQ Exchange Rules. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">18.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                FMDQ Exchange hereby undertakes to indemnify the Member against any claim or loss arising from its violation of the terms of this Agreement. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">18.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member shall at all times during the subsistence of this Agreement maintain fidelity bond coverage as prescribed by the SEC. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">18.4</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member hereby agrees to notify FMDQ Exchange in writing within twenty-four (24) hours of being aware that its fidelity bond has expired, been cancelled, terminated, or substantially modified. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>

                            <h4>19. Notices</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">19.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Any notice, request or other communication to be given or made under this Agreement shall be in writing. Any such communication shall be delivered by hand, airmail, established courier service, e-mail or other agreed medium to the Party to which it is required or permitted to be given or made at such Party’s address specified below or at such other address as such Party has from time to time designated by written notice to the other Party hereto, and shall be effective upon the earlier of (a) actual receipt and (b) deemed receipt under clause 19.2 below.<br />
                                                If to FMDQ Exchange: <br /><br />

                                                Member Regulation Group<br />
                                                FMDQ Securities Exchange Limited<br />
                                                Exchange Place<br />
                                                35, Idowu Taylor<br />
                                                Victoria Island<br />
                                                Lagos<br /><br />

                                                OR via email: meg@fmdqgroup.com<br /><br />

                                                If to the Member:<br /><br />

                                                Managing Director<br />
                                                {{ $details->name }}<br />
                                                {{ $details->address }}<br />

                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                
                            <div class="page-break"></div>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">19.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Any notice given as aforesaid shall be deemed to have been served when received, and shall be deemed to have been received (a) in the case of delivery by hand or courier, when delivered as evidenced by a receipt from the addressee; or (b) in the case of e-mail or other agreed medium, upon receipt by the sending party of electronic confirmation of receipt by the intended recipient. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">19.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                All documents to be provided or communications to be given or made under this Agreement shall be in English and, where the original version of any such document or communication is not in English, shall be accompanied by an English translation certified to be a true and correct translation of the original. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">19.4</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                In addition to clause 19.1, FMDQ Exchange may convey notices via other electronic broadcasts and/or via the Market Bulletin segment on the FMDQ Exchange website. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>


                            </ol>

                            <h4>20. Binding Agreement</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Notwithstanding any contrary agreement, both Parties agree that this Agreement constitutes a legal, valid and binding agreement which shall be enforceable against it in accordance with its terms. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>

                            <h4>21. Non-Waiver</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="vertical-align: top; text-align: justify;">
                                                No failure or delay by FMDQ Exchange to exercise any right, power or privilege hereunder shall operate as a waiver thereof nor shall any single or partial exercise of any right, power or privilege preclude any other or further exercise thereof, or the exercise of any other rights, power or privilege as herein provided. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>

                            <h4>22. Severability</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="vertical-align: top; text-align: justify;">
                                                If any provision of this Agreement is declared by any judicial or other competent authority to be void or otherwise unenforceable, that provision shall be severed from this Agreement and the remaining provisions shall remain in force and effect. Provided that the Parties shall thereafter amend this Agreement in such reasonable manner so as to achieve, without illegality, the intention of the Parties, with respect to the severed provision.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>



                            <h4>23. Governing Law</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Notwithstanding any other agreement to the contrary, this Agreement and all amendments thereto shall be governed by and construed in accordance with Nigerian law
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>





                            <h4>24. Dispute Resolution</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">24.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                In the event of any dispute arising out of or under this Agreement, the Parties shall within five (5) Business Days from the date the dispute arose, engage in an amicable settlement of the dispute by mutual negotiation.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">24.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Where the dispute is not resolved by mutual negotiation, the Parties shall in compliance with the provisions of the ISA, refer the matter to the Investment and Securities Tribunal for resolution.  
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>


                            <div class="page-break"></div>

                            <h4>25. Amendment</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The terms of this Agreement may be amended or varied by FMDQ Exchange (acting in good faith) from time to time by giving one (1) month calendar notice to the Member informing it of such amendment or variation. 
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>



                            <h4>26. Execution of Agreement</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="vertical-align: top; text-align: justify;">
                                                This Agreement shall be executed on behalf of the Member by any two (2) Directors or a Director and a Company Secretary of the Member. Where the Agreement is executed by any other representative of the Member, the Member must notify FMDQ Exchange in writing that such representative is authorised to execute this Agreement.  
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>

                            <h4>IN WITNESS WHEREOF the Parties have caused their authorised representatives to execute this
                                Agreement in the manner below, the day and year first above written </h4><br>

                            <h4>Signed for and on behalf of the within-named <br>
                                FMDQ SECURITIES EXCHANGE LIMITED:</h4>

                            <table>
                                <tr>
                                    <td style="width: 250px; vertical-align: bottom;">
                                        <div class="">
                                            <div class="signatory-cont">
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
                                                <div><Strong>Name: </Strong><span></span></div>
                                                <div><Strong>Designation: </Strong><span></span></div>
                                            </div>
                                        </div>

                                    </td>
                                    <td style="width: 250px; vertical-align: top;">
                                        <div class="">
                                            <div class="signatory-cont">
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
                                                <div><Strong>Name: </Strong><span></span></div>
                                                <div><Strong>Designation: </Strong><span></span></div>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                            </table>


                            <h4>Signed for and on behalf of the within-named <br>
                                <span style="text-transform: uppercase;">{{ $details->name }}</span>:</h4>

                            <table>
                                <tr>
                                    <td style="width: 250px; vertical-align: bottom;">
                                        <div class="">
                                            <div class="signatory-cont">
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
                                                <div><Strong>Name: </Strong><span></span></div>
                                                <div><Strong>Designation: </Strong><span></span></div>
                                            </div>
                                        </div>

                                    </td>
                                    <td style="width: 250px; vertical-align: top;">
                                        <div class="">
                                            <div class="signatory-cont">
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
                                                <div><Strong>Name: </Strong><span></span></div>
                                                <div><Strong>Designation: </Strong><span></span></div>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                            </table>

                        </div>




                    </td>
                </tr>


            </table>


        </div>

    </div>

</body>

</html>
