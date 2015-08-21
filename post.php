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


function get_curl_error($handle)
{
    return curl_errno($handle).": ".curl_error($handle);
}


$post_location = session_get('post_location');
if (strlen($post_location) == 0)
    error('No "post_location" in session');
$post_parameters = session_get('post_parameters');
if (strlen($post_parameters)>0)
    $post_parameters=unserialize($post_parameters);
$post_headers = session_get('post_headers');
if (strlen($post_headers)>0)
    $post_headers=unserialize($post_headers);
else
    $post_headers=array();

$post_headers[] = 'Accept: application/json';

$response = '';

if ( 'go' == http_get('action'))
{
    $curl = curl_init($post_location);
    if (false === $curl)
        error('curl_init failed');

    if (false === curl_setopt($curl, CURLOPT_RETURNTRANSFER, true) )   // Get result from curl_exec
        error('curl_setopt(..., CURLOPT_RETURNTRANSFER, true) failed; '.get_curl_error($curl));

    if(is_array($post_parameters))
    {
        $post = http_build_query($post_parameters);
        if (false === curl_setopt($curl, CURLOPT_POSTFIELDS, $post) )
            error('curl_setopt(..., CURLOPT_POSTFIELDS, ...) failed; '.get_curl_error($curl));
    }

    if(is_array($post_headers))
    {
        if (false === curl_setopt($curl, CURLOPT_HTTPHEADER, $post_headers) )
            error('curl_setopt(..., CURLOPT_HTTPHEADER, ...) failed; '.get_curl_error($curl));
    }

    $response = curl_exec($curl);
    if (false === $response)
        error('curl_exec failed; '.get_curl_error($curl));

    curl_close($curl);

    $decoded_response = json_decode($response);

    if (null === $decoded_response)
    {
        html_start();
        echo "<h1>Error decoding response</h1>\n";
        echo "<h2>Response</h2>\n";
        echo "<code>".htmlentities($response)."</code>";
    }
    else
    {
        // Redirect back to client with what we've got
        header('Location: client.php?'.http_build_query($decoded_response));
    }

    exit;
}

html_start();

echo "<h1>Post</h1>\n";
echo "<p>Make a back channel call</p>\n";
echo "<h2>Location</h2>\n";
echo "<code>".htmlentities($post_location)."</code>\n";

if (is_array($post_parameters))
{
    echo "<h2>Parameters</h2>\n";
    echo "<table>\n";
    foreach ($post_parameters as $key=>$value)
        echo "<tr><td><code>".htmlentities($key)."</code></td><td><code>".htmlentities($value)."</code></td></tr>\n";
    echo "</table>\n";
}

echo "<h2>HTTP Headers</h2>\n";
foreach ($post_headers as $value)
{
    echo "<code>".htmlentities($value)."</code>\n";
}

echo "<h3><a href='post.php?action=go'>Go!</a></h3>\n";


html_end();