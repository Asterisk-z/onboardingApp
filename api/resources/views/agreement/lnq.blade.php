<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Emulating real sheets of paper in web documents (using HTML and CSS)">
    <title>Sheets of Paper</title>
    <style>
        html,
        body {
            /* Reset the document's margin values */
            margin: 0;
            /* Reset the document's padding values */
            padding: 0;
            /* Use the platform's native font as the default */
            font-family: "Roboto", -apple-system, "San Francisco", "Segoe UI", "Helvetica Neue", sans-serif;
            /* Define a reasonable base font size */
            font-size: 12pt;

            /* Styles for better appearance on screens only -- are reset to defaults in print styles later */

            /* Use a non-white background color to make the content areas stick out from the full page box */
            background-color: #eee;
        }

        /* Styles that are shared by all elements */
        * {
            /* Include the content box as well as padding and border for precise definitions */
            box-sizing: border-box;
            -moz-box-sizing: border-box;
        }

        .page {
            /* Styles for better appearance on screens only -- are reset to defaults in print styles later */

            /* Divide single pages with some space and center all pages horizontally */
            margin: 1cm auto;
            /* Define a white paper background that sticks out from the darker overall background */
            background: #fff;
            /* Show a drop shadow beneath each page */
            box-shadow: 0 4px 5px rgba(75, 75, 75, 0.2);
            /* Override outline from user agent stylesheets */
            outline: 0;
        }

        /* Defines a class for manual page breaks via inserted .page-break element */
        div.page-break {
            page-break-after: always;
        }

        /* Simulates the behavior of manual page breaks from `print` mode in `screen` mode */
        @media screen {

            /* Renders the border and shadow at the bottom of the upper virtual page */
            div.page-break::before {
                content: "";
                display: block;
                /* Give a sufficient height to this element so that its drop shadow is properly rendered */
                height: 0.8cm;
                /* Offset the negative extra margin at the left of the non-pseudo element */
                margin-left: 0.5cm;
                /* Offset the negative extra margin at the right of the non-pseudo element */
                margin-right: 0.5cm;
                /* Make the bottom area appear as a part of the page margins of the upper virtual page */
                background-color: #fff;
                /* Show a drop shadow beneath the upper virtual page */
                box-shadow: 0 6px 5px rgba(75, 75, 75, 0.2);
            }

            /* Renders the empty space as a divider between the two virtual pages that are actually two parts of the same page */
            div.page-break {
                display: block;
                /* Assign the intended height plus the height of the pseudo element */
                height: 1.8cm;
                /* Apply a negative margin at the left to offset the page margins of the page plus some negative extra margin to paint over the border and shadow of the page */
                margin-left: -2.5cm;
                /* Apply a negative margin at the right to offset the page margins of the page plus some negative extra margin to paint over the border and shadow of the page */
                margin-right: -2.5cm;
                /* Create the bottom page margin on the upper virtual page (minus the height of the pseudo element) */
                margin-top: 1.2cm;
                /* Create the top page margin on the lower virtual page */
                margin-bottom: 2cm;
                /* Let this page appear as empty space between the virtual pages */
                background: #eee;
            }
        }

        /* For top-level headings only */
        h1 {
            /* Force page breaks after */
            page-break-before: always;
        }

        /* For all headings */
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            /* Avoid page breaks immediately */
            page-break-after: avoid;
        }

        /* For all paragraph tags */
        p {
            /* Reset the margin so that the text starts and ends at the expected marks */
            margin: 0;
        }

        /* For adjacent paragraph tags */
        p+p {
            /* Restore the spacing between the paragraphs */
            margin-top: 0.5cm;
        }

        /* For links in the document */
        a {
            /* Prevent colorization or decoration */
            text-decoration: none;
            color: black;
        }

        /* For tables in the document */
        table {
            /* Avoid page breaks inside */
            page-break-inside: avoid;
        }

        /* Use CSS Paged Media to switch from continuous documents to sheet-like documents with separate pages */
        @page {
            /* You can only change the size, margins, orphans, widows and page breaks here */

            /* Require that at least this many lines of a paragraph must be left at the bottom of a page */
            orphans: 4;
            /* Require that at least this many lines of a paragraph must be left at the top of a new page */
            widows: 2;
        }

        /* When the document is actually printed */
        @media print {

            html,
            body {
                /* Reset the document's background color */
                background-color: #fff;
            }

            .page {
                /* Reset all page styles that have been for better screen appearance only */
                /* Break cascading by using the !important rule */
                /* These resets are absolute must-haves for the print styles and the specificity may be higher elsewhere */
                width: initial !important;
                min-height: initial !important;
                margin: 0 !important;
                padding: 0 !important;
                border: initial !important;
                border-radius: initial !important;
                background: initial !important;
                box-shadow: initial !important;

                /* Force page breaks after each .page element of the document */
                page-break-after: always;
            }
        }


        .page {
            /* Styles for better appearance on screens only -- are reset to defaults in print styles later */

            /* Reflect the paper width in the screen rendering (must match size from @page rule) */
            width: 21cm;
            /* Reflect the paper height in the screen rendering (must match size from @page rule) */
            min-height: 29.7cm;

            /* Reflect the actual page margin/padding on paper in the screen rendering (must match margin from @page rule) */
            padding-left: 0.5cm;
            padding-top: 0.5cm;
            padding-right: 0.5cm;
            padding-bottom: 0.5cm;
        }

        /* Use CSS Paged Media to switch from continuous documents to sheet-like documents with separate pages */
        @page {
            /* You can only change the size, margins, orphans, widows and page breaks here */

            /* Paper size and page orientation */
            size: A4 portrait;

            /* Margin per single side of the page */
            margin-left: 0.5cm;
            margin-top: 0.5cm;
            margin-right: 0.5cm;
            margin-bottom: 0.5cm;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            box-sizing: border-box;
            font-family: 'Calibri', 'Segoe UI', 'Candara', 'Arial', sans-serif;
        }

        .whole {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 30px;
        }

        .page-container {
            height: 1100px;
            /* padding: 20px; */
        }

        .page-border-one {
            /* border: 1px solid #1d326d; */
            height: 100%;
            /* padding: 2px; */
        }

        .page-border-two {
            /* border: 1px solid #1d326d; */
            height: 100%;
            /* padding: 20px; */
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 200px;
        }

        /* section{
        width: 100vw;
        display: flex;
        justify-content: center;
        } */
        .title-page {
            width: 70%;
            height: 55%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
        }

        .content {
            padding: 30px 30px;
            width: 100%;
        }

        .toc-item {
            display: flex;
            justify-content: space-between;
        }

        .user-input {
            border-bottom: 1px solid black;
            display: inline-flex;
        }

        .uOne {
            width: 160px;
        }

        .uTwo {
            width: 80px;
        }

        .dictionary {
            display: flex;
            gap: 30px;
        }

        .whole-signatory {
            display: flex;
            justify-content: space-between;
        }

        .signatory-cont {
            width: 250px;
        }

        .signatory {
            border-bottom: 1px solid #000;
            width: 250px;
            display: inline-flex;
        }

        .name-designation {
            width: 250px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .flex-space-btw {
            display: flex;
            justify-content: space-between;
        }

        .sub-dictionary {
            display: flex;
            align-items: baseline;
            gap: 10px;
            /* justify-content: space-between; */
        }

        .definition {
            width: 450px;
        }

        .term {
            width: 150px;
        }

        .ml-20 {
            margin-left: 20px;
        }

        .ml-30 {
            margin-left: 30px;
        }

        .ml-40 {
            margin-left: 40px;
        }

        .ml-60 {
            margin-left: 60px;
        }

        .dmb-no {
            display: flex;
            justify-content: flex-end;
            padding-right: 0.5cm;
        }

    </style>
</head>
<body class="document">
    <div class="page" contenteditable="false">
        <section class="page-one">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two">
                        <div class="title-page">
                            <p>MEMBERSHIP AGREEMENT</p>
                            <p>BETWEEN</p>
                            <p>FMDQ SECURITIES EXCHANGE LIMITED</p>
                            <p>AND</p>
                            <p>[INSTITUTION’S NAME]</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">1</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-two">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content table-of-content">
                            <p>Table of Contents</p>
                            <div style="width: 100%;">
                                <ol style="margin-left: 20px;">
                                    <li>
                                        <div class="toc-item">Definitions and Interpretation <span>..........................................................................................................</span>3</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Market Standards <span>.............................................................................................................................</span>9</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Non-Agency Relationship <span>................................................................................................................</span>10</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Disclosure Requirements <span>................................................................................................................</span>10</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Anti-Money Laundering <span>..................................................................................................................</span>11</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Examination of Documents <span>.............................................................................................................</span>12</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Fees <span>..................................................................................................................................................</span>12</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Rules and Guidelines <span>........................................................................................................................</span>13</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Code of Conduct <span>..............................................................................................................................</span>13</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Member's Obligations <span>......................................................................................................................</span>15</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Discipline of the Member <span>.................................................................................................................</span>17</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Termination of Membership <span>.............................................................................................................</span>17</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Reporting Requirements <span>...................................................................................................................</span>18</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Willingness to Promote FMDQ Exchange <span>..........................................................................................</span>20</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Confidentiality <span>...................................................................................................................................</span>20</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Limitation of Liability <span>........................................................................................................................</span>20</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Indemnity <span>.........................................................................................................................................</span>21</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Notices <span>.............................................................................................................................................</span>21</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Binding Agreement <span>.........................................................................................................................</span>22</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Non-Waiver <span>.....................................................................................................................................</span>22</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Severability <span>.....................................................................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Governing Law <span>................................................................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Dispute Resolution <span>..........................................................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Amendment <span>....................................................................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Execution <span>........................................................................................................................................</span>23</div>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">2</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-three">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <p><strong>THIS DEALING MEMBERSHIP AGREEMENT</strong> is made the <span class="user-input uTwo"></span> day of <span class="user-input uTwo"></span>20<span class="user-input uTwo"> </span></p><br>
                            <p><strong>BETWEEN</strong></p><br>
                            <p><strong>FMDQ SECURITIES EXCHANGE LIMITED (RC. NO. 1617162)</strong>, a company incorporated under the laws of the Federal Republic of Nigeria with its principal place of business at Exchange Place, 35, Idowu Taylor Street, Victoria Island, Lagos, (hereinafter called <strong>“FMDQ Exchange”</strong> which expressionshall where the context so admits shall include its successors and assigns) of the first part.</p><br>
                            <p>AND</p><br>
                            <p>[Insert Institution’s name] (RC NO. XXXXX), a company incorporated under the laws of the Federal Republic of Nigeria with its registered office at [Insert Institution’s address] (the “Member” which expression shall where the context so admits shall include its successors and assigns) of the second part.</p><br>
                            <p>In this Agreement, FMDQ Exchange and the Member shall individually be referred to as a “Party” and collectively be referred to as the “Parties”.</p><br>
                            <p><strong>WHEREAS</strong></p><br>
                            <ol type="A" style="margin-left: 20px;">
                                <li>FMDQ Exchange is licensed by the Securities and Exchange Commission as a securities exchange and self-regulatory organisation with a Platform (as defined below) to enable its Members deal in Securities (as defined below) and carry out other activities.</li><br>
                                <li>[Insert Institution’s name], the Member, is a financial institution licensed by the SEC and has indicated interest in becoming a Member (as defined below) of FMDQ Exchange with a view to acting as a sponsor to Issuers’ listing of Securities on the Platform. </li><br>
                                <li>The Member has agreed to be duly licenced by FMDQ Exchange as a Registration Member (Listings). </li><br>
                                <li> Pursuant to the foregoing, the Parties hereby agree to be bound by the terms herein contained.</li>
                            </ol><br>
                            <p><strong>IT IS HEREBY AGREED AND DECLARED as follows: -</strong></p><br>
                            <ol style="margin-left: 20px;">
                                <li><strong>Definitions and Interpretation</strong><br><br>
                                    <div class="dictionary">
                                        <p>1.1</p>
                                        <div>
                                            Definitions
                                            <br><br>
                                            <p>In this Agreement, unless the context otherwise requires, the following expressions shall have the meanings set out hereunder: </p><br>
                                            <div class="sub-dictionary">
                                                <p class="term"><strong>“Act or ISA”</strong></p>
                                                <p class="definition">means the Investments and Securities Act, 2007 as may be amended or supplemented from time to time;</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">3</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-four">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary ml-40">
                                <p></p>
                                <div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Affiliate”</strong></p>
                                        <p class="definition">means an individual or body corporate that directly or indirectly controls, is controlled by, or is under common control with, the individual or body corporate specified. For the purpose of this definition, the terms "controlled by" and "controls" mean the possession, directly or indirectly, of the power to direct the management or policies of an individual or body corporate, whether through the ownership of shares, by contract, or otherwise; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Agreement”</strong></p>
                                        <p class="definition">means this Dealing Membership Agreement as may be amended or supplemented from time to time;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Applicable Law”</strong></p>
                                        <p class="definition">means any law for the time being in force in Nigeria(including statutory and common law), statute, constitution, judgment, treaty, regulation, rule, by-law, order, decree, code ofpractice, circular, directive, other legislative measure, guidelines, guidance note, requirement, request or guideline or injunction (whether or not having force of law and, to the extent not having force of law, is generally complied with by persons to whom it is addressed or applied) of or made by any governmental authority, which is binding and enforceable;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Authorised Representatives”</strong></p>
                                        <p class="definition">means an approved representative of a Member duly recognised by FMDQ Exchange to carry out any relevant financial market related functions on behalf of the Member; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Business Day”</strong></p>
                                        <p class="definition">means a day (other than a Saturday, Sunday or a FederalGovernment of Nigeria declared public holiday) on which Dealing Members are open for general business in Nigeria;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“CAMA”</strong></p>
                                        <p class="definition">means the Companies and Allied Matters Act, 2020, as may be amended or supplemented from time to time;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“CBN”</strong></p>
                                        <p class="definition">means the Central Bank of Nigeria;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Commission or SEC”</strong></p>
                                        <p class="definition">means the Securities and Exchange Commission;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Company”</strong></p>
                                        <p class="definition">has the meaning assigned to it in CAMA;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Confidential Information”</strong></p>
                                        <p class="definition">means any information, communications or data, about the Parties, Dealing Member(s) or their respective affairs or business in any form, whether oral, written, graphic, or electromagnetic, including all plans, proposals, forecasts, technical processes, methodologies, know-how, information about technological or organisational systems, customers, personnel, business activities, marketing, financial research or development activities,</p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">4</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-five">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary ml-40">
                                <p></p>
                                <div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong></strong></p>
                                        <p class="definition"> databases, Intellectual Property Rights, the terms and conditions of this Agreement and other information in relation to it, whether or not it is specifically marked confidential but excluding any information, which: </p>
                                    </div><br>
                                    <div style="display: flex;justify-content: flex-end;">
                                        <ol type="i" style="width: 400px;">
                                            <li>was already known to the Recipient at the time of its disclosure to the Recipient and is not subject to confidentiality restrictions;</li><br>
                                            <li>is in the public domain at the date of its disclosure to the Recipient or thereafter enters the public domain through no fault of the Recipient (but only after it becomes part of the public domain); or</li><br>
                                            <li>is independently developed by the Recipient without use or reference to the Disclosing Party’s confidential information, as shown by documents and other competent evidence in the receiving Party’s possession; or</li><br>
                                            <li>is required by law or regulation to be disclosed by the Recipient, provided that the Recipient, where it isreasonable in the circumstances,shall promptly give theDisclosing Party written notice of such requirement prior to any disclosure so that the Disclosing Party may seek a protective order or other appropriate relief</li><br>
                                        </ol>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Court”</strong></p>
                                        <p class="definition">means any court of competent jurisdiction;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Disclosing Party”</strong></p>
                                        <p class="definition">means the Party disclosing an item of Confidential Information;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“DMO” </strong></p>
                                        <p class="definition">means Debt Management Office of the Federal Republic of Nigeria;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“FMDQ Exchange Fees <br> & Dues Framework” </strong></p>
                                        <p class="definition">means the framework as advised to the Members containing all relevant and applicable fees and dues (including Membership Dues) as may be updated from time to time;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“FMDQ GOLD Award”</strong></p>
                                        <p class="definition">means a recognition of exceptional performance on the securities exchange, exemplary compliance with the FMDQ Exchange Rules and contribution to the Nigerian financial markets;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“FMDQ Exchange Rules” </strong></p>
                                        <p class="definition">means rules, circulars, bulletins, guidelines and other regulation designed by FMDQ Exchange (and where required, approved by the SEC, CBN or DMO, as the case may be) and advised to Members to govern activities on the Platform, as may be supplemented and amended from time to time; </p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">5</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-six">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary ml-40">
                                <p></p>
                                <div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Force Majeure Event” </strong></p>
                                        <p class="definition">means the occurrence of an event which materially interferes with the ability of a Party to perform its obligations or duties hereunder which is not within the reasonable control of the Party affected or any of its Affiliates, and which could not with the exercise of diligent efforts have been avoided, including, but not limited to, war (whether or not declared), rebellion, earthquake, fire, explosions, accident, strike, lockouts or other labour disturbances, riot, civil commotion, act of God, epidemics, pandemics, national emergencies, work stoppages, state or federal lockdowns, orders and laws of governmental authorities (both federal and state), change in Law or any act of God or other cause beyond the control of the Parties </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Inactive Member” </strong></p>
                                        <p class="definition">means a Member whose membership benefits has been withdrawn as a result of outstanding Membership Dues owed to the Exchange. </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Information Memorandum” </strong></p>
                                        <p class="definition">includes a circular, explanatory memorandum, or other equivalent document circulated, relating to Securities for which an Issuer applies for listing and quotation on the Platform; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Intellectual Property Rights” </strong></p>
                                        <p class="definition">includes any patent, copyright, trademark, trade name, trade secret, brand name, logo, corporate name, internet domain name or industrial design, any registrations thereof and pending applications therefor, any other intellectual property right (including, without limitation, any know-how, trade secret, trade right, formula, conditional or proprietary report or information, customer or membership list, any marketing data, and any computer program, software, database or data right), and license or other contract relating to any of the foregoing, and any goodwill associated with any business owning, holding or using any of the foregoing;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Insider Trading”</strong></p>
                                        <p class="definition">means trading done by an individual or body corporate or group of individuals or bodies corporate who being in possession of some confidential and price sensitive information not generally available to the public, utilises such information to buy or sell Securities for the benefit of themselves or any other individual or body corporate;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>"Issuer"</strong></p>
                                        <p class="definition">means a corporate body that intends to, or has raised, finance by issuing Securities to be quoted and traded on the Platform;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Market” </strong></p>
                                        <p class="definition">means the market for Products tradable or traded on the FMDQ Exchange Platform; </p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">6</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-seven">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary ml-40">
                                <p></p>
                                <div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Member” </strong></p>
                                        <p class="definition">means a Registration Member (Listings), which is a financial institution (such as banks and investment companies regulated by the CBN) and financial services operators such as private investment companies, investment advisers and other related financial service providers such as consulting, advisory and professional service firms duly registered by/with their relevant regulators/professional bodies and authorised by FMDQ Exchange for sponsoring the listing of Issuers’ Securities on the Platform; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Offer Documents” </strong></p>
                                        <p class="definition">mean the Information Memorandum or prospectus or any other documents for the public offer or private placement of Securities. This may include any other documents containing relevant information to help an investor make an investment decision such as pricing supplement, programme memorandum or equivalent documents; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Platform”</strong></p>
                                        <p class="definition">means the FMDQ Exchange-organised marketplace for listing, registration, quotation, order execution, and trade reporting;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Personal Data”</strong></p>
                                        <p class="definition">has the meaning contained in the Nigeria Data Protection, Regulation, 2019;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Private Censure”</strong></p>
                                        <p class="definition">means a private disciplinary action that constitutes a formal expression of disapproval of a Member by FMDQ Exchange. It includes but is not limited to warning or infractions lettersissued to the Member; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Public Censure”</strong></p>
                                        <p class="definition">means a public disciplinary action that constitutes a formal expression of disapproval of a Member by FMDQ Exchange. It includes but is not limited to newspaper publications and posting on the FMDQ Exchange website; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Recipient”</strong></p>
                                        <p class="definition">means the Party receiving an item of Confidential Information;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Securities”</strong></p>
                                        <p class="definition">means commercial papers and other financial instruments as may be described by FMDQ Exchange, such as short-term debt securites (where applicable) which are available for listing on the Platform;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Securities Exchange”</strong></p>
                                        <p class="definition">has the meaning assigned to it in the ISA; and</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“SEC Rules” </strong></p>
                                        <p class="definition">means the rules and regulations of the Commission issued pursuant to the ISA, as may be amended from time to time; </p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">7</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-eight">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 20px;">
                                <p>1.2</p>
                                <div>Interpretation <br><br>
                                    <p>In this Agreement:</p><br>
                                    <p>1.2.1 Words importing the singular number only shall include the plural and vice- versa and words importing the feminine gender only shall include the masculine gender and vice versa and words importing persons shall include corporations, associations, partnerships and governments (whether state or local), and the words “written” or “in writing” shall include printing, engraving, lithography or other means of visible reproduction.</p> <br>
                                    <p>1.2.2 The words “hereof,” “herein,” “hereby,” “hereto” and similar words refer to this entire Agreement and not any particular Clause, Schedule, or other subdivision of this Agreement.</p> <br>
                                    <p>1.2.3 A reference to “Party” or “Parties” shall mean a party or parties to this Agreement.</p> <br>
                                    <p>1.2.4 A reference to a statutory provision shall be deemed to include that provision as the same may from time to time be modified, amended, or re-enacted.</p> <br>
                                    <p>1.2.5 Any reference to Clauses and Schedules, are to Clauses and Schedules of this Agreement, and references to sub-clauses and paragraphs are references to sub-clauses and paragraphs of the clause or schedule in which they appear.</p> <br>
                                    <p>1.2.6 A reference to a provision of this Agreement is to that provision as amended in accordance with the terms of this Agreement.</p> <br>
                                    <p>1.2.7 A reference to “consent” means any consent, approval, authorisation, license, or clearance of any kind whether fiscal, statutory, or regulatory. </p> <br>
                                    <p>1.2.8 A reference to any document being “in the agreed form” means in a form which has been agreed by the Parties on or before the date of this Agreement and for identification purposes signed by them or on their behalf by their Authorised Signatories. </p> <br>
                                    <p>1.2.9 References to days shall refer to calendar days unless Business Days are specified; references to weeks, months or years shall be to calendar weeks, months, or years respectively. </p> <br>
                                    <p>1.2.10 References to any liability shall include actual, contingent, present, or future liabilities.</p> <br>
                                    <p>1.2.11 Words and expressions defined in any clause shall, unless the application of any such word or expression is specifically limited to that clause, bear the meaning assigned to such word or expression throughout this Agreement.</p> <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">8</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-nine">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 40px;">
                                <p></p>
                                <div>
                                    <p></p>
                                    <p>1.2.12 The expiration or termination of this Agreement shall not affect the provisions of this Agreement which are expressly indicated to survive the expiration or termination or which of necessity must continue to have effect after such expiration or termination either expressly or impliedly.</p> <br>
                                    <p>1.2.13 Where figures are referred to in numerals and in words, and there is any conflict between the two, the words shall prevail, unless the context indicates a contrary intention.</p> <br>
                                    <p>1.2.14 Defined terms appearing in this Agreement in upper case shall be given their meaning as defined, while the same terms appearing in lower case shall be interpreted in accordance with their plain English meaning.</p> <br>
                                    <p>1.2.15 Words and phrases used in this Agreement, unless otherwise defined in this Agreement,shall have themeanings given to them in theRuleBook, SECRules, CBN circulars, DMO guidelines, the ISA, and any other legislative enactment.</p> <br>
                                    <p>1.2.16 A reference to FMDQ Exchange or the Member herein shall include reference to their respective successors and assigns.</p> <br>
                                    <p>1.2.17 The division of this Agreement into clauses and sub-clauses, the provision of a table of contents and the insertion of headings are for convenience of reference only and shall not be deemed to form part of the text or affect the construction or interpretation hereof.</p> <br>
                                    <p>1.2.18 Any money payable under this Agreement on a day that falls on a public holiday shall be paid on the next Business Day. </p> <br>
                                </div>
                            </div>
                            <ol style="margin-left: 20px;" start="2">
                                <li><strong>Market Standards</strong><br><br>
                                    <p>The Member shall:</p><br>
                                    <div class="dictionary">
                                        <p>2.1</p>
                                        <div>
                                            <p>use its best endeavours to maintain such market standards as may be determined and communicated to the Member by FMDQ Exchange from time to time in its dealings with any Issuer or investor;</p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>2.2</p>
                                        <div>
                                            <p>comply with the minimum standards on risk management and compliance prescribedand communicated to the Member from time to time by FMDQ Exchange;</p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>2.3</p>
                                        <div>
                                            <p>establish a robust risk management and compliance function which shall be responsible for identifying, measuring, monitoring and reporting any risks that the Member may be exposed to; and</p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>2.4</p>
                                        <div>
                                            <p>maintain a proper structure that ensures the efficiency of its risk management and compliance function.</p>
                                        </div>
                                    </div> <br>
                                </li><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">9</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-ten">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="3">
                                <li><strong>Non-Agency Relationship</strong><br><br>
                                    <div class="dictionary">
                                        <p>The Member or its Authorised Representative(s) shall not hold itself out to any individual or body corporate as being an agent of or otherwise representing or having the power in any way to act for or bind FMDQ Exchange unless expressly authorised in writing.</p>
                                    </div> <br>
                                </li><br>
                                <li><strong>Disclosure Requirements</strong><br><br>
                                    <div class="dictionary">
                                        <p>4.1</p>
                                        <div>
                                            <p>The Member hereby undertakes to:</p><br>
                                            <p>4.1.1 disclose in writing to FMDQ Exchange its membership of any other Securities Exchange at the time of the execution of this Agreement;</p><br>
                                            <p>4.1.2 disclose to FMDQ Exchange in writing, not later than one (1) calendar month from when it becomes a Member of any other Securities Exchange after the execution of this Agreement, specifying the name and principal place of business of the other Securities Exchange, the date it was registered as a member of the Securities Exchange, the duration of its membership, and suchadditional or other information as may be required by FMDQ Exchange;</p><br>
                                            <p>4.1.3 disclose to FMDQ Exchange not later than one (1) calendar month after the execution of this Agreement the particulars of its management personnel and director(s) who are responsible for overseeing its financial markets function; provided that where any change is made in respect of the aforementioned persons, it will not later than one (1) calendar month thereafter inform FMDQExchange of such change;</p><br>
                                            <p>4.1.4 disclose any information regarding any Security that it believes may abnormally affect the Market to FMDQ Exchange immediately, and no later than twenty-four (24) hours of being aware of the information;</p><br>
                                            <p>4.1.5 disclose any investigation, sanction, enforcement proceeding or injunction against it in respect of any matter related to this Agreement, or any other membership agreements executed with any securities exchange, self-regulatory organisation, regulatory authority or such other body that may adversely affect the performance of its obligations herein to FMDQ Exchange within twenty-four (24) hours of being aware of the investigation, sanction, enforcement proceeding or injunction;</p><br>
                                            <p>4.1.6 disclose any event which may impair its ability to comply with this Agreement or any of the FMDQ Exchange Rules to FMDQ Exchange within twenty-four (24) hours of being aware of the event;</p><br>
                                            <p>4.1.7 disclose any information regarding the Issuer that may affect their listing on the Platform.</p><br>
                                        </div>
                                    </div>
                                </li><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">10</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-eleven">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="5">
                                <div class="dictionary">
                                    <p>4.2</p>
                                    <div>
                                        For the purpose of this clause, “disclose” means to alert, make known or reveal any of the event mentioned in clause 4.1 to FMDQ Exchange. FMDQ Exchange however reserves the right to demand more information should the need arise.
                                    </div>
                                </div> <br>
                                <li>
                                    <strong>Anti-Money Laundering</strong><br><br>
                                    <div class="dictionary">
                                        <p>5.1</p>
                                        <div>
                                            The Member covenants and represents that at all times during the subsistence of this Agreement, it shall comply with all applicable laws, policies and regulations on money laundering, including the SEC (Capital Market Operators Anti-Money Laundering/Combating the Financing of Terrorism and Proliferation Financing), Regulations, 2022 and shall establish/maintain a robust and comprehensive anti-money laundering/counter-terrorism financing framework. It shall adopt policies stating its commitment to comply with Anti-Money Laundering, Countering the Financing of Terrorism and Countering the Proliferation Financing (AML/CFT/CPF) obligations under the law and regulatory directives to actively prevent any transaction that facilitates criminal activities.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>5.2</p>
                                        <div>
                                            The Member undertakes to keep all records and documentation pertaining to any anti-money laundering and counter-terrorism financing due diligence procedures relating to its activities on the Platform for such period as required by FMDQ Exchange or by Applicable Law
                                        </div>
                                    </div><br>
                                    <div class="dictionary">
                                        <p>5.3</p>
                                        <div>
                                            Subject to any Applicable Law prohibiting disclosure, if FMDQ Exchange is required by the regulatory authorities to satisfy itself or such authorities as to the facts of any transaction or activities of the Member on the Platform or FMDQ Exchange suspects any form of money laundering or terrorism financing, or at any time pursuant to FMDQExchange’s request, the Member must immediately provide copies of all due diligence materials relating to such transaction or activities to FMDQ Exchange and/or all relevant regulatory authorities. In such circumstances, the Member must also provide a translation and certification of such documents if so requested by FMDQ Exchange.
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>5.4</p>
                                        <div>
                                            If the Member delegates, assigns, subcontracts or transfers any of its rights or obligations under this Agreement to another party, the Member shall ensure that such party complies with the requirements set out in this Agreement, FMDQ Exchange’sRules and Applicable Law.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>5.5</p>
                                        <div>
                                            The Member will ensure that none of its subsidiaries or Affiliates will fund all or part of any payment under any transaction out of proceeds derived from any unlawful activity which would result in any violation of any anti-money laundering or counter-terrorism financing legislation in force in Nigeria (as may be amended) and regulations thereunder or any other Applicable Law or regulation concerning anti-money laundering or the prevention thereof.

                                        </div>
                                    </div><br>
                                    <!-- <div class="dictionary">
                                                <p>6.6</p>
                                                <div>
                                                    Disclose any investigation, sanction, enforcement proceeding or injunction against it in respect of any matter related to this Agreement or that may adversely affect the performance of obligations herein to FMDQ Exchange within twenty-four (24) hours of being aware of the investigation, sanction, enforcement proceeding or injunction.
                                                </div>
                                            </div><br>
                                            <div class="dictionary">
                                                <p>6.7</p>
                                                <div>
                                                    Disclose any event which may impair its ability to comply with this Agreement or theRule Book to FMDQ Exchange within twenty-four (24) hours of being aware of the event.
                                                </div>
                                            </div><br>
                                            <div class="dictionary">
                                                <p>6.8</p>
                                                <div>
                                                    For the purpose of clause 6 of this Agreement, “disclose” means alert, make known or reveal any of the aforementioned events in clauses 6.1 to 6.7 above to FMDQ Exchange.FMDQ Exchange however reserves the right to demand more information should the need arise.
                                                </div>
                                            </div><br>
                                        </li><br>
                                    <li><strong>Anti-Money Laundering</strong><br><br>
                                        <p>The Parties covenant and represent that at all times during the existence of this Agreement, they shall comply with all applicable laws, policies, and regulations on money laundering, including the SEC (Capital Market Operators Anti-Money Laundering/Combating the Financing of Terrorism and Proliferation Financing), Regulations, 2022 and shall establish/maintain a robust and comprehensive anti-money laundering/counter-terrorism financing framework. It shall adopt policies stating its commitment to comply with Anti-Money Laundering, Countering the Financing of Terrorism and Countering the Proliferation Financing (“AML/CFT/CPF”)obligations under the law and regulatory directives to actively prevent any transaction that facilitates criminal activities.</p>
                                    </li><br>
                                </ol> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">11</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twelve">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="6">
                                <li><strong>Examination of Documents</strong><br><br>
                                    <div class="dictionary">
                                        <p>6.1</p>
                                        <div>
                                            The Member hereby undertakes that it shall make itself available for examination or audit howsoever required, and to make available any document or record relating to the Member’s functions as a Member, whether by means of paper copy, electronic copy, disk, hard drive, flash drive or such other storage device in its possession or subject to its possession, when required by FMDQ Exchange to carry out its supervisory function, provided that FMDQ Exchange shall give fourteen (14) days’ notice of such examination or review. Notwithstanding the foregoing, the Parties agree that FMDQ Exchange shall have the right to examine/audit the documents or records of the Member, at any time and without notice, where there is a reasonable cause to do so.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>6.2</p>
                                        <div>
                                            FMDQ Exchange shall ensure the confidentiality of documents provided under clause 6.1 above and not to disclose its content except as required by any law, rule, regulation, order, and judgment of a competent court in Nigeria or for any other lawful purposeand shall notify the Member before such disclosure, where practicable, and where it is impracticable to notify the Member prior to such disclosure, provide written notice to the Member promptly after disclosure.
                                        </div>
                                    </div> <br>
                                </li><br>
                                <li><strong>Fees</strong><br><br>
                                    <div class="dictionary">
                                        <p>7.1</p>
                                        <div>
                                            <strong>Listing Fees</strong><br><br>
                                            <p>The Member hereby agrees that:</p><br>
                                            <div>
                                                <p>7.1.1 FMDQ Exchange shall charge and may revise listing fees for every Security sought to be quoted by an Issuer and such fees will be provided in the FMDQ Exchange Fees and Dues Framework.</p><br>
                                                <p>7.1.2 Pursuant to Clause 7.1.1, notice of revision of listing fees shall be communicated to the Member. </p>
                                            </div>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>7.2</p>
                                        <div>
                                            <strong>Membership Dues</strong><br><br>
                                            <p>The Member hereby agrees that:</p><br>
                                            <div>
                                                <p>7.2.1 The Member shall pay an annual membership due to FMDQ Exchange at a rate to be determined and communicated by FMDQ Exchange from time to time. </p><br>
                                                <p>7.2.2 The Membership Dues shall be payable immediately upon the execution of this Agreement and shall thereafter become payable on the 1st Business Day of January of each year. FMDQ Exchange shall have the right to revise the dues from time to time. </p><br>
                                            </div>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">12</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twelve">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="8">
                                <div class="dictionary">
                                    <p>7.3</p>
                                    <div>FMDQ Exchange shall issue an invoice to the Member for the Membership Dues. If the Member does not pay the Membership Dues within two (2) weeks of the date of the issue of the invoice, the Member shall lose all rights and privileges on the FMDQ Exchange Platform.</div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>7.4</p>
                                    <div>Suspension or termination of the Member’s licence under the provisions of this Agreement shall not prevent FMDQ Exchange from proceeding against the Member for the recovery of all fees payable through all available legal means.</div>
                                </div> <br>
                                <li><strong>Rules and Guidelines</strong><br><br>
                                    <p>The Member shall comply with the provisions of the FMDQ Exchange Rules and any amendments thereto as may be made by FMDQ Exchange, in its relationship with FMDQ Exchange, other Members, Issuers and investors.</p>
                                </li><br>
                                <li><strong>Code of Conduct</strong><br><br>
                                    <p>The Member shall comply with the code of conduct set out below and as contained in the FMDQ Exchange Rules when acting as a Member.</p><br>
                                    <div class="dictionary">
                                        <p>9.1</p>
                                        <div>
                                            <strong>General Duties of Integrity, Care and Full Disclosure</strong><br><br>
                                            <p>As the sponsor to an Issuer’s listing of a Security, the Member shall:</p><br>
                                            <div>
                                                <p>9.1.1 observe high standards of integrity and fair market conduct; </p><br>
                                                <p>9.1.2 act with due skill, care and diligence;</p><br>
                                                <p>9.1.3 refrain from any act or conduct which is likely to mar the reputation of FMDQ Exchange and the Market;</p><br>
                                                <p>9.1.4 when required to disclose any fact to FMDQ Exchange or investors, to act in an honest, open, truthful, cooperative manner and not mislead or conceal any material matter; and</p><br>
                                                <p>9.1.5 provide full and prompt responses to all requests for information by FMDQ Exchange in respect of any Security listed on the Platform and provide access to all relevant books, records and other forms of documentation in accordance with the provisions of any applicable law and/or regulation.</p><br>
                                            </div>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">13</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-thirteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="8">
                                <p></p>
                                <div class="dictionary">
                                    <p>9.2</p>
                                    <div>
                                        <strong>No Fraudulent or Misleading Conduct</strong><br><br>
                                        <p>The Member shall not engage in, or fail to take reasonable steps to prevent:</p><br>
                                        <div>
                                            <p>9.2.1 any action that has the effect, or may be expected to have the effect, of artificially and/or abnormally affecting the price or value of a Security; </p><br>
                                            <p>9.2.2 any illegal action or conduct that creates or is likely to create any false or misleading impression as to the market price or value of any Security quoted on the Platform;</p><br>
                                            <p>9.2.3 any action or conduct that may mar the integrity and transparency of the process of listing a Security on the Platform, or any other activities which will adversely impact the Platform and/or the Market;</p><br>
                                            <p>9.2.4 agreeing or acting in concert with, or providing any assistance to any individual or body corporate (whether or not a Member) with a view to doing anything prohibited by this Agreement or the FMDQ Exchange Rules, or otherwise causing or contributing to a breach of any Applicable Law by such other individual or body corporate;</p><br>
                                            <p>9.2.5 its Authorised Representatives from effecting or causing to effect a fraud or deception in relation to any Security;</p><br>
                                            <p>9.2.6 its Authorised Representatives from participating in any Insider Trading in relation to a Security, or knowingly assist any other individual or body corporate to participate in any such Insider Trading; </p><br>
                                            <p>9.2.7 establishing measures that ensure its Authorised Representatives do not engage in personal dealings, whether directly or indirectly, in Securities which Issuer the Member is sponsor of, or of any other Securities which the Member may have confidential information by virtue of being a capital markets participant; and </p><br>
                                            <p>9.2.8 establishing measures that directly or indirectly, through an Affiliate or otherwise commit any fraudulent activity, make any untrue or misleading statement, or engage in any act, practice, or course of business which operates or would operate as a fraud or deceit upon any person, in connection with the purchase or sale of any Security </p><br>
                                        </div>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>9.3</p>
                                    <div>
                                        <strong>Authorised Representatives of the Member</strong><br><br>
                                        <p></p>
                                        <div>
                                            <p>9.3.1 The Member shall advise FMDQ Exchange of its Authorised Representatives at the point of onboarding to becoming a Member. </p><br>
                                            <p>9.3.2 The Member shall be responsible for the actions of its Authorised Representatives.</p><br>
                                            <p>9.3.3 Persons designated to act as Authorised Representatives shall be required to meet specified competency requirements as may be laid down by FMDQExchange from time to time.</p><br>
                                            <p>9.3.4 FMDQ Exchange may upon notice to the Member decline to recognise any Authorised Representative if upon investigation the Authorised Representativeis determined to have acted in an unethical manner or is found no longer fit and proper to perform activities on the FMDQ Exchange Platform.</p><br>
                                        </div>
                                    </div>
                                </div> <br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">14</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-fourteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="10">
                                <div class="dictionary">
                                    <p></p>
                                    <div>
                                        <strong></strong><br>
                                        <p></p><br>
                                        <div class="ml-20">
                                            <p>9.3.5 The Member shall make adequate arrangements to ensure that all its Authorised Representatives are suitable, competent, knowledgeable, adequately trained and properly supervised.</p><br>
                                            <p>9.3.6 The Member shall ensure that its Authorised Representatives participate in and complete all trainings, inductions and all other competency requirements as FMDQ Exchange may prescribe from time to time. </p><br>
                                            <p>9.3.7 The Member shall have the responsibility and duty to ascertain by investigation the good character, business repute, qualifications and experience of its Authorised Representatives. </p><br>
                                            <p>9.3.8 The Member shall also be responsible for ensuring that training programmes are designed to enhance the knowledge and competence of its Authorised Representatives in the Member’s role as a Member.</p><br>
                                            <p>9.3.9 The Member shall ensure that its Authorised Representatives complete all relevant annual corporate governance, risk management, compliance, anti-money laundering, counter-terrorism financing, know-your-customer (KYC) reporting, and such other trainings, tests, certifications and standards as may be required by FMDQ Exchange or any Applicable Law not less than once a year. </p><br>
                                            <p>9.3.10 The Member shall notify FMDQ Exchange in writing within seven (7) Business Days of any change to the list of Authorised Representatives in its employment, and bi-annually, i.e., January and July of every year as part of its compliance reporting to FMDQ Exchange.</p><br>
                                        </div>
                                    </div>
                                </div> <br>
                                <li><strong>Member’s Obligations</strong><br><br>
                                    <p>The Member hereby agrees on a continuing basis, to:</p><br>
                                    <div class="dictionary">
                                        <p>10.1</p>
                                        <div>
                                            <p>except as otherwise provided in this Agreement or in the FMDQ Exchange Rules, advise the Issuer on the process for listing and quotation of Securities on the Platform;</p><br>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>10.2</p>
                                        <div>
                                            <p>ensure that that the Issuer is in compliance with the FMDQ Exchange Rules and all Applicable Laws for the entire duration of the issue;</p><br>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>10.3</p>
                                        <div>
                                            <p>be responsible for the compilation and submission of documents required by FMDQ Exchange to support the Issuer’s application to quote Securities;</p><br>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">15</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-fourteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="10">
                                <strong></strong>
                                <p></p><br>
                                <div class="dictionary">
                                    <p>10.4</p>
                                    <div>
                                        <p>abide by the FMDQ Exchange Rules (and such other requirements as determined by FMDQ Exchange) and any other agreement with FMDQ Exchange in force and as may be amended from time to time and promptly notified to the Member by FMDQExchange;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.5</p>
                                    <div>
                                        <p>ensure that the Issuer meets the minimum application requirements as prescribed by the FMDQ Exchange Rules;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.6</p>
                                    <div>
                                        <p>ensure that the amount raised through the issuance of a Security is in line with the Offer Documents and within the limit approved by the Issuer’s board of directors or such other equivalent body;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.7</p>
                                    <div>
                                        <p>ensure that the amount raised through the issuance of a Security is utilised by the Issuer for the purpose(s) stated in the Offer Documents;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.8</p>
                                    <div>
                                        <p>pay the fees, dues and other applicable charges as set out in the FMDQ Exchange Fees & Dues Framework and as may be reviewed by FMDQ Exchange from time to time, upon conditions established by FMDQ Exchange and promptly communicated to the Member; </p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.9</p>
                                    <div>
                                        <p>subject to Clause 6.1, authorise FMDQ Exchange or its duly appointed agents to carry out examinations and investigations, during regular business hours, in any place of business of the Member or its Affiliate, and submit as soon as possible any information or document relating to the Member’s responsibility under this Agreement which FMDQ Exchange or its agents consider appropriate for purposes of such examinations and investigations;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.10</p>
                                    <div>
                                        <p>comply with all the requirements for operating as a Member as may be advised by FMDQ Exchange from time to time;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.11</p>
                                    <div>
                                        <p>ensure that any description of its membership or the services that it is able to provide, in the form and context in which it appears or is used, does not misrepresent the scope of the capacity which it enjoys as a Member;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.12</p>
                                    <div>
                                        <p>document, implement and maintain adequate internal procedures and controls in relation to its activities as a Member;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.13</p>
                                    <div>
                                        <p>meet the corporate governance, risk management, compliance, anti-money laundering, counter-terrorism financing, know-your-customer (KYC) reporting and such other trainings, tests, certifications and standards as may be required by FMDQ Exchange or any Applicable Law not less than once a year;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.14</p>
                                    <div>
                                        <p>keep and maintain proper records and books of account in respect of all its activities as a Member of the Platform and as the sponsor of a Security for a period to be advised by FMDQ Exchange and, in accordance with FMDQ Exchange Rules and any other Applicable Law; and</p>
                                    </div>
                                </div> <br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">16</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-fourteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="11">
                                <strong></strong>
                                <p></p><br>
                                <div class="dictionary">
                                    <p>10.15</p>
                                    <div>
                                        <p>promptly provide complete and accurate data and statistics relating to its activities as a Member of the Platform and as the sponsor of a Security as FMDQ Exchange may request from time to time.</p>
                                    </div>
                                </div> <br>
                                <li><strong>Discipline of the Member</strong><br><br>
                                    <p></p><br>
                                    <div class="dictionary">
                                        <p>11.1</p>
                                        <div>
                                            <p>The Member hereby acknowledges that FMDQ Exchange has the power to take disciplinary action against it for any established violation of any of the FMDQ Exchange Rules in force, or as may be amended from time to time, or any provision of this Agreement. In particular, FMDQ Exchange has the power to impose any of the following penalties on the Member and may as appropriate, report the disciplinary action to the relevant regulatory body:</p><br>
                                            <ol type="a">
                                                <li>fines;</li><br>
                                                <li>non-consideration for FMDQ GOLD Award;</li><br>
                                                <li>suspension of membership on such terms and for such period as FMDQ Exchange may think fit;</li><br>
                                                <li>revocation of the Member’s licence; or</li><br>
                                                <li>Public and/or Private Censure.</li>
                                            </ol>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>11.2</p>
                                        <div>
                                            <p>The disciplinary powers referred to above may be exercised separately or concurrently. The exercise of such powers shall not prejudice any right that may be vested in FMDQ Exchange to seek legal redress against the Member in pursuance of enforcement of the disciplinary decision. </p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>11.3</p>
                                        <div>
                                            <p>Where the Member’s licence is revoked, it shall forthwith lose all rights to act as a Member.</p>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Termination of Membership</strong><br><br>
                                    <div class="dictionary">
                                        <p>12.1</p>
                                        <div>
                                            <p>The Member shall cease to be a member of FMDQ Exchange if:</p><br>
                                            <p>12.1.1 it gives FMDQ Exchange sixty (60) days’ notice in writing of its intention to terminate its membership. Such membership shall terminate at the expiration of the sixty (60) days’ notice; Notwithstanding the notice period in this sub-clause 12.1.1, FMDQ Exchange may terminate the membership (upon receipt of the notice in writing from the Member), within such shorter period as FMDQ Exchange deems fit, where the Member has no outstanding obligation(s).</p><br>
                                            <p>12.1.2 it is wound up voluntarily;</p><br>
                                            <p>12.1.3 it has become insolvent;</p><br>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">17</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="13">
                                <div class="dictionary">
                                    <p></p>
                                    <div class="ml-40">
                                        <p>12.1.4 it is compulsorily wound up by order of the Court;</p><br>
                                        <p>12.1.5 the Commission or relevant regulatory body has revoked its registration/licence;</p><br>
                                        <p>12.1.6 it is unable to meet or has defaulted in its obligations under this Agreement;</p><br>
                                        <p>12.1.7 upon investigation by FMDQ Exchange, it is proven that it has acted in an unprofessional and unethical manner in the Market; or </p><br>
                                        <p>12.1.8 any other reason as FMDQ Exchange may deem fit to terminate the licence of the Member. </p><br>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>12.2</p>
                                    <div>
                                        <p>Where the membership of the Member is terminated upon the occurrence of any of the events in Clause 12.1, the Member shall immediately notify Issuers in relation to which it acts as a sponsor of the occurrence of the event. Upon receipt of the notice the Issuers shall be entitled to appoint another Member acceptable to FMDQ Exchange to act in place of the Member. </p><br>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>12.3</p>
                                    <div>
                                        <p>The Member hereby acknowledges that termination of its membership shall not prevent FMDQ Exchange from collecting any accrued fees, dues, fines or charges due or arising from this Agreement, the FMDQ Exchange Rules or any other agreement between FMDQ Exchange and the Member. </p><br>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>12.4</p>
                                    <div>
                                        <p>The Member hereby acknowledges that FMDQ Exchange reserves the right to apply to the Courts to recover any fees, dues, fines or charges due or arising from this Agreement upon termination of its membership and/or take all necessary steps to protect any investor until such a time that all reported claims have been settled. </p><br>
                                    </div>
                                </div> <br>
                                <li><strong>Reporting Requirements</strong><br><br>
                                    <div class="dictionary">
                                        <p>13.1</p>
                                        <div>
                                            <p>The Member, in respect of all sponsored quoted Securities shall:</p><br>
                                            <p>13.1.1 comply with the reporting requirements as determined by FMDQ Exchange and such other relevant regulatory body, from time to time;</p><br>
                                            <p>13.1.2 notify FMDQ Exchange immediately in writing of any change to the information submitted to FMDQ Exchange during the application for listing, including in particular (but not limited to) those in respect of the Member or Issuer's authorisation, licence or capacity to issue the Security;</p><br>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">18</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="14">
                                <div class="dictionary">
                                    <p></p>
                                    <div class="ml-40">
                                        <p>13.1.3 notify FMDQ Exchange immediately in writing of the occurrence of any event which affects the contents of the Offer Documents, making such documents contain untrue statements of a material fact or omit to state any material fact necessary to make the statements therein accurate;</p><br>
                                        <p>13.1.4 where any event contemplated in Clause 13.1.3 occurs, use all reasonable endeavours to procure a revision or supplement which will correct any untrue statement or include any omitted fact in the Offer Documents. Where the Member is unable to procure such revision or supplement, the Member shall inform FMDQ Exchange of this fact;</p><br>
                                        <p>13.1.5 notify FMDQ Exchange in writing of any facts or circumstances which may affect the legal form or organisation of the Member or the Issuer, including (but not limited to) any consolidation, reorganisation, merger, change of name, change of control or similar event to which the Member or Issuer is or will become a party and provide such additional information as FMDQ Exchange may reasonably require; </p><br>
                                        <p>13.1.6 immediately notify FMDQ Exchange as soon as it is served with or becomes aware of any proceeding for bankruptcy, insolvency, winding up, administration or similar event (including amicable settlement) in any relevant jurisdiction the Member or the Issuer is subject to, and, to which the Member or Issuer is a Party; </p><br>
                                        <p>13.1.7 immediately notify FMDQ Exchange as soon as it is served with or becomes aware of any litigation or claims against an Issuer (on whose behalf it acts as sponsor) which litigation or claim is likely to affect the value of the Security; </p><br>
                                        <p>13.1.8 notify FMDQ Exchange of any reduction in the rating of any Security (the listing of which is sponsored by the Member) on the Platform; </p><br>
                                        <p>13.1.9 notify FMDQ Exchange of updated rating of any Security (the listing of which is sponsored by the Member) as and when the rating has become due for an update (i.e. the anniversary of the rating); and </p><br>
                                        <p>13.1.10 where a Security sought to be quoted is being traded on another Securities Exchange, notify FMDQ Exchange of the fact before the Security is admitted to quote on the Platform. </p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.2</p>
                                    <div>
                                        <p>The Member shall also meet any other reporting obligations and standards as may be required by FMDQ Exchange from time to time. </p><br>
                                    </div>
                                </div> <br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">19</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-three">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="14">
                                <li><strong>Willingness to Promote FMDQ Exchange</strong><br><br>
                                    <p>The Member hereby agrees to:</p><br>
                                    <ol type="i" class="ml-20">
                                        <li>participate in market development sessions organised by FMDQ Exchange;</li><br>
                                        <li>attend functions organised by FMDQ Exchange upon receipt of a written invitation from FMDQ Exchange;</li><br>
                                        <li>within the Member’s discretion, promote FMDQ Exchange as a market destination; and</li><br>
                                        <li>provide advice, feedback, and suggestions to FMDQ Exchange.</li><br>
                                    </ol>
                                </li>
                                <li><strong>Confidentiality and Data Protection</strong><br><br>
                                    <div class="dictionary">
                                        <p>15.1</p>
                                        <div>
                                            <p>The Parties shall treat as strictly confidential all Confidential Information and shall ensure that their respective authorised employees use the Confidential Information only for the performance of their obligations and the exercise of their rights under this Agreement. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>15.2</p>
                                        <div>
                                            <p>Each Party shall protect and adequately secure every data belonging to the other Party and shall prevent against the theft or disclosure of such data by its Affiliates, Directors, employees, subcontractors, agents, or any other individual or body corporate having access to the data through it. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>15.3</p>
                                        <div>
                                            <p>In the event that a Party learns of any theft, unauthorised use, disclosure, or threatened unauthorised use or disclosure of any Confidential Information, the Party shall notify the other Party of the particulars of such theft, unauthorised use or disclosure. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>15.4</p>
                                        <div>
                                            <p>The Parties undertake and agree to comply with the provisions of the Nigeria Data Protection Regulation, 2019 issued by the National Information Technology Development Agency and any amendments thereto in respect of any Personal Data received pursuant to or in connection with this Agreement. </p><br>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Limitation of Liability</strong><br><br>
                                    <div class="dictionary">
                                        <p>16.1</p>
                                        <div>
                                            <p>The Parties hereby acknowledge that each Party shall have no liability or obligation to the other for: </p><br>
                                            <p>16.1.1 occurrences that could not have been reasonably foreseen at the date of execution of this Agreement; and includes a Force Majeure Event; <br><br>
                                            </p>
                                            <p>16.1.2 any loss or damage which may be suffered, or which may arise directly or indirectly as a result of activities in the Market not caused by FMDQ Exchange, its staff and agents; <br><br>
                                            </p>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">20</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-four">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="17">
                                <div class="dictionary">
                                    <p></p>
                                    <div class="ml-30">
                                        <p>16.1.3 any act, error, failure or omission on the part of FMDQ Exchange, acting reasonably, including any loss or damage in respect of the suspension, cancellation, interruption or closure of the Market in compliance with relevant directives or orders from any regulatory body in Nigeria;</p><br>
                                        <p>16.1.4 the originality, accuracy or completeness of any information or market data provided by a third party; </p><br>
                                        <p>16.1.5 FMDQ Exchange’s decision to suspend or terminate the licence of the Member provided such suspension or termination is in compliance with the provisions of this Agreement, the FMDQ Exchange Rules, SEC Rules, the ISA, CBN circulars and DMO guidelines; and </p><br>
                                        <p>16.1.6 any decision of FMDQ Exchange in the exercise of its powers; provided that such powers are specifically established under this Agreement or the FMDQ Exchange Rules. </p><br>
                                    </div>
                                </div> <br>
                                <li><strong>Indemnity</strong><br><br>
                                    <div class="dictionary">
                                        <p>17.1</p>
                                        <div>
                                            <p>The Member hereby undertakes to indemnify FMDQ Exchange against any claim or loss arising from its violation of the terms of this Agreement, or any wrongful, negligent or illegal activities as the sponsor of any Issuer in contravention of any provision of this Agreement or the FMDQ Exchange Rules. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>17.2</p>
                                        <div>
                                            <p>FMDQ Exchange hereby undertakes to indemnify the Member against any claim or loss arising from its violation of the terms of this Agreement. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>17.3</p>
                                        <div>
                                            <p>The Member shall at all times during the subsistence of this Agreement maintain fidelity bond coverage as prescribed by the SEC. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>17.4</p>
                                        <div>
                                            <p>The fidelity bond shall include a cancellation rider providing that the insurer will promptly notify FMDQ Exchange in the event that the bond is cancelled, terminated or substantially modified. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>17.5</p>
                                        <div>
                                            <p>The Member hereby agrees to notify FMDQ Exchange in writing within three (3) business days of the expiry of its fidelity bond its cancellation, termination, or substantial modification </p>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Notices</strong>
                                    <p></p><br>
                                    <div class="dictionary">
                                        <p>18.1</p>
                                        <div>
                                            <p>Any notice, request or other communication to be given or made under this Agreement shall be in writing. Any such communication shall be delivered by hand, airmail, established courier service, e-mail or other agreed medium to the Party to which it is required or permitted to be given or made at such Party’s address specified below or at such other address as such Party has from time to time designated by written notice to the other Party hereto, and shall be effective upon the earlier of (a) actual receipt and (b) deemed receipt under Clause 18.2 below. </p><br>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">21</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-five">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="19">
                                <p></p>
                                <strong></strong>
                                <p></p>
                                <div class="dictionary">
                                    <p></p>
                                    <div class="ml-30">
                                        If to FMDQ Exchange: <br><br>
                                        <strong>Member Regulation Group</strong><br>
                                        FMDQ Securities Exchange Limited <br>
                                        Exchange Place <br>
                                        35 Idowu Taylor Street <br>
                                        Victoria Island <br>
                                        Lagos <br><br>
                                        OR via email: <a href="" style="color: #0A6AC8;">meg@fmdqgroup.com</a><br><br>
                                        If to the Member: <br><br>
                                        <strong>Managing Director</strong> <br>
                                        [<i>Insert Institution’s name</i>] <br>
                                        [<i>Insert Institution’s address</i>] <br>

                                    </div>
                                </div><br>
                                <div class="dictionary">
                                    <p>18.2</p>
                                    <div>
                                        <p>Any notice given as aforesaid shall be deemed to have been served when received, and shall be deemed to have been received (a) in the case of delivery by hand or courier, when delivered as evidenced by a receipt from the addressee; or (b) in the case of e-mail or other agreed medium, upon receipt by the sending party of electronic confirmation of receipt by the intended recipient. </p><br>
                                    </div>
                                </div>
                                <div class="dictionary">
                                    <p>18.3</p>
                                    <div>
                                        <p>All documents to be provided or communications to be given or made under this Agreement shall be in English and, where the original version of any such document or communication is not in English, shall be accompanied by an English translation certified to be a true and correct translation of the original. </p><br>
                                    </div>
                                </div>
                                <div class="dictionary">
                                    <p>18.4</p>
                                    <div>
                                        <p>In addition to Clause 18.1, FMDQ Exchange may convey notices via electronic broadcasts and/or via the Market Bulletin segment on the FMDQ Exchange website. </p><br>
                                    </div>
                                </div>
                                <li><strong>Binding Agreement</strong><br><br>
                                    <p>Notwithstanding any contrary agreement, both Parties agrees that this Agreement constitutes a legal, valid and binding agreement which shall be enforceable against it in accordance with its terms.</p><br>
                                </li>
                                <li><strong>Non-Waiver</strong><br><br>
                                    <p>No failure or delay by FMDQ Exchange to exercise any right, power or privilege hereunder shall operate as a waiver thereof nor shall any single or partial exercise of any right, power or privilege preclude any other or further exercise thereof, or the exercise of any other rights, power or privilege as herein provided.</p><br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">22</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-five">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="21">
                                <p></p>
                                <li><strong>Severability</strong><br><br>
                                    <p>If any provision of this Agreement is declared by any judicial or other competent authority to be void or otherwise unenforceable, that provision shall be severed from this Agreement and the remaining provisions shall remain in force and effect. Provided that the Parties shall thereafter amend this Agreement in such reasonable manner so as to achieve, without illegality, the intention of the Parties, with respect to the severed provision.</p><br>
                                </li>
                                <li><strong>Governing Law</strong><br><br>
                                    <p>Notwithstanding any other agreement to the contrary, this Agreement and all amendments there to shall be governed by and construed in accordance with Nigerian law.</p><br>
                                </li>
                                <li><strong>Dispute Resolution</strong><br><br>
                                    <div class="dictionary">
                                        <p>23.1</p>
                                        <div class="">
                                            In the event of any dispute arising out of or under this Agreement, the Parties shall within five (5) Business Days from the date the dispute arose, engage in an amicable settlement of the dispute by mutual negotiation
                                        </div>
                                    </div><br>
                                    <div class="dictionary">
                                        <p>23.2</p>
                                        <div class="">
                                            Where the dispute is not resolved by mutual negotiation, the Parties shall in compliance with the provisions of the Investment and Securities Act 2007, refer the matter to the Investment and Securities Tribunal for resolution.
                                        </div>
                                    </div><br>
                                </li>
                                <li><strong>Amendment</strong><br><br>
                                    <p>This term of this Agreement may be amended or varied by FMDQ Exchange (acting in good faith) from time to time by giving one (1) month calendar notice to the Member informing it of such amendment or variation.</p><br>
                                </li>
                                <li><strong>Execution of Agreement</strong><br><br>
                                    <p>This Agreement shall be executed on behalf of the Member by any two (2) Director (s) or a Director and the Company Secretary of the Member. Where the Agreement is executed by any other representative of the Member, the Member must notify FMDQ Exchange in writing that such representative is authorised to execute this Agreement. </p><br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">23</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-seven">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="37">
                                <p>IN WITNESS WHEREOF the Parties have caused their authorised representatives to execute this Agreement in the manner below, the day and year first above written.</p><br><br>
                                <div>
                                    <p>Signed for and on behalf of the within-named</p>
                                    <p><strong>FMDQ SECURITIES EXCHANGE LIMITED:</strong></p>
                                </div><br><br><br><br>
                                <div class="whole-signatory">
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                    </div>
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                    </div>
                                </div><br>
                                <div class="whole-name-designation flex-space-btw">
                                    <div class="name-designation">
                                        <div><Strong>Name: </Strong><span></span></div>
                                        <div><Strong>Designation: </Strong><span></span></div>
                                    </div>
                                    <div class="name-designation">
                                        <div><Strong>Name: </Strong><span></span></div>
                                        <div><Strong>Designation: </Strong><span></span></div>
                                    </div>
                                </div><br>
                                <div>
                                    <p>Signed for and on behalf of the within-named</p>
                                    <p><strong>[INSTITUTION’S NAME]</strong></p>
                                </div><br><br><br><br>
                                <div class="whole-signatory">
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                    </div>
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                    </div>
                                </div><br>
                                <div class="whole-name-designation flex-space-btw">
                                    <div class="name-designation">
                                        <div><Strong>Name: </Strong><span></span></div>
                                        <div><Strong>Designation: </Strong><span></span></div>
                                    </div>
                                    <div class="name-designation">
                                        <div><Strong>Name: </Strong><span></span></div>
                                        <div><Strong>Designation: </Strong><span></span></div>
                                    </div>
                                </div><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">24</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Listings) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-one">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two">
                        <div class="title-page">
                            <p>MEMBERSHIP AGREEMENT</p>
                            <p>BETWEEN</p>
                            <p>FMDQ SECURITIES EXCHANGE LIMITED</p>
                            <p>AND</p>
                            <p>[INSTITUTION’S NAME]</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">1</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-two">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content table-of-content">
                            <p>Table of Contents</p>
                            <div style="width: 100%;">
                                <ol style="margin-left: 20px;">
                                    <li>
                                        <div class="toc-item">Definitions and Interpretation <span>..........................................................................................................</span>3</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Market Standards <span>.............................................................................................................................</span>9</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Non-Agency Relationship <span>................................................................................................................</span>10</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Disclosure Requirements <span>................................................................................................................</span>10</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Anti-Money Laundering <span>..................................................................................................................</span>11</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Examination of Documents <span>.............................................................................................................</span>12</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Fees <span>..................................................................................................................................................</span>12</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Rules and Guidelines <span>........................................................................................................................</span>13</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Code of Conduct <span>..............................................................................................................................</span>13</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Member's Obligations <span>......................................................................................................................</span>15</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Discipline of the Member <span>.................................................................................................................</span>17</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Termination of Membership <span>.............................................................................................................</span>17</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Reporting Requirements <span>...................................................................................................................</span>18</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Willingness to Promote FMDQ Exchange <span>..........................................................................................</span>20</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Confidentiality <span>...................................................................................................................................</span>20</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Limitation of Liability <span>........................................................................................................................</span>20</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Indemnity <span>.........................................................................................................................................</span>21</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Notices <span>.............................................................................................................................................</span>21</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Binding Agreement <span>.........................................................................................................................</span>22</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Non-Waiver <span>.....................................................................................................................................</span>22</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Severability <span>.....................................................................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Governing Law <span>................................................................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Dispute Resolution <span>..........................................................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Amendment <span>....................................................................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Execution <span>........................................................................................................................................</span>23</div>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">2</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-three">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <p><strong>THIS DEALING MEMBERSHIP AGREEMENT</strong> is made the <span class="user-input uTwo"></span> day of <span class="user-input uTwo"></span>20<span class="user-input uTwo"> </span></p><br>
                            <p><strong>BETWEEN</strong></p><br>
                            <p><strong>FMDQ SECURITIES EXCHANGE LIMITED (RC. NO. 1617162)</strong>, a company incorporated under the laws of the Federal Republic of Nigeria with its principal place of business at Exchange Place, 35, Idowu Taylor Street, Victoria Island, Lagos, (hereinafter called <strong>“FMDQ Exchange”</strong> which expressionshall where the context so admits shall include its successors and assigns) of the first part.</p><br>
                            <p>AND</p><br>
                            <p>[Insert Institution’s name] (RC NO. XXXXX), a company incorporated under the laws of the Federal Republic of Nigeria with its registered office at [Insert Institution’s address] (the “Member” which expression shall where the context so admits shall include its successors and assigns) of the second part.</p><br>
                            <p>In this Agreement, FMDQ Exchange and the Member shall individually be referred to as a “Party” and collectively be referred to as the “Parties”.</p><br>
                            <p><strong>WHEREAS</strong></p><br>
                            <ol type="A" style="margin-left: 20px;">
                                <li>FMDQ Exchange is licensed by the Securities and Exchange Commission as a securities exchange and self-regulatory organisation with a Platform (as defined below) to enable its Members deal in Securities (as defined below) and carry out other activities.</li><br>
                                <li>[Insert Institution’s name], the Member, is a financial institution licensed by the SEC and has indicated interest in becoming a Member (as defined below) of FMDQ Exchange with a view to acting as a sponsor to Issuers’ quotation of Securities on the Platform. </li><br>
                                <li>The Member has agreed to be duly licenced by FMDQ Exchange as a Registration Member (Quotations). </li><br>
                                <li> Pursuant to the foregoing, the Parties hereby agree to be bound by the terms herein contained.</li>
                            </ol><br>
                            <p><strong>IT IS HEREBY AGREED AND DECLARED as follows: -</strong></p><br>
                            <ol style="margin-left: 20px;">
                                <li><strong>Definitions and Interpretation</strong><br><br>
                                    <div class="dictionary">
                                        <p>1.1</p>
                                        <div>
                                            Definitions
                                            <br><br>
                                            <p>In this Agreement, unless the context otherwise requires, the following expressions shall have the meanings set out hereunder: </p><br>
                                            <div class="sub-dictionary">
                                                <p class="term"><strong>“Act or ISA”</strong></p>
                                                <p class="definition">means the Investments and Securities Act, 2007 as may be amended or supplemented from time to time;</p>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">3</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-four">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary ml-40">
                                <p></p>
                                <div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Affiliate”</strong></p>
                                        <p class="definition">means an individual or body corporate that directly or indirectly controls, is controlled by, or is under common control with, the individual or body corporate specified. For the purpose of this definition, the terms "controlled by" and "controls" mean the possession, directly or indirectly, of the power to direct the management or policies of an individual or body corporate, whether through the ownership of shares, by contract, or otherwise; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Agreement”</strong></p>
                                        <p class="definition">means this Dealing Membership Agreement as may be amended or supplemented from time to time;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Applicable Law”</strong></p>
                                        <p class="definition">means any law for the time being in force in Nigeria(including statutory and common law), statute, constitution, judgment, treaty, regulation, rule, by-law, order, decree, code ofpractice, circular, directive, other legislative measure, guidelines, guidance note, requirement, request or guideline or injunction (whether or not having force of law and, to the extent not having force of law, is generally complied with by persons to whom it is addressed or applied) of or made by any governmental authority, which is binding and enforceable;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Authorised Representatives”</strong></p>
                                        <p class="definition">means an approved representative of a Member duly recognised by FMDQ Exchange to carry out any relevant financial market related functions on behalf of the Member; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Business Day”</strong></p>
                                        <p class="definition">means a day (other than a Saturday, Sunday or a FederalGovernment of Nigeria declared public holiday) on which Dealing Members are open for general business in Nigeria;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“CAMA”</strong></p>
                                        <p class="definition">means the Companies and Allied Matters Act, 2020, as may be amended or supplemented from time to time;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“CBN”</strong></p>
                                        <p class="definition">means the Central Bank of Nigeria;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Commission or SEC”</strong></p>
                                        <p class="definition">means the Securities and Exchange Commission;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Company”</strong></p>
                                        <p class="definition">has the meaning assigned to it in CAMA;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Confidential Information”</strong></p>
                                        <p class="definition">means any information, communications or data, about the Parties, Dealing Member(s) or their respective affairs or business in any form, whether oral, written, graphic, or electromagnetic, including all plans, proposals, forecasts, technical processes, methodologies, know-how, information about technological or organisational systems, customers, personnel, business activities, marketing, financial research or development activities,</p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">4</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-five">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary ml-40">
                                <p></p>
                                <div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong></strong></p>
                                        <p class="definition"> databases, Intellectual Property Rights, the terms and conditions of this Agreement and other information in relation to it, whether or not it is specifically marked confidential but excluding any information, which: </p>
                                    </div><br>
                                    <div style="display: flex;justify-content: flex-end;">
                                        <ol type="i" style="width: 400px;">
                                            <li>was already known to the Recipient at the time of its disclosure to the Recipient and is not subject to confidentiality restrictions;</li><br>
                                            <li>is in the public domain at the date of its disclosure to the Recipient or thereafter enters the public domain through no fault of the Recipient (but only after it becomes part of the public domain); or</li><br>
                                            <li>is independently developed by the Recipient without use or reference to the Disclosing Party’s confidential information, as shown by documents and other competent evidence in the receiving Party’s possession; or</li><br>
                                            <li>is required by law or regulation to be disclosed by the Recipient, provided that the Recipient, where it isreasonable in the circumstances,shall promptly give theDisclosing Party written notice of such requirement prior to any disclosure so that the Disclosing Party may seek a protective order or other appropriate relief</li><br>
                                        </ol>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Court”</strong></p>
                                        <p class="definition">means any court of competent jurisdiction;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Disclosing Party”</strong></p>
                                        <p class="definition">means the Party disclosing an item of Confidential Information;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“DMO” </strong></p>
                                        <p class="definition">means Debt Management Office of the Federal Republic of Nigeria;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“FMDQ Exchange Fees <br> & Dues Framework” </strong></p>
                                        <p class="definition">means the framework as advised to the Members containing all relevant and applicable fees and dues (including Membership Dues) as may be updated from time to time;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“FMDQ GOLD Award”</strong></p>
                                        <p class="definition">means a recognition of exceptional performance on the securities exchange, exemplary compliance with the FMDQ Exchange Rules and contribution to the Nigerian financial markets;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“FMDQ Exchange Rules” </strong></p>
                                        <p class="definition">means rules, circulars, bulletins, guidelines and other regulation designed by FMDQ Exchange (and where required, approved by the SEC, CBN or DMO, as the case may be) and advised to Members to govern activities on the Platform, as may be supplemented and amended from time to time; </p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">5</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-six">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary ml-40">
                                <p></p>
                                <div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Force Majeure Event” </strong></p>
                                        <p class="definition">means the occurrence of an event which materially interferes with the ability of a Party to perform its obligations or duties hereunder which is not within the reasonable control of the Party affected or any of its Affiliates, and which could not with the exercise of diligent efforts have been avoided, including, but not limited to, war (whether or not declared), rebellion, earthquake, fire, explosions, accident, strike, lockouts or other labour disturbances, riot, civil commotion, act of God, epidemics, pandemics, national emergencies, work stoppages, state or federal lockdowns, orders and laws of governmental authorities (both federal and state), change in Law or any act of God or other cause beyond the control of the Parties </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Inactive Member” </strong></p>
                                        <p class="definition">means a Member whose membership benefits has been withdrawn as a result of outstanding Membership Dues owed to the Exchange. </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Information Memorandum” </strong></p>
                                        <p class="definition">includes a circular, explanatory memorandum, or other equivalent document circulated, relating to Securities for which an Issuer applies for listing and quotation on the Platform; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Insider Trading”</strong></p>
                                        <p class="definition">means trading done by an individual or body corporate or group of individuals or bodies corporate who being in possession of some confidential and price sensitive information not generally available to the public, utilises such information to buy or sell Securities for the benefit of themselves or any other individual or body corporate;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Intellectual Property Rights” </strong></p>
                                        <p class="definition">includes any patent, copyright, trademark, trade name, trade secret, brand name, logo, corporate name, internet domain name or industrial design, any registrations thereof and pending applications therefor, any other intellectual property right (including, without limitation, any know-how, trade secret, trade right, formula, conditional or proprietary report or information, customer or membership list, any marketing data, and any computer program, software, database or data right), and license or other contract relating to any of the foregoing, and any goodwill associated with any business owning, holding or using any of the foregoing;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>"Issuer"</strong></p>
                                        <p class="definition">means a corporate body that intends to, or has raised, finance by issuing Securities to be quoted and traded on the Platform;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Market” </strong></p>
                                        <p class="definition">means the market for Products tradable or traded on the FMDQ Exchange Platform; </p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">6</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-seven">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary ml-40">
                                <p></p>
                                <div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Member” </strong></p>
                                        <p class="definition">means a Registration Member (Quotations), which is a financial institution (such as banks and investment companies regulated by the CBN) and financial services operators such as private investment companies, investment advisers and other related financial service providers such as consulting, advisory and professional service firms duly registered by/with their relevant regulators/professional bodies and authorised by FMDQ Exchange for sponsoring the quotation of Issuers’ Securities on the Platform; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Offer Documents” </strong></p>
                                        <p class="definition">mean the Information Memorandum or prospectus or any other documents for the public offer or private placement of Securities. This may include any other documents containing relevant information to help an investor make an investment decision such as pricing supplement, programme memorandum or equivalent documents; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Platform”</strong></p>
                                        <p class="definition">means the FMDQ Exchange-organised marketplace for listing, registration, quotation, order execution, and trade reporting;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Personal Data”</strong></p>
                                        <p class="definition">has the meaning contained in the Nigeria Data Protection, Regulation, 2019;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Private Censure”</strong></p>
                                        <p class="definition">means a private disciplinary action that constitutes a formal expression of disapproval of a Member by FMDQ Exchange. It includes but is not limited to warning or infractions lettersissued to the Member; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Public Censure”</strong></p>
                                        <p class="definition">means a public disciplinary action that constitutes a formal expression of disapproval of a Member by FMDQ Exchange. It includes but is not limited to newspaper publications and posting on the FMDQ Exchange website; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Recipient”</strong></p>
                                        <p class="definition">means the Party receiving an item of Confidential Information;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Securities”</strong></p>
                                        <p class="definition">means commercial papers and other financial instruments as may be described by FMDQ Exchange, such as short-term debt securites (where applicable) which are available for quotation on the Platform;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Securities Exchange”</strong></p>
                                        <p class="definition">has the meaning assigned to it in the ISA; and</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“SEC Rules” </strong></p>
                                        <p class="definition">means the rules and regulations of the Commission issued pursuant to the ISA, as may be amended from time to time; </p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">7</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-eight">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 20px;">
                                <p>1.2</p>
                                <div>Interpretation <br><br>
                                    <p>In this Agreement:</p><br>
                                    <p>1.2.1 Words importing the singular number only shall include the plural and vice- versa and words importing the feminine gender only shall include the masculine gender and vice versa and words importing persons shall include corporations, associations, partnerships and governments (whether state or local), and the words “written” or “in writing” shall include printing, engraving, lithography or other means of visible reproduction.</p> <br>
                                    <p>1.2.2 The words “hereof,” “herein,” “hereby,” “hereto” and similar words refer to this entire Agreement and not any particular Clause, Schedule, or other subdivision of this Agreement.</p> <br>
                                    <p>1.2.3 A reference to “Party” or “Parties” shall mean a party or parties to this Agreement.</p> <br>
                                    <p>1.2.4 A reference to a statutory provision shall be deemed to include that provision as the same may from time to time be modified, amended, or re-enacted.</p> <br>
                                    <p>1.2.5 Any reference to Clauses and Schedules, are to Clauses and Schedules of this Agreement, and references to sub-clauses and paragraphs are references to sub-clauses and paragraphs of the clause or schedule in which they appear.</p> <br>
                                    <p>1.2.6 A reference to a provision of this Agreement is to that provision as amended in accordance with the terms of this Agreement.</p> <br>
                                    <p>1.2.7 A reference to “consent” means any consent, approval, authorisation, license, or clearance of any kind whether fiscal, statutory, or regulatory. </p> <br>
                                    <p>1.2.8 A reference to any document being “in the agreed form” means in a form which has been agreed by the Parties on or before the date of this Agreement and for identification purposes signed by them or on their behalf by their Authorised Signatories. </p> <br>
                                    <p>1.2.9 References to days shall refer to calendar days unless Business Days are specified; references to weeks, months or years shall be to calendar weeks, months, or years respectively. </p> <br>
                                    <p>1.2.10 References to any liability shall include actual, contingent, present, or future liabilities.</p> <br>
                                    <p>1.2.11 Words and expressions defined in any clause shall, unless the application of any such word or expression is specifically limited to that clause, bear the meaning assigned to such word or expression throughout this Agreement.</p> <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">8</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-nine">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 40px;">
                                <p></p>
                                <div>
                                    <p></p>
                                    <p>1.2.12 The expiration or termination of this Agreement shall not affect the provisions of this Agreement which are expressly indicated to survive the expiration or termination or which of necessity must continue to have effect after such expiration or termination either expressly or impliedly.</p> <br>
                                    <p>1.2.13 Where figures are referred to in numerals and in words, and there is any conflict between the two, the words shall prevail, unless the context indicates a contrary intention.</p> <br>
                                    <p>1.2.14 Defined terms appearing in this Agreement in upper case shall be given their meaning as defined, while the same terms appearing in lower case shall be interpreted in accordance with their plain English meaning.</p> <br>
                                    <p>1.2.15 Words and phrases used in this Agreement, unless otherwise defined in this Agreement,shall have themeanings given to them in theRuleBook, SECRules, CBN circulars, DMO guidelines, the ISA, and any other legislative enactment.</p> <br>
                                    <p>1.2.16 A reference to FMDQ Exchange or the Member herein shall include reference to their respective successors and assigns.</p> <br>
                                    <p>1.2.17 The division of this Agreement into clauses and sub-clauses, the provision of a table of contents and the insertion of headings are for convenience of reference only and shall not be deemed to form part of the text or affect the construction or interpretation hereof.</p> <br>
                                    <p>1.2.18 Any money payable under this Agreement on a day that falls on a public holiday shall be paid on the next Business Day. </p> <br>
                                </div>
                            </div>
                            <ol style="margin-left: 20px;" start="2">
                                <li><strong>Market Standards</strong><br><br>
                                    <p>The Member shall:</p><br>
                                    <div class="dictionary">
                                        <p>2.1</p>
                                        <div>
                                            <p>use its best endeavours to maintain such market standards as may be determined and communicated to the Member by FMDQ Exchange from time to time in its dealings with any Issuer or investor;</p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>2.2</p>
                                        <div>
                                            <p>comply with the minimum standards on risk management and compliance prescribedand communicated to the Member from time to time by FMDQ Exchange;</p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>2.3</p>
                                        <div>
                                            <p>establish a robust risk management and compliance function which shall be responsible for identifying, measuring, monitoring and reporting any risks that the Member may be exposed to; and</p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>2.4</p>
                                        <div>
                                            <p>maintain a proper structure that ensures the efficiency of its risk management and compliance function.</p>
                                        </div>
                                    </div> <br>
                                </li><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">9</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-ten">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="3">
                                <li><strong>Non-Agency Relationship</strong><br><br>
                                    <div class="dictionary">
                                        <p>The Member or its Authorised Representative(s) shall not hold itself out to any individual or body corporate as being an agent of or otherwise representing or having the power in any way to act for or bind FMDQ Exchange unless expressly authorised in writing.</p>
                                    </div> <br>
                                </li><br>
                                <li><strong>Disclosure Requirements</strong><br><br>
                                    <div class="dictionary">
                                        <p>4.1</p>
                                        <div>
                                            <p>The Member hereby undertakes to:</p><br>
                                            <p>4.1.1 disclose in writing to FMDQ Exchange its membership of any other Securities Exchange at the time of the execution of this Agreement;</p><br>
                                            <p>4.1.2 disclose to FMDQ Exchange in writing, not later than one (1) calendar month from when it becomes a Member of any other Securities Exchange after the execution of this Agreement, specifying the name and principal place of business of the other Securities Exchange, the date it was registered as a member of the Securities Exchange, the duration of its membership, and suchadditional or other information as may be required by FMDQ Exchange;</p><br>
                                            <p>4.1.3 disclose to FMDQ Exchange not later than one (1) calendar month after the execution of this Agreement the particulars of its management personnel and director(s) who are responsible for overseeing its financial markets function; provided that where any change is made in respect of the aforementioned persons, it will not later than one (1) calendar month thereafter inform FMDQExchange of such change;</p><br>
                                            <p>4.1.4 disclose any information regarding any Security that it believes may abnormally affect the Market to FMDQ Exchange immediately, and no later than twenty-four (24) hours of being aware of the information;</p><br>
                                            <p>4.1.5 disclose any investigation, sanction, enforcement proceeding or injunction against it in respect of any matter related to this Agreement, or any other membership agreements executed with any securities exchange, self-regulatory organisation, regulatory authority or such other body that may adversely affect the performance of its obligations herein to FMDQ Exchange within twenty-four (24) hours of being aware of the investigation, sanction, enforcement proceeding or injunction;</p><br>
                                            <p>4.1.6 disclose any event which may impair its ability to comply with this Agreement or any of the FMDQ Exchange Rules to FMDQ Exchange within twenty-four (24) hours of being aware of the event;</p><br>
                                            <p>4.1.7 disclose any information regarding the Issuer that may affect their quotation on the Platform.</p><br>
                                        </div>
                                    </div>
                                </li><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">10</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-eleven">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="5">
                                <div class="dictionary">
                                    <p>4.2</p>
                                    <div>
                                        For the purpose of this clause, “disclose” means to alert, make known or reveal any of the event mentioned in clause 4.1 to FMDQ Exchange. FMDQ Exchange however reserves the right to demand more information should the need arise.
                                    </div>
                                </div> <br>
                                <li>
                                    <strong>Anti-Money Laundering</strong><br><br>
                                    <div class="dictionary">
                                        <p>5.1</p>
                                        <div>
                                            The Member covenants and represents that at all times during the subsistence of this Agreement, it shall comply with all applicable laws, policies and regulations on money laundering, including the SEC (Capital Market Operators Anti-Money Laundering/Combating the Financing of Terrorism and Proliferation Financing), Regulations, 2022 and shall establish/maintain a robust and comprehensive anti-money laundering/counter-terrorism financing framework. It shall adopt policies stating its commitment to comply with Anti-Money Laundering, Countering the Financing of Terrorism and Countering the Proliferation Financing (AML/CFT/CPF) obligations under the law and regulatory directives to actively prevent any transaction that facilitates criminal activities.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>5.2</p>
                                        <div>
                                            The Member undertakes to keep all records and documentation pertaining to any anti-money laundering and counter-terrorism financing due diligence procedures relating to its activities on the Platform for such period as required by FMDQ Exchange or by Applicable Law
                                        </div>
                                    </div><br>
                                    <div class="dictionary">
                                        <p>5.3</p>
                                        <div>
                                            Subject to any Applicable Law prohibiting disclosure, if FMDQ Exchange is required by the regulatory authorities to satisfy itself or such authorities as to the facts of any transaction or activities of the Member on the Platform or FMDQ Exchange suspects any form of money laundering or terrorism financing, or at any time pursuant to FMDQExchange’s request, the Member must immediately provide copies of all due diligence materials relating to such transaction or activities to FMDQ Exchange and/or all relevant regulatory authorities. In such circumstances, the Member must also provide a translation and certification of such documents if so requested by FMDQ Exchange.
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>5.4</p>
                                        <div>
                                            If the Member delegates, assigns, subcontracts or transfers any of its rights or obligations under this Agreement to another party, the Member shall ensure that such party complies with the requirements set out in this Agreement, FMDQ Exchange’sRules and Applicable Law.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>5.5</p>
                                        <div>
                                            The Member will ensure that none of its subsidiaries or Affiliates will fund all or part of any payment under any transaction out of proceeds derived from any unlawful activity which would result in any violation of any anti-money laundering or counter-terrorism financing legislation in force in Nigeria (as may be amended) and regulations thereunder or any other Applicable Law or regulation concerning anti-money laundering or the prevention thereof.

                                        </div>
                                    </div><br>
                                    <!-- <div class="dictionary">
                                                <p>6.6</p>
                                                <div>
                                                    Disclose any investigation, sanction, enforcement proceeding or injunction against it in respect of any matter related to this Agreement or that may adversely affect the performance of obligations herein to FMDQ Exchange within twenty-four (24) hours of being aware of the investigation, sanction, enforcement proceeding or injunction.
                                                </div>
                                            </div><br>
                                            <div class="dictionary">
                                                <p>6.7</p>
                                                <div>
                                                    Disclose any event which may impair its ability to comply with this Agreement or theRule Book to FMDQ Exchange within twenty-four (24) hours of being aware of the event.
                                                </div>
                                            </div><br>
                                            <div class="dictionary">
                                                <p>6.8</p>
                                                <div>
                                                    For the purpose of clause 6 of this Agreement, “disclose” means alert, make known or reveal any of the aforementioned events in clauses 6.1 to 6.7 above to FMDQ Exchange.FMDQ Exchange however reserves the right to demand more information should the need arise.
                                                </div>
                                            </div><br>
                                        </li><br>
                                    <li><strong>Anti-Money Laundering</strong><br><br>
                                        <p>The Parties covenant and represent that at all times during the existence of this Agreement, they shall comply with all applicable laws, policies, and regulations on money laundering, including the SEC (Capital Market Operators Anti-Money Laundering/Combating the Financing of Terrorism and Proliferation Financing), Regulations, 2022 and shall establish/maintain a robust and comprehensive anti-money laundering/counter-terrorism financing framework. It shall adopt policies stating its commitment to comply with Anti-Money Laundering, Countering the Financing of Terrorism and Countering the Proliferation Financing (“AML/CFT/CPF”)obligations under the law and regulatory directives to actively prevent any transaction that facilitates criminal activities.</p>
                                    </li><br>
                                </ol> -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">11</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twelve">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="6">
                                <li><strong>Examination of Documents</strong><br><br>
                                    <div class="dictionary">
                                        <p>6.1</p>
                                        <div>
                                            The Member hereby undertakes that it shall make itself available for examination or audit howsoever required, and to make available any document or record relating to the Member’s functions as a Member, whether by means of paper copy, electronic copy, disk, hard drive, flash drive or such other storage device in its possession or subject to its possession, when required by FMDQ Exchange to carry out its supervisory function, provided that FMDQ Exchange shall give fourteen (14) days’ notice of such examination or review. Notwithstanding the foregoing, the Parties agree that FMDQ Exchange shall have the right to examine/audit the documents or records of the Member, at any time and without notice, where there is a reasonable cause to do so.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>6.2</p>
                                        <div>
                                            FMDQ Exchange shall ensure the confidentiality of documents provided under clause 6.1 above and not to disclose its content except as required by any law, rule, regulation, order, and judgment of a competent court in Nigeria or for any other lawful purposeand shall notify the Member before such disclosure, where practicable, and where it is impracticable to notify the Member prior to such disclosure, provide written notice to the Member promptly after disclosure.
                                        </div>
                                    </div> <br>
                                </li><br>
                                <li><strong>Fees</strong><br><br>
                                    <div class="dictionary">
                                        <p>7.1</p>
                                        <div>
                                            <strong>Quotation Fees</strong><br><br>
                                            <p>The Member hereby agrees that:</p><br>
                                            <div>
                                                <p>7.1.1 FMDQ Exchange shall charge and may revise quotation fees for every Security sought to be quoted by an Issuer and such fees will be provided in the FMDQ Exchange Fees and Dues Framework.</p><br>
                                                <p>7.1.2 Pursuant to Clause 7.1.1, notice of revision of quotation fees shall be communicated to the Member. </p>
                                            </div>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>7.2</p>
                                        <div>
                                            <strong>Membership Dues</strong><br><br>
                                            <p>The Member hereby agrees that:</p><br>
                                            <div>
                                                <p>7.2.1 The Member shall pay an annual membership due to FMDQ Exchange at a rate to be determined and communicated by FMDQ Exchange from time to time. </p><br>
                                                <p>7.2.2 The Membership Dues shall be payable immediately upon the execution of this Agreement and shall thereafter become payable on the 1st Business Day of January of each year. FMDQ Exchange shall have the right to revise the dues from time to time. </p><br>
                                            </div>
                                        </div>
                                    </div> <br>
                                </li>
                                <!-- <li><strong>Transaction Fees</strong><br><br>
                                        <p>The Member hereby agrees that:</p>
                                        <div class="dictionary">
                                            <p>9.1</p>
                                            <div>
                                                FMDQ Exchange shall charge and revise transaction fees at rates to be determined and published for transactions conducted on the Platform .
                                            </div>
                                        </div> <br>
                                        <div class="dictionary">
                                            <p>9.2</p>
                                            <div>
                                                Pursuant to Clause 9.1 above, notice of revision of fees shall be given to the Members within one (1) calendar month of its effective date.
                                            </div>
                                        </div> <br>
                                        <div class="dictionary">
                                            <p>9.3</p>
                                            <div>
                                                FMDQ Exchange shall deduct transaction fees from the Member’s account held with the CBN through direct debit, provided always that FMDQ Exchange shall promptly notify the Member before making such deductions.
                                            </div>
                                        </div> <br>
                                    </li><br>
                                    <li><strong>Membership Dues</strong><br><br>
                                        <div class="dictionary">
                                            <p>10.1</p>
                                            <div>
                                                The Member shall pay an annual membership due to FMDQ Exchange at a rate to be determined by FMDQ Exchange from time to time after due consultation with Dealing Members. The dues shall be payable immediately upon becoming a Dealing Member and shall thereafter become payable on the first Business Day of January of each year and FMDQ Exchange shall have the right to revise the dues after due consultation with the Members. Notice of the revised dues shall be communicated to the Dealing Member within one (1) calendar month before the expiration of the subsisting membership dues.
                                            </div>
                                        </div> <br>
                                        <div class="dictionary">
                                            <p>10.2</p>
                                            <div>
                                                The Member hereby agrees that FMDQ Exchange may deduct the annual membership dues from the Member’s account with the CBN by direct debit. Provided always that FMDQ Exchange shall promptly notify the Member before making such deductions.
                                            </div>
                                        </div> <br>
                                        <div class="dictionary">
                                            <p>10.3</p>
                                            <div>
                                                Denial of accessto some or allthe facilities of FMDQ Exchange through suspension under the provisions of this Agreement shall not prevent FMDQ Exchange from proceeding against the Member through all available legal means.
                                            </div>
                                        </div> <br>
                                    </li><br>
                                    <li><strong>Rules and Guidelines</strong><br><br>
                                        <p>The Member shall comply with the provisions of the Rule Book and any reasonable amendments thereto as may be made by FMDQ Exchange, in its relationship with FMDQ Exchange, other Dealing Members, its clients and the general public.</p>
                                    </li><br> -->
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">12</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twelve">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="8">
                                <div class="dictionary">
                                    <p>7.3</p>
                                    <div>FMDQ Exchange shall issue an invoice to the Member for the Membership Dues. If the Member does not pay the Membership Dues within two (2) weeks of the date of the issue of the invoice, the Member shall lose all rights and privileges on the FMDQ Exchange Platform.</div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>7.4</p>
                                    <div>Suspension or termination of the Member’s licence under the provisions of this Agreement shall not prevent FMDQ Exchange from proceeding against the Member for the recovery of all fees payable through all available legal means.</div>
                                </div> <br>
                                <li><strong>Rules and Guidelines</strong><br><br>
                                    <p>The Member shall comply with the provisions of the FMDQ Exchange Rules and any amendments thereto as may be made by FMDQ Exchange, in its relationship with FMDQ Exchange, other Members, Issuers and investors.</p>
                                </li><br>
                                <li><strong>Code of Conduct</strong><br><br>
                                    <p>The Member shall comply with the code of conduct set out below and as contained in the FMDQ Exchange Rules when acting as a Member.</p><br>
                                    <div class="dictionary">
                                        <p>9.1</p>
                                        <div>
                                            <strong>General Duties of Integrity, Care and Full Disclosure</strong><br><br>
                                            <p>As the sponsor to an Issuer’s quotation of a Security, the Member shall:</p><br>
                                            <div>
                                                <p>9.1.1 observe high standards of integrity and fair market conduct; </p><br>
                                                <p>9.1.2 act with due skill, care and diligence;</p><br>
                                                <p>9.1.3 refrain from any act or conduct which is likely to mar the reputation of FMDQ Exchange and the Market;</p><br>
                                                <p>9.1.4 when required to disclose any fact to FMDQ Exchange or investors, to act in an honest, open, truthful, cooperative manner and not mislead or conceal any material matter; and</p><br>
                                                <p>9.1.5 provide full and prompt responses to all requests for information by FMDQ Exchange in respect of any Security listed on the Platform and provide access to all relevant books, records and other forms of documentation in accordance with the provisions of any applicable law and/or regulation.</p><br>
                                            </div>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">13</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-thirteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="8">
                                <p></p>
                                <div class="dictionary">
                                    <p>9.2</p>
                                    <div>
                                        <strong>No Fraudulent or Misleading Conduct</strong><br><br>
                                        <p>The Member shall not engage in, or fail to take reasonable steps to prevent:</p><br>
                                        <div>
                                            <p>9.2.1 any action that has the effect, or may be expected to have the effect, of artificially and/or abnormally affecting the price or value of a Security; </p><br>
                                            <p>9.2.2 any illegal action or conduct that creates or is likely to create any false or misleading impression as to the market price or value of any Security quoted on the Platform;</p><br>
                                            <p>9.2.3 any action or conduct that may mar the integrity and transparency of the process of quoting a Security on the Platform, or any other activities which will adversely impact the Platform and/or the Market;</p><br>
                                            <p>9.2.4 agreeing or acting in concert with, or providing any assistance to any individual or body corporate (whether or not a Member) with a view to doing anything prohibited by this Agreement or the FMDQ Exchange Rules, or otherwise causing or contributing to a breach of any Applicable Law by such other individual or body corporate;</p><br>
                                            <p>9.2.5 its Authorised Representatives from effecting or causing to effect a fraud or deception in relation to any Security;</p><br>
                                            <p>9.2.6 its Authorised Representatives from participating in any Insider Trading in relation to a Security, or knowingly assist any other individual or body corporate to participate in any such Insider Trading; </p><br>
                                            <p>9.2.7 establishing measures that ensure its Authorised Representatives do not engage in personal dealings, whether directly or indirectly, in Securities which Issuer the Member is sponsor of, or of any other Securities which the Member may have confidential information by virtue of being a capital markets participant; and </p><br>
                                            <p>9.2.8 establishing measures that directly or indirectly, through an Affiliate or otherwise commit any fraudulent activity, make any untrue or misleading statement, or engage in any act, practice, or course of business which operates or would operate as a fraud or deceit upon any person, in connection with the purchase or sale of any Security </p><br>
                                        </div>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>9.3</p>
                                    <div>
                                        <strong>Authorised Representatives of the Member</strong><br><br>
                                        <p></p>
                                        <div>
                                            <p>9.3.1 The Member shall advise FMDQ Exchange of its Authorised Representatives at the point of onboarding to becoming a Member. </p><br>
                                            <p>9.3.2 The Member shall be responsible for the actions of its Authorised Representatives.</p><br>
                                            <p>9.3.3 Persons designated to act as Authorised Representatives shall be required to meet specified competency requirements as may be laid down by FMDQExchange from time to time.</p><br>
                                            <p>9.3.4 FMDQ Exchange may upon notice to the Member decline to recognise any Authorised Representative if upon investigation the Authorised Representativeis determined to have acted in an unethical manner or is found no longer fit and proper to perform activities on the FMDQ Exchange Platform.</p><br>
                                        </div>
                                    </div>
                                </div> <br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">14</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-fourteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="10">
                                <div class="dictionary">
                                    <p></p>
                                    <div>
                                        <strong></strong><br>
                                        <p></p><br>
                                        <div class="ml-20">
                                            <p>9.3.5 The Member shall make adequate arrangements to ensure that all its Authorised Representatives are suitable, competent, knowledgeable, adequately trained and properly supervised.</p><br>
                                            <p>9.3.6 The Member shall ensure that its Authorised Representatives participate in and complete all trainings, inductions and all other competency requirements as FMDQ Exchange may prescribe from time to time. </p><br>
                                            <p>9.3.7 The Member shall have the responsibility and duty to ascertain by investigation the good character, business repute, qualifications and experience of its Authorised Representatives. </p><br>
                                            <p>9.3.8 The Member shall also be responsible for ensuring that training programmes are designed to enhance the knowledge and competence of its Authorised Representatives in the Member’s role as a Member.</p><br>
                                            <p>9.3.9 The Member shall ensure that its Authorised Representatives complete all relevant annual corporate governance, risk management, compliance, anti-money laundering, counter-terrorism financing, know-your-customer (KYC) reporting, and such other trainings, tests, certifications and standards as may be required by FMDQ Exchange or any Applicable Law not less than once a year. </p><br>
                                            <p>9.3.10 The Member shall notify FMDQ Exchange in writing within seven (7) Business Days of any change to the list of Authorised Representatives in its employment, and bi-annually, i.e., January and July of every year as part of its compliance reporting to FMDQ Exchange.</p><br>
                                        </div>
                                    </div>
                                </div> <br>
                                <li><strong>Member’s Obligations</strong><br><br>
                                    <p>The Member hereby agrees on a continuing basis, to:</p><br>
                                    <div class="dictionary">
                                        <p>10.1</p>
                                        <div>
                                            <p>except as otherwise provided in this Agreement or in the FMDQ Exchange Rules, advise the Issuer on the process for quotation of Securities on the Platform;</p><br>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>10.2</p>
                                        <div>
                                            <p>ensure that that the Issuer is in compliance with the FMDQ Exchange Rules and all Applicable Laws for the entire duration of the issue;</p><br>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>10.3</p>
                                        <div>
                                            <p>be responsible for the compilation and submission of documents required by FMDQ Exchange to support the Issuer’s application to quote Securities;</p><br>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">15</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-fourteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="10">
                                <strong></strong>
                                <p></p><br>
                                <div class="dictionary">
                                    <p>10.4</p>
                                    <div>
                                        <p>abide by the FMDQ Exchange Rules (and such other requirements as determined by FMDQ Exchange) and any other agreement with FMDQ Exchange in force and as may be amended from time to time and promptly notified to the Member by FMDQExchange;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.5</p>
                                    <div>
                                        <p>ensure that the Issuer meets the minimum application requirements as prescribed by the FMDQ Exchange Rules;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.6</p>
                                    <div>
                                        <p>ensure that the amount raised through the issuance of a Security is in line with the Offer Documents and within the limit approved by the Issuer’s board of directors or such other equivalent body;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.7</p>
                                    <div>
                                        <p>ensure that the amount raised through the issuance of a Security is utilised by the Issuer for the purpose(s) stated in the Offer Documents;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.8</p>
                                    <div>
                                        <p>pay the fees, dues and other applicable charges as set out in the FMDQ Exchange Fees & Dues Framework and as may be reviewed by FMDQ Exchange from time to time, upon conditions established by FMDQ Exchange and promptly communicated to the Member; </p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.9</p>
                                    <div>
                                        <p>subject to Clause 6.1, authorise FMDQ Exchange or its duly appointed agents to carry out examinations and investigations, during regular business hours, in any place of business of the Member or its Affiliate, and submit as soon as possible any information or document relating to the Member’s responsibility under this Agreement which FMDQ Exchange or its agents consider appropriate for purposes of such examinations and investigations;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.10</p>
                                    <div>
                                        <p>comply with all the requirements for operating as a Member as may be advised by FMDQ Exchange from time to time;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.11</p>
                                    <div>
                                        <p>ensure that any description of its membership or the services that it is able to provide, in the form and context in which it appears or is used, does not misrepresent the scope of the capacity which it enjoys as a Member;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.12</p>
                                    <div>
                                        <p>document, implement and maintain adequate internal procedures and controls in relation to its activities as a Member;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.13</p>
                                    <div>
                                        <p>meet the corporate governance, risk management, compliance, anti-money laundering, counter-terrorism financing, know-your-customer (KYC) reporting and such other trainings, tests, certifications and standards as may be required by FMDQ Exchange or any Applicable Law not less than once a year;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.14</p>
                                    <div>
                                        <p>keep and maintain proper records and books of account in respect of all its activities as a Member of the Platform and as the sponsor of a Security for a period to be advised by FMDQ Exchange and, in accordance with FMDQ Exchange Rules and any other Applicable Law; and</p>
                                    </div>
                                </div> <br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">16</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-fourteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="11">
                                <strong></strong>
                                <p></p><br>
                                <div class="dictionary">
                                    <p>10.15</p>
                                    <div>
                                        <p>promptly provide complete and accurate data and statistics relating to its activities as a Member of the Platform and as the sponsor of a Security as FMDQ Exchange may request from time to time.</p>
                                    </div>
                                </div> <br>
                                <li><strong>Discipline of the Member</strong><br><br>
                                    <p></p><br>
                                    <div class="dictionary">
                                        <p>11.1</p>
                                        <div>
                                            <p>The Member hereby acknowledges that FMDQ Exchange has the power to take disciplinary action against it for any established violation of any of the FMDQ Exchange Rules in force, or as may be amended from time to time, or any provision of this Agreement. In particular, FMDQ Exchange has the power to impose any of the following penalties on the Member and may as appropriate, report the disciplinary action to the relevant regulatory body:</p><br>
                                            <ol type="a">
                                                <li>fines;</li><br>
                                                <li>non-consideration for FMDQ GOLD Award;</li><br>
                                                <li>suspension of membership on such terms and for such period as FMDQ Exchange may think fit;</li><br>
                                                <li>revocation of the Member’s licence; or</li><br>
                                                <li>Public and/or Private Censure.</li>
                                            </ol>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>11.2</p>
                                        <div>
                                            <p>The disciplinary powers referred to above may be exercised separately or concurrently. The exercise of such powers shall not prejudice any right that may be vested in FMDQ Exchange to seek legal redress against the Member in pursuance of enforcement of the disciplinary decision. </p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>11.3</p>
                                        <div>
                                            <p>Where the Member’s licence is revoked, it shall forthwith lose all rights to act as a Member.</p>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Termination of Membership</strong><br><br>
                                    <div class="dictionary">
                                        <p>12.1</p>
                                        <div>
                                            <p>The Member shall cease to be a member of FMDQ Exchange if:</p><br>
                                            <p>12.1.1 it gives FMDQ Exchange sixty (60) days’ notice in writing of its intention to terminate its membership. Such membership shall terminate at the expiration of the sixty (60) days’ notice; Notwithstanding the notice period in this sub-clause 12.1.1, FMDQ Exchange may terminate the membership (upon receipt of the notice in writing from the Member), within such shorter period as FMDQ Exchange deems fit, where the Member has no outstanding obligation(s).</p><br>
                                            <p>12.1.2 it is wound up voluntarily;</p><br>
                                            <p>12.1.3 it has become insolvent;</p><br>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">17</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="13">
                                <div class="dictionary">
                                    <p></p>
                                    <div class="ml-40">
                                        <p>12.1.4 it is compulsorily wound up by order of the Court;</p><br>
                                        <p>12.1.5 the Commission or relevant regulatory body has revoked its registration/licence;</p><br>
                                        <p>12.1.6 it is unable to meet or has defaulted in its obligations under this Agreement;</p><br>
                                        <p>12.1.7 upon investigation by FMDQ Exchange, it is proven that it has acted in an unprofessional and unethical manner in the Market; or </p><br>
                                        <p>12.1.8 any other reason as FMDQ Exchange may deem fit to terminate the licence of the Member. </p><br>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>12.2</p>
                                    <div>
                                        <p>Where the membership of the Member is terminated upon the occurrence of any of the events in Clause 12.1, the Member shall immediately notify Issuers in relation to which it acts as a sponsor of the occurrence of the event. Upon receipt of the notice the Issuers shall be entitled to appoint another Member acceptable to FMDQ Exchange to act in place of the Member. </p><br>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>12.3</p>
                                    <div>
                                        <p>The Member hereby acknowledges that termination of its membership shall not prevent FMDQ Exchange from collecting any accrued fees, dues, fines or charges due or arising from this Agreement, the FMDQ Exchange Rules or any other agreement between FMDQ Exchange and the Member. </p><br>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>12.4</p>
                                    <div>
                                        <p>The Member hereby acknowledges that FMDQ Exchange reserves the right to apply to the Courts to recover any fees, dues, fines or charges due or arising from this Agreement upon termination of its membership and/or take all necessary steps to protect any investor until such a time that all reported claims have been settled. </p><br>
                                    </div>
                                </div> <br>
                                <li><strong>Reporting Requirements</strong><br><br>
                                    <div class="dictionary">
                                        <p>13.1</p>
                                        <div>
                                            <p>The Member, in respect of all sponsored quoted Securities shall:</p><br>
                                            <p>13.1.1 comply with the reporting requirements as determined by FMDQ Exchange and such other relevant regulatory body, from time to time;</p><br>
                                            <p>13.1.2 notify FMDQ Exchange immediately in writing of any change to the information submitted to FMDQ Exchange during the Issuer’s application process, including in particular (but not limited to) those in respect of the Member or Issuer's authorisation, licence or capacity to issue the Security;</p><br>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">18</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="14">
                                <div class="dictionary">
                                    <p></p>
                                    <div class="ml-40">
                                        <p>13.1.3 notify FMDQ Exchange immediately in writing of the occurrence of any event which affects the contents of the Offer Documents, making such documents contain untrue statements of a material fact or omit to state any material fact necessary to make the statements therein accurate;</p><br>
                                        <p>13.1.4 where any event contemplated in Clause 13.1.3 occurs, use all reasonable endeavours to procure a revision or supplement which will correct any untrue statement or include any omitted fact in the Offer Documents. Where the Member is unable to procure such revision or supplement, the Member shall inform FMDQ Exchange of this fact;</p><br>
                                        <p>13.1.5 notify FMDQ Exchange in writing of any facts or circumstances which may affect the legal form or organisation of the Member or the Issuer, including (but not limited to) any consolidation, reorganisation, merger, change of name, change of control or similar event to which the Member or Issuer is or will become a party and provide such additional information as FMDQ Exchange may reasonably require; </p><br>
                                        <p>13.1.6 immediately notify FMDQ Exchange as soon as it is served with or becomes aware of any proceeding for bankruptcy, insolvency, winding up, administration or similar event (including amicable settlement) in any relevant jurisdiction the Member or the Issuer is subject to, and, to which the Member or Issuer is a Party; </p><br>
                                        <p>13.1.7 immediately notify FMDQ Exchange as soon as it is served with or becomes aware of any litigation or claims against an Issuer (on whose behalf it acts as sponsor) which litigation or claim is likely to affect the value of the Security; </p><br>
                                        <p>13.1.8 notify FMDQ Exchange of any reduction in the rating of any Security (the quotation of which is sponsored by the Member) on the Platform; </p><br>
                                        <p>13.1.9 notify FMDQ Exchange of updated rating of any Security (the quotation of which is sponsored by the Member) as and when the rating has become due for an update (i.e. the anniversary of the rating); and </p><br>
                                        <p>13.1.10 where a Security sought to be quoted is being traded on another Securities Exchange, notify FMDQ Exchange of the fact before the Security is admitted to quote on the Platform. </p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.2</p>
                                    <div>
                                        <p>The Member shall also meet any other reporting obligations and standards as may be required by FMDQ Exchange from time to time. </p><br>
                                    </div>
                                </div> <br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">19</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-three">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="14">
                                <li><strong>Willingness to Promote FMDQ Exchange</strong><br><br>
                                    <p>The Member hereby agrees to:</p><br>
                                    <ol type="i" class="ml-20">
                                        <li>participate in market development sessions organised by FMDQ Exchange;</li><br>
                                        <li>attend functions organised by FMDQ Exchange upon receipt of a written invitation from FMDQ Exchange;</li><br>
                                        <li>within the Member’s discretion, promote FMDQ Exchange as a market destination; and</li><br>
                                        <li>provide advice, feedback, and suggestions to FMDQ Exchange.</li><br>
                                    </ol>
                                </li>
                                <li><strong>Confidentiality and Data Protection</strong><br><br>
                                    <div class="dictionary">
                                        <p>15.1</p>
                                        <div>
                                            <p>The Parties shall treat as strictly confidential all Confidential Information and shall ensure that their respective authorised employees use the Confidential Information only for the performance of their obligations and the exercise of their rights under this Agreement. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>15.2</p>
                                        <div>
                                            <p>Each Party shall protect and adequately secure every data belonging to the other Party and shall prevent against the theft or disclosure of such data by its Affiliates, Directors, employees, subcontractors, agents, or any other individual or body corporate having access to the data through it. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>15.3</p>
                                        <div>
                                            <p>In the event that a Party learns of any theft, unauthorised use, disclosure, or threatened unauthorised use or disclosure of any Confidential Information, the Party shall notify the other Party of the particulars of such theft, unauthorised use or disclosure. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>15.4</p>
                                        <div>
                                            <p>The Parties undertake and agree to comply with the provisions of the Nigeria Data Protection Regulation, 2019 issued by the National Information Technology Development Agency and any amendments thereto in respect of any Personal Data received pursuant to or in connection with this Agreement. </p><br>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Limitation of Liability</strong><br><br>
                                    <div class="dictionary">
                                        <p>16.1</p>
                                        <div>
                                            <p>The Parties hereby acknowledge that each Party shall have no liability or obligation to the other for: </p><br>
                                            <p>16.1.1 occurrences that could not have been reasonably foreseen at the date of execution of this Agreement; and includes a Force Majeure Event; <br><br>
                                            </p>
                                            <p>16.1.2 any loss or damage which may be suffered, or which may arise directly or indirectly as a result of activities in the Market not caused by FMDQ Exchange, its staff and agents; <br><br>
                                            </p>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">20</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-four">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="17">
                                <div class="dictionary">
                                    <p></p>
                                    <div class="ml-30">
                                        <p>16.1.3 any act, error, failure or omission on the part of FMDQ Exchange, acting reasonably, including any loss or damage in respect of the suspension, cancellation, interruption or closure of the Market in compliance with relevant directives or orders from any regulatory body in Nigeria;</p><br>
                                        <p>16.1.4 the originality, accuracy or completeness of any information or market data provided by a third party; </p><br>
                                        <p>16.1.5 FMDQ Exchange’s decision to suspend or terminate the licence of the Member provided such suspension or termination is in compliance with the provisions of this Agreement, the FMDQ Exchange Rules, SEC Rules, the ISA, CBN circulars and DMO guidelines; and </p><br>
                                        <p>16.1.6 any decision of FMDQ Exchange in the exercise of its powers; provided that such powers are specifically established under this Agreement or the FMDQ Exchange Rules. </p><br>
                                    </div>
                                </div> <br>
                                <li><strong>Indemnity</strong><br><br>
                                    <div class="dictionary">
                                        <p>17.1</p>
                                        <div>
                                            <p>The Member hereby undertakes to indemnify FMDQ Exchange against any claim or loss arising from its violation of the terms of this Agreement, or any wrongful, negligent or illegal activities as the sponsor of any Issuer in contravention of any provision of this Agreement or the FMDQ Exchange Rules. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>17.2</p>
                                        <div>
                                            <p>FMDQ Exchange hereby undertakes to indemnify the Member against any claim or loss arising from its violation of the terms of this Agreement. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>17.3</p>
                                        <div>
                                            <p>The Member shall at all times during the subsistence of this Agreement maintain fidelity bond coverage as prescribed by the SEC. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>17.4</p>
                                        <div>
                                            <p>The fidelity bond shall include a cancellation rider providing that the insurer will promptly notify FMDQ Exchange in the event that the bond is cancelled, terminated or substantially modified. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>17.5</p>
                                        <div>
                                            <p>The Member hereby agrees to notify FMDQ Exchange in writing within three (3) business days of the expiry of its fidelity bond its cancellation, termination, or substantial modification </p>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Notices</strong>
                                    <p></p><br>
                                    <div class="dictionary">
                                        <p>18.1</p>
                                        <div>
                                            <p>Any notice, request or other communication to be given or made under this Agreement shall be in writing. Any such communication shall be delivered by hand, airmail, established courier service, e-mail or other agreed medium to the Party to which it is required or permitted to be given or made at such Party’s address specified below or at such other address as such Party has from time to time designated by written notice to the other Party hereto, and shall be effective upon the earlier of (a) actual receipt and (b) deemed receipt under Clause 18.2 below. </p><br>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">21</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-five">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="19">
                                <p></p>
                                <strong></strong>
                                <p></p>
                                <div class="dictionary">
                                    <p></p>
                                    <div class="ml-30">
                                        If to FMDQ Exchange: <br><br>
                                        <strong>Member Regulation Group</strong><br>
                                        FMDQ Securities Exchange Limited <br>
                                        Exchange Place <br>
                                        35 Idowu Taylor Street <br>
                                        Victoria Island <br>
                                        Lagos <br><br>
                                        OR via email: <a href="" style="color: #0A6AC8;">meg@fmdqgroup.com</a><br><br>
                                        If to the Member: <br><br>
                                        <strong>Managing Director</strong> <br>
                                        [<i>Insert Institution’s name</i>] <br>
                                        [<i>Insert Institution’s address</i>] <br>

                                    </div>
                                </div><br>
                                <div class="dictionary">
                                    <p>18.2</p>
                                    <div>
                                        <p>Any notice given as aforesaid shall be deemed to have been served when received, and shall be deemed to have been received (a) in the case of delivery by hand or courier, when delivered as evidenced by a receipt from the addressee; or (b) in the case of e-mail or other agreed medium, upon receipt by the sending party of electronic confirmation of receipt by the intended recipient. </p><br>
                                    </div>
                                </div>
                                <div class="dictionary">
                                    <p>18.3</p>
                                    <div>
                                        <p>All documents to be provided or communications to be given or made under this Agreement shall be in English and, where the original version of any such document or communication is not in English, shall be accompanied by an English translation certified to be a true and correct translation of the original. </p><br>
                                    </div>
                                </div>
                                <div class="dictionary">
                                    <p>18.4</p>
                                    <div>
                                        <p>In addition to Clause 18.1, FMDQ Exchange may convey notices via electronic broadcasts and/or via the Market Bulletin segment on the FMDQ Exchange website. </p><br>
                                    </div>
                                </div>
                                <li><strong>Binding Agreement</strong><br><br>
                                    <p>Notwithstanding any contrary agreement, both Parties agrees that this Agreement constitutes a legal, valid and binding agreement which shall be enforceable against it in accordance with its terms.</p><br>
                                </li>
                                <li><strong>Non-Waiver</strong><br><br>
                                    <p>No failure or delay by FMDQ Exchange to exercise any right, power or privilege hereunder shall operate as a waiver thereof nor shall any single or partial exercise of any right, power or privilege preclude any other or further exercise thereof, or the exercise of any other rights, power or privilege as herein provided.</p><br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">22</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-five">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="21">
                                <p></p>
                                <li><strong>Severability</strong><br><br>
                                    <p>If any provision of this Agreement is declared by any judicial or other competent authority to be void or otherwise unenforceable, that provision shall be severed from this Agreement and the remaining provisions shall remain in force and effect. Provided that the Parties shall thereafter amend this Agreement in such reasonable manner so as to achieve, without illegality, the intention of the Parties, with respect to the severed provision.</p><br>
                                </li>
                                <li><strong>Governing Law</strong><br><br>
                                    <p>Notwithstanding any other agreement to the contrary, this Agreement and all amendments there to shall be governed by and construed in accordance with Nigerian law.</p><br>
                                </li>
                                <li><strong>Dispute Resolution</strong><br><br>
                                    <div class="dictionary">
                                        <p>23.1</p>
                                        <div class="">
                                            In the event of any dispute arising out of or under this Agreement, the Parties shall within five (5) Business Days from the date the dispute arose, engage in an amicable settlement of the dispute by mutual negotiation
                                        </div>
                                    </div><br>
                                    <div class="dictionary">
                                        <p>23.2</p>
                                        <div class="">
                                            Where the dispute is not resolved by mutual negotiation, the Parties shall in compliance with the provisions of the Investment and Securities Act 2007, refer the matter to the Investment and Securities Tribunal for resolution.
                                        </div>
                                    </div><br>
                                </li>
                                <li><strong>Amendment</strong><br><br>
                                    <p>This term of this Agreement may be amended or varied by FMDQ Exchange (acting in good faith) from time to time by giving one (1) month calendar notice to the Member informing it of such amendment or variation.</p><br>
                                </li>
                                <li><strong>Execution of Agreement</strong><br><br>
                                    <p>This Agreement shall be executed on behalf of the Member by any two (2) Director (s) or a Director and the Company Secretary of the Member. Where the Agreement is executed by any other representative of the Member, the Member must notify FMDQ Exchange in writing that such representative is authorised to execute this Agreement. </p><br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">23</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-seven">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="37">
                                <p>IN WITNESS WHEREOF the Parties have caused their authorised representatives to execute this Agreement in the manner below, the day and year first above written.</p><br><br>
                                <div>
                                    <p>Signed for and on behalf of the within-named</p>
                                    <p><strong>FMDQ SECURITIES EXCHANGE LIMITED:</strong></p>
                                </div><br><br><br><br>
                                <div class="whole-signatory">
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                    </div>
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                    </div>
                                </div><br>
                                <div class="whole-name-designation flex-space-btw">
                                    <div class="name-designation">
                                        <div><Strong>Name: </Strong><span></span></div>
                                        <div><Strong>Designation: </Strong><span></span></div>
                                    </div>
                                    <div class="name-designation">
                                        <div><Strong>Name: </Strong><span></span></div>
                                        <div><Strong>Designation: </Strong><span></span></div>
                                    </div>
                                </div><br>
                                <div>
                                    <p>Signed for and on behalf of the within-named</p>
                                    <p><strong>[INSTITUTION’S NAME]</strong></p>
                                </div><br><br><br><br>
                                <div class="whole-signatory">
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                    </div>
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                    </div>
                                </div><br>
                                <div class="whole-name-designation flex-space-btw">
                                    <div class="name-designation">
                                        <div><Strong>Name: </Strong><span></span></div>
                                        <div><Strong>Designation: </Strong><span></span></div>
                                    </div>
                                    <div class="name-designation">
                                        <div><Strong>Name: </Strong><span></span></div>
                                        <div><Strong>Designation: </Strong><span></span></div>
                                    </div>
                                </div><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">24</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Registration Members (Quotations) </div>
            </div>
        </section>
    </div>
    <script type="text/javascript">
        // window.print();

        var Config = {};
        Config.pixelsPerInch = 96;
        Config.pageHeightInCentimeter = 29.7; // must match 'min-height' from 'css/sheets-of-paper-*.css' being used
        Config.pageMarginBottomInCentimeter = 2; // must match 'padding-bottom' and 'margin-bottom' from 'css/sheets-of-paper-*.css' being used

        window.addEventListener("DOMContentLoaded", function() {
            applyPageBreaks();
        });


        /* Applies any manual page breaks in preview mode (screen, non-print) where CSS Paged Media is not fully supported */
        function applyManualPageBreaks() {
            var docs, pages, snippets;
            docs = document.querySelectorAll(".document");

            for (var d = docs.length - 1; d >= 0; d--) {
                pages = docs[d].querySelectorAll(".page");

                for (var p = pages.length - 1; p >= 0; p--) {
                    snippets = pages[p].children;

                    for (var s = snippets.length - 1; s >= 0; s--) {
                        if (snippets[s].classList.contains("page-break")) {
                            pages[p].insertAdjacentHTML("afterend", "<div class=\"page\" contenteditable=\"true\"></div>");

                            for (var n = snippets.length - 1; n > s; n--) {
                                pages[p].nextElementSibling.insertBefore(snippets[n], pages[p].nextElementSibling.firstChild);
                            }

                            snippets[s].remove();
                        }
                    }
                }
            }
        }

        /* Applies (where necessary) automatic page breaks in preview mode (screen, non-print) where CSS Paged Media is not fully supported */
        function applyAutomaticPageBreaks(pixelsPerInch, pageHeightInCentimeter, pageMarginBottomInCentimeter) {
            var inchPerCentimeter = 0.393701;
            var pageHeightInInch = pageHeightInCentimeter * inchPerCentimeter;
            var pageHeightInPixels = Math.ceil(pageHeightInInch * pixelsPerInch);
            var pageMarginBottomInInch = pageMarginBottomInCentimeter * inchPerCentimeter;
            var pageMarginBottomInPixels = Math.ceil(pageMarginBottomInInch * pixelsPerInch);
            var docs, pages, snippets, pageCoords, snippetCoords;
            docs = document.querySelectorAll(".document");

            for (var d = docs.length - 1; d >= 0; d--) {
                pages = docs[d].querySelectorAll(".page");

                for (var p = 0; p < pages.length; p++) {
                    if (pages[p].clientHeight > pageHeightInPixels) {
                        pages[p].insertAdjacentHTML("afterend", "<div class=\"page\" contenteditable=\"true\"></div>");
                        pageCoords = pages[p].getBoundingClientRect();
                        snippets = pages[p].querySelectorAll("h1, h2, h3, h4, h5, h6, p, ul, ol");

                        for (var s = snippets.length - 1; s >= 0; s--) {
                            snippetCoords = snippets[s].getBoundingClientRect();

                            if ((snippetCoords.bottom - pageCoords.top + pageMarginBottomInPixels) > pageHeightInPixels) {
                                pages[p].nextElementSibling.insertBefore(snippets[s], pages[p].nextElementSibling.firstChild);
                            }
                        }

                        pages = docs[d].querySelectorAll(".page");
                    }
                }
            }
        }

    </script>
</body>


</html>
