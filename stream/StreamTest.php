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

    require_once 'PHPUnit/Framework.php';
    require_once 'streamlib.php';
    
    class StreamTest extends PHPUnit_Framework_TestCase
    {
        public function testPls()
        {
            $url=resolveMp3Stream("http://jamusj.github.com/iphone/stream/test.pls");
            $this->assertEquals($url,"http://127.0.0.1:80/stream/1003");
        }
        public function testM3u()
        {
            $url=resolveMp3Stream("http://jamusj.github.com/iphone/stream/test.m3u");
            $this->assertEquals($url,"http://127.0.0.1:8000/listen");
        }
        public function testParse()
        {
            $url="http://127.0.0.1:8000/test";
            $parsed=parseMp3Stream($url);
            $this->assertEquals($parsed["protocol"],"http");
            $this->assertEquals($parsed["site"],"127.0.0.1");
            $this->assertEquals($parsed["port"],"8000");
            $this->assertEquals($parsed["loc"],"/test");
            
            $url="http://jamusj.github.com";
            $parsed=parseMp3Stream($url);
            $this->assertEquals($parsed["protocol"],"http");
            $this->assertEquals($parsed["site"],"jamusj.github.com");
            $this->assertEquals($parsed["port"],"80");
            $this->assertEquals($parsed["loc"],"/");
            
            $url="http://jamusj.github.com/test";
            $parsed=parseMp3Stream($url);
            $this->assertEquals($parsed["protocol"],"http");
            $this->assertEquals($parsed["site"],"jamusj.github.com");
            $this->assertEquals($parsed["port"],"80");
            $this->assertEquals($parsed["loc"],"/test");
        }
        
        
    }
    
    
?>