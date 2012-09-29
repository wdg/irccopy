<?php

	//SCS => SuperCopySystem 

  include 'include/config.php'; //config XD

  error_reporting(E_ALL);    // alle error`s laten zien
  set_time_limit(0);         // neem alle tijd
//  ob_implicit_flush();       // Voor Connectie stabiliteit << does not what i want.
  define('nl',"\n");         // newline

  $socketRead  = @fsockopen($conf['cp']['server'], 6667);
  $socketWrite = @fsockopen($conf['my']['server'], 6667);

  if(!( $socketRead && $socketWrite ) )
  	{
  		exit('WTF');
  	}
  else
  	{	//w until better :P
  		$realname='Tbot';
  		$ident   = $conf['my']['asNick'];
  		send('w', "USER $ident $ident $ident :$realname\nNICK $ident\n");
  		$ident   = $conf['cp']['asNick'];
		send('r', "USER $ident $ident $ident :$realname\nNICK $ident\n");
  	}

if ( false == true ) { //handleasservice 
  send("PASS :" . $conf['pass']);
  send("PROTOCTL NOQUIT");
  send("SERVER " . $conf['sserver'] . " 1 :WesDeGroot Php Services Server");
}


function send($w,$txt) {
	global $conf, $socketWrite, $socketRead;

	if( $w == 'w' )
	{
	  if(!fputs($socketWrite,$txt . nl))
	  	unset($socketWrite);
	}
	else
	{
	  if(!fputs($socketRead,$txt . nl))
	  	unset($socketRead);
	}

  	if ( true ) {
   		echo "[" . $w . "] -> " . $txt . nl;
  	}
}



while(1) {

$dataRead  = fgets($socketRead,  128);
$dataWrite = fgets($socketWrite, 128);

if (!$socketRead || !$socketWrite)
 exit('One Of My Bots crashed (Backupplan will be made)'); //does not be called xD
//echo "/readmessage/Read.sock => " . $dataRead . "\n";
//echo "/readmessage/Write.sock => " . $dataWrite . "\n";

flush();

$exRead = explode(' ', $dataRead);
$ex2Read = explode(':', $dataRead);

	if (isset($exRead[3]))
		{
			$commandRead = str_replace(array(chr(10), chr(13)), '', $exRead[3]);
		}
	else
		{
			$commandRead = false;
		}

$exWrite  = explode(' ', $dataWrite);
$ex2Write = explode(':', $dataWrite);

	if (isset($exWrite[3]))
		{
			$commandWrite = str_replace(array(chr(10), chr(13)), '', $exWrite[3]);
		}
	else
		{
			$commandWrite = false;
		}

		// now make a thing that we'll check if the MOTD is over... or just not exists ;)
		if(preg_match("/(376|422)/", $dataRead))
		{
			send('r', 'JOIN ' . $conf['cp']['channel']);
		}

		if(preg_match("/(376|422)/", $dataWrite))
		{
			send('w', 'JOIN ' . $conf['my']['channel']);
		}

		///readmessage/Read.sock => :Wes!Wes@x.nl PRIVMSG #testcopychannel ::P
		if(preg_match("/PRIVMSG/", $dataRead))
		{
			if ( $exRead[2] == $conf['cp']['channel'])
			{
				// Read That Data out :)
				$cdata   = explode(":", $dataRead);
				$nick    = explode("!", $cdata[1]);
				$nick    = $nick[0];
				$message = $cdata[2];

				send('w', 'PRIVMSG '.$conf['my']['channel'].' :'.$nick.': '.$message."\r\n");
			}
		}

        if($exRead[0] == "PING"){
          send('r',"PONG ".$exRead[1]."\n");
        }
        if($exWrite[0] == "PING"){
          send('w',"PONG ".$exWrite[1]."\n");
        }

	unset($dataRead, $dataWrite, $exWrite, $exRead);

}