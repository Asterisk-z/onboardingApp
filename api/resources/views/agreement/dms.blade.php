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
            <div class="dmb-no">1</div>
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
                                        <div class="toc-item">Non-Agency Relationship <span>................................................................................................................</span>6</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Transaction Fees <span>............................................................................................................................</span>6</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Membership Dues <span>............................................................................................................................</span>6</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Member's Obligations <span>......................................................................................................................</span>6</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Termination of Membership <span>............................................................................................................</span>8</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Assignment of Trade Data Rights <span>......................................................................................................</span>8</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Limitation of Liability <span>........................................................................................................................</span>9</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Notices <span>.............................................................................................................................................</span>9</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Binding Agreement <span>.........................................................................................................................</span>9</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Non-Waiver <span>.....................................................................................................................................</span>9</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Severability <span>.....................................................................................................................................</span>9</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Governing Law <span>................................................................................................................................</span>9</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Dispute Resolution <span>..........................................................................................................................</span>9</div>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">2</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-three">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <p><strong>THIS DEALING MEMBERSHIP AGREEMENT</strong> is dated <span class="user-input uOne"></span>-<span class="user-input uOne"></span></p><br>
                            <p><strong>PARTIES</strong></p><br>
                            <p><strong>FMDQ SECURITIES EXCHANGE LIMITED (RC. NO. 1617162)</strong>, a company incorporated under the laws of the Federal Republic of Nigeria with its principal place of business at 35 Idowu Taylor Street, Victoria Island, Lagos, (hereinafter called <strong>“FMDQ Exchange”</strong> which expression shall where the context so admits include its successors and assigns) of the first part.</p><br>
                            <p>AND</p><br>
                            <p>[Insert Institution’s name] (RC NO. XXXXX),, <br>a company incorporated under the laws of the Federal Republic of Nigeria with its registered office at [Insert Institution’s address] (the “Member” which expression shall where the context so admits include its successors and assigns) of the second part.</p><br>
                            <p><strong>BACKGROUND</strong></p><br>
                            <ol type="A" style="margin-left: 20px;">
                                <li>FMDQ Securities Exchange Limited (“FMDQ Exchange” or the “Exchange”) is a securities exchange and self-regulatory organisation (“SRO”) licensed and regulated by the Securities and Exchange Commission (“SEC” or the “Commission”).</li><br>
                                <li>The Exchange provides a Platform for the listing, quotation, noting, registration, trading, order execution, and trade reporting of fixed income, currency, and derivative products, inter alia. </li><br>
                                <li>The Member has indicated interest in becoming a Dealing Member (Specialist) of the Exchange with a view to actively participating in Trading Activities on the Exchange. </li><br>
                                <li> By executing this Agreement, the Member agrees to be bound by the Rules (as defined below).</li>
                            </ol><br>
                            <p><strong>AGREED TERMS</strong></p><br>
                            <ol style="margin-left: 20px;">
                                <li><strong>Definitions and Interpretation</strong><br><br>
                                    <div class="dictionary">
                                        <p>1.1</p>
                                        <div>The following definitions shall apply in this Agreement: <br><br>
                                            <p><strong>Agreement:</strong> this Dealing Membership Agreement, as may be revised, updated and/or amended from time to time.</p> <br>
                                            <p><strong>Applicable Law:</strong> any law, statute, code, ordinance, decree, rule or regulation (including rules and regulations of self-regulatory organisations) as may relate to the activities of the Member(as may be revised, updated and/or amended from time to time).</p>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">3</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-four">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 40px;">
                                <p></p>
                                <div>
                                    <p><strong>Authorised Representatives:</strong> means an employee, or such other person as may be authorised by the Member to perform activities on its behalf on the Exchange. Authorised Representatives include but are not limited to treasurers, dealers, compliance officers, treasury operations staff, treasury sales staff, risk officers and control & audit staff.</p> <br>
                                    <p><strong>Broker:</strong> an individual or body corporate that arranges transactions between a buyer and a seller of a Product in return for a fee or commission upon due execution of a trade/deal.</p> <br>
                                    <p><strong>Business Day:</strong> a day (other than a Saturday, Sunday or Federal Government of Nigeria declared public holiday) on which banks are open for business in Nigeria. </p> <br>
                                    <p><strong>Dealing Member (Bank):</strong> a bank which has been admitted to trade on the Platform (as defined below). Dealing Member (Banks) shall serve as liquidity providers to Dealing Members (Specialists) on the Platform. </p> <br>
                                    <p><strong>Dealing Member (Specialist) or DMS:</strong> an investment banking firm, securities dealing firm or experienced fixed income dealer permitted to engage in Trading Activities (as defined below) on the Platform of the Exchange pursuant to terms of this Agreement and the Rules (defined below). </p> <br>
                                    <p><strong>Insider Trading:</strong> trading done by an individual or body corporate or group of individuals or bodies corporate who, being in possession of some confidential and price sensitive information not generally available to the public, utilising such information to buy or sell securities for the benefit of themselves or any other individual or body corporate. </p> <br>
                                    <p><strong>Market:</strong> the market for Products (as defined below) tradable or traded on the FMDQ Exchange Platform </p> <br>
                                    <p><strong>National Assembly:</strong> the National Assembly of the Federal Republic of Nigeria. </p> <br>
                                    <p><strong>Platform:</strong> the FMDQ Exchange organised market place for listing, registration, quotation,noting, trading, order execution, and trade reporting of fixed income, currency and derivative products, inter alia. </p> <br>
                                    <p><strong>Product:</strong> any instrument, security, currency, or other contract admitted by FMDQ Exchange for trading on the Platform. </p> <br>
                                    <p><strong>Platform:</strong> an individual or body corporate with demonstrable and recognised expertise, experience and knowledge in trading in one or more of the Products traded on the Platform as a Dealing Member (Specialist) (as defined above). </p> <br>
                                    <p><strong>Member:</strong> an individual or body corporate with demonstrable and recognised expertise, experience and knowledge in trading in one or more of the Products traded on the Platform as a Dealing Member (Specialist) (as defined above). </p> <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">4</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-five">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 40px;">
                                <p></p>
                                <div>
                                    <p><strong>Rules:</strong> rules, guidelines, bulletins, agreements and such other regulation relating to the Member as may be issued by the Exchange in its capacity as an SRO and advised to the Member from time to time. </p> <br>
                                    <p><strong>SEC Rules:</strong> rules and regulations issued by the SEC pursuant to the Investments and Securities Act 2007. </p> <br>
                                    <p><strong>System:</strong> the electronic trading programme around which the Platform is organised that allows the Proposed Member to submit trade-related data and fulfil contractual obligations leading up to the clearing and settlement of executed trades. </p> <br>
                                    <p><strong>Trading Activities:</strong> trading amongst Dealing Member (Specialists) and/or Dealing Member(Banks) in specific products advised by FMDQ Exchange. </p> <br>
                                    <p><strong>Year:</strong> a calendar year. </p> <br>
                                </div>
                            </div>
                            <div class="dictionary" style="margin-left: 20px;">
                                <p>1.2</p>
                                <div>Interpretation <br><br>
                                    <p>In this Agreement:</p><br>
                                    <p>1.2.1. Words importing the singular number only shall include the plural and vice-versa and words importing the feminine gender only shall include the masculine gender and vice versa and words importing persons shall include corporations, associations, partnerships and governments (whether federal, state or local), and the words “written” or “in writing” shall include printing, engraving, lithography or other means of visible reproduction.</p> <br>
                                    <p>1.2.2. A reference to “Party” or “Parties” shall mean a party or parties to this Agreement</p> <br>
                                    <p>1.2.3. The words “hereof,” “herein,” “hereby,” “hereto” and similar words refer to this entire Agreement and not any Clause, Schedule or other subdivision of this Agreement</p> <br>
                                    <p>1.2.4. Defined terms appearing in this Agreement in upper case shall be given their meaning as defined, while the same terms appearing in lower case shall be interpreted in accordance with their plain English meaning.</p> <br>
                                    <p>1.2.5. References to any liability shall include actual, contingent, present or future liabilities.</p> <br>
                                    <p>1.2.6. A reference to FMDQ Exchange or the Member herein shall include reference to their respective successors and assigns</p> <br>
                                    <p>1.2.7. Any money payable under this Agreement on a day that falls on a public holiday shall be paid on the next Business Day. </p> <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">5</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-six">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="2">
                                <li><strong>Non-Agency Relationship </strong><br><br>
                                    <div class="dictionary">
                                        <p>2.1</p>
                                        <div>
                                            The Member shall not hold itself out to any individual or body corporate as being an agent of or otherwise representing or having the power in any way to act for or bind the Exchange unless expressly authorised in writing.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>2.2</p>
                                        <div>
                                            The Member shall act as a principal in all its Trading Activities on the Platform without limitation, when trading, clearing or settling and be responsible to other Dealing Member(Specialists), Dealing Member (Banks) and the Exchange as a principal.
                                        </div>
                                    </div>
                                </li><br>
                                <li><strong>Transaction Fees</strong><br><br>
                                    <div class="dictionary">
                                        <p>3.1</p>
                                        <div>The Proposed Member hereby agrees that: <br><br>
                                            <p>3.1.1. The Exchange shall charge and revise transaction fees at rates to be determined and agreed for transactions conducted on the Platform.</p> <br>
                                            <p>3.1.2. It shall execute a Direct Debit Mandate authorising its bank to make periodic payments of transaction fees payable to FMDQ Exchange in the manner described in the form advised by FMDQ Exchange. Whenever transaction fees are revised by FMDQ Exchange and duly communicated to the Proposed Member, the Proposed Member shall be required to execute another Direct Debit Mandate to supersede the one previously executed.</p> <br>
                                        </div>
                                    </div>
                                </li>
                                <li><strong>Membership Dues </strong><br><br>
                                    <div class="dictionary">
                                        <p>4.1</p>
                                        <div>
                                            The Proposed Member undertakes to pay membership dues to FMDQ Exchange at a rate to be determined and agreed with FMDQ Exchange. The membership dues shall be payable immediately upon execution of this Agreement.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>4.2</p>
                                        <div>
                                            The Proposed Member shall execute a Direct Debit Mandate authorising its bank to make payment of subsequent membership dues payable to FMDQ Exchange in the manner described in the form advised by FMDQ Exchange. Whenever membership dues are revised by FMDQ Exchange and duly communicated to the Proposed Member, the Proposed Member shall be required to execute another Direct Debit Mandate to supersede the one previously executed.
                                        </div>
                                    </div><br>
                                    <div class="dictionary">
                                        <p>4.3</p>
                                        <div>
                                            No fees shall remain outstanding against the Member.
                                        </div>
                                    </div>
                                </li><br>
                                <li><strong>Transaction Fees</strong><br><br>
                                    <div class="dictionary">
                                        <p>5.1</p>
                                        <div>The Member undertakes to: <br><br>
                                            <p>5.1.1. Abide by the Exchange’s Rules, the SEC Rules, and such other Applicable Laws.</p> <br>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">6</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-seven">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 40px;">
                                <p></p>
                                <div>
                                    <p>5.1.2. Pay the fees, dues, and other applicable charges as set out in this Agreement or as prescribed by FMDQ Exchange according to the conditions established by FMDQ Exchange and duly communicated to the Member.</p> <br>
                                    <p>5.1.3. Comply with the technical requirements of the relevant trading System(s) and/or any other information technology system or network operated and advised by FMDQ Exchange.</p> <br>
                                    <p>5.1.4. Comply with such market standards, capacity requirements, capital or credit line requirements as may be determined by FMDQ Exchange from time to time and accepts that theMembership of the Exchange may be terminated for failure to meet the aforementioned. </p> <br>
                                    <p>5.1.5. Notify FMDQ Exchange of any facts or circumstances which may affect its Trading Activities on the Platform.</p> <br>
                                    <p>5.1.6. Notify FMDQ Exchange immediately in writing of any material changes to the information submitted during its membership application, including in particular (but not limited to) those in respect of the Member's authorisation or permission to conduct trading in Products. </p> <br>
                                    <p>5.1.7. Ensure that any quotes given by any of its Authorised Representatives are correct and firm (may be acted upon by the counterparty to whom the quote was given). </p> <br>
                                    <p>5.1.8. Ensure that it does not transact or conclude any trades with a Broker (either domestic or offshore) either directly or indirectly in relation to the Products traded on the FMDQ Exchange Platform unless such Broker is duly licenced by FMDQ Exchange.</p> <br>
                                    <p>5.1.9. Prevent the operation of any account that serves as brokerage settlement accounts, for the Products traded on the FMDQ Exchange Platform by/for any individual or body corporate that is not licenced by FMDQ Exchange and/or registered with the Commission to carry out a trading or brokerage function but still brokers any of the Products. </p> <br>
                                    <p>5.1.10. Maintain and take all necessary steps to ensure its Authorised Representatives maintain the highest level of professional and ethical conduct in all its dealings with other Dealing Member (Specialists), Dealing Member (Banks) and the Exchange and in respect of all its activities on the Platform. </p> <br>
                                    <p>5.1.11. Take reasonable steps to ensure that its Authorised Representatives do not participate in any form of Insider Trading in relation to its Trading Activities conducted on the Exchange, or knowingly or by gross negligence assist any individual or body corporate to participate in any such Insider Trading. </p> <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">7</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-eight">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 40px;">
                                <p></p>
                                <div>
                                    <p>5.1.12. Maintain and preserve all recordings of phone conversations, text messages and e-mails, based on which any transaction on the Platform was conducted, for a period not less than six (6) years or such other period as may be advised by FMDQ Exchange.</p> <br>
                                    <p>5.1.13. Report all trade data in respect of Products traded by the Member on the Platform in the manner prescribed and at the intervals advised by FMDQ Exchange. </p> <br>
                                </div>
                            </div>
                            <ol style="margin-left: 20px;" start="6">
                                <li><strong>Termination of Membership </strong><br><br>
                                    <div class="dictionary">
                                        <p>6.1</p>
                                        <div>
                                            Membership of the Exchange shall be terminated where the Member: <br><br>
                                            <p>6.1.1. gives the Exchange fourteen (14) days’ notice in writing of its intention to terminate itsmembership of the Exchange. Consequently, the membership of the Exchange shall beterminated: <br><br>
                                                <div style="margin-left: 40px;">
                                                    <div class="dictionary">
                                                        <p>6.1.1.1.</p>
                                                        <div>at the expiration of the fourteen (14) days’ notice.</div>
                                                    </div>
                                                    <div class="dictionary">
                                                        <p>6.1.1.2.</p>
                                                        <div>when all trades to which the Member is a counterparty have been delivered, settled and/or cleared on the agreed settlement dates; and </div>
                                                    </div>
                                                    <div class="dictionary">
                                                        <p>6.1.1.3.</p>
                                                        <div>when all fees and such other payments due and payable to FMDQ Exchange have been delivered and settled</div>
                                                    </div>
                                                </div>
                                            </p> <br>
                                            <p>6.1.2. defaults under this Agreement </p> <br>
                                            <p>6.1.3. violates any provisions of the Rules </p> <br>
                                            <p>6.1.4. fails to meet the capacity requirements, minimum capital requirements and such other market standards as may be advised by FMDQ Exchange from time to time having been given reasonable time to remedy such deficiencies. </p> <br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>6.2</p>
                                        <div>All applicable disciplinary actions to be taken against the Members for violations of this Agreement and the Rules shall be as prescribed in the Rules. <br><br>
                                        </div>
                                    </div>
                                </li><br>
                                <li><strong>Assignment of Trade Data Rights</strong><br><br>
                                    <div class="dictionary">
                                        <p>7.1</p>
                                        <div>The Member hereby agrees to assign to FMDQ Exchange all rights to the trade data acquired during the performance of its Trading Activities and other transactions with Dealing Member(Banks), other Dealing Member (Specialists) and clients.<br><br>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">8</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-nine">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="8">
                                <li><strong>Limitation of Liability</strong><br><br>
                                    <div class="dictionary">
                                        <p>8.1</p>
                                        <div>In no event will FMDQ Exchange have any obligation or liability (whether in tort, contract, warranty or otherwise and notwithstanding any fault, negligence, product liability, or strict liability), for any indirect, incidental, special, or consequential damages, including but not limited to, lost revenue, loss of profits or business interruption losses, sustained or arising from or related to activities, trading or otherwise, carried out on the Exchange. This section shall survive the termination of this Agreement. <br><br>
                                        </div>
                                    </div>
                                </li>
                                <li><strong>Notices </strong><br><br>
                                    <div class="dictionary">
                                        <p>9.1</p>
                                        <div>For the purpose of this provision, notices shall be conveyed via letters, emails, electronic broadcasts and/or via the market bulletin segment on the FMDQ Exchange website. <br><br>
                                        </div>
                                    </div>
                                </li>
                                <li><strong>Binding Agreement </strong><br><br>
                                    <div class="dictionary">
                                        <p>10.1</p>
                                        <div>Notwithstanding any contrary agreement, both Parties agrees that this Agreement constitutes a legal, valid, and binding agreement which shall be enforceable against it in accordance with its terms <br><br>
                                        </div>
                                    </div>
                                </li>
                                <li><strong>Non-Waiver </strong><br><br>
                                    <div class="dictionary">
                                        <p>11.1</p>
                                        <div>No failure or delay by FMDQ Exchange to exercise any right, power or privilege hereunder shall operate as a waiver thereof nor shall any single or partial exercise of any right, power or privilege preclude any other or further exercise thereof, or the exercise of any other rights, power or privilege as herein provided <br><br>
                                        </div>
                                    </div>
                                </li>
                                <li><strong>Severability </strong><br><br>
                                    <div class="dictionary">
                                        <p>12.1</p>
                                        <div>If any provision of this Agreement is declared by any judicial or other competent authority to be void or otherwise unenforceable, that provision shall be severed from this Agreement and the remaining provisions shall remain in force and effect. Provided that the Parties shall thereafter amend this Agreement in such reasonable manner to achieve, without illegality, the intention of the Parties, with respect to the severed provision. <br><br>
                                        </div>
                                    </div>
                                </li>
                                <li><strong>Governing Law </strong><br><br>
                                    <div class="dictionary">
                                        <p>13.1</p>
                                        <div>This Agreement shall be governed by Nigerian law. <br><br>
                                        </div>
                                    </div>
                                </li>
                                <li><strong>Dispute Resolution </strong><br><br>
                                    <div class="dictionary">
                                        <p>14.1</p>
                                        <div>In the event of any dispute arising out of or under this Agreement, the Parties shall within five (5) Business Days from the date the dispute arose, engage in an amicable settlement of the dispute by mutual negotiation. <br><br>
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">9</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-ten">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <div class="dictionary" style="margin-left: 20px;">
                                <p>14.2</p>
                                <div>Where the dispute is not resolved by mutual negotiation, the Parties shall in compliance with the provisions of the Investment and Securities Act 2007, refer the matter to the Investment and Securities Tribunal for resolution. <br><br>
                                </div>
                            </div><br><br>
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
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">10</div>
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
