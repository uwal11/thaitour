<?php

namespace App\Controllers;

use Mpdf\Mpdf;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfController extends BaseController
{
    private $db;
    private $productModel;
    private $roomImg;
    private $CodeModel;


    public function __construct() {
        $this->db           = db_connect();
        $this->productModel = model("ProductModel");
        $this->roomImg      = model("RoomImg");
        $this->CodeModel    = model("Code");
    }
	
    public function generateQuotation()
    {
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => [FCPATH . 'ttfonts'], // 폰트 폴더 추가
            'default_font' => 'nanumgothic',
            'fontdata' => [
                'nanumgothic' => [
                    'R' => 'NanumGothic.ttf',
                    'B' => 'NanumGothicBold.ttf',
                ]
            ]
        ]);

		$group_no = $this->request->getVar('group_no');

		$db = \Config\Database::connect();

		// 요약 정보 (상품 코드별 집계)
		$sql = "SELECT code_name, 
					   COUNT(order_idx) AS cnt,
					   SUM(real_price_bath) AS total_bath,
					   SUM(real_price_won) AS total_won
				FROM tbl_order_mst
				WHERE group_no = ?
				GROUP BY code_name";

		$sum = $db->query($sql, [$group_no])->getResultArray();

		// ① 그룹 해당 예약 목록
		$items = $db->query("SELECT * FROM tbl_order_mst WHERE group_no = ?", [$group_no])->getResultArray();

		$data = [
			'group_no' => $group_no,
			'sum'      => $sum,
			'items'    => $items
		];

		$html = view('pdf/quotation', $data);

        $pdf->WriteHTML($html);
		
        $pdf->Output('quotation.pdf', 'I');
        exit;
    }

    public function invoiceHotel()
    {
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => [FCPATH . 'ttfonts'], // 폰트 폴더 추가
            'default_font' => 'nanumgothic',
            'fontdata' => [
                'nanumgothic' => [
                    'R' => 'NanumGothic.ttf',
                    'B' => 'NanumGothicBold.ttf',
                ]
            ]
        ]);

		$order_idx = $this->request->getVar('order_idx');

        $private_key = private_key();
		
		$db      = db_connect(); // DB 연결
		$builder = $db->table('tbl_order_mst'); // 테이블 지정
		$builder->select(" *,
			AES_DECRYPT(UNHEX(order_user_name), '$private_key') AS order_user_name,
			AES_DECRYPT(UNHEX(order_user_email), '$private_key') AS order_user_email,
			AES_DECRYPT(UNHEX(order_user_first_name_en), '$private_key') AS order_user_first_name_en,
			AES_DECRYPT(UNHEX(order_user_last_name_en), '$private_key') AS order_user_last_name_en,
			AES_DECRYPT(UNHEX(order_user_mobile), '$private_key') AS order_user_mobile,
			AES_DECRYPT(UNHEX(local_phone), '$private_key') AS local_phone,
			AES_DECRYPT(UNHEX(order_zip), '$private_key') AS order_zip,
			AES_DECRYPT(UNHEX(order_addr1), '$private_key') AS order_addr1,
			AES_DECRYPT(UNHEX(order_addr2), '$private_key') AS order_addr2,
			AES_DECRYPT(UNHEX(manager_name), '$private_key') AS manager_name
		");		
		$query   = $builder->where('order_idx', $order_idx)->get(); // 조건 추가 후 실행

		$result  = $query->getResult(); // 결과 가져오기 (객체 배열)

        $builder = $db->table('tbl_policy_info');
		$policy = $builder->whereIn('p_idx', [24, 26])
							->orderBy('p_idx', 'asc')
							->get()->getResultArray();

		$html = view('pdf/invoice_hotel', [
            'result' => $result,
            'policy_1' 	=> $policy[0],
        ]);

        $pdf->WriteHTML($html);
		
        $pdf->Output('invoice_hotel.pdf', 'I');
        exit;
    }

    public function invoiceGolf()
    {
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => [FCPATH . 'ttfonts'], // 폰트 폴더 추가
            'default_font' => 'nanumgothic',
            'fontdata' => [
                'nanumgothic' => [
                    'R' => 'NanumGothic.ttf',
                    'B' => 'NanumGothicBold.ttf',
                ]
            ]
        ]);

		$order_idx = $this->request->getVar('order_idx');

        $private_key = private_key();
		$db = db_connect(); // DB 연결

		$builder = $db->table('tbl_order_mst');
		$builder->select(" *,
			AES_DECRYPT(UNHEX(order_user_name), '$private_key') AS order_user_name,
			AES_DECRYPT(UNHEX(order_user_email), '$private_key') AS order_user_email,
			AES_DECRYPT(UNHEX(order_user_first_name_en), '$private_key') AS order_user_first_name_en,
			AES_DECRYPT(UNHEX(order_user_last_name_en), '$private_key') AS order_user_last_name_en,
			AES_DECRYPT(UNHEX(order_user_mobile), '$private_key') AS order_user_mobile,
			AES_DECRYPT(UNHEX(local_phone), '$private_key') AS local_phone,
			AES_DECRYPT(UNHEX(order_zip), '$private_key') AS order_zip,
			AES_DECRYPT(UNHEX(order_addr1), '$private_key') AS order_addr1,
			AES_DECRYPT(UNHEX(order_addr2), '$private_key') AS order_addr2,
			AES_DECRYPT(UNHEX(manager_name), '$private_key') AS manager_name
		");

		$query  = $builder->where('order_idx', $order_idx)->get();
		$result = $query->getResultArray();
		$row    = $result[0];

        $query1     = $db->query("SELECT * FROM tbl_order_option WHERE order_idx = '". $order_idx ."' AND option_type = 'main' ");
		$order_info = $query1->getRowArray();

		// 기타 옵션
		$query2      = $db->query("SELECT * FROM tbl_order_option WHERE order_idx = '". $order_idx ."' AND option_type != 'main' ");
		$golf_option = $query2->getResultArray();

        $product_idx = $row["product_idx"];

		$builder = $db->table('tbl_product_mst');
		$builder->select("notice_comment");
		$query  = $builder->where('product_idx', $product_idx)->get();
		$result = $query->getRowArray();
		$notice_contents = $result["notice_comment"];

		$builder = $db->table('tbl_policy_cancel');
		$builder->select("policy_contents");
		$query  = $builder->where('product_idx', $product_idx)->get();
		$result = $query->getRowArray();
		$cancle_contents = $result["policy_contents"];

		$html = view('pdf/invoice_golf', [
            'row'         => $row,
			'golf_info'   => $order_info,
			'golf_option' => $golf_option,
            'notice_contents' => $notice_contents,
			'cancle_contents' => $cancle_contents
        ]);

        $pdf->WriteHTML($html);
		
        $pdf->Output('invoice_golf.pdf', 'I');
        exit;
    }

    public function invoiceTour()
    {
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => [FCPATH . 'ttfonts'], // 폰트 폴더 추가
            'default_font' => 'nanumgothic',
            'fontdata' => [
                'nanumgothic' => [
                    'R' => 'NanumGothic.ttf',
                    'B' => 'NanumGothicBold.ttf',
                ]
            ]
        ]);

		$order_idx = $this->request->getVar('order_idx');

        $private_key = private_key();

        $db = db_connect(); // DB 연결

        // 주문 정보 가져오기
        $builder = $db->table('tbl_order_mst');
        $builder->select("
            *,
            AES_DECRYPT(UNHEX(order_user_name), '$private_key') AS order_user_name,
            AES_DECRYPT(UNHEX(order_user_email), '$private_key') AS order_user_email,
            AES_DECRYPT(UNHEX(order_user_first_name_en), '$private_key') AS order_user_first_name_en,
            AES_DECRYPT(UNHEX(order_user_last_name_en), '$private_key') AS order_user_last_name_en,
            AES_DECRYPT(UNHEX(order_user_mobile), '$private_key') AS order_user_mobile,
            AES_DECRYPT(UNHEX(local_phone), '$private_key') AS local_phone,
            AES_DECRYPT(UNHEX(order_zip), '$private_key') AS order_zip,
            AES_DECRYPT(UNHEX(order_addr1), '$private_key') AS order_addr1,
            AES_DECRYPT(UNHEX(order_addr2), '$private_key') AS order_addr2,
            AES_DECRYPT(UNHEX(manager_name), '$private_key') AS manager_name
        ");
        $query = $builder->where('order_idx', $order_idx)->get();
        $orderResult = $query->getResult(); // 주문 데이터 (객체 배열)

        // 옵션 정보 가져오기
        $builder = $db->table('tbl_order_option');
        $builder->select("option_name, option_tot, option_cnt, option_date, option_qty, baht_thai");
        $query = $builder->where('order_idx', $order_idx)->get();
        $optionResult = $query->getResult(); // 옵션 데이터 (객체 배열)

        // 주문 객체에 옵션 정보 추가
        foreach ($orderResult as $order) {
            $order->options = $optionResult; // options 키에 옵션 배열 추가
        }

        $firstRow = $orderResult[0] ?? null;

        $product_idx = $firstRow->product_idx;

        $builder = $db->table('tbl_product_mst');
        $builder->select("notice_comment");
        $query  = $builder->where('product_idx', $product_idx)->get();
        $result = $query->getRowArray();
        $notice_contents = $result["notice_comment"];

        $builder = $db->table('tbl_policy_cancel');
        $builder->select("policy_contents");
        $query  = $builder->where('product_idx', $product_idx)->get();
        $result = $query->getRowArray();
        $cancle_contents = $result["policy_contents"];

		$html = view('pdf/invoice_tour', [
            'result' => $orderResult,
            'notice_contents' => $notice_contents,
            'cancle_contents' => $cancle_contents
        ]);
        

        $pdf->WriteHTML($html);
		
        $pdf->Output('invoice_tour.pdf', 'I');
        exit;
    }

    public function invoiceTicket()
    {
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => [FCPATH . 'ttfonts'], // 폰트 폴더 추가
            'default_font' => 'nanumgothic',
            'fontdata' => [
                'nanumgothic' => [
                    'R' => 'NanumGothic.ttf',
                    'B' => 'NanumGothicBold.ttf',
                ]
            ]
        ]);

		$order_idx = $this->request->getVar('order_idx');

        $private_key = private_key();

        $db = db_connect(); // DB 연결

        // 주문 정보 가져오기
        $builder = $db->table('tbl_order_mst');
        $builder->select("
            *,
            AES_DECRYPT(UNHEX(order_user_name), '$private_key') AS order_user_name,
            AES_DECRYPT(UNHEX(order_user_email), '$private_key') AS order_user_email,
            AES_DECRYPT(UNHEX(order_user_first_name_en), '$private_key') AS order_user_first_name_en,
            AES_DECRYPT(UNHEX(order_user_last_name_en), '$private_key') AS order_user_last_name_en,
            AES_DECRYPT(UNHEX(order_user_mobile), '$private_key') AS order_user_mobile,
            AES_DECRYPT(UNHEX(local_phone), '$private_key') AS local_phone,
            AES_DECRYPT(UNHEX(order_zip), '$private_key') AS order_zip,
            AES_DECRYPT(UNHEX(order_addr1), '$private_key') AS order_addr1,
            AES_DECRYPT(UNHEX(order_addr2), '$private_key') AS order_addr2,
            AES_DECRYPT(UNHEX(manager_name), '$private_key') AS manager_name
        ");
        $query = $builder->where('order_idx', $order_idx)->get();
        //write_log("last query- " . $db->getLastQuery());
        $orderResult = $query->getResult(); // 주문 데이터 (객체 배열)

        // 옵션 정보 가져오기
        $builder = $db->table('tbl_order_option');
        $builder->select("option_name, option_tot, option_cnt, option_date, option_qty, baht_thai");
        $query = $builder->where('order_idx', $order_idx)->get();
        $optionResult = $query->getResult(); // 옵션 데이터 (객체 배열)

        // 주문 객체에 옵션 정보 추가
        foreach ($orderResult as $order) {
            $order->options = $optionResult; // options 키에 옵션 배열 추가
        }

        $firstRow = $orderResult[0] ?? null;

        $product_idx = $firstRow->product_idx;

        $builder = $db->table('tbl_product_mst');
        $builder->select("notice_comment");
        $query  = $builder->where('product_idx', $product_idx)->get();
        $result = $query->getRowArray();
        $notice_contents = $result["notice_comment"];

        $builder = $db->table('tbl_policy_cancel');
        $builder->select("policy_contents");
        $query  = $builder->where('product_idx', $product_idx)->get();
        $result = $query->getRowArray();
        $cancle_contents = $result["policy_contents"];

		$html = view('pdf/invoice_ticket', [
            'result' => $orderResult,
            'notice_contents' => $notice_contents,
            'cancle_contents' => $cancle_contents
        ]);
        

        $pdf->WriteHTML($html);
		
        $pdf->Output('invoice_ticket.pdf', 'I');
        exit;
    }

    public function invoiceCar()
    {
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => [FCPATH . 'ttfonts'], // 폰트 폴더 추가
            'default_font' => 'nanumgothic',
            'fontdata' => [
                'nanumgothic' => [
                    'R' => 'NanumGothic.ttf',
                    'B' => 'NanumGothicBold.ttf',
                ]
            ]
        ]);

		$order_idx = $this->request->getVar('order_idx');

        $private_key = private_key();

        $db = db_connect(); // DB 연결

        // 주문 정보 가져오기
        $builder = $db->table('tbl_order_mst');
        $builder->select("
            *,
            AES_DECRYPT(UNHEX(order_user_name), '$private_key') AS order_user_name,
            AES_DECRYPT(UNHEX(order_user_email), '$private_key') AS order_user_email,
            AES_DECRYPT(UNHEX(order_user_first_name_en), '$private_key') AS order_user_first_name_en,
            AES_DECRYPT(UNHEX(order_user_last_name_en), '$private_key') AS order_user_last_name_en,
            AES_DECRYPT(UNHEX(order_user_mobile), '$private_key') AS order_user_mobile,
            AES_DECRYPT(UNHEX(local_phone), '$private_key') AS local_phone,
            AES_DECRYPT(UNHEX(order_zip), '$private_key') AS order_zip,
            AES_DECRYPT(UNHEX(order_addr1), '$private_key') AS order_addr1,
            AES_DECRYPT(UNHEX(order_addr2), '$private_key') AS order_addr2,
            AES_DECRYPT(UNHEX(manager_name), '$private_key') AS manager_name
        ");
        $query = $builder->where('order_idx', $order_idx)->get();
        $orderResult = $query->getResult(); // 주문 데이터 (객체 배열)

        // 옵션 정보 가져오기
        $builder = $db->table('tbl_order_option');
        $builder->select("option_name, option_tot, option_cnt, option_date, option_qty, baht_thai");
        $query = $builder->where('order_idx', $order_idx)->get();
        $optionResult = $query->getResult(); // 옵션 데이터 (객체 배열)

        // 주문 객체에 옵션 정보 추가
        foreach ($orderResult as $order) {
            $order->options = $optionResult; // options 키에 옵션 배열 추가
        }

        $firstRow = $orderResult[0] ?? null;

        $product_idx = $firstRow->product_idx;

        $builder = $db->table('tbl_product_mst');
        $builder->select("product_info");
        $query  = $builder->where('product_idx', $product_idx)->get();
        $result = $query->getRowArray();
        $notice_contents = $result["product_info"];

        $builder = $db->table('tbl_policy_cancel');
        $builder->select("policy_contents");
        $query  = $builder->where('product_idx', $product_idx)->get();
        $result = $query->getRowArray();
        $cancle_contents = $result["policy_contents"];

		$html = view('pdf/invoice_car', [
            'result' => $orderResult,
            'notice_contents' => $notice_contents,
            'cancle_contents' => $cancle_contents
        ]);
        

        $pdf->WriteHTML($html);
		
        $pdf->Output('invoice_car.pdf', 'I');
        exit;
    }

    public function invoiceGuide()
    {
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => [FCPATH . 'ttfonts'], // 폰트 폴더 추가
            'default_font' => 'nanumgothic',
            'fontdata' => [
                'nanumgothic' => [
                    'R' => 'NanumGothic.ttf',
                    'B' => 'NanumGothicBold.ttf',
                ]
            ]
        ]);

		$order_idx = $this->request->getVar('order_idx');

        $private_key = private_key();

        $db = db_connect(); // DB 연결

        // 주문 정보 가져오기
        $builder = $db->table('tbl_order_mst');
        $builder->select("
            *,
            AES_DECRYPT(UNHEX(order_user_name), '$private_key') AS order_user_name,
            AES_DECRYPT(UNHEX(order_user_email), '$private_key') AS order_user_email,
            AES_DECRYPT(UNHEX(order_user_first_name_en), '$private_key') AS order_user_first_name_en,
            AES_DECRYPT(UNHEX(order_user_last_name_en), '$private_key') AS order_user_last_name_en,
            AES_DECRYPT(UNHEX(order_user_mobile), '$private_key') AS order_user_mobile,
            AES_DECRYPT(UNHEX(local_phone), '$private_key') AS local_phone,
            AES_DECRYPT(UNHEX(order_zip), '$private_key') AS order_zip,
            AES_DECRYPT(UNHEX(order_addr1), '$private_key') AS order_addr1,
            AES_DECRYPT(UNHEX(order_addr2), '$private_key') AS order_addr2,
            AES_DECRYPT(UNHEX(manager_name), '$private_key') AS manager_name
        ");
        $query = $builder->where('order_idx', $order_idx)->get();
        //write_log("last query- " . $db->getLastQuery());
        $orderResult = $query->getResult(); // 주문 데이터 (객체 배열)

        // 옵션 정보 가져오기
        $builder = $db->table('tbl_order_option');
        $builder->select("option_name, option_tot, option_cnt, option_date, option_qty, baht_thai");
        $query = $builder->where('order_idx', $order_idx)->get();
        $optionResult = $query->getResult(); // 옵션 데이터 (객체 배열)

        // 주문 객체에 옵션 정보 추가
        foreach ($orderResult as $order) {
            $order->options = $optionResult; // options 키에 옵션 배열 추가
        }

        $firstRow = $orderResult[0] ?? null;

        $product_idx = $firstRow->product_idx;

        $builder = $db->table('tbl_product_mst');
        $builder->select("product_info");
        $query  = $builder->where('product_idx', $product_idx)->get();
        $result = $query->getRowArray();
        $notice_contents = $result["product_info"];

        $builder = $db->table('tbl_policy_cancel');
        $builder->select("policy_contents");
        $query  = $builder->where('product_idx', $product_idx)->get();
        $result = $query->getRowArray();
        $cancle_contents = $result["policy_contents"];

		$html = view('pdf/invoice_guide', [
            'result' => $orderResult,
            'notice_contents' => $notice_contents,
            'cancle_contents' => $cancle_contents
        ]);
        
        $pdf->WriteHTML($html);
		
        $pdf->Output('invoice_guide.pdf', 'I');
        exit;
    }

    public function voucherHotel()
    {
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => [FCPATH . 'ttfonts'], // 폰트 폴더 추가
            'default_font' => 'nanumgothic',
            'fontdata' => [
                'nanumgothic' => [
                    'R' => 'NanumGothic.ttf',
                    'B' => 'NanumGothicBold.ttf',
                ]
            ]
        ]);

		$order_idx = $this->request->getVar('order_idx');
		$type = $this->request->getVar('type'); 

        $private_key = private_key(); // 복호화 키

		$db = db_connect();
		$builder = $db->table('tbl_order_mst a');

		$builder->select("
					a.*, b.*, c.*,
					AES_DECRYPT(UNHEX(a.order_user_name), '$private_key') AS order_user_name,
					AES_DECRYPT(UNHEX(a.order_user_name_new), '$private_key') AS order_user_name_new,
					AES_DECRYPT(UNHEX(a.order_user_name_en_new), '$private_key') AS order_user_name_en_new,
					AES_DECRYPT(UNHEX(a.order_user_email), '$private_key') AS order_user_email,
					AES_DECRYPT(UNHEX(a.order_user_first_name_en), '$private_key') AS order_user_first_name_en,
					AES_DECRYPT(UNHEX(a.order_user_last_name_en), '$private_key') AS order_user_last_name_en,
					AES_DECRYPT(UNHEX(a.order_user_mobile), '$private_key') AS order_user_mobile,
					AES_DECRYPT(UNHEX(a.order_user_mobile_new), '$private_key') AS order_user_mobile_new,
					AES_DECRYPT(UNHEX(a.local_phone), '$private_key') AS local_phone,
					AES_DECRYPT(UNHEX(a.order_zip), '$private_key') AS order_zip,
					AES_DECRYPT(UNHEX(a.order_addr1), '$private_key') AS order_addr1,
					AES_DECRYPT(UNHEX(a.order_addr2), '$private_key') AS order_addr2,
					AES_DECRYPT(UNHEX(a.manager_name), '$private_key') AS manager_name
		");

		$builder->join('tbl_product_mst b', 'a.product_idx = b.product_idx', 'left');
		$builder->join('tbl_product_stay c', 'b.stay_idx = c.stay_idx', 'left');
		$builder->where('a.order_idx', $order_idx);

		$query  = $builder->get();
		$result = $query->getRow();

        $builder = $db->table('tbl_policy_info');
		$policy = $builder->whereIn('p_idx', [23])
							->orderBy('p_idx', 'asc')
							->get()->getResultArray();

        $arr_req = array_filter(explode("|", $result->additional_request ?? ''), fn($v) => trim($v) !== '');
		$arr_text_req = [];
		$arr_text_req_en = [];

		foreach($arr_req as $code){
			$row_code = $this->CodeModel->getByCodeNo($code);
			$code_name = $row_code["code_name"];
			$code_name_en = $row_code["code_name_en"];
			array_push($arr_text_req, $code_name);
			array_push($arr_text_req_en, $code_name_en);
		}

		$str_req = implode(", ", $arr_text_req);
		$str_req_en = implode(", ", $arr_text_req_en);

        if($type == "admin"){
			$user_name = $result->order_user_name;
			$user_name_en = $result->order_user_first_name_en . " " . $result->order_user_last_name_en;
			$user_mobile = $result->order_user_mobile;
			$order_date = date('d-M-Y(D)', strtotime($result->start_date)) 
						. " " .date('d-M-Y(D)', strtotime($result->end_date))
						. " / ".$result->order_day_cnt." night";
			$room_type = $result->room_type_eng;
			$bed_type = $result->bed_type_eng;
			$order_room_cnt = $result->order_room_cnt;
			$order_people = ($result->adult + $result->kids)  . "Adult(s)";
			$order_memo = $result->admin_memo;
			$breakfast = $result->breakfast == "N" ? "Include (No) Adult Breakfast" : "Include (Yes) Adult Breakfast";
			$guest_request = $str_req;
			$order_remark = $result->custom_req_eng;

		}else{
			if(!empty($result->order_user_name_new)){
				$user_name = $result->order_user_name_new;
			}else{
				$user_name = $result->order_user_name;
			}

			if(!empty($result->order_user_name_en_new)){
				$user_name_en = $result->order_user_name_en_new;
			}else{
				$user_name_en = $result->order_user_first_name_en . " " . $result->order_user_last_name_en;
			}

			if(!empty($result->order_user_name_new)){
				$user_mobile = $result->order_user_mobile_new;
			}else{
				$user_mobile = $result->order_user_mobile;
			}

			if(!empty($result->order_date_new)){
				$order_date = $result->order_date_new;
			}else{
				$order_date = date('d-M-Y(D)', strtotime($result->start_date)) 
						. " " .date('d-M-Y(D)', strtotime($result->end_date))
						. " / ".$result->order_day_cnt." night";
			}

			if(!empty($result->room_type_new)){
				$room_type = $result->room_type_new;
			}else{
				$room_type = $result->room_type_eng;
			}

			if(!empty($result->bed_type_new)){
				$bed_type = $result->bed_type_new;
			}else{
				$bed_type = $result->bed_type_eng;
			}

			if(!empty($result->order_room_cnt_new)){
				$order_room_cnt = $result->order_room_cnt_new;
			}else{
				$order_room_cnt = $result->order_room_cnt;
			}

			if(!empty($result->order_people_new)){
				$order_people = $result->order_people_new;
			}else{
				$order_people = ($result->adult + $result->kids) . "Adult(s)";
			}

			if(!empty($result->order_memo_new)){
				$order_memo = $result->order_memo_new;
			}else{
				$order_memo = $result->admin_memo;
			}

			if(!empty($result->child_age_new)){
				$child_age = $result->child_age_new;
			}

			if(!empty($result->breakfast_new)){
				$breakfast = $result->breakfast_new;
			}else{
				$breakfast = $result->breakfast == "N" ? "Include (No) Adult Breakfast" : "Include (Yes) Adult Breakfast";
			}

			if(!empty($result->guest_request_new)){
				$guest_request = $result->guest_request_new;
			}else{
				$guest_request = $str_req_en;
			}

			if(!empty($result->order_remark_new)){
				$order_remark = $result->order_remark_new;
			}

			if(!empty($result->order_remark_new)){
				$order_remark = $result->order_remark_new;
			}else{
				$order_remark = $result->custom_req_eng;
			}
		}

		$html = view('pdf/voucher_hotel', [ 
            'result'  => $result,
            'type' => $type,
            'user_name' => $user_name,
            'user_mobile' => $user_mobile,
            'order_date' => $order_date,
            'room_type' => $room_type,
            'bed_type' => $bed_type,
            'order_room_cnt' => $order_room_cnt,
            'order_people' => $order_people,
            'order_memo' => $order_memo,
			'user_name_en' => $user_name_en,
			'child_age' => $child_age,
			'breakfast' => $breakfast,
			'guest_request' => $guest_request,
			'order_remark' => $order_remark,
            'policy'  => $policy[0],
        ]);
        
        $pdf->WriteHTML($html);
		
        $pdf->Output('voucher_hotel.pdf', 'I');
        exit;
    }

    public function voucherGolf()
    {
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => [FCPATH . 'ttfonts'], // 폰트 폴더 추가
            'default_font' => 'nanumgothic',
            'fontdata' => [
                'nanumgothic' => [
                    'R' => 'NanumGothic.ttf',
                    'B' => 'NanumGothicBold.ttf',
                ]
            ],
            'margin_bottom' => 10,
        ]);

        $order_idx = $this->request->getVar('order_idx');

        $private_key = private_key(); // 복호화 키

		$db = db_connect();
		$builder = $db->table('tbl_order_mst a');

		$builder->select("
					a.*, b.*, c.*,
					AES_DECRYPT(UNHEX(a.order_user_name), '$private_key') AS order_user_name,
					AES_DECRYPT(UNHEX(a.order_user_email), '$private_key') AS order_user_email,
					AES_DECRYPT(UNHEX(a.order_user_first_name_en), '$private_key') AS order_user_first_name_en,
					AES_DECRYPT(UNHEX(a.order_user_last_name_en), '$private_key') AS order_user_last_name_en,
					AES_DECRYPT(UNHEX(a.order_user_mobile), '$private_key') AS order_user_mobile,
					AES_DECRYPT(UNHEX(a.local_phone), '$private_key') AS local_phone,
					AES_DECRYPT(UNHEX(a.order_zip), '$private_key') AS order_zip,
					AES_DECRYPT(UNHEX(a.order_addr1), '$private_key') AS order_addr1,
					AES_DECRYPT(UNHEX(a.order_addr2), '$private_key') AS order_addr2,
					AES_DECRYPT(UNHEX(a.manager_name), '$private_key') AS manager_name
		");

		$builder->join('tbl_product_mst b', 'a.product_idx = b.product_idx', 'left');
		$builder->join('tbl_product_stay c', 'b.stay_idx = c.stay_idx', 'left');
		$builder->where('a.order_idx', $order_idx);

		$query  = $builder->get();
		$result = $query->getRow();

        $builder1 = $db->table('tbl_policy_info');
		$policy = $builder1->whereIn('p_idx', [28])
							->orderBy('p_idx', 'asc')
							->get()->getResultArray();

		$html = view('pdf/voucher_golf',[
            'policy_1' => $policy[0],
            'result'  => $result
        ]);
        
        $pdf->WriteHTML($html);
		
        $pdf->Output('voucher_golf.pdf', 'I');
        exit;
    }

    public function voucherTour()
    {
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => [FCPATH . 'ttfonts'], // 폰트 폴더 추가
            'default_font' => 'nanumgothic',
            'fontdata' => [
                'nanumgothic' => [
                    'R' => 'NanumGothic.ttf',
                    'B' => 'NanumGothicBold.ttf',
                ]
            ]
        ]);

        $order_idx = $this->request->getVar('order_idx');

        $private_key = private_key(); // 복호화 키

		$db = db_connect();
		$builder = $db->table('tbl_order_mst a');

		$builder->select("
					a.*, b.*, c.*,
					AES_DECRYPT(UNHEX(a.order_user_name), '$private_key') AS order_user_name,
					AES_DECRYPT(UNHEX(a.order_user_email), '$private_key') AS order_user_email,
					AES_DECRYPT(UNHEX(a.order_user_first_name_en), '$private_key') AS order_user_first_name_en,
					AES_DECRYPT(UNHEX(a.order_user_last_name_en), '$private_key') AS order_user_last_name_en,
					AES_DECRYPT(UNHEX(a.order_user_mobile), '$private_key') AS order_user_mobile,
					AES_DECRYPT(UNHEX(a.local_phone), '$private_key') AS local_phone,
					AES_DECRYPT(UNHEX(a.order_zip), '$private_key') AS order_zip,
					AES_DECRYPT(UNHEX(a.order_addr1), '$private_key') AS order_addr1,
					AES_DECRYPT(UNHEX(a.order_addr2), '$private_key') AS order_addr2,
					AES_DECRYPT(UNHEX(a.manager_name), '$private_key') AS manager_name
		");

		$builder->join('tbl_product_mst b', 'a.product_idx = b.product_idx', 'left');
		$builder->join('tbl_product_stay c', 'b.stay_idx = c.stay_idx', 'left');
		$builder->where('a.order_idx', $order_idx);

		$query  = $builder->get();
		$result = $query->getRow();

		$html = view('pdf/voucher_tour', [
            'result'  => $result
        ]);
        
        $pdf->WriteHTML($html);
		
        $pdf->Output('voucher_tour.pdf', 'I');
        exit;
    }

    public function voucherTicket()
    {
        $pdf = new Mpdf([
            'mode' => 'utf-8',
            'format' => 'A4',
            'fontDir' => [FCPATH . 'ttfonts'], // 폰트 폴더 추가
            'default_font' => 'nanumgothic',
            'fontdata' => [
                'nanumgothic' => [
                    'R' => 'NanumGothic.ttf',
                    'B' => 'NanumGothicBold.ttf',
                ]
            ]
        ]);

        $order_idx = $this->request->getVar('order_idx');

        $private_key = private_key(); // 복호화 키

		$db = db_connect();
		$builder = $db->table('tbl_order_mst a');

		$builder->select("
					a.*, b.*, c.*,
					AES_DECRYPT(UNHEX(a.order_user_name), '$private_key') AS order_user_name,
					AES_DECRYPT(UNHEX(a.order_user_email), '$private_key') AS order_user_email,
					AES_DECRYPT(UNHEX(a.order_user_first_name_en), '$private_key') AS order_user_first_name_en,
					AES_DECRYPT(UNHEX(a.order_user_last_name_en), '$private_key') AS order_user_last_name_en,
					AES_DECRYPT(UNHEX(a.order_user_mobile), '$private_key') AS order_user_mobile,
					AES_DECRYPT(UNHEX(a.local_phone), '$private_key') AS local_phone,
					AES_DECRYPT(UNHEX(a.order_zip), '$private_key') AS order_zip,
					AES_DECRYPT(UNHEX(a.order_addr1), '$private_key') AS order_addr1,
					AES_DECRYPT(UNHEX(a.order_addr2), '$private_key') AS order_addr2,
					AES_DECRYPT(UNHEX(a.manager_name), '$private_key') AS manager_name
		");

		$builder->join('tbl_product_mst b', 'a.product_idx = b.product_idx', 'left');
		$builder->join('tbl_product_stay c', 'b.stay_idx = c.stay_idx', 'left');
		$builder->where('a.order_idx', $order_idx);

		$query  = $builder->get();
		$result = $query->getRow();

		$html = view('pdf/voucher_ticket', [
            'result'  => $result
        ]);
        
        $pdf->WriteHTML($html);
		
        $pdf->Output('voucher_ticket.pdf', 'I');
        exit;
    }
}


