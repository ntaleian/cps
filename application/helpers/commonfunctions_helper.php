<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function get_current_session($obj)
{
	$get = $obj->db->query("SELECT EntryID FROM sessions WHERE IsActive='Y'");

	if($get->num_rows() > 0)
	{
		return $get->row_array()['EntryID'];
	}
	else
	{
		return false;
	}
}

function log_trail($obj, $log_array)
{
	$insert = $obj->db->query("INSERT INTO user_logs(Action, Description, UserID, IPAddress) VALUES ('".$log_array['action']."', ".$obj->db->escape($log_array['description']).", '".$log_array['userid']."', '".$log_array['ipaddress']."')");

	if($insert)
	{
		return true;
	}
	else
	{
		return false;
	}
}

function format_fields_instr($obj, $field_array, $row_data=array())
{
	// print_r($field_array); exit;

	$bool = FALSE;
	#assuming instructions are in the first array item
	switch($field_array[0]) 
	{
		case 'RLINK':
			$string = "<a href='http://cps.frontmanug.com/reports/view_sittings?id=".$obj->cencrypt->encode($row_data['EntryID'])."&from=".$obj->cencrypt->encode($row_data['FromDate'])."&to=".$obj->cencrypt->encode($row_data['ToDate'])."&type=report'>".$row_data['Title']."</a>";
			$bool = TRUE;
		break;

		case 'BLINK':
			$string = "<a href='http://cps.frontmanug.com/reports/view_committee_bills?id=".$obj->cencrypt->encode($row_data['EntryID'])."&from=".$obj->cencrypt->encode($row_data['FromDate'])."&to=".$obj->cencrypt->encode($row_data['ToDate'])."&type=report'>".$row_data['Title']."</a>";
			$bool = TRUE;
		break;

		case 'FLINK':
			$string = "<a href='http://cps.frontmanug.com/reports/view_committee_oversight?id=".$obj->cencrypt->encode($row_data['EntryID'])."&from=".$obj->cencrypt->encode($row_data['FromDate'])."&to=".$obj->cencrypt->encode($row_data['ToDate'])."&type=report'>".$row_data['Title']."</a>";
			$bool = TRUE;
		break;

		case 'TLINK':
			$string = "<a href='http://cps.frontmanug.com/reports/view_committee_benchmarking?id=".$obj->cencrypt->encode($row_data['EntryID'])."&from=".$obj->cencrypt->encode($row_data['FromDate'])."&to=".$obj->cencrypt->encode($row_data['ToDate'])."&type=report'>".$row_data['Title']."</a>";
			$bool = TRUE;
		break;
		
		case 'MLINK':
			$string = "<a href='http://cps.frontmanug.com/reports/view_sittings_mp?id=".$obj->cencrypt->encode($row_data['EntryID'])."&from=".$obj->cencrypt->encode($row_data['FromDate'])."&to=".$obj->cencrypt->encode($row_data['ToDate'])."&type=report'>".$row_data['Title']."</a>";
			$bool = TRUE;
		break;

		case 'RDATE':
			$string = date('d-M-Y', strtotime($row_data[$field_array[1]]));
			$bool = TRUE;
		break;
		
		default:
			$string = '';
		break;
	}
	
	
	return array('bool'=>$bool, 'string'=>$string);
}

function format_fields_instr2($obj, $field_array, $row_data=array())
{
	// print_r($field_array); exit;

	$bool = FALSE;
	#assuming instructions are in the first array item
	switch($field_array[0]) 
	{
		case 'RLINK':
			$string = "<a href='http://cps.frontmanug.com/reports/view_sittings?id=".$obj->cencrypt->encode($row_data['EntryID'])."&session=".$obj->cencrypt->encode($row_data['SessionID'])."&type2=report'>".$row_data['Title']."</a>";
			$bool = TRUE;
		break;

		case 'BLINK':
			$string = "<a href='http://cps.frontmanug.com/reports/view_committee_bills?id=".$obj->cencrypt->encode($row_data['EntryID'])."&session=".$obj->cencrypt->encode($row_data['SessionID'])."&type2=report'>".$row_data['Title']."</a>";
			$bool = TRUE;
		break;

		case 'FLINK':
			$string = "<a href='http://cps.frontmanug.com/reports/view_committee_oversight?id=".$obj->cencrypt->encode($row_data['EntryID'])."&session=".$obj->cencrypt->encode($row_data['SessionID'])."&type2=report'>".$row_data['Title']."</a>";
			$bool = TRUE;
		break;

		case 'TLINK':
			$string = "<a href='http://cps.frontmanug.com/reports/view_committee_benchmarking?id=".$obj->cencrypt->encode($row_data['EntryID'])."&session=".$obj->cencrypt->encode($row_data['SessionID'])."&type2=report'>".$row_data['Title']."</a>";
			$bool = TRUE;
		break;

		case 'RDATE':
			$string = date('d-M-Y', strtotime($row_data[$field_array[1]]));
			$bool = TRUE;
		break;
		
		default:
			$string = '';
		break;
	}
	
	
	return array('bool'=>$bool, 'string'=>$string);
}

?>