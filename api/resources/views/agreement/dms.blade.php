<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>DMS</title>
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
                    <td>1. Definitions and Interpretation ................................................................................................................................ 3</td>
                </tr>
                <tr>
                    <td>2. Non-Agency Relationship....................................................................................................................................... 5</td>
                </tr>
                <tr>
                    <td>3. Transaction Fees .................................................................................................................................................... 5</td>
                </tr>
                <tr>
                    <td>4. Membership Dues ................................................................................................................................................. 5</td>
                </tr>
                <tr>
                    <td>5. Members Obligations .............................................................................................................................................. 5</td>
                </tr>
                <tr>
                    <td>6. Termination of Membership .................................................................................................................................... 7</td>
                </tr>
                <tr>
                    <td>7. Assignment of Trade Data Rights ........................................................................................................................... 7</td>
                </tr>
                <tr>
                    <td>8. Limitation of Liability ............................................................................................................................................. 7</td>
                </tr>
                <tr>
                    <td>9. Notices ..................................................................................................................................................................... 7</td>
                </tr>
                <tr>
                    <td>10. Binding Agreement ............................................................................................................................................... 7</td>
                </tr>
                <tr>
                    <td>11. Non-Waiver ........................................................................................................................................................... 8</td>
                </tr>
                <tr>
                    <td>12. Severability ........................................................................................................................................................... 8</td>
                </tr>
                <tr>
                    <td>13. Governing Law ................................................................................................................................................... 8</td>
                </tr>
                <tr>
                    <td>14. Dispute Resolution ............................................................................................................................................... 8</td>
                </tr>
            </table>
            <div class="page-break"></div>
        </div>
        <div class="page">
            <h4>THIS DEALING MEMBERSHIP AGREEMENT is dated {{ formatDate($details->updated_at) }}</h4>

            <table class="p2Table">
                <tr>
                    <td>
                        <h4>PARTIES</h4>
                        <p  style="text-align: justify;">
                            <strong>FMDQ SECURITIES EXCHANGE LIMITED (RC. NO. 1617162)</strong>, a company incorporated under
                            the laws of the Federal Republic of Nigeria with its principal place of business at 35 Idowu Taylor
                            Street, Victoria Island, Lagos, (hereinafter called <strong>“FMDQ Exchange”</strong> which expression shall where
                            the context so admits include its successors and assigns) of the first part.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <h4>AND</h4>
                        <p  style="text-align: justify;">
                            {{ $details->name }} (RC NO. {{ $details->rc_number }}), a company incorporated under the laws of the Federal Republic of Nigeria with its registered office at
                            {{ $details->address }} (the <strong>“Member”</strong> which expression shall where the context so admits
                            include its successors and assigns) of the second part.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td class="padding-20 background">
                        <h4>(1) BACKGROUND</h4>
                        <ol type="A" style="margin-left: 20px;">
                            <li  style="text-align: justify;">FMDQ Securities Exchange Limited (<strong>“FMDQ Exchange”</strong> or the <strong>“Exchange”</strong>) is a securities
                                exchange and self-regulatory organisation (<strong>“SRO”</strong>) licensed and regulated by the Securities
                                and Exchange Commission (<strong>“SEC”</strong> or the <strong>“Commission”</strong>).</li><br>
                            <li  style="text-align: justify;">The Exchange provides a Platform for the listing, quotation, noting, registration, trading, order execution, and trade reporting of fixed income, currency, and derivative products, inter alia. </li><br>
                            <li  style="text-align: justify;">The Member has indicated interest in becoming a Dealing Member (Specialist) of the Exchange with a view to actively participating in Trading Activities on the Exchange. </li><br>
                            <li  style="text-align: justify;"> By executing this Agreement, the Member agrees to be bound by the Rules (as defined below).</li>
                        </ol><br>

                    </td>
                </tr>
                <tr>
                    <td class=" padding-20 agreedTerm" style="">
                        <h4> AGREED TERMS</h4>
                        <h4>1. Definitions and Interpretation</h4>
                        <ol type="A" style="margin-left: 20px;">
                            <li  style="text-align: justify;">
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

                            <li  style="text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member shall not hold itself out to any individual or body corporate as being an agent of or otherwise representing or having the power in any way to act for or bind the Exchange unless expressly authorised in writing.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">2.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Proposed Member hereby agrees that:
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">3.1.1</td>
                                                                <td style="vertical-align: top; text-align: justify;">
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
                                                                <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member shall not hold itself out to any individual or body corporate as being an agent of or otherwise representing or having the power in any way to act for or bind the Exchange unless expressly authorised in writing.
                                            </td>
                                        </tr>
                                    </table>
                                </li>
                                <li>
                                    <table>
                                        <tr>
                                            <td style="width: 10px; vertical-align: top;">2.2</td>
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
                                                The Member undertakes to:
                                                <ol>
                                                    <li  style="text-align: justify;">5.1.1. Abide by the Exchange’s Rules, the SEC Rules, and such other Applicable Laws.</li><br>
                                                    <li  style="text-align: justify;">5.1.2. Pay the fees, dues, and other applicable charges as set out in this Agreement or as
                                                        prescribed by FMDQ Exchange according to the conditions established by FMDQ Exchange
                                                        and duly communicated to the Member.</li><br>
                                                    <li  style="text-align: justify;">5.1.3. Comply with the technical requirements of the relevant trading System(s) and/or any
                                                        other information technology system or network operated and advised by FMDQ Exchange.</li><br>
                                                    <li  style="text-align: justify;">5.1.4. Comply with such market standards, capacity requirements, capital or credit line
                                                        requirements as may be determined by FMDQ Exchange from time to time and accepts that the
                                                        Membership of the Exchange may be terminated for failure to meet the aforementioned.</li><br>
                                                    <li  style="text-align: justify;">5.1.5. Notify FMDQ Exchange of any facts or circumstances which may affect its Trading
                                                        Activities on the Platform.</li><br>
                                                    <li  style="text-align: justify;">5.1.6. Notify FMDQ Exchange immediately in writing of any material changes to the
                                                        information submitted during its membership application, including in particular (but not
                                                        limited to) those in respect of the Members authorisation or permission to conduct trading in
                                                        Products.</li><br>
                                                    <li  style="text-align: justify;">5.1.7. Ensure that any quotes given by any of its Authorised Representatives are correct and
                                                        firm (may be acted upon by the counterparty to whom the quote was given).</li><br>
                                                    <li  style="text-align: justify;">5.1.8. Ensure that it does not transact or conclude any trades with a Broker (either domestic
                                                        or offshore) either directly or indirectly in relation to the Products traded on the FMDQ
                                                        Exchange Platform unless such Broker is duly licenced by FMDQ Exchange.</li><br>
                                                    <li  style="text-align: justify;">5.1.9. Prevent the operation of any account that serves as brokerage settlement accounts, for
                                                        the Products traded on the FMDQ Exchange Platform by/for any individual or body corporate
                                                        that is not licenced by FMDQ Exchange and/or registered with the Commission to carry out a
                                                        trading or brokerage function but still brokers any of the Products.</li><br>
                                                    <li  style="text-align: justify;">5.1.10. Maintain and take all necessary steps to ensure its Authorised Representatives maintain
                                                        the highest level of professional and ethical conduct in all its dealings with other Dealing
                                                        Member (Specialists), Dealing Member (Banks) and the Exchange and in respect of all its
                                                        activities on the Platform.</li><br>
                                                    <li  style="text-align: justify;">5.1.11. Take reasonable steps to ensure that its Authorised Representatives do not participate
                                                        in any form of Insider Trading in relation to its Trading Activities conducted on the Exchange,
                                                        or knowingly or by gross negligence assist any individual or body corporate to participate in
                                                        any such Insider Trading.</li><br>
                                                    <li  style="text-align: justify;">5.1.12. Maintain and preserve all recordings of phone conversations, text messages and emails, based on which any transaction on the Platform was conducted, for a period not less than
                                                        six (6) years or such other period as may be advised by FMDQ Exchange.</li><br>
                                                    <li  style="text-align: justify;">5.1.13. Report all trade data in respect of Products traded by the Member on the Platform in
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
                                            <td style="vertical-align: top; text-align: justify;">
                                                Membership of the Exchange shall be terminated where the Member:
                                                <ol>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">6.1.1.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    gives the Exchange fourteen (14) days’ notice in writing of its intention to terminate its
                                                                    membership of the Exchange. Consequently, the membership of the Exchange shall be terminated:
                                                                    <ol>
                                                                        <li>
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="width: 10px; vertical-align: top;">6.1.1.1.</td>
                                                                                    <td style="vertical-align: top; text-align: justify;">
                                                                                        at the expiration of the fourteen (14) days’ notice.
                                                                                    </td>
                                                                                </tr>
                                                                            </table>
                                                                        </li>
                                                                        <li>
                                                                            <table>
                                                                                <tr>
                                                                                    <td style="width: 10px; vertical-align: top;">6.1.1.2.</td>
                                                                                    <td style="vertical-align: top; text-align: justify;">
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
                                                                                    <td style="vertical-align: top; text-align: justify;">
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
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    defaults under this Agreement.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">6.1.3.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
                                                                    violates any provisions of the Rules.
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </li>
                                                    <li>
                                                        <table>
                                                            <tr>
                                                                <td style="width: 10px; vertical-align: top;">6.1.4.</td>
                                                                <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
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
                                            <td style="vertical-align: top; text-align: justify;">
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

                        </div>




                    </td>
                </tr>


            </table>


        </div>
    </div>

</body>

</html>
