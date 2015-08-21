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

require_once 'util.inc';

require_once 'session.inc';

include_once 'defaults.inc';
include_once 'oauth2_errors.inc';

function redirect($location, $parameters)
{
    session_set('redirect_location', $location);
    session_set('redirect_parameters', serialize($parameters) );
    header('Location: redirect.php' );
    exit;
}

function post($location, $parameters, $headers)
{
    session_set('post_location', $location);
    session_set('post_parameters', serialize($parameters) );
    session_set('post_headers', serialize($headers) );
    header('Location: post.php' );
    exit;
}

function main()
{
    global $defaults;

    if ( isset($defaults[http_get('load_defaults')]) )
    {
        $default = $defaults[http_get('load_defaults')];
        $client_id = $default['client_id'];
        $client_secret = $default['client_secret'];
        $authorizeURL = $default['AuthorizeURL'];
        $tokenURL = $default['TokenURL'];
        if (isset($default['scope']))
            $scope = $default['scope'];
        if (isset($default['state']))
            $state = $default['state'];
        if (isset($default['code']))
            $code = $default['code'];
        if (isset($default['token_type']))
            $token_type = $default['token_type'];
        if (isset($default['access_token']))
            $token_type = $default['access_token'];
        if (isset($default['redirect_uri']))
            $redirect_uri = $default['redirect_uri'];
        if (isset($default['grand_type']))
            $redirect_uri = $default['grand_type'];
        else
            $redirect_uri = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'];
    }
    else
    {
        $client_id = http_get('client_id', session_get('client_id'));
        $client_secret = http_get('client_secret', session_get('client_secret'));
        $authorizeURL = http_get('AuthorizeURL', session_get('AuthorizeURL'));
        $tokenURL = http_get('TokenURL', session_get('TokenURL'));
        $scope = http_get('scope', session_get('scope'));
        $state = http_get('state', session_get('state'));
        $redirect_uri = http_get('redirect_uri', session_get('redirect_uri'));
        $code = http_get('code', session_get('code'));
        $access_token = http_get('access_token', session_get('access_token'));
        $token_type = http_get('token_type', session_get('token_type'));
        $grand_type = http_get('grand_type', session_get('grand_type'));
    }

    session_set('client_id', $client_id);
    session_set('client_secret', $client_secret);
    session_set('AuthorizeURL', $authorizeURL);
    session_set('TokenURL', $tokenURL);
    session_set('scope', $scope);
    session_set('state', $state);
    session_set('redirect_uri', $redirect_uri);
    session_set('code', $code);
    session_set('access_token', $access_token);
    session_set('token_type', $token_type);
    session_set('grand_type', $grand_type);

    if ( 'Authorization Request' == http_get('action') )
    {
        // Mandatory
        $query = array(
            'response_type' => 'code',
            'client_id' => $client_id,
        );
        // Optional
        if (strlen($redirect_uri) > 0)
            $query['redirect_uri'] = $redirect_uri;
        if (strlen($scope) > 0)
            $query['scope'] = $scope;
        if (strlen($state) > 0)
            $query['state'] = $state;

        redirect($authorizeURL, $query);    // Redirect to authorization URL

        exit;
    }

    if ('Access Token Request' == http_get('action') )
    {
        $request = array(
            'grant_type' => $grand_type,
            'client_id' => $client_id,
        );
        if (strlen($redirect_uri) > 0)
            $request['redirect_uri'] = $redirect_uri;
        if (strlen($state) > 0)
            $request['state'] = $state;
        if (strlen($code) > 0)
            $request['code'] = $code;
        if (strlen($client_secret) > 0)
            $request['client_secret'] = $client_secret;

        $headers = array();

        post($tokenURL, $request, $headers);
        exit;
    }


    html_start();

    echo "<h1>OAuth2 Client</h1>\n";

    if (isset($_GET['error']))
    {
        echo "<h2>Error</h2>\n";
        echo "<h3>".htmlentities($_GET['error'])."</h3>\n";
        global $oauth2_errors;
        if (isset($oauth2_errors[$_GET['error']]))
            echo htmlentities($oauth2_errors[$_GET['error']]);
        else
            echo "Unknown error.\n";
        if (isset($_GET['error_description']))
        {
            echo "<h3>error_description</h3>\n";
            echo htmlentities($_GET['error_description']);
        }
        if (isset($_GET['error_uri']))
        {
            echo "<h3>error_uri</h3>\n";
            $link = htmlentities($_GET['error_uri']);
            echo "<a href='{$link}'><code>{$link}</code></code></a>\n";
        }
    }

    echo "<form method='get'>\n";
    echo "<h2>Configuration</h2>\n";
    form_input('client_id', $client_id);
    form_input('client_secret', $client_secret);
    form_input('AuthorizeURL', $authorizeURL);
    form_input('TokenURL', $tokenURL);
    form_input('redirect_uri', $redirect_uri);
    echo "<h2>Parameters</h2>\n";
    form_input('code', $code);
    form_input('scope', $scope);
    form_input('access_token', $access_token);
    form_input('token_type', $token_type);
    form_select('grand_type', $grand_type, array(
            'authorization_code' => 'authorization_code',
            'client_credentials' => 'client_credentials',
        )
    );
    echo "<h2>Actions</h2>\n";
    echo "<h3>OAuth2 Requests</h3>\n";
    form_submit('action', 'Authorization Request');
    form_submit('action', 'Access Token Request');
    echo "<h3>Form</h3>\n";
    form_submit('', 'Update');
    echo "</form>\n";

    echo "<h3>Load defaults</h2>\n";
    global $defaults;
    foreach ($defaults as $option => $settings)
        echo "<li><a href='client.php?load_defaults={$option}'>{$option}</a></li>\n";

    html_end();
}

try
{
    main();
}
catch (Exception $e)
{
    error($e);
}