<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Lpayment {

    public function payement_form() {

        $CI = & get_instance();
        $CI->load->model('Payment');
        $CI->load->model('Suppliers');
        $CI->load->model('Customers');
        $CI->load->model('Settings');
        $CI->load->model('Accounts'); //
        $bank = $CI->Settings->get_bank_list();
        $supplier = $CI->Suppliers->supplier_list("110", "0");
        $customer = $CI->Customers->customer_list("110", "0");
        $account_list = $CI->Payment->account_list("110", "0");
        $office_person_list = $CI->Payment->office_person_list("110", "0");
        $account_list_category = $CI->Payment->account_list_category("110", "0");
        $payment = $CI->Accounts->accounts_name_finder(2);
        $expense = $CI->Accounts->accounts_name_finder(1);
        $loan_list = $CI->Settings->loan_list();
        $data = array(
            'title' => 'Add Payement',
            'supplier' => $supplier,
            'customer' => $customer,
            'bank' => $bank,
            'account_list' => $account_list,
            'office_person_list' => $office_person_list,
            'accounts' => $payment,
            'expense' => $expense,
            'trans_category' => $account_list_category,
            'loan_list' => $loan_list,
        );
//        echo '<pre>';        print_r($data);die();
        $paymentform = $CI->parser->parse('payment/form', $data, true);
        return $paymentform;
    }

    public function receipt_form() {

        $CI = & get_instance();
        $CI->load->model('Payment');
        $CI->load->model('Suppliers');
        $CI->load->model('Customers');
        $CI->load->model('Settings');
        $CI->load->model('Accounts'); //
        $bank = $CI->Settings->get_bank_list();
        $supplier = $CI->Suppliers->supplier_list("110", "0");
        $customer = $CI->Customers->customer_list("110", "0");
        $account_list_category = $CI->Payment->account_list_category("110", "0");
        $account_list = $CI->Payment->account_list("110", "0");
        $office_person_list = $CI->Payment->office_person_list("110", "0");
        $payment = $CI->Accounts->accounts_name_finder(2);
        $expense = $CI->Accounts->accounts_name_finder(1);
        $loan_list = $CI->Settings->loan_list();
        $data = array(
            'title' => 'Add Receipt',
            'supplier' => $supplier,
            'customer' => $customer,
            'bank' => $bank,
            'account_list' => $account_list,
            'office_person_list' => $office_person_list,
            'accounts' => $payment,
            'trans_category' => $account_list_category,
            'expense' => $expense,
            'loan_list' => $loan_list,
        );

        $paymentform = $CI->parser->parse('payment/receipt_form', $data, true);
        return $paymentform;
    }

    public function payment_list($links, $per_page, $page) {
        $CI = & get_instance();
        $CI->load->model('Payment');
        $CI->load->model('Reports');
        $CI->load->library('occational');

        $ledger = $CI->Payment->date_summary_query($per_page, $page);
//        echo '<pre>';        print_r($ledger);die();
        $category = $CI->Payment->tran_cat_list();

        $balance = 0;
        $total_credit = 0;
        $total_debit = 0;
        $total_balance = 0;
        $i = 0;

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Reports->retrieve_company();
        $data = array(
            'title' => display('manage_transaction'),
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
            'ledger' => $ledger,
            'transaction_id' => @$ledger[0]['transaction_id'],
            'category' => $category,
            'subtotalDebit' => number_format($total_debit, 2, '.', ','),
            'subtotalCredit' => number_format($total_credit, 2, '.', ','),
            'subtotalBalance' => number_format($total_balance, 2, '.', ','),
            'links' => $links,
            'company_info' => $company_info,
        );
        $chapterList = $CI->parser->parse('payment/payment', $data, true);
        return $chapterList;
    }

    public function payment_up_data($trans) {
        $CI = & get_instance();
        $CI->load->model('Payment');
        $CI->load->model('Suppliers');
        $CI->load->model('Customers');
        $CI->load->model('Settings');
        $CI->load->model('Accounts'); //


        $bank = $CI->Settings->get_bank_list();
        $supplier = $CI->Suppliers->supplier_list("110", "0");
        $customer = $CI->Customers->customer_list("110", "0");
        $account_list = $CI->Payment->account_list("110", "0");
        $payment = $CI->Accounts->accounts_name_finder(2);
        $expense = $CI->Accounts->accounts_name_finder(1);
        $loan_list = $CI->Settings->loan_list();

        $payment = $CI->Payment->payment_updata($trans);
//        $data['payment'] = $payment;
//        echo '<pre>';        print_r($payment);die();
        @$category_id = $payment[0]['transection_category'];
        $category_selected = $CI->Payment->selected_transection($category_id); //
        $supplier_selected = $CI->Payment->selected_supplier($trans);
        $customer_selected = $CI->Payment->selected_customer($trans);
        $tran_type_selected = $CI->Payment->selected_transection_type($trans);
        $loan_selected = $CI->Payment->selected_loan($trans);
        $office_selected = $CI->Payment->selected_office_trns($trans);
        $category = $CI->Payment->tran_cat_list();
        $office_person_list = $CI->Payment->office_person_list("110", "0");
//        echo '<pre>'; print_r($supplier_selected) ;die();
        $data = array(
            'transaction_id' => $payment[0]['transaction_id'],
            'date_of_transection' => $payment[0]['date_of_transection'],
            'relation_id' => $payment[0]['relation_id'],
            'transection_category' => $payment[0]['transection_category'],
            'transection_type' => $payment[0]['transection_type'],
            'description' => $payment[0]['description'],
            'amount' => $payment[0]['amount'],
            'pay_amount' => $payment[0]['pay_amount'],
            'relation_id' => $payment[0]['relation_id'],
            'category_list' => $category,
            'category_selected' => $category_selected,
            'supplier_seleced' => $supplier_selected,
            'office' => $office_selected,
            'customer_id' => $customer_selected[0]['customer_name'],
            'sel_loan' => $loan_selected[0]['person_name'],
            'supplier' => $supplier,
            'customer' => $customer,
            'bank' => $bank,
            'trn_mood' => $payment[0]['transection_mood'],
            'tran_type' => $tran_type_selected[0]['transection_type'],
            'account_list' => $account_list,
            'accounts' => $payment,
            'expense' => $expense,
            'office_person_list' => $office_person_list,
            'loan_list' => $loan_list,
        );
//        echo '<pre>';        print_r($data);die();
        $updatepayment = $CI->parser->parse('payment/update_payment', $data, true);
        return $updatepayment;
    }

// transection report start
    public function transection_report_details() {
        $CI = & get_instance();
        $CI->load->model('Payment');
        $CI->load->model('Web_settings');
        $trans_report = $CI->Payment->transection_report();

        $i = 0;
        if (!empty($trans_report)) {
            foreach ($trans_report as $k => $v) {
                $i++;
                $trans_report[$k]['sl'] = $i;
            }
        }
        $data = array(
            'title' => 'report List',
            'trans_report' => $trans_report,
        );

        $report = $CI->parser->parse('payment/trans_details', $data, true);
        return $report;
    }

    // transection details by id
    public function transection_data($id) {
        $CI = & get_instance();
        $CI->load->model('Payment');

        $ledger = $CI->Payment->transection_rp_id($id);


        $data = array(
            'trans' => $ledger,
        );

        $chapterList = $CI->parser->parse('payment/detail_byid', $data, true);
        return $chapterList;
    }

    // transaction report
    public function trans_data() {
        $CI = & get_instance();
        $CI->load->model('Payment');
        $ledger = $CI->Payment->tran_rep_query();

        $balance = 0;
        $total_credit = 0;
        $total_debit = 0;
        $total_balance = 0;

        if (!empty($ledger)) {
            foreach ($ledger as $k => $v) {
                $ledger[$k]['balance'] = ($ledger[$k]['debit'] - $ledger[$k]['credit']) + $balance;
                $balance = $ledger[$k]['balance'];

                $ledger[$k]['subtotalDebit'] = $total_debit + $ledger[$k]['debit'];
                $total_debit = $ledger[$k]['subtotalDebit'];

                $ledger[$k]['subtotalCredit'] = $total_credit + $ledger[$k]['credit'];
                $total_credit = $ledger[$k]['subtotalCredit'];

                $ledger[$k]['subtotalBalance'] = $total_balance + $ledger[$k]['balance'];
                $total_balance = $ledger[$k]['subtotalBalance'];
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
            'ledger' => $ledger,
            'subtotalDebit' => number_format($total_debit, 2, '.', ','),
            'subtotalCredit' => number_format($total_credit, 2, '.', ','),
            'subtotalBalance' => number_format($total_balance, 2, '.', ','),
            'links' => '',
        );
        $chapterList = $CI->parser->parse('payment/trans_report', $data, true);
        return $chapterList;
    }

    // date wise report
    public function trans_datewise_data($links, $per_page, $page) {
        $CI = & get_instance();
        $CI->load->model('Payment');
        $ledger = $CI->Payment->date_summary_query11($per_page, $page);

        $balance = 0;
        $total_credit = 0;
        $total_debit = 0;
        $total_balance = 0;

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
            'ledger' => $ledger,
            'subtotalDebit' => number_format($total_debit, 2, '.', ','),
            'subtotalCredit' => number_format($total_credit, 2, '.', ','),
            'subtotalBalance' => number_format($total_balance, 2, '.', ','),
            'links' => $links,
        );
        $chapterList = $CI->parser->parse('payment/date_wise', $data, true);
        return $chapterList;
    }

    //date between search result
    public function result_datewise_data($start, $end) {
        $CI = & get_instance();
        $CI->load->model('Payment');

        $stdate = $start;
        $end = $end;
        $ledger = $CI->Payment->search_query($start, $end);
//        echo '<pre>';        print_r($ledger);die();
        $previous_balance = $CI->Payment->supplier_product_sale_previous_debit($start);
        foreach ($previous_balance as $k => $v) {
            $previous_balance['pre_balance'] = $previous_balance[$k]['pre_debit'] - $previous_balance[$k]['pre_credit'];
            $pr_bal = $previous_balance['pre_balance'];
        }

        $balance = 0;
        $total_credit = 0;
        $total_debit = 0;
        $total_balance = 0;
        $subtotalbal = 0;

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
            'ledger' => $ledger,
            'subtotalDebit' => $total_debit + $pr_bal,
            'subtotalCredit' => number_format($total_credit, 2, '.', ','),
            'balance' => $total_debit + $pr_bal - $total_credit,
            'balnce_sub' => $subtotalbal,
            'links' => '',
            'start' => $stdate,
            'endt' => $end,
            'previous_bal' => $pr_bal,
        );
        $chapterList = $CI->parser->parse('payment/date_wise_cash_flow', $data, true);
        return $chapterList;
    }

    // customr report data
    public function trans_custom_report_data($links, $per_page, $page) {
        $CI = & get_instance();
        $CI->load->model('Payment');


        $ledger = $CI->Payment->date_summary_query11($per_page, $page);
        $category = $CI->Payment->tran_cat_list();
        $balance = 0;
        $total_credit = 0;
        $total_debit = 0;
        $total_balance = 0;

        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
            'ledger' => $ledger,
            //'invoice_no'    => $invoice,
            'category' => $category,
            //'invoice'       => $invoice,
            'subtotalDebit' => number_format($total_debit, 2, '.', ','),
            'subtotalCredit' => number_format($total_credit, 2, '.', ','),
            'subtotalBalance' => number_format($total_balance, 2, '.', ','),
            'links' => $links,
        );
        $chapterList = $CI->parser->parse('payment/custom_report', $data, true);
        return $chapterList;
    }

    // custom report search result info
    public function custom_result_datewise_data($start, $end, $account) {
        $CI = & get_instance();
        $CI->load->model('Payment');

        $category = $CI->Payment->tran_cat_list();
        $ledger = $CI->Payment->custom_search_query($start, $end, $account);


        $balance = 0;
        $total_credit = 0;
        $total_debit = 0;
        $total_balance = 0;

        if (!empty($ledger)) {
            foreach ($ledger as $k => $v) {
                $ledger[$k]['balance'] = (is_numeric($ledger[$k]['debit']) - $ledger[$k]['credit']) + $balance;
                $balance = $ledger[$k]['balance'];

                $ledger[$k]['subtotalDebit'] = $total_debit + is_numeric($ledger[$k]['debit']);
                $total_debit = $ledger[$k]['subtotalDebit'];

                $ledger[$k]['subtotalCredit'] = $total_credit + $ledger[$k]['credit'];
                $total_credit = $ledger[$k]['subtotalCredit'];

                $ledger[$k]['subtotalBalance'] = $total_balance + $ledger[$k]['balance'];
                $total_balance = $ledger[$k]['subtotalBalance'];
            }
        }
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $data = array(
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
            'ledger' => $ledger,
            'category' => $category,
            'subtotalDebit' => number_format($total_debit, 2, '.', ','),
            'subtotalCredit' => number_format($total_credit, 2, '.', ','),
            'subtotalBalance' => number_format($total_balance, 2, '.', ','),
            'links' => '',
        );
        $chapterList = $CI->parser->parse('payment/custom_report_datewise', $data, true);
        return $chapterList;
    }

    public function payment_date_date_info($star_date, $end_date, $links, $per_page, $page) {
        $CI = & get_instance();
        $CI->load->model('Payment');
        $CI->load->model('Reports');
        $CI->load->library('occational');
        $ledger = $CI->Payment->date_summary_date_to_date($star_date, $end_date, $per_page, $page);
        $category = $CI->Payment->tran_cat_list();
        $currency_details = $CI->Web_settings->retrieve_setting_editdata();
        $company_info = $CI->Reports->retrieve_company();

        $data = array(
            'currency' => $currency_details[0]['currency'],
            'position' => $currency_details[0]['currency_position'],
            'ledger' => $ledger,
            'transaction_id' => $ledger[0]['transaction_id'],
            'company_info' => $company_info,
            'category' => $category,
            'links' => $links,
        );

        $chapterList = $CI->parser->parse('payment/payment', $data, true);
        return $chapterList;
    }

}
