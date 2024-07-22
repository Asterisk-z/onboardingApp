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
                            <p>DEALING MEMBERSHIP AGREEMENT</p>
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
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
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
                                        <div class="toc-item">Non-Agency Relationship <span>................................................................................................................</span>9</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Market Disruption <span>...........................................................................................................................</span>10</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Disclosure Requirements <span>................................................................................................................</span>10</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Anti-Money Laundering <span>..................................................................................................................</span>10</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Examination of Documents <span>.............................................................................................................</span>11</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Fees <span>..................................................................................................................................................</span>12</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Rules and Guidelines <span>........................................................................................................................</span>12</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Code of Conduct <span>..............................................................................................................................</span>12</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Member's Obligations <span>......................................................................................................................</span>15</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Internal Control <span>.................................................................................................................................</span>15</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Trading Method <span>................................................................................................................................</span>17</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Discipline of the Member <span>.................................................................................................................</span>17</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Termination of Membership <span>.............................................................................................................</span>17</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Systems Security <span>...............................................................................................................................</span>18</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Access Right to Trading Systems <span>......................................................................................................</span>19</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Restrictions on Use of Trading Systems <span>............................................................................................</span>19</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Suspension of Trading <span>......................................................................................................................</span>19</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Confirmation of Instructions <span>............................................................................................................</span>20</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Prohibition of Transactions with Suspended Members <span>....................................................................</span>20</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Confidentiality <span>...................................................................................................................................</span>21</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Limitation of Liability <span>........................................................................................................................</span>21</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Indemnity <span>.........................................................................................................................................</span>22</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Notices <span>.............................................................................................................................................</span>22</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Binding Agreement <span>.........................................................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Non-Waiver <span>.....................................................................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Severability <span>.....................................................................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Governing Law <span>................................................................................................................................</span>24</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Dispute Resolution <span>..........................................................................................................................</span>24</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Amendment <span>.....................................................................................................................................</span>24</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Execution of Agreement <span>...................................................................................................................</span>24</div>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">2</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-three">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <p><strong>THIS DEALING MEMBERSHIP AGREEMENT</strong> is dated <span class="user-input uOne"></span>-<span class="user-input uOne"></span></p><br>
                            <p><strong>BETWEEN</strong></p><br>
                            <p><strong>FMDQ SECURITIES EXCHANGE LIMITED (RC. NO. 1617162)</strong>, a company incorporated under the laws of the Federal Republic of Nigeria with its principal place of business at Exchange Place, 35, Idowu Taylor Street, Victoria Island, Lagos, (hereinafter called <strong>“FMDQ Exchange”</strong> which expressionshall where the context so admits shall include its successors and assigns) of the first part.</p><br>
                            <p>AND</p><br>
                            <p>[Insert Institution’s name] (RC NO. XXXXX), a company incorporated under the laws of the Federal Republic of Nigeria with its registered office at [Insert Institution’s address] (the “Member” which expression shall where the context so admits shall include its successors and assigns) of the second part.</p><br>
                            <p>In this Agreement, FMDQ Exchange and the Member shall individually be referred to as a “Party” and collectively be referred to as the “Parties”.</p><br>
                            <p><strong>WHEREAS</strong></p><br>
                            <ol type="A" style="margin-left: 20px;">
                                <li>FMDQ Exchange is licenced by the Securities and Exchange Commission as a securities exchange and self-regulatory organisation with a Platform (as defined below) to enable its members deal in Products (as defined below) on the Platform and carry out other activities.</li><br>
                                <li>The Member (as defined below) has indicated interest in investing in Products traded on the Platform. </li><br>
                                <li>The Member has agreed to be duly licenced by FMDQ Exchange as an Associate Member (Client), to request for quotes and invest in the Products subject to the terms and conditions contained in this Agreement.</li><br>
                            </ol><br>
                            <p><strong>IT IS HEREBY AGREED AND DECLARED as follows: -</strong></p><br>
                            <ol style="margin-left: 20px;">
                                <li><strong>Definitions and Interpretation</strong><br><br>
                                    <div class="dictionary">
                                        <p>1.1</p>
                                        <div>
                                            <strong> Definitions</strong>
                                            <br><br>
                                            <p>In this Dealing Membership Agreement hereto, unlessthe context otherwise requires, the following expressions shall have the meanings set out hereunder: -</p><br>
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
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
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
                                        <p class="definition">means this Membership Agreement as may be amended or supplemented from time to time;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Applicable Law”</strong></p>
                                        <p class="definition">means any law for the time being in force in Nigeria(including statutory and common law), statute, constitution, judgment, treaty, regulation, rule, by-law, order, decree, code ofpractice, circular, directive, other legislative measure, guidelines, guidance note, requirement, request or guideline or injunction (whether or not having force of law and, to the extent not having force of law, is generally complied with by persons to whom it is addressed or applied) of or made by any governmental authority, which is binding and enforceable;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Authorised <br> Representatives”</strong></p>
                                        <p class="definition">means an approved representative of the Client, authorised by the Client to make representations to FMDQ Exchange on its behalf; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Broker”</strong></p>
                                        <p class="definition">means anybody corporate which has been admitted to trade on the Platform as a Broker; </p>
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
                                        <p class="definition">has the meaning contained in the CAMA</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Confidential Information”</strong></p>
                                        <p class="definition">means any information, communication or data, about any of the Parties or their respective affairs or business in any form, whether oral, written, graphic, or electromagnetic, including all plans, proposals, forecasts, technical processes, methodologies, know-how, information about technological or organisational systems, customers, personnel, business</p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">4</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
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
                                        <p class="definition">activities, business plans, marketing, financial research, reports, or development activities, databases, Intellectual Property Rights, the terms and conditions of this Agreement and other information in relation to it, whether or not it is specifically marked confidential but excluding any information, which: </p>
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
                                        <p class="term"><strong>“Dealing Member”</strong></p>
                                        <p class="definition">means any financial institution which has been admitted to trade on the Platform as a Dealing Member;</p>
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
                                        <p class="term"><strong>“FMDQ Depository”</strong></p>
                                        <p class="definition">means FMDQ Depository Limited </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“FMDQ Exchange Fees <br> & Dues Framework”</strong></p>
                                        <p class="definition">means the framework as advised to the Members containing all relevant and applicable fees and dues (including Membership Dues) as may be updated from time to time;</p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">5</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
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
                                        <p class="term"><strong>“FMDQ GOLD OTC Award”</strong></p>
                                        <p class="definition">means a recognition of exceptional performance on the securities exchange, exemplary compliance with the FMDQ Exchange Rules and contribution to the Nigerian financial markets;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“FMDQ Exchange Rules”</strong></p>
                                        <p class="definition">means rules, circulars, bulletins, guidelines and otherregulation designed by FMDQ Exchange (and where required, approved by the SEC, CBN or DMO, as the case may be) and advised to the Members to govern activities on the Platform, as may be supplemented and amended from time to time;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Force Majeure Event” </strong></p>
                                        <p class="definition">means the occurrence of an event which materially interferes with the ability of a Party to perform its obligations or duties hereunder which is not within the reasonable control of the Party affected or any of its Affiliates, and which could not with the exercise of diligent efforts have been avoided, including, but not limited to, war (whether or not declared), rebellion, earthquake, fire, explosions, accident, strike, lockouts or other labour disturbances, riot, civil commotion, act of God, epidemics, pandemics, national emergencies, work stoppages, state or federal lockdowns, orders and laws of governmental authorities (both federal and state), change in Law or any act of God or other cause beyond the control of the Parties </p>
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
                                        <p class="term"><strong>“Market” </strong></p>
                                        <p class="definition">means the market for Securities tradable or traded on the Platform; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>"Market Disruption"</strong></p>
                                        <p class="definition">means any event which makes it impossible or impracticable to trade Securities on the Platform, which disruption may or may not be of a technical or Systems-related nature, and is not caused by, or within the control of, any of the Parties;</p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">6</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
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
                                        <p class="term"><strong>“Member or Client”</strong></p>
                                        <p class="definition">means an Associate Member (Client) admitted to participate in activities as an end-user of products traded on the FMDQ Exchange platform;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Personal Data”</strong></p>
                                        <p class="definition">has the meaning contained in the Nigeria Data Protection, Regulation, 2019;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Platform”</strong></p>
                                        <p class="definition">means the FMDQ Exchange-organised marketplace for listing, registration, quotation, order execution, and trade reporting;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Product”</strong></p>
                                        <p class="definition">means any instrument, security, currency, or other contract admitted by FMDQ Exchange for trading on the Platform, Products shall be construed accordingly;</p>
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
                                        <p class="term"><strong>“Securities Exchange”</strong></p>
                                        <p class="definition">has the meaning assigned to it in the ISA (or subsequent amendments thereto);</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“SEC Rules” </strong></p>
                                        <p class="definition">means the rules and regulations of the Commission issued pursuant to the ISA, as may be amended and supplemented from time to time; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“SWIFT” </strong></p>
                                        <p class="definition">means a standardised communications platformused to facilitate the transmission of data about financial transactions. Such information includes (but is not limited to) confirmation of trades;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“System”</strong></p>
                                        <p class="definition">means an electronic trading programme that allows Members to submit trade-related data and fulfil contractual obligations leading up to the clearing and settlement of executed trades. Systems used on the FMDQ Exchange Platform include (but are not limited to) Bloomberg E-bond Trading System,Refinitiv Trading System, FMDQ OTC FX Futures Trading & Reporting System. Trading systems may be different from the clearing and settlement systems;</p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">7</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
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
                                    <p>1.2.5 Any reference to Clauses and Schedules, are to Clauses and Schedules of this Dealing Membership Agreement, and references to sub-clauses and paragraphs are references to sub-clauses and paragraphs of the clause or schedule in which they appear.</p> <br>
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
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
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
                                    <p>The Member shall use its best endeavours to maintain such market standards as may be reasonably determined and promptly communicated to it by FMDQ Exchange from time to time in its dealings with Dealing Members and/or Brokers.</p><br>
                                </li><br>
                                <li><strong>Non-Agency Relationship</strong><br><br>
                                    <div class="dictionary">
                                        <p>3.1</p>
                                        <div>
                                            The Member or its Authorised Representative shall not hold itself out to any individual or body corporate as being an agent of or otherwise representing or having the power in any way to act for or bind FMDQ Exchange unless expressly authorised in writing.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>3.2</p>
                                        <div>
                                            The Member shall act as a principal in all its activities with Dealing Members and/or Brokers on the Platform without limitation and shall be responsible to Dealing Members, Brokers and FMDQ Exchange as a principal.
                                        </div>
                                    </div>
                                </li><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">9</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-ten">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="4">
                                <li><strong>Market Disruption</strong><br><br>
                                    <div class="dictionary">
                                        <p>4.1</p>
                                        <div>
                                            FMDQ Exchange shall apply its best endeavours to keep the Platform operating efficiently during trading hours.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>4.2</p>
                                        <div>
                                            Each Party hereby agrees that the other Party shall not be liable for the failure of transactions on the Platform arising from Market Disruptions not due to negligent conduct on its part.
                                        </div>
                                    </div>
                                </li><br>
                                <li><strong>Disclosure Requirements</strong><br><br>
                                    <p>The Member hereby undertakes to:</p><br>
                                    <div class="dictionary">
                                        <p>5.1</p>
                                        <div>
                                            The Member hereby undertakes to: <br><br>
                                            <p>5.1.1 disclose any information regarding any Product that it believes may abnormally affect the Market to FMDQ Exchange within twenty-four (24) hours of being aware of the information;</p><br>
                                            <p>5.1.2 disclose any investigation, sanction, enforcement proceeding or injunction against it in respect of any matter related to this Agreement, or any other Membership Agreements executed with any securities exchange, self-regulatory organisation, regulatory authority or such other body, or that may adversely affect the performance of its obligations herein to FMDQ Exchange within twenty-four (24) hours of being aware of the investigation, sanction, enforcement proceeding or injunction; and</p><br>
                                            <p>5.1.3 disclose any event which may impair its ability to comply with this Agreement or the FMDQ Exchange Rules to FMDQ Exchange within twenty-four (24) hours of being aware of the event.</p><br>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>5.2</p>
                                        <div>
                                            For the purpose of this clause 5 of this Agreement, “disclose” means alert, make known or reveal any of the aforementioned events in clause 5.1 to FMDQ Exchange. FMDQ Exchange however reserves the right to demand more information should the need arise.
                                        </div>
                                    </div><br>
                                </li><br>
                                <li>
                                    <strong>Anti-Money Laundering</strong><br><br>
                                    <div class="dictionary">
                                        <p>6.1</p>
                                        <div>
                                            The Member covenants and represents that at all times during the subsistence of this Agreement, it shall comply with all applicable laws, policies and regulations on money laundering including the SEC (Capital Market Operators Anti-Money Laundering/Combating the Financing of Terrorism and Proliferation Financing), Regulations, 2022 and shall establish/maintain a robust and comprehensive anti-money laundering/counter-terrorism financing framework. It shall adopt policies stating its commitment to comply with Anti-Money Laundering, Countering the Financing of Terrorism and Countering the Proliferation Financing (AML/CFT/CPF) obligations under the law and regulatory directives to actively prevent any transaction that facilitates criminal activities.
                                        </div>
                                    </div><br>
                                </li><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">10</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-eleven">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="7">
                                <div>
                                    <div class="dictionary">
                                        <p>6.2</p>
                                        <div>
                                            The Member undertakes to keep all records and documentation pertaining to any anti-money laundering and counter-terrorism financing due diligence procedures relating to its activities on the Platform for such period as required by FMDQ Exchange or by Applicable Law.
                                        </div>
                                    </div><br>
                                    <div class="dictionary">
                                        <p>6.3</p>
                                        <div>
                                            Subject to any Applicable Law prohibiting disclosure, if FMDQ Exchange is required by the regulatory authorities, to satisfy itself or such authorities as to the facts of any transaction or activities of the Member on the Platform or FMDQ Exchange suspects any form of money laundering or terrorism financing, or at any time pursuant to FMDQ Exchange’s request, the Member must immediately provide copies of all due diligence materials relating to such transaction or activities to FMDQ Exchange and/or all relevant regulatory authorities. In such circumstances, the Member must also provide a translation and certification of such documents if so requested by FMDQ Exchange.
                                        </div>
                                    </div><br>
                                    <div class="dictionary">
                                        <p>6.4</p>
                                        <div>
                                            If the Member delegates, assigns, subcontracts or transfers any of its rights or obligations under this Agreement to another party, the Member shall ensure that such party complies with the requirements set out in this Agreement, FMDQ Exchange Rules and Applicable Law.
                                        </div>
                                    </div><br>
                                    <div class="dictionary">
                                        <p>6.5</p>
                                        <div>
                                            The Member will ensure that none of its subsidiaries or Affiliates will, fund all or part of any payment under any transaction out of proceeds derived from any unlawful activity which would result in any violation of any anti-money laundering or counter-terrorism financing legislation in force in Nigeria (as may be amended) and regulations there under or any other Applicable Law or regulation concerning anti-money laundering or the prevention thereof.
                                        </div>
                                    </div><br>
                                </div>
                                <li><strong>Examination of Documents</strong><br><br>
                                    <div class="dictionary">
                                        <p>7.1</p>
                                        <div>
                                            The Member hereby undertakes that it shall make itself available for examination or audit howsoever required, and to make available any document or record relating to the Member’s functions as a Member, whether by means of paper copy, electronic copy, disk, hard drive, flash drive or such other storage device in its possession or subject to its possession, when required by FMDQ Exchange to carry out its supervisory function, provided that FMDQ Exchange shall give fourteen (14) days’ notice of such examination or review. Notwithstanding the foregoing, the Parties agree that FMDQ Exchange shall have the right to examine/audit the documents or records of the Member, at any time and without notice, where there is a reasonable cause to do so.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>7.2</p>
                                        <div>
                                            FMDQ Exchange shall ensure the confidentiality of documents provided under clause 7.1 above and not to disclose its content except as required by any law, rule, regulation, order, and judgment of a competent court in Nigeria or for any other lawful purposeand shall notify the Member before such disclosure, where practicable, and where it is impracticable to notify the Member prior to such disclosure, provide written notice to the Member promptly after disclosure.
                                        </div>
                                    </div> <br>
                                </li><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">11</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
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
                                <li><strong>Fees</strong><br><br>
                                    <div class="dictionary">
                                        <p>8.1</p>
                                        <div>
                                            <strong>Membership Dues</strong><br><br>
                                            <p></p>
                                            <div>
                                                <p>8.1.1 The Member shall pay an annual membership due to FMDQ Exchange at a rate to be determined by FMDQ Exchange from time to time. </p><br>
                                                <p>8.1.2 The membership dues shall be payable immediately upon the execution of this Agreement and shall thereafter become payable on the first Business Day of January of each year. </p><br>
                                                <p>8.1.3 Notice of the revised membership dues shall be communicated to the Memberwithin seven (7) Business Days of such revision and in any case before the expiration of the subsisting membership dues. </p><br>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>8.2</p>
                                        <div>
                                            <strong></strong>
                                            <p></p>
                                            <div>
                                                <p>FMDQ Exchange shall issue an invoice to the Member for the membership dues. If the Member does not pay the membership dues within two (2) weeks of the date of issue of the invoice, the Member shall lose all rights and privileges on the FMDQ Exchange Platform. </p>
                                            </div>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>8.3</p>
                                        <div>
                                            <strong></strong>
                                            <p></p>
                                            <div>
                                                <p>Suspension or termination of the Member’s licence under the provisions of this Agreement shall not prevent FMDQ Exchange from proceeding against the Member for the recovery of all fees payable through all available legal means </p><br>
                                            </div>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Rules and Guidelines</strong><br><br>
                                    <p>The Member shall comply with the provisions of the FMDQ Exchange Rules and such other amendments thereto as may be made by FMDQ Exchange in its relationship with FMDQ Exchange, Dealing Members/or Brokers.</p>
                                </li><br>
                                <li><strong>Code of Conduct</strong><br><br>
                                    <p>The Member shall comply with the code of conduct set out below when obtaining quotes from Dealing Members/or Broker on the Platform in addition to the code of conduct as contained in the FMDQ Exchange Rules.</p><br>
                                    <div class="dictionary">
                                        <p>10.1</p>
                                        <div>
                                            <strong>General Duties of Integrity and Care</strong><br><br>
                                            <p>The Member shall: </p><br>
                                            <div>
                                                <p>10.1.1 refrain from any act or conduct which is likely to mar the reputation of FMDQ Exchange and the Market;</p><br>
                                                <p>10.1.2 behave in a responsible manner when using the Platform and associated facilities provided by FMDQ Exchange;</p><br>
                                                <p>10.1.3 only use the Platform and associated facilities when there is a legitimate need to do so;</p><br>
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
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-thirteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="12">
                                <strong></strong>
                                <p></p>
                                <div class="dictionary">
                                    <p></p>
                                    <div>
                                        <strong></strong>
                                        <p></p>
                                        <div class="ml-30">
                                            <p>10.1.4 when dealing with FMDQ Exchange, ensure that its Authorised Representatives act in an honest, open, truthful, cooperative manner and not mislead or conceal any material matter;</p><br>
                                            <p>10.1.5 provide full and prompt responses to all requests for information by FMDQ Exchange in respect of its activities on the Platform and provide access to all relevant books, records, audio logs and other forms of documentation in accordance with the provisions of any Applicable Law and/or regulation;</p><br>
                                            <p>10.1.6 take reasonable steps to ensure that its Authorised Representatives or any individual designated by it as responsible for its activities on the Platform are not under any legal obligation that restricts their ability to act for and on behalf of the Member.</p><br>
                                            <p>1.0.1.7 take reasonable steps to ensure that its Authorised Representatives or any other individual designated by it as responsible for its activities on the Platform are not under the influence of any prohibited drug or substance or under the influence of alcohol when carrying on any activity on the Platform; and</p><br>
                                            <p>10.1.8 take reasonable steps to prevent any form of gambling or betting between its officers, employees, representatives, agents or any other individual or body corporate so designated amongst themselves or with the officers, employees, representatives, agents of any other trader or any member of the general public in respect of any activity on the Platform</p><br>
                                        </div>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.2</p>
                                    <div>
                                        <strong>No Fraudulent or Misleading Conduct</strong><br><br>
                                        <p>In carrying on its activities on the Platform, the Member shall not engage in, or fail to take reasonable steps to prevent: </p><br>
                                        <div>
                                            <p>10.2.1 any action that has the effect, or may be expected to have the effect, of artificially and/or abnormally distorting the price or value of any Product;</p><br>
                                            <p>10.2.2 entering artificial transactions or otherwise entering into or causing any artificial transaction; </p><br>
                                            <p>10.2.3 any action or conduct that may mar the integrity of the Platform;</p><br>
                                            <p>10.2.4 activities prohibited by this Agreement or the FMDQ Exchange Rules or act in concert with, or provide any assistance to any individual or body corporate with a view to carrying out acts prohibited by this Agreement or the FMDQ Exchange Rules, or otherwise causing or contributing to a breach of any Applicable Law by such other individual or body corporate;</p><br>
                                        </div>
                                    </div>
                                </div> <br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">13</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-fourteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="12">
                                <div class="dictionary">
                                    <p></p>
                                    <div>
                                        <strong></strong>
                                        <p></p>
                                        <div class="ml-20">
                                            <p>10.2.5 its Authorised Representatives and other agents from effecting or causing to happen a fraud or deception in relation to any Product;</p><br>
                                            <p>10.2.6 its Authorised Representatives and other agents from participating in any Insider Trading in relation to a Security, or knowingly assist any other individual or body corporate to participate in any such Insider Trading;</p><br>
                                            <p>10.2.7 its Authorised Representatives and other agents from engaging in personal dealings, whether directly or indirectly, in Products, which the Member may have confidential information by virtue of being a capital markets participant; and</p><br>
                                            <p>10.2.8 fraudulent activities, whether directly or indirectly, through an Affiliate or otherwise make any untrue or misleading statement, or engage in any act, practice, or course of business which operates or would operate as a fraud or deceit upon any person, in connection with the purchase or sale of any Product.</p><br>
                                        </div>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.3</p>
                                    <div>
                                        <strong>Responsibility for Transactions</strong><br><br>
                                        <p></p>
                                        <div>
                                            <p>10.3.1 The Member agrees to be fully responsible for its activities on the Platform, whether or not such activity was duly approved by the Authorised Representatives of the Member.</p><br>
                                            <p>10.3.2 The Member agrees to provide necessary instructions to FMDQ Depository or any other body responsible for the settlement of transactions conducted on the Platform, to ensure that transactions conducted by Dealing Members/or Brokers on the Member’s instructions are settled promptly. </p><br>
                                        </div>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>10.4</p>
                                    <div>
                                        <strong>Authorised Representatives of the Member</strong><br><br>
                                        <p></p>
                                        <div>
                                            <p>10.4.1 The Member shall advise FMDQ Exchange of its Authorised Representatives and be responsible for the actions of its Authorised Representatives</p><br>
                                            <p>10.4.2 Persons designated to act as Authorised Representatives may be required to meet specified competency requirements as may be laid down by FMDQ Exchange from time to time. </p><br>
                                            <p>10.4.3 FMDQ Exchange may upon notice to the Member decline to recognise any Authorised Representative if upon investigation the Authorised Representatives is determined to have acted in an unethical manner or is found no longer fit and proper to act as an Authorised Representative for the purpose of the Member’s activities on the Platform. </p><br>
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
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-fifteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="11">
                                <div class="dictionary ml-20">
                                    <p></p>
                                    <div>
                                        <strong></strong>
                                        <p></p><br>
                                        <div>
                                            <p>10.4.4 The Member shall make adequate arrangements to ensure that all its Authorised Representatives are suitable, competent, knowledgeable, adequately trained and properly supervised.</p><br>
                                            <p>10.4.5 The Member shall ensure that its Authorised Representatives participate in and completes all trainings, inductions, and all other competency requirements as FMDQ Exchange may prescribe from time to time. </p><br>
                                            <p>10.4.6 The Member shall have the responsibility and duty to ascertain by investigation the good character, business repute, qualifications, and experience of its Authorised Representatives. </p><br>
                                            <p>10.4.7 The Member shall also be responsible for ensuring that training programmes are designed to enhance the knowledge and competence of its Authorised Representatives in the Member’s role as a Member. </p><br>
                                            <p>10.4.8 The Member shall ensure that its Authorised Representatives completes all relevant annual governance, risk management, compliance, AML/CFT/CPF, know-your-customer (KYC) and such other trainings, tests and certifications as may be required by FMDQ Exchange or any Applicable Law not less than once a year. </p><br>
                                            <p>10.4.9 The Member shall notify FMDQ Exchange in writing within seven (7) Business Days of any change to the list of Authorised Representatives in its employment, and bi-annually, that is, January and July of every year as part of its compliance reporting to FMDQ Exchange. </p><br>
                                        </div>
                                    </div>
                                </div> <br>
                                <li><strong>Degradation of Service</strong><br><br>
                                    <p>When using the System and associated facilities, the Member is prohibited from engaging in practices which may cause degradation of the service or give rise to a disorderly market. Such practices include, but are not limited to, submitting unwarranted or excessive electronic messages or requests-for-quotes to the System. </p><br>
                                </li>
                                <li><strong>Member’s Obligations</strong><br><br>
                                    <p>The Member hereby agrees on a continuing basis, to:</p><br>
                                    <div class="dictionary">
                                        <p>12.1</p>
                                        <div>
                                            <p>abide by the FMDQ Exchange Rules and any other agreement in force and as may be amended from time to time and notified to the Member by FMDQ Exchange;</p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>12.2</p>
                                        <div>
                                            <p>promptly pay the fees, dues and other applicable charges prescribed by FMDQ Exchange according to the conditions established by FMDQ Exchange and duly communicated to the Member;</p>
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
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-sixteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="13">
                                <div class="dictionary">
                                    <p>12.3</p>
                                    <div>
                                        subject to clause 6.1, authorise FMDQ Exchange or its duly appointed agents to carry out on-site examinations and investigations, during normal business hours, in any place of business of the Member or its Affiliate, and submit as soon as possible any information or document relating to this Agreement which FMDQ Exchange or its agents reasonably consider appropriate for the purposes of such examinations and investigations;
                                    </div>
                                </div><br>
                                <div class="dictionary">
                                    <p>12.4</p>
                                    <div>
                                        comply with the technical requirements of any relevant System and/or any other information technology system or network operated and advised by FMDQ Exchange;
                                    </div>
                                </div><br>
                                <div class="dictionary">
                                    <p>12.5</p>
                                    <div>
                                        notify FMDQ Exchange immediately in writing of any material changes to the information submitted during the course of the Member’s application, including in particular (but not limited to) those in respect of the Member's authorisation, licence or permission to request for quotes from Dealing Members/or Brokers;
                                    </div>
                                </div><br>
                                <div class="dictionary">
                                    <p>12.6</p>
                                    <div>
                                        notify FMDQ Exchange of any facts or circumstances which may affect the legal form or organisation of the Member or its activities on the Platform, including (but not limited to) any consolidation, reorganisation, merger, change of name, change of control or similar event to which the Member is or will become a party and provide such additional information as FMDQ Exchange may reasonably require;
                                    </div>
                                </div><br>
                                <div class="dictionary">
                                    <p>12.7</p>
                                    <div>
                                        immediately notify FMDQ Exchange as soon as it is served or becomes aware of any proceeding for bankruptcy, insolvency, winding up, administration or equivalent event (including amicable settlement) in any relevant jurisdiction which the Member is subject to or to which the Member is a Party;
                                    </div>
                                </div><br>
                                <div class="dictionary">
                                    <p>12.8</p>
                                    <div>
                                        notify FMDQ Exchange of any change in the composition of its Board of Directors within one month of such change;
                                    </div>
                                </div><br>
                                <div class="dictionary">
                                    <p>12.9</p>
                                    <div>ensure that any description of its membership or the services that it is able to provide, in the form and context in which it appears or is used, does not misrepresent the scope of the capacity which it enjoys as a Member on the Platform;</div>
                                </div><br>
                                <div class="dictionary">
                                    <p>12.10</p>
                                    <div>
                                        document, implement and maintain adequate internal procedures and controls in relation to the conduct of its activities on the Platform;</div>
                                </div><br>
                                <div class="dictionary">
                                    <p>12.11</p>
                                    <div>
                                        meet the corporate governance, risk management, compliance, AML/CFT/CPF, KYC, reporting and such other trainings, tests, certifications and standards as may be required by FMDQ Exchange or any Applicable Law not less than once a year;</div>
                                </div><br>
                                <div class="dictionary">
                                    <p>12.12</p>
                                    <div>
                                        ensure that documents, records, or any other material related to obtaining quotations and price discovery howsoever called are kept strictly confidential except as may be required by any law, rule, regulation, order or judgment of a competent court in Nigeria;</div>
                                </div><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">16</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-seventeen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="13">
                                <div class="dictionary">
                                    <p>12.3</p>
                                    <div>
                                        <p>keep and retain all recordings of phone conversations, text messages and e-mails, based on which any transaction on the Platform was conducted for a period to be advised by FMDQ Exchange and in accordance with FMDQ Exchange Rules and any other Applicable Law;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>12.4</p>
                                    <div>
                                        <p>promptly provide complete and accurate data and statistics relating to its activities as a Member which FMDQ Exchange may request from time to time;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>12.5</p>
                                    <div>
                                        <p>ensure that its Authorised Representatives have sufficient knowledge of the FMDQ Exchange Rules, this Agreement and other Applicable Laws regulating Products traded on the Platform; and</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>12.6</p>
                                    <div>
                                        <p>refrain from transferring or otherwise disposing of its licence (whether directly or indirectly) without the prior written consent of FMDQ Exchange.</p>
                                    </div>
                                </div> <br>
                                <li><strong>Internal Control</strong><br><br>
                                    <p></p>
                                    <div class="dictionary">
                                        <p>13.1</p>
                                        <div>
                                            <p>The Member hereby undertakes to comply with such minimum standards on internal control as may be reasonably prescribed and promptly communicated to the Member by FMDQ Exchange from time to time and shall ensure that its Authorised Representatives are regularly supervised while carrying out its activities on the Platform.</p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>13.2</p>
                                        <div>
                                            <p>The internal control process shall provide for written procedures to be established, maintained, and enforced, which procedures are designed to supervise the activities of the Authorised Representatives on the Platform.</p>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Trading Method</strong><br><br>
                                    <p>The Member shall not make commercial use of the published prices and any related information on the Platform in any manner whatsoever without the written approval of FMDQ Exchange, and such approval shall not be unreasonably withheld or unnecessarily delayed. </p><br>
                                </li>
                                <li><strong>Discipline of the Member</strong><br><br>
                                    <p></p><br>
                                    <div class="dictionary">
                                        <p>15.1</p>
                                        <div>
                                            <p>The Member hereby acknowledges that FMDQ Exchange shall following a formal warning and a declaration that the Member has been found guilty of any alleged infraction after a thorough investigation during which the Member will be given ample opportunity to defend itself, have the power to take disciplinary actions against it for any established violation of the FMDQ Exchange Rules or any provision of this Agreement. In particular, FMDQ Exchange shall have the power to impose any of the following penalties on the Member and may report the disciplinary action to appropriate regulatory authority:</p><br>
                                            <ol type="a">
                                                <li>fines;</li><br>
                                                <li>non-consideration for FMDQ GOLD Award;</li><br>
                                            </ol>
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
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-eighteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="16">
                                <p></p>
                                <div class="dictionary">
                                    <p></p>
                                    <div>
                                        <p></p>
                                        <ol type="a" start="3" class="ml-30">
                                            <li>suspension of membership on such terms and for such period as FMDQ Exchange may think fit;</li><br>
                                            <li>revocation of the Member’s licence; or</li><br>
                                            <li>Public and/or Private Censure.</li>
                                        </ol>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>15.2</p>
                                    <div>
                                        <p>The disciplinary powers referred to above may be exercised separately or concurrently. The exercise of such powers shall not prejudice any right that may be vested in FMDQ Exchange to seek legal redress against the Member in pursuance of enforcement of the disciplinary decision. </p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>15.3</p>
                                    <div>
                                        <p>Where the Member is expelled, it shall forthwith lose all rights on the Platform and such other rights conferred on it as a Member. </p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>15.4</p>
                                    <div>
                                        <p>Denial of access to the Member by FMDQ Exchange to some or all of the facilities of FMDQ Exchange through suspension, expulsion or such other disciplinary powers under the provisions of this Agreement shall not prevent FMDQ Exchange from proceeding against the Member through all available legal means. </p>
                                    </div>
                                </div> <br>
                                <li><strong>Termination of Membership</strong><br><br>
                                    <div class="dictionary">
                                        <p>16.1</p>
                                        <div>
                                            <p>The Member shall cease to be a member of FMDQ Exchange if:</p><br>
                                            <p>16.1.1 it gives FMDQ Exchange sixty (60) days’ notice in writing of its intention to terminate its membership. Such membership shall terminate at the expiration of the sixty (60) days’ notice; Notwithstanding the notice period in this sub-clause 16.1.1, FMDQ Exchange may terminate the membership (upon receipt of the notice in writing from the Member), within such shorter period as FMDQ Exchange deems fit, where the Member has no outstanding obligation(s).</p><br>
                                            <p>16.1.2 it is wound up voluntarily;</p><br>
                                            <p>16.1.3 it has become insolvent;</p><br>
                                            <p>16.1.4 it is compulsorily wound up by order of the Court;</p><br>
                                            <p>16.1.5 the Commission or relevant regulatory body has revoked its registration/licence;</p><br>
                                            <p>16.1.6 it is unable to meet or has defaulted in its obligations under this Agreement;</p><br>
                                            <p>16.1.7 upon investigation by FMDQ Exchange, it is proven that it has acted in an unprofessional and unethical manner in the Market; or </p><br>
                                            <p>16.1.8 any other reason as FMDQ Exchange may deem fit to terminate the licence of the Member. </p><br>
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
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-ninteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="17">
                                <div class="dictionary">
                                    <p>16.2</p>
                                    <div>
                                        <p>The Member hereby acknowledges that termination of its membership shall not prevent FMDQ Exchange from collecting any accrued fees, dues, fines or charges due or arising from this Agreement, the FMDQ Exchange Rules or any other agreement between FMDQ Exchange and the Member.</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>16.3</p>
                                    <div>
                                        <p>The Member hereby acknowledges that FMDQ Exchange reserves the right to apply to the Court to recover any fees, dues, fines or charges due or arising from this Agreement upon termination of its membership and/or take all necessary steps to protect any investor until such a time that all reported claims have been settled.</p>
                                    </div>
                                </div> <br>
                                <li><strong>Systems Security</strong><br><br>
                                    <div class="dictionary">
                                        <p>17.1</p>
                                        <div>
                                            <p>The Member hereby undertakes to ensure that the security of the Dealing Room is not compromised at any time. Accessto the Dealing Room and trading Systems shall only be to the Member’s authorised personnel. </p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>17.2</p>
                                        <div>
                                            <p>The Member hereby undertakes to ensure the security of the trading Systems. The Member shall be fully responsible for all its activities arising from access to the Systems through its access code.</p>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Access Right to Systems</strong><br><br>
                                    <div class="dictionary">
                                        <p>18.1</p>
                                        <div>
                                            <p>meeting the technical requirements reasonably determined and promptly communicated by FMDQ Exchange to the Member from time to time and acquiring the appropriate technical infrastructure required to gain access to the Platform; and </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>18.2</p>
                                        <div>
                                            <p>conforming and complying with any reasonable market access rules as may be prescribed and promptly communicated by FMDQ Exchange to the Member from time to time.</p><br>
                                        </div>
                                    </div>
                                </li>
                                <li><strong>Restrictions on Use of Trading Systems</strong><br><br>
                                    <div class="dictionary">
                                        <p>19.1</p>
                                        <div>
                                            <p>The Member hereby agrees that it shall not permit:</p><br>
                                            <p>19.1.3 the intrusion of any virus or malware into the Systems.</p><br>
                                            <p>19.1.2 the use of its access code, the Systems, or any software provided by FMDQ Exchange for any illegal purpose; or</p><br>
                                            <p>19.1.3 the intrusion of any virus or malware into the Systems.</p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>19.2</p>
                                        <div>
                                            <p>The Member shall be responsible for any illegal use of the Systems in its custody or the intrusion of any virus or malware caused by such use. </p><br>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">19</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="20">
                                <div class="dictionary">
                                    <p>19.3</p>
                                    <div>
                                        <p>The Member hereby acknowledges FMDQ Exchange’s right to immediately disconnect access to the Systems if it reasonably believes that the access code belonging to the Member has been compromised or is being used for any purpose other than as approved by FMDQ Exchange, provided that it shall promptly notify the Member of such decision prior to the disconnection and shall immediately reconnect the Member as soon as the reason for the disconnection no longer exists. </p><br>
                                    </div>
                                </div> <br>
                                <li><strong>Suspension of Trading</strong><br><br>
                                    <div class="dictionary">
                                        <p>20.1</p>
                                        <div>
                                            <p>The Member hereby acknowledges that FMDQ Exchange may in consent with, or upon instructions of other regulatory authorities decide to remove, reclassify or suspend trading in a Product on the Platform if:</p><br>
                                            <p>19.1.1 it believes that continuous trading will have an adverse effect on the Market; or</p><br>
                                            <p>19.1.2 a Force Majeure Event occurs.
                                            </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>20.2</p>
                                        <div>
                                            <p>Suspension of trading in any Product shall cease when the reasons for the suspension no longer exist and/or where the interests of a fair and orderly market are best served by resumption of trading. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>20.3</p>
                                        <div>
                                            <p>An announcement on FMDQ Exchange’s website shall be made by FMDQ Exchangeto give the Member notice of when trading in any Product is suspended and when such suspension is lifted. </p><br>
                                        </div>
                                    </div>
                                </li><br>
                                <li><strong>Confirmation of Instructions</strong><br><br>
                                    <p>The Member shall ensure that all instructions to a Dealing Member/or Broker for the purchase or sale of any Product are confirmed via any means to be agreed between the Member and the Dealing Member/or Broker, including but not limited to SWIFT and letter within twenty-four(24) hours of the instruction. The confirmation shall contain in the minimum the following details:</p><br>
                                    <div class="dictionary">
                                        <p></p>
                                        <div>
                                            <p></p>
                                            <ol type="a">
                                                <li>the transaction value and date;</li><br>
                                                <li>the description, tenor (where applicable) and the price; </li><br>
                                                <li>the transaction and settlement amounts; and</li><br>
                                                <li>any other details as may be advised by FMDQ Exchange from time to time.</li><br>
                                            </ol>
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
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-one">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="22">
                                <li><strong>Prohibition of Transactions with Suspended Members</strong><br><br>
                                    <p>The Member shall not trade with any Member whose membership rights have been suspended or revoked except as expressly approved in writing by FMDQ Exchange.</p><br>
                                </li>
                                <li><strong>Confidentiality and Data Protection</strong><br><br>
                                    <div class="dictionary">
                                        <p>23.1</p>
                                        <div>
                                            <p>The Parties shall treat as strictly confidential all Confidential Information and shall ensure that their respective authorised employees use the Confidential Information only for the performance of their obligations and the exercise of their rights under this Agreement. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>23.2</p>
                                        <div>
                                            <p>Each Party shall protect and adequately secure every data belonging to the other Party and shall prevent against the theft or disclosure of such data by its Affiliates, Directors, employees, subcontractors, agents, or any other individual or body corporate having access to the data through it. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>23.3</p>
                                        <div>
                                            <p>In the event that a Party learns of any theft, unauthorised use, disclosure, or threatened unauthorised use or disclosure of any Confidential Information, the Party shall notify the other Party of the particulars of such theft, unauthorised use or disclosure. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>23.4</p>
                                        <div>
                                            <p>The Parties undertake and agree to comply with the provisions of the Nigeria Data Protection Regulation, 2019 issued by the National Information Technology Development Agency and any amendments thereto in respect of any Personal Data received pursuant to or in connection with this Agreement. </p><br>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Limitation of Liability</strong><br><br>
                                    <div class="dictionary">
                                        <p>24.1</p>
                                        <div>
                                            <p>The Parties hereby acknowledge that each Party shall have no liability or obligation to the other, without limitation for: </p><br>
                                            <p>24.1.1 the inability to use its trading Systems as a result of Market Disruptions not due to negligence on its part;</p><br>
                                            <p>24.1.2 occurrences that could not have been reasonably foreseen at the date of execution of this Agreement; and includes a Force Majeure Event;</p><br>
                                            <p>24.1.3 any loss or damage which may be suffered or which may arise directly or indirectly as a result of activities in the Market not caused by FMDQ Exchange, its staff and agents; </p><br>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">21</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-two">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="25">
                                <div class="ml-60">
                                    <p>24.1.4 any act, error, failure, or omission on the part of FMDQ Exchange, acting reasonably including any loss or damage in respect of: <br><br>
                                        <div class="ml-40">
                                            <p>24.1.4.1 the suspension, cancellation, interruption, or closure of the Market in compliance with directives or orders from any regulatory body in Nigeria; or</p><br>
                                            <p>24.1.4.2 any inoperability of non-proprietary software or other equipment supplied to the Member and by third parties;</p><br>
                                        </div>
                                    </p><br>
                                    <p>24.1.5 the originality, accuracy or completeness of any information or market data provided by a third-party; </p><br>
                                    <p>24.1.6 FMDQ Exchange’s decision to suspend or terminate the membership of the Member provided such suspension or termination is in compliance with the provisions of this Agreement, the FMDQ Exchange Rules, SEC Rules, the ISA, CBN circulars or DMO guidelines; and </p><br>
                                    <p>24.1.7 any decision of FMDQ Exchange in the exercise of its powers; provided that such powers are specifically established under this Agreement </p><br>
                                </div>
                                <li><strong>Indemnity</strong><br><br>
                                    <div class="dictionary">
                                        <p>25.1</p>
                                        <div>
                                            <p>The Member hereby undertakes to indemnify FMDQ Exchange against any claim or loss directly arising from its wrongful, negligent or illegal activities on the Platform done in contravention of any provision of this Agreement or the FMDQ Exchange Rules. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>25.2</p>
                                        <div>
                                            <p>FMDQ Exchange hereby undertakes to indemnify the Member against any claim or loss arising from its violation of the terms of this Agreement. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>25.3</p>
                                        <div>
                                            <p>The indemnity obligations in this clause shall only operate during the pendency of this Agreement. </p><br>
                                        </div>
                                    </div>
                                </li>
                                <li><strong>Notices</strong><br><br>
                                    <p></p>
                                    <div class="dictionary">
                                        <p>26.1</p>
                                        <div>
                                            <p>Any notice, request or other communication to be given or made under this Agreement shall be in writing. Any such communication shall be delivered by hand, airmail, established courier service, e-mail or facsimile to the Party to which it is required or permitted to be given or made at such Party’s address specified below or at such other address as such Party has from time to time designated by written notice to the other Party hereto, and shall be effective upon the earlier of (a) actual receipt and (b) deemed receipt under clause 26.2 below. </p><br>
                                            If to FMDQ Exchange: <br><br>
                                            <strong>Member Regulation Group</strong><br>
                                            FMDQ Securities Exchange Limited <br>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">22</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-three">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="27">
                                <p></p>
                                <div class="dictionary">
                                    <p></p>
                                    <div class="ml-30">
                                        <p></p>
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
                                    <p>26.2</p>
                                    <div>
                                        <p>Any notice given as aforesaid shall be deemed to have been served when received and shall be deemed to have been received (a) in the case of delivery by hand or courier, when delivered as evidenced by a receipt from the addressee; or (b) in the case of e-mail or facsimile, upon receipt by the sending party of electronic confirmation of receipt by the intended recipient. </p><br>
                                    </div>
                                </div>
                                <div class="dictionary">
                                    <p>26.3</p>
                                    <div>
                                        <p>All documents to be provided or communications to be given or made under this Agreement shall be in English and, where the original version of any such document or communication is not in English, shall be accompanied by an English translation certified to be a true and correct translation of the original. </p><br>
                                    </div>
                                </div>
                                <div class="dictionary">
                                    <p>26.4</p>
                                    <div>
                                        <p>In addition to clause 26.1 above, FMDQ Exchange may convey notices other via electronic broadcasts and/or via the regulatory update segment on the FMDQ Exchange website. </p><br>
                                    </div>
                                </div>
                                <li><strong>Binding Agreement</strong><br><br>
                                    <p>Notwithstanding any contrary agreement, both Parties agrees that this Agreement constitutes a legal, valid and binding agreement which shall be enforceable against it in accordance with its terms.</p><br>
                                </li>
                                <li><strong>Non-Waiver</strong><br><br>
                                    <p>No failure or delay by FMDQ Exchange to exercise any right, power or privilege hereunder shall operate as a waiver thereof nor shall any single or partial exercise of any right, power or privilege preclude any other or further exercise thereof, or the exercise of any other rights, power or privilege as herein provided.</p><br>
                                </li>
                                <li><strong>Severability</strong><br><br>
                                    <p>If any provision of this Agreement is declared by any judicial or other competent authority to be void or otherwise unenforceable, that provision shall be severed from this Agreement and the remaining provisions shall remain in force and effect. Provided that the Parties shall thereafter amend this Agreement in such reasonable manner so as to achieve, without illegality, the intention of the Parties, with respect to the severed provision.</p><br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">23</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-five">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="30">
                                <li><strong>Governing Law</strong><br><br>
                                    <p>Notwithstanding any other agreement to the contrary, this Agreement and all amendments there to shall be governed by and construed in accordance with Nigerian law.</p><br>
                                </li>
                                <li><strong>Dispute Resolution</strong><br><br>
                                    <div class="dictionary">
                                        <p>31.1</p>
                                        <div class="">
                                            In the event of any dispute arising out of or under this Agreement, the Parties shall within five (5) Business Days from the date the dispute arose, engage in an amicable settlement of the dispute by mutual negotiation
                                        </div>
                                    </div><br>
                                    <div class="dictionary">
                                        <p>31.2</p>
                                        <div class="">
                                            Where the dispute is not resolved by mutual negotiation, the Parties shall in compliance with the provisions of the ISA, refer the matter to the Investment and Securities Tribunal for resolution.
                                        </div>
                                    </div><br>
                                </li>
                                <li><strong>Amendment</strong><br><br>
                                    <p>The terms of this Agreement may be amended or varied by FMDQ Exchange from time to time by giving one (1) month calendar notice to the Member informing it of such amendment or variation. </p><br>
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
                <div class="pageNo" style="text-align: center;">24</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
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
                                        <div style="text-align: center;"><strong>Authorised Signatory</strong></div>
                                    </div>
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                        <div style="text-align: center;"><strong>Authorised Signatory</strong></div>
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
                                        <div style="text-align: center;"><strong>Authorised Signatory</strong></div>
                                    </div>
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                        <div style="text-align: center;"><strong>Authorised Signatory</strong></div>
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
                <div class="pageNo" style="text-align: center;">25</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreement for Associate Member (Clients) </div>
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
