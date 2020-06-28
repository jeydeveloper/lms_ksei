<?php

include_once "sap.php";

class SAPBankWide extends SAP {
	var $report_type= "YTD";   // YTD = year to date , MTD = month to date
	
	function SAPBankWide()
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
		if ($cli == "od") return $this->config->item("sap_od_bankwide");
		return $this->config->item("sap_bankwide");
	}		
	
	function getminlevel()
	{
		return 1;
	}
	
	function getheader()
	{
		$header = "";
		
		$header .= "Directorate;Group;Department;Unit;Grade;Number of Learners;Mandays;Avg learning days/employee;Total Employee Traineds;Percentage of Employee Traineds";
		$header .= ";Total Cancelled participants;Percentage of Cancelled Participants;Total Completion of mandatory training;Percentage Completion of mandatory training;Total Completion of mandatory certification;Percentage Completion of mandatory certification";
		$header .= ";Training cost per grade;Cost per mandays/pax";
		
		return $header;
	}
	
	function process($rows)
	{
		$learnercourse = array();
		for($i=0; $i < count($rows); $i++)
		{
			// total uniq per training
			
			if (! isset($learnercourse[$rows[$i]->level_group_id][$rows[$i]->user_grade_code][$rows[$i]->history_exam_training][$rows[$i]->user_npk]))
			{
				$learnercourse[$rows[$i]->level_group_id][$rows[$i]->user_grade_code][$rows[$i]->history_exam_training][$rows[$i]->user_npk] = $rows[$i]->history_exam_status;
				continue;	
			}
			
			if ($learnercourse[$rows[$i]->level_group_id][$rows[$i]->user_grade_code][$rows[$i]->history_exam_training][$rows[$i]->user_npk]) 
			{
				continue;
			}
						
			$learnercourse[$rows[$i]->level_group_id][$rows[$i]->user_grade_code][$rows[$i]->history_exam_training][$rows[$i]->user_npk] = $rows[$i]->history_exam_status;
		}	
		
		if (count($learnercourse) == 0) return;
		
		foreach($learnercourse as $lvlgrp=>$val)
		{
			foreach($val as $grade=>$val1)
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
				
				$learner[$lvlgrp][$grade][0] = 0;
				$learner[$lvlgrp][$grade][1] = 0;
				$learner[$lvlgrp][$grade][2] = 0;
				$learner[$lvlgrp][$grade][3] = 0;
				$learner[$lvlgrp][$grade][4] = 0;
				$learner[$lvlgrp][$grade][5] = 0;
				$learner[$lvlgrp][$grade][6] = 0;
				$learner[$lvlgrp][$grade][7] = 0;
				$learner[$lvlgrp][$grade][8] = 0;				
				$learner[$lvlgrp][$grade][9] = 0;
				$learner[$lvlgrp][$grade][10] = 0;
				$learner[$lvlgrp][$grade][11] = 0;
				$learner[$lvlgrp][$grade][12] = 0;
				
				foreach($val1 as $trainingid=>$val2)
				{											
					$hour = (isset($this->m_trainings[$trainingid]['duration'])) ? $this->m_trainings[$trainingid]['duration'] : 0;
					$cost = (isset($this->m_trainings[$trainingid]['cost'])) ? $this->m_trainings[$trainingid]['cost'] : 0;
						
					$learner[$lvlgrp][$grade][0] += count($val2);
					$learner[$lvlgrp][$grade][1] += count($val2)*$hour;
					//$learner[$lvlgrp][$grade][11] += count($val2)*$cost;
					
					foreach($val2 as $npk=>$status)
					{
						if ($this->m_trainings[$trainingid]['type'] == 2)
						{
							if ($status != 1) continue;
							
							//$learner[$lvlgrp][$grade][9]++;
							continue;
						}						
						
						if ($this->m_trainings[$trainingid]['type'] == 1)
						{
							if (! in_array(2, $this->m_trainings[$trainingid]['exam']))
							{
								//$learner[$lvlgrp][$grade][7]++;
								continue;
							}
							
							if ($status != 1) continue;
							
							//$learner[$lvlgrp][$grade][7]++;
							continue;							
						}
					}
				}
				
				$learner[$lvlgrp][$grade][1] /= 3600*8;
				//$learner[$lvlgrp][$grade][8] = $learner[$lvlgrp][$grade][0] ? $learner[$lvlgrp][$grade][7]*100/$learner[$lvlgrp][$grade][0] : 0;
				//$learner[$lvlgrp][$grade][10] = $learner[$lvlgrp][$grade][0] ? $learner[$lvlgrp][$grade][9]*100/$learner[$lvlgrp][$grade][0] : 0;
				//$temp = $learner[$lvlgrp][$grade][1] ? $learner[$lvlgrp][$grade][11]/$learner[$lvlgrp][$grade][1] : 0;
				//$learner[$lvlgrp][$grade][12] = $learner[$lvlgrp][$grade][0] ? $temp/$learner[$lvlgrp][$grade][0] : 0;
				
				if ($learner[$lvlgrp][$grade][0] == 0)
				{
					$learner[$lvlgrp][$grade][2] = 0; 
				}
				else 
				{
					$learner[$lvlgrp][$grade][2] = $learner[$lvlgrp][$grade][1]/$learner[$lvlgrp][$grade][0]; 
				}
			}
		}

		foreach($learnercourse as $lvlgrp=>$val)
		{			
			$hirarki = implode(";", $this->gethirarki($lvlgrp));
			
			foreach($val as $grade=>$val1)
			{				
				$line = $hirarki.";".$grade;
								
				for($i=0; $i < count($learner[$lvlgrp][$grade]); $i++)
				{
					$line .= ";";
					$line .= $this->format($i, $learner[$lvlgrp][$grade][$i]);
				}
				
				$line .= "\r\n";
				fputs($this->m_fout, $line);							
			}
		}		
	}	
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/welcome.php */