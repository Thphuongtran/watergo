<div id="app">
  <div v-if='!loading' class="create-product-page">
    <?php get_template_part('pages/business/components/detailBar') ?>
    <div>
      <form action="#" class="product-form" v-on:submit.prevent>
        <div>
          <label>Category</label>
          <div
            class="select-input higher-element"
            @click='handleShowCategorySelection'
          >
            <input
              type="text"
              disabled
              placeholder="Select Category"
              :value='categorySelected ? categorySelected: ""'
            />
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" fill="none">
              <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class='select-item'>
              <div
                v-if="isOpenSelectCategorySelection"
                v-for="(item, index) in categories"
                aria-haspopup="true"
                @click='handleSelectCategory(item.label)'
              >
                {{item.label}}
              </div>
            </div>
          </div>
        </div>
        <div>
          <label>Brand</label>
          <div
            class="select-input lower-element"
            @click='handleShowBrandSelection'
          >
            <input
              type="text"
              disabled
              placeholder="Select Brand"
              :value='brandSelected ? brandSelected: ""'
            />
            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" fill="none">
              <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <div class='select-item'>
              <div
                v-if="isOpenSelectBrandSelection"
                v-for="(item, index) in brands"
                aria-haspopup="true"
                @click='handleSelectBrand(item.label)'
              >
                {{item.label}}
              </div>
            </div>
          </div>
        </div>
        <div class='price-stock-input'>
          <div>
            <label>Price</label>
            <input type="text" placeholder='0đ' :value='price ? price : ""' />
          </div>
          <div>
            <label>Stock</label>
            <input type="text" placeholder='0' :value='stock ? stock : ""' />
          </div>
        </div>
        <div class='discount-input'>
          <div class='discount-checkbox'>
            <label :class='isCheckDiscount ? "active" : ""'>
              <svg v-if='isCheckDiscount' xmlns="http://www.w3.org/2000/svg" width="21" height="16" viewBox="0 0 21 16" fill="none">
                <path d="M19.4211 1L6.75658 15L1 8.63636" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <input type="checkbox" @click='handleCheckDiscount' />
            </label>
            <span>Discount</span>
          </div>
          <div
            v-if='isCheckDiscount'
          >
            <label>Percentage Discount</label>
            <input type="text" placeholder='Enter Percentage' :value='discountPercent ? discountPercent : ""' />
          </div>
          <div
            v-if='isCheckDiscount'
            class='discount-date-section'
          >
            <div>
              <label>From</label>
              <input type="text" placeholder='dd/mm/yyyy' :value='discountStartDate ? discountStartDate : ""' />
            </div>
            <div>
            <label>To</label>
              <input type="text" placeholder='dd/mm/yyyy' :value='discountEndDate ? discountEndDate : ""' />
            </div>
          </div>
        </div>
        <div class='size-input-section'>
          <label>Size Description</label>
          <div>
            <label>Quantity</label>
            <div
              class="select-input higher-element"
              @click='handleShowQuantitySelection'
            >
              <input
                type="text"
                disabled
                placeholder="Select Quantity"
                :value='quantitySelected ? quantitySelected: ""'
              />
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" fill="none">
                <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <div class='select-item'>
                <div
                  v-if="isOpenSelectQuantitySelection"
                  v-for="(item, index) in quantityData"
                  aria-haspopup="true"
                  @click='handleSelectQuantity(item.label)'
                >
                  {{item.label}}
                </div>
              </div>
            </div>
          </div>
          <div>
            <label>Water Volume</label>
            <div
              class="select-input lower-element"
              @click='handleShowVolumeSelection'
            >
              <input
                type="text"
                disabled
                placeholder="Select Volume"
                :value='volumeSelected ? volumeSelected: ""'
              />
              <svg xmlns="http://www.w3.org/2000/svg" width="12" height="7" viewBox="0 0 12 7" fill="none">
                <path d="M1 1L6 6L11 1" stroke="#252831" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <div class='select-item'>
                <div
                  v-if="isOpenSelectVolumeSelection"
                  v-for="(item, index) in volumeData"
                  @click='handleSelectVolume(item.label)'
                >
                  {{item.label}}
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class='description-section'>
          <label>Product Description</label>
          <textarea placeholder="Enter Product Description"></textarea>
        </div>
        <div class='photo-section'>
          <label>Photo</label>
          <div class='upload-image'>
            <label>
              <input type="file" v-on:change='handleUploadImage' multiple />
                <svg xmlns="http://www.w3.org/2000/svg" width="104" height="107" viewBox="0 0 104 107" fill="none">
                  <rect x="1" y="1" width="102" height="105" rx="4" fill="white" stroke="#2790F9" stroke-width="2" stroke-dasharray="20 20"/>
                </svg>
            </label>
            <div
              v-if='imageUpload.length > 0'
              class='carousel-preview-image'
            >
              <div
                v-for='(item, index) in imageUpload'
                class='preview-image'
              >
                <span @click='handleRemoveImage(item)'>
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                    <rect width="16" height="16" rx="2" fill="white" fill-opacity="0.7"/>
                    <path d="M12 4L4 12" stroke="#515151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                    <path d="M4 4L12 12" stroke="#515151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                </span>
                <img v-bind:src="item.url" alt="image uploaded">
              </div>
            </div>
          </div>
        </div>
        <div class='discount-input' v-if='productId'>
          <div class='discount-checkbox'>
            <label :class='isOutOfStock ? "active" : ""'>
              <svg v-if='isCheckDiscount' xmlns="http://www.w3.org/2000/svg" width="21" height="16" viewBox="0 0 21 16" fill="none">
                <path d="M19.4211 1L6.75658 15L1 8.63636" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
              <input type="checkbox" @click='handleCheckOutOfStock' />
            </label>
            <span>Mark as out of stock</span>
          </div>
        </div>
        <div class='btn-submit'>
          <button
            v-text='productId ? "Save" : "Add"'
          ></button>
          <button
            v-if='productId'
            v-on:click.self='handleShowConfirmDeleteModel'
          >
            Delete
          </button>
        </div>
      </form>
    </div>

    <!-- overlay popup -->
    <div
      v-if='isOpenConfirmDeleteModel'
      class='overlay-popup'
      @click='handleShowConfirmDeleteModel'
    >
      <div class='confirm-model'>
        <p>Do you want to delete this product?</p>
        <div>
          <button @click='handleShowConfirmDeleteModel'>Cancel</button>
          <button>Confirm</button>
        </div>
      </div>
    </div>
    <!-- end overlay popup -->
  </div>

  <div v-if='loading'>
    <div class='progress-center'>
      <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
    </div>
  </div>
</div>
<script type='module'>
  var { createApp } = Vue;

  createApp({
    setup() {

    },
    data() {
      return {
        loading: false,
        detailBarTitle: "Add Water Product",
        categorySelected: "",
        isOpenSelectCategorySelection: false,
        brandSelected: "",
        isOpenSelectBrandSelection: false,
        quantitySelected: "",
        isOpenSelectQuantitySelection: false,
        volumeSelected: "",
        discountPercent: 0,
        discountStartDate: "",
        discountEndDate: "",
        price: 0,
        stock: 0,
        isOpenSelectVolumeSelection: false,
        isCheckDiscount: false,
        isOutOfStock: false,
        categories: [
          {
            label: "Bình Vòi",
            value: "Bình Vòi",
          },
          {
            label: "Bình Úp",
            value: "Bình Úp",
          },
          {
            label: "Bình 5L",
            value: "Bình 5L",
          },
          {
            label: "Nước Chai",
            value: "Nước Chai",
          },
        ],
        brands: [
          {
            label: "Aquafina",
            value: "Aquafina",
          },
          {
            label: "Lavie",
            value: "Lavie",
          },
          {
            label: "Brand 3",
            value: "Brand 3",
          },
          {
            label: "Brand 4",
            value: "Brand 4",
          },
        ],
        quantityData: [
          {
            label: "1 Chai",
            value: "1 Chai",
          },
          {
            label: "1 Bình",
            value: "1 Bình",
          },
          {
            label: "Lốc 12 chai",
            value: "Lốc 12 chai",
          },
          {
            label: "Thùng 24 chai",
            value: "Thùng 24 chai",
          },
        ],
        volumeData: [
          {
            label: "350 ml",
            value: "350 ml",
          },
          {
            label: "500 ml",
            value: "500 ml",
          },
          {
            label: "5L",
            value: "5L",
          },
          {
            label: "15L",
            value: "15L",
          },
        ],
        imageUpload: [],
        productId: 0,
        isOpenConfirmDeleteModel: false,
      };
    },
    methods: {
      goBack() {
        window.goBack();
      },
      handleShowCategorySelection() {
        this.isOpenSelectCategorySelection = !this.isOpenSelectCategorySelection;
      },
      handleShowBrandSelection() {
        this.isOpenSelectBrandSelection = !this.isOpenSelectBrandSelection;
      },
      handleShowQuantitySelection() {
        this.isOpenSelectQuantitySelection = !this.isOpenSelectQuantitySelection;
      },
      handleShowVolumeSelection() {
        this.isOpenSelectVolumeSelection = !this.isOpenSelectVolumeSelection;
      },
      handleSelectCategory(category) {
        this.categorySelected = category;
      },
      handleSelectBrand(brand) {
        this.brandSelected = brand;
      },
      handleSelectQuantity(quantity) {
        this.quantitySelected = quantity;
      },
      handleSelectVolume(volume) {
        this.volumeSelected = volume;
      },
      handleCheckDiscount() {
        this.isCheckDiscount = !this.isCheckDiscount;
      },
      handleUploadImage(event) {
        for (const item in event.target.files) {
          const isFile = event.target.files[item] instanceof File;
          if (isFile) {
            this.imageUpload.push({
              code: "",
              url: window.webkitURL.createObjectURL(event.target.files[item]),
            })
          }
        }
      },
      handleRemoveImage(image) {
        const index = this.imageUpload.indexOf(image);
        if (index > -1) {
          this.imageUpload.splice(index, 1);
        }
      },
      handleCheckOutOfStock() {
        this.isOutOfStock = !this.isOutOfStock;
      },
      handleShowConfirmDeleteModel() {
        this.isOpenConfirmDeleteModel = !this.isOpenConfirmDeleteModel;
      },
      handleClickTest(event) {
        event.preventDefault();
        console.log("haha");
      }
    },
    computed: {},
    async created() {
      this.loading = true;
      const url = new URLSearchParams(window.location.href);
      const productId = url.get("product_id");
      if (productId) {
        const productData = {
          id: 1,
          productName: "Product 1",
          description: "Thùng 24 chai 1L",
          category: "Bình 5L",
          brand: "Brand 3",
          quantity: "Thùng 24 chai",
          volume: "5L",
          price: 2000,
          stock: 50,
          isOutStock: false,
          discount: {
            percent: 20,
            startDate: '2023-07-05T06:58:23.125Z',
            endDate: '2023-07-15T06:58:23.125Z',
          },
          state: "Available",
          image: [
            {
              url: "https://i.redd.it/buzm78njzl8b1.jpg",
            },
            {
              url: "https://vmoba.com/images/source/linh-thu-dtcl/ahri-chibi-dtcl-mua-8.jpg",
            },
          ]
        };
        this.productId = productData.id;
        this.detailBarTitle = productData.productName;
        this.categorySelected = productData.category;
        this.brandSelected = productData.brand;
        this.quantitySelected = productData.quantity;
        this.volumeSelected = productData.volume;
        if (productData.discount) {
          this.isCheckDiscount = true;
          this.discountPercent = productData.discount.percent;
          this.discountStartDate = window.formatDate(productData.discount.startDate);
          this.discountEndDate = window.formatDate(productData.discount.endDate);
        }
        
        this.imageUpload = [...productData.image];
        this.weightSelected = "2 kg";
        this.price = productData.price;
        this.stock = productData.stock;
        this.isOutOfStock = productData.isOutStock;
      }
      this.loading = false;
    },
  }).mount('#app');
</script>