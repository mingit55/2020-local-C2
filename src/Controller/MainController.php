<?php
namespace Controller;

use App\DB;

class MainController {
    function indexPage(){
        view("index", [], "<link rel=\"stylesheet\" href=\"/css/index.css\">");   
    }
    function storePage(){
        $imports = "<link rel=\"stylesheet\" href=\"/css/store.css\">
                    <script src=\"js/Product.js\"></script>
                    <script src=\"js/App.js\"></script>
                    <script>
                        $(function(){
                            let app = new App();
                        });
                    </script>";

        view("store", [], $imports);
    }


    // # 온라인 집들이
    function partyPage(){
        $sql = "SELECT K.*, user_name, user_id, ifnull(score_total, 0) score_total, ifnull(score_cnt, 0) score_cnt
                FROM knowhows K
                LEFT JOIN users ON users.id = K.uid
                LEFT JOIN (SELECT SUM(score) score_total, COUNT(*) score_cnt, kid FROM knowhow_scores GROUP BY kid) S ON S.kid = K.id";
        $knowhows = DB::fetchAll($sql);

        $_myList = DB::fetchAll("SELECT kid FROM knowhow_scores WHERE uid = ?", [user()->id]); // 사용자가 별점을 준 노하우 목록
        $myList = [];
        foreach($_myList as $item)
            $myList[] = $item->kid;

        view("online-party", ["knowhows" => $knowhows, "myList" => $myList], "<link rel=\"stylesheet\" href=\"/css/index.css\">");
    }

    function writeKnowhow(){
        checkInput();
        extract($_POST);

        $img_before = $_FILES['img_before'];
        $img_after = $_FILES['img_after'];

        $now = time();
        $ext_before = substr($img_before['name'], strrpos($img_before['name'], "."));
        $ext_after = substr($img_after['name'], strrpos($img_after['name'], "."));
        $name_before = "before_" . $now . $ext_before;
        $name_after = "after_" . $now . $ext_after;

        $savePath = _PUB . DS. "upload" .DS ."knowhows";
        move_uploaded_file($img_before['tmp_name'], $savePath . DS . $name_before);
        move_uploaded_file($img_after['tmp_name'], $savePath . DS . $name_after);

        DB::query("INSERT INTO knowhows(img_before, img_after, uid, content) VALUES (?, ?, ?, ?)", [$name_before, $name_after, user()->id, $content]);
        
        go("/online-party", "글쓰기가 완료되었습니다.");
    }

    function scoreKnowhow(){
        checkInput("json");
        extract($_POST);
        
        $knowhow = DB::find("knowhows", $knowhow_id);
        if(!$knowhow) json_response("해당 글을 찾을 수 없습니다", false);
        if(!is_numeric($score) || $score < 1 || $score > 5) json_response("정확한 평점을 매겨주세요.", false);
        
        DB::query("INSERT INTO knowhow_scores(uid, kid, score) VALUES (?, ?, ?)", [user()->id, $knowhow->id, $score]);
        $result = DB::fetch("SELECT SUM(score) score_total, COUNT(*) score_cnt FROM knowhow_scores WHERE kid = ?", [$knowhow->id]);

        json_response(null, true, ["score" => ( floor($result->score_total / $result->score_cnt) )]);
    }


    // # 견적 페이지
    function estimatePage(){
        $sql = "SELECT req.*, res.cnt, U.user_name, U.user_id
                FROM requests req 
                LEFT JOIN (SELECT COUNT(*) cnt, qid FROM responses GROUP BY qid) res ON res.qid = req.id
                LEFT JOIN users U ON req.uid = U.id";
        $reqList = DB::fetchAll($sql);

        view("estimate", ["reqList" => $reqList]);
    }
    function writeRequest(){
        checkInput();
        extract($_POST);

        DB::query("INSERT INTO requests(uid, start_date, content) VALUES (?, ?, ?)", [user()->id, $start_date, $content]);
        go("/estimate", "요청이 완료되었습니다.");
    }
}