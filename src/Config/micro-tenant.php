<?php

return [
    'database' => [
        'app_tenant'   => [
            'prefix' => 'lite_',
            'suffix' => ''
        ],
        'model_connections' => [
            "central"        => [
                'models' => [
                    "ApiAccess",
                    "Cache",
                    "CacheLock",
                    "Country",
                    "District",
                    "Domain",
                    "FailedJob",
                    "JobBatch",
                    "Job",
                    "PasswordResetToken",
                    "PayloadMonitoring",
                    "PersonalAccessToken",
                    "Province",
                    "Subdistrict",
                    "Tenant",
                    "UserReference",
                    "User",
                    "Village",
                    "Workspace"
                ]
            ],
            "central_app"    => [
                'models' => [
                    "Encoding",
                    "MasterFeature",
                    "ModelHasFeature",
                    'CentralActivityStatus',
                    'CentralActivity'
                ]
            ],
            "central_tenant" => [
                'models' => [

                ]
            ],
            'pos' => [
                'is_cluster' => true,
                'connection_as' => 'tenant',
                'models' => [
                    'PosTransaction',
                    'PosTransactionItem',
                    'Activity',
                    'ActivityStatus',
                    'Billing',
                    'Invoice',
                    'TransactionHasConsument',
                    'PosTransactionItem',
                    'PaymentSummary',
                    'PaymentHistory',
                    'SplitPayment',
                    'PaymentDetail',
                    'PaymentHasModel',
                    'Refund',
                    'WalletTransaction'
                ]
            ],
            'emr' => [
                'is_cluster' => true,
                'connection_as' => 'tenant',
                'models' => [
                    'VisitPatient',
                    'VisitRegistration',
                    'Referral',
                    'VisitExamination',
                    'PatientTypeHistory',
                    'PractitionerEvaluation',
                    'ExaminationSummary',
                    'Support',
                    'InformedConsent',
                    'Assessment',
                    'Diagnose',
                    'PatientIllness',
                    'ExaminationTreatment',
                    'Prescription'
                ]
            ]
        ]
    ],
];