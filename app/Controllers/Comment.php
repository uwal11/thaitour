<?php

namespace App\Controllers;

use App\Libraries\SessionChk;
use Exception;

class Comment extends BaseController
{

    private $comment;

    protected $sessionLib;
    protected $sessionChk;

    public function __construct()
    {
        $this->comment = model("CommentModel");
        helper(['html']);
        $this->db = db_connect();
        $this->sessionLib = new SessionChk();
        $this->sessionChk = $this->sessionLib->infoChk();
        helper('my_helper');
        helper('comment_helper');
    }
    public function listComment()
    {
        $r_code = $this->request->getVar("r_code");
        $r_idx = updateSQ($this->request->getVar("r_idx"));
        $list = getComment($this->comment->getComments($r_code, $r_idx, private_key()), $r_code, $r_idx);
        return $list;
    }
    public function addComment()
    {
        $r_idx = updateSQ($this->request->getPost('r_idx'));
        $r_code = $this->request->getPost('r_code');
        $r_content = updateSQ($this->request->getPost('comment'));
        $user_id = $_SESSION['member']['id'];
        $r_m_idx = $_SESSION['member']['idx'];
        $r_name = $_SESSION['member']['name'];

        if (empty($user_id)) {
            return $this->response->setJSON("");
        }

        $data = [
            'r_idx' => $r_idx,
            'r_code' => $r_code,
            'r_m_idx' => $r_m_idx,
            'r_name' => $r_name ?? "",
            'r_content' => $r_content,
            'r_reg_date' => date('Y-m-d H:i:s'),
            'r_level' => 1,
            'r_step' => 1,
            'r_delYN' => 'N',
            'r_status' => 'Y'
        ];

        $result = $this->comment->addComment($data);

        return $result;
    }
    public function replyComment()
    {
        $r_ref = updateSQ($this->request->getPost('r_ref'));
        $r_idx = updateSQ($this->request->getPost('r_idx'));
        $r_level = updateSQ($this->request->getPost('r_level'));
        $r_content = updateSQ($this->request->getPost('r_content'));
        $r_code = $this->request->getPost('r_code');
        $r_m_idx = $_SESSION['member']['idx'];
        $r_name = $_SESSION['member']['name'];

        $data = [
            'r_ref' => $r_ref,
            'r_idx' => $r_idx,
            'r_level' => $r_level,
            'r_content' => $r_content,
            'r_code' => $r_code,
            'r_m_idx' => $r_m_idx,
            'r_name' => $r_name,
            'r_reg_date' => date('Y-m-d H:i:s')
        ];

        $result = $this->comment->replyComment($data);

        return $this->response->setJSON($result);
    }
    public function deleteComment()
    {
        $r_cmt_idx = updateSQ($this->request->getPost("r_cmt_idx"));

        $userId = $_SESSION['member']['idx'];
        $userIdx = $_SESSION['member']['idx'];
        $userLevel = $_SESSION['member']['level'];

        $result = $this->comment->softDeleteComment($r_cmt_idx, $userIdx, $userId, $userLevel);

        return $this->response->setJSON($result);
    }
    public function updateComment()
    {
        $r_cmt_idx  = updateSQ($this->request->getPost('r_cmt_idx'));
        $r_content  = updateSQ($this->request->getPost('r_content'));
        $user_idx   = $_SESSION['member']['idx'];
        $user_id    = $_SESSION['member']['id'];
        $user_level = $_SESSION['member']['level'];
    
        $result = $this->comment->updateComment($r_cmt_idx, $r_content, $user_idx, $user_id, $user_level);
    
        return $this->response->setJSON($result);
    }
    public function reportComment()
    {
        $code = updateSQ($this->request->getPost('code'));
        $r_idx = updateSQ($this->request->getPost('r_idx'));
        $r_cmt_idx = updateSQ($this->request->getPost('r_cmt_idx'));
        $report_reason = updateSQ($this->request->getPost('report_reason'));

        $m_idx = $_SESSION['member']['idx'];

        if (!$m_idx) {
            return $this->response->setJSON(['result' => 'NO', 'msg' => '로그인을 해주세요.']);
        }

        $result = $this->comment->reportComment($code, $r_idx, $r_cmt_idx, $report_reason, $m_idx);

        return $this->response->setJSON($result);
    }
}