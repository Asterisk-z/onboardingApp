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
                        <img src="assets/FMDQ-Logo 2.svg" alt="logo">
                        <div class="title">
                            <div class="title-item">
                                <strong>FMDQ SECURITIES EXCHANGE LIMITED</strong>
                                <p>AFFILIATE MEMBER (STANDARD) MEMBERSHIP AGREEMENT</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-two">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="content-page-border-two">
                        <div class="top-logo">
                            <img src="assets/FMDQ-Logo 4.svg" alt="small-logo">
                        </div>
                        <div class="content">
                            <div class="content-header"><strong>FMDQ SECURITIES EXCHANGE LIMITED AFFILIATE MEMBERSHIP
                                    (STANDARD) AGREEMENT</strong></div>
                            <p>
                                I/We <span class="user-input one"></span> (“Affiliate Member”) on this <span class="user-input two"></span> day of <span class="user-input three"></span> 20<span class="user-input four"></span> hereby agree to be an Affiliate Member on FMDQ
                                Securities Exchange Limited
                                (“FMDQ Exchange” or the “Exchange”), a securities exchange organised under the laws of
                                the Federal
                                Republic of Nigeria (together, the “Parties”), subject to the terms and conditions below
                            </p><br>
                            <div class="content-header sub-header"><strong>AS AN AFFILIATE MEMBER OF FMDQ EXCHANGE, WE
                                    UNDERTAKE TO:</strong></div>
                            <ol>
                                <li>Abide by all the FMDQ Exchange Rules, Guidelines, Bulletins and such other
                                    regulation as FMDQ Exchange may introduce to the market from time to time </li>
                                <li>Ensure that all our Authorised Representatives<sup>1</sup> act in good faith in
                                    respect of all our affairs with FMDQ Exchange and in relation to all activities as a
                                    Member on FMDQ Exchange</li>
                                <li>Notify FMDQ Exchange immediately in writing of any material changes to the
                                    information submitted during the course of our membership application</li>
                                <li>Notify FMDQ Exchange of any facts or circumstances which may affect the legal form
                                    of our organisation and any such occurrences that may affect our Affiliate
                                    membership status on the Exchange</li>
                                <li>Promptly pay the annual subscription fee and other charges, where applicable, as may
                                    be prescribed by the Exchange </li>
                            </ol><br>
                            <div class="content-header sub-header"><strong>WE UNDERSTAND THAT:</strong></div>
                            <ol start="6">
                                <li>Affiliate membership is ideal for institutions and individuals with a keen interest
                                    in the FMDQ Exchange markets, and an association with the financial markets, but not
                                    in a full participatory role as a full member of the Exchange, taking advantage of
                                    FMDQ Exchange’s commitment to develop the Nigerian financial markets via capacity
                                    building through knowledge and information</li>
                                <li>Affiliate Members are granted access to online information on the Nigerian fixed
                                    income and currency markets through the FMDQ “e-Markets” Portal which contains
                                    information relating to, amongst other things, financial market news, fundamentals,
                                    tips and education, market & model prices and rates of FMDQ Exchange products,
                                    securities and instruments, contributed by various sources</li>
                                <li>This information:
                                    <ol type="i" class="sublist">
                                        <li>is obtained from a combination of sources including FMDQ Exchange and other
                                            third parties</li>
                                        <li>is aggregated and disseminated by FMDQ Exchange through the “e-Markets”
                                            Portal</li>
                                        <li>does not constitute professional, financial or investment advice</li>
                                        <li>is provided “AS IS” and on an “AS AVAILABLE” basis
                                        </li>
                                    </ol>
                                </li>
                                <li>FMDQ Exchange does not guarantee the accuracy, timeliness, completeness,
                                    performance, or fitness for a particular purpose of any of the information, neither
                                    does FMDQ Exchange accept liability for the results of any action taken on the basis
                                    of the information</li>
                                <li> In accessing the data and information provided via this portal, you agree that you
                                    will not, without the prior written consent of the Exchange, sell, licence,
                                    sub-licence, distribute, lease or otherwise transfer or allow the transfer of the
                                    data or information, or any backup copy, to third parties, or use the data and
                                    information in any manner inconsistent with the rights granted by way of the
                                    aforesaid access. Where the data or information is disseminated, or used in a manner
                                    that is prohibited, FMDQ Exchange reserves the right to penalise erring entities in
                                    line with provisions laid down in its rules</li>
                            </ol><br>
                            <div class="reference">
                                <div class="top-line"></div>
                                <sup>1</sup> Authorised Representatives are persons authorised by the Member to make
                                representations to FMDQ Exchange on its behalf in respect of its membership on the FMDQ
                                Exchange platform
                            </div><br>
                            <div class="pageNo-DocName">
                                <div class="pageNo" style="text-align: center;">1</div>
                                <div class="DocName" style="font-size: 13px;"><strong><i>FMDQ Exchange Affiliate Member
                                            (Standard) Membership Agreement</i></strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-three">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="content-page-border-two">
                        <div class="top-logo">
                            <img src="assets/FMDQ-Logo 4.svg" alt="small-logo">
                        </div><br>
                        <div class="content">
                            <ol start="11">
                                <li>Payment of the annual subscription fee supports Affiliate Membership on the
                                    Exchange. Therefore, FMDQ Exchange shall send a reminder via email, not less than
                                    thirty (30) days before the end of the subscription period to confirm and validate
                                    renewal of membership towards a new susbscription period. In the event that no
                                    payment in respect of the annual subscription fee is made and received by the end of
                                    the current subscription period, Affiliate Membership on the Exchange shall be
                                    terminated and access to relevant portals restricted. The Exchange is at the
                                    discretion to revise the subscription fee for the succeeding twelve (12) month
                                    period by providing written notice to the Member not less than thirty (30) days
                                    prior to the beginning of such twelve (12) month period.</li>
                            </ol><br>
                            <p>The Parties have caused their Authorised Signatories to execute this Agreement in the
                                manner below, the day and year first above written.</p><br>
                            <div>
                                <p>Signed for and on behalf of</p>
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
                            <div style="text-decoration: underline;"><strong><i>Body Corporate:</i></strong></div>
                            <p>Signed by the aforementioned</p>
                            <p><strong>Affiliate Memeber:</strong></p><br><br>
                            <div class="signatory-cont">
                                <span class="signatory"></span>
                                <div style="text-align: left;"><strong>Authorised Signatory</strong></div>
                            </div><br>
                            <div class="witness-container">
                                <p><strong>In the presence of:</strong></p>
                                <div class="witness-item">Name: <span class="witness"></span></div>
                                <div class="witness-item">Address: <span class="witness"></span></div>
                                <div class="witness-item">Occupation: <span class="witness"></span></div>
                                <div class="witness-item">Signature: <span class="witness"></span></div>
                                <div class="witness-item">Date: <span class="witness"></span></div>
                            </div>
                            <div class="pageNo-DocName" style="margin-top: 95px;">
                                <div class="pageNo" style="text-align: center;">2</div>
                                <div class="DocName" style="font-size: 13px;"><strong><i>FMDQ Exchange Affiliate Member (Standard) Membership Agreement</i></strong></div>
                            </div>
                        </div>
                    </div>
                </div>
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
