<?php

namespace App\Controllers;

use CodeIgniter\Database\Config;
use CodeIgniter\I18n\Time;
use Config\Services;

class CheckoutController extends BaseController
{
    private $db;
    private $productModel;

    public function __construct() {
        $this->db = db_connect();
        $this->orderModel = model("productModel");

    }

    public function show()
    {
        $db         = \Config\Database::connect();

		$array = explode(",", $_POST['dataValue']);

		// 각 요소에 작은따옴표 추가
		$quotedArray = array_map(function($item) {
			return "'" . $item . "'";
		}, $array);

		// 배열을 다시 문자열로 변환
		$output = implode(',', $quotedArray);
 
		$sql = "SELECT 
				tbl_order_mst.*, SUM(tbl_order_mst.order_price) AS payment_price, 
				GROUP_CONCAT(CONCAT(tbl_order_option.option_name, ':', tbl_order_option.option_cnt) SEPARATOR '|') as options
				FROM 
					tbl_order_mst
				LEFT JOIN 
					tbl_order_option 
				ON 
					tbl_order_mst.order_idx = tbl_order_option.order_idx
				WHERE tbl_order_mst.order_no IN(". $output .") AND order_no != '' 
				GROUP BY 
					tbl_order_mst.order_no ";
		$result = $db->query($sql)->getResultArray();

		$payment_no            = "P_". date('YmdHis') . rand(100, 999); 				// 가맹점 결제번호
		
        return view("checkout/show", [
            "result"     => $result,
			"payment_no" => $payment_no
        ]);
    }

    public function confirm()
    {
        $db     = \Config\Database::connect();

        $session    =  Services::session();
        $memberIdx  =  $session->get('member')['idx'] ?? null;

        $m_idx      =  $memberIdx;
        $payment_no =  updateSQ($this->request->getPost('payment_no'));				// 가맹점 결제번호
		$order_no 	=  updateSQ($this->request->getPost('dataValue'));				// 가맹점 주문번호

		$array = explode(",", $order_no);
        for($i=0;$i<count($array);$i++)
        {
             if($i == 0) {
				$sql_p = " SELECT * from tbl_order_mst WHERE order_no = '" . $array[$i]. "'";
				$row_p = $db->query($sql_p)->getRowArray();
                $product_name = $row_p['product_name'];
				write_log($sql_p ." - ". $product_name);
             }
        }
          
        if(count($array) > 1) {
		   $product_name .= " 외 ". (count($array)-1) ."개";
		}
		
        $payment_price  	= updateSQ($this->request->getPost('payment_price'));

        $payment_user_name  = updateSQ($this->request->getPost('order_user_name'));
        $payment_user_name  = encryptField($payment_user_name, "encode");

        $companion_gender   = updateSQ($this->request->getPost('companion_gender'));

        $payment_user_first_name_en = updateSQ($this->request->getPost('order_user_first_name_en'));
        $payment_user_first_name_en = encryptField($payment_user_first_name_en, "encode");

		$payment_user_last_name_en  = updateSQ($this->request->getPost('order_user_last_name_en'));
        $payment_user_last_name_en  = encryptField($payment_user_last_name_en, "encode");

        $email_1      = updateSQ($this->request->getPost('email_1'));
        $email_2      = updateSQ($this->request->getPost('email_2'));
		$payment_user_email = $email_1 ."@". $email_2;
        $payment_user_email = encryptField($payment_user_email, "encode");

		$phone_1      = updateSQ($this->request->getPost('phone_1'));
        $phone_2      = updateSQ($this->request->getPost('phone_2'));	
        $phone_3      = updateSQ($this->request->getPost('phone_3'));
		$payment_user_mobile = $phone_1 ."-". $phone_2 ."-". $phone_3;
        $payment_user_mobile  = encryptField($payment_user_mobile, "encode");

		$payment_user_gender= updateSQ($this->request->getPost('companion_gender'));
        $phone_thai   = updateSQ($this->request->getPost('phone_thai'));
        $phone_thai   = encryptField($phone_thai, "encode");

        $local_phone1 = updateSQ($this->request->getPost('local_phone1'));
        $local_phone2 = updateSQ($this->request->getPost('local_phone2'));
        $local_phone  = $local_phone1 ."-". $local_phone2;
        $local_phone  = encryptField($local_phone, "encode");

        $payment_memo = updateSQ($this->request->getPost('order_memo'));
        $payment_date = Time::now('Asia/Seoul', 'en_US');

        $sql = " SELECT COUNT(payment_idx) AS cnt from tbl_payment_mst WHERE payment_no = '" . $payment_no . "'";
		write_log($sql);
        $row = $db->query($sql)->getRowArray();

        if($row['cnt'] == 0) {
				$sql = "INSERT INTO tbl_payment_mst SET m_idx                      = '". $m_idx ."'
													   ,payment_no                 = '". $payment_no ."'
													   ,order_no                   = '". $order_no ."'
													   ,product_name               = '". $product_name ."'
													   ,payment_date               = '". $payment_date ."'
													   ,payment_price              = '". $payment_price ."'
													   ,payment_user_name          = '". $payment_user_name ."'
													   ,payment_user_first_name_en = '". $payment_user_first_name_en ."'	
													   ,payment_user_last_name_en  = '". $payment_user_last_name_en ."'	
													   ,payment_user_email         = '". $payment_user_email ."'
													   ,payment_user_mobile        = '". $payment_user_mobile ."'
													   ,payment_user_phone         = '". $payment_user_phone ."'
													   ,local_phone                = '". $local_phone ."'	
													   ,payment_user_gender        = '". $payment_user_gender ."'
													   ,phone_thai                 = '". $phone_thai ."'
													   ,payment_memo               = '". $payment_memo ."' ";
				write_log($sql);
				$result = $db->query($sql);
        }

		if ($m_idx)
		{
			$sql_m	  = " SELECT * from tbl_member WHERE m_idx = '". $m_idx ."' ";
			$row_m    = $db->query($sql_m)->getRowArray();
			$mileage  = $row_m["mileage"];
			if ($mileage == "") {
				$mileage = 0;
			}

		}

// 쿼리 빌더 생성
$builder = $db->table('tbl_coupon c');

// JOIN 처리
$builder->select('c.c_idx, c.coupon_num, s.coupon_name, s.coupon_pe, s.coupon_price, s.dex_price_pe');
$builder->join('tbl_coupon_setting s', 'c.coupon_type = s.idx', 'left');
$builder->join('tbl_coupon_history h', 'c.c_idx = h.used_coupon_idx', 'left');

// 조건 처리
$builder->where('c.status', 'N');
$builder->where('c.enddate >', 'CURDATE()', false); // 'false'는 함수로 처리
$builder->where('c.usedate', '');
$builder->where('c.user_id', $session->get("member")["id"]);
$builder->where('h.used_coupon_idx IS NULL', null, false); // NULL 조건 처리

// GROUP BY 처리
$builder->groupBy('c.c_idx');

// 쿼리 실행
$query = $builder->get();
$resultCoupon = $query->getResultArray(); // 결과 배열 반환

        $data = [
            'product_name' => $product_name,
            'payment_no'   => $payment_no,
            'dataValue'    => $ordert_no,
            'resultCoupon' => $resultCoupon,
            'point'        => $mileage
        ];

        return view('checkout/confirm', $data);
    }

    public function bank()
    {
        return view('checkout/bank');
    }

    public function confirm_order()
    {
        return view('checkout/confirm_order', ['return_url' => '/']) ;
    }
}
