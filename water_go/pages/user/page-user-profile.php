<div id='app-user'>

   <div v-if='loading == false && user != null' class='page-user-profile'>
      <div class='appbar'>
         <div class='appbar-top'>
            <div class='leading'>
               <span class='leading-title'>Home</span>
            </div>
            <div class='action'>
               <div class='btn-badge ml10'>
                  <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6817 0H3.40384C2.58977 0 1.80904 0.334446 1.2334 0.929764C0.657759 1.52508 0.33437 2.33251 0.33437 3.17441V9.52324C0.33437 9.94011 0.413763 10.3529 0.568018 10.738C0.722275 11.1232 0.94837 11.4731 1.2334 11.7679C1.51842 12.0627 1.8568 12.2965 2.22921 12.456C2.60161 12.6155 3.00076 12.6977 3.40384 12.6977H5.24553H9.79695H15.6817C16.4958 12.6977 17.2766 12.3632 17.8522 11.7679C18.4278 11.1726 18.7512 10.3652 18.7512 9.52324V3.17441C18.7512 2.33251 18.4278 1.52508 17.8522 0.929764C17.2766 0.334446 16.4958 0 15.6817 0ZM15.6817 1.26977H3.40384C2.9154 1.26977 2.44696 1.47043 2.10158 1.82762C1.75619 2.18482 1.56216 2.66927 1.56216 3.17441V9.52324C1.56216 10.0284 1.75619 10.5128 2.10158 10.87C2.44696 11.2272 2.9154 11.4279 3.40384 11.4279H15.6817C16.1702 11.4279 16.6386 11.2272 16.984 10.87C17.3294 10.5128 17.5234 10.0284 17.5234 9.52324V3.17441C17.5234 2.66927 17.3294 2.18482 16.984 1.82762C16.6386 1.47043 16.1702 1.26977 15.6817 1.26977Z" fill="#2790F9"/>
                  <path d="M3.40384 1.26977H15.6817C16.1702 1.26977 16.6386 1.47043 16.984 1.82762C17.3294 2.18482 17.5234 2.66927 17.5234 3.17441V9.52324C17.5234 10.0284 17.3294 10.5128 16.984 10.87C16.6386 11.2272 16.1702 11.4279 15.6817 11.4279H3.40384C2.9154 11.4279 2.44696 11.2272 2.10158 10.87C1.75619 10.5128 1.56216 10.0284 1.56216 9.52324V3.17441C1.56216 2.66927 1.75619 2.18482 2.10158 1.82762C2.44696 1.47043 2.9154 1.26977 3.40384 1.26977Z" fill="white"/>
                  <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0577 4.76165H6.7798C6.29136 4.76165 5.82292 4.96232 5.47753 5.31951C5.13215 5.6767 4.93812 6.16115 4.93812 6.6663V13.0151C4.93812 13.5203 5.13215 14.0047 5.47753 14.3619C5.82292 14.7191 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9196 13.0793 14.9359 13.1539 14.9677C13.2285 14.9995 13.2963 15.0462 13.3534 15.1052L15.9882 17.8313V15.5547C15.9882 15.3863 16.0529 15.2248 16.168 15.1057C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7191 20.36 14.3619C20.7054 14.0047 20.8994 13.5203 20.8994 13.0151V6.6663C20.8994 6.16115 20.7054 5.6767 20.36 5.31951C20.0146 4.96232 19.5461 4.76165 19.0577 4.76165ZM6.7798 3.49188H19.0577C19.8718 3.49188 20.6525 3.82633 21.2282 4.42165C21.8038 5.01696 22.1272 5.82439 22.1272 6.6663V13.0151C22.1272 13.432 22.0478 13.8448 21.8935 14.2299C21.7393 14.6151 21.5132 14.965 21.2282 15.2598C20.9431 15.5545 20.6047 15.7884 20.2323 15.9479C19.8599 16.1074 19.4608 16.1895 19.0577 16.1895H17.216V19.364C17.2162 19.4897 17.1804 19.6127 17.1129 19.7173C17.0455 19.8219 16.9495 19.9034 16.8372 19.9516C16.7249 19.9997 16.6013 20.0123 16.4821 19.9877C16.3628 19.9631 16.2533 19.9025 16.1675 19.8135L12.6646 16.1895H6.7798C5.96573 16.1895 5.18499 15.8551 4.60936 15.2598C4.03372 14.6645 3.71033 13.857 3.71033 13.0151V6.6663C3.71033 5.82439 4.03372 5.01696 4.60936 4.42165C5.18499 3.82633 5.96573 3.49188 6.7798 3.49188Z" fill="#2790F9"/>
                  <path d="M19.0577 4.76165H6.7798C6.29136 4.76165 5.82292 4.96232 5.47753 5.31951C5.13215 5.6767 4.93812 6.16115 4.93812 6.6663V13.0151C4.93812 13.5203 5.13215 14.0047 5.47753 14.3619C5.82292 14.7191 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9196 13.0793 14.9359 13.1539 14.9677C13.2285 14.9995 13.2963 15.0462 13.3534 15.1052L15.9882 17.8313V15.5547C15.9882 15.3863 16.0529 15.2248 16.168 15.1057C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7191 20.36 14.3619C20.7054 14.0047 20.8994 13.5203 20.8994 13.0151V6.6663C20.8994 6.16115 20.7054 5.6767 20.36 5.31951C20.0146 4.96232 19.5461 4.76165 19.0577 4.76165Z" fill="white"/>
                  <path d="M10.4639 9.32349C10.4639 9.70494 10.1546 10.0142 9.77319 10.0142C9.39174 10.0142 9.08252 9.70494 9.08252 9.32349C9.08252 8.94204 9.39174 8.63282 9.77319 8.63282C10.1546 8.63282 10.4639 8.94204 10.4639 9.32349Z" fill="#2790F9"/>
                  <path d="M13.5947 9.30974C13.5947 9.69118 13.2855 10.0004 12.904 10.0004C12.5226 10.0004 12.2133 9.69118 12.2133 9.30974C12.2133 8.92829 12.5226 8.61906 12.904 8.61906C13.2855 8.61906 13.5947 8.92829 13.5947 9.30974Z" fill="#2790F9"/>
                  <path d="M16.7027 9.3235C16.7027 9.70494 16.3935 10.0142 16.012 10.0142C15.6306 10.0142 15.3214 9.70494 15.3214 9.3235C15.3214 8.94205 15.6306 8.63282 16.012 8.63282C16.3935 8.63282 16.7027 8.94205 16.7027 9.3235Z" fill="#2790F9"/>
                  </svg>
                  <span class='badge'>8</span>
               </div>
            </div>
         </div>
      </div>

      <div class='inner'>
         <div class='profile-user'>
            <img class='avatar-circle' width='80' height='80' :src="get_image_upload(user.avatar)">

            <div class='user-prefs'>
               <div class='username'>{{ get_first_name_user }}</div>
               <button @click='gotoPageUserEditProfile' class='btn-text arrow-right'>Edit Profile
                  <svg width="7" height="12" viewBox="0 0 7 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M1 11L6 6L1 1" stroke="#2040AF" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
               </button>
            </div>

         </div>

         <div class='list-tile single'>

            <button @click='gotoPageUserDeliveryAddress' class='tile-items'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" fill="#2040AF"/>
               <path d="M20.6 11.3C20.6 10.4727 20.437 9.65345 20.1204 8.88909C19.8038 8.12474 19.3398 7.43024 18.7548 6.84523C18.1698 6.26022 17.4753 5.79616 16.7109 5.47956C15.9466 5.16295 15.1273 5 14.3 5C13.4727 5 12.6534 5.16295 11.8891 5.47956C11.1247 5.79616 10.4302 6.26022 9.84523 6.84523C9.26022 7.43024 8.79616 8.12474 8.47956 8.88909C8.16295 9.65345 8 10.4727 8 11.3C8 12.5483 8.3681 13.7093 8.9945 14.6885H8.9873L14.3 23L19.6127 14.6885H19.6064C20.2552 13.6774 20.6 12.5013 20.6 11.3ZM14.3 14C13.5839 14 12.8972 13.7155 12.3908 13.2092C11.8845 12.7028 11.6 12.0161 11.6 11.3C11.6 10.5839 11.8845 9.89716 12.3908 9.39081C12.8972 8.88446 13.5839 8.6 14.3 8.6C15.0161 8.6 15.7028 8.88446 16.2092 9.39081C16.7155 9.89716 17 10.5839 17 11.3C17 12.0161 16.7155 12.7028 16.2092 13.2092C15.7028 13.7155 15.0161 14 14.3 14Z" fill="white"/>
               </svg>
               <span class='title'>Delivery address</span>
            </button>

            <button @click='gotoPageUserSettings' class='tile-items'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" fill="#2040AF"/>
               <path d="M15.5009 22H12.4996C12.3115 22 12.1291 21.9377 11.9826 21.8233C11.836 21.709 11.7342 21.5494 11.694 21.3712L11.3584 19.864C10.9107 19.6737 10.4862 19.4357 10.0927 19.1544L8.57799 19.6224C8.3987 19.6779 8.20525 19.6722 8.02976 19.6062C7.85427 19.5403 7.7073 19.4181 7.61326 19.26L6.10927 16.7392C6.01622 16.5809 5.98129 16.3967 6.01019 16.2166C6.0391 16.0365 6.13014 15.8713 6.26841 15.748L7.4434 14.708C7.38997 14.2369 7.38997 13.7615 7.4434 13.2904L6.26841 12.2528C6.12994 12.1294 6.03878 11.9641 6.00987 11.7838C5.98096 11.6036 6.016 11.4192 6.10927 11.2608L7.60996 8.7384C7.704 8.58025 7.85097 8.45807 8.02646 8.39215C8.20195 8.32623 8.3954 8.32053 8.57469 8.376L10.0894 8.844C10.2906 8.7 10.5 8.5656 10.7161 8.444C10.9247 8.3304 11.139 8.2272 11.3584 8.1352L11.6948 6.6296C11.7348 6.45136 11.8365 6.29175 11.9829 6.17724C12.1292 6.06273 12.3115 6.00019 12.4996 6H15.5009C15.689 6.00019 15.8713 6.06273 16.0177 6.17724C16.164 6.29175 16.2657 6.45136 16.3057 6.6296L16.6454 8.136C17.0925 8.32741 17.5169 8.56534 17.9111 8.8456L19.4266 8.3776C19.6058 8.32233 19.7991 8.32814 19.9744 8.39405C20.1497 8.45996 20.2965 8.58202 20.3905 8.74L21.8912 11.2624C22.0825 11.588 22.0166 12 21.7321 12.2536L20.5571 13.2936C20.6105 13.7647 20.6105 14.2401 20.5571 14.7112L21.7321 15.7512C22.0166 16.0056 22.0825 16.4168 21.8912 16.7424L20.3905 19.2648C20.2965 19.4229 20.1495 19.5451 19.974 19.6111C19.7986 19.677 19.6051 19.6827 19.4258 19.6272L17.9111 19.1592C17.5179 19.4403 17.0937 19.678 16.6462 19.868L16.3057 21.3712C16.2655 21.5493 16.1638 21.7087 16.0174 21.8231C15.8711 21.9374 15.6889 21.9998 15.5009 22ZM13.997 10.8C13.1222 10.8 12.2833 11.1371 11.6648 11.7373C11.0462 12.3374 10.6987 13.1513 10.6987 14C10.6987 14.8487 11.0462 15.6626 11.6648 16.2627C12.2833 16.8629 13.1222 17.2 13.997 17.2C14.8717 17.2 15.7106 16.8629 16.3291 16.2627C16.9477 15.6626 17.2952 14.8487 17.2952 14C17.2952 13.1513 16.9477 12.3374 16.3291 11.7373C15.7106 11.1371 14.8717 10.8 13.997 10.8Z" fill="white"/>
               </svg>
               <span class='title'>Settings</span>
            </button>
            
            <button @click='gotoSupport' class='tile-items'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" fill="#2040AF"/>
               <path d="M21.7882 17.5057C21.7878 18.5545 21.4293 19.5718 20.772 20.3891C20.1146 21.2064 19.1979 21.7747 18.1735 22L17.6842 20.5321C18.1323 20.4583 18.5584 20.286 18.9319 20.0276C19.3054 19.7693 19.6169 19.4313 19.844 19.0381H17.9534C17.5466 19.0381 17.1565 18.8765 16.8688 18.5888C16.5812 18.3011 16.4195 17.911 16.4195 17.5042V14.4364C16.4195 14.0296 16.5812 13.6394 16.8688 13.3518C17.1565 13.0641 17.5466 12.9025 17.9534 12.9025H20.2067C20.0196 11.4199 19.2978 10.0566 18.1769 9.0683C17.0561 8.08001 15.6131 7.53471 14.1187 7.53471C12.6244 7.53471 11.1814 8.08001 10.0605 9.0683C8.9396 10.0566 8.21786 11.4199 8.03071 12.9025H10.284C10.6908 12.9025 11.081 13.0641 11.3686 13.3518C11.6563 13.6394 11.8179 14.0296 11.8179 14.4364V17.5042C11.8179 17.911 11.6563 18.3011 11.3686 18.5888C11.081 18.8765 10.6908 19.0381 10.284 19.0381H7.98316C7.57634 19.0381 7.18619 18.8765 6.89853 18.5888C6.61087 18.3011 6.44927 17.911 6.44927 17.5042V13.6694C6.44927 9.43361 9.88288 6 14.1187 6C18.3545 6 21.7882 9.43361 21.7882 13.6694V17.5057Z" fill="white"/>
               </svg>
               <span class='title'>Support</span>
            </button>

            <div class='tile-items no-arrow no-border'>
               <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
               <circle cx="14" cy="14" r="14" fill="#2040AF"/>
               <path d="M5.00003 13.5556C4.99659 14.7288 5.30496 15.8861 5.90003 16.9333C6.60559 18.1882 7.69027 19.2437 9.03257 19.9816C10.3749 20.7195 11.9218 21.1106 13.5 21.1111C14.8199 21.1142 16.1219 20.8401 17.3 20.3111L23 22L21.1 16.9333C21.6951 15.8861 22.0034 14.7288 22 13.5556C21.9994 12.1527 21.5594 10.7777 20.7293 9.58451C19.8992 8.39135 18.7118 7.42719 17.3 6.80002C16.1219 6.27107 14.8199 5.99697 13.5 6.00003H13C10.9157 6.10224 8.94698 6.88426 7.47088 8.19634C5.99479 9.50843 5.11502 11.2584 5.00003 13.1111V13.5556Z" fill="white"/>
               <line x1="9.44849" y1="10.7886" x2="17.7243" y2="10.7886" stroke="#2040AF" stroke-width="1.5"/>
               <line x1="9.44849" y1="14.8911" x2="16.0692" y2="14.8911" stroke="#2040AF" stroke-width="1.5"/>
               </svg>
               <span class='title'>My Reviews</span>
            </div>

         </div>

         <div v-for='(review, reviewIndex) in reviews' :key='reviewIndex' class='box-review'>

            <div class='on-head'>
               <div class='on-left'>
                  <div class='tile-3col'>
                     <div class='avatar-cirlce'>
                        <img src="<?php echo THEME_URI . '/assets/images/demo-box-review01.png' ?>" alt="Dummy">
                     </div>
                     <div class='tile-detail'>
                        <span class='title'>{{ review.store_name }}</span>
                        <span class='subtitle'>{{ timestamp_to_date(review.time_created )}}</span>
                     </div>
                  </div>
               </div>
               <div class='on-right'>
                  <svg width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M7.32901 11.7286L3.77618 13.8689C3.61922 13.9688 3.45514 14.0116 3.28391 13.9973C3.11269 13.9831 2.96288 13.926 2.83446 13.8261C2.70604 13.7262 2.60616 13.6012 2.53482 13.4511C2.46348 13.301 2.44921 13.1335 2.49202 12.9486L3.43373 8.9035L0.287545 6.18536C0.144861 6.05695 0.0558259 5.91055 0.0204402 5.74618C-0.0149455 5.58181 -0.00438691 5.42143 0.0521161 5.26505C0.10919 5.1081 0.1948 4.97968 0.308948 4.8798C0.423095 4.77992 0.580048 4.71572 0.779806 4.68718L4.93192 4.32333L6.53712 0.513664C6.60846 0.342443 6.71918 0.214026 6.86929 0.128416C7.01939 0.0428054 7.17263 0 7.32901 0C7.48597 0 7.63921 0.0428054 7.78874 0.128416C7.93828 0.214026 8.049 0.342443 8.12091 0.513664L9.72611 4.32333L13.8782 4.68718C14.078 4.71572 14.2349 4.77992 14.3491 4.8798C14.4632 4.97968 14.5488 5.1081 14.6059 5.26505C14.663 5.422 14.6738 5.58266 14.6384 5.74704C14.6031 5.91141 14.5137 6.05752 14.3705 6.18536L11.2243 8.9035L12.166 12.9486C12.2088 13.1341 12.1945 13.3019 12.1232 13.452C12.0519 13.6021 11.952 13.7268 11.8236 13.8261C11.6952 13.926 11.5453 13.9831 11.3741 13.9973C11.2029 14.0116 11.0388 13.9688 10.8819 13.8689L7.32901 11.7286Z" fill="#FFC83A"/>
                  </svg>
                  <span class='rating-point'>{{ review.rating }}.0</span>
               </div>
            </div>
            <div class='contents'>{{ review.contents}}</div>

            <div class='dropdown-function'>
               <button @click='popup_reivew_action(review.id)' class='btn-icon'>
                  <svg width="14" height="3" viewBox="0 0 14 3" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M1.5 3C1.0875 3 0.734251 2.853 0.440251 2.559C0.146251 2.265 -0.000498727 1.912 1.27335e-06 1.5C1.27335e-06 1.0875 0.147001 0.73425 0.441001 0.440251C0.735001 0.146252 1.088 -0.000498725 1.5 1.27333e-06C1.9125 1.27333e-06 2.26575 0.147002 2.55975 0.441001C2.85375 0.735 3.0005 1.088 3 1.5C3 1.9125 2.853 2.26575 2.559 2.55975C2.265 2.85375 1.912 3.0005 1.5 3ZM7 3C6.5875 3 6.23425 2.853 5.94025 2.559C5.64625 2.265 5.4995 1.912 5.5 1.5C5.5 1.0875 5.647 0.73425 5.941 0.440251C6.235 0.146252 6.588 -0.000498725 7 1.27333e-06C7.4125 1.27333e-06 7.76575 0.147002 8.05975 0.441001C8.35375 0.735 8.5005 1.088 8.5 1.5C8.5 1.9125 8.353 2.26575 8.059 2.55975C7.765 2.85375 7.412 3.0005 7 3ZM12.5 3C12.0875 3 11.7343 2.853 11.4403 2.559C11.1463 2.265 10.9995 1.912 11 1.5C11 1.0875 11.147 0.73425 11.441 0.440251C11.735 0.146252 12.088 -0.000498725 12.5 1.27333e-06C12.9125 1.27333e-06 13.2657 0.147002 13.5597 0.441001C13.8537 0.735 14.0005 1.088 14 1.5C14 1.9125 13.853 2.26575 13.559 2.55975C13.265 2.85375 12.912 3.0005 12.5 3Z" fill="#252831"/></svg>
               </button>
               <div class='dropdown-items' :class='review.popup_active ? "active" : ""'>
                  <button @click='btn_review_edit(review.id)' class='t-primary'>Edit</button>
                  <button @click='btn_review_delete(review.id)'>Delete</button>
               </div>
            </div>

         </div>
         
      </div>

   </div>

   <div v-else>
      <div class='progress-center'>
         <div class='progress-container enabled'><progress class='progress-circular enabled' ></progress></div>
      </div>
   </div>

   <div v-if='popup_delete_all_review == true && user != null' class='modal-popup open'>
      <div class='modal-wrapper'>
         <p class='heading'>Do you want to delete this review?</p>
         <div class='actions'>
            <button @click='btn_popup_cancel' class='btn btn-outline'>Cancel</button>
            <button @click='btn_popup_delete' class='btn btn-primary'>Delete</button>
         </div>
      </div>
   </div>

</div>

<script type='module'>

var { createApp } = Vue;

createApp({
   data (){

      return {
         loading: false,
         user: null,
         reviews: [],
         popup_delete_all_review: false,
         review_id: 0

      }
   },

   methods: {
      gotoCart(){ window.gotoCart(); },
      count_product_in_cart(){return window.count_product_in_cart(); },
      get_image_upload(image){ return window.get_image_upload(image); },
      timestamp_to_date(timestamp){ return window.timestamp_to_date(timestamp)},
      btn_review_edit(review_id){ window.gotoPageUserReviewEdit(review_id);},
      async request(formdata){ 
        try{
            return axios({ method: 'post', url: get_ajaxadmin, data: formdata
            }).then(function (res) { 
               return res.status == 200 ? res.data.data : null;
            });
         }catch(e){
            console.log(e);
            return null;
         } 
      },

      async btn_popup_delete(){
         this.loading = true;
         var form = new FormData();
         form.append('action', 'atlantis_delete_review');
         form.append('review_id', this.review_id);
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'review_delete_ok' ){
               this.reviews.some( (item, index ) => {
                  if( item.id == this.review_id ){
                     this.reviews.splice(1, index);
                  }
               });
            }
         }
         this.btn_popup_cancel();
         this.loading = false;
      },
      btn_popup_cancel(){ 
         this.review_id = 0;
         this.reviews.every(item => item.popup_active = false);
         this.popup_delete_all_review = false; },

      btn_review_delete(review_id){ 
         this.review_id = review_id;
         this.popup_delete_all_review = true; },

      popup_reivew_action(review_id){
         this.reviews.some(item => {
            if(item.id == review_id){
               item.popup_active = !item.popup_active;
            }else{
               item.popup_active = false;
            }
         });
      },

      async initUser(){
         var form = new FormData();
         form.append('action', 'atlantis_get_user_login_data');
         var r = await this.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'user_found'){
               this.user = res.data;

            }
         }
      },

      async initReview(){
         var form = new FormData();
         form.append('action', 'atlantis_get_user_review');
         var r = await this.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if( res.message == 'review_found'){
               res.data.forEach(item => item.popup_active = false );
               this.reviews = res.data;
            }
         }
      },

      gotoPageUserDeliveryAddress(){ window.gotoPageUserDeliveryAddress();},
      gotoPageUserSettings(){ window.gotoPageUserSettings();},
      gotoSupport(){ window.gotoSupport();},
      gotoPageUserEditProfile(){ window.gotoPageUserEditProfile(); }
   },

   computed: {
      get_first_name_user(){
         if( this.user.first_name != undefined || this.user.first_name != null || this.user.first_name != ''){
            return this.user.first_name;
         }else{
            this.user.user_login
         }
      },
   },

   async created(){
      this.loading = true;
      await this.initReview();
      await this.initUser();
      this.loading = false;

      window.appbar_fixed();

   },

   

}).mount('#app-user');
</script>
