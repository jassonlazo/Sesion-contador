<?php
if (!isset($_COOKIE['loggedin']) || (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] == 'false'))
    {
        header("Location: login.php");
        exit;
    }
elseif (isset($_COOKIE['loggedin']) && $_COOKIE['loggedin'] == 'true')
    {
    //user is logged in, page was refreshed or reloaded to restart session so reset cookie
    setcookie("loggedin", "true", time()+30);
    }    
?>

<!DOCTYPE html>
<html>
<head>
<title>Avisar Tiempo de espera</title>
<link rel="stylesheet" type="text/css" href="css/style.css">
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.7.2.custom.css">

<script src="js/jquery-1.3.2.min.js" type="text/javascript" language="javascript"></script>
<script src="js/jquery-ui-1.7.2.custom.min.js" type="text/javascript" language="javascript"></script>

<script type="text/javascript" language="javascript">
//event to check session time variable declaration
var checkSessionTimeEvent;

$(document).ready(function() {
	//event to check session time left (times 1000 to convert seconds to milliseconds)
    checkSessionTimeEvent = setInterval("checkSessionTime()",10*1000);
});
//Sus variables de sincronización en número de segundos

//longitud total de la sesión en cuestión de segundos
var sessionLength = 30; 
//time warning shown (10 = warning box shown 10 seconds before session starts)
var warning = 10;  
//time redirect forced (10 = redirect forced 10 seconds after session ends)     
var forceRedirect = 10; 

//time session started
var pageRequestTime = new Date();

//session timeout length
var timeoutLength = sessionLength*1000;

//set time for first warning, ten seconds before session expires
var warningTime = timeoutLength - (warning*1000);

//force redirect to log in page length (session timeout plus 10 seconds)
var forceRedirectLength = timeoutLength + (forceRedirect*1000);

//set number of seconds to count down from for countdown ticker
var countdownTime = warning;

//warning dialog open; countdown underway
var warningStarted = false;

function checkSessionTime()
{
	//get time now
	var timeNow = new Date(); 
	
	//event create countdown ticker variable declaration
	var countdownTickerEvent; 	
	
	//difference between time now and time session started variable declartion
	var timeDifference = 0;
	
	timeDifference = timeNow - pageRequestTime;

    if (timeDifference > warningTime && warningStarted === false)
        {            
            //call now for initial dialog box text (time left until session timeout)
            countdownTicker(); 
            
            //set as interval event to countdown seconds to session timeout
            countdownTickerEvent = setInterval("countdownTicker()", 1000);
            
            $('#dialogWarning').dialog('open');
			warningStarted = true;
        }
    else if (timeDifference > timeoutLength){
    		//close warning dialog box
            if ($('#dialogWarning').dialog('isOpen')) $('#dialogWarning').dialog('close');
            
            //$("p#dialogText-expired").html(timeDifference);
            $('#dialogExpired').dialog('open');
            
             //clear (stop) countdown ticker
            clearInterval(countdownTickerEvent);
        }
        
    if (timeDifference > forceRedirectLength)
     	{    
        	//clear (stop) checksession event
            clearInterval(checkSessionTimeEvent);
            //force relocation
            window.location="login.php?expired=true";
        }

}

function countdownTicker()
{
	//put countdown time left in dialog box
	$("span#dialogText-warning").html(countdownTime);
	
	//decrement countdownTime
	countdownTime--;
}

$(function(){              
                // jQuery UI Dialog    
                $('#dialogWarning').dialog({
                    autoOpen: false,
                    width: 400,
                    modal: true,
                    resizable: false,
                    buttons: {
                        "Reiniciar Sesion": function() {
                            location.reload();
                        }
                    }
                });
                
                $('#dialogExpired').dialog({
                    autoOpen: false,
                    width: 400,
                    modal: true,
                    resizable: false,
					close: function() {
                            window.location="login.php?expired=true";
                        },
                    buttons: {
                        "Login": function() {
                            window.location="login.php?expired=true";
                        }
                    }
                });
});
</script>

</head>
<body>
<div class="container">
<h1>Sesion contador demo</h1>
<p>Espera 20 Segundos!!!<br />
<img src="css/images/loadingAnimation.gif" align="Animacion" /></p>
<p>Cookies:<br />
<?php
// all cookies
print_r($_COOKIE);
?>
</p>
<p><a href="login.php?expired=true">Salir</a></p>
<p><a href="http://facebook.com/jasson.lazo">Jasson Lazo</a></p>
</div>
</div>
<!--Dialog box contents-->
<div id="dialogExpired" title="Session (Page) Expired!"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span> Tu Sesion ah expirado<p id="dialogText-expired"></p></div>

<div id="dialogWarning" title="Session (Page) Expiring!"><p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 0 0;"></span> Tu Sesion Expira en <span id="dialogText-warning"></span> Segundos!</div>

</body>
</html>
