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

require_once 'session.inc';
require_once 'util.inc';


$redirect_location = session_get('redirect_location');
if (strlen($redirect_location) == 0)
    error('No "redirect_location" in session');
$redirect_parameters = session_get('redirect_parameters');
if (strlen($redirect_parameters)>0)
    $redirect_parameters=unserialize($redirect_parameters);

$redirect_location = htmlentities($redirect_location);

$link = $redirect_location;


html_start();

echo "<h1>Redirect</h1>\n";
echo "<p>Make a front channel call</p>\n";
echo "<h2>Location</h2>\n";
echo "<code>{$redirect_location}</code>\n";

if (is_array($redirect_parameters))
{
    $link.='?'.htmlentities(http_build_query($redirect_parameters));

    echo "<h2>Parameters</h2>\n";
    echo "<table>\n";
    foreach ($redirect_parameters as $key=>$value)
    echo "<tr><td><code>".htmlentities($key)."</code></td><td><code>".htmlentities($value)."</code></td></tr>\n";
    echo "</table>\n";
}

echo "<h2><a href='".$link."'>Go!</a></h2>\n";
echo "<code>{$link}</code>\n";

html_end();