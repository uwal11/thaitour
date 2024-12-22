<?php

namespace App\Controllers;

use App\Libraries\Nicepay;

class PaymentController extends BaseController
{
    private $nicepay;

    public function __construct()
    {
        $this->nicepay = new Nicepay();
    }

    // 결제 요청
    public function requestPayment()
    {
/*
				$orderId   = uniqid('ORDER_'); // 주문 번호 (고유해야 함)
				$amount    = 10000;            // 결제 금액
				$orderName = "테스트 상품";   // 상품 이름

				$response = $this->nicepay->requestPayment($orderId, $amount, $orderName);

				if ($response['statusCode'] === 200 && isset($response['response']['nextRedirectUrl'])) {
					// 결제 페이지로 리다이렉트
					return redirect()->to($response['response']['nextRedirectUrl']);
				}

				if ($response['statusCode'] !== 200) {
					log_message('error', '결제 요청 실패: ' . json_encode($response));
					return view('payment_failed', [
						'message'   => $response['response']['message'] ?? '결제 요청 실패',
						'errorCode' => $response['response']['errorCode'] ?? '알 수 없는 오류',
					]);
				}

				log_message('debug', '나이스페이 요청 데이터: ' . $orderId ." - ". $amount ." - ". $orderName);
				log_message('debug', '나이스페이 응답 데이터: ' . json_encode($response));
		*/
				// 오류 처리
				//return view('payment_request');
				$data[] = "";

				return $this->renderView('payment_request', $data);
    }

    // 결제 완료
    public function completePayment()
    {
				$transactionId = $this->request->getGet('transactionId'); // 나이스페이로부터 전달된 거래 ID

				$response = $this->nicepay->approvePayment($transactionId);

				if ($response['statusCode'] === 200 && isset($response['response']['status']) && $response['response']['status'] === 'APPROVED') {
					return view('payment_success', ['response' => $response['response']]);
				}

				// 오류 처리
				return view('payment_failed', [
					'message' => $response['response']['message'] ?? '결제 승인 실패',
				]);
    }

	public function nicepay_result()
	{
		        $db         = \Config\Database::connect();

				header("Content-Type:text/html; charset=utf-8;"); 
				/*
				****************************************************************************************
				* <인증 결과 파라미터>
				****************************************************************************************
				*/
	            $setting        = homeSetInfo();

				$authResultCode = $_POST['AuthResultCode'];		// 인증결과 : 0000(성공)
				$authResultMsg  = $_POST['AuthResultMsg'];		// 인증결과 메시지
				$nextAppURL     = $_POST['NextAppURL'];			// 승인 요청 URL
				$txTid          = $_POST['TxTid'];				// 거래 ID
				$authToken      = $_POST['AuthToken'];			// 인증 TOKEN
				$payMethod      = $_POST['PayMethod'];			// 결제수단
				$mid            = $_POST['MID'];				// 상점 아이디
				$moid           = $_POST['Moid'];				// 상점 주문번호
				$amt            = $_POST['Amt'];				// 결제 금액
				$reqReserved    = $_POST['ReqReserved'];		// 상점 예약필드
				$netCancelURL   = $_POST['NetCancelURL'];		// 망취소 요청 URL
				//$authSignature = $_POST['Signature'];			// Nicepay에서 내려준 응답값의 무결성 검증 Data

				/*  
				****************************************************************************************
				* Signature : 요청 데이터에 대한 무결성 검증을 위해 전달하는 파라미터로 허위 결제 요청 등 결제 및 보안 관련 이슈가 발생할 만한 요소를 방지하기 위해 연동 시 사용하시기 바라며 
				* 위변조 검증 미사용으로 인해 발생하는 이슈는 당사의 책임이 없음 참고하시기 바랍니다.
				****************************************************************************************
				 */
				$merchantKey = $setting['nicepay_key']; //"EYzu8jGGMfqaDEp76gSckuvnaHHu+bC4opsSN6lHv3b2lurNYkVXrZ7Z1AoqQnXI3eLuaUFyoRNC6FkrzVjceg=="; // 상점키

				// 인증 응답 Signature = hex(sha256(AuthToken + MID + Amt + MerchantKey)
				$authComparisonSignature = bin2hex(hash('sha256', $authToken. $mid. $amt. $merchantKey, true)); 

				/*
				****************************************************************************************
				* <승인 결과 파라미터 정의>
				* 샘플페이지에서는 승인 결과 파라미터 중 일부만 예시되어 있으며, 
				* 추가적으로 사용하실 파라미터는 연동메뉴얼을 참고하세요.
				****************************************************************************************
				*/

				$response = "";

				// 인증 응답으로 받은 Signature 검증을 통해 무결성 검증을 진행하여야 합니다.
				if($authResultCode === "0000" /* && $authSignature == $authComparisonSignature*/){
					/*
					****************************************************************************************
					* <해쉬암호화> (수정하지 마세요)
					* SHA-256 해쉬암호화는 거래 위변조를 막기위한 방법입니다. 
					****************************************************************************************
					*/	
				    $paydate  = date("YmdHis");

					$ediDate  = date("YmdHis");
					$signData = bin2hex(hash('sha256', $authToken . $mid . $amt . $ediDate . $merchantKey, true));

					try{
						$data = Array(
							'TID'       => $txTid,
							'AuthToken' => $authToken,
							'MID'       => $mid,
							'Amt'       => $amt,
							'EdiDate'   => $ediDate,
							'SignData'  => $signData,
							'CharSet'   => 'utf-8'
						);		
						$response = reqPost($data, $nextAppURL); //승인 호출
						$respArr  = json_decode($response);

                        if($respArr->ResultCode == "3001")  // 카드결제 정상완료
						{  
							    $sql = "UPDATE tbl_payment_mst SET payment_method = '신용카드'
																  ,payment_status = 'Y'
															      ,paydate		  = '". $paydate ."'
																  ,ResultCode_1   = '". $respArr->ResultCode ."'
															  	  ,ResultMsg_1    = '". $respArr->ResultMsg ."'
																  ,Amt_1          = '". $respArr->Amt ."'
																  ,TID_1          = '". $respArr->TID ."'
																  ,AuthCode_1     = '". $respArr->AuthCode ."'
																  ,AuthDate_1     = '". $respArr->AuthDate ."' WHERE payment_no = '". $moid ."'";														
                                $result = $db->query($sql);

								$sql = " SELECT order_no from tbl_payment_mst WHERE payment_no = '" . $moid . "'";
								$row = $db->query($sql)->getRowArray();

								$array = explode(",", $row['order_no']);

								// 각 요소에 작은따옴표 추가
								$quotedArray = array_map(function($item) {
									return "'" . $item . "'";
								}, $array);

								// 배열을 다시 문자열로 변환
								$output = implode(',', $quotedArray);

								$sql = "UPDATE tbl_order_mst SET order_status = 'Y'	WHERE order_no IN(". $output .") "; 
								$db->query($sql);

		                } else if($respArr->ResultCode == "4100") // 가상계좌 발급
						{  

						       $sql = " UPDATE tbl_payment_mst  SET payment_method  = '가상계좌'
						                                           ,payment_status 	= 'W'
																   ,paydate		    = '". $paydate ."'
																   ,ResultCode_1    = '". $respArr->ResultCode ."' 
																   ,ResultMsg_1     = '". $respArr->ResultMsg ."' 
																   ,Amt_1           = '". $respArr->Amt ."' 
																   ,TID_1           = '". $respArr->TID ."' 
																   ,VbankBankCode_1 = '". $respArr->VbankBankCode ."' 
																   ,VbankBankName_1 = '". $respArr->VbankBankName ."' 
																   ,VbankNum_1      = '". $respArr->VbankNum ."' 
																   ,VbankExpDate_1  = '". $respArr->VbankExpDate ."' 
																   ,VbankExpTime_1  = '". $respArr->VbankExpTime ."' 
																   ,AuthCode_1      = '". $respArr->AuthCode ."' 
																   ,AuthDate_1      = '". $respArr->AuthDate ."'  WHERE payment_no = '".$moid."' ";
                                $result = $db->query($sql);

								$sql = " SELECT order_no from tbl_payment_mst WHERE payment_no = '" . $moid . "'";
								$row = $db->query($sql)->getRowArray();

								$array = explode(",", $row['order_no']);

								// 각 요소에 작은따옴표 추가
								$quotedArray = array_map(function($item) {
									return "'" . $item . "'";
								}, $array);

								// 배열을 다시 문자열로 변환
								$output = implode(',', $quotedArray);

								$sql = "UPDATE tbl_order_mst SET order_status = 'W'	WHERE order_no IN(". $output .") "; 
								$db->query($sql);
					    }

						//jsonRespDump($response); //response json dump example
						
					}catch(Exception $e){
						$e->getMessage();
						$data = Array(
							'TID'       => $txTid,
							'AuthToken' => $authToken,
							'MID'       => $mid,
							'Amt'       => $amt,
							'EdiDate'   => $ediDate,
							'SignData'  => $signData,
							'NetCancel' => '1',
							'CharSet'   => 'utf-8'
						);
						$response = reqPost($data, $netCancelURL); //예외 발생시 망취소 진행
						jsonRespDump($response); //response json dump example
					}	
					
				}else /*if($authComparisonSignature == $authSignature)*/{
					//인증 실패 하는 경우 결과코드, 메시지
					$ResultCode = $authResultCode; 	
					$ResultMsg  = $authResultMsg;
				}/*else{
					echo('인증 응답 Signature : '. $authSignature.'</br');
					echo('인증 생성 Signature : '. $authComparisonSignature);
				}*/

                $data['ResultMsg'] = $respArr->ResultMsg;

				return $this->renderView('payment_result', $data);

	}
}

?>