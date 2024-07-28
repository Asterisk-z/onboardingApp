<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Emulating real sheets of paper in web documents (using HTML and CSS)">
    <title>Agreement</title>
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

        @media print {

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
                            <p style="text-transform: uppercase;">{{ $details->name }}</p>
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
                                        <div class="toc-item">Market Standards <span>.............................................................................................................................</span>9</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Trading Practice <span>...............................................................................................................................</span>10</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Non-Agency Relationship <span>................................................................................................................</span>10</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Market Disruption <span>...........................................................................................................................</span>10</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Disclosure Requirements <span>................................................................................................................</span>10</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Anti-Money Laundering <span>..................................................................................................................</span>11</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Examination of Documents <span>.............................................................................................................</span>11</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Transaction Fees <span>..............................................................................................................................</span>12</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Membership Dues <span>............................................................................................................................</span>12</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Rules and Guidelines <span>........................................................................................................................</span>12</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Code of Conduct <span>..............................................................................................................................</span>13</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Member's Obligations <span>......................................................................................................................</span>16</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Segregation of Duties <span>.......................................................................................................................</span>18</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Standard Settlement Instructions <span>....................................................................................................</span>19</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Trading Method <span>................................................................................................................................</span>19</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Discipline of the Member <span>.................................................................................................................</span>19</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Termination of Membership <span>.............................................................................................................</span>20</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Dealing Room and Systems Security <span>.................................................................................................</span>20</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Access Right to Trading Systems <span>......................................................................................................</span>21</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Use of the Trading Systems <span>..............................................................................................................</span>21</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Restrictions on Use of Trading Systems <span>............................................................................................</span>22</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Suspension of Trading <span>.......................................................................................................................</span>22</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Confirmation of Trades <span>.....................................................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Reporting Requirements <span>...................................................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Prohibition of Transactions with Suspended Members <span>....................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Willingness to Promote FMDQ Exchange <span>..........................................................................................</span>23</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Confidentiality <span>...................................................................................................................................</span>24</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Limitation of Liability <span>........................................................................................................................</span>24</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Indemnity <span>.........................................................................................................................................</span>25</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Notices <span>.............................................................................................................................................</span>25</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Binding Agreement <span>.........................................................................................................................</span>26</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Non-Waiver <span>.....................................................................................................................................</span>26</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Severability <span>.....................................................................................................................................</span>26</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Governing Law <span>................................................................................................................................</span>26</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Dispute Resolution <span>..........................................................................................................................</span>26</div>
                                    </li>
                                    <li>
                                        <div class="toc-item">Execution of Agreement <span>..................................................................................................................</span>27</div>
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
                            <p><strong>THIS DEALING MEMBERSHIP AGREEMENT</strong> is dated <span class="user-input uOne">{{ Carbon\Carbon::create($details->date)->isoFormat(" Do, MMMM") }}</span>-<span class="user-input uOne">{{ Carbon\Carbon::create($details->date)->isoFormat("YYYY") }}</span></p><br>



                            <p><strong>BETWEEN</strong></p><br>
                            <p><strong>FMDQ SECURITIES EXCHANGE LIMITED (RC. NO. 1617162)</strong>, a company incorporated under the laws of the Federal Republic of Nigeria with its principal place of business at Exchange Place, 35, Idowu Taylor Street, Victoria Island, Lagos, (hereinafter called <strong>“FMDQ Exchange”</strong> which expressionshall where the context so admits shall include its successors and assigns) of the first part.</p><br>
                            <p>AND</p><br>
                            <p>{{ $details->name }} (RC.NO. {{ $details->rc_number }}), a company incorporated under the laws of the Federal Republic of Nigeria with its registered office at {{ $details->address }} (the “Member” which expression shall where the context so admits shall include its successors and assigns) of the second part.</p><br>
                            <p>In this Agreement, FMDQ Exchange and the Member shall individually be referred to as a “Party” and collectively be referred to as the “Parties”.</p><br>
                            <p><strong>WHEREAS</strong></p><br>
                            <ol type="A" style="margin-left: 20px;">
                                <li>FMDQ Exchange is licensed by the Securities and Exchange Commission (“SEC”) as a securities exchange and self-regulatory organisation with a Platform to enable the Member deal in Products and carry out trading activities.</li><br>
                                <li>The Member is a financial institution duly licensed by the Central Bank of Nigeria and has indicated interest in becoming a Dealing Member on the FMDQ Exchange Platform with a view to actively participating in trading activities on the said Platform. </li><br>
                                <li>The Member has agreed to be duly licenced by FMDQ Exchange as a Dealing Member.</li><br>
                                <li> Pursuant to the foregoing, the Parties hereby agree to be bound by the terms herein contained.</li>
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
            <div class="dmb-no">3</div>
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
                                        <p class="term"><strong>“Broker”</strong></p>
                                        <p class="definition">means a body corporate that arranges transactions between a buyer and a seller in return for a fee or commission when the deal is executed;</p>
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
                                        <p class="term"><strong>“Commission”</strong></p>
                                        <p class="definition">means the Securities and Exchange Commission;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Company”</strong></p>
                                        <p class="definition">has the meaning assigned to it in CAMA;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Confidential Information”</strong></p>
                                        <p class="definition">means any information, communications or data, about the Parties, Dealing Member(s) or their respective affairs or business in any form, whether oral, written, graphic, or electromagnetic, including all plans, proposals, forecasts, technical processes, methodologies, know-how,</p>
                                    </div><br>
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
                            <div class="dictionary ml-40">
                                <p></p>
                                <div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong></strong></p>
                                        <p class="definition">information about technological or organisational systems, customers, personnel, business activities, marketing, financial research or development activities, databases, IntellectualProperty Rights, the terms and conditions of this Agreement and other information in relation to it, whether or not it is specifically marked confidential but excluding any information, which: </p>
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
                                        <p class="definition">means the Federal High Court</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Dealing Member/Member”</strong></p>
                                        <p class="definition">means any financial institution which has been admitted to trade on the Platform;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Dealing Room”</strong></p>
                                        <p class="definition">means the place set apart at the Member’s office by the Member to carry on Trading in Products listed/registered on the Platform, and other products;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Director” </strong></p>
                                        <p class="definition">has the meaning assigned to it under the CAMA;</p>
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
                                        <p class="term"><strong>“FMDA”</strong></p>
                                        <p class="definition">means the Financial Markets Dealers Association;</p>
                                    </div><br>
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
                            <div class="dictionary ml-40">
                                <p></p>
                                <div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“FMDQ GOLD Award”</strong></p>
                                        <p class="definition">means a recognition of exceptional performance on the securities exchange, exemplary compliance with its Rules and contribution to the Nigerian market;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“FMDQ Rebate Program”</strong></p>
                                        <p class="definition">means a collection of rewards to qualifying Members that provide liquidity on the Platform;</p>
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
                                        <p class="term"><strong>“Market” </strong></p>
                                        <p class="definition">means the market for Products tradable or traded on the FMDQ Exchange Platform; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>"Market Disruption"</strong></p>
                                        <p class="definition">means any event which makes it impossible or impracticable to conduct trades on the Platform, which disruption may or may not be of a technical orSystems- related nature, and is not caused by, or within the control of, any of the Parties;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Netting Agreement” </strong></p>
                                        <p class="definition">means an agreement consolidating buy and sell transactions amongst Members on the Platform such that net payments become payable based on the outcome of the combined transactions;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Personal Data”</strong></p>
                                        <p class="definition">has the meaning contained in the Nigeria Data Protection, Act, 2023.</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Platform”</strong></p>
                                        <p class="definition">means the FMDQ Exchange-organised marketplace for listing, registration, quotation, order execution, and trade reporting;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Product”</strong></p>
                                        <p class="definition">means any instrument, security, currency, or other contract admitted by FMDQ Exchange for trading on the Platform, Products shall be construed accordingly;</p>
                                    </div><br>
                                </div>
                            </div>
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
                            <div class="dictionary ml-40">
                                <p></p>
                                <div>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Public Censure”</strong></p>
                                        <p class="definition">means a public disciplinary action that constitutes a formal expression of disapproval of a Member by FMDQ Exchange. It includes but is not limited to newspaper publications and posting on FMDQ Exchange website; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Recipient”</strong></p>
                                        <p class="definition">means the Party receiving an item of Confidential Information;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Rule Book”</strong></p>
                                        <p class="definition">means rules and regulations designed by FMDQ Exchange (approved by the Commission, CBN and DMO) and advised to the Members to govern the trading activities on the FMDQ Exchange Platform and, shall include reasonable amendments thereto that are made from time to time and promptly made available to Dealing Members;
                                            <br><br>
                                            “Securities” has the meaning as is assigned to it in the Act, and any rule or resolution made pursuant to the Act;
                                        </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Securities Exchange”</strong></p>
                                        <p class="definition">means an exchange or approved trading facility such as a commodity exchange, metal exchange, petroleum exchange, options, future exchange, over the counter market, and other derivatives exchanges;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“SEC Rules” </strong></p>
                                        <p class="definition">means the rules and regulations of the Commission issued pursuant to the ISA, as may be amended from time to time; </p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Straight-Through <br>Processing (STP)” </strong></p>
                                        <p class="definition">means the process that enables the execution of Trading to be conducted without need for manual intervention; subject to legal and regulatory restrictions;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“SWIFT” </strong></p>
                                        <p class="definition">means a standardised communications platformused to facilitate the transmission of data about financial transactions. Such information includes (but is not limited to) confirmation of trades;</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“System”</strong></p>
                                        <p class="definition">means an electronic trading programme that allows Members to submit trade-related data and fulfil contractual obligations leading up to the clearing and settlement of executed trades. Systems used on the FMDQ Exchange Platform include (but are not limited to) Bloomberg E-bond Trading System,Refinitiv Trading System, FMDQ OTC FX Futures Trading & Reporting System. Trading systems may be different from the clearing and settlement systems; and</p>
                                    </div><br>
                                    <div class="sub-dictionary ">
                                        <p class="term"><strong>“Trading”</strong></p>
                                        <p class="definition">means trading amongst Dealing Members as well as amongst Dealing Members and clients.</p>
                                    </div><br>
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
                            <div class="dictionary" style="margin-left: 20px;">
                                <p>1.2</p>
                                <div>Interpretation <br><br>
                                    <p>In this Agreement:</p><br>
                                    <p>1.2.1 Words importing the singular number only shall include the plural and vice- versa and words importing the feminine gender only shall include the masculine gender and vice versa and words importing persons shall include corporations, associations, partnerships and governments (whether state or local), and the words “written” or “in writing” shall include printing, engraving, lithography or other means of visible reproduction.</p> <br>
                                    <p>1.2.2 The words “hereof,” “herein,” “hereby,” “hereto” and similar words refer to this entire Agreement and not any particular Clause, Schedule, or other subdivision of this Dealing Membership Agreement.</p> <br>
                                    <p>1.2.3 A reference to “Party” or “Parties” shall mean a party or parties to this Agreement.</p> <br>
                                    <p>1.2.4 A reference to a statutory provision shall be deemed to include that provision as the same may from time to time be modified, amended, or re-enacted.</p> <br>
                                    <p>1.2.5 Any reference to Clauses and Schedules, are to Clauses and Schedules of this Dealing Membership Agreement, and references to sub-clauses and paragraphs are references to sub-clauses and paragraphs of the clause or schedule in which they appear.</p> <br>
                                    <p>1.2.6 A reference to a provision of this Agreement is to that provision as amended in accordance with the terms of this Dealing Membership Agreement.</p> <br>
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
            <div class="dmb-no">8</div>
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
                                    <p>The Member shall use its best endeavours to maintain such market standards as may be reasonably determined and promptly communicated to the Member by FMDQ Exchange from time to time in its dealings with other Members and the general public. In particular it shall use its best endeavours to:</p><br>
                                    <div class="dictionary">
                                        <p>2.1</p>
                                        <div>
                                            <strong>Two-Way Quotation</strong><br>
                                            always provide “bid” and/or “ask” quotations for any designated Product whenever required by another Member. All quotes by the Member shall be live, executable, and irrevocable.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>2.2</p>
                                        <div>
                                            <strong>Risk Management Practice</strong><br>
                                            <p>2.2.1 comply with the minimum standards on risk management reasonably prescribed and promptly communicated to the Member from time to time by FMDQ Exchange;</p><br>
                                            <p>2.2.2 establish a robust risk management function which shall be responsible for identifying, measuring, monitoring, and reporting any risksthat the Member may be exposed to; and</p><br>
                                            <p>2.2.3 maintain a proper structure that ensures the efficiency of the said risk management function.</p>
                                        </div>
                                    </div>
                                </li><br>
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
                            <ol style="margin-left: 20px;" start="3">
                                <li><strong>Trading Practice</strong><br><br>
                                    <div class="dictionary">
                                        <p>3.1</p>
                                        <div>
                                            Except as otherwise determined by FMDQ Exchange, Trading shall be conducted during the hours as advised by FMDQ Exchange from time to time via prompt notice.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>3.2</p>
                                        <div>
                                            Any transaction completed after trading hours shall be on the terms agreed between Dealing Members and be taken to have occurred on that Business Day.
                                        </div>
                                    </div>
                                </li><br>
                                <li><strong>Non-Agency Relationship</strong><br><br>
                                    <div class="dictionary">
                                        <p>4.1</p>
                                        <div>
                                            The Member or its Authorised Representative shall not hold itself out to any individual or body corporate as being an agent of or otherwise representing or having the power in any way to act for or bind FMDQ Exchange unless expressly authorised in writing.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>4.2</p>
                                        <div>
                                            The Member shall act as a principal in all its activities with other Members on FMDQ Exchange’s platform without limitation, when trading, clearing, or settling and be responsible to other Members and FMDQ Exchange as a principal.
                                        </div>
                                    </div>
                                </li><br>
                                <li><strong>Market Disruption</strong><br><br>
                                    <div class="dictionary">
                                        <p>5.1</p>
                                        <div>
                                            FMDQ Exchange shall apply its best endeavours to keep the Platform operating efficiently during the advised trading hours.
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>5.2</p>
                                        <div>
                                            Each Party hereby agrees that the other Party shall not be liable for the failure of transactions on the Platform arising from Market Disruptions not due to negligent conduct on its part.
                                        </div>
                                    </div>
                                </li><br>
                                <li><strong>Disclosure Requirements</strong><br><br>
                                    <p>The Member hereby undertakes to:</p><br>
                                    <div class="dictionary">
                                        <p>6.1</p>
                                        <div>
                                            Disclose in writing to FMDQ Exchange its membership of any other Securities Exchange or at the time of the execution of this Agreement;
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>6.2</p>
                                        <div>
                                            Disclose to FMDQ Exchange in writing, not later than one (1) calendar month from when it becomes a Member of any other Securities Exchange after the execution of this Agreement, specifying the name and principal place of business of the other Securities Exchange, the date it was registered as a member of the Securities Exchange, the duration of its membership, and such additional or other information as may be required by FMDQ Exchange;
                                        </div>
                                    </div><br>
                                    <div class="dictionary">
                                        <p>6.3</p>
                                        <div>
                                            Disclose the existence of any Netting Agreement between it and any other Member to FMDQ Exchange within one (1) month of consummating such agreement.
                                        </div>
                                    </div>
                                </li><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">10</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-eleven">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="7">
                                <div class="dictionary">
                                    <p>6.4</p>
                                    <div>
                                        Disclose to FMDQ Exchange not later than one (1) calendar month after the execution of this Agreement the particulars of its executive director overseeing its financial markets function; provided that where any change is made in the executive director overseeing its financial markets function, it will not later than one (1) calendar month thereafter inform FMDQ Exchange of such change.
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>6.5</p>
                                    <div>
                                        Disclose any information regarding any Product that it believes may abnormally affect the Market to FMDQ Exchange within twenty-four (24) hours of being aware of the information.
                                    </div>
                                </div><br>
                                <div class="dictionary">
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
                                <li><strong>Anti-Money Laundering</strong><br><br>
                                    <p>The Parties covenant and represent that at all times during the existence of this Agreement, they shall comply with all applicable laws, policies, and regulations on money laundering, including the SEC (Capital Market Operators Anti-Money Laundering/Combating the Financing of Terrorism and Proliferation Financing), Regulations, 2022 and shall establish/maintain a robust and comprehensive anti-money laundering/counter-terrorism financing framework. It shall adopt policies stating its commitment to comply with Anti-Money Laundering, Countering the Financing of Terrorism and Countering the Proliferation Financing (“AML/CFT/CPF”)obligations under the law and regulatory directives to actively prevent any transaction that facilitates criminal activities.</p>
                                </li><br>
                                <li><strong>Examination of Documents</strong><br><br>
                                    <div class="dictionary">
                                        <p>8.1</p>
                                        <div>
                                            The Member hereby undertakes that it shall make available for examination or review howsoever required, any document or record relating to the Member’s participation in trading activities on FMDQ Exchange’s Platform whether by means of paper copy, disk, flash, or electronic copy in its possession or subject to its possession, when required by FMDQ Exchange to carry out its supervisory function, provided that FMDQ Exchange shall give reasonable notice of such examination or review. Such reasonable notice to be agreed between FMDQ Exchange and the Member.
                                        </div>
                                    </div> <br>
                                </li><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">11</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twelve">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="9">
                                <div class="dictionary">
                                    <p>8.2</p>
                                    <div>
                                        FMDQ Exchange shall ensure the confidentiality of documents provided under 8.1 above and not to disclose its content except as required by any law, rule, regulation, order, and judgment of a competent court in Nigeria or for any other lawful purpose and shall notify the Member before such disclosure where practicable, and where it is impracticable to notify the Member prior to such disclosure, provide written notice to the Member promptly after disclosure.
                                    </div>
                                </div> <br>
                                <li><strong>Transaction Fees</strong><br><br>
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
                                </li><br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">12</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-thirteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="12">
                                <li><strong>Code of Conduct</strong><br><br>
                                    <p>The Member shall comply with the code of conduct set out below when Trading on the Platform in addition to the code of conduct as contained in the Rule Book.</p><br>
                                    <div class="dictionary">
                                        <p>12.1</p>
                                        <div>
                                            <strong>General Duties of Integrity, Fair Dealing and Care</strong><br><br>
                                            <p>When Trading on the Platform, the Member shall use its best endeavours to:</p><br>
                                            <div>
                                                <p>12.1.1 observe high standards of integrity, market conduct and fair dealing;</p><br>
                                                <p>12.1.2 act with due skill, care and diligence;</p><br>
                                                <p>12.1.3 refrain from any act or conduct which is likely to mar the reputation of FMDQ Exchange;</p><br>
                                                <p>12.1.4 behave in a responsible manner when using the Platform and associated facilities provided by FMDQ Exchange;</p><br>
                                                <p>12.1.5 only use the Platform and associated facilities when there is a legitimate need to do so;</p><br>
                                                <p>12.1.6 when acting on behalf of clients in respect of a Product ensure that such client has been informed of the risk characteristics of the Product concerned;</p><br>
                                                <p>12.1.7 when dealing with FMDQ Exchange, ensure that its executive directors, and Authorised Representatives act in an honest, open, truthful, cooperative manner and not mislead or conceal any material matter;</p><br>
                                                <p>12.1.8 provide full and prompt responses to all requests for information by FMDQ Exchange in respect of Products or connected business thereto and provide access to all relevant books, records, audio logs and other forms of documentation in accordance with the provisions of any applicable law and/or regulation;</p><br>
                                                <p>12.1.9 take reasonable steps to ensure that its Authorised Representatives or any other individual designated as responsible for carrying out the trading activities are not under the influence of any prohibited drug or substance or under the influence of alcohol; and</p><br>
                                                <p>12.1.10 take reasonable steps to prevent any form of gambling or betting between its officers, employees, representatives, agents or any other individual or body corporate so designated amongst themselves or with the officers, employees, representatives, agents of any other trader or any member of the general public in respect of any Trading activity as provided by FMDQ Exchange.</p><br>
                                            </div>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">13</div>
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
                                    <p>12.2</p>
                                    <div>
                                        <strong>No Fraudulent or Misleading Conduct</strong><br><br>
                                        <p>In conducting business for itself or on behalf of its clients, the Member shall not engage in, or fail to take reasonable steps to prevent:</p><br>
                                        <div>
                                            <p>12.2.1 any action that has the effect, or may be expected to have the effect, of artificially and/or abnormally moving the price or value of any Product;</p><br>
                                            <p>12.2.2 entering artificial transactions or otherwise entering into or causing any artificial transaction;</p><br>
                                            <p>12.2.3 a fictitioustransaction or any other false data to FMDQ Exchange or causing such data to be inputted into any FMDQ Exchange System by reporting such fictitious transaction or false data whilst knowing the transaction or data to be fictitious or false;</p><br>
                                            <p>12.2.4 any illegal action or conduct that creates or is likely to create any false or misleading impression as to the market price or value of, any Product;</p><br>
                                            <p>12.2.5 any direct action or conduct that may mar the integrity and the transparency of FMDQ Exchange; </p><br>
                                            <p>12.2.6 activities prohibited by this Agreement or the FMDQ Exchange Rules and shall not agree or act in concert with, or provide any assistance to anybody corporate (whether or not a Member) with a view to carrying out acts prohibited by this Agreement or the Rule Book, or otherwise causing or contributing to a breach ofany Applicable Law by such other individual or body corporate;</p><br>
                                            <p>12.2.7 creating a misleading or false appearance of the trading volume or liquidity of any Product;</p><br>
                                            <p>12.2.8 making (alone or with others) any contrived transactions that may cause the price of any Product to rise, fall, or remain steady or ascribe any undue advantage to the Member or any other individual or body corporate;</p><br>
                                            <p>12.2.9 its Authorised Representatives from directly or indirectly employing any device, scheme or artifice to defraud any individual or bodycorporate, or engage in any act, practice, or course of business which operates or is likely to operate as a fraud or deception in any transaction with that body corporate involving the purchase or sale of Products;</p><br>
                                            <p>12.2.10 its Authorised Representatives from participating in any Insider Trading in relation to any Product or knowingly assist any other Member or any other body corporate to participate in any such Insider Trading; and</p><br>
                                        </div>
                                    </div>
                                </div> <br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">14</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-fifteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="12">
                                <div class="dictionary ml-20">
                                    <p></p>
                                    <div>
                                        <strong></strong>
                                        <p></p><br>
                                        <div>
                                            <p>12.2.11 its Authorised Representatives from engaging in personal dealings in Products traded on the Platform, whether directly or indirectly.</p><br>
                                        </div>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>12.3</p>
                                    <div>
                                        <strong>Responsibility for Transactions</strong><br><br>
                                        <div>
                                            <p>12.3.1 the Member agrees to be responsible (except for fraud committed by or in connivance with FMDQ Exchange) for, all transactions and/or business conducted on the FMDQ Exchange Platform using it’s approved and recognised electronic access code, and the password/security log-in details of its Authorised Representatives whether or not such transaction and/or business was duly approved by the authorised officers of the Member;</p><br>
                                            <p>12.3.2 the Member agrees to be solely responsible for the accuracy of quotes and orders entered on the FMDQ Exchange Platform through its Authorised Representatives;</p><br>
                                            <p>12.3.3 FMDQ Exchange shall ensure that the activities of any users of FMDQ Exchange advised trading Systems are auditable or identifiable at any time. FMDQ Exchange shall ensure that the trading System has the capability and capacity to show the activity log of any user of the System. FMDQ Exchange shall provide this log of user activity to the Member at any time upon request. FMDQ Exchange hereby absolves the Member from liability for any loss suffered by it due to the absence of this functionality; and</p><br>
                                            <p>12.3.4 FMDQ Exchange shall, in conjunction with the vendors, take reasonable steps to facilitate the implementation of automatic restrictions to the access of intending users after a number of invalid log-in attempts.</p><br>
                                        </div>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>12.4</p>
                                    <div>
                                        <strong>Degradation of Service</strong><br><br>
                                        <p>When using the System and associated facilities, the Member is prohibited from engaging in practices which may cause degradation of the service or give rise to a disorderly market. Such practices include, but are not limited to, submitting unwarranted or excessive electronic messages or requests to the system.</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>12.5</p>
                                    <div>
                                        <strong>Authorised Representatives of the Member</strong><br><br>
                                        <div>
                                            <p>The treasurers and compliance officers shall be the Member’s primary interface in its dealings with FMDQ Exchange.</p><br>
                                        </div>
                                    </div>
                                </div> <br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">15</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-sixteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="13">
                                <div class="dictionary ml-20">
                                    <p></p>
                                    <div>
                                        <strong></strong>
                                        <p></p><br>
                                        <div>
                                            <p>12.5.2 The Member shall be responsible for the actions of the Authorised Representatives.</p><br>
                                            <p>12.5.3 Persons designated to act as Authorised Representatives shall be approved by FMDQ Exchange after they have met the specified competency requirements as may be laid down by FMDQ Exchange from time to time.</p><br>
                                            <p>12.5.4 FMDQ Exchange may upon notice to the Member decline to recognise any Authorised Representative or terminate the status of a Authorised Representative if upon investigation the Authorised Representative is determined to have acted in an unethical manner or no longer fit and proper to act in that capacity;</p><br>
                                            <p>12.5.5 The Member shall make adequate arrangements to ensure that all its Authorised Representatives are suitable, competent, knowledgeable, adequately trained and properly supervised.</p><br>
                                            <p>12.5.6 The Member shall have the responsibility and duty to ascertain by investigation the good character, business repute, qualifications, and experience of its Authorised Representatives;</p><br>
                                            <p>12.5.7 The Member shall also be responsible for ensuring that training programmes are designed to enhance their knowledge and competence in the type of transactions engaged in by the Member on the Platform;</p><br>
                                            <p>12.5.8 The Member shall notify FMDQ Exchange in writing within seven (7) Business Days of any change to the list of Authorised Representatives in its employment;and</p><br>
                                            <p>12.5.9 Pursuant to the immediately preceding paragraph, the Member shall within twenty-four (24) hours upon the departure of any Authorised Representative, be solely responsible for disabling the Authorised Representative’s access code to all FMDQ Exchange maintained trading Systems and facilities.</p><br>
                                        </div>
                                    </div>
                                </div> <br>
                                <li><strong>Member’s Obligations</strong><br><br>
                                    <p>The Member hereby agrees on a continuing basis, to:</p><br>
                                    <div class="dictionary">
                                        <p>13.1</p>
                                        <div>
                                            <p>abide by the Rule Book in force and as may be reasonably amended from time to time and promptly notified to the Member by FMDQ Exchange;</p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>13.2</p>
                                        <div>
                                            <p>pay the fees, dues and other applicable charges as set out in this Agreement prescribed by FMDQ Exchange according to the conditions established by FMDQ Exchange and promptly communicated to the Member;</p>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">16</div>
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
                                    <p>13.3</p>
                                    <div>
                                        <p>authorise FMDQ Exchange or its duly appointed agentsto carry out on-site examinations and investigations, during normal business hours, in any place of business of the Member or its Affiliate, and submit as soon as possible any information or document relating to this Agreement which FMDQ Exchange or its agents reasonably consider appropriate for purposes of such examinations and investigations, provided that FMDQ Exchange shall give reasonable notice of such examinations and investigations. Such reasonable notice to be agreed between FMDQ Exchange and the Members;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.4</p>
                                    <div>
                                        <p>comply with the technical requirements of the relevant trading System(s) and/or any other information technology system or network operated and advised by FMDQ Exchange;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.5</p>
                                    <div>
                                        <p>notify FMDQ Exchange immediately in writing of any material changes to the information submitted during the course of its membership application, including in particular (but not limited to) those in respect of the Member's authorisation, license or permission to conduct trading in Products;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.6</p>
                                    <div>
                                        <p>notify FMDQ Exchange (whenever it has become practical for the Member to do so) of any facts or circumstances which may affect the legal form or organisation of the Member or its trading activities on the Platform, including (but not limited to) any consolidation, reorganisation, merger, change of name, change of control or similar event to which the Member is or will become a Party and provide such additional information as FMDQ Exchange may reasonably require;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.7</p>
                                    <div>
                                        <p>immediately notify FMDQ Exchange as soon as it is served or becomes aware of any bankruptcy, insolvency, winding up, administration or equivalent event (including amicable settlement) in any relevant jurisdiction the Member is subject to or to which the Member is a Party;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.8</p>
                                    <div>
                                        <p>ensure that any description of its Membership or the services that it is able to provide, in the form and context in which it appears or is used, does not misrepresent the scope of the capacity which it enjoys as a Member on FMDQ Exchange;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.9</p>
                                    <div>
                                        <p>document, implement and maintain adequate internal procedures and controls in relation to its business on the Market;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.10</p>
                                    <div>
                                        <p>ensure that it takes reasonable steps to prevent off market quotes by its Authorised Representatives. Provided always that where it has knowledge of any circumstance justifying such off-market quote, it shall promptly notify FMDQ Exchange not later than thirty (30) minutes after becoming aware of such circumstance;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.11</p>
                                    <div>
                                        <p>ensure that any quote given by any of its Authorised Representatives is correct and firm (may be acted upon by the Party to whom the quote was given);</p>
                                    </div>
                                </div> <br>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">17</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-eighteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="14">
                                <div class="dictionary">
                                    <p>13.12</p>
                                    <div>
                                        <p>ensure that it does not transact or conclude any trades with a Broker (either domestic or offshore) either directly or indirectly in relation to the Products traded on the FMDQ Exchange Platform unless such Broker shall be duly licenced by FMDQ Exchange and registered with the Commission;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.13</p>
                                    <div>
                                        <p>ensure that it takes reasonable steps to prevent the operation of current accounts that act in any way as brokerage settlement accounts, for the Products traded on the FMDQ Platform by/for any individual or body corporate that is not licensed by FMDQ Exchange and/or registered with the Commission to carry out a trading or brokerage function but still brokers any of the Products;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.14</p>
                                    <div>
                                        <p>take reasonable steps to ensure that its Authorised Representatives do not participate in any form of Insider Trading in relation to any Product traded on FMDQ Exchange, or knowingly or with gross negligence assist any individual or body corporate to participate in any such Insider Trading;</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.15</p>
                                    <div>
                                        <p>ensure that documents, records, or any other material related to Trading howsoever called are kept strictly confidential except as may be required by any law, rule, regulation, order, or judgment of a competent court inNigeria</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.16</p>
                                    <div>
                                        <p>keep and maintain proper records and books of account in respect of all transactions carried out by it for a period to be advised by FMDQ Exchange and where not expressly advised, in accordance with FMDQ Exchange’s prevailing Rule Book</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.17</p>
                                    <div>
                                        <p>keep and retain all recordings of phone conversations, text messages and e- mails, based on which any transaction on the Platform was conducted for a period to be advised by FMDQ Exchange and where not expressly advised, in accordance with FMDQ Exchange’s prevailing Rule Book; and</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>13.18</p>
                                    <div>
                                        <p>promptly provide data and statistics which FMDQ Exchange may reasonably request from time to time.</p>
                                    </div>
                                </div> <br>
                                <li><strong>Segregation of Duties</strong><br><br>
                                    <div class="dictionary">
                                        <p>14.1</p>
                                        <div>
                                            <p>The Member hereby undertakes to use its best endeavors to comply with such minimum standards on internal control as may be reasonably prescribed and promptly communicated to the Member by FMDQ Exchange from time to time and shall ensure that its Authorised Representatives are regularly supervised while trading on the Platform. </p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>14.2</p>
                                        <div>
                                            <p>The internal control process shall provide for written procedures to be established,
                                                maintained, and enforced, which procedures are designed to supervise the particular
                                                transactions undertaken by each Authorised Representative. The procedures shall
                                                identify the supervisors and their titles.</p>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">18</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-ninteen">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="15">
                                <div class="dictionary">
                                    <p>14.3</p>
                                    <div>
                                        <p>The internal control process shall ensure the segregation of duties amongst the Member’s Authorised Representatives in line with best business practices as reasonably articulated and communicated to the Member by FMDQ Exchange from time to time.</p>
                                    </div>
                                </div> <br>
                                <li><strong>Standard Settlement Instructions</strong><br><br>
                                    <p>The Member shall provide its account details, wherein payment shall be made in its favour, for each Product traded by it. The Member may change such account details at any time subject to giving prior notice of not less than five (5) Business Days to FMDQ Exchange and all other Members.</p><br>
                                </li>
                                <li><strong>Trading Method</strong><br><br>
                                    <div class="dictionary">
                                        <p>16.1</p>
                                        <div>
                                            <p>Dealing Members shall only trade amongst themselves on the Platform via FMDQ Exchange advised Systems or any other medium or form as promptly prescribed by FMDQ Exchange. </p>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>16.2</p>
                                        <div>
                                            <p>The Member shall not make commercial use of the published prices and any related information on the Platform in any manner whatsoever without the written approval of FMDQ Exchange, such approval not to be unreasonably withheld or unnecessarily delayed.</p>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Trading Method</strong><br><br>
                                    <div class="dictionary">
                                        <p>17.1</p>
                                        <div>
                                            <p>The Member hereby acknowledges that FMDQ Exchange shall following a formal warning and a declaration that the Member has been found guilty of any alleged infraction after thorough investigation, have the power to take disciplinary action against it for any established violation of the Rule Book or any provision of this Agreement. In particular, FMDQ Exchange shall have the power to impose any of the followingpenalties on the Member and may as appropriate, report the disciplinary action to the relevant regulatory body: <br><br>
                                                <ol type="a" class="ml-40">
                                                    <li>Warnings</li><br>
                                                    <li>Fines</li><br>
                                                    <li>disqualification from the FMDQ Rebate Program;</li><br>
                                                    <li>non-consideration for FMDQ GOLD Award;</li><br>
                                                    <li>suspension on such terms and for such period as FMDQ Exchange may thinkfit;</li><br>
                                                    <li>revocation of the Authorised Representative status; or</li><br>
                                                    <li>expulsion from the Platform;</li><br>
                                                    <li>Public Censure.</li><br>
                                                </ol>
                                            </p>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">19</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="18">
                                <div class="dictionary">
                                    <p>17.2</p>
                                    <div>
                                        <p>The disciplinary powers referred to above may be exercised separately or concurrently. The exercise of such powers shall not prejudice any right that may be vested in FMDQ Exchange to seek legal redress against the Member in pursuance of enforcement of the disciplinary decision.</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>17.3</p>
                                    <div>
                                        <p>Where the Member is expelled, it shall forthwith lose all Trading rights on the Platform</p>
                                    </div>
                                </div> <br>
                                <li><strong>Termination of Membership</strong><br><br>
                                    <div class="dictionary">
                                        <p>18.1</p>
                                        <div>
                                            <p>The Member shall cease to be a member of FMDQ Exchange if:</p><br>
                                            <p>18.1.1 it gives FMDQ Exchange sixty (60) days’ notice in writing of its intention to terminate its membership. Such membership shall terminate at the expiration of the sixty (60) days’ notice and all trades to which the Member is a Party shall be delivered, settled, and/or cleared on the agreed settlement dates;</p><br>
                                            <p>18.1.2 it is wound up voluntarily;</p><br>
                                            <p>18.1.3 it has become insolvent;</p><br>
                                            <p>18.1.4 it is compulsorily wound up by order of the Court;</p><br>
                                            <p>18.1.5 the Commission and/or the CBN has revoked its registration/licence;</p><br>
                                            <p>18.1.6 it is unable to meet or has defaulted in its obligations under this Agreement;</p><br>
                                            <p>18.1.7 it is proven that it has acted in an unprofessional and unethical manner in the Market. </p><br>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>18.2</p>
                                        <div>
                                            <p>The Member hereby acknowledges that termination of its membership shall not prevent FMDQ Exchange from collecting any accrued fees, dues, fines or charges due or arising from this Agreement, the Rule Book or any other agreement between FMDQ Exchange and the Member. </p><br>
                                        </div>
                                    </div> <br>
                                    <div class="dictionary">
                                        <p>18.3</p>
                                        <div>
                                            <p>The Member hereby acknowledges that FMDQ Exchange reserves the right to apply to the Courts to recover any fees, dues, fines or charges due or arising from this Agreement upon termination of its membership and/or take all necessary steps to protect any investor until such a time that all reported claims have been settled. </p><br>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Dealing Room and Systems Security</strong><br><br>
                                    <div class="dictionary">
                                        <p>19.1</p>
                                        <div>
                                            <p>The Member hereby undertakes to ensure that the security of the Dealing Room is not compromised at any time. Accessto the Dealing Room and trading Systems shall only be to the Member’s authorised personnel. </p>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">20</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-one">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="20">
                                <div class="dictionary">
                                    <p>19.2</p>
                                    <div>
                                        <p>The Member hereby undertakes to ensure the security of the trading Systems. The Member shall be fully responsible for all its activities arising from access to the Systems through its access code.</p>
                                    </div>
                                </div> <br>
                                <div class="dictionary">
                                    <p>19.3</p>
                                    <div>
                                        <p>Members shall undertake to comply with the minimum requirements for information security and Straight-Through Processing (STP), as may be reasonably and promptly advised by FMDQ Exchange from time to time.</p>
                                    </div>
                                </div> <br>
                                <li><strong>Access Right to Trading Systems</strong><br><br>
                                    <div class="dictionary">
                                        <p>20.1</p>
                                        <div>
                                            <p>Trading on the Systems shall be by remote access through a web based, encrypted internet connection to the secure trading Systems and/or a virtual private network. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>20.2</p>
                                        <div>
                                            <p>FMDQ Exchange may grant the Member accessto the Platform provided it complies with the following requirements. The Member shall:</p><br>
                                            <p>20.2.1 meet the technical requirements reasonably determined and promptly communicated by FMDQ Exchange to the Memberfrom time to time and acquire the appropriate technical infrastructure required to gain access to the Platform;</p><br>
                                            <p>20.2.2 register Authorised Representatives responsible for Trading as prescribed by FMDQ Exchange; and</p><br>
                                            <p>20.2.3 conform and comply with any reasonable market access rules as may be prescribed and promptly communicated by FMDQ Exchange to the Member from time to time.</p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>20.3</p>
                                        <div>
                                            <p>Except as otherwise expressly permitted by FMDQ Exchange, all Trading between Dealing Members shall be conducted on FMDQ Exchange approved trading Systems. </p><br>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Use of the Trading Systems</strong><br><br>
                                    <div class="dictionary">
                                        <p>21.1</p>
                                        <div>
                                            <p>The Member hereby undertakes to obtain and maintain the appropriate Systems and technology at its own expense, to establish Straight-Through Processing (STP) for settlement and internal back-office integration. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>21.2</p>
                                        <div>
                                            <p>The Member shall also document and implement a robust disaster recovery programme.</p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>21.3</p>
                                        <div>
                                            <p>FMDQ Exchange shall from time to time specify and promptly communicate various trading parameters relating to the Platform. </p><br>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">21</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-two">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="22">
                                <li><strong>Restrictions on Use of Trading Systems</strong><br><br>
                                    <div class="dictionary">
                                        <p>22.1</p>
                                        <div>
                                            <p>For the purposes of all Products traded on the FMDQ Exchange Platform, the Member hereby agrees that it shall not permit any of its Authorised Representatives to:</p><br>
                                            <p>22.1.1 use the trading Systems for any purpose other than the purpose as approved and specified by FMDQ Exchange;</p><br>
                                            <p>22.1.2 use its access code, the trading Systems, or any software provided by FMDQExchange for any illegal purpose;</p><br>
                                            <p>22.1.3 allow the intrusion of any virus or malware to the trading Systems.</p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>22.2</p>
                                        <div>
                                            <p>The Member shall be responsible for any illegal use of the trading Systems in its custody or the intrusion of any virus or malware caused by such use. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>22.3</p>
                                        <div>
                                            <p>The Member hereby acknowledges FMDQ Exchange’s right to immediately disconnect access to the trading System if it reasonably believes that the access code belonging to theMember is being used for any purpose other than as approved by FMDQ Exchange, provided it promptly notifies the Member of such purpose prior to the disconnection and shall immediately reconnect the Member as soon as the reason for the disconnection no longer exists. </p><br>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Suspension of Trading</strong><br><br>
                                    <div class="dictionary">
                                        <p>23.1</p>
                                        <div>
                                            <p>The Member hereby acknowledges that FMDQ Exchange may in concert with other regulators decide to remove, reclassify, or suspend Trading in a Product on the Platform if:</p><br>
                                            <p>23.1.1 it reasonably believes that continuous trading will have an adverse effect on the Market; or</p><br>
                                            <p>23.1.2 an act of God or any other event outside the control of FMDQ Exchangeoccurs.</p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>23.2</p>
                                        <div>
                                            <p>Any suspension of Trading in any of the Products shall cease when the reasons for the suspension no longer exist and/or the interest of a fair and orderly market are best served by a resumption of Trading. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>23.3</p>
                                        <div>
                                            <p>A broadcast on the trading System and/or announcement on FMDQ Exchange’s website shall be made by FMDQ Exchange to give the Member reasonable notice of when trading in any Product is suspended and when such suspension is lifted. </p><br>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">22</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-three">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="24">
                                <li><strong>Confirmation of Trades</strong><br><br>
                                    <p>The Member shall ensure all transactions for Products are confirmed via any means to be agreed between FMDQ Exchange and the Members including but not limited to SWIFT and a letter within twenty-four (24) hours of trade execution. The confirmation shall contain in the minimum the following details:</p><br>
                                    <ol type="a">
                                        <li>the transaction and value dates;</li><br>
                                        <li>the description, tenor (where applicable) and the price;</li><br>
                                        <li>the transaction and settlement amounts; and</li><br>
                                        <li>any other details as may be advised by FMDQ Exchange from time to time.</li><br>
                                    </ol>
                                </li>
                                <li><strong>Reporting Requirements</strong><br><br>
                                    <div class="dictionary">
                                        <p>25.1</p>
                                        <div>
                                            <p>Every Member, in respect of all trades entered, shall comply with the reporting requirements as determined by FMDQ Exchange and advised by the SEC, DMO and CBN. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>25.2</p>
                                        <div>
                                            <p>Every Member shall report all voice trades. Voice trades are defined as trades executed via telephone and on other FMDQ Exchange authorised systems. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>25.3</p>
                                        <div>
                                            <p>Dealing Members may also be required to submit complete trade data as captured in FMDQ Exchange advised reporting templates at frequencies to be determined by FMDQ Exchange and advised by the SEC, DMO and CBN. </p><br>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Prohibition of Transactions with Suspended Members</strong><br><br>
                                    <p>The Member shall not trade with any Member whose membership rights have been suspended or revoked except as expressly approved in writing by FMDQ Exchange.</p><br>
                                </li>
                                <li><strong>Willingness to Promote FMDQ Exchange</strong><br><br>
                                    <p>The Member hereby agrees to:</p><br>
                                    <ol type="a" class="ml-20">
                                        <li>participate in market development sessions organised by FMDQ Exchange;</li><br>
                                        <li>attend functions organised by FMDQ Exchange upon receipt of a written invitation from FMDQ Exchange, including FMDQ Exchange members induction and other member related meetings;</li><br>
                                        <li>within the Member’s discretion, promote FMDQ Exchange as a market destination; and</li><br>
                                        <li>provide advice, feedback, and suggestions to FMDQ Exchange.</li><br>
                                    </ol>
                                </li>

                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">23</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-four">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="28">
                                <li><strong>Confidentiality and Data Protection</strong><br><br>
                                    <div class="dictionary">
                                        <p>28.1</p>
                                        <div>
                                            <p>The Parties shall treat as strictly confidential all Confidential Information and shall ensure that their respective authorised employees use the Confidential Information only for the performance of their obligations and the exercise of their rights under this Agreement. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>28.2</p>
                                        <div>
                                            <p>Each Party shall protect and adequately secure every data belonging to the other Party and shall prevent against the theft or disclosure of such data by its Affiliates, Directors, employees, subcontractors, agents, or any other individual or body corporate having access to the data through it. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>28.3</p>
                                        <div>
                                            <p>In the event that a Party learns of any theft, unauthorised use, disclosure, or threatened unauthorised use or disclosure of any Confidential Information, the Party shall notify the other Party of the particulars of such theft, unauthorised use or disclosure. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>28.4</p>
                                        <div>
                                            <p>The Parties undertake and agree to comply with the provisions of the Nigeria Data Protection Act, 2023 and the Nigeria Data Protection Regulation, 2019 issued by the National Information Technology Development Agency and any amendments thereto in respect of any Personal Data received pursuant to or in connection with this Agreement. </p><br>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Limitation of Liability</strong><br><br>
                                    <div class="dictionary">
                                        <p>29.1</p>
                                        <div>
                                            <p>The Parties hereby acknowledge that each Party shall have no liability or obligation to the other, without limitation for: </p><br>
                                            <p>29.1.1 the inability to use its trading Systems as a result of Market Disruptions not due to negligence on its part;</p><br>
                                            <p>29.1.2 occurrences that could not have been reasonably foreseen at the date of execution of this Agreement; and includes, but is not limited to, war whether declared or not, revolution, riot, strikes or other protestor action, insurrection, civil commotion, invasion, armed conflict and Act of God </p><br>
                                            <p>29.1.3 any loss or damage which may be suffered, or which may arise directly or indirectly as a result of activities in the Market not caused by FMDQ Exchange, its staff and agents; </p><br>
                                            <p>29.1.4 any act, error, failure, or omission on the part of FMDQ Exchange, acting reasonably including any loss or damage in respect of: <br><br>
                                                <div class="ml-40">
                                                    <p>29.1.4.1 the suspension, cancellation, interruption, or closure of the Market in compliance with directives or orders from any regulatory body in Nigeria; or</p><br>
                                                    <p>29.1.4.2 any inoperability of non-proprietary software or other equipment supplied to the Member and by third parties;</p><br>
                                                </div>
                                            </p><br>
                                        </div>
                                    </div> <br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">24</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-five">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="30">
                                <div class="dictionary">
                                    <p></p>
                                    <div class="ml-60">
                                        <p>29.1.5 the originality, accuracy or completeness of any Company information or market data provided by a third party; </p><br>
                                        <p>29.1.6 FMDQ Exchange’s reasonable decision to suspend or terminate the membership of the Member provided such suspension or termination is in strict compliance with the provisions of this Agreement, the Rule Book, SEC Rules, the ISA, CBN circulars and DMO guidelines; and </p><br>
                                        <p>29.1.7 any decision of FMDQ Exchange in the reasonable exercise of its powers; provided that such powers are specifically established under this Agreement. </p><br>
                                    </div>
                                </div> <br>
                                <li><strong>Indemnity</strong><br><br>
                                    <div class="dictionary">
                                        <p>30.1</p>
                                        <div>
                                            <p>The Member hereby undertakes to indemnify FMDQ Exchange against any claim or loss arising from its wrongful, negligent, or illegal trading activities on the Platform done in contravention of any provision of this Agreement or Rule Book. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>30.2</p>
                                        <div>
                                            <p>FMDQ Exchange hereby undertakes to indemnify the Member against any claim or loss arising from its violation of the terms of this Agreement. </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>30.3</p>
                                        <div>
                                            <p>The Member shall at all times during the subsistence of this Agreement maintain an insurance policy coverage as prescribed by SEC </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>30.4</p>
                                        <div>
                                            <p>The insurance policy shall include a cancellation rider providing that the insurer will promptly notify FMDQ Exchange if the bond is cancelled, terminated, or substantially modified </p><br>
                                        </div>
                                    </div>
                                    <div class="dictionary">
                                        <p>30.5</p>
                                        <div>
                                            <p>The Member hereby agrees to notify FMDQ Exchange in writing within twenty-four (24) hours of being aware that its insurance policy has expired, been cancelled, terminated, or substantially modified. </p><br>
                                        </div>
                                    </div> <br>
                                </li>
                                <li><strong>Notices</strong><br><br>
                                    <p>For the purpose of this provision, notices shall be conveyed via letters, emails, electronic broadcasts and/or via the regulatory update segment on the FMDQ website</p><br>
                                    <div class="dictionary">
                                        <p>31.1</p>
                                        <div>
                                            <p>The addresses for notices shall be as follows: </p><br>
                                            If to FMDQ Exchange: <br><br>
                                            <strong>Member Regulation Group</strong><br>
                                            FMDQ Securities Exchange Limited <br>
                                            Exchange Place <br>
                                            35 Idowu Taylor Street <br>
                                            Victoria Island <br>
                                            Lagos
                                        </div>
                                    </div>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">25</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-five">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="32">
                                <p></p>
                                <div class="dictionary">
                                    <p></p>
                                    <div class="ml-20">
                                        <p></p>
                                        OR via email: <a href="" style="color: #0A6AC8;">meg@fmdqgroup.com</a><br><br>
                                        If to the Member: <br><br>
                                        <strong>Managing Director</strong> <br>
                                        <i>{{ $details->name }}</i> <br>
                                        <i>{{ $details->address }}</i> <br>
                                    </div>
                                </div><br>
                                <li><strong>Binding Agreement</strong><br><br>
                                    <p>Notwithstanding any contrary agreement, both Parties agrees that this Agreement constitutes a legal, valid and binding agreement which shall be enforceable against it in accordance with its terms.</p><br>
                                </li>
                                <li><strong>Non-Waiver</strong><br><br>
                                    <p>No failure or delay by FMDQ Exchange to exercise any right, power or privilege hereunder shall operate as a waiver thereof nor shall any single or partial exercise of any right, power or privilege preclude any other or further exercise thereof, or the exercise of any other rights, power or privilege as herein provided.</p><br>
                                </li>
                                <li><strong>Severability</strong><br><br>
                                    <p>If any provision of this Agreement is declared by any judicial or other competent authority to be void or otherwise unenforceable, that provision shall be severed from this Agreement and the remaining provisions shall remain in force and effect. Provided that the Parties shall thereafter amend this Agreement in such reasonable manner so as to achieve, without illegality, the intention of the Parties, with respect to the severed provision.</p><br>
                                </li>
                                <li><strong>Governing Law</strong><br><br>
                                    <p>Notwithstanding any other agreement to the contrary, this Agreement and all amendments there to shall be governed by and construed in accordance with Nigerian law.</p><br>
                                </li>
                                <li><strong>Dispute Resolution</strong><br><br>
                                    <div class="dictionary">
                                        <p>36.1</p>
                                        <div class="">
                                            In the event of any dispute arising out of or under this Agreement, the Parties shall within five (5) Business Days from the date the dispute arose, engage in an amicable settlement of the dispute by mutual negotiation
                                        </div>
                                    </div><br>
                                    <div class="dictionary">
                                        <p>36.2</p>
                                        <div class="">
                                            Where the dispute is not resolved by mutual negotiation, the Parties shall in compliance with the provisions of the ISA, refer the matter to the Investment and Securities Tribunal for resolution.
                                        </div>
                                    </div><br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">26</div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-twenty-six">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="page-border-two" style="padding-top: 20px;align-items: flex-start;">
                        <div class="content" style="text-align: justify;">
                            <ol style="margin-left: 20px;" start="37">
                                <li><strong>Execution of Agreement</strong><br><br>
                                    <p>This Agreement shall be executed on behalf of the Member by any two (2) Director (s) or a Director and the Company Secretary of the Member. Where the Agreement is executed by any other representative of the Member, the Member must notify FMDQ Exchange in writing that such representative is authorised to execute this Agreement. </p><br>
                                </li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dmb-no">27</div>
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
                                    <p style="text-transform: uppercase"><strong>{{ $details->name }}</strong></p>
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
            <div class="dmb-no">28</div>
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
