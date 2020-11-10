<?php

namespace App\Models;

class TaskFormat
{
	public static function taskListFormat(array &$taskList)
	{
		foreach($taskList as &$task) {
			self::dateFormat($task['due']);
			self::priorityFormat($task['priority']);
			self::finishedFormat($task['finished']);
		}
	}

	public static function dateFormat(&$date)
	{
		$dateTime = new \DateTime($date);

		self::dateEmpty($date);

		if (!empty($date)) {
			$date = $dateTime->format('d/m/Y');
		}
	}

	public static function priorityFormat(&$priority)
	{
		switch ($priority) {
			case 'low':
				$priority = 'baixa';
				break;
			case 'medium':
				$priority = 'média';
				break;
			case 'high':
				$priority = 'alta';
				break;
		}
	}

	public static function finishedFormat(&$finished)
	{
		if($finished == 1) {
			$finished = 'sim';
		} else {
			$finished = 'não';
		}
	}

	private static function dateEmpty(&$date)
	{
		if ($date == '0000-00-00') {
			$date = '';
		}
	}
}
