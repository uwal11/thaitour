<?php $this->extend('inc/layout_index'); ?>

<?php $this->section('content'); ?>

<?php echo view("/product/inc/spa_ticket_restaurant/list.php", ['title_page' => '<p><span>더</span>투어랩 스파</p>']); ?>

<?php $this->endSection(); ?>