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
                                <p>AFFILIATE MEMBER (FIXED INCOME) APPLICATION FORM</p>
                            </div>
                        </div>
                        <div class="title" style="width: 25%; padding: 5px;">
                            <div class="title-item">
                                <strong>MAY 2021</strong>
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
                            <div style="border: 1px solid black;height: 85%;">
                                <table class="table-one">
                                    <tr style="background: #1d326d;color: white;">
                                        <th colspan="4" style="text-align: center;">
                                            <p>FMDQ SECURITIES EXCHANGE LIMITED</p>
                                            <p>AFFILIATE MEMBER (FIXED INCOME) APPLICATION FORM</p>
                                        </th>
                                    </tr>
                                    <tr style="height: 40px;background: #BFBFBF;">
                                        <td colspan="4" style="text-align: center;"><strong>BODY CORPORATE</strong></td>
                                    </tr>
                                    <tr style="height: 40px;">
                                        <td style="width: 30%;">Company Name:</td>
                                        <td colspan="3" style="width: 70%;padding-right: 10px;"></td>
                                    </tr>
                                    <tr style="height: 40px;">
                                        <td>RC Number:</td>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr style="height: 40px;">
                                        <td>Registered Office Address:</td>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr style="height: 40px;">
                                        <td>Town/City:</td>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr style="height: 40px;">
                                        <td>Date of Incorporation:</td>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr style="height: 40px;">
                                        <td>Place of Incorporation:</td>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr style="height: 40px;">
                                        <td>Nature of Business:</td>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr style="height: 40px;">
                                        <td>Company Telephone Number(s):</td>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr style="height: 40px;">
                                        <td>Company Email Address:</td>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr style="height: 40px;">
                                        <td>Company Websit Address:</td>
                                        <td colspan="3"></td>
                                    </tr>
                                    <tr style="height: 40px;background: #BFBFBF;">
                                        <td colspan="4" style="text-align: center;"><strong>REASON FOR SEEKING
                                                MEMBERSHIP (Please tick as appropriate)</strong></td>
                                    </tr>
                                    <tr style="height: 40px;">
                                        <td style="text-align: center;">Investor</td>
                                        <td style="text-align: center;">Research</td>
                                        <td style="text-align: center;">Education</td>
                                        <td style="text-align: center;">Other(s)</td>
                                    </tr>
                                    <tr style="height: 40px;">
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="pageNo-DocName">
                                <div class="pageNo" style="text-align: center;">1</div>
                                <div class="DocName" style="font-size: 13px;"><strong><i>FMDQ Exchange Affiliate Member (Fixed Income) Application Form</i></strong></div>
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
                        </div>
                        <div class="content">
                            <div>
                                <table class="table-two">
                                    <tr style="height: 27px;background: #1d326d;color: white;">
                                        <th colspan="2">KEY OFFICERS</th>
                                    </tr>
                                    <tr style="height: 27px;background: #DEEAF6;">
                                        <td colspan="2">MANAGING DIRECTOR/CHIEF EXECUTIVE OFFICER (MD/CEO)</td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td colspan="2">Name: </td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td>Email:</td>
                                        <td>Telephone/Mobile No.:</td>
                                    </tr>
                                    <tr style="height: 27px;background: #DEEAF6;">
                                        <td colspan="2">CHIEF INVESTMENT OFFICER</td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td colspan="2">Name: </td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td>Email:</td>
                                        <td>Telephone/Mobile No.:</td>
                                    </tr>
                                    <tr style="height: 27px;background: #DEEAF6;">
                                        <td colspan="2">CHIEF DEALER</td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td colspan="2">Name: </td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td>Email:</td>
                                        <td>Telephone/Mobile No.:</td>
                                    </tr>
                                    <tr style="height: 27px;background: #DEEAF6;">
                                        <td colspan="2">COMPLIANCE OFFICER</td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td colspan="2">Name: </td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td>Email:</td>
                                        <td>Telephone/Mobile No.:</td>
                                    </tr>
                                    <tr style="height: 27px;background: #DEEAF6;">
                                        <td colspan="2">PRIMARY CONTACT</td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td colspan="2">Name: </td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td>Email:</td>
                                        <td>Telephone/Mobile No.:</td>
                                    </tr>
                                </table>
                                <table style="border-top: none;">
                                    <tr style="height: 27px;">
                                        <th colspan="2" style="border-top: none;background: #1d326d;color: white;">
                                            SUPPORTING DOCUMENTS<sup>1</sup> (TICK IF ENCLOSED)</th>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td style="width: 70%;padding-right: 10px;">Certificate of Incorporation</td>
                                        <td style="width: 30%;"></td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td style="width: 70%;padding-right: 10px;">Memorandum and Articles of
                                            Association</td>
                                        <td style="width: 30%;"></td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td style="width: 70%;padding-right: 10px;">Evidence of Payment of Application
                                            Fee and Membership Dues</td>
                                        <td style="width: 30%;"></td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td style="width: 70%;padding-right: 10px;">
                                            Company Profile
                                            <ul style="list-style-type: square;margin-left: 20px;">
                                                <li>Company Overview</li>
                                                <li>Details of Business Services</li>
                                                <li>Profile of Board of Directors and Executive Management</li>
                                                <li>Details of Technology Infrastructure</li>
                                            </ul>
                                        </td>
                                        <td style="width: 30%;"></td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td style="width: 70%;padding-right: 10px;">Any relevant documentation
                                            evidencing principal parties to the entity</td>
                                        <td style="width: 30%;"></td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td style="width: 70%;padding-right: 10px;">Particulars of Shareholders or other
                                            equivalent documentation <br> for Private Limited Companies(e.g. CAC Form 2
                                            for Nigerian <br> Private Limited Companies)</td>
                                        <td style="width: 30%;"></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="pageNo-DocName">
                                <div class="reference">
                                    <div class="top-line"></div>
                                    <sup>1</sup>Note: FMDQ Securities Exchange Limited (‘FMDQ Exchange’ or ‘the
                                    Exchange’) reserves the right to request additional information and documentation
                                    from time to time, where necessary. Upon successful filing of the above documents,
                                    the company will be required to execute a membership agreement with FMDQ Exchange
                                    before the registration can be complete
                                </div><br>

                                <div class="pageNo" style="text-align: center;">2</div>
                                <div class="DocName" style="font-size: 13px;"><strong><i>FMDQ Exchange Affiliate Member (Fixed Income) Application Form</i></strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-four">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="content-page-border-two">
                        <div class="top-logo">
                            <img src="assets/FMDQ-Logo 4.svg" alt="small-logo">
                        </div>
                        <div class="content">
                            <div>
                                <table style="border-top: none;">
                                    <tr style="height: 27px;">
                                        <td style="width: 70%;padding-right: 10px;">Evidence of registration with a
                                            regulatory authority, securities exchange or self-regulatory organisation
                                            (if applicable) </td>
                                        <td style="width: 30%;"></td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td style="width: 70%;padding-right: 10px;">Most recent one (1) year audited
                                            financial statements, not exceeding eighteen (18) months from end of the
                                            last financial yearIn the case of entities incorporated for less than one
                                            (1) year to the date of the application, FMDQ may at its discretion,
                                            consider the experience of the individual members of the Board or Management
                                            (should this apply, CVs of the Board or Management must be provided)</td>
                                        <td style="width: 30%;"></td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td style="width: 70%;padding-right: 10px;">Letter of introduction from an FMDQ
                                            Exchange-licenced Dealing Member (Bank) [Letter must be signed by the Chief
                                            Compliance Officer or an Executive Director of theDealing Member (Bank),
                                            attesting that due Know Your Customer has been carried out and that Bank
                                            Verification Number requirement is duly fulfilled]</td>
                                        <td style="width: 30%;"></td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td style="width: 70%;padding-right: 10px;">
                                            Details of Authorised Representatives in the FMDQ Exchange-advised template
                                            including but not limited to the following:
                                            <ol type="a">
                                                <li>MD/CEO, Principal or Managing Partner</li>
                                                <li>Chief Investment Officer (CIO) with a minimum of three (3) years’
                                                    fixed income trading experience (The MD/CEO may occupy the dual role
                                                    of the CIO) </li>
                                                <li>Compliance Officer</li>
                                                <li>Primary/Principal Contact Person (must be a separate person from the
                                                    MD/CEO and CIO)</li>
                                            </ol>
                                        </td>
                                        <td style="width: 30%;"></td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td style="width: 70%;padding-right: 10px;">
                                            Details of Authorised Representatives in the FMDQ Exchange-advised template
                                            including but not limited to the following:
                                            <ul style="list-style-type: square;margin-left: 20px;">
                                                <li>Name</li>
                                                <li>Qualification(s) </li>
                                                <li>Experience</li>
                                                <li>Date of appointment</li>
                                                <li>Previous positions held</li>
                                            </ul>
                                        </td>
                                        <td style="width: 30%;"></td>
                                    </tr>
                                    <tr style="height: 27px;">
                                        <td style="width: 70%;padding-right: 10px;">Information in respect of any
                                            pending or past legal proceedings involving the institution</td>
                                        <td style="width: 30%;"></td>
                                    </tr>
                                    <tr>
                                        <td colspan="2">
                                            <p style="margin: 20px 0;"><strong><i>Email submission of documents MUST be
                                                        made to <span><a href="" style="color: blue;">meg@fmdqgroup.com</a></span></i></strong>
                                            </p>
                                            <p style="margin-bottom: 20px;">Physical copies may be sent to :</p>
                                            <p style="margin-bottom: 20px;">
                                                Member Regulation Group <br>
                                                FMDQ Securities Exchange Limited <br>
                                                Exchange Place <br>
                                                35 Idowu Taylor Street <br>
                                                Victoria Island <br>
                                                Lagos <br>
                                                Nigeria <br>
                                            </p>
                                            <p style="margin-bottom: 50px;"><strong><i>Attention: Member Regulation
                                                        Group</i></strong></p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div>
                            </div>
                            <div class="pageNo-DocName">
                                <div class="pageNo" style="text-align: center;">3</div>
                                <div class="DocName" style="font-size: 13px;"><strong><i>FMDQ Exchange Affiliate Member
                                            (Fixed Income) Application Form</i></strong></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-five">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="content-page-border-two">
                        <div class="top-logo">
                            <img src="assets/FMDQ-Logo 4.svg" alt="small-logo">
                        </div>
                        <div class="content" style="border: 1px solid #000;height: 85%;">
                            <table style="margin-top: 50px;">
                                <tr style="background: #1d326d;color: white;text-align: center;">
                                    <th>APPLICANT DECLARATION</th>
                                </tr>
                                <tr>
                                    <td style="padding: 0 20px;">
                                        By submitting this application to become an Affiliate Member (Fixed Income) of
                                        FMDQ Securities Exchange Limited: <br><br>
                                        <ul style="margin-left: 20px;">
                                            <li>We declare that the information provided is complete and accurate and we
                                                agree, if approved, to comply with and be bound by all FMDQ Exchange
                                                Rules, Guidelines and such other regulation as may be in force from time
                                                to time</li> <br>
                                            <li>We shall notify FMDQ Exchange of any additional information which is
                                                relevant to the application and of any significant changes in the
                                                information provided in this application which occur after the date of
                                                submission of the application</li> <br>
                                            <li>We understand that misleading or attempting to mislead representatives
                                                of FMDQ Exchange during the application process shall render this
                                                application null and void</li> <br>
                                            <li>We agree that any entity within the FMDQ Group may have access to the
                                                information contained herein for marketing porposes</li>
                                        </ul>
                                    </td>
                                </tr>
                                <tr style="height: 100px;vertical-align: top;">
                                    <td style="padding: 0 20px;">Signature :</td>
                                </tr>
                                <tr style="background: #1d326d;color: white;text-align: center;">
                                    <td>SUBSCRIPTION FEE PAYMENT INFORMATION</td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 10px;">
                                        <p>
                                            Accepted Modes of Payment: Cheque/Bank Draft/Online Transfer <br><br>
                                            <i>All cheques are payable to "<strong>FMDQ SECURITIES EXCHANGE
                                                    LIMITED</strong>"</i><br><br>
                                            <strong>Account Details:</strong><br><br>
                                        </p>
                                        <table style="width: 40%;">
                                            <tr>
                                                <td>Bank</td>
                                                <td>Access Bank PLC</td>
                                            </tr>
                                            <tr>
                                                <td>account Name</td>
                                                <td>FMDQ Holdings PLC</td>
                                            </tr>
                                            <tr>
                                                <td>Account Number</td>
                                                <td>0689977404</td>
                                            </tr>
                                            <tr>
                                                <td>Sort Code</td>
                                                <td>044151106</td>
                                            </tr>
                                        </table>
                                        <p>
                                            In the case of online transfers, kindly specify payment reference in the
                                            format below: <br><br>
                                            <strong>"FMDQ Exchange/ (Category of Membership)/ (Company or Individual
                                                Name)/ (Payment Date: DD.MM.YYYY)"</strong><br><br>
                                            For example: FMDQ Exchange/Affiliate Member (Fixed Income)/OANDO/31.03.2021
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="pageNo-DocName">
                            <div class="pageNo" style="text-align: center;">4</div>
                            <div class="DocName" style="font-size: 13px;"><strong><i>FMDQ Exchange Affiliate Member
                                        (Fixed Income) Application Form</i></strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-six">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="content-page-border-two">
                        <div class="top-logo">
                            <img src="assets/FMDQ-Logo 4.svg" alt="small-logo">
                        </div>
                        <div class="content" style="display: block;">
                            <div class="content-header" style="text-align: center;"><strong>FMDQ SECURITIES EXCHANGE
                                    LIMITED AFFILIATE MEMBER (FIXED INCOME) MEMBERSHIP AGREEMENT</strong></div>
                            <p>
                                We <span class="user-input one"></span> (“Affiliate Member (Fixed Income)”) on this
                                <span class="user-input two"></span> day of <span class="user-input three"></span>
                                20<span class="user-input four"></span> hereby agree to be an Affiliate Member on FMDQ
                                Securities Exchange Limited
                                (“FMDQ Exchange” or the “Exchange”), a securities exchange organised under the laws of
                                the Federal
                                Republic of Nigeria (together, the “Parties”), subject to the terms and conditions below
                            </p><br>
                            <ol>
                                <li><strong style="text-decoration: underline;">Definitions:</strong><br><br>
                                    <p><strong> "Affiliate Member (Fixed Income)":</strong> small-to-medium sized
                                        institutions who participate as investors in the fixed income market through
                                        institutions duly registered with the Securities and Exchange Commission under
                                        the relevant capital market functions such as "FMDQ OTC Dealer", "Broker",
                                        "Dealer" or "Broker/Dealer". These small-to-medium sized institutions neither
                                        participate in the fixed income market as "Dealers" nor as "Traders". </p> <br>
                                    <p><strong>"Authorised Representatives": </strong>persons authorised by the
                                        FMDQ-registered Member to make representations to FMDQ Exchange on its behalf in
                                        respect of its membership on the FMDQ Exchange platform.</p>
                                </li><br>
                                <li><strong style="text-decoration: underline;">Understanding:</strong>
                                    <br><br>
                                    <p><strong>We understand that:</strong></p><br>
                                    <ol>
                                        <li>Affiliate Member (Fixed Income) membership category is granted access to online information on the Nigerian fixed income and currency markets through the FMDQ Exchange systems which contains information relating to, amongst other things, financial market news, fundamentals, tips and education, market & model prices and rates of FMDQ Exchange products, securities and instruments, contributed by
                                            various sources</li><br>
                                        <li>Affiliate Member (Fixed Income) membership category neither confer upon us participatory rights as a Dealing Member (as defined in the Investments and Securities Act 2007) of the Exchange nor voting right during FMDQ’s “Members’ only” meetings, but only allows us access to relevant FMDQ systems to facilitate, among others, relevant market data, best price execution, transparency and request response speed on FMDQ relevant fixed income products</li><br>
                                    </ol>
                                </li>
                                <li><strong style="text-decoration: underline;">Undertaking:</strong><br><br>
                                    <p><strong>As an Affiliate Member (Fixed Income) of FMDQ Exchange, we undertake to:</strong></p> <br>
                                    <ol>
                                        <li>Abide by all the FMDQ Exchange rules, guidelines, bulletins and such other regulation as FMDQ Exchange may introduce to the market from time to time</li><br>
                                        <li>Ensure that all our Authorised Representatives shall act in good faith in respect of all our affairs with FMDQ Exchange and in relation to all our activities as a Member on FMDQ
                                        </li><br>
                                        <li>Notify FMDQ Exchange immediately in writing of any material changes to the information submitted during the course of our membership application</li>
                                    </ol>
                                </li><br>
                            </ol>
                        </div>
                        <div class="pageNo-DocName">
                            <div class="pageNo" style="text-align: center;">5</div>
                            <div class="DocName" style="font-size: 13px;"><strong><i>FMDQ Exchange Affiliate Member
                                        (Fixed Income) Application Form</i></strong></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="page" contenteditable="false">
        <section class="page-seven">
            <div class="page-container">
                <div class="page-border-one">
                    <div class="content-page-border-two">
                        <div class="top-logo">
                            <img src="assets/FMDQ-Logo 4.svg" alt="small-logo">
                        </div>
                        <div class="content" style="display: block;">
                            <ol start="4">
                                <li>Notify FMDQ Exchange of any facts or circumstances which may affect the legal form of our organisation and any such occurrences that may affect our Affiliate Member (Fixed Income) membership status on FMDQ Exchange</li><br>
                                <li>Promptly pay the annual subscription fee and other charges, where applicable, as may be prescribed by the Exchange from time to time</li><br>
                                <li>Obtain written consent from FMDQ Exchange before we sell, licence, sub-licence, distribute, lease or otherwise transfer or allow the transfer of the data or information, or any backup copy, to third parties, or use the data and information in any manner inconsistent with the rights granted by way of the aforesaid access. Where the data or information is disseminated, or used in a manner that is prohibited, FMDQ Exchange reserves the right to penalise erring entities in line with provisions laid down in its rules</li><br>
                            </ol>
                            <p>The Parties have caused their Authorised Signatories to execute this Agreement in the manner below, the day and year first above written</p><br>
                            <p>Signed for and on behalf of </p><br>
                            <p><strong>FMDQ SECURITIES EXCHANGE LIMITED:</strong></p><br><br><br><br><br>
                            <div class="whole-signatory">
                                <div class="signatory-cont">
                                    <span class="signatory"></span>
                                    <div style="text-align: center;"><strong>Authorised Signatory</strong></div>
                                </div>
                                <div class="signatory-cont">
                                    <span class="signatory"></span>
                                    <div style="text-align: center;"><strong>Authorised Signatory</strong></div>
                                </div>
                            </div>
                            <div class="whole-name-designation flex-space-btw">
                                <div class="name-designation">
                                    <div><Strong>Name: </Strong><span></span></div>
                                    <div><Strong>Designation: </Strong><span></span></div>
                                </div>
                                <div class="name-designation">
                                    <div><Strong>Name: </Strong><span></span></div>
                                    <div><Strong>Designation: </Strong><span></span></div>
                                </div>
                            </div><br><br>
                            <p>Signed for and on behalf of</p>
                            <p>the aforementioned <strong> Affiliate Member (Fixed Income):</strong></p><br><br><br>
                            <div class="whole-signatory">
                                <div class="signatory-cont">
                                    <span class="signatory"></span>
                                    <div style="text-align: center;"><strong>Authorised Signatory</strong></div>
                                </div>
                                <div class="signatory-cont">
                                    <span class="signatory"></span>
                                    <div style="text-align: center;"><strong>Authorised Signatory</strong></div>
                                </div>
                            </div>
                            <div class="whole-name-designation flex-space-btw">
                                <div class="name-designation">
                                    <div><Strong>Name: </Strong><span></span></div>
                                    <div><Strong>Designation: </Strong><span></span></div>
                                </div>
                                <div class="name-designation">
                                    <div><Strong>Name: </Strong><span></span></div>
                                    <div><Strong>Designation: </Strong><span></span></div>
                                </div>
                            </div><br><br>
                        </div>
                        <div class="pageNo-DocName">
                            <div class="pageNo" style="text-align: center;">6</div>
                            <div class="DocName" style="font-size: 13px;"><strong><i>FMDQ Exchange Affiliate Member
                                        (Fixed Income) Application Form</i></strong></div>
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
