<?php

return [
    'app_name' => 'SOLOMON ISLANDS PUBLIC EMPLOYEES UNION',
    'app_slug_name' => 'SIPEU',
    'company_name' => 'Credit Union LTD',
    'paginate_length' => 100,
    'deduction_type' => [
        '1' => 'Membership Fee',
        '2' => 'Administration Fee',
        '3' => 'Loan Fee'
    ],
    'loan_interest_percent' => 1,
    'status' => [
        '0' => 'In active',
        '1' => 'Active'
    ],
    'loan_scheme' => [
        '1' => 'Loan',
        '2' => 'Advance'
    ],
    'salutation_array' => [
        '1' => 'Mr',
        '2' => 'Mrs',
        '3' => 'Miss',
        '4' => 'Dr'
    ],
    'currency_symbol' => '$',
    'gender_array' => [
        '0' => 'Male',
        '1' => 'Female',
        '2' => 'Trans Gender'
    ],
    'loan_status' => [
        '0' => 'Pending',
        '1' => 'Approved',
        '2' => 'Rejected',
        '3' => 'Deposited'
    ],
    'payment_method' => [
        '1' => 'Bank Deposit',
        '2' => 'Paid Cheque',
        '3' => 'Cash'
    ],
    'access' => [
        '0' => 'Dashboard',
        '1' => 'Manage Admin roles',
        '2' => 'Manage Admin users',
        '3' => 'Manage Loan Categories',
        '4' => 'Manage Salary Level',
        '5' => 'Manage Banks',
        '6' => 'Manage Members Type',
        '7' => 'Manage Members',
        '8' => 'New Members Loan/Advance Scheme',
        '9' => 'Requested Loans - (Credit Committee)',
        '10' => 'Requested Loans',
        '11' => 'Approved Loans',
        '12' => 'Deposited Loans',
        '13' => 'Other Status Loans - (Credit Committee)',
        '14' => 'Upload Savings',
        '15' => 'Upload Advance Repayment',
        '16' => 'Upload Loan Repayment',
        '17' => 'Generate Advance Repayment',
        '18' => 'Generate Loan Repayment',
        '19' => 'Admin Settings',
        '20' => 'Advance Reconciliation',
        '21' => 'SIPEU Loans'
    ],
    'menu_links' => [
        '0' => ['title' => 'Dashboard', 'class' => 'fa-dashboard', 'url' => 'admin/dashboard', 'controller' => 'Admin/AdminController'],
        '1' => ['title' => 'Manage Roles', 'class' => 'fa-users', 'url' => 'admin/roles', 'controller' => 'Admin/RoleMasterController'],
        '2' => ['title' => 'Manage Admin Users', 'class' => 'fa-user', 'url' => 'admin/users', 'controller' => 'Admin/UserController'],
        '3' => ['title' => 'Manage Loan Categories', 'class' => 'fa-server', 'url' => 'admin/loancategories', 'controller' => 'Admin/LoanCategoriesController'],
        '4' => ['title' => 'Manage Salary Level', 'class' => 'fa-sliders', 'url' => 'admin/salarylevels', 'controller' => 'Admin/SalaryLevelController'],
        '5' => ['title' => 'Manage Banks', 'class' => 'fa-money', 'url' => 'admin/banks', 'controller' => 'Admin/BankController'],
        '6' => ['title' => 'Manage Members Type', 'class' => 'fa-users', 'url' => 'admin/customer_type', 'controller' => 'Admin/CustomerTypeController'],
        '7' => ['title' => 'Manage Members', 'class' => 'fa-user', 'url' => 'admin/customers', 'controller' => 'Admin/CustomerController'],
        '8' => ['title' => 'New Members Loan/Advance Scheme', 'class' => 'fa-circle-o text-red', 'url' => 'admin/loan_section', 'controller' => 'Admin/LoanController'],
        '9' => ['title' => "Requested Loans", 'class' => 'fa-circle-o text-aqua', 'url' => 'admin/committee/customerLoanDetails', 'controller' => 'Admin/CommitteeController'],
        '10' => ['title' => "Requested Loans", 'class' => 'fa-circle-o text-aqua', 'url' => 'admin/loan/customerLoanRequests', 'controller' => 'Admin/LoanController'],
        '11' => ['title' => "Approved Loans", 'class' => 'fa-circle-o text-aqua', 'url' => 'admin/accounts/customerApprovedLoanDetails', 'controller' => 'Admin/AccountsController'],
        '12' => ['title' => "Deposited Loans", 'class' => 'fa-circle-o text-aqua', 'url' => 'admin/accounts/DepositedLoans', 'controller' => 'Admin/AccountsController'],
        '13' => ['title' => "Other Status Loans", 'class' => 'fa-circle-o text-aqua', 'url' => 'admin/committee/customerApprovedLoanDetails', 'controller' => 'Admin/CommitteeController'],
        '14' => ['title' => "Upload Savings", 'class' => 'fa-money', 'url' => 'admin/import/savings', 'controller' => 'Admin/AdminController'],
        '15' => ['title' => "Upload Advance Repayment", 'class' => 'fa-money', 'url' => 'admin/import/advance-loan', 'controller' => 'Admin/AdminController'],
        '16' => ['title' => "Upload Loan Repayment", 'class' => 'fa-money', 'url' => 'admin/import/credit-loan', 'controller' => 'Admin/AdminController'],
        '17' => ['title' => "Generate Advance Repayment", 'class' => 'fa-money', 'url' => 'admin/generate/advance-repayment-list', 'controller' => 'Admin/AdminController'],
        '18' => ['title' => "Generate Loan Repayment", 'class' => 'fa-money', 'url' => 'admin/generate/credit-repayment-list', 'controller' => 'Admin/AdminController'],
        '19' => ['title' => "Admin Settings", 'class' => 'fa-cog', 'url' => 'admin/settings', 'controller' => 'Admin/AdminController'],
        '20' => ['title' => "Advance Reconciliation", 'class' => 'fa-money', 'url' => 'admin/advance-reconciliation', 'controller' => 'Admin/AccountsController'],
        '21' => ['title' => "SIPEU Loans", 'class' => 'fa-money', 'url' => 'admin/total-loans', 'controller' => 'Admin/AdminController']
    ]
];
