<!DOCTYPE html>
<html lang="en">
<?php $setting = homeSetInfo(); ?>
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>페이지 / 찾을 수 없음 404</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow">
    <meta content="<?= $setting['site_name'] ?>" name="Title">
    <meta content="<?= $setting['site_name'] ?>" name="Description">
    <meta content="<?= $setting['site_name'] ?>" name="Keyword">
    <meta property="og:title" content="<?= $setting['site_name'] ?>">
    <meta property="og:description" content="<?= $setting['site_name'] ?>">
    <meta property="og:image" content="/uploads/setting/<?= $setting['og_img'] ?>">
    <meta property="og:url" content="https://happythaitour.com/">
    <meta property="al:web:url" content="https://happythaitour.com/">
    <meta name="naver-site-verification" content="466ef04fc98ddc84f2dc2f63451ef03d71efa5d7">
    <link href="/uploads/setting/<?= $setting['favico'] ?>" rel="icon" type="image/x-icon">
    <link rel="canonical" href="https://happythaitour.com/">

    <!-- Vendor CSS Files -->
    <link href="/assets/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="/assets/css/style.css" rel="stylesheet">
</head>

<body>

<main>
    <div class="container">

        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <h1>404</h1>
            <h2>찾으시는 페이지가 존재하지 않습니다.</h2>
            <a class="btn" onclick="fn_back();" href="#!">돌아가기</a>
            <img src="/assets/img/not-found.svg" class="img-fluid py-5" alt="Page Not Found">
        </section>

    </div>
</main><!-- End #main -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="/assets/lib/bootstrap/js/bootstrap.bundle.min.js"></script>

<script>
    function fn_back() {
        window.history.back();
    }
</script>
</body>

</html>