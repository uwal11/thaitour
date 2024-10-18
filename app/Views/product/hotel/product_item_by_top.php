<?php
if(is_file(ROOTPATH . "/public/data/hotel/" . $item['ufile1'])) {
    $src = "/data/hotel/" . $item['ufile1'];
} else {
    $src = "/images/product/noimg.png";
}
// var_dump($item['review_average']);die()
?>
<a href="/product-hotel/hotel-detail/<?= $item['product_idx'] ?>" class="thailand_hotel_top_item_">
    <div class="img_box img_box_10">
        <img src="<?= $src ?>" alt="main" loading="lazy">
    </div>
    <?php
    $num = count($item['codeTree']);
    ?>
    <div class="prd_keywords">
        <?php foreach ($item['codeTree'] as $key => $code): ?>
            <span class="prd_keywords_cus_span"> <?= $code['code_name'] ?>
                <?php if ($key < $num - 1): ?>
                    <img src="/images/ico/arrow_right_icon.png" alt="arrow_right_icon">
                <?php endif; ?>
            </span>
        <?php endforeach; ?>
    </div>
    <div class="prd_name">
        <?= $item['product_name'] ?>
    </div>
    <div class="prd_info">
        <div class="prd_info__left">
            <img class="ico_star" src="/images/ico/ico_star.svg" alt="">
            <span class="star_avg"><?= $item['review_average'] ?></span>
        </div>
        <span style="color: #eeeeee; line-height: 10px;overflow: hidden">|</span>
        <div class="prd_info__right">
            <span class="prd_info__right__ttl">생생리뷰</span>
            <span class="new_review_cnt">(<?= $item['total_review'] ?>)</span>
        </div>
    </div>
    <div class="prd_price_ko">
        <?= number_format($item['product_price']) ?> <span>원~</span> <span class="prd_price_thai">6,000
            <span>바트~</span></span>
    </div>
</a>