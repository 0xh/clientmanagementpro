<?php

function call_js($js = array())
{
    $htm = '';
    foreach ($js as $key => $value) {
        $htm .= Html::script(asset($value));
    }
    return $htm;
}

function call_css($css = array())
{
    $htm = '';
    foreach ($css as $key => $value) {
        $htm .= Html::style(asset($value));
    }
    return $htm;
}

function word_limit($word = '', $limit='5')
{
    preg_match( '/^([\w]+[\s[:punct:]]+){1,15}/' , $word , $m );
    return $m[0];
}