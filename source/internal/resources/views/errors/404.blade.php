<!--A Design by W3layouts
    Author: W3layout
    Author URL: http://w3layouts.com
    License: Creative Commons Attribution 3.0 Unported
    License URL: http://creativecommons.org/licenses/by/3.0/
    -->
<!DOCTYPE HTML>
<html>
    <head>
        <title>404 Not found</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <style type="text/css">
        
            body{
                /*background:url(images/bg.png);*/
                background:url( {{ URL::asset('image/404/bg.png') }} );
                margin:0;
                font-family: 'Amarante', cursive;
            }

            .wrap{
                margin:0 auto;
                width:1000px;
            }

            .logo{
                text-align:center;
            }   

            .logo p span{
                color:lightgreen;
            }   

            .sub a{
                color:white;
                background:rgba(0,0,0,0.3);
                text-decoration:none;
                padding:5px 10px;
                font-size:13px;
                font-family: arial, serif;
                font-weight:bold;
            }   

            .footer{
                color:#555;
                position:absolute;
                right:10px;
                bottom:10px;
                font-size:14px;
            }   

            .footer a{
                font-size:16px;
                color:#ff4800;
            }   
        </style>
    </head>
        <body>
            <!-- <img src="images/label.png"/>  -->
            <img src="{{ URL::asset('image/404/label.png') }}"/> 
            <div class="wrap">
                <div class="logo">
                    <!-- <img src="images/woody-404.png"/> -->
                    <img src="{{ URL::asset('image/404/woody-404.png') }}"/> 
                    <div class="sub">
                        <p><a href="{{ URL::Route('user-index') }}">Go Back to Home</a></p>
                    </div>
                </div>
            </div>
            <div class="footer">
                <!-- &copy 2012 Woody 404 . All Rights Reserved | Design by <a href="http://w3layouts.com">W3layouts</a> -->
                All Rights Reserved | Design by <a href="http://insight-tec.com.vn"> Insight-tec </a>
            </div>
    </body>
</html>