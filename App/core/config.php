<?php namespace Application\core;

/**
 * Config class
 * 
 */
class Config {
	const dev = 1;
	
	//production values
	const db_host		= 'localhost';
	const db_user		= 'user';
	const db_pass		= 'password';
	const db_name		= 'database';
	
	//development values
	const local_host	= 'localhost';
	const local_user	= 'usb';
	const local_pass	= 'asdf123';
	const local_name	= 'esdb';
	
	const salt			= 's4ltYs4lTs4r3b3rryS4LtY';
}