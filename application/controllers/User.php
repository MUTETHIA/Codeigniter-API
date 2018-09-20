<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('users_model');
		//include modal.php in views
		$this->inc['modal'] = $this->load->view('modal', '', true);
	}
	public function index(){
		$this->load->view('show', $this->inc);
	}

	public function show(){
		$data = $this->users_model->show();
	   //	$output = array();
       $count=1;
		foreach($data as $row){
			?>
			<tr>
			    <td><?php echo $count; ?></td>
				<td><?php echo $row->first_name; ?></td>
                <td><?php echo $row->last_name; ?></td>
                <td><?php echo $row->email; ?></td>
				<td><?php echo $row->phone; ?></td>
				<td>
					<button class="btn btn-warning edit" data-id="<?php echo $row->id; ?>"><span class="glyphicon glyphicon-edit"></span> Edit</button> ||
					<button class="btn btn-danger delete" data-id="<?php echo $row->id; ?>"><span class="glyphicon glyphicon-trash"></span> Delete</button>
				</td>
			</tr>
			<?php
            $count++;
		}
	}

	public function insert(){
        $user=array(
          'first_name'=>$_POST['fname'],
          'last_name'=>$_POST['lname'],
          'email'=>$_POST['email'],
          'phone'=>$_POST['phone'],
          'created'=>date('Y-m-d h:i:s'),
          'modified'=>date('Y-m-d h:i:s'),
          'status'=>1
        );
		
		$query = $this->users_model->insert($user);
	}

	public function getuser(){
		$id = $_POST['id'];
		$data = $this->users_model->getuser($id);
		echo json_encode($data);
	}

	public function update(){
		$id = $_POST['id'];
	  $user=array(
          'first_name'=>$_POST['fname'],
          'last_name'=>$_POST['lname'],
          'email'=>$_POST['email'],
          'phone'=>$_POST['phone'],
          'modified'=>date('Y-m-d h:i:s'),
          'status'=>1
        );

		$query = $this->users_model->updateuser($user, $id);
	}

	public function delete(){
		$id = $_POST['id'];
		$query = $this->users_model->delete($id);
	}


    public function process_callback(){
         header("Content-Type:application/json");
           if(!isset($_GET['token'])){
               echo "Technical error";
               exit();
           }

           if($_GET['token']!='engineer'){
               echo "Invalid authorization";
               exit();
           }
        $callbackJSONData=file_get_contents('php://input');
        $callbackData=json_decode($callbackJSONData);
        $transactionType=$callbackData->TransactionType;
        $transID=$callbackData->TransID;
        $transTime=$callbackData->TransTime;
        $transAmount=$callbackData->TransAmount;
        $businessShortCode=$callbackData->BusinessShortCode;
        $billRefNumber=$callbackData->BillRefNumber;
        $invoiceNumber=$callbackData->InvoiceNumber;
        $thirdPartyTransID=$callbackData->ThirdPartyTransID;
        $MSISDN=$callbackData->MSISDN;
        $firstName=$callbackData->FirstName;
        $middleName=$callbackData->MiddleName;
        $lastName=$callbackData->LastName;


      if($transAmount!=500){
       $resultdesc='Cancel';
        echo '{"ResultCode":1, "ResultDesc":"'. $resultdesc.'", "ThirdPartyTransID": 0}';
      }
      else{
        $resultdesc='Accept Payment';
        echo '{"ResultCode":0, "ResultDesc":"'. $resultdesc.'", "ThirdPartyTransID": 0}';
      }


    }

}
