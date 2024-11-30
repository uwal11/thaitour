<?php $this->extend('inc/layout_index'); ?>

<?php $this->section('content'); ?>
    <div class="customer-form-page golf">
    <div class="navigation-section">
        <div class="body_inner">
            <div class="content-main">
                <div class="item-n">
                    <span class="number-n">
                        1
                    </span>
                    <span class="label-n">상품선택</span>
                    <img src="/uploads/icons/arrow_right_nav.png" alt="">
                </div>
                <div class="item-n">
                    <span class="number-n">
                        2
                    </span>
                    <span class="label-n">예약정보</span>
                    <img src="/uploads/icons/arrow_right_nav.png" alt="">
                </div>
                <div class="item-n inactive">
                    <span class="number-n">
                        3
                    </span>
                    <span class="label-n">결제</span>
                </div>
            </div>
        </div>
    </div>
    <form action="/product-golf/customer-form-ok" name="order_frm" id="order_frm" method="post" target="hiddenFrame">
        <input type="hidden" name="product_idx" value="<?= $product_idx ?>">
        <input type="hidden" name="people_adult_cnt" value="<?= $people_adult_cnt ?>">
        <input type="hidden" name="order_date" id="order_date" value="<?= $order_date ?>">
        <input type="hidden" name="option_idx" id="option_idx" value="<?= $option_idx ?>">
        <input type="hidden" name="use_coupon_idx" id="use_coupon_idx" value="<?= $use_coupon_idx ?>">
        <div class="main-section">
            <div class="body_inner">
                <div class="container-card">
                    <div class="">
                        <div class="card-left">
                            <h3 class="title-main-c">
                                예약확정서 정보 입력
                            </h3>
                            <h3 class="title-sub-c">예약확정서 이름</h3>

                            <?php for ($i = 1; $i <= $people_adult_cnt; $i++) { ?>
                                <h3 class="title-sub-c">인원<?= $i ?></h3>

                                <div class="con-form mb-40">
                                    <div class="form-group">
                                        <label for="order_user_name">한국이름</label>
                                        <input type="text" id="order_user_name" name="order_user_name" required
                                               data-label="한국이름" placeholder="한국이름 작성해주세요."/>
                                    </div>

                                    <div class="form-group">
                                        <label for="gender<?= $i ?>">성별(남성/여성)*</label>
                                        <select name="companion_gender[]" id="gender<?= $i ?>" required
                                                data-label="성별" class="select-width" id="">
                                            <option value="M">남성</option>
                                            <option value="F">여성</option>
                                        </select>
                                    </div>
                                </div>
                            <?php } ?>

                            <div class="con-form mb-40">
                                <div class="form-group">
                                    <label for="order_user_first_name_en">영문 이름(First Name) *</label>
                                    <input type="text" id="order_user_first_name_en" name="order_user_first_name_en"
                                           required data-label="영문 이름" placeholder="영어로 작성해주세요."/>
                                </div>
                                <div class="form-group">
                                    <label for="order_user_last_name_en">영문 성(Last Name) *</label>
                                    <input type="text" id="order_user_last_name_en" name="order_user_last_name_en"
                                           required data-label="영문 성" placeholder="영어로 작성해주세요."/>
                                </div>
                            </div>
                            <h3 class="title-sub-c">연락처</h3>
                            <div class="form-group form-cus-select">
                                <label for="passport-name2">이메일 주소*</label>
                                <div class="cus-select-group">
                                    <input type="text" id="email_1" name="email_1" required data-label="이메일"
                                           placeholder="이메일"/>
                                    <span>@</span>
                                    <div class="email-group">
                                        <input type="text" name="email_2" id="email_2" required data-label="이메일"
                                               placeholder="" readonly>
                                        <select id="" class="select-width" onchange="handleEmail(this.value)">
                                            <option value="">선택</option>
                                            <option value="naver.com">naver.com</option>
                                            <option value="hanmail.net">hanmail.net</option>
                                            <option value="hotmail.com">hotmail.com</option>
                                            <option value="nate.com">nate.com</option>
                                            <option value="yahoo.co.kr">yahoo.co.kr</option>
                                            <option value="empas.com">empas.com</option>
                                            <option value="dreamwiz.com">dreamwiz.com</option>
                                            <option value="freechal.com">freechal.com</option>
                                            <option value="lycos.co.kr">lycos.co.kr</option>
                                            <option value="korea.com">korea.com</option>
                                            <option value="gmail.com">gmail.com</option>
                                            <option value="hanmir.com">hanmir.com</option>
                                            <option value="paran.com">paran.com</option>
                                            <option value="1">직접입력</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="phone_wrap">
                                <div class="phone_wrap_item form-group">
                                    <p>
                                        <input type="radio" id="test1" name="radio_phone" value="kor" checked>
                                        <label for="test1">한국번호*</label>
                                    </p>
                                    <div class="form-group form-group-cus-4input">
                                        <input name="phone_1" maxlength="3" class="phone_kor phone" type="text"
                                               id="phone_1" required data-label="한국번호"/>
                                        <span> - </span>
                                        <input name="phone_2" maxlength="4" class="phone_kor phone" type="text"
                                               id="phone_2" required data-label="한국번호"/>
                                        <span> - </span>
                                        <input name="phone_3" maxlength="4" class="phone_kor phone" type="text"
                                               id="phone_3" required data-label="한국번호"/>
                                    </div>
                                </div>
                                <div class="phone_wrap_item form-group">
                                    <p>
                                        <input type="radio" id="test2" name="radio_phone" value="thai">
                                        <label for="test2">태국번호 *</label>
                                    </p>
                                    <div class="form-group">
                                        <input name="phone_thai" maxlength="10" class="phone_thai phone" type="text"
                                               id="phone_thai" disabled required data-label="한국번호"/>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mo_mt-30">
                                <label for="passport-name2">여행시 현지 연락처</label>
                                <div class="form-group-flex">
                                    <select id="car-time-hour" class="select-width">
                                        <option value="01">TH</option>
                                    </select>
                                    <input name="local_phone" class="phone" maxlength="10" type="text" id="local_phone"
                                           placeholder=""/>
                                </div>
                            </div>
                        </div>

                        <div class="card-left2">
                            <h3 class="title-main-c">
                                여행자 정보 입력
                            </h3>
                            <div class="form-container">
                                <h3 class="form-title title-sub-c">골프장 왕복 픽업 차량 승용차: <?= $total_vehicle ?>대</h3>
                                <div class="con-form-select form-group mb-30">
                                    <label for="car-time-hour">차량 미팅 시간</label>
                                    <div class="form-group time-group">
                                        <div class="form-group-second">
                                            <select id="car-time-hour" name="vehicle_time_hour" class="select-width">
                                                <?php for ($i = 6; $i <= 19; $i++) { ?>
                                                    <option value="<?= sprintf("%02d", $i) ?>"><?= sprintf("%02d", $i) ?></option>
                                                <?php } ?>
                                            </select>
                                            <span>시</span>
                                        </div>
                                        <div class="form-group-second">
                                            <select id="car-time-minute" name="vehicle_time_minute"
                                                    class="select-width">
                                                <?php for ($i = 0; $i < 60; $i++) { ?>
                                                    <option value="<?= sprintf("%02d", $i) ?>"><?= sprintf("%02d", $i) ?></option>
                                                <?php } ?>
                                            </select>
                                            <span>분</span>
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group mb-30">
                                    <label for="pickup-location">출발지(필요호텔)</label>
                                    <input class="mb-10" type="text" id="pickup-location"
                                           name="departure_point"
                                           placeholder="호텔명을 영어로 적어주세요(주소불가)"/>
                                    <span class="text-gray">※일반주택은 정확한 건물명, 주소, 태국어 가능한 호스트의 태국 전화번호를 남겨줴요.</span>
                                </div>


                                <!-- <div class="form-group mb-30">
                                    <label for="golf-club">목적지(골프장명)</label>
                                    <input type="text" id="golf-club" value="Nikanti Golf Club" readonly />
                                </div> -->


                                <div class="form-group cus-form-group">
                                    <label for="extra-requests">기타요청</label>
                                    <textarea id="extra-requests" name="custom_req"
                                              placeholder="예약업무를 주로 현지인 직원들이 처리하므로 여기에는 가급적 영어로 요청사항을 적어주시기 바랍니다. 중요한 요청 및 한글 요청 사항은 1:1게시판에 따로 남겨주셔야 정상적으로 처리가 가능합니다."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="card-right">
                            <img src="/data/product/<?= $product['ufile1'] ?>" alt="">
                            <div class="below-right">
                                <h3 class="title-r"><?= $product['product_name'] ?></h3>
                                <p class="title-sub-r text-gray"><?= $product['addrs'] ?></p>
                                <h3 class="title-r"><?= $option['hole_cnt'] ?>홀 프로모션 오전</h3>
                                <div class="item-info">
                                    <span>일정</span>
                                    <span><?= $final_date ?></span>
                                </div>
                                <div class="item-info">
                                    <span>홀수</span>
                                    <span><?= $option['hole_cnt'] ?>홀</span>
                                </div>
                                <div class="item-info">
                                    <span>티오프시간</span>
                                    <span><?= $option['hour'] ?>시 <?= $option['minute'] ?>분</span>
                                </div>
                                <div class="item-info">
                                    <span>인원</span>
                                    <span><?= $people_adult_cnt ?>명</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-right2">
                            <h3 class="title-r">
                                요금정보
                            </h3>
                            <div class="item-info-r">
                                <span>그린피</span>
                                <span><?= number_format($total_price) ?>원 (<?= number_format($total_price_baht) ?>바트)</span>
                            </div>
                            <div class="item-info-r">
                                <span>캐디피</span>
                                <span>그린피에 포함</span>
                            </div>
                            <div class="item-info-r item-info-r-border-b">
                                <span>카트피</span>
                                <span>그린피에 포함</span>
                            </div>
                            <?php foreach ($vehicle_arr as $key => $value) { ?>
                                <div class="item-info-r item-info-r-border-b">
                                    <span>골프장 왕복 픽업 차량<br><?= $value['code_name'] ?> x <?= $value['cnt'] ?>대</span>
                                    <span><?= number_format($value['price']) ?>원 (<?= number_format($value['price_baht']) ?>바트)</span>
                                    <input type="hidden" name="vehicle_idx[]" value="<?= $value['code_idx'] ?>">
                                    <input type="hidden" name="vehicle_cnt[]" value="<?= $value['cnt'] ?>">
                                </div>
                            <?php } ?>
                            <div class="item-info-r">
                                <span>할인금액</span>
                                <span>- <?= number_format($discount) ?>원 (<?= number_format($discount_baht) ?>바트)</span>
                            </div>
                            <div class="item-info-r font-bold-cus">
                                <span>합계</span>
                                <span><?= number_format($final_price) ?>원</span>
                            </div>
                            <p class="below-des-price">
                                · 견적서를 받으신 후 결제해 주시면 결제 확인 후 해당
                                업체에 확정 요청을 합니다. 즉시 확정 상품은 결제해
                                주시면 확정 처리됩니다.
                            </p>
                            <div class="below-title-image">
                                <img class="only_web" src="/uploads/icons/block_icon.png" alt="block_icon">
                                <img class="only_mo" src="/uploads/icons/block_icon_mo.png" alt="block_icon">
                                <span>취소규정</span>
                            </div>
                            <p class="below-sub-des"><span class="color-blue">무료취소</span> / 결제 후 2024.09.01(일) 18시(한국시간)
                                이전
                            </p>
                            <span class="cus-label-r">본 예약건 취소규정</span>
                            <h3 class="title-r">약관동의</h3>
                            <div class="item-info-check-first item-clause-all">
                                <span>전체동의</span>
                                <!-- <img src="/uploads/icons/form_check_icon.png" alt="form_check_icon"> -->
                                <i></i>
                            </div>
                            <div class="item-info-check item-clause-item">
                                <span>이용약관 동의(필수)</span>
                                <!-- <img src="/uploads/icons/form_check_icon.png" alt="form_check_icon"> -->
                                <i></i>
                            </div>
                            <div class="item-info-check item-clause-item">
                                <span>개인정보 처리방침(필수)</span>
                                <!-- <img src="/uploads/icons/form_check_icon.png" alt="form_check_icon"> -->
                                <i></i>
                            </div>
                            <div class="item-info-check item-clause-item">
                                <span>개인정보 제3자 제공 및 국외 이전 동의(필수)</span>
                                <!-- <img src="/uploads/icons/form_check_icon.png" alt="form_check_icon"> -->
                                <i></i>
                            </div>
                            <div class="item-info-check item-clause-item">
                                <span>여행안전수칙 동의(필수)</span>
                                <!-- <img src="/uploads/icons/form_check_icon.png" alt="form_check_icon"> -->
                                <i></i>
                            </div>
                            <button class="btn-order" type="button" onclick="handleSubmit()">예약하기</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <iframe src="" id="hiddenFrame" name="hiddenFrame" style="display: none;" frameborder="0"></iframe>
    <script>
        $(document).ready(function () {

            $(".phone").on("input", function () {
                $(this).val($(this).val().replace(/[^0-9]/g, ""));
            });

            function formatDate(date) {
                var d = new Date(date),
                    month = '' + (d.getMonth() + 1),
                    day = '' + d.getDate(),
                    year = d.getFullYear();

                if (month.length < 2) month = '0' + month;
                if (day.length < 2) day = '0' + day;

                return [year, month, day].join('/');
            }

            $("#checkin, #checkout").datepicker({
                dateFormat: 'yy/mm/dd',
                onSelect: function (dateText, inst) {
                    var date = $(this).datepicker('getDate');
                    $(this).val(formatDate(date));
                }
            });

            $('#checkin').val(formatDate('2024/07/09'));
            $('#checkout').val(formatDate('2024/07/10'));


            $('.tab_box_element_').on('click', function () {

                $('.tab_box_element_').removeClass('tab_active_');


                $(this).addClass('tab_active_');


                const tabId = $(this).attr('rel');
                $('.tab_content').hide();
                $('#' + tabId).show();
            });

            $(".item-clause-all").click(function () {
                if ($(this).hasClass("click")) {
                    $(this).removeClass("click");
                    $('.item-clause-item').each(function () {
                        $(this).removeClass("acti");
                        $(this).find("img").attr("src", "/uploads/icons/form_check_icon.png");
                    })
                } else {
                    $(this).addClass("click");
                    $('.item-clause-item').each(function () {
                        $(this).addClass("acti");
                        $(this).find("img").attr("src", "/images/btn/clause-check-black.png");
                    })
                }
            });

            $(".item-clause-item").click(function () {
                if ($(this).hasClass("acti")) {
                    $(this).removeClass("acti");
                    $(this).find("img").attr("src", "/uploads/icons/form_check_icon.png");
                } else {
                    $(this).addClass("acti");
                    $(this).find("img").attr("src", "/images/btn/clause-check-black.png");
                }

                var allHaveActi = true;

                $('.item-clause-item').each(function () {
                    if (!$(this).hasClass('acti')) {
                        allHaveActi = false;
                        return false;
                    }
                });
                if (allHaveActi) {
                    $(".item-clause-all").addClass("click")
                } else {
                    $(".item-clause-all").removeClass("click")
                }
            });

            $("input[name='radio_phone'").change(function () {
                if ($(this).val() == 'kor') {
                    $(".phone_kor").attr("disabled", false).eq(0).focus();
                    $(".phone_thai").attr("disabled", true);
                } else {
                    $(".phone_thai").attr("disabled", false).focus();
                    $(".phone_kor").attr("disabled", true);
                }
            })
        });

        function handleEmail(email) {
            if (email == '1') {
                $("#email_2").val('').prop('readonly', false).focus();
            } else {
                $("#email_2").val(email).prop('readonly', true);
            }
        }
    </script>
    <script>
        function handleSubmit() {
            const frm = document.order_frm;
            let flag = true;

            $("input[required]:not(:disabled)").each(function () {
                if ($(this).val().trim() == "") {
                    alert($(this).attr("data-label") + "를 입력하십시오.");
                    $(this).focus();
                    flag = false;
                    return false;
                }
            });

            if (!flag) {
                return false;
            }

            if (!($(".item-clause-all").hasClass("click"))) {
                alert("이용약관 동의(필수)를 선택하십시오.");
                return false;
            }
            frm.submit();
        }
    </script>
<?php $this->endSection(); ?>