<?php
namespace Controller;

use App\DB;

class UserController {
    function signIn(){
        checkInput();
        extract($_POST);
        
        $user = DB::who($user_id);
        if(!$user || $user->password !== hash('sha256', $password)) back("아이디 또는 비밀번호가 일치하지 않습니다.");
        
        $_SESSION['user'] = $user;
        go("/", "로그인 되었습니다.");
    }   

    function signUp(){
        checkInput();
        extract($_POST);

        if($captcha !== $_SESSION['captcha']){
            updateCaptcha();
            back("자동입력방지 문자를 잘못 입력하였습니다.");
        }
        
        $user = DB::who($user_id);
        if($user){
            updateCaptcha();
            back("중복되는 아이디입니다. 다른 아이디를 사용해주세요.");
        }

        // 파일 업로드
        $photo = $_FILES['photo'];
        $extName = substr($photo['name'], strrpos($photo['name'], '.'));
        $fileName = time() . $extName;
        $filePath = _PUB.DS."upload".DS."user-photo".DS.$fileName;
        move_uploaded_file($photo['tmp_name'], $filePath);

        DB::query("INSERT INTO users(user_id, password, user_name, photo) VALUES (?, ?, ?, ?)", [$user_id, hash('sha256', $password), $user_name, $fileName]);
        go("/", "회원가입 되었습니다.");
    }   

    function logout(){
        unset($_SESSION['user']);
        go("/", "로그아웃 되었습니다.");
    }

    // # 자동가입방지 문자
    function captchaImage(){
        updateCaptcha();
        $captcha = $_SESSION['captcha'];

        $textSize = 30;
        $width = 450;
        $height = 150;
        $fontFile = _PUB.DS."fonts" .DS. "NanumSquareB.ttf";
        $img = imagecreatetruecolor($width, $height);
        $backColor = imagecolorallocatealpha($img, 255, 255, 255, 0);
        $textColor = imagecolorallocate($img, 64, 64, 64);

        imagealphablending($img, true);
        imagefill($img, 0, 0, $backColor);

        imagettftext($img, $textSize, 0, $width / 2 - $textSize * 2.5, $height / 2, $textColor, $fontFile, $captcha);

        header("Content-Type: image/png");
        imagepng($img);
        imagedestroy($img);
    }


    // # 전문가 페이지
    function specialistPage(){
        $sql = "SELECT u.*, ifnull(score_total, 0) score_total, ifnull(score_cnt, 0) score_cnt
                FROM users U
                LEFT JOIN (SELECT SUM(score) score_total, COUNT(*) score_cnt, sid FROM user_scores GROUP BY sid) S ON S.sid = U.id
                WHERE type = 'SPECIALIST'";
        $specialists = DB::fetchAll($sql);


        $sql = "SELECT s.*, U1.user_id, U1.user_name, U1.photo, U2.user_id s_id, U2.user_name s_name, U2.photo s_photo
                FROM user_scores S
                LEFT JOIN users U1 ON U1.id = S.uid
                LEFT JOIN users U2 ON U2.id = S.sid";
        $reviews = DB::fetchAll($sql);

        $_myList = DB::fetchAll("SELECT sid FROM user_scores WHERE uid = ?", [user()->id]);
        $myList = [];
        foreach($_myList as $item) $myList[] = $item->sid;

        view("specialist", ["specialists" => $specialists, "reviews" => $reviews, "myList" => $myList], "<link rel='stylesheet' href='/css/specialist.css'></link>");
    }

    function writeReview(){
        checkInput();
        extract($_POST);

        $specialist = DB::find("users", $sid);
        if(!$specialist) back("해당 유저는 존재하지 않습니다.");
        if(!is_numeric($price) || $price < 0) back("시공 비용을 정확하게 입력해 주세요.");

        DB::query("INSERT INTO user_scores(uid, sid, score, price, content) VALUES (?, ?, ?, ?, ?)", [user()->id, $sid, $score, $price , $content]);
        go("/specialist", "리뷰가 작성되었습니다.");
    }

}