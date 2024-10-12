<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AFT</title>
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
            <h4>FMDQ SECURITIES EXCHANGE LIMITED FX TRADING CORPORATES AGREEMENT</h4>

            <table class="p2Table">
                <tr>
                    <td>
                        <p>
                            <strong>
                                We/I {{ $details->name }} (“Affiliate Member (Fixed Income)”) on the {{ formatDate($details->updated_at) }}
                                hereby agree to be an FX Trading Corporate on FMDQ Securities Exchange Limited (“FMDQ Exchange” or the
                                “Exchange”), a Securities Exchange organised under the laws of the Federal Republic of Nigeria (together,
                                the “Parties”), subject to the terms and conditions below
                            </strong>

                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p><strong>AS AN FX TRADING CORPORATE OF FMDQ WE UNDERTAKE TO:</strong></p>

                        <ol style="margin-left: -15px;">
                            <li>Abide by all the FMDQ Exchange Rules, Guidelines, Bulletins and such other regulation as FMDQ Exchange
                                may introduce to the market from time to time.</li><br>

                            <li>Abide by the provisions of the Foreign Exchange (Monitoring and Miscellaneous Provisions) Act 2004 and
                                all Circulars issued by the Central Bank of Nigeria (CBN) from time to time.</li><br>
                            <li>Use the FMDQ Thomson Reuters FX Trading System strictly for the purpose of engaging in FX trading
                                activities with CBN FX Authorised Dealers;.</li><br>

                            <li>Ensure that all our Authorised Representatives2 act in good faith in respect of all our affairs with the
                                Exchange and in relation to all activities as a Member on FMDQ Exchange.</li><br>

                            <li>Notify FMDQ Exchange immediately in writing of any material changes to the information submitted
                                during the course of our membership application.</li><br>

                            <li>Notify FMDQ Exchange of any facts or circumstances which may affect the legal form of our organisation
                                and any such occurrences that may affect our FX Trading Corporate membership status on the Exchange.</li><br>

                            <li>Promptly pay the annual subscription fee and other charges, where applicable, as may be prescribed by
                                the Exchange.</li><br>

                        </ol>
                    </td>
                </tr>

                <tr>
                    <td>
                        <p><strong>WE UNDERSTAND THAT:</strong></p>

                        <ol style="margin-left: -15px;" start="8">
                            <li>This membership category of FMDQ Exchange only grants the FX market Authorised participants access
                                to the FMDQ Thomson Reuters FX Trading System strictly for the purpose of engaging in FX trading
                                activities with CBN FX Authorised Dealers.</li><br>


                            <li>This membership category does not confer upon us participatory rights as a full Member of the Exchange,
                                but only allows us to engage in FX trading as outlined above.</li><br>

                            <li> In accessing the data and information provided via this portal, we agree that we will not, without the prior
                                written consent of the Exchange, sell, licence, sub-licence, distribute, lease or otherwise transfer or allow
                                the transfer of the data or information, or any backup copy, to third parties, or use the; data and
                                information in any manner inconsistent with the rights granted by way of the aforesaid access. Where the data or information is disseminated, or used in a manner that is prohibited, FMDQ Exchange reserves the
                                right to penalise erring entities in line with provisions laid down in its rules.</li><br>



                            <li>Payment of the annual subscription fee supports Affiliate Membership on the Exchange. Therefore, FMDQ
                                Exchange shall send a reminder via email, not less than thirty (30) days before the end of the subscription
                                period to confirm and validate renewal of membership towards a new susbscription period. In the event
                                that no payment in respect of the annual subscription fee is made and received by the end of the current
                                subscription period, Affiliate Membership on the Exchange shall be terminated and access to relevant
                                portals restricted. The Exchange is at the discretion to revise the subscription fee for the succeeding twelve
                                (12) month period by providing written notice to the Member not less than thirty (30) days prior to the
                                beginning of such twelve (12) month period.</li><br>

                        </ol>
                    </td>
                </tr>
                <div class="page-break"></div>

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
                                <strong> FX Trading (Corporate): {{ $details->name }} </strong></p>



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
