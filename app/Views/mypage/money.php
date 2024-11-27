<?php $this->extend('inc/layout_index'); ?>
<?php $this->section('content'); ?>
<?php
$connect = db_connect();

if ($_SESSION["member"]["mIdx"] == "") {
    alert_msg("", "/member/login?returnUrl=" . urlencode($_SERVER['REQUEST_URI']));
    exit();
}

?>


<link href="/css/mypage/mypage_new.css" rel="stylesheet" type="text/css"/>
<link href="/css/mypage/mypage_reponsive_new.css" rel="stylesheet" type="text/css"/>
<style>
    .mypage_container .slide_tab .slide_tab_btn {
        height: 3.0769rem;
        width: 8.4615rem;
        flex-basis: unset;
        flex-shrink: 1;
    }

    .mypage_container .ttl_table_discount {
        margin-bottom: 2.3077rem;
    }

    .mypage_container .money_content .user_info .user_wrap label {
        margin-top: 0.7692rem;
    }

    .mypage_container .money_content .user_info .user_wrap:nth-child(3),
    .mypage_container .money_content .user_info .user_wrap .list_select_option {
        gap: 0;
    }

    .mypage_container .money_content .user_info .user_wrap .list_select_option .type_of_reason .reason_text_ttl {
        font-size: 1rem;
        padding-top: 0.7692rem;
    }
</style>
<section class="mypage_container">
    <div class="inner">
        <div class="mypage_wrap">
            <?php
            echo view("/mypage/mypage_gnb_menu_inc", ["tab_9" => "on", "tab_9_3" => "on"]);
            ?>

            <div class="money_content">
                <h1 class="ttl_table_discount">정보수정</h1>
                <div class="slide_tab discount flex">
                    <a class="slide_tab_btn" href="./info_option">내 정보 수정</a>
                    <a class="slide_tab_btn" href="./user_mange">계좌정보</a>
                    <a class="slide_tab_btn active" href="./money">회원탈퇴</a>
                </div>
                <div class="top_content">
                    <h1 class="benefit_ttl">회원탈퇴</h1>
                </div>
                <form class="user_info" name="frm" id="frm">
                    <input id="reason_list" type="hidden" name="out_reason" value="">
                    <div class="user_wrap">
                        <label for="password">비밀번호 입력</label>
                        <input type="password" name="user_pw" id="password" class="user_name" maxlength=20>
                    </div>
                    <div class="user_wrap wrap_reason">
                        <label style="margin-bottom: 115px;">탈퇴 사유</label>
                        <div class="list_select_option">
                            <?php
                            $fsql = "select * from tbl_code where code_gubun='leave' and depth='2' and status='Y' order by onum desc";
                            $fresult = $connect->query($fsql)->getResultArray();
                            foreach ($fresult as $frow) {
                                ?>
                                <div class="type_of_reason <?php if ($frow["code_name"] == "기타") {
                                    echo "etc";
                                } ?>">
                                    <input type="checkbox" class="element_select_option"
                                           id="e_select_option_<?= $frow["code_idx"] ?>" name="out_code"
                                           value="<?= $frow["code_name"] ?>" data-value="<?= $frow["code_name"] ?>">
                                    <label for="e_select_option_<?= $frow["code_idx"] ?>"><?= $frow["code_name"] ?></label>
                                </div>
                            <?php } ?>
                            <div class="type_of_reason dr-col">
                                <p class="reason_text_ttl">탈퇴 사유 및 개선점(선택)</p>
                                <textarea type="text" id="element_select_option_text" name="out_etc"
                                          placeholder="여행시 중요시 여기는 부분" maxlength=120></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="color_btn_box flex">
                        <button type="button" class="gray_btn" onclick="javascript:location.href='/'">취소</button>
                        <button type="button" class="btn_submit mar_r" onclick="javascript:send_it()">확인</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    function send_it() {
        let reason_list = "";
        $("input[name=out_code]:checked").each(function () {
            reason_list += $(this).val() + ',';
        })

        $("#reason_list").val(reason_list);

        let frm = document.frm;
        if (frm.user_pw.value == "") {
            frm.user_pw.focus();
            alert("비밀번호를 입력해주셔야 합니다.");
            return;
        }

        $.ajax({
            url: "money_ok",
            type: "POST",
            data: $("#frm").serialize(),
            error: function (request, status, error) {
                //통신 에러 발생시 처리
                alert("code : " + request.status + "\r\nmessage : " + request.reponseText);
            },
            success: function (res, status, request) {
                let response = res.message;
                if (response == "OK") {
                    alert("탈퇴한 계정입니다.");
                    location.href = "/mypage/member_out";
                    return;
                } else if (response == "NOUSER") {
                    alert("일치하는 아이디가 없습니다.");
                    return;
                } else if (response == "NOPASS") {
                    alert("패스워드가 일치하지 않습니다.");
                    return;
                } else if (response == "NOMOBILE") {
                    alert("휴대폰번호가 일치하지 않습니다.");
                    return;
                } else if (response == "NOMATCH") {
                    alert("로그인정보와 아이디가 일치하지 않습니다.");
                    return;
                } else {
                    alert(response);
                    alert("오류가 발생하였습니다!!");
                    return;
                }
            }
        });

    }
</script>
<?php $this->endSection(); ?>
