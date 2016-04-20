<?php

return [
    'adminEmail'                    => 'admin@example.com',
    'supportEmail'                  => 'noreply@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'languages'                     => [
        'en' => [
            'title'        => 'English',
            'dateFormat'   => 'dd MMMM yyyy',
            'yearOffset'   => 0,
            'dateSettings' => null,
            'timezone'     => null,
            'LC'           => 'en_US',
        ],
        'th' => [
            'title'        => 'Thai',
            'dateFormat'   => 'dd MMMM yyyy',
            'yearOffset'   => 543,
            'timezone'     => null,
            'dateSettings' => [
                'days'        => ["อาทิตย์", "จันทร์", "อังคาร", "พุธ", "พฤหัส", "ศุกร์", "เสาร์", "อาทิตย์"],
                'daysShort'   => ["อา", "จ", "อ", "พ", "พฤ", "ศ", "ส", "อา"],
                'months'      => ["มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"],
                'monthsShort' => ["ม.ค.", "ก.พ.", "มี.ค.", "เม.ย.", "พ.ค.", "มิ.ย.", "ก.ค.", "ส.ค.", "ก.ย.", "ต.ค.", "พ.ย.", "ธ.ค."],
                'meridiem'    => ['AM', 'PM'],
            ],
            'LC'           => 'th_TH',
        ],
    ],
    'kartik/grid/'                  => [
        'pageSummaryRowOptions' => ['class' => 'page-summary warning'],
        'exportConfig'          => [
            'pdf' => [
                'label'           => 'PDF',
                'icon'            => 'file-pdf-o',
                'iconOptions'     => ['class' => 'text-danger'],
                'showHeader'      => TRUE,
                'showPageSummary' => TRUE,
                'showFooter'      => TRUE,
                'showCaption'     => TRUE,
                'alertMsg'        => Yii::t('app/pdf', 'The PDF export file will be generated for download.'),
                'mime'            => 'application/pdf',
                'config'          => [
                    'mode'          => 'tha',
                    'format'        => 'A4-L',
                    'destination'   => 'D',
                    'marginTop'     => 20,
                    'marginBottom'  => 20,
                    'cssFile'       => '@app/assets/pdf/pdf.css',
                    'options'       => [
                        'title'            => 'Custom Title',
                        'subject'          => 'PDF export',
                        'keywords'         => 'pdf',
                        'autoScriptToLang' => true,
                        'autoLangToFont'   => true,
                    ],
                    'contentBefore' => '',
                    'contentAfter'  => '',
                ],
            ],
        ],
        'bordered'              => true,
        'striped'               => true,
        'condensed'             => true,
        'responsive'            => true,
        'hover'                 => false,
        'showPageSummary'       => false,
        'pjax'                  => true,
        'panel'                 => [
            'type' => 'primary',
        ],
        'toggleDataContainer'   => ['class' => 'btn-group btn-group-xs'],
        'exportContainer'       => ['class' => 'btn-group btn-group-xs'],
        'panelTemplate'         => '<div class="panel panel-primary panel-sm">
                                        {panelHeading}
                                        {items}
                                        {panelFooter}
                                   </div>',
        'panelHeadingTemplate'  => '<div class="pull-right">
                                        {toolbar}
                                    </div>
                                    <h3 class="panel-title">
                                        {heading}
                                    </h3>
                                    <div class="clearfix"></div>',

    ],

    'pdf' => [
        'header' => [
            'L' => [
                'content'   => '',
                'font-size' => 8,
                'color'     => '#333333',
            ],
            'C' => [
                'content'   => '',
                'font-size' => 16,
                'color'     => '#333333',
            ],
            'R' => [
                'content'   => '',
                'font-size' => 8,
                'color'     => '#333333',
            ],
        ],
        'footer' => [
            'L'    => [
                'content'    => '',
                'font-size'  => 8,
                'font-style' => 'B',
                'color'      => '#999999',
            ],
            'R'    => [
                'content'     => '[ {PAGENO} ]',
                'font-size'   => 10,
                'font-style'  => 'B',
                'font-family' => 'serif',
                'color'       => '#333333',
            ],
            'line' => TRUE,
        ],
    ],
    'sms' => [
        'username' => 'VDCportal',
        'password' => 'vdx51055',
        'sender'   => 'TermSaBuy',
        'gateway'   => 'https://member.smsmkt.com/SMSLink/SendMsg/index.php'
    ],
];
