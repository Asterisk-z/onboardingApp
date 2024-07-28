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
                            <p>{{ $details->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="pageNo-DocName" style="margin-top: 95px;">
            <div class="pageNo" style="text-align: center;">1</div>
            <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
        </div>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-two">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content table-of-content">
                            <p>Table of Contents</p>
                            <div style="width: 100%; font-size: 15px;">
                                <ol style="margin-left: 20px;">
                                    <li>
                                        <div class="toc-item">Definitions and Interpretation
                                            <span>...................................................................................................................</span>3
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Market Standards
                                            <span>........................................................................................................................................</span>9
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Non-Agency Relationship
                                            <span>............................................................................................................................</span>9
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Disclosure Requirements
                                            <span>............................................................................................................................</span>9
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Anti-Money Laundering
                                            <span>.............................................................................................................................</span>10
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Examination of Documents
                                            <span>........................................................................................................................</span>11
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">
                                            Fees<span>............................................................................................................................................................</span>11
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Rules and Guidelines
                                            <span>..................................................................................................................................</span>11
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Code of Conduct
                                            <span>........................................................................................................................................</span>11
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Member's
                                            Obligations<span>...............................................................................................................................</span>14
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Discipline of the Member
                                            <span>..........................................................................................................................</span>15
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Termination of Membership
                                            <span>.....................................................................................................................</span>16
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Suspension of Trading
                                            <span>...............................................................................................................................</span>16
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Reporting Requirements
                                            <span>............................................................................................................................</span>17
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Willingness to Promote FMDQ Exchange
                                            <span>..................................................................................................</span>17
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Confidentiality<span>..........................................................................................................................................</span>17
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Limitation of Liability
                                            <span>................................................................................................................................</span>17
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Indemnity
                                            <span>..................................................................................................................................................</span>18
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Notices
                                            <span>.....................................................................................................................................................</span>18
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Binding Agreement
                                            <span>..................................................................................................................................</span>19
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Non-Waiver
                                            <span>..............................................................................................................................................</span>19
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Severability
                                            <span>..............................................................................................................................................</span>19
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Governing Law
                                            <span>.........................................................................................................................................</span>20
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Dispute Resolution
                                            <span>...................................................................................................................................</span>20
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Amendment
                                            <span>..............................................................................................................................................</span>20
                                        </div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Execution
                                            <span>...................................................................................................................................................</span>20
                                        </div>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">2</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-three">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <p><strong>THIS MEMBERSHIP AGREEMENT</strong> is made the <span class="user-iput uOn">______________</span>day of<span class="user-inpu uOn">____________</span>20___</p><br>
                            <p>BETWEEN:</p><br>
                            <p><strong>FMDQ SECURITIES EXCHANGE LIMITED (RC. NO. 1617162)</strong>, a company
                                incorporated under the laws of the Federal Republic of Nigeria with its principal place
                                of business at Exchange Place, 35, Idowu Taylor Street, Victoria Island, Lagos,
                                (hereinafter called <strong>“FMDQ Exchange”</strong> which expressionshall where the
                                context so admits shall include its successors and assigns) of the first part.</p><br>
                            <p>AND</p><br>
                            <p>{{ $details->name }} (RC NO. {{ $details->rc_number }}), a company incorporated under the laws of the
                                Federal Republic of Nigeria with its registered office at {{ $details->address }}
                                (the “Member” which expression shall where the context so admits shall include its
                                successors and assigns) of the second part.</p><br>
                            <p>In this Agreement, FMDQ Exchange and the Member shall individually be referred to as a
                                “Party” and collectively be referred to as the “Parties”.</p><br>
                            <p><strong>WHEREAS</strong></p><br>
                            <ol type="A" style="margin-left: 20px;">
                                <li>FMDQ Exchange is licenced by the Securities and Exchange Commission as a securities
                                    exchange and self-regulatory organisation with a Platform (as defined below) to
                                    enable its Members deal in Securities (as defined below) and carry out other
                                    activities.</li><br>
                                <li>The Member is a financial institution registered with the SEC and has indicated
                                    interest in becoming a Member (as defined below) of FMDQ Exchange with a view to
                                    offering brokerage services between Dealing Members or Dealing Members and Clients
                                    on the Platform.</li><br>
                                <li>The Member has agreed to be duly licenced by FMDQ Exchange as an Associate Member
                                    (Inter-Dealer Broker).</li><br>
                                <li>Pursuant to the foregoing, the Parties hereby agree to be bound by the terms herein
                                    contained.</li>
                            </ol><br>
                            <p><strong>IT IS HEREBY AGREED AND DECLARED as follows: -</strong></p><br>
                            <ol style="margin-left: 20px;">
                                <li><strong>Definitions and Interpretation</strong><br><br>
                                    <div class="dictionary">
                                        <p>1.1</p>
                                        <div>
                                            <strong> Definitions</strong>
                                            <br><br>
                                            <p>In this Agreement, unless the context otherwise requires, the following
                                                expressions shall have the meanings set out hereunder: -</p><br>
                                            <div class="sub-dictionary">
                                                <p class="term"><strong>“Act or ISA”</strong></p>
                                                <p class="definition">means the Investments and Securities Act, 2007 as
                                                    may be amended or supplemented from time to time;</p>
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
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
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
                                        <p class="definition">means an individual or body corporate that directly or
                                            indirectly controls, is controlled by, or is under common control with, the
                                            individual or body corporate specified. For the purpose of this definition,
                                            the terms "controlled by" and "controls" mean the possession, directly or
                                            indirectly, of the power to direct the management or policies of an
                                            individual or body corporate, whether through the ownership of shares, by
                                            contract, or otherwise;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Agreement”</strong></p>
                                        <p class="definition">means this Membership Agreement as may be amended or
                                            supplemented from time to time;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Applicable Law”</strong></p>
                                        <p class="definition">means any law for the time being in force in Nigeria
                                            (including statutory and common law), statute, constitution, judgment,
                                            treaty, regulation, rule, by-law, order, decree, code of practice, circular,
                                            directive, other legislative measure, guidelines, guidance note,
                                            requirement, request or guideline or injunction (whether or not having force
                                            of law and, to the extent not having force of law, is generally complied
                                            with by persons to whom it is addressed or applied) of or made by any
                                            governmental authority, which is binding and enforceable;</p>
                                    </div><br>

                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Business Day”</strong></p>
                                        <p class="definition">means a day (other than a Saturday, Sunday or Federal
                                            Government of Nigeria declared public holiday) on which banks are open for
                                            general business in Nigeria;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“CAMA”</strong></p>
                                        <p class="definition">means the Companies and Allied Matters Act, 2020, as may
                                            be amended or supplemented from time to time;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“CBN”</strong></p>
                                        <p class="definition">means the Central Bank of Nigeria;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Client”</strong></p>
                                        <p class="definition">means a body corporate admitted to participate in activities as an end-user of products traded on the FMDQ Exchange platform;</p>
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
                                        <p class="definition">means any information, communication or data, about any of
                                            the Parties or their respective affairs or business in any form, whether
                                            oral, written, graphic, or electromagnetic, including all plans, proposals,
                                            forecasts, technical processes, methodologies, know-how, information about
                                            technological or organisational systems, customers, personnel, business
                                            activities, marketing, financial </p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">4</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
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
                                        <p class="definition">research or development activities, databases, Intellectual Property Rights, the terms and conditions of this Agreement and other information in relation to it, whether or not it is specifically marked confidential but excluding any information, which:
                                        </p>
                                    </div><br><br>
                                    <div style="display: flex;justify-content: flex-end;">
                                        <ol type="i" style="width: 400px;">
                                            <li>was already known to the Recipient at the time of its disclosure to the
                                                Recipient and is not subject to confidentiality restrictions;</li><br>
                                            <li>is in the public domain at the date of its disclosure to the Recipient
                                                or thereafter enters the public domain through no fault of the Recipient
                                                (but only after it becomes part of the public domain); or</li><br>
                                            <li>is independently developed by the Recipient without use or reference to
                                                the Disclosing Party’s confidential information, as shown by documents
                                                and other competent evidence in the receiving Party’s possession; or
                                            </li><br>
                                            <li>is required by law or regulation to be disclosed by the Recipient,
                                                provided that the Recipient, where it isreasonable in the
                                                circumstances,shall promptly give the Disclosing Party written notice of
                                                such requirement prior to any disclosure so that the Disclosing Party
                                                may seek a protective order or other appropriate relief</li><br>
                                        </ol>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Court”</strong></p>
                                        <p class="definition">means any court of competent jurisdiction;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Dealing Member”</strong></p>
                                        <p class="definition">means any financial institution which has been admitted to
                                            trade Products on the Platform;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Disclosing Party”</strong></p>
                                        <p class="definition">means the Party disclosing an item of Confidential
                                            Information;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“DMO”</strong></p>
                                        <p class="definition">means the Debt Management Office of the Federal Republic
                                            of Nigeria;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term" style="padding-right: 30px;"><strong>“FMDQ Exchange Fees
                                                & Dues Framework” </strong></p>
                                        <p class="definition">means the framework as advised to the Members containing
                                            all relevant and applicable fees and dues (including Membership Dues) as may
                                            be updated from time to time;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“FMDQ GOLD
                                                Award”</strong></p>
                                        <p class="definition">means a recognition of exceptional performance on the
                                            securities exchange, exemplary compliance with the FMDQ Exchange Rules and
                                            contribution to the Nigerian financial markets;</p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">5</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
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
                                        <p class="term"><strong>“FMDQ Exchange Rules” </strong></p>
                                        <p class="definition">means rules, circulars, bulletins, guidelines and other
                                            regulation designed by FMDQ Exchange (and where required, approved by the
                                            SEC, CBN or DMO, as the case may be) and advised to the Members to govern
                                            activities on the Platform, as may be supplemented and amended from time to
                                            time</p>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>Force Majeure Event</strong></p>
                                        <p class="definition">means the occurrence of an event which materially
                                            interferes with the ability of a Party to perform its obligations or
                                            duties hereunder which is not within the reasonable control of the Party
                                            affected or any of its Affiliates, and which could not with the exercise of
                                            diligent efforts have been avoided, including, but not limited to, war
                                            (whether or not declared), rebellion, earthquake, fire, explosions,
                                            accident, strike, lockouts or other labour disturbances, riot, civil
                                            commotion, act of God, epidemics, pandemics, national emergencies, work
                                            stoppages, state or federal lockdowns, orders and laws of governmental
                                            authorities (both federal and state), change in Law or any act of God or
                                            other cause beyond the control of the Parties;</p>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Intellectual Property Rights” </strong></p>
                                        <p class="definition">includes any patent, copyright, trademark, trade name,
                                            trade secret, brand name, logo, corporate name, internet domain name or
                                            industrial design, any registrations thereof and pending applications
                                            therefor, any other intellectual property right (including, without
                                            limitation, any know-how, trade secret, trade right, formula, conditional or
                                            proprietary report or information, customer or membership list, any
                                            marketing data, and any computer program, software, database or data right),
                                            and license or other contract relating to any of the foregoing, and any
                                            goodwill associated with any business owning, holding or using any of the
                                            foregoing;</p>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Insider Trading”</strong></p>
                                        <p class="definition">means trading done by an individual or body corporate or
                                            group of individuals or bodies corporate who being in possession of some
                                            confidential and price sensitive information not made available to the
                                            public, utilises such information to buy or sell Securities for the benefit
                                            of themselves or any other individual or body corporate;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Market” </strong></p>
                                        <p class="definition">means the market for Products tradable or traded on the
                                            FMDQ Platform; </p>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>"Market Disruption"</strong></p>
                                        <p class="definition">means any event which makes it impossible or impracticable to conduct trades on the Platform, which disruption may or may not be of a technical orSystems- related nature, and is not caused by, or within the control of, any of the Parties;</p>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>"Member"</strong></p>
                                        <p class="definition">means an Associate Member (Inter-Dealer Broker), which is
                                            an institution that facilitates brokerage services amongst FMDQ Exchange’s
                                            Dealing Members, and between FMDQ Exchange’s Dealing Members and other
                                            financial institutions including but not limited to pension fund
                                            administrators, fund managers and insurance </p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">6</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
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
                                        <p class="term"><strong></strong></p>
                                        <p class="definition">companies. These institutions are registered by the Securities and Exchange Commission as inter-dealer brokers, and are authorised by FMDQ Exchange to provide their services on the FMDQ Exchange platform;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“National Assembly”</strong></p>
                                        <p class="definition">means the National Assembly of the Federal Republic of Nigeria;</p>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Platform”</strong></p>
                                        <p class="definition">means the FMDQ Exchange-organised marketplace for listing,
                                            registration, quotation, order execution, and trade reporting;</p>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Product”</strong></p>
                                        <p class="definition">means any instrument, security, currency, or other
                                            contract admitted by FMDQ Exchange for trading on the Platform, Products
                                            shall be construed accordingly;</p>
                                    </div>
                                    <!-- <div class="sub-dictionary ">
                                        <p class="term"><strong>“Private Censure”</strong></p>
                                        <p class="definition">means a private disciplinary action that constitutes a
                                            formal expression of disapproval of a Member by FMDQ Exchange. It includes
                                            but is not limited to warning or infractions letters issued to the Member;
                                        </p>
                                    </div> -->
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Public Censure”</strong></p>
                                        <p class="definition">means a public disciplinary action that constitutes a
                                            formal expression of disapproval of a Member by FMDQ Exchange. It includes
                                            but is not limited to newspaper publications and postings on the FMDQ
                                            Exchange website;</p>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Recipient”</strong></p>
                                        <p class="definition">means the Party receiving an item of Confidential
                                            Information;</p>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Securities Exchange”</strong></p>
                                        <p class="definition">has the meaning assigned to it in the ISA;</p>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“SEC Rules” </strong></p>
                                        <p class="definition">means the rules and regulations of the Commission issued
                                            pursuant to the ISA as may be amended and supplemented from time to time;
                                        </p>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Settlement Guarantee Fund” </strong></p>
                                        <p class="definition">means a fund administered by FMDQ Exchange for the purpose of ensuring the performance of obligations arising from transactions conducted on the Platform;
                                        </p>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Sponsored Individual” </strong></p>
                                        <p class="definition">means a representative of a Member who is duly accredited by an institution recognised by FMDQ Exchange to carry out any relevant financial market related functions on behalf of the Member;
                                        </p>
                                    </div>

                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“System”</strong></p>
                                        <p class="definition">means an electronic trading programme that allows Members
                                            to submit trade-related data and fulfil contractual obligations leading up
                                            to the clearing and settlement of executed trades. Systems used on the FMDQ
                                            Exchange Platform include (but are not limited to) Bloomberg E-bond Trading
                                            System, Refinitiv Trading System, FMDQ OTC FX Futures Trading & Reporting
                                            System. Trading systems may be different from the clearing and settlement
                                            systems.</p>
                                    </div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Year”</strong></p>
                                        <p class="definition">means a calendar year</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">7</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
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
                                <div><b>1.2 <span style="margin-left: 15px;">Interpretation</span></b><br><br>
                                    <!-- <p>1.2</p> -->
                                    <p style="margin-left: 40px;"><b>In this Agreement:</b></p><br>
                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">1.2.1</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                Words importing the singular number only shall include the plural and
                                                vice-versa and words importing the feminine gender only shall include
                                                the
                                                masculine gender and vice versa and words importing persons shall
                                                include
                                                corporations, associations, partnerships and governments (whether state
                                                or
                                                local), and the words “written” or “in writing” shall include printing,
                                                engraving, lithography or other means of visible reproduction.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">1.2.2</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The words “hereof,” “herein,” “hereby,” “hereto” and similar words refer
                                                to
                                                this entire Agreement and not any particular Clause, Schedule or other
                                                subdivision of this Agreement.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">1.2.3</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                A reference to “Party” or “Parties” shall mean a party or parties to
                                                this
                                                Agreement.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">1.2.4</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                A reference to a statutory provision shall be deemed to include that
                                                provision as the same may from time to time be modified, amended or
                                                re-enacted.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">1.2.5</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                Any reference to Clauses and Schedules, are to Clauses and Schedules of
                                                this
                                                Agreement, and references to sub-clauses and paragraphs are references
                                                to
                                                sub-clauses and paragraphs of the clause or schedule in which they
                                                appear.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">1.2.6</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                A reference to a provision of this Agreement is to that provision as
                                                amended
                                                in accordance with the terms of this Agreement.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">1.2.7</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                A reference to “consent” means any consent, approval, authorisation,
                                                licence
                                                or clearance of any kind whether fiscal, statutory or regulatory.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">1.2.8</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                A reference to any document being “in the agreed form” means in a form
                                                which
                                                has been agreed by the Parties on or before the date of this Agreement
                                                and
                                                for identification purposes signed by them or on their behalf by their
                                                Authorised Signatories.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">1.2.9</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                References to days shall refer to calendar days unless Business Days are
                                                specified; references to weeks, months or years shall be to calendar
                                                weeks,
                                                months or years respectively.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">1.2.10</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                References to any liability shall include actual, contingent, present or
                                                future liabilities.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">1.2.11</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                Words and expressions defined in any clause shall, unless the
                                                application of
                                                any such word or expression is specifically limited to that clause, bear
                                                the
                                                meaning assigned to such word or expression throughout this Agreement
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">1.2.12</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The expiration or termination of this Agreement shall not affect the
                                                provisions of this Agreement which are expressly indicated to survive
                                                the
                                                expiration or termination or which of necessity must continue to have
                                                effect
                                                after such expiration or termination either expressly or impliedly.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">1.2.13</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                Where figures are referred to in numerals and in words, and there is any
                                                conflict between the two, the words shall prevail, unless the context
                                                indicates a contrary intention.
                                            </p>
                                        </div>

                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">8</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
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
                                    <div style="display: flex; margin-bottom: 20px;">
                                        <p style="width: 10%;">1.2.14</p>
                                        <p style="width: 90%; margin-top: 0;">
                                            Defined terms appearing in this Agreement in upper case shall be given
                                            their meaning as defined, while the same terms appearing in lower case
                                            shall be interpreted in accordance with their plain English meaning.
                                        </p>
                                    </div>
                                    <div style="display: flex; margin-bottom: 20px;">
                                        <p style="width: 10%;">1.2.15</p>
                                        <p style="width: 90%; margin-top: 0;">
                                            Words and phrases used in this Agreement, unless otherwise defined in this
                                            Agreement, shall have the meanings given to them in the FMDQ Exchange Rules,
                                            SEC Rules, CBN circulars, DMO guidelines, the ISA and any other legislative
                                            enactment.
                                        </p>
                                    </div>
                                    <div style="display: flex; margin-bottom: 20px;">
                                        <p style="width: 10%;">1.2.16</p>
                                        <p style="width: 90%; margin-top: 0;">
                                            A reference to FMDQ Exchange or the Member herein shall include reference to
                                            their respective successors and assigns.
                                        </p>
                                    </div>
                                    <div style="display: flex; margin-bottom: 20px;">
                                        <p style="width: 10%;">1.2.17</p>
                                        <p style="width: 90%; margin-top: 0;">
                                            The division of this Agreement into clauses and sub-clauses, the provision
                                            of a table of contents and the insertion of headings are for convenience of
                                            reference only and shall not be deemed to form part of the text or affect
                                            the construction or interpretation hereof.
                                        </p>
                                    </div>
                                    <div style="display: flex; margin-bottom: 20px;">
                                        <p style="width: 10%;">1.2.18</p>
                                        <p style="width: 90%; margin-top: 0;">
                                            Any money payable under this Agreement on a day that falls on a public
                                            holiday shall be paid on the next Business Day.
                                        </p>
                                    </div>

                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>2 <span style="margin-left: 27px;">Market Standards</span></b><br><br>
                                    <!-- <p>1.2</p> -->
                                    <p style="margin-left: 40px;"><b>The Member shall:</b></p><br>
                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">2.1</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                use its best endeavours to maintain such market standards as may be
                                                determined and communicated to the Member by FMDQ Exchange from time to
                                                time in its dealings with Dealing Members and Clients;
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">2.2</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                comply with the minimum standards on risk management and compliance
                                                prescribed and communicated to the Member from time to time by FMDQ
                                                Exchange;
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">2.3</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                establish a robust risk management and compliance function which shall
                                                be responsible for identifying, measuring, monitoring and reporting any
                                                risks that the Member may be exposed to; and
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">2.4</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                maintain a proper structure that ensures the efficiency of its risk
                                                management and compliance function.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>3 <span style="margin-left: 27px;">Non-Agency Relationship</span></b><br><br>
                                    <!-- <p>1.2</p> -->
                                    <p style="margin-left: 40px;">The Member or its Authorised Representatives shall not
                                        hold itself out to any individual or body corporate as being an agent of or
                                        otherwise representing or having the power in any way to act for or bind FMDQ
                                        Exchange unless expressly authorised in writing.</p><br>

                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>4 <span style="margin-left: 27px;">Disclosure Requirements</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex">
                                            <p style="width: 10%;">4.1</p>
                                            <p style="width: 90%; margin-top: 0">The Member hereby undertakes to:</p>
                                        </div><br>
                                        <div style="margin-left: 64px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">4.1.1</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    disclose in writing to FMDQ Exchange its membership of any other
                                                    Securities Exchange or at the time of the execution of this
                                                    Agreement;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">4.1.2</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    disclose to FMDQ Exchange in writing, not later than one (1)
                                                    calendar month from when it becomes a Member of any other Securities
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">9</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-ten">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 20px;">
                                <div>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="margin-left: 64px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;"></p>
                                                <p style="width: 90%; margin-top: 0;"> Exchange after the execution of this Agreement, specifying the name and principal place of business of the other Securities Exchange, the date it was registered as a member of the Securities Exchange, the duration of its membership, and such additional or other information as may be required by FMDQ Exchange;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">4.1.3</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    disclose to FMDQ Exchange not later than one (1) calendar month
                                                    after the execution of this Agreement the particulars of its
                                                    management personnel and director(s) who are responsible for
                                                    overseeing its financial markets function; provided that where any
                                                    change is made in respect of the aforementioned persons, it will not
                                                    later than one (1) calendar month thereafter inform FMDQ Exchange of
                                                    such change;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">4.1.4</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    disclose any information regarding any Product that it believes may
                                                    abnormally affect the Market to FMDQ Exchange within twenty-four
                                                    (24) hours of being aware of the information;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">4.1.5</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    disclose any investigation, sanction, enforcement proceeding or
                                                    injunction against it in respect of any matter related to this
                                                    Agreement, or any other membership agreements executed with any
                                                    securities exchange, self-regulatory organisation, regulatory
                                                    authority or such other body that may adversely affect the
                                                    performance of its obligations herein to FMDQ Exchange within
                                                    twenty-four (24) hours of being aware of the investigation,
                                                    sanction, enforcement proceeding or injunction;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">4.1.6</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    disclose any event which may impair its ability to comply with this
                                                    Agreement or any of the FMDQ Exchange Rules to FMDQ Exchange within
                                                    twenty-four (24) hours of being aware of the event;
                                                </p>
                                            </div>

                                        </div>
                                        <div style="margin-left: 0px;">

                                            <div style="margin-left: 0px;">
                                                <div style="display: flex">
                                                    <p style="width: 10%;">4.2</p>
                                                    <p style="width: 90%; margin-top: 0">For the purpose of this
                                                        clause, “disclose” means to alert, make known or reveal any
                                                        of the event mentioned in clause 4.1 to FMDQ Exchange. FMDQ
                                                        Exchange however reserves the right to demand more
                                                        information should the need arise.</p>
                                                </div><br>

                                            </div>
                                        </div>
                                    </div>
                                    <div><b>5 <span style="margin-left: 27px;">Anti-Money Laundering</span></b><br><br>
                                        <div style="margin-left: 40px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">5.1</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The Member covenants and represents that at all times during the subsistence of this Agreement, it shall comply with all applicable laws and policies on money laundering and shall establish/maintain a robust and comprehensive anti-money laundering/counter-terrorism financing framework.
                                                </p>
                                            </div>

                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">5.2</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The Member undertakes to keep all records and documentation pertaining to any anti-money laundering and counter-terrorism financing due diligence procedures relating to its activities on the Platform for such period as required by FMDQ Exchange or by Applicable Law.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">5.3</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    Subject to any Applicable Law prohibiting disclosure, if FMDQ Exchange is required by the regulatory authorities, to satisfy itself or such authorities as to the facts of any transaction or activities of the Member on the Platform or FMDQ Exchange suspects any form of money laundering or terrorism financing, or at any time pursuant to FMDQ Exchange’s request, the Member must immediately provide copies of all due diligence materials relating to such transaction or activities to FMDQ Exchange and/or all relevant regulatory authorities. In such circumstances, the Member must also provide a translation and certification of such documents if so requested by FMDQ Exchange.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">5.4</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    If the Member delegates, assigns, subcontracts or transfers any of its rights or obligations under this Agreement to another party, the Member shall ensure that such party complies with the requirements set out in this Agreement, FMDQ Exchange Rules and Applicable Law.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">5.5</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The Member will ensure that none of its subsidiaries or affiliates will, fund all or part of any payment under any transaction out of proceeds derived from any unlawful activity which would result in any violation of any anti-money laundering or counter-terrorism financing legislation in force in Nigeria (as may be amended) and regulations thereunder or any other Applicable Law or regulation concerning anti-money laundering or the prevention thereof.
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">10</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-eleven">
            <div class="page-container" style="text-align: justify;">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content">
                            <div class="dictionary" style="margin-left: 40px;">
                                <div><b>6 <span style="margin-left: 27px;">Examination of Documents</span></b><br><br>
                                    <!-- <p>1.2</p> -->
                                    <!-- <p style="margin-left: 40px;"><b>The Member shall:</b></p><br> -->
                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">6.1</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The Member hereby undertakes that it shall make itself available for examination or audit howsoever required, and to make available any document or record relating to the Member’s functions as a Member, whether by means of paper copy, electronic copy, disk, hard drive, flash drive or such other storage device in its possession or subject to its possession, when required by FMDQ Exchange to carry out its supervisory function, provided that FMDQ Exchange shall give notice of such examination or review.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">6.2</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                FMDQ Exchange shall ensure the confidentiality of documents provided under Clause 6.1 above and not to disclose its content except as required by any law, rule, regulation, order, and judgment of a competent court in Nigeria or for any other lawful purpose and shall notify the Member before such disclosure.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 40px;">
                                <div><b>7 <span style="margin-left: 27px;">Fees</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex">
                                            <p style="width: 10%;">7.1</p>
                                            <p style="width: 90%; margin-top: 0"><b>Transaction Fees</b></p>
                                        </div><br>
                                        <div style="margin-left: 64px;">
                                            <p>The Member hereby agrees that:</p><br>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">7.1.1</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    FMDQ Exchange shall charge and revise transaction fees at rates to be
                                                    determined and published for transactions conducted on the Platform.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">7.1.2</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    Pursuant to Clause 7.1.1 above, notice of revision of transaction fees
                                                    shall be communicated to the Member.
                                                </p>
                                            </div>
                                        </div>

                                        <div style="display: flex">
                                            <p style="width: 10%;">7.2</p>
                                            <p style="width: 90%; margin-top: 0"><b>Membership Dues:</b></p>
                                        </div><br>
                                        <div style="margin-left: 64px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">7.2.1</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The Member shall pay an annual membership due to FMDQ Exchange at a
                                                    rate to be determined by FMDQ Exchange from time to time.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">7.2.2</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The membership dues shall be payable immediately upon the execution
                                                    of this Agreement and shall thereafter become payable on the first
                                                    Business Day of January of each year.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">7.2.3</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    Notice of the revised membership dues shall be communicated to the Member.
                                                </p>
                                            </div>

                                        </div>
                                        <div style="margin-left: 0px;">
                                            <div style="display: flex">
                                                <p style="width: 10%;">7.3</p>
                                                <p style="width: 90%; margin-top: 0">FMDQ Exchange shall issue an invoice to the Member for the membership dues. If the Member does not pay the membership dues within two (2) weeks of the date of issue of the invoice, the Member shall lose all rights and privileges on the FMDQ Exchange Platform.
                                                </p>
                                            </div><br>

                                        </div>
                                        <div style="margin-left: 0px;">
                                            <div style="display: flex">
                                                <p style="width: 10%;">7.4</p>
                                                <p style="width: 90%; margin-top: 0">Suspension or termination of the Member’s license under the provisions of this Agreement shall not prevent FMDQ Exchange from proceeding against the Member for the recovery of all fees payable through all available legal means.
                                                </p>
                                            </div><br>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 40px;">
                                <div><b>8 <span style="margin-left: 27px;">Rules and Guidelines</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <p>
                                            The Member shall comply with the provisions of the FMDQ Exchange Rules and any amendments thereto as may be made by FMDQ Exchange, and any other relevant Applicable Laws.
                                        </p>
                                    </div><br>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 40px;">
                                <div><b>9 <span style="margin-left: 27px;">Code of Conduct</span></b><br><br>
                                    <!-- <p>1.2</p> -->
                                    <p style="margin-left: 40px;">The Member shall comply with the code of conduct set out below and as contained in the FMDQ Exchange Rules when acting as a Member.</p><br>

                                    <div style="margin-left: 40px;">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">11</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twelve">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">


                            <div class="dictionary" style="margin-left: 15px;">
                                <div>
                                    <!-- <p>1.2</p> -->
                                    <div style="margin-left: 40px;">
                                        <!--  -->
                                        <div style="display: flex">
                                            <p style="width: 10%;">9.1</p>
                                            <p style="width: 90%; margin-top: 0"><b>General Duties of Integrity, Care and Full Disclosure</b></p>
                                        </div><br>
                                        <div style="margin-left: 64px;">
                                            <p>When carrying out its brokerage activities on the Platform, the Member shall:</p><br>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.1.1</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    observe high standards of integrity and fair market conduct;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.1.2</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    act with due skill, care and diligence;
                                                </p>
                                            </div>
                                        </div>
                                        <div style="margin-left: 64px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.1.3</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    refrain from any act or conduct which is likely to mar the reputation of FMDQ Exchange and the Market;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.1.4</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    ensure that its Sponsored Individuals Sponsored Individuals act in an honest, open, truthful, cooperative manner and not mislead or conceal any material matter;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.1.5</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    when required to disclose any fact to FMDQ Exchange or investors, to act in an honest, open, truthful, cooperative manner and not mislead or conceal any material matter;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.1.6</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    provide full and prompt responses to all requests for information by FMDQ Exchange in respect of any Product traded on the Platform and provide access to all relevant books, records and other forms of documentation in accordance with the provisions of any applicable law and/or regulation;
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 14px;">
                                <div>
                                    <!-- <p>1.2</p> -->


                                    <div style="margin-left: 40px;">
                                        <div style="display: flex">
                                            <p style="width: 10%;">9.2</p>
                                            <p style="width: 90%; margin-top: 0"><b>No Fraudulent or Misleading Conduct</b></p>
                                        </div><br>
                                        <div style="margin-left: 64px;">
                                            <p>The Member shall not engage in, or fail to take reasonable steps to prevent</p><br>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.2.1</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    any action that has the effect, or may be expected to have the effect, of artificially and/or abnormally affecting the price or value of any Product traded on the Platform;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.2.2</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    entering artificial transactions or otherwise entering into or causing any artificial transaction;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.2.3</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    a fictitious transaction or any other false data to FMDQ Exchange or causing such data to be inputted into any FMDQ Exchange System by reporting such fictitious transaction or false data whilst knowing the transaction or data to be fictitious or false;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.2.4</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    any illegal action or conduct that creates or is likely to create any false or misleading impression as to the market price or value of any Product traded on the Platform;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.2.5</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    any action or conduct that may mar the integrity and transparency of the Platform;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.2.6</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    agreeing or acting in concert with, or providing any assistance to any individual or body corporate (whether or not a Member) with a view to doing anything prohibited by this Agreement or the FMDQ Exchange Rules, or otherwise causing or contributing to a breach of any Applicable Law by such other individual or body corporate;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.2.7</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    its Sponsored Individuals from effecting or causing to happen a fraud or deception in relation to any Product traded on the Platform;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.2.8</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    its Sponsored Individuals from participating in any Insider Trading in relation to a Product or knowingly assist any other individual or body corporate to participate in any such Insider Trading;
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">12</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-thirteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 40px;">
                                <div>
                                    <!-- <p>1.2</p> -->
                                    <div style="margin-left: 64px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">9.2.9</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                to establish measures to ensure that its Sponsored Individuals do not engage in personal dealings, whether directly or indirectly, in Products traded on the Platform which the Member may have confidential information by virtue of being a capital markets participant;
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">9.2.10</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                to establish measures which ensure that it does not, directly or indirectly, through an Affiliate or otherwise commit any fraudulent activity, make any untrue or misleading statement, or engage in any act, practice, or course of business which operates or would operate as a fraud or deceit upon any person, in connection with the purchase or sale of any Product.
                                            </p>
                                        </div>
                                    </div>
                                    <div style="margin-left: 40px;">
                                        <div style="display: flex">
                                            <p style="width: 10%;">9.3</p>
                                            <p style="width: 90%; margin-top: 0"><b>Sponsored Individuals of the Member</b></p>
                                        </div><br>
                                        <div style="margin-left: 64px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.3.1</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The Member shall advise FMDQ Exchange of its Sponsored Individuals
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.3.2</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The Member shall be responsible for the actions of its Sponsored Individuals.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.3.3</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    Persons designated to act as Sponsored Individuals shall be required to meet specified competency requirements as may be laid down by FMDQ Exchange from time to time.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.3.4</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    FMDQ Exchange may upon notice to the Member decline to recognise any Sponsored Individual or terminate the status of a Sponsored Individual if upon investigation the Sponsored Individual is determined to have acted in an unethical manner or is found no longer fit and proper to act as a Sponsored Individual.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.3.5</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The Member shall make adequate arrangements to ensure that all its Sponsored Individuals are suitable, competent, knowledgeable, adequately trained and properly supervised.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.3.6</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The Member shall ensure that its Sponsored Individuals participates in and completes all trainings, inductions and all other competency requirements as FMDQ Exchange may prescribe from time to time.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.3.7</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The Member shall have the responsibility and duty to ascertain by investigation the good character, business repute, qualifications and experience of its Sponsored Individuals.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.3.8</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The Member shall also be responsible for ensuring that training programmes are designed to enhance the knowledge and competence of its Sponsored Individuals in the Member’s role as a Member.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.3.9</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The Member shall ensure that its Sponsored Individuals completes all relevant annual corporate governance, risk management, compliance, anti-money laundering, counter-terrorism financing, know-your-customer (KYC), reporting and such other trainings, tests and certifications and standards as may be required by FMDQ Exchange or any Applicable Law not less than once a year.
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.3.10</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The Member shall notify FMDQ Exchange in writing within seven (7) Business Days of any change to the list of Sponsored Individuals in its employment, and as at the beginning of every year as part of its compliance reporting to FMDQ Exchange.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">13</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
            </div>
        </section>
    </div>

    <div class="page" contenteditable="false">
        <section class="page-fifteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 40px;">
                                <div>

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex">
                                            <p style="width: 10%;">9.4</p>
                                            <p style="width: 90%; margin-top: 0"><b>Responsibility for Transactions</b></p>
                                        </div><br>
                                        <div style="margin-left: 64px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.4.1</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    the Member agrees to be responsible (except for fraud committed by or in connivance with FMDQ Exchange) for, all transactions and/or business conducted on the FMDQ Exchange Platform using it’s approved and recognised electronic access code, and the password/security log-in details of its Sponsored Individuals whether or not such transaction and/or business was duly approved by the authorised officers of the Member; and
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 40px;">
                                <div>

                                    <div style="margin-left: 40px;">

                                        <div style="margin-left: 64px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">9.4.2</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    the Member agrees to be solely responsible for the accuracy of quotes and orders entered on the FMDQ Exchange Platform through its Sponsored Individuals.
                                                </p>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 40px;">
                                <div>

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex">
                                            <p style="width: 10%;">9.5</p>
                                            <p style="width: 90%; margin-top: 0"><b>Degradation of Service</b></p>
                                        </div><br>
                                        <div style="margin-left: 64px;">
                                            <div style=" margin-bottom: 20px;">
                                                <p>When using the System and associated facilities, the Member is prohibited from engaging in practices which may cause degradation of the service or give rise to a disorderly market. Such practices include, but are not limited to, submitting unwarranted or excessive electronic messages or requests to the system.</p>

                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>10 <span style="margin-left: 21px;">Member’s Obligations</span></b><br><br>
                                    <!-- <p>1.2</p> -->
                                    <p style="margin-left: 40px;">The Member hereby agrees on a continuing basis, to:</p><br>
                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">10.1</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                abide by the FMDQ Exchange Rules and any other agreement with FMDQ Exchange in force and as may be reasonably amended from time to time and promptly notified to the Member by FMDQ Exchange;
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">10.2</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                pay the fees, dues and other applicable charges as set out in this Agreement prescribed by FMDQ Exchange according to the conditions established by FMDQ Exchange and promptly communicated to the Member;
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">10.3</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                authorise FMDQ Exchange or its duly appointed agents to carry out on-site examinations and investigations, during normal business hours, in any place of business of the Member or its Affiliate, and submit as soon as possible any information or document relating to this Agreement which FMDQ Exchange or its agents consider appropriate for purposes of such examinations and investigations, provided that FMDQ Exchange shall give reasonable notice of such examinations and investigations. Such reasonable notice to be agreed between FMDQ Exchange and the Members;
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">10.4</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                comply with the technical requirements of the relevant trading System(s) and/or any other information technology system or network operated and advised by FMDQ Exchange;
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">10.5</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                notify FMDQ Exchange immediately in writing of any material changes to the information submitted during the course of its membership application, including in particular (but not limited to) those in respect of the Member's authorisation, licence or permission to conduct trading in Products;
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">10.6</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                notify FMDQ Exchange of any facts or circumstances which may affect the legal form or organisation of the Member or its trading activities on the Platform, including (but not limited to) any consolidation, reorganisation, merger, change of name, change of control or similar event to which the Member is or will become a Party and provide such additional information as FMDQ Exchange may reasonably require;
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">10.7</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                immediately notify FMDQ Exchange as soon as it is served or becomes aware of any bankruptcy, insolvency, winding up, administration or equivalent event (including amicable settlement) in any relevant jurisdiction the Member is subject to or to which the Member is a Party;
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">14</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-sixteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 20px;">
                                <div>
                                    <div style="display: flex; margin-bottom: 20px;margin-left: 40px;">
                                        <p style="width: 10%;">10.8</p>
                                        <p style="width: 90%; margin-top: 0;">
                                            ensure that any description of its membership or the services that it is able to provide, in the form and context in which it appears or is used, does not misrepresent the scope of the capacity which it enjoys as a Member on FMDQ Exchange;
                                        </p>
                                    </div>
                                    <div style="display: flex; margin-bottom: 20px;margin-left: 40px;">
                                        <p style="width: 10%;">10.9</p>
                                        <p style="width: 90%; margin-top: 0;">
                                            document, implement and maintain adequate internal procedures and controls in relation to its business on the Platform;
                                        </p>
                                    </div>
                                    <div style="display: flex; margin-bottom: 20px;margin-left: 40px;">
                                        <p style="width: 10%;">10.10</p>
                                        <p style="width: 90%; margin-top: 0;">
                                            ensure that it takes reasonable steps to prevent off market quotes by its Sponsored Individuals. Provided always that where it has knowledge of any circumstance justifying such off market quote, it shall promptly notify FMDQ Exchange not later than thirty (30) minutes after becoming aware of such circumstance;
                                        </p>
                                    </div>
                                    <div style="display: flex; margin-bottom: 20px;margin-left: 40px;">
                                        <p style="width: 10%;">10.12</p>
                                        <p style="width: 90%; margin-top: 0;">
                                            meet the corporate governance, risk management, compliance, anti-money laundering, counter-terrorism financing, know-your-customer (KYC), reporting and such other trainings, tests, certifications and standards as may be required by FMDQ Exchange or any Applicable Law not less than once a year;
                                        </p>
                                    </div>
                                    <div style="display: flex; margin-bottom: 20px;margin-left: 40px;">
                                        <p style="width: 10%;">10.13</p>
                                        <p style="width: 90%; margin-top: 0;">
                                            take reasonable steps to ensure that its Sponsored Individuals do not participate in any form of Insider Trading in relation to any Product traded on the Platform, or knowingly or with gross negligence assist any individual or body corporate to participate in any such Insider Trading;
                                        </p>
                                    </div>
                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">10.14</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                ensure that documents, records, or any other material related to its brokerage activities howsoever called are kept strictly confidential except as may be required by any law, rule, regulation, order or judgment of a competent court in Nigeria;
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">10.15</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                keep and maintain proper records and books of account in respect of all transactions carried out by it for a period to be advised by FMDQ Exchange and where not expressly advised, in accordance with FMDQ Exchange’s prevailing FMDQ Exchange Rules and any other Applicable Law;
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">10.16</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                not transact business with any natural and legal person whose membership rights have been suspended or revoked except as expressly approved in writing by FMDQ Exchange.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">10.17</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                keep and retain all recordings of phone conversations, text messages and e-mails, based on which any transaction on the Platform was conducted for a period to be advised by FMDQ Exchange and where not expressly advised, in accordance with FMDQ Exchange’s prevailing FMDQ Exchange Rules; and
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">10.18</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                promptly provide complete and accurate data and statistics which FMDQ Exchange may reasonably request from time to time.
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>11 <span style="margin-left: 21px;">Role of the Exchange</span></b><br><br>
                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">11.1</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                FMDQ Exchange undertakes to discharge its regulatory obligations as a securities exchange operating in Nigeria with fidelity.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">11.2</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                FMDQ Exchange shall provide the Member access to the Platform provided it complies with the terms of this Agreement and the Rules.
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">15</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-seventeen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>12 <span style="margin-left: 21px;">Discipline of the Member</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">12.1</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The Member hereby acknowledges that FMDQ Exchange has the power to take disciplinary action against it for any established violation of any of the FMDQ Exchange Rules in force, or as may be amended from time to time, or any provision of this Agreement. In particular, FMDQ Exchange has the power to impose any of the following penalties on the Member:
                                                <br> <br>
                                                (a) &nbsp fines;<br>
                                                (b) &nbsp non-consideration for FMDQ GOLD Award;
                                                <br>
                                                (c) &nbsp suspension of membership on such terms and for such period as FMDQ Exchange <br> &nbsp &nbsp &nbsp &nbsp may think fit; <br>
                                                (d) &nbsp revocation of the Member’s licence; or <br>
                                                (e) &nbsp Public Censure
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">12.2</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The disciplinary powers referred to above may be exercised separately or concurrently. The exercise of such powers shall not prejudice any right that may be vested in FMDQ Exchange to seek legal redress against the Member in pursuance of enforcement of the disciplinary decision.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">12.3</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                Where the Member’s licence is revoked, it shall forthwith lose all rights to act as a Member.
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>13 <span style="margin-left: 21px;">Termination of Membership</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">13.1</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The Member shall cease to be a Member if:
                                            </p>

                                        </div>
                                        <div style="margin-left: 64px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">13.1.1</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    it gives FMDQ Exchange sixty (60) days’ notice in writing of its intention to terminate its membership. Such membership shall terminate at the expiration of the sixty (60) days’ notice;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">13.1.2</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    it is wound up voluntarily;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">13.1.3</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    it has become insolvent;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">13.1.4</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    it is compulsorily wound up by order of the Court;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">13.1.5</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    the Commission has revoked its registration/licence;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">13.1.6</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    it is unable to meet or has defaulted in its obligations under this Agreement, or any other membership agreement executed with any securities exchange, self-regulatory organisation or such other body;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">13.1.7</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    upon investigation by FMDQ Exchange, it is proven that it has acted in an unprofessional and unethical manner in the Market; or
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">13.1.8</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    any other reason as FMDQ Exchange may deem fit to terminate the license of the Member.
                                                </p>
                                            </div>

                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">12.2</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The Member hereby acknowledges that termination of its membership shall not prevent FMDQ Exchange from collecting any accrued fees, dues, fines or charges due or arising from this Agreement, the FMDQ Exchange Rules or any other agreement between FMDQ Exchange and the Member.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">12.3</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The Member hereby acknowledges that FMDQ Exchange reserves the right to apply to the Courts to recover any fees, dues, fines or charges due or arising from this Agreement upon termination of its membership and/or take all necessary steps to protect any investor until such a time that all reported claims have been settled.
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">16</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-seventeen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>14 <span style="margin-left: 21px;">Suspension of Trading</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">14.1</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The Member hereby acknowledges that FMDQ Exchange may in concert with or upon instructions of other relevant regulatory authorities decide to remove, reclassify or suspend trading in a Product if:
                                            </p>

                                        </div>
                                        <div style="margin-left: 64px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">14.1.1</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    it reasonably believes that continuous trading will have an adverse effect on the Market; or
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">14.1.2</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    upon investigation finds that the Member has been in violation of any FMDQ Exchange Rules;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">14.1.3</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    a Force Majeure Event occurs.
                                                </p>
                                            </div>

                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">14.2</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                Suspension of trading in any Product shall cease when the reasons for the suspension no longer exist and/or where the interest of a fair and orderly market is best served by resumption of trading.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">14.3</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                An announcement on FMDQ Exchange’s website or other means shall be made by FMDQ Exchange to give the Member notice of when trading in any Product is suspended and when such suspension is lifted.
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>15 <span style="margin-left: 21px;">Reporting Requirements</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">15.1</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The Member, in respect of all brokered trades shall:
                                            </p>

                                        </div>
                                        <div style="margin-left: 64px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">15.1.1</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    comply with the reporting requirements as determined by FMDQ Exchange and/or advised by any relevant regulatory authority (e.g. the SEC) from time to time; and
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">15.1.2</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    submit complete trade data as captured in FMDQ Exchange-advised reporting templates at frequencies to be determined by FMDQ Exchange and/or advised any relevant regulatory authority.
                                                </p>
                                            </div>

                                        </div>
                                        <div style="margin-left: px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">15.2</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    The Member shall also meet any other reporting obligations and standards as may be required by FMDQ Exchange from time to time.
                                                </p>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>16 <span style="margin-left: 21px;">Willingness to Promote FMDQ Exchange</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="margin-bottom: 20px;">
                                            <p style="width: 90%; margin-top: 5px;">
                                                The Member hereby agrees to:
                                            </p><br>
                                            <p style="width: 90%; margin-top: 5px;">
                                                (i) &nbsp; &nbsp;participate in market development sessions organised by FMDQ Exchange;
                                            </p><br>
                                            <p style="width: 90%; margin-top: 5px;">
                                                (ii) &nbsp; attend functions organised by FMDQ Exchange upon receipt of a written invitation &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; from FMDQ Exchange;
                                            </p><br>
                                            <p style="width: 90%; margin-top: 5px;">
                                                (iii)&nbsp; within the Member’s discretion, promote FMDQ Exchange as a market destination; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;and
                                            </p><br>
                                            <p style="width: 90%; margin-top: 5px;">
                                                (iv) &nbsp; provide advice, feedback and suggestions to FMDQ Exchange
                                            </p>

                                        </div>


                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>17 <span style="margin-left: 21px;">Confidentiality</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">17.1</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The Parties shall treat as strictly confidential all Confidential Information and shall ensure that their respective authorised representatives use the Confidential Information only for the performance of their obligations and the exercise of their rights under this Agreement.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">17</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-ninteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b><span style="margin-left: 21px;"></span></b>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">17.2</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                Each Party shall protect and adequately secure every data belonging to the other Party and shall prevent against the theft or disclosure of such data by its Affiliates, directors, employees, representatives, subcontractors, agents, or any other individual or body corporate having access to the data through it.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">17.3</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                In the event that a Party learns of any theft, unauthorised use, disclosure, or threatened unauthorised use or disclosure of any Confidential Information, the Party shall notify the other Party of the particulars of such theft, unauthorised use or disclosure.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>18 <span style="margin-left: 21px;">Limitation of Liability</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">18.1</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The Parties hereby acknowledge that each Party shall have no liability or obligation to the other for:
                                            </p>

                                        </div>
                                        <div style="margin-left: 64px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">18.1.1</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    occurrences that could not have been reasonably foreseen at the date of execution of this Agreement; and includes a Force Majeure Event;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">18.1.2</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    any loss or damage which may be suffered or which may arise directly or indirectly as a result of activities in the Market not caused by FMDQ Exchange, its staff and agents;
                                                </p>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="margin-left: 64px;">
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">18.1.3</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    any act, error, failure or omission on the part of FMDQ Exchange, acting reasonably, including any loss or damage in respect of the suspension, cancellation, interruption or closure of the Market in compliance with relevant directives or orders from any regulatory body in Nigeria;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">18.1.4</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    the originality, accuracy or completeness of any information or market data provided by a third party;
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">18.1.5</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    FMDQ Exchange’s decision to suspend or terminate the licence of the Member provided such suspension or termination is in compliance with the provisions of this Agreement, the FMDQ Exchange Rules, SEC Rules, the ISA, CBN circulars and DMO guidelines or any other relevant legal framework; and
                                                </p>
                                            </div>
                                            <div style="display: flex; margin-bottom: 20px;">
                                                <p style="width: 10%;">18.1.6</p>
                                                <p style="width: 90%; margin-top: 0;">
                                                    any decision of FMDQ Exchange in the exercise of its powers; provided that such powers are specifically established under this Agreement or the FMDQ Exchange Rules.
                                                </p>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>19 <span style="margin-left: 21px;">Indemnity</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">19.1</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                he Member hereby undertakes to indemnify FMDQ Exchange against any claim or loss directly arising from its wrongful, negligent or illegal trading activities on the Platform done in contravention of any provision of this Agreement or FMDQ Exchange Rules.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">19.2</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                FMDQ Exchange hereby undertakes to indemnify the Member against any claim or loss arising from its violation of the terms of this Agreement.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">19.3</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The Member shall at all times during the subsistence of this Agreement maintain fidelity bond coverage as prescribed by the SEC.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">19.4</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The fidelity bond shall include a cancellation rider providing that the insurer will promptly notify FMDQ Exchange in the event that the bond is cancelled, terminated or substantially modified.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">19.5</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                The Member hereby agrees to notify FMDQ Exchange in writing within twenty-four (24) hours of being aware that its fidelity bond has expired, been cancelled, terminated, or substantially modified.
                                            </p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">18</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>20 <span style="margin-left: 21px;">Notices</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">20.1</p>
                                            <div style="width: 90%; margin-top: 0;">
                                                <p>
                                                    Any notice, request or other communication to be given or made under this Agreement shall be in writing. Any such communication shall be delivered by hand, airmail, established courier service, e-mail or other agreed medium to the Party to which it is required or permitted to be given or made at such Party’s address specified below or at such other address as such Party has from time to time designated by written notice to the other Party hereto, and shall be effective upon the earlier of (a) actual receipt and (b) deemed receipt under clause 19.2 below.
                                                </p>
                                                <br>
                                                <p>
                                                    If to FMDQ Exchange
                                                </p>
                                                <p>
                                                    <b>Member Regulation Group</b>
                                                    <br>
                                                    FMDQ Securities Exchange Limited
                                                    <br> <br>
                                                    Exchange Place
                                                    <br>
                                                    35 Idowu Taylor Street
                                                    <br>
                                                    Victoria Island
                                                    <br>
                                                    Lagos
                                                </p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 105px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <!-- <p style="width: 10%;">18.1</p> -->
                                            <div style="width: 100%; margin-top: 0;">
                                                <p>
                                                    <!-- Any notice, request or other communication to be given or made under this Agreement shall be in writing. Any such communication shall be delivered by hand, airmail, established courier service, e-mail or other agreed medium to the Party to which it is required or permitted to be given or made at such Party’s address specified below or at such other address as such Party has from time to time designated by written notice to the other Party hereto, and shall be effective upon the earlier of (a) actual receipt and (b) deemed receipt under clause 18.2 below. -->
                                                </p>
                                                <br>
                                                <p>
                                                    OR via email: meg@fmdqgroup.com
                                                </p>
                                                <p>If to the Member</p>
                                                <p>
                                                    <b>Managing Director</b>
                                                    <br>
                                                    {{ $details->name }}
                                                    <br>
                                                    {{ $details->address }}
                                                    <br>
                                                </p>
                                            </div>

                                        </div>

                                    </div>
                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">20.2</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                Any notice given as aforesaid shall be deemed to have been served when received, and shall be deemed to have been received (a) in the case of delivery by hand or courier, when delivered as evidenced by a receipt from the addressee; or (b) in the case of e-mail or other agreed medium, upon receipt by the sending party of electronic confirmation of receipt by the intended recipient.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">20.3</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                All documents to be provided or communications to be given or made under this Agreement shall be in English and, where the original version of any such document or communication is not in English, shall be accompanied by an English translation certified to be a true and correct translation of the original.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">20.4</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                In addition to clause 19.1, FMDQ Exchange may convey notices via other electronic broadcasts and/or via the Market Bulletin segment on the FMDQ Exchange website.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>21 <span style="margin-left: 20px;">Binding Agreement</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <p>
                                            Notwithstanding any contrary agreement, both Parties agrees that this Agreement constitutes a legal, valid and binding agreement which shall be enforceable against it in accordance with its terms.
                                        </p>
                                    </div><br>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>22<span style="margin-left: 27px;">Non-Waiver</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <p>
                                            No failure or delay by any Party to exercise any right, power or privilege hereunder shall operate as a waiver thereof nor shall any single or partial exercise of any right, power or privilege preclude any other or further exercise thereof, or the exercise of any other rights, power or privilege as herein provided.
                                        </p>
                                    </div><br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">19</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-one">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>23<span style="margin-left: 27px;">Severability</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <p>
                                            If any provision of this Agreement is declared by any judicial or other competent authority to be void or otherwise unenforceable, that provision shall be severed from this Agreement and the remaining provisions shall remain in force and effect. Provided that the Parties shall thereafter amend this Agreement in such reasonable manner so as to achieve, without illegality, the intention of the Parties, with respect to the severed provision.
                                        </p>
                                    </div><br>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>24<span style="margin-left: 27px;">Governing Law</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <p>
                                            Notwithstanding any other agreement to the contrary, this Agreement and all amendments thereto shall be governed by, and construed in accordance with Nigerian law.
                                        </p>
                                    </div><br>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>25 <span style="margin-left: 21px;">Dispute Resolution</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">25.1</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                In the event of any dispute arising out of or under this Agreement, the Parties shall within five (5) Business Days from the date the dispute arose, engage in an amicable settlement of the dispute by mutual negotiation.
                                            </p>
                                        </div>
                                        <div style="display: flex; margin-bottom: 20px;">
                                            <p style="width: 10%;">25.2</p>
                                            <p style="width: 90%; margin-top: 0;">
                                                Where the dispute is not resolved by mutual negotiation, the Parties shall in compliance with the provisions of the Investments and Securities Act 2007, refer the matter to the Investment and Securities Tribunal for resolution.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <div><b>26<span style="margin-left: 27px;">Amendment</span></b><br><br>
                                    <!-- <p>1.2</p> -->

                                    <div style="margin-left: 40px;">
                                        <p>
                                            The terms of this Agreement may be amended or varied by FMDQ Exchange (acting in good faith) from time to time by giving one (1) month calendar notice to the Member informing it of such amendment or variation.
                                        </p>
                                    </div><br>
                                </div>
                            </div>

                            <ol style="margin-left: 20px;" start="37">
                                <p>IN WITNESS WHEREOF the Parties have caused their authorised representatives to execute this Agreement in the manner below, the day and year first above written.
                                </p><br><br>
                                <div>
                                    <p>Signed for and on behalf of the within-named
                                        <br>
                                        <b>FMDQ SECURITIES EXCHANGE LIMITED:</b>
                                    </p>
                                </div><br><br><br><br>
                                <div class="whole-signatory">
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                        <!-- <div><strong>Authorised Signatory</strong></div> -->
                                    </div>
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                        <!-- <div><strong>Authorised Signatory</strong></div> -->
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
                                    <p>Signed for and on behalf of the within-named
                                        <br>
                                        <b>{{ $details->name }}</b>
                                    </p>
                                    <p><strong></strong></p>
                                </div><br><br><br><br>
                                <div class="whole-signatory">
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                        <!-- <div><strong>Authorised Signatory</strong></div> -->
                                    </div>
                                    <div class="signatory-cont">
                                        <span class="signatory"></span>
                                        <!-- <div><strong>Authorised Signatory</strong></div> -->
                                    </div>
                                </div><br>
                                <div class="whole-name-designation flex-space-btw">
                                    <div class="name-designation">
                                        <div><Strong>Name: </Strong><span></span></div>
                                        <div><Strong>Executive Director </Strong><span></span></div>
                                    </div>
                                    <div class="name-designation">
                                        <div><Strong>Name: </Strong><span></span></div>
                                        <div><Strong>Company Secretary/Treasurer </Strong><span></span></div>
                                    </div>
                                </div><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="pageNo-DocName" style="margin-top: 95px;">
                <div class="pageNo" style="text-align: center;">20</div>
                <div class="DocName" style="font-size: 13px;">FMDQ Exchange Membership Agreements for Associate Member (Brokers) </div>
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
