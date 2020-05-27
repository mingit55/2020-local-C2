<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>내집꾸미기</title>
    <script src="/js/jquery-3.4.1.min.js"></script>
    <link rel="stylesheet" href="/bootstrap-4.3.1-dist/css/bootstrap.min.css">
    <script src="/bootstrap-4.3.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/fontawesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="/css/style.css">
    <script>
        $(function(){
            $(".custom-file-input").on("change", function(){
                $(this).siblings(".custom-file-label").text(this.files[0].name);
            });
        });
    </script>
    <?= $import ?>
</head>
<body>
    <!-- 헤더 영역 -->
    <div id="header">
        <div class="container h-100">
            <div class="d-flex align-items-center justify-content-between h-100">
              <div class="left d-flex align-items-center">
                <a href="/">
                    <img src="/images/logo.svg" alt="내방꾸미기" title="내방꾸미기" height="50">
                </a>
                <div class="nav-area d-none d-lg-flex ml-5">
                    <a href="/">홈</a>
                    <a href="/online-party">온라인 집들이</a>
                    <a href="/online-store">스토어</a>
                    <a href="/specialist">전문가</a>
                    <a href="/estimate">시공 견적</a>
                </div>
              </div>
              <div class="right d-flex align-items-center">
                <div class="auth-area d-none d-lg-flex">
                    <?php if(!user()):?>
                        <a href="#" data-toggle="modal" data-target="#login-modal">로그인</a>
                        <a href="#" data-toggle="modal" data-target="#join-modal">회원가입</a>
                    <?php else: ?>
                        <span class="text-gold fx-n2"><?=user()->user_name?> 님</span>
                        <a href="/logout">로그아웃</a>
                    <?php endif;?>
                </div>
                <label class="menu-btn d-lg-none">
                    <span></span>
                    <span></span>
                    <span></span>
                </label>
                <div class="menu d-lg-none">
                    <div class="container">
                        <div class="d-flex flex-column">
                            <a href="/">홈</a>
                            <a href="/online-party">온라인 집들이</a>
                            <a href="/online-store">스토어</a>
                            <a href="/specialist">전문가</a>
                            <a href="/estimate">시공 견적</a>
                        </div>
                        <div class="fx-n3 mt-3">
                            <a href="#" data-toggle="modal" data-target="#login-modal">로그인</a>  
                            <a href="#" data-toggle="modal" data-target="#join-modal" class="ml-3">회원가입</a>
                        </div>
                    </div>
                </div>
              </div>
            </div>
        </div>
    </div>
    <!-- /헤더 영역 -->

    <!-- 로그인 모달 -->
    <div id="login-modal" class="modal fade">
        <div class="modal-dialog">
            <form action="/sign-in" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <strong class="fx-3 text-deepgold">로그인</strong>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>아이디</label>
                            <input type="text" class="form-control" name="user_id" placeholder="아이디를 입력하세요">
                        </div>
                        <div class="form-group">
                            <label>비밀번호</label>
                            <input type="password" class="form-control" name="password" placeholder="비밀번호를 입력하세요">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-right">
                            <button class="black-btn">로그인</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /로그인 모달 -->

    <!-- 회원가입 모달 -->
    <div id="join-modal" class="modal fade">
        <div class="modal-dialog">
            <form action="/sign-up" method="post" enctype="multipart/form-data">
                <div class="modal-content">
                    <div class="modal-header">
                        <strong class="fx-3 text-deepgold">회원가입</strong>            
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>아이디</label>
                            <input type="text" class="form-control" name="user_id" placeholder="아이디를 입력하세요">
                        </div>
                        <div class="form-group">
                            <label>비밀번호</label>
                            <input type="password" class="form-control" name="password" placeholder="비밀번호를 입력하세요">
                        </div>
                        <div class="form-group">
                            <label>이름</label>
                            <input type="text" class="form-control" name="user_name" placeholder="이름을 입력하세요">
                        </div>
                        <div class="form-group">
                            <label>사진</label>
                            <div class="custom-file">
                                <input type="file" id="user_photo" name="photo" class="custom-file-input">
                                <label for="user_photo" class="custom-file-label">파일을 업로드 하세요</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <img src="/sign-up/captcha" alt="캡챠 이미지" title="캡챠 이미지" class="w-100">
                            <input type="text" name="captcha" placeholder="위 문자를 입력해 주세요" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="text-right">
                            <button class="black-btn">가입하기</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /회원가입 모달 -->