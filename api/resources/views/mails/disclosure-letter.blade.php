<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="Emulating an invoice in web documents (using HTML and CSS)" />
    <title>E-Success Letter</title>
    <style>
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
    <div class="page" style="width: 700px;">
        <div style="padding: 30px">
            <div style="width: 100%; padding: 10px 20px; font-size: 14px">
                <div style="display: flex; align-items: center; justify-content: space-between; ">
                    <div style="color: #969698; float: left;">
                        <i>
                            <h3 style="margin: 0;">
                                FMDQ SECURITIES EXCHANGE LIMITED <br>
                                <span style="font-size: 13px; float: right;">RC:1617162</span>
                            </h3>
                        </i>
                    </div>
                    <div style="float: right;">
                        <img style="width: 250px;" src="{{ asset('assets/invoice/img/e_success_logo.png') }}" alt="fmdq logo">
                        {{-- <img style="width: 250px;" src="{{ public_path('assets/invoice/img/e_success_logo.png') }}" alt="fmdq logo"> --}}

                    </div>
                </div>
                <br><br>
                <div style="padding: 20px 20px">

                    {!! $content['body'] !!}

                </div>
            </div>
        </div>
    </div>

    <script>
        window.print()

    </script>
</body>
</html>
