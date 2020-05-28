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

        $sql = "SELECT res.*, sid, start_date, content, user_id, user_name
                FROM responses res
                LEFT JOIN requests req ON res.qid = req.id
                LEFT JOIN users U on U.id = req.uid";
        $resList = DB::fetchAll($sql);


        $_myList = DB::fetchAll("SELECT qid FROM responses WHERE uid = ?", [user()->id]);
        $myList = [];
        foreach($_myList as $item) $myList[] = $item->qid;

        view("estimate", ["reqList" => $reqList, "resList" => $resList, "myList" => $myList]);
    }
    function writeRequest(){
        checkInput();
        extract($_POST);

        DB::query("INSERT INTO requests(uid, start_date, content) VALUES (?, ?, ?)", [user()->id, $start_date, $content]);
        go("/estimate", "요청이 완료되었습니다.");
    }
    function writeResponse(){
        checkInput();
        extract($_POST);

        $req = DB::find("requests", $qid);
        if(!$req) back("정확한 요청 대상을 선택해 주세요");
        if(!is_numeric($price) || $price < 0) back("정확한 금액을 입력해 주세요");

        DB::query("INSERT INTO responses(uid, qid, price) VALUES (?, ?, ?)", [user()->id, $qid, $price]);
        go("/estimate", "견적 보내기가 완료되었습니다.");
    }
    function getResponse(){
        if(!isset($_GET['qid']) || !$_GET['qid']) json_response("요청 아이디를 입력하세요", false);

        $qid = $_GET['qid'];
        $req = DB::find("requests", $qid);
        if(!$req) json_response("대상 요청을 찾을 수 없습니다", false);
        
        $resList = DB::fetchAll("SELECT R.*, user_name, user_id FROM responses R LEFT JOIN users U ON U.id = R.uid WHERE qid = ?", [$qid]);

        json_response("요청 성공", true, ['list' => $resList, "request" => $req]);
    }
    function pickEstimate(){
        checkInput('json');
        extract($_POST);

        $req = DB::find("requests", $qid);
        $res = DB::find("responses", $sid);

        if(!$req || !$res) json_response("올바른 데이터를 입력해 주세요", false);

        DB::query("UPDATE requests SET sid = ? WHERE id = ?", [$sid, $qid]);
        DB::query("UPDATE responses SET selected = 1 WHERE id = ?", [$sid]);
        json_response("선택되었습니다.");
    }
}