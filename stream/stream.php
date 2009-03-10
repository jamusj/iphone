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

    require_once 'streamlib.php';

    $url=resolveMp3Stream($_GET["url"]);
    $parsed_url=parseMp3Stream($url);
    
    header('Content-Type: audio/mpeg');
    
    if (strcmp($_SERVER["HTTP_RANGE"],"bytes=0-1")==0)
    {
        
        header("HTTP/1.1 206 Partial Content");
        header('Accept-Ranges: bytes');
        header('Content-Range: bytes 0-1/4000000000');
        
        echo chr(255);
        echo chr(0xFB);
        exit;
    } else if (isset($_SERVER["HTTP_RANGE"])) {
        header("HTTP/1.1 206 Partial Content");
        header('Content-Length: 4000000000');
        header('Content-Range: bytes 0-3999999999/4000000000');
        header('Accept-Ranges: bytes');
    } else {
 	header("HTTP/1.1 200 OK");
        header('Content-Length: 4000000000');
        header('Accept-Ranges: bytes');
    }
        
    
    $file=fsockopen($parsed_url["site"],$parsed_url["port"]);
    fputs($file,"GET ".$parsed_url["loc"]." HTTP/1.0\n\n");
    
    while (1)
    {
        $data=fread($file,1);
        if ($data==chr(255)) 
        {
            $data=fread($file,1);
            if ($data==chr(0xFB))
                break;
            
        }
    }
    echo chr(255);
    echo chr(0xFB);
    while (1)
    {
        $data=fread($file,1024);
        echo $data;
    }
    
    ?>

