<?php

	//SCS => SuperCopySystem 

  include 'include/config.php'; //config XD

  error_reporting(E_ALL);    // alle error`s laten zien
  set_time_limit(0);         // neem alle tijd
//  ob_implicit_flush();       // Voor Connectie stabiliteit << does not what i want.
  define('nl',"\n");         // newline

  $socketRead  = @fsockopen($conf['cp']['server'], 6667); //connect ReadServer [clone]
  $socketWrite = @fsockopen($conf['my']['server'], 6667); //connect WriteServer [paste]

  if(!( $socketRead && $socketWrite ) )
  	{
  		exit('WTF'); //Error....?
  	}
  else
  	{	//w until better :P
  		$realname='Tbot'; //Botname
  		$ident   = $conf['my']['asNick']; //as nick/IDENT
  		send('w', "USER $ident $ident $ident :$realname\nNICK $ident\n");//PASTE
  		$ident   = $conf['cp']['asNick'];//Server2
		send('r', "USER $ident $ident $ident :$realname\nNICK $ident\n");//COPY
  	}

if ( false == true ) { //handleasservice . [Not built in yet.]
  send("PASS :" . $conf['pass']); //Password...
  send("PROTOCTL NOQUIT"); //Protocol
  send("SERVER " . $conf['sserver'] . " 1 :CloneIRCServices"); //CloneServices
}


function send($w,$txt) { ///Send Command
	global $conf, $socketWrite, $socketRead;

	if( $w == 'w' ) //To The "Paste" Server
	{
	  if(!fputs($socketWrite,$txt . nl))
	  	unset($socketWrite);
	}
	else //To The "CLONE" Server
	{
	  if(!fputs($socketRead,$txt . nl))
	  	unset($socketRead);
	}

  	if ( true ) { //Debug
   		echo "[" . $w . "] -> " . $txt . nl;
  	}
}



while(1) { //never ending loop

$dataRead  = fgets($socketRead,  128); //Read the "READ" Socket
$dataWrite = fgets($socketWrite, 128); //Read the "PASTE" Socket

if (!$socketRead || !$socketWrite) // Is there data?
 exit('One Of My Bots crashed (Backupplan will be made)'); //does not be called xD
//echo "/readmessage/Read.sock => " . $dataRead . "\n";
//echo "/readmessage/Write.sock => " . $dataWrite . "\n";

flush(); //Connection Stability?

$exRead = explode(' ', $dataRead); // Explode " " to Array
$ex2Read = explode(':', $dataRead); // Explode ":" to Array

	if (isset($exRead[3])) //Replace Some Weird Characters...
		{
			$commandRead = str_replace(array(chr(10), chr(13)), '', $exRead[3]);
            //replace bold, underline
		}
	else
		{
			$commandRead = false;
            //no command given?
		} //is it a command?

$exWrite  = explode(' ', $dataWrite); // Explode " " to Array
$ex2Write = explode(':', $dataWrite); // Explode ":" to Array

	if (isset($exWrite[3])) // Command?
		{
			$commandWrite = str_replace(array(chr(10), chr(13)), '', $exWrite[3]);
            //replace bold, underline
		}
	else
		{
			$commandWrite = false;
            //no command given
		} ///is it a command?

		// now make a thing that we'll check if the MOTD is over... or just not exists ;)
		if(preg_match("/(376|422)/", $dataRead))
		{
			send('r', 'JOIN ' . $conf['cp']['channel']);
            //Join Channel (ReadServer)
		}

		if(preg_match("/(376|422)/", $dataWrite))
		{
			send('w', 'JOIN ' . $conf['my']['channel']);
            //joins channel (PASTEServer)
		}

		///readmessage/Read.sock => :Wes!Wes@x.nl PRIVMSG #testcopychannel ::P
		if(preg_match("/PRIVMSG/", $dataRead)) //Yeah!, something to clone :P
		{
			if ( $exRead[2] == $conf['cp']['channel']) //is it the "cloning" channel?
			{
				// Read That Data out :)
                //Parsing nickname
				$cdata   = explode(":", $dataRead); //explode :nick!xxx@xxx privmsg #channel :message
				$nick    = explode("!", $cdata[1]); //explode nick!xxx@xxx
				$nick    = $nick[0]; //get Nickname
				$message = $cdata[2]; //Get Message

				send('w', 'PRIVMSG '.$conf['my']['channel'].' :'.$nick.': '.$message."\r\n");
                //send it to the "PASTEServer"
			}
		}

        if($exRead[0] == "PING"){ //got the ping
          send('r',"PONG ".$exRead[1]."\n");
          //and there the pong :)
        }
        if($exWrite[0] == "PING"){ //got the ping
          send('w',"PONG ".$exWrite[1]."\n");
          //and there the pong :)
        }

	unset($dataRead, $dataWrite, $exWrite, $exRead);
    //unset all "old" data and re-run the loop :>
}
?>