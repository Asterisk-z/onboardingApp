<?php

namespace App\Helpers;

use App\Models\Application;

class ESuccessLetter
{
    public static function generate(Application $application)
    {
        $content = null;
        $category = $application->membership_category_id;

        $data = Application::where('applications.id', $application->id);
        $application_data = Utility::applicationDetails($data);
        $application_data = $application_data->first();

        switch ($category) {
            case '1':
                $content = self::dmbWithoutSECLicenseLetterContent($application_data);
                break;

            default:
                // $content = [];
                $content = self::dmbWithoutSECLicenseLetterContent($application_data);
                break;
        }

        return $content;
    }

    protected static function dmbWithoutSECLicenseLetterContent($application)
    {
        $date = now();
        $designation = $application->applicationPrimaryContactName;
        $address = $application->registeredOfficeAddress;
        $companyName = $application->companyName;

        $url = config("app.front_end_url");

        return [
            'address' => "<p>'<i><b>$date</b></i>'</p>
                            <p>'<i><b>$designation</b></i>'</p>
                            <p>'<i><b>$address</b></i>'</p>",
            'title' => "<p><b>APPLICATION FOR THE FMDQ SECURITIES EXCHANGE LIMITED DEALING MEMBER (BANKS) CATEGORY</b></p>",
            'body' => "<p  style='text-align: justify;text-justify: inter-word;'>
                            Having reviewed your application for the Dealing Member (Bank) ('DMB')
                            category of FMDQ Securities Exchange Limited (“FMDQ Exchange”),
                            we are pleased to inform you that your application is successful, and
                            $companyName ($companyName) will now be profiled on the applicable modules on the
                            'FMDQ e-Markets portal' and e-Fixings (Real Time) sub-module, under the e-Benchmarks module.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Kindly update the details of a maximum of five (5) Authorised Representatives
                            of your institution on the MROIS portal($url).
                            Authorised Representatives will be profiled within one (1) business day after receipt of the relevant details,
                            after which you will receive an email containing your login details.
                            <br/>Details should include the following:
                        </p>
                        <ul>
                            <li>Name of Authorised Representative</li>
                            <li>Official Email Address</li>
                            <li>Telephone/Mobile number</li>
                            <li>Department</li>
                            <li>Designation</li>
                        </ul>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Please note that $companyName will be required to notify FMDQ Exchange prior to commencement of Two-way quote (2-WQ) trading activities for
                            the necessary introduction of $companyName to the 2-WQ Market as an FMDQ Exchange DMB and for the profiling of its Authorised Dealers on
                            FMDQ Exchange's recognised trading systems – FMDQ E-Bond Trading System & Refinitiv Foreign Exchange Trading system for Fixed Income and FX Trading Activities, respectively.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Further to the above, please note that the Investments and Securities Act 2007 requires all capital market operators to complete
                            registration with the Securities and Exchange Commission ('SEC' or the 'Commission') under the relevant functions they perform
                            and to this effect, $companyName will be required to complete registration with the Commission as an 'FMDQ Dealer'
                            no later than 'Six months from the approval date'.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            We congratulate you on this milestone and welcome you on board the FMDQ Exchange platform.
                        </p>

                        <p style='margin: 30px 0'>
                            Yours faithfully, <br />
                            <b>FMDQ Securities Exchange Limited</b>
                        </p>
                        <p >
                            '<i><b>Name of DH, MOD</b></i>'
                        </p>
                        <p>
                            '<i><b>Grade</b></i>' <br />
                            '<i><b>Division</b></i>'
                        </p>
                    "];
    }

    protected static function dmbWithSECLicenseLetterContent($application)
    {

        $date = now();
        $designation = $application->applicationPrimaryContactName;
        $address = $application->registeredOfficeAddress;
        $companyName = $application->companyName;

        $url = config("app.front_end_url");

        return [
            'address' => "<p>'<i><b>$date</b></i>'</p>
                            <p>'<i><b>$designation</b></i>'</p>
                            <p>'<i><b>$address</b></i>'</p>",
            'title' => "<p><b>APPLICATION FOR THE FMDQ SECURITIES EXCHANGE LIMITED DEALING MEMBER (BANKS) CATEGORY</b></p>",
            'body' => "<p  style='text-align: justify;text-justify: inter-word;'>
                            Having reviewed your application for the Dealing Member (Bank) ('DMB') category of FMDQ Securities Exchange Limited ('FMDQ Exchange'),
                            we are pleased to inform you that your application is successful, and $companyName ($companyName)
                            will now be profiled on the applicable modules on the 'FMDQ e-Markets portal' and e-Fixings (Real Time) sub-module, under the e-Benchmarks module.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Kindly update the details of a maximum of five (5) Authorised Representatives of your institution on the MROIS portal($url).
                            Authorised Representatives will be profiled within one (1) business day after receipt of the relevant details,
                            after which you will receive an email containing your login details. <br/> Details should include the following:
                        </p>
                        <ul>
                            <li>Name of Authorised Representative</li>
                            <li>Official Email Address</li>
                            <li>Telephone/Mobile number</li>
                            <li>Department</li>
                            <li>Designation</li>
                        </ul>
                        <p style='text-align: justify;text-justify: inter-word;'>
                        Please note that $companyName will be required to notify FMDQ Exchange prior to commencement of Two-way quote (2-WQ)
                        trading activities for the necessary introduction of $companyName to the 2-WQ Market as an FMDQ Exchange DMB and for
                        the profiling of its Authorised Dealers on FMDQ Exchange's recognised trading systems – FMDQ E-Bond Trading System & Refinitiv
                        Foreign Exchange Trading system for Fixed Income and FX Trading Activities, respectively.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            We congratulate you on this milestone and welcome you on board the FMDQ Exchange platform.
                        </p>

                        <p style='margin: 30px 0'>
                            Yours faithfully, <br />
                            <b>FMDQ Securities Exchange Limited</b>
                        </p>
                        <p >
                            '<i><b>Name of DH, MOD</b></i>'
                        </p>
                        <p>
                            '<i><b>Grade</b></i>' <br />
                            '<i><b>Division</b></i>'
                        </p>
                    "];
    }

    protected static function dmsLetterContent($application)
    {

        $date = now();
        $designation = $application->applicationPrimaryContactName;
        $address = $application->registeredOfficeAddress;
        $companyName = $application->companyName;

        $url = config("app.front_end_url");

        return [
            'address' => "<p>'<i><b>$date</b></i>'</p>
                            <p>'<i><b>$designation</b></i>'</p>
                            <p>'<i><b>$address</b></i>'</p>",
            'title' => "<p><b>
                            APPLICATION FOR THE FMDQ SECURITIES EXCHANGE LIMITED DEALING MEMBER (SPECIALISTS) CATEGORY
                        </b></p>",
            'body' => "<p  style='text-align: justify;text-justify: inter-word;'>
                            Having reviewed your application for the Dealing Member (Specialists) category of FMDQ Securities Exchange Limited ('FMDQ Exchange'),
                            we are pleased to inform you that your application is successful, and $companyName will now be profiled on the FMDQ e-Knowledge module.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            To gain access to e-Knowledge on the e-Markets portal, kindly update the details of a maximum of four (4)
                            Authorised Representatives of your institution on the MROIS portal($url). <br/> Details should include the following:
                        </p>
                        <ul>
                            <li>Name of Authorised Representative</li>
                            <li>Official Email Address</li>
                            <li>Telephone/Mobile number</li>
                            <li>Department</li>
                            <li>Designation</li>
                        </ul>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Authorised Representatives will be profiled within one (1) business day after receipt of the relevant details,
                            following which each Authorised Representative will receive an email notification containing login details.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Attached for your records, is a copy of the executed FMDQ Exchange Membership Agreement
                            between $companyName and FMDQ SECURITIES EXCHANGE LIMITED for the above-mentioned membership category.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            We thank you for your unwavering support and look forward to continuing a mutually beneficial relationship between our organisations.
                        </p>

                        <p style='margin: 30px 0'>
                            Yours faithfully, <br />
                            <b>FMDQ Securities Exchange Limited</b>
                        </p>
                        <p >
                            '<i><b>Name of DH, MOD</b></i>'
                        </p>
                        <p>
                            '<i><b>Grade</b></i>' <br />
                            '<i><b>Division</b></i>'
                        </p>
                    "];
    }

    protected static function amcLetterContent($application)
    {

        $date = now();
        $designation = $application->applicationPrimaryContactName;
        $address = $application->registeredOfficeAddress;
        $companyName = $application->companyName;

        $url = config("app.front_end_url");

        return [
            'address' => "<p>'<i><b>$date</b></i>'</p>
                            <p>'<i><b>$designation</b></i>'</p>
                            <p>'<i><b>$address</b></i>'</p>",
            'title' => "<p><b>
                            APPLICATION FOR THE FMDQ SECURITIES EXCHANGE LIMITED ASSOCIATE MEMBER (CLIENTS) CATEGORY
                        </b></p>",
            'body' => "<p  style='text-align: justify;text-justify: inter-word;'>
                           Having reviewed your application for the Associate Member (Clients) membership category of FMDQ Securities Exchange Limited ('FMDQ Exchange'),
                           we are pleased to inform you that your application is successful, and $companyName will now be profiled on the applicable modules on the 'FMDQ e-Markets portal'.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            To gain access to the applicable modules on the FMDQ e-Markets portal, kindly update the details of a maximum of two (2)
                            Authorised Representatives of your institution on the MROIS portal($url). <br/> Details should include the following:
                        </p>
                        <ul>
                            <li>Name of Authorised Representative</li>
                            <li>Official Email Address</li>
                            <li>Telephone/Mobile number</li>
                            <li>Department</li>
                            <li>Designation</li>
                        </ul>
                        <p style='text-align: justify;text-justify: inter-word;'>
                           Authorised Representatives will be profiled within one (1) business day after receipt of the relevant details,
                           following which each Authorised Representative will receive an email notification containing login details.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                           Attached for your records, is a copy of the executed FMDQ Exchange Membership Agreement
                           between $companyName and FMDQ SECURITIES EXCHANGE LIMITED for the above-mentioned membership category.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            We thank you for your unwavering support and look forward to continuing a mutually beneficial relationship between our organisations.
                        </p>

                        <p style='margin: 30px 0'>
                            Yours faithfully, <br />
                            <b>FMDQ Securities Exchange Limited</b>
                        </p>
                        <p>
                            '<i><b>Name of DH, MOD</b></i>'
                        </p>
                        <p>
                            '<i><b>Grade</b></i>' <br />
                            '<i><b>Division</b></i>'
                        </p>
                    "];
    }

    protected static function amiLetterContent($application)
    {

        $date = now();
        $designation = $application->applicationPrimaryContactName;
        $address = $application->registeredOfficeAddress;
        $companyName = $application->companyName;

        $url = config("app.front_end_url");

        return [
            'address' => "<p>'<i><b>$date</b></i>'</p>
                            <p>'<i><b>$designation</b></i>'</p>
                            <p>'<i><b>$address</b></i>'</p>",
            'title' => "<p><b>
                           APPLICATION FOR THE FMDQ SECURITIES EXCHANGE LIMITED ASSOCIATE MEMBER (INTER-DEALER BROKERS) CATEGORY
                        </b></p>",
            'body' => "<p  style='text-align: justify;text-justify: inter-word;'>
                            Having reviewed your application for the Associate Member (Inter-Dealer Brokers) membership category of
                            FMDQ Securities Exchange Limited (FMDQ Exchange), we are pleased to inform you that your application is successful,
                            and $companyName will now be profiled on the applicable modules on the 'FMDQ e-Markets portal'.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                           To gain access to the applicable modules on the FMDQ e-Markets portal, kindly update the details of a maximum of two (2)
                           Authorised Representatives of your institution on the MROIS portal($url). <br/> Details should include the following:
                        </p>
                        <ul>
                            <li>Name of Authorised Representative</li>
                            <li>Official Email Address</li>
                            <li>Telephone/Mobile number</li>
                            <li>Department</li>
                            <li>Designation</li>
                        </ul>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Authorised Representatives will be profiled within one (1) business day after receipt of the relevant details,
                            following which each Authorised Representative will receive an email notification containing login details.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Attached for your records, is a copy of the executed FMDQ Exchange Membership Agreement
                            between $companyName and FMDQ SECURITIES EXCHANGE LIMITED for the above-mentioned membership category.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            We thank you for your unwavering support and look forward to continuing a mutually beneficial relationship between our organisations.
                        </p>

                        <p style='margin: 30px 0'>
                            Yours faithfully, <br />
                            <b>FMDQ Securities Exchange Limited</b>
                        </p>
                        <p >
                            '<i><b>Name of DH, MOD</b></i>'
                        </p>
                        <p>
                            '<i><b>Grade</b></i>' <br />
                            '<i><b>Division</b></i>'
                        </p>
                    "];
    }

    protected static function ambLetterContent($application)
    {

        $date = now();
        $designation = $application->applicationPrimaryContactName;
        $address = $application->registeredOfficeAddress;
        $companyName = $application->companyName;

        $url = config("app.front_end_url");

        return [
            'address' => "<p>'<i><b>$date</b></i>'</p>
                            <p>'<i><b>$designation</b></i>'</p>
                            <p>'<i><b>$address</b></i>'</p>",
            'title' => "<p><b>
                           APPLICATION FOR THE FMDQ SECURITIES EXCHANGE LIMITED ASSOCIATE MEMBER (BROKERS) CATEGORY
                        </b></p>",
            'body' => "<p  style='text-align: justify;text-justify: inter-word;'>
                            Having reviewed your application for the Associate Member (Brokers) membership category of
                             FMDQ Securities Exchange Limited (FMDQ Exchange), we are pleased to inform you that your application is successful,
                             and $companyName will now be profiled on the applicable modules on the 'FMDQ e-Markets portal'.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            To gain access to the applicable modules on the FMDQ e-Markets portal, kindly update the details of
                            a maximum of two (2) Authorised Representatives of your institution on the MROIS portal($url). <br/> Details should include the following:
                        </p>
                        <ul>
                            <li>Name of Authorised Representative</li>
                            <li>Official Email Address</li>
                            <li>Telephone/Mobile number</li>
                            <li>Department</li>
                            <li>Designation</li>
                        </ul>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Authorised Representatives will be profiled within one (1) business day after receipt of the relevant details,
                            following which each Authorised Representative will receive an email notification containing login details.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Attached for your records, is a copy of the executed FMDQ Exchange Membership
                            Agreement between $companyName and FMDQ SECURITIES EXCHANGE LIMITED for the above-mentioned membership category.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            We thank you for your unwavering support and look forward to continuing a mutually beneficial relationship between our organisations.
                        </p>

                        <p style='margin: 30px 0'>
                            Yours faithfully, <br />
                            <b>FMDQ Securities Exchange Limited</b>
                        </p>
                        <p >
                            '<i><b>Name of DH, MOD</b></i>'
                        </p>
                        <p>
                            '<i><b>Grade</b></i>' <br />
                            '<i><b>Division</b></i>'
                        </p>
                    "];
    }

    protected static function rmmLetterContent($application)
    {

        $date = now();
        $designation = $application->applicationPrimaryContactName;
        $address = $application->registeredOfficeAddress;
        $companyName = $application->companyName;

        $url = config("app.front_end_url");
        return [
            'address' => "<p>'<i><b>$date</b></i>'</p>
                            <p>'<i><b>$designation</b></i>'</p>
                            <p>'<i><b>$address</b></i>'</p>",
            'title' => "<p><b>
                           APPLICATION FOR THE FMDQ SECURITIES EXCHANGE LIMITED REGISTRATION MEMBER (LISTINGS & QUOTATIONS) CATEGORIES
                        </b></p>",
            'body' => "<p  style='text-align: justify;text-justify: inter-word;'>
                            Having reviewed your application for the Registration Member (Listings & Quotations)
                            categories of FMDQ Securities Exchange Limited (“FMDQ Exchange”),
                            we are pleased to inform you that your application is successful, and $companyName
                            will now be profiled on the applicable modules on the “FMDQ e-Markets portal”.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            To gain access to the FMDQ e-Markets portal, kindly update the details of a maximum of
                            two (2) Authorised Representatives of your institution for each of the Registration Member (Listings) & Registration Member (Quotations)
                            category on the MROIS portal($url). <br/> Details should include the following:
                        </p>
                        <ul>
                            <li>Name of Authorised Representative</li>
                            <li>Official Email Address</li>
                            <li>Telephone/Mobile number</li>
                            <li>Department</li>
                            <li>Designation</li>
                        </ul>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Authorised Representatives will be profiled within one (1) business day after receipt of the relevant details,
                            following which each Authorised Representative will receive an email notification containing login details.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Attached for your records, are copies of the executed FMDQ Exchange Membership Agreement
                            between $companyName and FMDQ SECURITIES EXCHANGE LIMITED for the above-mentioned membership categories.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            We thank you for your unwavering support and look forward to continuing a mutually beneficial relationship between our organisations.
                        </p>

                        <p style='margin: 30px 0'>
                            Yours faithfully, <br />
                            <b>FMDQ Securities Exchange Limited</b>
                        </p>
                        <p >
                            '<i><b>Name of DH, MOD</b></i>'
                        </p>
                        <p>
                            '<i><b>Grade</b></i>' <br />
                            '<i><b>Division</b></i>'
                        </p>
                    "];
    }

    protected static function rmlLetterContent($application)
    {
        $date = now();
        $designation = $application->applicationPrimaryContactName;
        $address = $application->registeredOfficeAddress;
        $companyName = $application->companyName;

        $url = config("app.front_end_url");

        return [
            'address' => "<p>'<i><b>$date</b></i>'</p>
                            <p>'<i><b>$designation</b></i>'</p>
                            <p>'<i><b>$address</b></i>'</p>",
            'title' => "<p><b>
                           APPLICATION FOR THE FMDQ SECURITIES EXCHANGE LIMITED REGISTRATION MEMBER (LISTINGS) CATEGORY
                        </b></p>",
            'body' => "<p  style='text-align: justify;text-justify: inter-word;'>
                            Having reviewed your application for the Registration Member (Listings) category of FMDQ Securities Exchange Limited (“FMDQ Exchange”),
                             we are pleased to inform you that your application is successful, and $companyName
                             will now be profiled on the applicable modules on the “FMDQ e-Markets portal”.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            To gain access to the FMDQ e-Markets portal, kindly update the details of a
                             maximum of two (2) Authorised Representatives of your institution on the MROIS portal($url). <br/> Details should include the following:
                        </p>
                        <ul>
                            <li>Name of Authorised Representative</li>
                            <li>Official Email Address</li>
                            <li>Telephone/Mobile number</li>
                            <li>Department</li>
                            <li>Designation</li>
                        </ul>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Authorised Representatives will be profiled within one (1) business day after receipt of the relevant details,
                            following which each Authorised Representative will receive an email notification containing login details.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Attached for your records, is a copy of the executed FMDQ Exchange Membership
                            Agreement between $companyName and FMDQ SECURITIES EXCHANGE LIMITED for the above-mentioned membership category.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            We thank you for your unwavering support and look forward to continuing a mutually beneficial relationship between our organisations.
                        </p>

                        <p style='margin: 30px 0'>
                            Yours faithfully, <br />
                            <b>FMDQ Securities Exchange Limited</b>
                        </p>
                        <p >
                            '<i><b>Name of DH, MOD</b></i>'
                        </p>
                        <p>
                            '<i><b>Grade</b></i>' <br />
                            '<i><b>Division</b></i>'
                        </p>
                    "];
    }

    protected static function rmqLetterContent($application)
    {
        $date = now();
        $designation = $application->applicationPrimaryContactName;
        $address = $application->registeredOfficeAddress;
        $companyName = $application->companyName;

        $url = config("app.front_end_url");

        return [
            'address' => "<p>'<i><b>$date</b></i>'</p>
                            <p>'<i><b>$designation</b></i>'</p>
                            <p>'<i><b>$address</b></i>'</p>",
            'title' => "<p><b>
                           APPLICATION FOR THE FMDQ SECURITIES EXCHANGE LIMITED REGISTRATION MEMBER (QUOTATIONS) CATEGORY
                        </b></p>",
            'body' => "<p  style='text-align: justify;text-justify: inter-word;'>
                           Having reviewed your application for the Registration Member (Quotations) category of
                           FMDQ Securities Exchange Limited (“FMDQ Exchange”), we are pleased to inform you that your
                           application is successful, and $companyName will now be profiled on the applicable modules on the “FMDQ e-Markets portal”.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            To gain access to the FMDQ e-Markets portal, kindly update the details of a maximum of two (2)
                            Authorised Representatives of your institution on the MROIS portal($url).
                             <br/> Details should include the following:
                        </p>
                        <ul>
                            <li>Name of Authorised Representative</li>
                            <li>Official Email Address</li>
                            <li>Telephone/Mobile number</li>
                            <li>Department</li>
                            <li>Designation</li>
                        </ul>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Authorised Representatives will be profiled within one (1) business day after receipt of the relevant details,
                             following which each Authorised Representative will receive an email notification containing login details.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            Attached for your records, is a copy of the executed FMDQ Exchange
                            Membership Agreement between $companyName and FMDQ SECURITIES EXCHANGE LIMITED for the above-mentioned membership category.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            We thank you for your unwavering support and look forward to continuing a mutually beneficial relationship between our organisations.
                        </p>

                        <p style='margin: 30px 0'>
                            Yours faithfully, <br />
                            <b>FMDQ Securities Exchange Limited</b>
                        </p>
                        <p >
                            '<i><b>Name of DH, MOD</b></i>'
                        </p>
                        <p>
                            '<i><b>Grade</b></i>' <br />
                            '<i><b>Division</b></i>'
                        </p>
                    "];
    }

    protected static function affLetterContent($application)
    {
        $date = now();
        $designation = $application->applicationPrimaryContactName;
        $address = $application->registeredOfficeAddress;
        $companyName = $application->companyName;

        $url = config("app.front_end_url");

        return [
            'address' => "<p>'<i><b>$date</b></i>'</p>
                            <p>'<i><b>$designation</b></i>'</p>
                            <p>'<i><b>$address</b></i>'</p>",
            'title' => "<p><b>
                           APPLICATION FOR THE FMDQ SECURITIES EXCHANGE AFFILIATE MEMBER (FIXED INCOME) CATEGORY
                        </b></p>",
            'body' => "<p  style='text-align: justify;text-justify: inter-word;'>
                           Having reviewed your application for the Affiliate Member (Fixed Income) category of
                           FMDQ Securities Exchange Limited (“FMDQ Exchange”), we are pleased to inform you that your
                           application is successful, and $companyName will now be profiled on the FMDQ e-Knowledge module.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            To gain access to the e-knowledge on the e-Markets portal, kindly update the details
                            of a maximum of four (4) Authorised Representatives of your institution on the MROIS portal($url).
                             <br/> Details should include the following:
                        </p>
                        <ul>
                            <li>Name of Authorised Representative</li>
                            <li>Official Email Address</li>
                            <li>Telephone/Mobile number</li>
                            <li>Department</li>
                            <li>Designation</li>
                        </ul>
                        <p style='text-align: justify;text-justify: inter-word;'>
                           Authorised Representatives will be profiled within one (1) business day after receipt of
                           the relevant details, following which each Authorised Representative will receive an email notification containing login details.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                           Attached for your records, is a copy of the executed FMDQ Exchange Membership Agreement
                           between $companyName and FMDQ SECURITIES EXCHANGE LIMITED for the above-mentioned membership category.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                           We thank you for your unwavering support and look forward to continuing a mutually beneficial relationship between our organisations
                        </p>

                        <p style='margin: 30px 0'>
                            Yours faithfully, <br />
                            <b>FMDQ Securities Exchange Limited</b>
                        </p>
                        <p >
                            '<i><b>Name of DH, MOD</b></i>'
                        </p>
                        <p>
                            '<i><b>Grade</b></i>' <br />
                            '<i><b>Division</b></i>'
                        </p>
                    "];
    }

    protected static function afcLetterContent($application)
    {

        return [
            'address' => "<p>'<i><b>Date</b></i>'</p>
                            <p>'<i><b>Designation</b></i>'</p>
                            <p>'<i><b>Address</b></i>'</p>",
            'title' => "<p><b>
                           APPLICATION FOR THE FMDQ SECURITIES EXCHANGE LIMITED AFFILIATE MEMBER (STANDARD) CATEGORY
                        </b></p>",
            'body' => "<p  style='text-align: justify;text-justify: inter-word;'>
                           Having reviewed your application for the Affiliate Member (Standard) category of FMDQ Securities
                           Exchange Limited (“FMDQ Exchange”), we are pleased to inform you that your application is successful,
                            and “Member’s full name” will now be profiled on the FMDQ e-Knowledge module of the e-Markets portal.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            To gain access to the e-knowledge on the e-Markets portal, kindly update the details of a
                            maximum of four (4) Authorised Representatives of your institution on the MROIS portal(“link”).
                             <br/> Details should include the following:
                        </p>
                        <ul>
                            <li>Name of Authorised Representative</li>
                            <li>Official Email Address</li>
                            <li>Telephone/Mobile number</li>
                            <li>Department</li>
                            <li>Designation</li>
                        </ul>
                        <p style='text-align: justify;text-justify: inter-word;'>
                          Authorised Representatives will be profiled within one (1) business day after receipt of the relevant details,
                          following which each Authorised Representative will receive an email notification containing login details.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                           Attached for your records, is a copy of the executed FMDQ Exchange Membership
                           Agreement between “MEMBER’S FULL NAME” and FMDQ SECURITIES EXCHANGE LIMITED for the above-mentioned membership category.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            We thank you for your unwavering support and look forward to continuing a mutually beneficial relationship between our organisations.
                        </p>

                        <p style='margin: 30px 0'>
                            Yours faithfully, <br />
                            <b>FMDQ Securities Exchange Limited</b>
                        </p>
                        <p >
                            '<i><b>Name of DH, MOD</b></i>'
                        </p>
                        <p>
                            '<i><b>Grade</b></i>' <br />
                            '<i><b>Division</b></i>'
                        </p>
                    "];
    }

    protected static function afiLetterContent($application)
    {

        return [
            'address' => "<p>'<i><b>Date</b></i>'</p>
                            <p>'<i><b>Designation</b></i>'</p>
                            <p>'<i><b>Address</b></i>'</p>",
            'title' => "<p><b>
                            APPLICATION FOR THE FMDQ SECURITIES EXCHANGE LIMITED AFFILIATE MEMBER (STANDARD) CATEGORY
                        </b></p>",
            'body' => "<p  style='text-align: justify;text-justify: inter-word;'>
                          Having reviewed your application for the Affiliate Member (Standard) category of FMDQ Securities Exchange
                           Limited (“FMDQ Exchange”), we are pleased to inform you that your application is successful, and
                           “Member’s full name” will now be profiled on the FMDQ e-Knowledge module of the e-Markets portal.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            To gain access to the e-knowledge on the e-Markets portal,
                            kindly update your details on the MROIS portal(“link”).
                             <br/> Details should include the following:
                        </p>
                        <ul>
                            <li>Name of Authorised Representative</li>
                            <li>E-mail Address</li>
                            <li>Telephone/Mobile number</li>
                        </ul>
                        <p style='text-align: justify;text-justify: inter-word;'>
                            You will be profiled within one (1) business day after receipt of the relevant details,
                            following which you will receive an email notification containing login details.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                           Attached for your records, is a copy of the executed FMDQ Exchange Membership
                           Agreement between “MEMBER’S FULL NAME” and FMDQ SECURITIES EXCHANGE LIMITED for the above-mentioned membership category.
                        </p>
                        <p style='text-align: justify;text-justify: inter-word;'>
                           We thank you for your unwavering support and look forward to continuing a mutually beneficial relationship between our organisations.
                        </p>

                        <p style='margin: 30px 0'>
                            Yours faithfully, <br />
                            <b>FMDQ Securities Exchange Limited</b>
                        </p>
                        <p >
                            '<i><b>Name of DH, MOD</b></i>'
                        </p>
                        <p>
                            '<i><b>Grade</b></i>' <br />
                            '<i><b>Division</b></i>'
                        </p>
                    "];
    }

}
