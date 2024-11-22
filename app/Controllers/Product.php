<?php

namespace App\Controllers;

use App\Models\Hotel;
use CodeIgniter\I18n\Time;
use Config\CustomConstants as ConfigCustomConstants;
use Config\Services;
use Exception;

class Product extends BaseController
{
    private $bannerModel;
    private $productModel;
    private $bbsListModel;
    private $orderModel;
    private $orderSubModel;
    private $coupon;
    private $couponHistory;
    private $db;
    private $hotel;
    private $codeModel;
    private $reviewModel;
    private $mainDispModel;
    protected $golfInfoModel;
    protected $golfOptionModel;
    protected $golfVehicleModel;
    protected $orderOptionModel;
    protected $tourProducts;
    protected $infoProducts;
    protected $dayModel;
    protected $subSchedule;
    protected $mainSchedule;
    protected $carsOptionModel;
    protected $carsSubModel;
    protected $optionTours;
    protected $orderTours;
    private $scale = 8;

    public function __construct()
    {
        $this->db = db_connect();
        $this->bannerModel = model("Banner_model");
        $this->productModel = model("ProductModel");
        $this->bbsListModel = model("Bbs");
        $this->codeModel = model("Code");
        $this->reviewModel = model("ReviewModel");
        $this->mainDispModel = model("MainDispModel");
        $this->orderModel = model("OrdersModel");
        $this->orderSubModel = model("OrderSubModel");
        $this->coupon = model("Coupon");
        $this->couponHistory = model("CouponHistory");
        $this->golfInfoModel = model("GolfInfoModel");
        $this->golfOptionModel = model("GolfOptionModel");
        $this->golfVehicleModel = model("GolfVehicleModel");
        $this->orderOptionModel = model("OrderOptionModel");
        $this->tourProducts = model("ProductTourModel");
        $this->infoProducts = model("TourInfoModel");
        $this->optionTours = model("OptionTourModel");
        $this->dayModel = model("DayModel");
        $this->subSchedule = model("SubScheduleModel");
        $this->mainSchedule = model("MainScheduleModel");
        $this->carsOptionModel = model("CarsOptionModel");
        $this->carsSubModel = model("CarsSubModel");
        $this->orderTours = model("OrderTourModel");
        helper(['my_helper']);
        $constants = new ConfigCustomConstants();
    }

    public function showTicket($code_no)
    {
        try {
            $data = $this->viewData($code_no);
            $data['bannerTop'] = $this->bannerModel->getBanners($code_no, "top")[0];

            return $this->renderView('product/show-ticket', $data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function ticketDetail($product_idx)
    {
        $data = $this->getDataDetail($product_idx, '1317');

        return $this->renderView('/product/ticket/ticket-detail', $data);
    }

    public function ticketBooking()
    {
        $session = Services::session();
        $data = $session->get('data_cart');

        if (empty($data)) {
            return redirect()->to('/');
        }

        $res = $this->getDataBooking();

        $order_gubun = 'ticket';
        $res['order_gubun'] = $order_gubun;

        return $this->renderView('/product/ticket/ticket-booking', $res);
    }

    public function ticketCompleted()
    {
        return $this->renderView('/product/ticket/completed-order');
    }

    public function indexTour($code_no)
    {
        try {
            $sub_codes = $this->codeModel->where('parent_code_no', 1301)->orderBy('onum', 'DESC')->findAll();

            $products = $this->productModel->findProductPaging([
                'product_code_1' => 1301,
            ], $this->scale, 1, ['product_price' => 'ASC']);

            $code_name = $this->db->table('tbl_code')
                ->select('code_name')
                ->where('code_gubun', 'tour')
                ->where('code_no', $code_no)
                ->get()
                ->getRow()
                ->code_name;

            if (strlen($code_no) == 4) {
                $codes = $this->db->table('tbl_code')
                    ->where('parent_code_no', $code_no)
                    ->get()
                    ->getResult();
            } else {
                $codes = $this->db->table('tbl_code')
                    ->where('code_gubun', 'tour')
                    ->where('parent_code_no', substr($code_no, 0, 6))
                    ->orderBy('onum', 'DESC')
                    ->get()
                    ->getResult();
            }

            $code_new = $this->codeModel->getByParentAndDepth(2336, 3)->getResultArray();
            $codeRecommendedActive = $code_new[0]['code_no'];
            $productByRecommended = $this->mainDispModel->goods_find($codeRecommendedActive);

            $code_step2 = $this->codeModel->getByParentAndDepth($codeRecommendedActive, 4)->getResultArray();

            $codeStep2RecommendedActive = !empty($code_step2) ? $code_step2[0]['code_no'] : null;
            $productStep2ByRecommended = !empty($codeStep2RecommendedActive) ? $this->mainDispModel->goods_find($codeStep2RecommendedActive, 4, 1) : [];
            $productStep2ByRecommended['code_no'] = $codeStep2RecommendedActive;

            $code_popular = $this->codeModel->getByParentAndDepth(2337, 3)->getResultArray();
            $codePopularActive = $code_popular[0]['code_no'];
            $productByPopular = $this->mainDispModel->goods_find($codePopularActive);

            $product_popular = $this->productModel->findProductPaging([
                'product_code_1' => 1301,
                'special_price' => 'Y',
            ], $this->scale, 1, ['r_date' => 'DESC']);

            $data = [
                'bannerTop' => $this->bannerModel->getBanners($code_no, "top"),
                'bannerMiddle' => $this->bannerModel->getBanners($code_no, "middle")[0],
                'bannerBottom' => $this->bannerModel->getBanners($code_no, "bottom"),
                'code_no' => $code_no,
                'products' => $products,
                'codes' => $codes,
                'code_name' => $code_name,
                'sub_codes' => $sub_codes,
                'tab_active' => '3',
                'productByRecommended' => $productByRecommended,
                'codeRecommendedActive' => $codeRecommendedActive,
                'code_new' => $code_new,
                'productStep2ByRecommended' => $productStep2ByRecommended,
                'codeStep2RecommendedActive' => $codeStep2RecommendedActive,
                'code_step2' => $code_step2,
                'productByPopular' => $productByPopular,
                'codePopularActive' => $codePopularActive,
                'code_popular' => $code_popular,
                'product_popular' => $product_popular
            ];

            return $this->renderView('product/product-tours', $data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function indexHotel($code_no)
    {
        try {
            $keyword = $this->request->getVar('keyword') ?? '';
            $s = $this->request->getVar('s') ? $this->request->getVar('s') : 1;
            $perPage = 5;

            $products = $this->productModel->findProductPaging([
                'product_code_1' => 1303,
                'product_status' => 'sale',
            ], $this->scale, 1, ['onum' => 'DESC']);

            foreach ($products['items'] as $key => $product) {

                $hotel_codes = explode("|", $product['product_code_list']);
                $hotel_codes = array_values(array_filter($hotel_codes));

                $codeTree = $this->codeModel->getCodeTree($hotel_codes['0']);

                $products['items'][$key]['codeTree'] = $codeTree;

                $productReview = $this->reviewModel->getProductReview($product['product_idx']);

                $products['items'][$key]['total_review'] = $productReview['total_review'];
                $products['items'][$key]['review_average'] = $productReview['avg'];

                $fsql9 = "select * from tbl_code where parent_code_no='30' and code_no='" . $product['product_level'] . "' order by onum desc, code_idx desc";
                $fresult9 = $this->db->query($fsql9);
                $fresult9 = $fresult9->getRowArray();

                $products['items'][$key]['level_name'] = $fresult9['code_name'];
            }

            $pager = Services::pager();

            $code_name = $this->db->table('tbl_code')
                ->select('code_name')
                ->where('code_gubun', 'tour')
                ->where('code_no', $code_no)
                ->get()
                ->getRow()
                ->code_name;

            if (strlen($code_no) == 4) {
                $codes = $this->db->table('tbl_code')
                    ->where('parent_code_no', $code_no)
                    ->get()
                    ->getResult();
            } else {
                $codes = $this->db->table('tbl_code')
                    ->where('code_gubun', 'tour')
                    ->where('parent_code_no', substr($code_no, 0, 6))
                    ->orderBy('onum', 'DESC')
                    ->get()
                    ->getResult();
            }

            $sub_codes = $this->codeModel->where('parent_code_no', 1303)->orderBy('onum', 'DESC')->findAll();

            $theme_products = $this->productModel->findProductPaging([
                'product_code_1' => 1303,
                'product_status' => 'sale',
                'special_price' => 'Y',
            ], $this->scale, 1, ['onum' => 'DESC']);

            $bestValueProduct = $this->mainDispModel->goods_find(2334)['items'];

            foreach ($bestValueProduct as $key => $product) {

                $hotel_codes = explode("|", $product['product_code_list']);
                $hotel_codes = array_values(array_filter($hotel_codes));

                $codeTree = $this->codeModel->getCodeTree($hotel_codes['0']);

                $bestValueProduct[$key]['codeTree'] = $codeTree;

                $productReview = $this->reviewModel->getProductReview($product['product_idx']);

                $bestValueProduct[$key]['total_review'] = $productReview['total_review'];
                $bestValueProduct[$key]['review_average'] = $productReview['avg'];

                $fsql9 = "select * from tbl_code where parent_code_no='30' and code_no='" . $product['product_level'] . "' order by onum desc, code_idx desc";
                $fresult9 = $this->db->query($fsql9);
                $fresult9 = $fresult9->getRowArray();

                $bestValueProduct[$key]['level_name'] = $fresult9['code_name'];
            }

            $keyWordAll = $this->productModel->getKeyWordAll(1303);

            $keyWordActive = array_search($keyword, $keyWordAll) ?? 0;

            $productByKeyword = $this->productModel->findProductPaging([
                'product_code_1' => 1303,
                'search_txt' => $keyWordAll[$keyWordActive] ?? "",
                'search_category' => 'keyword'
            ], $this->scale, 1);

            foreach ($productByKeyword['items'] as $key => $product) {

                $fsql9 = "select * from tbl_code where parent_code_no='30' and code_no='" . $product['product_level'] . "' order by onum desc, code_idx desc";
                $fresult9 = $this->db->query($fsql9);
                $fresult9 = $fresult9->getRowArray();

                $productByKeyword['items'][$key]['level_name'] = $fresult9['code_name'];
            }

            $data = [
                'bannerTop' => $this->bannerModel->getBanners($code_no, "top")[0],
                'bannerMiddle' => $this->bannerModel->getBanners($code_no, "middle")[0],
                'bannerBottom' => $this->bannerModel->getBanners($code_no, "bottom"),
                'theme_products' => $theme_products,
                'products' => $products,
                'code_no' => $code_no,
                'sub_codes' => $sub_codes,
                's' => $s,
                'codes' => $codes,
                'code_name' => $code_name,
                'pager' => $pager,
                'perPage' => $perPage,
                'tab_active' => '1',
                'bestValueProduct' => $bestValueProduct,
                'keyWordAll' => $keyWordAll,
                'keyword' => $keyword,
                'keyWordActive' => $keyWordAll[$keyWordActive],
                'productByKeyword' => $productByKeyword
            ];

            return $this->renderView('product/product-hotel', $data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getProductByKeyword()
    {
        $keyword = $this->request->getVar('keyword');
        $code_no = $this->request->getVar('code_no');
        $page = $this->request->getVar('page');
        $productByKeyword = $this->productModel->findProductPaging([
            'product_code_1' => $code_no,
            'search_txt' => $keyword,
            'search_category' => 'keyword'
        ], $this->scale, $page);

        $html = '';
        foreach ($productByKeyword['items'] as $item) {
            $html .= view('product/hotel/product_item_by_keyword', ['item' => $item]);
        }
        $productByKeyword['html'] = $html;
        return $this->response->setJSON($productByKeyword);
    }

    public function getProductByTop()
    {
        $code_no = $this->request->getVar('code_no');
        $page = $this->request->getVar('page');
        $productByKeyword = $this->productModel->findProductPaging([
            'product_code_1' => $code_no,
            'product_status' => 'sale'
        ], $this->scale, $page, ['onum' => 'DESC']);

        $html = '';
        foreach ($productByKeyword['items'] as $item) {
            $hotel_codes = explode("|", $item['product_code_list']);
            $hotel_codes = array_values(array_filter($hotel_codes));

            $codeTree = $this->codeModel->getCodeTree($hotel_codes['0']);

            $item['codeTree'] = $codeTree;

            $productReview = $this->reviewModel->getProductReview($item['product_idx']);

            $item['total_review'] = $productReview['total_review'];
            $item['review_average'] = $productReview['avg'];
            $html .= view('product/hotel/product_item_by_top', ['item' => $item]);
        }
        $productByKeyword['html'] = $html;
        return $this->response->setJSON($productByKeyword);
    }

    public function getProductByCheep()
    {
        $code_no = $this->request->getVar('code_no');
        $page = $this->request->getVar('page');
        $productByKeyword = $this->productModel->findProductPaging([
            'product_code_1' => $code_no,
            'is_view' => 'Y'
        ], $this->scale, $page, ['product_price' => 'ASC']);

        $html = '';
        foreach ($productByKeyword['items'] as $item) {
            $hotel_codes = explode("|", $item['product_code_list']);
            $hotel_codes = array_values(array_filter($hotel_codes));

            $codeTree = $this->codeModel->getCodeTree($hotel_codes['0']);

            $item['codeTree'] = $codeTree;
            $html .= view('product/golf/product_item_by_cheep', ['item' => $item]);
        }
        $productByKeyword['html'] = $html;
        return $this->response->setJSON($productByKeyword);
    }

    public function getProductBySubCode()
    {
        $code_no = $this->request->getVar('code_no');
        $page = $this->request->getVar('page');
        $productBySubCode = $this->mainDispModel->goods_find($code_no, $this->scale, $page);

        $html = '';
        foreach ($productBySubCode['items'] as $key => $item) {

            if ($item['product_code_1'] == 1303) {
                $hotel_codes = explode("|", $item['product_code_list']);
                $hotel_codes = array_values(array_filter($hotel_codes));
                $code = $hotel_codes['0'];
            } else {
                $code = $item['product_code_1'];
                if ($item['product_code_2']) $code = $item['product_code_2'];
                if ($item['product_code_3']) $code = $item['product_code_3'];
            }


            $codeTree = $this->codeModel->getCodeTree($code);

            $item['codeTree'] = $codeTree;
            $html .= view('product/golf/product_item_by_md_recommended', ['item' => $item]);
        }
        $productBySubCode['html'] = $html;
        return $this->response->setJSON($productBySubCode);
    }

    public function getStep2ByCodeNo()
    {
        $code_no = $this->request->getVar('code_no');

        $code_step2 = $this->codeModel->getByParentAndDepth($code_no, 4)->getResultArray();

        $codeStep2RecommendedActive = !empty($code_step2) ? $code_step2[0]['code_no'] : null;

        $html = '';

        if (!empty($code_step2)) {
            foreach ($code_step2 as $code) {
                $html .= '<a href="javascript:void(0);" onclick="handleLoadRecommendedProduct(' . $code['code_no'] . ');" class="tour__head__tabs2__tab ' . ($codeStep2RecommendedActive == $code['code_no'] ? 'active' : '') . '">' .
                    viewSQ($code['code_name']) .
                    '</a>';

            }
        }

        return $this->response->setJSON([
            'codeStep2RecommendedActive' => $codeStep2RecommendedActive,
            'html' => $html,
        ]);
    }

    public function getProductBySubCodeTour()
    {
        $code_no = $this->request->getVar('code_no');
        $page = $this->request->getVar('page');
        $perPage = 4;
        $productBySubCode = $this->mainDispModel->goods_find($code_no, $perPage, $page);

        $html = '';
        foreach ($productBySubCode['items'] as $key => $item) {

            if ($item['product_code_1'] == 1303) {
                $hotel_codes = explode("|", $item['product_code_list']);
                $hotel_codes = array_values(array_filter($hotel_codes));
                $code = $hotel_codes['0'];
            } else {
                $code = $item['product_code_1'];
                if ($item['product_code_2']) $code = $item['product_code_2'];
                if ($item['product_code_3']) $code = $item['product_code_3'];
            }


            $codeTree = $this->codeModel->getCodeTree($code);

            $item['codeTree'] = $codeTree;
            $html .= view('product/tour/product_item_by_recommended', ['item' => $item]);
        }
        $productBySubCode['html'] = $html;
        return $this->response->setJSON($productBySubCode);

    }

    public function indexResult($code_no)
    {
        try {
            $s = $this->request->getVar('s') ? $this->request->getVar('s') : 1;
            $perPage = 5;

            $banners = $this->bannerModel->getBanners($code_no);
            $codeBanners = $this->bannerModel->getCodeBanners($code_no);

            $suggestedProducts = $this->productModel->getSuggestedProducts($code_no);

            $products = $this->productModel->getProducts($code_no, $s, $perPage);

            $totalProducts = $this->productModel->where($this->productModel->getCodeColumn($code_no), $code_no)->where('is_view', 'Y')->countAllResults();

            $pager = Services::pager();

            $code_name = $this->db->table('tbl_code')
                ->select('code_name')
                ->where('code_gubun', 'tour')
                ->where('code_no', $code_no)
                ->get()
                ->getRow()
                ->code_name;

            if (strlen($code_no) == 4) {
                $codes = $this->db->table('tbl_code')
                    ->where('parent_code_no', $code_no)
                    ->get()
                    ->getResult();
            } else {
                $codes = $this->db->table('tbl_code')
                    ->where('code_gubun', 'tour')
                    ->where('parent_code_no', substr($code_no, 0, 6))
                    ->orderBy('onum', 'DESC')
                    ->get()
                    ->getResult();
            }

            $data = [
                'banners' => $banners,
                'codeBanners' => $codeBanners,
                'suggestedProducts' => $suggestedProducts,
                'products' => $products,
                'code_no' => $code_no,
                's' => $s,
                'codes' => $codes,
                'code_name' => $code_name,
                'pager' => $pager,
                'perPage' => $perPage,
                'totalProducts' => $totalProducts,
            ];

            return $this->renderView('product/product-result', $data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function index2($code_no, $s = "1")
    {
        try {
            $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
            $perPage = 16;

            $suggestedProducts = $this->productModel->getSuggestedProducts($code_no);

            $bestProducts = $this->productModel->getBestProducts(1302);

            $totalProducts = $this->productModel->where($this->productModel->getCodeColumn($code_no), $code_no)->where('is_view', 'Y')->countAllResults();

            $cheepProducts = $this->productModel->findProductPaging([
                'product_code_1' => 1302,
                'is_view' => 'Y'
            ], $this->scale, 1, ['product_price' => 'ASC', 'onum' => 'DESC']);

            foreach ($cheepProducts['items'] as $key => $product) {

                $hotel_codes = explode("|", $product['product_code_list']);
                $hotel_codes = array_values(array_filter($hotel_codes));

                $codeTree = $this->codeModel->getCodeTree($hotel_codes['0']);

                $cheepProducts['items'][$key]['codeTree'] = $codeTree;

                $productReview = $this->reviewModel->getProductReview($product['product_idx']);

                $cheepProducts['items'][$key]['total_review'] = $productReview['total_review'];
                $cheepProducts['items'][$key]['review_average'] = $productReview['avg'];
            }

            $codes = $this->codeModel->getByParentAndDepth(2333, 3)->getResultArray();

            $codeRecommendedActive = $codes[0]['code_no'];

            $productByRecommended = $this->mainDispModel->goods_find($codeRecommendedActive);

            $productSpecialPrice = $this->productModel->findProductPaging([
                'product_code_1' => 1302,
                'is_view' => 'Y',
                'special_price' => 'Y'
            ], $this->scale, 1, ['onum' => 'DESC']);

            $productMDRecommended = $this->mainDispModel->goods_find(2335, $this->scale, 1);
            $productMDRecommended["code_no"] = 2335;

            foreach ($productMDRecommended['items'] as $key => $product) {
                $code = $product['product_code_1'];
                if ($product['product_code_2']) $code = $product['product_code_2'];
                if ($product['product_code_3']) $code = $product['product_code_3'];
                $codeTree = $this->codeModel->getCodeTree($code);

                $productMDRecommended['items'][$key]['codeTree'] = $codeTree;

                $productReview = $this->reviewModel->getProductReview($product['product_idx']);

                $productMDRecommended['items'][$key]['total_review'] = $productReview['total_review'];
                $productMDRecommended['items'][$key]['review_average'] = $productReview['avg'];
            }

            $data = [
                'bannerTop' => $this->bannerModel->getBanners($code_no, "top")[0],
                'suggestedProducts' => $suggestedProducts,
                'code_no' => $code_no,
                's' => $s,
                'codes' => $codes,
                'page' => $page,
                'perPage' => $perPage,
                'totalProducts' => $totalProducts,
                'tab_active' => '2',
                'categories' => $this->codeModel->getByParentAndDepth(1302, 3)->getResultArray(),
                'bestProducts' => $bestProducts,
                'cheepProducts' => $cheepProducts,
                'productByRecommended' => $productByRecommended,
                'codeRecommendedActive' => $codeRecommendedActive,
                'productSpecialPrice' => $productSpecialPrice,
                'productMDRecommended' => $productMDRecommended
            ];

            return $this->renderView('product/product-golf', $data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function index3($code_no, $s = "1")
    {
        try {
            $page = $this->request->getVar('page') ? $this->request->getVar('page') : 1;
            $perPage = 10;
            $perCnt = $perPage;
            $banners = $this->bannerModel->getBanners($code_no);
            $lineBanners = $this->bbsListModel->getLineBanners('123');
            $codeBanners = $this->bannerModel->getCodeBanners($code_no);

            $suggestedProducts = $this->productModel->getSuggestedProducts($code_no);
            $suggestedProducts2 = $this->productModel->getSuggestedProducts('232802');

            $products = $this->productModel->getProducts($code_no, $s, $perPage, $page);

            $totalProducts = $this->productModel->where($this->productModel->getCodeColumn($code_no), $code_no)
                ->where('is_view', 'Y')
                ->countAllResults();

            $pager = Services::pager();

            $code_name = $this->db->table('tbl_code')
                ->select('code_name')
                ->where('code_gubun', 'tour')
                ->where('code_no', $code_no)
                ->get()
                ->getRow()
                ->code_name;

            if (strlen($code_no) == 4) {
                $codes = $this->db->table('tbl_code')
                    ->where('parent_code_no', $code_no)
                    ->get()
                    ->getResult();
            } else {
                $codes = $this->db->table('tbl_code')
                    ->where('code_gubun', 'tour')
                    ->where('parent_code_no', substr($code_no, 0, 6))
                    ->orderBy('onum', 'DESC')
                    ->get()
                    ->getResult();
            }

            $len = strlen($code_no);
            $code_name1 = $code_name2 = $code_name3 = '';

            if ($len == 8) {
                $code_1 = substr($code_no, 0, 4);
                $code_2 = substr($code_no, 0, 6);
                $code_3 = $code_no;
            } elseif ($len == 6) {
                $code_1 = substr($code_no, 0, 4);
                $code_2 = $code_no;
            } else {
                $code_1 = $code_no;
            }

            $result1 = $this->productModel->getCodeName($code_1);
            $code_name1 = $result1 ? $result1['code_name'] : '';

            if (isset($code_2)) {
                $result2 = $this->productModel->getCodeName($code_2);
                $code_name2 = $result2 ? ', ' . $result2['code_name'] : '';
            }

            if (isset($code_3)) {
                $result3 = $this->productModel->getCodeName($code_3);
                $code_name3 = $result3 ? ', ' . $result3['code_name'] : '';
            }

            $sub_banners = $this->bannerModel->getBanners('1317');

            foreach ($products as &$product) {
                $product['yoil_values'] = explode('|', $product['yoil_0'] . "|" . $product['yoil_1'] . "|" . $product['yoil_2'] . "|" . $product['yoil_3'] . "|" . $product['yoil_4'] . "|" . $product['yoil_5'] . "|" . $product['yoil_6']);
            }

            // Get codes for day tour section
            $dayTourCodes = $this->productModel->getCodes('2329');
            $suggest_code = $this->request->getVar('suggest_code') ?: $dayTourCodes[0]['code_no'];
            $dayTourProducts = $this->productModel->getProductsByCode([$suggest_code], $perPage);
            $totalDayTourProducts = $this->productModel->getTotalProducts([$suggest_code]);

            $data = [
                'banners' => $banners,
                'codeBanners' => $codeBanners,
                'suggestedProducts' => $suggestedProducts,
                'suggestedProducts2' => $suggestedProducts2,
                'products' => $products,
                'code_no' => $code_no,
                'lineBanners' => $lineBanners,
                's' => $s,
                'codes' => $codes,
                'code_name' => $code_name,
                'pager' => $pager,
                'page' => $page,
                'perPage' => $perPage,
                'totalProducts' => $totalProducts,
                'sub_banners' => $sub_banners,
                'code_name1' => $code_name1,
                'code_name2' => $code_name2,
                'code_name3' => $code_name3,
                'dayTourCodes' => $dayTourCodes,
                'dayTourProducts' => $dayTourProducts,
                'totalDayTourProducts' => $totalDayTourProducts,
                'suggest_code' => $suggest_code,
                'perCnt' => $perCnt,
                'tab_active' => '6',
            ];

            return $this->renderView('product/product-list', $data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function indexSpa($code_no, $s = "1")
    {
        try {
            $data = $this->viewData($code_no);
            $data['bannerTop'] = $this->bannerModel->getBanners($code_no, "top")[0];

            return $this->renderView('product/product-spa', $data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function listHotel($code_no)
    {
        try {
            $pg = $this->request->getVar('pg') ?? 1;
            $checkin = $this->request->getVar('checkin') ?? "";
            $checkout = $this->request->getVar('checkout') ?? "";
            $search_product_name = $this->request->getVar('search_product_name') ?? "";
            $search_product_category = $this->request->getVar('search_product_category') ?? "";
            $search_product_hotel = $this->request->getVar('search_product_hotel') ?? "";
            $search_product_rating = $this->request->getVar('search_product_rating') ?? "";
            $search_product_promotion = $this->request->getVar('search_product_promotion') ?? "";
            $search_product_topic = $this->request->getVar('search_product_topic') ?? "";
            $search_product_bedroom = $this->request->getVar('search_product_bedroom') ?? "";
            $price_min = $this->request->getVar('price_min') ?? 0;
            $price_max = $this->request->getVar('price_max') ?? 0;


            $perPage = 5;

            $banners = $this->bannerModel->getBanners($code_no);
            $codeBanners = $this->bannerModel->getCodeBanners($code_no);
            $codes = $this->codeModel->getByParentCode($code_no)->getResultArray();
            $types_hotel = $this->codeModel->getByParentAndDepth(40, 2)->getResultArray();
            $ratings = $this->codeModel->getByParentAndDepth(30, 2)->getResultArray();
            $promotions = $this->codeModel->getByParentAndDepth(41, 2)->getResultArray();
            $topics = $this->codeModel->getByParentAndDepth(38, 2)->getResultArray();
            $bedrooms = $this->codeModel->getByParentAndDepth(39, 2)->getResultArray();

            $parent_code_name = $this->productModel->getCodeName($code_no)["code_name"];

            $arr_code_list = [];
            foreach ($codes as $code) {
                array_push($arr_code_list, $code["code_no"]);
            }

            $product_code_list = implode(",", $arr_code_list);

            $products = $this->productModel->findProductHotelPaging([
                'product_code_1' => 1303,
                'product_code_list' => $product_code_list,
                'checkin' => $checkin,
                'checkout' => $checkout,
                'search_product_name' => $search_product_name,
                'search_product_category' => $search_product_category,
                'search_product_hotel' => $search_product_hotel,
                'search_product_rating' => $search_product_rating,
                'search_product_promotion' => $search_product_promotion,
                'search_product_topic' => $search_product_topic,
                'search_product_bedroom' => $search_product_bedroom,
                'price_min' => $price_min,
                'price_max' => $price_max,
                'product_status' => 'sale'
            ], 10, $pg, ['onum' => 'DESC']);

            foreach ($products['items'] as $key => $product) {

                if (empty($search_product_category) || strpos($search_product_category, 'all') !== false) {
                    foreach ($arr_code_list as $h_code) {

                        if (strpos($product['product_code_list'], $h_code) !== false) {
                            $hotel_code = $h_code;
                            break;
                        }
                    }
                } else {
                    $hotel_codes = explode(",", $search_product_category);
                    foreach ($hotel_codes as $h_code) {
                        if (strpos($product['product_code_list'], $h_code) !== false) {
                            $hotel_code = $h_code;
                            break;
                        }
                    }
                }

                $codeTree = $this->codeModel->getCodeTree($hotel_code);

                $products['items'][$key]['codeTree'] = $codeTree;

                $productReview = $this->reviewModel->getProductReview($product['product_idx']);
                $hotel = $this->productModel->find($product['product_idx']);

                $fsql = 'SELECT * FROM tbl_hotel_option WHERE goods_code = ? and o_room != 0 ORDER BY idx DESC';
                $hotel_options = $this->db->query($fsql, [$hotel['product_code']])->getResultArray();
                $_arr_utilities = [];
                if (count($hotel_options) > 0) {
                    $hotel_option = $hotel_options[0];
                    $room_idx = $hotel_option['o_room'];

                    $hsql = "SELECT * FROM tbl_product_stay WHERE room_list LIKE '%" . $this->db->escapeLikeString($room_idx) . "|%'";
                    $stay_hotel = $this->db->query($hsql)->getRowArray();

                    $rsql = "SELECT * FROM tbl_room WHERE g_idx = '$room_idx'";
                    $room = $this->db->query($rsql)->getRowArray();

                    $products['items'][$key]['room_name'] = $room["roomName"];

                    $roomCat = explode("|", $room["category"]);
                    $arr_room_category = [];

                    foreach ($roomCat as $cat) {
                        $code_name = $this->codeModel->getCodeName($cat);
                        array_push($arr_room_category, $code_name);
                    }

                    $room_category = implode(", ", $arr_room_category);

                    $products['items'][$key]['room_category'] = $room_category;

                    if ($stay_hotel) {
                        $code_utilities = $stay_hotel['code_utilities'];
                        $_arr_utilities = explode("|", $code_utilities);
                    }
                }

                $list__utilities = rtrim(implode(',', $_arr_utilities), ',');

                if (!empty($list__utilities)) {
                    $fsql = "SELECT * FROM tbl_code WHERE code_no IN ($list__utilities) ORDER BY onum DESC, code_idx DESC";

                    $fresult4 = $this->db->query($fsql);
                    $fresult4 = $fresult4->getResultArray();
                    $products['items'][$key]['utilities'] = $fresult4;
                }

                $_arr_promotions = explode('|', $product['product_promotions']);

                $list__promotions = rtrim(implode(',', $_arr_promotions), ',');

                if (!empty($list__promotions)) {
                    $fsql = "SELECT * FROM tbl_code WHERE code_no IN ($list__promotions) ORDER BY onum DESC, code_idx DESC";

                    $fresult5 = $this->db->query($fsql);
                    $fresult5 = $fresult5->getResultArray();
                    $products['items'][$key]['promotions'] = $fresult5;
                }

                $products['items'][$key]['total_review'] = $productReview['total_review'];
                $products['items'][$key]['review_average'] = $productReview['avg'];

                $fsql9 = "select * from tbl_code where parent_code_no='30' and code_no='" . $product['product_level'] . "' order by onum desc, code_idx desc";
                $fresult9 = $this->db->query($fsql9);
                $fresult9 = $fresult9->getRowArray();

                $products['items'][$key]['level_name'] = $fresult9['code_name'];
            }

            $data = [
                'banners' => $banners,
                'codeBanners' => $codeBanners,
                'codes' => $codes,
                'types_hotel' => $types_hotel,
                'ratings' => $ratings,
                'promotions' => $promotions,
                'topics' => $topics,
                'bedrooms' => $bedrooms,
                'products' => $products,
                'code_no' => $code_no,
                'code_name' => $parent_code_name,
                'perPage' => $perPage,
                'tab_active' => '1',
            ];

            return $this->renderView('product/hotel/list-hotel', $data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function hotelDetail($idx)
    {
        try {
            $s_category_room = $_GET['s_category_room'] ?? '';
            $subSql = '';

            $session = session();

            if (isset($s_category_room) && $s_category_room !== '') {
                $subSql .= " AND r.category LIKE '%" . $s_category_room . "|%'";
            }

            $hotel = $this->productModel->find($idx);
            if (!$hotel) {
                throw new Exception('존재하지 않는 상품입니다.');
            }

            $hotel['array_hotel_code'] = $this->explodeAndTrim($hotel['product_code'], '|');
            $hotel['array_goods_code'] = $this->explodeAndTrim($hotel['product_code'], ',');

            $hotel['array_hotel_code_name'] = $this->getHotelCodeNames($hotel['array_hotel_code']);

            list($totalReview, $reviewAverage) = $this->getReviewSummary($hotel['product_idx'], $hotel['array_hotel_code'][0] ?? '');
            $hotel['total_review'] = $totalReview;
            $hotel['review_average'] = $reviewAverage;

            $suggestHotels = $this->getSuggestedHotels($hotel['product_idx'], $hotel['array_hotel_code'][0] ?? '', '1303');

            $fsql = 'SELECT * FROM tbl_hotel_option WHERE goods_code = ? and o_room != 0 ORDER BY idx ASC';
            $hotel_options = $this->db->query($fsql, [$hotel['product_code']])->getResultArray();
            $_arr_utilities = $_arr_best_utilities = $_arr_services = $_arr_populars = [];
            if (count($hotel_options) > 0) {
                $hotel_option = $hotel_options[0];
                $room_idx = $hotel_option['o_room'];

                $rsql = "SELECT * FROM tbl_product_stay WHERE room_list LIKE '%" . $this->db->escapeLikeString($room_idx) . "|%'";
                $stay_hotel = $this->db->query($rsql)->getRowArray();

                if ($stay_hotel) {
                    $code_utilities = $stay_hotel['code_utilities'];
                    $_arr_utilities = explode("|", $code_utilities);

                    $code_services = $stay_hotel['code_services'];
                    $_arr_services = explode("|", $code_services);

                    $code_best_utilities = $stay_hotel['code_best_utilities'];
                    $_arr_best_utilities = explode("|", $code_best_utilities);

                    $code_populars = $stay_hotel['code_populars'];
                    $_arr_populars = explode("|", $code_populars);
                }
            }

            $list__utilities = rtrim(implode(',', $_arr_utilities), ',');
            $list__best_utilities = rtrim(implode(',', $_arr_best_utilities), ',');
            $list__services = rtrim(implode(',', $_arr_services), ',');
            $list__populars = rtrim(implode(',', $_arr_populars), ',');

            if (!empty($list__utilities)) {
                $fsql = "SELECT * FROM tbl_code WHERE code_no IN ($list__utilities) ORDER BY onum DESC, code_idx DESC";

                $fresult4 = $this->db->query($fsql);
                $fresult4 = $fresult4->getResultArray();
            }

            if (!empty($list__best_utilities)) {
                $fsql = "SELECT * FROM tbl_code WHERE code_no IN ($list__best_utilities) ORDER BY onum DESC, code_idx DESC";
                $bresult4 = $this->db->query($fsql);
                $bresult4 = $bresult4->getResultArray();
            }

            if (!empty($list__services)) {
                $fsql = "SELECT * FROM tbl_code WHERE parent_code_no='34' ORDER BY onum DESC, code_idx DESC";
                $fresult5 = $this->db->query($fsql);
                $fresult5 = $fresult5->getResultArray();

                $fresult5 = array_map(function ($item) use ($list__services) {
                    $rs = (array)$item;

                    $code_no = $rs['code_no'];
                    $fsql = "SELECT * FROM tbl_code WHERE parent_code_no='$code_no' and code_no IN ($list__services) ORDER BY onum DESC, code_idx DESC";

                    $rs_child = $this->db->query($fsql)->getResultArray();

                    $rs['child'] = $rs_child;

                    return $rs;
                }, $fresult5);
            }

            if (!empty($list__populars)) {
                $fsql = "SELECT * FROM tbl_code WHERE code_no IN ($list__populars) ORDER BY onum DESC, code_idx DESC";
                $fresult8 = $this->db->query($fsql);
                $fresult8 = $fresult8->getResultArray();
            }
            $categories = '';

            $sql = "SELECT * 
                    FROM tbl_hotel_option o
                    JOIN tbl_room r ON r.g_idx = o.o_room
                    WHERE o.goods_code = '" . $hotel['product_code'] . "'
                    AND o.o_room != 0 
                    ORDER BY o.idx ASC";

            $hotel_options = $this->db->query($sql)->getResultArray();

            $hotel_option_convert = [];

            $list__gix = "";
            foreach ($hotel_options as $option) {
                $sql_count = "SELECT * FROM tbl_room WHERE g_idx = " . $option['o_room'];

                $room = $this->db->query($sql_count)->getRowArray();

                $list__gix .= $option['o_room'] . ',';
                $room_option = [];
                if ($room) {
                    $categories .= $room['category'];

                    $sql = "SELECT * FROM tbl_room_options WHERE h_idx = " . $idx . " AND r_idx = " . $room['g_idx'];
                    $room_option = $this->db->query($sql)->getResultArray();
                }

                $room['room_option'] = $room_option;
                $option['room'] = $room ?? '';
                $hotel_option_convert[] = $option;
            }

            $_arr_categories = explode("|", $categories);
            $_arr_categories = array_unique($_arr_categories);
            $list__categories = rtrim(implode(',', $_arr_categories), ',');

            $insql = "";
            if (count($_arr_categories) > 0 && $list__categories !== '') {
                $insql = " AND code_no IN ($list__categories)";
            }

            $_arr_gix = explode(",", $list__gix);
            $list__gix = rtrim(implode(',', $_arr_gix), ',');
            $insql2 = "";
            if (count($_arr_gix) > 0 && $list__gix !== '') {
                $insql2 = " AND g_idx IN ($list__gix)";
            }

            $sql = "SELECT * FROM tbl_code WHERE code_gubun = 'hotel_cate' and parent_code_no = 36 " . $insql . " ORDER BY onum DESC, code_idx DESC";

            $room_categories = $this->db->query($sql)->getResultArray();

            $room_categories_convert = [];
            foreach ($room_categories as $category) {
                $sql_count = "SELECT * FROM tbl_room WHERE category LIKE '%" . $this->db->escapeLikeString($category['code_no']) . "|%'" . $insql2;
                $count = $this->db->query($sql_count)->getNumRows();
                $category['count'] = $count;
                $room_categories_convert[] = $category;
            }

            $fsql = "select * from tbl_code where code_gubun='Room facil' and depth='2' order by onum desc, code_idx desc";
            $rresult = $this->db->query($fsql) or die($this->db->error);
            $rresult = $rresult->getResultArray();

            $sql = "SELECT a.*, b.ufile1 as avt
                    FROM tbl_travel_review a 
                    INNER JOIN tbl_member b ON a.user_id = b.m_idx 
                    WHERE a.product_idx = " . $idx . " AND a.is_best = 'Y' ORDER BY a.onum DESC, a.idx DESC";

            $reviews = $this->db->query($sql) or die($this->db->error);
            $reviewCount = $reviews->getNumRows();
            $reviews = $reviews->getResultArray();

            $sql = "SELECT * FROM tbl_code WHERE parent_code_no=42 ORDER BY onum ";
            $reviewCategories = $this->db->query($sql) or die($this->db->error);
            $reviewCategories = $reviewCategories->getResultArray();

            $reviewCategories = array_map(function ($item) use ($idx) {
                $reviewCategory = (array)$item;

                $sql = "SELECT * FROM tbl_travel_review WHERE product_idx = " . $this->db->escape($idx) .
                    " AND review_type LIKE '%" . $this->db->escapeLikeString($item['code_no']) . "%'";
                $results = $this->db->query($sql);
                $count = $results->getNumRows();
                $results = $results->getResultArray();

                if ($count == 0) {
                    $average = 0;
                } else {
                    $total = 0;
                    foreach ($results as $item2) {
                        $total += (int)$item2['number_stars'];
                    }

                    $average = number_format($total / $count, 1);
                }

                $reviewCategory['average'] = $average;
                $reviewCategory['total'] = $count;

                return $reviewCategory;
            }, $reviewCategories);

            if (!empty($session->get("member")["id"])) {
                $user_id = $session->get("member")["id"];
                $c_sql = "SELECT c.c_idx, c.coupon_num, c.user_id, c.regdate, c.enddate, c.usedate
                                , c.status, c.types, s.coupon_name, s.dc_type, s.coupon_pe, s.coupon_price 
                                    FROM tbl_coupon c LEFT JOIN tbl_coupon_setting s ON c.coupon_type = s.idx WHERE user_id = '" . $user_id . "' 
                                    AND status = 'N' AND STR_TO_DATE(enddate, '%Y-%m-%d') >= CURDATE()";
                $c_result = $this->db->query($c_sql);
                $c_row = $c_result->getResultArray();
            } else {
                $c_row = [];
            }

            $fsql9 = "select * from tbl_code where parent_code_no='30' and code_no='" . $hotel['product_level'] . "' order by onum desc, code_idx desc";
            $fresult9 = $this->db->query($fsql9);
            $fresult9 = $fresult9->getRowArray();

            $data = [
                'hotel' => $hotel,
                'fresult9' => $fresult9,
                's_category_room' => $s_category_room,
                'fresult4' => $fresult4 ?? [],
                'bresult4' => $bresult4 ?? [],
                'fresult5' => $fresult5 ?? [],
                'fresult8' => $fresult8 ?? [],
                'rresult' => $rresult ?? [],
                'reviewCategories' => $reviewCategories ?? [],
                'reviews' => $reviews ?? [],
                'reviewCount' => $reviewCount,
                'room_categories' => $room_categories_convert,
                'hotel_options' => $hotel_option_convert,
                'coupons' => $c_row,
                'suggestHotel' => $suggestHotels,
            ];

            return $this->renderView('product/hotel/hotel-details', $data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function index7($code_no)
    {
        return $this->renderView('product/hotel/customer-form');
    }

    public function reservationForm()
    {
        $cart = $this->request->getCookie('cart-hotel');

        if ($cart) {
            $cart_arr = json_decode($cart, true);
            $product_idx = $cart_arr["product_idx"] ?? 0;
            $room_op_idx = $cart_arr["room_op_idx"] ?? 0;
            $use_coupon_idx = $cart_arr["use_coupon_idx"] ?? 0;
            $used_coupon_money = $cart_arr["used_coupon_money"] ?? 0;
            $coupon_discount = $cart_arr["coupon_discount"] ?? 0;
            $inital_price = $cart_arr["inital_price"] ?? 0;
            $last_price = $cart_arr["last_price"] ?? 0;
            $number_room = $cart_arr["number_room"] ?? 0;
            $number_day = $cart_arr["number_day"] ?? 0;

            $setting = homeSetInfo();
            $extra_cost = 0;

            $type_extra_cost = $setting["type_extra_cost"];
            if (!empty($setting["extra_cost"])) {
                if ($type_extra_cost == "P") {
                    $extra_cost = round(intval($last_price) * floatval($setting["extra_cost"]) / 100);
                } else {
                    $extra_cost = $setting["extra_cost"];
                }
            }

            $hotel = $this->productModel->find($product_idx);

            $data = [
                'hotel' => $hotel,
                'inital_price' => $inital_price,
                'number_room' => $number_room,
                'number_day' => $number_day,
                'use_coupon_idx' => $use_coupon_idx,
                'room_op_idx' => $room_op_idx,
                'coupon_discount' => $coupon_discount,
                'used_coupon_money' => $used_coupon_money,
                'extra_cost' => $extra_cost,
                'last_price' => $last_price
            ];
        }

        return $this->renderView('product/hotel/reservation-form', $data);
    }

    public function reservationFormInsert()
    {

        try {

            $product_idx = $this->request->getPost('product_idx') ?? 0;
            $room_op_idx = $this->request->getPost('room_op_idx') ?? 0;
            $use_coupon_idx = $this->request->getPost('use_coupon_idx') ?? 0;
            $used_coupon_money = $this->request->getPost('used_coupon_money') ?? 0;
            $inital_price = $this->request->getPost('inital_price') ?? 0;
            $order_price = $this->request->getPost('order_price') ?? 0;
            $number_room = $this->request->getPost('number_room') ?? 0;
            $number_day = $this->request->getPost('number_day') ?? 0;
            $order_memo = $this->request->getPost('order_memo') ?? "";
            $email_name = $this->request->getPost('email_name') ?? "";
            $email_host = $this->request->getPost('email_host') ?? "";
            $order_user_name = $this->request->getPost('order_user_name') ?? "";
            $order_user_mobile = $this->request->getPost('order_user_mobile') ?? "";
            $order_user_email = $email_name . "@" . $email_host;
            $hotel = $this->productModel->find($product_idx);
            $m_idx = session()->get("member")["idx"];
            $order_status = "W";
            $ipAddress = $this->request->getIPAddress();
            $device_type = get_device();
            $code_name = $this->codeModel->getCodeName($hotel["product_code_1"]);

            if (!empty($use_coupon_idx)) {
                $coupon = $this->coupon->find($use_coupon_idx);
            }

            $data = [
                "m_idx" => $m_idx,
                "device_type" => $device_type,
                "product_idx" => $product_idx,
                "product_code_1" => $hotel["product_code_1"],
                "product_code_2" => $hotel["product_code_2"],
                "product_code_3" => $hotel["product_code_3"],
                "product_code_4" => $hotel["product_code_4"],
                "product_code_list" => $hotel["product_code_list"],
                "product_name" => $hotel["product_name"],
                "code_name" => $code_name,
                "order_gubun" => "hotel",
                "order_user_name" => encryptField($order_user_name, "encode"),
                "order_user_mobile" => encryptField($order_user_mobile, "encode"),
                "order_user_email" => encryptField($order_user_email, "encode"),
                "order_memo" => $order_memo,
                "inital_price" => $inital_price,
                "order_price" => $order_price,
                "order_date" => Time::now('Asia/Seoul', 'en_US'),
                "used_coupon_idx" => $use_coupon_idx,
                "used_coupon_money" => $used_coupon_money,
                "room_op_idx" => $room_op_idx,
                "order_room_cnt" => $number_room,
                "order_day_cnt" => $number_day,
                "order_r_date" => Time::now('Asia/Seoul', 'en_US'),
                "order_status" => $order_status,
                "encode" => "Y",
                "ip" => $ipAddress
            ];

            $order_idx = $this->orderModel->insert($data);
            if ($order_idx) {
                $order_no = $this->orderModel->makeOrderNo();
                $this->orderModel->update($order_idx, ["order_no" => $order_no]);

                if (!empty($use_coupon_idx)) {
                    $this->coupon->update($use_coupon_idx, ["status" => "E"]);

                    $cou_his = [
                        "order_idx" => $order_idx,
                        "product_idx" => $product_idx,
                        "used_coupon_no" => $coupon["coupon_num"] ?? "",
                        "used_coupon_idx" => $use_coupon_idx,
                        "used_coupon_money" => $used_coupon_money,
                        "ch_r_date" => Time::now('Asia/Seoul', 'en_US'),
                        "m_idx" => $m_idx
                    ];

                    $this->couponHistory->insert($cou_his);
                }

                $order_num_room = $this->request->getPost('order_num_room');
                $order_first_name = $this->request->getPost('order_first_name');
                $order_last_name = $this->request->getPost('order_last_name');
                foreach ($order_num_room as $key => $value) {
                    $first_name = encryptField($order_first_name[$key], "encode");
                    $last_name = encryptField($order_last_name[$key], "encode");
                    $data_sub = [
                        "m_idx" => $m_idx,
                        "order_idx" => $order_idx,
                        "product_idx" => $product_idx,
                        "number_room" => filter_var(preg_replace('/[^0-9]/', '', $value), FILTER_SANITIZE_NUMBER_INT),
                        "order_gubun" => "hotel",
                        "order_first_name" => $first_name,
                        "order_last_name" => $last_name,
                        "encode" => "Y"
                    ];
                    $this->orderSubModel->insert($data_sub);
                }

                $this->response->deleteCookie('cart');

                return $this->response->setJSON([
                    'result' => true,
                    'message' => "주문되었습니다."
                ], 200);
            }

            return $this->response->setJSON([
                'result' => false,
                'message' => "Error"
            ], 400);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function completedOrder()
    {
        return $this->renderView('product/completed-order', ['return_url' => '/']);
    }

    public function golfList($code_no)
    {
        $filters = $this->codeModel->getByParentAndDepth(45, 2)->getResultArray();

        $green_peas = $this->request->getGet('green_peas');
        $sports_days = $this->request->getGet('sports_days');
        $slots = $this->request->getGet('slots');
        $golf_course_odd_numbers = $this->request->getGet('golf_course_odd_numbers');
        $travel_times = $this->request->getGet('travel_times');
        $carts = $this->request->getGet('carts');
        $facilities = $this->request->getGet('facilities');
        $pg = $this->request->getGet('pg') ?? 1;

        foreach ($filters as $key => $filter) {
            $filters[$key]['children'] = $this->codeModel->getByParentAndDepth($filter['code_no'], 3)->getResultArray();
            if ($filter['code_no'] == 4501) $filters[$key]['filter_name'] = "green_peas";
            if ($filter['code_no'] == 4502) $filters[$key]['filter_name'] = "sports_days";
            if ($filter['code_no'] == 4503) $filters[$key]['filter_name'] = "slots";
            if ($filter['code_no'] == 4504) $filters[$key]['filter_name'] = "golf_course_odd_numbers";
            if ($filter['code_no'] == 4505) $filters[$key]['filter_name'] = "travel_times";
            if ($filter['code_no'] == 4506) $filters[$key]['filter_name'] = "carts";
            if ($filter['code_no'] == 4507) $filters[$key]['filter_name'] = "facilities";
        }

        $green_peas = array_filter(explode(",", $green_peas));
        $sports_days = array_filter(explode(",", $sports_days));
        $slots = array_filter(explode(",", $slots));
        $golf_course_odd_numbers = array_filter(explode(",", $golf_course_odd_numbers));
        $travel_times = array_filter(explode(",", $travel_times));
        $carts = array_filter(explode(",", $carts));
        $facilities = array_filter(explode(",", $facilities));

        $products = $this->productModel->findProductGolfPaging([
            'is_view' => 'Y',
            'product_code_1' => 1302,
            'product_code_2' => $code_no,
            'green_peas' => $green_peas,
            'sports_days' => $sports_days,
            'slots' => $slots,
            'golf_course_odd_numbers' => $golf_course_odd_numbers,
            'travel_times' => $travel_times,
            'carts' => $carts,
            'facilities' => $facilities,
        ], 10, $pg, []);


        foreach ($products['items'] as $key => $product) {

            $code = $product['product_code_1'];
            if ($product['product_code_2']) $code = $product['product_code_2'];
            if ($product['product_code_3']) $code = $product['product_code_3'];

            $codeTree = $this->codeModel->getCodeTree($product['product_code_1']);

            $products['items'][$key]['codeTree'] = $codeTree;

            $productReview = $this->reviewModel->getProductReview($product['product_idx']);

            $products['items'][$key]['total_review'] = $productReview['total_review'];
            $products['items'][$key]['review_average'] = $productReview['avg'];
        }

        return $this->renderView('product/golf/list-golf', [
            'filters' => $filters,
            'code_no' => $code_no,
            'code_info' => $this->codeModel->getByCodeNo($code_no),
            'green_peas' => $green_peas,
            'sports_days' => $sports_days,
            'slots' => $slots,
            'golf_course_odd_numbers' => $golf_course_odd_numbers,
            'travel_times' => $travel_times,
            'carts' => $carts,
            'facilities' => $facilities,
            'products' => $products
        ]);
    }

    public function golfDetail($product_idx)
    {
        $baht_thai = (float)($this->setting['baht_thai'] ?? 0);

        $data['product'] = $this->productModel->getProductDetails($product_idx);
        if (!$data['product']) {
            return view('errors/html/error_404');
        }
        $data['info'] = $this->golfInfoModel->getGolfInfo($product_idx);
        $productReview = $this->reviewModel->getProductReview($product_idx);
        $data['product']['total_review'] = $productReview['total_review'];
        $data['product']['review_average'] = $productReview['avg'];

        $data['imgs'] = [];
        $data['img_names'] = [];

        $golf_vehicle = $data['info']['golf_vehicle'];

        $golfVehicles = $this->golfVehicleModel->getByParentAndDepth(0, 1)->getResultArray();

        $data['golfVehicles'] = array_filter($golfVehicles, function ($vehicle) use ($golf_vehicle) {
            return in_array($vehicle['code_no'], explode("|", $golf_vehicle));
        });

        $golfVehiclesChildren = [];

        foreach ($data['golfVehicles'] as $key => $value) {
            $data['golfVehicles'][$key]['children'] = $this->golfVehicleModel->getByParentAndDepth($value['code_no'], 2)->getResultArray();

            $price = (float)$value['price'];
            $price_baht = round($price / $baht_thai);
            $data['golfVehicles'][$key]['price_baht'] = $price_baht;

            $golfVehiclesChildren = array_merge($golfVehiclesChildren, $data['golfVehicles'][$key]['children']);
        }

        foreach ($golfVehiclesChildren as $key => $value) {
            $price = (float)$value['price'];
            $price_baht = round($price / $baht_thai);
            $golfVehiclesChildren[$key]['price_baht'] = $price_baht;
        }

        $data['golfVehiclesChildren'] = $golfVehiclesChildren;

        for ($i = 1; $i <= 7; $i++) {
            $file = "ufile" . $i;
            if (is_file(ROOTPATH . "public/data/product/" . $data['product'][$file])) {
                $data['imgs'][] = "/data/product/" . $data['product'][$file];
                $data['img_names'][] = $data['product']["rfile" . $i];
            } else {
                $data['imgs'][] = "/images/product/noimg.png";
                $data['img_names'][] = "";
            }
        }

        if (!empty(session()->get("member")["id"])) {
            $user_id = session()->get("member")["id"];
            $c_sql = "SELECT c.c_idx, c.coupon_num, c.user_id, c.regdate, c.enddate, c.usedate
                            , c.status, c.types, s.coupon_name, s.dc_type, s.coupon_pe, s.coupon_price 
                                FROM tbl_coupon c LEFT JOIN tbl_coupon_setting s ON c.coupon_type = s.idx WHERE user_id = '" . $user_id . "' 
                                AND status = 'N' AND STR_TO_DATE(enddate, '%Y-%m-%d') >= CURDATE()";
            $c_result = $this->db->query($c_sql);
            $data['coupons'] = $c_result->getResultArray();
        } else {
            $data['coupons'] = [];
        }

        foreach ($data['coupons'] as $key => $coupon) {
            $coupon_price = (float)$coupon['coupon_price'];
            $coupon['coupon_price_baht'] = round($coupon_price / $baht_thai);
            $data['coupons'][$key] = $coupon;
        }

        $options = $this->golfOptionModel->getOptions($product_idx);

        $hole_cnt_arr = array_column($options, 'hole_cnt');
        $hour_arr = array_column($options, 'hour');

        $data['hole_cnt_arr'] = array_filter(GOLF_HOLES, function ($value) use ($hole_cnt_arr) {
            return in_array($value, $hole_cnt_arr);
        });

        $data['hour_arr'] = array_filter(GOLF_HOURS, function ($value) use ($hour_arr) {
            return in_array($value, $hour_arr);
        });

        return $this->renderView('product/golf/golf-details', $data);
    }

    public function optionList($product_idx)
    {
        $hole_cnt = $this->request->getVar('hole_cnt');
        $hour = $this->request->getVar('hour');
        $options = $this->golfOptionModel->getOptions($product_idx, $hole_cnt, $hour);

        foreach ($options as $key => $value) {
            $option_price = (float)$value['option_price'];
            $baht_thai = (float)($this->setting['baht_thai'] ?? 0);
            $option_price_baht = round($option_price / $baht_thai);
            $options[$key]['option_price_baht'] = $option_price_baht;
        }

        return view('product/golf/option_list', ['options' => $options]);
    }

    private function golfPriceCalculate($option_idx, $people_adult_cnt, $vehicle_cnt, $vehicle_idx, $use_coupon_idx)
    {

        $data['option'] = $this->golfOptionModel->find($option_idx);

        $data['total_price'] = $data['option']['option_price'] * $people_adult_cnt;

        $data['total_price_baht'] = round($data['total_price'] / (float)($this->setting['baht_thai'] ?? 0));

        $total_vehicle_price = 0;
        $total_vehicle_price_baht = 0;

        $vehicle_arr = [];
        $total_vehicle = 0;
        foreach ($vehicle_cnt as $key => $value) {
            if ($value > 0) {
                $info = $this->golfVehicleModel->getCodeByIdx($vehicle_idx[$key]);
                $info['cnt'] = $value;
                $info['price_baht'] = round((float)$info['price'] / (float)($this->setting['baht_thai'] ?? 0));
                $vehicle_arr[] = $info;

                $total_vehicle_price += $info['price'] * $value;
                $total_vehicle_price_baht += $info['price_baht'] * $value;

                $total_vehicle += $value;
            }
        }


        $data['vehicle_arr'] = $vehicle_arr;

        $data['total_vehicle'] = $total_vehicle;

        $coupon = $this->coupon->getCouponInfo($use_coupon_idx);

        if ($coupon) {
            if ($coupon['dc_type'] == "P") {
                $price = $total_vehicle_price + $data['total_price'];
                $data['discount'] = $price * ($coupon['coupon_pe'] / 100);
                $data['discount_baht'] = round((float)$data['discount'] / (float)($this->setting['baht_thai'] ?? 0));
            } else if ($coupon['dc_type'] == "D") {
                $data['discount'] = $coupon['coupon_price'];
                $data['discount_baht'] = round((float)$coupon['coupon_price'] / (float)($this->setting['baht_thai'] ?? 0));
            }
        }

        $data['inital_price'] = $total_vehicle_price + $data['total_price'];
        $data['final_price'] = $total_vehicle_price + $data['total_price'] - $data['discount'];
        $data['final_price_baht'] = $total_vehicle_price_baht + $data['total_price_baht'] - $data['discount_baht'];

        return $data;

    }

    public function customerForm()
    {
        $data['product_idx'] = $this->request->getVar('product_idx');
        $data['order_date'] = $this->request->getVar('order_date');
        $data['option_idx'] = $this->request->getVar('option_idx');
        $data['people_adult_cnt'] = $this->request->getVar('people_adult_cnt');
        $data['vehicle_idx'] = $this->request->getVar('vehicle_idx');
        $data['vehicle_cnt'] = $this->request->getVar('vehicle_cnt');
        $data['use_coupon_idx'] = $this->request->getVar('use_coupon_idx');

        $daysOfWeek = ["일", "월", "화", "수", "목", "금", "토"];

        $date = date("Y.m.d", strtotime($data['order_date']));

        $dayOfWeek = date("w");

        $formattedDate = $date . "(" . $daysOfWeek[$dayOfWeek] . ")";

        $data['final_date'] = $formattedDate;

        $data['product'] = $this->productModel->find($data['product_idx']);

        $priceCalculate = $this->golfPriceCalculate(
            $data['option_idx'],
            $data['people_adult_cnt'],
            $data['vehicle_cnt'],
            $data['vehicle_idx'],
            $data['use_coupon_idx']
        );

        return $this->renderView('product/golf/customer-form', array_merge($data, $priceCalculate));
    }

    public function customerFormOk()
    {
        try {
            $data = $this->request->getPost();
            $data['m_idx'] = session('member.idx') ?? "";
            $product = $this->productModel->find($data['product_idx']);
            $data['product_name'] = $product['product_name'];
            $data['product_code_1'] = $product['product_code_1'];
            $data['product_code_2'] = $product['product_code_2'];
            $data['product_code_3'] = $product['product_code_3'];
            $data['product_code_4'] = $product['product_code_4'];
            $data['order_no'] = $this->orderModel->makeOrderNo();
            $order_user_email = $data['email_1'] . "@" . $data['email_2'];
            $data['order_user_email'] = encryptField($order_user_email, 'encode');
            $data['order_r_date'] = date('Y-m-d H:i:s');
            $data['order_status'] = "W";
            if ($data['radio_phone'] == "kor") {
                $order_user_phone = $data['phone_1'] . "-" . $data['phone_2'] . "-" . $data['phone_3'];
            } else {
                $order_user_phone = $data['phone_thai'];
            }

            $data['order_user_phone'] = encryptField($order_user_phone, 'encode');

            $data['vehicle_time'] = $data['vehicle_time_hour'] . ":" . $data['vehicle_time_minute'];

            $priceCalculate = $this->golfPriceCalculate(
                $data['option_idx'],
                $data['people_adult_cnt'],
                $data['vehicle_cnt'],
                $data['vehicle_idx'],
                $data['use_coupon_idx']
            );

            $data['order_price'] = $priceCalculate['final_price'];
            $data['inital_price'] = $priceCalculate['inital_price'];
            $data['used_coupon_idx'] = $data['use_coupon_idx'];
            $data['ip'] = $this->request->getIPAddress();
            $data['order_gubun'] = "golf";
            $data['code_name'] = $this->codeModel->getByCodeNo($data['product_code_1'])['code_name'];
            $data['order_user_name'] = encryptField($data['order_user_name'], 'encode');
            $data['order_user_first_name_en'] = encryptField($data['order_user_first_name_en'], 'encode');
            $data['order_user_last_name_en'] = encryptField($data['order_user_last_name_en'], 'encode');

            if ($data['radio_phone'] == "kor") {
                $order_user_mobile = $data['phone_1'] . "-" . $data['phone_2'] . "-" . $data['phone_3'];
            } else {
                $order_user_mobile = $data['phone_thai'];
            }

            $data['order_user_mobile'] = encryptField($order_user_mobile, 'encode');

            $data['local_phone'] = encryptField($data['local_phone'], 'encode');

            $this->orderModel->save($data);

            $order_idx = $this->orderModel->getInsertID();

            foreach ($data['companion_name'] as $key => $value) {
                $this->orderSubModel->insert([
                    'order_gubun' => 'adult',
                    'order_idx' => $order_idx,
                    'product_idx' => $data['product_idx'],
                    'order_full_name' => encryptField($data['companion_name'][$key], 'encode'),
                    'order_sex' => $data['companion_gender'][$key],
                ]);
            }

            $this->orderOptionModel->insert([
                'option_type' => 'main',
                'order_idx' => $order_idx,
                'product_idx' => $data['product_idx'],
                'option_name' => $priceCalculate['option']['hole_cnt'] . "홀 / " . $priceCalculate['option']['hour'] . "시간 / " . $priceCalculate['option']['minute'] . "분",
                'option_idx' => $data['option_idx'],
                'option_tot' => $priceCalculate['total_price'],
                'option_cnt' => $data['people_adult_cnt'],
                'option_date' => $data['order_r_date'],
            ]);

            foreach ($data['vehicle_idx'] as $key => $value) {
                $vehicle = $this->golfVehicleModel->find($data['vehicle_idx'][$key]);
                if ($vehicle) {
                    $this->orderOptionModel->insert([
                        'option_type' => 'vehicle',
                        'order_idx' => $order_idx,
                        'product_idx' => $data['product_idx'],
                        'option_name' => $vehicle['code_name'],
                        'option_idx' => $vehicle['code_idx'],
                        'option_tot' => $vehicle['price'] * $data['vehicle_cnt'][$key],
                        'option_cnt' => $data['vehicle_cnt'][$key],
                        'option_date' => $data['order_r_date'],
                    ]);
                }
            }

            if (!empty($data['use_coupon_idx'])) {
                $coupon = $this->coupon->getCouponInfo($data['use_coupon_idx']);

                if ($coupon) {
                    $this->coupon->update($data['use_coupon_idx'], ["status" => "E"]);

                    $cou_his = [
                        "order_idx" => $order_idx,
                        "product_idx" => $data['product_idx'],
                        "used_coupon_no" => $coupon["coupon_num"] ?? "",
                        "used_coupon_idx" => $data['use_coupon_idx'],
                        "used_coupon_money" => $priceCalculate['discount'],
                        "ch_r_date" => date('Y-m-d H:i:s'),
                        "m_idx" => session('member.idx')
                    ];

                    $this->couponHistory->insert($cou_his);
                }
            }

            return $this->response->setBody("
                <script>
                    alert('주문되었습니다');
                    parent.location.href = '/product-golf/completed-order';
                </script>
            ");
        } catch (\Throwable $th) {
            return $this->response->setBody("
                    <script>
                        alert(`" . $th->getMessage() . "`);
                        parent.location.reload();
                    </script>
                ");
        }
    }

    public function golfCompletedOrder()
    {
        return $this->renderView('product/completed-order', ['return_url' => '/']);
    }

    public function tourCustomerForm()
    {
        $data['product_idx'] = $this->request->getVar('product_idx');
        $data['order_date'] = $this->request->getVar('order_date');
        $data['tours_idx'] = $this->request->getVar('tours_idx');
        $data['people_adult_cnt'] = $this->request->getVar('people_adult_cnt');
        $data['people_adult_price'] = $this->request->getVar('people_adult_price');
        $data['people_kids_cnt'] = $this->request->getVar('people_kids_cnt');
        $data['people_kids_price'] = $this->request->getVar('people_kids_price');
        $data['people_baby_cnt'] = $this->request->getVar('people_baby_cnt');
        $data['people_baby_price'] = $this->request->getVar('people_baby_price');
        $data['start_place'] = $this->request->getVar('start_place');
        $data['end_place'] = $this->request->getVar('end_place');
        $data['metting_time'] = $this->request->getVar('metting_time');
        $data['description'] = $this->request->getVar('description');
        $data['id_kakao'] = $this->request->getVar('id_kakao');
        $data['time_line'] = $this->request->getVar('time_line');
        $idx = $this->request->getVar('idx');
        $data['idx'] = explode(',', $idx);
        $data['adult_price_bath'] = round($data['people_adult_price'] / (float)($this->setting['baht_thai'] ?? 0));
        $data['kids_price_bath'] = round($data['people_kids_price'] / (float)($this->setting['baht_thai'] ?? 0));
        $data['baby_price_bath'] = round($data['people_baby_price'] / (float)($this->setting['baht_thai'] ?? 0));
        $data['total_price_product'] = $data['people_adult_price'] + $data['people_kids_price'] + $data['people_baby_price'];
        $data['total_price_product_bath'] = ( $data['adult_price_bath']) + ($data['kids_price_bath']) + ($data['baby_price_bath']);
        $data['adult_price_total'] = ( $data['people_adult_price']);
        $data['kids_price_total'] = ($data['people_kids_price']);
        $data['baby_price_total'] = ($data['people_baby_price']);        
        $data['use_coupon_idx'] = $this->request->getVar('use_coupon_idx');
        $data['final_discount'] = (float)($this->request->getVar('final_discount') ?? 0);
        $data['final_discount_bath'] = round($data['final_discount'] / (float)($this->setting['baht_thai'] ?? 0));

        $data['product'] = $this->productModel->find($data['product_idx']);

        $data['tour_product'] = $this->tourProducts->find($data['tours_idx']);
        $data['tour_info'] = $this->infoProducts->find($data['tour_product']['info_idx']);
        $data['tour_option'] = [];
        foreach ($data['idx'] as $id) {
            $tourOption = $this->optionTours->find(trim($id));
            if ($tourOption) {
                $data['tour_option'][] = $tourOption;
                $data['option_price'][] = $tourOption['option_price'];
                $data['option_price_bath'][] = round($tourOption['option_price'] / (float)($this->setting['baht_thai'] ?? 0));;
            }
        }
        $total_option_price_bath = array_sum($data['option_price_bath']);
        $total_option_price = array_sum($data['option_price']);

        $data['final_price'] = $data['total_price_product'] + $total_option_price - $data['final_discount'];
        $data['inital_price'] = $data['total_price_product'] + $total_option_price ;
        $data['final_price_bath'] = $data['total_price_product_bath'] + $total_option_price_bath;


        return $this->renderView('product/tour/customer-form', $data);
    }

    public function tourFormOk()
    {
        try {
            $data = $this->request->getPost();
            $data['m_idx'] = session('member.idx') ?? "";
            $product = $this->productModel->find($data['product_idx']);
            $data['product_name'] = $product['product_name'];
            $data['product_code_1'] = $product['product_code_1'];
            $data['product_code_2'] = $product['product_code_2'];
            $data['product_code_3'] = $product['product_code_3'];
            $data['product_code_4'] = $product['product_code_4'];
            $data['order_no'] = $this->orderModel->makeOrderNo();
            $order_user_email = $data['email_1'][0] . "@" . $data['email_2'][0];
            $data['order_user_email'] = encryptField($order_user_email, 'encode');
            $data['order_r_date'] = date('Y-m-d H:i:s');
            $data['order_status'] = "W";

            $data['used_coupon_idx'] = $data['use_coupon_idx'];
            $data['ip'] = $this->request->getIPAddress();
            $data['order_gubun'] = "tour";
            $data['code_name'] = $this->codeModel->getByCodeNo($data['product_code_1'])['code_name'];
            $data['order_user_name'] = encryptField($data['companion_name'][0], 'encode');

            $order_user_mobile = $data['phone_1'][0] . "-" . $data['phone_2'][0] . "-" . $data['phone_3'][0];
            $data['order_user_mobile'] = encryptField($order_user_mobile, 'encode');

            $data['people_adult_cnt'] = $data['people_adult_cnt'];
            $data['people_kids_cnt'] = $data['people_kids_cnt'];
            $data['people_baby_cnt'] = $data['people_baby_cnt'];

            $data['people_adult_price'] = $data['people_adult_price'];
            $data['people_kids_price'] = $data['people_kids_price'];
            $data['people_baby_price'] = $data['people_baby_price'];
            $data['order_price'] = $data['final_price'];
            $data['inital_price'] = $data['inital_price'];
            $this->orderModel->save($data);

            $order_idx = $this->orderModel->getInsertID();

            $adultCount = (int)$data['people_adult_cnt'];
            $kidsCount = (int)$data['people_kids_cnt'];
            $babyCount = (int)$data['people_baby_cnt'];
            foreach ($data['companion_name'] as $key => $value) {
                if ($key < $adultCount) {
                    $orderGubun = 'adult';
                } elseif ($key < $adultCount + $kidsCount) {
                    $orderGubun = 'kids';
                } else {
                    $orderGubun = 'baby';
                }

                $companion_email = $data['email_1'][$key] . "@" . $data['email_2'][$key] ?? '';
                $order_mobile = $data['phone_1'][$key] . "-" . $data['phone_2'][$key] . "-" . $data['phone_3'][$key] ?? '';
                $this->orderSubModel->insert([
                    'order_gubun' => $orderGubun,
                    'order_idx' => $order_idx,
                    'product_idx' => $data['product_idx'],
                    'order_full_name' => encryptField($data['companion_name'][$key], 'encode'),
                    'order_sex' => $data['companion_gender'][$key],
                    'order_birthday' => $data['order_birthday'][$key],
                    'order_mobile' => encryptField($order_mobile, 'encode'),
                    'order_email' => encryptField($companion_email, 'encode'),
                ]);
            }

            $optionsIdx = $this->request->getPost('option_idx');
            $optionsIdxString = is_array($optionsIdx) ? implode(',', $optionsIdx) : null;

            $orderTourData = [
                'tours_idx' => $this->request->getPost('tours_idx'),
                'order_idx' => $order_idx,
                'options_idx' => $optionsIdxString,
                'product_idx' => $data['product_idx'],
                'time_line' => $this->request->getPost('time_line'),
                'start_place' => $this->request->getPost('start_place'),
                'metting_time' => $this->request->getPost('metting_time'),
                'id_kakao' => $this->request->getPost('id_kakao'),
                'description' => $this->request->getPost('description'),
                'end_place' => $this->request->getPost('end_place'),
                'r_date' => date('Y-m-d H:i:s'),
            ];
            $this->orderTours->save($orderTourData);

            if (!empty($data['use_coupon_idx'])) {
                $coupon = $this->coupon->getCouponInfo($data['use_coupon_idx']);

                if ($coupon) {
                    $this->coupon->update($data['use_coupon_idx'], ["status" => "E"]);

                    $cou_his = [
                        "order_idx" => $order_idx,
                        "product_idx" => $data['product_idx'],
                        "used_coupon_no" => $coupon["coupon_num"] ?? "",
                        "used_coupon_idx" => $data['use_coupon_idx'],
                        "used_coupon_money" => $this->request->getPost('final_discount'),
                        "ch_r_date" => date('Y-m-d H:i:s'),
                        "m_idx" => session('member.idx')
                    ];

                    $this->couponHistory->insert($cou_his);
                }
            }


            return $this->response->setBody("
                <script>
                    alert('주문되었습니다');
                    parent.location.href = '/product-tours/completed-order';
                </script>
            ");
        } catch (\Throwable $th) {
            return $this->response->setBody("
                    <script>
                        alert('주문되지 않습니다');
                    </script>
                ");
        }
    }

    public function tourCompletedOrder()
    {
        return $this->renderView('product/completed-order', ['return_url' => '/']);
    }

    public function index8($product_idx)
    {
        $baht_thai = (float)($this->setting['baht_thai'] ?? 0);
        $data['product'] = $this->productModel->getProductDetails($product_idx);
        $timeLine = $data['product']['time_line'];
        $timeSegments = explode(',', $timeLine);
        $timeSegments = array_map('trim', $timeSegments);
        $data['timeSegments'] = $timeSegments;
        $data['imgs'] = [];
        $data['img_names'] = [];
        for ($i = 1; $i <= 7; $i++) {
            $file = "ufile" . $i;
            if (is_file(ROOTPATH . "public/data/product/" . $data['product'][$file])) {
                $data['imgs'][] = "/data/product/" . $data['product'][$file];
                $data['img_names'][] = $data['product']["rfile" . $i];
            } else {
                $data['imgs'][] = "/images/product/noimg.png";
                $data['img_names'][] = "";
            }
        }

        $data['imgs_tour'] = [];
        $data['img_names_tour'] = [];

        for ($i = 1; $i <= 6; $i++) {
            $file = "tours_ufile" . $i;
            if (isset($data['product'][$file]) && is_file(ROOTPATH . "public/data/product/" . $data['product'][$file])) {
                $data['imgs_tour'][] = "/data/product/" . $data['product'][$file];
                $data['img_names_tour'][] = $data['product']["tours_ufile" . $i] ?? '';
            }
        }

        if (!empty(session()->get("member")["id"])) {
            $user_id = session()->get("member")["id"];
            $c_sql = "SELECT c.c_idx, c.coupon_num, c.user_id, c.regdate, c.enddate, c.usedate
                            , c.status, c.types, s.coupon_name, s.dc_type, s.coupon_pe, s.coupon_price 
                                FROM tbl_coupon c LEFT JOIN tbl_coupon_setting s ON c.coupon_type = s.idx WHERE user_id = '" . $user_id . "' 
                                AND status = 'N' AND STR_TO_DATE(enddate, '%Y-%m-%d') >= CURDATE()";
            $c_result = $this->db->query($c_sql);
            $data['coupons'] = $c_result->getResultArray();
        } else {
            $data['coupons'] = [];
        }

        foreach ($data['coupons'] as $key => $coupon) {
            $coupon_price = (float)$coupon['coupon_price'];
            $coupon['coupon_price_baht'] = round($coupon_price / $baht_thai);
            $data['coupons'][$key] = $coupon;
        }


        $sql_info = "
        SELECT pt.*, pti.*
        FROM tbl_product_tours pt
        LEFT JOIN tbl_product_tour_info pti ON pt.info_idx = pti.info_idx
        WHERE pt.product_idx = ? ORDER BY pt.info_idx ASC, pt.tours_idx ASC
        ";

        $query_info = $this->db->query($sql_info, [$product_idx]);
        $results = $query_info->getResultArray();

        $groupedData = [];
        foreach ($results as $row) {
            $infoIndex = $row['info_idx'];

            if (!isset($groupedData[$infoIndex])) {
                $groupedData[$infoIndex] = [
                    'info' => $row,
                    'tours' => []
                ];
            }

            $price = (float)$row['tour_price'];
            $price_baht = round($price / $baht_thai);

            $price_kids = (float)$row['tour_price_kids'];
            $price_baht_kids = round($price_kids / $baht_thai);

            $price_baby = (float)$row['tour_price_baby'];
            $price_baht_baby = round($price_baby / $baht_thai);

            $groupedData[$infoIndex]['tours'][] = [
                'tours_idx' => $row['tours_idx'],
                'tours_subject' => $row['tours_subject'],
                'tour_price' => $row['tour_price'],
                'tour_price_kids' => $row['tour_price_kids'],
                'tour_price_baby' => $row['tour_price_baby'],
                'status' => $row['status'],
                'price_baht' => $price_baht,
                'price_baht_kids' => $price_baht_kids,
                'price_baht_baby' => $price_baht_baby,
            ];
        }

        $data['productTourInfo'] = $groupedData;

        $airCode = $this->request->getGet('air_code') ?? '0000';

        $productDetail = $this->dayModel->getProductDetail($product_idx, $airCode);
        if (!$productDetail) {
            $this->dayModel->createProductDetail([
                'product_idx' => $product_idx,
                'air_code' => $airCode,
                'total_day' => 0
            ]);
            $productDetail = $this->dayModel->getProductDetail($product_idx, $airCode);
        }
        $detailIdx = $productDetail['idx'];
        $totalDays = $productDetail['total_day'];
        $schedules = [];

        for ($dd = 1; $dd <= $totalDays; $dd++) {
            $schedule = $this->mainSchedule->getByDetailAndDay($detailIdx, $dd);
            $schedules[$dd] = $schedule ?? [];
        }
        $subSchedules = [];
        foreach ($schedules as $day => $schedule) {
            if (!empty($schedule)) {
                $subScheduleDetails = $this->subSchedule
                    ->where('detail_idx', $detailIdx)
                    ->where('day_idx', $day)
                    ->findAll();

                foreach ($subScheduleDetails as $subSchedule) {
                    $subSchedules[$day][$subSchedule['groups']][] = $subSchedule;
                }
            } else {
                $subSchedules[$day] = [];
            }
        }

        $data['subSchedules'] = $subSchedules;
        $data['schedules'] = $schedules;
        $data['totalDays'] = $totalDays;

        $builder = $this->db->table('tbl_tours_moption');
        $builder->where('product_idx', $product_idx);
        $builder->where('use_yn', 'Y');
        $builder->orderBy('onum', 'desc');
        $query = $builder->get();
        $options = $query->getResultArray();

        foreach ($options as &$option) {
            $optionBuilder = $this->db->table('tbl_tours_option');
            $optionBuilder->where('product_idx', $product_idx);
            $optionBuilder->where('code_idx', $option['code_idx']);
            $optionBuilder->orderBy('onum', 'desc');
            $optionQuery = $optionBuilder->get();
            $option['additional_options'] = $optionQuery->getResultArray();
        }

        $data['options'] = $options;

        return $this->renderView('tours/tour-details', $data);
    }

    public function index9($code_no)
    {
        try {
            $pg = $this->request->getVar('pg') ?? 1;
            $search_keyword = $this->request->getVar('search_keyword') ?? "";
            $search_word = $this->request->getVar('search_word') ?? "";
            $perPage = 5;

            $codes = $this->codeModel->getByParentCode($code_no)->getResultArray();

            $parent_code_name = $this->productModel->getCodeName($code_no)["code_name"];

            $arr_code_list = [];
            foreach ($codes as $code) {
                array_push($arr_code_list, $code["code_no"]);
            }

            $product_code_list = implode(",", $arr_code_list);

            $products = $this->productModel->findProductPaging([
                'product_code_1' => 1301,
                'product_code_2' => $code_no,
            ], 10, $pg, ['onum' => 'DESC']);

            foreach ($products['items'] as $key => $product) {

                $code = $product['product_code_1'];
                if ($product['product_code_2']) $code = $product['product_code_2'];
                if ($product['product_code_3']) $code = $product['product_code_3'];
    
                $codeTree = $this->codeModel->getCodeTree($product['product_code_1']);
    
                $products['items'][$key]['codeTree'] = $codeTree;
    
                $productReview = $this->reviewModel->getProductReview($product['product_idx']);
    
                $products['items'][$key]['total_review'] = $productReview['total_review'];
                $products['items'][$key]['review_average'] = $productReview['avg'];
            }

            if (!empty($search_keyword) && $search_keyword !== "all") {
                $keywords = explode(',', $search_keyword);
                $filteredProducts = array_filter($products['items'], function ($product) use ($keywords) {
                    $productKeywords = explode(',', $product['keyword']);
                    return array_intersect($keywords, $productKeywords);
                });
                $products['items'] = $filteredProducts;
            }


            $keyWordAll = $this->productModel->getKeyWordAll(1301);

            $keyWordActive = array_search($search_keyword, $keyWordAll) ?? 0;

            $productByKeyword = $this->productModel->findProductPaging([
                'product_code_1' => 1301,
                'search_txt' => $keyWordAll[$keyWordActive] ?? "",
                'search_category' => 'keyword'
            ], $this->scale, 1);

            foreach ($productByKeyword['items'] as $key => $product) {

                $fsql9 = "select * from tbl_code where parent_code_no='30' and code_no='" . $product['product_level'] . "' order by onum desc, code_idx desc";
                $fresult9 = $this->db->query($fsql9);
                $fresult9 = $fresult9->getRowArray();

                $productByKeyword['items'][$key]['level_name'] = $fresult9['code_name'];
            }

            if (!empty($search_word)) {
                $products['items'] = array_filter($products['items'], function ($product) use ($search_word) {
                    $search_word = strtolower($search_word);
                    $product_name = strtolower($product['product_name'] ?? "");
                    $product_keywords = strtolower($product['keyword'] ?? "");
            
                    return strpos($product_name, $search_word) !== false || strpos($product_keywords, $search_word) !== false;
                });
            }

            $products['nTotalCount'] = count($products['items']);

            $data = [
                'codes' => $codes,
                'products' => $products,
                'code_no' => $code_no,
                'code_name' => $parent_code_name,
                'perPage' => $perPage,
                'tab_active' => '1',
                'keyWordAll' => $keyWordAll,
                'search_keyword' => $search_keyword,
                'keyWordActive' => $keyWordAll[$keyWordActive],
                'productByKeyword' => $productByKeyword,
                'search_word' => $search_word,
            ];

            return $this->renderView('tours/list-tour', $data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function spaDetail($product_idx)
    {
        $data = $this->getDataDetail($product_idx, '1325');

        return $this->renderView('/product/spa/spa-details', $data);
    }

    public function productBooking()
    {
        $session = Services::session();
        $data = $session->get('data_cart');

        if (empty($data)) {
            return redirect()->to('/');
        }

        $res = $this->getDataBooking();

        $order_gubun = 'spa';
        $res['order_gubun'] = $order_gubun;

        return $this->renderView('/product/spa/product-booking', $res);
    }

    public function processBooking()
    {
        try {
            $session = Services::session();

            $product_idx = $_POST['product_idx'];
            $day_ = $_POST['day_'];

            $member_idx = $_SESSION['member']['idx'];

            if (!$member_idx) {
                $message = "로그인해주세요!";
                return $this->response->setJSON([
                    'result' => false,
                    'message' => $message
                ], 400);
            }

            $adultQty = $_POST['adultQty'];
            $adultPrice = $_POST['adultPrice'];

            $childrenQty = $_POST['childrenQty'];
            $childrenPrice = $_POST['childrenPrice'];

            $totalPrice = $_POST['totalPrice'];

            $option_idx = $_POST['option_idx'];
            $option_tot = $_POST['option_tot'];
            $option_qty = $_POST['option_qty'];
            $option_cnt = $_POST['option_cnt'];
            $option_name = $_POST['option_name'];
            $option_price = $_POST['option_price'];

            $data = [
                'product_idx' => $product_idx,
                'day_' => $day_,
                'member_idx' => $member_idx,
                'adultQty' => $adultQty,
                'adultPrice' => $adultPrice,
                'childrenQty' => $childrenQty,
                'childrenPrice' => $childrenPrice,
                'totalPrice' => $totalPrice,
                'option_idx' => $option_idx,
                'option_qty' => $option_qty,
                'option_tot' => $option_tot,
                'option_price' => $option_price,
                'option_cnt' => $option_cnt,
                'option_name' => $option_name
            ];

            $session->set('data_cart', $data);

            $message = "성공.";
            return $this->response->setJSON([
                'result' => $data,
                'message' => $message
            ], 200);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function spaCompletedOrder()
    {
        return $this->renderView('/product/spa/completed-order');
    }

    public function tourLocationInfo($product_idx)
    {
        $data['product'] = $this->productModel->getProductDetails($product_idx);
        $data['imgs'] = [];
        $data['img_names'] = [];
        for ($i = 1; $i <= 7; $i++) {
            $file = "ufile" . $i;
            if (is_file(ROOTPATH . "public/data/product/" . $data['product'][$file])) {
                $data['imgs'][] = "/data/product/" . $data['product'][$file];
                $data['img_names'][] = $data['product']["rfile" . $i];
            } else {
                $data['imgs'][] = "/images/product/noimg.png";
                $data['img_names'][] = "";
            }
        }
        return $this->renderView('tours/location-info', $data);
    }

    public function tourOrderForm($code_no)
    {
        return $this->renderView('tours/order-form');
    }

    public function restaurantIndex($code_no)
    {
        try {
            $data = $this->viewData($code_no);
            $data['bannerTop'] = $this->bannerModel->getBanners($code_no, "top")[0];

            return $this->renderView('/product/restaurant/product-restaurant', $data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function restaurantDetail($product_idx)
    {
        $data = $this->getDataDetail($product_idx, '1320');

        return $this->renderView('/product/restaurant/restaurant-detail', $data);
    }

    public function restaurantBooking()
    {
        $session = Services::session();
        $data = $session->get('data_cart');

        if (empty($data)) {
            return redirect()->to('/');
        }

        $res = $this->getDataBooking();
        $order_gubun = 'restaurant';
        $res['order_gubun'] = $order_gubun;
        return $this->renderView('/product/restaurant/restaurant-booking', $res);
    }

    public function restaurantCompleted()
    {
        return $this->renderView('/product/restaurant/completed-order');
    }

    public function vehicleGuide($code_no)
    {
        try {

            $codes = $this->codeModel->getByParentCode($code_no)->getResultArray();

            $place_start_list = $this->codeModel->getByParentCode(48)->getResultArray();

            $place_end_list = $this->codeModel->getByParentCode(49)->getResultArray();

            // foreach($products as $key => $value){
            //     $osql = "select * from tbl_cars_option where product_code = '" . $value["product_code"] . "'";
            //     $oresult = $this->db->query($osql);
            //     $oresult = $oresult->getResultArray();
            //     $products[$key]["options"] = $oresult;
            //     $product_price = (float)$value['product_price'];
            //     $baht_thai = (float)($setting['baht_thai'] ?? 0);
            //     $product_price_baht = $product_price / $baht_thai;
            //     $products[$key]['product_price_baht'] = $product_price_baht;
            // }

            $data = [
                'tab_active' => '7',
                'parent_code' => $code_no,
                'codes' => $codes,
                'place_start_list' => $place_start_list,
                'place_end_list' => $place_end_list,
                'bannerTop' => $this->bannerModel->getBanners($code_no, "top")
            ];

            return $this->renderView('product/vehicle-guide', $data);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function filterVehicle()
    {
        try {
            $code_no = $this->request->getPost("code_no");
            $departure_code = $this->request->getPost("departure_code");
            $destination_code = $this->request->getPost("destination_code");

            $child_codes = $this->codeModel->getByParentCode($code_no)->getResultArray();

            if (count($child_codes) > 0) {
                $i = 1;
                foreach ($child_codes as $child) {
                    if ($i == 1) {
                        $code_first = $child["code_no"];
                    }
                    $i++;
                }

            } else {
                $code_first = $code_no;
            }

            $products = $this->productModel->findProductCarPaging([
                "product_code_list" => $code_first,
                "departure_code" => $departure_code,
                "destination_code" => $destination_code
            ]);

            foreach ($products["items"] as $key => $value) {
                $options = $this->carsOptionModel->findOption($products["items"][$key]["product_code"]);
                foreach ($options as $key2 => $value2) {
                    $types = $this->codeModel->getByCodeNos(array_map("trim", explode(",", $value2["c_op_type"])));
                    $options[$key2]["icons"] = array_column($types, "ufile1");
                }
                $products["items"][$key]["options"] = $options;
            }

            $data = [
                'child_codes' => $child_codes,
                'products' => $products["items"]
            ];

            return $this->response->setJSON($data, 200);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function filterChildVehicle()
    {
        try {
            $child_code = $this->request->getPost("child_code");
            $departure_code = $this->request->getPost("departure_code");
            $destination_code = $this->request->getPost("destination_code");

            $products = $this->productModel->findProductCarPaging([
                "product_code_list" => $child_code,
                "departure_code" => $departure_code,
                "destination_code" => $destination_code
            ]);

            foreach ($products["items"] as $key => $value) {
                $options = $this->carsOptionModel->findOption($products["items"][$key]["product_code"]);
                foreach ($options as $key2 => $value2) {
                    $types = $this->codeModel->getByCodeNos(array_map("trim", explode(",", $value2["c_op_type"])));
                    $options[$key2]["icons"] = array_column($types, "ufile1");
                }
                $products["items"][$key]["options"] = $options;
            }

            $data = [
                'products' => $products["items"]
            ];

            return $this->response->setJSON($data, 200);
        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function vehicleOrder()
    {
        try {

            if (!empty(session()->get("member")["id"])) {
                $parent_code = $this->request->getPost('parent_code') ?? "";
                $product_code = $this->request->getPost('product_code') ?? "";
                $product_arr = $this->request->getPost('product_arr') ?? "";
                $product_cnt_arr = $this->request->getPost('product_cnt_arr') ?? "";
                $departure_area = $this->request->getPost('departure_area') ?? "";
                $destination_area = $this->request->getPost('destination_area') ?? "";
                $meeting_date = $this->request->getPost('meeting_date') ?? "";
                $adult_cnt = $this->request->getPost('adult_cnt') ?? 0;
                $child_cnt = $this->request->getPost('child_cnt') ?? 0;
                $hours = $this->request->getPost('hours') ?? "";
                $minutes = $this->request->getPost('minutes') ?? "";
                $departure_hotel = $this->request->getPost('departure_hotel') ?? "";
                $destination_hotel = $this->request->getPost('destination_hotel') ?? "";
                $order_memo = $this->request->getPost('order_memo') ?? "";
                $phone1 = $this->request->getPost('phone1') ?? "";
                $phone2 = $this->request->getPost('phone2') ?? "";
                $phone3 = $this->request->getPost('phone3') ?? "";
                $email_name = $this->request->getPost('email_name') ?? "";
                $email_host = $this->request->getPost('email_host') ?? "";
                $inital_price = $this->request->getPost('inital_price') ?? 0;
                $order_price = $this->request->getPost('order_price') ?? 0;

                $order_user_mobile = $phone1 . "-" . $phone2 . "-" . $phone3;
                $order_user_email = $email_name . "@" . $email_host;
                $m_idx = session()->get("member")["idx"];
                $order_status = "W";
                $ipAddress = $this->request->getIPAddress();
                $device_type = get_device();

                $code_name = $this->codeModel->getCodeName($parent_code);

                if (!empty($hours) && !empty($minutes)) {
                    $vehicle_time = $hours . ":" . $minutes;
                }

                $data = [
                    "m_idx" => $m_idx,
                    "device_type" => $device_type,
                    "product_idx" => 0,
                    "product_code_1" => $parent_code,
                    "product_code_2" => "",
                    "product_code_3" => "",
                    "product_code_4" => "",
                    "product_code_list" => $product_code,
                    "product_name" => "",
                    "code_name" => $code_name,
                    "order_gubun" => "vehicle",
                    "order_user_mobile" => encryptField($order_user_mobile, "encode"),
                    "order_user_email" => encryptField($order_user_email, "encode"),
                    "order_memo" => $order_memo,
                    "people_adult_cnt" => $adult_cnt,
                    "people_kids_cnt" => $child_cnt,
                    "inital_price" => $inital_price,
                    "order_price" => $order_price,
                    "order_date" => Time::now('Asia/Seoul', 'en_US'),
                    "vehicle_time" => $vehicle_time,
                    "departure_area" => $departure_area,
                    "destination_area" => $destination_area,
                    "meeting_date" => $meeting_date,
                    "departure_hotel" => $departure_hotel,
                    "destination_hotel" => $destination_hotel,
                    "order_r_date" => Time::now('Asia/Seoul', 'en_US'),
                    "order_status" => $order_status,
                    "encode" => "Y",
                    "ip" => $ipAddress
                ];

                $order_idx = $this->orderModel->insert($data);
                if ($order_idx) {
                    $order_no = $this->orderModel->makeOrderNo();
                    $this->orderModel->update($order_idx, ["order_no" => $order_no]);

                    $car_op_idx = explode(",", $product_arr);
                    $car_op_cnt = explode(",", $product_cnt_arr);

                    if (count($car_op_idx) > 0 && count($car_op_cnt) > 0) {
                        for ($i = 0; $i < count($car_op_idx); $i++) {
                            $product_idx = $this->carsSubModel->find($car_op_idx[$i])["product_idx"];
                            $op_price = $this->carsSubModel->find($car_op_idx[$i])["car_price"];
                            $data_sub = [
                                "option_type" => "vehicle",
                                "order_idx" => $order_idx,
                                "product_idx" => $product_idx,
                                "option_idx" => $car_op_idx[$i],
                                "option_date" => Time::now('Asia/Seoul', 'en_US'),
                                "option_price" => $op_price,
                                "option_qty" => $car_op_cnt[$i],
                            ];
                            $this->orderOptionModel->insert($data_sub);
                        }
                    }

                    return $this->response->setJSON([
                        'result' => true,
                        'message' => "주문되었습니다."
                    ], 200);
                }

                return $this->response->setJSON([
                    'result' => false,
                    'message' => "Error"
                ], 400);
            } else {
                return $this->response->setJSON([
                    'result' => false,
                    'message' => "주문하시려면 로그인해주세요"
                ]);
            }

        } catch (Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function view($product_idx)
    {

        $data['product'] = $this->productModel->getProductDetails($product_idx);

        if (!$data['product']) {
            return redirect()->to('/')->with('error', '상품이 없거나 판매중이 아닙니다.');
        }


        $start_date_in = $this->request->getVar('start_date_in') ?: date("Y-m-d");
        $product_info = $this->productModel->get_product_info($product_idx, $start_date_in);
        $air_info = $this->productModel->get_air_info($product_idx, $start_date_in);
        $day_details = $this->productModel->getDayDetails($product_idx);


        $min_amt = $this->calculateMinAmt($air_info);


        $_start_dd = date('d', strtotime($start_date_in));


        $tour_price = $air_info[0]['tour_price'] ?? 0;
        $oil_price = $air_info[0]['oil_price'] ?? 0;
        $tour_price_kids = $air_info[0]['tour_price_kids'] ?? 0;
        $tour_price_baby = $air_info[0]['tour_price_baby'] ?? 0;


        $seq = time();
        $sDate = date('Y-m-01');
        $today = date('Y-m-d');
        $priceData = $this->productModel->getPriceData($seq, $product_idx, $sDate);
        $first_date = $this->productModel->getFirstDate($seq, $product_idx, $today);
        $this->productModel->deletePriceVal($seq);

        $sel_date = '';
        $sel_price = '';
        foreach ($priceData as $row) {
            $cal_amt = $row['price'] / 10000;
            $sel_date .= $row['get_date'] . "|";
            $sel_price .= $cal_amt . "|";
        }

        $data['start_date_in'] = $start_date_in;
        $data['product_info'] = $product_info;
        $data['air_info'] = $air_info;
        $data['min_amt'] = $min_amt;
        $data['_start_dd'] = $_start_dd;
        $data['tour_price'] = $tour_price;
        $data['oil_price'] = $oil_price;
        $data['tour_price_kids'] = $tour_price_kids;
        $data['tour_price_baby'] = $tour_price_baby;
        $data['product_idx'] = $product_idx;
        $data['product_confirm'] = $data['product']['product_confirm'];
        $data['product_able'] = $data['product']['product_able'];
        $data['product_unable'] = $data['product']['product_unable'];
        $data['tour_info'] = $data['product']['tour_info'];
        $data['special_benefit'] = $data['product']['special_benefit'];
        $data['day_details'] = $day_details;
        $data['sel_date'] = $sel_date;
        $data['sel_price'] = $sel_price;
        $data['first_date'] = $first_date['get_date'] ?? '';

        $data['product_level'] = $this->productModel->getProductLevel($data['product']['product_level']);
        $data['img_1'] = $this->getImage($data['product']['ufile1']);
        $data['img_2'] = $this->getImage($data['product']['ufile2']);
        $data['img_3'] = $this->getImage($data['product']['ufile3']);
        $data['img_4'] = $this->getImage($data['product']['ufile4']);
        $data['img_5'] = $this->getImage($data['product']['ufile5']);
        $data['img_6'] = $this->getImage($data['product']['ufile6']);

        return $this->renderView('product/product_view', $data);
    }

    public function sel_moption()
    {
        try {
            $product_idx = $_POST['product_idx'];
            $code_idx = $_POST['code_idx'];

            $msg = "";
            $msg .= "<select name='option' id='option' onchange='sel_option(this.value);'>";
            $msg .= "<option value=''>옵션 선택</option>";


            $sql = "SELECT * FROM tbl_tours_option WHERE product_idx = '$product_idx' AND code_idx = '$code_idx' ";
            write_log($sql);
            $result = $this->db->query($sql);
            $result = $result->getResultArray();
            foreach ($result as $row) {
                $msg .= "<option value='" . $row['idx'] . "|" . $row['option_price'] . "'>" . $row['option_name'] . " +" . number_format($row['option_price']) . "원</option>";
            }

            $msg .= "</select>";

            return $msg;
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function sel_option()
    {
        try {
            $idx = $_POST['idx'];
            $moption = $_POST['moption'];

            $sql = "SELECT * FROM tbl_tours_moption WHERE code_idx = '$moption' ";
            write_log($sql);
            $result2 = $this->db->query($sql)->getRowArray();

            $sql = "SELECT * FROM tbl_tours_option WHERE idx = '$idx' ";
            write_log($sql);
            $result = $this->db->query($sql)->getRowArray();
            $result['parent_name'] = $result2['moption_name'];

            return $this->response->setJSON($result, 200);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function sel_coupon()
    {
        try {
            $result = [];

            $idx = $_POST['idx'];

            $sql = "SELECT c.c_idx, c.coupon_num, c.user_id, c.regdate, c.enddate, c.usedate
                            , c.status, c.types, s.coupon_name, s.dc_type, s.coupon_pe, s.coupon_price 
                                FROM tbl_coupon c LEFT JOIN tbl_coupon_setting s ON c.coupon_type = s.idx WHERE c.c_idx = '" . $idx . "' 
                                AND status = 'N' AND STR_TO_DATE(enddate, '%Y-%m-%d') >= CURDATE()";
            write_log($sql);
            $result = $this->db->query($sql)->getRowArray();

            return $this->response->setJSON($result, 200);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'result' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    private function explodeAndTrim($string, $delimiter)
    {
        return array_filter(array_map('trim', explode($delimiter, $string)));
    }

    private function getHotelCodeNames(array $hotelCodes)
    {
        if (empty($hotelCodes)) {
            return [];
        }

        $list = implode(',', $hotelCodes);

        $sql = "SELECT code_no, code_name FROM tbl_code WHERE code_no IN (?)";
        $items = $this->db->query($sql, [$list])->getResultArray();

        $hotelCodeNames = [];
        foreach ($items as $item) {
            if (!empty($item['code_name'])) {
                $hotelCodeNames[] = $item['code_name'];
            }
        }

        return $hotelCodeNames;
    }

    private function getReviewSummary($product_idx, $code)
    {
        $sql = "SELECT number_stars FROM tbl_travel_review WHERE product_idx = ?";
        $reviews = $this->db->query($sql, [$product_idx])->getResultArray();

        $totalReview = count($reviews);

        if ($totalReview === 0) {
            return [0, 0];
        }

        $reviewAverage = array_sum(array_column($reviews, 'number_stars')) / $totalReview;

        return [$totalReview, round($reviewAverage, 1)];
    }

    private function getSuggestedHotels($currentHotelId, $currentHotelCode, $productCode1 = null)
    {
        if (!$productCode1) {
            $productCode1 = 1303;
        }
        $suggestHotels = $this->productModel
            ->where('product_idx !=', $currentHotelId)
            ->where('product_code_1', $productCode1)
            ->limit(10)
            ->get()
            ->getResultArray();

        return array_map(function ($hotel) use ($currentHotelCode) {
            $hotel['array_hotel_code'] = $this->explodeAndTrim($hotel['product_code'], '|');
            $hotel['array_goods_code'] = $this->explodeAndTrim($hotel['product_code'], ',');

            $hotel['array_hotel_code_name'] = $this->getHotelCodeNames($hotel['array_hotel_code']);

            list($totalReview, $reviewAverage) = $this->getReviewSummary($hotel['product_idx'], $currentHotelCode);
            $hotel['total_review'] = $totalReview;
            $hotel['review_average'] = $reviewAverage;

            return $hotel;
        }, $suggestHotels);
    }

    private function calculateMinAmt($air_info)
    {
        $min_amt = 9999999999;
        foreach ($air_info as $info) {
            $tour_price = $info['tour_price'] / 10000;
            if ($tour_price < $min_amt && $tour_price > 0) {
                $min_amt = $tour_price;
            }
        }
        return $min_amt;
    }

    private function getImage($file)
    {
        // return base_url("images/{$file}");
        return base_url("/data/product/thum_798_463/{$file}");
    }

    private function viewData($code_no)
    {
        $search_product_name = $this->request->getVar('keyword') ?? "";
        $product_code_2 = $this->request->getVar('product_code_2') ?? "";

        $sql = "SELECT * FROM tbl_product_mst WHERE product_code_1 = " . $code_no . " AND is_view='Y' ORDER BY onum DESC, product_idx DESC";
        $products = $this->db->query($sql);
        $products = $products->getResultArray();

        $strSql = '';

        if ($search_product_name && $search_product_name != "") {
            $strSql = $strSql . " AND product_name LIKE '%$search_product_name%'";
        }
        if ($product_code_2 && $product_code_2 != "") {
            $strSql = $strSql . " AND product_code_2 = " . $product_code_2;
        }

        $sql = "SELECT * FROM tbl_product_mst WHERE product_code_1 = " . $code_no . " AND is_view='Y' $strSql ORDER BY onum DESC, product_idx DESC";
        $productResults = $this->db->query($sql);
        $productResults = $productResults->getResultArray();

        foreach ($productResults as $key => $product) {
            $hotel_codes = explode("|", $product['product_code_list']);
            $hotel_codes = array_values(array_filter($hotel_codes));

            $codeTree = $this->codeModel->getCodeTree($hotel_codes['0']);

            $productResults[$key]['codeTree'] = $codeTree;

            $productReview = $this->reviewModel->getProductReview($product['product_idx']);

            $productResults[$key]['total_review'] = $productReview['total_review'];
            $productResults[$key]['review_average'] = $productReview['avg'];
        }

        $sql = "SELECT * FROM tbl_code WHERE parent_code_no= $code_no AND status='Y' ORDER BY onum DESC, code_idx DESC";
        $codes = $this->db->query($sql);
        $codes = $codes->getResultArray();

        foreach ($codes as $key => $code) {
            $strSql2 = '';
            if ($search_product_name && $search_product_name != "") {
                $strSql2 = $strSql2 . " AND product_name LIKE '%$search_product_name%'";
            }
            $sql = "SELECT * FROM tbl_product_mst WHERE product_code_2 = " . $code['code_no'] . " AND is_view='Y' $strSql2 ORDER BY onum DESC, product_idx DESC";
            $sProducts = $this->db->query($sql);
            $sProducts = $sProducts->getNumRows();

            $codes[$key]['count'] = $sProducts;
        }

        $data = [
            "products" => $products,
            "productResults" => $productResults,
            "search_product_name" => $search_product_name,
            "product_code_2" => $product_code_2,
            "codes" => $codes,
        ];

        return $data;
    }

    private function getDataBooking()
    {
        $session = Services::session();
        $data = $session->get('data_cart');

        $product_idx = $data['product_idx'];
        $day_ = $data['day_'];
        $member_idx = $data['member_idx'];

        $adultQty = $data['adultQty'];
        $adultPrice = $data['adultPrice'];
        $childrenQty = $data['childrenQty'];
        $childrenPrice = $data['childrenPrice'];

        $totalPrice = $data['totalPrice'];

        $prod = $this->productModel->getById($product_idx);

        $builder = $this->db->table('tbl_tours_moption');
        $builder->where('product_idx', $product_idx);
        $builder->where('use_yn', 'Y');
        $builder->orderBy('onum', 'desc');
        $query = $builder->get();
        $moption = $query->getResultArray();

        $baht_thai = (float)($this->setting['baht_thai'] ?? 0);

        if (!empty(session()->get("member")["id"])) {
            $user_id = session()->get("member")["id"];
            $c_sql = "SELECT c.c_idx, c.coupon_num, c.user_id, c.regdate, c.enddate, c.usedate
                            , c.status, c.types, s.coupon_name, s.dc_type, s.coupon_pe, s.coupon_price 
                                FROM tbl_coupon c LEFT JOIN tbl_coupon_setting s ON c.coupon_type = s.idx WHERE user_id = '" . $user_id . "' 
                                AND status = 'N' AND STR_TO_DATE(enddate, '%Y-%m-%d') >= CURDATE()";
            $c_result = $this->db->query($c_sql);
            $coupons = $c_result->getResultArray();
        } else {
            $coupons = [];
        }

        foreach ($coupons as $key => $coupon) {
            $coupon_price = (float)$coupon['coupon_price'];
            $coupon['coupon_price_baht'] = round($coupon_price / $baht_thai);
            $coupons[$key] = $coupon;
        }

        return [
            'prod' => $prod,
            'day_' => $day_,
            'member_idx' => $member_idx,
            'moption' => $moption,
            'adultQty' => $adultQty,
            'adultPrice' => $adultPrice,
            'childrenQty' => $childrenQty,
            'childrenPrice' => $childrenPrice,
            'totalPrice' => $totalPrice,
            'coupons' => $coupons,
            'data' => $data,
        ];
    }

    private function getDataDetail($product_idx, $product_code)
    {
        $rowData = $this->productModel->find($product_idx);
        if (!$rowData) {
            throw new Exception('존재하지 않는 상품입니다.');
        }

        $hotel_codes = explode("|", $rowData['product_code_list']);
        $hotel_codes = array_values(array_filter($hotel_codes));

        $codeTree = $this->codeModel->getCodeTree($hotel_codes['0']);

        $rowData['codeTree'] = $codeTree;

        $productReview = $this->reviewModel->getProductReview($rowData['product_idx']);

        $rowData['total_review'] = $productReview['total_review'];
        $rowData['review_average'] = $productReview['avg'];

        $code_utilities = $rowData['code_utilities'];
        $_arr_utilities = explode("|", $code_utilities);
        $_arr_utilities = array_filter($_arr_utilities);

        $code_services = $rowData['code_services'];
        $_arr_services = explode("|", $code_services);
        $_arr_services = array_filter($_arr_services);

        $code_best_utilities = $rowData['code_best_utilities'];
        $_arr_best_utilities = explode("|", $code_best_utilities);
        $_arr_best_utilities = array_filter($_arr_best_utilities);

        $code_populars = $rowData['code_populars'];
        $_arr_populars = explode("|", $code_populars);;
        $_arr_populars = array_filter($_arr_populars);

        $list__utilities = rtrim(implode(',', $_arr_utilities), ',');
        $list__best_utilities = rtrim(implode(',', $_arr_best_utilities), ',');
        $list__services = rtrim(implode(',', $_arr_services), ',');
        $list__populars = rtrim(implode(',', $_arr_populars), ',');

        if (!empty($list__utilities)) {
            $fsql = "SELECT * FROM tbl_code WHERE code_no IN ($list__utilities) ORDER BY onum DESC, code_idx DESC";

            $fresult4 = $this->db->query($fsql);
            $fresult4 = $fresult4->getResultArray();
        }

        if (!empty($list__best_utilities)) {
            $fsql = "SELECT * FROM tbl_code WHERE code_no IN ($list__best_utilities) ORDER BY onum DESC, code_idx DESC";
            $bresult4 = $this->db->query($fsql);
            $bresult4 = $bresult4->getResultArray();
        }

        if (!empty($list__services)) {
            $fsql = "SELECT * FROM tbl_code WHERE parent_code_no='4404' ORDER BY onum DESC, code_idx DESC";
            $fresult5 = $this->db->query($fsql);
            $fresult5 = $fresult5->getResultArray();

            $fresult5 = array_map(function ($item) use ($list__services) {
                $rs = (array)$item;

                $code_no = $rs['code_no'];
                $fsql = "SELECT * FROM tbl_code WHERE parent_code_no='$code_no' and code_no IN ($list__services) ORDER BY onum DESC, code_idx DESC";

                $rs_child = $this->db->query($fsql)->getResultArray();

                $rs['child'] = $rs_child;

                return $rs;
            }, $fresult5);
        }

        if (!empty($list__populars)) {
            $fsql = "SELECT * FROM tbl_code WHERE code_no IN ($list__populars) ORDER BY onum DESC, code_idx DESC";
            $fresult8 = $this->db->query($fsql);
            $fresult8 = $fresult8->getResultArray();
        }

        $suggestSpas = $this->getSuggestedHotels($rowData['product_idx'], $rowData['array_hotel_code'][0] ?? '', $product_code);

        $builder = $this->db->table('tbl_tours_moption');
        $builder->where('product_idx', $product_idx);
        $builder->where('use_yn', 'Y');
        $builder->orderBy('onum', 'desc');
        $query = $builder->get();
        $moption = $query->getResultArray();

        $data = [
            'data_' => $rowData,
            'suggestSpas' => $suggestSpas,
            'moption' => $moption,
            'fresult4' => $fresult4,
            'bresult4' => $bresult4,
            'fresult5' => $fresult5,
            'fresult8' => $fresult8,
        ];

        return $data;
    }
}
