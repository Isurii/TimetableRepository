<?php


	$currDir=dirname(__FILE__);
	include("$currDir/defaultLang.php");
	include("$currDir/language.php");
	include("$currDir/lib.php");
	@include("$currDir/hooks/exam_time_table.php");
	include("$currDir/exam_time_table_dml.php");

	// mm: can the current member access this page?
	$perm=getTablePermissions('exam_time_table');
	if(!$perm[0]){
		echo error_message($Translation['tableAccessDenied'], false);
		echo '<script>setTimeout("window.location=\'index.php?signOut=1\'", 2000);</script>';
		exit;
	}

	$x = new DataList;
	$x->TableName = "exam_time_table";

	// Fields that can be displayed in the table view
	$x->QueryFieldsTV = array(   
		"`exam_time_table`.`id`" => "id",
		"if(`exam_time_table`.`date`,date_format(`exam_time_table`.`date`,'%m/%d/%Y'),'')" => "date",
		"TIME_FORMAT(`exam_time_table`.`time_start`, '%r')" => "time_start",
		"TIME_FORMAT(`exam_time_table`.`time_end`, '%r')" => "time_end",
		"`exam_time_table`.`unit_code`" => "unit_code",
		"`exam_time_table`.`venue`" => "venue",
		"IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') /* School */" => "school",
		"IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') /* Department */" => "department",
		"`exam_time_table`.`year_of_study`" => "year_of_study"
	);
	// mapping incoming sort by requests to actual query fields
	$x->SortFields = array(   
		1 => '`exam_time_table`.`id`',
		2 => '`exam_time_table`.`date`',
		3 => '`exam_time_table`.`time_start`',
		4 => '`exam_time_table`.`time_end`',
		5 => 5,
		6 => 6,
		7 => '`schools1`.`name`',
		8 => '`departments1`.`name`',
		9 => 9
	);

	// Fields that can be displayed in the csv file
	$x->QueryFieldsCSV = array(   
		"`exam_time_table`.`id`" => "id",
		"if(`exam_time_table`.`date`,date_format(`exam_time_table`.`date`,'%m/%d/%Y'),'')" => "date",
		"TIME_FORMAT(`exam_time_table`.`time_start`, '%r')" => "time_start",
		"TIME_FORMAT(`exam_time_table`.`time_end`, '%r')" => "time_end",
		"`exam_time_table`.`unit_code`" => "unit_code",
		"`exam_time_table`.`venue`" => "venue",
		"IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') /* School */" => "school",
		"IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') /* Department */" => "department",
		"`exam_time_table`.`year_of_study`" => "year_of_study"
	);
	// Fields that can be filtered
	$x->QueryFieldsFilters = array(   
		"`exam_time_table`.`id`" => "ID",
		"`exam_time_table`.`date`" => "Date",
		"`exam_time_table`.`time_start`" => "Time Start",
		"`exam_time_table`.`time_end`" => "Time End",
		"`exam_time_table`.`unit_code`" => "Unit code",
		"`exam_time_table`.`venue`" => "Venue",
		"IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') /* School */" => "School",
		"IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') /* Department */" => "Department",
		"`exam_time_table`.`year_of_study`" => "Year of study"
	);

	// Fields that can be quick searched
	$x->QueryFieldsQS = array(   
		"`exam_time_table`.`id`" => "id",
		"if(`exam_time_table`.`date`,date_format(`exam_time_table`.`date`,'%m/%d/%Y'),'')" => "date",
		"TIME_FORMAT(`exam_time_table`.`time_start`, '%r')" => "time_start",
		"TIME_FORMAT(`exam_time_table`.`time_end`, '%r')" => "time_end",
		"`exam_time_table`.`unit_code`" => "unit_code",
		"`exam_time_table`.`venue`" => "venue",
		"IF(    CHAR_LENGTH(`schools1`.`name`), CONCAT_WS('',   `schools1`.`name`), '') /* School */" => "school",
		"IF(    CHAR_LENGTH(`departments1`.`name`), CONCAT_WS('',   `departments1`.`name`), '') /* Department */" => "department",
		"`exam_time_table`.`year_of_study`" => "year_of_study"
	);

	// Lookup fields that can be used as filterers
	$x->filterers = array(  'school' => 'School', 'department' => 'Department');

	$x->QueryFrom = "`exam_time_table` LEFT JOIN `schools` as schools1 ON `schools1`.`id`=`exam_time_table`.`school` LEFT JOIN `departments` as departments1 ON `departments1`.`id`=`exam_time_table`.`department` ";
	$x->QueryWhere = '';
	$x->QueryOrder = '';

	$x->AllowSelection = 1;
	$x->HideTableView = ($perm[2]==0 ? 1 : 0);
	$x->AllowDelete = $perm[4];
	$x->AllowMassDelete = true;
	$x->AllowInsert = $perm[1];
	$x->AllowUpdate = $perm[3];
	$x->SeparateDV = 1;
	$x->AllowDeleteOfParents = 0;
	$x->AllowFilters = 1;
	$x->AllowSavingFilters = 1;
	$x->AllowSorting = 1;
	$x->AllowNavigation = 1;
	$x->AllowPrinting = 1;
	$x->AllowCSV = 1;
	$x->RecordsPerPage = 100;
	$x->QuickSearch = 1;
	$x->QuickSearchText = $Translation["quick search"];
	$x->ScriptFileName = "exam_time_table_view.php";
	$x->RedirectAfterInsert = "exam_time_table_view.php?SelectedID=#ID#";
	$x->TableTitle = "Exam time table";
	$x->TableIcon = "resources/table_icons/books.png";
	$x->PrimaryKey = "`exam_time_table`.`id`";

	$x->ColWidth   = array(  150, 150, 150, 150, 150, 150, 150, 150);
	$x->ColCaption = array("Date", "Time Start", "Time End", "Unit code", "Venue", "School", "Department", "Year of study");
	$x->ColFieldName = array('date', 'time_start', 'time_end', 'unit_code', 'venue', 'school', 'department', 'year_of_study');
	$x->ColNumber  = array(2, 3, 4, 5, 6, 7, 8, 9);

	// template paths below are based on the app main directory
	$x->Template = 'templates/exam_time_table_templateTV.html';
	$x->SelectedTemplate = 'templates/exam_time_table_templateTVS.html';
	$x->TemplateDV = 'templates/exam_time_table_templateDV.html';
	$x->TemplateDVP = 'templates/exam_time_table_templateDVP.html';

	$x->ShowTableHeader = 1;
	$x->TVClasses = "";
	$x->DVClasses = "";
	$x->HighlightColor = '#FFF0C2';

	// mm: build the query based on current member's permissions
	$DisplayRecords = $_REQUEST['DisplayRecords'];
	if(!in_array($DisplayRecords, array('user', 'group'))){ $DisplayRecords = 'all'; }
	if($perm[2]==1 || ($perm[2]>1 && $DisplayRecords=='user' && !$_REQUEST['NoFilter_x'])){ // view owner only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `exam_time_table`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='exam_time_table' and lcase(membership_userrecords.memberID)='".getLoggedMemberID()."'";
	}elseif($perm[2]==2 || ($perm[2]>2 && $DisplayRecords=='group' && !$_REQUEST['NoFilter_x'])){ // view group only
		$x->QueryFrom.=', membership_userrecords';
		$x->QueryWhere="where `exam_time_table`.`id`=membership_userrecords.pkValue and membership_userrecords.tableName='exam_time_table' and membership_userrecords.groupID='".getLoggedGroupID()."'";
	}elseif($perm[2]==3){ // view all
		// no further action
	}elseif($perm[2]==0){ // view none
		$x->QueryFields = array("Not enough permissions" => "NEP");
		$x->QueryFrom = '`exam_time_table`';
		$x->QueryWhere = '';
		$x->DefaultSortField = '';
	}
	// hook: exam_time_table_init
	$render=TRUE;
	if(function_exists('exam_time_table_init')){
		$args=array();
		$render=exam_time_table_init($x, getMemberInfo(), $args);
	}

	if($render) $x->Render();

	// hook: exam_time_table_header
	$headerCode='';
	if(function_exists('exam_time_table_header')){
		$args=array();
		$headerCode=exam_time_table_header($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$headerCode){
		include_once("$currDir/header.php"); 
	}else{
		ob_start(); include_once("$currDir/header.php"); $dHeader=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%HEADER%%>', $dHeader, $headerCode);
	}

	echo $x->HTML;
	// hook: exam_time_table_footer
	$footerCode='';
	if(function_exists('exam_time_table_footer')){
		$args=array();
		$footerCode=exam_time_table_footer($x->ContentType, getMemberInfo(), $args);
	}  
	if(!$footerCode){
		include_once("$currDir/footer.php"); 
	}else{
		ob_start(); include_once("$currDir/footer.php"); $dFooter=ob_get_contents(); ob_end_clean();
		echo str_replace('<%%FOOTER%%>', $dFooter, $footerCode);
	}
?>