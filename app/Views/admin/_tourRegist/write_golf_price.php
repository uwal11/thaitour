<?= $this->extend("admin/inc/layout_admin") ?>
<?= $this->section("body") ?>
<link rel="stylesheet" href="/css/admin/popup.css" type="text/css"/>
<script type="text/javascript" src="/lib/smarteditor/js/HuskyEZCreator.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>

<style>
	.badge {
		display: inline-flex;
		align-items: center;
		background-color: #007bff; /* 파란색 */
		color: white; /* 텍스트 색상 */
		font-weight: bold;
		font-size: 13px;
		padding: 4px 10px;
		box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
	}

	.badge-icon {
		width: 16px;
		height: 16px;
		margin-right: 6px;
	}
</style>
	
<div id="container">
    <div id="print_this"><!-- 인쇄영역 시작 //-->
        <header id="headerContainer">
            <div class="inner">
                <h2>골프 상품관리 정보입력</h2>
                <div class="menus">
                    <ul>
                        <li>
                            <a href="list_golf?s_product_code_1=<?= $s_product_code_1 ?>&s_product_code_2=<?= $s_product_code_2 ?>&s_product_code_2=<?= $s_product_code_3 ?>&search_name=<?= $search_name ?>&search_category=<?= $search_category ?>&pg=<?= $pg ?>"
                                class="btn btn-default">
                                <span class="glyphicon glyphicon-th-list"></span>
                                <span class="txt">리스트</span>
                            </a>
                        </li>
                        <?php if ($product_idx) { ?>
                            <li>
                                <a href="javascript:send_it()" class="btn btn-default">
                                    <span class="glyphicon glyphicon-cog"></span><span class="txt">수정</span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <!-- // inner -->
        </header>
        <!-- // headerContainer -->

        <form name="frm" action="<?= route_to('admin._tourRegist.write_golf_price_ok') ?>" method=post
                enctype="multipart/form-data" target="hiddenFrame">
            <input type=hidden name="search_category" value='<?= $search_category ?>'>
            <input type=hidden name="product_idx" id="product_idx" value='<?= $product_idx ?>'>
            <input type=hidden name="search_name" value='<?= $search_name ?>'>
            <input type=hidden name="pg" value='<?= $pg ?>'>
            <input type=hidden name="s_product_code_1" value='<?= $product['product_code_1'] ?>'>
            <input type=hidden name="s_product_code_2" value='<?= $product['product_code_2'] ?>'>
            <input type=hidden name="s_product_code_3" value='<?= $product['product_code_3'] ?>'>
            <div id="contents">
                <div class="listBottom">
				
					<table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail"
						   style="margin-top:50px;">
						<caption>
						</caption>
						<colgroup>
							<col width="12%"/>
							<col width="*%"/>
							<col width="10%"/>
							<col width="40%"/>
						</colgroup>
						<tbody>
						<tr height="45">
							<th>상품명</th>
							<td><?=$product_name?></td>
						</tr>
						<tr height="45">
							<th>최소/최대 라운딩인원</th>
							<td>
								<input id="minium_people_cnt" name="minium_people_cnt" class="input_txt" type="text" value="<?= $minium_people_cnt ?>" style="width:20%">명&nbsp;&nbsp;&nbsp;
								<input id="total_people_cnt" name="total_people_cnt" class="input_txt" type="text" value="<?= $total_people_cnt ?>" style="width:20%">명
							</td>
						</tr>
						<?php foreach ($filters as $key => $filter) { ?>
							<tr>
								<th>
									<?= $filter['code_name'] ?>
									<input type="checkbox" id="all_<?=$filter['filter_name']?>" class="all_input" value=""/>
									<label for="all_<?=$filter['filter_name']?>">
										모두 선택
									</label>
								</th>
								<td colspan="3">
									<!--select name="filter_<?= $filter['code_no'] ?>"
											id="filter_<?= $filter['code_no'] ?>"
											class="from-select select_filter"
											data-code_no="<?= $filter['code_no'] ?>"
											data-filter_name="<?= $filter['filter_name'] ?>">
										<option value="">선택하다</option>
										<?php foreach ($filter['children'] as $item) { ?>
											<option value="<?= $item['code_no'] ?>---<?= $item['code_name'] ?>"><?= $item['code_name'] ?></option>
										<?php } ?>
									</select>
									<div class="list_value_ list_value_<?= $filter['code_no'] ?>">
										<?php
										$filter_arr = explode("|", $golf_info[$filter['filter_name']]);
										$filter_arr = array_filter($filter_arr);

										?>
										<?php foreach ($filter['children'] as $item) { ?>
											<?php if (in_array($item['code_no'], $filter_arr)) { ?>
												<div class="item_">
													<span><?= $item['code_name'] ?></span>
													<input type="hidden" class="item_<?= $filter['code_no'] ?>"
														   name="<?= $filter['filter_name'] ?>[]"
														   value="<?= $item['code_no'] ?>">
													<div class="remove" onclick="removeData(this)">
														x
													</div>
												</div>
											<?php } ?>
										<?php } ?>
									</div--> 
									<?php foreach ($filter['children'] as $item) { ?>
										<input type="checkbox" class="code_<?= $filter['filter_name'] ?>" id="<?= $filter['filter_name'] ?>_<?= $item['code_no'] ?>" name="<?= $filter['filter_name'] ?>[]"
												value="<?= $item['code_no'] ?>" <?php if (in_array($item['code_no'], $filter_arr)) { echo "checked"; } ?> <?php if($filter['filter_name'] == "golf_course_odd_numbers" || $filter['filter_name'] == "green_peas") echo "disabled";?> />
										<label for="<?= $filter['filter_name'] ?>_<?= $item['code_no'] ?>">
											<?= $item['code_name'] ?>
										</label>
									<?php } ?>
								</td>
							</tr>
						<?php } ?>
                        <tr height="45">
                            <th>골프요금 추가</th>
                            <td>
								<button type="button" id="btn_add_fee" class="btn_01">추가</button>
                            </td>
                        </tr>						

						</tbody>
					</table>
							
                    <table cellpadding="0" cellspacing="0" border="1" summary="" class="listTable mem_detail" style="margin-top:10px;">
                        <tr>
                        <td>
                            <table cellpadding="0" cellspacing="0" border="1" summary="" class="listTable mem_detail" style="margin-top:10px;">
                            <colgroup>
                                <col width="10%"/>
                                <col width="90%"/>
                            </colgroup>
                            <tbody>
                            <tr height="45">
                                <th>홀선택</th>
                                <td>
									<select id="golf_code" name="golf_code" class="input_select">
										<option value="">선택</option>
										<?php foreach (GOLF_HOLES as $hole) : ?>
											<option value="<?= $hole ?>"><?= $hole ?>홀</option>
										<?php endforeach; ?>
									</select>
									<button type="button" id="btn_add_option" class="btn_01">추가</button>
									<!-- <span>(호텔을 선택해야 옵션에서 룸을 선택할 수 있습니다.)</span> -->
								</td>
                            </tr>
					        </table>
					    <tr>
					    <td>
                            <div id="mainGolf">
                                <?php foreach ($options as $frow3): ?>
                                    <?php if ($frow3['option_type'] == "M") { ?>
                                        <table>
                                            <colgroup>
                                                <col width="5%"></col>
                                                <col width="13%"></col>
                                                <col width="13%"></col>
                                                <col width="13%"></col>
                                                <col width="13%"></col>
                                                <col width="13%"></col>
                                                <col width="13%"></col>
                                                <col width="13%"></col>
                                                <col width="*"></col>
                                            </colgroup>
                                            <thead>
                                            <tr>
                                                <th>홀수</th>
                                                <th>일</th>
                                                <th>월</th>
                                                <th>화</th>
                                                <th>수</th>
                                                <th>목</th>
                                                <th>금</th>
                                                <th>토</th>
                                                <th>삭제</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tblgolf<?= $grow['o_golf'] ?>">
                                            <tr id="option_<?= $frow3['idx'] ?>">

                                                <input type='hidden' name='o_idx[]'
                                                        value='<?= $frow3['idx'] ?>'/>
                                                <input type='hidden' name='option_type[]'
                                                        value='<?= $frow3['option_type'] ?>'/>
                                                <input type='hidden' name='o_golf[]' id=''
                                                        value="<?= $frow3['o_golf'] ?>" size="70" class="hole_cnt"/>
                                                <input type='hidden' name='o_name[]' id=''
                                                        value="<?= $frow3['goods_name'] ?>" size="70"/>
                                                <td rowspan="4" style="text-align:center;">
                                                    <?= $frow3['goods_name'] ?>
                                                </td>
                                                <td>
                                                    <input type="text" numberonly="true" name="o_price1[]"
                                                            style="text-align:right;"
                                                            id="goods_price1_<?= $frow3['idx'] ?>"
                                                            value='<?= $frow3['goods_price1'] ?>'>
                                                </td>
                                                <td>
                                                    <input type="text" numberonly="true" name="o_price2[]"
                                                            style="text-align:right;"
                                                            id="goods_price2_<?= $frow3['idx'] ?>"
                                                            value='<?= $frow3['goods_price2'] ?>'>
                                                </td>
                                                <td>
                                                    <input type="text" numberonly="true" name="o_price3[]"
                                                            style="text-align:right;"
                                                            id="goods_price3_<?= $frow3['idx'] ?>"
                                                            value='<?= $frow3['goods_price3'] ?>'>
                                                </td>
                                                <td>
                                                    <input type="text" numberonly="true" name="o_price4[]"
                                                            style="text-align:right;"
                                                            id="goods_price4_<?= $frow3['idx'] ?>"
                                                            value='<?= $frow3['goods_price4'] ?>'>
                                                </td>
                                                <td>
                                                    <input type="text" numberonly="true" name="o_price5[]"
                                                            style="text-align:right;"
                                                            id="goods_price5_<?= $frow3['idx'] ?>"
                                                            value='<?= $frow3['goods_price5'] ?>'>
                                                </td>
                                                <td>
                                                    <input type="text" numberonly="true" name="o_price6[]"
                                                            style="text-align:right;"
                                                            id="goods_price6_<?= $frow3['idx'] ?>"
                                                            value='<?= $frow3['goods_price6'] ?>'>
                                                </td>
                                                <td>
                                                    <input type="text" numberonly="true" name="o_price7[]"
                                                            style="text-align:right;"
                                                            id="goods_price7_<?= $frow3['idx'] ?>"
                                                            value='<?= $frow3['goods_price7'] ?>'>
                                                </td>
                                                <td rowspan="2">
                                                    <!--button type="button" onclick="updPrice('<?= $frow3['idx'] ?>',this)">수정</button-->
                                                    <button type="button" class="btn_01"
                                                            onclick="delOption('<?= $frow3['idx'] ?>',this)">삭제
                                                    </button>
                                                </td>
                                            </tr>
                                            <tr color='<?= $_tmp_color ?>' size='<?= $frow2['type'] ?>'>
                                                <td colspan="3">
                                                    적용기간: <input type='text' readonly class='datepicker '
                                                                    name='o_sdate[]' style="width:30%"
                                                                    value='<?= $frow3['o_sdate'] ?>'/> ~
                                                    <input type='text' readonly class='datepicker ' name='o_edate[]'
                                                            style="width:30%" value='<?= $frow3['o_edate'] ?>'/>
                                                    <button type="button" class="btn_01"
                                                            onclick="updOption('<?= $frow3['idx'] ?>',this)">일자별수정
                                                    </button>
                                                </td>
                                                <td colspan="4">
                                                    <input type='checkbox' name='o_day_yn[]' id='day_<?= $frow3['o_golf'] ?>_<?= $i ?>' value='Y' checked disabled>
                                                    <label for='day_<?= $frow3['o_golf'] ?>_<?= $i ?>'>주간</label>
                                                    <input type='text' name="o_day_price[]" value="<?= $frow3['o_day_price'] ? $frow3['o_day_price'] : 0 ?>" numberonly="true" style='width:20%;text-align:right;'>

                                                    <?php if ($frow3['o_afternoon_yn'] == "Y") { ?>
                                                        <input type='checkbox' name='afternoon_yn[]' class='afternoon_yn' id='afternoon_<?= $frow3['o_golf'] ?>_<?= $i ?>' data-idx="<?= $frow3['idx'] ?>" value='Y' checked>
                                                    <?php } else { ?>
                                                        <input type='checkbox' name='afternoon_yn[]' class='afternoon_yn' id='afternoon_<?= $frow3['o_golf'] ?>_<?= $i ?>' value='Y' data-idx="<?= $frow3['idx'] ?>">
                                                    <?php } ?>

                                                    <?php if ($frow3['o_afternoon_yn'] == "Y") { ?>
                                                        <input type='hidden' name='o_afternoon_yn[]' class='o_afternoon_yn' value='Y'>
                                                    <?php } else { ?>
                                                        <input type='hidden' name='o_afternoon_yn[]' class='o_afternoon_yn' value=''>
                                                    <?php } ?>

                                                    <label for='afternoon_<?= $frow3['o_golf'] ?>_<?= $i ?>'>오후</label>
                                                    <input type='text' name="o_afternoon_price[]" value="<?= $frow3['o_afternoon_price'] ? $frow3['o_afternoon_price'] : 0 ?>" numberonly="true" style='width:20%;text-align:right;'>

                                                    <?php if ($frow3['o_night_yn'] == "Y") { ?>
                                                        <input type='checkbox' name='night_yn[]' class='night_yn' id='night_<?= $frow3['o_golf'] ?>_<?= $i ?>' data-idx="<?= $frow3['idx'] ?>" value='Y' checked>
                                                    <?php } else { ?>
                                                        <input type='checkbox' name='night_yn[]' class='night_yn' id='night_<?= $frow3['o_golf'] ?>_<?= $i ?>' value='Y' data-idx="<?= $frow3['idx'] ?>">
                                                    <?php } ?>

                                                    <?php if ($frow3['o_night_yn'] == "Y") { ?>
                                                        <input type='hidden' name='o_night_yn[]' class='o_night_yn' value='Y'>
                                                    <?php } else { ?>
                                                        <input type='hidden' name='o_night_yn[]' class='o_night_yn' value=''>
                                                    <?php } ?>

                                                    <label for='night_<?= $frow3['o_golf'] ?>_<?= $i ?>'>야간</label>
                                                    <input type='text' name="o_night_price[]" value="<?= $frow3['o_night_price'] ? $frow3['o_night_price'] : 0 ?>" numberonly="true" style='width:20%;text-align:right;'>(단위: 바트)

                                                </td>
                                            </tr>
                                            
                                            <tr color='<?= $_tmp_color ?>' size='<?= $frow2['type'] ?>'>
                                                <td colspan="8"><span class="badge">왕복</span>&nbsp;
                                                    승용차:      <input type='text' name='vehicle_price1[]' style="width:7%;text-align:right;" value='<?= $frow3['vehicle_price1'] ?>'/>&nbsp;&nbsp; 
                                                    밴 (승합차): <input type='text' name='vehicle_price2[]' style="width:7%;text-align:right;" value='<?= $frow3['vehicle_price2'] ?>'/>&nbsp;&nbsp; 
                                                    SUV:        <input type='text' name='vehicle_price3[]' style="width:7%;text-align:right;" value='<?= $frow3['vehicle_price3'] ?>'/>&nbsp; 
                                                    
													<span class="badge">편도</span>&nbsp;
                                                    승용차:      <input type='text' name='vehicle_o_price1[]' style="width:7%;text-align:right;" value='<?= $frow3['vehicle_o_price1'] ?>'/>&nbsp;&nbsp; 
                                                    밴 (승합차): <input type='text' name='vehicle_o_price2[]' style="width:7%;text-align:right;" value='<?= $frow3['vehicle_o_price2'] ?>'/>&nbsp;&nbsp; 
                                                    SUV:        <input type='text' name='vehicle_o_price3[]' style="width:7%;text-align:right;" value='<?= $frow3['vehicle_o_price3'] ?>'/>(단위: 바트) 
                                                </td>                                            
                                            <tr color='<?= $_tmp_color ?>' size='<?= $frow2['type'] ?>'>
                                                <td colspan="8">
                                                    카트:       <input type='text' name='cart_price[]' style="width:6%;text-align:right;" value='<?= $frow3['cart_price'] ?>'/>&nbsp;&nbsp;&nbsp; 
                                                    캐디피:      <input type='text' name='caddie_fee[]' style="width:6%;text-align:right;" value='<?= $frow3['caddie_fee'] ?>'/>&nbsp;&nbsp;
													
													<!-- 의무카트 S: -->
                                                    <?php if ($frow3['o_cart_due'] == "Y") { ?>
                                                         <input type='checkbox' name='cart_due[]' class='cart_due' id='cart_due_<?= $frow3['o_golf'] ?>_<?= $i ?>' data-idx="<?= $frow3['idx'] ?>" value='Y' checked >
													<?php } else { ?>
                                                         <input type='checkbox' name='cart_due[]' class='cart_due' id='cart_due_<?= $frow3['o_golf'] ?>_<?= $i ?>' data-idx="<?= $frow3['idx'] ?>" value='Y' >
													<?php } ?>
													
													<?php if ($frow3['o_cart_due'] == "Y") { ?>
                                                        <input type='hidden' name='o_cart_due[]' class='o_cart_due' value='Y'>
                                                    <?php } else { ?>
                                                        <input type='hidden' name='o_cart_due[]' class='o_cart_due' value=''>
                                                    <?php } ?>
                                                    <label for='cart_due_<?= $frow3['o_golf'] ?>_<?= $i ?>'>의무카트</label>&nbsp;&nbsp;
													<!-- 의무카트 E: -->
													
													<!-- 의무캐디 S: -->
                                                    <?php if ($frow3['o_caddy_due'] == "Y") { ?>
                                                         <input type='checkbox' name='caddy_due[]' class='caddy_due' id='caddy_due_<?= $frow3['o_golf'] ?>_<?= $i ?>' data-idx="<?= $frow3['idx'] ?>" value='Y' checked >
													<?php } else { ?>
                                                         <input type='checkbox' name='caddy_due[]' class='caddy_due' id='caddy_due_<?= $frow3['o_golf'] ?>_<?= $i ?>' data-idx="<?= $frow3['idx'] ?>" value='Y' >
													<?php } ?>
                                                    
													<?php if ($frow3['o_caddy_due'] == "Y") { ?>
                                                        <input type='hidden' name='o_caddy_due[]' class='o_caddy_due' value='Y'>
                                                    <?php } else { ?>
                                                        <input type='hidden' name='o_caddy_due[]' class='o_caddy_due' value=''>
                                                    <?php } ?>
                                                    <label for='caddy_due_<?= $frow3['o_golf'] ?>_<?= $i ?>'>의무캐디</label>&nbsp;&nbsp;
													<!-- 의무캐디 E: -->
													
													
													<!-- 카트포함 S: -->
                                                    <?php if ($frow3['o_cart_cont'] == "Y") { ?>
                                                         <input type='checkbox' name='cart_cont[]' class='cart_cont' id='cart_cont_<?= $frow3['o_golf'] ?>_<?= $i ?>' data-idx="<?= $frow3['idx'] ?>" value='Y' checked >
													<?php } else { ?>
                                                         <input type='checkbox' name='cart_cont[]' class='cart_cont' id='cart_cont_<?= $frow3['o_golf'] ?>_<?= $i ?>' data-idx="<?= $frow3['idx'] ?>" value='Y' >
													<?php } ?>
													
													<?php if ($frow3['o_cart_cont'] == "Y") { ?>
                                                        <input type='hidden' name='o_cart_cont[]' class='o_cart_cont' value='Y'>
                                                    <?php } else { ?>
                                                        <input type='hidden' name='o_cart_cont[]' class='o_cart_cont' value=''>
                                                    <?php } ?>
                                                    <label for='cart_cont_<?= $frow3['o_golf'] ?>_<?= $i ?>'>카트포함</label>&nbsp;&nbsp;
													<!-- 카트포함 E: -->
													
													<!-- 캐디포함 S: -->
                                                    <?php if ($frow3['o_caddy_cont'] == "Y") { ?>
                                                         <input type='checkbox' name='caddy_cont[]' class='caddy_cont' id='caddy_cont_<?= $frow3['o_golf'] ?>_<?= $i ?>' data-idx="<?= $frow3['idx'] ?>" value='Y' checked >
													<?php } else { ?>
                                                         <input type='checkbox' name='caddy_cont[]' class='caddy_cont' id='caddy_cont_<?= $frow3['o_golf'] ?>_<?= $i ?>' data-idx="<?= $frow3['idx'] ?>" value='Y' >
													<?php } ?>
                                                    
													<?php if ($frow3['o_caddy_cont'] == "Y") { ?>
                                                        <input type='hidden' name='o_caddy_cont[]' class='o_caddy_cont' value='Y'>
                                                    <?php } else { ?>
                                                        <input type='hidden' name='o_caddy_cont[]' class='o_caddy_cont' value=''>
                                                    <?php } ?>
                                                    <label for='caddy_cont_<?= $frow3['o_golf'] ?>_<?= $i ?>'>캐디포함</label>&nbsp;&nbsp;
													<!-- 캐디포함 E: -->
													
                                                </td>
                                            </tr>
                                            
                                            </tbody>
                                        </table>
                                    <?php } ?>
                                <?php endforeach; ?>
                            </div>
                        </td>
                        </tr>
                        </table>
						
                        <table cellpadding="0" cellspacing="0" border="1" summary="" class="listTable mem_detail" style="margin-top:10px;">
                        <tr height="45">
                            <th>
                                추가옵션등록
                                <p style="display:block;margin-top:10px;">
                                    <button type="button" id="btn_add_option2" class="btn_01">추가</button>
                                </p>
                            </th>
                            <td>
                                    <span style="color:red;">※ 옵션 삭제 시에 해당 옵션과 연동된 주문, 결제내역에 영향을 미치니 반드시 확인 후에
                                        삭제바랍니다.</span>
                                <div>
                                    <table>
                                        <colgroup>
                                            <col width="*">
                                            </col>
                                            <col width="25%">
                                            </col>
                                            <col width="15%">
                                            </col>
                                        </colgroup>
                                        <thead>
                                        <tr>
                                            <th>옵션명</th>
                                            <th>가격</th>
                                            <th>삭제</th>
                                        </tr>
                                        </thead>
                                        <tbody id="settingBody2">
                                        <?php foreach ($options as $frow3): ?>
                                            <?php if ($frow3['option_type'] == "S") { ?>
                                                <tr color='<?= $_tmp_color ?>' size='<?= $frow2['type'] ?>'>
                                                    <td>
                                                        <input type='hidden' name='o_idx[]'
                                                                value='<?= $frow3['idx'] ?>'/>
                                                        <input type='hidden' name='option_type[]'
                                                                value='<?= $frow3['option_type'] ?>'/>
                                                        <input type='text' name='o_name[]' style='width: 100%;'
                                                                id=''
                                                                value="<?= $frow3['goods_name'] ?>" size="70"/>
                                                    </td>
                                                    <td>
                                                        <input type='text' numberonly='true'
                                                                style='text-align:right;' name='o_price1[]' id=''
                                                                value="<?= $frow3['goods_price1'] ?>"/>
                                                    </td>
                                                    <td>
                                                        <button type="button"
                                                                onclick="delOption('<?= $frow3['idx'] ?>',this)">삭제
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
        </form>

        <!-- // listBottom -->
        <div class="tail_menu">
            <ul>
                <li class="left"></li>
                <li class="right_sub">
                    <a href="list_golf?s_product_code_1=<?= $s_product_code_1 ?>&s_product_code_2=<?= $s_product_code_2 ?>&s_product_code_2=<?= $s_product_code_3 ?>&search_name=<?= $search_name ?>&search_category=<?= $search_category ?>&pg=<?= $pg ?>"
                        class="btn btn-default">
                        <span class="glyphicon glyphicon-th-list"></span>
                        <span class="txt">리스트</span>
                    </a>
                    <a href="javascript:send_it()" class="btn btn-default">
                        <span class="glyphicon glyphicon-cog"></span>
                        <span class="txt">수정</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
    $(".all_input").on("click", function () {
        let targetClass = $(this).attr("id").replace("all_", "code_"); // 해당 그룹 클래스명 추출
        $("." + targetClass).prop("checked", $(this).prop("checked"));
    });

    // 개별 체크박스 클릭 시 "모두 선택" 체크 여부 확인
    $("input[type='checkbox']").not(".all_input").on("click", function () {
        let groupClass = $(this).attr("class"); // 개별 체크박스 클래스
        let allCheckbox = $("#all_" + groupClass.split(" ")[0].replace("code_", "")); // 해당 그룹의 "모두 선택" 체크박스
        let allChecked = $("." + groupClass.split(" ")[0]).length === $("." + groupClass.split(" ")[0] + ":checked").length;
        allCheckbox.prop("checked", allChecked);
    });
});
</script>

<script>
    $(function () {
        var clareCalendar1 = {
            dateFormat: 'yy-m-dd',
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            /* 			changeMonth : true, //월변경가능
                        changeYear : true, //년변경가능 */
            showMonthAfterYear: true, //년 뒤에 월 표시
            yearRange: '2023:2050',//2023~2050
            inline: true,
            /*minDate : 0,//현재날짜로 부터 이전 날짜 비활성화 */
            dateFormat: 'yy-mm-dd',
            minDate: 0,
            prevText: '이전달',
            nextText: '다음달',
            currentText: '오늘',
            yearSuffix: '년',
            onSelect: function (dateText, inst) {
                $("#datepicker1").val(dateText.split("-")[0] + "-" + dateText.split("-")[1] + "-" + dateText.split("-")[2] + "");
                $('.deadline_date').each(function () {
                    $(this).data('daterangepicker').minDate = moment($("#datepicker1").val());
                })
            }
        };

        var clareCalendar2 = {
            dateFormat: 'yy-m-dd',
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
            /* 			changeMonth : true, //월변경가능
                        changeYear : true, //년변경가능 */
            dateFormat: 'yy-mm-dd',
            showMonthAfterYear: true, //년 뒤에 월 표시
            yearRange: '2023:2050',//2023~2050
            inline: true,
            minDate: 0,//현재날짜로 부터 이전 날짜 비활성화 */
            prevText: '이전달',
            nextText: '다음달',
            currentText: '오늘',
            yearSuffix: '년',
            onSelect: function (dateText, inst) {
                $("#datepicker2").val(dateText.split("-")[0] + "-" + dateText.split("-")[1] + "-" + dateText.split("-")[2] + "");
                $('.deadline_date').each(function () {
                    $(this).data('daterangepicker').maxDate = moment($("#datepicker2").val());
                })
            }
        };
        $("#datepicker1").datepicker(clareCalendar1);
        $("#datepicker2").datepicker(clareCalendar2);

    });
</script>

<script type="text/javascript">
    function checkForNumber(str) {
        var key = event.keyCode;
        var frm = document.frm1;
        if (!(key == 8 || key == 9 || key == 13 || key == 46 || key == 144 ||
            (key >= 48 && key <= 57) || (key >= 96 && key <= 105) || key == 110 || key == 190)) {
            event.returnValue = false;
        }
    }
</script>

<script>
    function send_it() {
        var frm = document.frm;

        $("#ajax_loader").removeClass("display-none");

        frm.submit();
    }

    $(document).ready(function () {

        var i = 1;

        $("#btn_add_option").click(function () {

            var g_idx = $("#golf_code option:selected").val();

            if (g_idx == "") {
                alert("홀 선택해주세요.");
                return false;
            }

            var golf_code = $("#golf_code").val();

            var exists = false;
            $('.hole_cnt').each(function () {
                if ($(this).val() == golf_code) {
                    alert('홀이 중복선택 되었습니다.');
                    exists = true; // 일치하는 값이 있으면 true로 설정
                }
            });

            if (exists == false) {
                var golfName = $("#golf_code option:selected").text();


                if ($("#tblgolf" + g_idx).html() == undefined) {


                    var addTable = "";
                    var newIdx   = new Date().getTime(); // 유니크한 ID 생성

                    addTable += "<table id='tab_"+ newIdx +"'>";
                    addTable += "	<colgroup>";
                    addTable += "		<col width='*'></col>";
                    addTable += "		<col width='12%'></col>";
                    addTable += "		<col width='12%'></col>";
                    addTable += "		<col width='12%'></col>";
                    addTable += "		<col width='12%'></col>";
                    addTable += "		<col width='12%'></col>";
                    addTable += "		<col width='12%'></col>";
                    addTable += "		<col width='12%'></col>";
                    addTable += "		<col width='5%'></col>";
                    addTable += "	</colgroup>";
                    addTable += "	<thead>";
                    addTable += "		<tr>";
                    addTable += "			<th>홀수</th>";
                    addTable += "			<th>일</th>";
                    addTable += "			<th>월</th>";
                    addTable += "			<th>화</th>";
                    addTable += "			<th>수</th>";
                    addTable += "			<th>목</th>";
                    addTable += "			<th>금</th>";
                    addTable += "			<th>토</th>";
                    addTable += "			<th>삭제</th>";
                    addTable += "		</tr>";
                    addTable += "	</thead>";
                    addTable += "	<tbody id='tblgolf" + g_idx + "'>";

                    addTable += "	</tbody>";
                    addTable += "</table>";


                    $("#mainGolf").append(addTable);

                }

                var addOption = "";
                addOption += "<tr color='' size='' >												  ";
                addOption += "		<input type='hidden' name='o_idx[]'  value='' />				  ";
                addOption += "		<input type='hidden' name='option_type[]'  value='M' />			  ";
                addOption += "		<input type='hidden' name='o_golf[]'  value='" + g_idx + "' size='70' class='hole_cnt' />		  ";
                addOption += "		<input type='hidden' name='o_name[]'  value='" + golfName + "' size='70' />		  ";
                addOption += "	<td style='text-align:center;' rowspan='4'>																  ";
                addOption += golfName;
                addOption += "	</td>																  ";
                addOption += "	<td>																  ";
                addOption += "		<input type='text' numberonly='true' name='o_price1[]' style='text-align:right;' value='0' /> ";
                addOption += "	</td>																  ";
                addOption += "	<td>																  ";
                addOption += "		<input type='text' numberonly='true' name='o_price2[]' style='text-align:right;' value='0' /> ";
                addOption += "	</td>																  ";
                addOption += "	<td>																  ";
                addOption += "		<input type='text' numberonly='true' name='o_price3[]' style='text-align:right;' value='0' /> ";
                addOption += "	</td>																  ";
                addOption += "	<td>																  ";
                addOption += "		<input type='text' numberonly='true' name='o_price4[]' style='text-align:right;' value='0' /> ";
                addOption += "	</td>																  ";
                addOption += "	<td>																  ";
                addOption += "		<input type='text' numberonly='true' name='o_price5[]' style='text-align:right;' value='0' /> ";
                addOption += "	</td>																  ";
                addOption += "	<td>																  ";
                addOption += "		<input type='text' numberonly='true' name='o_price6[]' style='text-align:right;' value='0' /> ";
                addOption += "	</td>																  ";
                addOption += "	<td>																  ";
                addOption += "		<input type='text' numberonly='true' name='o_price7[]' style='text-align:right;' value='0' /> ";
                addOption += "	</td>																  ";
                addOption += "	<td rowspan='4'>																  ";
                addOption += "		<button type='button' class='delHole' data-idx='"+ newIdx +"'  >삭제</button>	  ";
                addOption += "	</td>																  ";
                addOption += "	</tr>																  ";
                addOption += "	<tr>																  ";
                addOption += "	<td colspan='3'>																  ";
                addOption += "		적용기간: <input type='text' class='datepicker' readonly name='o_sdate[]'  value='' style='width:30%' /> ~ ";
                addOption += "		         <input type='text' class='datepicker' readonly name='o_edate[]'  value='' style='width:30%' /> ";
                addOption += "	</td>																  ";
                addOption += "	<td colspan='4'>																  ";
                addOption += "			     <input type='checkbox' name='o_day_yn[]' id='" + "day_" + g_idx + "_" + i + "' value='Y' checked disabled>";
                addOption += "			     <label for='" + "day_" + g_idx + "_" + i + "'>주간</label>";
                addOption += "			     <input type='text' name='o_day_price[]' value='0' numberonly='true' style='width:20%;text-align:right;'>";

                addOption += "			     <input type='checkbox' name='afternoon_yn[]' class='afternoon_yn' id='" + "afternoon_" + g_idx + "_" + i + "' value='Y'>";
                addOption += "			     <input type='hidden' name='o_afternoon_yn[]' class='o_afternoon_yn' value=''>";
                addOption += "			     <label for='" + "afternoon_" + g_idx + "_" + i + "'>오후</label>";
                addOption += "			     <input type='text' name='o_afternoon_price[]' value='0' numberonly='true' style='width:20%;text-align:right;'>";

                addOption += "			     <input type='checkbox' name='night_yn[]' class='night_yn' id='" + "night_" + g_idx + "_" + i + "' value='Y'>";
                addOption += "			     <input type='hidden' name='o_night_yn[]' class='o_night_yn' value=''>";
                addOption += "			     <label for='" + "night_" + g_idx + "_" + i + "'>야간</label>";
                addOption += "			     <input type='text' name='o_night_price[]' value='0' numberonly='true' style='width:20%;text-align:right;'>단위: 바트)";
				
				
                addOption += "	</td>																  ";
                addOption += "</tr>																	  ";

                addOption += "<tr color='' size=''>";
                addOption += "<td colspan='8'><span class='badge'>왕복</span>&nbsp";
                addOption += "             승용차:      <input type='text' name='vehicle_price1[]' style='width:7%;text-align:right;' value=''/>&nbsp;&nbsp;"; 
                addOption += "             밴 (승합차): <input type='text' name='vehicle_price2[]' style='width:7%;text-align:right;' value=''/>&nbsp;&nbsp;"; 
                addOption += "             SUV:        <input type='text' name='vehicle_price3[]' style='width:7%;text-align:right;' value=''/>&nbsp;&nbsp;&nbsp;"; 
				
                addOption += "             <span class='badge'>편도</span>&nbsp";
                addOption += "             승용차:      <input type='text' name='vehicle_o_price1[]' style='width:7%;text-align:right;' value=''/>&nbsp;&nbsp;"; 
                addOption += "             밴 (승합차): <input type='text' name='vehicle_o_price2[]' style='width:7%;text-align:right;' value=''/>&nbsp;&nbsp;"; 
                addOption += "             SUV:        <input type='text' name='vehicle_o_price3[]' style='width:7%;text-align:right;' value=''/>(단위: 바트)"; 
				
                addOption += "</td>";
                addOption += "</tr>";
                addOption += "<tr color='' size=''>";
                addOption += "<td colspan='8'>";
                addOption += "             카트:       <input type='text' name='cart_price[]' style='width:6%;text-align:right;' value=''/>&nbsp;&nbsp;&nbsp;"; 
                addOption += "             캐디피:     <input type='text' name='caddie_fee[]' style='width:6%;text-align:right;' value=''/>"; 
				
                addOption += "             <input type='checkbox' name='cart_due[]' class='cart_due' id='" + "cart_due_" + g_idx + "_" + i + "' value='Y'>";
                addOption += "			   <input type='hidden' name='o_cart_due[]' class='o_cart_due' value=''>";
                addOption += "             <label for=''" + "cart_due_" + g_idx + "_" + i + "'>의무카트</label>";
				
                addOption += "             <input type='checkbox' name='caddy_due[]' class='caddy_due' id='" + "caddy_due_" + g_idx + "_" + i + "' value='Y'>";
                addOption += "			   <input type='hidden' name='o_caddy_due[]' class='o_caddy_due' value=''>";
                addOption += "             <label for=''" + "caddy_due_" + g_idx + "_" + i + "'>의무캐디</label>";
				
                addOption += "             <input type='checkbox' name='cart_cont[]' class='cart_cont' id='" + "cart_cont_" + g_idx + "_" + i + "' value='Y'>";
                addOption += "			   <input type='hidden' name='o_cart_cont[]' class='o_cart_cont' value=''>";
                addOption += "             <label for=''" + "cart_cont_" + g_idx + "_" + i + "'>카트포함</label>";
				
                addOption += "             <input type='checkbox' name='caddy_cont[]' class='caddy_cont' id='" + "caddy_cont_" + g_idx + "_" + i + "' value='Y'>";
                addOption += "			   <input type='hidden' name='o_caddy_cont[]' class='o_caddy_cont' value=''>";
                addOption += "             <label for=''" + "caddy_cont_" + g_idx + "_" + i + "'>캐디포함</label>";
                addOption += "</td>";
                addOption += "</tr>";

                $("#tblgolf" + g_idx).append(addOption);
                i++;
                $(".datepicker").datepicker();
                $(".afternoon_yn").change(function () {
                    if ($(this).is(":checked")) {                        
                        $(this).closest("td").find(".o_afternoon_yn").val("Y");
                    } else {
                        $(this).closest("td").find(".o_afternoon_yn").val("");
                    }                    
                });
                $(".night_yn").change(function () {
                    if ($(this).is(":checked")) {
                        $(this).closest("td").find(".o_night_yn").val("Y");
                    } else {
                        $(this).closest("td").find(".o_night_yn").val("");
                    }
                });
                
                $(".cart_due").change(function () {
                    if ($(this).is(":checked")) {
                        $(this).closest("td").find(".o_cart_due").val("Y");
                    } else {
                        $(this).closest("td").find(".o_cart_due").val("");
                    }
                });
                
                $(".caddy_due").change(function () {
                    if ($(this).is(":checked")) {
                        $(this).closest("td").find(".o_caddy_due").val("Y");
                    } else {
                        $(this).closest("td").find(".o_caddy_due").val("");
                    }
                });
                
                $(".cart_cont").change(function () {
                    if ($(this).is(":checked")) {
                        $(this).closest("td").find(".o_cart_cont").val("Y");
                    } else {
                        $(this).closest("td").find(".o_cart_cont").val("");
                    }
                });
                
                $(".caddy_cont").change(function () {
                    if ($(this).is(":checked")) {
                        $(this).closest("td").find(".o_caddy_cont").val("Y");
                    } else {
                        $(this).closest("td").find(".o_caddy_cont").val("");
                    }
                });
                
                // 동적으로 생성된 행 삭제 (이벤트 위임 사용)
                $(".delHole").click(function() {
                    var tab = $(this).data('idx');
                    $("#tab_"+tab).remove();
                });						
            }
        });


        $("#btn_add_option2").click(function () {

            var newOpt    = new Date().getTime(); // 유니크한 ID 생성
            var addOption = "";
            addOption += "<tr color='' size='' id='opt_"+ newOpt +"' >												  ";
            addOption += "	<td>																  ";
            addOption += "		<input type='hidden' name='o_idx[]'  value='' />				  ";
            addOption += "		<input type='hidden' name='option_type[]'  value='S' />			  ";
            addOption += "		<input type='text' name='o_name[]' style='width: 100%;' value='' size='70' />		  ";
            addOption += "	</td>																  ";
            addOption += "	<td>																  ";
            addOption += "		<input type='text' class='onlynum' name='o_price1[]' numberonly='true' value='' style='text-align:right;'/>  ";
            addOption += "	</td>																  ";
            addOption += "	<td>																  ";
            addOption += '		<button type="button" class="removeOpt" data-idx="'+ newOpt +'" >삭제</button>	  ';
            addOption += "	</td>																  ";
            addOption += "</tr>																	  ";

            $("#settingBody2").append(addOption);

        });

        // 동적으로 생성된 행 삭제 (이벤트 위임 사용)
        $(document).on("click", ".removeOpt", function() {
            var tab = $(this).data('idx');
            $("#opt_" + tab).remove();
        });
        
    });

    $(".afternoon_yn").change(function () {
        if ($(this).is(":checked")) {
            $(this).closest("td").find(".o_afternoon_yn").val("Y");
        } else {
            $(this).closest("td").find(".o_afternoon_yn").val("");
        }
    });
	
    $(".night_yn").change(function () {
        if ($(this).is(":checked")) {
            $(this).closest("td").find(".o_night_yn").val("Y");
        } else {
            $(this).closest("td").find(".o_night_yn").val("");
        }
    });
	
    $(".cart_due").change(function () {
        if ($(this).is(":checked")) {
            $(this).closest("td").find(".o_cart_due").val("Y");
        } else {
            $(this).closest("td").find(".o_cart_due").val("");
        }
    });
	
    $(".caddy_due").change(function () {
        if ($(this).is(":checked")) {
            $(this).closest("td").find(".o_caddy_due").val("Y");
        } else {
            $(this).closest("td").find(".o_caddy_due").val("");
        }
    });
	
    $(".cart_cont").change(function () {
        if ($(this).is(":checked")) {
            $(this).closest("td").find(".o_cart_cont").val("Y");
        } else {
            $(this).closest("td").find(".o_cart_cont").val("");
        }
    });
	
    $(".caddy_cont").change(function () {
        if ($(this).is(":checked")) {
            $(this).closest("td").find(".o_caddy_cont").val("Y");
        } else {
            $(this).closest("td").find(".o_caddy_cont").val("");
        }
    });
</script>

<script>
    function updOption(idx) {
        location.href = '/AdmMaster/_tourRegist/list_golf_price?o_idx=' + idx + '&product_idx=' + $("#product_idx").val();
    }
</script>

<script>

    $(document).ready(function () {
        // 숫자 전용 입력 처리
        $('.numberOnly').on('input', function () {
            // 입력값에서 숫자가 아닌 문자는 제거
            $(this).val($(this).val().replace(/[^0-9]/g, ''));
        });
    });

    function delOption(idx) {

        if (!confirm("가격정보를 삭제 하시겠습니까?"))
            return false;

        $.ajax({

            url: "/ajax/golf_option_delete",
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
</script>

<script>

    $("#btn_add_optionx").click(function () {

        var addOption = "";
        addOption += "<tr color='' size='' >												  ";
        addOption += "	<td>																  ";
        addOption += "		<input type='hidden' name='o_idx[]'  value='' />	  ";
        addOption += "		<input type='hidden' name='option_type[]'  value='M' />	  ";
        addOption += "		<input type='file' name='a_file[]'  value='' style='display:none;' />					  ";
        addOption += "		<input type='text' name='o_name[]'  value='' size='70' />	  ";
        addOption += "	</td>																  ";
        addOption += "	<td>																  ";
        addOption += "		<input type='text' class='onlynum' name='o_price[]'  value='' />	  ";
        addOption += "	</td>																  ";
        addOption += "	<td>																  ";
        addOption += "		<select name='ues_yn[]'>	                                      ";
        addOption += "		<option value='Y'>판매</option>    	                              ";
        addOption += "		<option value='N'>중지</option>    	                              ";
        addOption += "		</select>	                                                      ";
        addOption += "	</td>																  ";
        addOption += "	<td>																  ";
        addOption += '		<button type="button" onclick="delOption(\'\',this)">삭제</button>	  ';
        addOption += "	</td>																  ";
        addOption += "</tr>																	  ";

        $("#settingBody").append(addOption);

    });

    function add_option(code_idx) {
        var addOption = "";
        addOption += "<tr color='' size='' >												  ";

        addOption += "	<td>																  ";
        addOption += "		<input type='hidden' name='o_idx[]'  value='' />	  ";
        addOption += "		<input type='hidden' name='option_type[]'  value='M' />	  ";
        addOption += "		<input type='file' name='a_file[]'  value='' style='display:none;' />					  ";
        addOption += "		<input type='text' name='o_name[]'  value='' size='70' />	  ";
        addOption += "	</td>																  ";
        addOption += "	<td>																  ";
        addOption += "		<input type='text' class='onlynum' name='o_price[]'  value='' />	  ";
        addOption += "	</td>																  ";
        addOption += "	<td>																  ";
        addOption += "		<select name='ues_yn[]'>	                                      ";
        addOption += "		<option value='Y'>판매</option>    	                              ";
        addOption += "		<option value='N'>중지</option>    	                              ";
        addOption += "		</select/>	                                                      ";
        addOption += "	</td>																  ";
        addOption += "	<td>																  ";
        addOption += "		<input type='text' class='onlynum' name='o_num[]'  value='' />	  ";
        addOption += "	</td>																  ";
        addOption += "	<td>																  ";
        addOption += '		<button type="button" onclick="delOption(\'\',this)">삭제</button>	  ';
        addOption += "	</td>																  ";
        addOption += "</tr>																	  ";

        $("#settingBody_" + code_idx).append(addOption);
    }

    function upd_moption(code_idx) {
        var message = "";
        $.ajax({

            url: "/AdmMaster/_tourRegist/write_golf/upd_moption/" + code_idx,
            type: "PUT",
            data: {
                "goods_price": $("#goods_price_" + code_idx).val(),
                "goods_price1": $("#goods_price1_" + code_idx).val(),
                "goods_price2": $("#goods_price2_" + code_idx).val(),
                "goods_price3": $("#goods_price3_" + code_idx).val(),
                "goods_price4": $("#goods_price4_" + code_idx).val(),
                "goods_price5": $("#goods_price5_" + code_idx).val(),
                "goods_price6": $("#goods_price6_" + code_idx).val(),
                "goods_price7": $("#goods_price7_" + code_idx).val(),
                "caddy_fee": $("#caddy_fee_" + code_idx).val(),
                "cart_pie_fee": $("#cart_pie_fee_" + code_idx).val(),
            },
            dataType: "json",
            async: false,
            cache: false,
            success: function (data, textStatus) {
                message = data.message;
                alert(message);
                // location.reload();
            },
            error: function (request, status, error) {
                alert("code = " + request.status + " message = " + request.responseText + " error = " + error); // 실패 시 처리
            }
        });
    }

    function add_moption() {
        var message = "";
        $.ajax({
            url: "/AdmMaster/_tourRegist/write_golf/add_moption",
            type: "POST",
            data: {
                "product_idx": '<?=$product_idx?>',
                "moption_hole": $("#moption_hole").val(),
                "moption_hour": $("#moption_hour").val(),
                "moption_minute": $("#moption_minute").val()
            },
            async: false,
            cache: false,
            success: function (data, textStatus) {
                $("#list_option").append(data);
            },
            error: function (request, status, error) {
                alert("code = " + request.status + " message = " + request.responseText + " error = " + error); // 실패 시 처리
            }
        });
    }

    function date_moption(idx) {
        location.href = "/AdmMaster/_tourRegist/list_golf_price?product_idx=" + idx;
    }

    function del_moption(code_idx) {
        if (!confirm("선택한 옵션을 정말 삭제하시겠습니까?\n\n한번 삭제한 자료는 복구할 수 없습니다."))
            return false;

        var message = "";
        $.ajax({

            url: "/AdmMaster/_tourRegist/write_golf/del_moption/" + code_idx,
            type: "DELETE",
            dataType: "json",
            async: false,
            cache: false,
            success: function (data, textStatus) {
                message = data.message;
                alert(message);
                $("#option_" + code_idx).remove();
                location.reload();
            },
            error: function (request, status, error) {
                alert("code = " + request.status + " message = " + request.responseText + " error = " + error); // 실패 시 처리
            }
        });

    }

    function upd_option(code_idx) {
        var option_data = jQuery("#optionForm_" + code_idx).serialize();
        var save_result = "";

        $.ajax({
            type: "POST",
            data: option_data,
            url: "/ajax/ajax.add_option.php",
            cache: false,
            async: false,
            success: function (data, textStatus) {
                save_result = data;
                //alert('save_result- '+save_result);
                var obj = jQuery.parseJSON(save_result);
                var message = obj.message;
                alert(message);
                location.reload();
            },
            error: function (request, status, error) {
                alert("code = " + request.status + " message = " + request.responseText + " error = " + error); // 실패 시 처리
            }
        });
    }
</script>

<iframe width="300" height="300" name="hiddenFrame" id="hiddenFrame" src="" style="display:none"></iframe>
<?= $this->endSection() ?>