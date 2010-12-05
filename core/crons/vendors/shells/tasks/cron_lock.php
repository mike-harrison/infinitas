<?php
	class CronLockTask extends Shell {
		public $uses = array(
			'Crons.Cron'
		);

		/**
		 * @property Cron
		 */
		public $Cron;

		/**
		 * @brief This method checks if there is a cron already running befor starting a new one
		 *
		 * If there is already a cron running this method will prevent the cron
		 * from continuing. If It has been a long time since the cron has run
		 * it will send an email to alert the admin that there is a problem.
		 *
		 * @todo should see if there is a way to kill the process for self maintanence.
		 */
		public function start(){
			return $this->Cron->start();
		}

		public function end($tasksRan = 0, $memAverage = 0, $loadAverage = 0){
			return $this->Cron->end($tasksRan, $memAverage, $loadAverage);
		}
	}
