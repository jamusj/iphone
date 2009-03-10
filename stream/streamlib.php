<?php
    /*
     Copyright (c) 2009, Jamus Jegier
     All rights reserved.
     
     Redistribution and use in source and binary forms, with or without 
     modification, are permitted provided that the following conditions are met:
     
     - Redistributions of source code must retain the above copyright notice, this 
     list of conditions and the following disclaimer.
     
     - Redistributions in binary form must reproduce the above copyright notice, 
     this list of conditions and the following disclaimer in the documentation 
     and/or other materials provided with the distribution.
     - Neither the name of the Jamus Jegier nor the names of its contributors 
     may be used to endorse or promote products derived from this software 
     without specific prior written permission.
     
     THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" 
     AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE 
     IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE 
     ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE 
     LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR 
     CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF 
     SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS 
     INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN 
     CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) 
     ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE 
     POSSIBILITY OF SUCH DAMAGE.
     
     */

    function resolveMp3Stream($url)
    {
        // create a new cURL resource
        $ch = curl_init();
        
        // set URL and other appropriate options
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        
        // grab URL and pass it to the browser
        $result=curl_exec($ch);
        
        // try PLS format first
        
        preg_match_all("/File.*?=(.*)/",$result,$matches);
        
        // if we don't get any matches, try M3U format next
        if (sizeof($matches[0])==0)
        {
            preg_match_all("/^(http.*)/",$result,$matches);
        }
        $url=$matches[1][0];
        
        
        // close cURL resource, and free up system resources
        curl_close($ch);
        return $url;
    }
    
    function parseMp3Stream($url)
    {
        preg_match("|(.*?)\://(.*?)(:(.*?))?(/.*)?$|",$url,$matches);
        $ret["protocol"]=$matches[1];
        $ret["site"]=$matches[2];
        $ret["port"]=( (isset($matches[4]) && $matches[4]!="") ?$matches[4]:80);
        $ret["loc"]=( (isset($matches[5]) && $matches[5]!="") ?$matches[5]:"/");
        return $ret;
    }

?>