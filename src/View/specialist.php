 <!-- 비주얼 영역 -->
 <div id="visual" class="sub">
    <div class="design-line"></div>
    <div class="design-line"></div>
    <!-- 이미지 -->
    <img src="./images/slides/2.jpg" alt="슬라이드 이미지" title="슬라이드 이미지">
    <!-- 콘텐츠 -->
    <div class="content">
        <div class="text-white text-center">
            <h1 class="font-weight-bold" style="font-size: 3.5em;">SPECIALIST</h1>
            <p class="text-gray mt-3">당신의 상상을 현실로 이뤄줄 전문가들이 모였습니다.</p>
        </div>
    </div>
</div>
<!-- /비주얼 영역 -->


<!-- 전문가 영역 -->
<div class="bg-gray">
    <div class="container padding">
        <div class="d-between flex-column flex-md-row align-items-start">
            <div>
                <div class="text-muted">전문가 목록</div>
                <div class="section-title">SPECIALIST</div>
            </div>
        </div>
        <hr class="mt-4 mb-5">
        <div class="row">
            <?php foreach($specialists as $sp ):?>
            <div class="col-lg-6 mb-5">
                <div class="special-item h-100 border">
                    <div class="image">
                        <img src="/upload/user-photo/<?=$sp->photo?>" title="전문가 이미지" alt="전문가 이미지" class="fit-cover">
                    </div>
                    <div class="info">
                        <div>
                            <div class="fx-n3 text-muted mt-2">전문가 소개</div>
                            <div class="fx-3 mt-1">
                                <strong><?=$sp->user_name?> </strong>
                                <span class="fx-n3 text-deepgold">(<?=$sp->user_id?>)</span>
                            </div>
                        </div>
                        <div class="d-between pb-2">
                            <div class="text-gold">
                                <small class="text-muted">평점</small>
                                <span class="text-deepgold ml-2">
                                    <?php  $score = $sp->score_cnt > 0 ? floor($sp->score_total / $sp->score_cnt) : 0;
                                    for($i = 0; $i < $score; $i++): ?>
                                        <i class="fa fa-star text-gold"></i>
                                    <?php endfor;?>
                                    <?php if($i === 0): ?>
                                        <i class="fa fa-star-o text-gold"></i>
                                    <?php endif;?>
                                    <?=$score?>
                                </span>
                            </div>
                            <button class="black-btn px-3" data-id="<?=$sp->id?>" data-toggle="modal" data-target="#review-modal">시공 후기작성</button>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<!-- /전문가 영역 -->

<!-- 전문가 후기 영역 -->
<div class="container padding">
    <div class="sticky-top bg-white">
        <div class="py-3">
            <div class="text-muted">전문가 시공 후기</div>
            <div class="section-title">REVIEW</div>
        </div>
        <div class="table-head">
            <div class="cell-50">리뷰 정보</div>
            <div class="cell-15">작성자</div>
            <div class="cell-15">가격</div>
            <div class="cell-20">평점</div>
        </div>
    </div>
    <div class="review-list">
        <?php foreach($reviews as $review): ?>
        <div class="table-row">
            <div class="cell-50">
                <div class="text-left px-4 d-flex align-items-center">
                    <img class="table-image" src="/upload/user-photo/<?=$review->s_photo?>" alt="전문가 이미지" title="전문가 이미지" style="width: 100px; height: 100px;">
                    <div class="ml-4 py-2">
                        <div class="fx-2">
                            <?=$review->s_name?>
                            <small class="text-deepgold">(<?=$review->s_id?>)</small>
                        </div>
                        <p class="mt-2 text-muted"><?=nl2br(htmlentities($review->content))?></p>
                    </div>
                </div>
            </div>
            <div class="cell-15">
                <span><?=$review->user_name?>(<?=$review->user_id?>)</span>
            </div>
            <div class="cell-15">
                <span>￦ <?=number_format($review->price)?></span>
            </div>
            <div class="cell-20">
                <div class="text-gold">
                    <?php for($i=0; $i < $review->score; $i++):?>
                        <i class="fa fa-star"></i>
                    <?php endfor;?>
                    <?php for(;$i<5;$i++):?>
                        <i class="fa fa-star-o"></i>
                    <?php endfor;?>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<!-- /전문가 후기 영역 -->


<!-- 시공 후기 작성 -->
<div id="review-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="/specialist/reviews" method="post" class="modal-content">
            <input type="hidden" id="sid" name="sid">
            <div class="modal-header">
                <strong class="fx-3 text-deepgold">후기 작성</strong>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="price">시공 비용</label>
                    <input type="text" name="price" id="price" class="form-control" placeholder="비용을 입력해 주세요">
                </div>
                <div class="form-group">
                    <label for="score">평점</label>
                    <select name="score" id="score" class="form-control">
                        <option value="1">1점</option>
                        <option value="2">2점</option>
                        <option value="3">3점</option>
                        <option value="4">4점</option>
                        <option value="5">5점</option>
                    </select>
                </div>
                <div class="form-group">
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control" placeholder="시공 후기를 구체적으로 작성해 주세요"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <div class="text-right">
                    <button class="black-btn">작성 완료</button>
                </div>
            </div>
        </form>
    </div>
</div>  
<script>
    $(function(){
        $("button[data-target='#review-modal']").on("click", function(){
            let id = $(this).data('id');
            $("#sid").val(id);
        });
    });
</script>
<!-- /시공 후기 작성 -->