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

$defaults=array(
    'reset' => array(
        'client_id' => '',
        'client_secret' => '',
        'AuthorizeURL' => '',
        'TokenURL' => '',
        'scope' => '',
        'state' =>'',
        'code' => '',
        'token_type' => '',
        'access_token' => '',
    ),
    'clear all' => array(
        'client_id' => '',
        'client_secret' => '',
        'AuthorizeURL' => '',
        'TokenURL' => '',
        'scope' => '',
        'state' =>'',
        'code' => '',
        'token_type' => '',
        'access_token' => '',
        'redirect_uri' => '',
        'grand_type' => 'authorization_code',
    ),
    'pieter_test_oauth_client' => array(
        'client_id' => 'pieter_test_oauth_client_id',
        'client_secret' => 'pieter_test_oauth_client_secret',
        'AuthorizeURL' => 'https://api.test.surfconext.nl/v1/oauth2/authorize',
        'TokenURL' => 'https://api.test.surfconext.nl/v1/oauth2/token',
        'scope' => 'read',
        'state' =>'',
        'code' => '',
    ),
);
