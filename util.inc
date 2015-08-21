<?php
/**
 * Copyright 2014 SURFnet BV
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

function error($description)
{
    html_start();
    echo "<pre>\n";
    echo htmlentities($description);
    echo "\n";
    print_debug_backtrace();
    html_end();
    exit;
}


function http_get($key, $default=NULL) {
    return array_key_exists($key, $_REQUEST) ? $_REQUEST[$key] : $default;
}


function html_start($title='OAuth2 client')
{
    static $sbStarted = false;

    if ($sbStarted)
        return;

    $title = htmlentities($title);
    echo <<<html
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="en">
  <head>
    <meta http-equiv="content-type" content="text/html; charset=utf-8">
    <title>{$title}</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script type="text/javascript" src="script.js"></script>
  </head>
  <body>
html;

    $sbStarted = true;
}

function html_end()
{
    html_start();
    echo <<<html
  </body>
</html>
html;
}


function form_input($name, $value, $type='text')
{
    $value = htmlentities($value);
    $name = htmlentities($name);
    echo "<label>{$name}</label><input name='{$name}' value='{$value}' type='{$type}'/><br />\n";
}

function form_select($name, $value, $options=array())
{
    if (!isset($options[$value]) && strlen($value)>0 )
        $options[$value] = $value;
    $name = htmlentities($name);
    $value = htmlentities($value);
    echo "<label>{$name}</label><select name='{$name}'>";
    foreach ($options as $option_value => $option_label)
    {
        $option_value = htmlentities($option_value);
        $option_label = htmlentities($option_label);
        $selected = ($option_value == $value) ? ' selected' : '';
        echo "<option value='$option_value'{$selected}>{$option_label}</option>";
    }
    echo"</select><br /> \n";
}

function form_submit($name='action', $value='submit')
{
    echo "<input type='submit' name='{$name}' value='{$value}' /><br />\n";
}