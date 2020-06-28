<?php
include_once "base.php"; 
class Cron extends Base {
	function Cron()
	{
		parent::Base();	
				
	}
	
	function index()
	{
		$this->db->where("cron_status", 1);
		$q = $this->db->get("cron");
		
		$rows = $q->result();
		for($i=0; $i < count($rows); $i++)
		{
			unset($update);
			
			$update['cron_status'] = 2;
			$update['cron_started'] = date("Y-m-d H:i:s");
			
			$this->db->where("cron_id", $rows[$i]->cron_id);
			$this->db->update("cron", $update);

			switch($rows[$i]->cron_action)
			{
				case 22:
					$this->training_banksoal_archive($rows[$i]->cron_data);
				break;
				case 21:
					$this->training_banksoal_restore($rows[$i]->cron_data);
				break;
				case 23:
					$this->training_banksoal_remove($rows[$i]->cron_data);
				break;
				case 32:
					$this->certificate_banksoal_archive($rows[$i]->cron_data);
				break;
				case 31:
					$this->certificate_banksoal_restore($rows[$i]->cron_data);
				break;

			}
		}
	}
	
	function training_banksoal_restore($id)
	{
		$sql = sprintf("INSERT INTO %sbanksoal_answer SELECT %sbanksoal_answer_archive.* FROM %sbanksoal_answer_archive INNER JOIN %sbanksoal_question_archive ON banksoal_answer_question = banksoal_question_id WHERE banksoal_question_banksoal = %d AND banksoal_question_packet IS NULL", $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $id);
		printf("%s\r\n", $sql);
		$this->db->query($sql);
		
		$sql = sprintf("INSERT INTO %sbanksoal_question SELECT * FROM %sbanksoal_question_archive WHERE banksoal_question_banksoal = %d AND banksoal_question_packet IS NULL", $this->db->dbprefix, $this->db->dbprefix, $id);
		printf("%s\r\n", $sql);
		$this->db->query($sql);

		$this->db->where("banksoal_question_packet IS NULL", null);
		$this->db->where("banksoal_question_banksoal", $id);
		$this->db->join("banksoal_question_archive", "banksoal_answer_question = banksoal_question_id");
		$q = $this->db->get("banksoal_answer_archive");
		
		$rows = $q->result();
		$ids[] = 0;
		for($i=0; $i < count($rows); $i++)
		{
			$ids[] = $rows[$i]->banksoal_answer_id;
			
			// satu per satu, klo di where_in kek ngehang
			
			$this->db->where("banksoal_answer_id", $rows[$i]->banksoal_answer_id);
			$this->db->delete("banksoal_answer_archive");			
		}
		
		$this->db->where("banksoal_question_packet IS NULL", null);
		$this->db->where("banksoal_question_banksoal", $id);
		$this->db->delete("banksoal_question_archive");
		
		$sql = sprintf("OPTIMIZE TABLE %sbanksoal_answer_archive", $this->db->dbprefix);
		$this->db->query($sql);
		
		$sql = sprintf("OPTIMIZE TABLE %sbanksoal_question_archive", $this->db->dbprefix);
		$this->db->query($sql);

		
	}
	
	function training_banksoal_archive($id)
	{
		$sql = sprintf("INSERT INTO %sbanksoal_answer_archive SELECT %sbanksoal_answer.* FROM %sbanksoal_answer INNER JOIN %sbanksoal_question ON banksoal_answer_question = banksoal_question_id WHERE banksoal_question_banksoal = %d AND banksoal_question_packet IS NULL", $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $id);
		printf("%s\r\n", $sql);
		$this->db->query($sql);
		
		$sql = sprintf("INSERT INTO %sbanksoal_question_archive SELECT * FROM %sbanksoal_question WHERE banksoal_question_banksoal = %d AND banksoal_question_packet IS NULL", $this->db->dbprefix, $this->db->dbprefix, $id);
		printf("%s\r\n", $sql);
		$this->db->query($sql);

		$this->training_banksoal_remove($id);
	}	
	
	function training_banksoal_remove($id)
	{
		$this->db->where("banksoal_question_packet IS NULL", null);
		$this->db->where("banksoal_question_banksoal", $id);
		$this->db->join("banksoal_question", "banksoal_answer_question = banksoal_question_id");
		$q = $this->db->get("banksoal_answer");

		$rows = $q->result();

		$ids[] = 0;
		for($i=0; $i < count($rows); $i++)
		{
			$ids[] = $rows[$i]->banksoal_answer_id;
			
			// satu per satu, klo di where_in kek ngehang
			
			$this->db->where("banksoal_answer_id", $rows[$i]->banksoal_answer_id);
			$this->db->delete("banksoal_answer");			
		}
		
		$this->db->where("banksoal_question_packet IS NULL", null);
		$this->db->where("banksoal_question_banksoal", $id);
		$this->db->delete("banksoal_question");
		
		$sql = sprintf("OPTIMIZE TABLE %sbanksoal_answer", $this->db->dbprefix);
		$this->db->query($sql);
		
		$sql = sprintf("OPTIMIZE TABLE %sbanksoal_question", $this->db->dbprefix);
		$this->db->query($sql);
	}

	function certificate_banksoal_archive($id)
	{
		$sql = sprintf("
			INSERT INTO %sbanksoal_answer_archive
			SELECT %sbanksoal_answer.*
			FROM %sbanksoal_answer 
			INNER JOIN %sbanksoal_question ON banksoal_answer_question = banksoal_question_id 
			INNER JOIN %sbanksoal_unit ON banksoal_question_banksoal = banksoal_unit_id			
			INNER JOIN %sbanksoal ON banksoal_unit_banksoal = banksoal_id			
			WHERE NOT (banksoal_question_packet IS NULL) AND banksoal_id = %d
		", $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $id);
		
		printf("%s\r\n", $sql);
		$this->db->query($sql);

		$sql = sprintf("
			INSERT INTO %sbanksoal_question_archive
			SELECT %sbanksoal_question.*
			FROM %sbanksoal_question 
			INNER JOIN %sbanksoal_unit ON banksoal_question_banksoal = banksoal_unit_id			
			INNER JOIN %sbanksoal ON banksoal_unit_banksoal = banksoal_id			
			WHERE NOT (banksoal_question_packet IS NULL) AND banksoal_id = %d
		", $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $id);
		
		printf("%s\r\n", $sql);
		$this->db->query($sql);

		$this->certificate_banksoal_remove($id);
	}	

	function certificate_banksoal_remove($id, $postfix="")
	{
		// delete answers
		
		$this->db->where("(NOT (banksoal_question_packet IS NULL))", null);
		$this->db->where("banksoal_unit_banksoal", $id);
		$this->db->join("banksoal_question".$postfix, "banksoal_answer_question = banksoal_question_id");
		$this->db->join("banksoal_unit", "banksoal_question_banksoal = banksoal_unit_id");
		$q = $this->db->get("banksoal_answer".$postfix);

		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			// satu per satu, klo di where_in kek ngehang
			
			$this->db->where("banksoal_answer_id", $rows[$i]->banksoal_answer_id);
			$this->db->delete("banksoal_answer".$postfix);			
		}
		
		// delete questions
		
		$this->db->where("(NOT (banksoal_question_packet IS NULL))", null);
		$this->db->where("banksoal_unit_banksoal", $id);
		$this->db->join("banksoal_unit", "banksoal_question_banksoal = banksoal_unit_id");
		$this->db->get("banksoal_question".$postfix);

		$rows = $q->result();

		for($i=0; $i < count($rows); $i++)
		{
			// satu per satu, klo di where_in kek ngehang
			
			$this->db->where("banksoal_question_id", $rows[$i]->banksoal_question_id);
			$this->db->delete("banksoal_question".$postfix);			
		}
						
		$sql = sprintf("OPTIMIZE TABLE %sbanksoal_answer".$postfix, $this->db->dbprefix);
		$this->db->query($sql);
		
		$sql = sprintf("OPTIMIZE TABLE %sbanksoal_question".$postfix, $this->db->dbprefix);
		$this->db->query($sql);

	}

	function certificate_banksoal_restore($id)
	{
		$sql = sprintf("
			INSERT INTO %sbanksoal_answer
			SELECT %sbanksoal_answer_archive.*
			FROM %sbanksoal_answer_archive 
			INNER JOIN %sbanksoal_question_archive ON banksoal_answer_question = banksoal_question_id 
			INNER JOIN %sbanksoal_unit ON banksoal_question_banksoal = banksoal_unit_id			
			INNER JOIN %sbanksoal ON banksoal_unit_banksoal = banksoal_id			
			WHERE NOT (banksoal_question_packet IS NULL) AND banksoal_id = %d
		", $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $id);
		
		printf("%s\r\n", $sql);
		$this->db->query($sql);

		$sql = sprintf("
			INSERT INTO %sbanksoal_question
			SELECT %sbanksoal_question_archive.*
			FROM %sbanksoal_question_archive 
			INNER JOIN %sbanksoal_unit ON banksoal_question_banksoal = banksoal_unit_id			
			INNER JOIN %sbanksoal ON banksoal_unit_banksoal = banksoal_id			
			WHERE NOT (banksoal_question_packet IS NULL) AND banksoal_id = %d
		", $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $this->db->dbprefix, $id);
		
		printf("%s\r\n", $sql);
		$this->db->query($sql);

		$this->certificate_banksoal_remove($id, "_archive");
	}	

}
