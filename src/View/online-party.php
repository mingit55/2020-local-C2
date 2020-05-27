 <!-- 비주얼 영역 -->
<div id="visual" class="sub">
    <div class="design-line"></div>
    <div class="design-line"></div>
    <!-- 이미지 -->
    <img src="./images/slides/2.jpg" alt="슬라이드 이미지" title="슬라이드 이미지">
    <!-- 콘텐츠 -->
    <div class="content">
        <div class="text-white text-center">
            <h1 class="font-weight-bold" style="font-size: 3.5em;">ONLINE PARTY</h1>
            <p class="text-gray mt-3">자신만의 인테리어를 모두에게 공유해 보세요</p>
        </div>
    </div>
</div>
<!-- /비주얼 영역 -->

<!-- 온라인 집들이 -->
<div class="container padding">
    <div class="d-between flex-column flex-md-row align-items-start">
        <div>
            <div class="text-muted">온라인 집들이</div>
            <div class="fx-7 segoe font-weight-bold">KNOWHOWS</div>
        </div>
        <button class="read-more mt-4 mt-md-none" data-toggle="modal" data-target="#write-modal">
            글쓰기
            <i class="fa fa-pencil ml-2"></i>
        </button>
    </div>
    <hr class="mt-4 mb-5">
    <div class="row">
        <?php foreach($knowhows as $knowhow) :?>
        <div class="col-lg-4 col-md-6 mb-5">
            <div id="knowhow-item-<?=$knowhow->id?>" class="knowhow-item border h-100">
                <div class="image">
                    <img src="/upload/knowhows/<?=$knowhow->img_before?>" alt="Before" title="Before" class="before">
                    <img src="/upload/knowhows/<?=$knowhow->img_after?>" alt="After" title="After" class="after">
                </div>
                <div class="mt-3 px-4 py-1">
                    <div class="d-between">
                        <div>
                            <span><?=$knowhow->user_name?></span>
                            <small class="text-muted">(<?=$knowhow->user_id?>)</small>
                            <small class="text-muted ml-1"><?=date("Y년 m월 d일", strtotime($knowhow->created_at))?></small>
                        </div>
                        <div class="text-gold fx-2">
                            <i class="fa fa-star"></i>
                            <span class="score"><?=$knowhow->score_cnt > 0 ? floor($knowhow->score_total / $knowhow->score_cnt) : 0?></span>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-3">
                        <p class="text-muted"><?=nl2br(htmlentities($knowhow->content))?></p>
                    </div>
                    <?php if(array_search($knowhow->id, $myList) === false):?>
                    <div class="mb-3 d-between">
                        <small class="text-muted">이 인테리어의 점수는?</small>
                        <button class="black-btn" data-toggle="modal" data-target="#score-modal" data-id="<?=$knowhow->id?>">평점주기</button>
                    </div>
                    <?php endif;?>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<!-- /온라인 집들이 -->

<!-- 글쓰기 모달 -->
<div id="write-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="/online-party/knowhows" method="post" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="fx-3 text-deepgold">집들이 글쓰기</strong>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="img_before">Before 이미지</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="img_before" name="img_before">
                            <label for="img_before" class="custom-file-label">이미지를 업로드하세요</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="img_after">After 이미지</label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="img_after" name="img_after">
                            <label for="img_after" class="custom-file-label">이미지를 업로드하세요</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="content">노하우</label>
                        <textarea name="content" id="content" cols="30" rows="10" class="form-control" placeholder="당신만의 노하우를 공유해 보세요!"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="black-btn">작성 완료</button>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /글쓰기 모달 -->

<!-- 평점 주기 -->
<div id="score-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body py-4">
                <div class="text-center">
                    <small class="text-muted">이 게시글의 평점을 매겨주세요!</small>
                </div>
                <div class="mt-3 d-flex justify-content-center">
                    <button class="score-btn white-btn mx-1"><span class="text-gold"><i class="fa fa-star"></i> 1</span></button>
                    <button class="score-btn white-btn mx-1"><span class="text-gold"><i class="fa fa-star"></i> 2</span></button>
                    <button class="score-btn white-btn mx-1"><span class="text-gold"><i class="fa fa-star"></i> 3</span></button>
                    <button class="score-btn white-btn mx-1"><span class="text-gold"><i class="fa fa-star"></i> 4</span></button>
                    <button class="score-btn white-btn mx-1"><span class="text-gold"><i class="fa fa-star"></i> 5</span></button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        let knowhow_id;
        $("button[data-target='#score-modal']").on("click", function(){
            knowhow_id = $(this).data("id");
        });

        $(".score-btn").each(function(idx){
            let score = idx + 1;
            $(this).on("click", () => {
                if(!knowhow_id) return;

                $.post("/online-party/scores", {score, knowhow_id}, (res) => {
                    let $knowhowItem = $("#knowhow-item-" + knowhow_id);
                    $knowhowItem.find(".score").text(res.score);
                    $knowhowItem.find(".black-btn").parent().remove();
                    $("#score-modal").modal('hide');
                });
            });
        });
    });
</script>
<!-- .평점 주기 -->