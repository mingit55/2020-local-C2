 <!-- 비주얼 영역 -->
 <div id="visual" class="sub">
    <div class="design-line"></div>
    <div class="design-line"></div>
    <!-- 이미지 -->
    <img src="./images/slides/3.jpg" alt="슬라이드 이미지" title="슬라이드 이미지">
    <!-- 콘텐츠 -->
    <div class="content">
        <div class="text-white text-center">
            <h1 class="font-weight-bold" style="font-size: 3.5em;">ESTIMATE</h1>
            <p class="text-gray mt-3">전문적인 인력들과 함께 시공 견적을 확인하세요.</p>
        </div>
    </div>
</div>
<!-- /비주얼 영역 -->

<!-- 시공 견적 요청 -->
<div class="bg-gray">
    <div class="container padding">
        <div class="sticky-top bg-gray">
            <div class="d-between flex-column flex-md-row align-items-start">
                <div>
                    <div class="text-muted">시공 견적 요청</div>
                    <div class="section-title">REQUEST</div>
                </div>
                <button class="read-more mt-4 mt-md-none" data-toggle="modal" data-target="#request-modal">
                    견적 요청
                    <i class="fa fa-angle-right ml-2"></i>
                </button>
            </div>
            <div class="table-head mt-4">
                <div class="cell-10">상태</div>
                <div class="cell-40">내용 </div>
                <div class="cell-15">회원 정보</div>
                <div class="cell-15">시공일</div>
                <div class="cell-10">견적 개수</div>
                <div class="cell-10">+</div>
            </div>
        </div>
        <div class="list">
            <?php foreach($reqList as $req):?>
                <div class="table-row">
                    <div class="cell-10">
                        <?php if($req->sid): ?>
                            <span class="fx-n1 bg-gold px-3 py-2 round text-white">완료</span>
                        <?php else: ?>
                            <span class="fx-n1 bg-gold px-3 py-2 round text-white">진행 중</span>
                        <?php endif;?>
                    </div>
                    <div class="cell-40">
                        <p class="mb-0"><?=nl2br(htmlentities($req->content))?></p>
                    </div>
                    <div class="cell-15">
                        <span><?=$req->user_name?></span>
                        <span class="text-deepgold fx-n3">(<?=$req->user_id?>)</span>
                    </div>
                    <div class="cell-15">
                        <span class="fx-n2"><?=date("Y년 m월 d일", strtotime($req->start_date))?></span>
                    </div>
                    <div class="cell-10">
                        <span><?=number_format($req->cnt)?></span>
                    </div>
                    <div class="cell-10">
                        <?php if($req->sid == null && user()->type == 'SPECIALIST' && array_search($req->id, $myList) === false):?>
                        <button class="black-btn px-2" data-toggle="modal" data-target="#response-modal" data-id="<?=$req->id?>">
                            견적 보내기
                        </button>
                        <?php elseif(user()->id  === $req->uid): ?>
                        <button class="black-btn px-2" data-toggle="modal" data-target="#view-modal" data-id="<?=$req->id?>">
                            견적 보기
                        </button>
                        <?php endif;?>
                        
                    </div>
                </div>
            <?php endforeach;?>
        </div>
    </div>
</div>
<!-- /시공 견적 요청 -->

<!-- 보낸 견적 리스트 -->
<?php if(user() && user()->type === 'SPECIALIST') : ?>
<div class="container padding">
    <div class="sticky-top bg-white">
        <div>
            <div class="text-muted">보낸 견적</div>
            <div class="section-title">RESPONSE</div>
        </div>
        <div class="table-head mt-4">
            <div class="cell-10">선택 여부</div>
            <div class="cell-40">내용</div>
            <div class="cell-15">회원 정보</div>
            <div class="cell-15">시공일</div>
            <div class="cell-10">입력한 비용</div>
            <div class="cell-10">+</div>
        </div>
    </div>
    <div class="list">
        <?php foreach($resList as $res):?>
            <div class="table-row">
                <div class="cell-10">
                    <?php if($res->selected):?>
                        <span class="fx-n1 bg-gold px-3 py-2 round text-white">선택</span>    
                    <?php elseif($res->sid && !$res->selected):?>
                        <span class="fx-n1 bg-gold px-3 py-2 round text-white">미선택</span>
                    <?php else: ?>    
                        <span class="fx-n1 bg-gold px-3 py-2 round text-white">진행 중</span>
                    <?php endif;?>
                </div>
                <div class="cell-40">
                    <p class="mb-0"><?=$res->content?></p>
                </div>
                <div class="cell-15">
                    <span><?=$res->user_name?></span>
                    <span class="text-deepgold fx-n3">(<?=$res->user_id?>)</span>
                </div>
                <div class="cell-15">
                    <span class="fx-n2"><?=date("Y년 m월 d일", strtotime($res->start_date))?></span>
                </div>
                <div class="cell-10">
                    <small class="text-muted">￦</small>
                    <span class="fx-2 text-deepgold"><?=number_format($res->price)?></span>
                </div>
                <div class="cell-10">
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
<?php endif;?>
<!-- /보낸 견적 리스트 -->

<!-- 견적 요청 모달 -->
<div id="request-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="/estimate/requests" method="post" class="modal-content">
            <div class="modal-header">
                <strong class="fx-3 text-deepgold">견적 요청</strong>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="start_date">시공일</label>
                    <input type="date" id="start_date" class="form-control" name="start_date">
                </div>
                <div class="form-group">
                    <label for="content">내용</label>
                    <textarea name="content" id="content" cols="30" rows="10" class="form-control" placeholder="요청할 사항을 구체적으로 작성해 주세요"></textarea>
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
<!-- /견적 요청 모달 -->

<!-- 견적 보내기 -->
<div id="response-modal" class="modal fade">
    <div class="modal-dialog">
        <form action="/estimate/responses" method="post">
            <input type="hidden" name="qid">
            <div class="modal-content">
                <div class="modal-header">
                    <strong class="fx-3 text-deepgold">견적 보내기</strong>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="price">시공 비용</label>
                        <input type="text" id="price" class="form-control" name="price" placeholder="비용을 입력하세요">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-right">
                        <button class="black-btn">입력 완료</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $(function(){
        $("button[data-target='#response-modal']").on("click", function(){
            let id = $(this).data("id");
            $("#response-modal input[name='qid']").val(id);
        });
    });
</script>
<!-- /견적 보내기 -->


<!-- 견적 보기 -->
<div id="view-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center py-3">
                    <strong class="fx-3 text-deepgold">받은 견적 목록</strong>
                </div>
                <div class="table-head">
                    <div class="cell-40">
                        수주자
                    </div>
                    <div class="cell-40">수주 금액</div>
                    <div class="cell-20">+</div>
                </div>
                <div class="list">
                    
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        let qid;
        $("button[data-target='#view-modal']").on("click", function(){
            qid = $(this).data("id");

            $.getJSON("/estimate/responses?qid=" + qid, function(res){
                let {request, list} = res;

                $("#view-modal .list").html("");
                list.forEach(item => {
                    let elem = $(`<div class="table-row">
                                    <div class="cell-40">
                                        ${item.user_name}(${item.user_id})
                                    </div>
                                    <div class="cell-40">
                                        <small class="text-muted">￦</small>
                                        <span class="fx-2 text-deepgold">${parseInt(item.price).toLocaleString()}</span>
                                    </div>
                                    <div class="cell-20">
                                        ${
                                            !request.sid ?
                                            `<button class="black-btn" data-id="${item.id}">선택</button>`
                                            : ""
                                        }
                                    </div>
                                </div>`);
                    $("#view-modal .list").append(elem);
                }); 
            });
        });

        $("#view-modal .list").on("click", "button", function(){
            let sid = this.dataset.id;
            $.post("/estimate/pick", {qid, sid}, function(res){
                console.log(res);
                alert(res.message);
                if(res.result){
                    location.reload();
                }
            });
        });
    });
</script>
<!-- /견적 보기 -->