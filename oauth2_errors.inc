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

$oauth2_errors = array(
    'invalid_request' =>
'The request is missing a required parameter, includes an
invalid parameter value, includes a parameter more than
once, or is otherwise malformed.',

    'invalid_client' =>
'Client authentication failed (e.g., unknown client, no
client authentication included, or unsupported
authentication method).  The authorization server MAY
return an HTTP 401 (Unauthorized) status code to indicate
which HTTP authentication schemes are supported.  If the
client attempted to authenticate via the "Authorization"
request header field, the authorization server MUST
respond with an HTTP 401 (Unauthorized) status code and
include the "WWW-Authenticate" response header field
matching the authentication scheme used by the client.',

    'invalid_grant' =>
'The provided authorization grant (e.g., authorization
code, resource owner credentials) or refresh token is
invalid, expired, revoked, does not match the redirection
URI used in the authorization request, or was issued to
another client.',

    'unauthorized_client' =>
'The client is not authorized to request an authorization
code using this method.',

    'access_denied' =>
'The resource owner or authorization server denied the
request.',

    'unsupported_grant_type' =>
'The authorization grant type is not supported by the
authorization server.',

    'unsupported_response_type' =>
'The authorization server does not support obtaining an
authorization code using this method.',

    'invalid_scope' =>
'The requested scope is invalid, unknown, or malformed.',

    'server_error' =>
'The authorization server encountered an unexpected
condition that prevented it from fulfilling the request.
(This error code is needed because a 500 Internal Server
Error HTTP status code cannot be returned to the client
via an HTTP redirect.)',

    'temporarily_unavailable' =>
'The authorization server is currently unable to handle
the request due to a temporary overloading or maintenance
of the server.  (This error code is needed because a 503
Service Unavailable HTTP status code cannot be returned
to the client via an HTTP redirect.)',
);