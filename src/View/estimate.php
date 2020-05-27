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
            <div class="table-row">
                <div class="cell-10">
                    <span class="fx-n1">진행 중</span>
                </div>
                <div class="cell-40">
                    <p>주방의 리모델링이 필요합니다.</p>
                </div>
                <div class="cell-15">
                    <span>유저1</span>
                    <span class="text-deepgold fx-n3">(user1)</span>
                </div>
                <div class="cell-15">
                    <span class="fx-n2">2020년 5월 27일</span>
                </div>
                <div class="cell-10">
                    <span>1</span>
                </div>
                <div class="cell-10">
                    <button class="black-btn px-2">
                        견적 보내기
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /시공 견적 요청 -->


<!-- 견적 요청 모달 -->
<div id="request-modal" class="modal fade">
    <div class="modal-dialog">
        <form class="modal-content">
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