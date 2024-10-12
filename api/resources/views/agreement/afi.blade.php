<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AFI</title>
    <style>
        .page-break {
            page-break-after: always;
        }

        table.gTable {
            width: 100%;
            font-weight: lighter;
        }

        table.gTable tr td {
            text-transform: uppercase;
            text-align: center;
        }

        table.gTable,
        table.gTable>tbody>tr,
        table.gTable>tbody>tr>td {
            padding-top: 50px;
            padding-bottom: 50px;
        }

        table.p2Table {
            width: 100%;
        }

        table.p2Table th,
        table.p2Table td {
            text-align: left;
            padding: 2px;
            font-weight: lighter;
            font-size: 14px;
        }

        table.p2Table tr,
        table.p2Table td {
            width: 100%;
        }

        .padding-20>p,
        .padding-20>h4 {
            padding-left: 30px;
            padding-right: 30px;
        }

        .agreedTerm ol {
            list-style: none;
            counter-reset: num;
        }

        .agreedTerm ol li {
            counter-increment: num;
        }

        .agreedTerm ol li::before {
            content: "1."counter(num);
        }

        .agreedTerm ol li span {
            margin-left: 20px;
        }

        .nonAgency ol {
            list-style: none !important;
        }

        .nonAgency ol li::before {
            content: "";
        }


        .name-designation {
            width: 200px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .flex-space-btw {
            display: flex;
            justify-content: space-between;
        }

        .whole-signatory {
            display: flex;
            justify-content: space-between;
        }

        .signatory-cont {
            width: 200px;
        }

        .signatory {
            border-bottom: 1px solid #000;
            width: 200px;
            display: inline-flex;
        }

    </style>
</head>
<body>
    <div style="width: 700px;  box-sizing: border-box;">
        <div class="page">
            <table class="gTable">
                <tbody>
                    <tr>
                        <td>AFFILIATE MEMBER (FIXED INCOME) MEMBERSHIP AGREEMENT</td>
                    </tr>
                    <tr>
                        <td>BETWEEN</td>
                    </tr>
                    <tr>
                        <td>FMDQ SECURITIES EXCHANGE LIMITED</td>
                    </tr>
                    <tr>
                        <td>AND</td>
                    </tr>
                    <tr>
                        <td>{{ $details->name }}</td>
                    </tr>
                </tbody>
            </table>
            <div class="page-break"></div>
        </div>
        <div class="page">
            <h4>FMDQ SECURITIES EXCHANGE LIMITED AFFILIATE MEMBER (FIXED INCOME) MEMBERSHIP AGREEMENT </h4>



            <table class="p2Table">
                <tr>
                    <td>
                        <p>
                            <strong>
                                We/I {{ $details->name }} (“Affiliate Member (Fixed Income)”) on the {{ formatDate($details->updated_at) }}
                                hereby agree to be an Affiliate Member (Fixed Income) on FMDQ Securities Exchange Limited
                                (“FMDQ Exchange” or the “Exchange”), a securities exchange organised under the laws of the Federal
                                Republic of Nigeria (together, the “Parties”), subject to the terms and conditions below
                            </strong>

                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>1. Definitions:</strong></p>
                        <p><strong>"Affiliate Member (Fixed Income)":</strong> small-to-medium sized institutions who participate as investors in the fixed
                            income market through institutions duly registered with the Securities and Exchange Commission under the
                            relevant capital market functions such as "FMDQ OTC Dealer", "Broker", "Dealer" or "Broker/Dealer". These
                            small-to-medium sized institutions neither participate in the fixed income market as "Dealers" nor as "Traders".</p>

                        <p><strong>"Authorised Representatives":</strong> persons authorised by the FMDQ-registered Member to make representations
                            to FMDQ Exchange on its behalf in respect of its membership on the FMDQ Exchange platform.</p>
                    </td>
                </tr>

                <tr>
                    <td>
                        <p><strong>2. Understanding:</strong></p>
                        <p><strong> We understand that:</strong></p>

                        <ol style="margin-left: -15px;">
                            <li>Affiliate Member (Fixed Income) membership category is granted access to online information on the
                                Nigerian fixed income and currency markets through the FMDQ Exchange systems which contains
                                information relating to, amongst other things, financial market news, fundamentals, tips and education,
                                market & model prices and rates of FMDQ Exchange products, securities and instruments, contributed by
                                various sources.</li><br>

                            <li>Affiliate Member (Fixed Income) membership category neither confer upon us participatory rights as a
                                Dealing Member (as defined in the Investments and Securities Act 2007) of the Exchange nor voting right
                                during FMDQ’s “Members’ only” meetings, but only allows us access to relevant FMDQ systems to
                                facilitate, among others, relevant market data, best price execution, transparency and request response
                                speed on FMDQ relevant fixed income products.</li><br>
                        </ol><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>3. Undertaking:</strong></p>
                        <p><strong> As an Affiliate Member (Fixed Income) of FMDQ Exchange, we undertake to: </strong></p>

                        <ol style="margin-left: -15px;">
                            <li>Abide by all the FMDQ Exchange rules, guidelines, bulletins and such other regulation as FMDQ Exchange
                                may introduce to the market from time to time.</li><br>
                            <li>Ensure that all our Authorised Representatives shall act in good faith in respect of all our affairs with FMDQ
                                Exchange and in relation to all our activities as a Member on FMDQ.</li><br>
                            <li>Notify FMDQ Exchange immediately in writing of any material changes to the information submitted during
                                the course of our membership application.</li><br>
                            <li>Notify FMDQ Exchange of any facts or circumstances which may affect the legal form of our organisation
                                and any such occurrences that may affect our Affiliate Member (Fixed Income) membership status on
                                FMDQ Exchange.</li><br>
                            <div class="page-break"></div>

                            <li>Promptly pay the annual subscription fee and other charges, where applicable, as may be prescribed by
                                the Exchange from time to time.</li><br>
                            <li>Obtain written consent from FMDQ Exchange before we sell, licence, sub-licence, distribute, lease or
                                otherwise transfer or allow the transfer of the data or information, or any backup copy, to third parties, or
                                use the data and information in any manner inconsistent with the rights granted by way of the aforesaid
                                access. Where the data or information is disseminated, or used in a manner that is prohibited, FMDQ
                                Exchange reserves the right to penalise erring entities in line with provisions laid down in its rules;.</li><br>


                        </ol><br>
                    </td>
                </tr>

                <tr>
                    <td class="agreedTerm" style="">
                        <div class="nonAgency">

                            <h4>The Parties have caused their Authorised Signatories to execute this Agreement in the manner below, the
                                day and year first above written. </h4><br>


                            <h4>Signed for and on behalf of the within-named <br>
                                FMDQ SECURITIES EXCHANGE LIMITED:</h4>

                            <table>
                                <tr>
                                    <td style="width: 250; vertical-align: bottom;">
                                        <div class="">
                                            <div class="signatory-cont">
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
                                                <div>Authorised Signatory</div>
                                                <div><Strong>Name: </Strong><span></span></div>
                                                <div><Strong>Designation: </Strong><span></span></div>
                                            </div>
                                        </div>

                                    </td>
                                    <td style="width: 250px; vertical-align: top;">
                                        <div class="">
                                            <div class="signatory-cont">
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
                                                <div>Authorised Signatory</div>
                                                <div><Strong>Name: </Strong><span></span></div>
                                                <div><Strong>Designation: </Strong><span></span></div>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                            </table>



                            <p>
                                Signed for and on behalf of
                                the aforementioned <br>
                                <strong>d Affiliate Member (Fixed Income): {{ $details->name }} </strong></p>


                            <table>
                                <tr>
                                    <td style="width: 250; vertical-align: bottom;">
                                        <div class="">
                                            <div class="signatory-cont">
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
                                                <div>Authorised Signatory</div>
                                                <div><Strong>Name: </Strong><span></span></div>
                                                <div><Strong>Designation: </Strong><span></span></div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="width: 250px; vertical-align: top;">
                                        <div class="signatory-cont">
                                            <br>
                                            <br>
                                            <br>
                                            <br>
                                            <span class="signatory"></span>
                                        </div>
                                        <div class="name-designation">
                                            <div>Authorised Signatory</div>
                                            <div><Strong>Name: </Strong><span></span></div>
                                            <div><Strong>Designation: </Strong><span></span></div>
                                        </div>

                                    </td>
                                </tr>
                            </table>

                        </div>




                    </td>
                </tr>


            </table>


        </div>
    </div>

</body>

</html>
