<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |    
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |    
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timout:
    |    
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */
    
    'pdf' => [
        'enabled' => true,
        // 'binary'  => env('WKHTML_PDF_BINARY', '/usr/local/bin/wkhtmltopdf'),
        'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf"',

        'timeout' => false,
        'options' => ["enable-local-file-access" => true ,
                'margin-top'    => 35,
                'margin-right'  => 10,
                'margin-bottom' => 15,
                'margin-left'   => 10,
                'footer-center' => 'Page [page] of [toPage]',
                'footer-font-size' => 10,
                'footer-left' => '[date]'
                ] ,
        'env'     => [],
    ],
    
    'image' => [
        'enabled' => true,
        // 'binary'  => env('WKHTML_IMG_BINARY', '/usr/local/bin/wkhtmltoimage'),
        'binary'  => '"C:\Program Files\wkhtmltoimage\bin\wkhtmltoimage"',

        'timeout' => false,
        'options' => ["enable-local-file-access" => true] ,
        'env'     => [],
    ],

    

];
