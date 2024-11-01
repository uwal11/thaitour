<?= $this->extend("admin/inc/layout_admin") ?>
<?= $this->section("body") ?>
    <script type="text/javascript">
        function checkForNumber(str) {
            var key = event.keyCode;
            var frm = document.frm1;
            send_it_mess();
            if (!(key == 8 || key == 9 || key == 13 || key == 46 || key == 144 ||
                (key >= 48 && key <= 57) || (key >= 96 && key <= 105) || key == 110 || key == 190)) {
                event.returnValue = false;
            }
        }

        function send_it() {
            var frm = document.frm;
            document.getElementById('action_type').value = 'save';
            document.frm.submit();
            frm.submit();
        }

        function send_it_mess() {
            var frm = document.frm;
            document.getElementById('action_type').value = 'send_message';
            document.frm.submit();
            frm.submit();
        }
    </script>


    <div id="container">
        <div id="print_this"><!-- 인쇄영역 시작 //-->

            <header id="headerContainer">
                <div class="inner">
                    <h2><?= $titleStr ?></h2>
                    <div class="menus">
                        <ul>
                            <li>
                                <a href="list?search_category=<?= $search_category ?>&search_name=<?= $search_name ?>&pg=<?= $pg ?>"
                                   class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span
                                            class="txt">리스트</span></a></li>
                            <li><a href="javascript:send_it()" class="btn btn-default"><span
                                            class="glyphicon glyphicon-cog"></span><span class="txt">수정</span></a>
                            </li>
                            <li><a href="javascript:del_it()" class="btn btn-default"><span
                                            class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a>
                            </li>

                        </ul>
                    </div>
                </div>
                <!-- // inner -->
            </header>
            <!-- // headerContainer -->

            <form name=frm action="/AdmMaster/_reservation/write_ok" method=post enctype="multipart/form-data" target="hiddenFrame">
                <input type=hidden name="search_category" value='<?= $search_category ?>'>
                <input type=hidden name="search_name" value='<?= $search_name ?>'>
                <input type=hidden name="pg" value='<?= $pg ?>'>
                <input type="hidden" id="action_type" name="action_type" value="">

                <input type=hidden name="order_idx" id="order_idx" value='<?= $order_idx ?>'>
                <input type=hidden name="m_idx" value='<?= $m_idx ?>'>

                <input type=hidden name="product_idx" value='<?= $product_idx ?>'>
                <input type=hidden name="order_date" value='<?= $order_date ?>'>
                <input type=hidden name="people_adult_cnt" value='<?= $people_adult_cnt ?>'>
                <input type=hidden name="people_adult_price" value='<?= $people_adult_price ?>'>

                <input type=hidden name="people_kids_cnt" value='<?= $people_kids_cnt ?>'>
                <input type=hidden name="people_kids_price" value='<?= $people_kids_price ?>'>

                <input type=hidden name="people_baby_cnt" value='<?= $people_baby_cnt ?>'>
                <input type=hidden name="people_baby_price" value='<?= $people_baby_price ?>'>

                <input type=hidden name="oil_price" value='<?= $oil_price ?>'>
                <input type=hidden name="order_price" value='<?= $order_price ?>'>
                <input type=hidden name="used_coupon_no" value='<?= $used_coupon_no ?>'>
                <input type=hidden name="used_coupon_point" value='<?= $used_coupon_point ?>'>
                <input type=hidden name="used_coupon_idx" value='<?= $used_coupon_idx ?>'>
                <input type=hidden name="used_coupon_money" value='<?= $used_coupon_money ?>'>
                <input type=hidden name="product_mileage" value='<?= $product_mileage ?>'>
                <input type=hidden name="order_mileage" value='<?= $order_mileage ?>'>

                <input type=hidden name="product_period" value='<?= $product_period ?>'>
                <input type=hidden name="tour_period" value='<?= $tour_period ?>'>
                <input type=hidden name="used_mileage_money" value='<?= $used_mileage_money ?>'>
                <input type=hidden name="air_idx" value='<?= $air_idx ?>'>
                <input type=hidden name="yoil_idx" value='<?= $yoil_idx ?>'>
                <input type=hidden name="order_no" value='<?= $order_no ?>'>
                <input type=hidden name="order_r_date" value='<?= $order_r_date ?>'>
                <input type=hidden name="deposit_date" value='<?= $deposit_date ?>'>
                <input type=hidden name="order_confirm_date" value='<?= $order_confirm_date ?>'>
                <input type=hidden name="paydate" value='<?= $paydate ?>'>


                <div id="contents">
                    <div class="listWrap_noline">


                        <div class="listBottom">
                            <div style="font-size:12pt;margin-bottom:10px">■ 주문정보</div>
                            <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
                                <caption>
                                </caption>
                                <colgroup>
                                    <col width="10%"/>
                                    <col width="40%"/>
                                    <col width="10%"/>
                                    <col width="40%"/>
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th>상품명</th>
                                    <td>
                                        <?= $product_name ?><br><?= $tours_subject ?>
                                        <input type=hidden name="product_name" value='<?= $product_name ?>'>
                                    </td>
                                    <th>주문번호</th>
                                    <td>
                                        <?= $order_no ?>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th>주문자명</th>
                                    <td>
                                        <input type="text" id="order_user_name" name="order_user_name"
                                               value="<?= $order_user_name ?>" class="input_txt" style="width:90%"/>
                                    </td>
                                    <th>주문자이메일</th>
                                    <td>
                                        <input type="text" id="order_user_email" name="order_user_email"
                                               value="<?= $order_user_email ?>" class="input_txt" style="width:90%"/>
                                    </td>
                                </tr>
                                <tr>
                                    <th>휴대전화</th>
                                    <td>
                                        <input type="text" id="order_user_mobile" name="order_user_mobile"
                                               value="<?= $order_user_mobile ?>" class="input_txt" style="width:90%"/>
                                    </td>
                                    <!-- <th>해외 전화번호</th>
                                    <td>
                                        <input type="text" id="local_phone" name="local_phone"
                                               value="<?= $local_phone ?>" class="input_txt" style="width:90%"/>
                                    </td> -->
                                    <th>담당자</th>
                                    <td>
                                        <input type="text" id="manager_name" name="manager_name"
                                               value="<?= $row['manager_name'] ?>" class="input_txt" style="width:20%"/>
                                        <input type="text" id="manager_phone" name="manager_phone"
                                               value="<?= $row['manager_phone'] ?>" class="input_txt"
                                               style="width:20%"/>
                                        <input type="text" id="manager_email" name="manager_email"
                                               value="<?= $row['manager_email'] ?>" class="input_txt"
                                               style="width:20%"/>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <th>객실 수</th>
                                    <td>
                                        <?= $order_room_cnt ?>
                                    </td>
                                    <th>숙박일</th>
                                    <td>
                                        <?= $order_day_cnt ?>     
                                    </td>
                                </tr>

                                <?php if ($used_coupon_idx != "" && isset($order_idx) && $order_idx != "") { ?>
                                    <tr>
                                        <th>쿠폰번호</th>
                                        <td>
                                            <?= $row_cou['used_coupon_no'] ?>
                                        </td>
                                        <th>쿠폰금액</th>
                                        <td>
                                            <?= number_format($used_coupon_money) ?>원
                                        </td>
                                    </tr>
                                <?php } ?>

                                <tr>
                                    <th>사용된 마일리지</th>
                                    <td>
                                        <?= number_format($used_mileage_money) ?>
                                    </td>
                                    <th>총할인 금액</th>
                                    <td>
                                        <?= number_format($used_coupon_money + $used_mileage_money) ?>원
                                    </td>
                                </tr>
                                <tr>
                                    <th>총 결제금액</th>
                                    <td>
                                        <?php
                                            $total_price = 0;
                                            $total_price = $inital_price * $order_room_cnt * $order_day_cnt;
                                        ?>   
                                        <?= number_format($inital_price * $order_room_cnt * $order_day_cnt) ?>원    
                                        -
                                        <?= number_format($used_coupon_money) ?>원(할인쿠폰)
                                        -
                                        <?= number_format($used_mileage_money) ?>원(마일리지사용)
                                        = <?= number_format( $total_price- $used_coupon_money - $used_mileage_money) ?>
                                        원

                                    </td>
                                    <th>선금</th>
                                    <td>
                                        <input type="text" id="deposit_price" name="deposit_price"
                                               value="<?= $deposit_price ?>" class="input_txt price" style="width:100px"
                                               onkeyup="javascript:calc()" onkeydown="javascript:calc()"/>원
                                        <?php
                                        if ($ResultCode_1 == "3001" && $AuthCode_1 && $CancelDate_1 == "") {
                                            echo "(결제완료: " . date("Y-m-d H:i", strtotime("20" . $AuthDate_1)) . ")";
                                            echo "<button type='button' onclick='payment_cancel(1);'>결제취소</button>";
                                        }

                                        if ($CancelDate_1 != "") {
                                            echo "결제취소: " . $CancelDate_1;
                                        }
                                        ?>
                                        &nbsp;&nbsp;&nbsp;(결제시에 부여될 마일리지 비율<?= $product_mileage ?>%)
                                        <?php if ($order_status == "G") { ?>
                                            <a href="#!" onclick="payment_send('<?= $order_idx ?>:1');"
                                               class="btn btn-default"><span
                                                        class="glyphicon glyphicon-cog"></span><span
                                                        class="txt">문자발송</span></a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>결제현황</th>
                                    <td>
                                        <input type="hidden" name="o_order_status" value="<?= $order_status ?>">
                                        <select name="order_status" class="select_txt">
                                            <option value="">결제현황</option>
                                            <option value="W" <?php if ($order_status == "W") {
                                                echo "selected";
                                            } ?>>예약접수
                                            </option>
                                            <option value="G" <?php if ($order_status == "G") {
                                                echo "selected";
                                            } ?>>선금대기
                                            </option>
                                            <option value="R" <?php if ($order_status == "R") {
                                                echo "selected";
                                            } ?>>잔금대기
                                            </option>
                                            <option value="Y" <?php if ($order_status == "Y") {
                                                echo "selected";
                                            } ?>>결제완료
                                            </option>
                                            <option value="C" <?php if ($order_status == "C") {
                                                echo "selected";
                                            } ?>>예약취소
                                            </option>
                                        </select>
                                        <a href="#!" onclick="send_it_mess();" class="btn btn-default"><span
                                                    class="glyphicon glyphicon-cog"></span><span class="txt">문자발송</span></a>
                                    </td>

                                    <th>잔금</th>
                                    <td>
                                        <input type="text" id="order_confirm_price" name="order_confirm_price"
                                               value="<?= $order_confirm_price ?>" class="input_txt price"
                                               style="width:150px"/>원
                                        <?php
                                        if ($ResultCode_2 == "3001" && $AuthCode_2 && $CancelDate_2 == "") {
                                            echo "결제완료 ";
                                            echo "<button type='button' onclick='payment_cancel(2);'>결제취소</button>";
                                        }

                                        if ($CancelDate_2 != "") {
                                            echo "결제취소: " . $CancelDate_2;
                                        }
                                        ?>

                                        <?php if ($order_status == "R") { ?>
                                            <a href="#!" class="btn btn-default"
                                               onclick="payment_send('<?= $order_idx ?>:2');"><span
                                                        class="glyphicon glyphicon-cog"></span><span
                                                        class="txt">문자발송</span></a>
                                        <?php } ?>
                                    </td>

                                </tr>

                                <script>
                                    function payment_send(type) {
                                        var arr = type.split(":");
                                        var order_idx = arr[0];
                                        var type = arr[1];

                                        var amt_type = "";
                                        if (type == "1") amt_type = "선금";
                                        if (type == "2") amt_type = "잔금";

                                        if (!confirm(amt_type + ' 을 결제발송 하시겠습니까?'))
                                            return false;

                                        var message = "";
                                        $.ajax({
                                            url: "/nicepay/ajax.payment_send.php",
                                            type: "POST",
                                            data: {
                                                "order_idx": order_idx,
                                                "type": type
                                            },
                                            dataType: "json",
                                            async: false,
                                            cache: false,
                                            success: function (data, textStatus) {
                                                message = data.message;
                                                alert(message);
                                                location.reload();
                                            },
                                            error: function (request, status, error) {
                                                alert("code = " + request.status + " message = " + request.responseText + " error = " + error); // 실패 시 처리
                                            }
                                        });

                                    }
                                </script>

                                <!-- <tr>
                                    <th>합계</th>
                                    <td colspan="3">
                                        <input type="text" id="total_price" name="total_price" value=""
                                               class="input_txt" readonly style="width:150px; border: none	;"/>
                                    </td>
                                </tr> -->
                                <?php if ($order_status == "Y") { ?>
                                    <tr>
                                        <th>부여된마일리지</th>
                                        <td>
                                            <?= $order_mileage ?>P
                                        </td>
                                        <th>결제일시</th>
                                        <td>
                                            <?= $paydate ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <tr style="height:100px">
                                    <th>요청사항</th>
                                    <td colspan="3">
                                        <textarea id="custom_req" name="custom_req" class="input_txt"
                                                  style="width:90%;height:100px"><?php echo $custom_req ? $custom_req : $order_memo ?></textarea>
                                    </td>
                                </tr>
                                <tr style="height:100px">
                                    <th>관리자 메모</th>
                                    <td colspan="3">
                                        <textarea id="admin_memo" name="admin_memo" class="input_txt"
                                                  style="width:90%;height:100px"><?= $admin_memo ?></textarea>
                                    </td>
                                </tr>
                                </tbody>

                            </table>

                            <div style="font-size:12pt;margin-top:20px;margin-bottom:10px">■ 인원정보</div>
                            <table cellpadding="0" cellspacing="0" summary="" class="listTable mem_detail">
                                <caption>
                                </caption>
                                <colgroup>
                                    <col width="7%"/>
                                    <!-- <col width="*%"/> -->
                                    <col width="*%"/>
                                    <col width="40%"/>
                                </colgroup>
                                <tbody>
                                <tr>
                                    <th style="text-align:center">구분</th>
                                    <!-- <th style="text-align:center">한글명</th> -->
                                    <th style="text-align:center">영문성</th>
                                    <th style="text-align:center">영문이름</th>
                                </tr>
                                <?php
                                    foreach ($fresult as $frow) {
                                ?>
                                    <tr>
                                        <td style="text-align:center">
                                            <input type="hidden" name="gl_idx[]" value="<?= $frow["gl_idx"] ?>">
                                            <input type="hidden" name="order_gubun[]"
                                                   value="<?= $frow["order_gubun"] ?>">
                                            <?php

                                                if(!empty($frow["number_room"])){
                                                    echo "객실" . $frow["number_room"];
                                                }
                                            ?>
                                        </td>
                                        <!-- <td style="text-align:center"><input type="text" name="order_name_kor[]"
                                                                             value="<?= $frow["order_name_kor"] ?>"
                                                                             class="order_name_kor input_txt"
                                                                             style="width:90%"/></td> -->
                                        <td style="text-align:center"><input type="text" name="order_first_name[]"
                                                                             value="<?= $frow["order_first_name"] ?>"
                                                                             class="order_first_name input_txt"
                                                                             style="width:90%"/></td>
                                        <td style="text-align:center"><input type="text" name="order_last_name[]"
                                                                             value="<?= $frow["order_last_name"] ?>"
                                                                             class="order_last_name input_txt"
                                                                             style="width:90%"/></td>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- // listBottom -->

                        <div class="tail_menu">
                            <ul>
                                <li class="left"></li>
                                <li class="right_sub">

                                    <a href="list?search_category=<?= $search_category ?>&search_name=<?= $search_name ?>&pg=<?= $pg ?>"
                                       class="btn btn-default"><span class="glyphicon glyphicon-th-list"></span><span
                                                class="txt">리스트</span></a>
                                    <?php if ($order_idx == "") { ?>
                                        <a href="javascript:send_it()" class="btn btn-default"><span
                                                    class="glyphicon glyphicon-cog"></span><span
                                                    class="txt">등록</span></a>
                                    <?php } else { ?>
                                        <a href="javascript:send_it()" class="btn btn-default"><span
                                                    class="glyphicon glyphicon-cog"></span><span
                                                    class="txt">수정</span></a>
                                        <a href="javascript:del_it()" class="btn btn-default"><span
                                                    class="glyphicon glyphicon-trash"></span><span class="txt">삭제</span></a>
                                    <?php } ?>
                                </li>
                            </ul>
                        </div>

                    </div>
                    <!-- // listWrap -->

                </div>
                <!-- // contents -->
            </form>
            <div class="inner cmt_area">
                <form action="" id="frm" name="com_form" class="com_form">
                    <input type="hidden" name="code" id="code" value="order">
                    <input type="hidden" name="r_code" id="r_code" value="order">
                    <input type="hidden" name="r_idx" id="r_idx" value="<?= $order_idx ?>">
                    <div class="comment_box-input flex">
                        <textarea class="cmt_input" name="comment" id="comment" placeholder="댓글을 입력해주세요."></textarea>
                        <button type="button" class="btn btn-point btn-lg comment_btn" onclick="fn_comment()">등록
                        </button>
                    </div>
                </form>
                <div id="comment_list"></div>
            </div>
        </div><!-- 인쇄 영역 끝 //-->
    </div>

    <div class="pop_common img_pop">
        <div class="pop_item" style="max-width: 600px;">
            <div class="pop_top" style="border-radius: 0px;">
                <button
                        type="button"
                        class="btn_close no_txt"
                        onclick="PopCloseBtn('.img_pop')">
                    닫기
                </button>
            </div>
            <div style="width: 600px;height: 848px;display: flex;background-color: #252525;max-height: 100%;">
                <img style="margin:auto;max-height: 100%;" id="img_showing" src="" alt="">
            </div>
        </div>
        <div class="pop_dim" onclick="PopCloseBtn('.img_pop')"></div>
    </div>

    <script>

        function handleShowImgPop(img) {
            $("#img_showing").attr("src", img);
            $(".img_pop").show();
        }

    </script>

    <script>
        function payment_cancel(type) {
            var amt_type = "";
            if (type == "1") amt_type = "선금";
            if (type == "2") amt_type = "잔금";

            if (!confirm(amt_type + ' 을 결제취소 하시겠습니까?\n\n한번 취소한 자료는 복구할 수 없습니다.'))
                return false;

            var message = "";
            $.ajax({

                url: "/nicepay/ajax.cancelResult.php",
                type: "POST",
                data: {
                    "order_idx": $("#order_idx").val(),
                    "type": type
                },
                dataType: "json",
                async: false,
                cache: false,
                success: function (data, textStatus) {
                    message = data.message;
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

        function calculateTotal() {
            var depositPrice = document.getElementById('deposit_price').value;
            var confirmPrice = document.getElementById('order_confirm_price').value;

            depositPrice = parseFloat(depositPrice.replace(/,/g, '')) || 0;
            confirmPrice = parseFloat(confirmPrice.replace(/,/g, '')) || 0;

            if (depositPrice > 0 || confirmPrice > 0) {
                var totalPrice = depositPrice + confirmPrice;

                document.getElementById('total_price').value = totalPrice.toLocaleString();
            } else {
                document.getElementById('total_price').value = '';
            }
        }

        document.getElementById('deposit_price').addEventListener('keyup', calculateTotal);
        document.getElementById('deposit_price').addEventListener('change', calculateTotal);
        document.getElementById('order_confirm_price').addEventListener('keyup', calculateTotal);
        document.getElementById('order_confirm_price').addEventListener('change', calculateTotal);

        document.addEventListener('DOMContentLoaded', calculateTotal);


        function del_it() {

            if (confirm("삭제 하시겠습니까?\n삭제후에는 복구가 불가능합니다.") == false) {
                return;
            }
            $("#ajax_loader").removeClass("display-none");
            $.ajax({
                url: "delete",
                type: "POST",
                data: "order_idx[]=<?=$order_idx?>",
                error: function (request, status, error) {
                    //통신 에러 발생시 처리
                    alert_("code : " + request.status + "\r\nmessage : " + request.reponseText);
                    $("#ajax_loader").addClass("display-none");
                }
                , success: function (response, status, request) {
                    if (response.result == true) {
                        alert("정상적으로 삭제되었습니다.");
                        location.href = "list";
                        return;
                    } else {
                        alert(response);
                        return;
                    }
                }
            });
        }

        function fn_comment() {

            <? if ($_SESSION["member"]["id"] != "") { ?>
            if ($("#comment").val() == "") {
                alert("댓글을 입력해주세요.");
                return;
            }
            var queryString = $("form[name=com_form]").serialize();
            $.ajax({
                type: "POST",
                url: "/AdmMaster/_include/comment_proc.php",
                data: queryString,
                cache: false,
                success: function (ret) {
                    if (ret.trim() == "OK") {
                        fn_comment_list();
                        $("#comment").val("");
                    } else {
                        alert("등록 오류입니다." + ret);
                    }
                }
            });
            <? } else { ?>
            alert("로그인을 해주세요.");
            <? } ?>
        }

        function fn_comment_list() {

            $.ajax({
                type: "POST",
                url: "/AdmMaster/_include/comment_list.ajax.php",
                data: {
                    "r_code": "order",
                    "r_idx": "<?=$order_idx?>"
                },
                cache: false,
                success: function (ret) {
                    $("#comment_list").html(ret);
                }
            });

        }

        fn_comment_list();
    </script>
    <script src="/AdmMaster/_include/comment.js"></script>
    <script>
        $(function () {
            $.datepicker.regional['ko'] = {
                showButtonPanel: true,
                beforeShow: function (input) {
                    setTimeout(function () {
                        var buttonPane = $(input)
                            .datepicker("widget")
                            .find(".ui-datepicker-buttonpane");
                        var btn = $('<BUTTON class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all">Clear</BUTTON>');
                        btn.unbind("click").bind("click", function () {
                            $.datepicker._clearDate(input);
                        });
                        btn.appendTo(buttonPane);
                    }, 1);
                },
                closeText: '닫기',
                prevText: '이전',
                nextText: '다음',
                monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
                monthNamesShort: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                dayNames: ['일', '월', '화', '수', '목', '금', '토'],
                dayNamesShort: ['일', '월', '화', '수', '목', '금', '토'],
                dayNamesMin: ['일', '월', '화', '수', '목', '금', '토'],
                weekHeader: 'Wk',
                dateFormat: 'yy-mm-dd',
                firstDay: 0,
                isRTL: false,
                showMonthAfterYear: true,
                changeMonth: true,
                changeYear: true,
                showMonthAfterYear: true,
                closeText: '닫기', // 닫기 버튼 패널
                yearSuffix: ''
            };
            $.datepicker.setDefaults($.datepicker.regional['ko']);

            $(".datepicker").datepicker({
                showButtonPanel: true,
                beforeShow: function (input) {
                    setTimeout(function () {
                        var buttonPane = $(input)
                            .datepicker("widget")
                            .find(".ui-datepicker-buttonpane");
                        var btn = $('<BUTTON class="ui-datepicker-current ui-state-default ui-priority-secondary ui-corner-all">Clear</BUTTON>');
                        btn.unbind("click").bind("click", function () {
                            $.datepicker._clearDate(input);
                        });
                        btn.appendTo(buttonPane);
                    }, 1);
                },
                dateFormat: 'yy-mm-dd',
                showOn: "both",
                yearRange: "c-100:c+10",
                buttonImage: "/img/ico/date_ico.png",
                buttonImageOnly: true,
                closeText: '닫기',
                prevText: '이전',
                nextText: '다음'
                // ,minDate: 1
                <?php if ($str_guide != "") { ?>,
                    beforeShowDay: function (date) {
                        var day = date.getDay();
                        return [(<?= $str_guide ?>)];
                    }
                <?php } ?>
            });

            $('img.ui-datepicker-trigger').css({
                'display': 'none'
            });
            $('input.hasDatepicker').css({
                'cursor': 'pointer'
            });
        });
    </script>
    <iframe width="300" height="300" name="hiddenFrame" id="hiddenFrame" src="" style="display:none;"></iframe>

<?= $this->endSection() ?>