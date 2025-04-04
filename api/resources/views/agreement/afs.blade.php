<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>AFS</title>
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
                        <td>AFFILIATE MEMBER (STANDARD - INDIVIDUAL) MEMBERSHIP AGREEMENT</td>
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
            <h4>FMDQ SECURITIES EXCHANGE LIMITED AFFILIATE MEMBERSHIP (STANDARD - INDIVIDUAL) AGREEMENT (THE “AGREEMENT”)</h4>


            <table class="p2Table">
                <tr>
                    <td>
                        <p style="text-align:justify;">
                            <strong>
                                I {{ $details->name }} (“Affiliate Member”) on the {{ formatDate($details->updated_at) }}
                                hereby agree to be an Affiliate Member of FMDQ Securities Exchange Limited
                                (“FMDQ Exchange” or the “Exchange”), a securities exchange organised under the laws of the
                                Federal Republic of Nigeria (together, the “Parties”), subject to the terms and conditions below.
                            </strong>

                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>AS AN AFFILIATE MEMBER OF FMDQ EXCHANGE, WE UNDERTAKE TO:</h4>
                        <ol style="margin-left: -15px;">
                            <li style="text-align:justify;">Abide by all the FMDQ Exchange Rules, Guidelines, Bulletins and such other regulation as FMDQ Exchange may introduce to the market from time to time.</li><br>
                            <li style="text-align:justify;">Ensure that all our Authorised Representatives1 act in good faith in respect of all our affairs with FMDQ Exchange and in relation to all activities as a Member on FMDQ Exchange. </li><br>
                            <li style="text-align:justify;">Notify FMDQ Exchange immediately in writing of any material changes to the information submitted during the course of our membership application. </li><br>
                            <li style="text-align:justify;"> Notify FMDQ Exchange of any facts or circumstances which may affect the legal form of our organisation and any such occurrences that may affect our Affiliate membership status on the Exchange.</li><br>
                            <li style="text-align:justify;">Promptly pay the annual subscription fee and other charges, where applicable, as may be prescribed by the Exchange</li><br>
                        </ol><br>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>WE UNDERSTAND THAT:</h4>
                        <ol style="margin-left: -15px;" start="6">
                            <li  style="text-align:justify;">
                                Affiliate membership is ideal for institutions and individuals with a keen interest in the FMDQ
                                Exchange markets, and an association with the financial markets, but not in a full participatory role as
                                a full member of the Exchange, taking advantage of FMDQ Exchange’s commitment to develop the
                                Nigerian financial markets via capacity building through knowledge and information.
                            </li><br>
                            <li  style="text-align:justify;">
                                Affiliate Members are granted access to online information on the Nigerian fixed income and currency
                                markets through the FMDQ “e-Markets” Portal which contains information relating to, amongst other
                                things, financial market news, fundamentals, tips and education, market and model prices and rates of
                                FMDQ Exchange products, securities and instruments, contributed by various sources
                            </li><br>
                            <li  style="text-align:justify;">
                                The information:
                                <ol type="I">
                                    <li  style="text-align:justify;">is obtained from a combination of sources including FMDQ Exchange and other third parties </li>
                                    <li  style="text-align:justify;">is aggregated and disseminated by FMDQ Exchange through the “e-Markets” Portal</li>
                                    <li  style="text-align:justify;">does not constitute professional, financial or investment advice</li>
                                    <li  style="text-align:justify;">is provided “AS IS” and on an “AS AVAILABLE” basis</li>
                                </ol>

                            </li><br>
                            <li  style="text-align:justify;">
                                FMDQ Exchange does not guarantee the accuracy, timeliness, completeness, performance, or fitness
                                for a particular purpose of any of the information, neither does FMDQ Exchange accept liability for the
                                results of any action taken on the basis of the information

                            </li><br>
                            <li  style="text-align:justify;">

                                In accessing the data and information provided via this portal, you acknowledge that the data and
                                information is and shall remain the property of FMDQ Exchange and agree that you will not, without
                                the prior written consent of the Exchange, sell, licence, sub-licence, distribute, lease or otherwise
                                transfer or allow the transfer of the data or information, or any backup copy, to third parties, or use ;the data and information in any manner inconsistent with the rights granted by way of the aforesaid access.
                                Where the data or information is disseminated, or used in a manner that is prohibited, FMDQ Exchange
                                reserves the right to penalise erring parties in line with provisions laid down in its rules or as may be
                                determined by the Exchange on a case-by-case basis.
                            </li><br>
                            <div class="page-break"></div>

                            <li  style="text-align:justify;">
                                FMDQ Exchange owns all rights, title and interest to the “e-Markets” Portal and all intellectual property
                                rights embodied in or associated with the portal, and this Agreement does not grant the Member any
                                intellectual property rights to the portal and its contents.
                            </li><br>
                            <li  style="text-align:justify;">
                                Payment of the annual subscription fee supports Affiliate Membership on the Exchange. Therefore,
                                FMDQ Exchange shall send a reminder via email, not less than thirty (30) days before the end of the
                                subscription period to confirm and validate renewal of membership towards a new subscription period.
                                In the event that no payment in respect of the annual subscription fee is made and received by the end
                                of the current subscription period, Affiliate Membership on the Exchange shall be terminated and
                                access to relevant portals restricted. The Exchange is at the discretion to revise the subscription fee for
                                the succeeding twelve (12) month period by providing written notice to the Member not less than thirty
                                (30) days prior to the beginning of such twelve (12) month period.
                            </li><br>
                            <li  style="text-align:justify;">
                                The Parties will comply with the provisions of the Nigeria Data Protection Regulation, 2019 issued by
                                the National Information Technology Development Agency and any amendments thereto in respect of
                                any personal data received pursuant to or in connection with this Agreement.
                            </li><br>
                            <li  style="text-align:justify;">
                                The Member agrees to hold harmless and indemnify FMDQ Exchange, its affiliates, officers, agents,
                                and employees, from and against any loss, damages or claim arising from the Member’s breach of the
                                terms of this Agreement.
                            </li><br>
                            <li>Notwithstanding any other agreement to the contrary, this Agreement and all amendments thereto shall
                                be governed by and construed in accordance with the laws of the Federal Republic of Nigeria.</li>
                        </ol>

                    </td>
                </tr>


                <tr>
                    <td class="agreedTerm" style="">
                        <div class="nonAgency">

                            <h4  style="text-align:justify;">The Parties have caused their Authorised Signatories to execute this Agreement in the manner below, the
                                day and year first above written. </h4><br>


                            <h4  style="text-align:justify;">Signed for and on behalf of the within-named <br>
                                FMDQ SECURITIES EXCHANGE LIMITED:</h4>

                            <table>
                                <tr>
                                    <td style="width: 250px; vertical-align: bottom;">
                                        <div class="">
                                            <div class="signatory-cont">
                                                <br>
                                                <br>
                                                <br>
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
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
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
                                                <div><Strong>Name: </Strong><span></span></div>
                                                <div><Strong>Designation: </Strong><span></span></div>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                            </table>



                            <p><strong style="text-decoration: underline">Individual: </strong> <br>
                                Signed by the aforementioned <br>
                                <strong>Affiliate Member: {{ $details->name }} </strong></p>

                            <table>
                                <tr>
                                    <td style="width: 400px; vertical-align: bottom;">
                                        <div class="">
                                            <div class="signatory-cont">
                                                <br>
                                                <br>
                                                <br>
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
                                                <div>Authorised Signatory</div><br>
                                                <div>Name:__________________________________________________</div><br>
                                                <div>Address:_______________________________________________</div><br>
                                                <div>Occupation:____________________________________________</div><br>
                                                <div>Signature:_____________________________________________</div><br>
                                                <div>Date:________________________________________________</div><br>
                                            </div>
                                        </div>

                                    </td>
                                    <td style="width: 20px; vertical-align: top;">

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
