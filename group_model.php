<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 *

 * @since		Version 1.0
 *
 * This class is for handel group requests to the database
 *
 * @subpackage	Application
 * @category	model
 * @link		none
 */

//Include the database class
include_once COREDIR . '/database.php';

class group_model {

	//Set the params of the class
	private $db = '';
	public $return_error = '';
	public $return_data = array();

	// class constructor.  Initializations here.
	function group_model() {
		//Load the database class
		$this -> db = new db_class();

	}

	/*
	 * --------------------------------------------------------------------
	 * SELECT FROM THE DATABASE
	 * --------------------------------------------------------------------
	 *
	 */

	function GetGroupPayPalButtons($groupid, $id = false) {
		$this -> return_data = array();
		//Query the database for group info
		if (!$id)
			$query = "SELECT groupPayPal.*,members.fname AS membersfirstname,members.lname AS memberlastname FROM groupPayPal LEFT JOIN members ON groupPayPal.userid = members.id WHERE groupPayPal.groupid = '$groupid'";
		else
			$query = "SELECT groupPayPal.*,members.fname AS membersfirstname,members.lname AS memberlastname FROM groupPayPal LEFT JOIN members ON groupPayPal.userid = members.id WHERE groupPayPal.groupid = '$groupid' AND groupPayPal.id = '$id'";

		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			while ($row = $this -> db -> get_row($r))//We are returning lots of members
				$this -> return_data[] = $row;
			//Load the memebers into the array
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}
  // Get all email address from the db . ti=his is nessasry for the Get response API to reading
  // ************************* DO NOT REMOVE!!!! ***********************
  function getAllEmails(){
		$this -> return_data = array();

    $query=" SELECT DISTINCT privateEmail, fname, lname FROM members ";

		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			while ($row = $this -> db -> get_row($r))//We are returning lots of members
				$this -> return_data[] = $row;
			//Load the memebers into the array
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
  }

	function GetMemberPayPalButtons($userid, $groupid) {
		$this -> return_data = array();
		//Query the database for group info
		$query = "SELECT groupPaidPayPal.date as PAIDDATE, groupPayPal.* FROM groupPayPal LEFT JOIN groupPaidPayPal ON groupPayPal.id = groupPaidPayPal.paypalid  WHERE groupPayPal.groupid = '$groupid' AND (groupPayPal.userid = 0 OR groupPayPal.userid = $userid)";
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			while ($row = $this -> db -> get_row($r))//We are returning lots of members
				$this -> return_data[] = $row;
			//Load the memebers into the array
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

	function GetGroupAdminEmails($groupid) {
		$this -> return_data = array();
		//Query the database for group info
		$query = "SELECT members.privateEmail AS Email FROM `members` LEFT JOIN `groupToMembers` ON members.id = groupToMembers.member WHERE groupToMembers.isAdmin = '1' AND members.groupid = '$groupid'";
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			while ($row = $this -> db -> get_row($r))//We are returning lots of members
				$this -> return_data[] = $row;
			//Load the memebers into the array
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

	function GetGroupEmails($groupid) {
		$this -> return_data = array();
		//Query the database for group info
		$query = "SELECT members.privateEmail FROM `members` WHERE groupid = '$groupid'";
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			while ($row = $this -> db -> get_row($r))//We are returning lots of members
				$this -> return_data[] = $row;
			//Load the memebers into the array
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}
//This Should Run Only tWhen The Site is first Created
function build_cat_list(){
$_business_cat_array = 
array(
'Accident & Health Insurance                  ',
'Acupuncture                                  ',
'Administrative Services                      ',
'Advertising Agencies                         ',
'Aerospace/Defense - Major Diversified        ',
'Aerospace/Defense Products & Services        ',
'Agricultural Chemicals                       ',
'Air Delivery & Freight Services              ',
'Air Services, Other                          ',
'Aluminum                                     ',
'Apparel Stores                               ',
'Appliances                                   ',
'Application Software                         ',
'Asset Management                             ',
'Auto Dealerships                             ',
'Auto Manufacturers - Major                   ',
'Auto Parts                                   ',
'Auto Parts Stores                            ',
'Auto Parts Wholesale                         ',
'Banking/Financial                            ',
'Basic Materials Wholesale                    ',
'Beverages - Brewers                          ',
'Beverages - Soft Drinks                      ',
'Beverages - Wineries & Distillers            ',
'Biotechnology                                ',
'Broadcasting - Radio                         ',
'Broadcasting - TV                            ',
'Building Materials Wholesale                 ',
'Business Equipment                           ',
'Business Services                            ',
'Business Software & Services                 ',
'CATV Systems                                 ',
'Catalog & Mail Order Houses                  ',
'Cement                                       ',
'Chemicals - Major Diversified                ',
'Cigarettes                                   ',
'Cleaning Products                            ',
'Closed-End Fund - Debt                       ',
'Closed-End Fund - Equity                     ',
'Closed-End Fund - Foreign                    ',
'Communication Equipment                      ',
'Computer Based Systems                       ',
'Computer Peripherals                         ',
'Computers Wholesale                          ',
'Confectioners                                ',
'Conglomerates                                ',
'Consumer Services                            ',
'Copper                                       ',
'Credit Services                              ',
'Dairy Products                               ',
'Data Storage Devices                         ',
'Department Stores                            ',
'Diagnostic Substances                        ',
'Discount, Variety Stores                     ',
'Diversified Communication Services           ',
'Diversified Computer Systems                 ',
'Diversified Electronics                      ',
'Diversified Investments                      ',
'Diversified Machinery                        ',
'Diversified Utilities                        ',
'Drug Delivery                                ',
'Drug Manufacturers - Major                   ',
'Drug Manufacturers - Other                   ',
'Drug Related Products                        ',
'Drug Stores                                  ',
'Drugs - Generic                              ',
'Drugs Wholesale                              ',
'Education & Training Services                ',
'Electric Utilities                           ',
'Electronic Equipment                         ',
'Electronics Stores                           ',
'Electronics Wholesale                        ',
'Entertainment - Diversified                  ',
'Farm & Construction Machinery                ',
'Farm Products                                ',
'Food - Major Diversified                     ',
'Food Wholesale                               ',
'Foreign Money Center Banks                   ',
'Foreign Regional Banks                       ',
'Foreign Utilities                            ',
'Gaming Activities                            ',
'Gas Utilities                                ',
'General Building Materials                   ',
'General Contractors                          ',
'General Entertainment                        ',
'Gold                                         ',
'Grocery Stores                               ',
'Health                                       ',
'Health Care Plans                            ',
'Healthcare Information Services              ',
'Heavy Construction                           ',
'Home Furnishing Stores                       ',
'Home Furnishings & Fixtures                  ',
'Home Health Care                             ',
'Home Improvement Stores                      ',
'Home Inspection                              ',
'Home Services                                ',
'Hospitals                                    ',
'Housewares & Accessories                     ',
'Independent Oil & Gas                        ',
'Industrial Electrical Equipment              ',
'Industrial Equipment & Components            ',
'Industrial Equipment Wholesale               ',
'Industrial Metals & Minerals                 ',
'Information Technology                       ',    
'Information & Delivery Services              ',
'Information Technology Services              ',
'Insurance Brokers                            ',
'Internet Information Providers               ',
'Internet Service Providers                   ',
'Internet Software & Services                 ',
'Investment Brokerage - National              ',
'Investment Brokerage - Regional              ',
'Jewelry Stores                               ',
'Life Insurance                               ',
'Lodging                                      ',
'Long Distance Carriers                       ',
'Long-Term Care Facilities                    ',
'Lumber, Wood Production                      ',
'Machine Tools & Accessories                  ',
'Major Airlines                               ',
'Major Integrated Oil & Gas                   ',
'Management Services                          ',
'Manufactured Housing                         ',
'Marketing Services                           ',
'Meat Products                                ',
'Medical Appliances & Equipment               ',
'Medical Equipment Wholesale                  ',
'Medical Instruments & Supplies               ',
'Medical Laboratories & Research              ',
'Medical Practitioners                        ',
'Metal Fabrication                            ',
'Money Center Banks                           ',
'Mortgage Investment                          ',
'Movie Production, Theaters                   ',
'Multimedia & Graphics Software               ',
'Music & Video Stores                         ',
'Networking & Communication Devices           ',
'Nonmetallic Mineral Mining                   ',
'Office Supplies                              ',
'Oil & Gas Drilling & Exploration             ',
'Oil & Gas Equipment & Services               ',
'Oil & Gas Pipelines                          ',
'Oil & Gas Refining & Marketing               ',
'Online Marketing                             ',
'Packaging & Containers                       ',
'Paper & Paper Products                       ',
'Payroll services                             ',
'Personal Computers                           ',
'Personal Products                            ',
'Personal Services                            ',
'Pest Control                                 ',
'Photographer                                 ',
'Photographic Equipment & Supplies            ',
'Pollution & Treatment Controls               ',
'Printed Circuit Boards                       ',
'Processed & Packaged Goods                   ',
'Processing Systems & Products                ',
'Property & Casualty Insurance                ',
'Property Management                          ',
'Publishing - Books                           ',
'Publishing - Newspapers                      ',
'Publishing - Periodicals                     ',
'REIT - Diversified                           ',
'REIT - Healthcare Facilities                 ',
'REIT - Hotel/Motel                           ',
'REIT - Industrial                            ',
'REIT - Office                                ',
'REIT - Residential                           ',
'REIT - Retail                                ',
'Railroads                                    ',
'Real Estate Development                      ',
'Real Estate Inspections                      ',
'Real Estate Sales                            ',
'Recreational Goods, Other                    ',
'Recreational Vehicles                        ',
'Regional - Mid-Atlantic Banks                ',
'Regional - Midwest Banks                     ',
'Regional - Northeast Banks                   ',
'Regional - Pacific Banks                     ',
'Regional - Southeast Banks                   ',
'Regional - Southwest Banks                   ',
'Regional Airlines                            ',
'Rental & Leasing Services                    ',
'Research Services                            ',
'Residential Construction                     ',
'Resorts & Casinos                            ',
'Restaurants                                  ',
'Rubber & Plastics                            ',
'Salon                                        ',
'Savings & Loans                              ',
'Scientific & Technical Instruments           ',
'Security & Protection Services               ',
'Security Software & Services                 ',
'Semiconductor - Broad Line                   ',
'Semiconductor - Integrated Circuits          ',
'Semiconductor - Specialized                  ',
'Semiconductor Equipment & Materials          ',
'Semiconductor- Memory Chips                  ',
'Shipping                                     ',
'Silver                                       ',
'Small Tools & Accessories                    ',
'Specialized Health Services                  ',
'Specialty Chemicals                          ',
'Specialty Eateries                           ',
'Specialty Retail, Other                      ',
'Sporting Activities                          ',
'Sporting Goods                               ',
'Sporting Goods Stores                        ',
'Staffing & Outsourcing Services              ',
'Steel & Iron                                 ',
'Surety & Title Insurance                     ',
'Synthetics                                   ',
'Technical & System Software                  ',
'Technical Services                           ',
'Telecom Services - Domestic                  ',
'Telecom Services - Foreign                   ',
'Textile - Apparel Clothing                   ',
'Textile - Apparel Footwear & Accessories     ',
'Textile Industrial                           ',
'Tobacco Products, Other                      ',
'Toy & Hobby Stores                           ',
'Toys & Games                                 ',
'Trucking                                     ',
'Trucks & Other Vehicles                      ',
'Waste Management                             ',
'Water Utilities                              ',
'Wholesale, Other                             ',
'Wireless Communications                      ',
);

foreach($_business_cat_array as $v){
$query="INSERT INTO `group_categories` (id,cat_name,`status`) VALUES ('','".$v."',1) ";
$this -> db -> insert_sql($query);
}
if(! $this -> db -> last_error){
$this -> return_data[] = 'done';
}
else{$this -> return_error = $this -> db -> last_error;}
}

function get_cat_list(){
	$this -> return_data = array();
  
  $query = "SELECT * FROM `group_categories` WHERE `status`=1 ORDER BY cat_name ";
  //Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			while ($row = $this -> db -> get_row($r))//We are returning lots of members
				$this -> return_data[] = $row;
			//Load the memebers into the array
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
}

function add_new_category($catName){
	$this -> return_data = array();
  $query = "INSERT INTO `group_categories` (id,cat_name,`status`) VALUES ('','".$catName."',1)";
  if($this -> db -> insert_sql($query)){
    $this -> return_data[] = 'inserted successfully';
	  return false;
  }
  else{
    $this -> return_error = $this -> db -> last_error;
		return false;
  }

}

function delete_category($ids_array){

  $this -> return_data = array();
  foreach($ids_array as $id){
   $query = "DELETE FROM group_categories WHERE `id`=".$id." ";
   $this -> db -> insert_sql($query);
  }
  if(! $this -> db -> last_error){
   $this -> return_data[] = 'deleted all';
  }
  else{$this -> return_error = $this -> db -> last_error;}
}

	function GetAllGroupEmails() {
		$this -> return_data = array();
		//Query the database for all group info
		$query = "SELECT DISTINCT members.privateEmail , fname, lname FROM `members`";
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			while ($row = $this -> db -> get_row($r))//We are returning lots of members
				$this -> return_data[] = $row;
			//Load the memebers into the array
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

	function GetGroupInfo($groupid) {
    
		$query = sprintf("SELECT * FROM `group` WHERE id = '%s'", $this -> db -> sanitize($groupid));

		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			$this -> return_data = $this -> db -> get_row($r);
			//Only returning 1 group
			$_SESSION['GroupInfo'] = $this -> return_data;

			return true;
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}
	
	
	function GetGroupPoints($groupid){
		$groupsql="";
		if($groupid == "all"){
			// keep groupsql as is
		} else {
			$groupsql=" `WHERE groupid`='$groupid' AND ";
		}
		
		$this->return_data = array();
		$query  = sprintf("SELECT * FROM membersToPoints $groupsql ORDER BY why ASC");
		//Check if a error came back
		if($r = $this->db->select($query)){//Check for a false
			
			while($row = $this->db->get_row($r)){//We are returning lots of members
				$this->return_data[] = $row;//Load the memebers into the array
			}
			return true;	//no false return true
		}else{
			$this->return_error = $this->db->last_error; //If we get a false, grab the error		
			return false;	//return false
		}
		
		return false; //Nothing happen return false
	}	
		
		

	function GetGroupNews($groupid, $page = 0, $id = false) {
		$this -> return_data = array();
		//Query the database for group info
		if ($id) {
			
			$query = sprintf("SELECT * FROM `groupNews` WHERE groupId = '%s' AND id = '%s' ORDER BY date DESC LIMIT $page,10", $this -> db -> sanitize($groupid), $this -> db -> sanitize($id));
		} else {
			//$query  = sprintf("SELECT * FROM `groupNews` WHERE groupId = '%s' ORDER BY NewsOrMinutes,date DESC LIMIT $page,10",$this->db->sanitize($groupid));
			$query = sprintf("SELECT * FROM `groupNews` WHERE groupId = '%s' ORDER BY date DESC LIMIT $page,10", $this -> db -> sanitize($groupid));
		}
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			while ($row = $this -> db -> get_row($r))//We are returning lots of members
				$this -> return_data[] = $row;
			//Load the memebers into the array
			$this -> return_data['domain variable'] = '';
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

  function GetCorpNews(){

		$this -> return_data = array();
		//Query the database for group info
		$query = sprintf("SELECT * FROM `corporateNews`  ORDER BY date DESC ");

		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			while ($row = $this -> db -> get_row($r))//We are returning lots of members
				$this -> return_data[] = $row;
			//Load the memebers into the array
			$this -> return_data[] = '';
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
  }

	function GetGroupFiles($groupid) {
		$this -> return_data = array();
		//Query the database for group info
		$query = sprintf("SELECT * FROM `groupFiles` WHERE groupId = '%s'", $this -> db -> sanitize($groupid));
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			while ($row = $this -> db -> get_row($r))//We are returning lots of members
				$this -> return_data[] = $row;
			//Load the memebers into the array
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

	function GetAllGroups() {
		$this -> return_data = array();

		$query = "SELECT id,`name`,domain FROM `group` WHERE domain <>'leadsclub.org' ORDER BY name";
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			while ($row = $this -> db -> get_row($r))//We are returning lots of members
				$this -> return_data[] = $row;
			//Load the memebers into the array
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}
	}
  function GetGroupDomain($groupid){
		$this -> return_data = array();
    $query = sprintf("SELECT `domain` FROM `group` WHERE id = '%s'", $this -> db -> sanitize($groupid));

    if ($r = $this -> db -> select($query)) {//Check for a false
			$this -> return_data['domain'] = $this -> db -> get_row($r);
			//Only returning 1 group
			return true;
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}
  }
	function GetGroupRequests($groupid, $id = false) {
		//SetUp Return Array
		$this -> return_data = array();

		//Query the database for group info
		if ($groupid == MAIN_DOMAIN_HASH) {//<-------- This is the hash for the main group
			if ($id) {
				$query = sprintf("SELECT * FROM `groupAccess` WHERE id = '%s'", $this -> db -> sanitize($id));
			} else {
				$query = sprintf("SELECT * FROM `groupAccess` ");
			}
		} else {
			if ($id) {
				$query = sprintf("SELECT * FROM `groupAccess` WHERE groupid = '%s' AND id = '%s'", $this -> db -> sanitize($groupid), $this -> db -> sanitize($id));
			} else {
				$query = sprintf("SELECT * FROM `groupAccess` WHERE groupid = '%s'", $this -> db -> sanitize($groupid));
			}
		}

		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			while ($row = $this -> db -> get_row($r)) {//We are returning lots of members
				//print_r($row);
				if ($gr = $this -> db -> select("SELECT `domain`,`name` FROM `group` WHERE `id` = '{$row['groupid']}'")) {
					$group_row = $this -> db -> get_row($gr);
					$row['domain'] = $group_row['domain'];
					$row['group_name'] = $group_row['name'];
				}
				$this -> return_data[] = $row;
			}
      return true;
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

	function GetAllGroupsLeads($groupid, $date = false) {
		$this -> return_data = array();
		$date = (!$date) ? time() - 86400 : $date;

		$query = sprintf("SELECT count(*) as total FROM leads WHERE groupid = '%s' AND dateOfLead > '%s'", $this -> db -> sanitize($groupid), $date);
		$r = $this -> db -> select($query);
		$this -> return_data['total_leads'] = $this -> db -> get_row($r);

		$query = sprintf("SELECT count(*) as total FROM leads WHERE groupid = '%s' AND dateOfLead > '%s' AND typeOfLead = 3", $this -> db -> sanitize($groupid), $date);
		$r = $this -> db -> select($query);
		$this -> return_data['leads_closed'] = $this -> db -> get_row($r);

		$query = sprintf("SELECT SUM(revenue) as total  FROM leads WHERE groupid = '%s' AND dateOfLead > '%s'", $this -> db -> sanitize($groupid), $date);
		$r = $this -> db -> select($query);
		$this -> return_data['leads_revenue'] = $this -> db -> get_row($r);

		$query = sprintf("SELECT count(*) as total, why FROM membersToPoints WHERE groupid = '%s' AND date > '%s' GROUP BY why", $this -> db -> sanitize($groupid), $date);
		$r = $this -> db -> select($query);
		while ($row = $this -> db -> get_row($r))//We are returning lots of members
			$this -> return_data['group_totals'][str_replace(" ", "", $row['why'])] = $row;
		//Load the memebers into the array

		return true;
		//Nothing happen return false
	}
function GetAllGroupsLeadsSite($groupid, $date = false) {
		$groupsql="";	
		if($groupid == "all"){
			// keep groupsql as is
		} else {
			$groupsql=" `groupid`='$groupid' AND ";
		}
		$this -> return_data = array();
		$date = (!$date) ? time() - 86400 : $date;

		$query = sprintf("SELECT count(*) as total FROM leads WHERE $groupsql  dateOfLead > '%s'", $date);
		$r = $this -> db -> select($query);
		$this -> return_data['total_leads'] = $this -> db -> get_row($r);

		$query = sprintf("SELECT count(*) as total FROM leads WHERE $groupsql dateOfLead > '%s' AND typeOfLead = 3",  $date);
		$r = $this -> db -> select($query);
		$this -> return_data['leads_closed'] = $this -> db -> get_row($r);

		$query = sprintf("SELECT SUM(revenue) as total  FROM leads WHERE $groupsql dateOfLead > '%s'",  $date);
		$r = $this -> db -> select($query);
		$this -> return_data['leads_revenue'] = $this -> db -> get_row($r);

		$query = sprintf("SELECT count(*) as total, why FROM membersToPoints WHERE  $groupsql date > '%s' GROUP BY why", $date);
		$r = $this -> db -> select($query);
		while ($row = $this -> db -> get_row($r)){//We are returning lots of members
			$this -> return_data['group_totals'][str_replace(" ", "", $row['why'])] = $row;
    }
		//Load the memebers into the array

		return true;
		//Nothing happen return false
	}

	function GetGroupLeadsTotal($groupid, $date = false) {
		$this -> return_data = array();
		//Query the database for group info
		if ($date) {
			$query = sprintf("SELECT COUNT(*) AS POINTSFORMONTH FROM leads WHERE groupid = '%s' AND dateOfLead > '%s'", $this -> db -> sanitize($groupid), strtotime(date("m/01/Y")));
		} else {
      if($GLOBALS['DOMAIN_HASH']=='dd68ccc3627a4b5d01d0795e7703f454'){
			  $query = sprintf("SELECT COUNT(*) AS POINTSTOTAL FROM leads ");
      }else{
			  $query = sprintf("SELECT COUNT(*) AS POINTSTOTAL FROM leads WHERE groupid = '%s'", $this -> db -> sanitize($groupid));
      }
		}
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			$this -> return_data = $this -> db -> get_row($r);
			//Only returning 1 group
			return true;
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

	function checkforgroup($groupid) {
		$query = sprintf("SELECT * FROM `group` WHERE id = '%s'", $this -> db -> sanitize($groupid));
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false

			if ($this -> db -> row_count > 0) {
				return false;
			}

			return true;
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}
		return true;
	}

	function GetGroupRevTotal($groupid, $date = false) {
		$this -> return_data = array();
		//Query the database for group info
		if ($date) {
			$query = sprintf("SELECT SUM(revenue) AS TOTALREV FROM leads WHERE groupid = '%s' AND dateOfLead > '%s'", $this -> db -> sanitize($groupid), strtotime(date("m/01/Y")));
		} else {
      if($GLOBALS['DOMAIN_HASH']=='dd68ccc3627a4b5d01d0795e7703f454'){
			  $query = sprintf("SELECT SUM(revenue) AS TOTALREV FROM leads ");
      }else{
			  $query = sprintf("SELECT SUM(revenue) AS TOTALREV FROM leads WHERE groupid = '%s'", $this -> db -> sanitize($groupid));
      }
		}
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			$this -> return_data = $this -> db -> get_row($r);
			//Only returning 1 group
			return true;
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
	}

	function GetGroupsByState($state) {
		$this -> return_data = array();

		// queries for groups by state and discludes main leadsgroup just in case by domain hash
		$query = sprintf("SELECT * FROM `group` WHERE id !='" . MAIN_DOMAIN_HASH . "' AND `state`='$state' ORDER BY id DESC");

		if ($r = $this -> db -> select($query)) {//Check for a false
			$count = 1;
			while ($row = $this -> db -> get_row($r)) {//We are returning lots of members
				$this -> return_data['groups'][] = $row;
				$this -> return_data['group-count'] = $count++;
			}
			return true;
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
	}

	/*
	 * --------------------------------------------------------------------
	 * INSERT INTO THE DATABASE
	 * --------------------------------------------------------------------
	 *
	 */

	function AddPayPalButton($insert_array) {
		if ($this -> db -> insert_array('groupPayPal', $insert_array)) {
			return true;
		} else {
			$this -> return_error['SQL ERROR'] = $this -> db -> last_error;
			//If we get a false, grab the error
			$this -> return_error['SQL QUERY'] = $this -> db -> last_error;
			//If we get a false, grab the sql
			return false;
		}
		//return false, we should never make it here
		return false;
	}

	function AddGroupDoc($groupid, $photo, $title) {
		$insert_array = array('groupid' => $groupid, 'file' => $photo, 'fileTitle' => $title);
		if ($this -> db -> insert_array('groupFiles', $insert_array)) {
			return true;
		} else {
			$this -> return_error['SQL ERROR'] = $this -> db -> last_error;
			//If we get a false, grab the error
			$this -> return_error['SQL QUERY'] = $this -> db -> last_error;
			//If we get a false, grab the sql
			return false;
		}
		//return false, we should never make it here
		return false;
	}

	function addRequest($insert_array) {

		$query = sprintf("SELECT * FROM groupAccess WHERE email = '%s' AND groupid = '%s'", $this -> db -> sanitize($insert_array['email']), $this -> db -> sanitize($insert_array['groupid']));

		if (!$this -> db -> select($query) OR $this -> db -> row_count > 0) {//Check for a false
			$this -> return_error['email'] = 1;
			return false;
		}
		if ($this -> db -> insert_array('groupAccess', $insert_array)) {
			return true;
		} else {
			$this -> return_error['SQL ERROR'] = $this -> db -> last_error;
			//If we get a false, grab the error
			$this -> return_error['SQL QUERY'] = $this -> db -> last_error;
			//If we get a false, grab the sql
			return false;
		}
		//return false, we should never make it here
		return false;
	}

	function addNews($insert_array) {
		if ($this -> db -> insert_array('groupNews', $insert_array)) {
			return true;
		} else {
			$this -> return_error['SQL ERROR'] = $this -> db -> last_error;
			//If we get a false, grab the error
			$this -> return_error['SQL QUERY'] = $this -> db -> last_error;
			//If we get a false, grab the sql
			return false;
		}
		//return false, we should never make it here
		return false;
	}
	function addCorpNews($insert_array) {
		if ($this -> db -> insert_array('corporateNews', $insert_array)) {
			return true;
		} else {
			$this -> return_error['SQL ERROR'] = $this -> db -> last_error;
			//If we get a false, grab the error
			$this -> return_error['SQL QUERY'] = $this -> db -> last_error;
			//If we get a false, grab the sql
			return false;
		}
		//return false, we should never make it here
		return false;
	}

	function addGroup($insert_array) {
		if ($this -> db -> insert_array('`group`', $insert_array)) {
			return true;
		} else {
			$this -> return_error['SQL ERROR'] = $this -> db -> last_error;
			//If we get a false, grab the error
			$this -> return_error['SQL QUERY'] = $this -> db -> last_error;
			//If we get a false, grab the sql
			return false;
		}
		//return false, we should never make it here
		return true;
	}

	/*
	 * --------------------------------------------------------------------
	 * UPDATE THE DATABASE
	 * --------------------------------------------------------------------
	 *
	 */

	function addPosition($update_array, $memberid, $groupid) {

		if ($this -> db -> update_array('`members`', $update_array, "id = '$memberid' AND groupid = '$groupid'")) {
			return true;
		} else {
			$this -> return_error[] = $this -> db -> last_query;
			$this -> return_error[] = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}
		return false;
		//Nothing happen return false
	}

	function UpdateGroup($groupdata, $groupid, $privacy) {

		if ($this -> db -> update_array('`group`', $groupdata, "id = '$groupid'")) {
			return true;
		} else {
			$this -> return_error[] = $this -> db -> last_query;
			$this -> return_error[] = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}
		return false;
		//Nothing happen return false
	}

	function UpdateGroupPrivacy($groupid, $privacy) {

		$groupdata = array('isLive' => $privacy);

		if ($this -> db -> update_array('groupToMembers', $groupdata, "`group` = '$groupid'")) {
			return true;
		} else {
			$this -> return_error[] = $this -> db -> last_query;
			$this -> return_error[] = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}
		return false;
		//Nothing happen return false

	}

	function UpdateGroupAdmin($groupid, $privacy, $userid) {

		$groupdata = array('isAdmin' => $privacy);

		if ($this -> db -> update_array('groupToMembers', $groupdata, "`group` = '$groupid' AND member ='$userid'")) {
			return true;
		} else {
			$this -> return_error[] = $this -> db -> last_query;
			$this -> return_error[] = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}
		return false;
		//Nothing happen return false

	}

	function UpdateGroupMemeberPrivacy($groupid, $privacy, $userid) {

		$groupdata = array('isLive' => $privacy);

		if ($this -> db -> update_array('groupToMembers', $groupdata, "`group` = '$groupid' AND member ='$userid'")) {
			$this -> return_error[] = $this -> db -> last_query;
			return true;
		} else {
			$this -> return_error[] = $this -> db -> last_query;
			$this -> return_error[] = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}
		return false;
		//Nothing happen return false

	}

	function UpdateGroupPayPal($groupid, $paypalid, $paypaldata) {
		if ($this -> db -> update_array('groupPayPal', $paypaldata, "groupid = '$groupid' AND id ='$paypalid'")) {
			$this -> return_error[] = $this -> db -> last_query;
			return true;
		} else {
			$this -> return_error[] = $this -> db -> last_query;
			$this -> return_error[] = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}
		return false;
		//Nothing happen return false
	}

	/*
	 * --------------------------------------------------------------------
	 * DELETE FROM THE DATABASE
	 * --------------------------------------------------------------------
	 *
	 */
	function DeletePosition($id, $hash) {
		//query the member by id depening on if private or not
		$query = sprintf("UPDATE members SET groupPosition = '' WHERE id = '%s' AND groupid = '%s'", $id, $hash);
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

	function DeleteMember($id, $hash) {
		//query the member by id depening on if private or not
		$query = sprintf("DELETE FROM members WHERE id = '%s' AND groupid = '%s'", $id, $hash);
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

	function DeleteRequest($id, $hash) {
		//query the member by id depening on if private or not
		$query = sprintf("DELETE FROM groupAccess WHERE id = '%s' AND groupid = '%s'", $id, $hash);
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

	function DeleteNews($id, $groupid) {
		//query the member by id depening on if private or not
		$query = sprintf("DELETE FROM groupNews WHERE id = '%s' AND groupID = '%s'", $id, $groupid);
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

	function DeleteCorpNews($id) {
		//query the member by id depening on if private or not
		$query = sprintf("DELETE FROM corporateNews WHERE id = '%s' ", $id);
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

	function DeletePayPalButton($id, $groupid) {
		//query the member by id depening on if private or not
		$query = sprintf("DELETE FROM groupPayPal WHERE id = '%s' AND groupID = '%s'", $id, $groupid);
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

	function DeleteFile($id, $groupid) {
		//query the member by id depening on if private or not
		$query = sprintf("DELETE FROM groupFiles WHERE id = '%s' AND groupID = '%s'", $id, $groupid);
		//Check if a error came back
		if ($r = $this -> db -> select($query)) {//Check for a false
			return true;
			//no false return true
		} else {
			$this -> return_error = $this -> db -> last_error;
			//If we get a false, grab the error
			return false;
			//return false
		}

		return false;
		//Nothing happen return false
	}

	function getStateAbbreviation($state) {
		$state_list = array('AL' => "Alabama", 'AK' => "Alaska", 'AZ' => "Arizona", 'AR' => "Arkansas",
		//'CA'=>"California",
		'CA_N' => "California Northern", 'CA_CC' => "California Central Coast", 'CA_LA' => "California Los Angeles Area", 'CA_IE' => "California Inland Empire", 'CA_SD' => "California San Diego Area", 'CO' => "Colorado", 'CT' => "Connecticut", 'DE' => "Delaware", 'DC' => "District Of Columbia", 'FL' => "Florida", 'GA' => "Georgia", 'HI' => "Hawaii", 'ID' => "Idaho", 'IL' => "Illinois", 'IN' => "Indiana", 'IA' => "Iowa", 'KS' => "Kansas", 'KY' => "Kentucky", 'LA' => "Louisiana", 'ME' => "Maine", 'MD' => "Maryland", 'MA' => "Massachusetts", 'MI' => "Michigan", 'MN' => "Minnesota", 'MS' => "Mississippi", 'MO' => "Missouri", 'MT' => "Montana", 'NE' => "Nebraska", 'NV' => "Nevada", 'NH' => "New Hampshire", 'NJ' => "New Jersey", 'NM' => "New Mexico", 'NY' => "New York", 'NC' => "North Carolina", 'ND' => "North Dakota", 'OH' => "Ohio", 'OK' => "Oklahoma", 'OR' => "Oregon", 'PA' => "Pennsylvania", 'RI' => "Rhode Island", 'SC' => "South Carolina", 'SD' => "South Dakota", 'TN' => "Tennessee", 'TX' => "Texas", 'UT' => "Utah", 'VT' => "Vermont", 'VA' => "Virginia", 'WA' => "Washington", 'WV' => "West Virginia", 'WI' => "Wisconsin", 'WY' => "Wyoming");

		if ($abbr = array_search($state, $state_list)) {
			return $abbr;
		}

		return FALSE;
	}

}
