<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>

<?php
if (empty(session()->get("member")["mIdx"])) {
    alert_msg("", "/member/login?returnUrl=" . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

$cnt_1 = $cnt_2 = $cnt_3 = $cnt_4 = $cnt_5 = $cnt_6 = 0; 
foreach($order_list as $order) : 
 
        if($order['order_status'] == "W" || $order['order_status'] == "X") $cnt_1++;  // 예약신청
        if($order['order_status'] == "X" || $order['order_status'] == "Z" || $order['order_status'] == "G" || $order['order_status'] == "R" || $order['order_status'] == "J") $cnt_2++;  // 결제대기중
        if($order['order_status'] == "Y") $cnt_3++;  // 예약확정중
        if($order['order_status'] == "Z") $cnt_4++;  // 예약확정
        if($order['order_status'] == "N") $cnt_5++;  // 예약불가
        if($order['order_status'] == "C") $cnt_6++;  // 취소완료

endforeach; 
?>

<style>
	.box {
		text-align: center;
		font-size: 18px;
		cursor: pointer;
	}
	.hover-message {
		display: none;
		margin-top: 10px;
		color: red;
		font-weight: bold;
	}
</style>
	
<link href="/css/mypage/mypage_new.css" rel="stylesheet" type="text/css"/>
<link href="/css/mypage/mypage_reponsive_new.css" rel="stylesheet" type="text/css"/>
<link href="/css/mypage/mypage_reponsive_new02.css" rel="stylesheet" type="text/css"/>
<link href="/css/mypage/mypage.css" rel="stylesheet" type="text/css"/>
<link href="/css/mypage/mypage_reponsive.css" rel="stylesheet" type="text/css"/>
<link href="/css/community/community.css" rel="stylesheet" type="text/css"/>

<section class="mypage_container" style="margin-bottom: 0;">
    <div class="inner">
        <div class="mypage_wrap">
            <?php
            echo view("/mypage/mypage_gnb_menu_inc.php", ["tab_1" => "on"]);
            ?>

            <div class="booklist_wrap">
                <div class="book_big_ttl">
                    <h2 class="flex">최근 예약 현황 <p>(3개월 기준)</p></h2>
                </div>
                <div class="book_num_order">
                    <div class="top flex_c_c">
                        <div class="num_order flex_c_c">
                            <p class="titles">
                                예약신청
                            </p>
                            <div class="desc">
                                <p><?=$cnt_1?></p>
                                <span>건</span>
                            </div>
                        </div>
                        <div class="num_order flex_c_c">
                            <img src="/images/mypage/right-arrow.png" alt="">
                        </div>
                        <div class="num_order flex_c_c">
                            <p class="titles">
                                결제대기중 
                            </p>
                            <div class="desc">
                                <p><?=$cnt_2?></p>
                                <span>건</span>
                            </div>
                        </div>
                        <div class="num_order flex_c_c">
                            <img src="/images/mypage/right-arrow.png" alt="">
                        </div>
                        <div class="num_order flex_c_c">
                            <p class="titles">
                                예약확정중 
                            </p>
                            <div class="desc">
                                <p><?=$cnt_3?></p>
                                <span>건</span>
                            </div>
                        </div>
                        <div class="num_order flex_c_c">
                            <img src="/images/mypage/right-arrow.png" alt="">
                        </div>
                        <div class="num_order flex_c_c">
                            <p class="titles">
                                예약확정
                            </p>
                            <div class="desc">
                                <p><?=$cnt_4?></p>
                                <span>건</span>
                            </div>
                        </div>
                        <div class="num_order flex_c_c">
                            <img src="/images/mypage/right-arrow.png" alt="">
                        </div>
                        <div class="num_order flex_c_c">
                            <p class="titles">
                                예약불가 
                            </p>
                            <div class="desc">
                                <p><?=$cnt_5?></p>
                                <span>건</span>
                            </div>
                        </div>
                    </div>
                    <div class="process flex_c_c">
                        <p>취소처리중 <span>0</span> 건 </p>
                        <p>취소완료 <span><?=$cnt_6?></span> 건 </p>
                        <p>변경처리중 <span>0</span> 건 </p>
                        <p>실시간 예약상품 - 결제기한 만료 <span>0</span> 건 </p>
                    </div>
                </div>
                <div class="book_big_ttl flex_b">
                    <h2 class="flex">예약 현황</h2>
                    <p class="total only_mo">전체 <span><?= esc($nTotalCount) ?></span>건 </p>
                </div>
                <div class="result_book flex__c">
                    <p class="total only_web">전체 <span><?= esc($nTotalCount) ?></span>건 </p>
                    <div class="tab_box">
                        <ul class="flex">
                            <li <?php if($procType == "") echo "class='on'";?> data-menu="all">
                                <a href="#!" onclick="go_status('');">전체예약내역</a>
                            </li>
                            <li <?php if($procType == "1") echo "class='on'";?> data-menu="all">
                                <a href="#!" onclick="go_status('1');">예약진행중</a>
                                <img src="/images/mypage/question_mark.png" alt="">
                            </li>
                            <li <?php if($procType == "2") echo "class='on'";?> data-menu="all">
                                <a href="#!" onclick="go_status('2');">예약확정</a>
                                <img src="/images/mypage/question_mark.png" alt="">
                            </li>
                            <li <?php if($procType == "3") echo "class='on'";?> data-menu="all">
                                <a href="#!" onclick="go_status('3');">이용완료</a>
                                <img src="/images/mypage/question_mark.png" alt="">
                            </li>
                            <li <?php if($procType == "4") echo "class='on'";?> data-menu="all">
                                <a href="#!" onclick="go_status('4');">취소내역</a>
                                <img src="/images/mypage/question_mark.png" alt="">
                            </li>
                            <li <?php if($procType == "5") echo "class='on'";?> data-menu="all">
                                <a href="#!" onclick="go_status('5');">이용불가</a>
                                <img src="/images/mypage/question_mark.png" alt="">
                            </li>
                        </ul>
                    </div>
                </div>

                <form name="search" id="search">
                    <input type="hidden" name="s_status" value="">
                    <input type="hidden" name="pg" value="">
					<input type="hidden" name="procType" id="procType" value="<?=$procType?>" />
                    <div class="search_form flex_b_c">
                        <div class="only_web">
                            <div class="select_search_wrap flex__c">
                                <select name="dateType" id="dateType">
                                    <option value="1" <?php if($dateType == "1") echo "selected";?> >이용일(숙박일)</option>
                                    <option value="2" <?php if($dateType == "2") echo "selected";?> >예약일</option>
                                </select>
                                <div class="input-row flex__c">
                                    <div class="datepick"><input type="text" name="checkInDatex"  value="<?= esc($checkInDate)?>"  onfocus="this.blur()"
                                            class="bs-input"></div>
                                    <div class="datepick"><input type="text" name="checkOutDatex" value="<?= esc($checkOutDate)?>" onfocus="this.blur()"
                                            class="bs-input"></div>
                                </div>
                                <select name="payType" id="payType">
                                    <option value="">결제상태</option>
                                    <option value="1" <?php if($payType == "1") echo "selected";?> >결제완료</option>
                                    <option value="2" <?php if($payType == "2") echo "selected";?> >미결제</option>
                                </select>
								<select name="prodType" id="prodType">
									<option value="">상품종류</option>
									<option value="hotel"      <?= ($prodType == "hotel")      ? 'selected' : ''; ?> >호텔</option>
									<option value="golf"       <?= ($prodType == "golf")       ? 'selected' : ''; ?> >골프</option>
									<option value="tour"       <?= ($prodType == "tour")       ? 'selected' : ''; ?> >투어</option>
									<option value="spa"        <?= ($prodType == "spa")        ? 'selected' : ''; ?> >스파</option>
									<option value="ticket"     <?= ($prodType == "ticket")     ? 'selected' : ''; ?> >쇼ㆍ입장권</option>
									<option value="restaurant" <?= ($prodType == "restaurant") ? 'selected' : ''; ?> >레스토랑</option>
									<option value="vehicle"    <?= ($prodType == "vehicle")    ? 'selected' : ''; ?> >차량</option>
									<option value="guide"      <?= ($prodType == "guide")      ? 'selected' : ''; ?> >가이드</option>
								</select>

                                <select name="searchType" id="searchType">
                                    <option value="1" <?php if($searchType == "1") echo "selected";?> >상품명</option>
                                    <option value="2" <?php if($searchType == "2") echo "selected";?> >여행자 이름</option>
                                    <option value="3" <?php if($searchType == "3") echo "selected";?> >예약번호</option>
                                    <option value="4" <?php if($searchType == "4") echo "selected";?> >그룹번호</option>
                                </select>
                            </div>
                        </div>
                        <div class="popup_filter">
                            <div class="popups">
                                <button type="button" class="close" onclick="closePopups()"></button>
                                <div class="filter_content">
                                    <div class="filter_wrap">
                                        <div class="box_category">
                                            <h2 class="ttl">예약일</h2>
                                            <div class="category_list">
                                                <div class="wrap_input">
                                                    <input type="radio" name="dateType" id="dateType_01" data-name="" value="1">
                                                    <label for="dateType_01">그룹별예약정렬</label>
                                                </div>
                                                <div class="wrap_input">
                                                    <input type="radio" name="dateType" id="dateType_02" data-name="" value="2">
                                                    <label for="dateType_02">건별예약정렬</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box_category">
                                            <div class="box_date flex">
                                                <div class="datepick"><input type="text" name="checkInDate" id="checkInDate" onfocus="this.blur()"
                                                    class="bs-input"></div>
                                                <div class="datepick"><input type="text" name="checkOutDate" id="checkOutDate" onfocus="this.blur()"
                                                    class="bs-input"></div>
                                            </div>
                                        </div>
                                        <div class="box_category">
                                            <h2 class="ttl">결제상태</h2>
                                            <div class="category_list">
                                                <div class="wrap_input">
                                                    <input type="radio" name="payType" id="payType_01" data-name="" value="1">
                                                    <label for="payType_01">결제상태</label>
                                                </div>
                                                <div class="wrap_input">
                                                    <input type="radio" name="payType" id="payType_02" data-name="" value="2">
                                                    <label for="payType_02">결제완료</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box_category">
                                            <h2 class="ttl">상품종류</h2>
                                            <div class="category_list">
                                                <div class="wrap_input">
                                                    <input type="radio" name="prodType" id="cate_01" data-name="" value="">
                                                    <label for="cate_01">상품종류</label>
                                                </div>
                                                <div class="wrap_input">
                                                    <input type="radio" name="prodType" id="cate_02" data-name="" value="hotel">
                                                    <label for="cate_02">호텔</label>
                                                </div>
                                                <div class="wrap_input">
                                                    <input type="radio" name="prodType" id="cate_03" data-name="" value="golf">
                                                    <label for="cate_03">골프</label>
                                                </div>
                                                <div class="wrap_input">
                                                    <input type="radio" name="prodType" id="cate_04" data-name="" value="tour">
                                                    <label for="cate_04">투어</label>
                                                </div>
                                                <div class="wrap_input">
                                                    <input type="radio" name="prodType" id="cate_05" data-name="" value="spa">
                                                    <label for="cate_05">스파</label>
                                                </div>
                                                <div class="wrap_input">
                                                    <input type="radio" name="prodType" id="cate_06" data-name="" value="ticket">
                                                    <label for="cate_06">쇼ㆍ입장권</label>
                                                </div>
                                                <div class="wrap_input">
                                                    <input type="radio" name="prodType" id="cate_7" data-name="" value="restaurant">
                                                    <label for="cate_7">레스토랑</label>
                                                </div>
                                                <div class="wrap_input">
                                                    <input type="radio" name="prodType" id="cate_8" data-name="" value="vehicle">
                                                    <label for="cate_8">차량</label>
                                                </div>
                                                <div class="wrap_input">
                                                    <input type="radio" name="prodType" id="cate_9" data-name="" value="guide">
                                                    <label for="cate_9">가이드</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box_category">
                                            <h2 class="ttl">상품</h2>
                                            <div class="category_list">
                                                <div class="wrap_input">
                                                    <input type="radio" name="cate_04" id="cate_11" data-name="" value="">
                                                    <label for="cate_11">상품명</label>
                                                </div>
                                                <div class="wrap_input">
                                                    <input type="radio" name="cate_04" id="cate_12" data-name="" value="">
                                                    <label for="cate_12">여행자 이름</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg"></div>
                        </div>
                        <div class="only_mo">
                            <div class="filter_ic">
                                <img src="/images/mypage/filter_ic.png" alt="">
                            </div>
                        </div>
                        <div class="details_search flex_e_c">
                            <input type="text" name="search_word" value="<?= esc($search_word)?>">
                            <button class="search_button" type="button" onclick="go_submit();">검색</button>
                        </div>
                    </div>
                </form>
                
				<?php foreach($groupCounts as $group) : ?>
                <div class="booking_product" data-menu="all">
                    <div class="product_box">
                        <div class="book_group_wrap flex_b_c">
                            <div class="name_pro">
                                <div class="bs-input-check">
                                    <input type="checkbox" id="grp<?= esc($group['group_no']) ?>" class="grpCheck" data-grp="<?= esc($group['group_no']) ?>" value="Y">
                                    <label for="grp<?= esc($group['group_no']) ?>"> <?= esc($group['group_no']) ?> (그룹번호) / 전체 <?= esc($group['group_count']) ?>건 </label>
                                </div>
                            </div>
                            <div class="group_r flex__c">
                                <div class="total">
                                    <p>그룹 총금액 <span><?= esc(number_format($group['order_price']))?>원</span></p>
                                </div>
                                <div onclick="openNewWindow()" class="group_print flex__c">
                                    <img src="/images/mypage/printer_ic.png" alt="" class="only_web">
                                    <img src="/images/mypage/printer_ic_m.png" alt="" class="only_mo">
                                    <p class="only_web">그룹 견적서</p>
                                </div>
                            </div>
                        </div>


                        <script>
                                  function openNewWindow() {
                                      $(".estimate_popup_wrap").show();
                                      $(".estimate_popup_content .btn_close_popup").click(function() {
                                          $(".estimate_popup_wrap").hide();
                                      })
                                      // window.open("https://thetourlab.com/mypage/pop_estimate", "popupWindow", "width=720,height=840");
                                  }
                              </script>
						
						<?php 
						// $order_list에서 현재 그룹에 해당하는 행만 출력
						$_deli_type = get_deli_type();
						foreach($order_list as $order) : 
							if ($order['group_no'] == $group['group_no']) :
							
						?>
                        <div class="product_detail">
                            <div class="info_product">
                                <div class="bs-input-check">
                                    <?php 
									       if($order['order_status'] == "X" || $order['order_status'] == "G") {
										     echo '<input type="checkbox" 
											              data-idx="'. $order['order_no'] .'" 
														  data-price="'. $order['order_price'] .'" 
														  id="prod'.esc($order['order_idx']).'" 
														  class="pay sub'.esc($group['group_no']).'" 
														  value="Y">';
									       } 
									?>
									
                                    <label for="prod<?=esc($order['order_idx'])?>"> 예약일(예약번호): <?= esc($order['order_date'])?>(<?= esc(dateToYoil($order['order_r_date']))?>) (<?= esc($order['order_no'])?>) </label>
                                </div>
                                <a href="!#" class="product_tit">[<?= esc($order['code_name'])?>] <?= esc($order['product_name'])?> </a>
                                <div class="info_payment flex__c">
                                    <div class="tag">
                                        <p><?= esc($_deli_type[$order['order_status']])?></p>
                                    </div>
                                    <?php if($order['order_status'] == "X" || $order['order_status'] == "G") echo '<span>결제하시면 예약 확정이 진행돼요. </span>';?>
                                </div>
                                <div class="info_user flex">
								    <?php 
									    if($order['order_gubun'] == "hotel") {
										   echo "<p>". esc($order['start_date']) ."(". dateToYoil($order['start_date']) .") ~ ". esc($order['end_date']) ."(". dateToYoil($order['end_date']) .")</p>"; 
						                } else if($order['order_gubun'] == "golf" || $order['order_gubun'] == "tour") {
										   echo "<p>". esc($order['order_date']) ."</p>"; 
						                } else if($order['order_gubun'] == "spa" || $order['order_gubun'] == "ticket") {  
										   echo "<p>". esc($order['order_day']) ."(". dateToYoil($order['order_day']) .")</p>"; 
										}
									?>	
									
									<?php 
										if($order['order_gubun'] == "golf") {
                                           echo "<p>18홀 오전</p>";
                                           echo "<p>성인 ". $order['people_adult_cnt'] ."명</p>";
									    }
									?>	   
                                    <p><?= esc(number_format($order['order_price']))?>원 (<?= esc(number_format($order['order_price'] / $order['baht_thai']))?>바트)</p>
                                </div>
                                <div class="info_name">
                                    <p>여행자 이름: <?= esc($order["order_user_name"]);?>[<?= esc($order["order_user_first_name_en"]);?> <?= esc($order["order_user_last_name_en"]);?>]</p>
                                </div>
                                <div class="note flex__c">
                                    <img src="/images/mypage/not-allowed.png" alt="">
                                    <p>취소 규정 : 결제후 <span>03월20일 18시(한국시간)</span> 이전에 취소하시면 무료취소가 가능합니다</p>
                                </div>
                                <div class="info_link" data-product-idx="<?= $order['product_idx'] ?>">본 예약건 취소규정 자세히 보기</div>
                            </div>
                            <div class="info_price flex">
							    
								<?php if($order['order_status'] == "X" || $order['order_status'] == "G") { ?>
                                <div class="info_total_price flex__c box">
                                    <p class="pri_won"><?= esc(number_format($order['order_price']))?> <span>원</span></p>
                                    <p class="pri_bath">(<?= esc(number_format($order['order_price'] / $order['baht_thai']))?>바트)</p>
                                    <div class="btn_payment" data-idx="<?=$order['order_no']?>" >
                                        <p>결제하기</p>
                                    </div>
                                </div>
								<?php } ?>
								
                                <div class="estimate_wrap flex box">
                                    <div class="info_estimate btn_info flex__c box" data-idx="<?=$order['order_idx']?>" data-gubun="<?=$order['order_gubun']?>">
                                        <img src="/images/mypage/document_ic.png" alt="">
                                        <p>견적서</p>
                                    </div>

                                    <div class="info_reservation btn_info flex__c box" data-gubun="<?=$order['order_gubun']?>"  data-idx="<?=$order['order_idx']?>">
                                        <p>예약정보</p>
                                    </div>
                                </div>
                                <div class="info_btn btn_info flex__c order_del box" data-idx="<?=$order['order_idx']?>" >
                                    <img src="/images/mypage/delete_ic.png" alt="">
                                    <p>예약삭제</p>
                                </div>
                            </div>
                        </div>
						<?php 
							endif;
						endforeach; 
						endforeach; 
						?>

                <div class="booking_product" data-menu="canceled">

                </div>

				<div class="customer-center-page">
                    <?php
                        echo ipagelistingSub($pg, $nPage, $g_list_rows, current_url() . "?s_status=$s_status&search_word=$search_word&pg=")
                    ?>
                </div>
                <div class="p_box">
                    <div class="ord_info fl flex">
                    <p class="count_total">선택상품 : 총 <span class="f_nilegreen" id="totalCount">0</span>건</p>
                    <p class="price_total">총 결제금액  : <span class="f_orange"><strong id="totalAmount">0</strong>원</span></p>
                    </div>
                    <div class="fr">
                    <input type="button" class="custom_btn2 b_orange b_p1040" value="선택결제" onclick="fn_checkout();">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="estimate_popup_wrap">
      <div class="estimate_popup_content">
         <div class="btn_close_popup">
              <img src="/img/btn/btn_close_black_20x20.png" alt="">
          </div>
          <h1>더투어랩 여행견적서 </h1>
          <div class="sec1">
              <div class="left">
                  <p class="ttl">TOTO Booking Co., Ltd. </p>
                  <span>Sukhumvit 101 Bangjak </span>
                  <span>Prakhanong Bangkok 10260 </span>
                  <span>서비스/여행업 No. 101-86-79949 </span>
                  <p class="day">견적일 : 2025년 03월 14일 </p>
                  <p class="name">고객명 : 김평진 님 귀하 </p>
                  <img src="/images/mypage/stem.jpg" class="img_stem">
              </div>
              <div class="right">
                  <table>
                      <colgroup>
                          <col width="110px">
                          <col width="110px">
                          <col width="110px">
                      </colgroup>
                      <tbody>
                          <tr>
                              <th>호텔 </th>
                              <td>0건 </td>
                              <td>0원 </td>
                          </tr>
                          <tr>
                              <th>골프 </th>
                              <td>1건 </td>
                              <td>303,175원 </td>
                          </tr>
                          <tr>
                              <th>투어 </th>
                              <td>1건 </td>
                              <td>39,000원 </td>
                          </tr>
                          <tr>
                              <th>차량 </th>
                              <td>0건 </td>
                              <td>0원 </td>
                          </tr>
                          <tr>
                              <th>가이드 </th>
                              <td>0건 </td>
                              <td>0원 </td>
                          </tr>
                          <tr>
                              <th class="total">합계 </th>
                              <td class="total">2건 </td>
                              <td class="total">342,175원 </td>
                          </tr>
                      </tbody>
                  </table>
              </div>
          </div>
          <div class="sec2">
              <table>
                  <colgroup>
                      <col width="70px">
                      <col width="*">
                      <col width="110px">
                  </colgroup>
                  <tbody>
                      <tr>
                          <th>품목</th>
                          <th>상세</th>
                          <th>금액</th>
                      </tr>
                      <tr>
                          <td>골프 </td>
                          <td>
                              <p class="time">2025-03-28(금) | 로얄 방파인 골프 클럽 </p>
                              <p>18홀 오전 | 성인 2명 | 그린피 : 6,700바트 | 3,350바트 X 2명 </p>
                          </td>
                          <td>
                              <p>303,175원 </p>
                              <p>(6,700바트) </p>
                          </td>
                      </tr>
                      <tr>
                          <td>투어 </td>
                          <td>
                              <p class="time">2025-03-28(금) | (아속출발) 아유타야 선셋 리버크루즈 반일 투어 </p>
                              <p>[프로모션] 아유타야 오후 | 성인 1명 | 39,000원 X 1명 </p>
                          </td>
                          <td>
                              <p>39,000원 </p>
                          </td>
                      </tr>
  
              </table>
          </div>
  
          <div class="list_desc">
              <p>- 상기 견적은 고객님께서 직접 선택하신 상품으로 발행된 견적서입니다. </p>
              <p>- 견적서상 내용은 확정 예약시 상품의 예약가능여부/환을 등에 따라 금액 및 내용에 변동이 있을 수 있습니다. </p>
              <p>- 한국 : 국민은행 636101-01-301315 (주) 토토부킹 </p>
              <p>- 태국: Kasikorn Bank 895-2-19850-6 (Totobooking) </p>
          </div>
          <div class="send_mail">
              <input type="text" value="lifeess@naver.com ">
              <button>메일보내기 </button>
          </div>
          <div class="btns_download">
              <button>프린트</button>
              <button> PDF다운로드</button>
          </div>
      </div>
  </div>
<div class="popup_wrap place_pop policy_pop">
    <div class="pop_box">
        <button type="button" class="close" onclick="closePopup()"></button>
        <div class="pop_body">
            <div class="padding">
                <div class="popup_place__head">
                    <div class="popup_place__head__ttl">
                        <h2>취소 규정</h2>
                    </div>
                </div>
                <div class="popup_place__body">
                     <div id="policyContent"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="dim" style="justify-content: space-between;"></div>
</div>

<!--
<form id="checkOut" action="/checkout/payment" method="post">
<input type="hidden" name="payment_no" id="payment_no" value="" >
<input type="text" name="dataValue" id="dataValue" value="" >
</form>
-->

<form id="checkOut" action="/checkout/confirm" method="post">
<input type="text" name="payment_no" id="payment_no" value="" >
<input type="text" name="dataValue" id="dataValue" value="" >
</form>

<script>
$(document).ready(function () {
    $(".btn_payment").on("click", function () {
        var dataValue = $(this).data("idx"); // 주문번호 가져오기
		$("#dataValue").val(dataValue);
		
		$.ajax({

			url: "/ajax/ajax_payment",
			type: "POST",
			data: {

				"dataValue": dataValue 

			},
			dataType: "json",
			async: false,
			cache: false,
			success: function (data, textStatus) {
				var message = data.message;
				var payment_no = data.payment_no;
				alert('payment_no- '+payment_no);
				$("#dataValue").val(dataValue);
				$("#payment_no").val(payment_no);
                $("#checkOut").submit();
			},
			error: function (request, status, error) {
				alert("code = " + request.status + " message = " + request.responseText + " error = " + error); // 실패 시 처리
			}
		});
			
		
    });
});
</script>

<script>
$(document).ready(function() {
    function updateSummary() {
        let count      = 0;
        let totalPrice = 0;
        let dataValue  = "";

        // 체크된 체크박스만 필터링
        $(".pay:checked").each(function() {
            count++;
            totalPrice += parseInt($(this).data("price"));
			if($(this).data("idx")) dataValue += $(this).data("idx") +','; // 또는 $(this).attr("data-value");

        });

        // 결과 업데이트
        $("#totalCount").text(count);
        $("#totalAmount").text(totalPrice.toLocaleString()); // 천단위 콤마 추가
		
		//alert(count+' - '+totalPrice+' - '+dataValue);
		$("#dataValue").val(dataValue);
    }

    // 체크박스 변경 이벤트
    $(".pay").on("change", updateSummary);
});
</script>

<script>
function fn_checkout() {
	
	if($("#dataValue").val() == "") {
	   alert('결제상품을 선택하세요.');
	   return false;
	}
	
	$("#checkOut").submit();
	//window.location.href = `/checkout/show`;
}

function go_submit()
{
		 $("#search").submit();
}

function go_status(status)
{
		 $("#procType").val(status);
		 $("#search").submit();
}	
</script>

<script>
$(document).ready(function() {
    // Handle the click event on the checkbox with class .grpCheck
    $('.grpCheck').click(function() {
        if ($(this).prop('checked')) {
            var grp = $(this).data('grp');
            $('.sub'+grp).prop('checked', true);
			
			// 체크박스 변경 시 업데이트 실행
			updateSummary();	
			
        } else {
            var grp = $(this).data('grp');
            $('.sub'+grp).prop('checked', false);
			updateSummary();
        }
    });
	
    function updateSummary() {
		
        let count       = 0;
        let totalPrice  = 0;
        let selectedIdx = [];
		let dataValue   = ""; 

        // 체크된 체크박스(.pay)들의 data 값 가져오기
        $(".pay:checked").each(function() {
            count++; // 체크된 개수 증가
            totalPrice += parseInt($(this).data("price")); // data-price 값 합산
            selectedIdx.push($(this).data("idx")); // data-idx 값 저장
			if($(this).data("idx")) dataValue += $(this).data("idx") +','; // 또는 $(this).attr("data-value");
			
        });

        // 화면에 업데이트
        $("#totalCount").text(count);
        $("#totalAmount").text(totalPrice.toLocaleString()); // 천단위 콤마 추가

        //alert(count+':'+totalPrice+':'+dataValue);
		$("#dataValue").val(dataValue);

        // 콘솔에 체크된 항목 출력
        console.log("선택된 idx 목록:", selectedIdx);
    }

});
</script>

<script>
$(document).on('click', '.info_estimate', function () {

		var idx   = $(this).data('idx');  
		var gubun = $(this).data('gubun');  
		let url   = "";
		
		if(gubun == "hotel")  url = "/invoice/hotel_01/"+idx; 
		if(gubun == "tour")   url = "/invoice/tour_01/"+idx; 
		if(gubun == "spa")    url = "/invoice/ticket_01/"+idx; 
		if(gubun == "golf")   url = "/invoice/golf_01/"+idx; 
		if(gubun == "ticket") url = "/invoice/ticket_01/"+idx; 
		
		window.open(url, "popupWindow", "width=1000,height=700,left=100,top=100");

		// $('.confirm_depart').show();
});

$(document).on('click', '.info_reservation', function () {

		var gubun = $(this).data('gubun');  
		var idx   = $(this).data('idx');  
        /*
		if(idx){
			$.ajax({

				url: "/ajax/ajax_booking_delete",
				type: "POST",
				data: {

					"idx": idx 

				},
				dataType: "json",
				async: false,
				cache: false,
				success: function (data, textStatus) {
					var message = data.message;
					alert(message);
					location.reload();
				},
				error: function (request, status, error) {
					alert("code = " + request.status + " message = " + request.responseText + " error = " + error); // 실패 시 처리
				}
			});
        }
		*/
        location.href='/mypage/'+gubun+'/order_view_item?order_idx='+idx+'&pg=1#!';
});

$(document).on('click', '.order_del', function () {

		var idx   = $(this).data('idx');  

        if (confirm("삭제하시겠습니까?\n삭제 후에는 복구가 불가능합니다.") == false) {
            return;
        }

        if(idx){
			$.ajax({

				url: "/ajax/ajax_booking_delete",
				type: "POST",
				data: {

					"idx": idx 

				},
				dataType: "json",
				async: false,
				cache: false,
				success: function (data, textStatus) {
					var message = data.message;
					alert(message);
					location.reload();
				},
				error: function (request, status, error) {
					alert("code = " + request.status + " message = " + request.responseText + " error = " + error); // 실패 시 처리
				}
			});
        }		
});
</script>

<script>
    $(".datepick input").datepicker({
        dateFormat: 'yy-mm-dd',
        showOn: "both",
        buttonImage: '/images/ico/datepicker_ico.png',
        showMonthAfterYear: true,
        buttonImageOnly: true,
        monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
        dayNames: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
        dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
        changeMonth: true, // month 셀렉트박스 사용
        changeYear: true, // year 셀렉트박스 사용
        yearRange: 'c-100:c+0', // 년도 선택 셀렉트박스를 현재 년도에서 이전, 이후로 얼마의 범위를 표시할것인가.
    });

    // $(".info_link").on("click", function() {
    //     $(".policy_pop, .policy_pop .dim").show();
    // });

    $(".info_link").on("click", function() {
        let productIdx = $(this).data("product-idx");

        $.ajax({
            url: "/mypage/getPolicyContents/" + productIdx,
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.success) {
                    $("#policyContent").html(response.policy_contents);
                    $(".policy_pop, .policy_pop .dim").show();
                } else {
                    $("#policyContent").html("<p>" + response.message + "</p>");
                    $(".policy_pop, .policy_pop .dim").show();
                }
            },
            error: function() {
                $(".policy_pop, .policy_pop .dim").show();
            }
        });
    });

    function closePopup() {
        $(".popup_wrap").hide();
        $(".dim").hide();
    }

    $(".filter_ic").on("click", function() {
        $(".popup_filter").show();
    });

    function closePopups() {
        $(".popup_filter").hide();
    }

    $(window).on("scroll", function () {
        let pBox = $(".booklist_wrap .p_box");
        let footer = $("#footer");
        let pBoxHeight = pBox.outerHeight();
        let footerTop = footer.offset().top;
        let scrollTop = $(window).scrollTop();
        let windowHeight = $(window).height();

        if (scrollTop + windowHeight >= footerTop) {
            pBox.css({
                position: "relative",
                bottom: "unset"
            });
        } else {
            pBox.css({
                position: "fixed",
                bottom: "0"
            });
        }
    });

</script>
<script>
     document.addEventListener("DOMContentLoaded", function () {
        function updateBookingDisplay() {
            const activeMenu = document.querySelector(".tab_box li.on");
            if (!activeMenu) return;

            const activeMenuType = activeMenu.getAttribute("data-menu");

            document.querySelectorAll(".booking_product").forEach(item => {
                item.style.display = "none";
            });

            document.querySelectorAll(`.booking_product[data-menu="${activeMenuType}"]`).forEach(item => {
                item.style.display = "block";
            });

            const pBox = document.querySelector(".p_box");
            if (activeMenuType === "all" || activeMenuType === "progress") {
                pBox.style.display = "flex"; 
            } else {
                pBox.style.display = "none";
            }
        }

        document.querySelectorAll(".tab_box li").forEach(item => {
            item.addEventListener("click", function () {
                document.querySelectorAll(".tab_box li").forEach(li => li.classList.remove("on"));

                this.classList.add("on");

                updateBookingDisplay();
            });
        });

        updateBookingDisplay();
    });
</script>
<?php $this->endSection(); ?>
