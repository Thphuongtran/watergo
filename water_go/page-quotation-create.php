<?php if ( ! defined( 'ABSPATH' ) ) exit; // Don't load directly.?>
<?php

/*
   TEMPLATE NAME: Quotation Create
*/

if( ! is_user_logged_in() ){
   require_once get_template_directory() . '/template-parts/tab-not-login.php';
   die();
}

get_header();



$product_name = $terms = get_terms( [
   'taxonomy'   => 'product-name',
   'hide_empty' => false,
   'order'      => 'ASC',
   'orderby'    => 'term_id',
]);

$text_screw_pie         = __('Screw Pie', 'aution');
$text_input_information = __('Please input information', 'aution');
$text_product_name      = __('Product name', 'aution');
if( get_locale() == 'ko_KR' ){
   $text_screw_pie = '스크류파이';
   $text_input_information = '정보를 입력해주세요';
   $text_product_name = '견적제품';
}

$glass_20      = 'Glass Fiber 20%';
$glass_40      = 'Glass Fiber 40%';
$glass_more_40 = 'More than 40% Glass Fiber';

if( get_locale() == 'ko_KR' ){
   $glass_20 = 'G/F 20% 미만';
   $glass_40 = 'G/F 40% 미만';
   $glass_more_40 = 'G/F 40% 이상';
}

?>
<link defer rel="stylesheet" href="//code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<script defer src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<style>
   .custom_input_from_modal {
      height: 30px;
      border: 1px solid #CCCCCC;
      margin-bottom: 10px;
   }
   .custom_input_from_modal::placeholder {
      color: #808080;
      font-weight: 400;
      font-size: 14px;
   }

   .list-select button {
      border: 1px solid #E6E6E6;
      outline: none;
      background: transparent;
      border-radius: 4px;
      min-height: 26px;
      margin-right: 8px;
      margin-bottom: 8px;
      color: #1A1A1A;
   }

   .list-select button.is-select{
      background: #1A1A1A;
      color: white;
      border-color #1A1A1A;
   }


   .modal-body{
      padding: 25px 10px;
   }

   .modal-select {
      background: #626262;
   }
   .modal-select .modal-content {
      width: 90%;
      height: 80%;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
   }
   .modal-select .modal-footer{
      height: 68px;
      padding: 0 16px;

   }

   .modal-header .btn-close{
      background: none;
      opacity: 1.0;
   }
   .modal-header .btn-close svg{
      vertical-align: initial;
   }
   .modal-title{
      color: #1a1a1a;
      font-size: 14px;
      font-weight: 400;
   }
   .overlay {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: transparent;
      z-index: 88;
   }

   .modal-body{
      overflow-y: scroll;
      overflow-x: hidden;
   }

   .modal-footer{
      display: flex;
      flex-flow: row nowrap;
      justify-content: space-between;
      align-items: center;
   }

   .modal-footer .btn-secondary{
      background: none;
      outline: none;
      border: 0;
      width: auto;
      padding-left: 0;
      display: flex;
      align-items: center;
      padding: 0;
      margin: 0;
      width: 50px;
      height: 42px;
      display: flex;
      align-items: center;
      justify-content: center;
   }
   .modal-footer .btn-reset{
      border: 1px solid #808080;
      border-radius: 25px;
   }

   .modal-footer .btn-secondary:active{
      color: transparent;
      background-color: transparent;
   }

   .modal-footer .btn-reset:focus,
   .modal-footer .btn-reset:active,
   .modal-footer .btn-reset:hover{
      border: 1px solid #808080 !important;
   }

   .modal-footer .btn-primary{
      margin: 0;
   }

   .btn-apply{
      /* backfround: rgb(32 64 175) !important   */
   }

   .btn-primary{
      border-radius: 20px;
      background-color: #2040AF !important;
      border: none !important;
      outline: none;
      box-shadow: none;
      overflow: hidden;
   }

   .btn-primary.disabled{
      background-color: rgba(32, 64, 175, 0.3) !important;
      border: none !important;
   }   

   .form-design-button{
      position: fixed;
      z-index: 88;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 70px;
      padding: 0 16px;
      background: white;
      display: flex;
      align-items: center;
      justify-content: flex-end;
   }

   .form-design {
      padding: 20px 0;
      padding-bottom: 80px;
   }
   .form-design.form-input-disable input{
      pointer-events: none;
   }

   .form-design .form-select {
      background-image: none;
      box-shadow: none;
   }

   .form-design .form-style {
      margin-top: 15px;
   }
   .form-design .form-label {
      font-weight: 400;
      font-size: 14px;
   }
   .form-design .form-wrapper {
      position: relative;
   }

   .form-design .form-wrapper .form-select,
   .form-design .form-wrapper .form-control {
      border: 1px solid #CCCCCC;
   }

   .form-design .form-wrapper .icon {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      right: 15px;
   }
   .form-design .form-wrapper .form-control[disabled] {
      border: 1px solid #CCCCCC;
      background: white;
   }
   .form-design .form-wrapper .form-control::placeholder {
      font-size: 14px;
      font-weight: 400;
      color: #808080;
   }

   .fake-input {
      display: block;
      position: relative;
      width: 100%;
      border: 1px solid #1A1A1A;
      background: white;
      border-radius: 8px;
      height: 44px;
      text-align: left;
      padding-left: 8px;
   }
   .fake-input .text {
      color: #1A1A1A;
      font-weight: 400;
      font-size: 14px;
   }
   .fake-input .icon {
      position: absolute;
      top: 50%;
      transform: translateY(-50%);
      right: 15px;
   }

   .form-design textarea{
      min-height: 100px;
      border: 1px solid #CCCCCC;
      resize: none;
   }

   .modal-form-step .modal-header a,
   .modal-form-step .modal-header button {
      width: 28px;
   }
   .modal-form-step .modal-header{
      height: 56px;
      padding: 0 16px;
   }
   .modal-form-step .modal-header .modal-title {
      width: 100%;
      text-align: center;
      color: #1a1a1a;
      font-size: 16px;
      font-weight: 700;
   }
   /* .modal-form-step .modal-footer{
      position: fixed;
      bottom: 0;
      left: 0;
      width: 100%;
      height: 64px;
      background: white;
   } */

   .modal-form-step .modal-body {
      padding-top: 0;
      /* padding-bottom: 100px; */
   }


   .w100{
      width: 100%;
   }

   .form-trailing input {
      padding-right: 55px;
   }
   .form-trailing .trailing-text {
      position: absolute;
      top: 0;
      left: 0;
   }
   .form-trailing .trailing-fixed {
      right: 15px;
      top: 50%;
      transform: translateY(-50%);
      position: absolute;
      color: #1A1A1A;
      font-size: 16px;
      font-weight: 400;
   }
   .list-select2{
      margin-top: 8px;
   }
   .list-select2 button{
      border-radius: 4px;
   }
   .list-select2 button.is-select{
      background: #1A1A1A;
      border: 1px solid #1A1A1A;
      color: white;
   }

   button.btn-enter{
      background: transparent;
      border: 1px solid #E6E6E6;
      color: #1A1A1A;
   }

   .uploads {
      margin-top: 10px;
      display: flex;
      flex-flow: row wrap;
   }
   .uploads .images {
      margin-right: 10px;
      margin-bottom: 10px;
   }
   .uploads .btn-upload {
      width: 88px;
      height: 88px;
      border: 1px solid #E6E6E6;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-flow: column nowrap;
      margin-right: 10px;
   }
   .uploads .btn-upload .upload_count {
      margin-top: 10px;
   }
   .uploads input {
      display: none;
   }

   .uploads .images {
      position: relative;
      width: 88px;
      height: 88px;
   }
   .uploads .images img {
      width: 100%;
      object-fit: cover;
      aspect-ratio: 1/1;
   }
   .uploads .images button {
      position: absolute;
      right: 0;
      top: 0;
      border: none;
      outline: none;
      background: none;
      display: flex;
      padding: 0;
   }

   .modal-select.modal-successful .modal-header {
      height: 60px;
   }
   .modal-select.modal-successful .modal-content {
      min-height: 200px;
      height: auto;
   }
   .modal-select.modal-successful .modal-footer {
      justify-content: flex-end;
      height: 68px;
      border-top: 0;
   }

   .text-modal-success{
      color: #1A1A1A;
      font-size: 14px;
      font-weight: 400;
   }

   .modal-form-step .form-design{
      padding-bottom: 0;
   }

   .modal-form-step .modal-header .close-1{
      padding: 0;
   }

   .modal-successful a{
      line-height: 34px;
   }

   .modal-successful .modal-body{
      padding: 25px 14px;
   }

   .list-select2 {
      display: flex;
      flex-flow: row nowrap;
      justify-content: space-between;
   }
   .list-select2 button {
      margin-right: 0;
      margin-bottom: 0;
      min-width: 12%;
      height: 40px;
      margin-bottom: 8px;
      width: auto;
      padding: 0;
   }
   .list-select2 button.btn-enter {
      min-width: 26.5%;
      width: auto;
   }
   @media screen and (max-width: 375px) {
      .list-select2 button {
         font-size: 3.3vw;
      }
      .list-select2 button.btn-enter {
         font-size: 14px;
      }
   }
   .select2-container--open{
      z-index: 8888;
   }

   .select2-container--default .select2-selection--single .select2-selection__arrow{
      right: 10px;
   }

   input::placeholder, select::placeholder, textarea::placeholder{
      font-size: 14px;
   }
   .form-control, input, select, textarea{
      font-size: 14px;
      color: #1a1a1a;
   }

   .select2-container--default .select2-selection--single .select2-selection__rendered{
      font-size: 14px;
      color: #1a1a1a;
   }
   .modal-form-step .modal-header a, .modal-form-step .modal-header button{
      display: flex;
      align-items: center;
   }

   .ui-date-picker-wrapper {
      position: fixed;
      background: rgba(0, 0, 0, 0.5);
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: 8888;
      display: none;
   }

   .ui-datepicker td{
      width: calc( 100% / 7 );
   }
   .ui-date-picker-wrapper.active {
      display: block;
   }
   .ui-date-picker-wrapper #ui-datepicker-div {
      top: 50% !important;
      left: 50% !important;
      transform: translate(-50%, -50%);
   }
   .ui-date-picker-wrapper #ui-datepicker-div{
      max-width: 320px !important;
      width: 90% !important;
   }

   .ui-state-highlight, 
   .ui-widget-content .ui-state-highlight, 
   .ui-widget-header .ui-state-highlight{
      background: #f6f6f6;
      color: #454545;
      border: 1px solid #CCCCCC;

      /* background: #1a1a1a !important;
      color: white !important;
      border: 1px solid #1a1a1a !important; */
   }

   .ui-state-active, .ui-widget-content .ui-state-active, .ui-widget-header .ui-state-active, a.ui-button:active, .ui-button:active, .ui-button.ui-state-active:hover{
      background: #2040AF;
      color: white;
      border: 1px solid #2040AF;
   }
   
   .ui-state-hover, .ui-widget-content .ui-state-hover, .ui-widget-header .ui-state-hover, .ui-state-focus, .ui-widget-content .ui-state-focus, .ui-widget-header .ui-state-focus, .ui-button:hover, .ui-button:focus{
      background: #2040AF !important;
      color: white !important;
      border: 1px solid #2040AF !important;
   }

   .ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default, .ui-button, html .ui-button.ui-state-disabled:hover, html .ui-button.ui-state-disabled:active{
      text-align: center !important;
      border: 1px solid #CCCCCC;
   }

   .select2-container--above.select2-container--open .select2-selection__rendered{
      border-top-left-radius: 0px !important;
      border-top-right-radius: 0px !important;
   }
   .select2-container--below.select2-container--open .select2-selection__rendered{
      border-bottom-left-radius: 0px !important;
      border-bottom-right-radius: 0px !important;
   }

   .select2-container .select2-selection--single .select2-selection__rendered[title="Select product"],
   .select2-container .select2-selection--single .select2-selection__rendered[title="Select"]{
      color: #808080;
   }
   .select2-container--default .select2-selection--single .select2-selection__rendered{
      color: #1a1a1a;
   }
   textarea::placeholder, input::placeholder{
      color: #808080 !important;
   }
   .list-select button.is-select {
      border-color: #1a1a1a;
   }
   #modal-form-step .modal-footer{
      border:0;
      padding-left: 26px;
      padding-right: 26px;
   }

   .btn_disabled{
      background-color: rgba(32, 64, 175, 0.3) !important;
      border: none !important;
   }

   .t-error{
      color: #FB4C4C;
      font-weight: 400;
      font-size: 13px;
   }

</style>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/vue@3/dist/vue.global.js"></script>


<header class="header_fixed header-tab tab_quotation_create ">
    <nav class="navbar p-0 back">
        <div class="container position-relative">
            <a href="/?appt=X" onclick="btnBack(this, event)" class="btn_app_back btn-bank h-100 pr-4 position-absolute position-absolute top-50 start-0 translate-middle-y d-flex align-items-center">
               <svg width="12" height="22" ><use xlink:href="#svg_back"></use></svg>
            </a>
            <div class="header__title fs-16 font-weight-700 flex-fill text-center m-0"><?php echo __('Request Quotation', 'aution'); ?></div>
        </div>
    </nav>
</header>

<main id='app'>

   <div class='container'>
      <div class='form-design form-input-disable'>

         <label class="form-label"><?php echo $text_product_name; ?></label>
         <div class='form-wrapper'>
            <div class="dropdown custom_selecte_2">
               <select id='product_name' class="form-select" v-model='product_name'>
                  <option selected disabled value=''><?php echo __('Select product', 'aution'); ?></option>
                  <?php foreach( $product_name as $k => $vl ){ 
                     if( $vl->name == 'Resin Dryer' && get_locale() == 'ko_KR'){
                        $vl->name = '제습건조기';
                     }
                  ?>
                     <option value="<?php echo $vl->term_id; ?>"><?php echo __($vl->name, 'aution'); ?></option>
                  <?php } ?>
               </select>
            </div>
         </div>

         <!-- Injection Molding Machine -->

         <div v-if='form.form_2'>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Type of Machine', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_2_data.type_of_machine' placeholder='<?php echo __("Select or input", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("type_of_machine")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_2_data.type_of_machine == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Machine Tonnage', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_2_data.machine_tonnage' placeholder='<?php echo __("Select or input", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("machine_tonnage")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_2_data.machine_tonnage == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
            <div class='form-style'>
               <label class="form-label"><?php echo $text_screw_pie; ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_2_data.screw_pine' placeholder='<?php echo __("Select or input", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("screw_pine")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_2_data.screw_pine == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Resin Type', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_2_data.resin_type' placeholder='<?php echo __("Select or input", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("resin_type")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_2_data.resin_type == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Product (or Planned Product)', 'aution'); ?> </label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_2_data.planned_product' placeholder='<?php echo __("Select", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("planned_product")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_2_data.planned_product == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Operation Mode', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_2_data.operation_mode' placeholder='<?php echo __("Select", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("operation_mode")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_2_data.operation_mode == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
         </div>

         <!-- Industrial Robot -->

         <div v-if='form.form_3'>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Robot Arm Length', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_3_data.robot_arm_length' placeholder='<?php echo __("Select or input", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("robot_arm_length")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_3_data.robot_arm_length == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Special Jig Manufacturing Request', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_3_data.special_jig_manufacturing_request' placeholder='<?php echo __("Select", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("special_jig_manufacturing_request")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_3_data.special_jig_manufacturing_request == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
         </div>

         <!-- Resin Dryer -->

         <div v-if='form.form_4'>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Drying Method', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_4_data.drying_method' placeholder='<?php echo __("Select", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("drying_method")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_4_data.drying_method == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Drying capacity (PC standard 1.2)', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_4_data.drying_capacity' placeholder='<?php echo __("Select or input", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("drying_capacity")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_4_data.drying_capacity == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
         </div>

         <!-- Mold Temperature Controller -->

         <div v-if='form.form_5'>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Mold Temperature Control Method', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_5_data.mold_temperature_control_method' placeholder='<?php echo __("Select or input", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("mold_temperature_control_method")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_5_data.mold_temperature_control_method == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Maximum Mold Temperature', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_5_data.maximum_mold_temperature' placeholder='<?php echo __("Select or input", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("maximum_mold_temperature")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_5_data.maximum_mold_temperature == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Mold Temperature Control Channels', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_5_data.mold_temperature_control_channels' placeholder='<?php echo __("Select or input", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("mold_temperature_control_channels")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_5_data.mold_temperature_control_channels == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
         </div>

         <!-- Pelletizing Machine -->

         <div v-if='form.form_6'>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Repelletizing Method', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_6_data.repelletizing_method' placeholder='<?php echo __("Select or input", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("repelletizing_method")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_6_data.repelletizing_method == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Resin Types for Repelletizing', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_6_data.resin_types_for_tepelletizing' placeholder='<?php echo __("Select or input", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("resin_types_for_tepelletizing")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_6_data.resin_types_for_tepelletizing == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
            <div class='form-style'>
               <label class="form-label"><?php echo __('Repelletizing Production Capacity (Kg/h)', 'aution'); ?></label>
               <div class='form-wrapper'>
                  <input type="text" class='form-control' v-model='form_6_data.repelletizing_production_capacity' placeholder='<?php echo __("Select or input", "aution"); ?>'>
                  <span class='icon'>
                     <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                     </svg>
                  </span>
                  <div class='overlay' @click='open_modal("repelletizing_production_capacity")'></div>
               </div>
               <div v-show='show_next_form_error == true && form_6_data.repelletizing_production_capacity == ""' class='t-error'><?php echo $text_input_information; ?></div>
            </div>
         </div>
         
      </div>

      <div v-if='product_name != "" ' class='form-design-button'>
         <button @click='go_to_next_form' class='btn btn-primary' :class='can_next_form == true ? "" : "btn_disabled"'><?php echo __('Next', 'aution'); ?></button>
      </div>

   </div>

   <!-- MODAL SELECT -->
   <div class="modal fade modal-select" id="exampleModalFxullscreen" tabindex="-1" aria-modal="true" role="dialog" data-bs-backdrop="static">
      <div class="modal-dialog modal-fullscreen">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">{{ modal_title }}</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M10.0469 8L14.875 3.21875L15.8594 2.23438C16 2.09375 16 1.85938 15.8594 1.67188L14.8281 0.640625C14.6406 0.5 14.4062 0.5 14.2656 0.640625L8.5 6.45312L2.6875 0.640625C2.54688 0.5 2.3125 0.5 2.125 0.640625L1.09375 1.67188C0.953125 1.85938 0.953125 2.09375 1.09375 2.23438L6.90625 8L1.09375 13.8125C0.953125 13.9531 0.953125 14.1875 1.09375 14.375L2.125 15.4062C2.3125 15.5469 2.54688 15.5469 2.6875 15.4062L8.5 9.59375L13.2812 14.4219L14.2656 15.4062C14.4062 15.5469 14.6406 15.5469 14.8281 15.4062L15.8594 14.375C16 14.1875 16 13.9531 15.8594 13.8125L10.0469 8Z" fill="#1A1A1A"/>
                  </svg>
               </button>
            </div>

            <div class="modal-body">
               <input v-if='modal_title == "<?php echo __('Machine Tonnage', "aution"); ?>"' class='form-control custom_input_from_modal' type="text" v-model='input_Machine_Tonnage' placeholder='<?php echo __("Select or input", "aution"); ?>'>
               <input v-if='modal_title == "<?php echo $text_screw_pie; ?>"' class='form-control custom_input_from_modal' type="text" v-model='input_Screw_Pine' placeholder='<?php echo __("Select or input", "aution"); ?>'>
               <input v-if='modal_title == "<?php echo __('Resin Type', "aution"); ?>"' class='form-control custom_input_from_modal' type="text" v-model='input_Resin_Type' placeholder='<?php echo __("Select or input", "aution"); ?>'>
               <input v-if='modal_title == "<?php echo __('Robot Arm Length', "aution"); ?>"' class='form-control custom_input_from_modal' type="text" v-model='input_Robot_arm_length' placeholder='<?php echo __("Select or input", "aution"); ?>'>
               <input v-if='modal_title == "<?php echo __('Drying Capacity', "aution"); ?>"' class='form-control custom_input_from_modal' type="text" v-model='input_Drying_capacity' placeholder='<?php echo __("Select or input", "aution"); ?>'>
               <input v-if='modal_title == "<?php echo __('Mold Temperature Control Method', "aution"); ?>"' class='form-control custom_input_from_modal' type="text" v-model='input_Mold_Temperature_Control_Method' placeholder='<?php echo __("Select or input", "aution"); ?>'>
               <input v-if='modal_title == "<?php echo __('Maximum Mold Temperature', "aution"); ?>"' class='form-control custom_input_from_modal' type="text" v-model='input_Maximum_Mold_Temperature' placeholder='<?php echo __("Select or input", "aution"); ?>'>
               <input v-if='modal_title == "<?php echo __('Mold Temperature Control Channels', "aution"); ?>"' class='form-control custom_input_from_modal' type="text" v-model='input_Mold_Temperature_Control_Channels' placeholder='<?php echo __("Select or input", "aution"); ?>'>
               <input v-if='modal_title == "<?php echo __('Repelletizing Method', "aution"); ?>"' class='form-control custom_input_from_modal' type="text" v-model='input_Repelletizing_Method' placeholder='<?php echo __("Select or input", "aution"); ?>'>
               <input v-if='modal_title == "<?php echo __('Resin Types for Repelletizing', "aution"); ?>"' class='form-control custom_input_from_modal' type="text" v-model='input_Resin_Types_for_Repelletizing' placeholder='<?php echo __("Select or input", "aution"); ?>'>
               <input v-if='modal_title == "<?php echo __('Repelletizing Production Capacity (Kg/h)', "aution"); ?>"' class='form-control custom_input_from_modal' type="text" v-model='input_Repelletizing_Production_Capacity' placeholder='<?php echo __("Select or input", "aution"); ?>'>

               <div class='list-select'>
                  <button @click='select_property(select, modal_title)' 
                     v-for='( select, selectIndex) in get_list_select' 
                     :key='selectIndex'
                     :class='select.select == true ? "is-select" : "" '
                  >
                     {{ select.label }}
                  </button>
               </div>
            </div>

            <div class="modal-footer">
               <button @click='remove_select_property( modal_title )' class="btn btn-secondary btn-reset">
                  <!-- <svg width="46" height="38" viewBox="0 0 46 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M28.4961 12.0234L27.1289 13.3906C25.9805 12.5156 24.5312 11.9688 22.9727 11.9688C19.2539 11.9961 16.1914 15.0312 16.2188 18.7773C16.2188 22.5234 19.2539 25.5312 23 25.5312C24.7227 25.5312 26.3359 24.875 27.5391 23.8086C27.6758 23.6719 27.6758 23.4531 27.5391 23.3164L27.3477 23.125C27.2383 23.0156 27.0195 22.9883 26.9102 23.125C25.8438 24.082 24.4492 24.6016 23 24.6016C19.7734 24.6016 17.1484 22.0039 17.1484 18.75C17.1484 15.5234 19.7461 12.8984 23 12.8984C24.2578 12.8984 25.4609 13.3086 26.4727 14.0469L24.9961 15.5234C24.4492 16.0703 24.832 17 25.625 17H29.125C29.5898 17 30 16.6172 30 16.125V12.625C30 11.8594 29.043 11.4766 28.4961 12.0234ZM29.125 16.125H25.625L29.125 12.625V16.125Z" fill="#1A1A1A"/>
                  <rect x="0.5" y="0.5" width="45" height="37" rx="18.5" stroke="#808080"/>
                  </svg> -->
                  <svg width="14" height="15"><use xlink:href="#svg_btn_reset"></use></svg>
               </button>
               <button @click='apply_select_property( modal_title )' class="btn btn-primary btn-apply" :class='is_select_property(modal_title ) ? "" : "disabled" ' data-bs-dismiss="modal"><?php echo __("Apply", "aution"); ?></button>
            </div>

         </div>
      </div>
   </div>

   <!-- MODAL FORM STEP -->

   <div class="modal fade modal-form-step" id="modal-form-step" tabindex="-1" aria-modal="true" role="dialog" data-bs-backdrop="static">
      <div class="modal-dialog modal-fullscreen">
         <div class="modal-content">
            <div class="modal-header">
               <button @click='reset_form_step_data' type="button" class="h-100 btn-close close-1" data-bs-dismiss="modal" aria-label="Close">
                  <svg width="12" height="22" ><use xlink:href="#svg_back"></use></svg>
               </button>
               <h5 class="modal-title"><?php echo __('Request for a quotation', 'aution'); ?></h5>
               <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                  <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M10.0469 8L14.875 3.21875L15.8594 2.23438C16 2.09375 16 1.85938 15.8594 1.67188L14.8281 0.640625C14.6406 0.5 14.4062 0.5 14.2656 0.640625L8.5 6.45312L2.6875 0.640625C2.54688 0.5 2.3125 0.5 2.125 0.640625L1.09375 1.67188C0.953125 1.85938 0.953125 2.09375 1.09375 2.23438L6.90625 8L1.09375 13.8125C0.953125 13.9531 0.953125 14.1875 1.09375 14.375L2.125 15.4062C2.3125 15.5469 2.54688 15.5469 2.6875 15.4062L8.5 9.59375L13.2812 14.4219L14.2656 15.4062C14.4062 15.5469 14.6406 15.5469 14.8281 15.4062L15.8594 14.375C16 14.1875 16 13.9531 15.8594 13.8125L10.0469 8Z" fill="#1A1A1A"/>
                  </svg>
               </button> -->
            </div>

            <div class="modal-body">

               <div class='container'>
                  <div class='form-design'>

                     <div class='form-style'>
                        <label class='form-label'>
                           <?php echo $text_product_name; ?>
                        </label>
                        <button @click='reset_form_step_data' type="button" data-bs-dismiss="modal" class='fake-input'>
                           <span class='text'>{{ product_name_full }}</span>
                           <span class='icon'>
                              <svg width="9" height="5" viewBox="0 0 9 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M0.972656 0C0.480469 0 0.234375 0.601562 0.589844 0.957031L4.08984 4.45703C4.30859 4.67578 4.66406 4.67578 4.88281 4.45703L8.38281 0.957031C8.73828 0.601562 8.49219 0 8 0H0.972656Z" fill="#1A1A1A"/>
                              </svg>
                           <span>
                        </button>
                     </div>

                     <div class='form-style'>
                        <label class='form-label'><?php echo __('Desired Year of Manufacture for Used Machines', 'aution'); ?></label>
                        <div class='form-wrapper'>
                           <div class="dropdown custom_selecte_2">
                              <select id='desired_year_of_manufacture_for_used_machines' class='form-select' v-model='form_step_data.desired_year_of_manufacture_for_used_machines'>
                                 <option selected disabled value=''><?php echo __('Select', 'aution'); ?></option>
                                 <option value="Within 3 years"><?php echo __('Within 3 years', 'aution'); ?></option>
                                 <option value="Within 5 years"><?php echo __('Within 5 years', 'aution'); ?></option>
                                 <option value="Within 10 years"><?php echo __('Within 10 years', 'aution'); ?></option>
                                 <option value="Within 20 years"><?php echo __('Within 20 years', 'aution'); ?></option>
                                 <option value="No require(Select when a new product)"><?php 
                                    echo __('No require(Select when a new product)', 'aution'); 
                                 ?></option>
                              </select>
                           </div>
                        </div>
                        <div v-show='show_apply_form_error == true && form_step_data.desired_year_of_manufacture_for_used_machines == ""' class='t-error'><?php echo $text_input_information; ?></div>
                     </div>

                     <div class='form-style'>
                        <label><?php echo __('Other Quotation Request Details (optional)', 'aution'); ?></label>
                        <textarea @input='autoResize' ref='textarea' class='form-control' v-model='form_step_data.other_quotation_request_details' placeholder='<?php 
                           if( get_locale() == 'ko_KR'){
                              echo '직접입력(제품캐비티, 총중량등을 입력요망)';
                           }else{
                              echo __("Input", 'aution'); 
                           }
                        ?>'></textarea>
                     </div>

                     <div class='form-style'>
                        <label><?php echo __('Status of Machine', 'aution'); ?></label>
                        <div class='form-wrapper'>
                           <div class="dropdown custom_selecte_2">
                              <select id='status_of_machine' class='form-select' v-model='form_step_data.status_of_machine'>
                                 <option selected disabled value><?php echo __('Select', 'aution'); ?></option>
                                 <option value="New"><?php echo __('New', 'aution'); ?></option>
                                 <option value="Secondhand"><?php echo __('Secondhand', 'aution'); ?></option>
                              </select>
                           </div>
                        </div>
                        <div v-show='show_apply_form_error == true && form_step_data.status_of_machine == ""' class='t-error'><?php echo $text_input_information; ?></div>
                     </div>

                     <div class='form-style'>
                        <label><?php echo __('Quantity', 'aution'); ?></label>
                        <div class='form-wrapper form-trailing' v-show='quantity_enter_enable == true'>
                           <input class="form-control" inputmode='numeric' type='text' v-model='form_step_data.quantity'>
                           <span class="trailing-fixed"><?php echo __('pcs', 'aution'); ?></span>
                        </div>

                        <div class='list-select list-select2'>
                           <button 
                              @click='select_quantity(q)'
                              v-for='(q, qK) in quantity_mem.slice(0, 7)' :key='qK'
                              :class='q.select == true ? "is-select" : "" '
                           >
                              {{ q.label }}
                           </button>
                        </div>

                        <div class='list-select list-select2' style='margin-top: 0;'>
                           <button 
                              @click='select_quantity(q)'
                              v-for='(q, qK) in quantity_mem.slice(7, quantity_mem.length)' :key='qK'
                              :class='q.select == true ? "is-select" : "" '
                           >
                              {{ q.label }}
                           </button>
                           <button @click='select_quantity_enter' class='btn-enter' :class='quantity_enter_enable == true ? "is-select" : ""'><?php echo __('Enter', 'aution'); ?></button>
                        </div>

                        <div v-show='show_apply_form_error == true && form_step_data.quantity == ""' class='t-error'><?php echo $text_input_information; ?></div>
                        
                     </div>

                     <div class='form-style'>
                        <label><?php echo __('Installation location', 'aution'); ?></label>
                        <div class='form-wrapper'>
                           <input class='form-control' v-model='form_step_data.installation_location' type="text" placeholder='<?php echo __('Input', 'aution'); ?>'>
                        </div>
                        <div v-show='show_apply_form_error == true && form_step_data.installation_location == ""' class='t-error'><?php echo $text_input_information; ?></div>
                     </div>

                     <div class='form-style'>
                        <label><?php echo __('Delivery Terms', 'aution'); ?></label>
                        <div class='form-wrapper'>
                           <div class="dropdown custom_selecte_2">
                              <select id='delivery_terms' class='form-select' v-model='form_step_data.delivery_terms'>
                                 <option selected disabled value=''><?php echo __('Select', 'aution')?></option>
                                 <option value="DDP"><?php echo __('DDP', 'aution'); ?></option>
                                 <option value="CIF"><?php echo __('CIF', 'aution'); ?></option>
                                 <option value="FOB"><?php echo __('FOB', 'aution'); ?></option>
                                 <option value="EXW"><?php echo __('EXW', 'aution'); ?></option>
                              </select>
                           </div>
                        </div>
                        <div v-show='show_apply_form_error == true && form_step_data.delivery_terms == ""' class='t-error'><?php echo $text_input_information; ?></div>
                     </div>

                     <div class='form-style'>
                        <label><?php echo __('Desired delivery date', 'aution'); ?></label>
                        <div class='form-wrapper'>
                           <input id='desired_delivery_date' class='form-control' v-model='form_step_data.desired_delivery_date' type="date" placeholder='DD/MM/YYYY'>
                        </div>
                        <div v-show='show_apply_form_error == true && form_step_data.desired_delivery_date == ""' class='t-error'><?php echo $text_input_information; ?></div>
                     </div>

                     <div class='form-style'>
                        <label><?php echo __('Production Items', 'aution'); ?></label>
                        <div class='form-wrapper'>
                           <div class="dropdown custom_selecte_2">
                              <select id='production_items' class='form-select' v-model='form_step_data.production_items'>
                                 <option selected disabled value=''><?php echo __('Select', 'aution'); ?></option>
                                 <option value='Existing product'><?php echo __('Existing product', 'aution'); ?></option>
                                 <option value='Developmental product'><?php echo __('Developmental product', 'aution'); ?></option>
                                 <option value='Undecided'><?php echo __('Undecided', 'aution'); ?></option>
                              </select>
                           </div>
                        </div>
                        <div v-show='show_apply_form_error == true && form_step_data.production_items == ""' class='t-error'><?php echo $text_input_information; ?></div>
                     </div>

                     <div class='form-style'>
                        <label><?php echo __('Production Imagine (optional)', 'aution'); ?></label>
                        <div class='uploads'>
                           <label class='btn-upload'>
                              <input id='uploads' type="file" multiple @change='do_upload' :disabled='upload_count >= 2 ? true : false' accept="image/*">
                              <svg width="24" height="22" viewBox="0 0 24 22" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <path d="M15.1875 2C15.3281 2 15.4688 2.14062 15.5156 2.28125L16.5469 5H21.75C22.125 5 22.5 5.375 22.5 5.75V19.25C22.5 19.6719 22.125 20 21.75 20H2.25C1.82812 20 1.5 19.6719 1.5 19.25V5.75C1.5 5.375 1.82812 5 2.25 5H7.40625L8.34375 2.51562C8.4375 2.23438 8.71875 2 9.04688 2H15.1875ZM15.1875 0.5H9.04688C8.10938 0.5 7.26562 1.10938 6.9375 2L6.375 3.5H2.25C0.984375 3.5 0 4.53125 0 5.75V19.25C0 20.5156 0.984375 21.5 2.25 21.5H21.75C22.9688 21.5 24 20.5156 24 19.25V5.75C24 4.53125 22.9688 3.5 21.75 3.5H17.625L16.9219 1.71875C16.6406 1.01562 15.9844 0.5 15.1875 0.5ZM12 18.125C15.0938 18.125 17.625 15.6406 17.625 12.5C17.625 9.40625 15.0938 6.875 12 6.875C8.85938 6.875 6.375 9.40625 6.375 12.5C6.375 15.6406 8.85938 18.125 12 18.125ZM12 8.375C14.25 8.375 16.125 10.25 16.125 12.5C16.125 14.7969 14.25 16.625 12 16.625C9.70312 16.625 7.875 14.7969 7.875 12.5C7.875 10.25 9.70312 8.375 12 8.375Z" fill="#1A1A1A"/>
                              </svg>
                              <div class='upload_count'>{{ upload_count }}/2</div>
                           </label>

                           <div class='images' v-for='( image, imageIndex ) in form_step_data.production_imagine' :key='imageIndex'>
                              <img :src='image.imagePreview' alt="">
                                 <button @click='btn_delete_image(imageIndex)'>
                                 <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                 <rect width="16" height="16" rx="2" fill="white" fill-opacity="0.7"/>
                                 <path d="M12 4L4 12" stroke="#515151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 <path d="M4 4L12 12" stroke="#515151" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                 </svg>
                              </button>
                           </div>
                        </div>

                     </div>

                  </div>
               </div>

            </div>

            <div class="modal-footer">
               <button @click='btn_apply_form' class="btn btn-primary w100 btn-apply-fullsize" :class='can_apply_form ? "" : "btn_disabled"'>
                  <?php 
                     if( get_locale() == 'ko_KR'){ echo '견적의뢰';
                     }else{ echo __('Apply', 'aution'); }
                  ?>
               </button>
            </div>

         </div>
      </div>
   </div>

   <!-- MODAL SUCCESSFULLY -->
   <div class="modal fade modal-select modal-successful" id="modal-successful" tabindex="-1" aria-modal="true" role="dialog" data-bs-backdrop="static">
      <div class="modal-dialog modal-fullscreen">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title"><?php echo __('Successful quotation creation', 'aution'); ?></h5>
            </div>
            <div class="modal-body">
               <p class='text-modal-success'><?php echo __('Mauction will feedback you soon, Please pay attention to your email.', 'aution'); ?></p>
            </div>
            <div class="modal-footer">
               <button @click='btn_successfully' class="btn btn-primary"><?php echo __('Done', 'aution'); ?></button>
            </div>

         </div>
      </div>
   </div>


</main>
<script>

var app = Vue.createApp({
   data (){
      return {
         product_name: '',
         product_name_full: '',
         product_name_full_no_translate: '',
         upload_count: 0,

         can_apply_form: false,
         show_apply_form_error: false,

         can_next_form: false,
         show_next_form_error: false,

         // TOGGLE INPUT MAKE USE TYPE NUMBER (pcs)
         quantity_enter_enable: false,

         quantity_mem: [
            { label: '1대',  value: '1',  select: false },
            { label: '2대',  value: '2',  select: false },
            { label: '3대',  value: '3',  select: false },
            { label: '4대',  value: '4',  select: false },
            { label: '5대',  value: '5',  select: false },
            { label: '6대',  value: '6',  select: false },
            { label: '7대',  value: '7',  select: false },
            { label: '8대',  value: '8',  select: false },
            { label: '9대',  value: '9',  select: false },
            { label: '10대', value: '10', select: false },
            { label: '20대', value: '20', select: false },
            { label: '30대', value: '30', select: false }
         ],

         input_Machine_Tonnage: '',
         input_Screw_Pine: '',
         input_Resin_Type: '',
         input_Robot_arm_length: '',
         input_Drying_capacity: '',
         input_Mold_Temperature_Control_Method: '',
         input_Maximum_Mold_Temperature: '',
         input_Mold_Temperature_Control_Channels: '',
         input_Repelletizing_Method: '',
         input_Resin_Types_for_Repelletizing: '',
         input_Repelletizing_Production_Capacity: '',

         form: {
            form_2: false,
            form_3: false,
            form_4: false,
            form_5: false,
            form_6: false,
            form_step_2: false,
         },

         form_2_data: {
            type_of_machine: '',
            machine_tonnage: '',
            screw_pine: '',
            resin_type: '',
            planned_product: '',
            operation_mode: '',
         },

         form_3_data: {
            robot_arm_length: '',
            special_jig_manufacturing_request: '',
         },

         form_4_data: {
            drying_method: '',
            drying_capacity: '',
         },

         form_5_data: {
            mold_temperature_control_method: '',
            maximum_mold_temperature: '',
            mold_temperature_control_channels: '',
         },

         form_6_data: {
            repelletizing_method: '',
            resin_types_for_tepelletizing: '',
            repelletizing_production_capacity: ''
         },

         form_step_data: {
            desired_year_of_manufacture_for_used_machines: '',
            other_quotation_request_details: '',
            status_of_machine: '',
            quantity: '',
            installation_location: '',
            delivery_terms: '',
            desired_delivery_date: '',
            production_items: '',
            production_imagine: []
         },

         // FORM SELECT 2
         type_of_machine_select: [
            { label: '<?php echo __("Horizontal Machine", "aution"); ?>', value: 'Horizontal Machine', select: false},
            { label: '<?php echo __("Vertical Machine Single Acting", "aution"); ?>', value: 'Vertical Machine Single Acting', select: false},
            { label: '<?php echo __("Vertical Machine Rotary Type", "aution"); ?>', value: 'Vertical Machine Rotary Type', select: false},
            { label: '<?php echo __("Two Color (Multicolor) Machine", "aution"); ?>', value: 'Two Color (Multicolor) Machine', select: false},
            { label: '<?php echo __("Metal (LIM) Machine", "aution"); ?>', value: 'Metal (LIM) Machine', select: false},
            { label: '<?php echo __("Blower Machine", "aution"); ?>', value: 'Blower Machine', select: false},
            { label: '<?php echo __("Mucell Machine", "aution"); ?>', value: 'Mucell Machine', select: false}
         ],

         machine_tonnage_select: [
            { label: '3<?php echo __('Ton', 'aution'); ?>', value: '3', select: false },
            { label: '5<?php echo __('Ton', 'aution'); ?>', value: '5', select: false },
            { label: '10<?php echo __('Ton', 'aution'); ?>', value: '10', select: false },
            { label: '15<?php echo __('Ton', 'aution'); ?>', value: '15', select: false },
            { label: '18<?php echo __('Ton', 'aution'); ?>', value: '18', select: false },
            { label: '20<?php echo __('Ton', 'aution'); ?>', value: '20', select: false },
            { label: '30<?php echo __('Ton', 'aution'); ?>', value: '30', select: false },
            { label: '40<?php echo __('Ton', 'aution'); ?>', value: '40', select: false },
            { label: '45<?php echo __('Ton', 'aution'); ?>', value: '45', select: false },
            { label: '50<?php echo __('Ton', 'aution'); ?>', value: '50', select: false },
            { label: '70<?php echo __('Ton', 'aution'); ?>', value: '70', select: false },
            { label: '75<?php echo __('Ton', 'aution'); ?>', value: '75', select: false },
            { label: '80<?php echo __('Ton', 'aution'); ?>', value: '80', select: false },
            { label: '100<?php echo __('Ton', 'aution'); ?>', value: '100', select: false },
            { label: '110<?php echo __('Ton', 'aution'); ?>', value: '110', select: false },
            { label: '120<?php echo __('Ton', 'aution'); ?>', value: '120', select: false },
            { label: '130<?php echo __('Ton', 'aution'); ?>', value: '130', select: false },
            { label: '150<?php echo __('Ton', 'aution'); ?>', value: '150', select: false },
            { label: '170<?php echo __('Ton', 'aution'); ?>', value: '170', select: false },
            { label: '180<?php echo __('Ton', 'aution'); ?>', value: '180', select: false },
            { label: '200<?php echo __('Ton', 'aution'); ?>', value: '200', select: false },
            { label: '220<?php echo __('Ton', 'aution'); ?>', value: '220', select: false },
            { label: '250<?php echo __('Ton', 'aution'); ?>', value: '250', select: false },
            { label: '280<?php echo __('Ton', 'aution'); ?>', value: '280', select: false },
            { label: '300<?php echo __('Ton', 'aution'); ?>', value: '300', select: false },
            { label: '315<?php echo __('Ton', 'aution'); ?>', value: '315', select: false },
            { label: '350<?php echo __('Ton', 'aution'); ?>', value: '350', select: false },
            { label: '380<?php echo __('Ton', 'aution'); ?>', value: '380', select: false },
            { label: '400<?php echo __('Ton', 'aution'); ?>', value: '400', select: false },
            { label: '415<?php echo __('Ton', 'aution'); ?>', value: '415', select: false },
            { label: '450<?php echo __('Ton', 'aution'); ?>', value: '450', select: false },
            { label: '480<?php echo __('Ton', 'aution'); ?>', value: '480', select: false },
            { label: '500<?php echo __('Ton', 'aution'); ?>', value: '500', select: false },
            { label: '550<?php echo __('Ton', 'aution'); ?>', value: '550', select: false },
            { label: '600<?php echo __('Ton', 'aution'); ?>', value: '600', select: false },
            { label: '650<?php echo __('Ton', 'aution'); ?>', value: '650', select: false },
            { label: '800<?php echo __('Ton', 'aution'); ?>', value: '800', select: false },
            { label: '850<?php echo __('Ton', 'aution'); ?>', value: '850', select: false },
            { label: '1000<?php echo __('Ton', 'aution'); ?>', value: '1000', select: false },
            { label: '1100<?php echo __('Ton', 'aution'); ?>', value: '1100', select: false },
            { label: '1300<?php echo __('Ton', 'aution'); ?>', value: '1300', select: false },
            { label: '1500<?php echo __('Ton', 'aution'); ?>', value: '1500', select: false },
            { label: '1800<?php echo __('Ton', 'aution'); ?>', value: '1800', select: false },
            { label: '2000<?php echo __('Ton', 'aution'); ?>', value: '2000', select: false },
            { label: '2500<?php echo __('Ton', 'aution'); ?>', value: '2500', select: false },
            { label: '3000<?php echo __('Ton', 'aution'); ?>', value: '3000', select: false }
         ],

         screw_pine_select: [
            { label: 'Φ5', value: '5', select: false },
            { label: 'Φ8', value: '8', select: false },
            { label: 'Φ10', value: '10', select: false },
            { label: 'Φ12', value: '12', select: false },
            { label: 'Φ14', value: '14', select: false },
            { label: 'Φ16', value: '16', select: false },
            { label: 'Φ18', value: '18', select: false },
            { label: 'Φ20', value: '20', select: false },
            { label: 'Φ22', value: '22', select: false },
            { label: 'Φ24', value: '24', select: false },
            { label: 'Φ25', value: '25', select: false },
            { label: 'Φ26', value: '26', select: false },
            { label: 'Φ28', value: '28', select: false },
            { label: 'Φ30', value: '30', select: false },
            { label: 'Φ32', value: '32', select: false },
            { label: 'Φ35', value: '35', select: false },
            { label: 'Φ36', value: '36', select: false },
            { label: 'Φ38', value: '38', select: false },
            { label: 'Φ40', value: '40', select: false },
            { label: 'Φ42', value: '42', select: false },
            { label: 'Φ45', value: '45', select: false },
            { label: 'Φ46', value: '46', select: false },
            { label: 'Φ48', value: '48', select: false },
            { label: 'Φ50', value: '50', select: false },
            { label: 'Φ52', value: '52', select: false },
            { label: 'Φ55', value: '55', select: false },
            { label: 'Φ56', value: '56', select: false },
            { label: 'Φ58', value: '58', select: false },
            { label: 'Φ60', value: '60', select: false },
            { label: 'Φ63', value: '63', select: false },
            { label: 'Φ65', value: '65', select: false },
            { label: 'Φ68', value: '68', select: false },
            { label: 'Φ70', value: '70', select: false },
            { label: 'Φ71', value: '71', select: false },
            { label: 'Φ73', value: '73', select: false },
            { label: 'Φ75', value: '75', select: false },
            { label: 'Φ80', value: '80', select: false },
            { label: 'Φ85', value: '85', select: false },
            { label: 'Φ90', value: '90', select: false },
            { label: 'Φ95', value: '95', select: false },
            { label: 'Φ100', value: '100', select: false },
            { label: 'Φ110', value: '110', select: false },
            { label: 'Φ120', value: '120', select: false },
            { label: 'Φ130', value: '130', select: false },
            { label: 'Φ150', value: '150', select: false },
         ],

         resin_type_select: [
            { label: 'PP', value: 'PP', select: false },
            { label: 'PE', value: 'PE', select: false },
            { label: 'PS', value: 'PS', select: false },
            { label: 'PET', value: 'PET', select: false },
            { label: 'PETG', value: 'PETG', select: false },
            { label: 'SAN', value: 'SAN', select: false },
            { label: 'ABS', value: 'ABS', select: false },
            { label: 'PP+ABS', value: 'PP+ABS', select: false },
            { label: 'PA', value: 'PA', select: false },
            { label: 'PA6', value: 'PA6', select: false },
            { label: 'PA66', value: 'PA66', select: false },
            { label: 'PC', value: 'PC', select: false },
            { label: 'PC+ABS', value: 'PC+ABS', select: false },
            { label: 'PMMA', value: 'PMMA', select: false },
            { label: 'PPS', value: 'PPS', select: false },
            { label: 'POM', value: 'POM', select: false },
            { label: 'LDPE', value: 'LDPE', select: false },
            { label: '<?php echo __('Fluoropolymer', 'aution'); ?>', value: 'Fluoropolymer', select: false },
            { label: '<?php echo __('Phenolic resin', 'aution'); ?>', value: 'Phenolic resin', select: false },
            { label: '<?php echo __('Epoxy', 'aution'); ?>', value: 'Epoxy', select: false },
            { label: '<?php echo __('Eco-friendly resin', 'aution')?>', value: 'Eco-friendly resin', select: false },
            { label: '<?php echo __('Glass Fiber 20%', 'aution'); ?>', value: 'Glass Fiber 20%', select: false },
            { label: '<?php echo __('Glass Fiber 40%', 'aution'); ?>', value: 'Glass Fiber 40%', select: false },
            { label: '<?php echo __('More than 40% Glass Fiber', 'aution'); ?>', value: 'More than 40% Glass Fiber', select: false},
            { label: '<?php echo __('Unknow', 'aution'); ?>', value: 'Unknow', select: false },
         ],

         operation_mode_select: [
            { label: '<?php 
               if( get_locale() == 'ko_KR' ){ echo '전동식'; }else{
               echo __('Electric', 'aution'); }
            ?>', value: 'Electric', select: false },
            { label: '<?php 
               if( get_locale() == 'ko_KR' ){ echo '하이브리드'; }else{
               echo __('Hybric', 'aution'); }
            ?>', value: 'Hybric', select: false },
            { label: '<?php 
               if( get_locale() == 'ko_KR' ){ echo '유압식'; }else{
               echo __('Hydraulic', 'aution'); }
            ?>', value: 'Hydraulic', select: false }
         ],

         planned_product_select: [
            { label: '<?php echo __('Home appliances', 'aution'); ?>', value: 'Home appliances', select: false },
            { label: '<?php echo __('Automotive parts', 'aution'); ?>', value: 'Automotive parts', select: false },
            { label: '<?php echo __('Daily supplies', 'aution'); ?>', value: 'Daily supplies', select: false },
            { label: '<?php echo __('Precision parts', 'aution'); ?>', value: 'Precision parts', select: false },
            { label: '<?php echo __('Optical products', 'aution'); ?>', value: 'Optical products', select: false },
            { label: '<?php echo __('Connectors', 'aution'); ?>', value: 'Connectors', select: false },
            { label: '<?php echo __('Various containers', 'aution'); ?>', value: 'Various containers', select: false },
            { label: '<?php echo __('Unknow', 'aution'); ?>', value: 'Unknow', select: false },
         ],

         // FORM SELECT 3

         robot_arm_length_select: [
            { label: '650', value: '650', select: false },
            { label: '800', value: '800', select: false },
            { label: '1000', value: '1000', select: false },
            { label: '1200', value: '1200', select: false },
            { label: '1400', value: '1400', select: false },
            { label: '1700', value: '1700', select: false },
            { label: '2000', value: '2000', select: false },
            { label: '2500', value: '2500', select: false },
            { label: '3000', value: '3000', select: false },
         ],

         special_jig_manufacturing_request_select: [
            { label: '<?php echo __('Yes', 'aution'); ?>', value: 'Yes', select: false },
            { label: '<?php echo __('No', 'aution'); ?>', value: 'No', select: false },
            { label: '<?php echo __('Unknow', 'aution'); ?>', value: 'Unknow', select: false },
         ],

         // FORM SELECT 4

         drying_method_select: [
            { label: '<?php echo __('Hot air', 'aution'); ?>', value: 'Hot air', select: false },
            { label: '<?php echo __('Desiccant', 'aution'); ?>', value: 'Desiccant', select: false },
            { label: '<?php echo __('Electric', 'aution'); ?>', value: 'Electric', select: false },
            { label: '<?php echo __('Mixed', 'aution'); ?>', value: 'Mixed', select: false },
         ],

         drying_capacity_select: [
            { label: '15L (18kg)', value: '15L (18kg)', select: false },
            { label: '30L (36kg)', value: '30L (36kg)', select: false },
            { label: '50L (60kg)', value: '50L (60kg)', select: false },
            { label: '75L (90kg)', value: '75L (90kg)', select: false },
            { label: '80L (96kg)', value: '80L (96kg)', select: false },
            { label: '100L (120kg)', value: '100L (120kg)', select: false },
            { label: '150L (180kg)', value: '150L (180kg)', select: false },
            { label: '150L (180kg)', value: '150L (180kg)', select: false }
         ],

         // FORM SELECT 5

         mold_temperature_control_method_select: [
            { label: '<?php echo __('Oil temperature control', 'aution'); ?>', value: 'Oil temperature control', select: false },
            { label: '<?php echo __('Water temperature control', 'aution'); ?>', value: 'Water temperature control', select: false },
            { label: '<?php echo __('Chiller', 'aution') ;?>', value: 'Chiller', select: false }
         ],

         maximum_mold_temperature_select: [
            { label: '<?php echo __('100 degrees', 'aution'); ?>', value: '100 degrees', select: false },
            { label: '<?php echo __('160 degrees', 'aution'); ?>', value: '160 degrees', select: false },
            { label: '<?php echo __('Over 200 degrees', 'aution'); ?>', value: 'Over 200 degrees', select: false }
         ],

         mold_temperature_control_channels_select: [
            { label: '<?php echo __("2ch", "aution"); ?>', value: '2ch', select: false },
            { label: '<?php echo __("4ch", "aution"); ?>', value: '4ch', select: false }
         ],

         // FORM SELECT 6

         repelletizing_method_select: [
            { label: '<?php echo __('High-speed crusher', 'aution'); ?>', value: 'High-speed crusher', select: false },
            { label: '<?php echo __('Low-speed crusher (granting machine)', 'aution'); ?>', value: 'Low-speed crusher (granting machine)', select: false },
            { label: '<?php echo __('Small extruder', 'aution'); ?>', value: 'Small extruder', select: false },
            { label: '<?php echo __('Large extruder', 'aution'); ?>', value: 'Large extruder', select: false }
         ],

         resin_types_for_tepelletizing_select: [
            { label: 'PP', value: 'PP', select: false },
            { label: 'PE', value: 'PE', select: false },
            { label: 'PS', value: 'PS', select: false },
            { label: 'PET', value: 'PET', select: false },
            { label: 'PETG', value: 'PETG', select: false },
            { label: 'SAN', value: 'SAN', select: false },
            { label: 'ABS', value: 'ABS', select: false },
            { label: 'PP+ABS', value: 'PP+ABS', select: false },
            { label: 'PA', value: 'PA', select: false },
            { label: 'PA6', value: 'PA6', select: false },
            { label: 'PA66', value: 'PA66', select: false },
            { label: 'PC', value: 'PC', select: false },
            { label: 'PC+ABS', value: 'PC+ABS', select: false },
            { label: 'PMMA', value: 'PMMA', select: false },
            { label: 'PPS', value: 'PPS', select: false },
            { label: 'POM', value: 'POM', select: false },
            { label: 'LDPE', value: 'LDPE', select: false },
            { label: '<?php echo __('Fluoropolymer', 'aution'); ?>', value: 'Fluoropolymer', select: false },
            { label: '<?php echo __('Phenolic resin', 'aution'); ?>', value: 'Phenolic resin', select: false },
            { label: '<?php echo __('Epoxy', 'aution'); ?>', value: 'Epoxy', select: false },
            { label: '<?php echo __('Eco-friendly resin', 'aution'); ?>', value: 'Eco-friendly resin', select: false }
         ],

         repelletizing_production_capacity_select: [
            { label: '2kg', value: '2kg', select: false },
            { label: '5kg', value: '5kg', select: false },
            { label: '10kg', value: '10kg', select: false },
            { label: '20kg', value: '20kg', select: false },
            { label: '30kg', value: '30kg', select: false },
            { label: '50kg', value: '50kg', select: false },
            { label: '100kg', value: '100kg', select: false },
            { label: '<?php echo __('Unknow', 'aution'); ?>', value: 'Unknow', select: false },
         ],

         // MODAL SETTING
         modal_title: '',
         stage_select: [],

      }
   },

   watch: {

      product_name: function( val ){
         this.show_apply_form_error = false;
         this.show_next_form_error = false;

         for (const key in this.form) {
            if (this.form.hasOwnProperty(key)) {this.form[key] = false;}
         }
         switch( parseInt(val) ){
            case 18: this.form.form_2 = true; this.product_name_full = '<?php echo __("Injection Molding Machine", "aution"); ?>'; 
               this.product_name_full_no_translate = 'Injection Molding Machine'; 
               this.reset_all_form_3();
               this.reset_all_form_4();
               this.reset_all_form_5();
               this.reset_all_form_6();
               this.re_stream_can_next_form();
            break;
            case 19: this.form.form_3 = true; this.product_name_full = '<?php echo __("Industrial Robot", "aution"); ?>'; 
               this.product_name_full_no_translate = 'Industrial Robot'; 
               this.reset_all_form_2();
               this.reset_all_form_4();
               this.reset_all_form_5();
               this.reset_all_form_6();
               this.re_stream_can_next_form();
            break;
            case 20: this.form.form_4 = true; this.product_name_full = '<?php echo __("Resin Dryer", "aution"); ?>'; 
            this.product_name_full_no_translate = 'Resin Dryer'; 
               this.reset_all_form_2();
               this.reset_all_form_3();
               this.reset_all_form_5();
               this.reset_all_form_6();
               this.re_stream_can_next_form();
            break;
            case 21: this.form.form_5 = true; this.product_name_full = '<?php echo __("Mold Temperature Controller", "aution")?>'; 
               this.product_name_full_no_translate = 'Mold Temperature Controller';
               this.reset_all_form_2();
               this.reset_all_form_3();
               this.reset_all_form_4();
               this.reset_all_form_6();
               this.re_stream_can_next_form();
            break;
            case 22: this.form.form_6 = true; this.product_name_full = '<?php echo __("Pelletizing Machine", "aution")?>'; 
               this.product_name_full_no_translate = 'Pelletizing Machine';
               this.reset_all_form_2();
               this.reset_all_form_3();
               this.reset_all_form_4();
               this.reset_all_form_5();
               this.re_stream_can_next_form();
            break;
         }
      },

      // CHECK FORM REQUEST
      form_step_data: {
         handler( data ){

            function select_date_min( date ){
               var currentDate = new Date();
               currentDate.setHours(0, 0, 0, 0);
               var minimumDate = new Date(date);
               minimumDate.setHours(0, 0, 0, 0);
               if (currentDate > minimumDate) {
                  return false;
               } else {
                  return true;
               }
            }

            this.upload_count = data.production_imagine.length;
            if(
               data.desired_year_of_manufacture_for_used_machines != '' &&
               data.status_of_machine                             != '' &&
               data.quantity                                      != '' &&
               data.installation_location                         != '' &&
               data.delivery_terms                                != '' &&
               (data.desired_delivery_date != '' && select_date_min(data.desired_delivery_date) == true) && 
               data.production_items                              != ''
            ){
               this.can_apply_form = true;
            }else{
               this.can_apply_form = false;
            }
         },
         deep: true
      },

      input_Machine_Tonnage: function( val ){
         this.machine_tonnage_select.forEach( item => {if(item.label != val ){ item.select = false; }});
      },
      input_Screw_Pine: function( val ){
         this.screw_pine_select.forEach( item => {if(item.label != val ){ item.select = false; }});
      },
      input_Resin_Type: function( val ){
         this.resin_type_select.forEach( item => {if(item.label != val ){ item.select = false; }});
      },
      input_Robot_arm_length: function( val ){
         this.robot_arm_length_select.forEach( item => {if(item.label != val ){ item.select = false; }});
      },
      input_Drying_capacity: function( val ){
         this.drying_capacity_select.forEach( item => {if(item.label != val ){ item.select = false; }});
      },
      input_Mold_Temperature_Control_Method: function( val ){
         this.mold_temperature_control_method_select.forEach( item => {if(item.label != val ){ item.select = false; }});
      },
      input_Maximum_Mold_Temperature: function( val ){
         this.maximum_mold_temperature_select.forEach( item => {if(item.label != val ){ item.select = false; }});
      },
      input_Mold_Temperature_Control_Channels: function( val ){
         this.mold_temperature_control_channels_select.forEach( item => {if(item.label != val ){ item.select = false; }});
      },
      input_Repelletizing_Method: function( val ){
         this.repelletizing_method_select.forEach( item => {if(item.label != val ){ item.select = false; }});
      },
      input_Resin_Types_for_Repelletizing: function( val ){
         this.resin_types_for_tepelletizing_select.forEach( item => {if(item.label != val ){ item.select = false; }});
      },
      input_Repelletizing_Production_Capacity: function( val ){
         this.repelletizing_production_capacity_select.forEach( item => {if(item.label != val ){ item.select = false; }});
      },

   },

   computed: {

      get_list_select(){

         // FORM 2
         if( this.modal_title == '<?php echo __("Type of Machine", "aution");?>' )  return this.type_of_machine_select;
         if( this.modal_title == '<?php echo __("Machine Tonnage", "aution");?>' )  return this.machine_tonnage_select;
         if( this.modal_title == '<?php echo $text_screw_pie; ?>' )       return this.screw_pine_select;
         if( this.modal_title == '<?php echo __("Resin Type", "aution");?>' )       return this.resin_type_select;
         if( this.modal_title == '<?php echo __("Product (or Planned Product)", "aution");?>' ) return this.planned_product_select;
         if( this.modal_title == '<?php echo __("Operation Mode", "aution");?>' )   return this.operation_mode_select;

         // FORM 3
         if( this.modal_title == '<?php echo __("Robot Arm Length", "aution"); ?>' ) return this.robot_arm_length_select;
         if( this.modal_title == '<?php echo __("Special Jig Manufacturing Request", "aution"); ?>' ) return this.special_jig_manufacturing_request_select;

         // FORM 4
         if( this.modal_title == '<?php echo __("Drying Method", "aution"); ?>' )    return this.drying_method_select;
         if( this.modal_title == '<?php echo __("Drying Capacity", "aution"); ?>' )  return this.drying_capacity_select;

         // FORM 5
         if( this.modal_title == '<?php echo __("Mold Temperature Control Method", "aution"); ?>' )    return this.mold_temperature_control_method_select;
         if( this.modal_title == '<?php echo __("Maximum Mold Temperature", "aution"); ?>' )           return this.maximum_mold_temperature_select;
         if( this.modal_title == '<?php echo __("Mold Temperature Control Channels", "aution"); ?>' )  return this.mold_temperature_control_channels_select;

         // FORM 6
         if( this.modal_title == '<?php echo __("Repelletizing Method", "aution"); ?>' ) return this.repelletizing_method_select;
         if( this.modal_title == '<?php echo __("Resin Types for Repelletizing", "aution"); ?>' ) return this.resin_types_for_tepelletizing_select;
         if( this.modal_title == '<?php echo __("Repelletizing Production Capacity (Kg/h)", "aution"); ?>' ) return this.repelletizing_production_capacity_select;

         return this.stage_select;
      },

   },

   methods: {

      async request(formdata ){
         try{
            return axios({ method: 'post', url: '<?php echo admin_url('admin-ajax.php'); ?>', data: formdata
            }).then(function (res) { 
               return res.status == 200 ? res.data.data : null;
            });
         }catch(e){
            console.log(e);
            return null;
         }
      },

      select_quantity( q ){
         this.quantity_enter_enable = false;
         for (const key in this.quantity_mem) {
            if (this.quantity_mem.hasOwnProperty(key)) {this.quantity_mem[key].select = false;}
         }
         q.select = true;
         this.form_step_data.quantity = q.value;
      },
      select_quantity_enter(){
         this.quantity_enter_enable = !this.quantity_enter_enable;
         this.form_step_data.quantity = '';
         // DISABLE ALL SELECT QUANTITY NUMBER
         for (const key in this.quantity_mem) {
            if (this.quantity_mem.hasOwnProperty(key)) {this.quantity_mem[key].select = false;}
         }
      },

      re_stream_can_next_form( name_form ){
         this.can_next_form = false;

         if( this.form.form_2 == true ){
            if( 
               this.form_2_data.type_of_machine != '' &&
               this.form_2_data.machine_tonnage != '' &&
               this.form_2_data.screw_pine != '' &&
               this.form_2_data.resin_type != '' &&
               this.form_2_data.planned_product != '' &&
               this.form_2_data.operation_mode != ''
            ){
               this.can_next_form = true;
            }else{
               this.can_next_form = false;
            }
         }
         if( this.form.form_3 == true ){
            if(
               this.form_3_data.robot_arm_length != '' &&
               this.form_3_data.special_jig_manufacturing_request
            ) {
               this.can_next_form = true;
            }else{
               this.can_next_form = false;
            }
         }
         if( this.form.form_4 == true ){
            if(
               this.form_4_data.drying_method != '' &&
               this.form_4_data.drying_capacity != ''
            ){
               this.can_next_form = true;
            }else{
               this.can_next_form = false;
            }
         }
         if( this.form.form_5 == true ){
            if(
               this.form_5_data.mold_temperature_control_method != '' &&
               this.form_5_data.maximum_mold_temperature != '' &&
               this.form_5_data.mold_temperature_control_channels != ''
            ){
               this.can_next_form = true;
            }else{
               this.can_next_form = false;
            }
         }
         if( this.form.form_6 == true ){
            if(
               this.form_6_data.repelletizing_method != '' &&
               this.form_6_data.resin_types_for_tepelletizing != '' &&
               this.form_6_data.repelletizing_production_capacity != ''
            ){
               this.can_next_form = true;
            }else{
               this.can_next_form = false;
            }
         }
      },

      reset_form_step_data(){
         this.form_step_data.desired_year_of_manufacture_for_used_machines = '';
         this.form_step_data.other_quotation_request_details = '';
         this.form_step_data.status_of_machine = '';
         this.form_step_data.quantity = '';
         this.form_step_data.installation_location = '';
         this.form_step_data.delivery_terms = '';
         this.form_step_data.desired_delivery_date = '';
         this.form_step_data.production_items = '';
         this.form_step_data.production_imagine = [];
      },

      reset_all_form_2(){
         for (const key in this.type_of_machine_select) {if (this.type_of_machine_select.hasOwnProperty(key)) {this.type_of_machine_select[key].select = false;}}
         for (const key in this.machine_tonnage_select) {if (this.machine_tonnage_select.hasOwnProperty(key)) {this.machine_tonnage_select[key].select = false;}}
         for (const key in this.screw_pine_select) {if (this.screw_pine_select.hasOwnProperty(key)) {this.screw_pine_select[key].select = false;}}
         for (const key in this.resin_type_select) {if (this.resin_type_select.hasOwnProperty(key)) {this.resin_type_select[key].select = false;}}
         for (const key in this.operation_mode_select) {if (this.operation_mode_select.hasOwnProperty(key)) {this.operation_mode_select[key].select = false;}}
         for (const key in this.planned_product_select) {if (this.planned_product_select.hasOwnProperty(key)) {this.planned_product_select[key].select = false;}}
         for (const key in this.form_2_data) {if (this.form_2_data.hasOwnProperty(key)) { this.form_2_data[key] = '';}}         
         this.input_Machine_Tonnage = '';
         this.input_Screw_Pine = '';
         this.input_Resin_Type = '';
      },

      reset_all_form_3(){
         for (const key in this.robot_arm_length_select) {if (this.robot_arm_length_select.hasOwnProperty(key)) {this.robot_arm_length_select[key].select = false;}}
         for (const key in this.special_jig_manufacturing_request_select) {if (this.special_jig_manufacturing_request_select.hasOwnProperty(key)) {this.special_jig_manufacturing_request_select[key].select = false;}}
         for (const key in this.form_3_data) {if (this.form_3_data.hasOwnProperty(key)) { this.form_3_data[key] = '';}}
         this.input_Robot_arm_length = '';
      },

      reset_all_form_4(){
         for (const key in this.drying_method_select) {if (this.drying_method_select.hasOwnProperty(key)) {this.drying_method_select[key].select = false;}}
         for (const key in this.drying_capacity_select) {if (this.drying_capacity_select.hasOwnProperty(key)) {this.drying_capacity_select[key].select = false;}}
         for (const key in this.form_4_data) {if (this.form_4_data.hasOwnProperty(key)) { this.form_4_data[key] = '';}}
         this.input_Drying_capacity = '';
      },
      
      reset_all_form_5(){
         for (const key in this.mold_temperature_control_method_select) {if (this.mold_temperature_control_method_select.hasOwnProperty(key)) {this.mold_temperature_control_method_select[key].select = false;}}
         for (const key in this.maximum_mold_temperature_select) {if (this.maximum_mold_temperature_select.hasOwnProperty(key)) {this.maximum_mold_temperature_select[key].select = false;}}
         for (const key in this.mold_temperature_control_channels_select) {if (this.mold_temperature_control_channels_select.hasOwnProperty(key)) {this.mold_temperature_control_channels_select[key].select = false;}}
         for (const key in this.form_5_data) {if (this.form_5_data.hasOwnProperty(key)) { this.form_5_data[key] = '';}}
         this.input_Mold_Temperature_Control_Method = '';
         this.input_Maximum_Mold_Temperature = '';
         this.input_Mold_Temperature_Control_Channels = '';

      },

      reset_all_form_6(){
         for (const key in this.repelletizing_method_select) {if (this.repelletizing_method_select.hasOwnProperty(key)) {this.repelletizing_method_select[key].select = false;}}
         for (const key in this.resin_types_for_tepelletizing_select) {if (this.resin_types_for_tepelletizing_select.hasOwnProperty(key)) {this.resin_types_for_tepelletizing_select[key].select = false;}}
         for (const key in this.repelletizing_production_capacity_select) {if (this.repelletizing_production_capacity_select.hasOwnProperty(key)) {this.repelletizing_production_capacity_select[key].select = false;}}
         for (const key in this.form_6_data) {if (this.form_6_data.hasOwnProperty(key)) { this.form_6_data[key] = '';}}
         this.input_Repelletizing_Method = '';
         this.input_Resin_Types_for_Repelletizing = '';
         this.input_Repelletizing_Production_Capacity = '';
      },

      close_modal(){
         var modal_select = new bootstrap.Modal(document.getElementById('exampleModalFxullscreen'));
         modal_select.hide();
      },

      close_modal_next_form(){
         var modal_next = new bootstrap.Modal(document.getElementById('modal-form-step'));
         modal_next.hide();
      },

      go_to_next_form(){
         if( this.can_next_form == true ){
            this.show_next_form_error = false;
            var modal_form_step = new bootstrap.Modal(document.getElementById('modal-form-step'));
            modal_form_step.show();
         }else{
            this.show_next_form_error = true;
         }
      },

      // FILL TITLE TO MODEL
      open_modal( title ){
         
         switch( title ){

            // FORM 2
            case 'type_of_machine':   this.modal_title = '<?php echo __("Type of Machine", "aution"); ?>';  break;
            case 'machine_tonnage':   this.modal_title = '<?php echo __("Machine Tonnage", "aution");?>';  break;
            case 'screw_pine':        this.modal_title = '<?php echo $text_screw_pie; ?>';       break;
            case 'resin_type':        this.modal_title = '<?php echo __("Resin Type", "aution"); ?>';       break;
            case 'planned_product':   this.modal_title = '<?php echo __("Product (or Planned Product)", "aution"); ?>';   break;
            case 'operation_mode':    this.modal_title = '<?php echo __("Operation Mode", "aution"); ?>'; break;
            
            // FORM 3
            case 'robot_arm_length':                  this.modal_title = '<?php echo __("Robot Arm Length", "aution");?>'; break;
            case 'special_jig_manufacturing_request': this.modal_title = '<?php echo __("Special Jig Manufacturing Request", "aution");?>'; break;

            // FORM 4
            case 'drying_method':   this.modal_title = '<?php echo __("Drying Method", "aution")?>'; break;
            case 'drying_capacity': this.modal_title = '<?php echo __("Drying Capacity", "aution")?>'; break;

            // FORM 5
            case 'mold_temperature_control_method':   this.modal_title = '<?php echo __("Mold Temperature Control Method", "aution")?>'; break;
            case 'maximum_mold_temperature':          this.modal_title = '<?php echo __("Maximum Mold Temperature", "aution")?>'; break;
            case 'mold_temperature_control_channels': this.modal_title = '<?php echo __("Mold Temperature Control Channels", "aution")?>'; break;

            // FORM 6

            case 'repelletizing_method': this.modal_title = '<?php echo __("Repelletizing Method", "aution");?>'; break;
            case 'resin_types_for_tepelletizing': this.modal_title = '<?php echo __("Resin Types for Repelletizing", "aution");?>'; break;
            case 'repelletizing_production_capacity': this.modal_title = '<?php echo __("Repelletizing Production Capacity (Kg/h)", "aution");?>'; break;


         }

         var modal_select = new bootstrap.Modal(document.getElementById('exampleModalFxullscreen'));
         modal_select.show();
      },

      autoResize() {
         const scrollHeight = this.$refs.textarea.scrollHeight;
         const maxHeight = 125;
         if (scrollHeight > maxHeight) {
            this.$refs.textarea.style.height = 'auto';
            this.$refs.textarea.style.height = this.$refs.textarea.scrollHeight + 'px';
         }
      },

      do_upload(event){
         var files = event.target.files;
         var maxAllowedImages = 2;

         if (this.form_step_data.production_imagine.length + files.length > maxAllowedImages) {
            alert('You can only select up to 2 images.');
            event.target.value = null;
            return;
         }

         if ( files ) {
            for (var i = 0; i < files.length; i++) {
               var file = files[i];
               if (file.type.startsWith('image/')) {
                  var reader = new FileReader();
                  reader.onload = (( file) => (e) => {
                     var cloneFile = new File([file], file.name, { type: file.type, lastModified: file.lastModified });
                     this.form_step_data.production_imagine.push({
                        file: file, imagePreview: e.target.result
                     });
                  })(file);

                  reader.readAsDataURL(file);
                  reader = null;
               }
            }
         }
         // RESET UPLOAD
         jQuery('#uploads')[0].value = '';
      },

      btn_delete_image(indexImage){
         this.form_step_data.production_imagine.splice(indexImage, 1);
      },

      /**
       * @access CONVERT TO VALUE ENGLISH
       */
      convert_data_label_to_english( select_label , data ){
         // FORM 2
            if(select_label == 'type_of_machine' ){
               for( let i = 0; i < this.type_of_machine_select.length; i++){
                  if( data == this.type_of_machine_select[i].label){
                     return this.type_of_machine_select[i].value;
                  }
               }
            }
            if(select_label == 'resin_type' ){
               for( let i = 0; i < this.resin_type_select.length; i++){
                  if( data=== this.resin_type_select[i].label){
                     return this.resin_type_select[i].value;
                  }
               }
            }
            if(select_label == 'planned_product' ){
               for( let i = 0; i < this.planned_product_select.length; i++){
                  if( data == this.planned_product_select[i].label){
                     return this.planned_product_select[i].value;
                  }
               }
            }
            if(select_label == 'operation_mode' ){
               for( let i = 0; i < this.operation_mode_select.length; i++){
                  if( data == this.operation_mode_select[i].label){
                     return this.operation_mode_select[i].value;
                  }
               }
            }

         // FORM 3
         
            if( select_label == 'special_jig_manufacturing_request'){
               for( let i = 0; i < this.special_jig_manufacturing_request_select.length; i++){
                  if( data == this.special_jig_manufacturing_request_select[i].label){
                     return this.special_jig_manufacturing_request_select[i].value;
                  }
               }
            }
         
         // FORM 4
            if( select_label == 'drying_method'){
               for( let i = 0; i < this.drying_method_select.length; i++){
                  if( data == this.drying_method_select[i].label){
                     return this.drying_method_select[i].value;
                  }
               }
            }


         // FORM 5

            if( select_label == 'mold_temperature_control_method'){
               for( let i = 0; i < this.mold_temperature_control_method_select.length; i++){
                  if( data == this.mold_temperature_control_method_select[i].label){
                     return this.mold_temperature_control_method_select[i].value;
                  }
               }
            }

            if( select_label == 'maximum_mold_temperature'){
               for( let i = 0; i < this.maximum_mold_temperature_select.length; i++){
                  if( data == this.maximum_mold_temperature_select[i].label){
                     return this.maximum_mold_temperature_select[i].value;
                  }
               }
            }
            if( select_label == 'mold_temperature_control_channels'){
               for( let i = 0; i < this.mold_temperature_control_channels_select.length; i++){
                  if( data == this.mold_temperature_control_channels_select[i].label){
                     return this.mold_temperature_control_channels_select[i].value;
                  }
               }
            }

         // FORM 6

            if( select_label == 'repelletizing_method'){
               for( let i = 0; i < this.repelletizing_method_select.length; i++){
                  if( data == this.repelletizing_method_select[i].label){
                     return this.repelletizing_method_select[i].value;
                  }
               }
            }
            if( select_label == 'resin_types_for_tepelletizing'){
               for( let i = 0; i < this.resin_types_for_tepelletizing_select.length; i++){
                  if( data == this.resin_types_for_tepelletizing_select[i].label){
                     return this.resin_types_for_tepelletizing_select[i].value;
                  }
               }
            }
            if( select_label == 'repelletizing_production_capacity'){
               for( let i = 0; i < this.repelletizing_production_capacity_select.length; i++){
                  if( data == this.repelletizing_production_capacity_select[i].label){
                     return this.repelletizing_production_capacity_select[i].value;
                  }
               }
            }

            return data;

      },

      async btn_apply_form(){

         if( this.can_apply_form == true ){
            this.show_apply_form_error = false;

            window.addLoading();

            var form = new FormData();
            form.append('action', 'atlantis_request_quotation');
            form.append('product_name', this.product_name_full_no_translate);
            form.append('product_category', parseInt(this.product_name));

            form.append('desired_year_of_manufacture_for_used_machines', this.form_step_data.desired_year_of_manufacture_for_used_machines);
            form.append('other_quotation_request_details', this.form_step_data.other_quotation_request_details);
            form.append('status_of_machine', this.form_step_data.status_of_machine);
            form.append('quantity', parseInt(this.form_step_data.quantity));
            form.append('installation_location', this.form_step_data.installation_location);
            form.append('delivery_terms', this.form_step_data.delivery_terms);
            
            var [year, month, day ] = this.form_step_data.desired_delivery_date.split('-');
            var desired_delivery_date_convert = day + '/' + month + '/' + year;

            form.append('desired_delivery_date', desired_delivery_date_convert);
            form.append('production_items', this.form_step_data.production_items);

            if( this.form_step_data.production_imagine.length > 0 ){
               this.form_step_data.production_imagine.forEach( file => form.append('production_imagine[]', file.file ));
            }


            if( this.form.form_2 == true ) {
               form.append('form', 'form_2');
               form.append('type_of_machine',   this.convert_data_label_to_english("type_of_machine", this.form_2_data.type_of_machine) );
               form.append('machine_tonnage',   this.form_2_data.machine_tonnage);
               form.append('screw_pine',        this.form_2_data.screw_pine);
               form.append('resin_type',        this.convert_data_label_to_english("resin_type", this.form_2_data.resin_type) );
               form.append('planned_product',   this.convert_data_label_to_english("planned_product", this.form_2_data.planned_product) );
               form.append('operation_mode',    this.convert_data_label_to_english("operation_mode", this.form_2_data.operation_mode));
            }
            if( this.form.form_3 == true ){
               form.append('form', 'form_3');
               form.append('robot_arm_length', this.form_3_data.robot_arm_length);
               form.append('special_jig_manufacturing_request', this.convert_data_label_to_english("special_jig_manufacturing_request", this.form_3_data.special_jig_manufacturing_request));
            }
            if( this.form.form_4 == true ){
               form.append('form', 'form_4');
               form.append('drying_method', this.convert_data_label_to_english("drying_method", this.form_4_data.drying_method) );
               form.append('drying_capacity', this.convert_data_label_to_english("drying_capacity", this.form_4_data.drying_capacity) );
            }
            if( this.form.form_5 == true ){
               form.append('form', 'form_5');
               form.append('mold_temperature_control_method', this.convert_data_label_to_english("mold_temperature_control_method", this.form_5_data.mold_temperature_control_method));
               form.append('maximum_mold_temperature', this.convert_data_label_to_english("maximum_mold_temperature", this.form_5_data.maximum_mold_temperature));
               form.append('mold_temperature_control_channels', this.convert_data_label_to_english("mold_temperature_control_channels", this.form_5_data.mold_temperature_control_channels));
            }
            if( this.form.form_6 == true ){
               form.append('form', 'form_6');
               form.append('repelletizing_method', this.convert_data_label_to_english("repelletizing_method", this.form_6_data.repelletizing_method));
               form.append('resin_types_for_tepelletizing', this.convert_data_label_to_english("resin_types_for_tepelletizing", this.form_6_data.resin_types_for_tepelletizing));
               form.append('repelletizing_production_capacity', this.convert_data_label_to_english("repelletizing_production_capacity", this.form_6_data.repelletizing_production_capacity));
            }

            try {
               const requestPromise = this.request(form);
               const immediatePromise = new Promise(resolve => resolve());
               await Promise.race([requestPromise, immediatePromise]);

               window.unLoading();
               var modal_step = new bootstrap.Modal(document.getElementById('modal-form-step'));
               modal_step.hide();
               var modal_successful = new bootstrap.Modal(document.getElementById('modal-successful'));
               modal_successful.show();
            } catch (error) {
               console.error('Error occurred during the request:', error);
            }

         }else{
            this.show_apply_form_error = true;
         }

      },

      is_select_property( name_form ){
         
         if( name_form == '<?php echo __("Type of Machine", "aution"); ?>' ) {
            for (const key in this.type_of_machine_select) {
               if( this.type_of_machine_select[key].select == true ){
                  return true;
                  break;
               }
            }
         }

         if( name_form == '<?php echo __("Machine Tonnage", "aution"); ?>' ) {
            for (const key in this.machine_tonnage_select) {
               if( this.machine_tonnage_select[key].select == true ) {
                  return true;
                  break;
               }
            }
            if(this.input_Machine_Tonnage != '') return true;
         }

         if( name_form == '<?php echo $text_screw_pie; ?>' ) {
            for (const key in this.screw_pine_select) {
               if( this.screw_pine_select[key].select == true ) {
                  return true;
                  break;
               }
            }
            if(this.input_Screw_Pine != '') return true;
         }

         if( name_form == '<?php echo __("Resin Type", "aution"); ?>' ) {
            for (const key in this.resin_type_select) {
               if( this.resin_type_select[key].select == true ) {
                  return true;
                  break;
               }
            }
            if(this.input_Resin_Type != '') return true;
         }
         if( name_form == '<?php echo __("Operation Mode", "aution"); ?>' ) {
            for (const key in this.operation_mode_select) {
               if( this.operation_mode_select[key].select == true ) {
                  return true;
                  break;
               }
            }
         }
         if( name_form == '<?php echo __("Product (or Planned Product)", "aution"); ?>' ) {
            for (const key in this.planned_product_select) {
               if( this.planned_product_select[key].select == true ) {
                  return true;
                  break;
               }
            }
         }
         
         if( name_form == '<?php echo __("Robot Arm Length", "aution"); ?>') {
            for (const key in this.robot_arm_length_select) {
               if( this.robot_arm_length_select[key].select == true ) {
                  return true;
                  break;
               }
            }
            if(this.input_Robot_arm_length != '') return true;
         }

         if( name_form == '<?php echo __("Special Jig Manufacturing Request", "aution"); ?>') {
            for (const key in this.special_jig_manufacturing_request_select) {
               if( this.special_jig_manufacturing_request_select[key].select == true ) {
                  return true;
                  break;
               }
            }
            if( this.input_Drying_capacity != '') return true;
         }
         
         if( name_form == '<?php echo __("Drying Method", "aution"); ?>' ) {
            for (const key in this.drying_method_select) {
               if( this.drying_method_select[key].select == true ) {
                  return true;
                  break;
               }
            }
         }

         if( name_form == '<?php echo __("Drying Capacity", "aution"); ?>' ) {
            for (const key in this.drying_capacity_select) {
               if( this.drying_capacity_select[key].select == true ) {
                  return true;
                  break;
               }
            }
            if(this.input_Drying_capacity != '') return true;
         }

         if( name_form == '<?php echo __("Mold Temperature Control Method", "aution"); ?>' ) {
            for (const key in this.mold_temperature_control_method_select) {
               if( this.mold_temperature_control_method_select[key].select == true ) {
                  return true;
                  break;
               }
            }
            if( this.input_Mold_Temperature_Control_Method != '' ) return true;
         }

         if( name_form == '<?php echo __("Maximum Mold Temperature", "aution"); ?>' ) {
            for (const key in this.maximum_mold_temperature_select) {
               if( this.maximum_mold_temperature_select[key].select == true ) {
                  return true;
                  break;
               }
            }
            if( this.input_Maximum_Mold_Temperature != '' ) return true;
         }

         if( name_form == '<?php echo __("Mold Temperature Control Channels", "aution"); ?>' ) {
            for (const key in this.mold_temperature_control_channels_select) {
               if( this.mold_temperature_control_channels_select[key].select == true ) {
                  return true;
                  break;
               }
            }
            if( this.input_Mold_Temperature_Control_Channels != '' ) return true;
         }
   
         if( name_form == '<?php echo __("Repelletizing Method", "aution"); ?>' ) {
            for (const key in this.repelletizing_method_select) {
               if( this.repelletizing_method_select[key].select == true ) {
                  return true;
                  break;
               }
            }
            if( this.input_Repelletizing_Method != '' ) return true;
         }

         if( name_form == '<?php echo __("Resin Types for Repelletizing", "aution");?>' ){
            for (const key in this.resin_types_for_tepelletizing_select) {
               if( this.resin_types_for_tepelletizing_select[key].select == true ) {
                  return true;
                  break;
               }
            }
            if( this.input_Resin_Types_for_Repelletizing != '' ) return true;
         }

         if( name_form == '<?php echo __("Repelletizing Production Capacity (Kg/h)", "aution"); ?>' ){
            for (const key in this.repelletizing_production_capacity_select) {
               if( this.repelletizing_production_capacity_select[key].select == true ) {
                  return true;
                  break;
               }
            }
            if( this.input_Repelletizing_Production_Capacity != '' ) return true;
         }

         return false;
      },

      remove_select_property( name_form ){
         /**
          * @access FORM 2
          */

         if( name_form == '<?php echo __("Type of Machine", "aution"); ?>' ) {
            for (const key in this.type_of_machine_select) {if (this.type_of_machine_select.hasOwnProperty(key)) {this.type_of_machine_select[key].select = false;}}
            // this.form_2_data.type_of_machine = '';
         }
         if( name_form == '<?php echo __("Machine Tonnage", "aution"); ?>'){
            for (const key in this.machine_tonnage_select) {if (this.machine_tonnage_select.hasOwnProperty(key)) {this.machine_tonnage_select[key].select = false;}}
            this.input_Machine_Tonnage = '';
         }
         if( name_form == '<?php echo $text_screw_pie; ?>'){
            for (const key in this.screw_pine_select) {if (this.screw_pine_select.hasOwnProperty(key)) {this.screw_pine_select[key].select = false;}}
            this.input_Screw_Pine = '';
         }
         if( name_form == '<?php echo __("Resin Type", "aution"); ?>'){
            for (const key in this.resin_type_select) {if (this.resin_type_select.hasOwnProperty(key)) {this.resin_type_select[key].select = false;}}
            this.input_Resin_Type = '';
         }
         if( name_form == '<?php echo __("Operation Mode", "aution"); ?>'){
            for (const key in this.operation_mode_select) {if (this.operation_mode_select.hasOwnProperty(key)) {this.operation_mode_select[key].select = false;}}
            // this.form_2_data.operation_mode = '';
         }
         if( name_form == '<?php echo __("Product (or Planned Product)", "aution"); ?>'){
            for (const key in this.planned_product_select) {if (this.planned_product_select.hasOwnProperty(key)) {this.planned_product_select[key].select = false;}}
            // this.form_2_data.planned_product = '';
         }

         /**
          * @access FORM 3
          */

         if( name_form == '<?php echo __("Robot Arm Length", "aution"); ?>'){
            for (const key in this.robot_arm_length_select) {if (this.robot_arm_length_select.hasOwnProperty(key)) {this.robot_arm_length_select[key].select = false;}}
            this.input_Robot_arm_length = '';
         }
         if( name_form == '<?php echo __("Special Jig Manufacturing Request", "aution"); ?>'){
            for (const key in this.special_jig_manufacturing_request_select) {if (this.special_jig_manufacturing_request_select.hasOwnProperty(key)) {this.special_jig_manufacturing_request_select[key].select = false;}}
            // this.form_3_data.special_jig_manufacturing_request = '';
         }

         /**
          * @access FORM 4
          */

         if( name_form == '<?php echo __("Drying Method", "aution"); ?>'){
            for (const key in this.drying_method_select) {if (this.drying_method_select.hasOwnProperty(key)) {this.drying_method_select[key].select = false;}}
            // this.form_4_data.drying_method = '';
         }
         if( name_form == '<?php echo __("Drying Capacity", "aution"); ?>'){
            for (const key in this.drying_capacity_select) {if (this.drying_capacity_select.hasOwnProperty(key)) {this.drying_capacity_select[key].select = false;}}
            this.input_Drying_capacity = '';
         }

         /**
          * @access FORM 5
          */

         if( name_form == '<?php echo __("Mold Temperature Control Method", "aution"); ?>'){
            for (const key in this.mold_temperature_control_method_select) {if (this.mold_temperature_control_method_select.hasOwnProperty(key)) {this.mold_temperature_control_method_select[key].select = false;}}
            this.input_Mold_Temperature_Control_Method = '';
         }
         if( name_form == '<?php echo __("Maximum Mold Temperature", "aution"); ?>'){
            for (const key in this.maximum_mold_temperature_select) {if (this.maximum_mold_temperature_select.hasOwnProperty(key)) {this.maximum_mold_temperature_select[key].select = false;}}
            this.input_Maximum_Mold_Temperature = '';
         }
         if( name_form == '<?php echo __("Mold Temperature Control Channels", "aution"); ?>'){
            for (const key in this.mold_temperature_control_channels_select) {if (this.mold_temperature_control_channels_select.hasOwnProperty(key)) {this.mold_temperature_control_channels_select[key].select = false;}}
            this.input_Mold_Temperature_Control_Channels = '';
         }

         /**
          * @access FORM 6
          */

         if( name_form == '<?php echo __("Repelletizing Method", "aution"); ?>'){
            for (const key in this.repelletizing_method_select) {if (this.repelletizing_method_select.hasOwnProperty(key)) {this.repelletizing_method_select[key].select = false;}}
            this.input_Repelletizing_Method = '';
         }
         if( name_form == '<?php echo __("Resin Types for Repelletizing", "aution"); ?>'){
            for (const key in this.resin_types_for_tepelletizing_select) {if (this.resin_types_for_tepelletizing_select.hasOwnProperty(key)) {this.resin_types_for_tepelletizing_select[key].select = false;}}
            this.input_Resin_Types_for_Repelletizing = '';
         }
         if( name_form == '<?php echo __("Repelletizing Production Capacity (Kg/h)", "aution"); ?>'){
            for (const key in this.repelletizing_production_capacity_select) {if (this.repelletizing_production_capacity_select.hasOwnProperty(key)) {this.repelletizing_production_capacity_select[key].select = false;}}
            this.input_Repelletizing_Production_Capacity = '';
         }

         this.re_stream_can_next_form();

      },

      select_property( value, name_form ){

         /**
          * @access FORM 2
          */
         if( name_form == '<?php echo __("Type of Machine", "aution"); ?>' ){
            for (const key in this.type_of_machine_select) {
               if (this.type_of_machine_select.hasOwnProperty(key)) {this.type_of_machine_select[key].select = false;}
            }
            value.select = true;
         }
         if( name_form == '<?php echo __("Machine Tonnage", "aution"); ?>'){
            for (const key in this.machine_tonnage_select) {
               if (this.machine_tonnage_select.hasOwnProperty(key)) {this.machine_tonnage_select[key].select = false;}
            }
            value.select = true;
            this.input_Machine_Tonnage = value.label;
         }
         if( name_form == '<?php echo $text_screw_pie; ?>'){
            for (const key in this.screw_pine_select) {
               if (this.screw_pine_select.hasOwnProperty(key)) {this.screw_pine_select[key].select = false;}
            }
            value.select = true;
            this.input_Screw_Pine = value.label;
         }
         if( name_form == '<?php echo __("Resin Type", "aution"); ?>'){
            for (const key in this.resin_type_select) {
               if (this.resin_type_select.hasOwnProperty(key)) {this.resin_type_select[key].select = false;}
            }
            value.select = true;
            this.input_Resin_Type = value.label;
         }
         if( name_form == '<?php echo __("Operation Mode", "aution"); ?>'){
            for (const key in this.operation_mode_select) {
               if (this.operation_mode_select.hasOwnProperty(key)) {this.operation_mode_select[key].select = false;}
            }
            value.select = true;
         }
         if( name_form == '<?php echo __("Product (or Planned Product)", "aution"); ?>'){
            for (const key in this.planned_product_select) {
               if (this.planned_product_select.hasOwnProperty(key)) {this.planned_product_select[key].select = false;}
            }
            value.select = true;
         }

         /**
          * @access FORM 3
          */

         if( name_form == '<?php echo __("Robot Arm Length", "aution"); ?>'){
            for (const key in this.robot_arm_length_select) {
               if (this.robot_arm_length_select.hasOwnProperty(key)) {this.robot_arm_length_select[key].select = false;}
            }
            value.select = true;
            this.input_Robot_arm_length = value.label;
         }
         if( name_form == '<?php echo __("Special Jig Manufacturing Request", "aution"); ?>'){
            for (const key in this.special_jig_manufacturing_request_select) {
               if (this.special_jig_manufacturing_request_select.hasOwnProperty(key)) {this.special_jig_manufacturing_request_select[key].select = false;}
            }
            value.select = true;
         }

         /**
          * @access FORM 4
          */

         if( name_form == '<?php echo __("Drying Method", "aution"); ?>'){
            for (const key in this.drying_method_select) {
               if (this.drying_method_select.hasOwnProperty(key)) {this.drying_method_select[key].select = false;}
            }
            value.select = true;
         }
         if( name_form == '<?php echo __("Drying Capacity", "aution"); ?>'){
            for (const key in this.drying_capacity_select) {
               if (this.drying_capacity_select.hasOwnProperty(key)) {this.drying_capacity_select[key].select = false;}
            }
            value.select = true;
            this.input_Drying_capacity = value.label;
         }

         /**
          * @access FORM 5
          */

         if( name_form == '<?php echo __("Mold Temperature Control Method", "aution"); ?>'){
            for (const key in this.mold_temperature_control_method_select) {
               if (this.mold_temperature_control_method_select.hasOwnProperty(key)) {this.mold_temperature_control_method_select[key].select = false;}
            }
            value.select = true;
            
         }
         if( name_form == '<?php echo __("Maximum Mold Temperature", "aution");?>'){
            for (const key in this.maximum_mold_temperature_select) {
               if (this.maximum_mold_temperature_select.hasOwnProperty(key)) {this.maximum_mold_temperature_select[key].select = false;}
            }
            value.select = true;
            this.input_Maximum_Mold_Temperature = value.label;
         }
         if( name_form == '<?php echo __("Mold Temperature Control Channels", "aution");?>'){
            for (const key in this.mold_temperature_control_channels_select) {
               if (this.mold_temperature_control_channels_select.hasOwnProperty(key)) {this.mold_temperature_control_channels_select[key].select = false;}
            }
            value.select = true;
            this.input_Mold_Temperature_Control_Channels = value.label;
         }

         /**
          * @access FORM 6
          */

         if( name_form == '<?php echo __("Repelletizing Method", "aution");?>'){
            for (const key in this.repelletizing_method_select) {
               if (this.repelletizing_method_select.hasOwnProperty(key)) {this.repelletizing_method_select[key].select = false;}
            }
            value.select = true;
            this.input_Repelletizing_Method = value.label;
         }
         if( name_form == '<?php echo __("Resin Types for Repelletizing", "aution");?>'){
            for (const key in this.resin_types_for_tepelletizing_select) {
               if (this.resin_types_for_tepelletizing_select.hasOwnProperty(key)) {this.resin_types_for_tepelletizing_select[key].select = false;}
            }
            value.select = true;
            this.input_Resin_Types_for_Repelletizing = value.label;
         }
         if( name_form == '<?php echo __("Repelletizing Production Capacity (Kg/h)", "aution");?>'){
            for (const key in this.repelletizing_production_capacity_select) {
               if (this.repelletizing_production_capacity_select.hasOwnProperty(key)) {this.repelletizing_production_capacity_select[key].select = false;}
            }
            value.select = true;
            this.input_Repelletizing_Production_Capacity = value.label;
         }
         
         this.re_stream_can_next_form();

      },

      apply_select_property( name_form ){
         /**
          * @access FORM 2
          */

         if( name_form == '<?php echo __("Type of Machine", "aution")?>' ) {
            for (const key in this.type_of_machine_select) {
               if( this.type_of_machine_select[key].select == true ){
                  this.form_2_data.type_of_machine = this.type_of_machine_select[key].label;
                  break;
               }
            }
         }
         if( name_form == '<?php echo __("Machine Tonnage", "aution")?>'){
            for (const key in this.machine_tonnage_select) {
               if( this.machine_tonnage_select[key].select == true ){
                  this.form_2_data.machine_tonnage = this.machine_tonnage_select[key].value;
                  break;
               }
            }
            if(this.input_Machine_Tonnage != ''){
               this.form_2_data.machine_tonnage = this.input_Machine_Tonnage;
            }
         }
         if( name_form == '<?php echo $text_screw_pie; ?>'){
            for (const key in this.screw_pine_select) {
               if( this.screw_pine_select[key].select == true ){
                  this.form_2_data.screw_pine = this.screw_pine_select[key].label;
                  break;
               }
            }
            if(this.input_Screw_Pine != ''){
               this.form_2_data.screw_pine = this.input_Screw_Pine;
            }
         }
         if( name_form == '<?php echo __("Resin Type", "aution")?>'){
            for (const key in this.resin_type_select) {
               if( this.resin_type_select[key].select == true ){
                  this.form_2_data.resin_type = this.resin_type_select[key].label;
                  break;
               }
            }
            if(this.input_Resin_Type != ''){
               this.form_2_data.resin_type = this.input_Resin_Type;
            }
         }
         if( name_form == '<?php echo __("Operation Mode", "aution"); ?>'){
            for (const key in this.operation_mode_select) {
               if( this.operation_mode_select[key].select == true ){
                  this.form_2_data.operation_mode = this.operation_mode_select[key].label;
                  break;
               }
            }
         }
         if( name_form == '<?php echo __("Product (or Planned Product)", "aution"); ?>'){
            for (const key in this.planned_product_select) {
               if( this.planned_product_select[key].select == true ){
                  this.form_2_data.planned_product = this.planned_product_select[key].label;
                  break;
               }
            }
         }

         /**
          * @access FORM 3
          */

         if( name_form == '<?php echo __("Robot Arm Length", "aution"); ?>'){
            for (const key in this.robot_arm_length_select) {
               if (this.robot_arm_length_select[key].select == true ){
                  this.form_3_data.robot_arm_length = this.robot_arm_length_select[key].label;
               }
            }
            if( this.input_Robot_arm_length != '' ){
               this.form_3_data.robot_arm_length = this.input_Robot_arm_length;
            }
         }
         if( name_form == '<?php echo __("Special Jig Manufacturing Request", "aution")?>'){
            for (const key in this.special_jig_manufacturing_request_select) {
               if ( this.special_jig_manufacturing_request_select[key].select == true ){
                  this.form_3_data.special_jig_manufacturing_request = this.special_jig_manufacturing_request_select[key].label;
               }
            }
         }

         /**
          * @access FORM 4
          */

         if( name_form == '<?php echo __("Drying Method", "aution"); ?>'){
            for (const key in this.drying_method_select) {
               if ( this.drying_method_select[key].select == true ){
                  this.form_4_data.drying_method = this.drying_method_select[key].label;
               }
            }

         }
         if( name_form == '<?php echo __("Drying Capacity", "aution"); ?>'){
            for (const key in this.drying_capacity_select) {
               if ( this.drying_capacity_select[key].select == true ) {
                  this.form_4_data.drying_capacity = this.drying_capacity_select[key].label;
               }
            }
            if( this.input_Drying_capacity != '' ){
               this.form_4_data.drying_capacity = this.input_Drying_capacity;
            }
         }

         /**
          * @access FORM 5
          */

         if( name_form == '<?php echo __("Mold Temperature Control Method", "aution")?>'){
            for (const key in this.mold_temperature_control_method_select) {
               if (this.mold_temperature_control_method_select[key].select == true ){
                  this.form_5_data.mold_temperature_control_method = this.mold_temperature_control_method_select[key].label;
               }
            }
            if( this.input_Mold_Temperature_Control_Method != ''){
               this.form_5_data.mold_temperature_control_method = this.input_Mold_Temperature_Control_Method;
            }
         }
         if( name_form == '<?php echo __("Maximum Mold Temperature", "aution")?>'){
            for (const key in this.maximum_mold_temperature_select) {
               if ( this.maximum_mold_temperature_select[key].select == true ) {
                  this.form_5_data.maximum_mold_temperature = this.maximum_mold_temperature_select[key].label;
               }
            }
            if( this.input_Maximum_Mold_Temperature != ''){
               this.form_5_data.maximum_mold_temperature = this.input_Maximum_Mold_Temperature;
            }
         }
         if( name_form == '<?php echo __("Mold Temperature Control Channels", "aution")?>'){
            for (const key in this.mold_temperature_control_channels_select) {
               if ( this.mold_temperature_control_channels_select[key].select == true) {
                  this.form_5_data.mold_temperature_control_channels = this.mold_temperature_control_channels_select[key].label;
               }
            }
            if( this.input_Mold_Temperature_Control_Channels != ''){
               this.form_5_data.mold_temperature_control_channels = this.input_Mold_Temperature_Control_Channels;
            }
            
         }

         /**
          * @access FORM 6
          */

         if( name_form == '<?php echo __("Repelletizing Method", "aution")?>'){
            for (const key in this.repelletizing_method_select) {
               if ( this.repelletizing_method_select[key].select == true ) {
                  this.form_6_data.repelletizing_method = this.repelletizing_method_select[key].label;
               }
            }
            if( this.input_Repelletizing_Method != '' ){
               this.form_6_data.repelletizing_method = this.input_Repelletizing_Method;
            }
         }
         if( name_form == '<?php echo __("Resin Types for Repelletizing", "aution")?>'){
            for (const key in this.resin_types_for_tepelletizing_select) {
               if ( this.resin_types_for_tepelletizing_select[key].select == true ) {
                  this.form_6_data.resin_types_for_tepelletizing = this.resin_types_for_tepelletizing_select[key].label;
               }
            }
            if( this.input_Resin_Types_for_Repelletizing != '' ){
               this.form_6_data.resin_types_for_tepelletizing = this.input_Resin_Types_for_Repelletizing;
            }
         }
         if( name_form == '<?php echo __("Repelletizing Production Capacity (Kg/h)", "aution")?>'){
            for (const key in this.repelletizing_production_capacity_select) {
               if ( this.repelletizing_production_capacity_select[key].select == true ) {
                  this.form_6_data.repelletizing_production_capacity = this.repelletizing_production_capacity_select[key].label;
               }
            }
            if( this.input_Repelletizing_Production_Capacity != '' ){
               this.form_6_data.repelletizing_production_capacity = this.input_Repelletizing_Production_Capacity;
            }
            
         }

         this.re_stream_can_next_form();

      },
      
      btn_successfully(){
         window.appBridge.navigateTo('Quote', 'quotation_update');
      },


      // 


   },

   mounted(){

   },

   created(){

      // jQuery('#desired_delivery_date');
      

      document.addEventListener('DOMContentLoaded', function() {
         var dateInput = document.getElementById('desired_delivery_date');
         if (dateInput) {
            // Set the minimum date to today minus one day
            var today = new Date();
            today.setDate(today.getDate());
            var minDateString = today.toISOString().split('T')[0];      
            dateInput.min = minDateString;
         }
      });

      setTimeout( () => {this.autoResize();}, 0);
      // var prepend = '대';

      let vueInstance = this;

      var localeData = {
         'en_US': {
            monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            monthNamesShort: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            dayNames: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            dayNamesShort: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],
         },
         'vi': {
            monthNames: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6', 'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'],
            monthNamesShort: ['Th.1', 'Th.2', 'Th.3', 'Th.4', 'Th.5', 'Th.6', 'Th.7', 'Th.8', 'Th.9', 'Th.10', 'Th.11', 'Th.12'],
            dayNames: ['Chủ Nhật', 'Thứ Hai', 'Thứ Ba', 'Thứ Tư', 'Thứ Năm', 'Thứ Sáu', 'Thứ Bảy'],
            dayNamesShort: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7'],
            dayNamesMin: ['CN', 'T2', 'T3', 'T4', 'T5', 'T6', 'T7']
         },
         'ko_KR': {
            monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            monthNamesShort: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
            dayNames: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
            dayNamesShort: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일'],
            dayNamesMin: ['일요일', '월요일', '화요일', '수요일', '목요일', '금요일', '토요일']
         }
      };

      // Get the locale-specific month and day names based on this.locale
      var locale = 'en_US'; // Default to English
      var get_locale = '<?php echo get_locale(); ?>';
      if ( get_locale != undefined && localeData[get_locale] != undefined) {
         locale = get_locale;
      }

      jQuery(document).ready(function($) {
         jQuery('.custom_selecte_2 select').select2();

         jQuery('#product_name').on('change', function (event) {
            vueInstance.product_name = parseInt(event.target.value);
         });
         jQuery('#desired_year_of_manufacture_for_used_machines').on('change', function (event) {
            vueInstance.form_step_data.desired_year_of_manufacture_for_used_machines = event.target.value;
         });
         jQuery('#status_of_machine').on('change', function (event) {
            vueInstance.form_step_data.status_of_machine = event.target.value;
         });
         jQuery('#delivery_terms').on('change', function (event) {
            vueInstance.form_step_data.delivery_terms = event.target.value;
         });
         jQuery('#production_items').on('change', function (event) {
            vueInstance.form_step_data.production_items = event.target.value;
         });

         
         // jQuery('#desired_delivery_date').click(function(){
         //    jQuery('.ui-date-picker-wrapper').addClass('active');
         // });

         // DATE PICKER
         // jQuery('#desired_delivery_date').datepicker({
         //    // dayNamesMin: [ "Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat" ],monthNames:       localeData[locale].monthNames,
         //    monthNamesShort:  localeData[locale].monthNamesShort,
         //    dayNames:         localeData[locale].dayNames,
         //    dayNamesShort:    localeData[locale].dayNamesShort,
         //    dayNamesMin:      localeData[locale].dayNamesMin,
         //    minDate: 0,
         //    dateFormat: "dd/mm/yy",
         //    firstDay: 1,
         //    onSelect: function(dateText, inst){
         //       if(dateText != undefined || dateText != '' || dateText != null){
         //          vueInstance.form_step_data.desired_delivery_date = dateText;
         //       }
         //    },
         //    onClose: function(dateText, inst){
         //       jQuery('#desired_delivery_date').datepicker('hide');
         //       jQuery('.ui-date-picker-wrapper').removeClass('active');
         //    }
         // });

         if( jQuery('.ui-date-picker-wrapper #ui-datepicker-div').length == 0 ){
            jQuery('#ui-datepicker-div').wrap('<div class="ui-date-picker-wrapper"></div>');
         }

      });

   }

}).mount('#app');
// window.app = app;

if( window.appBridge != undefined){
   // window.appBridge.setEnableScroll(false);
}







</script>
<?php
get_footer();