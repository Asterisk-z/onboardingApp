<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta
      name="description"
      content="Emulating an invoice in web documents (using HTML and CSS)"
    />
    <title>Invoice</title>
    <style>
      .header{
      /* border: 2px solid red; */
      width: 100%;
      margin-bottom: 10px;
      }
      .address-info{
        /* border: 2px solid black; */
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
      }
      .address p{
        margin: 0;
        font-size: 12px;
        font-weight: 500;
      }
      .receipt-header{
        /* border-radius: 5px; */
        color: white;
        background-color: #1D326D;
        font-size: 12px;
        height: 30px;
        display: flex;
        justify-content: center;
        align-items: center;
      }
      table,th,td{
        border: 1px solid black;
        border-collapse: collapse;
      }
      .vHeader{
        padding: 2px;
      }
      .vHeader p{
        margin: 0;
        text-align: left;
      }
      .table.one{
        margin-bottom: 10px;
        font-size: 14px;
      }
      ul{
        list-style-type: none;
      }
      .sn ol{
        margin: 0;
      }
      .description-col-2{
        padding: 0;
      }
      .description-item p, .payment-info p{
        margin: 0;
      }
      .snno2{
        margin-top: 20px;
        margin-bottom: 20px;
      }
      .table.two{
        font-size: 14px;
      }
      .description-col-3 div{
        margin-top:55px ;
        text-align: right;
      }
      .description-col-3 p{
        margin: 0;
      }
      .description-col-4 div{
        margin-top:55px ;
        margin-bottom: 45px;
        text-align: right;
      }
      .dc4-2{
        margin-top: 45px;
        /* margin-bottom: 20px; */
      }
      .table.three{
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 10px;
      }
      .table.four{
        text-align: center;
        margin-bottom: 5px;
      }
      .payment-info h4{
        text-decoration: underline;
        margin: 0;
      }
      .footer{
        /* border: 2px solid red; */
        text-align: center;
        margin-top: 20px;
      }
      .tax-id-no{
        font-weight: 700;
        font-style: italic;
      }
      .footer-text{
        margin: 20px;
        font-size: 12px;
        font-weight: 700;
      }
    </style>
  </head>
  <body class="document">
    <div class="page">
      <div style="padding: 30px">
        <div style="width: 100%; padding: 10px 20px; font-size: 14px">
          <div
            style="
              display: flex;
              align-items: center;
              justify-content: space-between;
            "
          >
            <div style="color: #969698">
              <i
                ><h3>
                  FMDQ SECURITIES EXCHANGE LIMITED <br /><span
                    style="margin-left: 225px; font-size: 13px"
                    >RC:1617162</span
                  >
                </h3></i
              >
            </div>
            <div>
              <img
                style="width: 250px"
                src="{{ asset('assets/invoice/img/fmdqlogo-blurred.svg') }}"
                alt="fmdq logo"
              />
            </div>
          </div>
          <div style="padding: 20px 20px">
            <p>
              "<i><b>Date</b></i
              >"
            </p>
            <p>
              "<i><b>Designation</b></i
              >"
            </p>
            "<i><b>Address</b></i
            >"
            <p style="margin-top: 12px">Dear Sir/Madam,</p>
            <p>
              <b
                >APPLICATION FOR THE FMDQ SECURITIES EXCHANGE AFFILIATE
                MEMBER(FIXED INCOME) CATEGORY</b
              >
            </p>
            <p style="text-align: justify;
            text-justify: inter-word;">
              Having reviewed your application for the Affiliate Member (Fixed
              Income) category of FMDQ Securities Exchange Limited (“<b
                >FMDQ Exchange</b
              >”), we are pleased to inform you that your application is
              successful, and “<b>Member's full name</b>” will now be profiled
              on the <b>FMDQ e-Knowledge module</b>.
            </p>
            <p style="text-align: justify;
            text-justify: inter-word;">
              To gain access to the e-knowledge on the e-Markets portal, kindly
              update the details of a maximum of four (4) Authorised
              Representatives of your institution on the MROIS
              portal(“<b>link</b>”). Details should include the following:
            </p>
            <ul>
              <li>Name of Authorised Representative</li>
              <li>Official Email Address</li>
              <li>Telephone/Mobile number</li>
              <li>Department</li>
              <li>Designation</li>
            </ul>
            <p style="text-align: justify;
            text-justify: inter-word;">
              Authorised Representatives will be profiled within one (1)
              business day after receipt of the relevant details, following
              which each Authorised Representative will receive an email
              notification containing login details.
            </p>
            <p style="text-align: justify;
            text-justify: inter-word;">
              Attached for your records, is a copy of the executed FMDQ Exchange
              Membership Agreement between “<b><i>MEMBER'S FULL NAME</i></b
              >” and <b><i>FMDQ SECURITIES EXCHANGE LIMITED</i></b> for the
              above-mentioned membership category.
            </p>
            <p style="text-align: justify;
            text-justify: inter-word;">
              We thank you for your unwavering support and look forward to
              continuing a mutually beneficial relationship between our
              organisations.
            </p>
            <p style="margin: 30px 0">
              Yours faithfully, <br />
              <b>FMDQ Securities Exchange Limited</b>
            </p>
            <p>
              "<i><b>Name of DH, MOD</b></i
              >"
            </p>
            "<i><b>Grade</b></i
            >" <br />
            "<i><b>Division</b></i
            >"
          </div>
        </div>
      </div>
      <div
        style="
          border-top: 2px solid #969698;
          margin-top: 40px;
          text-align: center;
          padding: 10px 30px;
        "
      >
        <div style="font-size: 12px;">
            <i style="font-size: 11px;"><b>A Securities and Exchange Commission Registered Securities Exchange and Self-Regulatory Organisation (Member of  FMDQ Group)</b></i> <br>
            <i><span style="color: #1D326D;"><b>Exchange Place</b></span>, 35 Idowu Taylor Street, Victoria Island, Lagos, Nigeria.  W: www.fmdqgroup.com  T: +234-1- 7008555, 2778771, 2771719</i>
          <b
             style="padding: 0 20px;"><i
              >Chairman: Mr. Emeka Onwuka, OON; Vice Chairman: Mr. Kayode
              Akinkugbe; Managing Director: Ms. Tumi Sekoni Directors: Mr.
              Mobolaji Lawal, Mr. Mudassir Amray, Mr. Samuel Ocheho, Mr. Olumide
              Oyetan, Mr. Bola Onadele. Koko Ms. Kaodi Ugoji, Mr. Ayodele
              Onawunmi</i
            ></b
          >
        </div>
      </div>
    </div>
  </body>
</html>
