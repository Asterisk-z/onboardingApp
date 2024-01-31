<!DOCTYPE html>

<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="Emulating real sheets of paper in web documents (using HTML and CSS)">
		<title>Sheets of Paper</title>
		<link rel="stylesheet" type="text/css" href="{{ asset('assets/invoice/css/sheets-of-paper-a4.css') }}">
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
						<td>+234 -1-2778771</td>
					</tr>
				</table>
			</section>		
			<section class="table two">
				<table style="width: 100%;">
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
								<li>Dealing Member (Banks) - Commercial (National) - Application Fee (Non-Refundable)</li><br>
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
						<td style="width: 70%;">Twenty-Five Million, Two Hundred and Sixty-Two Thousand, Five Hundred Naira Only</td>
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
				<p>▪ In the case of online bank transfers, kindly specify payment reference by indicating the invoice number</p>
				<p>▪ All cheques payable to 'FMDQ Holdings PLC'</p>
			</section>	
			<div class="footer">
				<p class="tax-id-no">Tax Identification Number: 11426626 - 0001</p>
                <p class="footer-text">Global Competitiveness * Operational Excellence * Liquidity * Diversity</p>
            </div>	
		</div>
	</body>
</html>
