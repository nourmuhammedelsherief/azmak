<div class="show_meals bg-white p-3">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button
                class="nav-link active"
                id="home-tab"
                data-bs-toggle="tab"
                data-bs-target="#home"
                type="button"
                role="tab"
                aria-controls="home"
                aria-selected="true"
            >
                <i class="fas fa-th-large"></i>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button
                class="nav-link"
                id="profile-tab"
                data-bs-toggle="tab"
                data-bs-target="#profile"
                type="button"
                role="tab"
                aria-controls="profile"
                aria-selected="false"
            >
                <i class="fa-solid fa-image"></i>
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button
                class="nav-link"
                id="contact-tab"
                data-bs-toggle="tab"
                data-bs-target="#contact"
                type="button"
                role="tab"
                aria-controls="contact"
                aria-selected="false"
            >
                <i class="fa-solid fa-list"></i>
            </button>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div
            class="tab-pane fade show active"
            id="home"
            role="tabpanel"
            aria-labelledby="home-tab"
        >
            <div class="row mt-3">
                <div class="col-6">
                    <div class="list_Galler p-2" id="product1">
                        <div class="image">
                            <a href='/productdetails'>
                                <img src="{{asset('site/image/meal3.jpg')}}" alt="" />
                            </a>
                        </div>
                        <div class="content_list p-2">
                            <h3><a href='/productdetails'> اسم الوجبة</a></h3>
                            <p><a href='/productdetails'> وصف الوجبة </a></p>
                            <div
                                class="more_details d-flex align-items-center justify-content-between"
                            >
                                <div class="action">
                                    <button
                                        id="addToCartBtn"
                                        class="cart-btn"
                                        data-product-id="product1"
                                    >
                                        <a href='/productdetails'>
                                            <i class="fa-solid fa-cart-plus"></i>
                                        </a>
                                    </button>
                                    <i class="fa-solid fa-share-nodes"></i>
                                </div>
                                <div class="price">
                                    <span>50</span>
                                    <small> ر.س</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end home-tab -->
        <div
            class="tab-pane fade"
            id="profile"
            role="tabpanel"
            aria-labelledby="profile-tab"
        >
            <div class="list_Gallery mt-3">
                <div class="image">
                    <a href='/productdetails'>
                        <img src="{{asset('site/image/cover1.jpg')}}" alt="" />
                    </a>
                </div>
                <div class="content_list p-2">
                    <h3><a href='/productdetails'> اسم الوجبة</a></h3>
                    <p><a href='/productdetails'> وصف الوجبة </a></p>
                    <div
                        class="more_details d-flex align-items-center justify-content-between"
                    >
                        <div class="action">
                            <a href='/productdetails'>
                                <i class="fa-solid fa-cart-plus"></i>
                            </a>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                        <div class="price">
                            <span>40</span>
                            <small> ر.س</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list_Gallery mt-3">
                <div class="image">
                    <a href='/productdetails'>
                        <img src="{{asset('site/image/cover1.jpg')}}" alt="" />
                    </a>
                </div>
                <div class="content_list p-2">
                    <h3><a href='/productdetails'> اسم الوجبة</a></h3>
                    <p><a href='/productdetails'> وصف الوجبة </a></p>
                    <div
                        class="more_details d-flex align-items-center justify-content-between"
                    >
                        <div class="action">
                            <a href='/productdetails'>
                                <i class="fa-solid fa-cart-plus"></i>
                            </a>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                        <div class="price">
                            <span>40</span>
                            <small> ر.س</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- profile-tab -->
        <div
            class="tab-pane fade"
            id="contact"
            role="tabpanel"
            aria-labelledby="contact-tab"
        >
            <div class="list mt-3 d-flex align-items-center gap-2">
                <div class="image">
                    <a href='/productdetails'>
                        <img src="./image/drink.jpg" alt="" />
                    </a>
                </div>
                <div class="content_list p-2 w-100">
                    <h3><a href='/productdetails'> اسم الوجبة</a></h3>
                    <p><a href='/productdetails'> وصف الوجبة </a></p>
                    <div
                        class="more_details d-flex align-items-center justify-content-between"
                    >
                        <div class="action">
                            <a href='/productdetails'>
                                <i class="fa-solid fa-cart-plus"></i>
                            </a>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                        <div class="price">
                            <span>40</span>
                            <small> ر.س</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="list mt-3 d-flex align-items-center gap-2">
                <div class="image">
                    <a href='/productdetails'>
                        <img src="./image/drink.jpg" alt="" />
                    </a>
                </div>
                <div class="content_list p-2 w-100">
                    <h3><a href='/productdetails'> اسم الوجبة</a></h3>
                    <p><a href='/productdetails'> وصف الوجبة </a></p>
                    <div
                        class="more_details d-flex align-items-center justify-content-between"
                    >
                        <div class="action">
                            <a href='/productdetails'>
                                <i class="fa-solid fa-cart-plus"></i>
                            </a>
                            <i class="fa-solid fa-share-nodes"></i>
                        </div>
                        <div class="price">
                            <span>40</span>
                            <small> ر.س</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
