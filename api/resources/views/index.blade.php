<!DOCTYPE html>
<!--
 * HTML-Sheets-of-Paper (https://github.com/delight-im/HTML-Sheets-of-Paper)
 * Copyright (c) delight.im (https://www.delight.im/)
 * Licensed under the MIT License (https://opensource.org/licenses/MIT)
-->
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Emulating real sheets of paper in web documents (using HTML and CSS)">
    <title>Sheets of Paper</title>
    <link rel="stylesheet" type="text/css" href="css/sheets-of-paper-a4.css">
    <style>
        * {
            font-family: "Calibri" !important;
            font-size: 11px !important;
        }

        .header {
            /* border: 2px solid red; */
            width: 100%;
            margin-bottom: 10px;
        }

        .address-info {
            /* border: 2px solid black; */
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .address p {
            margin: 0;
            font-size: 12px;
            font-weight: 500;
        }

        .receipt-header {
            /* border-radius: 5px; */
            color: white;
            background-color: #1D326D;
            font-size: 12px;
            height: 30px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        .vHeader {
            padding: 2px;
        }

        .vHeader p {
            margin: 0;
            text-align: left;
        }

        .table.one {
            margin-bottom: 10px;
            font-size: 14px;
        }

        ul {
            list-style-type: none;
        }

        .sn ol {
            margin: 0;
        }

        .description-col-2 {
            padding: 0;
        }

        .description-item p,
        .payment-info p {
            margin: 0;
        }

        .snno2 {
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .table.two {
            font-size: 14px;
        }

        .description-col-3 div {
            margin-top: 55px;
            text-align: right;
        }

        .description-col-3 p {
            margin: 0;
        }

        .description-col-4 div {
            margin-top: 55px;
            margin-bottom: 45px;
            text-align: right;
        }

        .dc4-2 {
            margin-top: 45px;
            /* margin-bottom: 20px; */
        }

        .table.three {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .table.four {
            text-align: center;
            margin-bottom: 5px;
        }

        .payment-info h4 {
            text-decoration: underline;
            margin: 0;
        }

        .footer {
            /* border: 2px solid red; */
            text-align: center;
            margin-top: 20px;
        }

        .tax-id-no {
            font-weight: 700;
            font-style: italic;
        }

        .footer-text {
            margin: 20px;
            font-size: 12px;
            font-weight: 700;
        }

    </style>
</head>

<body class="document">
    <div class="page" contenteditable="false">
        <section class="header">
            <div class="receipt-container">
                <div class="address-info">
                    <div class="address">
                        <p>Exchange Place, 35, Idowu Taylor Street, Victoria Island, Lagos</p>
                        <p>Email: info@fmdqgroup.com</p>
                        <p>Website: www.fmdqgroup.com</p>
                    </div>
                    <div class="logo"><img src="{{ asset('assets/invoice/img/logo.png') }}" alt="fmdqlogo" style="height: 50px;"></div>
                </div>
                <div class="receipt-header">
                    <h1>INVOICE FROM FMDQ SECURITIES EXCHANGE LIMITED</h1>
                </div>
                <!-- Here will go the body of the receipt -->
            </div>
        </section>
        <section class="table one">
            <table style="width: 100%;">
                <tr>
                    <th rowspan="5" style="width: 45%;" class="vHeader">
                        <p>Bill To:</p>
                        <p>FMDQ</p>
                        <p>Lagos</p><br><br><br><br>
                        <p>Attention: Damilare Oluwole</p>
                    </th>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td>December 1, 2023</td>
                </tr>
                <tr>
                    <td>Invoice Number:</td>
                    <td>FMDQ/BDD/120123/DMB-19</td>
                </tr>
                <tr>
                    <td>Our Contact:</td>
                    <td>Uju Iwuamadi</td>
                </tr>
                <tr>
                    <td>Tel:</td>
                    <td>+234 20-1-700-8555</td>
                </tr>
            </table>
        </section>
        <section class="table two">
            <table style="width: 100%;
				background-image: url('{{ asset('assets/invoice/img/fmdqlogo-blurred.svg') }}');
				background-position: center;
				background-repeat: no-repeat;
				background-size: contain;">
                <tr>
                    <th style="width: 5%;">S/N</th>
                    <th style="width: 55%;">Description</th>
                    <th style="width: 20%;">₦</th>
                    <th style="width: 20%;">₦</th>
                </tr>
                <tr style="height: 200px;">
                    <td class="sn">
                        <ol>
                            <li></li><br>
                            <li class="snno2"></li>
                        </ol>
                    </td>
                    <td>
                        <ul class="description-col-2">
                            <li>Dealing Member (Banks) - Commercial (National) - Application Fee (Non-Refundable)</li>
                            <br>
                            <li class="description-item">
                                <p>Dealing Member (Banks) - 2023 Membership Dues</p>
                                <p>50% Discount on 2023 Membership Dues</p>
                            </li>
                        </ul>
                    </td>
                    <td class="description-col-3">
                        <div>
                            <p class="dc3-1">2,000,000.00</p>
                            <p>(1,000,000.00)</p>
                        </div>
                    </td>
                    <td class="description-col-4">
                        <div>
                            <p>22,500,000.00</p>
                            <p class="dc4-2">1,000,000.00</p>
                        </div>
                    </td>
                </tr>
                <tr style="text-align: right;font-weight: 700;">
                    <td></td>
                    <td>Total</td>
                    <td></td>
                    <td>23,500,000.00</td>
                </tr>
                <tr style="text-align: right;font-weight: 700;">
                    <td></td>
                    <td>VAT</td>
                    <td></td>
                    <td>1,762,500.00</td>
                </tr>
                <tr style="text-align: right;font-weight: 700;">
                    <td></td>
                    <td>Amount Due</td>
                    <td></td>
                    <td>25,262,500.00</td>
                </tr>
            </table>
        </section>
        <section class="table three">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 30%;">Amount in Words</td>
                    <td style="width: 70%;">Twenty-Five Million, Two Hundred and Sixty-Two Thousand, Five Hundred Naira
                        Only</td>
                </tr>
            </table>
        </section>
        <section class="payment-info">
            <h4>Payment Information</h4>
            <p>▪ Bank Account Details</p>
            <table style="width: 100%;" class="table four">
                <tr style="color: white; background-color: #1D326D;">
                    <th>Account Name</th>
                    <th colspan="2">FMDQ Holdings PLC</th>
                </tr>
                <tr style="background-color: #969696;">
                    <th>Bank</th>
                    <th>Account Number</th>
                    <th>Sort Code</th>
                </tr>
                <tr>
                    <td>Access Bank PLC</td>
                    <td>0689977404</td>
                    <td>044151106</td>
                </tr>
                <tr>
                    <td>Zenith Bank PLC</td>
                    <td>1013859207</td>
                    <td>057150796</td>
                </tr>
            </table>
            <p>▪ In the case of online bank transfers, kindly specify payment reference by indicating the invoice number
            </p>
            <p>▪ All cheques payable to 'FMDQ Holdings PLC'</p>
        </section>
        <div class="footer">
            <p class="tax-id-no">Tax Identification Number: 22257679-0001</p>
            <p class="footer-text">Global Competitiveness * Operational Excellence * Liquidity * Diversity</p>
        </div>
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

        function applyPageBreaks() {
            applyManualPageBreaks();
            applyAutomaticPageBreaks(Config.pixelsPerInch, Config.pageHeightInCentimeter, Config.pageMarginBottomInCentimeter);

            document.querySelectorAll(".document .page").forEach(function(element) {
                if (!element.classList.contains("has-events")) {
                    element.addEventListener("blur", function() {
                        applyPageBreaks();
                    });

                    element.classList.add("has-events");
                }
            });
        }

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
