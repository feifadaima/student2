<?php

if($_REQUEST['type'])
	$_SESSION['FSA_type'] = $_REQUEST['type'];
else
	$_SESSION['_REQUEST_vars']['type'] = $_REQUEST['type'] = $_SESSION['FSA_type'];

/*if($_REQUEST['type']=='staff')
{
	$tabcolor_s = '#DFDFDF'; $textcolor_s = '#999999';
	$tabcolor_u = Preferences('HEADER'); $textcolor_u = '#FFFFFF';
}
else
{
	$tabcolor_s = Preferences('HEADER'); $textcolor_s = '#FFFFFF';
	$tabcolor_u = '#DFDFDF'; $textcolor_u = '#999999';
}*/
$header = '<TABLE class="cellpadding-0 cellspacing-0" style="height:14px;"><TR>';
//modif Francois: remove DrawTab params
$header .= '<TD style="width:10px;"></TD><TD>'.DrawTab(_('Students'),"Modules.php?modname=$_REQUEST[modname]&type=student").'</TD>';
$header .= '<TD style="width:10px;"></TD><TD>'.DrawTab(_('Users'),"Modules.php?modname=$_REQUEST[modname]&type=staff").'</TD>';
$header .= '<TD style="width:10px;"></TD></TR></TABLE>';

DrawHeader(($_REQUEST['type']=='staff'?_('User'):_('Student')).' &minus; '.ProgramTitle(),(User('PROFILE')=='student'?'':'<TABLE style="background-color:#ffffff;"><TR><TD>'.$header.'</TD></TR></TABLE>'));

if($_REQUEST['modfunc']=='delete' && AllowEdit())
{
	require_once('modules/Food_Service/includes/DeletePromptX.fnc.php');
//modif Francois: add translation
	if(DeletePromptX(_('Transaction')))
	{
		require_once('modules/Food_Service/includes/DeleteTransaction.fnc.php');
		DeleteTransaction($_REQUEST['id'],$_REQUEST['type']);
		unset($_REQUEST['modfunc']);
		unset($_REQUEST['delete_ok']);
		unset($_SESSION['_REQUEST_vars']['modfunc']);
		unset($_SESSION['_REQUEST_vars']['delete_ok']);
	}
}

if(empty($_REQUEST['modfunc']))

{
include('modules/Food_Service/'.($_REQUEST['type']=='staff'?'Users':'Students').'/Transactions.php');
}

function red($value)
{
	if($value<0)
		return '<span style="color:red">'.$value.'</span>';
	else
		return $value;
}

function is_money($value)
{
	if($value > 0) {
		if (mb_strpos($value,'.')) return $value;
		elseif ($value >= 100) return $value/100;
		else return $value;
	}
	else return false;
}
?>