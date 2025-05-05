<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Emulating real sheets of paper in web documents (using HTML and CSS)">
    <title>Invoice</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/invoice/css/sheets-of-paper-a4.css') }}">
    <style>
        * {
            font-family: "Calibri" !important;
            font-size: 11pt !important;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }

            html,
            body {
                height: 100vh;
                margin: 0 !important;
                padding: 0 !important;
                overflow: hidden;
            }

            tr>td {
                color: black !important;
            }

            p {
                color: black !important;
            }
        }

        tr>td,
        p {
            color: black !important;
            font-weight: 700;
            z-index: 99999999;
        }

    </style>

    <script>
        // Trigger print dialog on page load
        window.onload = function() {
            // Uncomment the line below to automatically trigger the print dialog
            window.print();
        };

    </script>
</head>
<body class="document">
    <div class="page" contenteditable="false">
        <section class="header">
            <div class="receipt-container">
                <div class="address-info">
                    <div class="address">
                        <p>Exchange Place, 35 Idowu Taylor Street, Victoria Island, Lagos</p>
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
                        <p>{{$companyName}}</p>
                        <p>{{$address}}</p><br><br><br><br>
                        <p>Attention: {{$applicant->first_name}} {{$applicant->last_name}}</p>
                    </th>
                </tr>
                <tr>
                    <td>Date:</td>
                    <td>{{formatDate($invoice->created_at)}}</td>
                </tr>
                <tr>
                    <td>Invoice Number:</td>
                    <td>{{$invoice->invoice_number}}</td>
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
        <section class="table two" style="width: 100%;
				background-image: url('{{ asset('assets/invoice/img/fmdqlogo-blurred.svg') }}');
				background-position: center;
				background-repeat: no-repeat;
				background-size: contain;">
            <section>
                <table>
                    <tr>
                        <th style="width: 5%;">S/N</th>
                        <th style="width: 55%;">Description</th>
                        <th style="width: 20%;">₦</th>
                        <th style="width: 20%;">₦</th>
                    </tr>
                    @php
                    $i = 1;
                    @endphp
                    @foreach($invoiceContents as $invoiceContent)
                    @php

                    $subTotal = 0;
                    $name = strtolower($invoiceContent->name);
                    $children = invoiceChildren($invoiceContent->id);

                    if(count($children)){
                    $hasChildren = true;
                    }else{
                    $hasChildren = false;
                    }

                    @endphp

                    @if($name != "vat" && ! $invoiceContent->parent_id)
                    {{-- @if($name != "vat" && $name != "concession" && ! $invoiceContent->parent_id)  --}}
                    <tr style="height: 70px;">
                        <td style="text-align: center;">
                            {{$i}}
                        </td>
                        <td>
                            <p style="margin-bottom: -15px; text-transform: capitalize">{{$name}}</p>
                            @if($hasChildren)
                            @foreach($children as $child)
                            <p style="text-transform: capitalize">{{$child->name}}</p>
                            @endforeach
                            @endif
                        </td>
                        <td class="description-col-3">
                            @if($hasChildren == true)
                            @php
                            if($invoiceContent->type == 'credit'){
                            $subTotal -= $invoiceContent->value;
                            }

                            if($invoiceContent->type == 'debit'){
                            $subTotal += $invoiceContent->value;
                            }
                            @endphp

                            <p style="text-align: center;">{{formatNumber($invoiceContent->value)}}</p>

                            @foreach($children as $child)

                            @php
                            if($child->type == 'credit'){
                            $subTotal -= $child->value;
                            }

                            if($child->type == 'debit'){
                            $subTotal += $child->value;
                            }
                            @endphp
                            <p style="text-align: center;">({{formatNumber($child->value)}})</p>

                            @endforeach

                            @endif
                        </td>
                        <td style="text-align: center;">
                            @if($invoiceContent->type == 'credit')
                            {{ "-" }}
                            @endif

                            @if($hasChildren == false)
                            {{formatNumber($invoiceContent->value)}}
                            @endif
                            @if($subTotal > 0)
                            {{formatNumber($subTotal)}}
                            @endif
                        </td>
                    </tr>
                    @php
                    $i++;
                    @endphp
                    @endif
                    @endforeach

                    <tr style="text-align: right;font-weight: 700;">
                        <td></td>
                        <td colspan="2">Total</td>
                        {{-- <td></td>  --}}
                        <td>{{$total}}</td>
                    </tr>
                    <tr style="text-align: right;font-weight: 700;">
                        <td></td>
                        <td colspan="2">VAT</td>
                        {{-- <td></td>  --}}
                        <td>{{$vat}}</td>
                    </tr>
                    <tr style="text-align: right;font-weight: 700;">
                        <td></td>
                        <td colspan="2">Amount Due</td>
                        {{-- <td></td>  --}}
                        <td>{{$amountDue}}</td>
                    </tr>
                </table>
            </section>
        </section>
        <section class="table three">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 30%;">Amount in Words</td>
                    <td style="width: 70%; text-transform: capitalize">{{$amountInWords}} Naira Only</td>
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
                @php
                $accounts = fmdqAccountDetails();
                @endphp
                @if(isset($accounts))
                @foreach($accounts as $account)
                <tr>
                    <td>{{$account->bank_name}}</td>
                    <td>{{$account->account_number}}</td>
                    <td>{{$account->sort_code}}</td>
                </tr>
                @endforeach
                @endif
            </table>
            <p style="font-size: 13px;">▪ In the case of online bank transfers, kindly specify payment reference by indicating the invoice number</p>
            <p style="font-size: 13px;">▪ All cheques payable to 'FMDQ Holdings PLC</p>
        </section>
        <div class="footer">
            <p class="tax-id-no">Tax Identification Number: 22257679-0001</p>
            <p class="footer-text">Global Competitiveness * Operational Excellence * Liquidity * Diversity</p>
        </div>
    </div>
</body>
</html>
