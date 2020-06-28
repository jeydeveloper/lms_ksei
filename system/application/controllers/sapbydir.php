<?php

include_once "sap.php";

class SAPByDir extends SAP {
	var $report_type= "YTD";   // YTD = year to date , MTD = month to date

	function SAPByDir()
	{
		parent::SAP();					
	}
	
	function index($cli=1)
	{
		//-- generate year to date , from 1 january
		$this->set_type("YTD");
		$this->generalreport($cli);
		
		//-- generate monthly
		$this->set_type("MTD");
		$this->generalreport($cli);
	
	}
	
	function getfilename($cli)
	{
		if ($cli == "od") return $this->config->item("sap_od_bydir");		
		return $this->config->item("sap_bydir");
	}		
	
	function getminlevel()
	{
		return 1;
	}	
	
	function getheader()
	{
		$header = "";
		
		$header .= "Directorate;Number of Learners;Mandays;Avg learning days/employee;Total Employee Traineds;Percentage of Employee Traineds";
		$header .= ";Total Cancelled participants;Percentage of Cancelled Participants;Total Completion of mandatory training;Percentage Completion of mandatory training;Total Completion of mandatory certification;Percentage Completion of mandatory certification";
		$header .= ";Training cost per grade;Cost per mandays/pax";

		return $header;
	}
	
	function process($rows)
	{
		$learnercourse = array();
		for($i=0; $i < count($rows); $i++)
		{
			
			$arrhirarki = $this->gethirarki($rows[$i]->level_group_id);
			
			// total uniq per training
			
			if (! isset($learnercourse[$arrhirarki[0]][$rows[$i]->history_exam_training][$rows[$i]->user_npk]))
			{
				$learnercourse[$arrhirarki[0]][$rows[$i]->history_exam_training][$rows[$i]->user_npk] = $rows[$i]->history_exam_status;
				continue;	
			}
			
			if ($learnercourse[$arrhirarki[0]][$rows[$i]->history_exam_training][$rows[$i]->user_npk]) 
			{
				continue;
			}
						
			$learnercourse[$arrhirarki[0]][$rows[$i]->history_exam_training][$rows[$i]->user_npk] = $rows[$i]->history_exam_status;
		}	
		
		if (count($learnercourse) == 0) return;
		
		foreach($learnercourse as $dir=>$val2)
		{
			 // 0: nlearners
			 // 1: mandays
			 // 2: avg 'mandays'
			 // 3: total employee traineed
			 // 4: persentasi employee traineed
			 // 5: total cancelled participants
			 // 6: Percentage of Cancelled Participants
			 // 7: total completed training
			 // 8: percentasi completed training
			 // 9: total completed certification
			 // 10: percentage completed certification
			 // 11: training cost
			 // 12: cost per day per orang
			 
			$learner[$dir][0] = 0;
			$learner[$dir][1] = 0;
			$learner[$dir][3] = 0;
			$learner[$dir][4] = 0;
			$learner[$dir][5] = 0;
			$learner[$dir][6] = 0;
			$learner[$dir][7] = 0;
			$learner[$dir][8] = 0;
			$learner[$dir][9] = 0;
			$learner[$dir][10] = 0;
			$learner[$dir][11] = 0;
			$learner[$dir][12] = 0;
			
			foreach($val2 as $trainingid=>$val3)
			{
				$hour = (isset($this->m_trainings[$trainingid]['duration'])) ? $this->m_trainings[$trainingid]['duration'] : 0;
				$cost = (isset($this->m_trainings[$trainingid]['cost'])) ? $this->m_trainings[$trainingid]['cost'] : 0;
					
				$learner[$dir][0] += count($val3);
				$learner[$dir][1] += count($val3)*$hour;
				//$learner[$dir][11] += count($val3)*$cost;																
				
				foreach($val3 as $npk=>$status)
				{
					if ($this->m_trainings[$trainingid]['type'] == 2)
					{
						if ($status != 1) continue;
						
						//$learner[$dir][9]++;
						continue;
					}						
					
					if ($this->m_trainings[$trainingid]['type'] == 1)
					{
						if (! in_array(2, $this->m_trainings[$trainingid]['exam']))
						{
							//$learner[$dir][7]++;
							continue;
						}
						
						if ($status != 1) continue;
						
						//$learner[$dir][7]++;
						continue;							
					}
				}				
			}
			
			$learner[$dir][1] /= 3600*8;
			
			//$learner[$dir][8] = $learner[$dir][0] ? $learner[$dir][7]*100/$learner[$dir][0] : 0;
			//$learner[$dir][10] = $learner[$dir][0] ? $learner[$dir][9]*100/$learner[$dir][0] : 0;					

			//$temp = $learner[$dir][1] ? $learner[$dir][11]/$learner[$dir][1] : 0;
			//$learner[$dir][12] = $learner[$dir][0] ? $temp/$learner[$dir][0] : 0;
			
			if ($learner[$dir][0] == 0)
			{
				$learner[$dir][2] = 0; 
			}
			else 
			{
				$learner[$dir][2] = $learner[$dir][1]/$learner[$dir][0]; 
			}			
		}		

		foreach($learner as $dir=>$val)
		{			
			$line = $dir;
			
			for($i=0; $i < count($val); $i++)
			{
				$line .= ";";
				$line .= $this->format($i, $val[$i]);
			}
			
			$line .= "\r\n";
			fputs($this->m_fout, $line);
		}
	}		
	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */