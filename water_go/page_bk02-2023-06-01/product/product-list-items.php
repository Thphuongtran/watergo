<?php
   // PAGE LIST 2 MAIN PRODUCT
?>
<!-- PAGE WATER -->
<div v-if='navigator == "water"' class='page-home-water'>

   <div class='appbar'>

      <div class='leading'>

         <button @click='gotoHome' class='btn-action'>
            <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
            </svg>
         </button>

         <p class='leading-title'>Water</p>

      </div>
      <div class='action'>
         <div @click='buttonSortFeature' class='btn-text'>
            <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.50197e-05 1.08889V0.252778V1.08889ZM1.50197e-05 1.08889C-0.000569119 1.17459 0.0158907 1.25955 0.0484373 1.33883M1.50197e-05 1.08889L0.0484373 1.33883M0.0484373 1.33883C0.0809839 1.41811 0.128968 1.49013 0.189598 1.55069M0.0484373 1.33883L0.189598 1.55069M0.189598 1.55069L6.02293 7.38403L0.189598 1.55069ZM6.55326 6.8537L0.750015 1.05045V0.75H14.8056V1.05531L9.01691 6.84398L8.79724 7.06365V7.37431V12.7887L6.77293 11.7808V7.38403V7.07337L6.55326 6.8537ZM0.719656 1.02009C0.719747 1.02018 0.719838 1.02027 0.719929 1.02036L0.719656 1.02009Z" fill="#2040AF" stroke="#2040AF" stroke-width="1.5"/>
            </svg>
            <span class='text'>Sort</span>
         </div>
      </div>

   </div>


   <div v-if='sortFeatureOpen == true' class='box-sort' :class='sortFeatureOpen == true ? "active" : ""'>
      <ul>
         <li @click='buttonSortFeatureSelected(0)' :class='sortFeatureCurrentValue == 0 ? "active" : ""'>Nearest</li>
         <li @click='buttonSortFeatureSelected(1)' :class='sortFeatureCurrentValue == 1 ? "active" : ""'>Cheapest</li>
         <li @click='buttonSortFeatureSelected(2)' :class='sortFeatureCurrentValue == 2 ? "active" : ""'>Top Rated</li>
      </ul>
   </div>
   
   <div class='overlay-layer' :class='sortFeatureOpen == true ? "active" : ""'>

      <ul class='navbar'>
         <li v-for='(cat, index) in categoryWater' :key='index' :class='index == 0 ? "active" : ""'>
            {{ cat.name }}
         </li>
      </ul>
      <ul class='navbar style01'>
         <li v-for='(brands, index) in brandsWater' :key='index'>
            {{ brands.name }}
         </li>
      </ul>
   </div>

   <div class='inner'>
      <div class='grid-masonry'>
         <div @click='gotoProductDetails(product)' class='product-design' v-for='(product, index) in getProductsWater ' :key='index'>
            <div class='img'>
               <img src='<?php echo THEME_URI . '/assets/images/demo-product01.png'; ?>'>
               <span v-if='has_discount(product) == true' class='badge-discount'>-{{ product.discount_percent }}%</span>
            </div>
            <div class='box-wrapper'>
               <p class='tt01'>{{ product.name }} </p>
               <p class='tt02'>{{ get_product_quantity(product) }}</p>
               <div class='gr-price' :class="has_discount(product) == true ? 'has_discount' : '' ">
                  <span class='price'>
                     {{ has_discount(product) == true 
                        ? get_product_price_discount(product) 
                        : get_product_price(product.price)
                     }}
                  </span>
                  <span v-if='has_discount(product) == true' class='price-sub'>
                     {{ get_product_price(product.price) }}
                  </span>
               </div>
            </div>
         </div>
      </div>
   </div>

</div>

<!-- PAGE ICE -->
<div v-if='navigator == "ice"' class='page-home-ice'>
   <div class='appbar'>
      <div class='leading'>

         <button @click='gotoHome' class='btn-action'>
            <svg width="11" height="16" viewBox="0 0 11 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd" d="M10.5309 0.375342C10.8759 0.806604 10.806 1.4359 10.3747 1.78091L2.60078 8.00004L10.3747 14.2192C10.806 14.5642 10.8759 15.1935 10.5309 15.6247C10.1859 16.056 9.55657 16.1259 9.12531 15.7809L0.375305 8.78091C0.13809 8.59113 0 8.30382 0 8.00004C0 7.69625 0.13809 7.40894 0.375305 7.21917L9.12531 0.219168C9.55657 -0.125842 10.1859 -0.0559202 10.5309 0.375342Z" fill="#252831"/>
            </svg>
         </button>
         <p class='leading-title'>Ice</p>
      </div>
      <div class='action'>
         <div @click='buttonSortFeature' class='btn-text'>
            <svg width="16" height="14" viewBox="0 0 16 14" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M1.50197e-05 1.08889V0.252778V1.08889ZM1.50197e-05 1.08889C-0.000569119 1.17459 0.0158907 1.25955 0.0484373 1.33883M1.50197e-05 1.08889L0.0484373 1.33883M0.0484373 1.33883C0.0809839 1.41811 0.128968 1.49013 0.189598 1.55069M0.0484373 1.33883L0.189598 1.55069M0.189598 1.55069L6.02293 7.38403L0.189598 1.55069ZM6.55326 6.8537L0.750015 1.05045V0.75H14.8056V1.05531L9.01691 6.84398L8.79724 7.06365V7.37431V12.7887L6.77293 11.7808V7.38403V7.07337L6.55326 6.8537ZM0.719656 1.02009C0.719747 1.02018 0.719838 1.02027 0.719929 1.02036L0.719656 1.02009Z" fill="#2040AF" stroke="#2040AF" stroke-width="1.5"/>
            </svg>
            <span class='text'>Sort</span>
         </div>
      </div>
   </div>

   <div v-if='sortFeatureOpen == true' class='box-sort' :class='sortFeatureOpen == true ? "active" : ""'>
      <ul>
         <li @click='buttonSortFeatureSelected(0)' :class='sortFeatureCurrentValue == 0 ? "active" : ""'>Nearest</li>
         <li @click='buttonSortFeatureSelected(1)' :class='sortFeatureCurrentValue == 1 ? "active" : ""'>Cheapest</li>
         <li @click='buttonSortFeatureSelected(2)' :class='sortFeatureCurrentValue == 2 ? "active" : ""'>Top Rated</li>
      </ul>
   </div>

   <div class='overlay-layer' :class='sortFeatureOpen == true ? "active" : ""'>
      <div class='box-category'>
         <ul class='navbar'>
            <li v-for='(cat, index) in categoryIce' :key='index' :class='index == 0 ? "active" : ""'>
               {{ cat.name }}
            </li>
         </ul>
      </div>
      
      <div class='inner'>
         <div class='grid-masonry'>
            <div @click='gotoProductDetails(product)' class='product-design' v-for='(product, index) in getProductsIce ' :key='index'>
               <div class='img'>
                  <img src='<?php echo THEME_URI . '/assets/images/demo-product03.png'; ?>'>
                  <span v-if='has_discount(product) == true' class='badge-discount'>-{{ product.discount_percent }}%</span>
               </div>
               <div class='box-wrapper'>
                  <p class='tt01'>{{ product.name }} </p>
                  <p class='tt02'>{{ get_product_quantity(product) }}</p>
                  <div class='gr-price' :class="has_discount(product) == true ? 'has_discount' : '' ">
                     <span class='price'>
                        {{ has_discount(product) == true 
                           ? get_product_price_discount(product) 
                           : get_product_price(product.price)
                        }}
                     </span>
                     <span v-if='has_discount(product) == true' class='price-sub'>
                        {{ get_product_price(product.price) }}
                     </span>
                  </div>
               </div>
            </div>
         </div>
      </div>

   </div>

</div>