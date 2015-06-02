<?php

return [
   /*
    |--------------------------------------------------------------------------
    | 自定义扩展
    |--------------------------------------------------------------------------
    */
    'extends' => [
        '/@form(\(((?>[^()]+)|(?1))*\))?/x'        => '<?php echo form$1; ?>',
        '/@endform/s'                              => '<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"></form>',
        '/@btn_link(\(((?>[^()]+)|(?1))*\))?/x'    => '<?php echo btn_link$1; ?>',
        '/@batch_delete/s'                         => '<?php echo batch_delete(); ?>',
        '/@search_box(\(((?>[^()]+)|(?1))*\))?/x'  => '<?php echo search_box$1; ?>',
        '/@pager(\(((?>[^()]+)|(?1))*\))?/x'       => '<?php echo pager$1; ?>',
        '/@edit_link(\(((?>[^()]+)|(?1))*\))?/x'   => '<?php echo edit_link$1; ?>',
        '/@delete_link(\(((?>[^()]+)|(?1))*\))?/x' => '<?php echo delete_link$1; ?>',
        '/@tds(\(((?>[^()]+)|(?1))*\))?/x'         => '<?php echo tds$1; ?>',
        '/@title(\(((?>[^()]+)|(?1))*\))?/x'       => '<?php echo title$1; ?>',
        '/@input(\(((?>[^()]+)|(?1))*\))?/x'       => '<?php echo inputbox$1; ?>',
        '/@text(\(((?>[^()]+)|(?1))*\))?/x'        => '<?php echo input_text$1; ?>',
        '/@label(\(((?>[^()]+)|(?1))*\))?/x'       => '<?php echo label$1; ?>',
        '/@btn(\(((?>[^()]+)|(?1))*\))?/x'         => '<?php echo btn$1; ?>',
        '/@id_chkbox_col(\(((?>[^()]+)|(?1))*\))?/x' => '<?php echo id_chkbox_col$1; ?>',
        '/@select(\(((?>[^()]+)|(?1))*\))?/x'      => '<?php echo select$1; ?>',
        '/@distpicker(\(((?>[^()]+)|(?1))*\))?/x'  => '<?php echo distpicker$1; ?>',
        '/@submit(\(((?>[^()]+)|(?1))*\))?/x'      => '<?php echo submit$1; ?>',
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
