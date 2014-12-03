<?php

class CApiMailIcs
{
	/**
	 * @var string
	 */
	public $Uid;

	/**
	 * @var string
	 */
	public $Attendee;

	/**
	 * @var string
	 */
	public $File;
	
	/**
	 * @var string
	 */
	public $Type;

	/**
	 * @var string
	 */
	public $Location;

	/**
	 * @var string
	 */
	public $Description;

	/**
	 * @var string
	 */
	public $When;

	/**
	 * @var string
	 */
	public $CalendarId;

	/**
	 * @var array
	 */
	public $Calendars;

	private function __construct()
	{
		$this->Uid = '';
		$this->Attendee = '';
		$this->File = '';
		$this->Type = '';
		$this->Location = '';
		$this->Description = '';
		$this->When = '';
		$this->CalendarId = '';
		$this->Calendars = array();
	}

	/**
	 * @return CApiMailIcs
	 */
	public static function NewInstance()
	{
		return new self();
	}
}
