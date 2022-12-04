<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Accounts extends CI_Controller {

    public function __construct(){
		parent::__construct();
		$this->load->helper(array('dompdf'));
		$this->load->model('accounts_model', 'Accounts_model', true);
		$this->load->library(array('account','form_validation'));
		$this->load->model('Common_model_new','cm',true);
		//$this->load->library('form_validation'); 
		if(!$this->session->userdata('logged_in')){
			redirect('login');
			exit;
		}
	}
	public function index(){
		$data['page']='accounts/index.php';
		$this->load->view('master',$data);
	} 
	
	/*----------------------------------- Master Head --------------------------*/
	
	public function master_head_delete($id){
		$d_data['fcoa_master_id'] = $id;
		
		if($this->cm->common_delete('tbl_fcoa_master',$d_data)>0){
			$this->session->set_flashdata('message', 'Master head delete Successfully');
			redirect('accounts/master_head_list');
		}
		else {
			$this->session->set_flashdata('message', 'Master head delete UnSuccessfully');
			redirect('accounts/master_head_list');
		}
	}

	public function master_head_list(){
		$my_id = 1;
		$fcoa_master_id='';
		$sucess=0;
		$this->form_validation->set_rules('fcoa_master', 'Please Type Master Head Name', 'required');
		$this->form_validation->set_rules('master_code', 'Please Type Master Head Code', 'required');
		//$this->form_validation->set_rules('fcoa_code', 'Please Type Sub1 Head Code', 'required');
		
		if ($this->form_validation->run() == true){
			$data = array(
				'my_id'    	=> $my_id,
				'fcoa_master' 	=> trim($this->input->post('fcoa_master')),
				'master_code'  	=> trim($this->input->post('master_code')),
				'rec_date'    	=> date('Y-m-d H:i:s',time())
			);
				
			$fcoa_master_id = $this->input->post('fcoa_master_id');
			
			if(!empty($fcoa_master_id)){
								   $con['fcoa_master_id']=$fcoa_master_id;
								   
				if($this->cm->common_update('tbl_fcoa_master',$data,$con)==1){
					$this->session->set_flashdata('message', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>Data has been saved successfully</div>');
				}
				else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>Data has not been saved. Please try again.</div>');
				}
			}
			else {
				$sucess = $this->cm->common_insert('tbl_fcoa_master',$data);
				if(!empty($sucess) and $sucess>0){
					$this->session->set_flashdata('message', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>Data has been saved successfully</div>');
				}
				else {
					$this->session->set_flashdata('message', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>Data has not been saved. Please try again.</div>');
				}
			}		
		}
		
		
		$data['master_head_list'] = $this->Accounts_model->master_head_list($my_id);
		$data['page']='accounts/master_head_list.php';
		$this->load->view('master',$data);
	}
	
	/*----------------------------------- FCOA Start --------------------------*/
	
	public function sub1_head_edit($id){
		$my_id = 1;
		$data['master_head_list'] = $this->Accounts_model->master_head_list($my_id);
		$data['sub1_head_edit'] = $this->Accounts_model->sub1_head_edit($my_id, $id);
		$this->load->view('accounts/sub1_head_edit', $data);
	}
	
	public function sub1_head_delete($id){
		$d_data['fcoa_id'] = $id;
		
		if($this->cm->common_delete('tbl_fcoa',$d_data)>0){
			$this->session->set_flashdata('message', 'Sub1 head delete Successfully');
			redirect('accounts/sub1_head_list');
		}
		else {
			$this->session->set_flashdata('message', 'Sub1 head delete UnSuccessfully');
			redirect('accounts/sub1_head_list');
		}
	}

	public function sub1_head_list(){
		$my_id = 1;
		$fcoa_id='';
		$sucess=0;
		
		
			$this->form_validation->set_rules('fcoa_master_id', 'Please Select Master Head', 'required');
			$this->form_validation->set_rules('fcoa', 'Please Type Sub1 Head Name', 'required');
			$this->form_validation->set_rules('fcoa_code', 'Please Type Sub1 Head Code', 'required');
			
			if ($this->form_validation->run() == true)
			{
				$data = array(
					'fcoa_master_id'=> $this->input->post('fcoa_master_id'),
					'my_id'    	=> $my_id,
					'fcoa' 			=> trim($this->input->post('fcoa')),
					'fcoa_code'  	=> trim($this->input->post('fcoa_code')),
					'fcoa_balance'  => $this->input->post('fcoa_balance'),
					'rec_date'    	=> date('Y-m-d H:i:s',time())
				);
				
				$fcoa_id = $this->input->post('fcoa_id');
				
				if(!empty($fcoa_id)){
					$con['fcoa_id']=$fcoa_id;
					if($this->cm->common_update('tbl_fcoa',$data,$con)==1){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>Data has been saved successfully</div>');
					}
					else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>Data has not been saved. Please try again.</div>');
					}
				}
				else {
					$sucess = $this->cm->common_insert('tbl_fcoa',$data);
					if(!empty($sucess) and $sucess>0){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>Data has been saved successfully</div>');
					}
					else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>Data has not been saved. Please try again.</div>');
					}
				}		
			}
		
		$data['master_head_list'] = $this->Accounts_model->master_head_list($my_id);
		$data['sub1_head_list'] = $this->Accounts_model->sub1_head_list($my_id);
		$data['page']='accounts/sub1_head_list.php';
		$this->load->view('master',$data);
	}
	
	/*----------------------------------- FCOA BKDN Start --------------------------*/
	
	public function sub2_head_create(){
		$my_id = 1;
		$data['master_head_list'] = $this->Accounts_model->master_head_list($my_id);
		$this->load->view('accounts/sub2_head_create', $data);
	}
	
	public function get_sub1_list_json(){
		
		
		$fcoa_master_id = $_REQUEST['fcoa_master_id'];
		$my_id = 1;
		$list_array = array();
		
		$datalist = $this->Accounts_model->sub1_head_list_ajax($my_id,$fcoa_master_id);
		
		foreach($datalist as $row){
			$list_array[] = array('optionValue'=>$row['fcoa_id'],'optionDisplay'=>$row['fcoa'],'fcoacode'=>$row['fcoa_code']);
		}
		
		print json_encode($list_array);
	}

	public function sub2_head_edit(){
		$my_id = 1;
		$id = $_GET['id'];
		$data['master_head_list'] = $this->Accounts_model->master_head_list($my_id);
		$data['sub2_head_edit'] = $this->Accounts_model->sub2_head_edit($my_id, $id);
		
			$mainContent=$this->load->view('accounts/sub2_head_edit_json', $data, true);
			
		$result = 'success';
		$return = array('result' => $result, 'mainContent'=> $mainContent);
		print json_encode($return);
		exit;   
	}
	
	public function sub2_head_delete($id){
		$d_data['my_id'] = 1;
		$d_data['fcoa_bkdn_id'] = $id;
		if($this->cm->common_delete('tbl_fcoa_bkdn',$d_data)>0){
			$this->session->set_flashdata('message', 'Sub2 head delete Successfully');
			redirect('accounts/sub2_head_list');
		}
		else {
			$this->session->set_flashdata('message', 'Sub2 head delete UnSuccessfully');
			redirect('accounts/sub2_head_list');
		}
	}

	public function sub2_head_list(){
		$my_id = 1;
		$fcoa_bkdn_id='';
		$sucess=0;
		
			$this->form_validation->set_rules('fcoa_id', 'Please Select Sub1 Head', 'required');
			$this->form_validation->set_rules('fcoa_bkdn', 'Please Type Sub2 Head Name', 'required');
			$this->form_validation->set_rules('bkdn_code', 'Please Type Sub2 Head Code', 'required');
			
			if ($this->form_validation->run() == true)
			{
				$data = array(
					'fcoa_id'		=> $this->input->post('fcoa_id'),
					'my_id'    	=> $my_id,
					'fcoa_bkdn' 	=> trim($this->input->post('fcoa_bkdn')),
					'bkdn_code'  	=> trim($this->input->post('bkdn_code')),
					'bkdn_balance'  => $this->input->post('bkdn_balance'),
					'rec_date'    	=> date('Y-m-d H:i:s',time())
				);
				
				$fcoa_bkdn_id = $this->input->post('fcoa_bkdn_id');
				
				if(!empty($fcoa_bkdn_id)){
					$con['fcoa_bkdn_id']=$fcoa_bkdn_id;
					if($this->cm->common_update('tbl_fcoa_bkdn',$data,$con)==1){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>Data has been saved successfully</div>');
					}
					else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>Data has not been saved. Please try again.</div>');
					}
				}
				else {
					$sucess = $this->cm->common_insert('tbl_fcoa_bkdn',$data);
					if(!empty($sucess) and $sucess>0){
						$this->session->set_flashdata('message', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">&times;</a>Data has been saved successfully</div>');
					}
					else {
						$this->session->set_flashdata('message', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">&times;</a>Data has not been saved. Please try again.</div>');
					}
				}		
			}
		
		$data['master_head_list'] = $this->Accounts_model->master_head_list($my_id);
		$data['sub2_head_list'] = $this->Accounts_model->sub2_head_list($my_id);
		$data['page']='accounts/sub2_head_list.php';
		$this->load->view('master',$data);
	}

	/*----------------------------------- FCOA BKDN SUB Start --------------------------*/
	
	public function sub3_head_create(){
		$my_id = 1;
		
		$this->load->view('accounts/sub3_head_create', $data);
	}
	
	public function get_sub2_list_json(){
		
		$fcoa_id = $_REQUEST['fcoa_id'];
		$my_id = 1;
		$list_array = array();
		
		$datalist = $this->Accounts_model->sub2_head_list_ajax($my_id,$fcoa_id);
		
		foreach($datalist as $row){
			$list_array[] = array('optionValue'=>$row['fcoa_bkdn_id'],'optionDisplay'=>$row['fcoa_bkdn'],'fcoacode'=>$row['bkdn_code']);
		}
		
		print json_encode($list_array);
	}
	
	public function sub3_head_edit(){
		$my_id = 1;
		$id = $_GET['id'];
		$data['sub3_head_edit'] = $this->Accounts_model->sub3_head_edit($my_id, $id);
		
			$mainContent=$this->load->view('accounts/sub3_head_edit_json', $data, true);
			
		$result = 'success';
		$return = array('result' => $result, 'mainContent'=> $mainContent);
		print json_encode($return);
		exit;   
	}
	
	public function sub3_head_delete($id){
		$d_data['my_id'] = 1;
		$d_data['fcoa_bkdn_sub_id'] = $id;
		
		if($this->cm->common_delete('tbl_fcoa_bkdn_sub',$d_data)>0){
			$this->session->set_flashdata('message', 'Sub3 head delete Successfully');
			redirect('accounts/sub3_head_list');
		}
		else {
			$this->session->set_flashdata('message', 'Sub3 head delete UnSuccessfully');
			redirect('accounts/sub3_head_list');
		}
	}

	public function sub3_head_list(){
		$my_id = 1;
		$fcoa_bkdn_sub_id='';
		$sucess=0;
		
			$this->form_validation->set_rules('fcoa_bkdn_id', 'Please Select Sub2 Head', 'required');
			$this->form_validation->set_rules('fcoa_bkdn_sub', 'Please Type Sub3 Head Name', 'required');
			$this->form_validation->set_rules('sub_code', 'Please Type Sub3 Head Code', 'required');
			
			if ($this->form_validation->run() == true)
			{
				$data = array(
					'fcoa_bkdn_id'		=> $this->input->post('fcoa_bkdn_id'),
					'my_id'    			=> $my_id,
					'fcoa_bkdn_sub' 	=> trim($this->input->post('fcoa_bkdn_sub')),
					'sub_code'  		=> trim($this->input->post('sub_code')),
					'sub_balance'  		=> $this->input->post('sub_balance'),
					'rec_date'    		=> date('Y-m-d H:i:s',time())
				);
				
				$fcoa_bkdn_sub_id = $this->input->post('fcoa_bkdn_sub_id');
				
				if(!empty($fcoa_bkdn_sub_id)){
					$con['fcoa_bkdn_sub_id']=$fcoa_bkdn_sub_id;
					if($this->cm->common_update('tbl_fcoa_bkdn_sub',$data,$con)==1){
						$this->session->set_flashdata('message', 'Sub3 head update successfully');
						redirect('accounts/sub3_head_list');
					}
					else {
						$this->session->set_flashdata('message', 'Sub3 head update Unsuccessfully');
						redirect('accounts/sub3_head_list');
					}
				}
				else {
					$sucess = $this->cm->common_insert('tbl_fcoa_bkdn_sub',$data);
					if(!empty($sucess) and $sucess>0){
						$this->session->set_flashdata('message', 'Sub3 head insert successfully');
						redirect('accounts/sub3_head_list');
					}
					else {
						$this->session->set_flashdata('message', 'Sub3 head insert Unsuccessfully');
						redirect('accounts/sub3_head_list');
					}
				}		
			}
		
		$data['master_head_list'] = $this->Accounts_model->master_head_list($my_id);
		$data['sub3_head_list'] = $this->Accounts_model->sub3_head_list($my_id);
		$data['page']='accounts/sub3_head_list.php';
		$this->load->view('master',$data);
	}
	
	/*----------- Navigation Head View Start -------------*/
	
	public function navigation_head_view(){
		$my_id = 1;
		$data['page']='accounts/navigation_head_view.php';
		$this->load->view('master',$data);
	}
	
	/*----------------------------------- Debit Voucher --------------------------*/
	
	public function debit_voucher_entry(){
		$data['page']='accounts/debit_voucher_entry.php';
		$this->load->view('master',$data);
	}
	
	public function array_flatten($array){
		$return = array();
		array_walk_recursive($array, function($x) use (&$return) { $return[] = $x; });
		return $return;
	}
	
	public function search_array_key($array, $key, $value){
		$results = array();
		if (is_array($array))
		{	
			if (isset($array[$key]) && $array[$key] == $value){
				$results[] = $array;
			}
			foreach ($array as $subarray){
				$results = array_merge($results, $this->search_array_key($subarray, $key, $value));
			}
		}		
		return $results;
	}
	
	public function get_check_account_code(){
		
		$code = $_REQUEST['code'];
		$increment = $_REQUEST['increment'];
		
		$needle = $_REQUEST['code'];
		$needle = strtolower($needle);
		
	
		$my_id = 1;
		$list_array=array();
		
		$return_Arr = $this->Accounts_model->account_code_list_ajax($code,$increment,$my_id);
		
		$master_headArr = $return_Arr[0];
		$fcoaArr = $return_Arr[1];
		$fcoa_bkdnArr = $return_Arr[2];
		$sub_fcoa_bkdnArr = $return_Arr[3];
		
		
		$masterSingleArr=array();
		$fcoaSingleArr=array();
		$fcoa_bkdnSingleArr=array();
		$sub_fcoa_bkdnSingleArr=array();
		
		if(sizeof($master_headArr)>0){
			foreach($master_headArr as $masterheadArr){
				
				$masterhead_coa_id 	= $masterheadArr["id"];
				$masterhead_coa 	= $masterheadArr["head"];
				$coa_code			= $masterheadArr["coa_code"];
				$lavel				= $masterheadArr["lavel"];
				
				$result=$this->search_array_key($fcoaArr,'parent',$masterhead_coa_id);
				
				if(sizeof($result)<=0){
					$masterSingleArr[]=$coa_code."-".$masterhead_coa."-".$lavel."-".$masterhead_coa_id;
				}	
			}
		}
		
		
		if(sizeof($fcoaArr)>0){
			foreach($fcoaArr as $fcoa_Arr){
				
				$fcoa_id 	= $fcoa_Arr["id"];
				$fcoa_head 	= $fcoa_Arr["head"];
				$coa_code	= $fcoa_Arr["coa_code"];
				$lavel		= $fcoa_Arr["lavel"];
				
				$result=$this->search_array_key($fcoa_bkdnArr,'parent',$fcoa_id);
				if(sizeof($result)<=0){
					$fcoaSingleArr[]=$coa_code."-".$fcoa_head."-".$lavel."-".$fcoa_id;
				}	
			}
		}
		
		if(sizeof($fcoa_bkdnArr)>0){
			foreach($fcoa_bkdnArr as $fcoabkdnArr){
				
				$fcoa_bkdn_id 	= $fcoabkdnArr["id"];
				$fcoa_bkdn 		= $fcoabkdnArr["head"];
				$coa_code		= $fcoabkdnArr["coa_code"];
				$lavel			= $fcoabkdnArr["lavel"];
				
				$result=$this->search_array_key($sub_fcoa_bkdnArr,'parent',$fcoa_bkdn_id);
				if(sizeof($result)<=0){
					$fcoa_bkdnSingleArr[]=$coa_code."-".$fcoa_bkdn."-".$lavel."-".$fcoa_bkdn_id;
				}	
			}
		}
		
		if(sizeof($sub_fcoa_bkdnArr)>0){
			foreach($sub_fcoa_bkdnArr as $subfcoabkdnArr){
				
				$sub_fcoa_bkdn_id 	= $subfcoabkdnArr["id"];
				$sub_fcoa_bkdn 		= $subfcoabkdnArr["head"];
				$coa_code			= $subfcoabkdnArr["coa_code"];
				$lavel				= $subfcoabkdnArr["lavel"];
				
				/*$result=$this->search_array_key($coa_subArr,'parent',$sub_fcoa_bkdn_id);
				if(sizeof($result)<=0){*/
					$sub_fcoa_bkdnSingleArr[]=$coa_code."-".$sub_fcoa_bkdn."-".$lavel."-".$sub_fcoa_bkdn_id;
				//}	
			}
		}
		
	
		$FinalResult = array_merge($masterSingleArr, $fcoaSingleArr);
		$FinalResult = array_merge($FinalResult, $fcoa_bkdnSingleArr);
		$FinalResult = array_merge($FinalResult, $sub_fcoa_bkdnSingleArr);
		
		
		$FinalResultBuild=array();
		$FinalResultTmp=array();
		$FinalResultTmp = $FinalResult;
		foreach($FinalResultTmp as $FinalResultStr){
			$coacode='';
			$coaname='';
			$FinalResultARR=explode("-",$FinalResultStr);
			$coacode=$FinalResultARR[0];
			$coaname=$FinalResultARR[1];
			$FinalResultBuild[]= $coacode."-".$coaname;	
		}
		
		$StrToLowerFRES=array();
		foreach($FinalResult as $StrToLower){
			$StrToLowerFRES[]= strtolower($StrToLower);	
		}
		
		$StrToLowerRes=array();
		foreach($FinalResultBuild as $StrToLower){
			$StrToLowerRes[]= strtolower($StrToLower);	
		}
		
		
		$ret=array();
		$ret = array_values(array_filter($StrToLowerRes, function($var) use ($needle){
			return strpos($var, $needle) !== false;
		}));
		
		
		$res=array();
		foreach($ret as $retstr){
			$res[] = array_values(array_filter($StrToLowerFRES, function($var) use ($retstr){
				return strpos($var, $retstr) !== false;
			}));
		}
		
		
		$resss=array();
		$resss = $this->array_flatten($res);
		
		if(sizeof($resss)>0){
			foreach($resss as $ret_value){
				$ret_valueArr=explode("-",$ret_value);
				$codenumber = $ret_valueArr[0];
				$head 		= ucwords($ret_valueArr[1]);
				$tableName 	= $ret_valueArr[2];
				$tableId 	= $ret_valueArr[3];
				
				$display_value = $codenumber."-".$head;
				
				if(!empty($tableName) && !empty($tableId)){
					$list_array[] = array('table_name'=>$tableName,'table_id'=>$tableId,'display_value'=>$display_value);
				}
			}
		}
		print json_encode($list_array);
	}
	
	public function debit_voucher_list(){
		$my_id = 1;
		$insert_id=0;
		
		if(isPostBack()){
			$this->form_validation->set_rules('pay_name', 'Please Type Pay Name', 'trim|required|prep_for_form');
			$this->form_validation->set_rules('purpose', 'Please Type Purpose', 'trim|required|prep_for_form');
			$this->form_validation->set_rules('debit_sum', 'Total Debit Is Empty', 'trim|required|matches[credit_sum]');
			$this->form_validation->set_rules('debit_sum', 'Total Debit And Credit Are Not Equal', 'matches[credit_sum]');
			$this->form_validation->set_rules('credit_sum', 'Total Credit Is Empty', 'trim|required|prep_for_form');
			$this->form_validation->set_rules('particulars[]', 'Please Type Your Particulars', 'required|prep_for_form');
			$this->form_validation->set_rules('account_code[]', 'Please Insert Account Code', 'required|prep_for_form');
			$this->form_validation->set_rules('table_name[]', 'Table Name Not Found', 'required|prep_for_form');
			$this->form_validation->set_rules('table_id[]', 'Table Id Not Found', 'required|prep_for_form');
			
			if ($this->form_validation->run() == true){
				$current_date=$this->input->post('current_date');
				
				if(!empty($current_date)){
					$current_date_tmp	= explode("-",$this->input->post('current_date'));
					
					$yyyy		= $current_date_tmp[0];
					$mm		= $current_date_tmp[1];
					$dd	= $current_date_tmp[2];
					$current_date = $yyyy."-".$mm."-".$dd;
					
				}
				else{
					$current_date    = date('Y-m-d',time());
				}
				$rec_date   	= $current_date.' '.date('H:i:s',time());
				
				$pay_name		= trim($this->input->post('pay_name'));
				$pay_status		= trim($this->input->post('pay_status'));
				$purpose		= trim($this->input->post('purpose'));
				$debit_sum  	= trim($this->input->post('debit_sum'));
				$credit_sum  	= trim($this->input->post('credit_sum'));
				
				$cheque_no  	= trim($this->input->post('cheque_no'));
				
				$cheque_dt  	= $this->input->post('cheque_dt');
				if(!empty($cheque_dt)){
					$cheque_dt_tmp	= explode("-",$this->input->post('cheque_dt'));
					
					$yyyy				= $cheque_dt_tmp[0];
					$mm				= $cheque_dt_tmp[1];
					$dd			= $cheque_dt_tmp[2];
					$cheque_dt		= $yyyy."-".$mm."-".$dd;
				
				}
				else{
					$cheque_dt= '';
				}
				
				$bank= trim($this->input->post('bank'));
				
				$voucher_no = $this->Accounts_model->create_voucher_no($my_id);
				
				if(!empty($voucher_no)){
					$data1 = array(
							'my_id'    		=> $my_id,
							'voucher_no'    => $voucher_no,
							'current_date'	=> $current_date,
							'pay_status'	=> $pay_status,
							'pay_name'		=> $pay_name,
							'purpose'		=> $purpose,
							'debit_sum'    	=> $debit_sum,
							'credit_sum'    => $credit_sum,
							'cheque_no'     => $cheque_no,
							'cheque_dt'   	=> $cheque_dt,
							'bank'    		=> $bank,
							'rec_date'    	=> $rec_date,
							'createdBy' 	=> $this->session->userdata('logged_in')['id']
							);
					
					$insert_id = $this->cm->common_insert('tbl_debit_voucher',$data1);			
					
					if(!empty($insert_id) and $insert_id>0){
						$particularsArr		= $this->input->post('particulars');
						$account_codeArr	= $this->input->post('account_code');
						$table_nameArr    	= $this->input->post('table_name');
						$table_idArr 		= $this->input->post('table_id');
						$debitArr 			= $this->input->post('debit');
						$creditArr 			= $this->input->post('credit');
						$bkdn_idArr 		= $this->input->post('bkdn_id');
						
						if(sizeof($bkdn_idArr)>0){
							$inc=0;	
							foreach($bkdn_idArr as $bkdn_id){
								$insertid='';
								$particulars	= '';
								$account_code	= '';
								$table_name    	= '';
								$table_id 		= '';
								$debit 			= '';
								$credit 		= '';
								
								if(!empty($particularsArr[$inc])){$particulars = trim($particularsArr[$inc]);}
								if(!empty($account_codeArr[$inc])){$account_code = $account_codeArr[$inc];}
								if(!empty($table_nameArr[$inc])){$table_name = $table_nameArr[$inc];}
								if(!empty($table_idArr[$inc])){$table_id = $table_idArr[$inc];}
								if(!empty($debitArr[$inc])){$debit = $debitArr[$inc];}
								if(!empty($creditArr[$inc])){$credit = $creditArr[$inc];}
								
								$data2 = array(
									'debit_voucher_id'  => $insert_id,
									'particulars'    	=> $particulars,
									'account_code'		=> $account_code,
									'table_name'		=> $table_name,
									'table_id'    		=> $table_id,
									'debit'    			=> $debit,
									'credit'    		=> $credit
								);
								
								$insertid = $this->cm->common_insert('tbl_devoucher_bkdn',$data2);
								
								if(!empty($insertid) and $insertid>0){
								
								// Ledger part
								if($table_name=="tbl_fcoa_master"){$field_name="fcoa_master_id";}
								else if($table_name=="tbl_fcoa"){$field_name="fcoa_id";}
								else if($table_name=="tbl_fcoa_bkdn"){$field_name="fcoa_bkdn_id";}
								else if($table_name=="tbl_fcoa_bkdn_sub"){$field_name="fcoa_bkdn_sub_id";}
									
								if($debit>0 && empty($credit)){
									$journal_title=$particulars;
									 $data3 = array(
											'journal_title'=> $journal_title,
											'dr'=> $debit,
											'rec_date'=> $rec_date,
											'my_id'=> $my_id,
											'jv_id'=> $voucher_no,
											'debit_voucher_id'=> $insert_id,
											'devoucher_bkdn_id' => $insertid,
											''.$field_name.''=> $table_id
											);
									$this->cm->common_insert('tbl_general_ledger',$data3);
								}
								if(empty($debit) && $credit>0){
									$journal_title=$particulars;
									$data3 = array(
													'journal_title' 	=> $journal_title,
													'cr'    			=> $credit,
													'rec_date'			=> $rec_date,
													'my_id'    		=> $my_id,
													'jv_id'    			=> $voucher_no,
													'debit_voucher_id'  => $insert_id,
													'devoucher_bkdn_id' => $insertid,
													''.$field_name.''	=> $table_id
												);
									$this->cm->common_insert('tbl_general_ledger',$data3);
								}
								// Ledger part
								}
								$inc++;
							}
						}
					/* voucher success save message */
					$this->session->set_flashdata('message', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">X</a>Data has been saved successfully</div>');
					}
				}
			}// Validated
			else {
				/* voucher unsuccess save message */
				$this->session->set_flashdata('message', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">X</a>Data has not been saved. Please try again.</div>');
				$this->load->view('accounts/debit_voucher_entry');
			}
		}// if Post Back

		$my_id = 1;
		$data['debit_voucher_list'] = $this->Accounts_model->debit_voucher_list($my_id);
		$data['page']='accounts/debit_voucher_list.php';
		$this->load->view('master',$data);
	}
	
	public function debit_voucher_edit($id){
		$my_id = 1;
		
		if(isPostBack()){
			
			$this->form_validation->set_rules('pay_name', 'Please Type Pay Name', 'trim|required|prep_for_form');
			$this->form_validation->set_rules('purpose', 'Please Type Purpose', 'trim|required|prep_for_form');
			$this->form_validation->set_rules('particulars[]', 'Please Type Your Particulars', 'required|prep_for_form');
			
			if ($this->form_validation->run() == true){
				$debit_voucher_id 	= $this->input->post('debit_voucher_id');
				$cheque_no  		= trim($this->input->post('cheque_no'));
				$cheque_dt  		= $this->input->post('cheque_dt');
				if(!empty($cheque_dt)){
					$cheque_dt_tmp	= explode("/",$this->input->post('cheque_dt'));
					$mm				= $cheque_dt_tmp[0];
					$dd				= $cheque_dt_tmp[1];
					$yyyy			= $cheque_dt_tmp[2];
					$cheque_dt 		= $yyyy."-".$mm."-".$dd;
				}
				else {
					$cheque_dt = '';
				}
				
				$bank = trim($this->input->post('bank'));
				
				
				$data1 = array(
					'pay_status'	=> trim($this->input->post('pay_status')),
					'pay_name'	=> trim($this->input->post('pay_name')),
					'purpose' 	=> trim($this->input->post('purpose')),
					'cheque_no'     => $cheque_no,
					'cheque_dt'   	=> $cheque_dt,
					'bank'    		=> $bank,
				);
				$con['debit_voucher_id']=$debit_voucher_id;
				$this->cm->common_update('tbl_debit_voucher',$data1,$con);
				
				$particularsArr = $this->input->post('particulars');
				$bkdn_idArr 	= $this->input->post('bkdn_id');
				if(sizeof($bkdn_idArr)>0){	
					$inc=0;	
					foreach($bkdn_idArr as $bkdn_id){
						$particulars = $particularsArr[$inc];
						$data2 = array('particulars' => trim($particulars));
						$con['devoucher_bkdn_id']=$bkdn_id;
						$this->cm->common_update('tbl_devoucher_bkdn',$data2,$con);
						
					$inc++;	
					}
				}
				redirect('accounts/debit_voucher_list','refresh'); //irfans add
			}
		}
		
		
		$data['debit_voucher_row_edit'] = $this->Accounts_model->debit_voucher_row_edit($my_id,$id);
		$data['devoucher_bkdn_row_edit'] = $this->Accounts_model->devoucher_bkdn_row_edit($my_id,$id);
		$data['page']='accounts/debit_voucher_edit.php';
		$this->load->view('master',$data);
	}
	
	public function debit_voucher_delete($id){
		
		$this->db->trans_start();
		
		$this->db->query("DELETE FROM `tbl_debit_voucher` WHERE `debit_voucher_id`=$id");
		$this->db->query("DELETE FROM `tbl_devoucher_bkdn` WHERE `debit_voucher_id`=$id");
		$this->db->query("DELETE FROM `tbl_general_ledger` WHERE `debit_voucher_id`=$id");
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">X</a>Data has not been deleted. Please try again.</div>');
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">X</a>Data has been deleted.</div>');
		}
		redirect('accounts/debit_voucher_list','refresh'); 
	}
	
	public function debit_voucher_approve($id,$status){
		
		$this->db->trans_start();
		$this->db->query("UPDATE `tbl_debit_voucher` SET `approve`=$status WHERE `debit_voucher_id`=$id");
		$this->db->query("UPDATE `tbl_devoucher_bkdn` SET `approve`=$status WHERE `debit_voucher_id`=$id");
		$this->db->query("UPDATE `tbl_general_ledger` SET `approve`=$status WHERE `debit_voucher_id`=$id");
		$this->db->trans_complete();

		if ($this->db->trans_status() === FALSE)
		{
			$this->session->set_flashdata('message', '<div class="alert alert-danger"><a href="#" class="close" data-dismiss="alert">X</a>Data has not been saved. Please try again.</div>');
		}
		else
		{
			$this->session->set_flashdata('message', '<div class="alert alert-success"><a href="#" class="close" data-dismiss="alert">X</a>Data has been saved.</div>');
		}
		redirect('accounts/debit_voucher_list','refresh'); 
	}
	
	function debit_voucher_print($id){
		//ob_start();
		$my_id=1;
		$data['debit_voucher_row_edit'] = $this->Accounts_model->debit_voucher_row_edit($my_id,$id);
		$data['devoucher_bkdn_row_edit'] = $this->Accounts_model->devoucher_bkdn_row_edit($my_id,$id);
		$html = $this->load->view('accounts/debit_voucher_print', $data, true);
		//$html .= ob_get_clean();
		pdf_create($html, $data['debit_voucher_row_edit']["voucher_no"].'Voucher');
					//or
		//$data = pdf_create($html, '', false);
		//write_file('name', $data);
		//if you want to write it to disk and/or send it as an attachment   
	}
	
	/*----------------------------------- Credit Voucher --------------------------*/
	
	public function credit_voucher_entry(){
		$my_id = 1;
		$this->load->view('accounts/credit_voucher_entry');
	}		
	
	public function credit_voucher_list(){
		date_default_timezone_set('Asia/Dhaka');
		$my_id = 1;
		$insert_id=0;
		$rec_date   = date('Y-m-d H:i:s',time());
		
		if(isPostBack()){
			$this->form_validation->set_rules('pay_to', 'Please Type Pay To', 'trim|required|xss_clean|prep_for_form');
			$this->form_validation->set_rules('purpose', 'Please Type Purpose', 'trim|required|xss_clean|prep_for_form');
			$this->form_validation->set_rules('debit_sum', 'Total Debit Is Empty', 'trim|required|xss_clean|matches[credit_sum]');
			$this->form_validation->set_rules('debit_sum', 'Total Debit And Credit Are Not Equal', 'matches[credit_sum]');
			$this->form_validation->set_rules('credit_sum', 'Total Credit Is Empty', 'trim|required|xss_clean|prep_for_form');
			$this->form_validation->set_rules('particulars[]', 'Please Type Your Particulars', 'required|xss_clean|prep_for_form');
			$this->form_validation->set_rules('account_code[]', 'Please Insert Account Code', 'required|xss_clean|prep_for_form');
			$this->form_validation->set_rules('table_name[]', 'Table Name Not Found', 'required|xss_clean|prep_for_form');
			$this->form_validation->set_rules('table_id[]', 'Table Id Not Found', 'required|xss_clean|prep_for_form');
			
			if ($this->form_validation->run() == true)
			{
				$current_date=$this->input->post('current_date');
				if(!empty($current_date)){
					$current_date_tmp	= explode("/",$this->input->post('current_date'));
					$mm		= $current_date_tmp[0];
					$dd		= $current_date_tmp[1];
					$yyyy	= $current_date_tmp[2];
					$current_date = $yyyy."-".$mm."-".$dd;
				}
				else {
					$current_date    	= date('Y-m-d',time());
				}
				
				$pay_to			= trim($this->input->post('pay_to'));
				$purpose		= trim($this->input->post('purpose'));
				$debit_sum  	= trim($this->input->post('debit_sum'));
				$credit_sum  	= trim($this->input->post('credit_sum'));
				
				$cheque_no  	= trim($this->input->post('cheque_no'));
				
				$cheque_dt  	= $this->input->post('cheque_dt');
				if(!empty($cheque_dt)){
					$cheque_dt_tmp	= explode("/",$this->input->post('cheque_dt'));
					$mm		= $cheque_dt_tmp[0];
					$dd		= $cheque_dt_tmp[1];
					$yyyy	= $cheque_dt_tmp[2];
					$cheque_dt = $yyyy."-".$mm."-".$dd;
				}
				else {
					$cheque_dt    	= '';
				}
				
				$bank  			= trim($this->input->post('bank'));
				
				$voucher_no = $this->Accounts_model->create_voucher_no($my_id);
				
				if(!empty($voucher_no)){

					$data1 = array(
									'my_id'    	=> $my_id,
									'voucher_no'    => $voucher_no,
									'current_date'	=> $current_date,
									'pay_to'		=> $pay_to,
									'purpose'		=> $purpose,
									'debit_sum'    	=> $debit_sum,
									'credit_sum'    => $credit_sum,
									'cheque_no'     => $cheque_no,
									'cheque_dt'   	=> $cheque_dt,
									'bank'    		=> $bank,
									'rec_date'    	=> $rec_date
								);
					
					$insert_id = $this->cm->common_insert('tbl_credit_voucher',$data1);			
					
					if(!empty($insert_id) and $insert_id>0){
						
						$particularsArr		= $this->input->post('particulars');
						$account_codeArr	= $this->input->post('account_code');
						$table_nameArr    	= $this->input->post('table_name');
						$table_idArr 		= $this->input->post('table_id');
						$debitArr 			= $this->input->post('debit');
						$creditArr 			= $this->input->post('credit');
						$bkdn_idArr 		= $this->input->post('bkdn_id');
						
						if(sizeof($bkdn_idArr)>0){
							
							$inc=0;	
							foreach($bkdn_idArr as $bkdn_id){
								
								$insertid='';
								
								$particulars	= '';
								$account_code	= '';
								$table_name    	= '';
								$table_id 		= '';
								$debit 			= '';
								$credit 		= '';
								
								if(!empty($particularsArr[$inc])){$particulars = $particularsArr[$inc];}
								if(!empty($account_codeArr[$inc])){$account_code = $account_codeArr[$inc];}
								if(!empty($table_nameArr[$inc])){$table_name = $table_nameArr[$inc];}
								if(!empty($table_idArr[$inc])){$table_id = $table_idArr[$inc];}
								if(!empty($debitArr[$inc])){$debit = $debitArr[$inc];}
								if(!empty($creditArr[$inc])){$credit = $creditArr[$inc];}
								
								$data2 = array(
									'credit_voucher_id'  => $insert_id,
									'particulars'    	=> $particulars,
									'account_code'		=> $account_code,
									'table_name'		=> $table_name,
									'table_id'    		=> $table_id,
									'debit'    			=> $debit,
									'credit'    		=> $credit
								);
								
								$insertid = $this->cm->common_insert('tbl_crvoucher_bkdn',$data2);
								
								if(!empty($insertid) and $insertid>0){
								
								// Ledger part
								
								if($table_name=="tbl_fcoa_master"){$field_name="fcoa_master_id";}
								else if($table_name=="tbl_fcoa"){$field_name="fcoa_id";}
								else if($table_name=="tbl_fcoa_bkdn"){$field_name="fcoa_bkdn_id";}
								else if($table_name=="tbl_fcoa_bkdn_sub"){$field_name="fcoa_bkdn_sub_id";}
									
								if($debit>0 && empty($credit)){
									
									$journal_title=$particulars;
									$data3 = array(
													'journal_title' 	=> $journal_title,
													'dr'    			=> $debit,
													'rec_date'			=> $rec_date,
													'my_id'    		=> $my_id,
													'jv_id'    			=> $voucher_no,
													'credit_voucher_id'  => $insert_id,
													'crvoucher_bkdn_id' => $insertid,
													''.$field_name.''	=> $table_id
												);
									$this->cm->common_insert('tbl_general_ledger',$data3);
								}
								if(empty($debit) && $credit>0){
									$journal_title=$particulars;
									$data3 = array(
													'journal_title' 	=> $journal_title,
													'cr'    			=> $credit,
													'rec_date'			=> $rec_date,
													'my_id'    		    => $my_id,
													'jv_id'    			=> $voucher_no,
													'credit_voucher_id' => $insert_id,
													'crvoucher_bkdn_id' => $insertid,
													''.$field_name.''	=> $table_id
												);
									$this->cm->common_insert('tbl_general_ledger',$data3);
								}
								// Ledger part
								}
								$inc++;
							}
						}
					}
				}
				
			}// Validated
			else{
				redirect('accounts/credit_voucher_entry');
			}
		}// if Post Back
		$data['credit_voucher_list'] = $this->Accounts_model->credit_voucher_list($my_id);
		$this->load->view('accounts/credit_voucher_list', $data);	
	}

	public function credit_voucher_edit($id){
		$my_id = 1;

		if(isPostBack()){
			$this->form_validation->set_rules('pay_to', 'Please Type Pay To', 'trim|required|xss_clean|prep_for_form');
			$this->form_validation->set_rules('purpose', 'Please Type Purpose', 'trim|required|xss_clean|prep_for_form');
			$this->form_validation->set_rules('particulars[]', 'Please Type Your Particulars', 'required|xss_clean|prep_for_form');
			
			if ($this->form_validation->run() == true){
				$credit_voucher_id = $this->input->post('credit_voucher_id');
				
				$cheque_no  	= trim($this->input->post('cheque_no'));
				
				$cheque_dt  	= $this->input->post('cheque_dt');
				if(!empty($cheque_dt)){
					$cheque_dt_tmp	= explode("/",$this->input->post('cheque_dt'));
					$mm		= $cheque_dt_tmp[0];
					$dd		= $cheque_dt_tmp[1];
					$yyyy	= $cheque_dt_tmp[2];
					$cheque_dt = $yyyy."-".$mm."-".$dd;
				}
				else {
					$cheque_dt    	= '';
				}

				$bank  			= trim($this->input->post('bank'));

				$data1 = array(
					'pay_to'	=> trim($this->input->post('pay_to')),
					'purpose' 	=> trim($this->input->post('purpose')),
					'cheque_no'     => $cheque_no,
					'cheque_dt'   	=> $cheque_dt,
					'bank'    		=> $bank,
				);
							$con['credit_voucher_id']=$credit_voucher_id;
				if($this->cm->common_update('tbl_credit_voucher',$data1,$con)==1){
					
				}

				$particularsArr = $this->input->post('particulars');
				$bkdn_idArr 	= $this->input->post('bkdn_id');
				if(sizeof($bkdn_idArr)>0){
					$inc=0;	
					foreach($bkdn_idArr as $bkdn_id){
						$particulars = $particularsArr[$inc];
						$data2 = array('particulars' => trim($particulars));
						$con['crvoucher_bkdn_id']=$bkdn_id;
						$this->cm->common_update('tbl_crvoucher_bkdn',$data2,$con);
						$inc++;	
					}
				}
			}
		}

		$data['credit_voucher_row_edit'] = $this->Accounts_model->credit_voucher_row_edit($my_id,$id);
		$data['crvoucher_bkdn_row_edit'] = $this->Accounts_model->crvoucher_bkdn_row_edit($my_id,$id);
		$this->load->view('accounts/credit_voucher_edit',$data);
	}

	public function credit_voucher_print($id){	
		//ob_start();
		$my_id=1;
		$data['credit_voucher_row_edit'] = $this->Accounts_model->credit_voucher_row_edit($my_id,$id);
		$data['crvoucher_bkdn_row_edit'] = $this->Accounts_model->crvoucher_bkdn_row_edit($my_id,$id);
		$html = $this->load->view('accounts/credit_voucher_print', $data, true);
		//$html .= ob_get_clean();
		pdf_create($html, 'Credit_Voucher');
					//or
		//$data = pdf_create($html, '', false);
		//write_file('name', $data);
		//if you want to write it to disk and/or send it as an attachment   			
	}
		
	public function trial_balance($rec_date=false){
		
		date_default_timezone_set('Asia/Dhaka');
		$my_id = 1;
		$insert_id=0;
		$data['my_id'] = $my_id;
		
		$this->account->get_chart_of_account($my_id,$rec_date);
		$data['coahead'] = $this->account->coahead;
		
		/*model method can direct access to controller 
		because this model include into lib */
		$data['page']='accounts/trial_balance.php';
			$this->load->view('master',$data);
		//$this->load->view('accounts/trial_balance',$data);
	}
}
