 <!-- 비주얼 영역 -->
<div id="visual" class="sub">
    <div class="design-line"></div>
    <div class="design-line"></div>
    <!-- 이미지 -->
    <img src="./images/slides/1.jpg" alt="슬라이드 이미지" title="슬라이드 이미지">
    <!-- 콘텐츠 -->
    <div class="content">
        <div class="text-white text-center">
            <h1 class="font-weight-bold" style="font-size: 3.5em;">STORE</h1>
            <p class="text-gray mt-3">다양한 인테리어로 당신의 공간을 채우세요</p>
        </div>
    </div>
</div>
<!-- /비주얼 영역 -->
<!-- 장바구니 -->
<div class="bg-gray">
    <div class="container padding">
        <div class="sticky-top bg-gray">
            <div class="py-3">
                <div class="text-muted">장바구니</div>
                <div class="section-title">CART</div>
            </div>
            <div class="table-head">
                <div class="cell-10">#</div>
                <div class="cell-40">상품 정보</div>
                <div class="cell-15">가격</div>
                <div class="cell-15">수량</div>
                <div class="cell-15">합계</div>
                <div class="cell-auto"></div>
            </div>
        </div>
        <div id="cart-box" class="list">
            
        </div>
        <div class="d-between mt-5">
            <div>
                <span class="text-black">총 합계</span>
                <span class="ml-3 text-muted">￦</span>
                <span class="ml-1 fx-5 total-price text-deepgold">0</span>
            </div>
            <button class="read-more buy-btn" data-toggle="modal" data-target="#buy-modal">
                구매하기
                <i class="fa fa-shopping-cart ml-2"></i>
            </button>
        </div>
    </div>
</div>
<!-- /장바구니 -->
<!-- 스토어 -->
<div class="container padding">
    <div class="sticky-top bg-white border-bottom border-black">
        <input type="checkbox" id="open-cart" checked hidden>
        <div class="d-between align-items-end py-2">
            <div class="py-3">
                <div class="text-muted">인테리어 쇼핑몰</div>
                <div class="section-title">STORE</div>
            </div>
            <div class="d-flex">
                <label for="open-cart" class="mr-4 text-gold">
                    <i class="fa fa-shopping-cart fa-2x"></i>
                </label>
                <div class="search">
                    <span class="icon">
                        <i class="fa fa-search fa-sm"></i>
                    </span>
                    <input type="text" placeholder="검색어를 입력하세요" id="search-input">
                </div>
            </div>
        </div>
        <div class="drop-area">
            <div class="w-100 position-center text-white text-center">
                <i class="fa fa-shopping-cart fa-4x mt-3"></i>
                <p class="fx-n2 mt-3">이곳에 상품을 넣아주세요</p>
            </div>
        </div>
    </div>
    <div id="store-box" class="row mt-5">
        
    </div>
</div>
<!-- /스토어 -->

<!-- 구매 모달 -->
<div id="buy-modal" class="modal fade">
    <div class="modal-dialog">
        <form>
            <div class="modal-content">
                <div class="modal-header">
                    <span class="fx-3 text-deepgold">구매하기</span>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="user_name">구매자 명</label>
                        <input type="text" name="user_name" class="form-control" id="user_name" placeholder="구매자 명을 입력해 주세요">
                    </div>
                    <div class="form-group">
                        <label for="address">배송지 주소</label>
                        <input type="text" name="address" class="form-control" id="address" placeholder="주소를 입력해 주세요">
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="text-right">
                        <button class="black-btn">구매하기</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
<!-- /구매 모달 -->

<!-- 구매 내역 모달 -->
<div id="purchase-modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <img class="w-100" src="" alt="">
            </div>
        </div>
    </div>
</div>
<!-- /구매 내역 모달 -->