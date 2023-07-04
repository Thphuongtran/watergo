<div id='app'>
  <div v-if='loading == false' class='product-page'>
    <?php get_template_part('pages/product/appBar') ?>
    <?php get_template_part('pages/product/filterBar') ?>
    <div style='height: 10px;'></div>
    <?php get_template_part('pages/product/searchBox') ?>
    <div class='action-bar'>
      <div class='filter-dropdown'>
        <button
          class='btn-filter active'
          @click='handleOpenFilterSelector'
        >
          <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.50197e-05 1.08889V0.252778V1.08889ZM1.50197e-05 1.08889C-0.000569119 1.17459 0.0158907 1.25955 0.0484373 1.33883M1.50197e-05 1.08889L0.0484373 1.33883M0.0484373 1.33883C0.0809839 1.41811 0.128968 1.49013 0.189598 1.55069M0.0484373 1.33883L0.189598 1.55069M0.189598 1.55069L6.02293 7.38403L0.189598 1.55069ZM6.55326 6.8537L0.750015 1.05045V0.75H14.8056V1.05531L9.01691 6.84398L8.79724 7.06365V7.37431V12.7887L6.77293 11.7808V7.38403V7.07337L6.55326 6.8537ZM0.719656 1.02009C0.719747 1.02018 0.719838 1.02027 0.719929 1.02036L0.719656 1.02009Z" fill="#2790F9" stroke="#2790F9" stroke-width="1.5"/>
          </svg>
          Filter
        </button>
        <div v-if='showFilterSelector' class='filter-selector'>
          <button
            v-for='(item, index) in actionBarFilter'
            :key='index'
            :class='item.active == true ? "active" : ""'
          >
            {{ item.label }}
          </button>
        </div>
      </div>
      <button class='add-new-btn active' @click="handleGoToAddNewProduct">Add new</button>
    </div>
    <div
      v-for='(item, index) in products'
      class='product-item-container'
      :key='index'
    >
      <!-- TODO: use dynamic image here -->
      <!-- <img :src="get_image_upload(item.image)" alt=""> -->
      <div class='product-image-container'>
        <span v-if='item.discountPercent > 0'>-{{item.discountPercent}}&percnt;</span>
        <img src='<?php echo THEME_URI . '/assets/images/demo-product01.png' ?>' />
      </div>
      <div class='product-item-content'>
        <h2>{{item.productName}}</h2>
        <h4>{{item.description}}</h4>
        <div class='product-item-price'>
          <div>
            <span class='product-discount'>
              {{setDiscountPrice(item.price, item.discountPercent)}}
            </span>
            <span v-if='item.discountPercent > 0' class='product-price'>{{setDiscountPrice(item.price)}}</span>
          </div>
          <button class="active">View</button>
        </div>
        <div class='product-item-state'>
          <div>
            <p>Sold:: <span>{{item.sold}}</span></p>
            <p>Stock: <span>{{item.stock}}</span></p>
          </div>
          <span class="state" :class='item.state === "Available" ? "state-available" : "state-outOfStock"'>{{item.state}}</span>
        </div>
      </div>
    </div>
  </div>


  <div v-if='loading == true'>
    <div class='progress-center'>
      <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
    </div>
  </div>
</div>
<script type='module'>
  var { createApp } = Vue;

  createApp({
    data() {
      return {
        loading: false,
        pageTitle: 'Product',
        message_count: 0,
        notification_count: 0,
        latitude: 10.780900239854994,
        longitude: 106.7226271387539,
        header_filter: [
          { label: 'Water', active: true, count: 0 },
          { label: 'Ice', active: false, count: 0 },
        ],
        searchBoxPlaceholder: "Search product",
        actionBarFilter: [
          { label: 'Out of Stock', active: true },
          { label: 'Available', active: false },
        ],
        showFilterSelector: false,
        products: [],
      };
    },
    methods: {
      get_current_location(){
        if(window.appBridge){
          window.appBridge.getLocation().then((data) => {
            if (Object.keys(data).length === 0) {
              alert("Error-1 :Không thể truy cập vị trí");
            }
            this.latitude = data.lat;
            this.longitude = data.lng;
          }).catch((e) => { alert(e); })
        }
      },
      gotoChat() {
        window.gotoChat();
      },
      gotoNotificationIndex() {
        window.gotoNotificationIndex();
      },
      select_header_filter(tabName) {
        this.header_filter.some((item) => {
          item.active = false;
          if (tabName === item.label) {
            item.active = true;
          }
        })
      },
      handleOpenFilterSelector() {
        this.showFilterSelector = !this.showFilterSelector
      },
      get_image_upload(image) {
        return window.get_image_upload(image)
      },
      setDiscountPrice(price, discountPercent = 0) {
        if (!discountPercent) {
          return window.priceFormat(price);
        } 
        return window.priceFormat(price - (price * discountPercent / 100));
      },
      handleGoToAddNewProduct() {
        console.log("haha");
        var productTabSelected = this.header_filter.find(function (item) {
          return item.active;
        });
        console.log("productTabSelected::", productTabSelected);

        if (productTabSelected && productTabSelected.label === "Water") {
          window.location.href = window.watergo_domain + "product?product_page=water";
          return;
        }
      },
    },
    computed: {},
    async created() {
      this.loading = true;
      this.get_current_location();
      this.products = [
        {
          productName: "Product 1",
          description: "Thùng 24 chai 1L",
          price: 250000,
          discountPercent: 20,
          sold: 50,
          stock: 2874,
          state: "Available",
          image: "/assets/images/demo-product01.png",
        },
        {
          productName: "Product 2",
          description: "Thùng 24 chai 1L",
          price: 250000,
          discountPercent: 0,
          sold: 50,
          stock: 0,
          state: "Out of Stock",
          image: "/assets/images/demo-product02.png",
        }
      ]
      this.loading = false;
    }
  }).mount('#app');
</script>