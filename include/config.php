<?php

$conf=array(

	"my"	=>	array(
		"server" 			=> "hoxxme.xxxx.nl", // lol?
		"info"	 			=> "lol..........", //info?
		"proto"	 			=> "NOQUIT", //LEAVE
		"asService" 		=> true, // not supported yet
		"password-r" 		=> "testpassfornow", //not supported yet,
		"password-s" 		=> "testpassfornow", //not supported yet,
		"channel" 	 		=> "#SuperGezellig", //channel to copy
		"testasNotService" 	=> true, //notservice not supported
		"asNick"         	=> "CopyBot" //nickname
	),

	"cp"	=>	array(
		"server" 			=> "hoxxxme.xxxxx.nl", //funny :P
		"channel" 			=> "#testcopychannel", // copy to channel
		"asNick"  			=> "MySuperNick", //tip add [idle] on some servers who hates "non-talking" irc's
		"asBot"   			=> false //must set +B [some servers want that, but you risk a ban!]
	),

	'usedatabase'  			=> false, //not supported yet
	'makeusers'    			=> true, // must supported
	'copychannels' 			=> false, //can copy one channel :(

	'copyadmins'   			=> "x,xx,xxx" //adminNicks seperated with ,
);

?>
