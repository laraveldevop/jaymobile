<?php
	class Spreadsheet_Excel_Writer {
		
		function xlsBOF() {
			echo pack("ssssss", 0x809, 0x8, 0x0, 0x10, 0x0, 0x0);
			return;
		}
		
		function xlsEOF() {
			echo pack("ss", 0x0A, 0x00);
			return;
		}
		
		function xlsWriteNumber($Row, $Col, $Value) {
			echo pack("sssss", 0x203, 14, $Row, $Col, 0x0);
			echo pack("d", $Value);
			return;
		}
		
		function xlsWriteLabel($Row, $Col, $Value ) {
			$L = strlen($Value);
			echo pack("ssssss", 0x204, 8 + $L, $Row, $Col, 0x0, $L);
			echo $Value;
			return;
		}
		
		function xlsWrite($members,$labels) {		
			header("Pragma: public");
			header("Expires: 0");
			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			header("Content-Type: application/force-download");
			header("Content-Type: application/octet-stream");
			header("Content-Type: application/download");;
			header("Content-Disposition: attachment;filename=export_repot.xls ");
			header("Content-Transfer-Encoding: binary ");			
			$this->xlsBOF();
						
			/*
			Make a top line on your excel sheet at line 1 (starting at 0).
			The first number is the row number and the second number is the column, both are start at '0'
			*/
			
			// Make column labels
			$xlsCol = 0;
			foreach($labels as $label)
			{
				$this->xlsWriteLabel(0,$xlsCol,$label);
				$xlsCol++;	
			}

			// Put data records
			$xlsRow = 1;			
			foreach($members as $row)
			{
				$xlsCol = 0;
				foreach($labels as $label)
				{
					$this->xlsWriteLabel($xlsRow,$xlsCol,$row[$label]);
					$xlsCol++;	
				}
				$xlsRow++;
			}
			$this->xlsEOF();
		}
	}
?>