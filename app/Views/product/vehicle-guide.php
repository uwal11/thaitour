<?php $this->extend('inc/layout_index'); ?>

<?php $this->section('content'); ?>

<!-- Moment.js -->
<script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

<style>
    .ui-state-disabled .ui-state-default{
        color: #ccc;
        pointer-events: none;
        cursor: not-allowed;
    }
</style>

<section class="section_vehicle_1">
    <div class="banner_vehicle">
        <div class="body_inner">
            <div class="swiper_container_ticket swiper">
                <div class="swiper-wrapper">
                    <?php foreach ($bannerTop as $banner) : ?>
                        <div class="swiper-slide">
                            <div class="img_box img_box_14">
                                <picture>
                                    <source media="(min-width: 851px)"
                                            srcset="/data/cate_banner/<?= $banner['ufile1'] ?>">
                                    <img class="img_box__img" src="/data/cate_banner/<?= $banner['ufile2'] ?>" alt="">
                                </picture>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div class="swiper-button-next-vehicle"><img src="/uploads/icons/next_s.png" alt=""></div>
                <div class="swiper-button-prev-vehicle"><img src="/uploads/icons/prev_s.png" alt=""></div>
            </div>
        </div>
    </div>
</section>

<section class="section_vehicle_2">
    <div class="body_inner">
        <div class="section_vehicle_2__wrap">
            <section class="section_vehicle_2_1">
                <div class="section_vehicle_2_1__head">
                    <div class="section_vehicle_2_1__head__ttl vehicle_ttl">
                        간편 차량예약 <span>출발 지역 -> 최종 도착 지역을 선택해주세요</span>
                    </div>
                    <div class="section_vehicle_2_1__head__icon">
                        <a href="#!">
                            <img src="/images/ico/ico_warning.svg" alt="">
                            주의사항
                        </a>
                    </div>
                </div>
                <div class="section_vehicle_2_1__body">
                    <div class="place_chosen">
                        <div class="place_chosen__start bg_gray" role="button" id="place_chosen__start">
                            <img src="/images/ico/ico_place.svg" alt="">
                            <span class="departure_name">출발지역</span>
                        </div>
                        <div class="place_chosen__icon">
                            <img src="/images/ico/ico_transfer.svg" alt="">
                        </div>
                        <div class="place_chosen__end bg_gray" role="button" id="place_chosen__end">
                            <img src="/images/ico/ico_place.svg" alt="">
                            <span class="destination_name">도착지역</span>
                        </div>
                        <div class="place_chosen__date bg_gray">
                            <label for="departure_date" role="button">
                                <img src="/images/ico/ico_calendar_1.png" alt="">
                                미팅날짜 : <span id="departure_date_text">06.21(토)</span>
                                <input type="text" id="departure_date" class="datepicker">
                            </label>
                        </div>
                        <div></div>
                        <div class="place_chosen__people_wrap">
                            <div class="place_chosen__people bg_gray" role="button" id="place_chosen__people">
                                <img src="/images/ico/ico_person_1.png" alt="">
                                <p>성인 <span id="people_adult_cnt">0</span>명,&nbsp;&nbsp;소아 <span
                                            id="people_child_cnt">0</span>명</p>
                            </div>
                            <div class="place_chosen__people_pop">
                                <div class="pickup_amount">
                                    <div class="pickup_amount__ttl">성인</div>
                                    <div class="pickup_amount__numbox">
                                        <button class="btn_minus">
                                            <img src="/images/ico/ico_minus1.png" alt="">
                                        </button>
                                        <input type="text" class="pickup_amount__num" name="adult_cnt" value="0"
                                               min="0">
                                        <button class="btn_plus">
                                            <img src="/images/ico/ico_plus1.png" alt="">
                                        </button>
                                    </div>
                                </div>
                                <div class="pickup_amount">
                                    <div class="pickup_amount__ttl">소아</div>
                                    <div class="pickup_amount__numbox">
                                        <button class="btn_minus">
                                            <img src="/images/ico/ico_minus1.png" alt="">
                                        </button>
                                        <input type="text" class="pickup_amount__num" name="child_cnt" value="0"
                                               min="0">
                                        <button class="btn_plus">
                                            <img src="/images/ico/ico_plus1.png" alt="">
                                        </button>
                                    </div>
                                </div>
                                <button class="btn_pickup_people" id="btn_pickup_people">완료</button>
                            </div>
                        </div>
                    </div>
                    <a href="#!" class="view_map_btn">
                        <picture>
                            <source media="(max-width: 850px)" srcset="/images/sub/btn_view_map_m.png">
                            <img src="/images/sub/btn_view_map.png" alt="view_map">
                        </picture>
                    </a>
                </div>
            </section>
            <section class="section_vehicle_2_2">
                <div class="section_vehicle_2_2__head">
                    <div class="section_vehicle_2_2__head__ttl vehicle_ttl">
                        상품선택 <span>상품 선택후 아래 세부항목을 선택해주세요.</span>
                        <img style="vertical-align: middle;margin-left: 3px" src="/images/ico/ico_question.png" alt="">
                    </div>

                    <div class="cars_category_wrap">
                        <p class="ttl_category_depth_1">상품을 선택해주세요</p>
                        <ul class="section_vehicle_2_2__head__tabs cars_category_depth_1">
    
                        </ul>
                        <div class="section_vehicle_2_2__airport">
    
                        </div>
                    </div>

                </div>
            </section>

            <section class="section_vehicle_2_3">
                <div class="section_vehicle_2_3__head">
                    <div class="section_vehicle_2_3__head__ttl vehicle_ttl">
                        차량선택 <span>차량의 종류와 대수를 선택해주세요</span>
                    </div>
                </div>
                <table class="vehicle_list">
                    <colgroup>
                        <col width="277px">
                        <col width="480px">
                        <col width="320">
                    </colgroup>
                    <tbody id="product_vehicle_list">
                    </tbody>
                </table>
            </section>
            <section class="section_vehicle_2_4">
                <div class="section_vehicle_2_4__head">
                    <div class="section_vehicle_2_4__head__ttl">
                        취소 규정 : 결제후 06월26일 18시(한국시간) 이전에 취소하시면 무료취소가 가능합니다.
                        <a class="vehicle_ttl__link" href="#!">본 예약건 취소규정 자세히 보기</a>
                    </div>
                </div>
                <table class="vehicle_list">
                    <colgroup>
                        <col width="277px">
                        <col width="480px">
                        <col width="320">
                    </colgroup>
                    <tbody id="product_vehicle_list_selected" style="display: none;">
                    </tbody>
                </table>
                <div class="vehicle_synthetic">
                    <div>
                        <p class="vehicle_synthetic__ttl">선택상품</p>
                        <p class="vehicle_synthetic__txt">차량 <i id="total_cnt">0</i>대</p>
                    </div>
                    <div>
                        <p class="vehicle_synthetic__ttl">차량가격</p>
                        <div class="vehicle_all_price"><i id="all_price">0</i><span> 원 (<i id="all_price_baht">0</i>바트)</span>
                        </div>
                    </div>
                    <div class="vehicle_minus">
                        <span class="minus_ico"></span>
                    </div>
                    <div>
                        <p class="vehicle_synthetic__ttl">할인</p>
                        <div class="vehicle_all_price">0<span> 원 (0바트)</span></div>
                    </div>
                    <div class="vehicle_equal">
                        <span class="equal_ico"></span>
                    </div>
                    <div>
                        <p class="vehicle_synthetic__ttl">결제예정금액</p>
                        <div class="vehicle_price"><i id="final_price">0</i><span> 원 (<i id="final_price_baht">0</i>바트)</span>
                        </div>
                    </div>
                    <!-- <div class="vehicle_coupon">
                        <button class="coupon_btn">쿠폰선택</button>
                        <button class="point_btn">포인트사용</button>
                    </div> -->
                </div>
                <div class="section_vehicle_2_4__foot">
                    예약시 기재하신 미팅장소에서 목적지까지의 단순 편도 차량입니다. <br> 샌딩 지역이 예약하신 상품의 지역이 아닌 곳은 추
                </div>
            </section>
            <section class="section_vehicle_2_5">
                <div class="section_vehicle_2_5__head">
                    <div class="section_vehicle_2_5__head__ttl vehicle_ttl">
                        포함/불포함사항
                    </div>
                </div>
                <div class="section_vehicle_2_5__body">
                    <div class="include_box chk_info">
                        <p class="sub_label"><i></i> 포함사항</p>
                        <div class="txt_box">
                            <!-- <p>- 국제선 항공요금 및 각종 TAX 및 유류할증료 (항공불포함 제외)</p>
                            <p>&nbsp; <font color="red">비지니스 이용을 원하실 경우 담당자에게 문의해주세요.</font>
                            </p>
                            <p>- 전일정 4성급 호텔 및 식사 (불포함 표기 식사 제외)</p>
                            <p>&nbsp; <font color="red">호텔 업그레이드를 원하시는 경우 담당자에게 문의해주세요.</font>
                            </p>
                            <p>- 전일정 전용차량 및 입장료 (자유일정 제외)<br>- 여행자 보험&nbsp;</p>
                            <p>
                                <font color="black">&nbsp;</font>
                            </p> -->
                            <?= viewSQ(getPolicy(16)) ?>
                        </div>
                    </div>
                    <div class="no_include_box chk_info">
                        <p class="sub_label"><i></i> 불포함사항</p>
                        <div class="txt_box">
                            <!-- <p>- 더투어랩는 가이드 팁 대신 책 (신간) 을 받습니다.</p>
                            <p>&nbsp; 장르 상관없이 1인당 책 1권만 가지고 오시면 되며, 호주 내 한인 도서관에 기증됩니다.</p>
                            <p>- 불포함 표기 식사 및 자유일정</p>
                            <p>
                                <font color="black">- 호주 ETA 비자 : AustralianETA 모바일 앱을 통해 직접 신청</font>
                            </p>
                            <p>- 기타 개인 경비 (물값, 자유시간 시 개인비용 등)</p>
                            <p>※ 호주 화폐로 준비해주시기 바랍니다.</p> -->
                            <?= viewSQ(getPolicy(17)) ?>

                        </div>
                    </div>
                </div>
            </section>
            <section class="section_vehicle_2_6">
                <div class="section_vehicle_2_6__head">
                    <div class="section_vehicle_2_6__head__ttl vehicle_ttl">
                        공지사항
                    </div>
                </div>
                <div class="section_vehicle_2_6__body">
                    <!-- <ul>
                        <li>승용차는 최대 성인 3인 혹은 성인 2인 + 아동 1인까지만 가능합니다. 만약 성인 3인 + 아동 1인인 경우 SUV 혹은 승합차로 이용하셔야 합니다.</li>
                        <li>승용차의 트렁크에는 가스통이 있어 짐이 많을 경우 좁을 수 있으니 소인을 포함하여 인원이 3 ~ 4분이면 짐의 양도 고려하셔야 합니다.</li>
                        <li>별도로 카시트는 준비되지 않습니다.</li>
                        <li>에어비엔비등으로 예약한 일반 숙소, 풀빌라등의 경우 정확한 건물명, 주소, 호스트의 태국 현지 연락처를 기재하셔야 합니다.</li>
                        <li>
                            예약시 기재한 일정 외에 미리 알리지 않은 일정을 당일 추가시 비용이 추가가 되며 기사님의 스케쥴에 따라 이용이 어려울 수도 있으니
                            미리 게시판을 통하여 문의하시기 바랍니다.
                        </li>
                        <li>차량내 흡연, 음주, 안전벨트 미착용등의 위반시 5,000원 이상의 벌금이 부과되니 주의해 주세요.</li>
                        <li>고급차량(알파드,벤츠)등은 10시간 렌탈로 요청 가능하며, 일일렌탈 12시간으로 예약신청 후 10시간으로 렌탈요청시 견적서 다시 보내드립니다.</li>
                        <li>프리미엄 세단은 벤츠 E클래스 또는 BMW5 시리즈 등 동급으로 배정 됩니다.</li>
                        <li>럭셔리 세단은 벤츠 S클래스 또는 BMW7 시리즈 등 동급으로 배정됩니다.</li>
                    </ul> -->
                    <?= viewSQ(getPolicy(18)) ?>
                </div>
            </section>
            <section class="section_vehicle_2_7"  style="display: none;">
                <div class="section_vehicle_2_7__head">
                    <div class="section_vehicle_2_7__head__ttl vehicle_ttl">
                        예약자 정보입력
                    </div>
                </div>
                <div class="section_vehicle_2_7__body">
                    <form action="/vehicle-guide/vehicle-order" name="frmCar" id="frmCar" method="post">
                        <input type="hidden" name="code_no" id="code_no" value="<?=$code_no?>">
                        <input type="hidden" name="cp_idx" id="cp_idx" value="">
                        <input type="hidden" name="product_cnt" id="product_cnt" value="">
                        <input type="hidden" name="ca_depth_idx" id="ca_depth_idx" value="">
                        <input type="hidden" name="departure_area" id="departure_area" value="">
                        <input type="hidden" name="destination_area" id="destination_area" value="">
                        <input type="hidden" name="meeting_date" id="meeting_date" value="">
                        <input type="hidden" name="return_date" id="return_date" value="">
                        <input type="hidden" name="adult_cnt" id="adult_cnt" value="">
                        <input type="hidden" name="child_cnt" id="child_cnt" value="">
                        <input type="hidden" name="inital_price" id="inital_price" value="">
                        <input type="hidden" name="order_price" id="order_price" value="">

                        <div class="section_vehicle_info_wrap">
                            
                        </div>
                        <div class="section_vehicle_2_7__btn_wrap">
                            <button class="btn_add_cart" onclick="window.location.href='/cart/item-list/123'">
                                장바구니담기
                            </button>
                            <!-- <button class="btn_submit" onclick="window.location.href='/product/completed-order'">
                                상품 예약하기
                            </button> -->
                            <button class="btn_submit" type="button">
                                상품 예약하기
                            </button>
                        </div>
                    </form>
                </div>
            </section>
        </div>
    </div>
</section>
<section class="popup_section">
    <div class="popup_wrap place_pop place_chosen__start_pop">
        <div class="pop_box">
            <button type="button" class="close" onclick="closePopup()"></button>
            <div class="pop_body">
                <div class="padding">
                    <div class="popup_place__head">
                        <div class="popup_place__head__ttl">
                            <h2>출발지역</h2>
                        </div>
                    </div>
                    <div class="popup_place__body">
                        <ul class="popup_place__list">
                            <?php 
                                $i = 1;
                                foreach ($departure_list as $key => $value) : 
                            ?>
                                <li data-ca_idx="<?= $value["ca_idx"] ?>" data-code="<?= $value["code_no"] ?>" onclick="change_departure_category(this);">
                                    <span class="<?php if($i == 1){ echo "active"; } ?>"><?= getCodeFromCodeNo($value["code_no"])["code_name"] ?></span>
                                </li>
                            <?php 
                                $i++;
                                endforeach; 
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="dim"></div>
    </div>
    <div class="popup_wrap place_pop place_chosen__end_pop">
        <div class="pop_box">
            <button type="button" class="close" onclick="closePopup()"></button>
            <div class="pop_body">
                <div class="padding">
                    <div class="popup_place__head">
                        <div class="popup_place__head__ttl">
                            <h2>도착지역</h2>
                        </div>
                    </div>
                    <div class="popup_place__body">
                        <ul class="popup_place__list">
                            
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="dim"></div>
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
                        <?= viewSQ(getPolicy(19)) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="dim" style="justify-content: space-between;"></div>
    </div>
</section>

<script>

    function updateDepartureDateToday() {
        let date = new Date();
        const year = String(date.getFullYear()).slice(-2);
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const dayOfWeek = daysOfWeek[date.getDay()];

        $("#departure_date_text").text(`${year}.${month}.${day}(${dayOfWeek})`);
        $(".meeting_time__date").text(`${date.getFullYear()}-${month}-${day}(${dayOfWeek})`);
        $("#meeting_date").val(`${date.getFullYear()}-${month}-${day}`);
    }

    function updateDestinationDateToday() {
        let date = new Date();
        const year = String(date.getFullYear()).slice(-2);
        const month = String(date.getMonth() + 1).padStart(2, '0');
        const day = String(date.getDate()).padStart(2, '0');
        const dayOfWeek = daysOfWeek[date.getDay()];

        $("#destination_date_text").text(`${year}.${month}.${day}(${dayOfWeek})`);
        $("#return_date").val(`${date.getFullYear()}-${month}-${day}`);
    }
    
    updateDepartureDateToday();

    function changeEmail(select){
        let email_host = $(select).val();
        $("#email_host").val(email_host);
    }

    function change_departure_category(button){
        let ca_idx = $(button).data("ca_idx");
        let departure_name = $(button).find("span").text();        

        $(button).find("span").addClass("active");
        $(button).siblings().find("span").removeClass("active");
        $("#departure_area").val(ca_idx);
        $(".departure_name").text(departure_name);
        $(".place_chosen__start_pop").hide();

        get_destination();
    }

    function change_destination_category(button) {
        let ca_idx = $(button).data("ca_idx");
        let destination_name = $(button).find("span").text();
        $(button).find("span").addClass("active");
        $(button).siblings().find("span").removeClass("active");
        $("#destination_area").val(ca_idx);
        $(".destination_name").text(destination_name);
        $(".place_chosen__end_pop").hide();
        // handleFetch();
        get_depth_first_category();
    }

    function get_destination() {
        let ca_idx = $(".place_chosen__start_pop .popup_place__list li span.active").closest("li").data("ca_idx");
        let code_no = $(".place_chosen__start_pop .popup_place__list li span.active").closest("li").data("code");
        let departure_name = $(".place_chosen__start_pop .popup_place__list li span.active").text();

        $("#departure_area").val(ca_idx);
        $(".departure_name").text(departure_name);
        
        $.ajax({
            url: '/ajax/get_destination',
            type: "GET",
            data: { ca_idx, code_no },
            error: function (request, status, error) {
                alert("code = " + request.status + " message = " + request.responseText + " error = " + error); // 실패 시 처리
            },
            success: function (data, textStatus) {
                let html = ``;

                let first_ca_idx = 0;
                let first_code_name = "";
                for(let i = 0; i < data.length; i++){
                    if(i == 0){
                        first_ca_idx = data[i]["ca_idx"];
                        first_code_name = data[i]["code_name"];
                    }

                    html += `<li data-ca_idx="${data[i]["ca_idx"]}" onclick="change_destination_category(this);">
                                <span class="${ i == 0 ? "active" : ''}">${data[i]["code_name"]}</span>
                            </li>`;
                }        

                
                $(".place_chosen__end_pop .popup_place__list").html(html);
                $("#destination_area").val(first_ca_idx);
                $(".destination_name").text(first_code_name);

                get_depth_first_category();

            }
        });
    }

    function get_depth_first_category() {
        let ca_idx = $(".place_chosen__end_pop .popup_place__list li span.active").closest("li").data("ca_idx");
        
        $.ajax({
            url: '/ajax/get_child_category',
            type: "GET",
            data: { ca_idx },
            error: function (request, status, error) {
                alert("code = " + request.status + " message = " + request.responseText + " error = " + error); // 실패 시 처리
            },
            success: function (response, textStatus) {
                let data = response.category_list;
                let html = ``;

                for(let i = 0; i < data.length; i++){

                    html += `<li class="section_vehicle_2_2__head__tabs__item category_item ${ i == 0 ? "active" : ''}" onclick="get_depth_category(this, 2);" data-ca_idx="${data[i]["ca_idx"]}" data-code="${data[i]["code_no"]}">
                                <a href="#!">${data[i]["code_name"]}</a>
                            </li>`;
                }                

                $(".cars_category_depth_1").html(html);

                get_depth_category($(".cars_category_depth_1 .section_vehicle_2_2__head__tabs__item.active"), 2);
            }
        });
    }

    function get_depth_category(button, depth){
        
        $(button).addClass("active").siblings().removeClass("active");
        let previous_depth = Number(depth) - 1 ?? 1;
        let ca_idx = $(button).data("ca_idx");

        let code_first = $(".cars_category_depth_1 .section_vehicle_2_2__head__tabs__item.active").data("code");
        let ca_first_idx = $(".cars_category_depth_1 .section_vehicle_2_2__head__tabs__item.active").data("ca_idx");

        $("#ca_depth_idx").val(ca_first_idx);

        if(previous_depth == 1){
            if(code_first == "5403"){
                let date_html = '';
                date_html += `<label for="departure_date" role="button">
                                <img src="/images/ico/ico_calendar_1.png" alt="">
                                미팅날짜 : <span id="departure_date_text">06.21(토)</span>
                                <input type="text" id="departure_date" class="datepicker">
                            </label>`;
                date_html += `<input type="hidden" id="day_range_total" value="">`;
                date_html += `<span id="day_range_text">1</span>`;
                date_html += `<label for="destination_date" role="button">
                                <img src="/images/ico/ico_calendar_1.png" alt="">
                                미팅날짜 : <span id="destination_date_text">06.21(토)</span>
                                <input type="text" id="destination_date" class="datepicker">
                            </label>`;

                $(".place_chosen__date").html(date_html);
                $(".place_chosen__date").css("justify-content", "space-between");

                updateDestinationDateToday();
            }else{
                $(".place_chosen__date").html(
                    `<label for="departure_date" role="button">
                        <img src="/images/ico/ico_calendar_1.png" alt="">
                        미팅날짜 : <span id="departure_date_text">06.21(토)</span>
                        <input type="text" id="departure_date" class="datepicker">
                    </label>`
                );

                $(".place_chosen__date").css("justify-content", "unset");
                $("#destination_date_text").text('');
                $("#return_date").val('');
            }

            updateDepartureDateToday();
            init_datepicker();
            
        }

        $.ajax({
            url: '/ajax/get_child_category',
            type: "GET",
            data: { ca_idx },
            error: function (request, status, error) {
                alert("code = " + request.status + " message = " + request.responseText + " error = " + error); // 실패 시 처리
            },
            success: function (response, textStatus) {
                let data = response.category_list;
                let count_child = response.count_child;                

                $(".cars_category_depth_" + previous_depth).nextAll().remove();

                if(data.length > 0){
                    let html = ``;
                    if(count_child > 0){

                        if(code_first == "5406"){
                            html += `<p class="ttl_category_depth_child">골프장 선택</p>`;  
                        }else{
                            html += `<p class="ttl_category_depth_child">상세상품을 선택해주세요</p>`;  
                        }

                        html += `<ul class="section_vehicle_2_2__head__tabs cars_category_depth_${depth}">`;
                        for(let i = 0; i < data.length; i++){
        
                            html += `<li class="section_vehicle_2_2__head__tabs__item category_item ${ i == 0 ? "active" : ''}" onclick="get_depth_category(this, ${depth + 1});" data-ca_idx="${data[i]["ca_idx"]}">
                                        <a href="#!">${data[i]["code_name"]}</a>
                                    </li>`;
                        }                
        
                        html += `</ul>`;
                    }else{
                        if(code_first == "5401"){
                            html += `<p class="ttl_category_depth_child">왕복/편도 여부를 선택해주세요.</p>`;  
                        }else if(code_first == "5406"){
                            html += `<p class="ttl_category_depth_child">홀수 선택</p>`;  
                        }else{
                            html += `<p class="ttl_category_depth_child">상세상품을 선택해주세요</p>`;  
                        }

                        html += `<ul class="section_vehicle_2_2__airport cars_category_depth_${depth}">`;
    
                        if(code_first == "5401" && depth == 3){
                            for(let i = 0; i < data.length; i++){
                                html += `<span>
                                            <input ${data[i]["code_name"].trim() == "편도" ? "checked" : ""} type="radio" id="airport${data[i]["ca_idx"]}" onclick="get_cars_product(this);" name="airport" value="${data[i]["ca_idx"]}">
                                            <label for="airport${data[i]["ca_idx"]}">${data[i]["code_name"]}</label>
                                        </span>`;
                            }                
                        }else{
                            for(let i = 0; i < data.length; i++){
                                html += `<span>
                                            <input ${i == 0 ? "checked" : ""} type="radio" id="airport${data[i]["ca_idx"]}" onclick="get_cars_product(this);" name="airport" value="${data[i]["ca_idx"]}">
                                            <label for="airport${data[i]["ca_idx"]}">${data[i]["code_name"]}</label>
                                        </span>`;
                            }  
                        }

        
                        html += `</ul>`;
                    }

                    $(".cars_category_depth_" + previous_depth).after(html);
    
                    get_depth_category($(".cars_category_depth_" + depth + " .section_vehicle_2_2__head__tabs__item.active"), depth + 1);
                }else{
                    get_cars_product($(".section_vehicle_2_2__airport input[type='radio']:checked"));
                }
            }
        });

    }

    function renderPrdList(products, ca_idx) {
        let product_list = "";

        for (let i = 0; i < products.length; i++) {
            let img = "";
            if (products[i]["ufile1"]) {
                img = '/data/cars/' + products[i]["ufile1"];
            } else {
                img = '/data/product/noimg.png';
            }
            const options = products[i]["options"].map((option, index) => {
                let html = "";
                let icons = option.icons.map(icon => `<img src="/data/code/${icon}" alt="">`).join('');
                if (index % 2 == 0) {
                    html += `
                    <tr>
                        <td class="">${icons}</td>
                        <td class="vehicle_info__item">${option.c_op_name}</td>`;
                }
                if (index % 2 == 1) {
                    html += `
                        <td class="vehicle_info__item">또는</td>
                        <td class="">${icons}</td>
                        <td class="vehicle_info__item">${option.c_op_name}</td>
                    </tr>
                    `;
                }
                return html;
            }).join('');
            const minium_cars_cnt = Number(products[i]["minium_people_cnt"]) ?? 0;
            const total_cars_cnt = Number(products[i]["total_people_cnt"]) ?? 0;

            const adult_cnt = Number(products[i]["adult_people_cnt"]) ?? 0;
            const people_cnt = Number(products[i]["people_cnt"]) ?? 0;

            let vehicle_select = $(`#product_vehicle_list_selected tr.product_${products[i]["cp_idx"]}`);

            const cnt_options = Array(total_cars_cnt - minium_cars_cnt + 1).fill(1).map((_, index) => {
                const cnt = minium_cars_cnt + index;
                let selected = "";
                if (vehicle_select && vehicle_select.data("cnt") == cnt) {
                    selected = "selected";
                }
                return `<option value="${cnt}" ${selected}>${cnt}대</option>`
            }).join('');

            const price_str = Math.round(products[i]["sale_price"]);

            const price_won_str = Math.round(products[i]["car_price_won"]);

            product_list +=
                `<tr class="product_${products[i]["cp_idx"]}" data-price="${price_str}" data-price_won="${price_won_str}" data-ca_idx="${ca_idx}">
                <td>
                    <div class="vehicle_image">
                        <div class="img_box img_box_15">
                            <img src="${img}" alt="${products[i]["rfile1"]}">
                        </div>
                    </div>
                </td>
                <td>
                    <div class="vehicle_info">
                        <h4 class="vehicle_info__name">
                            ${products[i]["product_name"]}
                        </h4>
                        <table>
                            <colgroup>
                                <col width="10%">
                                <col width="30%">
                                <col width="10%">
                                <col width="10%">
                                <col width="40%">
                            </colgroup>
                            <tbody>
                                ${options}
                            </tbody>
                        </table>
                    </div>
                </td>
                <td>
                    <div class="vehicle_price">
                        ${price_won_str.toLocaleString('ko-KR')}<span> 원 (${price_str.toLocaleString('ko-KR')} 바트)</span>
                    </div>
                    <div class="vehicle_options">
                        <label class="vehicle_options__label__vehicle_cnt" for="vehicle_cnt">차량수량</label>
                        <select name="" id="vehicle_cnt_${products[i]["cp_idx"]}" data-id="${products[i]["cp_idx"]}" class="vehicle_options__select vehicle_cnt" onchange="handleSelectNumber(this)">
                            ${cnt_options}
                        </select>
                        <input type="hidden" id="minium_people_cnt_${products[i]["cp_idx"]}" value="${minium_cars_cnt}">
                        <input type="hidden" id="total_people_cnt_${products[i]["cp_idx"]}" value="${total_cars_cnt}">
                        <input type="hidden" id="adult_cnt_${products[i]["cp_idx"]}" value="${adult_cnt}">
                        <input type="hidden" id="people_cnt_${products[i]["cp_idx"]}" value="${people_cnt}">
                        <input type="checkbox" id="vehicle_prd_${products[i]["cp_idx"]}" class="vehicle_prd_select" data-id="${products[i]["cp_idx"]}" onchange="handleSelectVehicle(this)">
                        <label class="vehicle_options__label__vehicle_prd" for="vehicle_prd_${products[i]["cp_idx"]}"></label>
                        <button>상품담기</button>
                    </div>
                </td>
            </tr>`;
        }

        $("#product_vehicle_list").html(product_list);

    }

    function get_cars_product(radio) {
        let ca_idx = $(radio).val();

        $.ajax({
            url: '/ajax/get_cars_product',
            type: "GET",
            data: { ca_idx },
            async: false,
            cache: false,
            success: function (data, textStatus) {
                let products = data;
                
                renderPrdList(products, ca_idx);

                $("#cp_idx").val("");
                $("#product_vehicle_list_selected").empty();
                $(".section_vehicle_2_7").hide();
                $(".section_vehicle_info_wrap").empty();
                calculatePrice();
            },
            error: function (request, status, error) {
                alert("code = " + request.status + " message = " + request.responseText + " error = " + error); // 실패 시 처리
            }
        });
    }

    function calculatePrice() {
        let totalPrice = 0;
        let totalPriceWon = 0;
        let totalCnt = 0;
        let arr_cnt = [];
        $("#product_vehicle_list_selected > tr").each(function () {

            const price = Number($(this).data("price")) ?? 0;
            const price_won = Number($(this).data("price_won")) ?? 0;
            const cnt = Number($(this).data("cnt")) ?? 0;

            totalPrice += price * cnt;
            totalPriceWon += price_won * cnt;
            totalCnt += cnt;
            arr_cnt.push(cnt);
        });

        $("#inital_price").val(totalPriceWon);
        $("#order_price").val(totalPriceWon);
        $("#product_cnt").val(arr_cnt.join(","));
        $("#total_cnt").text(totalCnt);
        $("#all_price").text(totalPriceWon.toLocaleString('ko-KR'));
        $("#all_price_baht").text(totalPrice.toLocaleString('ko-KR'));
        $("#final_price").text(totalPriceWon.toLocaleString('ko-KR'));
        $("#final_price_baht").text(totalPrice.toLocaleString('ko-KR'));
    }

    var previousCarsCnt;
    var previousAdultCnt;
    var previousPeopleCnt;
    var arr_days = ['일', '월', '화', '수', '목', '금', '토'];

    function handleSelectNumber(e) {
        let id = $(e).data("id");
        let cnt = $(e).val();

        if (Number(cnt) === 0) {
            alert("0보다 큰 수량을 선택하세요.");
            $(e).val(previousCarsCnt);
            return false;
        }

        previousCarsCnt = cnt;

        let selected_product = $("#product_vehicle_list").children("tr").find(".vehicle_options input[type='checkbox']:checked");

        let total_adult_cnt = Number($(`#adult_cnt_${id}`).val()) * cnt;
        let total_people_cnt = Number($(`#people_cnt_${id}`).val()) * cnt;

        let select_adult_cnt = Number($("#adult_cnt").val()) ?? 0;
        let select_child_cnt = Number($("#child_cnt").val()) ?? 0;

        if((select_adult_cnt > total_adult_cnt && select_child_cnt == 0) || (select_adult_cnt + select_child_cnt > total_people_cnt && select_child_cnt != 0)) {
            alert("차량은 자리수 부족합니다. 다른 분류 선택하거나 수량 확인부탁드립니다");
            selected_product.prop("checked", false);
            $(".section_vehicle_2_7").hide();
            $(".section_vehicle_info_wrap").empty();
            $("#cp_idx").val("");
            $("#product_vehicle_list_selected").empty();
            calculatePrice();
            return false;
        }
        
        $(`#product_vehicle_list_selected tr.product_${id}`).data("cnt", cnt);
        $("#frm_number_cars").text(cnt);
        calculatePrice();

    }

    function addFormReservation() {
        let code_no = $(".cars_category_depth_1").children(".section_vehicle_2_2__head__tabs__item.active").data("code");
        let id = $("#product_vehicle_list").children("tr").find(".vehicle_options input[type='checkbox']:checked").data("id");

        let cnt = Number($(`#product_vehicle_list tr.product_${id}`).find("select.vehicle_cnt").val());
        let adult_cnt = Number($("#adult_cnt").val()) ?? 0;
        let child_cnt = Number($("#child_cnt").val()) ?? 0; 

        let arr_category_text = [];
        $(".cars_category_wrap").find(".category_item.active").each(function() {
            let cat_text = $(this).find("a").text().trim();
            arr_category_text.push(cat_text);
        });

        let last_cat_text = $(".cars_category_wrap").find(".section_vehicle_2_2__airport input[type='radio']:checked").siblings("label").text().trim();
        arr_category_text.push(last_cat_text);

        let form_html = ``;
        form_html += `
            <div class="section_vehicle_info">
                선택상품 : ${arr_category_text.join(", ")}, <span id="frm_number_cars">${cnt}</span>대, 성인 <span id="frm_adult_cnt">${adult_cnt}</span>명, 아동 <span id="frm_child_cnt">${child_cnt}</span>명
            </div>

            <div class="info_detail_table">
                <table>
                    <colgroup>
                        <col width="150px">
                        <col width="*">
                        <col width="150px">
                        <col width="*">
                    </colgroup>
                    <tbody>
                        <tr>
                            <th>한국이름 *</th>
                            <td>
                                <input class="mb-3rem" type="text" id="order_user_name" name="order_user_name" required="" data-label="한국이름" placeholder="한국이름 작성해주세요.">
                            </td>
                            <th>성별(남성/여성)*</th>
                            <td>
                                <select name="order_user_gender" id="order_user_gender" style="width: 100%" required="" data-label="성별" class="select-width">
                                    <option value="M">남성</option>
                                    <option value="F">여성</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>영문 이름 <br> (First Name) *</th>
                            <td>
                                <input class="mb-3rem" type="text" id="order_user_first_name_en" name="order_user_first_name_en" required="" data-label="영문 이름" placeholder="영어로 작성해주세요.">
                            </td>
                            <th>영문 성 <br> (Last Name) *</th>
                            <td>
                                <input type="text" id="order_user_last_name_en" name="order_user_last_name_en" required="" data-label="영문 성" placeholder="영어로 작성해주세요.">
                            </td>
                        </tr>
                        <tr>
                            <th>전화번호*</th>
                            <td colspan="3">
                                <div class="phone_number">
                                    <select name="phone1" id="phone1">
                                        <option value="010">010</option>
                                        <option value="011">011</option>
                                    </select>
                                    <input type="text" name="phone2" id="phone2"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="4">
                                    <input type="text" name="phone3" id="phone3"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="4">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <th>이메일*</th>
                            <td colspan="3">
                                <div class="contact_email">
                                    <input type="text" name="email_name" id="email_name">
                                    <span>@</span>
                                    <input type="text" name="email_host" id="email_host" value="gmail.com" readonly>
                                    <select id="select_email" onchange="changeEmail(this);">
                                        <option value="gmail.com">gmail.com</option>
                                        <option value="naver.com">naver.com</option>
                                        <option value="kakao.com">kakao.com</option>
                                        <option value="hanmail.com">hanmail.com</option>
                                        <option value="nate.com">nate.com</option>
                                        <option value="yahoo.com">yahoo.com</option>
                                        <option value="hotmail.com">hotmail.com</option>
                                        <option value="chol.com">chol.com</option>
                                    </select>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        `;
        if(code_no == "5401"){

            form_html += `
                <div class="section_vehicle_table">
                    <div class="section_vehicle_2_7__head__ttl vehicle_ttl">
                        가는 편
                    </div>
                    <table>
                        <colgroup>
                            <col width="150px">
                            <col width="*">
                            <col width="150px">
                            <col width="*">
                        </colgroup>
                        <tbody> 
                            <input type="hidden" name="departure_name[]" value="">
                            <tr>
                                <th>항공편 명</th>
                                <td colspan="3">
                                    <select name="airline_code[]" id="airline">
                                        <option value="">항공편 명을 선택해주세요.</option>
                                        <option value="KE 657">대한항공 KE 657(인천 09:15 - 방콕 13:15)</option>
                                        <option value="KE 653">대한항공 KE 653(인천 19:05 - 방콕 23:20)</option>
                                        <option value="KE 651">대한항공 KE 651(인천 17:20 - 방콕 21:30)</option>
                                        <option value="KE 659">대한항공 KE 659(인천 20:35 - 방콕 00:45)</option>
                                        <option value="KE 2001">대한항공 KE 2001(부산 20:25 - 방콕 00:30)</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>항공 도착 날짜</th>
                                <td colspan="3">
                                    <div class="datepicker_wrap" style="width: 250px;">
                                        <input type="text" name="date_trip[]" class="date_form_trip" readonly>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>항공 도착 시간</th>
                                <td colspan="3">
                                    <div class="meeting_time">
                                        <select name="hours[]" id="hours">
                                            <?php
                                            for ($i = 0; $i < 24; $i++) {
                                                $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                ?>
                                                <option value="<?= $hour ?>"><?= $hour ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="hours">시</label>
                                        <select name="minutes[]" id="minutes">
                                            <?php
                                            for ($i = 0; $i < 60; $i+=5) {
                                                $minute = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                ?>
                                                <option value="<?= $minute ?>"><?= $minute ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="minutes">분</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    목적지
                                </th>
                                <td colspan="3">
                                    <div class="destination">
                                        <span class="destination_name"></span>
                                        <input type="text" name="destination_name[]" placeholder="호텔명을 영어로 적어주세요(주소불가)">
                                    </div>
                                    <div class="departure__note">
                                        - 일반주택은 정확한 건물명, 주소, 태국어 가능한 호스트의 태국 전화번호를 남겨주세요. <br>
                                        - 예약 시 선택하신 지역과 입력하신 장소가 다른 경우, 바우처 발송 후에도 추가 요금이 발생할 수 있습니다. <br>
                                        - 윈저파크, 아티타야 등 대부분의 방콕 골프텔은 방콕 외곽 지역에 속합니다.
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>기타요철</th>
                                <td colspan="3">
                                    <textarea name="order_memo[]" id="order_memo" class="other_irregularities" placeholder="예약업무를 주로 현지인 직원들이 처리하므로 여기에는 가급적 영어로 요청사항을 적어주시기 바랍니다. 중요한 요청 및 한글 요청 사항은 1:1 게시판에 따로 남겨주셔야 정상적으로 처리가 가능합니다."></textarea>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            `;

            if($(".cars_category_depth_1").siblings(".cars_category_depth_3").length > 0){
                let text = $(".cars_category_depth_1").siblings(".cars_category_depth_3").find("input[type='radio']:checked").siblings("label").text().trim();

                if(text == "왕복"){
                    form_html += `
                        <div class="section_vehicle_table">
                            <div class="section_vehicle_2_7__head__ttl vehicle_ttl">
                                오는 편
                            </div>
                            <table>
                                <colgroup>
                                    <col width="150px">
                                    <col width="*">
                                    <col width="150px">
                                    <col width="*">
                                </colgroup>
                                <tbody>
                                    <input type="hidden" name="destination_name[]" value="">
                                    <tr>
                                        <th>차량 미팅 날짜</th>
                                        <td colspan="3">
                                            <div class="datepicker_wrap" style="width: 250px;">
                                                <input type="text" name="date_trip[]" class="date_form" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>미팅 시간</th>
                                        <td colspan="3">
                                            <div class="meeting_time">
                                                <select name="hours[]" id="hours">
                                                    <?php
                                                    for ($i = 0; $i < 24; $i++) {
                                                        $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                        ?>
                                                        <option value="<?= $hour ?>"><?= $hour ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <label for="hours">시</label>
                                                <select name="minutes[]" id="minutes">
                                                    <?php
                                                    for ($i = 0; $i < 60; $i+=5) {
                                                        $minute = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                        ?>
                                                        <option value="<?= $minute ?>"><?= $minute ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <label for="minutes">분</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            미팅 장소
                                        </th>
                                        <td colspan="3">
                                            <div class="departure">
                                                <span class="departure_name"></span>
                                                <input type="text" name="departure_name[]" placeholder="호텔명을 영어로 적어주세요(주소불가)">
                                            </div>
                                            <div class="departure__note">
                                                - 일반주택은 정확한 건물명, 주소, 태국어 가능한 호스트의 태국 전화번호를 남겨주세요. <br>
                                                - 예약 시 선택하신 지역과 입력하신 장소가 다른 경우, 바우처 발송 후에도 추가 요금이 발생할 수 있습니다. <br>
                                                - 윈저파크, 아티타야 등 대부분의 방콕 골프텔은 방콕 외곽 지역에 속합니다.
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            항공편 명
                                        </th>
                                        <td colspan="3">
                                            <input type="text" name="airline_code[]" placeholder="예) KE658">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>기타요철</th>
                                        <td colspan="3">
                                            <textarea name="order_memo[]" id="order_memo" class="other_irregularities" placeholder="예약업무를 주로 현지인 직원들이 처리하므로 여기에는 가급적 영어로 요청사항을 적어주시기 바랍니다. 중요한 요청 및 한글 요청 사항은 1:1 게시판에 따로 남겨주셔야 정상적으로 처리가 가능합니다."></textarea>
                                        </td>
                                    </tr>     
                                </tbody>
                            </table>
                        </div>
                    `;
                }
                
            }
        }else if(code_no == "5402"){
            form_html += `
                <div class="section_vehicle_table">
                    <table>
                        <colgroup>
                            <col width="150px">
                            <col width="*">
                            <col width="150px">
                            <col width="*">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>차량 미팅 날짜</th>
                                <td colspan="3">
                                    <div class="datepicker_wrap" style="width: 250px;">
                                        <input type="text" name="date_trip[]" class="date_form" readonly>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>미팅 시간</th>
                                <td colspan="3">
                                    <div class="meeting_time">
                                        <select name="hours[]" id="hours">
                                            <?php
                                            for ($i = 0; $i < 24; $i++) {
                                                $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                ?>
                                                <option value="<?= $hour ?>"><?= $hour ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="hours">시</label>
                                        <select name="minutes[]" id="minutes">
                                            <?php
                                            for ($i = 0; $i < 60; $i+=5) {
                                                $minute = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                ?>
                                                <option value="<?= $minute ?>"><?= $minute ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="minutes">분</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    미팅 장소
                                </th>
                                <td colspan="3">
                                    <div class="departure">
                                        <span class="departure_name"></span>
                                        <input type="text" name="departure_name[]" placeholder="호텔명을 영어로 적어주세요(주소불가)">
                                    </div>
                                    <div class="departure__note">
                                        - 일반주택은 정확한 건물명, 주소, 태국어 가능한 호스트의 태국 전화번호를 남겨주세요. <br>
                                        - 예약 시 선택하신 지역과 입력하신 장소가 다른 경우, 바우처 발송 후에도 추가 요금이 발생할 수 있습니다. <br>
                                        - 윈저파크, 아티타야 등 대부분의 방콕 골프텔은 방콕 외곽 지역에 속합니다.
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    항공편 명
                                </th>
                                <td colspan="3">
                                    <input type="text" name="airline_code[]" placeholder="예) KE658">
                                </td>
                            </tr>
                            <tr>
                                <th>기타 요청</th>
                                <td colspan="3">
                                    <textarea name="order_memo[]" class="other_irregularities" id="order_memo" placeholder="예약업무를 주로 현지인 직원들이 처리하므로 여기에는 가급적 영어로 요청사항을 적어주시기 바랍니다. 중요한 요청 및 한글 요청 사항은 1:1 게시판에 따로 남겨주셔야 정상적으로 처리가 가능합니다."></textarea>
                                </td>
                            </tr>     
                        </tbody>
                    </table>
                </div>
            `;
        }else if(code_no == "5403"){
            let start_date_text = $("#meeting_date").val();
            let end_date_text = $("#return_date").val();
            if(start_date_text && end_date_text) {
                const startDate = new Date(start_date_text);
                const endDate = new Date(end_date_text);

                const differenceInTime = endDate - startDate;

                let differenceInDays = (differenceInTime / (1000 * 60 * 60 * 24)) + 1;
                
                let currentDate = new Date(startDate);
                let i = 1;
                while (currentDate <= endDate) {
                    let day = arr_days[currentDate.getDay()];
                    form_html += `
                        <div class="section_vehicle_table">
                            <div class="section_vehicle_2_7__head__ttl vehicle_ttl">
                                <span class="schedule_ttl">${i} 일차</span> 일정을 입력해주세요
                            </div>
                            <table>
                                <colgroup>
                                    <col width="150px">
                                    <col width="*">
                                    <col width="150px">
                                    <col width="*">
                                </colgroup>
                                <tbody>
                                    <tr>
                                        <th>차량 출발시간</th>
                                        <td colspan="3">
                                            <div class="meeting_time">
                                                <input type="hidden" name="date_trip[]" value="${currentDate.toISOString().split('T')[0]}">
                                                <span class="meeting_time__date">${currentDate.toISOString().split('T')[0]}(${day})</span>
                                                <select name="hours[]" id="hours">
                                                    <?php
                                                    for ($i = 0; $i < 24; $i++) {
                                                        $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                        ?>
                                                        <option value="<?= $hour ?>"><?= $hour ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <label for="hours">시</label>
                                                <select name="minutes[]" id="minutes">
                                                    <?php
                                                    for ($i = 0; $i < 60; $i+=5) {
                                                        $minute = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                        ?>
                                                        <option value="<?= $minute ?>"><?= $minute ?></option>
                                                        <?php
                                                    }
                                                    ?>
                                                </select>
                                                <label for="minutes">분</label>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            출발지
                                        </th>
                                        <td colspan="3">
                                            <div class="departure">
                                                <span class="departure_name"></span>
                                                <input type="text" name="departure_name[]" placeholder="호텔명을 영어로 적어주세요(주소불가)">
                                            </div>
                                            <div class="departure__note">
                                                - 일반주택은 정확한 건물명, 주소, 태국어 가능한 호스트의 태국 전화번호를 남겨주세요. <br>
                                                - 예약 시 선택하신 지역과 입력하신 장소가 다른 경우, 바우처 발송 후에도 추가 요금이 발생할 수 있습니다. <br>
                                                - 윈저파크, 아티타야 등 대부분의 방콕 골프텔은 방콕 외곽 지역에 속합니다.
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>
                                            이동루트
                                        </th>
                                        <td colspan="3">
                                            <textarea name="schedule_content[]" placeholder="가급적 영어로 적어주세요. 사전에 고지되지 않은 코스를 추가하실 때에는 추가 요금이 발생할 수 있으니 가급적 일정을 상세히 적어 주시기 바랍니다." class="other_irregularities schedule_content"></textarea>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>기타요철</th>
                                        <td colspan="3">
                                            <textarea name="order_memo[]" placeholder="예약업무를 주로 현지인 직원들이 처리하므로 여기에는 가급적 영어로 요청사항을 적어주시기 바랍니다. 중요한 요청 및 한글 요청 사항은 1:1 게시판에 따로 남겨주셔야 정상적으로 처리가 가능합니다." class="other_irregularities order_memo"></textarea>
                                        </td>
                                    </tr>     
                                </tbody>
                            </table>
                        </div>
                    `;
                    i++;
                    currentDate.setDate(currentDate.getDate() + 1);
                }
            }

        }else if(code_no == "5404"){
            let startDate = $("#meeting_date").val();
            let currentDate = new Date(startDate);
            let day = arr_days[currentDate.getDay()];
            form_html += `
                <div class="section_vehicle_table">
                    <table>
                        <colgroup>
                            <col width="150px">
                            <col width="*">
                            <col width="150px">
                            <col width="*">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>차량 출발시간</th>
                                <td colspan="3">
                                    <div class="meeting_time">
                                        <input type="hidden" name="date_trip[]" value="${currentDate.toISOString().split('T')[0]}">
                                        <span class="meeting_time__date">${currentDate.toISOString().split('T')[0]}(${day})</span>
                                        <select name="hours[]" id="hours">
                                            <?php
                                            for ($i = 0; $i < 24; $i++) {
                                                $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                ?>
                                                <option value="<?= $hour ?>"><?= $hour ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="hours">시</label>
                                        <select name="minutes[]" id="minutes">
                                            <?php
                                            for ($i = 0; $i < 60; $i+=5) {
                                                $minute = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                ?>
                                                <option value="<?= $minute ?>"><?= $minute ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="minutes">분</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    출발지(픽업호텔)
                                </th>
                                <td colspan="3">
                                    <div class="departure">
                                        <span class="departure_name"></span>
                                        <input type="text" name="departure_name[]" placeholder="호텔명을 영어로 적어주세요(주소불가)">
                                    </div>
                                    <div class="departure__note">
                                        - 일반주택은 정확한 건물명, 주소, 태국어 가능한 호스트의 태국 전화번호를 남겨주세요. <br>
                                        - 예약 시 선택하신 지역과 입력하신 장소가 다른 경우, 바우처 발송 후에도 추가 요금이 발생할 수 있습니다. <br>
                                        - 윈저파크, 아티타야 등 대부분의 방콕 골프텔은 방콕 외곽 지역에 속합니다.
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    경유지
                                </th>
                                <td colspan="3">
                                    <input type="text" name="rest_name[]" placeholder="가급적 영어로 적어주세요.">
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    목적지
                                </th>
                                <td colspan="3">
                                    <input type="text" name="destination_name[]" placeholder="가급적 영어로 적어주세요.">
                                </td>
                            </tr>
                            <tr>
                                <th>기타요철</th>
                                <td colspan="3">
                                    <textarea name="order_memo[]" placeholder="예약업무를 주로 현지인 직원들이 처리하므로 여기에는 가급적 영어로 요청사항을 적어주시기 바랍니다. 중요한 요청 및 한글 요청 사항은 1:1 게시판에 따로 남겨주셔야 정상적으로 처리가 가능합니다." class="other_irregularities order_memo"></textarea>
                                </td>
                            </tr>     
                        </tbody>
                    </table>
                </div>
            `;
        }else if(code_no == "5405"){
            let startDate = $("#meeting_date").val();
            let currentDate = new Date(startDate);
            let day = arr_days[currentDate.getDay()];
            form_html += `
                <div class="section_vehicle_table">
                    <table>
                        <colgroup>
                            <col width="150px">
                            <col width="*">
                            <col width="150px">
                            <col width="*">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>미팅 시간</th>
                                <td colspan="3">
                                    <div class="meeting_time">
                                        <input type="hidden" name="date_trip[]" value="${currentDate.toISOString().split('T')[0]}">
                                        <span class="meeting_time__date">${currentDate.toISOString().split('T')[0]}(${day})</span>
                                        <select name="hours[]" id="hours">
                                            <?php
                                            for ($i = 0; $i < 24; $i++) {
                                                $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                ?>
                                                <option value="<?= $hour ?>"><?= $hour ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="hours">시</label>
                                        <select name="minutes[]" id="minutes">
                                            <?php
                                            for ($i = 0; $i < 60; $i+=5) {
                                                $minute = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                ?>
                                                <option value="<?= $minute ?>"><?= $minute ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="minutes">분</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    출발지(픽업호텔)
                                </th>
                                <td colspan="3">
                                    <div class="departure">
                                        <span class="departure_name"></span>
                                        <input type="text" name="departure_name[]" placeholder="호텔명을 영어로 적어주세요(주소불가)">
                                    </div>
                                    <div class="departure__note">
                                        - 일반주택은 정확한 건물명, 주소, 태국어 가능한 호스트의 태국 전화번호를 남겨주세요. <br>
                                        - 예약 시 선택하신 지역과 입력하신 장소가 다른 경우, 바우처 발송 후에도 추가 요금이 발생할 수 있습니다. <br>
                                        - 윈저파크, 아티타야 등 대부분의 방콕 골프텔은 방콕 외곽 지역에 속합니다.
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    목적지
                                </th>
                                <td colspan="3">
                                    <div class="destination">
                                        <span class="destination_name"></span>
                                        <input type="text" name="destination_name[]" placeholder="호텔명을 영어로 적어주세요(주소불가)">
                                    </div>
                                    <div class="departure__note">
                                        - 일반주택은 정확한 건물명, 주소, 태국어 가능한 호스트의 태국 전화번호를 남겨주세요. <br>
                                        - 예약 시 선택하신 지역과 입력하신 장소가 다른 경우, 바우처 발송 후에도 추가 요금이 발생할 수 있습니다. <br>
                                        - 윈저파크, 아티타야 등 대부분의 방콕 골프텔은 방콕 외곽 지역에 속합니다.
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>기타요철</th>
                                <td colspan="3">
                                    <textarea name="order_memo[]" placeholder="예약업무를 주로 현지인 직원들이 처리하므로 여기에는 가급적 영어로 요청사항을 적어주시기 바랍니다. 중요한 요청 및 한글 요청 사항은 1:1 게시판에 따로 남겨주셔야 정상적으로 처리가 가능합니다." class="other_irregularities order_memo"></textarea>
                                </td>
                            </tr>     
                        </tbody>
                    </table>
                </div>
            `;
        }else{
            let startDate = $("#meeting_date").val();
            let currentDate = new Date(startDate);
            let day = arr_days[currentDate.getDay()];
            form_html += `
                <div class="section_vehicle_table">
                    <table>
                        <colgroup>
                            <col width="150px">
                            <col width="*">
                            <col width="150px">
                            <col width="*">
                        </colgroup>
                        <tbody>
                            <tr>
                                <th>미팅 시간</th>
                                <td colspan="3">
                                    <div class="meeting_time">
                                        <input type="hidden" name="date_trip[]" value="${currentDate.toISOString().split('T')[0]}">
                                        <span class="meeting_time__date">${currentDate.toISOString().split('T')[0]}(${day})</span>
                                        <select name="hours[]" id="hours">
                                            <?php
                                            for ($i = 0; $i < 24; $i++) {
                                                $hour = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                ?>
                                                <option value="<?= $hour ?>"><?= $hour ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="hours">시</label>
                                        <select name="minutes[]" id="minutes">
                                            <?php
                                            for ($i = 0; $i < 60; $i+=5) {
                                                $minute = str_pad($i, 2, '0', STR_PAD_LEFT);
                                                ?>
                                                <option value="<?= $minute ?>"><?= $minute ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                        <label for="minutes">분</label>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    출발지(픽업호텔)
                                </th>
                                <td colspan="3">
                                    <div class="departure">
                                        <span class="departure_name"></span>
                                        <input type="text" name="departure_name[]" placeholder="호텔명을 영어로 적어주세요(주소불가)">
                                    </div>
                                    <div class="departure__note">
                                        - 일반주택은 정확한 건물명, 주소, 태국어 가능한 호스트의 태국 전화번호를 남겨주세요. <br>
                                        - 예약 시 선택하신 지역과 입력하신 장소가 다른 경우, 바우처 발송 후에도 추가 요금이 발생할 수 있습니다. <br>
                                        - 윈저파크, 아티타야 등 대부분의 방콕 골프텔은 방콕 외곽 지역에 속합니다.
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    목적지(골프장명)
                                </th>
                                <td colspan="3">
                                    <input type="text" name="destination_name[]" placeholder="가급적 영어로 적어주세요.">
                                </td>
                            </tr>
                            <tr>
                                <th>기타 요청</th>
                                <td colspan="3">
                                    <textarea name="order_memo[]" class="other_irregularities order_memo" placeholder="예약업무를 주로 현지인 직원들이 처리하므로 여기에는 가급적 영어로 요청사항을 적어주시기 바랍니다. 중요한 요청 및 한글 요청 사항은 1:1 게시판에 따로 남겨주셔야 정상적으로 처리가 가능합니다."></textarea>
                                </td>
                            </tr>     
                        </tbody>
                    </table>
                </div>
            `;
        }
        
        $(".section_vehicle_info_wrap").html(form_html);

        let selected_meeting_date = $("#meeting_date").val();

        if(code_no == "5401"){
            $(".date_form_trip").val(selected_meeting_date);

            let currentDate = new Date(selected_meeting_date);

            currentDate.setDate(currentDate.getDate() + 1);

            let nextDate = currentDate.toISOString().split('T')[0]; 

            $(".date_form_trip").datepicker({
                dateFormat: "yy-mm-dd",
                showOn: "both",
                buttonImage: "/images/ico/date_ico.png",
                buttonImageOnly: true,
                minDate: new Date(selected_meeting_date),
                maxDate: new Date(nextDate)
            });
        }

        $(".date_form").val(selected_meeting_date);
        $(".date_form").datepicker({
            dateFormat: "yy-mm-dd",
            showOn: "both",
            buttonImage: "/images/ico/date_ico.png",
            buttonImageOnly: true,
            minDate: new Date(selected_meeting_date)
        });

        let departure_name = $(".place_chosen__start_pop .popup_place__list li span.active").text();
        let destination_name = $(".place_chosen__end_pop .popup_place__list li span.active").text();
        $(".departure_name").text(departure_name);
        $(".destination_name").text(destination_name);
    }

    function handleSelectVehicle(e) {

        $(e).closest("tr").siblings().find(".vehicle_options input[type='checkbox']").prop("checked", false);

        let id = $(e).data("id");

        $("#cp_idx").val("");
        $("#product_vehicle_list_selected").empty();
        $(".section_vehicle_2_7").hide();
        $(".section_vehicle_info_wrap").empty();

        const min_cnt = Number($(`#minium_people_cnt_${id}`).val());
        const max_cnt = Number($(`#total_people_cnt_${id}`).val());
        let cnt = Number($(`#product_vehicle_list tr.product_${id}`).find("select.vehicle_cnt").val());

        let total_adult_cnt = Number($(`#adult_cnt_${id}`).val()) * cnt;
        let total_people_cnt = Number($(`#people_cnt_${id}`).val()) * cnt;

        let select_adult_cnt = Number($("#adult_cnt").val()) ?? 0;
        let select_child_cnt = Number($("#child_cnt").val()) ?? 0;

        if (max_cnt - min_cnt <= 0) {
            alert("제품 수량이 충분하지 않습니다.");
            $(e).prop("checked", false);
            calculatePrice();
            return false;
        }

        if (cnt === 0) {
            alert("0보다 큰 수량을 선택하세요.");
            $(e).prop("checked", false);
            calculatePrice();
            return false;
        }

        if((select_adult_cnt > total_adult_cnt && select_child_cnt == 0) || (select_adult_cnt + select_child_cnt > total_people_cnt && select_child_cnt != 0)) {
            alert("차량은 자리수 부족합니다. 다른 분류 선택하거나 수량 확인부탁드립니다");
            $(e).prop("checked", false);
            calculatePrice();
            return false;
        }

        let cp_idx = $("#cp_idx").val();

        if ($(e).is(":checked")) {

            if (cp_idx != id) {
                const $tr = $(`#product_vehicle_list tr.product_${id}`).clone();
                $tr.find(".vehicle_options").hide();
                $tr.find("button").attr("disabled", true);
                $tr.data("cnt", $(`#product_vehicle_list tr.product_${id}`).find("select.vehicle_cnt").val());
                $("#product_vehicle_list_selected").html($tr);

                addFormReservation();

                $(".section_vehicle_2_7").show();

                cp_idx = id;
            }

        } else {
            $(`#product_vehicle_list_selected .product_${id}`).remove();
            cp_idx = "";
        }
        $("#cp_idx").val(cp_idx);

        calculatePrice();
    }

</script>

<script>
    initCars();

    function initCars() {
        get_destination();
    }
</script>

<script>
    function closePopup() {
        $(".popup_wrap").hide();
        $(".dim").hide();
    }

    function init_datepicker() {
        let today = new Date();
        let departureDate = new Date($("#meeting_date").val());
        let destinationDate = new Date($("#return_date").val());

        $("#departure_date").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: today,
            onSelect: function (dateText, inst) {
                departureDate = $(this).datepicker('getDate');

                var date = $(this).datepicker('getDate');
                const year = String(date.getFullYear()).slice(-2);
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const dayOfWeek = daysOfWeek[date.getDay()];

                $("#departure_date_text").text(`${year}.${month}.${day}(${dayOfWeek})`);
                $(".meeting_time__date").text(`${date.getFullYear()}-${month}-${day}(${dayOfWeek})`);
                $("#meeting_date").val(`${date.getFullYear()}-${month}-${day}`);

                $("#destination_date").datepicker('option', 'minDate', departureDate);
                calculate_days(departureDate, destinationDate);

                $(".section_vehicle_info_wrap").empty();
                addFormReservation();
            },
            beforeShowDay: function(date) {
                if (destinationDate && date > destinationDate) {
                    return [false, 'ui-state-disabled'];
                }
                return [true, ''];
            }
        });

        $("#destination_date").datepicker({
            dateFormat: "yy-mm-dd",
            minDate: today,
            onSelect: function (dateText, inst) {
                destinationDate = $(this).datepicker('getDate');
                var date = $(this).datepicker('getDate');
                const year = String(date.getFullYear()).slice(-2);
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                const dayOfWeek = daysOfWeek[date.getDay()];

                $("#destination_date_text").text(`${year}.${month}.${day}(${dayOfWeek})`);
                $("#return_date").val(`${date.getFullYear()}-${month}-${day}`);

                $("#departure_date").datepicker('option', 'maxDate', destinationDate);

                calculate_days(departureDate, destinationDate);

                $(".section_vehicle_info_wrap").empty();
                addFormReservation();
            },
            beforeShowDay: function(date) {
                if (departureDate && date < departureDate) {
                    return [false, 'ui-state-disabled'];
                }
                return [true, ''];
            }
        });

    }

    function calculate_days(departureDate, destinationDate) {
        if (departureDate && destinationDate) {
            let startDate = moment(departureDate);
            let endDate = moment(destinationDate);

            let daysDiff = endDate.diff(startDate, 'days');
            daysDiff = daysDiff + 1;
            $("#day_range_total").val(daysDiff);
            $("#day_range_text").text(daysDiff);
        }
    }

    $("#place_chosen__start").on("click", function () {
        $(".place_chosen__start_pop, .place_chosen__start_pop .dim").show();
    });

    $("#place_chosen__end").on("click", function () {
        $(".place_chosen__end_pop, .place_chosen__end_pop .dim").show();
    });

    $(".vehicle_ttl__link").on("click", function () {
        $(".policy_pop, .policy_pop .dim").show();
    });

    $(".date_form").datepicker({
        dateFormat: "yy-mm-dd",
        showOn: "both",
        buttonImage: "/images/ico/date_ico.png",
        buttonImageOnly: true
    });

    $("#place_chosen__people").on("click", function () {
        $(".place_chosen__people_pop").toggle();
    });

    $(".btn_minus").on("click", function () {
        const val = Number($(this).parent().find("input").val()) || 0;
        if (val === 1) {
            $(this).attr("disabled", true);
        }
        if (val > 0) {
            $(this).parent().find("input").val(val - 1);
        }
    });

    $(".btn_plus").on("click", function () {
        const val = Number($(this).parent().find("input").val()) || 0;
        $(this).parent().find("input").val(val + 1);
        $(this).parent().find(".btn_minus").attr("disabled", false);
    });

    $("#btn_pickup_people").on("click", function () {

        $(".pickup_amount__num").each(function () {
            const name = $(this).attr("name");
            $("#people_" + name).text($(this).val());
            $("#" + name).val($(this).val());
        })

        $(".place_chosen__people_pop").hide();

        let selected_product = $("#product_vehicle_list").children("tr").find(".vehicle_options input[type='checkbox']:checked");

        if(selected_product.length > 0){
            let id = selected_product.data("id");            

            let cnt = Number($(`#product_vehicle_list tr.product_${id}`).find("select.vehicle_cnt").val());

            let total_adult_cnt = Number($(`#adult_cnt_${id}`).val()) * cnt;
            let total_people_cnt = Number($(`#people_cnt_${id}`).val()) * cnt;

            let select_adult_cnt = Number($("#adult_cnt").val()) ?? 0;
            let select_child_cnt = Number($("#child_cnt").val()) ?? 0;

            $("#frm_adult_cnt").text(select_adult_cnt);
            $("#frm_child_cnt").text(select_child_cnt);

            if((select_adult_cnt > total_adult_cnt && select_child_cnt == 0) || (select_adult_cnt + select_child_cnt > total_people_cnt && select_child_cnt != 0)) {
                alert("차량은 자리수 부족합니다. 다른 분류 선택하거나 수량 확인부탁드립니다");
                selected_product.prop("checked", false);
                $("#cp_idx").val("");
                $("#product_vehicle_list_selected").empty();
                $(".section_vehicle_2_7").hide();
                $(".section_vehicle_info_wrap").empty();
                calculatePrice();
                return false;
            }
            
        }

    });

    $(".btn_submit").on("click", function () {

        <?php
            if (empty(session()->get("member")["id"])) {
        ?>
            alert("주문하시려면 로그인해주세요!");
            return false;
        <?php
            }
        ?>

        var frm = document.frmCar;

        if (frm.departure_area.value == "") {
            alert("출발지역 선택해주세요!");
            return false;
        }

        if (frm.destination_area.value == "") {
            alert("출발지역 선택해주세요!");
            return false;
        }

        if (!frm.adult_cnt.value) {
            alert("소아 선택해주세요!");
            return false;
        }

        if (frm.cp_idx.value == "") {
            alert("제품을 선택해주세요!");
            return false;
        }

        if (frm.order_user_name.value == "") {
            alert("한국이름 입력해주세요!");
            return false;
        }

        if (frm.order_user_gender.value == "") {
            alert("성별 선택해주세요!");
            return false;
        }

        if (frm.order_user_first_name_en.value == "") {
            alert("영문 이름 입력해주세요!");
            return false;
        }

        if (frm.order_user_last_name_en.value == "") {
            alert("영문 성 입력해주세요!");
            return false;
        }

        if (frm.phone1.value == "" || frm.phone2.value == "" || frm.phone3.value == "") {
            alert("전화번호 입력해주세요!");
            return false;
        }

        if (frm.email_name.value == "" || frm.email_host.value == "") {
            alert("이메일 입력해주세요!");
            return false;
        }

        $.ajax({
            url: "/vehicle-guide/vehicle-order",
            type: "POST",
            data: $("#frmCar").serialize(),
            error: function (request, status, error) {
                alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
            }
            , success: function (response, status, request) {
                if (response.result == true) {
                    alert(response.message);
                    window.location.href = '/product/completed-order';
                } else {
                    alert(response.message);
                }
            }
        });

    });
</script>

<script>
    var swiper = new Swiper('.swiper_container_ticket', {
        slidesPerView: 1,
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        spaceBetween: 22,
        navigation: {
            nextEl: '.swiper-button-next-vehicle',
            prevEl: '.swiper-button-prev-vehicle',
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        on: {
            init: function () {
                updateSlideCounter(this);
            },
            slideChange: function () {
                updateSlideCounter(this);
            }
        }
    });

    function updateSlideCounter(swiper) {
        var currentIndex = swiper.realIndex + 1;
        var totalSlides = swiper.slides.length
    }

    document.getElementById('autoplay-button')?.addEventListener('click', function () {
        var playButton = document.getElementById('play-button');
        var pauseButton = document.getElementById('pause-button');
        if (swiper.autoplay.running) {
            swiper.autoplay.stop();
            playButton.style.display = 'block';
            pauseButton.style.display = 'none';
        } else {
            swiper.autoplay.start();
            playButton.style.display = 'none';
            pauseButton.style.display = 'block';
        }
    });
</script>

<?php $this->endSection(); ?>