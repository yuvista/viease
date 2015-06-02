<?php

return [
   /*
    |--------------------------------------------------------------------------
    | 自定义扩展
    |--------------------------------------------------------------------------
    */
    'extends' => [

        '/@script(\(((?>[^()]+)|(?1))*\))?/x'      => '<?php echo HTML::script$1;?>',
        '/@decode(\(((?>[^()]+)|(?1))*\))?/x'      => '<?php echo HTML::decode$1;>',
        '/@style(\(((?>[^()]+)|(?1))*\))?/x'       => '<?php echo HTML::style$1;>',
        '/@image(\(((?>[^()]+)|(?1))*\))?/x'       => '<?php echo HTML::image$1;>',
        '/@link(\(((?>[^()]+)|(?1))*\))?/x'        => '<?php echo HTML::image$1;>',
        '/@form(\(((?>[^()]+)|(?1))*\))?/x'        => '<?php echo From::open$1;>',
        '/@endform/s'                              => '<?php echo <input type="hidden" name="_token" value="<?php echo csrf_token().From::close$1;>',
        '/@submit(\(((?>[^()]+)|(?1))*\))?/x'      => '<?php echo From::submit$1;>',
        '/@button(\(((?>[^()]+)|(?1))*\))?/x'      => '<?php echo From::button$1;>',
        '/@reset(\(((?>[^()]+)|(?1))*\))?/x'       => '<?php echo From::reset$1;>',
        '/@old(\(((?>[^()]+)|(?1))*\))?/x'         => '<?php echo From::old$1;>',
        '/@select(\(((?>[^()]+)|(?1))*\))?/x'      => '<?php echo From::select$1;>',
        '/@textarea(\(((?>[^()]+)|(?1))*\))?/x'    => '<?php echo From::textarea$1;>',
        '/@hidden(\(((?>[^()]+)|(?1))*\))?/x'      => '<?php echo From::hidden$1;>',
        '/@password(\(((?>[^()]+)|(?1))*\))?/x'    => '<?php echo From::password$1;>',
        '/@text(\(((?>[^()]+)|(?1))*\))?/x'        => '<?php echo From::text$1;>',
        '/@input(\(((?>[^()]+)|(?1))*\))?/x'       => '<?php echo From::input$1;>',
        '/@label(\(((?>[^()]+)|(?1))*\))?/x'       => '<?php echo From::label$1;>',
        '/@token(\(((?>[^()]+)|(?1))*\))?/x'       => '<?php echo From::token$1;>',
        '/@form(\(((?>[^()]+)|(?1))*\))?/x'        => '<?php echo From::open$1;>',

 
    ],


    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Most templating systems load templates from disk. Here you may specify
    | an array of paths that should be checked for your views. Of course
    | the usual Laravel view path has already been registered for you.
    |
    */

    'paths' => [
        realpath(base_path('resources/views'))
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    |
    | This option determines where all the compiled Blade templates will be
    | stored for your application. Typically, this is within the storage
    | directory. However, as usual, you are free to change this value.
    |
    */

    'compiled' => realpath(storage_path('framework/views')),

];
