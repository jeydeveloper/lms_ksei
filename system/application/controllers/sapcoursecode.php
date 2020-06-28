<?php

include_once "sap.php";

class SAPCourseCode extends SAP {
	var $report_type= "YTD";   // YTD = year to date , MTD = month to date
	function SAPCourseCode()
	{
		parent::SAP();					
	}
	
	function index($cli=1)
	{
		$this->generalreport($cli);
	}
	
	function getfilename($cli)
	{
		if ($cli == "od") return $this->config->item("sap_od_coursecode");		
		return $this->config->item("sap_coursecode");
	}		
	
	function getminlevel()
	{
		return 1;
	}	
	
	function getheader()
	{
		$header = "";

		$header .= "CourseCode;Number of Learners;Mandays;Avg learning days/employee;Total Employee Traineds;Percentage of Employee Traineds";
		$header .= ";Total Cancelled participants;Percentage of Cancelled Participants;Total Completion of mandatory training;Percentage Completion of mandatory training;Total Completion of mandatory certification;Percentage Completion of mandatory certification";
		$header .= ";Training cost per grade;Cost per mandays/pax";
		
		return $header;
	}
	
	function iscoursecode()
	{
		return true;
	}	
	
	function process($rows)
	{
		$learnercourse = array();
		for($i=0; $i < count($rows); $i++)
		{
			
			// total uniq per training
			
			if (! isset($learnercourse[$rows[$i]->category_code][$rows[$i]->history_exam_training][$rows[$i]->user_npk]))
			{
				$learnercourse[$rows[$i]->category_code][$rows[$i]->history_exam_training][$rows[$i]->user_npk] = $rows[$i]->history_exam_status;
				continue;	
			}
			
			if ($learnercourse[$rows[$i]->category_code][$rows[$i]->history_exam_training][$rows[$i]->user_npk]) 
			{
				continue;
			}
						
			$learnercourse[$rows[$i]->category_code][$rows[$i]->history_exam_training][$rows[$i]->user_npk] = $rows[$i]->history_exam_status;
		}	
		
		if (count($learnercourse) == 0) return;
		
		foreach($learnercourse as $coursecode=>$val1)
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
			 
			$learner[$coursecode][0] = 0;
			$learner[$coursecode][1] = 0;
			$learner[$coursecode][3] = 0;
			$learner[$coursecode][4] = 0;
			$learner[$coursecode][5] = 0;
			$learner[$coursecode][6] = 0;
			$learner[$coursecode][7] = 0;
			$learner[$coursecode][8] = 0;
			$learner[$coursecode][9] = 0;
			$learner[$coursecode][10] = 0;
			$learner[$coursecode][11] = 0;
			$learner[$coursecode][12] = 0;
			
			foreach($val1 as $trainingid=>$val2)
			{
				$hour = (isset($this->m_trainings[$trainingid]['duration'])) ? $this->m_trainings[$trainingid]['duration'] : 0;
				$cost = (isset($this->m_trainings[$trainingid]['cost'])) ? $this->m_trainings[$trainingid]['cost'] : 0;
					
				$learner[$coursecode][0] += count($val2);
				$learner[$coursecode][1] += count($val2)*$hour;
				//$learner[$coursecode][11] += count($val2)*$cost;																
				
				foreach($val2 as $npk=>$status)
				{
					if ($this->m_trainings[$trainingid]['type'] == 2)
					{
						if ($status != 1) continue;
						
						//$learner[$coursecode][9]++;
						continue;
					}						
					
					if ($this->m_trainings[$trainingid]['type'] == 1)
					{
						if (! in_array(2, $this->m_trainings[$trainingid]['exam']))
						{
							//$learner[$coursecode][7]++;
							continue;
						}
						
						if ($status != 1) continue;
						
						//$learner[$coursecode][7]++;
						continue;							
					}
				}									
			}
			
			$learner[$coursecode][1] /= 3600*8;
			//$learner[$coursecode][8] = $learner[$coursecode][0] ? $learner[$coursecode][7]*100/$learner[$coursecode][0] : 0;
			//$learner[$coursecode][10] = $learner[$coursecode][0] ? $learner[$coursecode][9]*100/$learner[$coursecode][0] : 0;												
			//$temp = $learner[$coursecode][1] ? $learner[$coursecode][11]/$learner[$coursecode][1] : 0;
			//$learner[$coursecode][12] = $learner[$coursecode][0] ? $temp/$learner[$coursecode][0] : 0;
			
			if ($learner[$coursecode][0] == 0)
			{
				$learner[$coursecode][2] = 0; 
			}
			else 
			{
				$learner[$coursecode][2] = $learner[$coursecode][1]/$learner[$coursecode][0]; 
			}			
		}		

		foreach($learner as $coursecode=>$val)
		{			
			$line = $coursecode;
			
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