<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Home - Veeco Tech Invoice System</title>

    <link rel="stylesheet" href="../Styles/style.css">

    <script src="../Lib/jquery/jquery_v3.js"></script>
    <script type="text/javascript" src="../Lib/bootstrap-3.3.7-dist/js/bootstrap.js"></script>
    <link rel="stylesheet" type="text/css" href="../Lib/bootstrap-3.3.7-dist/css/bootstrap.css" />
    <script src="../../Lib/realperson_captcha/jquery.plugin.js"></script>
    <script src="../../Lib/realperson_captcha/jquery.realperson.js"></script>
    <script src="../../Lib/PasswordStrength/password.js"></script>
    <link rel="stylesheet" href="../../Lib/PasswordStrength/password.css" />
    <link rel="stylesheet" href="../../Lib/realperson_captcha/jquery.realperson.css"/> 
    <link rel="stylesheet" href="../Styles/Scrolls.css" />
    <style type="text/css">
        footer{
            position:fixed;
            bottom:0;
            width: 100%;
            background-color: rgba(48, 255, 244, 0.45);
            padding-top: 12px;
            padding-bottom: 12px;
            font-family: sans-serif;
            font-weight: bold;
            text-align: center;
            color: white;
        }
        
        #web_link:link, #web_link:visited{
            color: rgb(234, 234, 234);
            text-decoration: underline;
        }
        
        #web_link:hover{
            color: rgb(34, 170, 166);
            text-decoration: underline;
        }
        
        #web_link:active{
            color: red;
            text-decoration: underline;
        }
        
        .realperson-challenge{
            margin-top: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
    </style>
    <script type="text/javascript">
        var cap = null;
        var cap2 = null;
        
        $(document).ready(function(e){
            cap = $('#captcha_box').realperson({
                length: 8,
                chars: $.realperson.alphanumeric
            });
        });
        
        $(document).ready(function(e){
            cap2 = $('#log_captcha_box').realperson({
                length: 8,
                chars: $.realperson.alphanumeric
            });
        });
        
        $(document).ready(function(e){
            $('#Reg_UserPw').password({
                shortPass: 'The password is too short',
                badPass: 'Weak; try combining letters & numbers',
                goodPass: 'Medium; try using special charecters',
                strongPass: 'Strong password',
                containsUsername: 'The password contains the username',
                enterPass: 'Type your password',
                showPercent: true,
                showText: true, // shows the text tips
                animate: true, // whether or not to animate the progress bar on input blur/focus
                animateSpeed: 'slow', // the above animation speed
                username: false, // select the username field (selector or jQuery instance) for better password checks
                usernamePartialMatch: true, // whether to check for username partials
                minimumLength: 5
            });
        });
        
        
    </script>
</head>