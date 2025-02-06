<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DMB</title>
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
                        <td>DEALING MEMBERSHIP AGREEMENT</td>
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
            <h4>Table of Contents</h4>
            <table class="p2Table">
                <tr>
                    <td>1. Definitions and Interpretation .....................................................................................................................,........... 3</td>
                </tr>
                <tr>
                    <td>2. Market Standards ............................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>3. Trading Practice ............................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>4. Non-Agency Relationship ........................................................................................................................................ 3</td>
                </tr>
                <tr>
                    <td>5. Market Disruption .............................................................................................................................................. 3</td>
                </tr>
                <tr>
                    <td>6. Disclosure Requirements ........................................................................................................................................ 3</td>
                </tr>
                <tr>
                    <td>7. Anti-Money Laundering .......................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>8. Examination of Documents ....................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>9. Transaction Fees ............................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>10. Membership Dues ............................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>11. Rules and Guidelines .......................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>12. Code of Conduct ............................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>13. Member’s Obligations .......................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>14. Segregation of Duties ......................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>15. Standard Settlement Instructions .............................................................................................................................. 3</td>
                </tr>
                <tr>
                    <td>16. Trading Method ................................................................................................................................................ 3</td>
                </tr>
                <tr>
                    <td>17. Discipline of the Member ...................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>18. Termination of Membership ..................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>19. Dealing Room and Systems Security ............................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>20. Access Right to Trading Systems ...................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>21. {{ 'Use of the Trading Systems' }} ...................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>22. {{ 'Restrictions on Use of Trading Systems' }} .......................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>23. Suspension of Trading ................................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>24. Confirmation of Trades .................................................................................................................................................. 3</td>
                </tr>
                <tr>
                    <td>25. Reporting Requirements .................................................................................................................................................. 3</td>
                </tr>
                <tr>
                    <td>26. Prohibition of Transactions with Suspended Members .................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>27. Willingness to Promote FMDQ Exchange ....................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>28. Confidentiality ............................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>29. Limitation of Liability ....................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>30. Indemnity ..................................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>31. Notices ....................................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>32. Binding Agreement ............................................................................................................................................. 3</td>
                </tr>
                <tr>
                    <td>33. Non-Waiver .................................................................................................................................................... 3</td>
                </tr>
                <tr>
                    <td>34. Severability .................................................................................................................................................. 3</td>
                </tr>
                <tr>
                    <td>35. Governing Law ................................................................................................................................................. 3</td>
                </tr>
                <tr>
                    <td>36. Dispute Resolution ............................................................................................................................................ 3</td>
                </tr>
                <tr>
                    <td>37. Execution of Agreement ........................................................................................................................................ 3</td>
                </tr>

            </table>
            <div class="page-break"></div>
        </div>
        <div class="page">
            <h4>THIS DEALING MEMBERSHIP AGREEMENT is made the {{ formatDate($details->updated_at) }}</h4>


            <table class="p2Table">
                <tr>
                    <td>
                        <h4>BETWEEN</h4>
                        <p>
                            <strong>FMDQ SECURITIES EXCHANGE LIMITED (RC. NO. 1617162)</strong>, a company incorporated under
                            the laws of the Federal Republic of Nigeria with its principal place of business at Exchange Place, 35,
                            Idowu Taylor Street, Victoria Island, Lagos, (hereinafter called <strong>“FMDQ Exchange”</strong> which expression
                            shall where the context so admits shall include its successors and assigns) of the first part.

                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>AND</h4>
                        <p>
                            {{ $details->name }} (RC NO. {{ $details->rc_number }}), a company incorporated under the laws of the Federal
                            Republic of Nigeria with its registered office at {{ $details->address }}
                            (the <strong>“Member”</strong> which expression shall where the context so admits
                            include its successors and assigns) of the second part.
                        </p>
                        <p>
                            In this Agreement, FMDQ Exchange and the Member shall individually be referred to as a <strong>“Party”</strong> and
                            collectively be referred to as the <strong>“Parties”</strong>.
                        </p>
                    </td>
                </tr>

                <tr>
                    <td class="padding-20 background">
                        <h4>WHEREAS:</h4>
                        <ol type="A" style="margin-left: 20px;">
                            <li>
                                FMDQ Exchange is licensed by the Securities and Exchange Commission <strong>(“SEC”)</strong> as a
                                securities exchange and self-regulatory organisation with a Platform to enable the Member deal
                                in Products and carry out trading activities.
                            </li><br>
                            <li>The Member is a financial institution duly licensed by the Central Bank of Nigeria and has
                                indicated interest in becoming a Dealing Member on the FMDQ Exchange Platform with a view
                                to actively participating in trading activities on the said Platform. </li><br>
                            <li>The Member has agreed to be duly licenced by FMDQ Exchange as a Dealing Member. </li><br>
                            <li> Pursuant to the foregoing, the Parties hereby agree to be bound by the terms herein contained.</li>
                        </ol><br>
                    </td>
                </tr>

                <tr>
                    <td class="padding-20 agreedTerm">
                        <h4>IT IS HEREBY AGREED AND DECLARED as follows: -</h4>
                        <h4>1. Definitions and Interpretation</h4>
                        <div class="nonAgency">
                            <ol style="list-style: none;">
                                <li>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td style="width: 10px; vertical-align: top;">1.1.</td>
                                                <td style="vertical-align: top;">
                                                    Definitions
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="vertical-align: top;" colspan="2">
                                                    In this Dealing Membership Agreement hereto, unlessthe context otherwise requires, the
                                                    following expressions shall have the meanings set out hereunder: -
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Act or ISAA”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means the Investments and Securities Act, 2007 as may be
                                                    amended or supplemented from time to time;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Affiliate”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means an individual or body corporate that directly or indirectly
                                                    controls, is controlled by, or is under common control with, the
                                                    individual or body corporate specified. For the purpose of this
                                                    definition, the terms "controlled by" and "controls" mean the
                                                    possession, directly or indirectly, of the power to direct the
                                                    management or policies of an individual or body corporate,
                                                    whether through the ownership of shares, by contract, or
                                                    otherwise;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Agreement”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means this Dealing Membership Agreement as may be amended
                                                    or supplemented from time to time;

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Applicable Law”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means any law for the time being in force in Nigeria
                                                    (including statutory and common law), statute, constitution,
                                                    judgment, treaty, regulation, rule, by-law, order, decree, code of
                                                    practice, circular, directive, other legislative measure,
                                                    guidelines, guidance note, requirement, request or guideline or
                                                    injunction (whether or not having force of law and, to the extent
                                                    not having force of law, is generally complied with by persons
                                                    to whom it is addressed or applied) of or made by any
                                                    governmental authority, which is binding and enforceable;

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Broker”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means a body corporate that arranges transactions between a
                                                    buyer and a seller in return for a fee or commission when the
                                                    deal is executed;

                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Business Day”</strong></td>35 <td style="width: 500px; vertical-align: top;">
                                                    means a day (other than a Saturday, Sunday or a Federal
                                                    Government of Nigeria declared public holiday) on which
                                                    Dealing Members are open for general business in Nigeria;

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“CAMA” </strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means the Companies and Allied Matters Act, 2020, as may be
                                                    amended or supplemented from time to time;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“CBN”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means the Central Bank of Nigeria;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Commission”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means the Securities and Exchange Commission;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Company”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    has the meaning assigned to it in CAMA;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Confidential Information”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means any information, communications or data, about
                                                    the Parties, Dealing Member(s) or their respective affairs or
                                                    business in any form, whether oral, written,
                                                    graphic, or electromagnetic, including all plans, proposals,
                                                    forecasts, technical processes, methodologies, know-how,
                                                    information about technological or organisational systems,
                                                    customers, personnel, business activities, marketing, financial
                                                    research or development activities, databases, Intellectual
                                                    Property Rights, the terms and conditions of this Agreement and
                                                    other information in relation to it, whether or not it is
                                                    specifically marked confidential but excluding any information,
                                                    which:
                                                    <ol>
                                                        <li>
                                                            (i) was already known to the Recipient at the time of its
                                                            disclosure to the Recipient and is not subject to
                                                            confidentiality restrictions;
                                                        </li>

                                                        <li>
                                                            (ii) is in the public domain at the date of its disclosure to
                                                            the Recipient or thereafter enters the public domain
                                                            through no fault of the Recipient (but only after it
                                                            becomes part of the public domain); or

                                                        </li>
                                                        <li>
                                                            (iii) is independently developed by the Recipient without
                                                            use or reference to the Disclosing Party’s confidential
                                                            information, as shown by documents and other
                                                            competent evidence in the receiving Party’s possession;

                                                        </li>
                                                        <li>
                                                            (iv) is required by law or regulation to be disclosed by the
                                                            Recipient, provided that the Recipient, where it is
                                                            reasonable in the circumstances,shall promptly give the
                                                            Disclosing Party written notice of such requirement
                                                            prior to any disclosure so that the Disclosing Party may
                                                            seek a protective order or other appropriate relief

                                                        </li>


                                                    </ol>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Court”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means the Federal High Court
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Dealing Member/Member” </strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means any financial institution which has been admitted to trade
                                                    on the Platform;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Dealing Room”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means the place set apart at the Member’s office by the
                                                    Member to carry on Trading in Products listed/registered on the
                                                    Platform, and other products;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Director”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    has the meaning assigned to it under the CAMA;
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong> “Disclosing Party”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means the Party disclosing an item of Confidential Information;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“DMO”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means Debt Management Office of the Federal Republic of
                                                    Nigeria;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“FMDA”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means the Financial Markets Dealers Association;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“FMDQ GOLD Award”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means a recognition of exceptional performance on the
                                                    securities exchange, exemplary compliance with its Rules and
                                                    contribution to the Nigerian market;
                                                </td>
                                            </tr>

                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“FMDQ Rebate Program”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means a collection of rewards to qualifying Members
                                                    that provide liquidity on the Platform;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Insider Trading”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means trading done by an individual or body corporate
                                                    or group of individuals or bodies corporate who being in
                                                    possession of some confidential and price sensitive information
                                                    not generally available to the public, utilises such information to
                                                    buy or sell Securities for the benefit of themselves or any other
                                                    individual or body corporate;

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Intellectual Property Rights”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    includes any patent, copyright, trademark, trade name, trade
                                                    secret, brand name, logo, corporate name, internet domain name
                                                    or industrial design, any registrations thereof and pending
                                                    applications therefor, any other intellectual property right
                                                    (including, without limitation, any know-how, trade secret,
                                                    trade right, formula, conditional or proprietary report or
                                                    information, customer or membership list, any marketing data,
                                                    and any computer program, software, database or data right),
                                                    and license or other contract relating to any of the foregoing,
                                                    and any goodwill associated with any business owning, holding
                                                    or using any of the foregoing;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Market”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means the market for Products tradable or traded on the FMDQ
                                                    Exchange Platform;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Market Disruption”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means any event which makes it impossible or
                                                    impracticable to conduct trades on the Platform, which
                                                    disruption may or may not be of a technical orSystems- related
                                                    nature, and is not caused by, or within the control of, any of the
                                                    Parties;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Netting Agreement”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means an agreement consolidating buy and sell
                                                    transactions amongst Members on the Platform such that net
                                                    payments become payable based on the outcome of the
                                                    combined transactions;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Personal Data”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    has the meaning contained in the Nigeria Data Protection, Act,
                                                    2023.
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Platform”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means the FMDQ Exchange-organised marketplace for listing,
                                                    registration, quotation, order execution, and trade reporting;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Product”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means any instrument, security, currency, or other contract
                                                    admitted by FMDQ Exchange for trading on the Platform,
                                                    Products shall be construed accordingly;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Public Censure”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means a public disciplinary action that constitutes a
                                                    formal expression of disapproval of a Member by FMDQ
                                                    Exchange. It includes but is not limited to newspaper
                                                    publications and posting on FMDQ Exchange website;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Recipient”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means the Party receiving an item of Confidential Information;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Rule Book”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means rules and regulations designed by FMDQ Exchange
                                                    (approved by the Commission, CBN and DMO) and advised to
                                                    the Members to govern the trading activities on the FMDQ
                                                    Exchange Platform and, shall include reasonable amendments
                                                    thereto that are made from time to time and promptly made
                                                    available to Dealing Members;

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Securities”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    has the meaning as is assigned to it in the Act,
                                                    and any rule or resolution made pursuant to the Act;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Securities Exchange”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means an exchange or approved trading facility such as
                                                    a commodity exchange, metal exchange, petroleum exchange,
                                                    options, future exchange, over the counter market, and other
                                                    derivatives exchanges;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“SEC Rules”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means the rules and regulations of the Commission issued
                                                    pursuant to the ISA, as may be amended from time to time;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Straight-Through Processing (STP)”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means the process that enables the execution of
                                                    Trading to be conducted without need for manual intervention;
                                                    subject to legal and regulatory restrictions;
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“SWIFT”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means a standardised communications platformused to facilitate
                                                    the transmission of data about financial transactions. Such
                                                    information includes (but is not limited to) confirmation of
                                                    trades;

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“System” </strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    means an electronic trading programme that allows Members
                                                    to submit trade-related data and fulfil contractual obligations
                                                    leading up to the clearing and settlement of executed trades.
                                                    Systems used on the FMDQ Exchange Platform include (but
                                                    are not limited to) Bloomberg E-bond Trading System,
                                                    Refinitiv Trading System, FMDQ OTC FX Futures Trading &
                                                    Reporting System. Trading systems may be different from the
                                                    clearing and settlement systems; and

                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="width: 200px !important; vertical-align: top;"><strong>“Act or ISAA”</strong></td>
                                                <td style="width: 350px; vertical-align: top;">
                                                    “Trading” means trading amongst Dealing Members as well as amongst
                                                    Dealing Members and clients.
                                                </td>
                                            </tr>


                                        </tbody>
                                    </table>
                                </li>



                            </ol><br>
                        </div>
                    </td>
                </tr>

                {{-- fdfdfdfdfdfd  --}}

                <tr style="display: none;">
                    <td class=" padding-20 agreedTerm" style="">
                        <h4> AGREED TERMS</h4>
                        <h4>1. Definitions and Interpretation</h4>
                        <ol type="A" style="margin-left: 20px;">
                            <li>
                                The following definitions shall apply in this Agreement:<br><br>
                                <span><strong>Agreement:</strong> this Dealing Membership Agreement, as may be revised, updated and/or amended
                                    from time to time.</span>
                                <br><br>
                                <span><strong>Applicable Law:</strong> any law, statute, code, ordinance, decree, rule or regulation (including rules
                                    and regulations of self-regulatory organisations) as may relate to the activities of the Member
                                    (as may be revised, updated and/or amended from time to time).</span>
                                <br><br>
                                <span><strong>Authorised Representative:</strong> means an employee, or such other person as may be authorised
                                    by the Member to perform activities on its behalf on the Exchange. Authorised Representatives
                                    include but are not limited to treasurers, dealers, compliance officers, treasury operations staff,
                                    treasury sales staff, risk officers and control & audit staff.</span>
                                <br><br>

                                <span><strong>Broker:</strong> an individual or body corporate that arranges transactions between a buyer and a seller
                                    of a Product in return for a fee or commission upon due execution of a trade/deal.
                                </span>
                                <div class="page-break"></div>
                                <span><strong>Business Day:</strong> a day (other than a Saturday, Sunday or Federal Government of Nigeria declared
                                    public holiday) on which banks are open for business in Nigeria.</span><br><br>
                                <span><strong>Dealing Member (Bank):</strong> a bank which has been admitted to trade on the Platform (as defined
                                    below). Dealing Member (Banks) shall serve as liquidity providers to Dealing Members
                                    (Specialists) on the Platform.</span><br><br>
                                <span><strong>Dealing Member (Specialist) or DMS:</strong> an investment banking firm, securities dealing firm or
                                    experienced fixed income dealer permitted to engage in Trading Activities (as defined below)
                                    on the Platform of the Exchange pursuant to terms of this Agreement and the Rules (defined
                                    below).</span><br><br>
                                <span><strong>Insider Trading:</strong> trading done by an individual or body corporate or group of individuals or
                                    bodies corporate who, being in possession of some confidential and price sensitive information
                                    not generally available to the public, utilising such information to buy or sell securities for the
                                    benefit of themselves or any other individual or body corporate.</span><br><br>
                                <span><strong>Market:</strong> the market for Products (as defined below) tradable or traded on the FMDQ Exchange
                                    Platform.</span><br><br>
                                <span><strong>National Assembly:</strong> the National Assembly of the Federal Republic of Nigeria.</span><br><br>
                                <span><strong>Platform:</strong> the FMDQ Exchange organised market place for listing, registration, quotation,
                                    noting, trading, order execution, and trade reporting of fixed income, currency and derivative
                                    products, inter alia.</span><br><br>
                                <span><strong>Product:</strong> any instrument, security, currency, or other contract admitted by FMDQ Exchange
                                    for trading on the Platform.</span><br><br>
                                <span><strong>Member:</strong> an individual or body corporate with demonstrable and recognised expertise,
                                    experience and knowledge in trading in one or more of the Products traded on the Platform as
                                    a Dealing Member (Specialist) (as defined above).</span><br><br>
                                <span><strong> Rules:</strong> rules, guidelines, bulletins, agreements and such other regulation relating to the Member
                                    as may be issued by the Exchange in its capacity as an SRO and advised to the Member from
                                    time to time.
                                    SEC Rules:</strong> rules and regulations issued by the SEC pursuant to the Investments and Securities
                                    Act 2007.</span><br><br>
                                <span><strong>System:</strong> the electronic trading programme around which the Platform is organised that allows
                                    the Proposed Member to submit trade-related data and fulfil contractual obligations leading up
                                    to the clearing and settlement of executed trades.</span><br><br>
                                <span><strong>Trading Activities:</strong> trading amongst Dealing Member (Specialists) and/or Dealing Member
                                    (Banks) in specific products advised by FMDQ Exchange.</span><br><br>
                                <span><strong>Year:</strong> a calendar year.</span><br><br>
                            </li><br>

                            <li>
                                Interpretation:<br><br>

                                <span>1.2.1. Words importing the singular number only shall include the plural and vice-versa and
                                    words importing the feminine gender only shall include the masculine gender and vice versa
                                    5
                                    and words importing persons shall include corporations, associations, partnerships and
                                    governments (whether federal, state or local), and the words “written” or “in writing” shall
                                    include printing, engraving, lithography or other means of visible reproduction.
                                </span>
                                <br><br>

                                <span>1.2.2. A reference to “Party” or “Parties” shall mean a party or parties to this Agreement.</span><br><br>
                                <span>1.2.3. The words “hereof,” “herein,” “hereby,” “hereto” and similar words refer to this entire
                                    Agreement and not any Clause, Schedule or other subdivision of this Agreement.</span><br><br>
                                <span>1.2.4. Defined terms appearing in this Agreement in upper case shall be given their meaning
                                    as defined, while the same terms appearing in lower case shall be interpreted in accordance
                                    with their plain English meaning.</span><br><br>
                                <div class="page-break"></div>

                                <span>1.2.5. References to any liability shall include actual, contingent, present or future liabilities.</span><br><br>
                                <span>1.2.6. A reference to FMDQ Exchange or the Member herein shall include reference to their
                                    respective successors and assigns.</span><br><br>
                                <span>1.2.7. Any money payable under this Agreement on a day that falls on a public holiday shall
                                    be paid on the next Business Day.</span><br><br>

                            </li><br>
                        </ol><br>


                        <div class="nonAgency">
                            <h4>2. Non-Agency Relationship</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">2.1</td>
                                            <td style="vertical-align: top;">
                                                The Member shall not hold itself out to any individual or body corporate as being an agent of or otherwise representing or having the power in any way to act for or bind the Exchange unless expressly authorised in writing.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">2.2</td>
                                            <td style="vertical-align: top;">
                                                The Member shall act as a principal in all its Trading Activities on the Platform without
                                                limitation, when trading, clearing or settling and be responsible to other Dealing Member
                                                (Specialists), Dealing Member (Banks) and the Exchange as a principal.
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>

                            <h4>3. Transaction Fees</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">3.1</td>
                                            <td style="vertical-align: top;">
                                                The Proposed Member hereby agrees that:
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">3.1.1</td>
                                                                <td style="vertical-align: top;">
                                                                    The Exchange shall charge and revise transaction fees at rates to be determined and
                                                                    agreed for transactions conducted on the Platform.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>

                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">3.1.2</td>
                                                                <td style="vertical-align: top;">
                                                                    It shall execute a Direct Debit Mandate authorising its bank to make periodic payments
                                                                    of transaction fees payable to FMDQ Exchange in the manner described in the form advised by
                                                                    FMDQ Exchange. Whenever transaction fees are revised by FMDQ Exchange and duly
                                                                    communicated to the Proposed Member, the Proposed Member shall be required to execute
                                                                    another Direct Debit Mandate to supersede the one previously executed.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                </ol>
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>
                            <h4>2. Non-Agency Relationship</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">2.1</td>
                                            <td style="vertical-align: top;">
                                                The Member shall not hold itself out to any individual or body corporate as being an agent of or otherwise representing or having the power in any way to act for or bind the Exchange unless expressly authorised in writing.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">2.2</td>
                                            <td style="vertical-align: top;">
                                                The Member shall act as a principal in all its Trading Activities on the Platform without
                                                limitation, when trading, clearing or settling and be responsible to other Dealing Member
                                                (Specialists), Dealing Member (Banks) and the Exchange as a principal.
                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>

                            <h4>4. Membership Dues</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">4.1.</td>
                                            <td style="vertical-align: top;">
                                                The Proposed Member undertakes to pay membership dues to FMDQ Exchange at a rate to be
                                                determined and agreed with FMDQ Exchange. The membership dues shall be payable
                                                immediately upon execution of this Agreement.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">4.2</td>
                                            <td style="vertical-align: top;">
                                                The Proposed Member shall execute a Direct Debit Mandate authorising its bank to make
                                                payment of subsequent membership dues payable to FMDQ Exchange in the manner described
                                                in the form advised by FMDQ Exchange. Whenever membership dues are revised by FMDQ
                                                Exchange and duly communicated to the Proposed Member, the Proposed Member shall be
                                                required to execute another Direct Debit Mandate to supersede the one previously executed.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">4.3</td>
                                            <td style="vertical-align: top;">
                                                No fees shall remain outstanding against the Member.
                                            </td>
                                        </tr>
                                    </table>
                                </li>


                            </ol>
                            <div class="page-break"></div>

                            <h4>5. Member’s Obligations</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">5.1.</td>
                                            <td style="vertical-align: top;">
                                                The Member undertakes to:
                                                <ol>
                                                    <li>5.1.1. Abide by the Exchange’s Rules, the SEC Rules, and such other Applicable Laws.</li><br>
                                                    <li>5.1.2. Pay the fees, dues, and other applicable charges as set out in this Agreement or as
                                                        prescribed by FMDQ Exchange according to the conditions established by FMDQ Exchange
                                                        and duly communicated to the Member.</li><br>
                                                    <li>5.1.3. Comply with the technical requirements of the relevant trading System(s) and/or any
                                                        other information technology system or network operated and advised by FMDQ Exchange.</li><br>
                                                    <li>5.1.4. Comply with such market standards, capacity requirements, capital or credit line
                                                        requirements as may be determined by FMDQ Exchange from time to time and accepts that the
                                                        Membership of the Exchange may be terminated for failure to meet the aforementioned.</li><br>
                                                    <li>5.1.5. Notify FMDQ Exchange of any facts or circumstances which may affect its Trading
                                                        Activities on the Platform.</li><br>
                                                    <li>5.1.6. Notify FMDQ Exchange immediately in writing of any material changes to the
                                                        information submitted during its membership application, including in particular (but not
                                                        limited to) those in respect of the Members authorisation or permission to conduct trading in
                                                        Products.</li><br>
                                                    <li>5.1.7. Ensure that any quotes given by any of its Authorised Representatives are correct and
                                                        firm (may be acted upon by the counterparty to whom the quote was given).</li><br>
                                                    <li>5.1.8. Ensure that it does not transact or conclude any trades with a Broker (either domestic
                                                        or offshore) either directly or indirectly in relation to the Products traded on the FMDQ
                                                        Exchange Platform unless such Broker is duly licenced by FMDQ Exchange.</li><br>
                                                    <li>5.1.9. Prevent the operation of any account that serves as brokerage settlement accounts, for
                                                        the Products traded on the FMDQ Exchange Platform by/for any individual or body corporate
                                                        that is not licenced by FMDQ Exchange and/or registered with the Commission to carry out a
                                                        trading or brokerage function but still brokers any of the Products.</li><br>
                                                    <li>5.1.10. Maintain and take all necessary steps to ensure its Authorised Representatives maintain
                                                        the highest level of professional and ethical conduct in all its dealings with other Dealing
                                                        Member (Specialists), Dealing Member (Banks) and the Exchange and in respect of all its
                                                        activities on the Platform.</li><br>
                                                    <li>5.1.11. Take reasonable steps to ensure that its Authorised Representatives do not participate
                                                        in any form of Insider Trading in relation to its Trading Activities conducted on the Exchange,
                                                        or knowingly or by gross negligence assist any individual or body corporate to participate in
                                                        any such Insider Trading.</li><br>
                                                    <li>5.1.12. Maintain and preserve all recordings of phone conversations, text messages and emails, based on which any transaction on the Platform was conducted, for a period not less than
                                                        six (6) years or such other period as may be advised by FMDQ Exchange.</li><br>
                                                    <li>5.1.13. Report all trade data in respect of Products traded by the Member on the Platform in
                                                        the manner prescribed and at the intervals advised by FMDQ Exchange.</li><br>


                                                </ol>

                                            </td>
                                        </tr>
                                    </table>
                                </li>

                            </ol>
                            <div class="page-break"></div>

                            <h4>6. Termination of Membership</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">6.1.</td>
                                            <td style="vertical-align: top;">
                                                Membership of the Exchange shall be terminated where the Member:
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">6.1.1.</td>
                                                                <td style="vertical-align: top;">
                                                                    gives the Exchange fourteen (14) days’ notice in writing of its intention to terminate its
                                                                    membership of the Exchange. Consequently, the membership of the Exchange shall be terminated:
                                                                    <ol>
                                                                        <li>
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="width: 10px; vertical-align: top;">6.1.1.1.</td>
                                                                                    <td style="vertical-align: top;">
                                                                                        at the expiration of the fourteen (14) days’ notice.
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </li>
                                                                        <li>
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="width: 10px; vertical-align: top;">6.1.1.2.</td>
                                                                                    <td style="vertical-align: top;">
                                                                                        when all trades to which the Member is a counterparty have been delivered,
                                                                                        settled and/or cleared on the agreed settlement dates; and
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </li>
                                                                        <li>
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="width: 10px; vertical-align: top;">6.1.1.3.</td>
                                                                                    <td style="vertical-align: top;">
                                                                                        when all fees and such other payments due and payable to FMDQ Exchange
                                                                                        have been delivered and settled.
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </li>

                                                                    </ol>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">6.1.2.</td>
                                                                <td style="vertical-align: top;">
                                                                    defaults under this Agreement.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">6.1.3.</td>
                                                                <td style="vertical-align: top;">
                                                                    violates any provisions of the Rules.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">6.1.4.</td>
                                                                <td style="vertical-align: top;">
                                                                    fails to meet the capacity requirements, minimum capital requirements and such other
                                                                    market standards as may be advised by FMDQ Exchange from time to time having been given
                                                                    reasonable time to remedy such deficiencies.

                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>


                                                </ol>

                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">6.2.</td>
                                            <td style="vertical-align: top;">
                                                All applicable disciplinary actions to be taken against the Members for violations of this
                                                Agreement and the Rules shall be as prescribed in the Rules.
                                            </td>
                                        </tr>
                                    </table>
                                </li>


                            </ol>

                            <h4>7. Assignment of Trade Data Rights </h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">7.1.</td>
                                            <td style="vertical-align: top;">
                                                The Member hereby agrees to assign to FMDQ Exchange all rights to the trade data acquired
                                                during the performance of its Trading Activities and other transactions with Dealing Member
                                                (Banks), other Dealing Member (Specialists) and clients.

                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>

                            <h4>8. Limitation of Liability </h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">8.1.</td>
                                            <td style="vertical-align: top;">
                                                In no event will FMDQ Exchange have any obligation or liability (whether in tort, contract,
                                                warranty or otherwise and notwithstanding any fault, negligence, product liability, or strict
                                                liability), for any indirect, incidental, special, or consequential damages, including but not
                                                limited to, lost revenue, loss of profits or business interruption losses, sustained or arising from
                                                or related to activities, trading or otherwise, carried out on the Exchange. This section shall
                                                survive the termination of this Agreement.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>
                            <h4>9. Notices </h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">9.1.</td>
                                            <td style="vertical-align: top;">
                                                For the purpose of this provision, notices shall be conveyed via letters, emails, electronic
                                                broadcasts and/or via the market bulletin segment on the FMDQ Exchange website.

                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>
                            <h4>10. Binding Agreement </h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">10.1.</td>
                                            <td style="vertical-align: top;">
                                                Notwithstanding any contrary agreement, both Parties agrees that this Agreement constitutes a
                                                legal, valid, and binding agreement which shall be enforceable against it in accordance with its
                                                terms.


                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>
                            <h4>11. Non-Waiver </h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">11.1.</td>
                                            <td style="vertical-align: top;">
                                                No failure or delay by FMDQ Exchange to exercise any right, power or privilege hereunder
                                                shall operate as a waiver thereof nor shall any single or partial exercise of any right, power or
                                                privilege preclude any other or further exercise thereof, or the exercise of any other rights,
                                                power or privilege as herein provided.


                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>
                            <div class="page-break"></div>

                            <h4>12. Severability </h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">12.1.</td>
                                            <td style="vertical-align: top;">
                                                If any provision of this Agreement is declared by any judicial or other competent authority to
                                                be void or otherwise unenforceable, that provision shall be severed from this Agreement and
                                                the remaining provisions shall remain in force and effect. Provided that the Parties shall
                                                thereafter amend this Agreement in such reasonable manner to achieve, without illegality, the
                                                intention of the Parties, with respect to the severed provision.

                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>
                            <h4>13. Governing Law</h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">13.1.</td>
                                            <td style="vertical-align: top;">
                                                This Agreement shall be governed by Nigerian law.


                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>
                            <h4>14. Dispute Resolution </h4>
                            <ol>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">14.1.</td>
                                            <td style="vertical-align: top;">
                                                In the event of any dispute arising out of or under this Agreement, the Parties shall within five
                                                (5) Business Days from the date the dispute arose, engage in an amicable settlement of the dispute
                                                by mutual negotiation.

                                            </td>
                                        </tr>
                                    </table>
                                </li>

                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">14.2.</td>
                                            <td style="vertical-align: top;">
                                                Where the dispute is not resolved by mutual negotiation, the Parties shall in compliance with
                                                the provisions of the Investment and Securities Act 2007, refer the matter to the Investment and
                                                Securities Tribunal for resolution.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                            </ol>

                            <h4>IN WITNESS WHEREOF the Parties have caused their authorised representatives to execute this
                                Agreement in the manner below, the day and year first above written </h4><br>

                            <h4>Signed for and on behalf of the within-named <br>
                                FMDQ SECURITIES EXCHANGE LIMITED:</h4>

                            <table>
                                <tr>
                                    <td style="width: 250px; vertical-align: bottom;">
                                        <div class="">
                                            <div class="signatory-cont">
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
                                                <div>Authorised Signatory</div>
                                                <div>Name: </div>
                                                <div>Designation: </div>
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
                                                <br>
                                                <br>
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
                                                <div>Authorised Signatory</div>
                                                <div>Name: </div>
                                                <div>Designation: </div>
                                            </div>
                                        </div>


                                    </td>
                                </tr>
                            </table>


                            <h4>Signed for and on behalf of the within-named <br>
                                <span style="text-transform: uppercase;">{{ $details->name }}</span>:</h4>

                            <table>
                                <tr>
                                    <td style="width: 250px; vertical-align: bottom;">
                                        <div class="">
                                            <div class="signatory-cont">
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <br>
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
                                                <div>Authorised Signatory</div>
                                                <div>Name: </div>
                                                <div>Designation: </div>
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
                                                <br>
                                                <br>
                                                <span class="signatory"></span>
                                            </div>
                                            <div class="name-designation">
                                                <div>Authorised Signatory</div>
                                                <div>Name: </div>
                                                <div>Designation: </div>
                                            </div>
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
