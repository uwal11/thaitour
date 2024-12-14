<?php $this->extend('inc/layout_index'); ?>

<?php $this->section('content'); ?>

    <div class="content-sub-hotel-detail custom-golf-detail">
    <div class="body_inner">
        <div>
            <form name="frm" id="frm" action="/product-golf/customer-form" class="section1">
                <input type="hidden" name="product_idx" value="<?= $product['product_idx'] ?>">
                <input type="hidden" name="order_date" id="order_date" value="">
                <input type="hidden" name="option_idx" id="option_idx" value="">
                <input type="hidden" name="use_coupon_idx" id="use_coupon_idx" value="">
                <input type="hidden" id="total_price" value="">
                <input type="hidden" id="total_price_baht" value="">
                <?php foreach ($golf_price as $price) { ?>
                    <input type="hidden" id="firstDate" value="<?= $price['golf_date'] ?>">
                    <input type="hidden" id="firstPrice" value="<?= $price['option_price'] ?>">
                <?php } ?>

                <div class="title-container">
                    <h2><?= viewSQ($product['product_name']) ?></h2>
                    <div class="list-icon">
                        <img src="/uploads/icons/print_icon.png" alt="print_icon" class="only_web">
                        <img src="/uploads/icons/print_icon_mo.png" alt="print_icon_mo" class="only_mo">
                        <img src="/uploads/icons/heart_icon.png" alt="heart_icon" class="only_web">
                        <img src="/uploads/icons/heart_icon_mo.png" alt="heart_icon_mo" class="only_mo">
                        <img src="/uploads/icons/share_icon.png" alt="share_icon" class="only_web">
                        <img src="/uploads/icons/share_icon_mo.png" alt="share_icon_mo" class="only_mo">
                    </div>
                </div>
                <div class="location-container">
                    <img src="/uploads/icons/location_blue_icon.png" alt="location_blue_icon">
                    <span><?= $product['addrs'] ?></span>
                </div>
                <div class="rating-container">
                    <img src="/uploads/icons/star_icon.png" alt="star_icon.png">
                    <span><strong><?= $product['review_average'] ?></strong></span>
                    <span>생생리뷰 <strong>(<?= $product['total_review'] ?>)</strong></span>
                </div>
                <div class="hotel-image-container">
                    <div class="hotel-image-container-1" style="<?= $imgs[0] == '' ? 'visibility: hidden' : '' ?>">
                        <img src="<?= $imgs[0] ?>" alt="<?= $img_names[0] ?>">
                    </div>
                    <div class="grid_2_2">
                        <img class="grid_2_2_size" src="<?= $imgs[1] ?>" alt="<?= $img_names[1] ?>"
                             style="<?= $imgs[1] == '' ? 'visibility: hidden' : '' ?>">
                        <img class="grid_2_2_size" src="<?= $imgs[2] ?>" alt="<?= $img_names[2] ?>"
                             style="<?= $imgs[2] == '' ? 'visibility: hidden' : '' ?>">
                        <img class="grid_2_2_size" src="<?= $imgs[3] ?>" alt="<?= $img_names[3] ?>"
                             style="<?= $imgs[3] == '' ? 'visibility: hidden' : '' ?>">
                        <div class="grid_2_2_sub"
                             style="position: relative; cursor: pointer;<?= $imgs[4] == '' ? 'visibility: hidden;' : '' ?>"
                             onclick="img_pops('<?= $product['product_idx'] ?>')">
                            <img class="custom_button" src="<?= $imgs[4] ?>" alt="<?= $img_names[4] ?>">
                            <div class="button-show-detail-image"
                                 style="<?= $imgs[5] == '' ? 'visibility: hidden' : '' ?>">
                                <img class="only_web" src="/uploads/icons/image_detail_icon.png"
                                     alt="image_detail_icon">
                                <img class="only_mo" src="/uploads/icons/image_detail_icon_m.png"
                                     alt="image_detail_icon_m">
                                <span>사진 모두 보기</span>
                                <span>(<?= count($imgs) - 5 ?>장)</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sub-header-hotel-detail">
                    <div class="main">
                        <a class="short_link active" data-target="product_info" href="#product_info">상품 정보</a>
                        <a class="short_link" data-target="pickup" href="#pickup">상품예약</a>
                        <a class="short_link" data-target="product_des" href="#product_des">상품설명</a>
                        <a class="short_link" data-target="location" href="#location">위치정보</a>
                        <a class="short_link" data-target="review" href="#review">생생리뷰(<?= $product['total_review'] ?>
                            개)</a>
                        <a class="short_link" data-target="qna" href="#qna">상품 Q&A</a>
                    </div>
                    <div class="btn-container">
                        <a class="w-100" href="#!" data-target="#booking_area" onclick="handleShowBookingArea(this)">
                            <button type="button">
                                상품예약
                            </button>
                        </a>
                    </div>
                </div>
                <h3 class="title-size-24" id="product_info">상품 정보</h3>
                <table class="golf-table">
                    <thead>
                    <tr>
                        <th>더투어랩 평가 등급</th>
                        <th>
                            <div class="rating-list">
                                <?php if ($info['star_level'] > 0) { ?><img src="/uploads/icons/star_icon.png"
                                                                            alt="star_icon"><?php } ?>
                                <?php if ($info['star_level'] > 1) { ?><img src="/uploads/icons/star_icon.png"
                                                                            alt="star_icon"><?php } ?>
                                <?php if ($info['star_level'] > 2) { ?><img src="/uploads/icons/star_icon.png"
                                                                            alt="star_icon"><?php } ?>
                                <?php if ($info['star_level'] > 3) { ?><img src="/uploads/icons/star_icon.png"
                                                                            alt="star_icon"><?php } ?>
                                <?php if ($info['star_level'] > 4) { ?><img src="/uploads/icons/star_icon.png"
                                                                            alt="star_icon"><?php } ?>
                            </div>
                        </th>
                        <th>총홀수</th>
                        <th><?= $info['holes_number'] ?></th>
                        <th>휴무일</th>
                        <th><?= $info['holidays'] ?></th>
                    </tr>
                    </thead>
                    <tbody class="text-gray">
                    <tr>
                        <td>시내에서 거리 및 이동기간</td>
                        <td><?= $info['distance_from_center'] ?></td>
                        <td>공항에서 거리 및 이동시간</td>
                        <td><?= $info['distance_from_airport'] ?></td>
                        <td>팀당 라운딩 인원</td>
                        <td><?= $info['num_of_players'] ?></td>
                    </tr>
                    <tr>
                        <td>전동카트</td>
                        <td colspan="5"><?= $info['electric_car'] ?></td>
                    </tr>
                    <tr>
                        <td>갤러리피</td>
                        <td colspan="5"><?= $info['caddy'] ?></td>
                    </tr>
                    <tr>
                        <td>장비렌탈</td>
                        <td colspan="5"><?= $info['equipment_rent'] ?></td>
                    </tr>
                    <tr>
                        <td>스포츠데이</td>
                        <td colspan="5"><?= $info['sports_day'] ?></td>
                    </tr>
                    </tbody>
                </table>
                <h3 id="pickup" class="title-size-24 text-parent">상품 예약<span>날짜 · 홀수 ·인원 ·시간대를 먼저 선택해 주세요.</span></h3>
                <div class="calendar">
                    <div class="year">
                        <img src="/uploads/icons/year_prev_icon.png" alt="year_prev_icon" srcset="" id="prev_icon"
                             class="only_web">
                        <img src="/uploads/icons/year_prev_icon_mo.png" alt="year_prev_icon" srcset="" id="prev_icon"
                             class="only_mo">
                        <span><span id="year"></span>년 <span id="month"></span>월</span>
                        <img src="/uploads/icons/year_next_icon.png" alt="next_icon" srcset="" id="next_icon"
                             class="only_web">
                        <img src="/uploads/icons/year_next_icon_mo.png" alt="next_icon" srcset="" id="next_icon"
                             class="only_mo">
                    </div>
                    <div class="dates">
                        <div class="swiper-button-next swiper-button swiper-button-custom">
                            <img src="/uploads/icons/next_day_icon.png" alt="year_next_icon" class="only_web">
                        </div>
                        <div class="swiper-button-prev swiper-button swiper-button-custom">
                            <img src="/uploads/icons/prev_day_icon.png" alt="prev_day_icon" class="only_web">
                        </div>
                        <div class="swiper-button-prev swiper-button swiper-button-custom only_mo">
                            <img src="/uploads/icons/prev_day_icon_mo.png" alt="prev_day_icon">
                        </div>
                        <div class="swiper-button-next swiper-button swiper-button-custom only_mo">
                            <img src="/uploads/icons/next_day_icon_mo.png" alt="next_day_icon">
                        </div>
                        <div class="calendar-swiper-container swiper-container">
                            <div class="calendar-swiper-wrapper swiper-wrapper"></div>
                        </div>
                    </div>
                </div>
                <div class="tag-con-below-calendar">
                    <div class="flex" style="justify-content: space-between">
                        <div class="item-tag">
                            <span class="label">홀수</span>
                            <div class="tag-list">
                                <?php foreach ($hole_cnt_arr as $hole) : ?>
                                    <span class="tag tag-js" data-tab="<?= $hole ?>"><?= $hole ?>홀</span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                        <div class="item-tag new">
                            <span class="label">인원</span>
                            <select class="select_custom_ active_ cus-width" onchange="changePeople()"
                                    name="people_adult_cnt" id="people_adult_cnt">
                                <option value="">선택해주세요.</option>
                                <?php
                                $min = floatval($product['minium_people_cnt']);
                                $max = floatval($product['total_people_cnt']);
                                for ($i = $min; $i <= $max; $i++) {
                                    echo '<option value="' . $i . '">' . $i . '인</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="box-selecter flex_b_c">
                        <div class="ic_item">
                            <div class="title">주/야간 선택 </div>
                            <div class="body-box flex">
                                <div class="box day_option day_option_first flex_1 active" >
                                    <p>주간</p>
                                </div>
                                <div class="box day_option day_option_second flex_1">
                                    <p>야간</p>
                                </div>
                            </div>
                        </div>
                        <div class="ic_item">
                            <div class="title">티오프 시간 선택</div>
                            <div class="body-box flex">
                                <select class="box flex_1" id="hoursDay" onchange="">
                                    <option value="">선택</option>
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                </select>
                                <select class="box flex_1" id="minuteDay" onchange="">
                                    <option value="">선택</option>
                                        <option value="00">00</option>
                                        <option value="01">01</option>
                                        <option value="02">02</option>
                                        <option value="03">03</option>
                                        <option value="04">04</option>
                                        <option value="05">05</option>
                                        <option value="06">06</option>
                                        <option value="07">07</option>
                                        <option value="08">08</option>
                                        <option value="09">09</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                        <option value="13">13</option>
                                        <option value="14">14</option>
                                        <option value="15">15</option>
                                        <option value="16">16</option>
                                        <option value="17">17</option>
                                        <option value="18">18</option>
                                        <option value="19">19</option>
                                        <option value="20">20</option>
                                        <option value="21">21</option>
                                        <option value="22">22</option>
                                        <option value="23">23</option>
                                        <option value="24">24</option>
                                        <option value="25">25</option>
                                        <option value="26">26</option>
                                        <option value="27">27</option>
                                        <option value="28">28</option>
                                        <option value="29">29</option>
                                        <option value="30">30</option>
                                        <option value="31">31</option>
                                        <option value="32">32</option>
                                        <option value="33">33</option>
                                        <option value="34">34</option>
                                        <option value="35">35</option>
                                        <option value="36">36</option>
                                        <option value="37">37</option>
                                        <option value="38">38</option>
                                        <option value="39">39</option>
                                        <option value="40">40</option>
                                        <option value="41">41</option>
                                        <option value="42">42</option>
                                        <option value="43">43</option>
                                        <option value="44">44</option>
                                        <option value="45">45</option>
                                        <option value="46">46</option>
                                        <option value="47">47</option>
                                        <option value="48">48</option>
                                        <option value="49">49</option>
                                        <option value="50">50</option>
                                        <option value="51">51</option>
                                        <option value="52">52</option>
                                        <option value="53">53</option>
                                        <option value="54">54</option>
                                        <option value="55">55</option>
                                        <option value="56">56</option>
                                        <option value="57">57</option>
                                        <option value="58">58</option>
                                        <option value="59">59</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="box-selecter">
                        <div class="titles">선택옵션</div>
                        <div class="select-more-body flex__c">
						    <?php $seq = 1;?>
						    <?php foreach ($result_opt as $option) : ?>
                            <div class="item">
                                <div class="item_left flex__c">
                                    <span class="tit">추가옵션<?=$seq++;?></span>
                                    <p class="content" rel="<?=$option['goods_name']?>"><?=$option['goods_name']?></p>
                                </div>
                                <div class="item_right flex__c">
                                    <span class="pri" rel="<?=$option['goods_price1']?>">￦<?=number_format($option['goods_price1'])?></span>
                                    <input type="hidden" name="option_idx[]" value="<?= $option['idx'] ?>">
                                    <select data-name="<?=$option['goods_name']?>" 
									        data-price="<?=$option['goods_price1']?>" 
											data-price_baht="<?=(int)($option['goods_price1'] * $baht_thai)?>" class="option_select select_custom_ active_ cus-width" name="option_cnt[]" onchange="calculatePrice();"> 
                                        <option value="0">선택</option>
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
										<option value="26">26</option>
										<option value="27">27</option>
										<option value="28">28</option>
										<option value="29">29</option>
										<option value="30">30</option>
								</select>
                                </div>
                            </div>
                            <?php endforeach; ?>

                            <!--div class="item">
                                <div class="item_left flex__c">
                                    <span class="tit">추가선택2</span>
                                    <p class="content" rel="1인객실사용료 (싱글차지) / 박당 (+80,000원)">1인객실사용료 (싱글차지) / 박당 (+80,000원)</p>
                                </div>
                                <div class="item_right flex__c">
                                    <span class="pri" rel="80000">￦80,000</span>
                                    <select name="sel_cnt[]" id="" onchange="writePrice()">
                                        <option value="0">선택</option>
                                                                                <option value="1">1</option>
                                                                                <option value="2">2</option>
                                                                                <option value="3">3</option>
                                                                                <option value="4">4</option>
                                                                                <option value="5">5</option>
                                                                                <option value="6">6</option>
                                                                                <option value="7">7</option>
                                                                                <option value="8">8</option>
                                                                                <option value="9">9</option>
                                                                                <option value="10">10</option>
                                                                                <option value="11">11</option>
                                                                                <option value="12">12</option>
                                                                                <option value="13">13</option>
                                                                                <option value="14">14</option>
                                                                                <option value="15">15</option>
                                                                                <option value="16">16</option>
                                                                                <option value="17">17</option>
                                                                                <option value="18">18</option>
                                                                                <option value="19">19</option>
                                                                                <option value="20">20</option>
                                                                                <option value="21">21</option>
                                                                                <option value="22">22</option>
                                                                                <option value="23">23</option>
                                                                                <option value="24">24</option>
                                                                                <option value="25">25</option>
                                                                                <option value="26">26</option>
                                                                                <option value="27">27</option>
                                                                                <option value="28">28</option>
                                                                                <option value="29">29</option>
                                                                                <option value="30">30</option>
                                                                        </select>
                                </div>
                            </div-->
                        </div>
                    </div>
                    <div class="tag-list">
                        <?php foreach ($hour_arr as $hour) : ?>
                            <span class="tag tag-js2" data-tab="<?= $hour ?>"><?= $hour ?>시</span>
                            <!--span class="tag tag-js2" data-tab="06">06시</span>
                            <span class="tag tag-js2" data-tab="07">07시</span>
                            <span class="tag tag-js2" data-tab="08">08시</span>
                            <span class="tag tag-js2" data-tab="09">09시</span>
                            <span class="tag tag-js2" data-tab="10">10시</span>
                            <span class="tag tag-js2" data-tab="11">11시</span>
                            <span class="tag tag-js2" data-tab="12">12시</span>
                            <span class="tag tag-js2" data-tab="13">13시</span>
                            <span class="tag tag-js2" data-tab="14">14시</span>
                            <span class="tag tag-js2" data-tab="15">14시</span>
                            <span class="tag tag-js2" data-tab="16">16시</span-->
                        <?php endforeach; ?>
                    </div>
                </div>

        </div>
        <div class="date-text-2">
            <div class="result_select">
                <p class="final_date"></p> /
                <p class="final_hole">0</p><span>홀수</span> /
                <p class="final_hour">00</p><span>시</span> /
                <p class="final_people_cnt">0</p><span>인</span>
            </div>
            <p>※ 아래 요금은 1인당 가격입니다.</p>
        </div>
        <div class="card-content" id="final_option_list"></div>
        <div class="section1-sub">
            <h3 class="title-size-24 text-parent">골프장 왕복 픽업 차량<span>※선택 옵션입니다. 추가 원하시면 선택해 주세요.</span></h3>
        </div>
        <div class="list-select-element">
            <?php foreach ($golfVehicles as $value) : ?>
                <div class="item-select">
                    <span class="label"><?= $value['code_name'] ?></span>
                    <input type="hidden" name="vehicle_idx[]" value="<?= $value['code_idx'] ?>">
                    <select
                            data-name="<?= $value['code_name'] ?>"
                            data-price="<?= $value['price'] ?>"
                            data-price_baht="<?= $value['price_baht'] ?>"
                            class="vehicle_select select_custom_ active_ cus-width"
                            name="vehicle_cnt[]">
                        <option value="">선택해주세요.</option>
                        <?php for ($i = $value['min_cnt']; $i <= $value['max_cnt']; $i++) : ?>
                            <option value="<?= $i ?>"><?= $i ?>개</option>
                        <?php endfor; ?>
                    </select>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="section2-sub">
            <div class="left-main">
                <h3 class="tit-left">피닉스 골드 골프 방콕 (구 · 수완나품 컨트리클럽) </h3>
                <p>
                    <span class="l-label">일정</span>
                    <span class="l-label2 final_date"></span>
                </p>
                <p>
                    <span class="l-label">홀수</span>
                    <span class="l-label2"><em class="final_hole">0</em>홀</span>
                </p>
                <p>
                    <span class="l-label">티오프시간</span>
                    <span class="l-label2"><em class="final_hour">00</em>시 <em class="final_minute">00</em>분</span>
                </p>
                <p>
                    <span class="l-label">인원</span>
                    <span class="l-label2"><em class="final_people_cnt">0</em>인</span>
                </p>
                <!--button class="btn-price-content-normal" type="button"
                        onclick="showCouponPop()">쿠폰적용
                </button-->
                <!--button class="btn-price-content-normal" type="button" onclick="cartAdd()">장바구니 담기</button-->
            </div>
            <div class="right-main" id="booking_area">
                <div class="item-right">
                    <div class="list-text">
                        <p><span class="text-gray">그린피 : </span><em id="final_option_price">0</em> 원
                            (1인 <em id="final_option_price_baht">0</em>바트 X <em class="final_people_cnt">0</em>인)</p>
                        <p><span class="text-gray">캐디피 : </span><em id="final_caddy_fee">그린피에 포함</em></p>
                        <p><span class="text-gray">카트피 : </span><em id="final_cart_pie_fee">그린피에 포함</em></p>
                    </div>
                    <span class="price-text text-gray"><em id="total_final_option_price">0</em> 원 (<em
                                id="total_final_option_price_baht">0</em>바트)</span>
                </div>
                <div class="vehicle_list_result" id="vehicle_list_result"></div>
                <div class="option_list_result" id="option_list_result"></div>
                <!--div class="item-right cus-border">
                    <p><span class="">쿠폰 적용</span></p>
                    <span class="price-text">- <em id="final_discount">0</em>원 (<em
                                id="final_discount_baht">0</em>원)</span>
                </div-->
                <div class="item-last-right">
                    <p>합계</p>
                    <p class="price-text"><em id="last_price">0</em><span> 원(<em id="last_price_baht">0</em>바트)</span>
                    </p>
                </div>
                <?php if ($product['product_status'] == 'sale'): ?>
                    <button class="btn-price-content" type="button" onclick="handleSubmit()">예약하기</button>
                <?php endif; ?>
            </div>
        </div>
        </form>
        <h3 class="title-size-24" id="product_des">상품설명</h3>
        <div class="container-big-text">
            <?= viewSQ($product['tour_info']) ?>
        </div>
        <h3 class="title-size-24" id="location">위치정보</h3>
        <div id="map" style="width: 100%; height: 450px;"></div>
        <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"/>
        <script>
            var lat = '<?= $product['latitude'] ?>' || 13.7563;
            var lng = '<?= $product['longitude'] ?>' || 100.5018;
            var map = L.map('map').setView([lat, lng], 17);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: 'The Tour Lab'
            }).addTo(map);
            L.marker([lat, lng]).addTo(map)
        </script>
        <div class="location-container">
            <img src="/uploads/icons/location_blue_icon.png" alt="location_blue_icon">
            <span class="text-gray"><?= $product['addrs'] ?></span>
        </div>

        <?php echo view("/product/inc/review_product"); ?>

        <div class="section6">
            <h2 class="title-sec6" id="qna"><span>상품 Q&A</span>(516)</h2>
            <div class="qa-section">
                <div class="custom-area-text">
                    <label class="custom-label" for="qa-comment">
                            <textarea name="qa-comment" id="qa-comment"
                                      class="custom-main-input-style textarea autoExpand"
                                      placeholder="상품에 대해 궁금한 점을 물어보세요."></textarea>
                    </label>
                    <div type="submit" class="qa-submit-btn">등록</div>
                </div>


                <ul class="qa-list">
                    <li class="qa-item">
                        <div class="qa-question">
                            <span class="qa-number">124</span>
                            <span class="qa-tag normal-style">답변대기중</span>
                            <div class="con-cus-mo-qa">
                                <p class="qa-text">티켓은 어떻게 예약할 수 있나요?</p>
                                <div class="qa-meta text-gray only_mo">2024.07.24 09:39</div>
                            </div>
                        </div>
                        <div class="qa-meta text-gray only_web">2024.07.24 09:39</div>
                    </li>
                    <li class="qa-item">
                        <div class="qa-question">
                            <span class="qa-number">123</span>
                            <span class="qa-tag">답변대기중</span>
                            <div class="con-cus-mo-qa">
                                <p class="qa-text">결제 시점은 언제인가요?</p>
                                <div class="qa-meta text-gray only_mo">2024.07.24 09:39</div>
                            </div>
                        </div>
                        <div class="qa-meta text-gray only_web">2024.07.24 09:39</div>
                    </li>
                    <li class="qa-item">
                        <div class="qa-question">
                            <span class="qa-number">122</span>
                            <span class="qa-tag normal-style">답변대기중</span>
                            <div class="con-cus-mo-qa">
                                <p class="qa-text">2월23일 성인 8명, 어린이 2명으로 예약하면 10명인데요. 통로역 근처인 저희 호텔로 외주실수...</p>
                                <div class="qa-meta text-gray only_mo">2024.07.24 09:39</div>
                            </div>
                        </div>
                        <div class="qa-meta text-gray only_web">2024.07.24 09:39</div>
                    </li>
                    <li class="qa-item">
                        <div class="qa-question">
                            <span class="qa-number">121</span>
                            <span class="qa-tag normal-style">답변대기중</span>
                            <div class="con-cus-mo-qa">
                                <p class="qa-text">오늘 투어인데 아유타야에 있어서요. 혹시 아유타야에서 도중에 만나서 일정만 소화하고 아유타야에서...</p>
                                <div class="qa-meta text-gray only_mo">2024.07.24 09:39</div>
                            </div>
                        </div>
                        <div class="qa-meta text-gray only_web">2024.07.24 09:39</div>
                    </li>
                    <li class="qa-item">
                        <div class="qa-question">
                            <span class="qa-number">120</span>
                            <span class="qa-tag">답변대기중</span>
                            <div class="con-cus-mo-qa">
                                <p class="qa-text">입금 했습니다. 아직 확정 전이라고 떠서 확인부탁드려요.</p>
                                <div class="qa-meta text-gray only_mo">2024.07.24 09:39</div>
                            </div>
                        </div>
                        <div class="qa-meta text-gray only_web">2024.07.24 09:39</div>
                    </li>
                </ul>
                <div class="additional-info">
                    <span class="load-more">더투어랩</span>
                    <p>조인투어로 전환 시 정해진 미팅장소에서 가이드님과 만나실 수 있습니다.<br>아유타야는 넓기 때문에 다른 장소에서 미팅은 어려운 점 예약 시 참고해주시기 바랍니다.
                    </p>
                    <p class="mt-36">만약 투어 종료 후 개별 이동을 원하시면 당일 가이드님께 말씀해주시면 됩니다.</p>
                </div>
            </div>
            <div class="pagination">
                <a href="#" class="page-link">
                    <img class="only_web" src="/uploads/icons/arrow_prev_step.png" alt="arrow_prev_step">
                    <img class="only_mo" src="/uploads/icons/arrow_prev_step_mo.png" alt="arrow_prev_step_mo">
                </a>
                <a href="#" class="page-link cus-padding mr">
                    <img class="only_web" src="/uploads/icons/arrow_prev_all.png" alt="arrow_prev_all">
                    <img class="only_mo" src="/uploads/icons/arrow_prev_all_mo.png" alt="arrow_prev_all_mo">
                </a>
                <a href="#" class="page-link active">1</a>
                <a href="#" class="page-link">2</a>
                <a href="#" class="page-link">3</a>
                <a href="#" class="page-link cus-padding ml">
                    <img class="only_web" src="/uploads/icons/arrow_next_all.png" alt="arrow_next_step">
                    <img class="only_mo" src="/uploads/icons/arrow_next_all_mo.png" alt="arrow_next_step_mo">
                </a>
                <a href="#" class="page-link">
                    <img class="only_web" src="/uploads/icons/arrow_next_step.png" alt="arrow_next_step">
                    <img class="only_mo" src="/uploads/icons/arrow_next_step_mo.png" alt="arrow_next_step">
                </a>
            </div>
        </div>
    </div>
    <div id="dim"></div>
    <div id="popup_img" class="on">
        <strong id="pop_roomName"></strong>
        <div>
            <ul class="multiple-items">
                <?php foreach ($imgs as $img) {
                    echo "<li><img src='" . $img . "' alt='' /></li>";
                } ?>
            </ul>
        </div>
        <a class="closed_btn" href="javaScript:void(0)"><img src="/images/ico/close_ico_w.png" alt="close"/></a>
    </div>
    <div id="popup_coupon" class="popup" data-price="">
        <div class="popup-content">
            <img src="/images/ico/close_icon_popup.png" alt="close_icon" class="close-btn"></img>
            <h2 class="title-popup">적용가능한 쿠폰 확인</h2>
            <div class="order-popup">
                <?php
                $nums_coupon = count($coupons);
                ?>
                <p class="count-info">사용 가능 쿠폰 <span><?= $nums_coupon ?>장</span></p>
                <div class="description-above">
                    <?php
                    foreach ($coupons as $coupon) {
                        if ($coupon["dc_type"] == "P") {
                            $discount = $coupon["coupon_pe"] . "%";
                            $dis = $coupon["coupon_pe"];
                        } else if ($coupon["dc_type"] == "D") {
                            $discount = number_format($coupon["coupon_price"]) . "원";
                            $dis = $coupon["coupon_price"];
                        } else {
                            $discount = "회원등급에 따름";
                            $dis = 0;
                        }
                        ?>
                        <div class="item-price-popup" style="cursor: pointer;"
                             data-idx="<?= $coupon["c_idx"] ?>" data-type="<?= $coupon["dc_type"] ?>"
                             data-discount="<?= $dis ?>" data-discount_baht="<?= $coupon["coupon_price_baht"] ?>">
                            <div class="img-container">
                                <img src="/images/sub/popup_cash_icon.png" alt="popup_cash_icon">
                            </div>
                            <div class="text-con">
                                <span class="item_coupon_name"><?= $coupon["coupon_name"] ?></span>
                                <span class="text-gray"><?= $discount ?> 할인쿠폰</span>
                            </div>
                            <span class="date-sub">~<?= date("Y.m.d", strtotime($coupon["enddate"])) ?></span>
                        </div>
                        <?php
                    }
                    ?>
                    <div class="item-price-popup item-price-popup--button active"
                         data-idx="" data-type="" data-discount="0" data-discount_baht="0">
                        <span>적용안함</span>
                    </div>
                </div>
                <div class="line-gray"></div>
                <div class="footer-popup">
                    <div class="des-above">
                        <div class="item">
                            <span class="text-gray">총 주문금액</span>
                            <span class="text-gray total_price" id="total_price_popup" data-price="">0원</span>
                        </div>
                        <div class="item">
                            <span class="text-gray">할인금액</span>
                            <span class="text-gray discount" data-price="">0원</span>
                        </div>
                    </div>
                    <div class="des-below">
                        <div class="price-below">
                            <span>최종결제금액</span>
                            <p class="price-popup">
                                <span id="last_price_popup">0</span><span
                                        class="text-gray">원</span>
                            </p>
                        </div>
                    </div>
                    <!--button type="button" class="btn_accept_popup btn_accept_coupon">
                        쿠폰적용
                    </button-->
                    <button type="button" class="btn_accept_popup btn_accept_coupon">
                        장바구니 담기
                    </button>
                </div>
            </div>
        </div>
    </div>

	<script>
    $(document).ready(function() {
        $('#hoursDay').change(function() {
            const selectedValue = $(this).val(); // 선택된 값
            alert('선택된 시: ' + selectedValue);
        });
        $('#minuteDay').change(function() {
            const selectedValue = $(this).val(); // 선택된 값
            alert('선택된 분: ' + selectedValue);
        });
    });
	</script>

    <script>

        function handleShowBookingArea(elm) {
            const target = $(elm).data('target');
            $(window).scrollTop($(target).offset().top - 100, 'slow');
        }

        $(function () {
            $(".tag-js").eq(0).trigger("click");
            $(".tag-js2").eq(0).trigger("click");
            $("#people_adult_cnt").find("option").eq(1).prop("selected", true);
            $("#people_adult_cnt").trigger("change");
        })

        function setGolfOption() {
            let total_option_price      = 0;
            let total_option_price_baht = 0;
            let html = `<div class="item-right">
                            <p><span class="text-gray">추가옵션 - </span>[name] x [cnt]대</p>
                            <span class="price-text text-gray">[price] 원 ([price_baht]바트)</span>
                        </div>`;

            const html2 = $(".option_select").filter(function () {
                return $(this).val() !== "";
            }).map(function () {
                const p_name     = $(this).data('name');
                const cnt        = $(this).val() || 0;
                const price      = Math.round($(this).data('price') * cnt);
                const price_baht = Math.round($(this).data('price_baht') * cnt);

                total_option_price      += price;
                total_option_price_baht += price_baht;
                return html.replace("[name]", p_name)
                    .replace("[cnt]", cnt)
                    .replace("[price]", number_format(price))
                    .replace("[price_baht]", number_format(price_baht));
            }).get().join('');
            $("#option_list_result").html(html2);
            return {
                total_option_price,
                total_option_price_baht
            };  

		}
		
		function setListVehicle() {
            let total_vehicle_price = 0;

            let total_vehicle_price_baht = 0;

            let html = `<div class="item-right">
                            <p><span class="text-gray">골프장 왕복 픽업 차량 - </span>[name] x [cnt]대</p>
                            <span class="price-text text-gray">[price] 원 ([price_baht]바트)</span>
                        </div>`;

            const html2 = $(".vehicle_select").filter(function () {
                return $(this).val() !== "";
            }).map(function () {
                const p_name = $(this).data('name');
                const cnt = $(this).val() || 0;
                const price = Math.round($(this).data('price') * cnt);
                const price_baht = Math.round($(this).data('price_baht') * cnt);
                total_vehicle_price += price;
                total_vehicle_price_baht += price_baht;
                return html.replace("[name]", p_name)
                    .replace("[cnt]", cnt)
                    .replace("[price]", number_format(price))
                    .replace("[price_baht]", number_format(price_baht));
            }).get().join('');
            $("#vehicle_list_result").html(html2);

            return {
                total_vehicle_price,
                total_vehicle_price_baht
            };
        }

        function setOptionArea() {

            const optionActive = $("#final_option_list .card-item.active_2");
            const price = optionActive.data("option_price") || 0;
            const caddy_fee = optionActive.data("caddy_fee") || "그린피에 포함";
            const cart_pie_fee = optionActive.data("cart_pie_fee") || "그린피에 포함";
            const price_baht = optionActive.data("option_price_baht") || 0;
            const people_cnt = $("#people_adult_cnt").val() || 0;
            const final_price = Math.round(price * people_cnt);
            const final_price_baht = Math.round(price_baht * people_cnt);
            const minute = optionActive.data("minute") || "00";

            $("#option_idx").val(optionActive.data("idx"));
            $("#final_option_price").text(number_format(price));
            $("#final_caddy_fee").text(caddy_fee);
            $("#final_cart_pie_fee").text(cart_pie_fee);
            $("#final_option_price_baht").text(number_format(price_baht));
            $(".final_people_cnt").text(number_format(people_cnt));
            $("#total_final_option_price").text(number_format(final_price));
            $("#total_final_option_price_baht").text(number_format(final_price_baht));
            $(".final_minute").text(minute);

            return {
                final_price,
                final_price_baht
            }
        }

        function setCouponArea(isAcceptBtn = false) {
            const couponActive = $(".item-price-popup.active");
            let total_price = $("#total_price").val() || 0;
            let total_price_baht = $("#total_price_baht").val() || 0;
            const idx = couponActive.data("idx") || 0;
            const discount = couponActive.data("discount") || 0;
            let discount_baht = couponActive.data("discount_baht") || 0;
            const type = couponActive.data("type") || 0;

            let discount_price = 0;
            let discount_price_baht = 0;
            if (type === "D") {
                discount_price = discount;
                discount_price_baht = discount_baht;
            } else if (type === "P") {
                discount_price = Math.round(total_price * discount / 100);
                discount_price_baht = Math.round(total_price_baht * discount / 100);
            }

            total_price -= discount_price;
            total_price_baht -= discount_price_baht;

            $(".discount").text(number_format(discount_price) + "원");
            $("#last_price_popup").text(number_format(total_price));

            if (isAcceptBtn) {
                $("#final_discount").text(number_format(discount_price));
                $("#final_discount_baht").text(number_format(discount_price_baht));
                $("#use_coupon_idx").val(idx);
            }

            return {
                discount_price,
                discount_price_baht
            };
        }

        function calculatePrice() {
            const vehiclePrice = setListVehicle();

            const optionPrice  = setOptionArea();
            const optionPrice1 = setGolfOption();

			let last_price      = vehiclePrice.total_vehicle_price + optionPrice.final_price + optionPrice1.total_option_price;
            let last_price_baht = vehiclePrice.total_vehicle_price_baht + optionPrice.final_price_baht + optionPrice1.total_option_price_baht;

            $("#total_price_popup").text(number_format(last_price) + "원");
            $("#total_price").val(last_price);
            $("#total_price_baht").val(last_price_baht);

            const discount_price = $("#final_discount").text().replace(/[^0-9]/g, '');
            const discount_price_baht = $("#final_discount_baht").text().replace(/[^0-9]/g, '');

            last_price -= discount_price;
            last_price_baht -= discount_price_baht;

            $("#last_price").text(number_format(last_price));
            $("#last_price_baht").text(number_format(last_price_baht));
        }

        function selectOption(obj) {
            $('#final_option_list .card-item').removeClass('active_2');
            $(obj).addClass('active_2');
            calculatePrice();
        }

        function getOptions() {
            const golf_date = $("#order_date").val();
            const hole_cnt = $('.tag-js.active').data('tab');
            const hour = $('.tag-js2.active').data('tab');
            if (!hole_cnt || !hour) {
                return false;
            }
            $.ajax({
                type: "GET",
                url: "/product-golf/option-price/<?= $product['product_idx']?>",
                data: {
                    golf_date,
                    hole_cnt,
                    hour,
                },
                success: function (data) {
                    $('#final_option_list').html(data);
                    $("#final_option_list .card-item").eq(0).trigger("click");
                    calculatePrice();
                }
            })
        }

        function changePeople() {
            calculatePrice();
        }

        $(".item-price-popup").click(function () {
            $(this).addClass("active").siblings().removeClass("active");
            setCouponArea();
        })

        $(".btn_accept_coupon").click(function () {
            setCouponArea(true);
            calculatePrice();
            $("#popup_coupon").css('display', 'none');
        })


        function showCouponPop() {
            $("#popup_coupon").css('display', 'flex');
        }


        function handleSubmit() {
            <?php
            if (empty(session()->get("member")["id"])) {
            ?>
            showOrHideLoginItem();
            return false;
            <?php
            }
            ?>

			if($("#people_adult_cnt").val() < 1) {
               alert('인원을 선택하세요.');
			   $("#people_adult_cnt").focus();
			   return false;
            }

            $("#frm").submit();
        }

        $(".vehicle_select").change(function () {
            calculatePrice();
        })

        function cartAdd() {
            alert('장바구니 담기');
        }


        function formatDate(date, separate = "-") {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            return `${year}${separate}${month}${separate}${day}`;
        }

        function getDatesInRange(start, end) {
            let dates = [];
            let current = new Date(start);
            while (current <= end) {
                dates.push(new Date(current));
                current.setDate(current.getDate() + 1);
            }
            return dates;
        }

        function isDateInRange(date, s, e) {
            return date >= s && date <= e;
        }

        function getAvailableDates(s_date, e_date, deadline_date_arr) {
            let result = [];
            const allDates = getDatesInRange(s_date, e_date);

            allDates.forEach(date => {
                let isBlocked = deadline_date_arr.some(deadline =>
                    isDateInRange(date, deadline.s_date, deadline.e_date)
                );
                if (!isBlocked) {
                    result.push(formatDate(date));
                }
            });

            return result.join("|");
        }

        jQuery(document).ready(function () {
            var dim = $('#dim');
            var popup = $('#popupRoom');
            var closedBtn = $('#popupRoom .closed_btn');

            var popup2 = $('#popup_img');
            var closedBtn2 = $('#popup_img .closed_btn');

            var order_date = $("#order_date").val();
            var temp = order_date.split("-");
            $("#year").text(temp[0]);
            $("#motn").text(temp[1]);

            /* closed btn*/
            closedBtn.click(function () {
                popup.hide();
                dim.fadeOut();
                $('.multiple-items').slick('unslick'); // slick 삭제
                return false;
            });

            closedBtn2.click(function () {
                popup2.hide();
                dim.fadeOut();
                $('.multiple-items').slick('unslick'); // slick 삭제
                return false;
            });

            $(".short_link").on('click', function (evt) {
                evt.preventDefault();
                var target = $(this).data('target');
                // $(window).scrollTop($('#' + target).offset().top - 100, 300);
                $('html, body').animate({
                    scrollTop: $('#' + target).offset().top - 100
                }, 'slow');
                return false;
            });

        });
        $('.tag-list .tag-js').on('click', function () {
            $('.tag-list .tag-js').removeClass('active');
            $(".final_hole").text($(this).data('tab'));
            $(this).addClass('active');
            getOptions();
        });

        $('.tag-list .tag-js2').on('click', function () {
            $('.tag-list .tag-js2').removeClass('active');
            $(".final_hour").text($(this).data('tab'));
            $(this).addClass('active');
            getOptions();
        });

        let swiper = new Swiper(".swiper_product_list_", {
            slidesPerView: 1,
            spaceBetween: 20,
            loop: true,
            pagination: {
                el: ".swiper_product_list_pagination_",
                clickable: true,
            },
            breakpoints: {
                850: {
                    slidesPerView: 4,
                    spaceBetween: 10,
                }
            }
        });

        // Get the popup, open button, close button elements
        const $closePopupBtn = $('.close-btn');

        $('.list-icon img[alt="heart_icon"]').click(function () {
            if ($(this).attr('src') === '/uploads/icons/heart_icon.png') {
                $(this).attr('src', '/uploads/icons/heart_on_icon.png');
            } else {
                $(this).attr('src', '/uploads/icons/heart_icon.png');
            }
        });

        // Close the popup when the "Close" button or the "x" is clicked
        $closePopupBtn.on('click', function () {
            $("#popup_coupon").css('display', 'none');
        });

        const s_date = new Date('<?=$info['s_date']?>');
        const e_date = new Date('<?=$info['e_date']?>');
        const deadline_date = '<?=$info['deadline_date']?>';
        const deadline_date_arr = deadline_date.split(',').map(function (date) {
            const [s_date, e_date] = date.split('~').map(x => x.trim());
            return {s_date: new Date(s_date), e_date: new Date(e_date)};
        });

        var sel_Date = getAvailableDates(s_date, e_date, deadline_date_arr);
        const arrDate = sel_Date.split("|");
        const arrPrice = arrDate.map(x => '<?=round($product['product_price_won'] / 10000, 1)?>');

        function getMonthDatesWithWeekdays(month, year) {
            const monthDatesWithWeekdays = [];
            const daysInMonth = new Date(year, month, 0).getDate();

            for (let day = 1; day <= daysInMonth; day++) {
                const date = new Date(year, month - 1, day);
                const weekday = date.getDay();

                const dateInfo = {
                    dayOfMonth: day,
                    weekday: weekday
                };

                monthDatesWithWeekdays.push(dateInfo);
            }

            return monthDatesWithWeekdays;
        }

        let currentDate = new Date();
        let currentMonth = currentDate.getMonth() + 1;
        let currentYear = currentDate.getFullYear();

        const today = new Date();

        let swiper01 = new Swiper('.calendar-swiper-container', {
            slidesPerView: 22,
            spaceBetween: 2,
            loop: false,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            observer: true,
            observeParents: true,
        });

        function sel_date(day, date = null) {
            if (date) {
                const newDay = new Date(date).getDay();
                $(".final_date").text(`${date.replaceAll("-", ".")} (${daysOfWeek[newDay]})`);
                $("#order_date").val(date);
                $("#final_option_list").empty();
                getOptions();

            }
            $('.day a').removeClass("on");
            $('.day a').eq(day - 1).addClass("on");
        }

        function setSlide(currentMonth, currentYear) {
            const currentDay = `0${currentDate.getDate()}`.slice(-2);
            let to_Day = currentYear + '-' + currentMonth + '-' + currentDay;

            $("#year").text(currentYear);
            $("#month").text(currentMonth);
            swiper01.destroy();
            const daysInCurrentMonth = getMonthDatesWithWeekdays(currentMonth, currentYear);
            $(".calendar-swiper-wrapper").empty();

            daysInCurrentMonth.forEach(e => {

                var calDate = currentYear + '-' + currentMonth + '-' + `0${e.dayOfMonth}`.slice(-2);

                var idx = -1;

                if (arrDate.includes(calDate) && new Date(calDate).getTime() > today.getTime()) {
                    idx = arrDate.indexOf(calDate);
                }

                if (idx == -1) {
                    var selAmt = "-";
                } else {
                    var selAmt = arrPrice[idx] + '만';
                }

                const href = selAmt !== "-" ? `javascript:sel_date(${e.dayOfMonth}, "${calDate}");` : "javascript:void(0);";

                const active = selAmt !== "-" ? "on" : "";

                $(".calendar-swiper-wrapper").append(`
                <div class="swiper-slide">
                    <div style="color:${e.weekday === 6 || e.weekday === 0 ? "red" : "black"}">${daysOfWeek[e.weekday]}</div>
                    <div class="day ${active}" day_${e.dayOfMonth}">
                        <a href='${href}' data-date="${calDate}">
                            ${e.dayOfMonth}
                        </a>
                        <p class="txt">${selAmt}</p>
                    </div>
                </div>
            `);
            });

            swiper01 = new Swiper('.calendar-swiper-container', {
                slidesPerView: 22,
                spaceBetween: 2,
                // slidesPerGroup: 13,
                loop: false,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                observer: true,
                observeParents: true,
                breakpoints: {
                    850: {
                        slidesPerView: 22,
                        spaceBetween: 2,
                    },
                    350: {
                        slidesPerView: 5,
                        spaceBetween: 2,
                    }
                },
            });

            swiper01.slideTo(currentDay - 2);
        }

        setSlide(`0${currentMonth}`.slice(-2), currentYear);

        const initDate = $(".calendar-swiper-wrapper").find(".day.on a").eq(0).attr("data-date");
        //const initDate = $("#firstDate").val();
        $(".calendar-swiper-wrapper").find(".day.on a").eq(0).addClass("on");
        $(".final_date").text(formatDate(new Date(initDate), "."));
        $("#order_date").val(formatDate(new Date(initDate), "-"));

        function nextMonth() {
            var yy = $("#year").text();
            var mm = $("#month").text();
            if (mm.length < 2) {
                mm = "0" + mm;
                $("#month").text(mm);
            }

            var dd = "1";
            currentDate.setMonth(currentDate.getMonth() + 1);
            currentDate.setDate(1);
            currentMonth = currentDate.getMonth() + 1;
            currentYear = currentDate.getFullYear();

            setSlide(`0${currentMonth}`.slice(-2), currentYear)
        }

        function prevMonth() {
            var yy = $("#year").text();
            var mm = $("#month").text();
            if (mm.length < 2) {
                mm = "0" + mm;
                $("#month").text(mm);
            }
            currentDate.setMonth(currentDate.getMonth() - 1);
            currentDate.setDate(1);
            currentMonth = currentDate.getMonth() + 1;
            currentYear = currentDate.getFullYear();
            setSlide(`0${currentMonth}`.slice(-2), currentYear)
        }

        $("#prev_icon").on("click", prevMonth)
        $("#next_icon").on("click", nextMonth)
        $("#prev_icon_mo").on("click", prevMonth)
        $("#next_icon_mo").on("click", nextMonth)

        function img_pops(idx) {
            var dim = $('#dim');
            var popup = $('#popup_img');

            popup.show();
            dim.fadeIn();

            $('.multiple-items').slick({
                slidesToShow: 1,
                initialSlide: 0,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 2000,
                dots: true,
                focusOnSelect: true
            });
        }

    </script>

<?php $this->endSection(); ?>