<?php $this->extend('inc/layout_index'); ?>
<?php $setting = homeSetInfo(); ?>
<?php $this->section('content'); ?>
    <link rel="stylesheet" type="text/css" href="/lib/daterangepicker/daterangepicker_custom.css"/>
    <script type="text/javascript" src="/lib/momentjs/moment.min.js"></script>
    <script type="text/javascript" src="/lib/daterangepicker/daterangepicker.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBw3G5DUAOaV9CFr3Pft_X-949-64zXaBg&libraries=geometry"
            async defer></script>
    <style>
        .tours-detail .container-calendar {
            display: block;
        }

        .tours-detail .container-calendar.tour {
            padding-top: 0;
            border-top: unset;
            gap: 40px;
            height: auto;
        }

        .tours-detail .container-calendar.tour.open_ {
            min-height: 500px;
        }

        .tours-detail .steps-type {
            display: flex;
            align-items: center;
            gap: 100px;
            margin-bottom: 110px;
            padding-left: 120px;
            margin-top: 50px;
        }

        .sec2-item-card .calendar_header {
            display: flex;
            justify-content: space-between;
            padding: 20px 0;
            cursor: pointer;
        }

        .sec2-item-card .calendar_header .desc_product {
            font-size: 22px;
            font-weight: 600;
        }

        .sec2-item-card .calendar_header .desc_product .desc_product_sub {
            font-size: 16px;
            font-weight: 400;
            color: #757575;
            margin-top: 15px;
            display: flex;
            justify-content: start;
            align-items: start;
            gap: 20px;
            margin-bottom: 20px;
        }

        .sec2-item-card .calendar_header .desc_product .desc_product_sub p {

        }

        .sec2-item-card .calendar_header .desc_product .desc_product_sub ul {
            display: flex;
            justify-content: start;
            align-items: start;
            gap: 10px;
            flex-direction: column;
        }

        .sec2-item-card .calendar_header .desc_product .desc_product_sub li {

        }

        .sec2-item-card .calendar_header .box_price {
            font-size: 16px;
            color: #757575;
        }

        .sec2-item-card .calendar_header .box_price i {
            color: #000;
            font-size: 22px;
            font-weight: 600;
            margin-left: 10px;
        }

        .sec2-item-card .calendar_header .box_price .btn_oder {
            text-align: right;
        }

        .sec2-item-card .calendar_header .box_price .btn_oder button {
            padding: 7px 25px;
            border-radius: 6px;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            margin-top: 16px;
            width: 100%;
            height: 40px;
            background-color: #2a459f;
        }

        .sec2-item-card .desc_top {
            font-size: 17px;
            color: #757575;
            padding: 50px 0;
            text-align: center;
            line-height: 1.4;
            background-color: #fafafa;
            border-radius: 13px;
            margin-bottom: 50px;
        }

        .calendar_text_head {
            text-align: center;
            font-size: 20px;
            font-weight: 500;
            display: none;
        }

        .calendar_text_head.open_ {
            display: block;
        }

        .calendar_note {
            display: flex;
            gap: 40px;
            margin-top: 30px;
            font-size: 15px;
            font-weight: 500;
        }

        .calendar_note_cannot {
            padding-left: 20px;
            position: relative;
        }

        .calendar_note_cannot::before {
            content: "";
            position: absolute;
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #cccccc;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .calendar_note_maybe {
            padding-left: 20px;
            position: relative;
        }

        .calendar_note_maybe::before {
            content: "";
            position: absolute;
            display: inline-block;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #2a459f;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        table.book_tbl {
            width: 100%;
            margin: 0 auto;
            margin-bottom: 50px;
        }

        table.book_tbl tr {
            border-top: 2px solid #dbdbdb;
            border-bottom: 2px solid #dbdbdb;
        }

        table.book_tbl th,
        table.book_tbl td {
            font-weight: 400;
            text-align: left;
            padding: 14px 10px 14px 13px !important;
            position: static;
            /* border: 1px solid #dcdcdc */
        }

        table.book_tbl th {
            /* border-top: 1px solid #dcdcdc;
            border-right: 1px solid #dcdcdc;
            border-left: 1px solid #dcdcdc; */
            background-color: #f5f7f9 !important
        }

        table.book_tbl td {
            background: #fff;
            text-align: left;
            /* border: 1px solid #dcdcdc */
        }

        table.book_tbl td.label_flex label {
            display: flex;
            gap: 5px;
            align-items: center;
            margin-right: 20px;
            float: left
        }

        table.book_tbl .list {
            display: block;
            overflow: hidden
        }

        table.book_tbl .list li {
            float: left;
            margin-right: 20px;
            line-height: 16px
        }

        table.book_tbl .list li input {
            width: 14px;
            height: 14px;
            vertical-align: top;
            margin-right: 3px
        }

        table.book_tbl textarea.memo {
            width: 95%;
            padding: 5px
        }

        table.book_tbl span.ti_schedule {
            background: #93aac6;
            border: 1px solid #7a91ac;
            padding: 3px 10px;
            color: #fff
        }

        table.book_tbl .list_golf_mem .conts {
            display: flex;
            border: none;
            align-items: center;
            width: 100%
        }

        table.book_tbl .list_golf_mem .conts li {
            padding: 0
        }

        table.book_tbl .list_golf_mem .conts select {
            height: 30px;
            width: 50px;
            margin-right: 10px
        }

        table.book_result {
            width: 100%;
            margin-top: 20px
        }

        table.book_result th {
            background: #7d7d7d;
            color: #fff
        }

        table.book_result th,
        table.book_result td {
            text-align: center;
            padding: 10px 0;
            line-height: 16px;
            border: 0
        }

        table.book_result td {
            background: #fff
        }

        table.book_result b {
            color: #fb7622
        }

        .fl {
            float: left;
        }

        .mt5 {
            margin-top: 5px;
        }


        .content-sub-hotel-detail .section6 .title-sec6 {
            font-size: 24px;
            margin: 64px 0 32px;
        }

        .content-sub-hotel-detail .section6 .card-list-recommemded .recommemded-item {
            width: unset
        }

        .title_sec2 {
            font-size: 24px;
            margin-bottom: 40px;
        }

        .calendar_container_tongle {
            padding-top: 50px;
            border-top: 1px solid #dbdbdb;
            position: relative;

        }

        .calendar_container_tongle .close_btn {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }

        .tours-detail .section2 .sec2-item-card:last-child {
            padding-bottom: 30px;
        }

        .calendar_submit {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
        }

        .calendar_submit button {
            padding: 10px 26px;
            border: 10px;
            color: #fff;
            font-size: 22px;
            font-weight: 400;
            background-color: #2a459f;
            border-radius: 8px;
            width: 250px;
            height: 66px;
        }

        .daterange_guilde_detail {
            visibility: hidden;
        }

        /* Custom datepicker and dateranger */
        .daterangepicker {
            width: 1140px;
            left: calc((100% - 1140px) / 2);
            height: auto;
            display: block !important;
            position: static !important;
        }


        .daterangepicker .calendar-table td .custom-info {
            width: 74px;
            height: 77px;
            font-size: 18px;
            gap: 6px;
        }

        .daterangepicker .calendar-table td .custom-info .allow-text {
            font-size: 14px;
            padding: 5px;
        }

        .daterangepicker .calendar-table td .custom-info .sold-out-text {
            font-size: 14px;
            padding: 5px;
        }

        .daterangepicker .calendar-table table thead tr:nth-child(2) th {
            font-size: 18px;
            padding: 15px 10px;
        }

        .daterangepicker th.month {
            font-size: 18px;
        }
    </style>

    <div class="content-sub-hotel-detail tours-detail">
        <div class="body_inner">
            <form name="frm" id="frm" action="#" class="">
                <input type="hidden" name="product_idx" value="<?= $guide['product_idx'] ?>">

                <div class="section1">
                    <div class="title-container">
                        <h2><?= $guide['product_name'] ?></h2>
                        <div class="only_web">
                            <div class="list-icon">
                                <img src="/uploads/icons/print_icon.png" alt="print_icon">
                                <img src="/uploads/icons/heart_icon.png" alt="heart_icon">
                                <img src="/uploads/icons/share_icon.png" alt="share_icon">
                            </div>
                        </div>
                    </div>
                    <div class="location-container">
                        <img src="/uploads/icons/location_blue_icon.png" alt="location_blue_icon">
                        <span><?= $guide['product_country'] ?></span>
                    </div>
                    <div class="above-cus-content">
                        <div class="rating-container">
                            <img src="/uploads/icons/star_icon.png" alt="star_icon.png">
                            <span><strong> <?= $guide['review_average'] ?></strong></span>
                            <span>생생리뷰 <strong>(<?= $guide['total_review'] ?>)</strong></span>
                            <span>추천 MBTI: <?= $mcode['code_name'] ?></span>
                        </div>
                        <div class="list-icon only_mo">
                            <img src="/uploads/icons/print_icon.png" alt="print_icon">
                            <img src="/uploads/icons/heart_icon.png" alt="heart_icon">
                            <img src="/uploads/icons/share_icon.png" alt="share_icon">
                        </div>
                    </div>
                    <?php
                    $i3 = 0;
                    for ($t = 1; $t < 8; $t++) {
                        if (!empty($guide['ufile' . $t]) && $guide['ufile' . $t] != '') {
                            $i3++;
                        }
                    }
                    ?>
                    <div class="hotel-image-container">
                        <div class="hotel-image-container-1" style="">
                            <img class="imageDetailMain_"
                                 onclick="img_pops('<?= $guide['product_idx'] ?>')"
                                 src="/uploads/guides/<?= $guide['ufile1'] ?>"
                                 alt="<?= $guide['product_name'] ?>"
                                 onerror="this.src='/images/share/noimg.png'">
                        </div>
                        <div class="grid_2_2">
                            <?php for ($j = 2; $j < 5; $j++) { ?>
                                <img onclick="img_pops('<?= $guide['product_idx'] ?>')"
                                     class="grid_2_2_size imageDetailSup_"
                                     src="/uploads/guides/<?= $guide['ufile' . $j] ?>"
                                     alt="<?= $guide['product_name'] ?>" onerror="this.src='/images/share/noimg.png'">
                            <?php } ?>
                            <div class="grid_2_2_sub" onclick="img_pops('<?= $guide['product_idx'] ?>')"
                                 style="position: relative; cursor: pointer;">
                                <img class="custom_button imageDetailSup_"
                                     src="/uploads/guides/<?= $guide['ufile5'] ?>"
                                     alt="<?= $guide['product_name'] ?>"
                                     onerror="this.src='/images/share/noimg.png'">
                                <div class="button-show-detail-image">
                                    <img class="only_web" src="/uploads/icons/image_detail_icon.png"
                                         alt="image_detail_icon">
                                    <img class="only_mo" src="/uploads/icons/image_detail_icon_m.png"
                                         alt="image_detail_icon_m">
                                    <span>사진 모두 보기</span>
                                    <span>(<?= $i3 ?>장)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="sub-header-hotel-detail">
                        <div class="main nav-list">
                            <a class="active short_link" onclick="scrollToEl('product_info')" data-target="product_info"
                               href="#!">가격/상품정보</a>
                            <a class="short_link" onclick="scrollToEl('product_des')" data-target="product_des"
                               href="#!">생생리뷰</a>
                            <a class="short_link" onclick="scrollToEl('section8')" href="#!">상품Q&A</a>
                        </div>
                    </div>

                </div>
                <div class="section2" id="product_info">
                    <h4 class="title_sec2">가격/상품정보</h4>
                    <?php foreach ($options as $key => $option): ?>
                        <div class="sec2-item-card tour_calendar">

                            <div class="calendar_header" data-key="<?= $key ?>"
                                 data-num="<?= $option['o_idx'] ?>">
                                <div class="desc_product">
                                    <div class=""
                                         data-price="<?= $option['o_sale_price'] ?>"><?= $option['o_name'] ?></div>
                                    <div class="desc_product_sub">
                                        <p> 옵션포함:</p>
                                        <ul>
                                            <?php foreach ($option['sup_options'] as $item): ?>
                                                <li class="" data-price="<?= $item['s_price'] ?>">
                                                    - <?= $item['s_name'] ?> </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                    <div class="desc_product_sub">예약기능여부 : <span
                                                style="color : #2a459f "><?= $option['o_availability'] ?></span>
                                    </div>
                                </div>

                                <div class="box_price">
                                    <p>
                                        <?= number_format($option['o_sale_price']) ?>바트
                                        <i><?= number_format($option['o_sale_price'] * $setting['baht_thai']) ?></i>원
                                    </p>
                                    <div class="btn_oder">
                                        <button type="button">선택</button>
                                    </div>
                                </div>
                            </div>

                            <div class="calendar_container_tongle" style="display : none">
                                <div class="close_btn">
                                    <img src="/images/ico/close_ic.png" alt="">
                                </div>
                                <table class="book_tbl">
                                    <colgroup>
                                        <col style="width:15%">
                                        <col style="width:18%">
                                        <col style="width:15%">
                                        <col style="width:15%">
                                        <col style="width:18%">
                                        <col>
                                    </colgroup>
                                    <tbody>
                                    <tr>
                                        <th>가이드 시작일</th>
                                        <td colspan="1">
                                            <div class="custom_input fl mr5" style="width:150px">
                                                <div class="val_wrap">
                                                    <input name="checkin_date" type="text" data-key="<?= $key ?>"
                                                           data-num="<?= $option['o_idx'] ?>"
                                                           id="checkInDate<?= $option['o_idx'] ?>" class="hasDateranger"
                                                           data-group="true" placeholder="체크인" readonly="readonly"
                                                           value="" size="13">
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            <div class="fl mr5" style="width:80px ; margin-left: 10px">
                                                <div class="selectricWrapper selectric-selectric">
                                                    <div class="selectricHideSelect">
                                                        <select name="count_day" id="countDay<?= $option['o_idx'] ?>"
                                                                class="selectric">
                                                            <?php for ($i = 1; $i <= 31; $i++) { ?>
                                                                <option value="<?= $i ?>"><?= $i ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="line-height: 50px; margin-left: 10px;" class="fl">일</div>
                                        </td>
                                        <th>가이드 종료일</th>
                                        <td>
                                            <div class="custom_input fl mr5" style="width:150px">
                                                <div class="val_wrap">
                                                    <input name="checkout_date" type="text"
                                                           id="checkOutDate<?= $option['o_idx'] ?>"
                                                           class="hasDateranger" data-key="<?= $key ?>"
                                                           data-num="<?= $option['o_idx'] ?>"
                                                           data-group="true" placeholder="체크아웃" readonly="readonly"
                                                           value="" size="13">
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr id="">
                                        <th>총인원</th>
                                        <td colspan="5">
                                            <div class="fl mr5" style="width:90px">
                                                <select name="people_cnt" id="people<?= $option['o_idx'] ?>"
                                                        class="selectric">
                                                    <?php for ($i = 1; $i <= $option['o_people_cnt']; $i++) { ?>
                                                        <option value="<?= $i ?>"><?= $i ?> 명</option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <div class="calendar_text_head" id="calendar_text_head<?= $option['o_idx'] ?>">
                                    <span id="day_start_txt<?= $option['o_idx'] ?>">2023년 7월</span> ~ <span
                                            id="day_end_txt<?= $option['o_idx'] ?>">2023년 7월</span>
                                </div>
                                <div class="container-calendar tour" id="calendar_tab_<?= $option['o_idx'] ?>">
                                    <input style="height: 10px" type="text"
                                           id="daterange_guilde_detail<?= $option['o_idx'] ?>"
                                           class="daterange_guilde_detail"/>
                                </div>
                                <div class="calendar_note">
                                    <p class="calendar_note_cannot"> 예약마감</p>
                                    <p class="calendar_note_maybe"> 예약가능</p>
                                </div>

                                <div class="calendar_submit">
                                    <button type="button" onclick="location.href = '/guide_booking'">견적/예약하기</button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </form>

            <?php
            $reject_dates = [];
            $arr_date_ = explode('||||', $guide['deadline_time']);
            foreach ($arr_date_ as $itemDate) {
                if ($itemDate != "" && $itemDate) {
                    $arr_date_s_ = explode('||', $itemDate);

                    $start_date = new DateTime($arr_date_s_[0]);
                    $end_date = new DateTime($arr_date_s_[1]);
                    $end_date->modify('+1 day');

                    $interval = new DateInterval('P1D');
                    $daterange = new DatePeriod($start_date, $interval, $end_date);

                    foreach ($daterange as $date) {
                        $reject_dates[] = $date->format('Y-m-d');
                    }
                }
            }

            $available_dates = [];
            $arr_date_ = explode('||', $guide['available_period']);
            $start_date = new DateTime($arr_date_[0]);
            $end_date = new DateTime($arr_date_[1]);
            $end_date->modify('+1 day');

            $interval = new DateInterval('P1D');
            $daterange = new DatePeriod($start_date, $interval, $end_date);

            foreach ($daterange as $date) {
                $reject_dates[] = $date->format('Y-m-d');
            }
            ?>

            <script>
                $(document).ready(function () {
                    $(".calendar_header").click(function () {
                        $('.tour_calendar').removeClass('active');
                        $(".calendar_container_tongle").hide();
                        $(this).next().show().parent().addClass('active');
                        openDateRanger(this);
                    });

                    $(".calendar_container_tongle .close_btn").click(function () {
                        $(this).parent().hide()
                    });

                    $('.hasDateranger').click(function () {
                        openDateRanger(this);
                    })

                    function openDateRanger(el) {
                        /* Get idx of option */
                        let num_idx = $(el).data('num');

                        /*
                        Add style for option idx
                        */
                        $('.calendar_text_head').removeClass('open_')
                        $('#calendar_text_head' + num_idx).addClass('open_')
                        $('.container-calendar.tour').removeClass('open_')
                        $('#calendar_tab_' + num_idx).addClass('open_')
                        /* Init date ranger and open popup date ranger */
                        init_daterange(num_idx);
                        $('#daterange_guilde_detail' + num_idx).click();
                    }

                    async function init_daterange(idx) {
                        const enabled_dates = splitStartDate();
                        const reject_days = splitEndDate();

                        const daterangepickerElement = '#daterange_guilde_detail' + idx;
                        const calendarTabElement = '#calendar_tab_' + idx;

                        await $(daterangepickerElement).daterangepicker({
                            locale: {
                                format: 'YYYY-MM-DD',
                                separator: ' ~ ',
                                applyLabel: '적용',
                                cancelLabel: '취소',
                                fromLabel: '시작일',
                                toLabel: '종료일',
                                customRangeLabel: '사용자 정의',
                                daysOfWeek: ['일', '월', '화', '수', '목', '금', '토'],
                                monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                                firstDay: 0
                            },
                            isInvalidDate: function (date) {
                                const formattedDate = date.format('YYYY-MM-DD');
                                return enabled_dates.includes(formattedDate);
                            },
                            linkedCalendars: true,
                            alwaysShowCalendars: true,
                            parentEl: calendarTabElement,
                            minDate: moment().add(1, 'days'),
                            opens: "center"
                        }, await function (start, end) {
                            const startDate = moment(start.format('YYYY-MM-DD'));
                            const endDate = moment(end.format('YYYY-MM-DD'));

                            $('#checkInDate' + idx).val(startDate.format('YYYY-MM-DD'));
                            $('#checkOutDate' + idx).val(endDate.format('YYYY-MM-DD'));

                            const duration = moment.duration(endDate.diff(startDate));
                            const days = Math.round(duration.asDays());

                            const disabledDates = reject_days.filter(date => {
                                const newDate = moment(date);
                                return newDate.isBetween(startDate, endDate, 'day', '[]');
                            });

                            $("#countDay" + idx).val(days - disabledDates.length);
                        });

                        const observer = new MutationObserver((mutations) => {
                            mutations.forEach((mutation) => {
                                if (mutation.type === 'childList' && $(mutation.target).hasClass('calendar-table')) {
                                    $(mutation.target)
                                        .find('td.off.disabled')
                                        .each(function () {
                                            const $cell = $(this);
                                            const text = $cell.text().trim();
                                            if (!$cell.find('.custom-info').length) {
                                                $cell.html(`<div class="custom-info">
                                <span>${text}</span>
                                <span class="label sold-out-text">예약마감</span>
                                </div>`);
                                            }
                                        });
                                    $(mutation.target)
                                        .find('td.available')
                                        .each(function () {
                                            const $cell = $(this);
                                            const text = $cell.text().trim();
                                            if (!$cell.find('.custom-info').length) {
                                                $cell.html(`<div class="custom-info">
                                <span>${text}</span>
                                <span class="label allow-text">0만원</span>
                                </div>`);
                                            }
                                        });

                                    const filteredRows = $("tr").filter(function () {
                                        const tds = $(this).find("td");
                                        return tds.length > 0 && tds.toArray().every(td => $(td).hasClass("ends"));
                                    }).hide();
                                }
                            });
                        });

                        observer.observe(document.querySelector('.daterangepicker'), {
                            childList: true,
                            subtree: true,
                        });

                        $(daterangepickerElement).click()
                    }

                    function splitEndDate() {
                        let rj = `<?= implode(',', $reject_dates) ?>`;
                        return rj.split(',');
                    }

                    function splitStartDate() {
                        let rj = `<?= implode(',', $available_dates) ?>`;
                        return rj.split(',');
                    }
                });
            </script>

            <h2 class="title-sec3" id="product_des">
                상품설명
            </h2>
            <div class="des-type">
                <?= viewSQ($guide['product_info']) ?>
            </div>

            <h2 class="title-sec2">
                더투어랩 이용방법
            </h2>
            <div class="steps-type">
                <div class="step-type">
                    <div class="con-step">
                        <img src="/uploads/sub/step_img1.png" alt="step_img1">
                    </div>
                    <span class="step-label">예약신청</span>
                    <span class="number-step">1</span>
                    <div class="cus-step-note">
                        <img src="/uploads/icons/detail_step_icon.png" alt="detail_step_icon">
                        <span class="txt-step-note">기능유무조회</span>
                    </div>
                </div>
                <div class="step-type">
                    <div class="con-step">
                        <img src="/uploads/sub/step_img2.png" alt="step_img2">
                    </div>
                    <span class="step-label">예약신청</span>
                    <span class="number-step">2</span>
                    <div class="cus-step-note">
                        <img src="/uploads/icons/detail_step_icon.png" alt="detail_step_icon">
                        <span class="txt-step-note">결제</span>
                    </div>
                </div>

                <div class="step-type">
                    <div class="con-step">
                        <img src="/uploads/sub/step_img3.png" alt="step_img2">
                    </div>
                    <span class="step-label">예약신청</span>
                    <span class="number-step">3</span>
                    <div class="cus-step-note">
                        <img src="/uploads/icons/detail_step_icon.png" alt="detail_step_icon">
                        <span class="txt-step-note">확정 후</span>
                    </div>
                </div>
                <div class="step-type">
                    <div class="con-step">
                        <img src="/uploads/sub/step_img4.png" alt="step_img2">
                    </div>
                    <span class="step-label">예약신청</span>
                    <span class="number-step">4</span>
                </div>
            </div>

            <?php echo view("/product/inc/review_product", ['product' => $guide]); ?>


            <div class="custom-golf-detail">
                <div class="section6" id="section8">
                    <h2 class="title-sec6">상품문의(FAQ)</h2>

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
                            <li class="">
                                <div class="qa-item qa_item_">
                                    <div class="qa-question">
                                        <span class="qa-number">124</span>
                                        <span class="qa-tag normal-style">답변대기중</span>
                                        <div class="con-cus-mo-qa">
                                            <p class="qa-text">티켓은 어떻게 예약할 수 있나요?</p>
                                            <div class="qa-meta text-gray only_mo">2024.07.24 09:39</div>
                                        </div>
                                    </div>
                                    <div class="qa-meta text-gray only_web">2024.07.24 09:39</div>
                                </div>
                            </li>
                            <li class="">
                                <div class="qa-item qa_item_">
                                    <div class="qa-question">
                                        <span class="qa-number">123</span>
                                        <span class="qa-tag">답변완료</span>
                                        <div class="con-cus-mo-qa">
                                            <p class="qa-text">결제 시점은 언제인가요?</p>
                                            <div class="qa-meta text-gray only_mo">2024.07.24 09:39</div>
                                        </div>
                                    </div>
                                    <div class="qa-meta text-gray only_web">2024.07.24 09:39</div>
                                </div>
                                <div class="additional-info d_none additional_info_">
                                    <span class="load-more">더투어랩</span>
                                    <p>조인투어로 전환 시 정해진 미팅장소에서 가이드님과 만나실 수 있습니다.<br>아유타야는 넓기 때문에 다른 장소에서 미팅은 어려운 점
                                        예약 시
                                        참고해주시기
                                        바랍니다.
                                    </p>
                                    <p class="mt-36">만약 투어 종료 후 개별 이동을 원하시면 당일 가이드님께 말씀해주시면 됩니다.</p>
                                </div>
                            </li>
                            <li class="">
                                <div class="qa-item qa_item_">
                                    <div class="qa-question">
                                        <span class="qa-number">122</span>
                                        <span class="qa-tag normal-style">답변대기중</span>
                                        <div class="con-cus-mo-qa">
                                            <p class="qa-text">2월23일 성인 8명, 어린이 2명으로 예약하면 10명인데요. 통로역 근처인 저희 호텔로
                                                외주실수...</p>
                                            <div class="qa-meta text-gray only_mo">2024.07.24 09:39</div>
                                        </div>
                                    </div>
                                    <div class="qa-meta text-gray only_web">2024.07.24 09:39</div>
                                </div>
                            </li>
                            <li class="">
                                <div class="qa-item qa_item_">
                                    <div class="qa-question">
                                        <span class="qa-number">121</span>
                                        <span class="qa-tag normal-style">답변대기중</span>
                                        <div class="con-cus-mo-qa">
                                            <p class="qa-text">오늘 투어인데 아유타야에 있어서요. 혹시 아유타야에서 도중에 만나서 일정만 소화하고
                                                아유타야에서...</p>
                                            <div class="qa-meta text-gray only_mo">2024.07.24 09:39</div>
                                        </div>
                                    </div>
                                    <div class="qa-meta text-gray only_web">2024.07.24 09:39</div>
                                </div>
                            </li>
                            <li class="">
                                <div class="qa-item qa_item_">
                                    <div class="qa-question">
                                        <span class="qa-number">120</span>
                                        <span class="qa-tag">답변완료</span>
                                        <div class="con-cus-mo-qa">
                                            <p class="qa-text">입금 했습니다. 아직 확정 전이라고 떠서 확인부탁드려요.</p>
                                            <div class="qa-meta text-gray only_mo">2024.07.24 09:39</div>
                                        </div>
                                    </div>
                                    <div class="qa-meta text-gray only_web">2024.07.24 09:39</div>
                                </div>
                                <div class="additional-info d_none additional_info_">
                                    <span class="load-more">더투어랩</span>
                                    <p>조인투어로 전환 시 정해진 미팅장소에서 가이드님과 만나실 수 있습니다.<br>아유타야는 넓기 때문에 다른 장소에서 미팅은 어려운 점
                                        예약 시
                                        참고해주시기
                                        바랍니다.
                                    </p>
                                    <p class="mt-36">만약 투어 종료 후 개별 이동을 원하시면 당일 가이드님께 말씀해주시면 됩니다.</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <style>
                        .d_none {
                            display: none;
                            transition: all 0.3s ease;
                        }
                    </style>
                    <script>
                        $('.qa_item_').on('click keypress', function (e) {
                            if (e.type === 'click' || e.key === 'Enter') {
                                $('.additional_info_').addClass('d_none').attr('aria-hidden', 'true');
                                if ($(this).next('.additional-info').hasClass('d_none')) {
                                    $(this).attr('aria-expanded', 'true').next().removeClass('d_none').attr('aria-hidden', 'false');
                                } else {
                                    $(this).attr('aria-expanded', 'false').next().addClass('d_none').attr('aria-hidden', 'true');
                                }
                            }
                        });
                    </script>

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
                <a class="closed_btn" href="javaScript:void(0)"><img src="/images/ico/close_ico_w.png" alt="close"></a>
            </div>
        </div>

        <script>
            function closePopup() {
                $(".popup_wrap").hide();
                $(".dim").hide();
            }

            $("#policy_show").on("click", function () {
                $(".policy_pop, .policy_pop .dim").show();
            });

            function scrollToEl(elID) {
                $('html, body').animate({
                    scrollTop: $('#' + elID).offset().top - 250
                }, 'slow');
            }

            jQuery(document).ready(function () {
                var dim = $('#dim');
                var popup = $('#popupRoom');
                var closedBtn = $('#popupRoom .closed_btn');

                var popup2 = $('#popup_img');
                var closedBtn2 = $('#popup_img .closed_btn');

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
            });

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
    </div>
<?php $this->endSection(); ?>