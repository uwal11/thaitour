<?php $this->extend('inc/layout_index'); ?>

<?php $this->section('content'); ?>

<?php echo view("/product/inc/spa_ticket_restaurant/detail.php"); ?>
<script>
        function getCookie(name) {
            let cookies = document.cookie.split('; ');
            for (let i = 0; i < cookies.length; i++) {
                let parts = cookies[i].split('=');
                if (parts[0] === name) {
                    return decodeURIComponent(parts[1]);
                }
            }
            return null;
        }

        function setCookie(name, value, days) {
            let expires = "";
            if (days) {
                const date = new Date();
                date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                expires = "; expires=" + date.toUTCString();
            }
            document.cookie = name + "=" + (value || "") + expires + "; path=/";
        }

        const product = {
            name: "<?= addslashes($data_['product_name']) ?>",
            link: "<?= '/product-spa/spa-details/' . $data_['product_idx']?>",
            image: "<?= '/data/product/' . $data_['ufile1'] ?>",
            ...(<?= isset($img_list[0]['ufile']) && $img_list[0]['ufile'] ? 'true' : 'false' ?> && { image2: "<?= '/data/product/' . $img_list[0]['ufile'] ?>" })
        };

        let viewedProducts = getCookie('viewedProducts');
        if (viewedProducts) {
            viewedProducts = JSON.parse(viewedProducts);
        } else {
            viewedProducts = [];
        }

        if (!viewedProducts.some(p => p.name === product.name)) {
            viewedProducts.push(product);
            if (viewedProducts.length > 10) {
                viewedProducts.shift();
            }
            setCookie('viewedProducts', JSON.stringify(viewedProducts), 1);
        }
    </script>
<?php $this->endSection(); ?>