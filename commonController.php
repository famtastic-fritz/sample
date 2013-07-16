<?php
if (!defined('BASEPATH'))
  exit('No direct script access allowed');

/**
 *

 * @since		Version 1.0
 *
 * This class is for handel get requests
 *
 * @subpackage	Application
 * @category	Controller

 */

//Include the group model
include APPPATH . '/models/group_model.php';
//Include the member model
include APPPATH . '/models/member_model.php';
//Include the usmap model
include APPPATH . '/models/usmap_model.php';


class commonController extends BaseController {
	//Set the param for the class
	public $group_model = '';
	public $member_model = '';
	public $usmap_model = '';
	public $uri_control = array();


	
	function __construct(){
		parent::__construct();
		//Load the group model
		$this -> group_model = new group_model();
		//Load the member model
		$this -> member_model = new member_model();
		$this -> usmap_model = new usmap_model();
	}
	

	
	public function getCurrentDomain($uri_spot = 3, $returndefault = true){
		//print_r($this-> uri_control);exit;
		$domain = (@($this -> uri_control[$uri_spot]) != "") ? $this -> uri_control[$uri_spot] : $GLOBALS['DOMAIN_HASH'];
		if(!$returndefault && empty($this -> uri_control[$uri_spot]))return "";
		return $domain;
	}
	public function getGroup($domain) {
		if ($this -> group_model -> GetGroupInfo($domain)) {
			//Set the returned members array to go to the view
			$this -> _VIEW_ -> set('group', $this -> group_model -> return_data);
			
			
			// get states for dropdown
			//$this -> usmap_model = new usmap_model();
			$usmap_model = new usmap_model();
			$this -> _VIEW_ -> set('allStates', $usmap_model -> getStateList());
			
			
		} else {
			//There was an error being returned, send it to the view
			$this -> _VIEW_ -> set('error', $this -> group_model -> return_error);
		}
	}

  public function getAllUsersEmails(){
		//Run the Group Model to get group info
		if ($this -> group_model -> getAllEmails()) {
			//Set the returned members array to go to the view
			$this -> _VIEW_ -> set('group_emails', $this -> group_model -> return_data);
		} else {
			//There was an error being returned, send it to the view
			$this -> _VIEW_ -> set('error', $this -> group_model -> return_error);
		}
  }

	public function getGroups() {
		//Run the Group Model to get group info
		if ($this -> group_model -> GetAllGroups()) {
			//Set the returned members array to go to the view
			$this -> _VIEW_ -> set('groups', $this -> group_model -> return_data);

			// get states for dropdown
			$this -> usmap_model = new usmap_model();
			$this -> _VIEW_ -> set('allStates', $this -> usmap_model -> getStateList());

		} else {
			//There was an error being returned, send it to the view
			$this -> _VIEW_ -> set('error', $this -> group_model -> return_error);
		}
	}
	
	public function getMember($memberid){
		//Get the member data from the members model		
		if($this->member_model->GetUserData($memberid)){
			//load the member data to an array to pass to the view	
			$this->_VIEW_->set('member', $this->member_model->return_data);
			return true;
		}else{
			//something happened set an error
			$this->_VIEW_->set('error', $this->member_model->return_error);
			return false;
		}
	}
	
	public function getMembers($domain, $sortby = false, $sortorder = "asc", $islive = false){
		//Run the members model with the domain hash to get the members of the group
		if ($this -> member_model -> GetGroupAllMembers($domain,$islive)) {
			//Set the returned members array to go to the view
			if($sortby != false){
				$this -> _VIEW_ -> set('members', $this -> sort2d($this -> member_model -> return_data, $sortby, $sortorder, true));
			} else {
				$this -> _VIEW_ -> set('members', $this -> member_model -> return_data);
			}
		} else {
			//There was an error being returned, send it to the view
			$this -> _VIEW_ -> set('error', $this -> member_model -> return_error);
			return false;
		}
		return true;
	}

	public function getRequests($domain) {
		//Run the Group Model to get requests
		if ($this -> group_model -> GetGroupRequests($domain)) {
			//Set the returned members array to go to the view
			$this -> _VIEW_ -> set('requests', $this -> group_model -> return_data);
		} else {
			//There was an error being returned, send it to the view
			$this -> _VIEW_ -> set('error', $this -> group_model -> return_error);
		}
	}
	
	public function getNews($domain){
		//Run the Group Model to get group NEWS
		if ($this -> group_model -> GetGroupNews($domain)) {
			//Set the returned members array to go to the view
			$this -> _VIEW_ -> set('news', $this -> group_model -> return_data);

		} else {

			//There was an error being returned, send it to the view
			$this -> _VIEW_ -> set('error', $this -> group_model -> return_error);
		}
		//Run the Group Model to get group NEWS
		if ($this -> group_model -> GetCorpNews()) {
			//Set the returned members array to go to the view
			$this -> _VIEW_ -> set('groupnews', $this -> group_model -> return_data);

		} else {

			//There was an error being returned, send it to the view
			$this -> _VIEW_ -> set('error', $this -> group_model -> return_error);
		}
	}
	/*public function getCorpNews(){

	}*/
	
	public function getPaypal($domain){
		//Run the Group Model to get group payment
		if ($this -> group_model -> GetGroupPayPalButtons($domain)) {
			//Set the returned members array to go to the view
			$this -> _VIEW_ -> set('paypal', $this -> group_model -> return_data);

		} else {

			//There was an error being returned, send it to the view
			$this -> _VIEW_ -> set('error', $this -> group_model -> return_error);
		}
	}
	
	public function getFiles($domain){
		//Run the Group Model to get group FILES
		if ($this -> group_model -> GetGroupFiles($domain)) {
			//Set the returned members array to go to the view
			$this -> _VIEW_ -> set('files', $this -> group_model -> return_data);

		} else {

			//There was an error being returned, send it to the view
			$this -> _VIEW_ -> set('error', $this -> group_model -> return_error);
		}
	}
	
	public function getLeads($domain){
		$newdate = time()-31556926;
		if($this->group_model->GetAllGroupsLeadsSite($domain,$newdate)){
			$this->_VIEW_->set('all_leads', $this->group_model->return_data);
		}else{
			//something happened set an error
			$this->_VIEW_->set('error', $this->group_model->return_error);
		}
	}
	
	public function getMemberLeads($memberid,$gettype){
		if($this->member_model-> GetSiteLeads($memberid,$gettype)){
			//load the member data to an array to pass to the view	
			$this->_VIEW_->set('leads', $this->member_model->return_data);
		}else{
			//something happened set an error
		$this->_VIEW_->set('error', $this->member_model->return_error);
		}
	}

	public function getMemberCompany($memberid){
		//Get user companys
		if($this->member_model->GetUserCompanys($memberid)){
			//load the member data to an array to pass to the view	
			$this->_VIEW_->set('company', $this->member_model->return_data);
		}else{
			//something happened set an error
			$this->_VIEW_->set('error', $this->member_model->return_error);
		}
	}
	
	public function getMemberTestimonials($memberid,$domain){
				//Run the members model with the domain hash to get the members of the group
		if($this->member_model->GetUserReviews($memberid,$domain,'Public')){
			$this->_VIEW_->set('testimonials', $this->member_model->return_data);		
		}else{
			//There was an error being returned, send it to the view
			$this->_VIEW_->set('error', $this->member_model->return_error);
		}
	}
	
	public function getMemberReviews($memberid,$domain){
				//Get user companys
		if($this->member_model->GetUserReviews($memberid,$domain)){
			//load the member data to an array to pass to the view	
			$this->_VIEW_->set('reviews', $this->member_model->return_data);
		}else{
			//something happened set an error
			$this->_VIEW_->set('error', $this->member_model->return_error);
		}	
	}
	
	public function getMemberPoints($memberid){
		//Run the Group Model to get group info
		if($this->member_model->GetMemberPoints($memberid)){
			//Set the returned members array to go to the view
			$this->_VIEW_->set('points', $this->member_model->return_data);	
			
		}else{
			
			//There was an error being returned, send it to the view
			$this->_VIEW_->set('error', $this->group_model->return_error);	
		}
		
		
	}
	
  public function getMemberPoints2($memberid,$domain){
		//Run the Group Model to get group info
		if($this->member_model->GetMemberPoints($memberid, $domain)){
			//Set the returned members array to go to the view
			$this->_VIEW_->set('mem_points', $this->member_model->return_data);	
			
		}else{
			
			//There was an error being returned, send it to the view
			$this->_VIEW_->set('error', $this->group_model->return_error);	
		}
	}
		
	public function getPoints($domain){
		//Run the Group Model to get group info
		if($this->group_model->GetGroupPoints($domain)){
			//Set the returned members array to go to the view
			$this->_VIEW_->set('points', $this->group_model->return_data);	
			
		}else{
			
			//There was an error being returned, send it to the view
			$this->_VIEW_->set('error', $this->group_model->return_error);	
		}
	}
	
	public function getMemberOffers($memberid,$private){
		if($this->member_model->GetUserOffers($memberid, $private)){
			//Set the returned members array to go to the view
			$this->_VIEW_->set('offers', $this->member_model->return_data);	
			
		}else{
			
			//There was an error being returned, send it to the view
			$this->_VIEW_->set('error', $this->member_model->return_error);	
		}
	}
	
	
	
}
