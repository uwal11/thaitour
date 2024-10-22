<a href="/product-golf/list-golf/1324" class="thailand_golf_list_item_">
    <div class="img_box img_box_10">
        <img src="/data/product/<?= $item['ufile1'] ?>" alt="<?= $item['product_name'] ?>" loading="lazy">
    </div>
    <div class="prd_keywords">
        <?php foreach ($item['codeTree'] as $key => $value) { ?>
            <span class="prd_keywords_cus_span"><?= $value ?>
                <?php if($key < count($item['codeTree']) - 1) { ?>
                    <img src="/images/ico/arrow_right_icon.png" alt="arrow_right_icon">
                <?php } ?>
            </span>
        <?php } ?>
    </div>
    <div class="prd_name">
        <?= $item['product_name'] ?>
    </div>
    <div class="prd_info">
        <div class="prd_info__left">
            <img class="ico_star" src="/images/ico/star_yellow_icon.png" alt="">
            <span class="star_avg"><?= $item['review_average'] ?></span>
        </div>
        <span style="color: #eeeeee; line-height: 10px;overflow: hidden">|</span>
        <div class="prd_info__right">
            <span class="prd_info__right__ttl">생생리뷰</span>
            <span class="new_review_cnt">(<?= $item['total_review'] ?>)</span>
        </div>
    </div>
    <div class="prd_price_ko">
        <?=number_format($product['product_price'])?><span>원</span>
        <span class="prd_price_ko_sub"><?=number_format($product['product_price_baht'])?>바트</span>
    </div>
</a>