<div id='app'>

   <div v-if='loading == false'>
      <div class='page-home'>
         <div class='appbar'>
            <div class='appbar-top'>
               <div class='leading'>
                  <span class='leading-title'>Home</span>
               </div>
               <div class='action'>
                  <div @click='gotoCart' class='btn-badge'>
                     <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M9.05036 18.4583C9.05036 18.7244 8.97134 18.9846 8.82329 19.2058C8.67524 19.4271 8.46481 19.5996 8.21861 19.7015C7.97241 19.8033 7.7015 19.83 7.44014 19.778C7.17878 19.7261 6.9387 19.5979 6.75027 19.4098C6.56184 19.2216 6.43352 18.9818 6.38153 18.7208C6.32954 18.4597 6.35622 18.1892 6.4582 17.9433C6.56018 17.6974 6.73288 17.4873 6.95445 17.3394C7.17602 17.1915 7.43652 17.1126 7.703 17.1126C8.06034 17.1126 8.40305 17.2544 8.65573 17.5067C8.9084 17.7591 9.05036 18.1014 9.05036 18.4583ZM17.7119 17.1126C17.4455 17.1126 17.185 17.1915 16.9634 17.3394C16.7418 17.4873 16.5691 17.6974 16.4672 17.9433C16.3652 18.1892 16.3385 18.4597 16.3905 18.7208C16.4425 18.9818 16.5708 19.2216 16.7592 19.4098C16.9477 19.5979 17.1877 19.7261 17.4491 19.778C17.7105 19.83 17.9814 19.8033 18.2276 19.7015C18.4738 19.5996 18.6842 19.4271 18.8322 19.2058C18.9803 18.9846 19.0593 18.7244 19.0593 18.4583C19.0593 18.1014 18.9174 17.7591 18.6647 17.5067C18.412 17.2544 18.0693 17.1126 17.7119 17.1126ZM22.113 4.78659L19.3682 13.6976C19.2367 14.1303 18.9691 14.5091 18.605 14.778C18.241 15.0468 17.8 15.1914 17.3472 15.1903H8.0947C7.63433 15.1886 7.18695 15.0378 6.81974 14.7604C6.45253 14.4831 6.18533 14.0943 6.05826 13.6524L2.57823 1.48882C2.56669 1.44855 2.54231 1.41315 2.50878 1.38799C2.47525 1.36283 2.43442 1.3493 2.39248 1.34945H0.773728C0.620582 1.34945 0.473708 1.28869 0.365417 1.18054C0.257126 1.07238 0.196289 0.925697 0.196289 0.772746C0.196289 0.619796 0.257126 0.473109 0.365417 0.364957C0.473708 0.256804 0.620582 0.196045 0.773728 0.196045H2.39248C2.68501 0.196833 2.9694 0.292344 3.20296 0.468247C3.43652 0.64415 3.60667 0.890957 3.68787 1.17163L4.5088 4.04072H21.5615C21.6518 4.04081 21.7408 4.06204 21.8214 4.1027C21.902 4.14336 21.9719 4.20232 22.0255 4.27485C22.0791 4.34738 22.115 4.43146 22.1302 4.52033C22.1454 4.6092 22.1395 4.70039 22.113 4.78659ZM20.7801 5.19412H4.8389L7.16887 13.34C7.22639 13.5409 7.34788 13.7176 7.51493 13.8433C7.68199 13.969 7.88551 14.037 8.0947 14.0369H17.3443C17.5502 14.0369 17.7506 13.971 17.9162 13.8489C18.0818 13.7268 18.2038 13.5548 18.2644 13.3583L20.7801 5.19412Z" fill="#2790F9"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M22.3002 4.84434L19.5556 13.7547C19.4118 14.2275 19.1191 14.6419 18.7213 14.9357C18.3234 15.2296 17.8413 15.3876 17.3465 15.3864H8.09448C7.59174 15.3845 7.10242 15.2198 6.70136 14.917C6.3003 14.6141 6.00841 14.1894 5.86961 13.7066L2.39029 1.54556H0.773518C0.568449 1.54556 0.371729 1.4642 0.226647 1.31931C0.0815564 1.1744 0 0.977815 0 0.77278C0 0.567745 0.0815563 0.371158 0.226647 0.226253C0.371729 0.0813567 0.568449 0 0.773518 0H2.39227C2.72716 0.000902557 3.05328 0.110242 3.32071 0.311653C3.58815 0.513066 3.78301 0.795701 3.87602 1.11717L4.65643 3.84467H21.5613C21.6822 3.8448 21.8016 3.87322 21.9095 3.92768C22.0174 3.98214 22.1111 4.06113 22.1829 4.15832C22.2548 4.25551 22.3028 4.36819 22.3232 4.48731C22.3436 4.60644 22.3357 4.72881 22.3002 4.84434ZM22.1128 4.78662L19.368 13.6976L22.1128 4.78662ZM18.2642 13.3583L20.7799 5.19416H4.83869L7.16866 13.3401C7.22618 13.5409 7.34767 13.7176 7.51472 13.8433C7.68178 13.9691 7.8853 14.037 8.09448 14.0369H17.3441C17.55 14.0369 17.7504 13.9711 17.916 13.8489C18.0816 13.7268 18.2036 13.5548 18.2642 13.3583ZM9.24622 18.4583C9.24622 18.7633 9.15567 19.0614 8.98604 19.3149C8.81642 19.5685 8.57535 19.766 8.29335 19.8827C8.01136 19.9993 7.70107 20.0299 7.40173 19.9704C7.10238 19.9109 6.82737 19.7641 6.6115 19.5485C6.39563 19.3329 6.24859 19.0582 6.18902 18.7591C6.12944 18.46 6.16002 18.15 6.27687 17.8682C6.39372 17.5865 6.59158 17.3457 6.8454 17.1763C7.09921 17.007 7.39758 16.9166 7.70279 16.9166C8.11205 16.9166 8.50461 17.0789 8.79408 17.368C9.08355 17.6572 9.24622 18.0493 9.24622 18.4583ZM16.8543 17.1763C17.1082 17.007 17.4065 16.9166 17.7117 16.9166C18.121 16.9166 18.5136 17.0789 18.803 17.368C19.0925 17.6571 19.2552 18.0493 19.2552 18.4583C19.2552 18.7633 19.1646 19.0614 18.995 19.3149C18.8254 19.5685 18.5843 19.766 18.3023 19.8827C18.0203 19.9993 17.71 20.0299 17.4107 19.9704C17.1113 19.9109 16.8363 19.7641 16.6205 19.5485C16.4046 19.3329 16.2575 19.0582 16.198 18.7591C16.1384 18.46 16.169 18.15 16.2858 17.8682C16.4027 17.5865 16.6005 17.3457 16.8543 17.1763ZM8.82308 19.2059C8.97113 18.9846 9.05015 18.7244 9.05015 18.4583C9.05015 18.1014 8.90819 17.7591 8.65552 17.5068C8.40284 17.2544 8.06013 17.1126 7.70279 17.1126C7.43631 17.1126 7.17581 17.1916 6.95424 17.3394C6.73266 17.4873 6.55997 17.6974 6.45799 17.9433C6.35601 18.1892 6.32933 18.4598 6.38132 18.7208C6.43331 18.9818 6.56163 19.2216 6.75006 19.4098C6.93849 19.598 7.17857 19.7261 7.43993 19.7781C7.70129 19.83 7.9722 19.8033 8.2184 19.7015C8.4646 19.5996 8.67503 19.4272 8.82308 19.2059ZM16.9632 17.3394C17.1848 17.1916 17.4453 17.1126 17.7117 17.1126C18.0691 17.1126 18.4118 17.2544 18.6645 17.5068C18.9171 17.7591 19.0591 18.1014 19.0591 18.4583C19.0591 18.7244 18.9801 18.9846 18.832 19.2059C18.684 19.4272 18.4735 19.5996 18.2273 19.7015C17.9812 19.8033 17.7102 19.83 17.4489 19.7781C17.1875 19.7261 16.9474 19.598 16.759 19.4098C16.5706 19.2216 16.4423 18.9818 16.3903 18.7208C16.3383 18.4598 16.365 18.1892 16.4669 17.9433C16.5689 17.6974 16.7416 17.4873 16.9632 17.3394ZM4.50859 4.04075H21.5613H4.50859ZM21.5613 4.04075C21.6516 4.04084 21.7406 4.06207 21.8212 4.10273L21.5613 4.04075ZM21.8212 4.10273C21.9017 4.1434 21.9716 4.20236 22.0253 4.27489L21.8212 4.10273ZM22.0253 4.27489C22.0789 4.34742 22.1147 4.43149 22.1299 4.52036L22.0253 4.27489ZM22.1299 4.52036C22.1451 4.60923 22.1393 4.70043 22.1128 4.78662L22.1299 4.52036Z" fill="#2790F9"/>
                     </svg>

                     <span class='badge' :class="count_product_in_cart > 0 ? 'enable' : '' ">{{ count_product_in_cart }}</span>
                  </div>
                  <div @click='gotoChat' class='btn-badge ml10'>
                     <svg width="23" height="20" viewBox="0 0 23 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M15.6817 0H3.40384C2.58977 0 1.80904 0.334446 1.2334 0.929764C0.657759 1.52508 0.33437 2.33251 0.33437 3.17441V9.52324C0.33437 9.94011 0.413763 10.3529 0.568018 10.738C0.722275 11.1232 0.94837 11.4731 1.2334 11.7679C1.51842 12.0627 1.8568 12.2965 2.22921 12.456C2.60161 12.6155 3.00076 12.6977 3.40384 12.6977H5.24553H9.79695H15.6817C16.4958 12.6977 17.2766 12.3632 17.8522 11.7679C18.4278 11.1726 18.7512 10.3652 18.7512 9.52324V3.17441C18.7512 2.33251 18.4278 1.52508 17.8522 0.929764C17.2766 0.334446 16.4958 0 15.6817 0ZM15.6817 1.26977H3.40384C2.9154 1.26977 2.44696 1.47043 2.10158 1.82762C1.75619 2.18482 1.56216 2.66927 1.56216 3.17441V9.52324C1.56216 10.0284 1.75619 10.5128 2.10158 10.87C2.44696 11.2272 2.9154 11.4279 3.40384 11.4279H15.6817C16.1702 11.4279 16.6386 11.2272 16.984 10.87C17.3294 10.5128 17.5234 10.0284 17.5234 9.52324V3.17441C17.5234 2.66927 17.3294 2.18482 16.984 1.82762C16.6386 1.47043 16.1702 1.26977 15.6817 1.26977Z" fill="#2790F9"/>
                     <path d="M3.40384 1.26977H15.6817C16.1702 1.26977 16.6386 1.47043 16.984 1.82762C17.3294 2.18482 17.5234 2.66927 17.5234 3.17441V9.52324C17.5234 10.0284 17.3294 10.5128 16.984 10.87C16.6386 11.2272 16.1702 11.4279 15.6817 11.4279H3.40384C2.9154 11.4279 2.44696 11.2272 2.10158 10.87C1.75619 10.5128 1.56216 10.0284 1.56216 9.52324V3.17441C1.56216 2.66927 1.75619 2.18482 2.10158 1.82762C2.44696 1.47043 2.9154 1.26977 3.40384 1.26977Z" fill="white"/>
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M19.0577 4.76171H6.7798C6.29136 4.76171 5.82292 4.96238 5.47753 5.31957C5.13215 5.67676 4.93812 6.16121 4.93812 6.66636V13.0152C4.93812 13.5203 5.13215 14.0048 5.47753 14.362C5.82292 14.7192 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9197 13.0793 14.936 13.1539 14.9678C13.2285 14.9996 13.2963 15.0463 13.3534 15.1052L15.9882 17.8314V15.5547C15.9882 15.3863 16.0529 15.2249 16.168 15.1058C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7192 20.36 14.362C20.7054 14.0048 20.8994 13.5203 20.8994 13.0152V6.66636C20.8994 6.16121 20.7054 5.67676 20.36 5.31957C20.0146 4.96238 19.5461 4.76171 19.0577 4.76171ZM6.7798 3.49194H19.0577C19.8718 3.49194 20.6525 3.82639 21.2282 4.42171C21.8038 5.01703 22.1272 5.82445 22.1272 6.66636V13.0152C22.1272 13.4321 22.0478 13.8448 21.8935 14.23C21.7393 14.6151 21.5132 14.9651 21.2282 15.2598C20.9431 15.5546 20.6047 15.7884 20.2323 15.948C19.8599 16.1075 19.4608 16.1896 19.0577 16.1896H17.216V19.364C17.2162 19.4897 17.1804 19.6127 17.1129 19.7173C17.0455 19.8219 16.9495 19.9035 16.8372 19.9516C16.7249 19.9998 16.6013 20.0124 16.4821 19.9878C16.3628 19.9632 16.2533 19.9025 16.1675 19.8135L12.6646 16.1896H6.7798C5.96573 16.1896 5.18499 15.8552 4.60936 15.2598C4.03372 14.6645 3.71033 13.8571 3.71033 13.0152V6.66636C3.71033 5.82445 4.03372 5.01703 4.60936 4.42171C5.18499 3.82639 5.96573 3.49194 6.7798 3.49194Z" fill="#2790F9"/>
                     <path d="M19.0577 4.76171H6.7798C6.29136 4.76171 5.82292 4.96238 5.47753 5.31957C5.13215 5.67676 4.93812 6.16121 4.93812 6.66636V13.0152C4.93812 13.5203 5.13215 14.0048 5.47753 14.362C5.82292 14.7192 6.29136 14.9198 6.7798 14.9198H12.9188C12.9994 14.9197 13.0793 14.936 13.1539 14.9678C13.2285 14.9996 13.2963 15.0463 13.3534 15.1052L15.9882 17.8314V15.5547C15.9882 15.3863 16.0529 15.2249 16.168 15.1058C16.2832 14.9867 16.4393 14.9198 16.6021 14.9198H19.0577C19.5461 14.9198 20.0146 14.7192 20.36 14.362C20.7054 14.0048 20.8994 13.5203 20.8994 13.0152V6.66636C20.8994 6.16121 20.7054 5.67676 20.36 5.31957C20.0146 4.96238 19.5461 4.76171 19.0577 4.76171Z" fill="white"/>
                     <path d="M10.4639 9.32355C10.4639 9.705 10.1546 10.0142 9.77319 10.0142C9.39174 10.0142 9.08252 9.705 9.08252 9.32355C9.08252 8.9421 9.39174 8.63288 9.77319 8.63288C10.1546 8.63288 10.4639 8.9421 10.4639 9.32355Z" fill="#2790F9"/>
                     <path d="M13.5947 9.3098C13.5947 9.69124 13.2855 10.0005 12.904 10.0005C12.5226 10.0005 12.2133 9.69124 12.2133 9.3098C12.2133 8.92835 12.5226 8.61912 12.904 8.61912C13.2855 8.61912 13.5947 8.92835 13.5947 9.3098Z" fill="#2790F9"/>
                     <path d="M16.7027 9.32356C16.7027 9.70501 16.3935 10.0142 16.012 10.0142C15.6306 10.0142 15.3214 9.70501 15.3214 9.32356C15.3214 8.94211 15.6306 8.63288 16.012 8.63288C16.3935 8.63288 16.7027 8.94211 16.7027 9.32356Z" fill="#2790F9"/>
                     </svg>
                     
                     <span class='badge' :class="message_count > 0 ? 'enable' : '' " >{{ message_count }}</span>
                     
                  </div>
                  <div @click='gotoNotificationIndex' class='btn-badge ml10'>
                     <svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path d="M16.1176 14.6055C16.577 15.3164 17.1289 15.9629 17.7587 16.5281V17.2473H0.826953V16.5278C1.44914 15.9599 1.99356 15.3122 2.44603 14.6015L2.46376 14.5737L2.47879 14.5443C2.99231 13.5401 3.30009 12.4435 3.38408 11.3188L3.38602 11.2928V11.2667L3.38602 8.22777L3.38602 8.22636C3.38312 6.7874 3.9018 5.39615 4.84599 4.31028C5.79017 3.22441 7.09589 2.51751 8.5213 2.32051L9.12547 2.23701V1.6271V0.821239C9.12547 0.789084 9.13824 0.758246 9.16098 0.735511C9.18371 0.712773 9.21455 0.7 9.24671 0.7C9.27886 0.7 9.3097 0.712773 9.33243 0.735509C9.35517 0.758248 9.36795 0.789086 9.36795 0.821239V1.6148V2.23105L9.97923 2.30915C11.4175 2.49291 12.7392 3.19556 13.696 4.28509C14.6527 5.37462 15.1787 6.77603 15.1751 8.22601V8.22777V11.2667V11.2928L15.177 11.3188C15.261 12.4435 15.5688 13.5401 16.0823 14.5443L16.0984 14.5758L16.1176 14.6055Z" stroke="#2790F9" stroke-width="1.4"/>
                     <path d="M7.67493 18.5933C7.72887 18.9832 7.92209 19.3404 8.21891 19.599C8.51572 19.8576 8.89607 20 9.28972 20C9.68337 20 10.0637 19.8576 10.3605 19.599C10.6574 19.3404 10.8506 18.9832 10.9045 18.5933H7.67493Z" fill="#2790F9"/>
                     </svg>
                     <span class='badge' :class="notification_count > 0 ? 'enable' : '' ">{{notification_count}}</span>
                  </div>
               </div>
            </div>
            <div class='appbar-bottom style01'>
               <div class='box-search box-search-home'>
                  <input @click='gotoSearch' class='input-search' type="text" v-model='inputSearch' placeholder='Search by product or store name'>
                  <span class='icon-search'>
                     <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                     <path fill-rule="evenodd" clip-rule="evenodd" d="M4.90688 0.60506C5.87126 0.205599 6.90488 0 7.94872 0C8.99256 0 10.0262 0.205599 10.9906 0.60506C11.9549 1.00452 12.8312 1.59002 13.5693 2.32813C14.3074 3.06623 14.8929 3.94249 15.2924 4.90688C15.6918 5.87126 15.8974 6.90488 15.8974 7.94872C15.8974 8.99256 15.6918 10.0262 15.2924 10.9906C14.9914 11.7172 14.5848 12.3938 14.0869 12.999L19.7747 18.6868C20.0751 18.9872 20.0751 19.4743 19.7747 19.7747C19.4743 20.0751 18.9872 20.0751 18.6868 19.7747L12.999 14.0869C12.3938 14.5848 11.7172 14.9914 10.9906 15.2924C10.0262 15.6918 8.99256 15.8974 7.94872 15.8974C6.90488 15.8974 5.87126 15.6918 4.90688 15.2924C3.94249 14.8929 3.06623 14.3074 2.32813 13.5693C1.59002 12.8312 1.00452 11.9549 0.60506 10.9906C0.2056 10.0262 0 8.99256 0 7.94872C0 6.90488 0.2056 5.87126 0.60506 4.90688C1.00452 3.94249 1.59002 3.06623 2.32813 2.32813C3.06623 1.59002 3.94249 1.00452 4.90688 0.60506ZM7.94872 1.53846C7.10691 1.53846 6.27335 1.70427 5.49562 2.02641C4.71789 2.34856 4.01123 2.82073 3.41598 3.41598C2.82073 4.01123 2.34856 4.71789 2.02641 5.49562C1.70427 6.27335 1.53846 7.10691 1.53846 7.94872C1.53846 8.79053 1.70427 9.62409 2.02641 10.4018C2.34856 11.1795 2.82073 11.8862 3.41598 12.4815C4.01123 13.0767 4.71789 13.5489 5.49562 13.871C6.27335 14.1932 7.10691 14.359 7.94872 14.359C8.79053 14.359 9.62409 14.1932 10.4018 13.871C11.1795 13.5489 11.8862 13.0767 12.4815 12.4815C13.0767 11.8862 13.5489 11.1795 13.871 10.4018C14.1932 9.62409 14.359 8.79053 14.359 7.94872C14.359 7.10691 14.1932 6.27335 13.871 5.49562C13.5489 4.71789 13.0767 4.01123 12.4815 3.41598C11.8862 2.82073 11.1795 2.34856 10.4018 2.02641C9.62409 1.70427 8.79053 1.53846 7.94872 1.53846Z" fill="#252831"/>
                     </svg>
                  </span>
               </div>
            </div>
         </div>

         <div class='inner'> 

            

         </div>

         <div class='slider-container'>
            <ul class='sliders'>
               <li class='slide'><img src="<?php echo THEME_URI . '/assets/images/demo-home-slide01.png' ?>" alt=""></li>
               <li class='slide'><img src="<?php echo THEME_URI . '/assets/images/demo-home-slide01.png' ?>" alt=""></li>
               <li class='slide'><img src="<?php echo THEME_URI . '/assets/images/demo-home-slide01.png' ?>" alt=""></li>
            </ul>
         </div>

         <div class='inner'>
            <div class='gr-btn'>
               <button @click='gotoProductWater' class='btn-outline'>Water</button>
               <button @click='gotoProductIce' class='btn-outline'>Ice</button>
            </div>

            <div class='home-contents mt40'>

               <div v-if='productRecommend.length > 0' class='list-product-recommend'>
                  <div class='gr-heading'>
                     <p class='heading'>Recommend</p>
                     <span @click='gotoProductRecommend' class='link'>See All</span>
                  </div>

                  <div class='list-horizontal'>
                     <ul>
                        <li 
                           @click='gotoProductDetail(product.id)'
                           v-for='(product, index) in productRecommend' :key='index' class='product-design'>
                           <div class='img'>
                              <img :src='get_image_upload(product.product_image)'>
                              <span v-if='has_discount(product) == true' class='badge-discount'>-{{ product.discount_percent }}%</span>
                           </div>
                           <p class='tt01'>{{ product.name }} </p>
                           <p class='tt02'>{{ get_product_quantity(product) }}</p>
                           <div class='gr-price' :class="has_discount(product) == true ? 'has_discount' : '' ">
                              <span class='price'>
                                 {{ has_discount(product) == true 
                                    ? common_get_product_price(product.price, product.discount_percent) 
                                    : common_get_product_price(product.price)
                                 }}
                              </span>
                              <span v-if='has_discount(product) == true' class='price-sub'>
                                 {{ common_get_product_price(product.price) }}
                              </span>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>

               <div v-if='storeNearby.length > 0' class='list-product-recommend more-space'>
                  <div class='gr-heading mt40'>
                     <p class='heading'>Nearby</p>
                     <span @click='gotoNearbyStore' class='link'>See All</span>
                  </div>

                  <div class='list-horizontal'>
                     <ul>
                        <li 
                           @click='gotoStoreDetail(store.id)'
                           v-for='(store, index) in storeNearby' :key='index' class='product-design store-style'>
                           <div class='img'>
                              <img :src='get_image_upload(store.store_image)'>
                           </div>
                           <p class='tt01'>{{ store.name }} </p>
                           <p class='product-meta'>
                              <span class='store-distance'>{{ mathCeilDistance(store.distance) }} km</span>
                              <svg v-if='store.avg_rating > 0' width="15" height="14" viewBox="0 0 15 14" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M7.32901 11.7286L3.77618 13.8689C3.61922 13.9688 3.45514 14.0116 3.28391 13.9973C3.11269 13.9831 2.96287 13.926 2.83446 13.8261C2.70604 13.7262 2.60616 13.6012 2.53482 13.4511C2.46348 13.301 2.44921 13.1335 2.49202 12.9486L3.43373 8.9035L0.287545 6.18536C0.144861 6.05695 0.0558259 5.91055 0.0204402 5.74618C-0.0149455 5.58181 -0.00438691 5.42143 0.0521161 5.26505C0.10919 5.1081 0.1948 4.97968 0.308948 4.8798C0.423095 4.77992 0.580048 4.71571 0.779806 4.68718L4.93192 4.32333L6.53712 0.513664C6.60846 0.342443 6.71918 0.214026 6.86928 0.128416C7.01939 0.0428054 7.17263 0 7.32901 0C7.48597 0 7.63921 0.0428054 7.78874 0.128416C7.93827 0.214026 8.049 0.342443 8.12091 0.513664L9.72611 4.32333L13.8782 4.68718C14.078 4.71571 14.2349 4.77992 14.3491 4.8798C14.4632 4.97968 14.5488 5.1081 14.6059 5.26505C14.663 5.422 14.6738 5.58266 14.6384 5.74704C14.6031 5.91141 14.5137 6.05752 14.3705 6.18536L11.2243 8.9035L12.166 12.9486C12.2088 13.1341 12.1945 13.3019 12.1232 13.452C12.0519 13.6021 11.952 13.7268 11.8236 13.8261C11.6952 13.926 11.5453 13.9831 11.3741 13.9973C11.2029 14.0116 11.0388 13.9688 10.8819 13.8689L7.32901 11.7286Z" fill="#FFC83A"/></svg>
                              <span v-if='store.avg_rating > 0' class='store-rating'>{{ratingNumber(store.avg_rating)}}</span>
                           </p>

                        </li>
                     </ul>
                  </div>
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

   <component-location-modal ref='component_location_modal'></component-location-modal>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css" integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<script src='<?php echo THEME_URI . '/pages/module/location_modal.js'; ?>'></script>

<script type='module'>

var { createApp } = Vue;

createApp({
   data (){
      return {

         loading: false,
         inputSearch: '',
         latitude: 10.780900239854994,
         longitude: 106.7226271387539,

         notification_count: 0,
         message_count: 0,

         productRecommend: [],
         storeNearby: [],

         carts: [],
         
      }
   },

   methods: {

      ratingNumber(rating){ return parseFloat(rating).toFixed(1); },
      mathCeilDistance( distance ){ return parseFloat(distance).toFixed(1); },
      gotoNotificationIndex(){ window.gotoNotificationIndex()},
      gotoSearch(){ window.gotoSearch()},
      get_image_upload(i){ return window.get_image_upload(i) },
      has_discount( product ){ return window.has_discount( product ); },      
      get_product_quantity( product ){ return window.get_product_quantity( product ); },
      common_get_product_price( price, discount_percent ){ return window.common_get_product_price( price, discount_percent ); },
      gotoProductRecommend(){ window.gotoProductRecommend(); },
      gotoNearbyStore(){ window.gotoNearbyStore() },
      gotoProductWater(){window.gotoProductWater() },
      gotoProductIce(){window.gotoProductIce()},
      gotoProductDetail(product_id){ window.gotoProductDetail(product_id) },
      gotoStoreDetail(store_id){ window.gotoStoreDetail( store_id ) },
      gotoCart(){ window.gotoCart() },
      gotoChat(){ window.gotoChat() },

      get_current_location(){

         if( window.appBridge != undefined ){
            window.appBridge.getLocation().then( (data) => {
               if (Object.keys(data).length === 0) {
                  alert("Error-1 :Không thể truy cập vị trí");
               }else{
                  let lat = data.lat;
                  let lng = data.lng;
                  this.latitude = data.lat;
                  this.longitude = data.lng;
               }
            }).catch((e) => { alert(e); })
         }
      },

      async get_notification_count(){
         var form = new FormData();
         form.append('action', 'atlantis_notification_count');
         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r));
            if(res.message == 'notification_found' ){
               this.notification_count = res.data;
            }
         }
      },

      async get_messages_count(){
         var form_message_count = new FormData();
         form_message_count.append('action', 'atlantis_count_messages');
         var _atlantis_message = await window.request(form_message_count);
         if( _atlantis_message != undefined ){
            let res = JSON.parse( JSON.stringify( _atlantis_message));
            if( res.message == 'message_count_found' ){
               this.message_count = parseInt(res.data);
            }
         }
      },

      async get_store_nearby(){
         var form = new FormData();
         form.append('action', 'atlantis_get_store_location');
         form.append('lat', this.latitude);
         form.append('lng', this.longitude);

         var r = await window.request(form);
         if( r != undefined ){
            var res = JSON.parse( JSON.stringify(r ));
            if( res.message == 'store_location_found' ){
               this.storeNearby.push( ...res.data );
            }
         }
      },      


   },

   computed: {
      count_product_in_cart(){ return window.count_product_in_cart(); }
   },

   async created(){

      this.loading = true;

      this.get_current_location();
      await this.get_messages_count();
      await this.get_store_nearby();

      var form = new FormData();
      form.append('action', 'atlantis_load_product_recommend');
      form.append('lat',this.latitude);
      form.append('lng',this.longitude);
      form.append('product_id_already_exists',[0]);
      form.append('filter', 'nearest');

      var r = await window.request(form);

      if( r != undefined ){
         var res = JSON.parse( JSON.stringify( r));
         if( res.message == 'product_found' ){
            this.productRecommend.push(...res.data );
         }
      }

      this.loading = false;

      (function($){
         $(document).ready(function(){
            $('.slider-container .sliders').slick({
               dots: false,
               arrows: false,
               infinite: false,
               speed: 300,
               slidesToShow: 1,
               slidesToScroll: 1,
            })
         });
      })(jQuery);

      window.appbar_fixed();
   },
   
   mounted(){

      

   }

})
.component('component-location-modal', LocationModal)
.mount('#app');
</script>