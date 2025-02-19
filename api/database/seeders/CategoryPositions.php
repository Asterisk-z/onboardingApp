<?php

namespace Database\Seeders;

use App\Models\GroupMail;
use App\Models\MembershipCategory;
use App\Models\MembershipCategoryPostition;
use App\Models\Position;
use Illuminate\Database\Seeder;

class CategoryPositions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        MembershipCategoryPostition::query()->truncate();

        $membership_category = 'Dealing Member (Banks)';
        $rows = [["name" => "Group Managing Director"],
            ["name" => "Managing Director/CEO", "is_compulsory" => true, "email" => "dmbceos@fmdqgroup.com"],
            ["name" => "Supervising Director", "email" => "dmsds@fmdqgroup.com"],
            ["name" => "Treasurer", "is_compulsory" => true, "email" => "DMBTreasurers@fmdqgroup.com"],
            ["name" => "Chief Dealer", "is_compulsory" => true, "email" => "chiefdealers@fmdqgroup.com"],
            ["name" => "Senior Dealer "],
            ["name" => "T.bills Dealer 1", "email" => "T.billsDealers@fmdqgroup.com"],
            ["name" => "T.bills Dealer 2", "email" => "T.billsDealers@fmdqgroup.com"],
            ["name" => "T.bills Dealer 3", "email" => "T.billsDealers@fmdqgroup.com"],
            ["name" => "Bonds Dealer 1", "email" => "BondDealers@fmdqgroup.com"],
            ["name" => "Bonds Dealer 2", "email" => "BondDealers@fmdqgroup.com"],
            ["name" => "Bonds Dealer 3", "email" => "BondDealers@fmdqgroup.com"],
            ["name" => "FX Dealer 1", "email" => "FXDealers@fmdqgroup.com"],
            ["name" => "FX Dealer 2", "email" => "FXDealers@fmdqgroup.com"],
            ["name" => "FX Dealer 3", "email" => "FXDealers@fmdqgroup.com"],
            ["name" => "Money Market Dealer 1"],
            ["name" => "Money Market Dealer 2"],
            ["name" => "Money Market Dealer 3"],
            ["name" => "Derivatives Dealer 1", "email" => "ddl@fmdqgroup.com"],
            ["name" => "Derivatives Dealer 2", "email" => "ddl@fmdqgroup.com"],
            ["name" => "Derivatives Dealer 3", "email" => "ddl@fmdqgroup.com"],
            ["name" => "ALM Officer 1"],
            ["name" => "ALM Officer 2"],
            ["name" => "ALM Officer 3"],
            ["name" => "Treasury Sales Officer 1"],
            ["name" => "Treasury Sales Officer 2"],
            ["name" => "Treasury Sales Officer 3"],
            ["name" => "Head, Treasury Operations", "is_compulsory" => true, "email" => "DMBTROPS@fmdqgroup.com"],
            ["name" => "Treasury Operations Officer 1 ", "email" => "DMBTROPS@fmdqgroup.com"],
            ["name" => "Treasury Operations Officer 2", "email" => "DMBTROPS@fmdqgroup.com"],
            ["name" => "Treasury Operations Officer 3", "email" => "DMBTROPS@fmdqgroup.com"],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true, "email" => "DMBCompliance@fmdqgroup.com"],
            ["name" => "Compliance Officer 1", "is_compulsory" => true, "email" => "DMBCompliance@fmdqgroup.com"],
            ["name" => "Compliance Officer 2", "email" => "DMBCompliance@fmdqgroup.com"],
            ["name" => "Compliance Officer 3", "email" => "DMBCompliance@fmdqgroup.com"],
            ["name" => "Group Head, Internal Control"],
            ["name" => "Internal Control Officer 1"],
            ["name" => "Internal Control Officer 2"],
            ["name" => "Internal Control Officer 3"],
            ["name" => "Chief Audit Executive"],
            ["name" => "Internal Audit Officer 2"],
            ["name" => "Internal Audit Officer 3"],
            ["name" => "Chief Risk Officer"],
            ["name" => "Risk Management Officer 1"],
            ["name" => "Risk Management Officer 2"],
            ["name" => "Risk Management Officer 3"],
            ["name" => "Head, Market Risk"],
            ["name" => "Market Risk Officer 1"],
            ["name" => "Market Risk Officer 2"],
            ["name" => "Market Risk Officer 3"],
            ["name" => "Head, IT"],
            ["name" => "IT Officer 1"],
            ["name" => "IT Officer 2"],
            ["name" => "IT Officer 3"]];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }
        $membership_category = 'Dealing Member (Specialist)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true, "email" => "DMSCEOsActivated@fmdqgroup.com"],
            ["name" => "Head of Investments"],
            ["name" => "Dealer(s)", "is_compulsory" => true, "email" => "DMSDealers@fmdqgroup.com"],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true, "email" => "DMSCompliance@fmdqgroup.com"],
            ["name" => "Risk Management Officer"],
            ["name" => "Primary Contact(s)", "is_compulsory" => true, "email" => "DMSPrimaryContacts@fmdqgroup.com"],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }
        $membership_category = 'Associate Member (Brokers)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true, "email" => "AMBCEOS@fmdqgroup.com"],
            ["name" => "Treasurer/Chief Financial Officer", "is_compulsory" => true],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true, "email" => "AMBCompliance@fmdqgroup.com"],
            ["name" => "Primary Contact(s)", "is_compulsory" => true, "email" => "AMBPrimaryContacts@fmdqgroup.com"],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }
        $membership_category = 'Associate Member (Inter-Dealer Brokers)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true, "email" => "AMICEOS@fmdqgroup.com"],
            ["name" => "Treasurer/Chief Financial Officer", "is_compulsory" => true],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true, "email" => "AMICompliance@fmdqgroup.com"],
            ["name" => "Primary Contact(s)", "is_compulsory" => true, "email" => "AMIPrimaryContacts@fmdqgroup.com"],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }
        $membership_category = 'Associate Member (Client)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true, "email" => "AMCCEOS@fmdqgroup.com"],
            ["name" => "Head of Investment"],
            ["name" => "Dealer(s)", "is_compulsory" => true],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true, "email" => "AMCCompliance@fmdqgroup.com"],
            ["name" => "Risk Management Officer", "is_compulsory" => true],
            ["name" => "Primary Contact(s)", "is_compulsory" => true, "email" => "AMCPrimaryContacts@fmdqgroup.com"],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }
        $membership_category = 'Registration Member (Listings)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true, "email" => "RMLCEOs@fmdqgroup.com"],
            ["name" => "Treasurer/Chief Financial Officer", "is_compulsory" => true],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true, "email" => "RMLCompliance@fmdqgroup.com"],
            ["name" => "Primary Contact(s)", "is_compulsory" => true, "email" => "RMLPrimaryContacts@fmdqgroup.com"],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }

        $membership_category = 'Registration Member (Quotations)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true, "email" => "RMQCEO@fmdqgroup.com"],
            ["name" => "Treasurer/Chief Financial Officer", "is_compulsory" => true],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true, "email" => "RMQCompliance@fmdqgroup.com"],
            ["name" => "Primary Contact(s)", "is_compulsory" => true, "email" => "RMQPrimaryContacts@fmdqgroup.com"],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }

        $membership_category = 'Registration Member (Listings & Quotations)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true, "email" => "RMLRMQCEOs@fmdqgroup.com"],
            ["name" => "Treasurer/Chief Financial Officer", "is_compulsory" => true],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true, "email" => "RMLRMQCompliance@fmdqgroup.com"],
            ["name" => "Primary Contact(s)", "is_compulsory" => true, "email" => "RMLRMQPrimaryContacts@fmdqgroup.com"],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }
        $membership_category = 'Affiliate Member - Standard (Individual)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true],
            ["name" => "Treasurer/Chief Financial Officer", "is_compulsory" => true],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true],
            ["name" => "Primary Contact(s)", "is_compulsory" => true],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }

        $membership_category = 'Affiliate Member - Standard (Corporate)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true],
            ["name" => "Treasurer/Chief Financial Officer", "is_compulsory" => true],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true],
            ["name" => "Primary Contact(s)", "is_compulsory" => true],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }

        $membership_category = 'Affiliate Member (Foreign Exchange Trading)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true],
            ["name" => "Treasurer/Chief Financial Officer", "is_compulsory" => true],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true],
            ["name" => "Primary Contact(s)", "is_compulsory" => true],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }

        $membership_category = 'Affiliate Member (Fixed Income)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true],
            ["name" => "Treasurer/Chief Financial Officer", "is_compulsory" => true],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true],
            ["name" => "Primary Contact(s)", "is_compulsory" => true],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }

        $membership_category = 'Affiliate Member (Regulator)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true],
            ["name" => "Treasurer/Chief Financial Officer", "is_compulsory" => true],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true],
            ["name" => "Primary Contact(s)", "is_compulsory" => true],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }
        $membership_category = 'Foreign Exchange (Corporates)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true],
            ["name" => "Treasurer/Chief Financial Officer", "is_compulsory" => true],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true],
            ["name" => "Primary Contact(s)", "is_compulsory" => true],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }

        $membership_category = 'Dealing Member (Non-Bank Financial Institutions)';

        $rows = [
            ["name" => "Managing Director/CEO", "is_compulsory" => true],
            ["name" => "Treasurer/Chief Financial Officer", "is_compulsory" => true],
            ["name" => "Chief Compliance Officer", "is_compulsory" => true],
            ["name" => "Primary Contact(s)", "is_compulsory" => true],
        ];

        $checkMemberCategory = MembershipCategory::where('name', $membership_category)->first();

        if ($checkMemberCategory) {
            foreach ($rows as $position) {
                $checkPosition = Position::where('name', $position['name'])->first();

                $email = null;
                $is_compulsory = '0';

                if (isset($position['email'])) {
                    $email = GroupMail::where('email', $position['email'])->first();
                }

                if (isset($position['is_compulsory'])) {
                    $is_compulsory = '1';
                }

                if ($checkPosition) {

                    MembershipCategoryPostition::updateOrCreate([
                        "category_id" => $checkMemberCategory->id,
                        "position_id" => $checkPosition->id,
                        "group_mail_id" => $email ? $email->id : null,
                        "is_compulsory" => $is_compulsory,
                    ]);

                }

            }

        }

    }
}
