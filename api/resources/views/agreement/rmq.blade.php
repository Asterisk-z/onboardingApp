<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>RMQ</title>
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
                    <td>1. Definitions and Interpretation
                        .....................................................................................................................................
                        3</td>
                </tr>
                <tr>
                    <td>2. Market
                        Standards.........................................................................................................................................................
                        8</td>
                </tr>
                <tr>
                    <td>3. Non-Agency Relationship
                        ...........................................................................................................................................
                        9</td>
                </tr>
                <tr>
                    <td>4. Disclosure Requirements
                        .............................................................................................................................................
                        9</td>
                </tr>
                <tr>
                    <td>5. Anti-Money Laundering
                        .............................................................................................................................................
                        10</td>
                </tr>
                <tr>
                    <td>6. Examination of Documents
                        ........................................................................................................................................
                        10</td>
                </tr>
                <tr>
                    <td>7. Fees
                        .............................................................................................................................................................................
                        11</td>
                </tr>
                <tr>
                    <td>8. Rules and Guidelines
                        ..................................................................................................................................................
                        11</td>
                </tr>
                <tr>
                    <td>9. Code of Conduct
                        .........................................................................................................................................................
                        12</td>
                </tr>
                <tr>
                    <td>10. Member’s Obligations
                        ..............................................................................................................................................
                        14</td>
                </tr>

                <tr>
                    <td>11. Discipline of the Member
                        .........................................................................................................................................
                        15</td>
                </tr>
                <tr>
                    <td>12. Termination of Membership
                        .....................................................................................................................................
                        15</td>
                </tr>
                <tr>
                    <td>13. Reporting Requirements
                        ...........................................................................................................................................
                        16</td>
                </tr>
                <tr>
                    <td>14. Willingness to Promote FMDQ Exchange
                        ................................................................................................................
                        17</td>
                </tr>
                <tr>
                    <td>15. Confidentiality and Data Protection
                        ..........................................................................................................................
                        17</td>
                </tr>
                <tr>
                    <td>16. Limitation of Liability
                        ...............................................................................................................................................
                        18</td>
                </tr>
                <tr>
                    <td>17. Indemnity
                        ...................................................................................................................................................................
                        18</td>
                </tr>
                <tr>
                    <td>18. Notices
                        .......................................................................................................................................................................
                        19</td>
                </tr>
                <tr>
                    <td>19. Binding Agreement
                        ....................................................................................................................................................
                        19</td>
                </tr>
                <tr>
                    <td>20. Non-Waiver
                        ................................................................................................................................................................
                        20</td>
                </tr>
                <tr>
                    <td>21. Severability
                        ................................................................................................................................................................
                        20</td>
                </tr>
                <tr>
                    <td>22. Governing Law
                        ..........................................................................................................................................................
                        20</td>
                </tr>
                <tr>
                    <td>23. Dispute Resolution
                        .....................................................................................................................................................
                        20</td>
                </tr>
                <tr>
                    <td>24. Amendment
                        .................................................................................................................................................................
                        20</td>
                </tr>
                <tr>
                    <td>25. Execution
                        ....................................................................................................................................................................
                        20</td>
                </tr>

            </table>
            <div class="page-break"></div>
        </div>
        <div class="page"  style="width: 680px;">
            <h4>THIS MEMBERSHIP AGREEMENT is dated {{ formatDate($details->updated_at) }}</h4>

            <table class="p2Table">
                <tr>
                    <td>
                        <h4>BETWEEN</h4>
                        <p  style="text-align:justify;">
                            <strong>FMDQ SECURITIES EXCHANGE LIMITED (RC. NO. 1617162)</strong>, a company incorporated under
                            the laws of the Federal Republic of Nigeria with its principal place of business at 35 Idowu Taylor
                            Street, Victoria Island, Lagos, (hereinafter called <strong>“FMDQ Exchange”</strong> which
                            expression shall where
                            the context so admits include its successors and assigns) of the first part.

                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>AND</h4>
                        <p  style="text-align:justify;">
                            <strong><span style="text-transform: uppercase;"> {{ $details->name }}</span> (RC NO. {{
                                $details->rc_number }}),</strong> a company incorporated under the laws of the Federal Republic
                            of Nigeria with its registered office at
                            {{ $details->address }} (the <strong>“Member”</strong> which expression shall where the context so
                            admits
                            include its successors and assigns) of the second part.
                        </p>
                        <p  style="text-align:justify;">
                            In this Agreement, FMDQ Exchange and the Member shall individually be referred to as a “Party” and
                            collectively be referred to as the “Parties”.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="padding-20 background">
                        <h4>WHEREAS:</h4>
                        
                        <div class="padding-20 agreedTerm">
                            <div class="nonAgency">
                                
                                <ol>
                                    <li>
                                        <table>
                                            <tr>
                                                <td style="width: 10px; vertical-align: top;">(A)</td>
                                                <td style="vertical-align: top; text-align: justify;">
                                                   FMDQ Exchange is licensed by the SEC as a securities exchange and self-regulatory organisation with a Platform (as defined below) to enable its Members deal in Securities (as defined below) and carry out other activities.
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                    <li>
                                        <table>
                                            <tr>
                                                <td style="width: 10px; vertical-align: top;">(B)</td>
                                                <td style="vertical-align: top; text-align: justify;">
                                                   <span style="text-transform: uppercase;">{{ $details->name }}</span> the Member is a financial institution licensed by the SEC and has indicated interest in becoming a Member (as defined below) of FMDQ Exchange with a view to acting as a sponsor to Issuers’ listing of Securities on the Platform. 
                                                </td>
                                            </tr>
                                        </table>
                                    </li>
                                    <li>
                                        <table>
                                            <tr>
                                                <td style="width: 10px; vertical-align: top;">(C)</td>
                                                <td style="vertical-align: top; text-align: justify;">
                                                    The Member has agreed to be duly licensed by FMDQ Exchange as a Registration Member (Quotations). 
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
                            <!-- <div class="page-break"></div> -->
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
                                                                    means the Investments and Securities Act, 2007 as may be amended or supplemented from time to time; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Affiliate”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means an individual or body corporate that directly or indirectly controls, is controlled by, or is under common control with, the individual or body corporate specified. For the purpose of this definition, the terms "controlled by" and "controls" mean the possession, directly or indirectly, of the power to direct the management or policies of an individual or body corporate, whether through the ownership of shares, by contract, or otherwise; 
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>Agreement”</strong></td>
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
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Inactive Member ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means a Member whose membership benefits has been withdrawn as a result of outstanding Membership Dues owed to the Exchange.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Information Memorandum ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    includes a circular, explanatory memorandum, or other equivalent document circulated, relating to Securities for which an Issuer applies for listing and quotation on the Platform;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Intellectual Property Rights ”</strong></td>
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
                                                    <div class="page-break"></div>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Issuer ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means a company, government, government agency or department, or statutory body that intends to, or has raised finance by issuing Securities to be listed and traded on the Platform;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Market ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the market for Securities tradable or traded on the Platform;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Member ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means Registration Members (Quotations), which is a financial institution (CBN-licenced deposit money bank or discount house, or non-bank financial institution sponsoring the listing of Issuers’ Securities on the Platform;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Offer Documents ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    mean the Information Memorandum or prospectus or any other documents for the public offer or private placement of Securities. This may include any other document containing relevant information to help an investor make an investment decision such as pricing supplement, programme memorandum or equivalent documents;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Platform ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the FMDQ Exchange-organised marketplace for listing, registration, quotation, order execution and trade reporting;
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
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Securities ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    include units of debentures, bonds (Federal Government of Nigeria (FGN), Agency, Sub-national, Supranational and Corporate), fixed income mutual funds, exchange traded funds, asset-backed securities, mortgage-backed securities and non-participating preference shares, and such other financial instruments as may be described by FMDQ Exchange and made available for listing on the Platform;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“ Securities Exchange ”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    has the meaning assigned to it in the ISA;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 200px !important; vertical-align: top;"><strong>“SEC Rules”</strong></td>
                                                                <td style="width: 350px !important; vertical-align: top; text-align: justify;">
                                                                    means the rules and regulations of the Commission issued pursuant to the ISA as may be amended and supplemented from time to time; and
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
                                                                    Words importing the singular number only shall include the plural and vice-versa and words importing the feminine gender only shall include the masculine gender and vice versa and words importing persons shall include corporations, associations, partnerships and governments (whether state or local), and the words “written” or “in writing” shall include printing, engraving, lithography or other means of visible reproduction.
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
                                                                    A reference to any document being “in the agreed form” means in a form which has been agreed by the Parties on or before the date of this Agreement and for identification purposes signed by them or on their behalf by their authorised signatories.
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

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">4.1.7</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    disclose any information regarding the Issuer that may affect their listing on the Platform.
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
                                                The Member covenants and represents that at all times during the subsistence of this Agreement, it shall comply with all applicable laws, policies and regulations on money laundering, including the SEC (Capital Market Operators Anti-Money Laundering, Combating the Financing of Terrorism and Proliferation Financing), Regulations, 2022 and shall establish/maintain a robust and comprehensive anti-money laundering/counter-terrorism financing framework. It shall adopt policies stating its commitment to comply with Anti-Money Laundering, Countering the Financing of Terrorism and Countering the Proliferation Financing (AML/CFT/CPF) obligations under the law and regulatory directives to actively prevent any transaction that facilitates criminal activities.
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
                                
                            <div class="page-break"></div>
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
                            <br>

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
                                                                <td style="width: 10px; vertical-align: top;">7.2.3</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    Notice of the revised Membership Dues shall be communicated to the Member within seven (7) Business Days of such revision and in any case before the expiration of the subsisting Membership Dues.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">7.2.4</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    In the event the membership of an Inactive Member is terminated, such a Member may only file a new application one (1) year after the termination of such membership. Provided, however, that if the Member wishes to file a new application earlier than one (1) year after the termination of the membership, the Member is required to pay all outstanding Membership Dues prior to and after becoming an Inactive Member.
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
                                                                    act with due skill, care, and diligence;
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
                                                                    when required to disclose any fact to FMDQ Exchange or investors, to act in an honest, open, truthful, cooperative manner and not mislead or conceal any material matter; and
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.1.5</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    provide full and prompt responses to all requests for information by FMDQ Exchange in respect of any Security listed on the Platform and provide access to all relevant books, records and other forms of documentation in accordance with the provisions of any applicable law and/or regulation.
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
                                                                    any action that has the effect, or may be expected to have the effect of artificially and/or abnormally affecting the price or value of a Security;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.2</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    any illegal action or conduct that creates or is likely to create any false or misleading impression as to the market price or value of any Security listed on the Platform;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.3</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    any action or conduct that may mar the integrity and transparency of the process of listing a Security on the Platform, or any other activities which will adversely impact the Platform and/or the Market;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.4</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    activities prohibited by this Agreement or the FMDQ Exchange Rules or act in concert with, or provide any assistance to any individual or body corporate (whether or not a Member) with a view to carrying out acts prohibited by this Agreement or the FMDQ Exchange Rules, or otherwise causing or contributing to a breach of any Applicable Law by such other individual or body corporate;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.5</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    its Authorised Representatives from effecting or causing to effect a fraud or deception in relation to any Security;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.6</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    its Authorised Representativesfrom participating in any Insider Trading in relation to a Security, or knowingly assist any other individual or body corporate to participate in any such Insider Trading;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.7</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    its Authorised Representativesfrom engaging in personal dealings, whether directly or indirectly, in Securities which Issuer the Member is sponsor of, or of any other Securities which the Member may have confidential information by virtue of being a capital markets participant; and
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.2.8</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    fraudulent activities, whether directly or indirectly, through an Affiliate or otherwise make any untrue or misleading statement, or engage in any act, practice, or course of business which operates or would operate as a fraud or deceit upon any person, in connection with the purchase or sale of any Security.
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
                                            <td style="width: 10px; vertical-align: top;">9.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Authorised Representatives of the Member
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.1 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    The Member shall advise FMDQ Exchange of its Authorised Representativesat the point of onboarding to becoming a Member.
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
                                                                    Persons designated to act as Authorised Representativesshall be required to meet specified competency requirements as may be laid down by FMDQ Exchange from time to time.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.4 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    FMDQ Exchange may upon notice to the Member decline to recognise any Authorised Representativesif upon investigation the Authorised Representativesis determined to have acted in an unethical manner or is found no longer fit and proper to perform activities on the FMDQ Exchange Platform.
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
                                                                    The Member shall ensure that its Authorised Representativesparticipate in and complete all trainings, inductions and all other competency requirements as FMDQ Exchange may prescribe from time to time.
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
                                                                    The Member shall also be responsible for ensuring that training programmes are designed to enhance the knowledge and competence of its Authorised Representativesin the Member’s role as a Member.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.9 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    The Member shall ensure that its Authorised Representatives complete all relevant annual corporate governance, risk management, compliance, anti-money laundering, counter-terrorism financing, know-your-customer (“KYC”), reporting and such other trainings, tests and certifications and standards as may be required by FMDQ Exchange or any Applicable Law not less than once a year.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">9.3.10</td>
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
                            </ol>


                            <h4>10. Member’s Obligations</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.1 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                except as otherwise provided in this Agreement or in the FMDQ Exchange Rules, advise the Issuer on the process for listing and quotation of Securities on the Platform;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.2 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                ensure that that the Issuer is in compliance with the FMDQ Exchange Rules and all Applicable Laws for the entire duration of the issue;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.3 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                be responsible for the compilation and submission of documents required by FMDQ Exchange to support the Issuer’s application to list Securities;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.4 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                abide by the FMDQ Exchange Rules and any other agreement with FMDQ Exchange in force and as may be amended from time to time and promptly notified to the Member by FMDQ Exchange;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.5 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                ensure that the Issuer meets the minimum application requirements as prescribed by the FMDQ Exchange Rules;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.6 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                ensure that the amount raised through the issuance of a Security is in line with the Offer Documents and within the limit approved by the Issuer’s board of directors or such other equivalent body;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.7 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                ensure that the amount raised through the issuance of a Security is utilised by the Issuer for the purpose(s) stated in the Offer Documents;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.8 </td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                pay the fees, dues and other applicable charges as set out in the FMDQ Exchange Fees & Dues Framework and as may be reviewed by FMDQ Exchange from time to time, upon conditions established by FMDQ Exchange and promptly communicated to the Member;
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
                                                subject to clause 6.1, authorise FMDQ Exchange or its duly appointed agents to carry out examinations and investigations, during regular business hours, in any place of business of the Member or its Affiliate, and submit as soon as possible any information or document relating to the Member’s responsibility under this Agreement which FMDQ Exchange or its agents consider appropriate for purposes of such examinations and investigations;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.10</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                comply with all the requirements for operating as a Member as may be advised by FMDQ Exchange from time to time;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.11</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                ensure that any description of its membership or the services that it is able to provide, in the form and context in which it appears or is used, does not misrepresent the scope of the capacity which it enjoys as a Member;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.12</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                document, implement and maintain adequate internal procedures and controls in relation to its activities as a Member;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.13</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                meet the corporate governance, risk management, compliance, anti-money laundering, counter-terrorism financing, know-your-customer (KYC), reporting and such other trainings, tests, certifications and standards as may be required by FMDQ Exchange or any Applicable Law not less than once a year;
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.14</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                keep and maintain proper records and books of account in respect of all its activities as a Member of the Platform and as the Sponsor of a Security for a period to be advised by FMDQ Exchange and, in accordance with FMDQ Exchange Rules and any other Applicable Law; and
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.15</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                promptly provide complete and accurate data and statistics relating to its activities as a Member of the Platform and as the sponsor of a Security as FMDQ Exchange may request from time to time.
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>

                            <h4>11. Discipline of the Member</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">11.1</td>
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
                                            <td style="width: 10px; vertical-align: top;">11.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The disciplinary powers referred to above may be exercised separately or concurrently. The exercise of such powers shall not prejudice any right that may be vested in FMDQ Exchange to seek legal redress against the Member in pursuance of enforcement of the disciplinary decision.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">11.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Where the Member’s licence is revoked, it shall forthwith lose all rights to act as a Member.
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>
                            <div class="page-break"></div>

                            <h4>12. Termination of Membership</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;"> 12.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member shall cease to be a Member if:

                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">12.1.1</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    it gives FMDQ Exchange sixty (60) days’ notice in writing of its intention to terminate its membership. Such membership shall terminate at the expiration of the sixty (60) days’ notice. Notwithstanding the notice period in this sub-clause 12.1.1, FMDQ Exchange may terminate the membership (upon receipt of the notice in writing from the Member), within such shorter period as FMDQ Exchange deems fit, where the Member has no outstanding obligation(s);
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">12.1.2</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    it is wound up voluntarily;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">12.1.3</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    it has become insolvent;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">12.1.4</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    it is compulsorily wound up by order of the Court;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">12.1.5</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    the Commission has revoked its registration/licence;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">12.1.6</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    it is unable to meet or has defaulted in its obligations under this Agreement;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">12.1.7</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    upon investigation by FMDQ Exchange, it is proven that it has acted in an unprofessional and unethical manner in the Market; or
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">12.1.8</td>
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
                                            <td style="width: 10px; vertical-align: top;">12.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Where the membership of the Member is terminated upon the occurrence of any of the events in clause 12.1, the Member shall immediately notify Issuers in relation to which it acts as a sponsor of the occurrence of the event. Upon receipt of the notice the Issuers shall be entitled to appoint another Member acceptable to FMDQ Exchange to act in place of the Member.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">12.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member hereby acknowledges that termination of its membership shall not prevent FMDQ Exchange from collecting any accrued fees, dues, fines or charges due or arising from this Agreement, the FMDQ Exchange Rules or any other agreement between FMDQ Exchange and the Member.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">12.4</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member hereby acknowledges that FMDQ Exchange reserves the right to apply to the Courts to recover any fees, dues, fines or charges due or arising from this Agreement upon termination of its membership and/or take all necessary steps to protect any investor until such a time that all reported claims have been settled.
                                            </td>
                                        </tr>
                                    </table>
                                </li>


                            </ol>
                            <div class="page-break"></div>

                            <h4>13. Reporting Requirements</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">13.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member, in respect of all sponsored listed Securities shall:
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.1 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    comply with the reporting requirements as determined by FMDQ Exchange and advised by the SEC and such other relevant regulator, from time to time;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.2 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    notify FMDQ Exchange immediate=ly in writing of any change to the information submitted to FMDQ Exchange during the application for listing, including in particular (but not limited to) those in respect of the Member or Issuers authorisation, licence or capacity to issue the Security;
                                                                </td>
                                                            </tr>
                                                        </table>

                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.3 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    notify FMDQ Exchange immediately in writing of the occurrence of any event which affects the contents of the Offer Documents, making such documents contain untrue statements of a material fact or omit to state any material fact necessary to make the statements therein accurate;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.4 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    where any event contemplated in clause 13.1.3 occurs, use all reasonable endeavours to procure a revision or supplement which will correct any untrue statement or include any omitted fact in the Offer Documents. Where the Member is unable to procure such revision or supplement, the Member shall inform FMDQ Exchange of this fact;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.5 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    notify FMDQ Exchange in writing of any facts or circumstances which may affect the legal form or organisation of the Member or the Issuer, including (but not limited to) any consolidation, reorganisation, merger, change of name, change of control or similar event to which the Member or Issuer is or will become a party and provide such additional information as FMDQ Exchange may reasonably require;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.6 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    immediately notify FMDQ Exchange as soon as it is served with or becomes aware of any proceeding for bankruptcy, insolvency, winding up, administration or similar event (including amicable settlement) in any relevant jurisdiction the Member or the Issuer is subject to, and, to which the Member or Issuer is a Party;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.7 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    immediately notify FMDQ Exchange as soon as it is served with or becomes aware of any litigation or claims against an Issuer (on whose behalf it acts as sponsor) which litigation or claim is likely to affect the value of the Security;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.8 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    notify FMDQ Exchange of any reduction in the rating of any Security (the listing of which is sponsored by the Member) on the Platform;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.9 </td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    notify FMDQ Exchange of updated rating of any Security (the listing of which is sponsored by the Member) as and when the rating has become due for an update (i.e. the anniversary of the rating); and
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">13.1.10</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    where a Security sought to be listed is being traded on another Securities Exchange, to notify FMDQ Exchange of the fact before the Security is admitted to list on the Platform.
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
                                                The Member shall also meet any other reporting obligations and standards as may be required by FMDQ Exchange from time to time.
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>



                            <div class="page-break"></div>


                            <h4>14. Willingness to Promote FMDQ Exchange</h4>
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
                            <h4>15. Confidentiality and Data Protection</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">15.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Parties shall treat as strictly confidential all Confidential Information and shall ensure that their respective authorised representatives use the Confidential Information only for the performance of their obligations and the exercise of their rights under this Agreement;.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">15.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Each Party shall protect and adequately secure every data belonging to the other Party and shall prevent against the theft or disclosure of such data by its Affiliates, directors, employees, representatives, subcontractors, agents, or any other individual or body corporate having access to the data through it.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">15.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                In the event that a Party learns of any theft, unauthorised use, disclosure, or threatened unauthorised use or disclosure of any Confidential Information, the Party shall notify the other Party of the particulars of such theft, unauthorised use or disclosure;.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">15.4</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Parties undertake and agree to comply with the provisions of the Nigeria Data Protection Regulation, 2019 issued by the National Information Technology Development Agency and any amendments thereto in respect of any Personal Data received pursuant to or in connection with this Agreement.
                                            </td>
                                        </tr>
                                    </table>
                                </li>


                            </ol>



                            <h4>16. Limitation of Liability</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">16.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Parties hereby acknowledge that each Party shall have no liability or obligation to the other for:
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">16.1.1</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    occurrences that could not have been reasonably foreseen at the date of execution of this Agreement; and includes a Force Majeure Event;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">16.1.2</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    any loss or damage which may be suffered or which may arise directly or indirectly as a result of activities in the Market not caused by FMDQ Exchange, its staff and agents;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">16.1.3</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    any act, error, failure or omission on the part of FMDQ Exchange, acting reasonably, including any loss or damage in respect of the suspension, cancellation, interruption or closure of the Market in compliance with relevant directives or orders from any regulatory body in Nigeria;
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">16.1.4</td>
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
                                                                <td style="width: 10px; vertical-align: top;">16.1.5</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    FMDQ Exchange’s decision to suspend or terminate the licence of the Member provided such suspension or termination is in compliance with the provisions of this Agreement, the FMDQ Exchange Rules, SEC Rules, the ISA, CBN circulars and DMO guidelines; and
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">16.1.6</td>
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




                            <h4>17. Indemnity</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">17.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member hereby undertakes to indemnify FMDQ Exchange against any claim or loss arising from its violation of the terms of this Agreement, or any wrongful, negligent or illegal activities as the sponsor of any Issuer in contravention of any provision of this Agreement or the FMDQ Exchange Rules.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">17.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                FMDQ Exchange hereby undertakes to indemnify the Member against any claim or loss arising from its violation of the terms of this Agreement.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">17.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member shall at all times during the subsistence of this Agreement maintain fidelity bond coverage as prescribed by the SEC.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">17.4</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The fidelity bond shall include a cancellation rider providing that the insurer will promptly notify FMDQ Exchange in the event that the bond is cancelled, terminated or substantially modified.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">17.5</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member hereby agrees to notify FMDQ Exchange in writing within three (3) Business Days of the expiry of its fidelity bond, its cancellation, termination, or substantial modification.
                                            </td>
                                        </tr>
                                    </table>
                                </li>


                            </ol>

                            <h4>18. Notices</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">18.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Any notice, request or other communication to be given or made under this Agreement shall be in writing. Any such communication shall be delivered by hand, airmail, established courier service, e-mail or other agreed medium to the Party to which it is required or permitted to be given or made at such Party’s address specified below or at such other address as such Party has from time to time designated by written notice to the other Party hereto, and shall be effective upon the earlier of (a) actual receipt and (b) deemed receipt under clause 18.2 below.<br />
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
                                            <td style="width: 10px; vertical-align: top;">18.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Any notice given as aforesaid shall be deemed to have been served when received, and shall be deemed to have been received (a) in the case of delivery by hand or courier, when delivered as evidenced by a receipt from the addressee; or (b) in the case of e-mail or other agreed medium, upon receipt by the sending party of electronic confirmation of receipt by the intended recipient.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">18.3</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                All documents to be provided or communications to be given or made under this Agreement shall be in English and, where the original version of any such document or communication is not in English, shall be accompanied by an English translation certified to be a true and correct translation of the original.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">18.4</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                In addition to clause 8.1, FMDQ Exchange may convey notices via electronic broadcasts and/or via the Market Bulletin segment on the FMDQ Exchange website.
                                            </td>
                                        </tr>
                                    </table>
                                </li>


                            </ol>

                            <h4>19. Binding Agreement</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Notwithstanding any contrary agreement, both Parties agrees that this Agreement constitutes a legal, valid and binding agreement which shall be enforceable against either Party in accordance with its terms.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>

                            <h4>20. Non-Waiver</h4>
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

                            <h4>21. Severability</h4>
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



                            <h4>22. Governing Law</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Notwithstanding any other agreement to the contrary, this Agreement and all amendments thereto shall be governed by, and construed in accordance with Nigerian law.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>





                            <h4>23. Dispute Resolution</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">23.1</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                In the event of any dispute arising out of or under this Agreement, the Parties shall within five (5) Business Days from the date the dispute arose, engage in an amicable settlement of the dispute by mutual negotiation.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">23.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
                                                Where the dispute is not resolved by mutual negotiation, the Parties shall in compliance with the provisions of the ISA, refer the matter to the Investment and Securities Tribunal for resolution.
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>


                            <div class="page-break"></div>

                            <h4>24. Amendment</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="vertical-align: top; text-align: justify;">
                                                This terms of this Agreement may be amended or varied by FMDQ Exchange (acting in good faith) from time to time by giving one (1) month calendar notice to the Member informing it of such amendment or variation.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>



                            <h4>25. Execution of Agreement</h4>
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
