<?php

$conf=array(

	"my"	=>	array(
		"server" 			=> "home.wdgss.nl",
		"info"	 			=> "lol..........",
		"proto"	 			=> "NOQUIT", //LEAVE
		"asService" 		=> true,
		"password-r" 		=> "testpassfornow",
		"password-s" 		=> "testpassfornow",
		"channel" 	 		=> "#SuperGezellig",
		"testasNotService" 	=> true,
		"asNick"         	=> "CopyBot"
	),

	"cp"	=>	array(
		"server" 			=> "home.wdgss.nl", //funny :P
		"channel" 			=> "#testcopychannel",
		"asNick"  			=> "MySuperNick", //tip add [idle] on some servers who hates "non-talking" irc's
		"asBot"   			=> false //must set +B [some servers want that, but you risk a ban!]
	),

	'usedatabase'  			=> false, //not supported yet
	'makeusers'    			=> true, // must supported
	'copychannels' 			=> false, //can copy one channel :(

	'copyadmins'   			=> "Wes,Mariska" //adminNicks
);

?>
